<?php
/**
 * The Sidebar for a single map
 * - Show the contents in the same project than the map
 * - Show the last maps if there is less than X other contents
 *
 * @package GeoProjects
 */
?>
<div id="secondary" role="complementary">

		<?php /* CONTENTS IN SAME PROJECT */ ?>

		<?php
		$project_contents_total = 0;
		$map_project_ID = get_post_meta( get_the_ID(), 'gp_project', true );

		if ( $map_project_ID != 0 ) :
			
			if ( gp_query_exists_project( $map_project_ID ) ) :

				$project_contents = gp_query_get_project_contents(
					$map_project_ID,
					array(
						'post__not_in' => array( get_the_ID() )
					) 
				);

				$project_contents_total = count( $project_contents );

				if ( $project_contents_total > 0 ) : ?>

					<aside class="side-same-project">

						<h1 class="side-title txt-on-bg"><?php _e( 'In the same Project', 'lang_geoprojects' ); ?></h1>

						<ul class="clearfix">
					
							<?php
							// Loop through project contents
							foreach ( $project_contents as $post ) : setup_postdata( $post ); ?>

								<?php
								$post_types = array(
									'post' 		=> 'post',
									'maps' 		=> 'map'
								);

								$content_permalink = get_permalink( $post );
								?>

								<li class="side-same-project-<?php echo $post_types[$post->post_type]; ?>">

									<?php
									// Content type MAPS
									if ( $post->post_type == 'maps' ) : ?>

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

										<div class="side-same-project-inner" <?php echo $bloc_css; ?>>

											<h1>
												<a href="<?php echo $content_permalink; ?>" title="<?php the_title(); ?>">
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
											            <div id="gp-same-project-map-<?php the_ID(); ?>" class="gp-leaflet-map"
											            	data-map-id="<?php the_ID(); ?>"
											            	data-map-tiles="<?php echo $map_tiles_provider; ?>"
											                <?php if ( isset( $map_cloudmade_style ) ) : ?>
											                    data-map-cloudmade-style="<?php echo $map_cloudmade_style; ?>"
											                <?php endif; ?>
											            	data-map-clusterize="0"
											            	data-map-controls="0"
											            	data-map-drag="0"
											            	data-map-popups="0"
											            	data-map-permalink="<?php echo $content_permalink; ?>"></div>
											        </div>
											    </div>

											<?php endif; ?>

										</div>

									<?php endif; ?>

									<?php
									// Content type POST
									if ( $post->post_type == 'post' ) : ?>

										<div class="side-same-project-inner">

											<a href="<?php echo $content_permalink; ?>" class="side-same-project-post-wrap" title="<?php the_title(); ?>">

												<h1>
													<?php the_title(); ?>
												</h1>

												<p>
													<?php echo gp_get_custom_excerpt( 'side-map', false ); ?>
												</p>

											</a>

										</div>

									<?php endif; ?>

								</li>

							<?php endforeach; wp_reset_postdata(); ?>

						</ul>

					</aside>

					<?php
				endif;
			endif;
		endif;
		?>


		<?php /* LASTS MAPS */ ?>

		<?php
		// If more than X other contents in the same project
		if ( $project_contents_total <= GP_NB_OTHER_CONTENTS_IN_SAME_PROJECT_TRIGGER_LAST_MAPS ) : ?>

			<?php
			gp_the_side_last_maps( array( 
				'max_maps' 		=> GP_NB_SIDE_LAST_MAPS - $project_contents_total,
				'excluded_maps'	=> array( get_the_ID() )
			));
			?>

		<?php endif; ?>

</div>