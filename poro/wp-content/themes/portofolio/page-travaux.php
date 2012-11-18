<?php get_header(); ?>
<section>
<h2>Mes travaux</h2>
<article id="zone_travaux">
<?php wp_reset_postdata(); ?>
  <?php query_posts('posts_per_page=-1&post_type=works'); ?>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <!--<h3 class="project-name"><?php the_title(); ?></h3>
        <p class="project-description"><?php the_excerpt(); ?></p>-->
      <div class="travaux">
		<a href="<?php the_content(); ?>">
        <?php the_post_thumbnail(); ?>
		</a>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</article>

</section>
<script src="<?php echo home_url( '/wp-content/themes/portofolio/' ); ?>jquery-box.js" type="text/javascript" ></script>
<?php get_footer(); ?>