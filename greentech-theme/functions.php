<?php
/**
 * GreenTech Theme Functions
 * 
 * Modern WordPress theme built for Gutenberg with clean OOP architecture.
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('GREENTECH_VERSION', '1.0.0');
define('GREENTECH_THEME_DIR', get_template_directory());
define('GREENTECH_THEME_URI', get_template_directory_uri());
define('GREENTECH_ASSETS_URI', GREENTECH_THEME_URI . '/assets');

/**
 * Theme autoloader
 * 
 * @param string $class_name The class name to load
 */
function greentech_autoloader($class_name) {
    // Check if the class is in our namespace
    if (strpos($class_name, __NAMESPACE__) !== 0) {
        return;
    }
    
    // Remove namespace prefix
    $class_name = str_replace(__NAMESPACE__ . '\\', '', $class_name);
    
    // Convert to file path
    $file_name = 'class-' . strtolower(str_replace('_', '-', $class_name)) . '.php';
    $file_path = GREENTECH_THEME_DIR . '/inc/' . $file_name;
    
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

// Register autoloader
spl_autoload_register(__NAMESPACE__ . '\\greentech_autoloader');

/**
 * Main Theme Class
 * 
 * Coordinates all theme functionality
 */
class Theme {
    
    /**
     * Theme version
     */
    public $version = GREENTECH_VERSION;
    
    /**
     * Initialize the theme
     */
    public function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }
    
    /**
     * Load required files and initialize classes
     */
    private function load_dependencies() {
        // Load core classes
        new Theme_Setup();
        new Assets();
        new Customizer();
        new Block_Styles();
        new Block_Patterns();
        
        // Load admin classes if in admin
        if (is_admin()) {
            new Admin();
        }
    }
    
    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        add_action('after_setup_theme', [$this, 'setup']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);
        add_filter('body_class', [$this, 'body_classes']);
        add_action('wp_head', [$this, 'add_meta_tags']);
    }
    
    /**
     * Theme setup
     */
    public function setup() {
        // Load text domain
        load_theme_textdomain('greentech', GREENTECH_THEME_DIR . '/languages');
        
        // Add theme support
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
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
        
        // Add custom logo support
        add_theme_support('custom-logo', [
            'height' => 100,
            'width' => 400,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => ['site-title', 'site-description'],
            'unlink-homepage-logo' => true,
        ]);
        
        // Add custom background support
        add_theme_support('custom-background', [
            'default-color' => 'ffffff',
        ]);
        
        // Add custom header support
        add_theme_support('custom-header', [
            'default-image' => '',
            'width' => 1920,
            'height' => 800,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => true,
        ]);
        
        // Register navigation menus
        register_nav_menus([
            'primary' => __('Primary Menu', 'greentech'),
            'footer' => __('Footer Menu', 'greentech'),
            'social' => __('Social Links Menu', 'greentech'),
        ]);
        
        // Set content width
        if (!isset($content_width)) {
            $content_width = 1200;
        }
        
        // Add editor styles
        add_editor_style('assets/css/editor-style.css');
        
        // Add theme.json support
        add_theme_support('appearance-tools');
        
        // Remove core block patterns
        remove_theme_support('core-block-patterns');
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        // Main stylesheet
        wp_enqueue_style(
            'greentech-style',
            get_stylesheet_uri(),
            [],
            $this->version
        );
        
        // Google Fonts
        $google_fonts_url = $this->get_google_fonts_url();
        if ($google_fonts_url) {
            wp_enqueue_style(
                'greentech-google-fonts',
                $google_fonts_url,
                [],
                null
            );
        }
        
        // Main JavaScript
        wp_enqueue_script(
            'greentech-main',
            GREENTECH_ASSETS_URI . '/js/main.js',
            ['jquery'],
            $this->version,
            true
        );
        
        // Localize script
        wp_localize_script('greentech-main', 'greentech_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('greentech_nonce'),
        ]);
        
        // Comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
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
            $this->version
        );
        
        // Editor script
        wp_enqueue_script(
            'greentech-editor-script',
            GREENTECH_ASSETS_URI . '/js/editor.js',
            ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
            $this->version,
            true
        );
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
     * Add custom body classes
     */
    public function body_classes($classes) {
        // Add page-specific classes
        if (is_front_page()) {
            $classes[] = 'home-page';
        }
        
        if (is_page()) {
            $classes[] = 'page-' . get_post_field('post_name');
        }
        
        // Add customizer classes
        if (get_theme_mod('header_sticky', true)) {
            $classes[] = 'has-sticky-header';
        }
        
        if (get_theme_mod('layout_boxed', false)) {
            $classes[] = 'layout-boxed';
        }
        
        return $classes;
    }
    
    /**
     * Add meta tags to head
     */
    public function add_meta_tags() {
        // Viewport meta tag
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
        
        // Theme color for mobile browsers
        $primary_color = get_theme_mod('colors_primary', '#4CAF50');
        echo '<meta name="theme-color" content="' . esc_attr($primary_color) . '">' . "\n";
        
        // Preconnect to Google Fonts
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    }
}

