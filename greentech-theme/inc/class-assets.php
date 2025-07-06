<?php
/**
 * Assets Class
 * 
 * Handles asset management, enqueuing, and optimization.
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
 * Assets Class
 */
class Assets {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);
        add_action('wp_head', [$this, 'add_preload_links'], 1);
        add_filter('style_loader_tag', [$this, 'add_style_attributes'], 10, 2);
        add_filter('script_loader_tag', [$this, 'add_script_attributes'], 10, 2);
    }
    
    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        // Google Fonts with display=swap for performance
        $google_fonts_url = $this->get_google_fonts_url();
        if ($google_fonts_url) {
            wp_enqueue_style(
                'greentech-google-fonts',
                $google_fonts_url,
                [],
                null
            );
        }
        
        // Main theme stylesheet
        wp_enqueue_style(
            'greentech-style',
            get_stylesheet_uri(),
            [],
            GREENTECH_VERSION
        );
        
        // Main JavaScript file
        wp_enqueue_script(
            'greentech-main',
            GREENTECH_ASSETS_URI . '/js/main.js',
            ['jquery'],
            GREENTECH_VERSION,
            true
        );
        
        // Localize script for AJAX
        wp_localize_script('greentech-main', 'greentech_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('greentech_nonce'),
            'strings' => [
                'loading' => __('Loading...', 'greentech'),
                'error' => __('Something went wrong. Please try again.', 'greentech'),
            ],
        ]);
        
        // Comment reply script for threaded comments
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        
        // Conditional assets
        $this->enqueue_conditional_assets();
    }
    
    /**
     * Enqueue editor assets
     */
    public function enqueue_editor_assets() {
        // Editor styles
        wp_enqueue_style(
            'greentech-editor-style',
            GREENTECH_ASSETS_URI . '/css/editor-style.css',
            ['wp-edit-blocks'],
            GREENTECH_VERSION
        );
        
        // Block styles
        wp_enqueue_style(
            'greentech-block-styles',
            GREENTECH_ASSETS_URI . '/css/block-styles.css',
            ['wp-edit-blocks'],
            GREENTECH_VERSION
        );
        
        // Editor JavaScript
        wp_enqueue_script(
            'greentech-editor-script',
            GREENTECH_ASSETS_URI . '/js/editor.js',
            ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
            GREENTECH_VERSION,
            true
        );
        
        // Google Fonts for editor
        if ($this->get_google_fonts_url()) {
            wp_enqueue_style(
                'greentech-editor-fonts',
                $this->get_google_fonts_url(),
                [],
                null
            );
        }
    }
    
    /**
     * Enqueue conditional assets based on page type
     */
    private function enqueue_conditional_assets() {
        // Contact form styles (if Contact Form 7 is active)
        if (class_exists('WPCF7')) {
            wp_enqueue_style(
                'greentech-contact-form',
                GREENTECH_ASSETS_URI . '/css/contact-form.css',
                ['contact-form-7'],
                GREENTECH_VERSION
            );
        }
        
        // WooCommerce styles (if WooCommerce is active)
        if (class_exists('WooCommerce')) {
            wp_enqueue_style(
                'greentech-woocommerce',
                GREENTECH_ASSETS_URI . '/css/woocommerce.css',
                ['woocommerce-general'],
                GREENTECH_VERSION
            );
        }
        
        // Animation library for enhanced interactions
        if (get_theme_mod('enable_animations', true)) {
            wp_enqueue_script(
                'greentech-animations',
                GREENTECH_ASSETS_URI . '/js/animations.js',
                ['greentech-main'],
                GREENTECH_VERSION,
                true
            );
        }
    }
    
    /**
     * Get Google Fonts URL
     */
    private function get_google_fonts_url() {
        $heading_font = get_theme_mod('typography_heading_font', 'Inter');
        $body_font = get_theme_mod('typography_body_font', 'Inter');
        
        $fonts = [];
        
        // Add heading font
        if ($heading_font !== 'inherit') {
            $fonts[] = $heading_font . ':wght@300;400;500;600;700;800';
        }
        
        // Add body font (if different from heading)
        if ($body_font !== 'inherit' && $body_font !== $heading_font) {
            $fonts[] = $body_font . ':wght@300;400;500;600;700;800';
        }
        
        // Add default fonts if none selected
        if (empty($fonts)) {
            $fonts = [
                'Inter:wght@300;400;500;600;700;800',
                'Poppins:wght@300;400;500;600;700;800'
            ];
        }
        
        if (!empty($fonts)) {
            $fonts_url = add_query_arg([
                'family' => implode('&family=', $fonts),
                'display' => 'swap',
            ], 'https://fonts.googleapis.com/css2');
            
            return $fonts_url;
        }
        
        return false;
    }
    
    /**
     * Add preload links for critical resources
     */
    public function add_preload_links() {
        // Preload Google Fonts
        $google_fonts_url = $this->get_google_fonts_url();
        if ($google_fonts_url) {
            echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
            echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
            echo '<link rel="preload" href="' . esc_url($google_fonts_url) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
            echo '<noscript><link rel="stylesheet" href="' . esc_url($google_fonts_url) . '"></noscript>' . "\n";
        }
        
        // Preload critical CSS (if exists)
        $critical_css_path = GREENTECH_ASSETS_URI . '/css/critical.css';
        if (file_exists(str_replace(GREENTECH_ASSETS_URI, GREENTECH_THEME_DIR . '/assets', $critical_css_path))) {
            echo '<link rel="preload" href="' . esc_url($critical_css_path) . '" as="style">' . "\n";
        }
        
        // Preload main JavaScript
        echo '<link rel="preload" href="' . esc_url(GREENTECH_ASSETS_URI . '/js/main.js') . '" as="script">' . "\n";
    }
    
    /**
     * Add attributes to style tags
     */
    public function add_style_attributes($html, $handle) {
        // Add media="print" onload for non-critical CSS
        if (strpos($handle, 'google-fonts') !== false) {
            $html = str_replace(' media=\'all\'', ' media="print" onload="this.media=\'all\'"', $html);
        }
        
        return $html;
    }
    
    /**
     * Add attributes to script tags
     */
    public function add_script_attributes($tag, $handle) {
        // Add async/defer attributes to specific scripts
        $async_scripts = ['greentech-animations'];
        $defer_scripts = ['greentech-main', 'greentech-editor-script'];
        
        if (in_array($handle, $async_scripts)) {
            $tag = str_replace(' src', ' async src', $tag);
        } elseif (in_array($handle, $defer_scripts)) {
            $tag = str_replace(' src', ' defer src', $tag);
        }
        
        return $tag;
    }
    
    /**
     * Get asset version for cache busting
     */
    public function get_asset_version($file_path) {
        $file_path = str_replace(GREENTECH_ASSETS_URI, GREENTECH_THEME_DIR . '/assets', $file_path);
        
        if (file_exists($file_path)) {
            return filemtime($file_path);
        }
        
        return GREENTECH_VERSION;
    }
    
    /**
     * Minify CSS (basic minification)
     */
    public function minify_css($css) {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        
        // Remove unnecessary whitespace
        $css = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $css);
        
        // Remove trailing semicolon before closing brace
        $css = str_replace(';}', '}', $css);
        
        return trim($css);
    }
    
    /**
     * Minify JavaScript (basic minification)
     */
    public function minify_js($js) {
        // Remove single-line comments (but preserve URLs)
        $js = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/', '', $js);
        
        // Remove unnecessary whitespace
        $js = preg_replace('/\s+/', ' ', $js);
        
        return trim($js);
    }
    
    /**
     * Check if asset should be loaded
     */
    public function should_load_asset($asset_name, $context = 'frontend') {
        $load_assets = [
            'frontend' => [
                'main-js' => true,
                'main-css' => true,
                'google-fonts' => true,
                'animations' => get_theme_mod('enable_animations', true),
            ],
            'editor' => [
                'editor-css' => true,
                'block-styles' => true,
                'editor-js' => true,
            ],
        ];
        
        return isset($load_assets[$context][$asset_name]) ? $load_assets[$context][$asset_name] : false;
    }
}