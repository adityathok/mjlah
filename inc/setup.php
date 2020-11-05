<?php
/**
 * Theme basic setup
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

add_action( 'after_setup_theme', 'mjlah_setup' );

if ( ! function_exists( 'mjlah_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mjlah_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'mjlah' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'mjlah_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Set up the WordPress Theme logo feature.
		add_theme_support( 'custom-logo' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Check and setup theme default settings.
		mjlah_setup_theme_default_settings();

	}
}

function mjlah_header_footer_render() {

	if ( ! class_exists( 'FLThemeBuilderLayoutData' ) ) {
		return;
	}

	// Get the header ID.
	$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();

	// If we have a header, remove the theme header and hook in Theme Builder's.
	if ( ! empty( $header_ids ) ) {
		remove_action( 'mjlah_do_header', 'mjlah_the_header_content' );
		add_action( 'mjlah_do_header', 'FLThemeBuilderLayoutRenderer::render_header' );
	}

	// Get the footer ID.
	$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

	// If we have a footer, remove the theme footer and hook in Theme Builder's.
	if ( ! empty( $footer_ids ) ) {
		remove_action( 'mjlah_do_footer', 'mjlah_the_footer_content' );
		add_action( 'mjlah_do_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
	}
}
add_action( 'wp', 'mjlah_header_footer_render' );

add_filter( 'fl_theme_builder_part_hooks', 'mjlah_register_part_hooks' );
function mjlah_register_part_hooks() {
  return array(
    array(
      'label' => 'Header',
      'hooks' => array(
        'mjlah_before_header' => 'Before Header',
        'mjlah_after_header'  => 'After Header',
      )
    ),
    array(
      'label' => 'Content',
      'hooks' => array(
        'mjlah_before_content' => 'Before Content',
        'mjlah_after_content'  => 'After Content',
      )
    ),
    array(
      'label' => 'Footer',
      'hooks' => array(
        'mjlah_before_footer' => 'Before Footer',
        'mjlah_after_footer'  => 'After Footer',
      )
    )
  );
}

function mjlah_customizer( $wp_customize ) {
    // $wp_customize->remove_panel( 'widgets' );
    $wp_customize->remove_section("colors");
    $wp_customize->remove_section("background_image");
    $wp_customize->remove_section("static_front_page");
}
add_action( 'customize_register', 'mjlah_customizer' );