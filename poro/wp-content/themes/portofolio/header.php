<!DOCTYPE HTML>
<html lang="<?php bloginfo('language'); ?>">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description') ; ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<!--<link rel="stylesheet/less" media="screen" href="css/css.less" type="text/css"/>-->
	<title>Ludovic Bekaert - <?php the_title(); ?></title>
</head>
<body>
<header>
<h1><a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo home_url( '/wp-content/themes/portofolio/' ); ?>images/mini_logo.png" width="48px" height="42px"/> Ludovic Bekaert</a></h1>
<?php wp_nav_menu('Menu'); ?>
</header>