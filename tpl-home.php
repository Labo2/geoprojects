<?php
/**
 * Template Name: Home page
 * 
 * @package GeoProjects
 */

get_header();

$gp_options = get_option( 'gp_options' );
?>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<?php

		// Get maps list
		$maps_list = gp_query_get_maps(
			array(
				'orderby'			=> 'date',
				'order'				=> 'DESC',
				'posts_per_page'	=> $gp_options['front_nb_maps'],
				'offset'			=> 0
			)
		);

		// Is there maps ?
		if ( count( $maps_list ) > 0 ) : ?>

			<section class="front-maps-list-wrap clearfix">

				<h1 class="txt-on-bg"><?php _e( 'Last maps', 'lang_geoprojects' ); ?></h1>

				<div class="front-maps-list">

					<?php foreach ( $maps_list as $post ) : setup_postdata( $post ); ?>

						<?php
						// Has featured image ?
						$has_post_thumb = has_post_thumbnail();
						$bloc_css = '';

						if ( $has_post_thumb ) {
							$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'gp-front-map-fimg' );
							$featured_img_url = $featured_img[0];
							$bloc_css = 'style="background:#fff url(' . $featured_img_url . ') center center no-repeat"';
						}
						?>

						<article class="front-map">
							<div class="front-map-inner-wrap" <?php echo $bloc_css; ?>>

								<header>

									<h1>
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
											<?php the_title(); ?>
										</a>
									</h1>

									<?php
									// Get map's project
									$map_project_ID = get_post_meta( get_the_ID(), 'gp_project', true );

									if ( $map_project_ID != 0 ) :
										$map_project = gp_query_get_project( $map_project_ID );

										if ( $map_project != '' ) : ?>
											
											<p class="front-map-project">
												<?php _e( 'Project', 'lang_geoprojects' ); ?> :
												<a href="<?php echo get_permalink( $map_project ); ?>" title="<?php echo esc_attr( $map_project->post_title ); ?>">
													<?php echo $map_project->post_title; ?>
												</a>
											</p>

											<?php
										endif;
									endif;
									?>

								</header>

								<?php if ( $has_post_thumb ) : ?>

									<a href="<?php the_permalink(); ?>" class="map-more" title="<?php _e( 'See the map', 'lang_geoprojects' ); ?>">
										<span class="visuallyhidden"><?php _e( 'See the map', 'lang_geoprojects' ); ?></span>
									</a>

								<?php else :

									// Load Leaflet
									gp_load_frontend_leaflet();

									$map_tiles_provider = get_post_meta( get_the_ID(), 'gp_tiles_provider', true );
								    if ( $map_tiles_provider == '' ) {
								        $map_tiles_provider = GP_DEFAULT_TILES_PROVIDER;
								    }

								    if ( $map_tiles_provider == 'cloudmade' ) {
								        $map_cloudmade_style = get_post_meta( get_the_ID(), 'gp_cloudmade_style', true );
								        if ( $map_cloudmade_style == '' ) {
								            $map_cloudmade_style = GP_DEFAULT_CLOUDMADE_STYLE;
								        }
								    }
									?>

									<div class="gp-leaflet-map-container">
								        <div class="gp-leaflet-map-wrap">
								            <div id="gp-map-<?php the_ID(); ?>" class="gp-leaflet-map"
								            	data-map-id="<?php the_ID(); ?>"
								            	data-map-tiles="<?php echo $map_tiles_provider; ?>"
								                <?php if ( isset( $map_cloudmade_style ) ) : ?>
								                    data-map-cloudmade-style="<?php echo $map_cloudmade_style; ?>"
								                <?php endif; ?>
								            	data-map-clusterize="0"
								            	data-map-controls="0"
								            	data-map-drag="0"
								            	data-map-popups="0"
								            	data-map-permalink="<?php the_permalink(); ?>"></div>
								        </div>
								    </div>

								<?php endif; ?>									

							</div>
						</article>

					<?php endforeach; ?>

					<?php wp_reset_postdata(); ?>

				</div>

			</section>

		<?php else : ?>

			<p class="gp-info">
				<?php _e( 'You should create at least 1 map for seeing it here.', 'lang_geoprojects' ); ?>
			</p>

		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>

