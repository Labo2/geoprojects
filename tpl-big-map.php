<?php
/**
 * Template Name: Big Map
 * 
 * @package GeoProjects
 * @since GeoProjects 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="big-map-page" class="hentry">
				
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>

				<?php
				$content = get_the_content();
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);

				if ( $content != '' ) : ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<?php
				// Load Leaflet
			    gp_load_frontend_leaflet();

			    $gp_options = get_option( 'gp_options' );
			    $big_map_tiles_provider = $gp_options['special_map_tiles_provider'];
			    $big_map_cloudmade_style = $gp_options['special_map_cloudmade_style'];
				?>

				<div class="gp-leaflet-map-container">
			        <div class="gp-leaflet-map-wrap">
			            <div id="gp-big-map" class="gp-leaflet-map"
			            	data-map-id="all"
			            	data-map-tiles="<?php echo $big_map_tiles_provider; ?>"
			                <?php if ( $big_map_tiles_provider == 'cloudmade' ) : ?>
			                    data-map-cloudmade-style="<?php echo $big_map_cloudmade_style; ?>"
			                <?php endif; ?>
			            	data-map-clusterize="1"></div>
			        </div>
			    </div>

			</article>

		<?php endwhile; ?>

	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
