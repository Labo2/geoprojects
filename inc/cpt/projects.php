<?php

/**
 * CUSTOM POST TYPE : Projects
 */

 
/**
 * Class definition of the CPT "Projects"
 */
class gp_cpt_projects {

	var $type   = 'projects';


	/**
	 * Constructor
	 */
	function __construct() {
		$this->single = __( 'Project', 'lang_geoprojects' );
		$this->plural = __( 'Projects', 'lang_geoprojects' );
	}


	/**
	* Define and register the post type
	*/  
	function add_post_type(){

		$labels = array(
			'name'                	=> $this->plural,
			'singular_name'       	=> $this->single,
			'add_new'             	=> __( 'Add', 'lang_geoprojects' ),
			'add_new_item'        	=> sprintf( __( 'Add a new %s', 'lang_geoprojects' ), $this->single ),
			'edit_item'           	=> sprintf( __( 'Edit this %s', 'lang_geoprojects' ), $this->single ),
			'new_item'            	=> sprintf( __( 'New %s', 'lang_geoprojects' ), $this->single ),
			'view_item'           	=> sprintf( __( 'See the %s', 'lang_geoprojects' ), $this->single ),
			'search_items'        	=> sprintf( __( 'Search %s', 'lang_geoprojects' ), $this->plural ),
			'not_found'           	=> sprintf( __( 'No %s found', 'lang_geoprojects' ), $this->plural ),
			'not_found_in_trash'  	=> sprintf( __( 'No %s found in trash', 'lang_geoprojects' ), $this->plural ),
			'parent_item_colon'   	=> sprintf( __( 'My %s', 'lang_geoprojects' ), $this->plural )
		);

		$options = array(
			'labels'              	=> $labels,
			'public'              	=> true,
			'publicly_queryable'  	=> true,
			'exclude_from_search' 	=> false,
			'show_ui'             	=> true,
			'show_in_menu'        	=> true,
			'menu_position'       	=> 20,
			'menu_icon'				=> 'dashicons-portfolio',
			'capability_type'     	=> 'post',
			'hierarchical'        	=> false,
			'supports'            	=> array( 'title', 'editor', 'thumbnail' ),
			'has_archive'         	=> true,
			'rewrite'             	=> true,
			'query_var'           	=> true,
			'can_export'          	=> true
		);

		// Register the Post Type
		register_post_type( $this->type, $options );

	}


	/**
	* CPT Infos Messages
	*/  
	function add_messages ( $messages ) {

		global $post;
		$post_ID = $post->ID;      

		$messages[$this->type] = array(
			0 => '', 
			1 => sprintf( __( '%1$s updated. <a href="%2$s">See the %1$s</a>', 'lang_geoprojects' ), $this->single, esc_url( get_permalink( $post_ID ) ) ),
			2 => __( 'Custom field updated.', 'lang_geoprojects' ),
			3 => __( 'Custom field deleted.', 'lang_geoprojects' ),
			4 => sprintf( __( '%s updated.', 'lang_geoprojects' ), $this->single ),
			5 => isset($_GET['revision']) ? sprintf( __( '%1$s restored at revision %2$s', 'lang_geoprojects' ), $this->single, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( '%1$s published. <a href="%2$s">See the %1$s</a>', 'lang_geoprojects' ), $this->single, esc_url( get_permalink( $post_ID ) ) ),
			7 => sprintf( __( '%s saved', 'lang_geoprojects' ), $this->single ),
			8 => sprintf( '%1$s saved. <a target="_blank" href="%2$s">Preview the %1$s</a>', $this->single, esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			9 => sprintf( '%1$s planned for the : <strong>%2$s</strong>. <a target="_blank" href="%3$s">Preview the %1$s</a>', $this->single, date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
			10 => sprintf( 'Draft of %1$s updates. <a target="_blank" href="%2$s">Preview the %1$s</a>', $this->single, esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		);

		return $messages;
	}

}


/**
 * Init action for registering this CPT
 */
function gp_init_cpt_projects() {
	// Create class instance
	$cptProjects = new gp_cpt_projects;

	// Register CPT
	$cptProjects->add_post_type();

	// Register Messages
	add_filter( 'post_updated_messages', array( &$cptProjects, 'add_messages' ) );
}

add_action( 'init', 'gp_init_cpt_projects' );


/**
 * When sending to trash
 */
function gp_trashed_project( $project_ID ) {
	global $post_type;

	if ( $post_type == 'projects' ) {
		$gp_options = get_option( 'gp_options' );
		
		// Search for posts and maps that are linked to this project
		// Change their project to none (0)
		$contents_linked_to_this_project = gp_query_get_project_contents( $project_ID, array( 'post_status' => 'any' ) );

		if ( count( $contents_linked_to_this_project ) > 0 ) {
			foreach ( $contents_linked_to_this_project as $content ) {
				update_post_meta( $content->ID, 'gp_project', 0 );
			}
		}

		// Send maps, markers and posts to trash to ?
		if ( $gp_options['project_trash_keep_contents'] == 0 ) {

			// Trash maps, markers and posts
			if ( count( $contents_linked_to_this_project ) > 0 ) {
				$maps_IDs = array();

				// Trash maps and posts
				foreach ( $contents_linked_to_this_project as $content ) {

					// Keep track of maps ID for trashing markers below
					if ( $content->post_type == 'maps' ) {
						$maps_IDs[] = $content->ID;
					}

					// Send map or post to trash
					wp_trash_post( $content->ID );

				}

				// Trash markers
				if ( count( $maps_IDs ) > 0 ) {
					foreach ( $maps_IDs as $mID ) {
						$map_markers = gp_query_get_map_markers(
							$mID,
							array(
								'post_status' 		=> 'any'
							)
						);

						if ( count( $map_markers ) > 0 ) {
							foreach ( $map_markers as $mm ) {

								// Unlink marker from map
								update_post_meta( $mm->ID, 'gp_map', 0 );

								// Send marker to trash
								wp_trash_post( $mm->ID );

							}
						}

					}
				}

			}

		}

	}

}

add_action( 'trashed_post', 'gp_trashed_project', 10 );