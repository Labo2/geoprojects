<?php
/**
 * GeoProjects functions and definitions
 *
 * @package GeoProjects
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 */
/*if ( ! isset( $content_width ) )
	$content_width = 640; */


/**
 * Base Variables
 */
require_once( get_template_directory() . '/inc/base.php' );


/**
 * COMMON functions
 */
require_once( GP_PATH_INC . '/functions-common.php' );


/**
 * Functions for ADMIN only
 */
if ( is_admin() ) {
	require_once( GP_PATH_INC . '/functions-admin.php' );
}
/**
 * Functions for FRONTEND only
 */
else {
	require_once( GP_PATH_INC . '/functions-frontend.php' );
}