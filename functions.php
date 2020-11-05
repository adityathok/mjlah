<?php
/**
 * mjlah functions and definitions
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$mjlah_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
	'/editor.php',                          // Load Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
	'/builder-part.php',                    // Load kirki.
	'/kirki/kirki.php',                     // Load kirki.
	'/customizer.php',						// Setup Kirki.
	'/aq_resizer.php',						// load aq_resizer functions.
	'/breadcrumbs.php',						// load breadcrumbs functions.
	'/template-function.php',							// load mjlah functions.
);

foreach ( $mjlah_includes as $file ) {
	require_once get_template_directory() . '/inc' . $file;
}
