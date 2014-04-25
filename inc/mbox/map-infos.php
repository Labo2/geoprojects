<?php
/**
 * Metabox : "Infos"
 * Post types : maps
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */


/**
 * Register Metabox
 */
function gp_mbox_map_infos() {
    add_meta_box( 'mbox_map_infos', __( 'Infos', 'lang_geoprojects' ), 'gp_mbox_map_infos_content', 'maps', 'side', 'core' );
}

add_action( 'add_meta_boxes', 'gp_mbox_map_infos' );


/**
 * Content of the Metabox
 * @param object $post Post Object
 */
function gp_mbox_map_infos_content( $post ) {
    $gp_options = get_option( 'gp_options' );

    // Nonce Field
    wp_nonce_field( plugin_basename( __FILE__ ), 'mbox_map_infos_nonce' );

    // Add tiles provider choice only if Cloudmade API key is set, otherwise the only choice is OpenStreetMap so no need to display
    if ( $gp_options['cloudmade_api_key'] != GP_DEFAULT_CLOUDMADE_API_KEY ) :
	
        // Get fields values
        $gp_tiles_provider = get_post_meta( $post->ID, 'gp_tiles_provider', true );
        $gp_cloudmade_style = get_post_meta( $post->ID, 'gp_cloudmade_style', true );

        if ( $gp_tiles_provider == '' ) {
            $gp_tiles_provider = GP_DEFAULT_TILES_PROVIDER;
            $gp_cloudmade_style = GP_DEFAULT_CLOUDMADE_STYLE;
        }
    	?>

        <p class="mbox-label">
            <?php _e( 'Choose a tiles provider :', 'lang_geoprojects' ); ?>
        </p>

        <p class="gp-tiles-provider-elt">
            <label title="OpenStreetMap">
                <input type="radio" name="gp-tiles-provider" value="osm" <?php echo ( $gp_tiles_provider == 'osm' ) ? 'checked="checked"' : ''; ?>>
                OpenStreetMap
            </label>
        </p>

        <p class="gp-tiles-provider-elt">
            <label title="Cloudmade">
                <input type="radio" name="gp-tiles-provider" value="cloudmade" <?php echo ( $gp_tiles_provider == 'cloudmade' ) ? 'checked="checked"' : ''; ?>>
                Cloudmade
                <span class="gp-cloudmade-style">
                    Style ID : 
                    <input type="text" class="small-text" name="gp-cloudmade-style" value="<?php echo $gp_cloudmade_style; ?>">
                    (default : 997)
                </span>
            </label>
        </p>

        <p class="description">
            <?php _e( '(Save this map to update the preview)', 'lang_geoprojects' ); ?>
        </p>

    	<?php
    endif;

    // Export Map
    $meta_export_map = get_post_meta( $post->ID, 'gp_export', true );
    $meta_export_map = ( $meta_export_map == '' ) ? $gp_options['export_maps'] : $meta_export_map;
    ?>

    <p class="mbox-label">
        <?php _e( 'Export', 'lang_geoprojects' ); ?>
    </p>

    <p>
        <label for="gp-export">
            <input type="checkbox" id="gp-export" name="gp-export" value="<?php echo GP_DEFAULT_EXPORT_MAPS; ?>" <?php if ( $meta_export_map == GP_DEFAULT_EXPORT_MAPS ) { echo 'checked="checked"'; } ?>>
            <?php _e( 'Allow sharing this map (iframe)', 'lang_geoprojects' ); ?>
        </label>
    </p>

    <?php

}


/**
 * Save the Metaboxes data
 * @param  Int $post_id ID of the post
 */
function gp_save_mbox_map_infos( $post_id ) {
  
    // Don't do anything for auto-save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return $post_id;

    // No nonce ?
    if( !isset( $_POST['mbox_map_infos_nonce'] ) )
        return $post_id;

    // Check nonce
    if ( !wp_verify_nonce( $_POST['mbox_map_infos_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_posts', $post_id ) )
        return;

    // Export map
    $gp_export = ( isset( $_POST['gp-export'] ) && $_POST['gp-export'] == GP_DEFAULT_EXPORT_MAPS ) ? GP_DEFAULT_EXPORT_MAPS : 0;
    update_post_meta( $post_id, 'gp_export', $gp_export );

    // If tiles provider choice is displayed
    if ( isset( $_POST['gp-tiles-provider'] ) ) {
        update_post_meta( $post_id, 'gp_tiles_provider', $_POST['gp-tiles-provider'] );
        update_post_meta( $post_id, 'gp_cloudmade_style', $_POST['gp-cloudmade-style'] );
    }

}

add_action( 'save_post', 'gp_save_mbox_map_infos' );