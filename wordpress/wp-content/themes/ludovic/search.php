<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage TravelBlogger
 * @since TravelBlogger Theme 1.0
 */

get_header(); ?>

	<div id="content">
	   <div id="search">
				<?php if ( have_posts() ) : ?>
						<h2 class="page-title"><?php printf( __( 'Résultat de la recherche pour: %s', 'ludovic' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
						<?php
						/* Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called loop-search.php and that will be used instead.
						 */
						 get_template_part( 'loop', 'search' );
						?>
				<?php else : ?>
							<h2 class="entry-title"><?php _e( 'Nothing Found', 'travelblogger' ); ?></h2>
								<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'travelblogger' ); ?></p>
								<?php get_search_form(); ?>
				<?php endif; ?>
	   </div><!--yui-b-main-->
	</div><!--yui-main-->

<?php get_footer(); ?>
