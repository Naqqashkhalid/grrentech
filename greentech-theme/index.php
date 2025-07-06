<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and is used to display a page when nothing more specific matches a query.
 *
 * @package GreenTech
 */

get_header(); ?>

<?php if (is_front_page() || is_home()) : ?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-content text-center">
                        <h1 class="fade-in"><?php echo get_theme_mod('hero_title', 'Build Your Digital Future with GreenTech'); ?></h1>
                        <p class="lead fade-in"><?php echo get_theme_mod('hero_subtitle', 'Professional web development, hosting, and digital marketing services for modern businesses.'); ?></p>
                        <div class="hero-buttons fade-in">
                            <a href="<?php echo get_theme_mod('hero_button_url', '#contact'); ?>" class="btn btn-primary btn-large">
                                <?php echo get_theme_mod('hero_button_text', 'Get Started'); ?>
                            </a>
                            <a href="#services" class="btn btn-outline btn-large">
                                <?php _e('Our Services', 'greentech'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('Our Services', 'greentech'); ?></h2>
                    <p class="lead fade-in"><?php _e('Comprehensive digital solutions to help your business thrive in the modern world.', 'greentech'); ?></p>
                </div>
            </div>
            <div class="services-grid">
                <?php foreach (greentech_get_services() as $service) : ?>
                    <div class="service-card scale-in">
                        <div class="service-icon">
                            <?php echo $service['icon']; ?>
                        </div>
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['description']); ?></p>
                        <ul class="service-list">
                            <?php foreach ($service['services'] as $item) : ?>
                                <li><?php echo esc_html($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('Our Portfolio', 'greentech'); ?></h2>
                    <p class="lead fade-in"><?php _e('Showcasing our latest projects and success stories.', 'greentech'); ?></p>
                </div>
            </div>
            
            <div class="portfolio-filters">
                <button class="filter-btn active" data-filter="all"><?php _e('All', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="web-development"><?php _e('Web Development', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="e-commerce"><?php _e('E-Commerce', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="mobile-app"><?php _e('Mobile Apps', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="design"><?php _e('Design', 'greentech'); ?></button>
            </div>
            
            <div class="portfolio-grid">
                <?php foreach (greentech_get_portfolio() as $item) : ?>
                    <div class="portfolio-item fade-in" data-category="<?php echo esc_attr($item['category']); ?>">
                        <div class="portfolio-image">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                            <div class="portfolio-overlay">
                                <a href="<?php echo esc_url($item['image']); ?>" class="btn btn-primary">
                                    <?php _e('View Project', 'greentech'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['description']); ?></p>
                            <div class="portfolio-tags">
                                <?php foreach ($item['tags'] as $tag) : ?>
                                    <span class="portfolio-tag"><?php echo esc_html($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('What Our Clients Say', 'greentech'); ?></h2>
                    <p class="lead fade-in"><?php _e('Hear from businesses that have transformed their digital presence with us.', 'greentech'); ?></p>
                </div>
            </div>
            
            <div class="testimonials-carousel">
                <?php $testimonials = greentech_get_testimonials(); ?>
                <?php foreach ($testimonials as $index => $testimonial) : ?>
                    <div class="testimonial-item <?php echo $index === 0 ? 'active' : ''; ?> fade-in">
                        <div class="testimonial-content">
                            <p>"<?php echo esc_html($testimonial['content']); ?>"</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="<?php echo esc_url($testimonial['avatar']); ?>" alt="<?php echo esc_attr($testimonial['author']); ?>" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4><?php echo esc_html($testimonial['author']); ?></h4>
                                <p><?php echo esc_html($testimonial['position']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Technology Logos Section -->
    <section class="tech-logos section-sm">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('Technologies We Work With', 'greentech'); ?></h2>
                </div>
            </div>
            <div class="tech-grid">
                <?php foreach (greentech_get_technologies() as $tech) : ?>
                    <div class="tech-logo fade-in">
                        <img src="<?php echo esc_url($tech['logo']); ?>" alt="<?php echo esc_attr($tech['name']); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact CTA Section -->
    <section id="contact" class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('Ready to Start Your Project?', 'greentech'); ?></h2>
                    <p class="lead fade-in"><?php _e('Let\'s discuss how we can help you achieve your digital goals.', 'greentech'); ?></p>
                    <div class="fade-in">
                        <a href="mailto:<?php echo get_theme_mod('contact_email', 'inquiry@greentech.guru'); ?>" class="btn btn-primary btn-large">
                            <?php _e('Get Free Quote', 'greentech'); ?>
                        </a>
                        <a href="tel:<?php echo get_theme_mod('contact_phone', '0544-277588'); ?>" class="btn btn-outline btn-large">
                            <?php _e('Call Us Now', 'greentech'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Blog Posts -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fade-in"><?php _e('Latest from Our Blog', 'greentech'); ?></h2>
                    <p class="lead fade-in"><?php _e('Stay updated with the latest trends and insights from our team.', 'greentech'); ?></p>
                </div>
            </div>
            <div class="row">
                <?php 
                $recent_posts = new WP_Query([
                    'posts_per_page' => 3,
                    'post_status' => 'publish'
                ]);
                
                if ($recent_posts->have_posts()) : 
                    while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <div class="col-4">
                            <article class="service-card fade-in">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="portfolio-image">
                                        <?php the_post_thumbnail('greentech-portfolio'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="portfolio-content">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                        <?php _e('Read More', 'greentech'); ?>
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; 
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>
    </section>

<?php else : ?>
    <!-- Regular Blog Index -->
    <main id="primary" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <?php if (have_posts()) : ?>
                        <header class="page-header">
                            <?php if (is_home() && !is_front_page()) : ?>
                                <h1 class="page-title"><?php single_post_title(); ?></h1>
                            <?php else : ?>
                                <h1 class="page-title"><?php _e('Blog', 'greentech'); ?></h1>
                            <?php endif; ?>
                        </header>

                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('service-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="portfolio-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('greentech-portfolio'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="portfolio-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                        </h2>
                                        <div class="entry-meta">
                                            <span class="posted-on"><?php echo get_the_date(); ?></span>
                                            <span class="byline"><?php _e('by', 'greentech'); ?> <?php the_author(); ?></span>
                                        </div>
                                    </header>
                                    
                                    <div class="entry-content">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <footer class="entry-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                            <?php _e('Read More', 'greentech'); ?>
                                        </a>
                                    </footer>
                                </div>
                            </article>
                        <?php endwhile; ?>
                        
                        <?php greentech_pagination(); ?>
                        
                    <?php else : ?>
                        <section class="no-results not-found">
                            <header class="page-header">
                                <h1 class="page-title"><?php _e('Nothing here', 'greentech'); ?></h1>
                            </header>
                            <div class="page-content">
                                <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'greentech'); ?></p>
                                <?php get_search_form(); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
                
                <div class="col-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </main>
<?php endif; ?>

<?php get_footer(); ?>