<?php
/**
 * The template for displaying all pages
 * 
 * This is the template that displays all pages by default.
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
            
            get_template_part('template-parts/content', 'page');
            
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            
        endwhile; // End of the loop.
        ?>
    </div><!-- .main-content -->
</main><!-- #primary -->

<?php
get_footer();