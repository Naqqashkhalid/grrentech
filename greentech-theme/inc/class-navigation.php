<?php
/**
 * Navigation Class
 * 
 * Handles navigation menu rendering and mobile navigation
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Navigation Class
 */
class Navigation {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        add_filter('nav_menu_css_class', [$this, 'add_menu_classes'], 10, 4);
        add_filter('nav_menu_link_attributes', [$this, 'add_menu_link_attributes'], 10, 4);
        add_action('wp_footer', [$this, 'mobile_menu_script']);
    }
    
    /**
     * Add CSS classes to menu items
     * 
     * @param array $classes CSS classes
     * @param WP_Post $item Menu item
     * @param stdClass $args Menu arguments
     * @param int $depth Menu depth
     * @return array Modified classes
     */
    public function add_menu_classes($classes, $item, $args, $depth) {
        if (isset($args->theme_location) && $args->theme_location === 'primary') {
            $classes[] = 'nav-item';
            
            if (in_array('current-menu-item', $classes)) {
                $classes[] = 'active';
            }
            
            if (in_array('menu-item-has-children', $classes)) {
                $classes[] = 'dropdown';
            }
        }
        
        return $classes;
    }
    
    /**
     * Add attributes to menu links
     * 
     * @param array $atts Link attributes
     * @param WP_Post $item Menu item
     * @param stdClass $args Menu arguments
     * @param int $depth Menu depth
     * @return array Modified attributes
     */
    public function add_menu_link_attributes($atts, $item, $args, $depth) {
        if (isset($args->theme_location) && $args->theme_location === 'primary') {
            $atts['class'] = 'nav-link';
            
            if (in_array('menu-item-has-children', $item->classes)) {
                $atts['class'] .= ' dropdown-toggle';
                $atts['data-toggle'] = 'dropdown';
            }
        }
        
        return $atts;
    }
    
    /**
     * Render primary navigation
     */
    public static function render_primary_nav() {
        if (has_nav_menu('primary')) {
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class' => 'nav-menu',
                'container' => false,
                'depth' => 2,
                'fallback_cb' => false,
            ]);
        } else {
            echo '<ul class="nav-menu">';
            echo '<li><a href="' . home_url() . '">' . __('Home', 'greentech') . '</a></li>';
            echo '<li><a href="' . home_url('#services') . '">' . __('Services', 'greentech') . '</a></li>';
            echo '<li><a href="' . home_url('#portfolio') . '">' . __('Portfolio', 'greentech') . '</a></li>';
            echo '<li><a href="' . home_url('#about') . '">' . __('About', 'greentech') . '</a></li>';
            echo '<li><a href="' . home_url('#contact') . '">' . __('Contact', 'greentech') . '</a></li>';
            echo '</ul>';
        }
    }
    
    /**
     * Render footer navigation
     */
    public static function render_footer_nav() {
        if (has_nav_menu('footer')) {
            wp_nav_menu([
                'theme_location' => 'footer',
                'menu_class' => 'footer-menu',
                'container' => false,
                'depth' => 1,
                'fallback_cb' => false,
            ]);
        }
    }
    
    /**
     * Render social navigation
     */
    public static function render_social_nav() {
        if (has_nav_menu('social')) {
            wp_nav_menu([
                'theme_location' => 'social',
                'menu_class' => 'social-menu',
                'container' => false,
                'depth' => 1,
                'link_before' => '<span class="screen-reader-text">',
                'link_after' => '</span>',
                'fallback_cb' => false,
            ]);
        } else {
            self::render_social_links();
        }
    }
    
    /**
     * Render social links from customizer
     */
    public static function render_social_links() {
        $social_networks = [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'github' => 'GitHub',
        ];
        
        echo '<div class="social-links">';
        foreach ($social_networks as $network => $label) {
            $url = get_theme_mod("social_{$network}", '');
            if ($url) {
                echo '<a href="' . esc_url($url) . '" class="social-link ' . esc_attr($network) . '" target="_blank" rel="noopener noreferrer">';
                echo '<span class="sr-only">' . esc_html($label) . '</span>';
                echo self::get_social_icon($network);
                echo '</a>';
            }
        }
        echo '</div>';
    }
    
    /**
     * Get social media icon
     * 
     * @param string $network Social network name
     * @return string SVG icon
     */
    private static function get_social_icon($network) {
        $icons = [
            'facebook' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            'twitter' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
            'instagram' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
            'linkedin' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            'youtube' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
            'github' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>',
        ];
        
        return isset($icons[$network]) ? $icons[$network] : '';
    }
    
    /**
     * Add mobile menu script
     */
    public function mobile_menu_script() {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const primaryMenu = document.querySelector('#primary-menu');
            
            if (menuToggle && primaryMenu) {
                menuToggle.addEventListener('click', function() {
                    const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
                    
                    menuToggle.setAttribute('aria-expanded', !isExpanded);
                    menuToggle.classList.toggle('active');
                    primaryMenu.classList.toggle('active');
                    
                    // Toggle hamburger animation
                    const spans = menuToggle.querySelectorAll('span');
                    spans.forEach(span => span.classList.toggle('active'));
                });
            }
        });
        </script>
        <?php
    }
}