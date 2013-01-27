<?php get_header(); ?>
<div id="content">
<div id="contact">
<?php  $page_data = get_page($_GET['page_id']);  ?>
<?php echo $page_data->post_content; ?>
</div>
</div>
<?php get_footer(); ?>