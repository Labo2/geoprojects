<?php
/**
 * Content for a single markers
 * 
 * @package GeoProjects
 * @since GeoProjects 1.0
 */
?>

<article class="type-markers">
	
	<header class="marker-header">
	
		<h1 class="marker-title"><?php the_title(); ?></h1>

	</header>

	<div class="marker-content">

		<?php the_content(); ?>

	</div>

    <?php
    $marker_map_ID = get_post_meta( get_the_ID(), 'gp_map', true );

    if ( $marker_map_ID != 0 ) :
        $marker_map = gp_query_get_map( $marker_map_ID );

        if ( $marker_map != '' ) :
            $marker_map_project_ID = get_post_meta( $marker_map->ID, 'gp_project', true );
            ?>

            <footer class="marker-meta">

                <p class="same-map-title">
                    <?php _e( 'In the same map', 'lang_geoprojects' ); ?> :
                </p>

                <h2>
                    <a href="<?php echo get_permalink( $marker_map ); ?>" title="<?php _e( 'See this map', 'lang_geoprojects' ); ?>">
                        <?php echo $marker_map->post_title; ?>
                    </a>
                </h2>

                <?php
                if ( $marker_map_project_ID != '' ) :
                    $marker_map_project = gp_query_get_project( $marker_map_project_ID );

                    if ( $marker_map_project != '' ) : ?>

                        <p class="marker-project">
                            <?php _e( 'Project', 'lang_geoprojects' ); ?> :
                            <a href="<?php echo get_permalink( $marker_map_project ); ?>" title="<?php _e( 'See this project', 'lang_geoprojects' ); ?>">
                                <?php echo $marker_map_project->post_title; ?>
                            </a>
                        </p>

                    <?php endif; ?>

                <?php endif; ?>

                <?php
                // Load Leaflet
                gp_load_frontend_leaflet();
                ?>

                <div class="gp-leaflet-map-container">
                    <div class="gp-leaflet-map-wrap">
                        <div id="gp-map-marker-<?php echo $marker_map_ID; ?>" class="gp-leaflet-map"
                            data-map-id="<?php echo $marker_map_ID; ?>"
                            data-map-tiles="osm"
                            data-map-clusterize="1"
                            data-map-markers-index="1"
                            data-map-open-marker="<?php the_ID(); ?>"></div>
                    </div>
                </div>

            </footer>

        <?php endif; ?>

    <?php endif; ?>

</article>