// Initialize the theme
new Theme();

/**
 * Helper function to get theme instance
 */
function greentech() {
    static $instance = null;
    
    if (null === $instance) {
        $instance = new Theme();
    }
    
    return $instance;
}

/**
 * Template helper functions
 */

/**
 * Get customizer option with default fallback
 */
function greentech_get_option($option, $default = '') {
    return get_theme_mod($option, $default);
}

/**
 * Display site logo
 */
function greentech_site_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url(home_url('/')) . '" class="site-title-link">';
        echo '<span class="site-title">' . get_bloginfo('name') . '</span>';
        if (get_bloginfo('description')) {
            echo '<span class="site-description">' . get_bloginfo('description') . '</span>';
        }
        echo '</a>';
    }
}

/**
 * Display navigation menu
 */
function greentech_nav_menu($location = 'primary', $args = []) {
    $defaults = [
        'theme_location' => $location,
        'container' => 'nav',
        'container_class' => $location . '-navigation',
        'menu_class' => $location . '-menu',
        'fallback_cb' => false,
        'depth' => 2,
    ];
    
    $args = wp_parse_args($args, $defaults);
    
    if (has_nav_menu($location)) {
        wp_nav_menu($args);
    }
}

/**
 * Display social links menu
 */
function greentech_social_links() {
    if (has_nav_menu('social')) {
        wp_nav_menu([
            'theme_location' => 'social',
            'container' => 'nav',
            'container_class' => 'social-navigation',
            'menu_class' => 'social-links',
            'link_before' => '<span class="screen-reader-text">',
            'link_after' => '</span>',
            'depth' => 1,
        ]);
    }
}

/**
 * Get contact information from customizer
 */
function greentech_get_contact_info() {
    return [
        'phone' => get_theme_mod('contact_phone', ''),
        'email' => get_theme_mod('contact_email', ''),
        'address' => get_theme_mod('contact_address', ''),
        'website' => get_theme_mod('contact_website', ''),
    ];
}

/**
 * Display contact information
 */
function greentech_contact_info($field = '') {
    $contact = greentech_get_contact_info();
    
    if ($field && isset($contact[$field])) {
        echo esc_html($contact[$field]);
    } else {
        return $contact;
    }
}

/**
 * Custom excerpt length
 */
function greentech_excerpt_length($length) {
    return get_theme_mod('blog_excerpt_length', 30);
}
add_filter('excerpt_length', __NAMESPACE__ . '\\greentech_excerpt_length');

/**
 * Custom excerpt more text
 */
