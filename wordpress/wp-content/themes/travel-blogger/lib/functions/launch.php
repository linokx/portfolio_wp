<?php
/** Tell WordPress to run travelblogger_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'travelblogger_setup' );

define('WP_VERSION', $wp_version);

function exp_theme_defaults() {
	$opt = array(
		'theme_grid'=>'yui-t2',
		'theme_color'=>'default',
		'theme_loop_content'=>'',
		'theme_font' => array(
			'value' => 'Candara, Verdana, sans-serif',
			'css' => 'body { font-family: ',
			'key' => 'candara'
		),
		'custom_css'=>'',
		'use_roundy'=>true,
		'show_header_text'=>true,
		'social_feeds'=> array(
			'facebook'=>'',
			'twitter'=>'',
			'rss'=>'',
			'facebook_like_url'=>''
		),
		'social_bar'=>true,
		'face_bar'=>true,
		'twit_bar'=>true,
		'google_bar'=>true,
		'follow_bar'=>true,
		'featured_area'=>'show',
		'footer_links'=> array(
			'credit'=>'show',
			'add_credit'=>'',
			'custom_copy'=>''
		),
		'color_settings'=>'',
		'show_postmeta'=> true,
		'show_blogroll_comments'=> true,
		'use_roundy'=>true,
		'linkheader'=>false
	);
	return $opt;
}
function exp_get_theme_options() {
	$options = get_option('travelblogger_theme_options',exp_theme_defaults());
	$all_options = array_merge(exp_theme_defaults(),$options);
	
	return $all_options;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since TravelBlogger Theme 1.0
 */
function travelblogger_setup() {
 	global $exp_theme_color_default;

 	// Checks to see if WordPress installation is compatible with theme
	if (WP_VERSION < 3.2): // disable theme front end if wp < 3.2
	
	  function exp_unsupported_wp_version(){ ?>
	  <div class='error fade'>
		   <p>
			   <?php
			    printf(__('Your site is running on %1$s. Travel Blogger Theme requires at least %2$s. Please consider upgrading WordPress, it\'s safer, faster and carries more features.','travelblogger'), 'Wordpress '.WP_VERSION, '<a href="http://codex.wordpress.org/Upgrading_WordPress">Wordpress 3.2</a>');
			    if (current_user_can('switch_themes') && !is_admin()) echo '<br /><a href="'.site_url().'/wp-admin/">'.__("(Dashboard)","travelblogger").'</a>';
			   ?>
		   </p>
	  </div>
	  <?php if(!is_admin()) die();
	  }
	  add_action('admin_notices', 'exp_unsupported_wp_version');
	  add_action('wp', 'exp_unsupported_wp_version');
	
	else :
		
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();
		
		define( 'FOOTER_IMAGE_WIDTH', 975 );
		define( 'FOOTER_IMAGE_HEIGHT', 130 );
		
		// This theme allows users to set a footer background
		add_custom_footer();
		
		// This theme allows users to set a custom background
		$defaults = array(
			'default-color'          => 'BBD9EE',
			'default-image'          => '%s/images/backgrounds/background-default.jpg',
			'wp-head-callback'       => 'exp_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => 'esp_background_div_admin'
		);
		add_theme_support( 'custom-background', $defaults );
		
		// Add support for custom headers.
		$custom_header_support = array(
			// The default header text color.
			'default-text-color' => '000',
			// The height and width of our custom header.
			'width' => apply_filters( 'travelblogger_header_image_width', 975 ),
			'height' => apply_filters( 'travelblogger_header_image_height', 130 ),
			// Support flexible heights.
			'flex-height' => true,
			// Random image rotation by default.
			'random-default' => false,
			// Callback for styling the header.
			'wp-head-callback' => 'exp_header_style',
			// Callback for styling the header preview in the admin.
			'admin-head-callback' => 'esp_admin_header_style',
			// Callback used to display the header preview in the admin.
			'admin-preview-callback' => '',
			'uploads' => true,
			'header-text' => true
		);
		add_theme_support( 'custom-header', $custom_header_support );

		if ( ! function_exists( 'get_custom_header' ) ) {
			// This is all for compatibility with versions of WordPress prior to 3.4.
			define( 'HEADER_TEXTCOLOR', '' );
			define( 'HEADER_IMAGE', '' );
			define( 'NO_HEADER_TEXT', false );
			define( 'HEADER_IMAGE_WIDTH', apply_filters( 'travelblogger_header_image_width', 975 ) );
			define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'travelblogger_header_image_height', 130 ) );
			add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
			
			define( 'BACKGROUND_IMAGE', '%s/images/backgrounds/background-default.jpg' );
			define( 'BACKGROUND_COLOR', 'BBD9EE');
			add_custom_background('exp_custom_background_cb','esp_background_div_admin');
		}
		
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );
		
		// Size for thumbnails in post listings and feature
		set_post_thumbnail_size( 190, 190 );
	
		// Size for widget thumbnails
		add_image_size( 'widget-thumbnail', 60, 80 ); // Permalink thumbnail size
		
		add_image_size( 'feature-thumbnail', 400, 335 ); // Permalink thumbnail size
	
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
	
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'travelblogger' ),
			'footer' => __( 'Footer Navigation', 'travelblogger' )
		) );
		
		// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
		register_default_headers( array(
			'clouds-compass' => array(
				'url' => '%s/images/headers/clouds-compass.jpg',
				'thumbnail_url' => '%s/images/headers/clouds-compass-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Clouds Compass', 'travelblogger' )
			),
			'forest-sunset' => array(
				'url' => '%s/images/headers/forest-sunset.jpg',
				'thumbnail_url' => '%s/images/headers/forest-sunset-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Forest Sunset', 'travelblogger' )
			),
			'lake' => array(
				'url' => '%s/images/headers/lake.jpg',
				'thumbnail_url' => '%s/images/headers/lake-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Lake', 'travelblogger' )
			),
			'mountains' => array(
				'url' => '%s/images/headers/mountains.jpg',
				'thumbnail_url' => '%s/images/headers/mountains-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Mountains', 'travelblogger' )
			),
			'red-sunset' => array(
				'url' => '%s/images/headers/red-sunset.jpg',
				'thumbnail_url' => '%s/images/headers/red-sunset-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Red Sunset', 'travelblogger' )
			),
			'st-basils' => array(
				'url' => '%s/images/headers/st-basils.jpg',
				'thumbnail_url' => '%s/images/headers/st-basils-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'St. Basils', 'travelblogger' )
			),
			'tent' => array(
				'url' => '%s/images/headers/tent.jpg',
				'thumbnail_url' => '%s/images/headers/tent-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Tent', 'travelblogger' )
			)
		) );
		
		exp_footer_links();
		
		// Writes version of theme
		if(!get_option('exp_theme_ver')) {
			if ( function_exists( 'wp_get_theme' ) ) {
				$theme_data = wp_get_theme();
			} else {
				$_theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
				$theme_data = (object) $_theme_data;
			}
			add_option('exp_theme_ver',$theme_data->Version);
		}
		
	endif;
}

// Live preview custom settings
add_action( 'customize_register', 'esp_customize_register' );
function esp_customize_register($wp_customize) {
	// Override default background_repeat settings.
	$wp_customize->add_setting( 'background_repeat', array(
		'default'        => 'no-repeat',
		'theme_supports' => 'custom-background',
	) );
}


?>