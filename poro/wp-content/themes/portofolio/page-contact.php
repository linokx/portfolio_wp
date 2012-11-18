<?php get_header(); ?>
<section>
<?php  $page_data = get_page($_GET['page_id']);  ?>
<?php echo $page_data->post_content; ?>

</section>
<?php get_footer(); ?>