function greentech_excerpt_more($more) {
    return '&hellip; <a href="' . get_permalink() . '" class="read-more">' . 
           __('Continue reading', 'greentech') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\greentech_excerpt_more');

/**
 * Custom pagination
 */
function greentech_pagination() {
    $pagination = paginate_links([
        'type' => 'array',
        'prev_text' => '&laquo; ' . __('Previous', 'greentech'),
        'next_text' => __('Next', 'greentech') . ' &raquo;',
    ]);
    
    if ($pagination) {
        echo '<nav class="pagination" role="navigation">';
        echo '<ul class="pagination-list">';
        foreach ($pagination as $page) {
            echo '<li class="pagination-item">' . $page . '</li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
}

/**
 * Schema.org markup for organization
 */
function greentech_schema_organization() {
    $contact = greentech_get_contact_info();
    $logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url(),
        'description' => get_bloginfo('description'),
    ];
    
    if ($logo) {
        $schema['logo'] = $logo[0];
    }
    
    if ($contact['phone']) {
        $schema['telephone'] = $contact['phone'];
    }
    
    if ($contact['email']) {
        $schema['email'] = $contact['email'];
    }
    
    if ($contact['address']) {
        $schema['address'] = $contact['address'];
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}

/**
 * Add schema markup to head
 */
function greentech_add_schema() {
    if (is_front_page()) {
        greentech_schema_organization();
    }
}
add_action('wp_head', __NAMESPACE__ . '\\greentech_add_schema');

/**
 * Disable WordPress emoji scripts
 */
function greentech_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', __NAMESPACE__ . '\\greentech_disable_emojis');

/**
 * Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Add security headers
 */
function greentech_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', __NAMESPACE__ . '\\greentech_security_headers');

/**
 * Optimize WordPress queries
 */
function greentech_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Limit post revisions
        if (!defined('WP_POST_REVISIONS')) {
            define('WP_POST_REVISIONS', 3);
        }
        
        // Disable attachment pages
        if ($query->is_attachment()) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
        }
    }
}
add_action('pre_get_posts', __NAMESPACE__ . '\\greentech_optimize_queries');

/**
 * Add custom CSS variables to head
 */
function greentech_css_variables() {
    $primary_color = get_theme_mod('colors_primary', '#4CAF50');
    $secondary_color = get_theme_mod('colors_secondary', '#1a1a1a');
    $accent_color = get_theme_mod('colors_accent', '#66bb6a');
    
    $css = ':root {';
    $css .= '--wp--preset--color--primary: ' . $primary_color . ';';
    $css .= '--wp--preset--color--secondary: ' . $secondary_color . ';';
    $css .= '--wp--preset--color--accent: ' . $accent_color . ';';
    $css .= '--wp--preset--color--primary-hover: ' . $this->adjust_brightness($primary_color, -20) . ';';
    $css .= '}';
    
    echo '<style id="greentech-css-variables">' . $css . '</style>';
}
add_action('wp_head', __NAMESPACE__ . '\\greentech_css_variables');

/**
 * Adjust color brightness
 */
function greentech_adjust_brightness($hex, $percent) {
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
 * Display post meta information
 */
function greentech_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x('Posted on %s', 'post date', 'greentech'),
        '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display post author information
 */
function greentech_posted_by() {
    $byline = sprintf(
        /* translators: %s: post author. */
        esc_html_x('by %s', 'post author', 'greentech'),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display entry footer with categories, tags, and edit link
 */
function greentech_entry_footer() {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'greentech'));
        if ($categories_list) {
            /* translators: 1: list of categories. */
            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'greentech') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'greentech'));
        if ($tags_list) {
            /* translators: 1: list of tags. */
            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'greentech') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'greentech'),
                    [
                        'span' => [
                            'class' => [],
                        ],
                    ]
                ),
                wp_kses_post(get_the_title())
            )
        );
        echo '</span>';
    }

    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __('Edit <span class="screen-reader-text">"%s"</span>', 'greentech'),
                [
                    'span' => [
                        'class' => [],
                    ],
                ]
            ),
            wp_kses_post(get_the_title())
        ),
        '<span class="edit-link">',
        '</span>'
    );
}