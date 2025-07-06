<?php
/**
 * Template part for displaying posts
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail() && !is_single()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail('greentech-featured', [
                    'alt' => the_title_attribute([
                        'echo' => false,
                    ]),
                ]);
                ?>
            </a>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>

        <?php if ('post' === get_post_type()) : ?>
            <div class="entry-meta">
                <?php
                greentech_posted_on();
                greentech_posted_by();
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        if (is_single()) {
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'greentech'),
                        [
                            'span' => [
                                'class' => [],
                            ],
                        ]
                    ),
                    wp_kses_post(get_the_title())
                )
            );

            wp_link_pages([
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'greentech'),
                'after'  => '</div>',
            ]);
        } else {
            if (get_theme_mod('blog_show_excerpt', true)) {
                the_excerpt();
            } else {
                the_content(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'greentech'),
                            [
                                'span' => [
                                    'class' => [],
                                ],
                            ]
                        ),
                        wp_kses_post(get_the_title())
                    )
                );
            }
        }
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php greentech_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->