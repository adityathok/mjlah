<?php
/**
 * mjlah enqueue scripts
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mjlah_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function mjlah_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.css' );
		wp_enqueue_style( 'mjlah-styles', get_template_directory_uri() . '/css/theme.css', array(), $css_version );
		wp_enqueue_style( 'mjlah-custom-styles', get_template_directory_uri() . '/css/custom.css', array(), $css_version );

		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'mjlah-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version, true );
		wp_enqueue_script( 'mjlah-custom-scripts', get_template_directory_uri() . '/js/custom.js', array(), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // End of if function_exists( 'mjlah_scripts' ).

add_action( 'wp_enqueue_scripts', 'mjlah_scripts' );
