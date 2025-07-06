<?php
/**
 * The header for our theme
 * 
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php _e('Skip to content', 'greentech'); ?>
    </a>

    <header id="masthead" class="site-header<?php echo get_theme_mod('header_sticky', true) ? ' sticky-header' : ''; ?><?php echo ' header-style-' . get_theme_mod('header_style', 'transparent'); ?>">
        <div class="header-container">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <div class="site-title-wrapper">
                        <?php if (is_front_page() && is_home()) : ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                        <?php else : ?>
                            <p class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        
                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $description; ?></p>
                        <?php endif; ?>
                    </div>
                    <?php
                }
                ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'greentech'); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="menu-toggle-icon"></span>
                    <span class="menu-toggle-text screen-reader-text"><?php _e('Menu', 'greentech'); ?></span>
                </button>
                
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav><!-- #site-navigation -->

            <div class="header-actions">
                <?php if (is_active_sidebar('header-widgets')) : ?>
                    <div class="header-widgets">
                        <?php dynamic_sidebar('header-widgets'); ?>
                    </div>
                <?php endif; ?>

                <?php
                $cta_text = get_theme_mod('header_cta_text', __('Get Started', 'greentech'));
                $cta_url = get_theme_mod('header_cta_url', '#contact');
                
                if ($cta_text && $cta_url) :
                    ?>
                    <div class="header-cta">
                        <a href="<?php echo esc_url($cta_url); ?>" class="cta-button">
                            <?php echo esc_html($cta_text); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php
                // Social links menu
                if (has_nav_menu('social')) :
                    ?>
                    <div class="header-social">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'social',
                            'menu_class'     => 'social-links-menu',
                            'container'      => false,
                            'depth'          => 1,
                            'link_before'    => '<span class="screen-reader-text">',
                            'link_after'     => '</span>',
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
            </div><!-- .header-actions -->
        </div><!-- .header-container -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">
        <div class="content-container">