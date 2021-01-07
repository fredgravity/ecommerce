(function () {
    'use strict';

    ARTISAOSTORE.homeslider.initCarousel = function () {

        $('.hero-slider').slick({
            slidesToShow: 1,
            autoplay: true,
            arrows: false,
            dots: false,
            fade: true,
            autoplayHoverPause: true,
            slidesToScroll: 1,
            adaptiveHeight: true
        });
    };



})();