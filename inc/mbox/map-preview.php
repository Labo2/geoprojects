<?php
/**
 * Metabox : "Map Preview"
 * Post types : maps
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */


/**
 * Register Metabox
 */
function gp_mbox_map_preview() {
  	add_meta_box( 'mbox_map_preview', __( 'Map Preview', 'lang_geoprojects' ), 'gp_mbox_map_preview_content', 'maps', 'normal', 'core' );
}

add_action( 'add_meta_boxes', 'gp_mbox_map_preview' );


/**
 * Content of the Metabox
 * @param object $post Post Object
 */
function gp_mbox_map_preview_content( $post ) {
	$map_id = ( $post->post_status == 'auto-draft' ) ? 0 : $post->ID;
    
    $map_tiles_provider = get_post_meta( $post->ID, 'gp_tiles_provider', true );
    if ( $map_tiles_provider == '' ) {
        $map_tiles_provider = GP_DEFAULT_TILES_PROVIDER;
    }

    if ( $map_tiles_provider == 'cloudmade' ) {
        $map_cloudmade_style = get_post_meta( $post->ID, 'gp_cloudmade_style', true );
        if ( $map_cloudmade_style == '' ) {
            $map_cloudmade_style = GP_DEFAULT_CLOUDMADE_STYLE;
        }
    }
	?>

    <p class="mbox-map-add-markers">
        <?php printf(
            '<a href="%1$s">%2$s</a> <span>(%3$s)</span>',
            admin_url( 'post-new.php?post_type=markers&map=' . $map_id ),
            __( 'Add markers in this map', 'lang_geoprojects' ),
            __( 'Save this map before clicking', 'lang_geoprojects' )
        ); ?>
    </p>
	
	<div class="gp-leaflet-map-container">
        <div class="gp-leaflet-map-wrap">
            <div id="mbox-map-preview-map" class="gp-leaflet-map"
            	data-map-id="<?php echo $map_id; ?>"
            	data-map-tiles="<?php echo $map_tiles_provider; ?>"
                <?php if ( isset( $map_cloudmade_style ) ) : ?>
                    data-map-cloudmade-style="<?php echo $map_cloudmade_style; ?>"
                <?php endif; ?>
            	data-map-clusterize="1"></div>
        </div>
    </div>

	<?php
}