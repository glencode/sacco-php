<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package sacco-php
 */

if ( ! function_exists( 'sacco_php_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function sacco_php_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'sacco-php' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'sacco_php_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function sacco_php_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'sacco-php' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'sacco_php_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function sacco_php_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'sacco-php' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'sacco-php' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'sacco-php' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'sacco-php' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'sacco-php' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'sacco-php' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'sacco_php_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function sacco_php_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if (!function_exists('sacco_php_display_home_product_card')) {
    /**
     * Displays a product card for the homepage.
     *
     * @param int $post_id The ID of the post (product, loan, or saving).
     * @param string $default_icon Default Font Awesome icon class if no specific icon is found.
     */
    function sacco_php_display_home_product_card($post_id, $default_icon = 'fa-piggy-bank') {
        $title = get_the_title($post_id);
        $permalink = get_permalink($post_id);
        $excerpt = get_the_excerpt($post_id);
        if (empty($excerpt)) {
            $content = get_the_content(null, false, $post_id);
            $excerpt = wp_trim_words($content, 15, '...');
        }
        // You could add a custom field for product-specific icons, e.g., '_product_icon_class'
        $product_icon = get_post_meta($post_id, '_product_icon_class', true) ?: $default_icon;
        $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium_large'); // Or any appropriate image size

        echo '<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">';
        echo '<div class="card product-card-home h-100 shadow-sm border-0 overflow-hidden">';
        
        if ($thumbnail_url) {
            echo '<a href="' . esc_url($permalink) . '" class="product-card-home-img-link">';
            echo '<img src="' . esc_url($thumbnail_url) . '" class="card-img-top product-card-home-img" alt="' . esc_attr($title) . '">';
            echo '</a>';
        } else {
            // Fallback icon if no thumbnail
            echo '<div class="product-card-home-icon-placeholder bg-light d-flex align-items-center justify-content-center" style="height: 200px;">';
            echo '<i class="fas ' . esc_attr($product_icon) . ' fa-3x text-primary"></i>';
            echo '</div>';
        }
        
        echo '<div class="card-body d-flex flex-column p-4">';
        echo '<h3 class="card-title h5"><a href="' . esc_url($permalink) . '" class="text-decoration-none stretched-link">' . esc_html($title) . '</a></h3>';
        if ($excerpt) {
            echo '<p class="card-text small text-muted flex-grow-1">' . esc_html($excerpt) . '</p>';
        }
        // The stretched-link on the title/h3 makes a separate "Learn More" button redundant here for card-style link
        // If you prefer an explicit button, remove stretched-link and uncomment the line below.
        // echo '<a href="' . esc_url($permalink) . '" class="btn btn-sm btn-outline-primary mt-auto align-self-start">Learn More</a>';
        echo '</div>'; // end card-body
        echo '</div>'; // end product-card-home
        echo '</div>'; // end col
    }
}

if ( ! function_exists( 'sacco_php_pagination' ) ) :
	/**
	 * Displays pagination for archive pages.
	 */
	function sacco_php_pagination() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => esc_html__( '&laquo; Previous', 'sacco-php' ),
				'next_text' => esc_html__( 'Next &raquo;', 'sacco-php' ),
				'screen_reader_text' => esc_html__( 'Posts navigation', 'sacco-php' ),
			)
		);
	}
endif;
