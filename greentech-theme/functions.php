<?php
/**
 * GreenTech Theme Functions
 * 
 * @package GreenTech
 * @version 1.0.0
 */

namespace GreenTech;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup Class
 */
class ThemeSetup {
    
    /**
     * Initialize the theme
     */
    public function __construct() {
        add_action('after_setup_theme', [$this, 'setup']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('init', [$this, 'register_menus']);
        add_action('widgets_init', [$this, 'register_sidebars']);
        add_action('customize_register', [$this, 'customize_register']);
        add_action('wp_head', [$this, 'add_custom_styles']);
    }
    
    /**
     * Theme setup
     */
    public function setup() {
        // Theme support
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ]);
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('custom-header');
        add_theme_support('custom-background');
        add_theme_support('custom-logo');
        add_theme_support('automatic-feed-links');
        
        // Set content width
        if (!isset($content_width)) {
            $content_width = 1200;
        }
        
        // Image sizes
        add_image_size('greentech-hero', 1920, 800, true);
        add_image_size('greentech-portfolio', 400, 300, true);
        add_image_size('greentech-service', 300, 200, true);
        add_image_size('greentech-testimonial', 100, 100, true);
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        // Styles
        wp_enqueue_style('greentech-style', get_stylesheet_uri(), [], '1.0.0');
        wp_enqueue_style('greentech-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', [], null);
        
