<?php
/**
 * GeoProjects common UTILS functions
 *
 * package GeoProjects
 * s@since GeoProjects 1.0
 */


/**
 * Convert an array of markers object to an array of markers arrays with all available infos
 */
function gp_get_markers_infos_from_obj( $markers_objects ) {
	$markers_array = array();

	if ( count( $markers_objects ) > 0 ) {

		foreach ( $markers_objects as $index => $m ) {

			// Get Marker Content in order
			$marker_content = array();
			$marker_content_order = get_post_meta( $m->ID, 'gp_popup_content_order', true );

			if ( $marker_content_order != '' ) {
				$content_order_array = explode( ',', $marker_content_order );

				foreach( $content_order_array as $content_type ) {
					
					switch( $content_type ) {

						case 'text':
							$marker_content[$content_type] = get_post_meta( $m->ID, 'gp_popup_' . $content_type, true );
							break;

						case 'image':
							// If this image is the only content, get the big sized else get the ribbon
							$imgInfos = wp_get_attachment_image_src(
								get_post_meta( $m->ID, 'gp_popup_' . $content_type, true ),
								( count( $content_order_array ) > 1 ) ? 'gp-marker-popup-ribbon' : 'gp-marker-popup'
							);

							$marker_content[$content_type] = array(
								'src' 	=> $imgInfos[0],
								'w'		=> $imgInfos[1],
								'h' 	=> $imgInfos[2]
							);
							break;

						case 'video':
							$video_url = get_post_meta( $m->ID, 'gp_popup_' . $content_type, true );
							$marker_content[$content_type] = wp_oembed_get( $video_url, array( 'width' => 300 ) );
							break;

						case 'audio':
							$audio_url = wp_get_attachment_url( get_post_meta( $m->ID, 'gp_popup_' . $content_type, true ) );
							$marker_content[$content_type] = do_shortcode( '[audio mp3="' . $audio_url . '"][/audio]' );
							break;

					}

				}

			}

			// Get post status
			$m_status = '';

			switch ( $m->post_status ) {

				case 'draft':
					$m_status = '<em class="visuallyhidden">-</em> <i class="status-draft">' . __( 'draft', 'lang_geoprojects' ) . '</i>';
					break;

				case 'private':
					$m_status = '<em class="visuallyhidden">-</em> <i class="status-private">' . __( 'private', 'lang_geoprojects' ) . '</i>';
					break;

			}

			// Add to Markers infos array
			$markers_array[] = array(
				'id' 			=> $m->ID,
				'pmlnk'			=> get_permalink( $m->ID ),
				'editlnk'		=> ( current_user_can( 'edit_others_posts' ) ) ? get_admin_url() . 'post.php?post=' . $m->ID . '&action=edit' : '',
				'title' 		=> $m->post_title . ' ' . $m_status,
				'lat' 			=> get_post_meta( $m->ID, 'gp_lat', true ),
				'lng' 			=> get_post_meta( $m->ID, 'gp_lng', true ),
				'icon'			=> gp_get_all_icon_infos( get_post_meta( $m->ID, 'gp_icon_type', true ), get_post_meta( $m->ID, 'gp_icon_filename', true ) ),
				'contt' 	 	=> $marker_content
			);

		}

	}

	return $markers_array;

}


/**
 * Get all infos of a given icon
 */
function gp_get_all_icon_infos( $icon_type = 'default', $icon_filename = GP_DEFAULT_MARKER_FILE ) {
	$icon_infos = array();
	$icon_type = ( in_array( $icon_type, array( 'default', 'custom' ) ) ) ? $icon_type : 'default';
	$iconPath = ( $icon_type == 'default' ) ? GP_PATH_DEFAULT_MARKERS_ICONS . '/' . $icon_filename : GP_PATH_CUSTOM_MARKERS_ICONS . '/' . $icon_filename;

	// Icon file exists ?
	if ( file_exists( $iconPath ) ) {

		$icon_infos = array(
			'icon'		=> $icon_filename,
			'icon_type'	=> $icon_type
		);

		$icon_size = getimagesize( $iconPath );

		$icon_infos['icon_url'] = ( $icon_type == 'default' ) ? GP_URL_DEFAULT_MARKERS_ICONS . '/' . $icon_filename : GP_URL_CUSTOM_MARKERS_ICONS . '/' . $icon_filename;
		$icon_infos['icon_size'] = array( 'x' => $icon_size[0], 'y' => $icon_size[1] );

	}

	return $icon_infos;

}


/**
 * Output JSON encoded array given in argument
 * @param  array  $output Array of data
 * @return JSON           JSON encoded data
 */
function gp_output_json( $output = array() ) {

	header( "Content-Type: application/json" );
	echo json_encode( $output );
	exit();

}