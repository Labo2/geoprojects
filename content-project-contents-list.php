<?php
/**
 * Content for the project maps/posts list
 * 
 * @package GeoProjects
 * @since GeoProjects 1.0
 */
?>

<?php
$project_ID = get_the_ID();

// Get maps and posts in this project
$project_contents = gp_query_get_project_contents( $project_ID );

if ( count( $project_contents ) > 0 ) : ?>

	<div class="project-contents-list">
		<div class="project-contents-list-inner">

		<?php foreach ( $project_contents as $post ) : setup_postdata( $post ); ?>

			<?php
			$post_types = array(
				'post' 		=> 'post',
				'maps' 		=> 'map'
			);
			?>

			<article class="<?php echo $post_types[$post->post_type]; ?>-in-list">
				
				<?php if ( $post->post_type == 'post' ) : ?>

					<div class="inner-wrap">

						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">

							<h1><?php the_title(); ?></h1>

							<p>
								<?php echo gp_get_custom_excerpt( 'post-in-project-list', false ) ?>
							</p>

						</a>

					</div>

				<?php elseif ( $post->post_type == 'maps' ) : ?>

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

					<div class="inner-wrap" <?php echo $bloc_css; ?>>

						<h1>
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
								<?php the_title(); ?>
							</a>
						</h1>

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

				<?php endif; ?>

			</article>

		<?php endforeach; ?>

		<?php wp_reset_postdata(); ?>

	</div>

<?php endif; ?>