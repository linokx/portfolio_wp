<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="bd">
 *
 * @package WordPress
 * @subpackage Ludovic Bekaert
 * @since Ludovic Bekaert Theme 1.0
 */
	?>
	<!DOCTYPE HTML>
<html lang="<?php bloginfo('language'); ?>">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description') ; ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<!--<link rel="stylesheet/less" media="screen" href="css/css.less" type="text/css"/>-->
	<link type="image/x-icon" href="<?php echo home_url( '/wp-content/themes/ludovic/' ); ?>images/favicon.ico" rel="shortcut icon"/>
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 * We filter the output of wp_title() a bit -- see
	 * travelblogger_filter_wp_title() in functions.php.
	 */
	wp_title( '-', true, 'right' );

	?></title>
</head>
<body>
	<div id="bgheader">
		<header>
			<a href="<?php echo home_url( '/' ); ?>">
		<hgroup><img src="<?php echo home_url( '/wp-content/themes/ludovic/' ); ?>images/mini_logo.png" width="48px" height="42px"/><h1>Ludovic Bekaert <span>Web Designer &amp; Programmer</span></h1></a><h2>
&ldquo;Aujourd'hui, aucune société n'existe si elle n'est pas présente sur le web. Site vitrine ou veritable e-commerce, je saurais répondre à vos attentes.&rdquo;</h2>
		</hgroup></header><?php // wp_nav_menu('Menu'); ?>
		<?php
		$defaults = array(
			'menu'            => 'Principal',
			'container'       => 'nav',
			'container_class' => 'principal',
			'container_id'    => false,
			'echo'            => true,
			'items_wrap'      => '%3$s'
		);

		wp_nav_menu( $defaults );
		?>
	</div>