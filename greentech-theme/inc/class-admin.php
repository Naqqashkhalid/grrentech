<?php
/**
 * Admin Class
 * 
 * Handles admin-specific functionality and customizations.
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
 * Admin Class
 */
class Admin {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'add_theme_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_init', [$this, 'add_editor_styles']);
        add_action('admin_notices', [$this, 'show_welcome_notice']);
        add_action('wp_ajax_dismiss_greentech_notice', [$this, 'dismiss_notice']);
        add_filter('admin_footer_text', [$this, 'admin_footer_text']);
        add_action('admin_head', [$this, 'admin_styles']);
    }
    
    /**
     * Add theme options page
     */
    public function add_theme_page() {
        add_theme_page(
            __('GreenTech Theme', 'greentech'),
            __('GreenTech Theme', 'greentech'),
            'manage_options',
            'greentech-theme',
            [$this, 'theme_page_content']
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only load on theme pages and customizer
        if (!in_array($hook, ['appearance_page_greentech-theme', 'customize.php'])) {
            return;
        }
        
        wp_enqueue_style(
            'greentech-admin',
            GREENTECH_ASSETS_URI . '/css/admin.css',
            [],
            GREENTECH_VERSION
        );
        
        wp_enqueue_script(
            'greentech-admin',
            GREENTECH_ASSETS_URI . '/js/admin.js',
            ['jquery'],
            GREENTECH_VERSION,
            true
        );
        
        wp_localize_script('greentech-admin', 'greentech_admin', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('greentech_admin_nonce'),
        ]);
    }
    
    /**
     * Add editor styles
     */
    public function add_editor_styles() {
        add_editor_style([
            'assets/css/editor-style.css',
            $this->get_google_fonts_url(),
        ]);
    }
    
    /**
     * Show welcome notice for new installations
     */
    public function show_welcome_notice() {
        // Only show on admin pages and if not dismissed
        if (!current_user_can('manage_options') || get_user_meta(get_current_user_id(), 'greentech_welcome_dismissed', true)) {
            return;
        }
        
        $screen = get_current_screen();
        if (!in_array($screen->id, ['dashboard', 'themes', 'appearance_page_greentech-theme'])) {
            return;
        }
        
        ?>
        <div class="notice notice-success is-dismissible greentech-welcome-notice">
            <h3><?php _e('Welcome to GreenTech Theme!', 'greentech'); ?></h3>
            <p><?php _e('Thank you for choosing GreenTech. Get started by customizing your site colors, fonts, and layout.', 'greentech'); ?></p>
            <p>
                <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary">
                    <?php _e('Customize Your Site', 'greentech'); ?>
                </a>
                <a href="<?php echo admin_url('themes.php?page=greentech-theme'); ?>" class="button">
                    <?php _e('Theme Documentation', 'greentech'); ?>
                </a>
            </p>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $(document).on('click', '.greentech-welcome-notice .notice-dismiss', function() {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'dismiss_greentech_notice',
                        nonce: '<?php echo wp_create_nonce('greentech_dismiss_notice'); ?>'
                    }
                });
            });
        });
        </script>
        <?php
    }
    
    /**
     * Dismiss welcome notice
     */
    public function dismiss_notice() {
        if (!wp_verify_nonce($_POST['nonce'], 'greentech_dismiss_notice')) {
            wp_die(__('Security check failed', 'greentech'));
        }
        
        update_user_meta(get_current_user_id(), 'greentech_welcome_dismissed', true);
        wp_die();
    }
    
    /**
     * Theme page content
     */
    public function theme_page_content() {
        ?>
        <div class="wrap greentech-admin-wrap">
            <h1><?php _e('GreenTech Theme', 'greentech'); ?></h1>
            
            <div class="greentech-admin-header">
                <div class="greentech-admin-header-content">
                    <h2><?php _e('Welcome to GreenTech', 'greentech'); ?></h2>
                    <p><?php _e('A modern, professional WordPress theme built for Gutenberg. Perfect for web development agencies, SEO firms, hosting providers, and software houses.', 'greentech'); ?></p>
                </div>
            </div>
            
            <div class="greentech-admin-content">
                <div class="greentech-admin-grid">
                    <div class="greentech-admin-card">
                        <div class="greentech-admin-card-icon">🎨</div>
                        <h3><?php _e('Customize Your Site', 'greentech'); ?></h3>
                        <p><?php _e('Use the WordPress Customizer to change colors, fonts, layout, and more.', 'greentech'); ?></p>
                        <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary">
                            <?php _e('Open Customizer', 'greentech'); ?>
                        </a>
                    </div>
                    
                    <div class="greentech-admin-card">
                        <div class="greentech-admin-card-icon">🧩</div>
                        <h3><?php _e('Block Patterns', 'greentech'); ?></h3>
                        <p><?php _e('Use pre-built block patterns to quickly create beautiful pages.', 'greentech'); ?></p>
                        <a href="<?php echo admin_url('post-new.php?post_type=page'); ?>" class="button">
                            <?php _e('Create New Page', 'greentech'); ?>
                        </a>
                    </div>
                    
                    <div class="greentech-admin-card">
                        <div class="greentech-admin-card-icon">📚</div>
                        <h3><?php _e('Documentation', 'greentech'); ?></h3>
                        <p><?php _e('Learn how to get the most out of your GreenTech theme.', 'greentech'); ?></p>
                        <a href="#" class="button" target="_blank">
                            <?php _e('View Documentation', 'greentech'); ?>
                        </a>
                    </div>
                    
                    <div class="greentech-admin-card">
                        <div class="greentech-admin-card-icon">🛠️</div>
                        <h3><?php _e('Theme Features', 'greentech'); ?></h3>
                        <p><?php _e('Explore all the powerful features included with GreenTech.', 'greentech'); ?></p>
                        <ul class="greentech-feature-list">
                            <li>✅ <?php _e('Block-based design', 'greentech'); ?></li>
                            <li>✅ <?php _e('Custom block styles', 'greentech'); ?></li>
                            <li>✅ <?php _e('Pre-built patterns', 'greentech'); ?></li>
                            <li>✅ <?php _e('Responsive design', 'greentech'); ?></li>
                            <li>✅ <?php _e('SEO optimized', 'greentech'); ?></li>
                            <li>✅ <?php _e('Performance focused', 'greentech'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="greentech-admin-section">
                    <h3><?php _e('Quick Start Guide', 'greentech'); ?></h3>
                    <div class="greentech-quick-start">
                        <div class="greentech-step">
                            <div class="greentech-step-number">1</div>
                            <div class="greentech-step-content">
                                <h4><?php _e('Customize Your Branding', 'greentech'); ?></h4>
                                <p><?php _e('Upload your logo and set your brand colors in the Customizer.', 'greentech'); ?></p>
                            </div>
                        </div>
                        
                        <div class="greentech-step">
                            <div class="greentech-step-number">2</div>
                            <div class="greentech-step-content">
                                <h4><?php _e('Create Your Pages', 'greentech'); ?></h4>
                                <p><?php _e('Use block patterns to quickly build your homepage, about page, and contact page.', 'greentech'); ?></p>
                            </div>
                        </div>
                        
                        <div class="greentech-step">
                            <div class="greentech-step-number">3</div>
                            <div class="greentech-step-content">
                                <h4><?php _e('Set Up Your Menus', 'greentech'); ?></h4>
                                <p><?php _e('Create and assign menus for your header, footer, and social links.', 'greentech'); ?></p>
                            </div>
                        </div>
                        
                        <div class="greentech-step">
                            <div class="greentech-step-number">4</div>
                            <div class="greentech-step-content">
                                <h4><?php _e('Add Your Content', 'greentech'); ?></h4>
                                <p><?php _e('Start adding your content using the powerful Gutenberg editor.', 'greentech'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="greentech-admin-section">
                    <h3><?php _e('System Information', 'greentech'); ?></h3>
                    <table class="greentech-system-info">
                        <tr>
                            <td><strong><?php _e('Theme Version', 'greentech'); ?></strong></td>
                            <td><?php echo GREENTECH_VERSION; ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php _e('WordPress Version', 'greentech'); ?></strong></td>
                            <td><?php echo get_bloginfo('version'); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php _e('PHP Version', 'greentech'); ?></strong></td>
                            <td><?php echo PHP_VERSION; ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php _e('Active Plugins', 'greentech'); ?></strong></td>
                            <td><?php echo count(get_option('active_plugins')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Custom admin footer text
     */
    public function admin_footer_text($text) {
        $screen = get_current_screen();
        
        if (isset($screen->id) && strpos($screen->id, 'greentech') !== false) {
            $text = sprintf(
                __('Thank you for using <strong>GreenTech</strong> theme. <a href="%s" target="_blank">Rate us</a> ★★★★★', 'greentech'),
                'https://wordpress.org/themes/greentech/'
            );
        }
        
        return $text;
    }
    
    /**
     * Add admin styles
     */
    public function admin_styles() {
        ?>
        <style>
        .greentech-admin-wrap {
            max-width: 1200px;
        }
        
        .greentech-admin-header {
            background: linear-gradient(135deg, #4CAF50 0%, #66bb6a 100%);
            color: white;
            padding: 2rem;
            margin: 1rem 0;
            border-radius: 8px;
        }
        
        .greentech-admin-header h2 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
        }
        
        .greentech-admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .greentech-admin-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .greentech-admin-card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .greentech-admin-card h3 {
            margin: 0 0 0.5rem 0;
            color: #4CAF50;
        }
        
        .greentech-feature-list {
            list-style: none;
            padding: 0;
        }
        
        .greentech-feature-list li {
            margin: 0.5rem 0;
        }
        
        .greentech-quick-start {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .greentech-step {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 8px;
        }
        
        .greentech-step-number {
            background: #4CAF50;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .greentech-step-content h4 {
            margin: 0 0 0.5rem 0;
        }
        
        .greentech-system-info {
            width: 100%;
            border-collapse: collapse;
        }
        
        .greentech-system-info td {
            padding: 0.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .greentech-admin-section {
            margin: 2rem 0;
            padding: 1.5rem;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        </style>
        <?php
    }
    
    /**
     * Get Google Fonts URL for admin
     */
    private function get_google_fonts_url() {
        $fonts = [
            'Inter:wght@300;400;500;600;700;800',
        ];
        
        $fonts_url = add_query_arg([
            'family' => implode('&family=', $fonts),
            'display' => 'swap',
        ], 'https://fonts.googleapis.com/css2');
        
        return $fonts_url;
    }
}