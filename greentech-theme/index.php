<?php
/**
 * The main template file
 * 
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

get_header();
?>

<main id="primary" class="site-main">
    <div class="main-content">
        <?php if (have_posts()) : ?>
            
            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div class="posts-container <?php echo 'layout-' . get_theme_mod('blog_layout', 'grid'); ?> columns-<?php echo get_theme_mod('blog_columns', 3); ?>">
                <?php
                // Start the Loop
                while (have_posts()) :
                    the_post();
                    
                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_type());
                    
                endwhile;
                ?>
            </div><!-- .posts-container -->

            <?php
            // Display pagination
            greentech_pagination();
            
        else :
            
            get_template_part('template-parts/content', 'none');
            
        endif;
        ?>
    </div><!-- .main-content -->

    <?php get_sidebar(); ?>
</main><!-- #primary -->

<?php
get_footer();