/**
 * Remote Store Theme Scripts
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        // Mobile Menu Toggle
        $('.menu-toggle').on('click', function() {
            $('#site-navigation').toggleClass('toggled');
            $(this).attr('aria-expanded', $('#site-navigation').hasClass('toggled'));
        });

        // Add dropdown toggle buttons for mobile navigation
        $('.main-navigation .menu-item-has-children > a').after('<button class="dropdown-toggle" aria-expanded="false"><span class="screen-reader-text">Expand child menu</span></button>');

        // Toggle mobile submenu
        $('.dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('toggled');
            $(this).closest('.menu-item-has-children').toggleClass('toggled');
            $(this).attr('aria-expanded', $(this).hasClass('toggled'));
        });

        // Add smooth scrolling to anchor links
        $('a[href*="#"]:not([href="#"]):not([href="#0"]):not([href*="="]):not([href^="#tab-"])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                    return false;
                }
            }
        });

        // Product quantity buttons
        if (typeof $.fn.on === 'function') {
            $(document).on('click', '.quantity .plus, .quantity .minus', function() {
                var $qty = $(this).closest('.quantity').find('.qty'),
                    currentVal = parseFloat($qty.val()),
                    max = parseFloat($qty.attr('max')),
                    min = parseFloat($qty.attr('min')),
                    step = $qty.attr('step');

                if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                if (max === '' || max === 'NaN') max = '';
                if (min === '' || min === 'NaN') min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

                if ($(this).is('.plus')) {
                    if (max && (max == currentVal || currentVal > max)) {
                        $qty.val(max);
                    } else {
                        $qty.val(currentVal + parseFloat(step));
                    }
                } else {
                    if (min && (min == currentVal || currentVal < min)) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        $qty.val(currentVal - parseFloat(step));
                    }
                }

                $qty.trigger('change');
            });
        }

        // Add quantity buttons to product pages and cart
        function addQuantityButtons() {
            $('.quantity').each(function() {
                if (!$(this).find('.plus').length) {
                    $(this).append('<button type="button" class="plus">+</button>');
                    $(this).prepend('<button type="button" class="minus">-</button>');
                }
            });
        }

        addQuantityButtons();

        $(document.body).on('updated_cart_totals', function() {
            addQuantityButtons();
        });

        // Sticky header on scroll
        var $header = $('.site-header');
        var headerHeight = $header.outerHeight();
        var $body = $('body');
        var lastScrollTop = 0;

        $(window).scroll(function() {
            var scrollTop = $(this).scrollTop();

            if (scrollTop > headerHeight && !$body.hasClass('sticky-header')) {
                $body.addClass('sticky-header');
                $header.css('margin-bottom', headerHeight + 'px');
            } else if (scrollTop <= headerHeight && $body.hasClass('sticky-header')) {
                $body.removeClass('sticky-header');
                $header.css('margin-bottom', '0');
            }

            // Hide/show header on scroll down/up
            if (scrollTop > lastScrollTop && scrollTop > headerHeight) {
                // Scroll down - hide header
                $body.addClass('header-hidden');
            } else {
                // Scroll up - show header
                $body.removeClass('header-hidden');
            }

            lastScrollTop = scrollTop;
        });

        // Initialize product carousels if owlCarousel exists
        if (typeof $.fn.owlCarousel === 'function') {
            $('.products-carousel').owlCarousel({
                loop: false,
                margin: 20,
                nav: true,
                dots: false,
                navText: [
                    '<i class="fas fa-chevron-left"></i>',
                    '<i class="fas fa-chevron-right"></i>'
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    992: {
                        items: 4
                    }
                }
            });
        }

        // Back to top button
        var $backToTop = $('.back-to-top');

        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('show');
            } else {
                $backToTop.removeClass('show');
            }
        });

        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 800);
        });
    });

})(jQuery);
