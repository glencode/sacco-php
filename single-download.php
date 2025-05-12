<?php
/**
 * The template for displaying single Download posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

    <section class="page-header bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="text-muted text-uppercase small mb-2">
                        <?php 
                        $terms = get_the_terms(get_the_ID(), 'resource_type');
                        if ($terms && !is_wp_error($terms)) {
                            $term_links = array();
                            foreach ($terms as $term) {
                                $term_links[] = '<a href="' . esc_url(get_term_link($term)) . '" rel="tag">' . esc_html($term->name) . '</a>';
                            }
                            echo implode(', ', $term_links);
                        } else {
                            esc_html_e('Download', 'sacco-php');
                        }
                        ?>
                    </p>
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php
                    if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">','</p>');
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="download-detail-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('download-single-entry card shadow-sm'); ?>>
                        <div class="card-body p-4 p-md-5">
                            <?php 
                            $file_url = get_post_meta(get_the_ID(), '_download_file_url', true);
                            $file_version = get_post_meta(get_the_ID(), '_file_version', true);
                            $file_publish_date_meta = get_post_meta(get_the_ID(), '_file_publish_date', true);
                            $file_publish_date = $file_publish_date_meta ? date_format(date_create($file_publish_date_meta), 'F j, Y') : get_the_date('F j, Y'); // Fallback to post publish date

                            if ($file_url) :
                            ?>
                                <div class="download-cta text-center mb-4 pb-4 border-bottom">
                                    <a href="<?php echo esc_url($file_url); ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener noreferrer">
                                        <i class="fas fa-download me-2"></i>Download File
                                    </a>
                                    <?php if ($file_version) : ?>
                                        <p class="text-muted mt-2 mb-0">Version: <?php echo esc_html($file_version); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning text-center" role="alert">
                                    Download link not available for this item.
                                </div>
                            <?php endif; ?>

                            <div class="entry-content mb-4">
                                <?php 
                                if (has_excerpt()) {
                                    the_excerpt();
                                    echo '<p><a href="#full-content" class="read-more-toggle">Read more...</a></p>';
                                    echo '<div id="full-content" style="display:none;">';
                                    the_content();
                                    echo '</div>';
                                } else {
                                    the_content(); 
                                }
                                ?>
                            </div>

                            <footer class="entry-footer small text-muted">
                                <p class="mb-1">
                                    <strong>Published:</strong> <?php echo esc_html($file_publish_date); ?><br>
                                </p>
                                <?php
                                $post_tags = get_the_tags();
                                if ($post_tags) {
                                    echo '<p class="mb-0"><strong>Tags:</strong> ';
                                    $tag_links = array();
                                    foreach($post_tags as $tag) {
                                        $tag_links[] = '<a href="' . get_tag_link($tag->term_id) . '" class="badge bg-secondary text-decoration-none me-1">' . $tag->name . '</a>';
                                    }
                                    echo implode(' ', $tag_links);
                                    echo '</p>';
                                }
                                ?>
                            </footer>
                        </div>
                    </article>

                    <div class="related-downloads mt-5">
                        <h3 class_="mb-4 text-center">Other Downloads in this Category</h3>
                        <?php
                        $current_terms = get_the_terms(get_the_ID(), 'resource_type');
                        if ($current_terms && !is_wp_error($current_terms)) {
                            $term_ids = wp_list_pluck($current_terms, 'term_id');
                            $args = array(
                                'post_type' => 'download',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID()),
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'resource_type',
                                        'field'    => 'term_id',
                                        'terms'    => $term_ids,
                                    ),
                                ),
                                'orderby' => 'rand'
                            );
                            $related_query = new WP_Query($args);

                            if ($related_query->have_posts()) :
                                echo '<div class="row gy-4">';
                                while ($related_query->have_posts()) : $related_query->the_post();
                                    get_template_part('template-parts/content/content', 'download-card'); // Assumes a download card template part exists
                                endwhile;
                                echo '</div>';
                                wp_reset_postdata();
                            else :
                                echo '<p class="text-center text-muted">No other related downloads found in this category.</p>';
                            endif;
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer(); 