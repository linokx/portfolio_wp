<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=bd div and all content
 * after. 
 *
 * @package WordPress
 * @subpackage TravelBlogger
 * @since TravelBlogger Theme 1.0
 */
 global $exp_theme_options;
 $footerlinks = $exp_theme_options['footer_links'];
?>
<footer>
	<div id="site-info">
			<?php wp_nav_menu( array( 'menu_class' => 'footer-links', 'depth' => '1', 'theme_location' => 'footer', 'fallback_cb' => 'wp_page_menu'  ) ); ?>
			<div class="coord">
				<a href="wp-content/uploads/cv.pdf" id="cv" title="Cv de Ludovic Bekaert" type="application/pdf">Télécharger mon CV (pdf)</a>
				<p itemscope itemtype="http://schema.org/Person">
					<span itemprop="name">Ludovic Bekaert</span><br/>
					<span itemprop="email">Linokx@hotmail.com</span><br/>
					<span itemprop="telephone">Tél.: 0498/47.18.48</span><br/>
					<span itemprop="addressLocality">Mouscron</span> (<span itemprop="addressCountry">Belgique</span>)
				</p>
			</div>
			<?php mailchimpSF_signup_form(); ?>
	</div><!-- #site-info -->
</footer><!-- #doc -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	//wp_footer();
?>
</body>
</html>
