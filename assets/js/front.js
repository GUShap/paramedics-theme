if (typeof $ == 'undefined') {
    var $ = jQuery;
}
const ajaxUrl = customVars.ajax_url;

$(document).ready(function () {
    setSectionScrolloing();
    setHeaderEffects();
    setHeaderRotatingIcon();
    // setSideScrollSection();
    /******/
    setJourneyForm();
});

const sectionManager = (() => {
    let currentActiveSection = null;
    let nextSection = null;
    let isScrollingDown = true;

    return {
        getCurrentActiveSection: () => currentActiveSection,
        setCurrentActiveSection: (section) => {
            currentActiveSection = section;
        },
        getNextSection: () => nextSection,
        setNextSection: (section) => {
            nextSection = section;
        },
        getIsScrollingDown: () => isScrollingDown,
        setIsScrollingDown: (scrollingDown) => {
            isScrollingDown = scrollingDown;
        }
    };
})();

function setHeaderEffects() {
    const $header = $('[data-elementor-type="header"]');
    const $sections = $('[data-item="dynamic-section"]');
    const minScroll = 0;

    $(window).scroll(function () {
        const newScroll = $(this).scrollTop();
        const $section = sectionManager.getCurrentActiveSection();

        newScroll > minScroll ? $header.addClass('scrolled') : $header.removeClass('scrolled');

        if (!$section.length || !newScroll) {
            $header.removeClass('dark-contrast');
            $header.removeClass('light-contrast');
            return;
        }

        if ($section.hasClass('dark')) {
            $header.removeClass('dark-contrast');
            $header.addClass('light-contrast');
        }
        if ($section.hasClass('light')) {
            $header.removeClass('light-contrast');
            $header.addClass('dark-contrast');
        }

    });
};

function setHeaderRotatingIcon() {
    const $rotatingIcon = $('#rotating-icon');
    const $blueIcon = $('#blue-logo-header');
    const $header = $('[data-elementor-type="header"]');
    let rotation = 0;
    let prevScroll = 0;
    $(window).scroll(function () {
        const newScroll = $(this).scrollTop();
        const isScrollingDown = newScroll > prevScroll;

        if (!$header.hasClass('scrolled')) {
            rotation = 0;
        } else {
            if (isScrollingDown) {
                rotation += 0.2;
            } else {
                rotation -= 0.2;
            }
        }
        prevScroll = newScroll;

        $rotatingIcon.css('transform', `rotate(${rotation}deg)`);
        $blueIcon.css('transform', `rotate(${rotation}deg)`);
    });
}

function setSectionScrolloing() {
    const $sections = $('[data-item="dynamic-section"]');
    const $stickyHeadings = $sections.find('.sticky-heading');
    let prevScroll = 0;

    $(window).on('scroll', function () {
        const isScrollingDown = $(this).scrollTop() > prevScroll;
        const $currentActiveSection = $sections.filter('.active');
        const $nextSection = isScrollingDown ? $currentActiveSection.next() : $currentActiveSection.prev();

        sectionManager.setCurrentActiveSection($currentActiveSection);
        sectionManager.setNextSection($nextSection);
        sectionManager.setIsScrollingDown(isScrollingDown);

        prevScroll = $(this).scrollTop();
        if (!$nextSection.length) return;

        isScrollingDown
            ? setSectionsScrollingDown()
            : setSectionsScrollingUp();
    });

    $stickyHeadings.each(function () {
        const $stickyHeading = $(this);
        setStickyHeading($stickyHeading);
    });
}

function setSectionsScrollingDown() {
    const $nextSection = sectionManager.getNextSection();
    const distanceFromTop = $nextSection.offset().top - $(window).scrollTop();
    if (distanceFromTop <= 1) {
        $nextSection.addClass('active');
        $nextSection.prevAll().removeClass('active').addClass('visited');
    }
}

