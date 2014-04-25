<?php
/**
 * Metabox : "Marker Infos"
 * Post types : markers
 * Goal : All the marker infos
 *
 * @package GeoProjects
 */


/**
 * Register Metabox
 */
function gp_mbox_marker_infos() {
  	add_meta_box( 'mbox_marker_infos', __( 'Marker Informations', 'lang_geoprojects' ), 'gp_mbox_marker_infos_content', 'markers', 'normal', 'core' );
}

add_action( 'add_meta_boxes', 'gp_mbox_marker_infos' );


/**
 * Content of the Metabox
 * @param object $post Post Object
 */
function gp_mbox_marker_infos_content( $post ) {

	// Get fields values
	$marker_map = get_post_meta( $post->ID, 'gp_map', true );
    $marker_icon_type = get_post_meta( $post->ID, 'gp_icon_type', true );
    $marker_icon_filename = get_post_meta( $post->ID, 'gp_icon_filename', true );
    $marker_popup_content_order = get_post_meta( $post->ID, 'gp_popup_content_order', true );
    $marker_popup_text = get_post_meta( $post->ID, 'gp_popup_text', true );
    $marker_popup_image = get_post_meta( $post->ID, 'gp_popup_image', true );
    $marker_popup_video = get_post_meta( $post->ID, 'gp_popup_video', true );
    $marker_popup_audio = get_post_meta( $post->ID, 'gp_popup_audio', true );
    $marker_lat = get_post_meta( $post->ID, 'gp_lat', true );
    $marker_lng = get_post_meta( $post->ID, 'gp_lng', true );

    if ( $marker_lat == '' ) { $marker_lat = GP_DEFAULT_MAP_CENTER_LAT; }
    if ( $marker_lng == '' ) { $marker_lng = GP_DEFAULT_MAP_CENTER_LNG; }

	// Nonce Field
    wp_nonce_field( plugin_basename( __FILE__ ), 'mbox_marker_infos_nonce' );

    // Get maps list
    $all_maps = gp_query_get_maps();

    // Set map (if given via url GET and in new marker form)
    if ( $marker_map == '' && isset( $_GET['map'] ) ) {
        if ( gp_query_exists_map( $_GET['map'] ) ) {
            $marker_map = $_GET['map'];
        }
    }

    // Display Mbox content
    ?>

    <h4 style="margin:1em 0"><?php _e( 'General', 'lang_geoprojects' ); ?></h4>

	<table class="mbox-fields-table">

		<thead class="visuallyhidden">
			<tr>
				<th>
                    <?php _e( 'Field name', 'lang_geoprojects' ); ?>
                </th>

                <th>
                    <?php _e( 'Field value', 'lang_geoprojects' ); ?>
                </th>
			</tr>
		</thead>

		<tbody>

            <?php /* Marker Map */ ?>

			<tr>

				<td class="mbox-field-name">
					<label for="gp-map"><?php _e( 'Map', 'lang_geoprojects' ); ?></label>
				</td>

				<td class="mbox-field-value">

					<?php if ( count( $all_maps ) > 0 ) : ?>
                        
                        <p style="margin-bottom:6px">
    						<select name="gp-map" id="gp-map">
    							<option value="0" <?php if ( $marker_map == 0 ) { echo 'selected="selected"'; } ?>>-----</option>
    							<?php foreach ( $all_maps as $map ) : ?>
    								<option value="<?php echo $map->ID; ?>" <?php if ( $marker_map == $map->ID ) { echo 'selected="selected"'; } ?>><?php echo $map->post_title; ?></option>
    					    	<?php endforeach; ?>
    						</select>
                        </p>
                        <?php if ( $marker_map != 0 ) : ?>
                            <p style="margin-top:6px">
                                <a href="<?php echo admin_url( 'post.php?post=' . $marker_map . '&action=edit' ); ?>"><?php _e( 'Edit the map', 'lang_geoprojects' ); ?></a> - 
                                <a href="<?php echo get_permalink( $marker_map ); ?>"><?php _e( 'See the map', 'lang_geoprojects' ); ?></a>
                            </p>
                        <?php endif; ?>

					<?php else : ?>

						<p class="mbox-field-info">
                            <?php printf( __( 'No map found. If you want to add this marker to a map, <a href="%1$s">you must create one first</a> (don\'t forget to save this content before clicking on this link).', 'lang_geoprojects' ), get_admin_url() . 'post-new.php?post_type=maps' ); ?>
                        </p>
					
                    <?php endif; ?>

				</td>

			</tr>

            <?php /* Marker Icon */ ?>

            <?php
            // No icon => set to default one
            if ( $marker_icon_type == '' ) {
                $marker_icon_type = 'default';
                $marker_icon_filename = GP_DEFAULT_MARKER_FILE;
            }
            ?>

            <tr>

                <td class="mbox-field-name">
                    <label><?php _e( 'Icon', 'lang_geoprojects' ); ?></label>
                </td>

                <td class="mbox-field-value">

                    <input type="hidden" name="gp-icon-type" value="<?php echo $marker_icon_type; ?>">
                    <input type="hidden" name="gp-icon-filename" value="<?php echo $marker_icon_filename; ?>">

                    <p class="mbox-marker-icon-preview">
                        <?php
                        $marker_icon_base_url = ( $marker_icon_type == 'default' ) ? GP_URL_DEFAULT_MARKERS_ICONS : GP_URL_CUSTOM_MARKERS_ICONS;
                        $marker_icon_url = $marker_icon_base_url . '/' . $marker_icon_filename;
                        ?>
                        <img src="<?php echo $marker_icon_url; ?>">
                        <a href="" class="mbox-marker-icon-change"><?php _e( 'change', 'lang_geoprojects' ); ?></a>
                    </p>

                    <div class="mbox-marker-icons-lists-wrap">

                        <p class="mbox-marker-icons-lists-choice">
                            <input type="radio" name="gp-marker-icons-list" id="mbox-marker-icons-list-default" value="default" checked="checked">
                            <label for="mbox-marker-icons-list-default"><?php _e( 'Default icons', 'lang_geoprojects' ); ?></label>
                            <input type="radio" name="gp-marker-icons-list" id="mbox-marker-icons-list-custom" value="custom">
                            <label for="mbox-marker-icons-list-custom"><?php _e( 'Custom icons', 'lang_geoprojects' ); ?></label>
                        </p>

                        <div class="mbox-marker-icons-list-default mbox-marker-icons-list">
                            <?php gp_get_markers_icons_list( 'default' ); ?>
                        </div>

                        <div class="mbox-marker-icons-list-custom mbox-marker-icons-list">
                            <img src="<?php echo GP_URL_IMAGE_LOADING; ?>" class="loading" alt="<?php _e( 'Loading', 'lang_geoprojects' ); ?>">
                        </div>

                    </div>

                </td>

            </tr>

		</tbody>

	</table>


    <?php /* Marker Content */ ?>

    <h4><?php _e( 'In the Popup', 'lang_geoprojects' ); ?></h4>

    <p class="mbox-info">
        <?php printf( __( '%1$s Note %2$s you can drag an drop created contents for changing display order in the popup. Contents are displayed one above the others in the popup, starting with the created content at left.', 'lang_geoprojects' ), '<strong>', ': </strong>' ); ?>
    </p>

    <div class="mbox-marker-content-wrap">
        
        <input type="hidden" name="gp-popup-content-order" value="<?php echo $marker_popup_content_order; ?>">

        <div class="mbox-marker-content-list-wrap clearfix">

            <ul class="mbox-marker-content-list content-types-sortable">

                <?php
                $marker_popup_content_types = array(
                    'text'      => __( 'Text', 'lang_geoprojects' ),
                    'image'     => __( 'Image', 'lang_geoprojects' ),
                    'video'     => __( 'Video', 'lang_geoprojects' ),
                    'audio'     => __( 'Audio', 'lang_geoprojects' )
                );
                ?>

                <?php
                $marker_popup_content_order_array = explode( ',', $marker_popup_content_order );
                $first_content_type = ( $marker_popup_content_order != '' ) ? $marker_popup_content_order_array[0] : '';

                // Display created content first
                $cpt = 1;
                if ( $marker_popup_content_order != '' ) :
                    foreach ( $marker_popup_content_order_array as $marker_popup_content_type ) : ?>

                        <li class="mbox-marker-content-<?php echo $marker_popup_content_type; echo ( $cpt == 1 ) ? ' active' : ''; ?>">
                            <a href="" data-content-to-delete="<?php echo $marker_popup_content_type; ?>" class="mbox-marker-content-delete">
                                <span><?php _e( 'Delete', 'lang_geoprojects' ); ?></span>
                            </a>
                            <a href="" data-content-to-edit="<?php echo $marker_popup_content_type; ?>" class="mbox-marker-content-edit">
                                <span><?php echo $marker_popup_content_types[$marker_popup_content_type]; ?></span>
                            </a>
                        </li>

                    <?php $cpt++; endforeach;  ?>
                <?php endif; ?>

                <?php
                // Display (but hide) other contents
                foreach ( $marker_popup_content_types as $marker_popup_content_type => $marker_popup_content_type_text ) : ?>

                    <?php if ( !in_array( $marker_popup_content_type, $marker_popup_content_order_array ) ) : ?>

                        <li class="mbox-marker-content-<?php echo $marker_popup_content_type; ?>" style="display:none">
                            <a href="" data-content-to-delete="<?php echo $marker_popup_content_type; ?>" class="mbox-marker-content-delete">
                                <span><?php _e( 'Delete', 'lang_geoprojects' ); ?></span>
                            </a>
                            <a href="" data-content-to-edit="<?php echo $marker_popup_content_type; ?>" class="mbox-marker-content-edit">
                                <span><?php echo $marker_popup_content_type_text; ?></span>
                            </a>
                        </li>

                    <?php endif; ?>

                <?php endforeach;  ?>

            </ul>

            <ul class="mbox-marker-content-add-choice clearfix">

                <li class="mbox-marker-content-choice-text" <?php if ( in_array( 'text', $marker_popup_content_order_array ) ) { echo 'style="display:none"'; } ?>>
                    <a href="" data-content-to-add="text" title="<?php _e( 'Add a Text', 'lang_geoprojects' ); ?>">
                        <span><?php _e( 'Add a <strong>Text</strong>', 'lang_geoprojects' ); ?></span>
                    </a>
                </li>

                <li class="mbox-marker-content-choice-image" <?php if ( in_array( 'image', $marker_popup_content_order_array ) ) { echo 'style="display:none"'; } ?>>
                    <a href="" data-content-to-add="image" title="<?php _e( 'Add an Image', 'lang_geoprojects' ); ?>">
                        <span><?php _e( 'Add an <strong>Image</strong>', 'lang_geoprojects' ); ?></span>
                    </a>
                </li>

                <li class="mbox-marker-content-choice-video" <?php if ( in_array( 'video', $marker_popup_content_order_array ) ) { echo 'style="display:none"'; } ?>>
                    <a href="" data-content-to-add="video" title="<?php _e( 'Add a Video', 'lang_geoprojects' ); ?>">
                        <span><?php _e( 'Add a <strong>Video</strong>', 'lang_geoprojects' ); ?></span>
                    </a>
                </li>

                <li class="mbox-marker-content-choice-audio" <?php if ( in_array( 'audio', $marker_popup_content_order_array ) ) { echo 'style="display:none"'; } ?>>
                    <a href="" data-content-to-add="audio" title="<?php _e( 'Add an Audio', 'lang_geoprojects' ); ?>">
                        <span><?php _e( 'Add an <strong>Audio</strong>', 'lang_geoprojects' ); ?></span>
                    </a>
                </li>

            </ul>

        </div>
        
        <div class="mbox-marker-content-edit-text-wrap mbox-marker-content-edit-pan" <?php echo ( $first_content_type == 'text' ) ? '' : 'style="display:none"'; ?>>

            <?php
            // Display a minimal Wysiwyg editor
            wp_editor(
                $marker_popup_text,
                'gp-popup-text',
                array(
                    'media_buttons' => false,
                    'teeny'         => true,
                    'textarea_rows' => 10,
                    'quicktags'     => false
                )
            );
            ?>

        </div>

        <div class="mbox-marker-content-edit-image-wrap mbox-marker-content-edit-pan" <?php echo ( $first_content_type == 'image' ) ? '' : 'style="display:none"'; ?>>

            <?php
            // Get Image HTML
            if ( $marker_popup_image != '' ) {
                $marker_popup_image_html = wp_get_attachment_image( $marker_popup_image, 'medium' );

                // If image does not exist anymore, reset field
                if ( $marker_popup_image_html == '' ) {
                    $marker_popup_image = '';
                }
            }
            ?>

            <input type="hidden" name="gp-popup-image" value="<?php echo $marker_popup_image; ?>">
            
            <div class="mbox-marker-content-edit-image-preview">
                <?php if ( $marker_popup_image != '' ) { echo $marker_popup_image_html; } ?>
            </div>

            <p class="mbox-marker-content-edit-buttons">
                <a href="" class="mbox-marker-content-edit-image-choose" <?php if ( $marker_popup_image != '' ) { echo 'style="display:none"'; } ?>>
                    <?php _e( 'Choose an Image', 'lang_geoprojects' ); ?>
                </a>
                <a href="" class="mbox-marker-content-edit-image-delete" <?php if ( $marker_popup_image == '' ) { echo 'style="display:none"'; } ?>>
                    <?php _e( 'Remove image', 'lang_geoprojects' ); ?>
                </a>
            </p>

        </div>

        <div class="mbox-marker-content-edit-video-wrap mbox-marker-content-edit-pan" <?php echo ( $first_content_type == 'video' ) ? '' : 'style="display:none"'; ?>>
            
            <p>
                <label for="mbox-marker-content-edit-video-url"><?php _e( 'URL of the video', 'lang_geoprojects' ); ?></label>
                <input type="text" name="gp-popup-video" id="mbox-marker-content-edit-video-url" value="<?php echo $marker_popup_video; ?>">
            </p>

            <div class="mbox-marker-content-edit-video-preview" <?php if ( $marker_popup_video == '' ) { echo 'style="display:none"'; } ?>>
                <?php
                if ( $marker_popup_video != '' ) {
                    echo wp_oembed_get( $marker_popup_video );
                }
                ?>
            </div>

            <p class="mbox-marker-content-edit-buttons">
                <a href="" class="mbox-marker-content-edit-video-delete" <?php if ( $marker_popup_video == '' ) { echo 'style="display:none"'; } ?>>
                    <?php _e( 'Remove video', 'lang_geoprojects' ); ?>
                </a>
            </p>

        </div>

        <div class="mbox-marker-content-edit-audio-wrap mbox-marker-content-edit-pan" <?php echo ( $first_content_type == 'audio' ) ? '' : 'style="display:none"'; ?>>

            <?php
            // Get Audio filename
            if ( $marker_popup_audio != '' ) {

                $audioAttachment = gp_query_get_attachment( $marker_popup_audio );

                // If audio does not exist anymore, reset field
                if ( $audioAttachment == '' ) {
                    $marker_popup_audio = '';
                }

            }
            ?>

            <input type="hidden" name="gp-popup-audio" value="<?php echo $marker_popup_audio; ?>">
            
            <div class="mbox-marker-content-edit-audio-preview">
                <?php
                if ( $marker_popup_audio != '' ) {
                    echo do_shortcode( '[audio mp3="' . $marker_popup_audio . '"][/audio]' );
                }
                ?>
            </div>

            <p class="mbox-marker-content-edit-buttons">
                <a href="" class="mbox-marker-content-edit-audio-choose" <?php if ( $marker_popup_audio != '' ) { echo 'style="display:none"'; } ?>>
                    <?php _e( 'Choose a MP3 file', 'lang_geoprojects' ); ?>
                </a>
                <a href="" class="mbox-marker-content-edit-audio-delete" <?php if ( $marker_popup_audio == '' ) { echo 'style="display:none"'; } ?>>
                    <?php _e( 'Remove audio file', 'lang_geoprojects' ); ?>
                </a>
            </p>

        </div>

    </div>


    <?php /* Marker Geolocation */ ?>
    
    <h4><?php _e( 'Geolocation', 'lang_geoprojects' ); ?></h4>

    <div class="mbox-marker-geo-wrap">

        <div class="mbox-marker-geo-infos">
            <p class="mbox-info"><?php _e( 'Drag the marker to the desired position.', 'lang_geoprojects' ); ?></p>
            <p class="mbox-info"><?php _e( 'You can zoom and pan to the desired location and bring back the marker there by clicking the button "center marker here".', 'lang_geoprojects' ); ?></p>
            <p class="mbox-info"><?php _e( 'You can also search for a postal address (powered by <a href="http://nominatim.openstreetmap.org/" target="_blank">OpenStreetMap Nominatim</a>). If you can\'t find an address, try to be more precise or test other keywords.', 'lang_geoprojects' ); ?></p>
        </div>

        <input type="hidden" name="gp-lat" id="mbox-marker-geo-lat" value="<?php echo $marker_lat; ?>">
        <input type="hidden" name="gp-lng" id="mbox-marker-geo-lng" value="<?php echo $marker_lng; ?>">
        
        <div class="gp-leaflet-map-container">
            <div class="gp-leaflet-map-wrap">
                <div id="mbox-marker-map" class="gp-leaflet-map"
                    data-map-tiles="osm"
                    data-map-center-lat="<?php echo $marker_lat; ?>"
                    data-map-center-lng="<?php echo $marker_lng; ?>"
                    data-map-zoom="<?php echo GP_DEFAULT_MAP_ZOOM; ?>"
                    data-map-drag-marker="1"
                    data-map-drag-marker-icon-type="<?php echo $marker_icon_type; ?>"
                    data-map-drag-marker-icon-filename="<?php echo $marker_icon_filename; ?>"
                    data-map-center-here="1"
                    data-map-lat-field="mbox-marker-geo-lat"
                    data-map-lng-field="mbox-marker-geo-lng"
                    data-map-search-box="1"></div>
            </div>
        </div>

    </div>


    <?php

}


