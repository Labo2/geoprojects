<?php
/**
 * Metabox : "Project"
 * Post types : post, maps
 * Goal : Choose a project for a post or a map
 *
 * @package GeoProjects
 */


/**
 * Register Metabox
 */
function gp_mbox_project_infos() {
  	add_meta_box( 'mbox_project_infos', __( 'Additionnal Informations', 'lang_geoprojects' ), 'gp_mbox_project_infos_content', 'projects', 'normal', 'core' );
}

add_action( 'add_meta_boxes', 'gp_mbox_project_infos' );


/**
 * Content of the Metabox
 * @param object $post Post Object
 */
function gp_mbox_project_infos_content( $post ) {

    // Get fields values
    $gp_owner = get_post_meta( $post->ID, 'gp_owner', true );
    $gp_website = get_post_meta( $post->ID, 'gp_website', true );
    $gp_date = get_post_meta( $post->ID, 'gp_date', true );
    $gp_twitter = get_post_meta( $post->ID, 'gp_twitter', true );
    $gp_facebook = get_post_meta( $post->ID, 'gp_facebook', true );
    $gp_file = get_post_meta( $post->ID, 'gp_file', true );

    // Nonce Field
    wp_nonce_field( plugin_basename( __FILE__ ), 'mbox_project_infos_nonce' );

    // Display HTML
    ?>
    
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
            <tr>
                <td class="mbox-field-name">
                    <label for="gp-owner"><?php _e( 'Project initiator', 'lang_geoprojects' ); ?></label>
                </td>
                <td class="mbox-field-value">
                    <p><input type="text" name="gp-owner" id="gp-owner" value="<?php echo $gp_owner; ?>"></p>
                </td>
            </tr>
            <tr>
                <td class="mbox-field-name">
                    <label for="gp-website"><?php _e( 'Initiator website URL', 'lang_geoprojects' ); ?></label>
                </td>
                <td class="mbox-field-value">
                    <p><input type="text" name="gp-website" id="gp-website" value="<?php echo $gp_website; ?>"></p>
                </td>
            </tr>
            <tr>
                <td class="mbox-field-name">
                    <label for="gp-date"><?php _e( 'Project start date', 'lang_geoprojects' ); ?></label>
                </td>
                <td class="mbox-field-value">
                    <p><input type="text" name="gp-date" id="gp-date" value="<?php echo $gp_date; ?>"></p>
                </td>
            </tr>
            <tr>
                <td class="mbox-field-name">
                    <label for="gp-twitter"><?php _e( 'Project\'s Twitter URL', 'lang_geoprojects' ); ?></label>
                </td>
                <td class="mbox-field-value">
                    <p><input type="text" name="gp-twitter" id="gp-twitter" value="<?php echo $gp_twitter; ?>"></p>
                </td>
            </tr>
            <tr>
                <td class="mbox-field-name">
                    <label for="gp-facebook"><?php _e( 'Project\'s Facebook URL', 'lang_geoprojects' ); ?></label>
                </td>
                <td class="mbox-field-value">
                    <p><input type="text" name="gp-facebook" id="gp-facebook" value="<?php echo $gp_facebook; ?>"></p>
                </td>
            </tr>
            <tr>
                <td class="mbox-field-name">
                    <label><?php _e( 'Attached file', 'lang_geoprojects' ); ?></label>
                </td>
                <td class="mbox-field-value">
                    <input type="hidden" name="gp-file" value="<?php echo $gp_file; ?>">
                    <div class="mbox-project-infos-file-preview">
                        <?php if ( $gp_file != '' ) : ?>
                            <p>
                                <?php echo wp_get_attachment_link( $gp_file, '' ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <p class="mbox-project-infos-file-buttons">
                        <a href="" class="mbox-project-infos-choose-file" <?php if ( $gp_file != '' ) { echo 'style="display:none"'; } ?>>
                            <?php _e( 'Choose a file', 'lang_geoprojects' ); ?>
                        </a>
                        <a href="" class="mbox-project-infos-delete-file" <?php if ( $gp_file == '' ) { echo 'style="display:none"'; } ?>>
                            <?php _e( 'Remove file', 'lang_geoprojects' ); ?>
                        </a>
                    </p>
                </td>
            </tr>
        </tbody>

    </table>

    <?php
}


/**
 * Save the Metaboxes data
 * @param  Int $post_id ID of the post
 */
function gp_save_mbox_project_infos( $post_id ) {
  
    // Don't do anything for auto-save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return $post_id;

    // No nonce ?
    if( !isset( $_POST['mbox_project_infos_nonce'] ) )
        return $post_id;

    // Check nonce
    if ( !wp_verify_nonce( $_POST['mbox_project_infos_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_posts', $post_id ) )
        return;

    if ( isset( $_POST['gp-website'] ) && isset( $_POST['gp-owner'] ) ) {

        $gp_website = trim( $_POST['gp-website'] );
        update_post_meta( $post_id, 'gp_website', $gp_website );

        $gp_owner = trim( $_POST['gp-owner'] );
        update_post_meta( $post_id, 'gp_owner', $gp_owner );

        $gp_date = trim( $_POST['gp-date'] );
        update_post_meta( $post_id, 'gp_date', $gp_date );

        $gp_twitter = trim( $_POST['gp-twitter'] );
        update_post_meta( $post_id, 'gp_twitter', $gp_twitter );

        $gp_facebook = trim( $_POST['gp-facebook'] );
        update_post_meta( $post_id, 'gp_facebook', $gp_facebook );

        $gp_file = trim( $_POST['gp-file'] );
        update_post_meta( $post_id, 'gp_file', $gp_file );

    }

}

add_action( 'save_post', 'gp_save_mbox_project_infos' );