<?php
/**
 * Theme Setup Class
 * 
 * Handles WordPress theme setup, menus, widget areas, and basic configuration
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
 * Theme Setup Class
 */
class Theme_Setup {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('init', [$this, 'register_menus']);
        add_action('widgets_init', [$this, 'register_sidebars']);
        add_action('after_setup_theme', [$this, 'content_width'], 0);
    }
    
    /**
     * Register navigation menus
     */
    public function register_menus() {
        register_nav_menus([
            'primary' => __('Primary Menu', 'greentech'),
            'footer' => __('Footer Menu', 'greentech'),
            'social' => __('Social Media Menu', 'greentech')
        ]);
    }
    
    /**
     * Register widget areas
     */
    public function register_sidebars() {
        // Main sidebar
        register_sidebar([
            'name' => __('Sidebar', 'greentech'),
            'id' => 'sidebar-1',
            'description' => __('Add widgets here to appear in your sidebar.', 'greentech'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ]);
        
        // Footer widget areas
        for ($i = 1; $i <= 4; $i++) {
            register_sidebar([
                'name' => sprintf(__('Footer Widget Area %d', 'greentech'), $i),
                'id' => 'footer-' . $i,
                'description' => sprintf(__('Add widgets here to appear in footer column %d.', 'greentech'), $i),
                'before_widget' => '<div class="footer-widget">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ]);
        }
        
        // Homepage widgets
        register_sidebar([
            'name' => __('Homepage Widgets', 'greentech'),
            'id' => 'homepage-widgets',
            'description' => __('Add widgets here to appear on the homepage.', 'greentech'),
            'before_widget' => '<section id="%1$s" class="homepage-widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ]);
    }
    
    /**
     * Set content width
     */
    public function content_width() {
        $GLOBALS['content_width'] = apply_filters('greentech_content_width', 1200);
    }
}