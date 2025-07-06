<?php
/**
 * Performance Class
 * 
 * Handles performance optimizations and speed improvements
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
 * Performance Class
 */
class Performance {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('init', [$this, 'disable_emojis']);
        add_action('wp_enqueue_scripts', [$this, 'dequeue_scripts'], 100);
        add_filter('wp_resource_hints', [$this, 'resource_hints'], 10, 2);
        add_action('wp_head', [$this, 'preload_assets'], 1);
        add_filter('script_loader_src', [$this, 'add_script_version'], 10, 2);
        add_filter('style_loader_src', [$this, 'add_style_version'], 10, 2);
        add_action('wp_footer', [$this, 'inline_critical_scripts'], 20);
        add_filter('body_class', [$this, 'add_performance_classes']);
    }
    
    /**
     * Disable WordPress emojis
     */
    public function disable_emojis() {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        
        // Remove from TinyMCE
        add_filter('tiny_mce_plugins', [$this, 'disable_emojis_tinymce']);
        add_filter('wp_resource_hints', [$this, 'disable_emojis_remove_dns_prefetch'], 10, 2);
    }
    
    /**
     * Remove emoji plugin from TinyMCE
     */
    public function disable_emojis_tinymce($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        }
        return [];
    }
    
    /**
     * Remove emoji DNS prefetch
     */
    public function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
            $urls = array_diff($urls, [$emoji_svg_url]);
        }
        
        return $urls;
    }
    
    /**
     * Dequeue unnecessary scripts and styles
     */
    public function dequeue_scripts() {
        // Remove jQuery Migrate in production
        if (!is_admin() && !WP_DEBUG) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), false, null, true);
            wp_enqueue_script('jquery');
        }
        
        // Remove block library CSS if not using Gutenberg
        if (!is_admin() && !current_theme_supports('wp-block-styles')) {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-blocks-style');
        }
        
        // Remove classic theme styles if not needed
        wp_dequeue_style('classic-theme-styles');
        
        // Remove global styles
        wp_dequeue_style('global-styles');
    }
    
    /**
     * Add resource hints
     */
    public function resource_hints($urls, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            $urls[] = '//fonts.googleapis.com';
            $urls[] = '//fonts.gstatic.com';
        }
        
        if ('preconnect' === $relation_type) {
            $urls[] = [
                'href' => 'https://fonts.googleapis.com',
                'crossorigin',
            ];
            $urls[] = [
                'href' => 'https://fonts.gstatic.com',
                'crossorigin',
            ];
        }
        
        return $urls;
    }
    
    /**
     * Preload critical assets
     */
    public function preload_assets() {
        // Preload primary font
        echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
        echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"></noscript>' . "\n";
        
        // Preload critical CSS
        $critical_css = GREENTECH_ASSETS_URI . '/css/critical.css';
        if (file_exists(str_replace(GREENTECH_ASSETS_URI, GREENTECH_THEME_DIR . '/assets', $critical_css))) {
            echo '<link rel="preload" href="' . $critical_css . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
        }
        
        // Preload hero image if on front page
        if (is_front_page()) {
            $hero_image = GREENTECH_ASSETS_URI . '/images/hero-bg.jpg';
            echo '<link rel="preload" href="' . $hero_image . '" as="image">' . "\n";
        }
    }
    
    /**
     * Add version to scripts based on file modification time
     */
    public function add_script_version($src, $handle) {
        if (strpos($src, GREENTECH_ASSETS_URI) !== false) {
            $file_path = str_replace(GREENTECH_ASSETS_URI, GREENTECH_THEME_DIR . '/assets', $src);
            if (file_exists($file_path)) {
                $version = filemtime($file_path);
                $src = add_query_arg('ver', $version, $src);
            }
        }
        
        return $src;
    }
    
    /**
     * Add version to styles based on file modification time
     */
    public function add_style_version($src, $handle) {
        if (strpos($src, GREENTECH_ASSETS_URI) !== false) {
            $file_path = str_replace(GREENTECH_ASSETS_URI, GREENTECH_THEME_DIR . '/assets', $src);
            if (file_exists($file_path)) {
                $version = filemtime($file_path);
                $src = add_query_arg('ver', $version, $src);
            }
        }
        
        return $src;
    }
    
    /**
     * Inline critical JavaScript
     */
    public function inline_critical_scripts() {
        if (!is_admin()) {
            ?>
            <script>
            // Critical inline scripts for performance
            (function() {
                // Lazy load images
                if ('IntersectionObserver' in window) {
                    const imageObserver = new IntersectionObserver((entries, observer) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const img = entry.target;
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        });
                    });
                    
                    document.querySelectorAll('img[data-src]').forEach(img => {
                        imageObserver.observe(img);
                    });
                }
                
                // Preload links on hover
                const linkObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const link = entry.target;
                            link.addEventListener('mouseenter', () => {
                                const linkTag = document.createElement('link');
                                linkTag.rel = 'prefetch';
                                linkTag.href = link.href;
                                document.head.appendChild(linkTag);
                            }, { once: true });
                            linkObserver.unobserve(link);
                        }
                    });
                });
                
                document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]').forEach(link => {
                    linkObserver.observe(link);
                });
            })();
            </script>
            <?php
        }
    }
    
    /**
     * Add performance-related body classes
     */
    public function add_performance_classes($classes) {
        // Add connection type if available
        if (isset($_SERVER['HTTP_SAVE_DATA']) && $_SERVER['HTTP_SAVE_DATA'] === 'on') {
            $classes[] = 'save-data';
        }
        
        // Add device type classes
        if (wp_is_mobile()) {
            $classes[] = 'mobile-device';
        } else {
            $classes[] = 'desktop-device';
        }
        
        // Add browser classes for specific optimizations
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (strpos($user_agent, 'Chrome') !== false) {
            $classes[] = 'chrome';
        } elseif (strpos($user_agent, 'Firefox') !== false) {
            $classes[] = 'firefox';
        } elseif (strpos($user_agent, 'Safari') !== false) {
            $classes[] = 'safari';
        } elseif (strpos($user_agent, 'Edge') !== false) {
            $classes[] = 'edge';
        }
        
        return $classes;
    }
    
    /**
     * Optimize database queries
     */
    public static function optimize_queries() {
        // Remove unnecessary queries
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        
        // Disable XML-RPC
        add_filter('xmlrpc_enabled', '__return_false');
        
        // Remove query strings from static resources
        add_filter('script_loader_src', [__CLASS__, 'remove_script_version'], 15, 1);
        add_filter('style_loader_src', [__CLASS__, 'remove_script_version'], 15, 1);
    }
    
    /**
     * Remove version query strings
     */
    public static function remove_script_version($src) {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    
    /**
     * Enable Gzip compression
     */
    public static function enable_compression() {
        if (!is_admin() && !headers_sent()) {
            if (function_exists('ob_gzhandler') && ob_get_level() == 0) {
                ob_start('ob_gzhandler');
            }
        }
    }
    
    /**
     * Set up caching headers
     */
    public static function set_cache_headers() {
        if (!is_admin() && !is_user_logged_in()) {
            $expires = 31536000; // 1 year
            header('Cache-Control: public, max-age=' . $expires);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
            header('Vary: Accept-Encoding');
        }
    }
}