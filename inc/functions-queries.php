<?php
/**
 * GeoProjects Queries to database functions
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */


/*******************
 ***** GETTERS *****
 *******************/


/**
 * Get a Project
 * @return array 	Array of 1 Project WP object
 */
function gp_query_get_project( $project_id = 0 ) {

	if ( $project_id != 0 ) {

		$project = get_posts( array(
	        'post_type'     => 'projects',
	        'p'             => $project_id
	    ));

	    if ( count( $project ) == 1 ) {
	    	return $project[0];
	    }

	}

	return '';

}


/**
 * Get all projects
 * @param  array 	$params 	Array of WP_Query parameters
 * @return array  				Array of Projects WP objects
 */
function gp_query_get_projects( $params = array() ) {

	// Merge params
	$defaults_params = array(
		'post_status' 		=> 'publish',
		'orderby'			=> 'title',
		'order'				=> 'ASC',
		'posts_per_page'	=> -1
	);

	$params = array_merge( $defaults_params, $params );

	return get_posts( array(
    	'post_type'			=> 'projects',
    	'post_status'		=> $params['post_status'],
    	'orderby'			=> $params['orderby'],
    	'order'				=> $params['order'],
    	'posts_per_page' 	=> $params['posts_per_page']
    ));

}


/**
 * Get Maps or Posts belonging to a given project
 * @param  int 		$project_id  	Project ID
 * @param  array 	$params 		Array of WP_Query parameters
 * @return array  					Array of posts/maps WP objects
 */
function gp_query_get_project_contents( $project_id = 0, $params = array() ) {

	if ( $project_id != 0 ) {

		// Merge params
		$defaults_params = array(
			'post_status' 		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'date',
			'order'				=> 'DESC',
			'post__not_in'		=> array()
		);

		$params = array_merge( $defaults_params, $params );

		return get_posts( array(
			'post_type'			=> array( 'post', 'maps' ),
			'post_status'		=> $params['post_status'],
			'meta_query'		=> array(
									array(
										'key' 		=> 'gp_project',
										'value' 	=> $project_id,
										'compare' 	=> '='
									)
			),
			'posts_per_page' 	=> $params['posts_per_page'],
			'orderby' 			=> $params['orderby'],
			'order' 			=> $params['order'],
			'post__not_in'  	=> $params['post__not_in']

		));

	}

	return array();

}


/**
 * Get a Map
 * @param  int 		$map_ID 	ID of the requested map
 * @return array 				Array of 1 Maps WP object
 */
function gp_query_get_map( $map_ID = 0 ) {

	if ( $map_ID != 0 ) {

		$map = get_posts( array(
	        'post_type'     => 'maps',
	        'p'             => $map_ID
	    ));

	    if ( count( $map ) == 1 ) {
	    	return $map[0];
	    }

	}

	return '';

}


/**
 * Get Maps
 * @param  array 	$params 	Array of WP_Query parameters
 * @return array 				Array of Maps WP objects
 */
function gp_query_get_maps( $params = array() ) {

	// Merge params
	$defaults_params = array(
		'post_status' 		=> 'publish',
		'orderby'			=> 'title',
		'order'				=> 'ASC',
		'posts_per_page'	=> -1,
		'offset'			=> 0,
		'post__not_in'		=> array()
	);

	$params = array_merge( $defaults_params, $params );

	return get_posts( array(
    	'post_type'			=> 'maps',
    	'post_status'		=> $params['post_status'],
    	'orderby'			=> $params['orderby'],
    	'order'				=> $params['order'],
    	'posts_per_page' 	=> $params['posts_per_page'],
    	'offset'			=> $params['offset'],
    	'post__not_in' 		=> $params['post__not_in']
    ));

}


/**
 * Get all maps with tiles provider as Cloudmade
 * @return array 	Array of Maps WP objects
 */
function gp_query_get_maps_with_cloudmade() {
	return get_posts( array(
		'post_type' 		=> 'maps',
		'post_status'		=> 'any',
		'posts_per_page'	=> -1,
		'meta_query'		=> array( array(
									'key'		=> 'gp_tiles_provider',
									'value'		=> 'cloudmade',
									'compare'	=> '='
								))
	));
}


/**
 * Get Map Markers
 * @param  int 		$map_id  	Map ID
 * @param  array 	$params 	Array of WP_Query parameters
 * @return array 				Array of markers WP objects
 */
function gp_query_get_map_markers( $map_id = 0, $params = array() ) {

	// Map != 0
	if ( $map_id != 0 ) {

		// Merge params
		$defaults_params = array(
			'post_status' 		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'date',
			'order'				=> 'ASC'
		);

		$params = array_merge( $defaults_params, $params );

		// Get map markers
		return get_posts( array(
			'post_type' 		=> 'markers',
			'post_status'		=> $params['post_status'],
			'meta_query' 		=> array(
									array(
										'key' 		=> 'gp_map',
										'value'		=> $map_id,
										'compare'	=> '='
									)
			),
			'posts_per_page' 	=> $params['posts_per_page'],
			'orderby' 			=> $params['orderby'],
			'order' 			=> $params['order']
		));

	}

	return array();

}


/**
 * Get all markers
 * @param array $params Parameters for the WP_query
 */
