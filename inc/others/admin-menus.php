<?php
/**
 * GeoProjects Admin Menus
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */


/**
 * Add admin menus
 * - Theme Settings page
 */
function gp_admin_menu() {
	// Main Menu
	add_menu_page( __( 'Theme settings', 'lang_geoprojects' ), __( 'GeoProjects', 'lang_geoprojects' ), 'delete_others_posts', 'gp_geoprojects_page', 'gp_geoprojects_page_content', 'dashicons-admin-generic', '100');

	// Submenus
	add_submenu_page( 'gp_geoprojects_page', __( 'Help - Credits', 'lang_geoprojects' ), __( 'Help - Credits', 'lang_geoprojects' ), 'delete_others_posts', 'gp_geoprojects_page_help', 'gp_geoprojects_page_help' . '_content' );
	
	// Fix the title of the 1st submenu which is the same link than the top level but not the same text
	global $submenu;
	
	if ( isset( $submenu['gp_geoprojects_page'] ) ) {
		$submenu['gp_geoprojects_page'][0][0] = __( 'Theme settings', 'lang_geoprojects' );
	}
}

add_action( 'admin_menu', 'gp_admin_menu' );


/**
 * Theme settings page content
 */
function gp_geoprojects_page_content() {
	?>

	<div id="page_settings" class="wrap">
  
		<div id="icon-options-general" class="icon32"><br></div>
		<h2><?php _e( 'Theme settings', 'lang_geoprojects' ); ?></h2>

		<?php settings_errors(); ?>

		<form action="options.php" method="post">

			<?php
			settings_fields( 'gp_options' );
			do_settings_sections( 'gp_theme_settings' );
			?>

			<p class="submit">
				<input type="submit" name="Submit" value="<?php _e( 'Save changes', 'lang_geoprojects' ); ?>" class="button-primary">
			</p>

		</form>

	</div>

	<?php
}


/**
 * Help Page Content
 */
function gp_geoprojects_page_help_content() {

	require_once( GP_PATH_OTHERS . '/help.php' );

}