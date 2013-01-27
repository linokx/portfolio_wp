<?php
/**
 * Admin template for theme layout
 *
 * @package WordPress
 * @subpackage TravelBlogger
 * @since TravelBlogger Theme 1.0
 */

function exp_add_theme_menu() {
	$page = add_theme_page(
	   __('Theme Layout & Skins', 'travelblogger'),
	   __('Theme Layout & Skins', 'travelblogger'),
	   'edit_theme_options',
	   'exp-theme-settings',
	   'exp_theme_settings'
	);
	add_action("admin_print_styles-$page", 'exp_load_theme_styles');
	add_action("admin_print_scripts-$page", 'exp_load_theme_scripts');
	add_action("load-$page", 'exp_theme_options_option_updates');
}
add_action('admin_menu', 'exp_add_theme_menu');

function exp_theme_options_option_updates() {
	$exp_theme_options = exp_get_theme_options();
	// See if the user has posted us some information
	if (!empty($_POST['update-theme-layout'])) {
		if ( check_admin_referer('exp_theme_settings-update') ) {
			if (isset($_POST['theme_grid'])) {
				$exp_theme_options['theme_grid'] = esc_attr($_POST['theme_grid']);
			}
			if (isset($_POST['theme_color'])) {
				global ${'exp_body_bg_'.$_POST['theme_color']},${'exp_theme_color_'.$_POST['theme_color']};
				$defaults = exp_theme_defaults();
				set_theme_mod('background_image', get_stylesheet_directory_uri().'/images/backgrounds/background-'.$_POST['theme_color'].'.jpg' );
				set_theme_mod('background_image_thumb', get_stylesheet_directory_uri().'/images/backgrounds/background-'.$_POST['theme_color'].'-thumbnail.jpg' );
				if(file_exists(TEMPLATEPATH .'/images/backgrounds/footer-'.$_POST['theme_color'].'.jpg')) {
					set_theme_mod('footer_image', get_stylesheet_directory_uri().'/images/backgrounds/footer-'.$_POST['theme_color'].'.jpg' );
				} else {
					remove_theme_mod('footer_image');
				}
				remove_theme_mod('header_image');
				set_theme_mod('background_repeat', 'no-repeat');
				set_theme_mod('background_attachment', 'fixed');
				set_theme_mod('background_position_x', 'center');
				set_theme_mod('background_color', ${'exp_body_bg_'.$_POST['theme_color']});
				$theme = ${'exp_theme_color_'.$_POST['theme_color']};
				$exp_theme_options['color_settings'] = $theme;
				$exp_theme_options['theme_color'] = esc_attr($_POST['theme_color']);
				$exp_theme_options['theme_font'] = $defaults['theme_font'];
				$exp_theme_options['custom_css'] = $defaults['custom_css'];
			}
			if (isset($_POST['theme_loop_content'])) {
				if ( $_POST['theme_loop_content'] == 1 ) {
					$exp_theme_options['theme_loop_content']='full';
				} elseif ( $_POST['theme_loop_content'] == 0  ) {
					$exp_theme_options['theme_loop_content']='';
				}
			}
			if (isset($_POST['show_postmeta'])) {
				if ( $_POST['show_postmeta'] == 1 ) {
					$exp_theme_options['show_postmeta'] = true;
				} elseif ( $_POST['show_postmeta'] == 0  ) {
					$exp_theme_options['show_postmeta'] = false;
				}
			}
			if (isset($_POST['show_blogroll_comments'])) {
				if ( $_POST['show_blogroll_comments'] == 1 ) {
					$exp_theme_options['show_blogroll_comments'] = true;
				} elseif ( $_POST['show_blogroll_comments'] == 0  ) {
					$exp_theme_options['show_blogroll_comments'] = false;
				}
			}
			if (isset($_POST['use_roundy'])) {
				if ( $_POST['use_roundy'] == 1 ) {
					$exp_theme_options['use_roundy']=true;
				} elseif ( $_POST['use_roundy'] == 0  ) {
					$exp_theme_options['use_roundy']=false;
				}
			}
			if (isset($_POST['column_size'])) {
				$exp_theme_options['column_size']=$_POST['column_size'];
			}
			update_option('travelblogger_theme_options', $exp_theme_options);
			wp_redirect(admin_url('themes.php?page=exp-theme-settings&updated=true'));
		}
	} elseif (!empty($_GET['dontshow'])) {
		if ( check_admin_referer('exp_dont_show_again-optout') ) {
			update_option('exp_dont_bother','dontshow');
			wp_redirect(admin_url('themes.php?page=exp-theme-settings&updated=true'));
		}
	} elseif (!empty($_GET['activatelink'])) {
		if ( check_admin_referer('exp_activate_link-optin') ) {
			$footerlinks = $exp_theme_options['footer_links'];
			$footerlinks['credit']='show';
			$footerlinks['add_credit']='show';
			$exp_theme_options['footer_links'] = $footerlinks;
			update_option('travelblogger_theme_options', $exp_theme_options);
			delete_option('exp_dont_bother');
			wp_redirect(admin_url('themes.php?page=exp-theme-settings&updated=true'));
		}
	} elseif (!empty($_GET['exp_updategmaps'])) {
		if ( check_admin_referer('exp_updategmaps-optin') ) {
			
			exp_get_geo_latlng();
			
			wp_redirect(admin_url('themes.php?page=exp-theme-settings&updated=true'));
		}
	}
	
}

