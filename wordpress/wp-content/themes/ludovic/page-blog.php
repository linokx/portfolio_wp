<?php get_header(); ?>
<div id="content">
<article id="blog">
<?php query_posts('posts_per_page=10'); ?>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
	<div class="content">
	<h2><?php the_title(); ?></h2>
	<span>
		Posté <span class="author"><?php _e('par'); ?> <?php the_author(); ?></span>
		<?php _e('le'); ?> <?php echo get_the_date('d M. Y'); ?>
	</span><?php the_excerpt(); ?></div>
	<hr />
	<?php theme_pagination(); ?>
<?php endwhile; ?>
<?php endif; ?>
</article>
</div>
<?php get_footer();?>