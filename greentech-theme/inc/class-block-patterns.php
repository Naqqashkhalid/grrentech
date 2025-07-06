<?php
/**
 * Block Patterns Class
 * 
 * Registers custom block patterns for easy page building.
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
 * Block Patterns Class
 */
class Block_Patterns {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', [$this, 'register_pattern_categories']);
        add_action('init', [$this, 'register_block_patterns']);
    }
    
    /**
     * Register pattern categories
     */
    public function register_pattern_categories() {
        register_block_pattern_category('greentech-hero', [
            'label' => __('GreenTech Heroes', 'greentech'),
        ]);
        
        register_block_pattern_category('greentech-services', [
            'label' => __('GreenTech Services', 'greentech'),
        ]);
        
        register_block_pattern_category('greentech-testimonials', [
            'label' => __('GreenTech Testimonials', 'greentech'),
        ]);
        
        register_block_pattern_category('greentech-cta', [
            'label' => __('GreenTech Call to Action', 'greentech'),
        ]);
        
        register_block_pattern_category('greentech-about', [
            'label' => __('GreenTech About', 'greentech'),
        ]);
        
        register_block_pattern_category('greentech-portfolio', [
            'label' => __('GreenTech Portfolio', 'greentech'),
        ]);
    }
    
    /**
     * Register block patterns
     */
    public function register_block_patterns() {
        // Hero section pattern
        register_block_pattern('greentech/hero-section', [
            'title'       => __('Hero Section', 'greentech'),
            'description' => __('A hero section with title, subtitle, and call-to-action buttons.', 'greentech'),
            'content'     => $this->get_hero_pattern(),
            'categories'  => ['greentech-hero'],
            'keywords'    => ['hero', 'banner', 'header'],
        ]);
        
        // Services grid pattern
        register_block_pattern('greentech/services-grid', [
            'title'       => __('Services Grid', 'greentech'),
            'description' => __('A 4-column grid showcasing services with icons and descriptions.', 'greentech'),
            'content'     => $this->get_services_pattern(),
            'categories'  => ['greentech-services'],
            'keywords'    => ['services', 'grid', 'features'],
        ]);
        
        // Testimonials pattern
        register_block_pattern('greentech/testimonials', [
            'title'       => __('Testimonials Section', 'greentech'),
            'description' => __('Customer testimonials with quotes and author information.', 'greentech'),
            'content'     => $this->get_testimonials_pattern(),
            'categories'  => ['greentech-testimonials'],
            'keywords'    => ['testimonials', 'reviews', 'quotes'],
        ]);
        
        // Call to action pattern
        register_block_pattern('greentech/cta-section', [
            'title'       => __('Call to Action', 'greentech'),
            'description' => __('A prominent call-to-action section with gradient background.', 'greentech'),
            'content'     => $this->get_cta_pattern(),
            'categories'  => ['greentech-cta'],
            'keywords'    => ['cta', 'call-to-action', 'contact'],
        ]);
        
        // About section pattern
        register_block_pattern('greentech/about-section', [
            'title'       => __('About Section', 'greentech'),
            'description' => __('About section with image and content side by side.', 'greentech'),
            'content'     => $this->get_about_pattern(),
            'categories'  => ['greentech-about'],
            'keywords'    => ['about', 'team', 'company'],
        ]);
        
        // Portfolio grid pattern
        register_block_pattern('greentech/portfolio-grid', [
            'title'       => __('Portfolio Grid', 'greentech'),
            'description' => __('A responsive grid layout for showcasing portfolio items.', 'greentech'),
            'content'     => $this->get_portfolio_pattern(),
            'categories'  => ['greentech-portfolio'],
            'keywords'    => ['portfolio', 'work', 'projects'],
        ]);
        
        // Team section pattern
        register_block_pattern('greentech/team-section', [
            'title'       => __('Team Section', 'greentech'),
            'description' => __('Team member showcase with photos and descriptions.', 'greentech'),
            'content'     => $this->get_team_pattern(),
            'categories'  => ['greentech-about'],
            'keywords'    => ['team', 'staff', 'people'],
        ]);
        
        // FAQ pattern
        register_block_pattern('greentech/faq-section', [
            'title'       => __('FAQ Section', 'greentech'),
            'description' => __('Frequently asked questions with expandable answers.', 'greentech'),
            'content'     => $this->get_faq_pattern(),
            'categories'  => ['greentech-about'],
            'keywords'    => ['faq', 'questions', 'help'],
        ]);
    }
    
    /**
     * Get hero pattern content
     */
    private function get_hero_pattern() {
        return '<!-- wp:group {"className":"is-style-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-hero"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-text-align-center has-huge-font-size">' . __('Professional Web Development &amp; Digital Marketing Services', 'greentech') . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">' . __('Transform your business with our comprehensive web development, hosting, and digital marketing solutions. We help businesses grow online.', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","textColor":"background","className":"is-style-fill"} -->
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-background-color has-primary-background-color wp-element-button">' . __('Get Started Today', 'greentech') . '</a></div>
<!-- /wp:button -->

