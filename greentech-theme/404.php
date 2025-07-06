<?php
/**
 * The template for displaying 404 pages (not found)
 * 
 * @package GreenTech
 * @since 1.0.0
 */

namespace GreenTech;

get_header();
?>

<main id="primary" class="site-main">
    <div class="main-content">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'greentech'); ?></h1>
            </header><!-- .page-header -->

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'greentech'); ?></p>

                <?php get_search_form(); ?>

                <div class="error-404-content">
                    <div class="widget-area">
                        <div class="widget">
                            <h2 class="widget-title"><?php esc_html_e('Most Used Categories', 'greentech'); ?></h2>
                            <ul>
                                <?php
                                wp_list_categories([
                                    'orderby'    => 'count',
                                    'order'      => 'DESC',
                                    'show_count' => 1,
                                    'title_li'   => '',
                                    'number'     => 10,
                                ]);
                                ?>
                            </ul>
                        </div><!-- .widget -->

                        <?php
                        // Only show the widget if site has multiple published authors.
                        if (is_multi_author()) :
                            ?>
                            <div class="widget">
                                <h2 class="widget-title"><?php esc_html_e('Try looking in the monthly archives.', 'greentech'); ?></h2>
                                <ol>
                                    <?php
                                    wp_get_archives([
                                        'type'  => 'monthly',
                                        'limit' => 12,
                                    ]);
                                    ?>
                                </ol>
                            </div><!-- .widget -->
                        <?php endif; ?>
                    </div><!-- .widget-area -->
                </div><!-- .error-404-content -->
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </div><!-- .main-content -->
</main><!-- #primary -->

<?php
get_footer();