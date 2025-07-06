<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
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

                        <?php if (get_edit_post_link()) : ?>
                            <footer class="entry-footer">
                                <?php edit_post_link(__('Edit', 'greentech'), '<span class="edit-link">', '</span>'); ?>
                            </footer>
                        <?php endif; ?>
                    </article>

                    <?php
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