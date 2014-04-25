<?php
/**
 * Template : Help - Credits
 */
?>

<div id="page_help" class="wrap">
  
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e( 'Help and Credits', 'lang_geoprojects' ); ?></h2>

	<h3>
		<?php _e( 'Organization of Contents', 'lang_geoprojects' ); ?>
	</h3>

	<p>
		<?php _e( 'The GeoProjects Wordpress theme adds 3 content types : Projects, Maps and Markers.', 'lang_geoprojects' ); ?>
	</p>
	<p>
		<?php _e( 'A Map contain markers and can be associated to a Project. You can also associate the traditionnals Wordpress posts to Projects.', 'lang_geoprojects' ); ?>
	</p>
	<p>
		<?php _e( 'Markers can contain text, images, sound or video (and a mix of them), and you can provide you own icons to show up on the maps.', 'lang_geoprojects' ); ?>
	</p>

	<h3>
		<?php _e( 'Home page', 'lang_geoprojects' ); ?>
	</h3>

	<p>
		<?php _e( 'You can set your Home page to show the list of lasts created maps instead of the last posts. Follow this instructions to do so :', 'lang_geoprojects' ); ?>
	</p>

	<ul class="gp-help-list">
		<li><?php _e( 'Create a page named "Home" (for exemple), and set its "Model" as "Home Page" in the right "Page Attributes" bloc', 'lang_geoprojects' ); ?></li>
		<li><?php _e( 'Create another page which will display your blog posts', 'lang_geoprojects' ); ?></li>
		<li><?php _e( 'Go to Settings > Reading, and in the "Front page displays" option, choose "A static page" with your Home page as "Front page" and your blog page as "Posts page"', 'lang_geoprojects' ); ?></li>
	</ul>

	<h3>
		<?php _e( 'Big Map Page', 'lang_geoprojects' ); ?>
	</h3>

	<p>
		<?php _e( 'The GeoProjects theme comes with a special page showing all Markers of all Maps.', 'lang_geoprojects' ); ?>
	</p>

	<p>
		<?php _e( 'To use it, create a new Page, and set its "Model" to "Big Map". You can then add this page to your menu.', 'lang_geoprojects' ); ?>
	</p>

	<h3>
		<?php _e( 'Widgets', 'lang_geoprojects' ); ?>
	</h3>

	<p>
		<?php _e( 'This theme has a Widgets zone in the footer, where you can add any of them.', 'lang_geoprojects' ); ?>
	</p>

	<h2>
		<?php _e( 'Credits - License', 'lang_geoprojects' ); ?>
	</h2>

	<p>
		<?php
		printf(
		 	__( 'This Wordpress theme has been developped by %1$s and funded by the %2$s.', 'lang_geoprojects' ),
		 	'<a href="http://labomedia.org" target="_blank">Labomedia</a>',
		 	'<a href="http://bibliotheque.nimes.fr" target="_blank">Carré d\'Art Bibliothèques de Nîmes</a>'
		);
		?>
	</p>

	<p>
		<?php
		printf(
			__( 'Released under the GPL v.2 license, you can download this theme on %1$s. Please, feel free to report bugs and submit fixes or new features !', 'lang_geoprojects' ),
			'<a href="https://github.com/Labomedia/lm-maps-manager">GitHub</a>'
		); ?>
	</p>

</div>