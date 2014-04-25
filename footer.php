<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package GeoProjects
 */
?>
				</div> <?php /* #main-content-inner */ ?>

			</div> <?php /* #wrap-main-content */ ?>

    	</div> <?php /* #main */ ?>

    </div> <?php /* #page */ ?>

    <footer id="colophon" class="site-footer" role="contentinfo">
		
		<?php
		// Footer Widgets
		if ( is_active_sidebar( 'footer-widgets' ) ) :

			// Count widgets
			$the_sidebars = wp_get_sidebars_widgets();
			$nb_widgets = count( $the_sidebars['footer-widgets'] );
			?>
			
			<div class="footer-widgets nb-widgets-<?php echo $nb_widgets; ?> clearfix">
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
			</div>

		<?php endif; ?>

		<p class="created-by-labomedia">
			<a href="http://labomedia.org" target="_blank">
				<span><?php _e( 'Theme created by Labomedia', 'lang_geoprojects' ); ?></span>
			</a>
		</p>

	</footer>

    <?php wp_footer(); ?>

  </body>
</html>