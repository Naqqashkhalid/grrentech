/**
 * GreenTech Theme JavaScript
 * 
 * Main JavaScript file for frontend functionality
 * 
 * @package GreenTech
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Theme object
    const GreenTech = {
        
        /**
         * Initialize all functions
         */
        init: function() {
            this.mobileMenu();
            this.stickyHeader();
            this.smoothScroll();
            this.scrollAnimations();
            this.backToTop();
            this.accessibility();
            this.performance();
        },

        /**
         * Mobile menu functionality
         */
        mobileMenu: function() {
            const menuToggle = $('.menu-toggle');
            const navigation = $('#site-navigation');
            const primaryMenu = $('#primary-menu');

            menuToggle.on('click', function(e) {
                e.preventDefault();
                
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                
                $(this).attr('aria-expanded', !isExpanded);
                navigation.toggleClass('menu-open');
                primaryMenu.slideToggle(300);
                
                // Trap focus within menu when open
                if (!isExpanded) {
                    primaryMenu.find('a').first().focus();
                }
            });

            // Close menu on escape key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && navigation.hasClass('menu-open')) {
                    menuToggle.click();
                    menuToggle.focus();
                }
            });

            // Close menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#site-navigation').length && navigation.hasClass('menu-open')) {
                    menuToggle.click();
                }
            });

            // Handle submenu toggles
            primaryMenu.find('.menu-item-has-children > a').after('<button class="submenu-toggle" aria-expanded="false"><span class="screen-reader-text">Toggle submenu</span></button>');
            
            $('.submenu-toggle').on('click', function(e) {
                e.preventDefault();
                
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                const submenu = $(this).siblings('.sub-menu');
                
                $(this).attr('aria-expanded', !isExpanded);
                submenu.slideToggle(200);
            });
        },

        /**
         * Sticky header functionality
         */
        stickyHeader: function() {
            const header = $('#masthead');
            const stickyClass = 'is-sticky';
            let lastScrollTop = 0;

            if (!header.hasClass('sticky-header')) {
                return;
            }

            $(window).on('scroll', this.throttle(function() {
                const scrollTop = $(window).scrollTop();
                const headerHeight = header.outerHeight();

                if (scrollTop > headerHeight) {
                    header.addClass(stickyClass);
                    
                    // Hide header on scroll down, show on scroll up
                    if (scrollTop > lastScrollTop && scrollTop > headerHeight * 2) {
                        header.addClass('header-hidden');
                    } else {
                        header.removeClass('header-hidden');
                    }
                } else {
                    header.removeClass(stickyClass + ' header-hidden');
                }

                lastScrollTop = scrollTop;
            }, 100));
        },

        /**
         * Smooth scrolling for anchor links
         */
        smoothScroll: function() {
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                const target = $(this.hash);
                
                if (target.length) {
                    e.preventDefault();
                    
                    const headerHeight = $('#masthead').outerHeight() || 0;
                    const targetOffset = target.offset().top - headerHeight - 20;
                    
                    $('html, body').animate({
                        scrollTop: targetOffset
                    }, 800, 'swing');
                    
                    // Update focus for accessibility
                    target.focus();
                    if (!target.is(':focus')) {
                        target.attr('tabindex', '-1');
                        target.focus();
                    }
                }
            });
        },

        /**
         * Scroll-triggered animations
         */
        scrollAnimations: function() {
            // Check if animations are enabled
            if (!$('body').hasClass('animations-enabled')) {
                return;
            }

            const animatedElements = $('.fade-in, .slide-in-up, .slide-in-left, .slide-in-right, .scale-in');
            
            if (!animatedElements.length) {
                return;
            }

            // Intersection Observer for better performance
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            $(entry.target).addClass('animate');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });

                animatedElements.each(function() {
                    observer.observe(this);
                });
            } else {
                // Fallback for older browsers
                $(window).on('scroll', this.throttle(function() {
                    const windowHeight = $(window).height();
                    const scrollTop = $(window).scrollTop();

                    animatedElements.each(function() {
                        const elementTop = $(this).offset().top;
                        
                        if (elementTop < scrollTop + windowHeight - 100) {
                            $(this).addClass('animate');
                        }
                    });
                }, 100));
            }
        },

        /**
         * Back to top button
         */
        backToTop: function() {
            const backToTopButton = $('<button id="back-to-top" class="back-to-top" aria-label="Back to top"><span class="screen-reader-text">Back to top</span></button>');
            $('body').append(backToTopButton);

            $(window).on('scroll', this.throttle(function() {
                if ($(window).scrollTop() > 300) {
                    backToTopButton.addClass('show');
                } else {
                    backToTopButton.removeClass('show');
                }
            }, 100));

            backToTopButton.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 600);
            });
        },

        /**
         * Accessibility enhancements
         */
        accessibility: function() {
            // Skip link focus fix
            $('.skip-link').on('click', function(e) {
                const target = $(this.hash);
                if (target.length) {
                    target.attr('tabindex', '-1').focus();
                }
            });

            // Improve focus visibility
            $('a, button, input, textarea, select').on('focus blur', function() {
                $(this).toggleClass('focus-visible');
            });

            // ARIA live region for dynamic content
            if (!$('#aria-live-region').length) {
                $('body').append('<div id="aria-live-region" aria-live="polite" aria-atomic="true" class="screen-reader-text"></div>');
            }
        },

        /**
         * Performance optimizations
         */
        performance: function() {
            // Lazy load images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.removeAttribute('data-src');
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(function(img) {
                    imageObserver.observe(img);
                });
            }

            // Preload critical resources
            this.preloadCriticalResources();
        },

        /**
         * Preload critical resources
         */
        preloadCriticalResources: function() {
            // Preload hero images and critical assets
            const heroImages = $('.hero-image, .featured-image').find('img');
            heroImages.each(function() {
                const link = document.createElement('link');
                link.rel = 'preload';
                link.as = 'image';
                link.href = this.src;
                document.head.appendChild(link);
            });
        },

        /**
         * Throttle function for performance
         */
        throttle: function(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },

        /**
         * Debounce function for performance
         */
        debounce: function(func, wait, immediate) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },

        /**
         * Update ARIA live region
         */
        updateAriaLive: function(message) {
            $('#aria-live-region').text(message);
        }
    };

    // Initialize theme when document is ready
    $(document).ready(function() {
        GreenTech.init();
    });

    // Make GreenTech object globally available
    window.GreenTech = GreenTech;

})(jQuery);