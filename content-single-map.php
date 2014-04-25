<?php
/**
 * Content for a single maps
 * 
 * @package GeoProjects
 */
?>

<article class="type-maps">
	
	<header class="map-header">
	
		<h1 class="map-title"><?php the_title(); ?></h1>

        <?php
        $map_project_ID = get_post_meta( get_the_ID(), 'gp_project', true );

        if ( $map_project_ID != 0 ) :
            $map_project = gp_query_get_project( $map_project_ID );

            if ( $map_project != '' ) : ?>
                
                <p class="map-project">
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

	<?php
	// Load Leaflet
    gp_load_frontend_leaflet();

    $gp_options = get_option( 'gp_options' );

    $map_tiles_provider = get_post_meta( get_the_ID(), 'gp_tiles_provider', true );
    $map_export = get_post_meta( get_the_ID(), 'gp_export', true );
    if ( $map_export == '' ) { $map_export = $gp_options['export_maps']; }
	?>

	<div class="gp-leaflet-map-container">
        <div class="gp-leaflet-map-wrap">
            <div id="gp-map-<?php the_ID(); ?>" class="gp-leaflet-map"
            	data-map-id="<?php the_ID(); ?>"
            	data-map-tiles="<?php echo $map_tiles_provider; ?>"
                <?php if ( $map_tiles_provider == 'cloudmade' ) : ?>
                    data-map-cloudmade-style="<?php echo get_post_meta( get_the_ID(), 'gp_cloudmade_style', true ); ?>"
                <?php endif; ?>
            	data-map-clusterize="1"
                data-map-markers-index="1"
                <?php if ( $map_export ) : ?>
                    data-map-export="1"
                <?php endif;?>
                ></div>
        </div>
    </div>

	<div class="map-content">

		<?php the_content(); ?>

	</div>

</article>
