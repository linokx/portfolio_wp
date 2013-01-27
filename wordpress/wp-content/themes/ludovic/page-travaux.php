<?php get_header(); ?>
<section id="content">
<article id="zone_travaux">
<?php wp_reset_postdata(); ?>
  <?php query_posts('posts_per_page=-1&post_type=works'); ?>
  <?php if (have_posts()) : ?>
      <div id="slider">
        <i class="icon-left-open" id="previous"></i>
        <i class="icon-right-open"id="next"></i>
        <ul>
    <?php while (have_posts()) : the_post(); ?>
          <li>
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
          </li>
    <?php endwhile; ?>
        </ul>
      </div>
  <?php endif; ?>
</article>

</section>
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="<?php echo home_url( '/wp-content/themes/ludovic/scripts/' ); ?>travaux.js" type="text/javascript" ></script>
<?php get_footer(); ?>