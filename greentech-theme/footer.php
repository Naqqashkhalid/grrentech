    </main><!-- #main -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">
            
            <!-- Main Footer Content -->
            <div class="footer-content">
                
                <!-- Company Information -->
                <div class="footer-section footer-about">
                    <h3><?php bloginfo('name'); ?></h3>
                    <p><?php echo esc_html(get_theme_mod('footer_description', __('Professional web development, hosting, and digital marketing services for modern businesses.', 'greentech'))); ?></p>
                    
                    <!-- Contact Info -->
                    <?php 
                    $contact = \GreenTech\greentech_get_contact_info();
                    if ($contact['address'] || $contact['phone'] || $contact['email']) : ?>
                        <div class="footer-contact">
                            <?php if ($contact['address']) : ?>
                                <div class="contact-item">
                                    <span class="contact-icon">📍</span>
                                    <span><?php echo esc_html($contact['address']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($contact['phone']) : ?>
                                <div class="contact-item">
                                    <span class="contact-icon">📞</span>
                                    <a href="tel:<?php echo esc_attr($contact['phone']); ?>"><?php echo esc_html($contact['phone']); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($contact['email']) : ?>
                                <div class="contact-item">
                                    <span class="contact-icon">✉️</span>
                                    <a href="mailto:<?php echo esc_attr($contact['email']); ?>"><?php echo esc_html($contact['email']); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Social Links -->
                    <?php \GreenTech\Navigation::render_social_nav(); ?>
                </div>

                <!-- Services Links -->
                <div class="footer-section footer-services">
                    <h3><?php _e('Our Services', 'greentech'); ?></h3>
                    <ul class="footer-menu">
                        <li><a href="<?php echo home_url('#services'); ?>"><?php _e('Web Development', 'greentech'); ?></a></li>
                        <li><a href="<?php echo home_url('#services'); ?>"><?php _e('E-Commerce Development', 'greentech'); ?></a></li>
                        <li><a href="<?php echo home_url('#services'); ?>"><?php _e('Digital Marketing', 'greentech'); ?></a></li>
                        <li><a href="<?php echo home_url('#services'); ?>"><?php _e('Graphic Design', 'greentech'); ?></a></li>
                        <li><a href="<?php echo home_url('#services'); ?>"><?php _e('SEO Services', 'greentech'); ?></a></li>
                        <li><a href="<?php echo home_url('#services'); ?>"><?php _e('Hosting & Cloud', 'greentech'); ?></a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="footer-section footer-links">
                    <h3><?php _e('Quick Links', 'greentech'); ?></h3>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class' => 'footer-menu',
                        'container' => false,
                        'depth' => 1,
                        'fallback_cb' => function() {
                            echo '<ul class="footer-menu">';
                            echo '<li><a href="' . home_url() . '">' . __('Home', 'greentech') . '</a></li>';
                            echo '<li><a href="' . home_url('#about') . '">' . __('About Us', 'greentech') . '</a></li>';
                            echo '<li><a href="' . home_url('#portfolio') . '">' . __('Portfolio', 'greentech') . '</a></li>';
                            echo '<li><a href="' . home_url('#contact') . '">' . __('Contact', 'greentech') . '</a></li>';
                            echo '<li><a href="' . home_url('/blog') . '">' . __('Blog', 'greentech') . '</a></li>';
                            echo '<li><a href="' . home_url('/privacy-policy') . '">' . __('Privacy Policy', 'greentech') . '</a></li>';
                            echo '</ul>';
                        }
                    ]);
                    ?>
                </div>

                <!-- Newsletter Signup -->
                <div class="footer-section footer-newsletter">
                    <h3><?php _e('Stay Updated', 'greentech'); ?></h3>
                    <p><?php _e('Subscribe to our newsletter for the latest updates and insights.', 'greentech'); ?></p>
                    
                    <form class="newsletter-form" method="post" action="#" aria-label="<?php _e('Newsletter Signup', 'greentech'); ?>">
                        <div class="form-group">
                            <input type="email" name="newsletter_email" placeholder="<?php _e('Your email address', 'greentech'); ?>" required aria-label="<?php _e('Email address', 'greentech'); ?>">
                            <button type="submit" class="btn btn-primary" aria-label="<?php _e('Subscribe to newsletter', 'greentech'); ?>">
                                <?php _e('Subscribe', 'greentech'); ?>
                            </button>
                        </div>
                        <?php wp_nonce_field('newsletter_signup', 'newsletter_nonce'); ?>
                    </form>
                </div>

            </div>

            <!-- Footer Widgets -->
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
                <div class="footer-widgets">
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-1')) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar('footer-1'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-2')) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar('footer-2'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-3')) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar('footer-3'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-4')) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar('footer-4'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'greentech'); ?></p>
                    </div>
                    
                    <div class="footer-credits">
                        <p>
                            <?php 
                            printf(
                                __('Designed & Developed by %s', 'greentech'),
                                '<a href="' . esc_url($contact['website'] ? 'https://' . $contact['website'] : home_url()) . '" target="_blank" rel="noopener">' . __('GreenTech', 'greentech') . '</a>'
                            );
                            ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top" aria-label="<?php _e('Back to top', 'greentech'); ?>" style="display: none;">
    <span class="screen-reader-text"><?php _e('Back to top', 'greentech'); ?></span>
    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z"/>
    </svg>
</button>

<?php wp_footer(); ?>

<!-- Structured Data for Organization -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "<?php bloginfo('name'); ?>",
    "description": "<?php bloginfo('description'); ?>",
    "url": "<?php echo home_url(); ?>",
    <?php if (has_custom_logo()) : ?>
    "logo": "<?php echo wp_get_attachment_url(get_theme_mod('custom_logo')); ?>",
    <?php endif; ?>
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?php echo esc_js($contact['address']); ?>",
        "addressLocality": "Jhelum",
        "addressCountry": "PK"
    },
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "<?php echo esc_js($contact['phone']); ?>",
        "contactType": "customer support",
        "email": "<?php echo esc_js($contact['email']); ?>"
    },
    "sameAs": [
        <?php
        $social_networks = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
        $social_urls = [];
        foreach ($social_networks as $network) {
            $url = get_theme_mod("social_{$network}", '');
            if ($url) {
                $social_urls[] = '"' . esc_js($url) . '"';
            }
        }
        echo implode(',', $social_urls);
        ?>
    ]
}
</script>

</body>
</html>