        // Scripts
        wp_enqueue_script('greentech-main', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], '1.0.0', true);
        
        // Localize script
        wp_localize_script('greentech-main', 'greentech_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('greentech_nonce')
        ]);
        
        // Comments script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
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
     * Register sidebars
     */
    public function register_sidebars() {
        register_sidebar([
            'name' => __('Sidebar', 'greentech'),
            'id' => 'sidebar-1',
            'description' => __('Add widgets here.', 'greentech'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ]);
        
        register_sidebar([
            'name' => __('Footer Widget Area', 'greentech'),
            'id' => 'footer-widgets',
            'description' => __('Add widgets here to appear in the footer.', 'greentech'),
            'before_widget' => '<div class="footer-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ]);
    }
    
    /**
     * Customizer settings
     */
    public function customize_register($wp_customize) {
        
        // Colors Panel
        $wp_customize->add_panel('greentech_colors', [
            'title' => __('GreenTech Colors', 'greentech'),
            'priority' => 30,
        ]);
        
        // Primary Color
        $wp_customize->add_section('primary_color', [
            'title' => __('Primary Color', 'greentech'),
            'panel' => 'greentech_colors',
        ]);
        
        $wp_customize->add_setting('primary_color', [
            'default' => '#4CAF50',
            'sanitize_callback' => 'sanitize_hex_color',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'primary_color', [
            'label' => __('Primary Color', 'greentech'),
            'section' => 'primary_color',
        ]));
        
        // Contact Information
        $wp_customize->add_section('contact_info', [
            'title' => __('Contact Information', 'greentech'),
            'priority' => 35,
        ]);
        
        // Phone
        $wp_customize->add_setting('contact_phone', [
            'default' => '0544-277588',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('contact_phone', [
            'label' => __('Phone Number', 'greentech'),
            'section' => 'contact_info',
            'type' => 'text',
        ]);
        
        // Email
        $wp_customize->add_setting('contact_email', [
            'default' => 'inquiry@greentech.guru',
            'sanitize_callback' => 'sanitize_email',
        ]);
        
        $wp_customize->add_control('contact_email', [
            'label' => __('Email Address', 'greentech'),
            'section' => 'contact_info',
            'type' => 'email',
        ]);
        
        // Address
        $wp_customize->add_setting('contact_address', [
            'default' => 'Office# 11, 1st Floor Soldier Arcade, Al-Markaz Road, Jhelum',
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        
        $wp_customize->add_control('contact_address', [
            'label' => __('Address', 'greentech'),
            'section' => 'contact_info',
            'type' => 'textarea',
        ]);
        
        // Website
        $wp_customize->add_setting('contact_website', [
            'default' => 'www.greentech.guru',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control('contact_website', [
            'label' => __('Website', 'greentech'),
            'section' => 'contact_info',
            'type' => 'url',
        ]);
        
        // Hero Section
        $wp_customize->add_section('hero_section', [
            'title' => __('Hero Section', 'greentech'),
            'priority' => 40,
        ]);
        
        $wp_customize->add_setting('hero_title', [
            'default' => 'Build Your Digital Future with GreenTech',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('hero_title', [
            'label' => __('Hero Title', 'greentech'),
            'section' => 'hero_section',
            'type' => 'text',
        ]);
        
        $wp_customize->add_setting('hero_subtitle', [
            'default' => 'Professional web development, hosting, and digital marketing services for modern businesses.',
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        
        $wp_customize->add_control('hero_subtitle', [
            'label' => __('Hero Subtitle', 'greentech'),
            'section' => 'hero_section',
            'type' => 'textarea',
        ]);
        
        $wp_customize->add_setting('hero_button_text', [
            'default' => 'Get Started',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('hero_button_text', [
            'label' => __('Hero Button Text', 'greentech'),
            'section' => 'hero_section',
            'type' => 'text',
        ]);
        
        $wp_customize->add_setting('hero_button_url', [
            'default' => '#contact',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control('hero_button_url', [
            'label' => __('Hero Button URL', 'greentech'),
            'section' => 'hero_section',
            'type' => 'url',
        ]);
    }
    
    /**
     * Add custom styles to header
     */
    public function add_custom_styles() {
        $primary_color = get_theme_mod('primary_color', '#4CAF50');
        
        if ($primary_color !== '#4CAF50') {
            echo '<style type="text/css">
                :root {
                    --primary-color: ' . esc_attr($primary_color) . ';
                    --primary-dark: ' . esc_attr($this->darken_color($primary_color, 20)) . ';
                    --primary-light: ' . esc_attr($this->lighten_color($primary_color, 20)) . ';
                }
            </style>';
        }
    }
    
    /**
     * Darken a color
     */
    private function darken_color($color, $percent) {
        $color = str_replace('#', '', $color);
        $rgb = array_map('hexdec', str_split($color, 2));
        
        foreach ($rgb as $i => $value) {
            $rgb[$i] = max(0, min(255, $value - ($value * $percent / 100)));
        }
        
        return '#' . implode('', array_map('dechex', $rgb));
    }
    
    /**
     * Lighten a color
     */
    private function lighten_color($color, $percent) {
        $color = str_replace('#', '', $color);
        $rgb = array_map('hexdec', str_split($color, 2));
        
        foreach ($rgb as $i => $value) {
            $rgb[$i] = max(0, min(255, $value + ((255 - $value) * $percent / 100)));
        }
        
        return '#' . implode('', array_map('dechex', $rgb));
    }
}

// Initialize theme
new ThemeSetup();

/**
 * Helper Functions
 */

/**
 * Get services data
 */
function greentech_get_services() {
    return [
        [
            'title' => 'Web & App Development',
            'description' => 'Custom web applications, WordPress sites, mobile apps, ERP systems, and hosting solutions.',
            'icon' => '💻',
            'services' => ['Web Development', 'WordPress', 'Mobile Apps', 'ERP', 'Hosting & Cloud', 'Plugin Development']
        ],
        [
            'title' => 'E-Commerce Development',
            'description' => 'Complete e-commerce solutions on major platforms with payment integration and optimization.',
            'icon' => '🛒',
            'services' => ['Shopify', 'Shopify Plus', 'Magento', 'BigCommerce', 'WooCommerce']
        ],
        [
            'title' => 'Graphic Designing',
            'description' => 'Professional design services for branding, print, digital, and user experience.',
            'icon' => '🎨',
            'services' => ['Logo & Branding', 'Print Design', 'Product Design', 'Banners & Ads', 'UI/UX Design']
        ],
        [
            'title' => 'Digital Marketing',
            'description' => 'Comprehensive digital marketing strategies to grow your online presence and conversions.',
            'icon' => '📈',
            'services' => ['Performance Marketing', 'TikTok Marketing', 'SEO', 'Influencer Marketing', 'Social Media', 'Email Marketing', 'CRO']
        ]
    ];
}

/**
 * Get portfolio items
 */
function greentech_get_portfolio() {
    return [
        [
            'title' => 'E-Commerce Platform',
            'description' => 'Modern Shopify store with custom features',
            'image' => get_template_directory_uri() . '/assets/images/portfolio-1.jpg',
            'category' => 'e-commerce',
            'tags' => ['Shopify', 'E-Commerce', 'Custom Development']
        ],
        [
            'title' => 'Corporate Website',
            'description' => 'Professional WordPress site for law firm',
            'image' => get_template_directory_uri() . '/assets/images/portfolio-2.jpg',
            'category' => 'web-development',
            'tags' => ['WordPress', 'Corporate', 'Responsive']
        ],
        [
            'title' => 'Mobile App',
            'description' => 'iOS and Android app for food delivery',
            'image' => get_template_directory_uri() . '/assets/images/portfolio-3.jpg',
            'category' => 'mobile-app',
            'tags' => ['React Native', 'Mobile', 'Food Delivery']
        ],
        [
            'title' => 'Brand Identity',
            'description' => 'Complete branding package for startup',
            'image' => get_template_directory_uri() . '/assets/images/portfolio-4.jpg',
            'category' => 'design',
            'tags' => ['Branding', 'Logo Design', 'Identity']
        ]
    ];
}

/**
 * Get testimonials
 */
function greentech_get_testimonials() {
    return [
        [
            'content' => 'GreenTech delivered an outstanding e-commerce platform that exceeded our expectations. Their attention to detail and technical expertise is remarkable.',
            'author' => 'Sarah Johnson',
            'position' => 'CEO, Fashion Forward',
            'avatar' => get_template_directory_uri() . '/assets/images/testimonial-1.jpg'
        ],
        [
            'content' => 'The team at GreenTech transformed our online presence completely. Our website traffic increased by 300% within the first month.',
            'author' => 'Mike Chen',
            'position' => 'Marketing Director, Tech Solutions',
            'avatar' => get_template_directory_uri() . '/assets/images/testimonial-2.jpg'
        ],
        [
            'content' => 'Professional, reliable, and innovative. GreenTech has been our go-to partner for all digital marketing needs.',
            'author' => 'Emily Rodriguez',
            'position' => 'Founder, Local Business Hub',
            'avatar' => get_template_directory_uri() . '/assets/images/testimonial-3.jpg'
        ]
    ];
}

/**
 * Get technology logos
 */
function greentech_get_technologies() {
    return [
        ['name' => 'WordPress', 'logo' => get_template_directory_uri() . '/assets/images/tech-wordpress.png'],
        ['name' => 'Shopify', 'logo' => get_template_directory_uri() . '/assets/images/tech-shopify.png'],
        ['name' => 'React', 'logo' => get_template_directory_uri() . '/assets/images/tech-react.png'],
        ['name' => 'PHP', 'logo' => get_template_directory_uri() . '/assets/images/tech-php.png'],
        ['name' => 'JavaScript', 'logo' => get_template_directory_uri() . '/assets/images/tech-js.png'],
        ['name' => 'Google Ads', 'logo' => get_template_directory_uri() . '/assets/images/tech-google.png'],
        ['name' => 'Facebook', 'logo' => get_template_directory_uri() . '/assets/images/tech-facebook.png'],
        ['name' => 'AWS', 'logo' => get_template_directory_uri() . '/assets/images/tech-aws.png']
    ];
}

/**
 * Custom excerpt length
 */
function greentech_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'greentech_excerpt_length');

/**
 * Custom excerpt more
 */
function greentech_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'greentech_excerpt_more');

/**
 * Custom post navigation
 */
function greentech_post_navigation() {
    the_posts_navigation([
        'prev_text' => __('← Older posts', 'greentech'),
        'next_text' => __('Newer posts →', 'greentech'),
    ]);
}

/**
 * Custom comment form
 */
function greentech_comment_form() {
    $args = [
        'class_submit' => 'btn btn-primary',
        'label_submit' => __('Post Comment', 'greentech'),
    ];
    
    comment_form($args);
}

/**
 * Body classes
 */
function greentech_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    
    if (is_page_template('page-services.php')) {
        $classes[] = 'services-page';
    }
    
    if (is_page_template('page-portfolio.php')) {
        $classes[] = 'portfolio-page';
    }
    
    if (is_page_template('page-contact.php')) {
        $classes[] = 'contact-page';
    }
    
    return $classes;
}
add_filter('body_class', 'greentech_body_classes');

/**
 * Pagination
 */
function greentech_pagination() {
    global $wp_query;
    
    $big = 999999999;
    
    echo paginate_links([
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => __('← Previous', 'greentech'),
        'next_text' => __('Next →', 'greentech'),
    ]);
}

/**
 * Load theme text domain
 */
function greentech_load_textdomain() {
    load_theme_textdomain('greentech', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'greentech_load_textdomain');

/**
 * Add async/defer to scripts
 */
function greentech_add_async_defer($tag, $handle, $src) {
    $async_scripts = ['greentech-main'];
    
    if (in_array($handle, $async_scripts)) {
        return '<script src="' . $src . '" async defer></script>' . "\n";
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'greentech_add_async_defer', 10, 3);