function setSectionsScrollingUp() {
    const $currentActiveSection = sectionManager.getCurrentActiveSection();
    const $nextSection = sectionManager.getNextSection();
    let isOverlapping = $currentActiveSection.next().length && $(window).scrollTop() - ($currentActiveSection.next().offset().top - $(window).height()) >= 0;

    if ($(window).scrollTop() - ($('footer').offset().top - $(window).height()) >= 0) {
        isOverlapping = true;
    }
    if (!isOverlapping) {
        $nextSection.addClass('active');
        $nextSection.nextAll().removeClass('active visited');
        $currentActiveSection.removeClass('active');
    }
}

function setStickyHeading($stickyHeading) {
    const originalOffsetTop = $stickyHeading.offset().top;
    const spacing = 0;

    $(window).on('scroll', function () {
        const $currentActiveSection = sectionManager.getCurrentActiveSection();
        const $nextSection = $currentActiveSection.next();

        const isActive = $currentActiveSection.is($stickyHeading.closest('[data-item="dynamic-section"]'));

        if (!isActive || !$nextSection.length) return;

        const distanceNextFromTop = $nextSection.offset().top - $(window).scrollTop();
        const isOverlapping = distanceNextFromTop <= originalOffsetTop + $stickyHeading.height() + spacing;
        const newOffsetTop = isOverlapping
            ? $nextSection.offset().top - $stickyHeading.height() - spacing
            : originalOffsetTop + $(window).scrollTop();

        $stickyHeading.offset({ top: newOffsetTop });

    });
}

/*journey registration form*/

function setJourneyForm() {
    const $forms = $('form.sign-up-form');
    $forms.each(function () {
        const $form = $(this);
        setFormPopup($form);
        setFormSteps($form);
        setCustomSelect($form);
        setCustomDate($form);
        setConditionalFields($form);
        setFormSubmission($form);
    });
}

function setCustomSelect($form) {
    const $selectWrapper = $form.find('.input-wrapper.type-select');
    const $customSelectWrapper = $selectWrapper.find('.custom-select-wrapper');
    const $customSelectList = $customSelectWrapper.find('.custom-select-list');
    const $customListRadio = $customSelectList.find('input[type="radio"]');

    $customSelectWrapper.find('>label').on('click', function () {
        const $wrapper = $(this).closest('.input-wrapper');
        const $list = $(this).next();
        $list.toggleClass('active');
        $(document).on('click', function (e) {
            const targetNode = e.target;
            // check if target node has same $wrapper parent or is $wrapper
            if (!$wrapper.is(targetNode) && !$.contains($wrapper[0], targetNode)) {
                $list.removeClass('active');
            }
        }
        );
    });

    $customListRadio.on('change', function () {
        const $wrapper = $(this).closest('.custom-select-wrapper');
        const $select = $(this).closest('.input-wrapper').find('select');
        const $list = $(this).closest('.custom-select-list');
        const $item = $(this).closest('.custom-select-item');

        const prefix = $wrapper.data('prefix');
        const isDate = $wrapper.data('date');


        let value = $(this).val();
        let labelValue = $item.data('label-value');
        let text = prefix ? `${prefix} ${value}` : value;

        if (isDate) {
            const dateArr = labelValue ? labelValue.split('-') : value.split('-');
            text = dateArr.join('/');
        }

        $wrapper.find('>label').text(labelValue ? labelValue : text);
        $list.removeClass('active');
        $select.val(value).trigger('change');
    });
}

function setCustomDate($form) {
    const $dateInput = $form.find('input[name="dob"]');

    $dateInput.on('blur', function () {
        const dob = $(this).val();
        if (!dob) return;
        const dobArr = dob.split('-');
        const newDob = `${dobArr[2]}/${dobArr[1]}/${dobArr[0]}`;
        $dateInput.val(newDob).css('text-align', 'end');
    });
}

function setConditionalFields($form) {
    const $conditionalFields = $form.find('.input-wrapper.condition');
    const setResVisibility = (value, condition) => {
        const $followingInputWrappers = $form.find(`.condition-res[data-condition="${condition}"]`);
        const $selectedRes = value ? $followingInputWrappers.filter(function () {
            const conditionValues = $(this).data('condition-value');
            if (typeof conditionValues === 'string') return conditionValues.includes(value);
            else return conditionValues == +value;
        }) : null;

        $followingInputWrappers.removeClass('active');
        $followingInputWrappers.find('input, select, textarea').prop('required', false);

        if (!$selectedRes) return;

        $selectedRes.addClass('active');
        $selectedRes.find('input, select, textarea').prop('required', true);
    }

    $conditionalFields.each(function () {
        const $input = $(this).find('>input, >select, >textarea');
        const condition = $(this).data('condition');
        $input.on('change', function () {
            const value = $(this).val();
            setResVisibility(value, condition);
        });
        setResVisibility($input.val(), condition);
    });
}

