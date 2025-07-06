<?php
/**
 * Customizer Class
 * 
 * Handles WordPress Customizer integration and theme options.
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
     * Constructor
     */
    public function __construct() {
        add_action('customize_register', [$this, 'register_customizer_options']);
        add_action('customize_preview_init', [$this, 'customize_preview_js']);
        add_action('wp_head', [$this, 'output_customizer_styles']);
    }
    
    /**
     * Register customizer options
     */
    public function register_customizer_options($wp_customize) {
        // Remove default sections we don't need
        $wp_customize->remove_section('colors');
        $wp_customize->remove_section('background_image');
        
        // Add custom panels
        $this->add_branding_panel($wp_customize);
        $this->add_layout_panel($wp_customize);
        $this->add_contact_panel($wp_customize);
        $this->add_blog_panel($wp_customize);
    }
    
    /**
     * Add branding panel
     */
    private function add_branding_panel($wp_customize) {
        // Branding Panel
        $wp_customize->add_panel('greentech_branding', [
            'title'       => __('Branding & Design', 'greentech'),
            'description' => __('Customize your site branding, colors, and typography.', 'greentech'),
            'priority'    => 30,
        ]);
        
        // Colors Section
        $wp_customize->add_section('greentech_colors', [
            'title'    => __('Colors', 'greentech'),
            'panel'    => 'greentech_branding',
            'priority' => 10,
        ]);
        
        // Primary Color
        $wp_customize->add_setting('colors_primary', [
            'default'           => '#4CAF50',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'colors_primary', [
            'label'    => __('Primary Color', 'greentech'),
            'section'  => 'greentech_colors',
            'settings' => 'colors_primary',
        ]));
        
        // Secondary Color
        $wp_customize->add_setting('colors_secondary', [
            'default'           => '#1a1a1a',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'colors_secondary', [
            'label'    => __('Secondary Color', 'greentech'),
            'section'  => 'greentech_colors',
            'settings' => 'colors_secondary',
        ]));
        
        // Accent Color
        $wp_customize->add_setting('colors_accent', [
            'default'           => '#66bb6a',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, 'colors_accent', [
            'label'    => __('Accent Color', 'greentech'),
            'section'  => 'greentech_colors',
            'settings' => 'colors_accent',
        ]));
        
        // Typography Section
        $wp_customize->add_section('greentech_typography', [
            'title'    => __('Typography', 'greentech'),
            'panel'    => 'greentech_branding',
            'priority' => 20,
        ]);
        
        // Heading Font
        $wp_customize->add_setting('typography_heading_font', [
            'default'           => 'Inter',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('typography_heading_font', [
            'type'     => 'select',
            'label'    => __('Heading Font', 'greentech'),
            'section'  => 'greentech_typography',
            'choices'  => [
                'Inter'     => 'Inter',
                'Poppins'   => 'Poppins',
                'Roboto'    => 'Roboto',
                'Open Sans' => 'Open Sans',
                'Lato'      => 'Lato',
            ],
        ]);
        
        // Body Font
        $wp_customize->add_setting('typography_body_font', [
            'default'           => 'Inter',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('typography_body_font', [
            'type'     => 'select',
            'label'    => __('Body Font', 'greentech'),
            'section'  => 'greentech_typography',
            'choices'  => [
                'Inter'     => 'Inter',
                'Poppins'   => 'Poppins',
                'Roboto'    => 'Roboto',
                'Open Sans' => 'Open Sans',
                'Lato'      => 'Lato',
            ],
        ]);
        
        // Font Size Scale
        $wp_customize->add_setting('typography_font_scale', [
            'default'           => '1',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('typography_font_scale', [
            'type'        => 'range',
            'label'       => __('Font Size Scale', 'greentech'),
            'section'     => 'greentech_typography',
            'input_attrs' => [
                'min'  => '0.8',
                'max'  => '1.2',
                'step' => '0.1',
            ],
        ]);
    }
    
    /**
     * Add layout panel
     */
    private function add_layout_panel($wp_customize) {
        // Layout Panel
        $wp_customize->add_panel('greentech_layout', [
            'title'       => __('Layout & Header', 'greentech'),
            'description' => __('Customize your site layout, header, and footer options.', 'greentech'),
            'priority'    => 40,
        ]);
        
        // Header Section
        $wp_customize->add_section('greentech_header', [
            'title'    => __('Header Settings', 'greentech'),
            'panel'    => 'greentech_layout',
            'priority' => 10,
        ]);
        
        // Header Style
        $wp_customize->add_setting('header_style', [
            'default'           => 'transparent',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('header_style', [
            'type'     => 'select',
            'label'    => __('Header Style', 'greentech'),
            'section'  => 'greentech_header',
            'choices'  => [
                'transparent' => __('Transparent', 'greentech'),
                'solid'       => __('Solid', 'greentech'),
                'boxed'       => __('Boxed', 'greentech'),
            ],
        ]);
        
        // Sticky Header
        $wp_customize->add_setting('header_sticky', [
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('header_sticky', [
            'type'    => 'checkbox',
            'label'   => __('Enable Sticky Header', 'greentech'),
            'section' => 'greentech_header',
        ]);
        
        // Header CTA Button
        $wp_customize->add_setting('header_cta_text', [
            'default'           => __('Get Started', 'greentech'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('header_cta_text', [
            'type'    => 'text',
            'label'   => __('Header CTA Button Text', 'greentech'),
            'section' => 'greentech_header',
        ]);
        
        $wp_customize->add_setting('header_cta_url', [
            'default'           => '#contact',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('header_cta_url', [
            'type'    => 'url',
            'label'   => __('Header CTA Button URL', 'greentech'),
            'section' => 'greentech_header',
        ]);
        
        // Layout Section
        $wp_customize->add_section('greentech_layout_options', [
            'title'    => __('Layout Options', 'greentech'),
            'panel'    => 'greentech_layout',
            'priority' => 20,
        ]);
        
        // Container Width
        $wp_customize->add_setting('layout_container_width', [
            'default'           => '1200',
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('layout_container_width', [
            'type'        => 'range',
            'label'       => __('Container Width (px)', 'greentech'),
            'section'     => 'greentech_layout_options',
            'input_attrs' => [
                'min'  => '1000',
                'max'  => '1400',
                'step' => '50',
            ],
        ]);
        
        // Boxed Layout
        $wp_customize->add_setting('layout_boxed', [
            'default'           => false,
            'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('layout_boxed', [
            'type'    => 'checkbox',
            'label'   => __('Enable Boxed Layout', 'greentech'),
            'section' => 'greentech_layout_options',
        ]);
        
        // Footer Section
        $wp_customize->add_section('greentech_footer', [
            'title'    => __('Footer Settings', 'greentech'),
            'panel'    => 'greentech_layout',
            'priority' => 30,
        ]);
        
        // Footer Copyright
        $wp_customize->add_setting('footer_copyright', [
            'default'           => sprintf(__('© %s %s. All rights reserved.', 'greentech'), date('Y'), get_bloginfo('name')),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('footer_copyright', [
            'type'    => 'textarea',
            'label'   => __('Footer Copyright Text', 'greentech'),
            'section' => 'greentech_footer',
        ]);
        
        // Footer Widgets
        $wp_customize->add_setting('footer_widgets_columns', [
            'default'           => '4',
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('footer_widgets_columns', [
            'type'     => 'select',
            'label'    => __('Footer Widget Columns', 'greentech'),
            'section'  => 'greentech_footer',
            'choices'  => [
                '1' => __('1 Column', 'greentech'),
                '2' => __('2 Columns', 'greentech'),
                '3' => __('3 Columns', 'greentech'),
                '4' => __('4 Columns', 'greentech'),
            ],
        ]);
    }
    
    /**
     * Add contact panel
     */
    private function add_contact_panel($wp_customize) {
        // Contact Panel
        $wp_customize->add_panel('greentech_contact', [
            'title'       => __('Contact Information', 'greentech'),
            'description' => __('Add your business contact information and social media links.', 'greentech'),
            'priority'    => 50,
        ]);
        
        // Contact Info Section
        $wp_customize->add_section('greentech_contact_info', [
            'title'    => __('Contact Details', 'greentech'),
            'panel'    => 'greentech_contact',
            'priority' => 10,
        ]);
        
        // Phone
        $wp_customize->add_setting('contact_phone', [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('contact_phone', [
            'type'    => 'tel',
            'label'   => __('Phone Number', 'greentech'),
            'section' => 'greentech_contact_info',
        ]);
        
        // Email
        $wp_customize->add_setting('contact_email', [
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('contact_email', [
            'type'    => 'email',
            'label'   => __('Email Address', 'greentech'),
            'section' => 'greentech_contact_info',
        ]);
        
        // Address
        $wp_customize->add_setting('contact_address', [
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('contact_address', [
            'type'    => 'textarea',
            'label'   => __('Business Address', 'greentech'),
            'section' => 'greentech_contact_info',
        ]);
        
        // Website
        $wp_customize->add_setting('contact_website', [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('contact_website', [
            'type'    => 'url',
            'label'   => __('Website URL', 'greentech'),
            'section' => 'greentech_contact_info',
        ]);
        
        // Social Media Section
        $wp_customize->add_section('greentech_social_media', [
            'title'    => __('Social Media', 'greentech'),
            'panel'    => 'greentech_contact',
            'priority' => 20,
        ]);
        
        $social_networks = [
            'facebook'  => 'Facebook',
            'twitter'   => 'Twitter',
            'instagram' => 'Instagram',
            'linkedin'  => 'LinkedIn',
            'youtube'   => 'YouTube',
            'github'    => 'GitHub',
        ];
        
        foreach ($social_networks as $network => $label) {
            $wp_customize->add_setting("social_{$network}", [
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'postMessage',
            ]);
            
            $wp_customize->add_control("social_{$network}", [
                'type'    => 'url',
                'label'   => sprintf(__('%s URL', 'greentech'), $label),
                'section' => 'greentech_social_media',
            ]);
        }
    }
    
    /**
     * Add blog panel
     */
    private function add_blog_panel($wp_customize) {
        // Blog Panel
        $wp_customize->add_panel('greentech_blog', [
            'title'       => __('Blog Settings', 'greentech'),
            'description' => __('Customize your blog layout and display options.', 'greentech'),
            'priority'    => 60,
        ]);
        
        // Blog Layout Section
        $wp_customize->add_section('greentech_blog_layout', [
            'title'    => __('Blog Layout', 'greentech'),
            'panel'    => 'greentech_blog',
            'priority' => 10,
        ]);
        
        // Blog Layout Style
        $wp_customize->add_setting('blog_layout', [
            'default'           => 'grid',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('blog_layout', [
            'type'     => 'select',
            'label'    => __('Blog Layout', 'greentech'),
            'section'  => 'greentech_blog_layout',
            'choices'  => [
                'grid'     => __('Grid Layout', 'greentech'),
                'list'     => __('List Layout', 'greentech'),
                'masonry'  => __('Masonry Layout', 'greentech'),
            ],
        ]);
        
        // Posts per Row
        $wp_customize->add_setting('blog_columns', [
            'default'           => '3',
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('blog_columns', [
            'type'     => 'select',
            'label'    => __('Posts per Row', 'greentech'),
            'section'  => 'greentech_blog_layout',
            'choices'  => [
                '1' => __('1 Column', 'greentech'),
                '2' => __('2 Columns', 'greentech'),
                '3' => __('3 Columns', 'greentech'),
                '4' => __('4 Columns', 'greentech'),
            ],
        ]);
        
        // Show Excerpt
        $wp_customize->add_setting('blog_show_excerpt', [
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('blog_show_excerpt', [
            'type'    => 'checkbox',
            'label'   => __('Show Post Excerpts', 'greentech'),
            'section' => 'greentech_blog_layout',
        ]);
        
        // Excerpt Length
        $wp_customize->add_setting('blog_excerpt_length', [
            'default'           => 30,
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('blog_excerpt_length', [
            'type'        => 'range',
            'label'       => __('Excerpt Length (words)', 'greentech'),
            'section'     => 'greentech_blog_layout',
            'input_attrs' => [
                'min'  => '10',
                'max'  => '100',
                'step' => '5',
            ],
        ]);
        
        // Read More Text
        $wp_customize->add_setting('blog_read_more_text', [
            'default'           => __('Read More', 'greentech'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);
        
        $wp_customize->add_control('blog_read_more_text', [
            'type'    => 'text',
            'label'   => __('Read More Button Text', 'greentech'),
            'section' => 'greentech_blog_layout',
        ]);
    }
    
    /**
     * Enqueue customizer preview script
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
     * Output customizer styles
     */
    public function output_customizer_styles() {
        $primary_color = get_theme_mod('colors_primary', '#4CAF50');
        $secondary_color = get_theme_mod('colors_secondary', '#1a1a1a');
        $accent_color = get_theme_mod('colors_accent', '#66bb6a');
        $container_width = get_theme_mod('layout_container_width', 1200);
        $font_scale = get_theme_mod('typography_font_scale', 1);
        
        $css = "
        <style id='greentech-customizer-styles'>
            :root {
                --wp--preset--color--primary: {$primary_color};
                --wp--preset--color--secondary: {$secondary_color};
                --wp--preset--color--accent: {$accent_color};
                --wp--preset--color--primary-hover: " . $this->adjust_brightness($primary_color, -20) . ";
                --wp--style--global--content-size: {$container_width}px;
                --wp--style--global--wide-size: " . ($container_width + 200) . "px;
                --font-scale: {$font_scale};
            }
            
            .container {
                max-width: {$container_width}px;
            }
            
            body {
                font-size: calc(1rem * var(--font-scale));
            }
        </style>";
        
        echo $css;
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
}