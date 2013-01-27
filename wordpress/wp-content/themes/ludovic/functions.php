<?php
/**
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @package WordPress
 * @subpackage TravelBlogger
 * @since TravelBlogger Theme 1.0
 */

// Define directory constants
define('EXP_LIB', get_template_directory() . '/lib');
define('EXP_ADMIN', EXP_LIB . '/admin');
define('EXP_FUNCTIONS', EXP_LIB . '/functions');
define('EXP_CLASSES', EXP_LIB . '/classes');

// Launch Theme within WordPress
require_once(EXP_FUNCTIONS . '/launch.php');

// Load theme functions
require_once(EXP_FUNCTIONS . '/layout.php');
require_once(EXP_FUNCTIONS . '/components.php');
require_once(EXP_FUNCTIONS . '/widgets.php');

if(is_admin()) {
	// Adds options to Appearance tab in admin area
	require_once(EXP_ADMIN .'/opt_theme_layout.php');
	require_once(EXP_ADMIN .'/opt_colors_fonts.php');
	require_once(EXP_ADMIN .'/opt_social_media.php');
	// Loads classes
	require_once(ABSPATH . 'wp-admin/custom-header.php');
	require_once(ABSPATH . 'wp-admin/custom-background.php');
	require_once(EXP_CLASSES . '/custom-background.php');
	require_once(EXP_CLASSES . '/custom-header.php');
	require_once(EXP_CLASSES . '/custom-footer.php');
	// Adds admin only functions
	require_once(EXP_FUNCTIONS .'/admin.php');
}
	add_action('widgets_init', 'invinciweb_sidebars');
	add_action('after_setup_theme','invinciweb_setup');
	add_action('init','create_post_type');
	//add_action( 'init', 'people_init' );
	
	
	
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
					'has_archive' => true,
					'taxonomies' => array('post_tag','category')
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
		}
	}
	/*if(!function_exists('people_init')){
		function people_init() {
		// create a new taxonomy
		register_taxonomy(
			'people',
			'post',
			array(
				'label' => __( 'People' ),
				'rewrite' => array( 'slug' => 'person' ),
				'capabilities' => array(
					'assign_terms' => 'edit_guides',
					'edit_terms' => 'publish_guides'
					)
				)
			);
		}
	}*/
	function new_excerpt_more($more) {
       global $post;
	return '<div class="read_more"><a href="'. get_permalink($post->ID) . '">Lire la suite de '.get_the_title().'</a></div>';
}
add_filter('excerpt_more', 'new_excerpt_more');
	if( !function_exists( 'theme_pagination' ) ) {
	
		function theme_pagination()
		{
		
		global $wp_query, $wp_rewrite;
			$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
		
			$pagination = array(
				'base' => @add_query_arg('page','%#%'),
				'format' => '',
				'total' => $wp_query->max_num_pages,
				'current' => $current,
		                'show_all' => false,
		                'end_size'     => 1,
		                'mid_size'     => 2,
				'type' => 'list',
				'next_text' => '»',
				'prev_text' => '«'
				);
		
			if( $wp_rewrite->using_permalinks() )
				$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
		
			if( !empty($wp_query->query_vars['s']) )
				$pagination['add_args'] = array( 's' => str_replace( ' ' , '+', get_query_var( 's' ) ) );
			
			echo str_replace('page/1/','', paginate_links( $pagination ) );
		}	
		
	}