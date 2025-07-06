/**
 * GreenTech Theme JavaScript
 * 
 * @package GreenTech
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {
        initializeTheme();
    });

    /**
     * Initialize all theme functionality
     */
    function initializeTheme() {
        // Core functionality
        initSmoothScroll();
        initScrollAnimations();
        initScrollToTop();
        initHeaderScrollEffect();
        
        // Interactive features
        initMobileMenu();
        initPortfolioFilter();
        initTestimonialCarousel();
        initNewsletterForm();
        
        // Performance optimizations
        initLazyLoading();
        initImageOptimization();
        
        // Accessibility
        initA11yFeatures();
        
        console.log('GreenTech theme initialized successfully');
    }

    /**
     * Smooth scrolling for anchor links
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                const target = $(this.hash);
                const $target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if ($target.length) {
                    e.preventDefault();
                    
                    const offset = $('.site-header').outerHeight() || 80;
                    const scrollPosition = $target.offset().top - offset;
                    
                    $('html, body').animate({
                        scrollTop: scrollPosition
                    }, 800, 'easeInOutCubic');
                    
                    // Update URL hash
                    if (history.pushState) {
                        history.pushState(null, null, this.hash);
                    }
                }
            }
        });
    }

    /**
     * Scroll animations using Intersection Observer
     */
    function initScrollAnimations() {
        // Check for Intersection Observer support
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        
                        // Add staggered animation delays for grid items
                        if (entry.target.parentElement.classList.contains('services-grid') ||
                            entry.target.parentElement.classList.contains('portfolio-grid')) {
                            const siblings = Array.from(entry.target.parentElement.children);
                            const index = siblings.indexOf(entry.target);
                            entry.target.style.animationDelay = `${index * 0.1}s`;
                        }
                        
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all elements with animation classes
            $('.fade-in, .scale-in, .slide-in-left, .slide-in-right').each(function() {
                observer.observe(this);
            });
        } else {
            // Fallback for browsers without Intersection Observer
            $('.fade-in, .scale-in, .slide-in-left, .slide-in-right').addClass('visible');
        }
    }

    /**
     * Back to top button
     */
    function initScrollToTop() {
        const $backToTop = $('#back-to-top');
        
        if ($backToTop.length) {
            $(window).on('scroll', throttle(() => {
                if ($(window).scrollTop() > 500) {
                    $backToTop.fadeIn();
                } else {
                    $backToTop.fadeOut();
                }
            }, 100));

            $backToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 800);
            });
        }
    }

    /**
     * Header scroll effects
     */
    function initHeaderScrollEffect() {
        const $header = $('.site-header');
        let lastScrollTop = 0;

        $(window).on('scroll', throttle(() => {
            const scrollTop = $(window).scrollTop();
            
            // Add scrolled class after scrolling
            if (scrollTop > 50) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }
            
            // Hide/show header on scroll (optional)
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                $header.addClass('header-hidden');
            } else {
                $header.removeClass('header-hidden');
            }
            
            lastScrollTop = scrollTop;
        }, 10));
    }

    /**
     * Mobile menu functionality
     */
    function initMobileMenu() {
        const $menuToggle = $('.menu-toggle');
        const $primaryMenu = $('#primary-menu');
        const $body = $('body');

        $menuToggle.on('click', function() {
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            
            $(this).attr('aria-expanded', !isExpanded);
            $(this).toggleClass('active');
            $primaryMenu.toggleClass('active');
            $body.toggleClass('menu-open');
        });

        // Close menu when clicking on links
        $primaryMenu.find('a').on('click', function() {
            $menuToggle.attr('aria-expanded', 'false');
            $menuToggle.removeClass('active');
            $primaryMenu.removeClass('active');
            $body.removeClass('menu-open');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation').length) {
                $menuToggle.attr('aria-expanded', 'false');
                $menuToggle.removeClass('active');
                $primaryMenu.removeClass('active');
                $body.removeClass('menu-open');
            }
        });

        // Handle escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $primaryMenu.hasClass('active')) {
                $menuToggle.trigger('click');
            }
        });
    }

    /**
     * Portfolio filtering
     */
    function initPortfolioFilter() {
        const $filterButtons = $('.filter-btn');
        const $portfolioItems = $('.portfolio-item');

        $filterButtons.on('click', function() {
            const filter = $(this).data('filter');
            
            // Update active button
            $filterButtons.removeClass('active');
            $(this).addClass('active');
            
            // Filter portfolio items
            $portfolioItems.each(function() {
                const $item = $(this);
                const category = $item.data('category');
                
                if (filter === 'all' || category === filter) {
                    $item.removeClass('hidden').addClass('visible');
                } else {
                    $item.addClass('hidden').removeClass('visible');
                }
            });
        });
    }

    /**
     * Testimonial carousel
     */
    function initTestimonialCarousel() {
        const $carousel = $('#testimonials-carousel');
        const $items = $carousel.find('.testimonial-item');
        
        if ($items.length <= 1) return;
        
        let currentIndex = 0;
        const itemCount = $items.length;
        
        // Auto-rotate testimonials
        setInterval(() => {
            $items.eq(currentIndex).removeClass('active');
            currentIndex = (currentIndex + 1) % itemCount;
            $items.eq(currentIndex).addClass('active');
        }, 5000);
        
        // Optional: Add manual controls
        if ($('.testimonial-controls').length) {
            $('.testimonial-prev').on('click', () => {
                $items.eq(currentIndex).removeClass('active');
                currentIndex = currentIndex === 0 ? itemCount - 1 : currentIndex - 1;
                $items.eq(currentIndex).addClass('active');
            });
            
            $('.testimonial-next').on('click', () => {
                $items.eq(currentIndex).removeClass('active');
                currentIndex = (currentIndex + 1) % itemCount;
                $items.eq(currentIndex).addClass('active');
            });
        }
    }

    /**
     * Newsletter form handling
     */
    function initNewsletterForm() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const originalText = $submitBtn.text();
            
            // Show loading state
            $submitBtn.text('Subscribing...').prop('disabled', true);
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                $submitBtn.text('Subscribed!').addClass('success');
                $form.find('input[type="email"]').val('');
                
                setTimeout(() => {
                    $submitBtn.text(originalText).removeClass('success').prop('disabled', false);
                }, 2000);
            }, 1000);
        });
    }

    /**
     * Lazy loading for images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            img.classList.add('loaded');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            $('.lazy, img[data-src]').each(function() {
                imageObserver.observe(this);
            });
        }
    }

    /**
     * Image optimization and progressive loading
     */
    function initImageOptimization() {
        // Add loading placeholder for images
        $('img:not(.loaded)').on('load', function() {
            $(this).addClass('loaded');
        });

        // Handle image errors
        $('img').on('error', function() {
            $(this).addClass('error').attr('alt', 'Image failed to load');
        });
    }

    /**
     * Accessibility features
     */
    function initA11yFeatures() {
        // Skip link functionality
        $('.skip-link').on('click', function(e) {
            const target = $($(this).attr('href'));
            if (target.length) {
                target.attr('tabindex', '-1').focus();
            }
        });

        // Keyboard navigation for mobile menu
        $('.menu-toggle').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        // Focus management for modals/popups
        $(document).on('keydown', function(e) {
            // Trap focus in open modals
            if (e.key === 'Tab') {
                const $modal = $('.modal.active, .popup.active');
                if ($modal.length) {
                    const $focusable = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                    const $first = $focusable.first();
                    const $last = $focusable.last();

                    if (e.shiftKey) {
                        if (document.activeElement === $first[0]) {
                            e.preventDefault();
                            $last.focus();
                        }
                    } else {
                        if (document.activeElement === $last[0]) {
                            e.preventDefault();
                            $first.focus();
                        }
                    }
                }
            }
        });
    }

    /**
     * Utility Functions
     */

    // Throttle function for performance
    function throttle(func, limit) {
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
    }

    // Debounce function for performance
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Custom easing function
    $.easing.easeInOutCubic = function(x) {
        return x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2;
    };

    /**
     * Advanced Features
     */

    // Parallax scrolling (optional)
    function initParallax() {
        if (window.innerWidth > 768) { // Only on desktop
            $(window).on('scroll', throttle(() => {
                const scrolled = $(window).scrollTop();
                $('.parallax').each(function() {
                    const rate = scrolled * -0.5;
                    $(this).css('transform', `translateY(${rate}px)`);
                });
            }, 16));
        }
    }

    // Contact form validation
    function initContactForm() {
        $('.contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            let isValid = true;
            
            // Basic validation
            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (!value) {
                    isValid = false;
                    $field.addClass('error');
                } else {
                    $field.removeClass('error');
                }
                
                // Email validation
                if ($field.attr('type') === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        isValid = false;
                        $field.addClass('error');
                    }
                }
            });
            
            if (isValid) {
                // Submit form via AJAX
                submitContactForm($form);
            }
        });
    }

    // Initialize advanced features if needed
    if ($('.parallax').length) {
        initParallax();
    }
    
    if ($('.contact-form').length) {
        initContactForm();
    }

    // Search functionality enhancement
    $('.search-form input').on('input', debounce(function() {
        const query = $(this).val();
        if (query.length > 2) {
            // Implement live search suggestions
            // This would typically involve AJAX calls to WordPress
        }
    }, 300));

    // Performance monitoring
    if (window.performance && window.performance.timing) {
        $(window).on('load', function() {
            const loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
            console.log(`Page load time: ${loadTime}ms`);
        });
    }

    // Service Worker registration (for advanced PWA features)
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('SW registered: ', registration);
                })
                .catch(function(registrationError) {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }

})(jQuery);