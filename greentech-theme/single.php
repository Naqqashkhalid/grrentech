<?php
/**
 * The template for displaying all single posts
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

get_header();
?>

<main id="primary" class="site-main">
    <div class="main-content">
        <?php
        while (have_posts()) :
            the_post();
            
            get_template_part('template-parts/content', get_post_type());
            
            // Post navigation
            the_post_navigation([
                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'greentech') . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'greentech') . '</span> <span class="nav-title">%title</span>',
            ]);
            
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            
        endwhile; // End of the loop.
        ?>
    </div><!-- .main-content -->

    <?php get_sidebar(); ?>
</main><!-- #primary -->

<?php
get_footer();