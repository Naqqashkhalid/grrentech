<?php
/**
 * Template Name: Services Page
 * 
 * The template for displaying the services page
 *
 * @package GreenTech
 */

get_header(); ?>

<main id="primary" class="site-main services-page">
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-content text-center">
                        <h1 class="fade-in"><?php _e('Our Services', 'greentech'); ?></h1>
                        <p class="lead fade-in"><?php _e('Comprehensive digital solutions to help your business thrive in the modern world.', 'greentech'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Details Section -->
    <section class="services section">
        <div class="container">
            <?php foreach (greentech_get_services() as $index => $service) : ?>
                <div class="service-detail <?php echo $index % 2 === 0 ? 'row' : 'row row-reverse'; ?>">
                    <div class="col-6">
                        <div class="service-content fade-in">
                            <div class="service-icon-large">
                                <?php echo $service['icon']; ?>
                            </div>
                            <h2><?php echo esc_html($service['title']); ?></h2>
                            <p class="lead"><?php echo esc_html($service['description']); ?></p>
                            
                            <div class="service-features">
                                <h3><?php _e('What We Offer:', 'greentech'); ?></h3>
                                <ul class="feature-list">
                                    <?php foreach ($service['services'] as $item) : ?>
                                        <li>
                                            <i class="feature-icon">✓</i>
                                            <?php echo esc_html($item); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div class="service-cta">
                                <a href="#contact" class="btn btn-primary btn-large">
                                    <?php _e('Get Started', 'greentech'); ?>
                                </a>
                                <a href="tel:<?php echo get_theme_mod('contact_phone', '0544-277588'); ?>" class="btn btn-outline btn-large">
                                    <?php _e('Call Us', 'greentech'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="service-image fade-in">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/service-' . ($index + 1) . '.jpg'; ?>" alt="<?php echo esc_attr($service['title']); ?>">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('Our Process', 'greentech'); ?></h2>
                    <p class="lead fade-in"><?php _e('We follow a proven methodology to deliver exceptional results.', 'greentech'); ?></p>
                </div>
            </div>
            
            <div class="process-steps">
                <div class="process-step fade-in">
                    <div class="step-number">1</div>
                    <h3><?php _e('Discovery', 'greentech'); ?></h3>
                    <p><?php _e('We start by understanding your business goals, target audience, and requirements.', 'greentech'); ?></p>
                </div>
                
                <div class="process-step fade-in">
                    <div class="step-number">2</div>
                    <h3><?php _e('Planning', 'greentech'); ?></h3>
                    <p><?php _e('Create detailed project plans, wireframes, and technical specifications.', 'greentech'); ?></p>
                </div>
                
                <div class="process-step fade-in">
                    <div class="step-number">3</div>
                    <h3><?php _e('Development', 'greentech'); ?></h3>
                    <p><?php _e('Build your solution using modern technologies and best practices.', 'greentech'); ?></p>
                </div>
                
                <div class="process-step fade-in">
                    <div class="step-number">4</div>
                    <h3><?php _e('Testing & Launch', 'greentech'); ?></h3>
                    <p><?php _e('Thorough testing, optimization, and successful deployment of your project.', 'greentech'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('Ready to Get Started?', 'greentech'); ?></h2>
                    <p class="lead fade-in"><?php _e('Let\'s discuss your project and create something amazing together.', 'greentech'); ?></p>
                    <div class="fade-in">
                        <a href="mailto:<?php echo get_theme_mod('contact_email', 'inquiry@greentech.guru'); ?>" class="btn btn-primary btn-large">
                            <?php _e('Get Free Quote', 'greentech'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>