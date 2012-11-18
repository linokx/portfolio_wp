<?php get_header(); ?>
<h1><a href="<?php bloginfo('wpurl'); ?>"><?php bloginfo('name'); ?></a></h1>
<?php if(have_posts()): ?>
<?php while(have_posts()): the_post(); ?>
	<h2><?php the_title(); ?></h2>
	<h3>
		<?php _e('Posté par'); ?> <?php the_author(); ?>
		<?php _e('le'); ?> <?php echo get_the_date(); ?>
	</h3>
	<div class="content">
		<?php get_template_part('content','single'); ?>
	</div>
<?php endwhile; ?>
<?php endif; ?>
<?php comments_template(); ?>
<?php get_footer();?>