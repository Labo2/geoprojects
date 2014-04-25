<?php
/**
 * GeoProjects Common functions
 *
 * @package GeoProjects
 */

/**
 * Require Queries functions
 */
require_once( GP_PATH_INC . '/functions-queries.php' );

/**
 * Require common utils functions
 */
require_once( GP_PATH_INC . '/functions-common-utils.php' );

/**
 * Require AJAX functions
 */
require_once( GP_PATH_INC . '/functions-ajax.php' );


/**
 * Register posts types (in init action)
 */
require_once( GP_PATH_CPT . '/projects.php' );
require_once( GP_PATH_CPT . '/maps.php' );
require_once( GP_PATH_CPT . '/markers.php' );

/**
 * Include Custom Widgets classes definitions
 */
require_once( GP_PATH_OTHERS . '/widget-posts-in-category.php' );

/**
 * Require JS i18n
 */
require_once( GP_PATH_INC . '/js-i18n.php' );

/**
 * Require JS global Vars
 */
require_once( GP_PATH_INC . '/js-global-vars.php' );


/**
 * Flush Rewrite Rules on theme switching
 */
function gp_flush_rewrite_rules() {
	flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'gp_flush_rewrite_rules' );


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 */
function gp_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( GP_PATH_OTHERS . '/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( GP_PATH_OTHERS . '/extras.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'lang_geoprojects', GP_PATH_LANGUAGES );

	/**
	 * Unactivate Theme Editor
	 */
	define( 'DISALLOW_FILE_EDIT', true );

	/**
	 * This theme styles the visual editor with editor-style.css to match the theme style.
	 */
	add_editor_style();

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme allows users to set a custom background.
	add_theme_support(
		'custom-background',
		array( 'default-color' => '2C3A4E' )
	);

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'lang_geoprojects' ),
	) );

	/**
	 * Add Images sizes
	 */
	add_image_size( 'gp-front-map-fimg', GP_IMAGE_SIZE_FRONT_MAP_FIMG_WIDTH, GP_IMAGE_SIZE_FRONT_MAP_FIMG_HEIGHT, true );
	add_image_size( 'gp-marker-popup', GP_IMAGE_SIZE_MARKER_POPUP_WIDTH, GP_IMAGE_SIZE_MARKER_POPUP_HEIGHT, true );
	add_image_size( 'gp-marker-popup-ribbon', GP_IMAGE_SIZE_MARKER_POPUP_RIBBON_WIDTH, GP_IMAGE_SIZE_MARKER_POPUP_RIBBON_HEIGHT, true );
	add_image_size( 'gp-project-thumb', GP_IMAGE_SIZE_PROJECT_THUMB_WIDTH, GP_IMAGE_SIZE_PROJECT_THUMB_HEIGHT, false );
	add_image_size( 'gp-post-thumb-in-list', GP_IMAGE_SIZE_POST_THUMB_IN_LIST_WIDTH, GP_IMAGE_SIZE_POST_THUMB_IN_LIST_HEIGHT, true );

	// If theme is activated
	if ( isset( $_GET['activated'] ) ) {
		// Create default theme options (settings)
		gp_default_theme_options();
	}
}

add_action( 'after_setup_theme', 'gp_setup' );


/**
 * Define the default theme options (settings)
 */
function gp_default_theme_options() {

	$default_options = array(
		'primary_color'					=> GP_DEFAULT_PRIMARY_COLOR,
		'secondary_color'				=> GP_DEFAULT_SECONDARY_COLOR,
		'front_nb_maps'					=> GP_DEFAULT_FRONT_NB_MAPS,
		'tiles_provider'                => GP_DEFAULT_TILES_PROVIDER,
		'special_map_tiles_provider'    => GP_DEFAULT_TILES_PROVIDER,
		'cloudmade_api_key'             => GP_DEFAULT_CLOUDMADE_API_KEY,
		'cloudmade_style'               => GP_DEFAULT_CLOUDMADE_STYLE,
		'special_map_cloudmade_style'   => GP_DEFAULT_CLOUDMADE_STYLE,
		'center_lat' 					=> GP_DEFAULT_MAP_CENTER_LAT,
		'center_lng' 					=> GP_DEFAULT_MAP_CENTER_LNG,
		'zoom'							=> GP_DEFAULT_MAP_ZOOM,
		'export_maps'					=> GP_DEFAULT_EXPORT_MAPS,
		'url_twitter' 					=> GP_DEFAULT_URL_TWITTER,
		'url_facebook' 					=> GP_DEFAULT_URL_FACEBOOK,
		'url_youtube' 					=> GP_DEFAULT_URL_YOUTUBE,
		'project_trash_keep_contents' 	=> GP_DEFAULT_PROJECT_TRASH_KEEP_CONTENTS,
		'map_trash_keep_markers'		=> GP_DEFAULT_MAP_TRASH_KEEP_MARKERS,
		'theme_version' 				=> GP_THEME_VERSION
	);

	// delete_option( 'gp_options' ); // uncomment for debug
	add_option( 'gp_options', $default_options );

}


/**
 * Register widgetized area
 * Register Custom Widgets
 *
 */
function gp_widgets_init() {

	// Register widgetized area
	register_sidebar( array(
		'name' => __( 'Footer Widgets', 'lang_geoprojects' ),
		'id' => 'footer-widgets',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	// Register custom widgets
	register_widget( 'gp_widget_posts_in_category' );

}

add_action( 'widgets_init', 'gp_widgets_init' );