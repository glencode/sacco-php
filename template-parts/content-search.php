<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-4 p-3 border rounded search-result-item'); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title h5"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta small text-muted">
			<?php
			sacco_php_posted_on();
			sacco_php_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php the_post_thumbnail(); ?>

	<div class="entry-summary small mt-2">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer small mt-2">
		<?php sacco_php_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
