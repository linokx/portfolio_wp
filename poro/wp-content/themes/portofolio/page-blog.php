<?php get_header(); ?><section>
<article id="blog">
<?php query_posts('posts_per_page=5'); ?>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
	<div class="content">
	<h2><?php <?php the_title(); ?></h2>
	<span>
		<?php _e('Posté par'); ?> <?php the_author(); ?>
		<?php _e('le'); ?> <?php echo get_the_date(); ?>
	</span><?php the_content(); ?></div>
	<hr />
<?php endwhile; ?>
<?php endif; ?>
</article>
</section>
<?php get_footer();?>