<?php
/**
 * The footer for our theme
 * 
 * This is the template that displays all the footer content
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

?>

        </div><!-- .content-container -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
            <div class="footer-widgets">
                <div class="footer-widgets-container">
                    <?php
                    $footer_columns = get_theme_mod('footer_widgets_columns', 4);
                    $widget_classes = [
                        1 => 'footer-widget-full',
                        2 => 'footer-widget-half',
                        3 => 'footer-widget-third',
                        4 => 'footer-widget-quarter',
                    ];
                    $widget_class = isset($widget_classes[$footer_columns]) ? $widget_classes[$footer_columns] : 'footer-widget-quarter';
                    
                    for ($i = 1; $i <= $footer_columns; $i++) :
                        if (is_active_sidebar('footer-' . $i)) :
                            ?>
                            <div class="footer-widget-area <?php echo esc_attr($widget_class); ?>">
                                <?php dynamic_sidebar('footer-' . $i); ?>
                            </div>
                            <?php
                        endif;
                    endfor;
                    ?>
                </div>
            </div><!-- .footer-widgets -->
        <?php endif; ?>

        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <div class="footer-info">
                    <div class="footer-copyright">
                        <?php
                        $copyright = get_theme_mod('footer_copyright', sprintf(__('© %s %s. All rights reserved.', 'greentech'), date('Y'), get_bloginfo('name')));
                        echo wp_kses_post($copyright);
                        ?>
                    </div>

                    <?php
                    // Contact information
                    $contact_info = greentech_get_contact_info();
                    if (array_filter($contact_info)) :
                        ?>
                        <div class="footer-contact">
                            <?php if ($contact_info['phone']) : ?>
                                <span class="footer-contact-item">
                                    <a href="tel:<?php echo esc_attr(str_replace([' ', '-', '(', ')'], '', $contact_info['phone'])); ?>">
                                        <?php echo esc_html($contact_info['phone']); ?>
                                    </a>
                                </span>
                            <?php endif; ?>

                            <?php if ($contact_info['email']) : ?>
                                <span class="footer-contact-item">
                                    <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>">
                                        <?php echo esc_html($contact_info['email']); ?>
                                    </a>
                                </span>
                            <?php endif; ?>

                            <?php if ($contact_info['address']) : ?>
                                <span class="footer-contact-item">
                                    <?php echo esc_html($contact_info['address']); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .footer-info -->

                <div class="footer-navigation">
                    <?php
                    if (has_nav_menu('footer')) :
                        wp_nav_menu([
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                        ]);
                    endif;
                    ?>

                    <?php if (has_nav_menu('social')) : ?>
                        <div class="footer-social">
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
                </div><!-- .footer-navigation -->
            </div><!-- .footer-bottom-container -->
        </div><!-- .footer-bottom -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>