function exp_theme_settings() {
	global $theme_data;
    //must check that the user has the required capability 
    if (!current_user_can('edit_theme_options')) {
      wp_die( __('You do not have sufficient permissions to access this page.' , 'travelblogger') );
    }

    // Read in existing theme layout options from database
    $opt_layout = exp_get_theme_options();

	// Set types of layouts
	$boxes = array('col-3'=>'yui-t2','col-2-left'=>'yui-t3','col-2-right'=>'yui-t6');

	// Set preset theme colors
	$colors = array('default','camping');
	$current='';
	$max = ($opt_layout['theme_grid']=='yui-t2') ? 30 : 50; // Max width for resizable columns
	$factor = ($opt_layout['theme_grid']=='yui-t2') ? 2 : 1; // Factor in which gutter space is calculated.
	$grid = ($opt_layout['theme_grid']=='yui-t2') ? "t-3" : "t-2";
	$adminurl = admin_url('themes.php?page=exp-theme-settings');
?>
<span class="max"><?php echo $max ?></span>
<span class="factor"><?php echo $factor ?></span>
<?php if ( !empty($_GET['updated']) ) { ?>
<div id="message" class="updated">
	<p><?php printf( __( 'Settings updated. <a href="%s" target="_blank">Visit your site</a> to see how it looks.' , 'travelblogger' ), home_url( '/' ) ); ?></p>
</div>
<?php } ?>
<script>
	var scale_grid = ['|', '20', '|', '60', '|', '|', '|', '140', '|', '|', '|', '220', '|', '|', '|', '300', '|', '|', '|', '380', '|', '|', '|', '460', '|', '|', '|', '540', '|', '|', '|', '620', '|', '|', '|', '700', '|', '|', '|', '780', '|', '|', '|', '860', '|', '|', '|', '940', '|'],
	scale_fluid = ['0', '|', '10', '|', '20', '|', '30', '|', '40', '|','50', '|', '60', '|', '70', '|', '80', '|', '90', '|', '100'];
	
	function stop_at_max(value, max, factor) {
		// stops slider from going past maximum allowed width
		if(value >= max) {
			jQuery( ".v" ).width( max+"%");
			jQuery( ".jslider-pointer" ).css("left", max+"%" );
			jQuery( "#preview .col.first, #preview .col.last" ).width( max+"%");
			var diff = ( parseInt(100) - ( (parseInt(max) * parseInt(factor)) + (parseInt(2) * parseInt(factor)) ) );
			jQuery( "#preview .content" ).width( diff + "%");
			jQuery( "#slider" ).attr("value", max);
		}
	}
	
	jQuery(document).ready(function($) {
		$("#slider").slider({ 
			from: 0, 
			to: 100,
			step: 1, 
			round: 1,
			dimension: '&nbsp;%',
			scale: scale_fluid,
			onstatechange: function( value ){
				var factor = $('.factor').text();
				var max = $('.max').text();
				$( ".v" ).width( value + "%");
				$( "#preview .col.first, #preview .col.last" ).width( value + "%");
				var diff = ( parseInt(100) - ( (parseInt(value) * parseInt(factor)) + (parseInt(2) * parseInt(factor)) ) );
				$( "#preview .content" ).width( diff + "%");
				stop_at_max(value, max, factor);
			} 
		});
		$(".v").show().css("left", 0 );
		
		$('.layout').click( function() {
			$('.layout').removeClass('checked');
			$('.radio-layout').removeAttr('checked','checked')
			$(this).toggleClass('checked');
			$(this).next('.radio-layout').attr('checked','checked');
			var grids = $(this).next('.radio-layout').val();
			var value = $( "#slider" ).val();
			$('#bd').removeClass('t-3 t-2');
			if(grids == 'yui-t2') {
				$('#bd').addClass('t-3');
				$('.max').text(30);
				$('.factor').text(2);
				var diff = ( parseInt(100) - ( (parseInt(value) * parseInt(2)) + (parseInt(2) * parseInt(2)) ) );
				$( "#preview .content" ).width( diff + "%");
				stop_at_max(value, 30, 2);
			} else {
				$('#bd').addClass('t-2');
				$('.max').text(50)
				$('.factor').text(1);
				var diff = ( parseInt(100) - ( (parseInt(value) * parseInt(1)) + (parseInt(2) * parseInt(1)) ) );
				$( "#preview .content" ).width( diff + "%");
				stop_at_max(value, 50, 1);
			}
		});
		$('.colors').click( function($) {
			jQuery('.colors').removeClass('checked');
			jQuery('.radio-colors').removeAttr('checked','checked')
			jQuery(this).toggleClass('checked');
			jQuery(this).next('.radio-colors').attr('checked','checked');
		})
	});
</script>
<div class="wrap appearance_page_custom-header">
<div id="icon-themes" class="icon32"><br/></div>

		<h2>Theme Layout</h2>
		<h3>Theme Grid Layout</h3>
		<p>Select the Theme Grid to set the number of columns. Then move the slider to set the Column sizes. In a 2 column layout, no column can go over 50% of the width of the page. In a 3 column layout, no column can go over 30% of the width of the page.</p>
		<form action="" method="post" id="exp-theme-layout-form">
			<table class="form-table">
			<tbody>
				<tr valign="top">
				<th scope="row">Theme Grid</th>
					<td>
						<?php foreach ($boxes as $key => $value) { 
							$checked = ($opt_layout['theme_grid'] == $value) ? 'checked ' : '';
						?>
							<div class="layout-box">
								<label for="layout-settings-<?php echo $key ?>" class="layout <?php echo $checked ?> <?php echo $key ?>"></label>
								<input class="radio-layout" type="radio" name="theme_grid" id="layout-settings-<?php echo $key ?>" <?php echo $checked ?> value="<?php echo $value ?>" />
							</div>
						<?php } ?>
					</td>
				</tr>
				<tr valign="top">
				<th scope="row"><div class="slider-layout">Column Sizes</div></th>
					<td>
						<div class="columns">
								<div class="slider-layout">
									<?php
										if(!isset($opt_layout['column_size'])) {
											$column_size = ($opt_layout['theme_grid']=='yui-t2') ? "20.5" : "31";
										} else {
											$column_size = $opt_layout['column_size'];
										}
									?>
									<input id="slider" type="slider" name="column_size" value="<?php echo $column_size ?>" />
								</div>

								<strong>Preview</strong>
								<div id="preview">
									<div class="header">
										header
									</div>
									<div id="bd" class="<?php echo $grid ?> clearfix">
										<div class="col first">
											sidebar primary
										</div>
										<div class="content">
											content area
										</div>
										<div class="col last">
											sidebar secondary
										</div>
									</div>
								</div><!-- /#preview -->
						</div>
					</td>
				</tr>
			</tbody>
			</table>		
		<h3>Default Theme Skins</h3>
			<table class="form-table">
			<tbody>
				<tr valign="top">
				<th scope="row">&nbsp;</th>
					<td>
						<?php foreach ($colors as $color) { 
							$checked = ($opt_layout['theme_color'] == $color) ? 'checked ' : '';
						?>
							<div class="color-box">
								<b><?php echo $color ?></b>
								<label for="color-settings-<?php echo $color ?>" class="colors <?php echo $checked ?> <?php echo $color ?>"></label>
								<input class="radio-colors" type="radio" name="theme_color" id="color-settings-<?php echo $color ?>" <?php echo $checked ?> value="<?php echo $color ?>" />
							</div>
						<?php }?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">&nbsp;</th>
					<td><p style="margin-top:-10px;">Select a default travel skin to change the look and feel of the entire theme. WARNING: This will override any custom image, font or color settings you have made.</p></td>
				</tr>
				<tr valign="top">
				<th scope="row">Square or Rounded Corners?</th>
				<td>
					<p>
					<label><input type="radio" value="1" name="use_roundy" id="use_roundy"<?php checked( ( $opt_layout['use_roundy'] ) ? true : false ); ?> /> Rounded</label>
					<label><input type="radio" value="0" name="use_roundy" id="no_roundy"<?php checked( ( !$opt_layout['use_roundy'] )  ? true : false ); ?> /> Square</label>
					</p>
					<p>This option allows you to set between square and rounded corners for this thgee.</p>
				</td>
				</tr>
			</tbody>
			</table>
			<h3>Blog Roll Content Setting</h3>
				<table class="form-table">
				<tbody>
					<tr valign="top">
					<th scope="row">Display in Full HTML<br/> or Summary Text</th>
					<td>
						<p>
						<label><input type="radio" value="1" name="theme_loop_content" id="fulltext"<?php checked( ( !empty( $opt_layout['theme_loop_content'] ) )  ? true : false ); ?> /> Full Text</label>
						<label><input type="radio" value="0" name="theme_loop_content" id="summarytext"<?php checked( ( empty( $opt_layout['theme_loop_content'] ) ) ? true : false ); ?> /> Summary</label>
						</p>
						<p>This option allows you to set whether to display the full text of your posts in the blog roll, or simply the excerpts.</p>
					</td>
					</tr>
					<tr valign="top">
					<th scope="row">Display meta information in posts (author, time and comments)</th>
					<td>
						<p>
						<label><input type="radio" value="1" name="show_postmeta" id="show_postmeta"<?php checked( ( $opt_layout['show_postmeta'] ) ? true : false ); ?> /> Display</label>
						<label><input type="radio" value="0" name="show_postmeta" id="hide_postmeta"<?php checked( ( !$opt_layout['show_postmeta'] )  ? true : false ); ?> /> Hide</label>
						</p>
						<p>This option hides the informational bar under the post title.</p>
					</td>
					</tr>
					<tr valign="top">
					<th scope="row">Display comments on home page blog roll</th>
					<td>
						<p>
						<label><input type="radio" value="1" name="show_blogroll_comments" id="show_blogroll_comments"<?php checked( ( $opt_layout['show_blogroll_comments'] ) ? true : false ); ?> /> Display</label>
						<label><input type="radio" value="0" name="show_blogroll_comments" id="hine_blogroll_comments"<?php checked( ( !$opt_layout['show_blogroll_comments'] )  ? true : false ); ?> /> Hide</label>
						</p>
						<p>This option hides the comments on the right side of the blog posts on home page.</p>
					</td>
					</tr>
				</tbody>
				</table>
			<table>
				<tr valign="top">
					<td>
						<p class="submit">
							<input type="submit" name="update-theme-layout" class="button-primary" value="<?php echo esc_attr('Save Changes') ?>" />
						</p>
					</td>
				</tr>
			</table>
			<?php wp_nonce_field('exp_theme_settings-update'); ?>
		</form>

		<h2>Travel Blogger Help &amp; Support</h2>
			<table class="form-table">
			<tbody>
				<tr valign="top">
					<td>
						<p>Please visit our main Travel Blogger support website for instructions on theme installation &amp; setup, configuration and complete information about use of the theme features: <a href="<?php echo $theme_data->AuthorURI; ?>" target="_blank">http://www.freetravelwebsitetemplates.com/</a></p>

						<p>This site is where more frequent updates and bug fixes to the theme may be found. Please visit every once in a while to download the latest version.</p>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<p><a href="<?php echo wp_nonce_url($adminurl.'&exp_updategmaps=1','exp_updategmaps-optin') ?>">Click here</a> to update your current locations. This fixes an issue with Google Maps.</p>
					</td>
				</tr>
			</tbody>
			</table>

</div><!-- #wrapper -->
<?php
}
