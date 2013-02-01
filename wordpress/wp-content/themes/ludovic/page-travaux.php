<?php get_header(); ?>
<div id="content">
<div id="zone_travaux">
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
                <div class="apercu">
                  <img src="<?php echo home_url( '/wp-content/uploads/images/' ).strtolower(get_the_title()); ?>_grand.png" alt="<?php echo the_title(); ?>" width="549" height="500" />
                  <img src="<?php echo home_url( '/wp-content/uploads/images/' ).strtolower(get_the_title()); ?>_mini_1.png" alt="<?php echo the_title(); ?>" width="243" height="251" />
                  <img src="<?php echo home_url( '/wp-content/uploads/images/' ).strtolower(get_the_title()); ?>_mini_2.png" alt="<?php echo the_title(); ?>" width="243" height="251" />
                </div>
                <div class="legende">
                <?php the_content(); ?>
              </div>
          </li>
    <?php endwhile; ?>
        </ul>
      </div>
  <?php endif; ?>
</div>

</div>
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="<?php echo home_url( '/wp-content/themes/ludovic/scripts/' ); ?>travaux.js" type="text/javascript" ></script>
<?php get_footer(); ?>