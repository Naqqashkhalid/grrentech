<?php
/**
 * Template Functions Class
 * 
 * Provides utility functions for template rendering and content management
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
 * Template Functions Class
 */
class Template_Functions {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('wp_head', [$this, 'add_meta_tags']);
        add_filter('the_content', [$this, 'add_lazy_loading']);
        add_action('wp_enqueue_scripts', [$this, 'add_inline_styles']);
    }
    
    /**
     * Add meta tags to head
     */
    public function add_meta_tags() {
        if (is_front_page()) {
            echo '<meta name="description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";
        } elseif (is_single() || is_page()) {
            $excerpt = get_the_excerpt();
            if ($excerpt) {
                echo '<meta name="description" content="' . esc_attr(wp_trim_words($excerpt, 30)) . '">' . "\n";
            }
        }
        
        // Open Graph tags
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        echo '<meta property="og:type" content="' . (is_single() ? 'article' : 'website') . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        
        if (has_post_thumbnail()) {
            $image = get_the_post_thumbnail_url(null, 'large');
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
        }
        
        // Twitter Card tags
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    }
    
    /**
     * Add lazy loading to images
     * 
     * @param string $content Post content
     * @return string Modified content
     */
    public function add_lazy_loading($content) {
        if (is_admin() || is_feed()) {
            return $content;
        }
        
        $content = preg_replace('/<img(.*?)src=/', '<img$1loading="lazy" src=', $content);
        return $content;
    }
    
    /**
     * Add inline styles
     */
    public function add_inline_styles() {
        $custom_css = '';
        
        // Dynamic colors from customizer
        $primary_color = get_theme_mod('primary_color', '#4CAF50');
        $secondary_color = get_theme_mod('secondary_color', '#1a1a1a');
        
        $custom_css .= "
            :root {
                --primary-color: {$primary_color};
                --secondary-color: {$secondary_color};
            }
        ";
        
        if ($custom_css) {
            wp_add_inline_style('greentech-style', $custom_css);
        }
    }
    
    /**
     * Render page title
     */
    public static function render_page_title() {
        if (is_front_page()) {
            return;
        }
        
        echo '<div class="page-header">';
        echo '<div class="container">';
        
        if (is_home()) {
            echo '<h1 class="page-title">' . __('Blog', 'greentech') . '</h1>';
        } elseif (is_archive()) {
            the_archive_title('<h1 class="page-title">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
        } elseif (is_search()) {
            echo '<h1 class="page-title">' . sprintf(__('Search Results for: %s', 'greentech'), get_search_query()) . '</h1>';
        } elseif (is_404()) {
            echo '<h1 class="page-title">' . __('Page Not Found', 'greentech') . '</h1>';
        } else {
            echo '<h1 class="page-title">' . get_the_title() . '</h1>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    /**
     * Render breadcrumbs
     */
    public static function render_breadcrumbs() {
        if (is_front_page()) {
            return;
        }
        
        $home_text = __('Home', 'greentech');
        $delimiter = ' / ';
        
        echo '<nav class="breadcrumbs" aria-label="' . __('Breadcrumb Navigation', 'greentech') . '">';
        echo '<div class="container">';
        echo '<ol class="breadcrumb-list">';
        echo '<li><a href="' . home_url() . '">' . $home_text . '</a></li>';
        
        if (is_category() || is_single()) {
            $category = get_the_category();
            if ($category) {
                echo '<li><a href="' . get_category_link($category[0]->cat_ID) . '">' . $category[0]->cat_name . '</a></li>';
            }
            if (is_single()) {
                echo '<li>' . get_the_title() . '</li>';
            }
        } elseif (is_page()) {
            if (wp_get_post_parent_id(get_the_ID())) {
                $parent_id = wp_get_post_parent_id(get_the_ID());
                $breadcrumbs = [];
                
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id = $page->post_parent;
                }
                
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo $crumb;
                }
            }
            echo '<li>' . get_the_title() . '</li>';
        } elseif (is_search()) {
            echo '<li>' . sprintf(__('Search Results for: %s', 'greentech'), get_search_query()) . '</li>';
        } elseif (is_404()) {
            echo '<li>' . __('404 - Page Not Found', 'greentech') . '</li>';
        }
        
        echo '</ol>';
        echo '</div>';
        echo '</nav>';
    }
    
    /**
     * Get excerpt with custom length
     * 
     * @param int $length Excerpt length
     * @param string $more More text
     * @return string Excerpt
     */
    public static function get_excerpt($length = 30, $more = '...') {
        $excerpt = get_the_excerpt();
        return wp_trim_words($excerpt, $length, $more);
    }
    
    /**
     * Get reading time estimate
     * 
     * @param int $post_id Post ID
     * @return string Reading time
     */
    public static function get_reading_time($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        $content = get_post_field('post_content', $post_id);
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
        
        return sprintf(_n('%d min read', '%d min read', $reading_time, 'greentech'), $reading_time);
    }
    
    /**
     * Render post meta
     * 
     * @param array $meta_items Meta items to display
     */
    public static function render_post_meta($meta_items = ['date', 'author', 'categories']) {
        if (empty($meta_items)) {
            return;
        }
        
        echo '<div class="entry-meta">';
        
        foreach ($meta_items as $item) {
            switch ($item) {
                case 'date':
                    echo '<span class="posted-on">';
                    echo '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>';
                    echo '</span>';
                    break;
                    
                case 'author':
                    echo '<span class="byline">';
                    echo '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>';
                    echo '</span>';
                    break;
                    
                case 'categories':
                    $categories_list = get_the_category_list(', ');
                    if ($categories_list) {
                        echo '<span class="cat-links">' . $categories_list . '</span>';
                    }
                    break;
                    
                case 'tags':
                    $tags_list = get_the_tag_list('', ', ');
                    if ($tags_list) {
                        echo '<span class="tags-links">' . $tags_list . '</span>';
                    }
                    break;
                    
                case 'comments':
                    if (comments_open() || get_comments_number()) {
                        echo '<span class="comments-link">';
                        comments_popup_link(__('Leave a comment', 'greentech'), __('1 Comment', 'greentech'), __('% Comments', 'greentech'));
                        echo '</span>';
                    }
                    break;
                    
                case 'reading-time':
                    echo '<span class="reading-time">' . self::get_reading_time() . '</span>';
                    break;
            }
        }
        
        echo '</div>';
    }
    
    /**
     * Render featured image with overlay
     * 
     * @param string $size Image size
     * @param bool $with_overlay Include overlay
     */
    public static function render_featured_image($size = 'large', $with_overlay = false) {
        if (!has_post_thumbnail()) {
            return;
        }
        
        echo '<div class="featured-image' . ($with_overlay ? ' with-overlay' : '') . '">';
        
        if (is_singular()) {
            the_post_thumbnail($size);
        } else {
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail($size);
            echo '</a>';
        }
        
        if ($with_overlay) {
            echo '<div class="image-overlay">';
            echo '<div class="overlay-content">';
            echo '<h3><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h3>';
            echo '<p>' . self::get_excerpt(15) . '</p>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
    }
    
    /**
     * Render CTA section
     * 
     * @param string $title CTA title
     * @param string $description CTA description
     * @param string $button_text Button text
     * @param string $button_url Button URL
     * @param string $bg_class Background class
     */
    public static function render_cta_section($title = '', $description = '', $button_text = '', $button_url = '', $bg_class = 'bg-primary') {
        $title = $title ?: __('Ready to Start Your Project?', 'greentech');
        $description = $description ?: __('Contact us today to discuss your web development, hosting, or digital marketing needs.', 'greentech');
        $button_text = $button_text ?: __('Get Started', 'greentech');
        $button_url = $button_url ?: '#contact';
        
        echo '<section class="cta-section ' . esc_attr($bg_class) . '">';
        echo '<div class="container">';
        echo '<div class="cta-content text-center">';
        echo '<h2 class="cta-title">' . esc_html($title) . '</h2>';
        echo '<p class="cta-description">' . esc_html($description) . '</p>';
        echo '<a href="' . esc_url($button_url) . '" class="btn btn-lg btn-outline">' . esc_html($button_text) . '</a>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
    
    /**
     * Render contact information
     */
    public static function render_contact_info() {
        $contact = \GreenTech\greentech_get_contact_info();
        
        echo '<div class="contact-info">';
        
        if ($contact['address']) {
            echo '<div class="contact-item">';
            echo '<span class="contact-icon">📍</span>';
            echo '<div class="contact-details">';
            echo '<strong>' . __('Address', 'greentech') . '</strong>';
            echo '<p>' . esc_html($contact['address']) . '</p>';
            echo '</div>';
            echo '</div>';
        }
        
        if ($contact['phone']) {
            echo '<div class="contact-item">';
            echo '<span class="contact-icon">📞</span>';
            echo '<div class="contact-details">';
            echo '<strong>' . __('Phone', 'greentech') . '</strong>';
            echo '<p><a href="tel:' . esc_attr($contact['phone']) . '">' . esc_html($contact['phone']) . '</a></p>';
            echo '</div>';
            echo '</div>';
        }
        
        if ($contact['email']) {
            echo '<div class="contact-item">';
            echo '<span class="contact-icon">✉️</span>';
            echo '<div class="contact-details">';
            echo '<strong>' . __('Email', 'greentech') . '</strong>';
            echo '<p><a href="mailto:' . esc_attr($contact['email']) . '">' . esc_html($contact['email']) . '</a></p>';
            echo '</div>';
            echo '</div>';
        }
        
        if ($contact['website']) {
            echo '<div class="contact-item">';
            echo '<span class="contact-icon">🌐</span>';
            echo '<div class="contact-details">';
            echo '<strong>' . __('Website', 'greentech') . '</strong>';
            echo '<p><a href="http://' . esc_attr($contact['website']) . '" target="_blank">' . esc_html($contact['website']) . '</a></p>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
    }
    
    /**
     * Check if page is using Elementor
     * 
     * @param int $post_id Post ID
     * @return bool
     */
    public static function is_elementor_page($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        return class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get($post_id)->is_built_with_elementor();
    }
    
    /**
     * Get theme color palette
     * 
     * @return array Color palette
     */
    public static function get_color_palette() {
        return [
            'primary' => get_theme_mod('primary_color', '#4CAF50'),
            'secondary' => get_theme_mod('secondary_color', '#1a1a1a'),
            'white' => '#ffffff',
            'light' => '#f8fafc',
            'dark' => '#1a1a1a',
            'muted' => '#6b7280'
        ];
    }
}