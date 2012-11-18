<?php //Smashing wordpress
	add_action('widgets_init', 'invinciweb_sidebars');
	add_action('after_setup_theme','invinciweb_setup');
	add_action('init','create_post_type');
	
	
	
	if(!function_exists('invinciweb_setup')){
		function invinciweb_setup(){
			add_theme_support('automatic-feed-links');
			add_theme_support('post-formats', array('aside','link','gallery','status','quote','image'));
			add_theme_support('post-thumbnails');
			register_nav_menu('header-menu',__('Header Menu', 'portofolio'));
			if(function_exists('add_image_size')){
				add_image_size('folio-work',640,480,false);
			}
		}
	}
	
	if(!function_exists('create_post_type')){
		function create_post_type(){
			register_post_type('works',
				array(
					'labels' => array(
						'name' => __('Travaux'),
						'singular_name' => __('Travail')
					),
					'supports' => array('title','editor','thumbnail','post-formats'),
					'public' => true,
					'has_archive' => true
				)
			);
		}
	}
	if(!function_exists('invinciweb_sidebars')){
		function invinciweb_sidebars(){
			register_sidebar(
				array(
					'id' => 'prymary',
					'name' => __('Primary'),
					'description' => __('A short description of the sidebar.'),
					'before_widget' => '<div id="%1$s" class="widget %2$s>',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>'
				)
			);
			register_sidebar(
				array(
					'id' => 'secondary',
					'name' => __('Secondary'),
					'description' => __('A short description of the sidebar.'),
					'before_widget' => '<div id="%1$s" class="widget %2$s>',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>'
				)
			);
		}
	}