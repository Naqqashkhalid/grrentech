<?php
/**
 * Template part for displaying hero section
 * 
 * @package GreenTech
 */

$hero_title = get_theme_mod('hero_title', __('Professional Web Development & Digital Marketing Services', 'greentech'));
$hero_subtitle = get_theme_mod('hero_subtitle', __('Transform your business with our comprehensive web development, hosting, and digital marketing solutions. Based in Jhelum, serving clients worldwide.', 'greentech'));
$hero_primary_button_text = get_theme_mod('hero_primary_button_text', __('Get Started Today', 'greentech'));
$hero_primary_button_url = get_theme_mod('hero_primary_button_url', '#contact');
$hero_secondary_button_text = get_theme_mod('hero_secondary_button_text', __('View Our Work', 'greentech'));
$hero_secondary_button_url = get_theme_mod('hero_secondary_button_url', '#portfolio');
?>

<section class="hero section-lg">
    <div class="container">
        <div class="hero-content text-center fade-in">
            <h1 class="hero-title mb-6"><?php echo esc_html($hero_title); ?></h1>
            <p class="lead mb-8"><?php echo esc_html($hero_subtitle); ?></p>
            <div class="btn-group">
                <a href="<?php echo esc_url($hero_primary_button_url); ?>" class="btn btn-primary btn-lg">
                    <?php echo esc_html($hero_primary_button_text); ?>
                </a>
                <a href="<?php echo esc_url($hero_secondary_button_url); ?>" class="btn btn-outline btn-lg">
                    <?php echo esc_html($hero_secondary_button_text); ?>
                </a>
            </div>
        </div>
    </div>
</section>