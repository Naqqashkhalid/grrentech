<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package GreenTech
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="error-404 not-found text-center">
                    <header class="page-header">
                        <h1 class="page-title"><?php _e('404', 'greentech'); ?></h1>
                        <h2><?php _e('Oops! That page can&rsquo;t be found.', 'greentech'); ?></h2>
                    </header>

                    <div class="page-content">
                        <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'greentech'); ?></p>

                        <?php get_search_form(); ?>

                        <div class="row mt-5">
                            <div class="col-6">
                                <div class="widget">
                                    <h3 class="widget-title"><?php _e('Most Used Categories', 'greentech'); ?></h3>
                                    <ul>
                                        <?php
                                        wp_list_categories([
                                            'orderby' => 'count',
                                            'order' => 'DESC',
                                            'show_count' => 1,
                                            'title_li' => '',
                                            'number' => 10,
                                        ]);
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="widget">
                                    <h3 class="widget-title"><?php _e('Recent Posts', 'greentech'); ?></h3>
                                    <ul>
                                        <?php
                                        $recent_posts = wp_get_recent_posts([
                                            'numberposts' => 5,
                                            'post_status' => 'publish',
                                        ]);
                                        
                                        foreach ($recent_posts as $post) : ?>
                                            <li>
                                                <a href="<?php echo get_permalink($post['ID']); ?>">
                                                    <?php echo $post['post_title']; ?>
                                                </a>
                                            </li>
                                        <?php endforeach;
                                        wp_reset_postdata();
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h3><?php _e('Try these popular pages:', 'greentech'); ?></h3>
                            <div class="error-404-links">
                                <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                                    <?php _e('Home', 'greentech'); ?>
                                </a>
                                <a href="<?php echo home_url('#services'); ?>" class="btn btn-outline">
                                    <?php _e('Services', 'greentech'); ?>
                                </a>
                                <a href="<?php echo home_url('#portfolio'); ?>" class="btn btn-outline">
                                    <?php _e('Portfolio', 'greentech'); ?>
                                </a>
                                <a href="<?php echo home_url('#contact'); ?>" class="btn btn-outline">
                                    <?php _e('Contact', 'greentech'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>