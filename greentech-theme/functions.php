<?php
/**
 * GreenTech Theme Functions
 * 
 * Main functions file that bootstraps the theme using OOP principles
 * and modern WordPress development practices.
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
        new Navigation();
        new Template_Functions();
        
        // Load optional classes based on conditions
        if (is_admin()) {
            new Admin();
        }
        
        // Load performance optimizations
        new Performance();
    }
    
    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        add_action('after_setup_theme', [$this, 'setup']);
        add_action('init', [$this, 'init']);
        add_filter('body_class', [$this, 'body_classes']);
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
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('custom-header');
        add_theme_support('custom-background');
        add_theme_support('custom-logo', [
            'height' => 100,
            'width' => 400,
            'flex-height' => true,
            'flex-width' => true,
        ]);
        
        // Add WooCommerce support
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        
        // Set content width
        if (!isset($content_width)) {
            $content_width = 1200;
        }
        
        // Register image sizes
        add_image_size('greentech-hero', 1920, 800, true);
        add_image_size('greentech-portfolio', 400, 300, true);
        add_image_size('greentech-service', 300, 200, true);
        add_image_size('greentech-testimonial', 100, 100, true);
        add_image_size('greentech-blog', 600, 400, true);
    }
    
    /**
     * Initialize theme components
     */
    public function init() {
        // Register custom post types if needed
        $this->register_post_types();
        
        // Register custom taxonomies if needed
        $this->register_taxonomies();
    }
    
    /**
     * Add custom body classes
     * 
     * @param array $classes Existing body classes
     * @return array Modified body classes
     */
    public function body_classes($classes) {
        // Add page-specific classes
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
        
        // Add browser-specific classes
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            $classes[] = 'threaded-comments';
        }
        
        return $classes;
    }
    
    /**
     * Register custom post types
     */
    private function register_post_types() {
        // Portfolio post type
        register_post_type('portfolio', [
            'labels' => [
                'name' => __('Portfolio', 'greentech'),
                'singular_name' => __('Portfolio Item', 'greentech'),
                'add_new' => __('Add New', 'greentech'),
                'add_new_item' => __('Add New Portfolio Item', 'greentech'),
                'edit_item' => __('Edit Portfolio Item', 'greentech'),
                'new_item' => __('New Portfolio Item', 'greentech'),
                'view_item' => __('View Portfolio Item', 'greentech'),
                'search_items' => __('Search Portfolio', 'greentech'),
                'not_found' => __('No portfolio items found', 'greentech'),
                'not_found_in_trash' => __('No portfolio items found in trash', 'greentech'),
            ],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'portfolio'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
            'show_in_rest' => true,
        ]);
        
        // Services post type
        register_post_type('service', [
            'labels' => [
                'name' => __('Services', 'greentech'),
                'singular_name' => __('Service', 'greentech'),
                'add_new' => __('Add New', 'greentech'),
                'add_new_item' => __('Add New Service', 'greentech'),
                'edit_item' => __('Edit Service', 'greentech'),
                'new_item' => __('New Service', 'greentech'),
                'view_item' => __('View Service', 'greentech'),
                'search_items' => __('Search Services', 'greentech'),
                'not_found' => __('No services found', 'greentech'),
                'not_found_in_trash' => __('No services found in trash', 'greentech'),
            ],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'services'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-admin-tools',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
            'show_in_rest' => true,
        ]);
    }
    
    /**
     * Register custom taxonomies
     */
    private function register_taxonomies() {
        // Portfolio categories
        register_taxonomy('portfolio_category', 'portfolio', [
            'hierarchical' => true,
            'labels' => [
                'name' => __('Portfolio Categories', 'greentech'),
                'singular_name' => __('Portfolio Category', 'greentech'),
                'search_items' => __('Search Portfolio Categories', 'greentech'),
                'all_items' => __('All Portfolio Categories', 'greentech'),
                'parent_item' => __('Parent Portfolio Category', 'greentech'),
                'parent_item_colon' => __('Parent Portfolio Category:', 'greentech'),
                'edit_item' => __('Edit Portfolio Category', 'greentech'),
                'update_item' => __('Update Portfolio Category', 'greentech'),
                'add_new_item' => __('Add New Portfolio Category', 'greentech'),
                'new_item_name' => __('New Portfolio Category Name', 'greentech'),
                'menu_name' => __('Categories', 'greentech'),
            ],
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'portfolio-category'],
            'show_in_rest' => true,
        ]);
        
        // Service categories
        register_taxonomy('service_category', 'service', [
            'hierarchical' => true,
            'labels' => [
                'name' => __('Service Categories', 'greentech'),
                'singular_name' => __('Service Category', 'greentech'),
                'search_items' => __('Search Service Categories', 'greentech'),
                'all_items' => __('All Service Categories', 'greentech'),
                'parent_item' => __('Parent Service Category', 'greentech'),
                'parent_item_colon' => __('Parent Service Category:', 'greentech'),
                'edit_item' => __('Edit Service Category', 'greentech'),
                'update_item' => __('Update Service Category', 'greentech'),
                'add_new_item' => __('Add New Service Category', 'greentech'),
                'new_item_name' => __('New Service Category Name', 'greentech'),
                'menu_name' => __('Categories', 'greentech'),
            ],
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'service-category'],
            'show_in_rest' => true,
        ]);
    }
}

