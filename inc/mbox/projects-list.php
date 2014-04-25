<?php
/**
 * Metabox : "Projects list"
 * Post types : post, maps
 * Goal : Choose a project for a post or a map
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */


/**
 * Register Metabox
 */
function gp_mbox_projects_list() {
  	add_meta_box( 'mbox_projects_list', __( 'Project', 'lang_geoprojects' ), 'gp_mbox_projects_list_content', 'maps', 'side', 'core' );
  	add_meta_box( 'mbox_projects_list', __( 'Project', 'lang_geoprojects' ), 'gp_mbox_projects_list_content', 'post', 'side', 'core' );
}

add_action( 'add_meta_boxes', 'gp_mbox_projects_list' );


/**
 * Content of the Metabox
 * @param object $post Post Object
 */
function gp_mbox_projects_list_content( $post ) {
    
    // Get fields values
    $gp_project = get_post_meta( $post->ID, 'gp_project', true );

    // Nonce Field
    wp_nonce_field( plugin_basename( __FILE__ ), 'mbox_projects_list_nonce' );

    // Get Projects list
    $all_projects = gp_query_get_projects();

	// Display different text depending on the post type
   	$textType = ( $post->post_type == 'maps' ) ? __( 'this map', 'lang_geoprojects' ) : __( 'this post', 'lang_geoprojects' );

    // Display Mbox content
    if ( count( $all_projects ) > 0 ) : ?>

    	<p><?php printf( __( 'Attach %1$s to a project (optionnal)', 'lang_geoprojects' ), $textType ); ?></p>

	    <select name="gp-project">
	    	<option value="0" <?php if ( $gp_project == 0 || $gp_project == '' ) { echo 'selected="selected"'; } ?>>-----</option>
	    	<?php foreach ( $all_projects as $project ) : ?>
				<option value="<?php echo $project->ID; ?>" <?php if ( $gp_project == $project->ID ) { echo 'selected="selected"'; } ?>><?php echo $project->post_title; ?></option>
	    	<?php endforeach; ?>
	    </select>

    <?php
    // No projects
    else : ?>

		<p class="mbox-info">
			<?php printf( __( 'No project found. You can optionnaly <a href="%1$s">create a new project</a> to put %2$s in (don\'t forget to save this content before clicking on this link)' , 'lang_geoprojects' ), get_admin_url() . 'post-new.php?post_type=projects', $textType ) ?>
		</p>
		
    <?php endif;
}


/**
 * Save the Metaboxes data
 * @param  Int $post_id ID of the post
 */
function gp_save_mbox_projects_list( $post_id ) {
  
    // Don't do anything for auto-save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return $post_id;

    // No nonce ?
    if( !isset( $_POST['mbox_projects_list_nonce'] ) )
        return $post_id;

    // Check nonce
    if ( !wp_verify_nonce( $_POST['mbox_projects_list_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_posts', $post_id ) )
        return;

    // Mbox submitted ?
    if ( isset( $_POST['gp-project'] ) ) {
        update_post_meta( $post_id, 'gp_project', $_POST['gp-project'] );
    }

}

add_action( 'save_post', 'gp_save_mbox_projects_list' );