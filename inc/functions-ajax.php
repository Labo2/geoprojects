<?php
/**
 * GeoProjects AJAX functions
 *
 * @package GeoProjects
 */


/**
 * Return all markers list
 * If current user is editor, show all markers or else show only published markers in published maps
 * @return Echo JSON
 */
function gp_ajax_get_all_markers() {
	$markers = array();

	if ( current_user_can( 'edit_others_posts' ) ) {

		$markers_objects = gp_query_get_markers( array( 'post_status' => 'any' ) );

		if ( count( $markers_objects ) > 0 ) {
			$markers = gp_get_markers_infos_from_obj( $markers_objects );
		}

	}
	else {

		// Get published markers
		$published_markers = gp_query_get_markers( array( 'post_status' => 'publish' ) );

		// Get Published maps
		$published_maps = gp_query_get_maps( array( 'post_status' => 'publish' ) );

		// Filter markers to keep only the ones in published maps
		
		if ( count( $published_markers ) > 0 && count( $published_maps ) > 0 ) {
			$filtered_markers = array();
			$published_maps_IDs = array();
			
			// Get published maps IDs
			foreach ( $published_maps as $pMap ) {
				$published_maps_IDs[] = $pMap->ID;
			}

			foreach ( $published_markers as $pMarker ) {
				$marker_map = get_post_meta( $pMarker->ID, 'gp_map', true );

				if ( in_array( $marker_map, $published_maps_IDs ) ) {
					$filtered_markers[] = $pMarker;
				}
			}

			if ( count( $filtered_markers ) > 0 ) {
				$markers = gp_get_markers_infos_from_obj( $filtered_markers );
			}
		}

	}

	gp_output_json( $markers );

}

add_action( 'wp_ajax_gp-get-all-markers', 'gp_ajax_get_all_markers' );
add_action( 'wp_ajax_nopriv_gp-get-all-markers', 'gp_ajax_get_all_markers' );


/**
 * Return Map markers list
 * @return Echo JSON
 */
function gp_ajax_get_map_markers() {
	$map_markers = array();

	// Given ID ?
	if ( isset( $_GET['id'] ) && $_GET['id'] != '' ) {

		// If connected as editor, show all markers or else show only published
		$params = ( current_user_can( 'edit_others_posts' ) ) ? array( 'post_status' => 'any' ) : array();

		$markers = gp_query_get_map_markers( $_GET['id'], $params );

		// Markers in map ?
		if ( count( $markers ) > 0 ) {

			$map_markers = gp_get_markers_infos_from_obj( $markers );

		}

	}

	gp_output_json( $map_markers );

}

add_action( 'wp_ajax_gp-get-map-markers', 'gp_ajax_get_map_markers' );
add_action( 'wp_ajax_nopriv_gp-get-map-markers', 'gp_ajax_get_map_markers' );


/**
 * Return the HTML of markers icons list
 * @return Echo HTML
 */
function gp_ajax_get_markers_icons_list() {

	if ( isset( $_GET['list_type'] ) ) {
		$list_type = ( in_array( $_GET['list_type'], array( 'default', 'custom' ) ) ) ? $_GET['list_type'] : 'default';
		gp_get_markers_icons_list( $list_type );
	}

	exit();

}

add_action( 'wp_ajax_gp-get-markers-icons-list', 'gp_ajax_get_markers_icons_list' );


/**
 * Return a given image preview
 * @return Echo HTML
 */
function gp_ajax_get_mbox_image_preview() {
    echo wp_get_attachment_image( $_GET['id'], 'medium' );
    exit();
}

add_action( 'wp_ajax_gp-get-mbox-image-preview', 'gp_ajax_get_mbox_image_preview' );


/**
 * Return a given audio file preview (mediaelement HTML)
 * @return Echo HTML
 */
function gp_ajax_get_mbox_audio_preview() {

	if ( isset( $_GET['id'] ) && $_GET['id'] != '' ) {
		echo do_shortcode( '[audio mp3="' . wp_get_attachment_url( $_GET['id'] ) . '"][/audio]' );
	}

    exit();
}

add_action( 'wp_ajax_gp-get-mbox-audio-preview', 'gp_ajax_get_mbox_audio_preview' );


/**
 * Return a given video preview
 * @return Echo HTML
 */
function gp_ajax_get_video_player() {
    
	if ( $_GET['url'] != '' ) {
		echo wp_oembed_get( $_GET['url'] );
	}

    exit();
}

add_action( 'wp_ajax_gp-get-video-player', 'gp_ajax_get_video_player' );


/**
 * Return requested icon infos (src, size)
 * @return Echo JSON
 */
function gp_ajax_get_all_icon_infos() {
	$icon_infos = array();

	if ( isset( $_GET['icontype'] ) && isset( $_GET['iconfilename'] ) ) {
		$icon_infos = gp_get_all_icon_infos( $_GET['icontype'], $_GET['iconfilename'] );
	}

	gp_output_json( $icon_infos );

}

add_action( 'wp_ajax_gp-get-all-icon-infos', 'gp_ajax_get_all_icon_infos' );