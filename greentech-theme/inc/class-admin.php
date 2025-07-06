<?php
/**
 * Admin Class
 * 
 * Handles admin functionality and backend customizations
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
     * Initialize the class
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_action('admin_menu', [$this, 'add_theme_page']);
        add_filter('admin_footer_text', [$this, 'admin_footer_text']);
        add_action('wp_dashboard_setup', [$this, 'add_dashboard_widgets']);
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        // Only load on theme-related pages
        if (!in_array($hook, ['appearance_page_greentech-options', 'customize.php'])) {
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
    }
    
    /**
     * Add theme options page
     */
    public function add_theme_page() {
        add_theme_page(
            __('GreenTech Options', 'greentech'),
            __('Theme Options', 'greentech'),
            'manage_options',
            'greentech-options',
            [$this, 'theme_options_page']
        );
    }
    
    /**
     * Theme options page content
     */
    public function theme_options_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('GreenTech Theme Options', 'greentech'); ?></h1>
            
            <div class="greentech-admin-grid">
                <div class="greentech-admin-card">
                    <h2><?php _e('Quick Setup', 'greentech'); ?></h2>
                    <p><?php _e('Get your site ready in minutes with our theme setup guide.', 'greentech'); ?></p>
                    <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary">
                        <?php _e('Customize Your Site', 'greentech'); ?>
                    </a>
                </div>
                
                <div class="greentech-admin-card">
                    <h2><?php _e('Documentation', 'greentech'); ?></h2>
                    <p><?php _e('Learn how to use all the features of your GreenTech theme.', 'greentech'); ?></p>
                    <a href="#" class="button" target="_blank">
                        <?php _e('View Documentation', 'greentech'); ?>
                    </a>
                </div>
                
                <div class="greentech-admin-card">
                    <h2><?php _e('Support', 'greentech'); ?></h2>
                    <p><?php _e('Need help? Our support team is ready to assist you.', 'greentech'); ?></p>
                    <a href="#" class="button" target="_blank">
                        <?php _e('Get Support', 'greentech'); ?>
                    </a>
                </div>
            </div>
            
            <div class="greentech-system-info">
                <h2><?php _e('System Information', 'greentech'); ?></h2>
                <table class="widefat">
                    <tbody>
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
                    </tbody>
                </table>
            </div>
        </div>
        
        <style>
        .greentech-admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .greentech-admin-card {
            background: #fff;
            border: 1px solid #ccd0d4;
            padding: 20px;
            border-radius: 4px;
        }
        
        .greentech-admin-card h2 {
            margin-top: 0;
            color: #4CAF50;
        }
        
        .greentech-system-info {
            margin-top: 30px;
        }
        
        .greentech-system-info table {
            margin-top: 10px;
        }
        
        .greentech-system-info td {
            padding: 10px;
        }
        </style>
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
                '#'
            );
        }
        
        return $text;
    }
    
    /**
     * Add dashboard widgets
     */
    public function add_dashboard_widgets() {
        wp_add_dashboard_widget(
            'greentech_dashboard_widget',
            __('GreenTech Theme', 'greentech'),
            [$this, 'dashboard_widget_content']
        );
    }
    
    /**
     * Dashboard widget content
     */
    public function dashboard_widget_content() {
        ?>
        <div class="greentech-dashboard-widget">
            <h3><?php _e('Welcome to GreenTech', 'greentech'); ?></h3>
            <p><?php _e('Your professional business theme is ready to help you create an amazing website.', 'greentech'); ?></p>
            
            <div class="greentech-widget-actions">
                <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary">
                    <?php _e('Customize Theme', 'greentech'); ?>
                </a>
                <a href="<?php echo admin_url('themes.php?page=greentech-options'); ?>" class="button">
                    <?php _e('Theme Options', 'greentech'); ?>
                </a>
            </div>
            
            <div class="greentech-widget-stats">
                <div class="stat-item">
                    <strong><?php echo wp_count_posts()->publish; ?></strong>
                    <span><?php _e('Published Posts', 'greentech'); ?></span>
                </div>
                <div class="stat-item">
                    <strong><?php echo wp_count_posts('page')->publish; ?></strong>
                    <span><?php _e('Published Pages', 'greentech'); ?></span>
                </div>
                <div class="stat-item">
                    <strong><?php echo wp_count_comments()->approved; ?></strong>
                    <span><?php _e('Approved Comments', 'greentech'); ?></span>
                </div>
            </div>
        </div>
        
        <style>
        .greentech-dashboard-widget h3 {
            color: #4CAF50;
            margin-top: 0;
        }
        
        .greentech-widget-actions {
            margin: 15px 0;
        }
        
        .greentech-widget-actions .button {
            margin-right: 10px;
        }
        
        .greentech-widget-stats {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        
        .stat-item {
            text-align: center;
            flex: 1;
        }
        
        .stat-item strong {
            display: block;
            font-size: 24px;
            color: #4CAF50;
            line-height: 1.2;
        }
        
        .stat-item span {
            font-size: 12px;
            color: #666;
        }
        </style>
        <?php
    }
}