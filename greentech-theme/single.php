<?php
/**
 * The template for displaying all single posts
 *
 * @package GreenTech
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="entry-meta">
                                <span class="posted-on">
                                    <?php _e('Posted on', 'greentech'); ?> 
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </a>
                                </span>
                                <span class="byline">
                                    <?php _e('by', 'greentech'); ?> 
                                    <span class="author vcard">
                                        <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                            <?php the_author(); ?>
                                        </a>
                                    </span>
                                </span>
                                <?php if (has_category()) : ?>
                                    <span class="cat-links">
                                        <?php _e('in', 'greentech'); ?> <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="entry-thumbnail">
                                <?php the_post_thumbnail('greentech-hero'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php
                            the_content();
                            
                            wp_link_pages([
                                'before' => '<div class="page-links">' . __('Pages:', 'greentech'),
                                'after' => '</div>',
                            ]);
                            ?>
                        </div>

                        <footer class="entry-footer">
                            <?php if (has_tag()) : ?>
                                <div class="tag-links">
                                    <strong><?php _e('Tags:', 'greentech'); ?></strong>
                                    <?php the_tags('', ', ', ''); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (get_edit_post_link()) : ?>
                                <div class="edit-link">
                                    <?php edit_post_link(__('Edit', 'greentech'), '<span class="edit-link">', '</span>'); ?>
                                </div>
                            <?php endif; ?>
                        </footer>
                    </article>

                    <?php
                    // Previous/next post navigation
                    the_post_navigation([
                        'prev_text' => __('← Previous Post', 'greentech'),
                        'next_text' => __('Next Post →', 'greentech'),
                    ]);

                    // Author bio
                    if (get_the_author_meta('description')) : ?>
                        <div class="author-bio service-card">
                            <div class="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                            </div>
                            <div class="author-info">
                                <h3 class="author-name"><?php the_author(); ?></h3>
                                <p class="author-description"><?php the_author_meta('description'); ?></p>
                            </div>
                        </div>
                    <?php endif;

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                <?php endwhile; ?>
            </div>

            <div class="col-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>