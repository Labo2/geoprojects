<?php
/**
 * GeoProjects Base Variables
 *
 * @package GeoProjects
 */

$upload_dir = wp_upload_dir();


/* SOME COOL VARS */

define( 'GP_THEME_VERSION', '0.1.2' );

define( 'GP_DEFAULT_MARKER_FILE', '0000.png' );
define( 'GP_CUSTOM_MARKERS_ICONS_DIRNAME', 'markers-icons' );

define( 'GP_IMAGE_SIZE_FRONT_MAP_FIMG_WIDTH', 400 );
define( 'GP_IMAGE_SIZE_FRONT_MAP_FIMG_HEIGHT', 250 );
define( 'GP_IMAGE_SIZE_MARKER_POPUP_WIDTH', 250 );
define( 'GP_IMAGE_SIZE_MARKER_POPUP_HEIGHT', 150 );
define( 'GP_IMAGE_SIZE_MARKER_POPUP_RIBBON_WIDTH', 250 );
define( 'GP_IMAGE_SIZE_MARKER_POPUP_RIBBON_HEIGHT', 100 );
define( 'GP_IMAGE_SIZE_PROJECT_THUMB_WIDTH', 400 );
define( 'GP_IMAGE_SIZE_PROJECT_THUMB_HEIGHT', 300 );
define( 'GP_IMAGE_SIZE_POST_THUMB_IN_LIST_WIDTH', 250 );
define( 'GP_IMAGE_SIZE_POST_THUMB_IN_LIST_HEIGHT', 250 );

define( 'GP_DEFAULT_PROJECTS_DISPLAYED_IN_LIST_MIN', 2 );
define( 'GP_DEFAULT_PROJECTS_DISPLAYED_IN_LIST_MED', 4 );
define( 'GP_DEFAULT_PROJECTS_DISPLAYED_IN_LIST_MAX', 15 );

define( 'GP_DEFAULT_EXCERPT_LENGTH', 60 );
define( 'GP_DEFAULT_EXCERPT_SIDE_POST', 35 );
define( 'GP_DEFAULT_EXCERPT_POST_IN_PROJECT_LIST', 45 );

define( 'GP_NB_OTHER_CONTENTS_IN_SAME_PROJECT_TRIGGER_LAST_MAPS', 2 );
define( 'GP_NB_SIDE_LAST_MAPS', 4 );
define( 'GP_WIDGET_POSTS_IN_CATEGORY_NB_POSTS', 5 );
define( 'GP_DEFAULT_EXPORT_MAP_HEIGHT', 400 );

/* THEME SETTINGS */

define( 'GP_DEFAULT_TITLE_COLOR', '#86A2C2' );
define( 'GP_DEFAULT_TAGLINE_COLOR', '#FFFFFF' );
define( 'GP_DEFAULT_PRIMARY_COLOR', '#86A2C2' );
define( 'GP_DEFAULT_SECONDARY_COLOR', '#39526E' );
define( 'GP_DEFAULT_TILES_PROVIDER', 'osm' );
define( 'GP_DEFAULT_CLOUDMADE_API_KEY', '' );
define( 'GP_DEFAULT_CLOUDMADE_STYLE', 997 );
define( 'GP_DEFAULT_MAP_CENTER_LAT', '47.9005296' );
define( 'GP_DEFAULT_MAP_CENTER_LNG', '1.9137456' );
define( 'GP_DEFAULT_MAP_ZOOM', 12 );
define( 'GP_DEFAULT_EXPORT_MAPS', 1 );
define( 'GP_DEFAULT_URL_TWITTER', '' );
define( 'GP_DEFAULT_URL_FACEBOOK', '' );
define( 'GP_DEFAULT_URL_YOUTUBE', '' );
define( 'GP_DEFAULT_FRONT_NB_MAPS', 12 );
define( 'GP_DEFAULT_PROJECT_TRASH_KEEP_CONTENTS', 1 );
define( 'GP_DEFAULT_MAP_TRASH_KEEP_MARKERS', 1 );

/* PATHS */

define( 'GP_PATH_INC', get_template_directory() . '/inc' );
define( 'GP_PATH_CPT', GP_PATH_INC . '/cpt' );
define( 'GP_PATH_IMAGES', get_template_directory() . '/images' );
define( 'GP_PATH_LANGUAGES', get_template_directory() . '/languages' );
define( 'GP_PATH_MBOX', GP_PATH_INC . '/mbox' );
define( 'GP_PATH_OTHERS', GP_PATH_INC . '/others' );

define( 'GP_PATH_DEFAULT_MARKERS_ICONS', GP_PATH_IMAGES . '/markers-icons' );
define( 'GP_PATH_DEFAULT_MARKERS_SHADOWS', GP_PATH_DEFAULT_MARKERS_ICONS . '/shadows' );
define( 'GP_PATH_CUSTOM_MARKERS_ICONS', WP_CONTENT_DIR . '/' . GP_CUSTOM_MARKERS_ICONS_DIRNAME );
define( 'GP_PATH_CUSTOM_MARKERS_SHADOWS', GP_PATH_CUSTOM_MARKERS_ICONS . '/shadows' );

/* URLS */

define( 'GP_URL_CSS', get_template_directory_uri() . '/css' );
define( 'GP_URL_INC', get_template_directory_uri() . '/inc' );
define( 'GP_URL_IMAGES', get_template_directory_uri() . '/images' );
define( 'GP_URL_JS', get_template_directory_uri() . '/js' );
define( 'GP_URL_LIBS', get_template_directory_uri() . '/libs' );
define( 'GP_URL_LEAFLET', GP_URL_LIBS . '/leaflet' );

define( 'GP_URL_DEFAULT_MARKERS_ICONS', GP_URL_IMAGES . '/markers-icons' );
define( 'GP_URL_DEFAULT_MARKERS_SHADOWS', GP_URL_DEFAULT_MARKERS_ICONS . '/shadows' );
define( 'GP_URL_CUSTOM_MARKERS_ICONS', WP_CONTENT_URL . '/' . GP_CUSTOM_MARKERS_ICONS_DIRNAME );
define( 'GP_URL_CUSTOM_MARKERS_SHADOWS', GP_URL_CUSTOM_MARKERS_ICONS . '/shadows' );

define( 'GP_URL_IMAGE_LOADING', GP_URL_IMAGES . '/loading.gif' );

define( 'GP_URL_MEDIAELEMENT', includes_url() . 'js/mediaelement' );