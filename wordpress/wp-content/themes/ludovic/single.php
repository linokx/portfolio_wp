<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage TravelBlogger
 * @since TravelBlogger Theme 1.0
 */

get_header(); ?>

<section id="content">

<article id="article">


		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>	
		
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<h2 class="entry-title"><?php the_title(); ?></h2>
		
							<div class="entry-meta">
								<p>Posté le <?php the_date('d M. Y'); ?></p>
							</div><!-- .entry-meta -->
		
							<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'travelblogger' ), 'after' => '</div>' ) ); ?>
							</div><!-- .entry-content -->
							
							
		
		<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
							<div id="entry-author-info">
								<div id="author-avatar">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'travelblogger_author_bio_avatar_size', 60 ) ); ?>
								</div><!-- #author-avatar -->
								<div id="author-description">
									<h2><?php printf( esc_attr__( 'About %s', 'travelblogger' ), get_the_author() ); ?></h2>
									<?php the_author_meta( 'description' ); ?>
									<div id="author-link">
										<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
											<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'travelblogger' ), get_the_author() ); ?>
										</a>
									</div><!-- #author-link	-->
								</div><!-- #author-description -->
							</div><!-- #entry-author-info -->
		<?php endif; ?>
		
							<?php /*<div class="entry-utility">
								<p>Catégorie: <?php the_category(','); ?></p>
								<?php //travelblogger_posted_in(); ?>
								<?php edit_post_link( __( 'Edit', 'travelblogger' ), '<span class="edit-link">', '</span>' ); ?>
							</div><!-- .entry-utility -->
						</div><!-- #post-## --> */?>
						
					<div class="nav-outter clearfix">
						<div id="nav-below" class="navigation clearfix">
							<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'travelblogger' ) . '</span> %title' ); ?></div>
							<a href="../blog" title="Revenir au blog">Retour</a>
							<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'travelblogger' ) . '</span>' ); ?></div>
						</div><!-- #nav-below -->
					</div><!-- .nav-outter -->
						<?php //comments_template( '', true ); ?>
		
		<?php endwhile; // end of the loop. ?>



			</div><!-- /.main-content -->
	  </article>
	</section>
<?php get_footer(); ?>