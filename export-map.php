<?php
/**
 * GeoProjects Export Map (in iframe)
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */

global $wp_scripts;

$gp_options = get_option( 'gp_options' );

// Check if this map is allowed to be exported
$meta_map_export = get_post_meta( get_the_ID(), 'gp_export', true );
if ( $meta_map_export == '' ) { $meta_map_export = $gp_options['export_maps']; }

if ( $meta_map_export ) {

	// JS global vars
	$export_js_global = gp_js_global_vars();

	foreach ( (array) $export_js_global as $key => $value ) {
		if ( !is_scalar($value) )
			continue;

		$export_js_global[$key] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8');
	}

	// JS i18n
	$export_js_i18n = gp_js_i18n();

	foreach ( (array) $export_js_i18n as $key => $value ) {
		if ( !is_scalar($value) )
			continue;

		$export_js_i18n[$key] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8');
	}

}


?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8" />
		<?php /* A supprimer : utiliser le .htaccess à la place quand c'est possible */ ?>
  		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title( '' ); ?></title>

		<meta name="viewport" content="width=device-width">
		<meta name="author" content="Nicolas Derambure">
	
		<?php if ( $meta_map_export ) : ?>

			<link rel="stylesheet" type="text/css" href="<?php echo GP_URL_LEAFLET . '/leaflet.css?v=1.0.0'; ?>" media="all">
			<link rel="stylesheet" type="text/css" href="<?php echo GP_URL_CSS . '/export-map.css?v=1.0.0'; ?>" media="all">

			<script type="text/javascript">
			/* <![CDATA[ */
			var gpGlobalVars = <?php echo json_encode( $export_js_global ); ?>;
			var gpGlobalI18n = <?php echo json_encode( $export_js_i18n ); ?>;
			/* ]]> */
			</script>

			<script type="text/javascript" src="<?php echo includes_url( 'js/jquery/jquery.js' ); ?>?v=1.0.0"></script>
			<script type="text/javascript" src="<?php echo GP_URL_LEAFLET . '/leaflet.js?v=1.0.0'; ?>"></script>
			<script type="text/javascript" src="<?php echo GP_URL_JS . '/leaflet-wrapper.js?v=1.0.0'; ?>"></script>
			<script type="text/javascript" src="<?php echo GP_URL_JS . '/export-map.js?v=1.0.0'; ?>"></script>

		<?php endif; ?>

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	</head>
	<body>

		<?php if ( $meta_map_export ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php $map_tiles_provider = get_post_meta( get_the_ID(), 'gp_tiles_provider', true ); ?>

				<div class="gp-leaflet-map-container">
			        <div class="gp-leaflet-map-wrap">
			            <div id="gp-map-<?php the_ID(); ?>" class="gp-leaflet-map"
			            	data-map-id="<?php the_ID(); ?>"
			            	data-map-tiles="<?php echo $map_tiles_provider; ?>"
			                <?php if ( $map_tiles_provider == 'cloudmade' ) : ?>
			                    data-map-cloudmade-style="<?php echo get_post_meta( get_the_ID(), 'gp_cloudmade_style', true ); ?>"
			                <?php endif; ?>
			            	data-map-clusterize="1"
			            	data-map-embed="1"
			            	data-map-title="<?php echo esc_attr( get_the_title() ); ?>"
			            	data-map-original-url="<?php the_permalink(); ?>"></div>
			        </div>
			    </div>

			<?php endwhile; ?>

		<?php else : ?>

			<?php _e( 'Sorry but this map is no more shareable', 'lang_geoprojects' ); ?>.

		<?php endif; ?>

	</body>
</html>