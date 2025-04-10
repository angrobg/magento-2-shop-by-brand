define([
    'jquery',
    'jquery-ui-modules/widget',
    'owlCarousel',
    'domReady!',
], function ($) {

    $.widget('mage.brandsSlider', {
        options: {
            delayTimeout: 1000,
            carouselOptions: {
                autoplay: true,
                autoplayTimeout: 5000,
                nav: false,
                dots: false,
                responsive: {
                    0: {items: 3},
                    481: {items: 4},
                    768: {items: 6},
                    992: {items: 8},
                    1200: {items: 10},
                    1441: {items: 12},
                    1681: {items: 12},
                    1920: {items: 12},
                },
                margin: 20,
                autoplayHoverPause: true,
                loop: true,
                stagePadding: 0,
                mouseDrag: true,
                touchDrag: true,
                slideBy: 10
            },
        },

        _create: function () {
            if (this.element.data('brands-slider-initialized')) {
                return;
            }

            this.element.data('brands-slider-initialized', 1);

            this.initSlider();
        },

        initSlider: function () {

            const container = this.element;

            if (!('IntersectionObserver' in window)) {
                // Fallback: immediately load if IntersectionObserver is not supported
                this.loadSlider(container);
            } else {
                const me = this;

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            observer.unobserve(entry.target);
                            me.loadSlider(entry.target);
                        }
                    });
                }, {threshold: 0.1});

                observer.observe(container[0]);
            }
        },

        loadSlider: function (container) {
            if (this.options.delayTimeout > 0) {
                const me = this;
                setTimeout(function () {
                    me.loadSliderAfterDelay(container);
                }, this.options.delayTimeout);
            } else {
                this.loadSliderAfterDelay(container);
            }
        },

        initCarousel: function (container, data) {
            container.innerHTML = data;
            const options = this.options.carouselOptions;
            $(container).find('.owl-carousel').owlCarousel(options);
        },

        loadSliderAfterDelay: function (container) {
            const url = container.dataset.ajaxUrl;
            if (!url) return;

            const me = this;

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    me.initCarousel(container, response);
                },
                error: function () {
                    console.error('Failed to load brand slider via AJAX.');
                }
            });
        }
    });

    return $.mage.brandsSlider;
});
