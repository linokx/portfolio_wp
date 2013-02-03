<?php get_header(); ?>
<div id="content">
	<article id="propos">
<?php wp_reset_postdata(); ?>
  <?php query_posts('post_type=capacities'); ?>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    	<h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
    <?php endwhile; ?>
  <?php endif; ?>
	</article>
</div>
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="<?php echo home_url( '/wp-content/themes/ludovic/scripts/' ); ?>travaux.js" type="text/javascript" ></script>
<?php get_footer(); ?>
