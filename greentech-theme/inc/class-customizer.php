<?php
/**
 * Customizer Class
 * 
 * Handles WordPress Customizer integration and theme options
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
 * Customizer Class
 */
class Customizer {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('customize_register', [$this, 'register_customizer']);
        add_action('customize_preview_init', [$this, 'customize_preview_js']);
        add_action('wp_head', [$this, 'customize_css']);
    }
    
    /**
     * Register customizer options
     * 
     * @param WP_Customize_Manager $wp_customize Customizer manager instance
     */
    public function register_customizer($wp_customize) {
        
        // Remove default sections we don't need
        $wp_customize->remove_section('colors');
        
        // Add GreenTech panel
        $wp_customize->add_panel('greentech_panel', [
            'title' => __('GreenTech Options', 'greentech'),
            'description' => __('Customize your GreenTech theme settings', 'greentech'),
            'priority' => 30,
        ]);
        
        // Colors
        $this->add_colors_section($wp_customize);
        
        // Typography
        $this->add_typography_section($wp_customize);
        
        // Header
        $this->add_header_section($wp_customize);
        
        // Hero Section
        $this->add_hero_section($wp_customize);
        
        // Contact Information
        $this->add_contact_section($wp_customize);
        
        // Social Media
        $this->add_social_section($wp_customize);
        
        // Footer
        $this->add_footer_section($wp_customize);
        
        // Blog Settings
        $this->add_blog_section($wp_customize);
    }
    
    /**
     * Add colors section
     */
    private function add_colors_section($wp_customize) {
        $wp_customize->add_section('greentech_colors', [
            'title' => __('Colors', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 10,
        ]);
        
        // Primary Color
        $wp_customize->add_setting('primary_color', [
            'default' => '#4CAF50',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'primary_color', [
            'label' => __('Primary Color', 'greentech'),
            'description' => __('Choose the main accent color for your site', 'greentech'),
            'section' => 'greentech_colors',
        ]));
        
        // Secondary Color
        $wp_customize->add_setting('secondary_color', [
            'default' => '#1a1a1a',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'secondary_color', [
            'label' => __('Secondary Color', 'greentech'),
            'description' => __('Choose the secondary color for text and backgrounds', 'greentech'),
            'section' => 'greentech_colors',
        ]));
    }
    
    /**
     * Add typography section
     */
    private function add_typography_section($wp_customize) {
        $wp_customize->add_section('greentech_typography', [
            'title' => __('Typography', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 20,
        ]);
        
        // Headings Font
        $wp_customize->add_setting('headings_font', [
            'default' => 'Inter',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('headings_font', [
            'label' => __('Headings Font', 'greentech'),
            'section' => 'greentech_typography',
            'type' => 'select',
            'choices' => [
                'Inter' => 'Inter',
                'Roboto' => 'Roboto',
                'Open Sans' => 'Open Sans',
                'Montserrat' => 'Montserrat',
                'Poppins' => 'Poppins',
            ],
        ]);
        
        // Body Font
        $wp_customize->add_setting('body_font', [
            'default' => 'Inter',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('body_font', [
            'label' => __('Body Font', 'greentech'),
            'section' => 'greentech_typography',
            'type' => 'select',
            'choices' => [
                'Inter' => 'Inter',
                'Roboto' => 'Roboto',
                'Open Sans' => 'Open Sans',
                'Source Sans Pro' => 'Source Sans Pro',
                'Lato' => 'Lato',
            ],
        ]);
    }
    
    /**
     * Add header section
     */
    private function add_header_section($wp_customize) {
        $wp_customize->add_section('greentech_header', [
            'title' => __('Header Settings', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 30,
        ]);
        
        // Header Style
        $wp_customize->add_setting('header_style', [
            'default' => 'transparent',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('header_style', [
            'label' => __('Header Style', 'greentech'),
            'section' => 'greentech_header',
            'type' => 'select',
            'choices' => [
                'transparent' => __('Transparent', 'greentech'),
                'solid' => __('Solid', 'greentech'),
                'boxed' => __('Boxed', 'greentech'),
            ],
        ]);
        
        // Sticky Header
        $wp_customize->add_setting('sticky_header', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('sticky_header', [
            'label' => __('Sticky Header', 'greentech'),
            'description' => __('Make header stick to top when scrolling', 'greentech'),
            'section' => 'greentech_header',
            'type' => 'checkbox',
        ]);
    }
    
    /**
     * Add hero section
     */
    private function add_hero_section($wp_customize) {
        $wp_customize->add_section('greentech_hero', [
            'title' => __('Hero Section', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 40,
        ]);
        
        // Hero Title
        $wp_customize->add_setting('hero_title', [
            'default' => __('Build Your Digital Future with GreenTech', 'greentech'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
        ]);
        
        $wp_customize->add_control('hero_title', [
            'label' => __('Hero Title', 'greentech'),
            'section' => 'greentech_hero',
            'type' => 'text',
        ]);
        
        // Hero Subtitle
        $wp_customize->add_setting('hero_subtitle', [
            'default' => __('Professional web development, hosting, and digital marketing services for modern businesses.', 'greentech'),
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'postMessage',
        ]);
        
        $wp_customize->add_control('hero_subtitle', [
            'label' => __('Hero Subtitle', 'greentech'),
            'section' => 'greentech_hero',
            'type' => 'textarea',
        ]);
        
        // Primary Button
        $wp_customize->add_setting('hero_button_text', [
            'default' => __('Get Started', 'greentech'),
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('hero_button_text', [
            'label' => __('Primary Button Text', 'greentech'),
            'section' => 'greentech_hero',
            'type' => 'text',
        ]);
        
        $wp_customize->add_setting('hero_button_url', [
            'default' => '#contact',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control('hero_button_url', [
            'label' => __('Primary Button URL', 'greentech'),
            'section' => 'greentech_hero',
            'type' => 'url',
        ]);
        
        // Secondary Button
        $wp_customize->add_setting('hero_button_2_text', [
            'default' => __('Our Services', 'greentech'),
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('hero_button_2_text', [
            'label' => __('Secondary Button Text', 'greentech'),
            'section' => 'greentech_hero',
            'type' => 'text',
        ]);
        
        $wp_customize->add_setting('hero_button_2_url', [
            'default' => '#services',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control('hero_button_2_url', [
            'label' => __('Secondary Button URL', 'greentech'),
            'section' => 'greentech_hero',
            'type' => 'url',
        ]);
    }
    
    /**
     * Add contact section
     */
    private function add_contact_section($wp_customize) {
        $wp_customize->add_section('greentech_contact', [
            'title' => __('Contact Information', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 50,
        ]);
        
        // Phone
        $wp_customize->add_setting('contact_phone', [
            'default' => '0544-277588',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('contact_phone', [
            'label' => __('Phone Number', 'greentech'),
            'section' => 'greentech_contact',
            'type' => 'tel',
        ]);
        
        // Email
        $wp_customize->add_setting('contact_email', [
            'default' => 'inquiry@greentech.guru',
            'sanitize_callback' => 'sanitize_email',
        ]);
        
        $wp_customize->add_control('contact_email', [
            'label' => __('Email Address', 'greentech'),
            'section' => 'greentech_contact',
            'type' => 'email',
        ]);
        
        // Address
        $wp_customize->add_setting('contact_address', [
            'default' => 'Office# 11, 1st Floor Soldier Arcade, Al-Markaz Road, Jhelum',
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        
        $wp_customize->add_control('contact_address', [
            'label' => __('Address', 'greentech'),
            'section' => 'greentech_contact',
            'type' => 'textarea',
        ]);
        
        // Website
        $wp_customize->add_setting('contact_website', [
            'default' => 'www.greentech.guru',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        
        $wp_customize->add_control('contact_website', [
            'label' => __('Website', 'greentech'),
            'section' => 'greentech_contact',
            'type' => 'url',
        ]);
    }
    
    /**
     * Add social media section
     */
    private function add_social_section($wp_customize) {
        $wp_customize->add_section('greentech_social', [
            'title' => __('Social Media', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 60,
        ]);
        
        $social_networks = [
            'facebook' => __('Facebook', 'greentech'),
            'twitter' => __('Twitter', 'greentech'),
            'instagram' => __('Instagram', 'greentech'),
            'linkedin' => __('LinkedIn', 'greentech'),
            'youtube' => __('YouTube', 'greentech'),
            'github' => __('GitHub', 'greentech'),
        ];
        
        foreach ($social_networks as $network => $label) {
            $wp_customize->add_setting("social_{$network}", [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]);
            
            $wp_customize->add_control("social_{$network}", [
                'label' => $label . ' ' . __('URL', 'greentech'),
                'section' => 'greentech_social',
                'type' => 'url',
            ]);
        }
    }
    
    /**
     * Add footer section
     */
    private function add_footer_section($wp_customize) {
        $wp_customize->add_section('greentech_footer', [
            'title' => __('Footer Settings', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 70,
        ]);
        
        // Copyright Text
        $wp_customize->add_setting('footer_copyright', [
            'default' => sprintf(__('© %s %s. All rights reserved.', 'greentech'), date('Y'), get_bloginfo('name')),
            'sanitize_callback' => 'wp_kses_post',
        ]);
        
        $wp_customize->add_control('footer_copyright', [
            'label' => __('Copyright Text', 'greentech'),
            'section' => 'greentech_footer',
            'type' => 'textarea',
        ]);
        
        // Footer Layout
        $wp_customize->add_setting('footer_layout', [
            'default' => '4-columns',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('footer_layout', [
            'label' => __('Footer Layout', 'greentech'),
            'section' => 'greentech_footer',
            'type' => 'select',
            'choices' => [
                '1-column' => __('1 Column', 'greentech'),
                '2-columns' => __('2 Columns', 'greentech'),
                '3-columns' => __('3 Columns', 'greentech'),
                '4-columns' => __('4 Columns', 'greentech'),
            ],
        ]);
    }
    
    /**
     * Add blog section
     */
    private function add_blog_section($wp_customize) {
        $wp_customize->add_section('greentech_blog', [
            'title' => __('Blog Settings', 'greentech'),
            'panel' => 'greentech_panel',
            'priority' => 80,
        ]);
        
        // Blog Layout
        $wp_customize->add_setting('blog_layout', [
            'default' => 'sidebar-right',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('blog_layout', [
            'label' => __('Blog Layout', 'greentech'),
            'section' => 'greentech_blog',
            'type' => 'select',
            'choices' => [
                'full-width' => __('Full Width', 'greentech'),
                'sidebar-right' => __('Sidebar Right', 'greentech'),
                'sidebar-left' => __('Sidebar Left', 'greentech'),
            ],
        ]);
        
        // Show Excerpt
        $wp_customize->add_setting('blog_excerpt', [
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
        
        $wp_customize->add_control('blog_excerpt', [
            'label' => __('Show Excerpt', 'greentech'),
            'description' => __('Show post excerpt instead of full content on blog pages', 'greentech'),
            'section' => 'greentech_blog',
            'type' => 'checkbox',
        ]);
        
        // Read More Text
        $wp_customize->add_setting('blog_read_more', [
            'default' => __('Read More', 'greentech'),
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        
        $wp_customize->add_control('blog_read_more', [
            'label' => __('Read More Text', 'greentech'),
            'section' => 'greentech_blog',
            'type' => 'text',
        ]);
    }
    
    /**
     * Enqueue customizer preview scripts
     */
    public function customize_preview_js() {
        wp_enqueue_script(
            'greentech-customizer-preview',
            GREENTECH_ASSETS_URI . '/js/customizer-preview.js',
            ['customize-preview'],
            GREENTECH_VERSION,
            true
        );
    }
    
    /**
     * Output customizer CSS
     */
    public function customize_css() {
        $primary_color = get_theme_mod('primary_color', '#4CAF50');
        $secondary_color = get_theme_mod('secondary_color', '#1a1a1a');
        
        $css = "
        <style type='text/css'>
            :root {
                --primary-color: {$primary_color};
                --secondary-color: {$secondary_color};
            }
        </style>
        ";
        
        echo $css;
    }
}