function gp_query_get_markers( $params = array() ) {

	// Merge params
	$defaults_params = array(
		'post_status' 		=> 'publish',
		'posts_per_page'	=> -1,
		'orderby'			=> 'title',
		'order'				=> 'ASC'
	);

	$params = array_merge( $defaults_params, $params );

	return get_posts( array(
		'post_type'			=> 'markers',
		'post_status'		=> $params['post_status'],
		'posts_per_page' 	=> $params['posts_per_page'],
		'orderby'			=> $params['orderby'],
		'order' 			=> $params['order']
	));

}


/**
 * Get an Attachment
 * @param  	$attch_id 	Attachment ID
 * @return  array  		Array of 1 attachment
 */
function gp_query_get_attachment( $attch_id = 0 ) {

	if ( $attch_id != 0 ) {

		$attch = get_posts( array(
	        'post_type'     => 'attachment',
	        'p'             => $attch_id,
	        'post_status'   => 'inherit'
	    ));

		if ( count( $attch ) == 1 ) {
	    	return $attch[0];
	   	}

	}

	return '';

}


/**
 * Get posts in a given category
 * @param 	int 	$category_ID 	Category ID
 */
function gp_query_get_posts_in_category( $category_ID = 0, $params = array() ) {

	if ( $category_ID != 0 ) {
		$category = get_term( $category_ID, 'category' );

		if ( $category !== null ) {

			// Merge params
			$defaults_params = array(
				'posts_per_page' 	=> -1
			);

			$params = array_merge( $defaults_params, $params );

			return get_posts( array(
				'post_type'			=> 'post',
				'post_status'		=> 'publish',
				'posts_per_page'	=> $params['posts_per_page'],
				'orderby' 			=> 'date',
				'order'				=> 'DESC',
				'tax_query' 		=> array( array(
											'taxonomy' 		=> 'category',
											'field' 		=> 'id',
											'terms'			=> $category_ID
										))
			));

		}

	}

	return array();

}



/**********************
 ****** EXISTORS ******
 **********************/

/**
 * Test if a project exists
 */
function gp_query_exists_project( $project_ID = 0 ) {

	if ( $project_ID != 0 && $project_ID != '' ) {
		if ( gp_query_get_project( $project_ID ) ) {
			return true;
		}
	}

	return false;

}


/**
 * Test if a map exists
 */
function gp_query_exists_map( $map_ID = 0 ) {

	if ( $map_ID != 0 && $map_ID != '' ) {
		if ( gp_query_get_map( $map_ID ) ) {
			return true;
		}
	}

	return false;

}



/**********************
 ****** COUNTERS ******
 **********************/


/**
 * Count Maps in a given project
 */
function gp_query_count_maps_in_project( $project_id = 0 ) {

	if ( $project_id != 0 ) {

		$maps_in_this_project = get_posts( array(
	        'post_type'     	=> 'maps',
	        'post_status'  	 	=> 'publish',
		    'meta_query'    	=> array( array(
							            'key'       => 'gp_project',
							            'value'     => $project_id,
							            'compare'   => '='
							        )),
	        'posts_per_page'	=> -1
	    ));

	    return count( $maps_in_this_project );

	}

	return 0;

}


/**
 * Count Posts in a given project
 */
function gp_query_count_posts_in_project( $project_id = 0 ) {

	if ( $project_id != 0 ) {

		$posts_in_this_project = get_posts( array(
	        'post_type'     	=> 'post',
	        'post_status'   	=> 'publish',
	        'meta_query'    	=> array( array(
							            'key'       => 'gp_project',
							            'value'     => $project_id,
							            'compare'   => '='
							        )),
	        'posts_per_page'	=> -1
	    ));

	    return count( $posts_in_this_project );

	}

	return 0;

}


/**
 * Count Markers in a given Map
 */
function gp_query_count_markers_in_map( $map_id = 0 ) {

	if ( $map_id != 0 ) {

		$posts_in_this_project = get_posts( array(
            'post_type'     	=> 'markers',
            'post_status'   	=> 'publish',
            'meta_query'    	=> array( array(
						                'key'       => 'gp_map',
						                'value'     => $map_id,
						                'compare'   => '='
						            )),
            'posts_per_page'	=> -1
    	));

	    return count( $posts_in_this_project );

	}

	return 0;

}


/**
 * Count Orphan Maps
 */
function gp_query_count_orphan_maps() {

	$maps_in_this_project = get_posts( array(
        'post_type'     	=> 'maps',
        'post_status'  	 	=> 'any',
	    'meta_query'    	=> array( array(
						            'key'       => 'gp_project',
						            'value'     => 0,
						            'compare'   => '='
						        )),
        'posts_per_page'	=> -1
    ));

	return count( $maps_in_this_project );

}


/**
 * Count Orphan Markers
 */
function gp_query_count_orphan_markers() {

	$markers_in_this_map = get_posts( array(
        'post_type'     	=> 'markers',
        'post_status'  	 	=> 'any',
	    'meta_query'    	=> array( array(
						            'key'       => 'gp_map',
						            'value'     => 0,
						            'compare'   => '='
						        )),
        'posts_per_page'	=> -1
    ));

	return count( $markers_in_this_map );

}