<?php
/**
 * Theme Setup Class
 * 
 * Handles theme setup, configuration, and WordPress feature support.
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
     * Constructor
     */
    public function __construct() {
        add_action('after_setup_theme', [$this, 'setup_theme']);
        add_action('widgets_init', [$this, 'register_sidebars']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_styles']);
    }
    
    /**
     * Setup theme features and support
     */
    public function setup_theme() {
        // Make theme available for translation
        load_theme_textdomain('greentech', GREENTECH_THEME_DIR . '/languages');
        
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');
        
        // Let WordPress manage the document title
        add_theme_support('title-tag');
        
        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');
        
        // Switch default core markup to output valid HTML5
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ]);
        
        // Add support for core custom logo
        add_theme_support('custom-logo', [
            'height'      => 100,
            'width'       => 400,
            'flex-width'  => true,
            'flex-height' => true,
            'header-text' => ['site-title', 'site-description'],
            'unlink-homepage-logo' => true,
        ]);
        
        // Add theme support for selective refresh for widgets
        add_theme_support('customize-selective-refresh-widgets');
        
        // Add support for custom background
        add_theme_support('custom-background', [
            'default-color' => 'ffffff',
            'default-image' => '',
        ]);
        
        // Add support for custom header
        add_theme_support('custom-header', [
            'default-image'      => '',
            'width'              => 1920,
            'height'             => 800,
            'flex-height'        => true,
            'flex-width'         => true,
            'uploads'            => true,
            'random-default'     => false,
            'header-text'        => true,
            'default-text-color' => '1a1a1a',
            'wp-head-callback'   => [$this, 'header_style'],
        ]);
        
        // Add Gutenberg support
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('editor-styles');
        add_theme_support('responsive-embeds');
        add_theme_support('custom-spacing');
        add_theme_support('custom-units');
        add_theme_support('link-color');
        add_theme_support('border');
        add_theme_support('appearance-tools');
        
        // Add support for editor color palette
        add_theme_support('editor-color-palette', [
            [
                'name'  => __('Primary', 'greentech'),
                'slug'  => 'primary',
                'color' => '#4CAF50',
            ],
            [
                'name'  => __('Secondary', 'greentech'),
                'slug'  => 'secondary',
                'color' => '#1a1a1a',
            ],
            [
                'name'  => __('Accent', 'greentech'),
                'slug'  => 'accent',
                'color' => '#66bb6a',
            ],
            [
                'name'  => __('Background', 'greentech'),
                'slug'  => 'background',
                'color' => '#ffffff',
            ],
            [
                'name'  => __('Foreground', 'greentech'),
                'slug'  => 'foreground',
                'color' => '#1a1a1a',
            ],
            [
                'name'  => __('Tertiary', 'greentech'),
                'slug'  => 'tertiary',
                'color' => '#6b7280',
            ],
        ]);
        
        // Add support for editor font sizes
        add_theme_support('editor-font-sizes', [
            [
                'name' => __('Small', 'greentech'),
                'size' => 14,
                'slug' => 'small'
            ],
            [
                'name' => __('Normal', 'greentech'),
                'size' => 16,
                'slug' => 'normal'
            ],
            [
                'name' => __('Medium', 'greentech'),
                'size' => 20,
                'slug' => 'medium'
            ],
            [
                'name' => __('Large', 'greentech'),
                'size' => 24,
                'slug' => 'large'
            ],
            [
                'name' => __('Extra Large', 'greentech'),
                'size' => 32,
                'slug' => 'extra-large'
            ],
            [
                'name' => __('Huge', 'greentech'),
                'size' => 48,
                'slug' => 'huge'
            ],
        ]);
        
        // Disable custom colors
        add_theme_support('disable-custom-colors');
        
        // Disable custom font sizes
        add_theme_support('disable-custom-font-sizes');
        
        // Remove core block patterns
        remove_theme_support('core-block-patterns');
        
        // Register navigation menus
        register_nav_menus([
            'primary' => __('Primary Menu', 'greentech'),
            'footer'  => __('Footer Menu', 'greentech'),
            'social'  => __('Social Links Menu', 'greentech'),
        ]);
        
        // Set content width
        if (!isset($content_width)) {
            $content_width = 1200;
        }
        
        // Add image sizes
        add_image_size('greentech-featured', 800, 600, true);
        add_image_size('greentech-thumbnail', 400, 300, true);
        add_image_size('greentech-hero', 1920, 800, true);
        add_image_size('greentech-card', 600, 400, true);
    }
    
    /**
     * Register widget areas
     */
    public function register_sidebars() {
        // Primary sidebar
        register_sidebar([
            'name'          => __('Primary Sidebar', 'greentech'),
            'id'            => 'sidebar-1',
            'description'   => __('Add widgets here to appear in your sidebar.', 'greentech'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
        
        // Footer widgets
        for ($i = 1; $i <= 4; $i++) {
            register_sidebar([
                'name'          => sprintf(__('Footer Widget Area %d', 'greentech'), $i),
                'id'            => 'footer-' . $i,
                'description'   => sprintf(__('Add widgets here to appear in footer column %d.', 'greentech'), $i),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h4 class="widget-title">',
                'after_title'   => '</h4>',
            ]);
        }
        
        // Header widget area
        register_sidebar([
            'name'          => __('Header Widget Area', 'greentech'),
            'id'            => 'header-widgets',
            'description'   => __('Add widgets here to appear in the header area.', 'greentech'),
            'before_widget' => '<div id="%1$s" class="header-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="header-widget-title">',
            'after_title'   => '</h4>',
        ]);
    }
    
    /**
     * Enqueue theme styles
     */
    public function enqueue_styles() {
        // Theme stylesheet
        wp_enqueue_style(
            'greentech-style',
            get_stylesheet_uri(),
            [],
            GREENTECH_VERSION
        );
        
        // Add inline styles for customizer options
        $this->add_customizer_styles();
    }
    
    /**
     * Enqueue editor styles
     */
    public function enqueue_editor_styles() {
        // Editor stylesheet
        wp_enqueue_style(
            'greentech-editor-style',
            GREENTECH_ASSETS_URI . '/css/editor-style.css',
            ['wp-edit-blocks'],
            GREENTECH_VERSION
        );
        
        // Add Google Fonts for editor
        wp_enqueue_style(
            'greentech-editor-fonts',
            $this->get_google_fonts_url(),
            [],
            null
        );
    }
    
    /**
     * Add customizer styles
     */
    private function add_customizer_styles() {
        $primary_color = get_theme_mod('colors_primary', '#4CAF50');
        $secondary_color = get_theme_mod('colors_secondary', '#1a1a1a');
        $accent_color = get_theme_mod('colors_accent', '#66bb6a');
        
        $custom_css = "
            :root {
                --wp--preset--color--primary: {$primary_color};
                --wp--preset--color--secondary: {$secondary_color};
                --wp--preset--color--accent: {$accent_color};
                --wp--preset--color--primary-hover: " . $this->adjust_brightness($primary_color, -20) . ";
            }
        ";
        
        wp_add_inline_style('greentech-style', $custom_css);
    }
    
    /**
     * Get Google Fonts URL
     */
    private function get_google_fonts_url() {
        $fonts = [
            'Inter:wght@300;400;500;600;700;800',
            'Poppins:wght@300;400;500;600;700;800'
        ];
        
        $fonts_url = add_query_arg([
            'family' => implode('&family=', $fonts),
            'display' => 'swap',
        ], 'https://fonts.googleapis.com/css2');
        
        return $fonts_url;
    }
    
    /**
     * Adjust color brightness
     */
    private function adjust_brightness($hex, $percent) {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        $hex = array_map('hexdec', str_split($hex, 2));
        
        foreach ($hex as &$color) {
            $adjustableLimit = $percent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $percent / 100);
            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }
        
        return '#' . implode($hex);
    }
    
    /**
     * Custom header style callback
     */
    public function header_style() {
        $header_text_color = get_header_textcolor();
        
        if (!empty($header_text_color) && $header_text_color !== 'blank') {
            echo '<style type="text/css">';
            echo '.site-title, .site-description { color: #' . esc_attr($header_text_color) . '; }';
            echo '</style>';
        }
    }
}