<!-- wp:button {"textColor":"primary","className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-primary-color wp-element-button">' . __('View Our Work', 'greentech') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->';
    }
    
    /**
     * Get services pattern content
     */
    private function get_services_pattern() {
        return '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">' . __('Our Services', 'greentech') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Comprehensive solutions for your digital needs', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"is-style-service-grid"} -->
<div class="wp-block-columns is-style-service-grid"><!-- wp:column {"className":"is-style-card"} -->
<div class="wp-block-column is-style-card"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">💻 ' . __('Web Development', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Custom web applications, WordPress sites, and modern responsive designs that convert visitors into customers.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"is-style-card"} -->
<div class="wp-block-column is-style-card"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">🛒 ' . __('E-Commerce', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Complete e-commerce solutions on Shopify, WooCommerce, and other platforms with payment integration.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"is-style-card"} -->
<div class="wp-block-column is-style-card"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">🎨 ' . __('Design Services', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Professional design services including branding, UI/UX design, and print materials that make an impact.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"is-style-card"} -->
<div class="wp-block-column is-style-card"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">📈 ' . __('Digital Marketing', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('SEO, social media marketing, and performance advertising to grow your online presence and revenue.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->';
    }
    
    /**
     * Get testimonials pattern content
     */
    private function get_testimonials_pattern() {
        return '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">' . __('What Our Clients Say', 'greentech') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Don\'t just take our word for it - see what our clients have to say', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-testimonial"} -->
<div class="wp-block-group is-style-testimonial"><!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>' . __('GreenTech delivered an outstanding e-commerce platform that exceeded our expectations. Their attention to detail and technical expertise is remarkable.', 'greentech') . '</p>
<!-- /wp:paragraph --><cite><strong>Sarah Johnson</strong><br>' . __('CEO, Fashion Forward', 'greentech') . '</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-testimonial"} -->
<div class="wp-block-group is-style-testimonial"><!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>' . __('The team transformed our online presence completely. Our website traffic increased by 300% within the first month.', 'greentech') . '</p>
<!-- /wp:paragraph --><cite><strong>Mike Chen</strong><br>' . __('Marketing Director, Tech Solutions', 'greentech') . '</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-testimonial"} -->
<div class="wp-block-group is-style-testimonial"><!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>' . __('Professional, reliable, and innovative. GreenTech has been our go-to partner for all digital needs.', 'greentech') . '</p>
<!-- /wp:paragraph --><cite><strong>Lisa Rodriguez</strong><br>' . __('Founder, StartupHub', 'greentech') . '</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->';
    }
    
    /**
     * Get CTA pattern content
     */
    private function get_cta_pattern() {
        return '<!-- wp:group {"className":"is-style-cta","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-cta"><!-- wp:heading {"textAlign":"center","level":2,"textColor":"background"} -->
<h2 class="wp-block-heading has-text-align-center has-background-color">' . __('Ready to Get Started?', 'greentech') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"background","fontSize":"large"} -->
<p class="has-text-align-center has-background-color has-large-font-size">' . __('Contact us today to discuss your project requirements and get a free consultation.', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"background","textColor":"primary","className":"is-style-fill"} -->
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-primary-color has-background-background-color wp-element-button">' . __('Contact Us', 'greentech') . '</a></div>
<!-- /wp:button -->

<!-- wp:button {"textColor":"background","className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-background-color wp-element-button">' . __('View Portfolio', 'greentech') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->';
    }
    
    /**
     * Get about pattern content
     */
    private function get_about_pattern() {
        return '<!-- wp:media-text {"mediaPosition":"right","mediaId":1,"mediaType":"image","className":"is-style-bordered"} -->
<div class="wp-block-media-text has-media-on-the-right is-stacked-on-mobile is-style-bordered"><div class="wp-block-media-text__content"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">' . __('About GreenTech', 'greentech') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('We are a team of passionate developers, designers, and digital marketers dedicated to helping businesses succeed online. With years of experience and a commitment to excellence, we deliver solutions that drive real results.', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-checkmark"} -->
<ul class="wp-block-list is-style-checkmark"><!-- wp:list-item -->
<li>' . __('Expert team with 10+ years experience', 'greentech') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('100+ successful projects delivered', 'greentech') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('24/7 support and maintenance', 'greentech') . '</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>' . __('Cutting-edge technology solutions', 'greentech') . '</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:button {"backgroundColor":"primary","textColor":"background"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-primary-background-color wp-element-button">' . __('Learn More', 'greentech') . '</a></div>
<!-- /wp:button --></div><figure class="wp-block-media-text__media"><img src="' . esc_url(GREENTECH_ASSETS_URI . '/images/about-placeholder.jpg') . '" alt="' . __('About GreenTech', 'greentech') . '" class="wp-image-1 size-full"/></figure></div>
<!-- /wp:media-text -->';
    }
    
    /**
     * Get portfolio pattern content
     */
    private function get_portfolio_pattern() {
        return '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">' . __('Our Latest Work', 'greentech') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Check out some of our recent projects and success stories', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"className":"is-style-rounded"} -->
<figure class="wp-block-image is-style-rounded"><img src="' . esc_url(GREENTECH_ASSETS_URI . '/images/portfolio-1.jpg') . '" alt="' . __('E-Commerce Platform', 'greentech') . '"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . __('E-Commerce Platform', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Modern Shopify store with custom features and enhanced user experience for a fashion retailer.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"className":"is-style-rounded"} -->
<figure class="wp-block-image is-style-rounded"><img src="' . esc_url(GREENTECH_ASSETS_URI . '/images/portfolio-2.jpg') . '" alt="' . __('Corporate Website', 'greentech') . '"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . __('Corporate Website', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Professional WordPress site for a law firm with custom functionality and modern design.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"className":"is-style-rounded"} -->
<figure class="wp-block-image is-style-rounded"><img src="' . esc_url(GREENTECH_ASSETS_URI . '/images/portfolio-3.jpg') . '" alt="' . __('Mobile App', 'greentech') . '"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . __('Mobile App', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Cross-platform mobile app for food delivery service with real-time tracking features.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->';
    }
    
    /**
     * Get team pattern content
     */
    private function get_team_pattern() {
        return '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">' . __('Meet Our Team', 'greentech') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('The talented people behind our success', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"align":"center","className":"is-style-rounded"} -->
<figure class="wp-block-image aligncenter is-style-rounded"><img src="' . esc_url(GREENTECH_ASSETS_URI . '/images/team-1.jpg') . '" alt="' . __('John Doe', 'greentech') . '"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">' . __('John Doe', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"tertiary"} -->
<p class="has-text-align-center has-tertiary-color">' . __('Lead Developer', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Expert in modern web technologies with 8+ years of experience in full-stack development.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"align":"center","className":"is-style-rounded"} -->
<figure class="wp-block-image aligncenter is-style-rounded"><img src="' . esc_url(GREENTECH_ASSETS_URI . '/images/team-2.jpg') . '" alt="' . __('Jane Smith', 'greentech') . '"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">' . __('Jane Smith', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"tertiary"} -->
<p class="has-text-align-center has-tertiary-color">' . __('Creative Director', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Award-winning designer specializing in user experience and brand identity design.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"align":"center","className":"is-style-rounded"} -->
<figure class="wp-block-image aligncenter is-style-rounded"><img src="' . esc_url(GREENTECH_ASSETS_URI . '/images/team-3.jpg') . '" alt="' . __('Mike Johnson', 'greentech') . '"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">' . __('Mike Johnson', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"tertiary"} -->
<p class="has-text-align-center has-tertiary-color">' . __('Marketing Strategist', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Digital marketing expert with proven track record of growing businesses online.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->';
    }
    
    /**
     * Get FAQ pattern content
     */
    private function get_faq_pattern() {
        return '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">' . __('Frequently Asked Questions', 'greentech') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . __('Find answers to common questions about our services', 'greentech') . '</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . __('How long does a typical project take?', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Project timelines vary depending on complexity, but most websites take 4-8 weeks from start to finish. We provide detailed timelines during the planning phase.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . __('Do you provide ongoing support?', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Yes, we offer comprehensive support and maintenance packages to keep your website secure, updated, and performing optimally.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . __('What technologies do you use?', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('We use modern technologies including WordPress, React, PHP, and various e-commerce platforms like Shopify and WooCommerce.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card"} -->
<div class="wp-block-group is-style-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . __('Can you help with SEO?', 'greentech') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . __('Absolutely! We offer comprehensive SEO services including on-page optimization, content strategy, and performance marketing.', 'greentech') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->';
    }
}