<?php
/**
 * GeoProjects JS i18n
 *
 * @package GeoProjects
 */


/**
 * Global Vars for JS
 * @return array Global vars
 */
function gp_js_global_vars() {
    $gp_options = get_option( 'gp_options' );

    return array(
        'ajaxurl'                   => admin_url( 'admin-ajax.php' ),
        'cloudmadeApiKey'           => ( $gp_options['cloudmade_api_key'] != GP_DEFAULT_CLOUDMADE_API_KEY ) ? $gp_options['cloudmade_api_key'] : GP_DEFAULT_CLOUDMADE_API_KEY,
        'defaultMapCenterLat'       => $gp_options['center_lat'],
        'defaultMapCenterLng'       => $gp_options['center_lng'],
        'defaultMapZoom'            => $gp_options['zoom'],
        'defaultCloudmadeStyle'     => $gp_options['cloudmade_style'],
        'defaultMarkerIconFilename' => GP_DEFAULT_MARKER_FILE,
        'urlToDefaultMarkersIcons'  => GP_URL_DEFAULT_MARKERS_ICONS,
        'urlToCustomMarkersIcons'   => GP_URL_CUSTOM_MARKERS_ICONS,
        'urlToLoadingImg'           => GP_URL_IMAGE_LOADING,
        'urlMediaelementLib'        => GP_URL_MEDIAELEMENT . '/mediaelement-and-player.min.js',
        'defaultExportMapHeight'    => GP_DEFAULT_EXPORT_MAP_HEIGHT
    );
    
}


