<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage TravelBlogger
 * @since TravelBlogger Theme 1.0
 */

get_header(); ?>

	<div id="content">
		<div id="search">
			<p class="entry-title"><?php _e( 'Oups', 'ludovic' ); ?></p>
			<div class="entry-content">
				<p><?php _e( 'La page que vous cherchez n\'existe pas.', 'ludovic' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div>
	</div><!-- #post-0 -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>