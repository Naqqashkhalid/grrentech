/**
 * GreenTech Theme JavaScript
 * 
 * Handles smooth scrolling, animations, portfolio filtering, and other interactive features
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        initScrollAnimations();
        initPortfolioFiltering();
        initMobileNavigation();
        initTestimonialCarousel();
        initSmoothScrolling();
        initHeaderScrollEffect();
    });

    /**
     * Initialize scroll-triggered animations
     */
    function initScrollAnimations() {
        const animatedElements = $('.fade-in, .scale-in');
        
        function checkAnimation() {
            const windowHeight = $(window).height();
            const windowTop = $(window).scrollTop();
            
            animatedElements.each(function() {
                const element = $(this);
                const elementTop = element.offset().top;
                const elementHeight = element.outerHeight();
                
                // Check if element is in viewport
                if (elementTop <= windowTop + windowHeight - 100 && 
                    elementTop + elementHeight >= windowTop) {
                    element.addClass('visible');
                }
            });
        }
        
        // Check on scroll and resize
        $(window).on('scroll resize', checkAnimation);
        
        // Initial check
        checkAnimation();
    }

    /**
     * Initialize portfolio filtering
     */
    function initPortfolioFiltering() {
        const filterButtons = $('.filter-btn');
        const portfolioItems = $('.portfolio-item');
        
        filterButtons.on('click', function() {
            const filter = $(this).data('filter');
            
            // Update active button
            filterButtons.removeClass('active');
            $(this).addClass('active');
            
            // Filter portfolio items
            portfolioItems.each(function() {
                const item = $(this);
                const category = item.data('category');
                
                if (filter === 'all' || category === filter) {
                    item.fadeIn(400);
                } else {
                    item.fadeOut(400);
                }
            });
        });
    }

    /**
     * Initialize mobile navigation
     */
    function initMobileNavigation() {
        const menuToggle = $('.menu-toggle');
        const navigation = $('.main-navigation');
        const navigationMenu = $('#primary-menu');
        
        menuToggle.on('click', function() {
            $(this).toggleClass('active');
            navigationMenu.toggleClass('active');
            
            // Toggle menu visibility
            if (navigationMenu.hasClass('active')) {
                navigationMenu.slideDown(300);
            } else {
                navigationMenu.slideUp(300);
            }
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!navigation.is(e.target) && navigation.has(e.target).length === 0) {
                menuToggle.removeClass('active');
                navigationMenu.removeClass('active').slideUp(300);
            }
        });
        
        // Close menu when clicking on menu items
        navigationMenu.find('a').on('click', function() {
            menuToggle.removeClass('active');
            navigationMenu.removeClass('active').slideUp(300);
        });
    }

    /**
     * Initialize testimonial carousel
     */
    function initTestimonialCarousel() {
        const testimonials = $('.testimonial-item');
        let currentTestimonial = 0;
        
        if (testimonials.length > 1) {
            // Hide all testimonials except the first
            testimonials.hide();
            testimonials.first().show();
            
            // Auto-rotate testimonials
            setInterval(function() {
                testimonials.eq(currentTestimonial).fadeOut(500, function() {
                    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
                    testimonials.eq(currentTestimonial).fadeIn(500);
                });
            }, 5000);
        }
    }

    /**
     * Initialize smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000, 'easeInOutExpo');
                    return false;
                }
            }
        });
    }

    /**
     * Initialize header scroll effect
     */
    function initHeaderScrollEffect() {
        const header = $('.site-header');
        
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 100) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
        });
    }

    /**
     * Initialize loading animations
     */
    function initLoadingAnimations() {
        // Fade in body when page loads
        $('body').addClass('loaded');
        
        // Animate elements on page load
        setTimeout(function() {
            $('.hero .fade-in').each(function(index) {
                const element = $(this);
                setTimeout(function() {
                    element.addClass('visible');
                }, index * 200);
            });
        }, 500);
    }

    // Initialize loading animations after page load
    $(window).on('load', function() {
        initLoadingAnimations();
    });

    /**
     * Initialize contact form handling
     */
    function initContactForm() {
        const contactForm = $('#contact-form');
        
        if (contactForm.length) {
            contactForm.on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                const submitButton = $(this).find('button[type="submit"]');
                const originalText = submitButton.text();
                
                // Show loading state
                submitButton.text('Sending...').prop('disabled', true);
                
                // Send form data via AJAX
                $.ajax({
                    url: greentech_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'handle_contact_form',
                        nonce: greentech_ajax.nonce,
                        form_data: formData
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification('Thank you! Your message has been sent successfully.', 'success');
                            contactForm[0].reset();
                        } else {
                            showNotification('Sorry, there was an error sending your message. Please try again.', 'error');
                        }
                    },
                    error: function() {
                        showNotification('Sorry, there was an error sending your message. Please try again.', 'error');
                    },
                    complete: function() {
                        submitButton.text(originalText).prop('disabled', false);
                    }
                });
            });
        }
    }

    /**
     * Show notification
     */
    function showNotification(message, type) {
        const notification = $('<div class="notification notification-' + type + '">' + message + '</div>');
        $('body').append(notification);
        
        setTimeout(function() {
            notification.addClass('show');
        }, 100);
        
        setTimeout(function() {
            notification.removeClass('show');
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }

    /**
     * Initialize lazy loading for images
     */
    function initLazyLoading() {
        const lazyImages = $('img[data-src]');
        
        if (lazyImages.length && 'IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            lazyImages.each(function() {
                imageObserver.observe(this);
            });
        }
    }

    // Initialize lazy loading
    initLazyLoading();

    // Custom easing function
    $.easing.easeInOutExpo = function(x, t, b, c, d) {
        if (t === 0) return b;
        if (t === d) return b + c;
        if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
        return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
    };

    // Initialize everything after DOM is ready
    $(document).ready(function() {
        initContactForm();
    });

})(jQuery);

/**
 * Vanilla JavaScript for performance-critical features
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize parallax effect for hero section
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            hero.style.transform = 'translateY(' + rate + 'px)';
        });
    }
    
    // Initialize tech logo hover effects
    const techLogos = document.querySelectorAll('.tech-logo');
    techLogos.forEach(function(logo) {
        logo.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.05)';
        });
        
        logo.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Initialize service card animations
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Initialize portfolio item animations
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    portfolioItems.forEach(function(item) {
        item.addEventListener('mouseenter', function() {
            const image = this.querySelector('.portfolio-image img');
            if (image) {
                image.style.transform = 'scale(1.1)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const image = this.querySelector('.portfolio-image img');
            if (image) {
                image.style.transform = 'scale(1)';
            }
        });
    });
});