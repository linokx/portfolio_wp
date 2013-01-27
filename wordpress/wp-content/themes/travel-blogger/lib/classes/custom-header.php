<?php
/**
 * The custom header image script. Script modified to accomodate custom theme settings.
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * The custom header image class.
 *
 */
class EXP_Custom_Image_Header extends Custom_Image_Header {

	var $theme_options = '';

	/**
	 * Execute custom header modification.
	 *
	 * @since 2.6.0
	 */
	function take_action() {
		$this->theme_options = exp_get_theme_options();
		if ( ! current_user_can('edit_theme_options') )
			return;

		if ( empty( $_POST ) )
			return;

		$this->updated = true;

		if ( isset( $_POST['resetheader'] ) ) {
			check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
			// This is all for compatibility with versions of WordPress prior to 3.4.
			if ( function_exists('display_header_text') )  {
				$this->reset_header_image();
			} else {
				remove_theme_mod( 'header_image' );
			}
			return;
		}

		if ( isset( $_POST['resettext'] ) ) {
			check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
			remove_theme_mod('header_textcolor');
			return;
		}

		if ( isset( $_POST['removeheader'] ) ) {
			check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
			// This is all for compatibility with versions of WordPress prior to 3.4.
			if ( function_exists('display_header_text') )  {
				$this->remove_header_image();
			} else {
				set_theme_mod( 'header_image', 'remove-header' );
			}
			return;
		}	
		
		if ( isset( $_POST['exp-custom-header'] ) ) {
			if ( !isset( $_POST['display-header-text'] ) ) {
				check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
				set_theme_mod( 'header_textcolor', 'blank' );
				$this->theme_options['show_header_text'] = false;
			} else {
				$this->theme_options['show_header_text'] = true;
				set_theme_mod( 'header_textcolor', '' );
			}
		}
				
		if ( isset( $_POST['featured_area'] ) ) {
			check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
				$featured = $_POST['featured_area'];
				$this->theme_options['featured_area'] = esc_attr($featured);
		}
		
		if ( isset( $_POST['linkheader'] ) ) {
			check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
			if ( $_POST['linkheader'] == 1 ) {
				$this->theme_options['linkheader'] = true;
			} elseif ( $_POST['linkheader'] == 0  ) {
				$this->theme_options['linkheader'] = false;
			}
		}

		// This is all for compatibility with versions of WordPress prior to 3.4.
		if ( function_exists('display_header_text') )  {
			if ( isset( $_POST['default-header'] ) ) {
				check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
				$this->set_header_image( $_POST['default-header'] );
			}
		} else {
			if ( isset( $_POST['default-header'] ) ) {
				check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
				if ( 'random-default-image' == $_POST['default-header'] ) {
					set_theme_mod( 'header_image', 'random-default-image' );
				} elseif ( 'random-uploaded-image' == $_POST['default-header'] ) {
					set_theme_mod( 'header_image', 'random-uploaded-image' );
				} else {
					$this->process_default_headers();
					$uploaded = get_uploaded_header_images();
					if ( isset( $uploaded[$_POST['default-header']] ) )
						set_theme_mod( 'header_image', esc_url( $uploaded[$_POST['default-header']]['url'] ) );
					elseif ( isset( $this->default_headers[$_POST['default-header']] ) )
						set_theme_mod( 'header_image', esc_url( $this->default_headers[$_POST['default-header']]['url'] ) );
				}
			}
		}
		

		update_option('travelblogger_theme_options',$this->theme_options);
	}

