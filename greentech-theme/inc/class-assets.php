<?php
/**
 * Assets Class
 * 
 * Handles enqueuing and optimizing CSS and JavaScript files
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
     * Initialize the class
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_fonts']);
        add_filter('script_loader_tag', [$this, 'add_async_defer'], 10, 3);
        add_filter('style_loader_tag', [$this, 'add_preload_styles'], 10, 4);
    }
    
    /**
     * Enqueue theme styles
     */
    public function enqueue_styles() {
        // Main theme stylesheet
        wp_enqueue_style(
            'greentech-style',
            get_stylesheet_uri(),
            [],
            GREENTECH_VERSION
        );
        
        // Print styles
        wp_enqueue_style(
            'greentech-print',
            GREENTECH_ASSETS_URI . '/css/print.css',
            ['greentech-style'],
            GREENTECH_VERSION,
            'print'
        );
        
        // RTL support
        if (is_rtl()) {
            wp_enqueue_style(
                'greentech-rtl',
                GREENTECH_ASSETS_URI . '/css/rtl.css',
                ['greentech-style'],
                GREENTECH_VERSION
            );
        }
        
        // Add inline styles for customizer options
        $this->add_inline_styles();
    }
    
    /**
     * Enqueue theme scripts
     */
    public function enqueue_scripts() {
        // Main theme script
        wp_enqueue_script(
            'greentech-main',
            GREENTECH_ASSETS_URI . '/js/main.js',
            ['jquery'],
            GREENTECH_VERSION,
            true
        );
        
        // Localize script with AJAX data
        wp_localize_script('greentech-main', 'greentechAjax', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('greentech_nonce'),
            'strings' => [
                'loading' => __('Loading...', 'greentech'),
                'error' => __('An error occurred. Please try again.', 'greentech'),
                'success' => __('Success!', 'greentech'),
            ]
        ]);
        
        // Comments script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        
        // Skip link focus fix for IE11
        wp_enqueue_script(
            'greentech-skip-link-focus-fix',
            GREENTECH_ASSETS_URI . '/js/skip-link-focus-fix.js',
            [],
            GREENTECH_VERSION,
            true
        );
        
        // Navigation script for mobile
        wp_enqueue_script(
            'greentech-navigation',
            GREENTECH_ASSETS_URI . '/js/navigation.js',
            ['greentech-main'],
            GREENTECH_VERSION,
            true
        );
        
        // Smooth scroll polyfill for older browsers
        wp_enqueue_script(
            'greentech-smooth-scroll',
            GREENTECH_ASSETS_URI . '/js/smooth-scroll.min.js',
            [],
            GREENTECH_VERSION,
            true
        );
    }
    
    /**
     * Enqueue Google Fonts
     */
    public function enqueue_fonts() {
        // Inter font family
        $font_url = $this->get_google_font_url();
        
        if ($font_url) {
            wp_enqueue_style(
                'greentech-fonts',
                $font_url,
                [],
                null
            );
        }
    }
    
    /**
     * Get Google Fonts URL
     * 
     * @return string|false Font URL or false if no fonts needed
     */
    private function get_google_font_url() {
        $fonts = [];
        $subsets = 'latin,latin-ext';
        
        // Inter font
        $fonts[] = 'Inter:300,400,500,600,700';
        
        // Allow filtering of fonts
        $fonts = apply_filters('greentech_google_fonts', $fonts);
        
        if (empty($fonts)) {
            return false;
        }
        
        $query_args = [
            'family' => implode('|', $fonts),
            'subset' => $subsets,
            'display' => 'swap',
        ];
        
        return add_query_arg($query_args, 'https://fonts.googleapis.com/css2');
    }
    
    /**
     * Add inline styles for customizer options
     */
    private function add_inline_styles() {
        $primary_color = get_theme_mod('primary_color', '#4CAF50');
        
        $custom_css = "
            :root {
                --primary-color: {$primary_color};
                --primary-hover: " . $this->adjust_brightness($primary_color, -20) . ";
                --primary-light: " . $this->adjust_brightness($primary_color, 20) . ";
                --primary-dark: " . $this->adjust_brightness($primary_color, -40) . ";
            }
        ";
        
        // Add any additional customizer CSS
        $additional_css = get_theme_mod('additional_css', '');
        if ($additional_css) {
            $custom_css .= "\n" . $additional_css;
        }
        
        wp_add_inline_style('greentech-style', $custom_css);
    }
    
    /**
     * Adjust color brightness
     * 
     * @param string $hex_color Hex color
     * @param int $percent Percentage to adjust (-100 to 100)
     * @return string Adjusted hex color
     */
    private function adjust_brightness($hex_color, $percent) {
        $hex_color = ltrim($hex_color, '#');
        
        if (strlen($hex_color) === 3) {
            $hex_color = str_repeat(substr($hex_color, 0, 1), 2) .
                        str_repeat(substr($hex_color, 1, 1), 2) .
                        str_repeat(substr($hex_color, 2, 1), 2);
        }
        
        $rgb = array_map('hexdec', str_split($hex_color, 2));
        
        foreach ($rgb as &$color) {
            $adjust_amount = $percent < 0 ? $color * $percent / 100 : (255 - $color) * $percent / 100;
            $color = max(0, min(255, $color + $adjust_amount));
        }
        
        return '#' . implode('', array_map(function($val) {
            return str_pad(dechex($val), 2, '0', STR_PAD_LEFT);
        }, $rgb));
    }
    
    /**
     * Add async/defer attributes to scripts
     * 
     * @param string $tag HTML tag
     * @param string $handle Script handle
     * @param string $src Script source
     * @return string Modified tag
     */
    public function add_async_defer($tag, $handle, $src) {
        // Scripts that should be loaded async
        $async_scripts = [
            'greentech-main',
            'greentech-smooth-scroll'
        ];
        
        // Scripts that should be deferred
        $defer_scripts = [
            'greentech-navigation',
            'greentech-skip-link-focus-fix'
        ];
        
        if (in_array($handle, $async_scripts)) {
            return str_replace('<script ', '<script async ', $tag);
        }
        
        if (in_array($handle, $defer_scripts)) {
            return str_replace('<script ', '<script defer ', $tag);
        }
        
        return $tag;
    }
    
    /**
     * Add preload for critical CSS
     * 
     * @param string $html HTML tag
     * @param string $handle Style handle
     * @param string $href Style href
     * @param string $media Media query
     * @return string Modified tag
     */
    public function add_preload_styles($html, $handle, $href, $media) {
        // Critical styles that should be preloaded
        $preload_styles = [
            'greentech-style',
            'greentech-fonts'
        ];
        
        if (in_array($handle, $preload_styles)) {
            $preload = '<link rel="preload" href="' . $href . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
            $noscript = '<noscript>' . $html . '</noscript>';
            return $preload . $noscript;
        }
        
        return $html;
    }
    
    /**
     * Get asset version based on file modification time
     * 
     * @param string $file_path File path
     * @return string Version string
     */
    public static function get_asset_version($file_path) {
        if (file_exists($file_path)) {
            return filemtime($file_path);
        }
        
        return GREENTECH_VERSION;
    }
}