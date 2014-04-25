<?php
/**
 * Additional filters in listings
 *
 * In maps list : 
 * - add a link in view filters for seeing orpahn maps (no project)
 *
 * In markers list :
 * - add a link in view filters for seeing orphan markers (no maps)
 *
 * @package GeoProjects
 */


/***********************
 * MAPS LISTING FILTERS
 ***********************/

/**
 * Add custom view
 * @param  array $views Array of view links
 * @return array        Updated array of view links
 */

/* Add view link menu */

function gp_views_edit_maps( $views ) {
	$new_views = array();

	// Insert the view 'orphans maps' just before 'trash' if 'trash' exists
	if ( array_key_exists( 'trash', $views ) ) {

		foreach ( $views as $view_ID => $view_link ) {
			
			if ( $view_ID == 'trash' ) {
				$new_views['orphans'] = '<a href="' . admin_url( 'edit.php' ) . '?post_type=maps&orphans=1">' . __( 'Orphan Maps', 'lang_geoprojects' ) . ' <span class="count">(' . gp_query_count_orphan_maps() . ')</span></a>';
			}

			$new_views[$view_ID] = $view_link;

		}

	}
	else {

		$new_views = $views;
		$new_views['orphans'] = '<a href="' . admin_url( 'edit.php' ) . '?post_type=maps&orphans=1">' . __( 'Orphan Maps', 'lang_geoprojects' ) . ' <span class="count">(' . gp_query_count_orphan_maps() . ')</span></a>';

	}

	return $new_views;

}

add_filter( 'views_edit-maps', 'gp_views_edit_maps' );

/* Alter query to filter by orphan maps */

function gp_load_edit_maps_custom_view_filter() {
    global $typenow;

    // Return if not CPT maps
    if( 'maps' != $typenow ) { return; }

    add_filter( 'posts_where' , 'gp_post_where_maps_custom_view_filter' );
}

add_action( 'load-edit.php', 'gp_load_edit_maps_custom_view_filter' );

function gp_post_where_maps_custom_view_filter( $where ) {
    global $wpdb;       

    if ( isset( $_GET[ 'orphans' ] ) && !empty( $_GET[ 'orphans' ] ) ) 
    {
        $where .= " AND ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key='gp_project' AND meta_value=0 )";
    }
    return $where;
}



/**************************
 * MARKERS LISTING FILTERS
 **************************/

/**
 * Add custom view
 * @param  array $views Array of view links
 * @return array        Updated array of view links
 */

/* Add view link menu */

function gp_views_edit_markers( $views ) {
	$new_views = array();

	// Insert the view 'orphans markers' just before 'trash' if 'trash' exists
	if ( array_key_exists( 'trash', $views ) ) {

		foreach ( $views as $view_ID => $view_link ) {
			
			if ( $view_ID == 'trash' ) {
				$new_views['orphans'] = '<a href="' . admin_url( 'edit.php' ) . '?post_type=markers&orphans=1">' . __( 'Orphan Markers', 'lang_geoprojects' ) . ' <span class="count">(' . gp_query_count_orphan_markers() . ')</span></a>';
			}

			$new_views[$view_ID] = $view_link;

		}

	}
	else {

		$new_views = $views;
		$new_views['orphans'] = '<a href="' . admin_url( 'edit.php' ) . '?post_type=markers&orphans=1">' . __( 'Orphan Markers', 'lang_geoprojects' ) . ' <span class="count">(' . gp_query_count_orphan_markers() . ')</span></a>';

	}

	return $new_views;

}

add_filter( 'views_edit-markers', 'gp_views_edit_markers' );

/* Alter query to filter by orphan markers */

function gp_load_edit_markers_custom_view_filter() {
    global $typenow;

    // Return if not CPT markers
    if( 'markers' != $typenow ) { return; }

    add_filter( 'posts_where' , 'gp_post_where_markers_custom_view_filter' );
}

add_action( 'load-edit.php', 'gp_load_edit_markers_custom_view_filter' );

function gp_post_where_markers_custom_view_filter( $where ) {
    global $wpdb;       

    if ( isset( $_GET[ 'orphans' ] ) && !empty( $_GET[ 'orphans' ] ) ) 
    {
        $where .= " AND ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key='gp_map' AND meta_value=0 )";
    }
    return $where;
}