// Initialize the theme
new Theme();

/**
 * Helper function to get theme instance
 * 
 * @return Theme
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
 * Get services data
 * 
 * @return array Services data
 */
function greentech_get_services() {
    return [
        [
            'title' => __('Web & App Development', 'greentech'),
            'description' => __('Custom web applications, WordPress sites, mobile apps, ERP systems, and hosting solutions.', 'greentech'),
            'icon' => '💻',
            'services' => [
                __('Web Development', 'greentech'),
                __('WordPress Development', 'greentech'),
                __('Mobile App Development', 'greentech'),
                __('ERP Systems', 'greentech'),
                __('Hosting & Cloud Service', 'greentech'),
                __('Plugin & App Development', 'greentech')
            ],
            'category' => 'web-development'
        ],
        [
            'title' => __('E-Commerce Development', 'greentech'),
            'description' => __('Complete e-commerce solutions on major platforms with payment integration and optimization.', 'greentech'),
            'icon' => '🛒',
            'services' => [
                __('Shopify Development', 'greentech'),
                __('Shopify Plus', 'greentech'),
                __('Magento Development', 'greentech'),
                __('BigCommerce', 'greentech'),
                __('WooCommerce', 'greentech')
            ],
            'category' => 'e-commerce'
        ],
        [
            'title' => __('Graphic Designing', 'greentech'),
            'description' => __('Professional design services for branding, print, digital, and user experience.', 'greentech'),
            'icon' => '🎨',
            'services' => [
                __('Logo & Branding', 'greentech'),
                __('Print Design', 'greentech'),
                __('Product & Merchandise', 'greentech'),
                __('Banners & Advertisement', 'greentech'),
                __('UI/UX Design', 'greentech')
            ],
            'category' => 'design'
        ],
        [
            'title' => __('Digital Marketing', 'greentech'),
            'description' => __('Comprehensive digital marketing strategies to grow your online presence and conversions.', 'greentech'),
            'icon' => '📈',
            'services' => [
                __('Performance Marketing', 'greentech'),
                __('TikTok Marketing', 'greentech'),
                __('SEO Services', 'greentech'),
                __('Influencer Marketing', 'greentech'),
                __('Social Media Marketing', 'greentech'),
                __('Email Marketing', 'greentech'),
                __('Conversion Rate Optimization', 'greentech')
            ],
            'category' => 'marketing'
        ]
    ];
}

/**
 * Get portfolio items
 * 
 * @return array Portfolio data
 */
