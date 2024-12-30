if (typeof $ == 'undefined') {
    var $ = jQuery;
}

$(document).ready(function () {
    setSectionScrolloing();
    setHeaderEffects();
    setHeaderRotatingIcon();
    // setSideScrollSection();
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