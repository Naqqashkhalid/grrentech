<?php
/**
 * The template for displaying search results pages
 *
 * @package GreenTech
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        printf(
                            __('Search Results for: %s', 'greentech'),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                </header>

                <?php if (have_posts()) : ?>
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
                                        <?php if (has_category()) : ?>
                                            <span class="cat-links">
                                                <?php _e('in', 'greentech'); ?> <?php the_category(', '); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </header>
                                
                                <div class="entry-summary">
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
                            <h1 class="page-title"><?php _e('Nothing found', 'greentech'); ?></h1>
                        </header>
                        <div class="page-content">
                            <p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'greentech'); ?></p>
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

<?php get_footer(); ?>