function greentech_get_portfolio() {
    // First try to get from custom post type
    $portfolio_posts = get_posts([
        'post_type' => 'portfolio',
        'posts_per_page' => 12,
        'post_status' => 'publish'
    ]);
    
    if (!empty($portfolio_posts)) {
        $portfolio = [];
        foreach ($portfolio_posts as $post) {
            $categories = get_the_terms($post->ID, 'portfolio_category');
            $category_slug = !empty($categories) ? $categories[0]->slug : 'general';
            
            $portfolio[] = [
                'title' => $post->post_title,
                'description' => $post->post_excerpt ?: wp_trim_words($post->post_content, 20),
                'image' => get_the_post_thumbnail_url($post->ID, 'greentech-portfolio') ?: (GREENTECH_ASSETS_URI . '/images/portfolio-placeholder.jpg'),
                'category' => $category_slug,
                'tags' => wp_get_post_terms($post->ID, 'portfolio_category', ['fields' => 'names']),
                'url' => get_permalink($post->ID)
            ];
        }
        return $portfolio;
    }
    
    // Fallback to static data
    return [
        [
            'title' => __('E-Commerce Platform', 'greentech'),
            'description' => __('Modern Shopify store with custom features and enhanced user experience.', 'greentech'),
            'image' => GREENTECH_ASSETS_URI . '/images/portfolio-1.jpg',
            'category' => 'e-commerce',
            'tags' => ['Shopify', 'E-Commerce', 'Custom Development'],
            'url' => '#'
        ],
        [
            'title' => __('Corporate Website', 'greentech'),
            'description' => __('Professional WordPress site for law firm with custom functionality.', 'greentech'),
            'image' => GREENTECH_ASSETS_URI . '/images/portfolio-2.jpg',
            'category' => 'web-development',
            'tags' => ['WordPress', 'Corporate', 'Responsive'],
            'url' => '#'
        ],
        [
            'title' => __('Mobile App', 'greentech'),
            'description' => __('Cross-platform mobile app for food delivery service.', 'greentech'),
            'image' => GREENTECH_ASSETS_URI . '/images/portfolio-3.jpg',
            'category' => 'mobile-app',
            'tags' => ['React Native', 'Mobile', 'Food Delivery'],
            'url' => '#'
        ],
        [
            'title' => __('Brand Identity', 'greentech'),
            'description' => __('Complete branding package for tech startup including logo and guidelines.', 'greentech'),
            'image' => GREENTECH_ASSETS_URI . '/images/portfolio-4.jpg',
            'category' => 'design',
            'tags' => ['Branding', 'Logo Design', 'Identity'],
            'url' => '#'
        ],
        [
            'title' => __('SEO Campaign', 'greentech'),
            'description' => __('Comprehensive SEO strategy that increased organic traffic by 300%.', 'greentech'),
            'image' => GREENTECH_ASSETS_URI . '/images/portfolio-5.jpg',
            'category' => 'marketing',
            'tags' => ['SEO', 'Digital Marketing', 'Analytics'],
            'url' => '#'
        ],
        [
            'title' => __('SaaS Dashboard', 'greentech'),
            'description' => __('Modern dashboard design for project management software.', 'greentech'),
            'image' => GREENTECH_ASSETS_URI . '/images/portfolio-6.jpg',
            'category' => 'web-development',
            'tags' => ['SaaS', 'Dashboard', 'UI/UX'],
            'url' => '#'
        ]
    ];
}

/**
 * Get testimonials data
 * 
 * @return array Testimonials data
 */
function greentech_get_testimonials() {
    return [
        [
            'content' => __('GreenTech delivered an outstanding e-commerce platform that exceeded our expectations. Their attention to detail and technical expertise is remarkable.', 'greentech'),
            'author' => 'Sarah Johnson',
            'position' => __('CEO, Fashion Forward', 'greentech'),
            'avatar' => GREENTECH_ASSETS_URI . '/images/testimonial-1.jpg',
            'rating' => 5
        ],
        [
            'content' => __('The team at GreenTech transformed our online presence completely. Our website traffic increased by 300% within the first month.', 'greentech'),
            'author' => 'Mike Chen',
            'position' => __('Marketing Director, Tech Solutions', 'greentech'),
            'avatar' => GREENTECH_ASSETS_URI . '/images/testimonial-2.jpg',
            'rating' => 5
        ],
        [
            'content' => __('Professional, reliable, and innovative. GreenTech has been our go-to partner for all digital marketing needs.', 'greentech'),
            'author' => 'Emily Rodriguez',
            'position' => __('Founder, Local Business Hub', 'greentech'),
            'avatar' => GREENTECH_ASSETS_URI . '/images/testimonial-3.jpg',
            'rating' => 5
        ]
    ];
}

/**
 * Get technology logos data
 * 
 * @return array Technology logos data
 */
