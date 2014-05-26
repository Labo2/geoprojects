<?php
/**
 * GeoProjects Admin funtions
 *
 * @package GeoProjects
 */


/**
 * Require Admin utils functions
 */
require_once( GP_PATH_INC . '/functions-admin-utils.php' );


/**
 * Register Metaboxes
 */
require_once( GP_PATH_MBOX . '/projects-list.php' );
require_once( GP_PATH_MBOX . '/project-infos.php' );
require_once( GP_PATH_MBOX . '/map-preview.php' );
require_once( GP_PATH_MBOX . '/map-infos.php' );
require_once( GP_PATH_MBOX . '/marker-infos.php' );


/**
 * Add custom colums and filters in listings
 */
require_once( GP_PATH_OTHERS . '/custom-listing-columns.php' );
require_once( GP_PATH_OTHERS . '/custom-listing-filters.php' );


/**
 * Add Theme Settings page
 */
require_once( GP_PATH_OTHERS . '/admin-menus.php' );


/**
 * Admin Init
 * - Register settings fields
 */
function gp_admin_init() {

    // Register settings
    if ( current_user_can( 'delete_others_posts' ) ) {
        require( GP_PATH_OTHERS . '/settings.php' );
        gp_register_settings();
    }
    
}

add_action( 'admin_init', 'gp_admin_init' );


/**
 * Enqueue CSS and JS for Admin
 */
function gp_admin_enqueue_scripts( $hook ) {
    global $post_type, $pagenow;
    $gp_options = get_option( 'gp_options' );

	// Admin CSS
	wp_enqueue_style( 'gp_admin_css', GP_URL_CSS . '/admin.css', array(), '0.1.2', 'all' );

    // For Map / Marker Forms and settings page
    if ( $post_type == 'markers' || $post_type == 'maps' || ( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'gp_geoprojects_page' ) ) {

        // Leaflet CSS
        wp_enqueue_style( 'gp_leaflet_css', GP_URL_LEAFLET . '/leaflet.css', array(), '0.1.2', 'all' );

        // Custom Leaflet CSS
        wp_enqueue_style( 'gp_leaflet_map_css', GP_URL_CSS . '/leaflet-map.css', array(), '0.1.2', 'all' );

        // Leaflet JS
        wp_enqueue_script( 'gp_leaflet_js', GP_URL_LEAFLET . '/leaflet.js', array( 'jquery' ), '0.1.2', true );

        // Custom Leaflet JS
        wp_enqueue_script( 'gp_leaflet_wrapper_js', GP_URL_JS . '/leaflet-wrapper.js', array( 'jquery', 'gp_leaflet_js' ), '0.1.2', true );

    }

    // For Settings page
    if ( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'gp_geoprojects_page' ) {
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );
    }

    // MediaElement CSS for Map / Marker Forms
    if ( $post_type == 'markers' || $post_type == 'maps' ) {

        // MediaElement CSS
        wp_enqueue_style( 'mediaelement' );
        wp_enqueue_style( 'wp-mediaelement' );

    }

    // Admin JS
    wp_enqueue_script( 'gp_admin_js', GP_URL_JS . '/admin.js', array( 'jquery' ), '0.1.2', true );

    // Some global vars
    wp_localize_script( 'jquery', 'gpGlobalVars', gp_js_global_vars() );

    // Some i18n
    wp_localize_script( 'jquery', 'gpGlobalI18n', gp_js_i18n() );

}

add_action( 'admin_enqueue_scripts', 'gp_admin_enqueue_scripts' );


/*
 * Customise the WYSIWYG buttons
 */
function gp_custom_wysiwyg_buttons( $init ) {
  	// block formats available
  	$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5';
  	// some buttons suppressed
  	$init['theme_advanced_disable'] = 'blockquote,pastetext,pasteword,justifyfull';
  	return $init;
}

add_filter( 'tiny_mce_before_init', 'gp_custom_wysiwyg_buttons' );


/**
 * Add custom posts types counts to Dashboard widget
 */
function gp_add_cpt_counts_to_dashboard_glance_items() {
    $output = array();

    // Projects
    $nbProjects = wp_count_posts( 'projects' );
    $nbProjectsPublished = $nbProjects->publish;
    $projectsText = _n( __( 'Project', 'lang_geoprojects' ), __( 'Projects', 'lang_geoprojects' ), $nbProjectsPublished );

    // Maps
    $nbMaps = wp_count_posts( 'maps' );
    $nbMapsPublished = $nbMaps->publish;
    $mapsText = _n( __( 'Map', 'lang_geoprojects' ), __( 'Maps', 'lang_geoprojects' ), $nbMapsPublished );

    // Markers
    $nbMarkers = wp_count_posts( 'markers' );
    $nbMarkersPublished = $nbMarkers->publish;
    $markersText = _n( __( 'Marker', 'lang_geoprojects' ), __( 'Markers', 'lang_geoprojects' ), $nbMarkersPublished );

    // Can the current user clic on numbers ?
    if ( current_user_can( 'edit_posts' ) ) {
        $output[] = '<a href="edit.php?post_type=projects">' . $nbProjectsPublished . ' ' . $projectsText . '</a>';
        $output[] = '<a href="edit.php?post_type=maps">' . $nbMapsPublished . ' ' . $mapsText . '</a>';
        $output[] = '<a href="edit.php?post_type=markers">' . $nbMarkersPublished . ' ' . $markersText . '</a>';
    } else {
        $output[] = $nbProjectsPublished . ' ' . $projectsText;
        $output[] = $nbMapsPublished . ' ' . $mapsText;
        $output[] = $nbMarkersPublished . ' ' . $markersText;
    }

    return $output;

}

add_filter( 'dashboard_glance_items', 'gp_add_cpt_counts_to_dashboard_glance_items' );


/**
 * Hide Wordpress Update notice for all but admin
 */
function gp_hide_update_notice_to_all_but_admin_users() 
{
    if ( !current_user_can( 'update_core' ) ) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}

add_action( 'admin_notices', 'gp_hide_update_notice_to_all_but_admin_users', 1 );


/**
 * Modify the admin footer text
 */
function gp_admin_footer_text () {
    bloginfo( 'description' );
}

add_filter( 'admin_footer_text', 'gp_admin_footer_text' );