	/**
	 * Display first step of custom header image page.
	 *
	 * @since 2.1.0
	 */
	function step_1() {
		$this->process_default_headers();
?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Custom Header</h2>

	<?php if ( ! empty( $this->updated ) ) { ?>
	<div id="message" class="updated">
	<p><?php printf( 'Header updated. <a href="%s">Visit your site</a> to see how it looks.', home_url( '/' ) ); ?></p>
	</div>
	<?php } ?>

	<h3>Header Image</h3>

	<table class="form-table">
	<tbody>

	<tr valign="top">
	<th scope="row">Preview</th>
	<td>
		<?php if ( $this->admin_image_div_callback ) {
		  call_user_func( $this->admin_image_div_callback );
		} else {
		?>
		<div id="headimg" style="background-image:url(<?php esc_url ( header_image() ) ?>);max-width:<?php echo get_custom_header()->width; ?>px;height:<?php echo get_custom_header()->height; ?>px;">
			<?php
			if ( display_header_text() )
				$style = ' style="color:#' . get_header_textcolor() . ';"';
			else
				$style = ' style="display:none;"';
			?>
			<h1><a id="name" class="displaying-header-text" <?php echo $style; ?> onclick="return false;" href="<?php home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<div id="desc" class="displaying-header-text" <?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		</div>
		<?php } ?>
	</td>
	</tr>
	<?php if ( current_theme_supports( 'custom-header', 'uploads' ) ) : ?>
	<tr valign="top">
	<th scope="row">Select Image</th>
	<td>
		<p>You can upload a custom header image to be shown at the top of your site instead of the default one. On the next screen you will be able to crop the image.<br />
		<?php
		
		// This is all for compatibility with versions of WordPress prior to 3.4.
		if ( function_exists('display_header_text') )  {
		
			if ( ! current_theme_supports( 'custom-header', 'flex-height' ) && ! current_theme_supports( 'custom-header', 'flex-width' ) ) {
				printf( 'Images of exactly <strong>%1$d &times; %2$d pixels</strong> will be used as-is. <br />', get_theme_support( 'custom-header', 'width' ), get_theme_support( 'custom-header', 'height' ) );
			} elseif ( current_theme_supports( 'custom-header', 'flex-height' ) ) {
				if ( ! current_theme_supports( 'custom-header', 'flex-width' ) )
					printf( 'Images should be at least <strong>%1$d pixels</strong> wide. ', get_theme_support( 'custom-header', 'width' ) );
			} elseif ( current_theme_supports( 'custom-header', 'flex-width' ) ) {
				if ( ! current_theme_supports( 'custom-header', 'flex-height' ) )
					printf( 'Images should be at least <strong>%1$d pixels</strong> tall. ', get_theme_support( 'custom-header', 'height' ) );
			}
			if ( current_theme_supports( 'custom-header', 'flex-height' ) || current_theme_supports( 'custom-header', 'flex-width' ) ) {
				if ( current_theme_supports( 'custom-header', 'width' ) )
					printf( 'Suggested width is <strong>%1$d pixels</strong>. ', get_theme_support( 'custom-header', 'width' ) );
				if ( current_theme_supports( 'custom-header', 'height' ) )
					printf( 'Suggested height is <strong>%1$d pixels</strong>. ', get_theme_support( 'custom-header', 'height' ) );
			}
			
		} else {
			printf( 'Images of exactly <strong>%1$d &times; %2$d pixels</strong> will be used as-is.' , HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT );
		}
		?></p>
		<form enctype="multipart/form-data" id="upload-form" method="post" action="<?php echo esc_attr( add_query_arg( 'step', 2 ) ) ?>">
		<p>
			<label for="upload">Choose an image from your computer:</label><br />
			<input type="file" id="upload" name="import" />
			<input type="hidden" name="action" value="save" />
			<?php wp_nonce_field( 'custom-header-upload', '_wpnonce-custom-header-upload' ); ?>
			<?php submit_button( 'Upload', 'button', 'submit', false ); ?>
		</p>
		<?php
			
		// This is all for compatibility with versions of WordPress prior to 3.4.
		if ( function_exists('display_header_text') )  {
			$image_library_url = get_upload_iframe_src( 'image', null, 'library' );
			$image_library_url = remove_query_arg( 'TB_iframe', $image_library_url );
			$image_library_url = add_query_arg( array( 'context' => 'custom-header', 'TB_iframe' => 1 ), $image_library_url );
		?>
		<p>
			<label for="choose-from-library-link">Or choose an image from your media library:</label><br />
			<a id="choose-from-library-link" class="button thickbox" href="<?php echo esc_url( $image_library_url ); ?>">Choose Image</a>
		</p>
		<?php } ?>
		</form>
	</td>
	</tr>
	<?php endif; ?>
	</tbody>
	</table>


	<form method="post" action="<?php echo esc_attr( add_query_arg( 'step', 1 ) ) ?>">
	<table class="form-table">
	<tbody>
		<?php if ( get_uploaded_header_images() ) : ?>
	<tr valign="top">
	<th scope="row">Uploaded Images</th>
	<td>
		<p>You can choose one of your previously uploaded headers, or show a random one.</p>
		<?php
			$this->show_header_selector( 'uploaded' );
		?>
	</td>
	</tr>
		<?php endif;
		if ( ! empty( $this->default_headers ) ) : ?>
	<tr valign="top">
	<th scope="row">Default Images</th>
	<td>
	<?php if ( current_theme_supports( 'custom-header', 'uploads' ) ) : ?>
		<p>If you don&lsquo;t want to upload your own image, you can use one of these cool headers, or show a random one.</p>
	<?php else: ?>
		<p>You can use one of these cool headers or show a random one on each page.</p>
	<?php endif; ?>
		<?php
			$this->show_header_selector( 'default' );
		?>
	</td>
	</tr>
		<?php endif;
		if ( get_header_image() ) : ?>
	<tr valign="top">
	<th scope="row">Remove Image</th>
	<td>
		<p>This will remove the header image. You will not be able to restore any customizations.</p>
		<?php submit_button(  'Remove Header Image' , 'button', 'removeheader', false ); ?>
	</td>
	</tr>
		<?php endif;

		$default_image = get_theme_support( 'custom-header', 'default-image' );
		if ( $default_image && get_header_image() != $default_image ) : ?>
	<tr valign="top">
	<th scope="row">Reset Image</th>
	<td>
		<p>This will restore the original header image. You will not be able to restore any customizations.</p>
		<?php submit_button( 'Restore Original Header Image', 'button', 'resetheader', false ); ?>
	</td>
	</tr>
		<?php endif; ?>
	</tbody>
	</table>

	<?php if ( current_theme_supports( 'custom-header', 'header-text' ) ) : ?>

	<h3>Header Text</h3>

	<table class="form-table">
	<tbody>
	<tr valign="top">
	<th scope="row">Header Text</th>
	<td>
		<?php // This is all for compatibility with versions of WordPress prior to 3.4. ?>
		<?php if ( function_exists('display_header_text') )  { ?>
			<p>
			<label><input type="checkbox" name="display-header-text" id="display-header-text"<?php checked( display_header_text() ); ?> /> Show header text with your image.</label>
			</p>
		<?php } else { ?>		
			<p>
			<?php $hidetext = get_theme_mod( 'header_textcolor', '' );
				$hidetext = ($hidetext == 'blank') ? false : true;
			 ?>
			<label><input type="checkbox" name="display-header-text" id="display-header-text"<?php checked( $hidetext ); ?> /> Show header text with your image.</label>
			</p>		
		<?php } ?>
	</td>
	</tr>

	<tr valign="top">
	<th scope="row">Make Header link to home page</th>
	<td>
		<p>
		<?php $linkheader = $this->theme_options['linkheader']; ?>
		<label><input type="radio" value="0" name="linkheader" id="dontlinkheader"<?php checked( !$linkheader ? true : false ); ?> /> No</label>
		<label><input type="radio" value="1" name="linkheader" id="linkheader"<?php checked( $linkheader ? true : false ); ?> /> Yes</label>
		</p>
	</td>
	</tr>

	</tbody>
	</table>
<?php endif; ?>

<h3>Header Featured Area</h3>
<p>This theme allows you a great deal of control over how to display and use the "Featured Area" located at the top of your blog pages. This area is designed to feature a single post on the home page, category pages, or on all pages of your site - you can choose which. You can also feature one unique post on your home page, and separate posts on each of your category pages. You can set which post to display on your home page or category pages, use the "Feature Post" controls while you are editing a Post.</p>

	<table class="form-table">
	<tbody>
	<tr valign="top">
	<td>
		<p>
		<?php $featured_area = $this->theme_options['featured_area']; ?>
		<label><input type="radio" value="show" name="featured_area" id="featured_area"<?php checked( ( $featured_area == 'show' )  ? true : false ); ?> /> Show Featured Area on Home &amp; Category Pages Only</label><br/>
		<label><input type="radio" value="showall" name="featured_area" id="featured_area"<?php checked( ( $featured_area == 'showall' ) ? true : false ); ?> /> Show Featured Area on All Pages</label><br/>
		<label><input type="radio" value="noshow" name="featured_area" id="featured_area"<?php checked( ( $featured_area == 'noshow' )  ? true : false ); ?> /> Hide Featured Area on All Pages</label><br/>
		</p>
	</td>
	</tr>
	</tbody>
	</table>
<div class="clear">&nbsp;</div>

<?php 
	do_action( 'custom_header_options' );
	wp_nonce_field( 'custom-header-options', '_wpnonce-custom-header-options' );
?>
<p class="submit"><input type="submit" class="button-primary" name="save-header-options" value="<?php echo esc_attr( 'Save Changes' ); ?>" /></p>
<input type="hidden" name="exp-custom-header" value="" />

<div id="color-picker" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
</form>
</div>

<?php }


}
?>