function greentech_get_technologies() {
    return [
        ['name' => 'WordPress', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-wordpress.png'],
        ['name' => 'Shopify', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-shopify.png'],
        ['name' => 'React', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-react.png'],
        ['name' => 'PHP', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-php.png'],
        ['name' => 'JavaScript', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-js.png'],
        ['name' => 'Google Ads', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-google.png'],
        ['name' => 'Facebook', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-facebook.png'],
        ['name' => 'AWS', 'logo' => GREENTECH_ASSETS_URI . '/images/tech-aws.png']
    ];
}

/**
 * Get contact information
 * 
 * @return array Contact data
 */
function greentech_get_contact_info() {
    return [
        'address' => get_theme_mod('contact_address', 'Office# 11, 1st Floor Soldier Arcade, Al-Markaz Road, Jhelum'),
        'phone' => get_theme_mod('contact_phone', '0544-277588'),
        'email' => get_theme_mod('contact_email', 'inquiry@greentech.guru'),
        'website' => get_theme_mod('contact_website', 'www.greentech.guru')
    ];
}

/**
 * Custom excerpt length
 * 
 * @param int $length Excerpt length
 * @return int Modified excerpt length
 */
function greentech_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', __NAMESPACE__ . '\\greentech_excerpt_length');

/**
 * Custom excerpt more
 * 
 * @param string $more Excerpt more string
 * @return string Modified excerpt more
 */
function greentech_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\greentech_excerpt_more');

/**
 * Pagination function
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
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    ]);
}

/**
 * Social share buttons
 * 
 * @param int $post_id Post ID
 */
function greentech_social_share($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post_url = get_permalink($post_id);
    $post_title = get_the_title($post_id);
    
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url);
    $twitter_url = 'https://twitter.com/intent/tweet?url=' . urlencode($post_url) . '&text=' . urlencode($post_title);
    $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($post_url);
    
    echo '<div class="social-share">';
    echo '<h4>' . __('Share this post:', 'greentech') . '</h4>';
    echo '<div class="social-share-links">';
    echo '<a href="' . $facebook_url . '" target="_blank" class="social-share-link facebook">Facebook</a>';
    echo '<a href="' . $twitter_url . '" target="_blank" class="social-share-link twitter">Twitter</a>';
    echo '<a href="' . $linkedin_url . '" target="_blank" class="social-share-link linkedin">LinkedIn</a>';
    echo '</div>';
    echo '</div>';
}

/**
 * Related posts function
 * 
 * @param int $post_id Post ID
 * @param int $posts_per_page Number of posts to show
 */
function greentech_related_posts($post_id = null, $posts_per_page = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = get_the_category($post_id);
    if (empty($categories)) {
        return;
    }
    
    $category_ids = array_map(function($cat) {
        return $cat->term_id;
    }, $categories);
    
    $related_posts = get_posts([
        'category__in' => $category_ids,
        'post__not_in' => [$post_id],
        'posts_per_page' => $posts_per_page,
        'orderby' => 'rand'
    ]);
    
    if (empty($related_posts)) {
        return;
    }
    
    echo '<div class="related-posts">';
    echo '<h3>' . __('Related Posts', 'greentech') . '</h3>';
    echo '<div class="related-posts-grid">';
    
    foreach ($related_posts as $post) {
        setup_postdata($post);
        echo '<article class="related-post card">';
        if (has_post_thumbnail($post->ID)) {
            echo '<div class="related-post-image">';
            echo '<a href="' . get_permalink($post->ID) . '">';
            echo get_the_post_thumbnail($post->ID, 'greentech-blog');
            echo '</a>';
            echo '</div>';
        }
        echo '<div class="related-post-content">';
        echo '<h4><a href="' . get_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a></h4>';
        echo '<p>' . wp_trim_words(get_the_excerpt($post->ID), 15) . '</p>';
        echo '<a href="' . get_permalink($post->ID) . '" class="btn btn-outline btn-sm">' . __('Read More', 'greentech') . '</a>';
        echo '</div>';
        echo '</article>';
    }
    
    echo '</div>';
    echo '</div>';
    
    wp_reset_postdata();
}

/**
 * Schema markup for organization
 */
function greentech_schema_organization() {
    $contact = greentech_get_contact_info();
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url(),
        'logo' => get_theme_mod('custom_logo') ? wp_get_attachment_url(get_theme_mod('custom_logo')) : null,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $contact['address'],
            'addressLocality' => 'Jhelum',
            'addressCountry' => 'PK'
        ],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => $contact['phone'],
            'contactType' => 'customer support',
            'email' => $contact['email']
        ],
        'sameAs' => [
            'https://www.facebook.com/greentech',
            'https://www.twitter.com/greentech',
            'https://www.linkedin.com/company/greentech'
        ]
    ];
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Schema markup for articles
 */
function greentech_schema_article() {
    if (!is_single()) {
        return;
    }
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'description' => get_the_excerpt(),
        'author' => [
            '@type' => 'Person',
            'name' => get_the_author()
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => get_theme_mod('custom_logo') ? wp_get_attachment_url(get_theme_mod('custom_logo')) : null
            ]
        ],
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'mainEntityOfPage' => get_permalink()
    ];
    
    if (has_post_thumbnail()) {
        $schema['image'] = get_the_post_thumbnail_url(null, 'full');
    }
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
}

// Add schema markup to appropriate pages
add_action('wp_head', __NAMESPACE__ . '\\greentech_schema_organization');
add_action('wp_head', __NAMESPACE__ . '\\greentech_schema_article');