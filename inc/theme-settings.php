<?php
/**
 * Check and setup theme's default settings
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mjlah_setup_theme_default_settings' ) ) {
	/**
	 * Store default theme settings in database.
	 */
	function mjlah_setup_theme_default_settings() {
		$defaults = mjlah_get_theme_default_settings();
		$settings = get_theme_mods();
		foreach ( $defaults as $setting_id => $default_value ) {
			// Check if setting is set, if not set it to its default value.
			if ( ! isset( $settings[ $setting_id ] ) ) {
				set_theme_mod( $setting_id, $default_value );
			}
		}
	}
}

if ( ! function_exists( 'mjlah_get_theme_default_settings' ) ) {
	/**
	 * Retrieve default theme settings.
	 *
	 * @return array
	 */
	function mjlah_get_theme_default_settings() {
		$defaults = array(
			'mjlah_posts_index_style' => 'default',   // Latest blog posts style.
			'mjlah_sidebar_position'  => 'right',     // Sidebar position.
			'mjlah_container_type'    => 'container', // Container width.
		);

		/**
		 * Filters the default theme settings.
		 *
		 * @param array $defaults Array of default theme settings.
		 */
		return apply_filters( 'mjlah_theme_default_settings', $defaults );
	}
}


