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
    <section id="hero" class="hero section fade-in">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">
                    <?php echo esc_html(get_theme_mod('hero_title', __('Build Your Digital Future with GreenTech', 'greentech'))); ?>
                </h1>
                <p class="lead hero-subtitle">
                    <?php echo esc_html(get_theme_mod('hero_subtitle', __('Professional web development, hosting, and digital marketing services for modern businesses.', 'greentech'))); ?>
                </p>
                <div class="btn-group hero-buttons">
                    <a href="<?php echo esc_url(get_theme_mod('hero_button_url', '#contact')); ?>" class="btn btn-primary btn-lg">
                        <?php echo esc_html(get_theme_mod('hero_button_text', __('Get Started', 'greentech'))); ?>
                    </a>
                    <a href="<?php echo esc_url(get_theme_mod('hero_button_2_url', '#services')); ?>" class="btn btn-outline btn-lg">
                        <?php echo esc_html(get_theme_mod('hero_button_2_text', __('Our Services', 'greentech'))); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title fade-in"><?php _e('Our Services', 'greentech'); ?></h2>
                <p class="section-description fade-in">
                    <?php _e('We provide comprehensive digital solutions to help your business thrive in the modern world.', 'greentech'); ?>
                </p>
            </div>
            
            <div class="services-grid">
                <?php 
                $services = \GreenTech\greentech_get_services();
                foreach ($services as $index => $service) : 
                    $delay = $index * 0.1;
                ?>
                    <div class="service-card fade-in" style="animation-delay: <?php echo $delay; ?>s;">
                        <div class="service-icon"><?php echo $service['icon']; ?></div>
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['description']); ?></p>
                        
                        <?php if (!empty($service['services'])) : ?>
                            <ul class="service-list">
                                <?php foreach ($service['services'] as $sub_service) : ?>
                                    <li><?php echo esc_html($sub_service); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        
                        <a href="<?php echo home_url('/services#' . $service['category']); ?>" class="btn btn-outline">
                            <?php _e('Learn More', 'greentech'); ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title fade-in"><?php _e('Our Portfolio', 'greentech'); ?></h2>
                <p class="section-description fade-in">
                    <?php _e('Explore our recent projects and see how we\'ve helped businesses achieve their goals.', 'greentech'); ?>
                </p>
            </div>
            
            <!-- Portfolio Filters -->
            <div class="portfolio-filters text-center fade-in">
                <button class="filter-btn active" data-filter="all"><?php _e('All Projects', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="web-development"><?php _e('Web Development', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="e-commerce"><?php _e('E-Commerce', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="design"><?php _e('Design', 'greentech'); ?></button>
                <button class="filter-btn" data-filter="marketing"><?php _e('Marketing', 'greentech'); ?></button>
            </div>
            
            <!-- Portfolio Grid -->
            <div class="portfolio-grid" id="portfolio-grid">
                <?php 
                $portfolio = \GreenTech\greentech_get_portfolio();
                foreach ($portfolio as $index => $project) : 
                    $delay = $index * 0.1;
                ?>
                    <article class="portfolio-item scale-in" data-category="<?php echo esc_attr($project['category']); ?>" style="animation-delay: <?php echo $delay; ?>s;">
                        <div class="portfolio-image">
                            <img src="<?php echo esc_url($project['image']); ?>" alt="<?php echo esc_attr($project['title']); ?>" loading="lazy">
                            <div class="portfolio-overlay">
                                <div class="overlay-content">
                                    <h3><?php echo esc_html($project['title']); ?></h3>
                                    <p><?php echo esc_html($project['description']); ?></p>
                                    <a href="<?php echo esc_url($project['url']); ?>" class="btn btn-outline btn-sm">
                                        <?php _e('View Project', 'greentech'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <h3><?php echo esc_html($project['title']); ?></h3>
                            <p><?php echo esc_html($project['description']); ?></p>
                            
                            <?php if (!empty($project['tags'])) : ?>
                                <div class="portfolio-tags">
                                    <?php foreach ($project['tags'] as $tag) : ?>
                                        <span class="portfolio-tag"><?php echo esc_html($tag); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?php echo home_url('/portfolio'); ?>" class="btn btn-primary btn-lg">
                    <?php _e('View All Projects', 'greentech'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title fade-in"><?php _e('What Our Clients Say', 'greentech'); ?></h2>
                <p class="section-description fade-in">
                    <?php _e('Don\'t just take our word for it. Here\'s what our satisfied clients have to say about our services.', 'greentech'); ?>
                </p>
            </div>
            
            <div class="testimonials-carousel fade-in" id="testimonials-carousel">
                <?php 
                $testimonials = \GreenTech\greentech_get_testimonials();
                foreach ($testimonials as $index => $testimonial) : 
                    $active_class = $index === 0 ? 'active' : '';
                ?>
                    <div class="testimonial-item <?php echo $active_class; ?>">
                        <div class="testimonial-content">
                            <?php echo esc_html($testimonial['content']); ?>
                        </div>
                        <div class="testimonial-author">
                            <img src="<?php echo esc_url($testimonial['avatar']); ?>" alt="<?php echo esc_attr($testimonial['author']); ?>" class="testimonial-avatar" loading="lazy">
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
    <section id="technologies" class="tech-logos section-sm">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title fade-in"><?php _e('Technologies We Work With', 'greentech'); ?></h2>
                <p class="section-description fade-in">
                    <?php _e('We use cutting-edge technologies and platforms to deliver exceptional results.', 'greentech'); ?>
                </p>
            </div>
            
            <div class="tech-grid">
                <?php 
                $technologies = \GreenTech\greentech_get_technologies();
                foreach ($technologies as $index => $tech) : 
                    $delay = $index * 0.05;
                ?>
                    <div class="tech-logo scale-in" style="animation-delay: <?php echo $delay; ?>s;">
                        <img src="<?php echo esc_url($tech['logo']); ?>" alt="<?php echo esc_attr($tech['name']); ?>" loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact CTA Section -->
    <section id="contact" class="cta-section bg-primary section">
        <div class="container">
            <div class="cta-content text-center fade-in">
                <h2 class="cta-title"><?php _e('Ready to Start Your Project?', 'greentech'); ?></h2>
                <p class="cta-description">
                    <?php _e('Contact us today to discuss your web development, hosting, or digital marketing needs. Let\'s build something amazing together.', 'greentech'); ?>
                </p>
                
                <!-- Contact Information Display -->
                <div class="contact-info-grid">
                    <?php 
                    $contact = \GreenTech\greentech_get_contact_info();
                    ?>
                    
                    <?php if ($contact['phone']) : ?>
                        <div class="contact-item">
                            <div class="contact-icon">📞</div>
                            <div class="contact-details">
                                <h4><?php _e('Call Us', 'greentech'); ?></h4>
                                <a href="tel:<?php echo esc_attr($contact['phone']); ?>"><?php echo esc_html($contact['phone']); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($contact['email']) : ?>
                        <div class="contact-item">
                            <div class="contact-icon">✉️</div>
                            <div class="contact-details">
                                <h4><?php _e('Email Us', 'greentech'); ?></h4>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>"><?php echo esc_html($contact['email']); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($contact['address']) : ?>
                        <div class="contact-item">
                            <div class="contact-icon">📍</div>
                            <div class="contact-details">
                                <h4><?php _e('Visit Us', 'greentech'); ?></h4>
                                <p><?php echo esc_html($contact['address']); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="btn-group mt-12">
                    <a href="<?php echo esc_url($contact['email'] ? 'mailto:' . $contact['email'] : '#'); ?>" class="btn btn-lg btn-outline">
                        <?php _e('Send Email', 'greentech'); ?>
                    </a>
                    <a href="<?php echo esc_url($contact['phone'] ? 'tel:' . $contact['phone'] : '#'); ?>" class="btn btn-lg btn-primary">
                        <?php _e('Call Now', 'greentech'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Blog Posts -->
    <?php 
    $recent_posts = get_posts([
        'posts_per_page' => 3,
        'post_status' => 'publish'
    ]);
    
    if ($recent_posts) : ?>
        <section id="blog" class="blog-section section">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-title fade-in"><?php _e('Latest from Our Blog', 'greentech'); ?></h2>
                    <p class="section-description fade-in">
                        <?php _e('Stay updated with the latest trends, tips, and insights from the world of web development and digital marketing.', 'greentech'); ?>
                    </p>
                </div>
                
                <div class="blog-grid">
                    <?php 
                    foreach ($recent_posts as $index => $post) : 
                        setup_postdata($post);
                        $delay = $index * 0.1;
                    ?>
                        <article class="blog-card fade-in" style="animation-delay: <?php echo $delay; ?>s;">
                            <?php if (has_post_thumbnail($post->ID)) : ?>
                                <div class="blog-image">
                                    <a href="<?php echo get_permalink($post->ID); ?>">
                                        <?php echo get_the_post_thumbnail($post->ID, 'greentech-blog'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <time datetime="<?php echo get_the_date('c', $post->ID); ?>"><?php echo get_the_date('', $post->ID); ?></time>
                                    <span class="blog-category">
                                        <?php 
                                        $categories = get_the_category($post->ID);
                                        if ($categories) {
                                            echo esc_html($categories[0]->name);
                                        }
                                        ?>
                                    </span>
                                </div>
                                
                                <h3><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h3>
                                <p><?php echo wp_trim_words(get_the_excerpt($post->ID), 20); ?></p>
                                
                                <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-outline btn-sm">
                                    <?php _e('Read More', 'greentech'); ?>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
                
                <div class="text-center mt-12">
                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn btn-primary btn-lg">
                        <?php _e('View All Posts', 'greentech'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

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