<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Theme color for mobile browsers -->
    <meta name="theme-color" content="#4CAF50">
    <meta name="msapplication-navbutton-color" content="#4CAF50">
    <meta name="apple-mobile-web-app-status-bar-style" content="#4CAF50">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to content link for accessibility -->
<a class="skip-link sr-only" href="#main"><?php _e('Skip to content', 'greentech'); ?></a>

<div id="page" class="site">
    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="header-inner">
                
                <!-- Site Logo/Brand -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php if (get_bloginfo('description', 'display')) : ?>
                            <p class="site-description"><?php echo get_bloginfo('description', 'display'); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Main Navigation -->
                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php _e('Primary Menu', 'greentech'); ?>">
                    <?php
                    // Mobile menu toggle button
                    echo '<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="' . __('Toggle navigation', 'greentech') . '">';
                    echo '<span></span>';
                    echo '<span></span>';
                    echo '<span></span>';
                    echo '</button>';
                    
                    // Navigation menu
                    echo '<div id="primary-menu" class="menu-container">';
                    \GreenTech\Navigation::render_primary_nav();
                    echo '</div>';
                    ?>
                </nav>

                <!-- Header CTA Button -->
                <div class="header-cta">
                    <a href="<?php echo esc_url(get_theme_mod('hero_button_url', '#contact')); ?>" class="btn btn-primary">
                        <?php echo esc_html(get_theme_mod('hero_button_text', __('Get Started', 'greentech'))); ?>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <?php 
    // Render page title/breadcrumbs for non-homepage
    if (!is_front_page()) {
        \GreenTech\Template_Functions::render_page_title();
        \GreenTech\Template_Functions::render_breadcrumbs();
    }
    ?>

    <main id="main" class="site-main" role="main">