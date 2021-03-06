<?php
/**
 * Template Name: One Column No Sidebar
 *
 * A custom page template without sidebars.
 *
 *
 * @package WordPress
 * @subpackage TravelBlogger
 * @since TravelBlogger Theme 1.0
 */

get_header(); ?>

	<div id="yui-main">
	   <div id="content" class="yui-b hfeed rounded">
		 
		 <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		 
		 				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		 					<h1 class="entry-title"><?php the_title(); ?></h1>
		 					<div class="entry-content">
		 						<?php the_content(); ?>
		 						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'travelblogger' ), 'after' => '</div>' ) ); ?>
		 						<?php edit_post_link( __( 'Edit', 'travelblogger' ), '<span class="edit-link">', '</span>' ); ?>
		 					</div><!-- .entry-content -->
		 				</div><!-- #post-## -->
		 
		 				<?php comments_template( '', true ); ?>
		 
		 <?php endwhile; ?>
		 			
	   </div><!--yui-b-main-->
	</div><!--yui-main-->

<?php get_footer(); ?>
