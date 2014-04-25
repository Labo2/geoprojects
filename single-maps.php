<?php
/**
 * The Template for displaying all single maps.
 *
 * WARNING : 
 * This page is used for single maps and for exported maps (iframes)
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */

// Exported Map
if ( isset( $_GET['embed'] ) && $_GET['embed'] == 1 ) :

	include_once( get_template_directory() . '/export-map.php' );


// Single Map
else :

	get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single-map' ); ?>

			<?php
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
			?>

		<?php endwhile; ?>

		</div>
	</div>

	<?php get_sidebar( 'single-map' ); ?>

	<?php get_footer(); ?>

<?php endif; // End single map ?>