<?php
/**
 * GeoProjects Frontend funtions
 *
 * @package GeoProjects
 */


/**
 * Enqueue scripts and styles
 * and remove unused
 */
function gp_enqueue_scripts() {
	global $template;

	// If we are in all page except export map page
	if ( !( ( basename( $template ) == 'single-maps.php' ) && isset( $_GET['embed'] ) && $_GET['embed'] == 1 ) ) {
		$gp_options = get_option( 'gp_options' );

		// Leaflet CSS
	    wp_enqueue_style( 'gp_leaflet_css', GP_URL_LEAFLET . '/leaflet.css', array(), '0.1.1', 'all' );

	    // Custom Leaflet CSS
	    wp_enqueue_style( 'gp_leaflet_map_css', GP_URL_CSS . '/leaflet-map.css', array(), '0.1.1', 'all' );

	    // MediaElement CSS
	    wp_enqueue_style( 'mediaelement' );
	    wp_enqueue_style( 'wp-mediaelement' );

		// Frontend JS
		// Including : Respond.js, the small navigation menu trigger, fitvids.js, iOS orientation fix
		wp_enqueue_script( 'gp_frontend_js', GP_URL_JS . '/frontend.js', array( 'jquery' ), '0.1.1', true );

		wp_localize_script( 'jquery', 'gpGlobalVars', gp_js_global_vars() );

	    // Some i18n
	    wp_localize_script( 'jquery', 'gpGlobalI18n', gp_js_i18n() );

		// JS for comment replying
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Add Custom Open Sans, and Ubuntu Fonts and deregister the one registered by wordpress when authentified
		if ( wp_style_is( 'open-sans', 'registered' ) ) {
			wp_deregister_style( 'open-sans' );
		}
		wp_enqueue_style( 'open-sans', '//fonts.googleapis.com/css?family=Ubuntu+Condensed|Open+Sans:300italic,400,300,600&subset=latin,latin-ext', array(), '0.1.1', 'all' );

	}

}

add_action( 'wp_enqueue_scripts', 'gp_enqueue_scripts' );


/**
 * Customize title and url of login page
 */
function gp_login_headerurl() {
	return get_bloginfo( 'url' );
}

function gp_login_headertitle() {
	return get_option( 'blogname' );
}

add_filter( 'login_headerurl', 'gp_login_headerurl' );
add_filter( 'login_headertitle', 'gp_login_headertitle' );


/**
 * Get a custom Excerpt regarding the given type
 * @param  string $type Type of the excerpt.
 */
function gp_get_custom_excerpt( $type = 'default', $with_more_link = true ) {
	global $post;
	$excerpt_more_link = ( $with_more_link ) ? ' <a href="' . get_permalink( $post ) . '" class="entry-more">' . __( 'more', 'lm3' ) . '...</a>' : '...';

	switch( $type ) {
		case 'post-in-project-list':
			$excerpt_length = GP_DEFAULT_EXCERPT_POST_IN_PROJECT_LIST;
			break;
		case 'side-map':
			$excerpt_length = GP_DEFAULT_EXCERPT_SIDE_POST;
			break;
		default:
			$excerpt_length = GP_DEFAULT_EXCERPT_LENGTH;
			break;
	}

	// Has already a manual excerpt
	if ( has_excerpt() ) {
		$output_excerpt = $post->post_excerpt . $excerpt_more_link;
	}
	// Generate an excerpt
	else {
		$output_excerpt = get_the_content( '' );
		$output_excerpt = strip_shortcodes( $output_excerpt );
		$output_excerpt = apply_filters( 'the_content', $output_excerpt );
		$output_excerpt = str_replace( ']]>', ']]&gt;', $output_excerpt );
		$output_excerpt = wp_trim_words( $output_excerpt, $excerpt_length, $excerpt_more_link );
	}

	echo $output_excerpt;
}


/**
 * Add necessary Leaflet JS for displaying a map
 */
function gp_load_frontend_leaflet() {

	// Leaflet JS
	wp_dequeue_script( 'gp_leaflet_js' );
    wp_enqueue_script( 'gp_leaflet_js', GP_URL_LEAFLET . '/leaflet.js', array( 'jquery' ), '0.1.1', true );

    // Custom Leaflet JS
    wp_dequeue_script( 'gp_leaflet_wrapper_js' );
    wp_enqueue_script( 'gp_leaflet_wrapper_js', GP_URL_JS . '/leaflet-wrapper.js', array( 'jquery', 'gp_leaflet_js' ), '0.1.1', true );

    // Custom JS (reloaded here for placing it after leaflet)
    wp_dequeue_script( 'gp_frontend_js' );
    wp_enqueue_script( 'gp_frontend_js', GP_URL_JS . '/frontend.js', array( 'jquery', 'gp_leaflet_wrapper_js' ), '0.1.1', true );

}