<?php
/**
 * Additional columns in listings
 *
 * Add 'Project' column in POSTS and MAPS posts types
 * Add 'Map' column in MARKERS post type
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */


/**
 * Add columns heads
 * @param  array    $columns  Array of columns names
 * @return array                    Modified array
 */
function gp_add_column_heads( $defaults, $new_columns ) {
    $new_defaults = array();

    // Add custom columns before the selected column
    foreach ( $defaults as $default_column_ID => $default_column_title ) {

        if ( array_key_exists( $default_column_ID, $new_columns ) ) {
            
            foreach( $new_columns[$default_column_ID] as $new_column_ID => $new_column_title ) {
                $new_defaults[$new_column_ID] = $new_column_title;
            }

        }

        $new_defaults[$default_column_ID] = $default_column_title;

    }

    return $new_defaults;

}


/**
 * Add column contents
 * @param  array    $column_name    Name of the current column
 * @param  int      $post_ID        Post ID
 * @return                          Echo HTML content
 */
function gp_add_column_content( $column_name, $post_ID ) {

    switch( $column_name ) {

        case 'totals_in_project':

            // Total maps in this project
            $total_maps = gp_query_count_maps_in_project( $post_ID );

            // Total posts in this project
            $total_posts = gp_query_count_posts_in_project( $post_ID );

            echo '<span class="total-project-column-content-info"><strong>' . $total_maps . '</strong> ' . _n( 'map', 'maps', $total_maps, 'lang_geoprojects' ) . '</span>';
            echo '<span class="total-project-column-content-info"><strong>' . $total_posts . '</strong> ' . _n( 'post', 'posts', $total_posts, 'lang_geoprojects' ) . '</span>';

            break;

        case 'project':

            $project_ID = get_post_meta( $post_ID, 'gp_project', true );

            // Current post type has a project
            if ( $project_ID != 0 ) {

                $project = gp_query_get_project( $project_ID );

                if ( $project != '' ) {
                    echo $project->post_title;
                }

            }

            break;

        case 'marker_map':

            $map_ID = get_post_meta( $post_ID, 'gp_map', true );

            // Current post type has a map
            if ( $map_ID != 0 ) {

                $map = gp_query_get_map( $map_ID );

                if ( $map != '' ) {
                    echo $map->post_title;
                }

            }

            break;

        case 'marker_icon':

            $icon_type = get_post_meta( $post_ID, 'gp_icon_type', true );
            $icon_filename = get_post_meta( $post_ID, 'gp_icon_filename', true );

            $icon_src = ( $icon_type == 'default' ) ? GP_URL_DEFAULT_MARKERS_ICONS . '/' . $icon_filename : GP_URL_CUSTOM_MARKERS_ICONS . '/' . $icon_filename;

            echo '<img src="' . $icon_src . '" class="marker-icon">';

            break;

        case 'total_markers':

            echo gp_query_count_markers_in_map( $post_ID );

            break;

    }

}


/**
 * ##########################
 * ADD COLUMNS TO POSTS TYPES
 * ##########################
 */


/**
 * Add custom columns heads and content to POSTS listing
 * @param  array $defaults 	Defaults columns heads
 * @return array 			The modified array
 */
function gp_posts_listing_columns_head( $defaults ) {

    return gp_add_column_heads(
        $defaults,
        array(
            'date'  => array(
                'project'   => __( 'Project', 'lang_geoprojects' )
            )
        )
    );

}

add_filter( 'manage_post_posts_columns', 'gp_posts_listing_columns_head', 10 );
add_action( 'manage_post_posts_custom_column', 'gp_add_column_content', 10, 2 );


/**
 * Add custom columns heads and content to PROJECTS listing
 * @param  array $defaults 	Defaults columns heads
 * @return array 			The modified array
 */
function gp_projects_listing_columns_head( $defaults ) {

	return gp_add_column_heads(
        $defaults,
        array(
            'date'  => array(
                'totals_in_project'    => __( 'Totals', 'lang_geoprojects' )
            )
        )
    );

}

add_filter( 'manage_projects_posts_columns', 'gp_projects_listing_columns_head', 10 );
add_action( 'manage_projects_posts_custom_column', 'gp_add_column_content', 10, 2 );


/**
 * Add custom columns heads to MAPS listing
 * @param  array $defaults 	Defaults columns heads
 * @return array 			The modified array
 */
function gp_maps_listing_columns_head( $defaults ) {

	return gp_add_column_heads(
        $defaults,
        array(
            'date'  => array(
                'project'       => __( 'Project', 'lang_geoprojects' ),
                'total_markers' => __( 'Markers', 'lang_geoprojects' )
            )
        )
    );

}

add_filter( 'manage_maps_posts_columns', 'gp_maps_listing_columns_head', 10 );
add_action( 'manage_maps_posts_custom_column', 'gp_add_column_content', 10, 2 );


/**
 * Add custom columns heads to MARKERS listing
 * @param  array $defaults 	Defaults columns heads
 * @return array 			The modified array
 */
function gp_markers_listing_columns_head( $defaults ) {

    return gp_add_column_heads(
        $defaults,
        array(
            'title' => array(
                'marker_icon'  => __( 'Icon', 'lang_geoprojects' )
            ),
            'date'  => array(
                'marker_map'   => __( 'Map', 'lang_geoprojects' )
            )
        )
    );

}

add_filter( 'manage_markers_posts_columns', 'gp_markers_listing_columns_head', 10 );
add_action( 'manage_markers_posts_custom_column', 'gp_add_column_content', 10, 2 );