function setFormSteps($form) {
    const $steps = $form.find('.form-step');
    const $nextBtn = $form.find('.next-step');
    const $prevBtn = $form.find('.prev-step');
    const $submitBtn = $form.find('.submit-wrapper');
    const $inputs = $form.find('input:not(.list-input), select, textarea');
    let currentStep = 0;

    $nextBtn.find('button').on('click', function () {
        const $currentStep = $steps.eq(currentStep);
        const $nextStep = $steps.eq(currentStep + 1);
        if (!isRequiredStepInputsFilled($currentStep)) return;
        $currentStep.removeClass('active');
        $nextStep.addClass('active');
        currentStep++;
        $(this).prop('disabled', !isRequiredStepInputsFilled($nextStep));
        $prevBtn.find('button').prop('disabled', false);
    });

    $prevBtn.find('button').on('click', function () {
        const $currentStep = $steps.eq(currentStep);
        const $prevStep = $steps.eq(currentStep - 1);
        $currentStep.removeClass('active');
        $prevStep.addClass('active');
        currentStep--;

        $(this).prop('disabled', isFirstStep($prevStep));
        $nextBtn.find('button').prop('disabled', !isRequiredStepInputsFilled($prevStep));
    });

    $inputs.on('change', function () {
        const $step = $(this).closest('.form-step');
        const isLastStepx = isLastStep($step);
        const requiredInputsFilled = isRequiredStepInputsFilled($step);

        isLastStepx
            ? $submitBtn.find('button').prop('disabled', !requiredInputsFilled)
            : $nextBtn.find('button').prop('disabled', !requiredInputsFilled);
    });
}

function isRequiredStepInputsFilled($step) {
    const $inputs = $step.find('input:not(.list-input), select, textarea');
    return Array.from($inputs).every(input => {
        const $input = $(input);
        const isRequired = $input.prop('required');
        const isCheckbox = $input.prop('type') === 'checkbox';
        const isRadio = $input.prop('type') === 'radio';

        let isFilled = false

        if (!isRequired) return true;

        if (isCheckbox) {
            isFilled = $input.is(':checked')
        }
        else if (isRadio) {
            const name = $input.attr('name');
            const $checkedRadio = $(`input[name="${name}"]:checked`);
            isFilled = $checkedRadio.length;
        }
        else {
            isFilled = $input.val() && $input.val().length > 0;
        }

        if (!isFilled) {
        }

        return isFilled
    });

}

function isFirstStep($step) {
    return $step.hasClass('step-1');
}

function isLastStep($step) {
    return $step.hasClass('last');
}

function setFormSubmission($form) {
    $form.on('submit', function (e) {
        e.preventDefault();
        let data = $form.serialize();
        data += '&action=journey_registration';
        data += '&security=' + customVars.nonce;

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data,
            beforeSend: function () {
                $form.addClass('submitting');
            },
            success: function (response) {
                $form.find('.form-loader').remove();
                response.success
                    ? $form.append(`<div class="response-message success">${response.data.message}</div>`)
                    : $form.append(`<div class="response-message error">${response.data.message}</div>`);
            },
            error: function (response) {
                $form.find('.form-loader').remove();
                $form.append(`<div class="response-message error">${response.data.message}</div>`);
            }
        });

    });
}

function setFormPopup($form) {
    const $container = $form.closest('.sign-up-container');
    const $openBtn = $container.find('.open-popup-button');
    const $closeBtn = $container.find('.close-button');

    $openBtn.on('click', function () {
        $container.find('.form-wrapper').addClass('active');
    });

    $closeBtn.on('click', function () {
        $container.find('.form-wrapper').removeClass('active');
    });
}