<?php get_header(); ?>
<div id="content">
<div id="contact">
<?php  $page_data = get_page($_GET['page_id']);  ?>
<?php echo $page_data->post_content; ?>
</div>
</div>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="<?php echo home_url( '/wp-content/themes/ludovic/scripts/' ); ?>travaux.js" type="text/javascript" ></script>
<?php get_footer(); ?>