/**
 * Save the Metaboxes data
 * @param  Int $post_id ID of the post
 */
function gp_save_mbox_marker_infos( $post_id ) {
  
    // Don't do anything for auto-save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return $post_id;

    // No nonce ?
    if( !isset( $_POST['mbox_marker_infos_nonce'] ) )
        return $post_id;

    // Check nonce
    if ( !wp_verify_nonce( $_POST['mbox_marker_infos_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_posts', $post_id ) )
        return;

    // Mbox submitted ?
    if ( isset( $_POST['gp-icon-type'] ) ) {

        // Save map
        update_post_meta( $post_id, 'gp_map', trim( $_POST['gp-map'] ) );

        // Save icon type
        update_post_meta( $post_id, 'gp_icon_type', trim( $_POST['gp-icon-type'] ) );

        // Save icon filename
        update_post_meta( $post_id, 'gp_icon_filename', trim( $_POST['gp-icon-filename'] ) );
        
        // Remove empty contents from the content order
        $content_order = explode( ',', trim( $_POST['gp-popup-content-order'] ) );
        $new_content_order = array();

        foreach ( $content_order as $content_type ) {
            if ( trim( $_POST['gp-popup-' . $content_type] ) != '' ) {
                $new_content_order[] = $content_type;
            }
        }

        // Save content order
        update_post_meta( $post_id, 'gp_popup_content_order', implode( ',', $new_content_order ) );

        // Save popup contents
        update_post_meta( $post_id, 'gp_popup_text', ( in_array( 'text', $new_content_order ) ) ? trim( $_POST['gp-popup-text'] ) : '' );
        update_post_meta( $post_id, 'gp_popup_image', ( in_array( 'image', $new_content_order ) ) ? trim( $_POST['gp-popup-image'] ) : '' );
        update_post_meta( $post_id, 'gp_popup_video', ( in_array( 'video', $new_content_order ) ) ? trim( $_POST['gp-popup-video'] ) : '' );
        update_post_meta( $post_id, 'gp_popup_audio', ( in_array( 'audio', $new_content_order ) ) ? trim( $_POST['gp-popup-audio'] ) : '' );

        // Save geolocation
        update_post_meta( $post_id, 'gp_lat', trim( $_POST['gp-lat'] ) );
        update_post_meta( $post_id, 'gp_lng', trim( $_POST['gp-lng'] ) );

    }

}

add_action( 'save_post', 'gp_save_mbox_marker_infos' );