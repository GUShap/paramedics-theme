if (typeof $ == 'undefined') {
    var $ = jQuery;
}



$(document).ready(function () {
    const interval = setInterval(() => {
        if ($('.testimonials-slider-wrapper').length) {
            clearInterval(interval);
            initSliders();
        }
    }, 100);
});

function initSliders() {
    const $thumbsSlider = $('.testimonials-thumbs-slider');
    var thumbsSlider = new Swiper($thumbsSlider.get(0), {
        loop: true,
        slidesPerView: $thumbsSlider.data('view'),
        spaceBetween: 20,
        direction: 'vertical',
        mousewheel: true,
        slideThumbActiveClass: 'swiper-slide-thumb-active',
        multipleActiveThumbs: true,
    });
    
    var mainSlider = new Swiper('.testimonials-main-slider', {
        loop: true,
        inverse: true,
        spaceBetween: 10,
        mousewheel: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: thumbsSlider,
        },
    });
}