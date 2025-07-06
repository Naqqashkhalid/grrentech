<?php
/**
 * Block Styles Class
 * 
 * Registers custom block styles for Gutenberg blocks.
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
 * Block Styles Class
 */
class Block_Styles {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', [$this, 'register_block_styles']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_block_styles']);
    }
    
    /**
     * Register custom block styles
     */
    public function register_block_styles() {
        // Hero style for Group/Cover blocks
        register_block_style('core/group', [
            'name'  => 'hero',
            'label' => __('Hero Section', 'greentech'),
        ]);
        
        register_block_style('core/cover', [
            'name'  => 'hero',
            'label' => __('Hero Section', 'greentech'),
        ]);
        
        // Card style for Group blocks
        register_block_style('core/group', [
            'name'  => 'card',
            'label' => __('Card', 'greentech'),
        ]);
        
        // Service grid style for Columns blocks
        register_block_style('core/columns', [
            'name'  => 'service-grid',
            'label' => __('Service Grid', 'greentech'),
        ]);
        
        // Testimonial style for Group blocks
        register_block_style('core/group', [
            'name'  => 'testimonial',
            'label' => __('Testimonial', 'greentech'),
        ]);
        
        register_block_style('core/quote', [
            'name'  => 'testimonial',
            'label' => __('Testimonial Style', 'greentech'),
        ]);
        
        // CTA (Call to Action) style for Group blocks
        register_block_style('core/group', [
            'name'  => 'cta',
            'label' => __('Call to Action', 'greentech'),
        ]);
        
        // Button styles
        register_block_style('core/button', [
            'name'  => 'outline-primary',
            'label' => __('Outline Primary', 'greentech'),
        ]);
        
        register_block_style('core/button', [
            'name'  => 'ghost',
            'label' => __('Ghost Button', 'greentech'),
        ]);
        
        register_block_style('core/button', [
            'name'  => 'rounded',
            'label' => __('Rounded Button', 'greentech'),
        ]);
        
        // Image styles
        register_block_style('core/image', [
            'name'  => 'rounded',
            'label' => __('Rounded Image', 'greentech'),
        ]);
        
        register_block_style('core/image', [
            'name'  => 'shadow',
            'label' => __('Shadow Image', 'greentech'),
        ]);
        
        // Heading styles
        register_block_style('core/heading', [
            'name'  => 'gradient-text',
            'label' => __('Gradient Text', 'greentech'),
        ]);
        
        register_block_style('core/heading', [
            'name'  => 'underlined',
            'label' => __('Underlined Heading', 'greentech'),
        ]);
        
        // List styles
        register_block_style('core/list', [
            'name'  => 'checkmark',
            'label' => __('Checkmark List', 'greentech'),
        ]);
        
        register_block_style('core/list', [
            'name'  => 'no-bullets',
            'label' => __('No Bullets', 'greentech'),
        ]);
        
        // Separator styles
        register_block_style('core/separator', [
            'name'  => 'gradient',
            'label' => __('Gradient Separator', 'greentech'),
        ]);
        
        register_block_style('core/separator', [
            'name'  => 'dotted',
            'label' => __('Dotted Separator', 'greentech'),
        ]);
        
        // Spacer styles
        register_block_style('core/spacer', [
            'name'  => 'wave-divider',
            'label' => __('Wave Divider', 'greentech'),
        ]);
        
        // Media & Text styles
        register_block_style('core/media-text', [
            'name'  => 'overlap',
            'label' => __('Overlap Style', 'greentech'),
        ]);
        
        register_block_style('core/media-text', [
            'name'  => 'bordered',
            'label' => __('Bordered Style', 'greentech'),
        ]);
        
        // Gallery styles
        register_block_style('core/gallery', [
            'name'  => 'masonry',
            'label' => __('Masonry Layout', 'greentech'),
        ]);
        
        register_block_style('core/gallery', [
            'name'  => 'hover-zoom',
            'label' => __('Hover Zoom Effect', 'greentech'),
        ]);
        
        // Column styles
        register_block_style('core/column', [
            'name'  => 'highlight',
            'label' => __('Highlighted Column', 'greentech'),
        ]);
        
        // Table styles
        register_block_style('core/table', [
            'name'  => 'modern',
            'label' => __('Modern Table', 'greentech'),
        ]);
        
        register_block_style('core/table', [
            'name'  => 'pricing',
            'label' => __('Pricing Table', 'greentech'),
        ]);
    }
    
    /**
     * Enqueue block styles
     */
    public function enqueue_block_styles() {
        // Enqueue additional block styles CSS
        wp_enqueue_style(
            'greentech-block-styles',
            GREENTECH_ASSETS_URI . '/css/block-styles.css',
            ['wp-edit-blocks'],
            GREENTECH_VERSION
        );
    }
}