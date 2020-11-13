<?php
/**
 * mjlah functions kirki
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function mjlah_mjlah_configuration() {
    return array( 'url_path'     => get_stylesheet_directory_uri() . '/inc/kirki/' );
}


// Add our config to differentiate from other themes/plugins 
// that may use Kirki at the same time.
Kirki::add_config( 'mjlah_config', array(
	'capability'  => 'edit_theme_options',
	'option_type' => 'theme_mod',
) );

// Add Panel global
Kirki::add_panel('panel_global', [
	'priority'    => 10,
	'title'       => esc_html__('Global', 'mjlah'),
	'description' => esc_html__('', 'mjlah'),
]);

	// Add field Site Identity
	Kirki::add_section('title_tagline', [
		'panel'    => 'panel_global',
		'title'    => __('Site Identity', 'mjlah'),
		'priority' => 10,
	]);

	// Add field to global container
	Kirki::add_section( 'global_container', array(
		'panel'    => 'panel_global',
		'title'    => __( 'Width', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'slider',
			'settings'    => 'width_website',
			'label'       => esc_html__( 'Width Website', 'mjlah' ),
			'section'     => 'global_container',
			'default'     => 1100,
			'transport'   => 'auto',
			'choices'     => [
				'min'  => 600,
				'max'  => 2300,
				'step' => 1,
			],
			'output' => array(
				array(
					'element'  => '.container',
					'property' => 'max-width',
					'units'    => 'px',
				),
			),
		] );		
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'dimensions',
			'settings'    => 'dimensions_main_block_setting',
			'label'       => esc_html__( 'Margin Main Block', 'mjlah' ),
			'description' => esc_html__( 'Atur Jarak Block Utama', 'mjlah' ),
			'section'     => 'global_container',
			'default'     => [
				'padding-top'    => '1em',
				'padding-bottom' => '1em',
				'padding-left'   => '1em',
				'padding-right'  => '1em',
		
				'margin-top'    => '0em',
				'margin-bottom' => '0em',
				// 'margin-left'   => '0em',
				// 'margin-right'  => '0em',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => array('#wrapper-main > .wrapper > #content'),
				],
			],
		] );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'background',
			'settings'    => 'background_main_block_setting',
			'label'       => esc_html__( 'Background Main Block', 'mjlah' ),
			'description' => esc_html__( 'Atur background Block Konten Utama', 'mjlah' ),
			'section'     => 'global_container',
			'default'     => [
				'background-color'      => '#ffffff',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => array('#wrapper-main > .wrapper > #content'),
				],
			],
		] );
		
		
	// Add field to global color
	Kirki::add_section( 'global_color', array(
		'panel'    => 'panel_global',
		'title'    => __( 'Color', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'multicolor',
			'settings'    => 'colortheme_setting',
			'label'       => esc_html__( 'Color Themes', 'mjlah' ),
			'section'     => 'global_color',
			'priority'    => 10,
			'choices'     => [
				'primary' => esc_html__( 'Primary', 'mjlah' ),
			],
			'default'     => [
				'primary' => '#000000',
				'light'   => '#333333',
			],	
			'output'    => [
				[
					'choice'    => 'primary',
					'element'   => ':root',
					'property'  => '--primary',
				],
			],
		] );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'multicolor',
			'settings'    => 'colorlink_setting',
			'label'       => esc_html__( 'Color Link', 'mjlah' ),
			'section'     => 'global_color',
			'priority'    => 10,
			'choices'     => [
				'link'    => esc_html__( 'Color', 'mjlah' ),
				'hover'   => esc_html__( 'Hover', 'mjlah' ),
				'active'  => esc_html__( 'Active', 'mjlah' ),
			],
			'default'     => [
				'link'    => '#1e73be',
				'hover'   => '#333333',
				'active'  => '#1e73be',
			],	
			'output'    => [
				[
					'choice'    => 'link',
					'element'   => 'a',
					'property'  => 'color',
				],
				[
					'choice'    => 'hover',
					'element'   => 'a:hover',
					'property'  => 'color',
				],
				[
					'choice'    => 'active',
					'element'   => 'a:active',
					'property'  => 'color',
				],
			],
		] );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'background',
			'settings'    => 'background_website',
			'label'       => esc_html__( 'Background Website', 'mjlah' ),
			'description' => esc_html__( '', 'mjlah' ),
			'section'     => 'global_color',
			'default'     => [
				'background-color'      => '#F5F5F5',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => 'body',
				],
			],
		] );

	// Add field to global color
	Kirki::add_section( 'global_typography', array(
		'panel'    => 'panel_global',
		'title'    => __( 'Typography', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'typography',
			'settings'    => 'typography_setting',
			'label'       => esc_html__( 'Typography Website', 'mjlah' ),
			'section'     => 'global_typography',
			'default'     => [
				'font-family'    => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
				'variant'        => 'regular',
				'font-size'      => '14px',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#333333',
				'text-transform' => 'none',
				'text-align'     => 'left',
			],
			'priority'    => 10,
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => 'body',
				],
			],
		] );	
	// Add field to global color
	Kirki::add_section( 'global_block', array(
		'panel'    => 'panel_global',
		'title'    => __( 'Block Setting', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'background',
			'settings'    => 'background_block_setting',
			'label'       => esc_html__( 'Background Block', 'mjlah' ),
			'description' => esc_html__( 'Atur background (widget, heading, article, dll)', 'mjlah' ),
			'section'     => 'global_block',
			'default'     => [
				'background-color'      => 'rgba(255,255,255,0)',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => array('.block-customizer'),
				],
			],
		] );
		
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'dimensions',
			'settings'    => 'dimensions_block_setting',
			'label'       => esc_html__( 'Margin Block', 'mjlah' ),
			'description' => esc_html__( 'Atur Jarak Block (widget, heading, article, dll)', 'mjlah' ),
			'section'     => 'global_block',
			'default'     => [
				'padding-top'    => '0em',
				'padding-bottom' => '0em',
				'padding-left'   => '0em',
				'padding-right'  => '0em',
		
				'margin-top'    => '0em',
				'margin-bottom' => '2em',
				'margin-left'   => '0em',
				'margin-right'  => '0em',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => array('.block-customizer'),
				],
			],
		] );
	

// Add Panel header
Kirki::add_panel('panel_header', [
	'priority'    => 10,
	'title'       => esc_html__('Header', 'mjlah'),
	'description' => esc_html__('', 'mjlah'),
]);

	// Add field to header width
	Kirki::add_section( 'header_width', array(
		'panel'    => 'panel_header',
		'title'    => __( 'Width', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'select',
			'settings'    => 'lebar_container_header',
			'label'       => esc_html__( 'Width Container Header', 'mjlah' ),
			'section'     => 'header_width',
			'default'     => 'fixed',
			'description' => esc_html__( 'Container header', 'mjlah' ),
			'priority'    => 10,
			'multiple'    => 1,
			'choices'     => [
				'fixed' => esc_html__( 'Fixed', 'mjlah' ),
				'full' 	=> esc_html__( 'Full', 'mjlah' ),
			],
		] ); 

	// Add field to header width
	Kirki::add_section( 'header_color', array(
		'panel'    => 'panel_header',
		'title'    => __( 'Color', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'background',
			'settings'    => 'background_block_header',
			'label'       => esc_html__( 'Background Block header', 'mjlah' ),
			'description' => esc_html__( 'Setting background color header', 'mjlah' ),
			'section'     => 'header_color',
			'default'     => [
				'background-color'      => '#ffffff',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => array('.block-header'),
				],
			],
		] );
		
	// Add field to header menu
	Kirki::add_section( 'header_menu', array(
		'panel'    => 'panel_header',
		'title'    => __( 'Menu', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'multicolor',
			'settings'    => 'link_menu_header_setting',
			'label'       => esc_html__( 'Color Link Menu', 'mjlah' ),
			'section'     => 'header_menu',
			'priority'    => 10,
			'choices'     => [
				'link'    => esc_html__( 'Color', 'mjlah' ),
				'hover'   => esc_html__( 'Hover', 'mjlah' ),
				'active'  => esc_html__( 'Active', 'mjlah' ),
			],
			'default'     => [
				'link'    => '#ffffff',
				'hover'   => '#f00000',
				'active'  => '#ffffff',
			],	
			'output'    => [
				[
					'choice'    => 'link',
					'element'   => '.header-menu a,.header-menu .fa',
					'property'  => 'color',
				],
				[
					'choice'    => 'hover',
					'element'   => '.header-menu a:hover,.header-menu .nav-link:hover .fa',
					'property'  => 'color',
				],
				[
					'choice'    => 'active',
					'element'   => '.header-menu a:active,.header-menu .nav-link:active .fa',
					'property'  => 'color',
				],
			],
			'partial_refresh'    => [
				'partial_link_menu_header_setting' => [
					'selector'        => '.header-menu',
					'render_callback' => '__return_false'
				]
			],
		] );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'background',
			'settings'    => 'background_menu_header',
			'label'       => esc_html__( 'Background Menu', 'mjlah' ),
			'description' => esc_html__( 'Setting background color Menu header', 'mjlah' ),
			'section'     => 'header_menu',
			'default'     => [
				'background-color'      => '#333333',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => array(
						'.header-menu',
						'.header-menu #navbarNavDropdown',
						'.header-menu .dropdown-menu',
						'.dropdown-item:focus',
						'.dropdown-item:hover'
					),
				],
			],
		] );

	// Add field to header color
	Kirki::add_section( 'header_typography', array(
		'panel'    => 'panel_header',
		'title'    => __( 'Typography', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'typography',
			'settings'    => 'menu_setting',
			'label'       => esc_html__( 'Menu Typography', 'mjlah' ),
			'section'     => 'header_typography',
			'default'     => [
				'font-family'    => '',
				'variant'        => '',
				'font-size'      => '16px',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#ffffff',
				'text-transform' => 'uppercase',
				'text-align'     => 'left',
			],
			'priority'    => 10,
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => '#main-menu',
				],
			],
		] );

// Add Panel breadcrumb
Kirki::add_panel('panel_breadcrumb', [
	'priority'    => 10,
	'title'       => esc_html__('Breadcrumb', 'mjlah'),
	'description' => esc_html__('', 'mjlah'),
]);
    //add field to footer widget
	Kirki::add_section( 'breadcrumb_visibility', array(
		'panel'    => 'panel_breadcrumb',
		'title'    => __( 'Visibility', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'multicheck',
			'settings'    => 'breadcrumb_disable',
			'label'       => esc_html__( 'Visibility Breadcrumb', 'mjlah' ),
			'section'     => 'breadcrumb_visibility',
			'default'     => array('disable-on-home', 'disable-on-404'),
			'description' => esc_html__( 'Hide breadcrumb', 'mjlah' ),
			'priority'    => 10,
			'choices'     => [
        		'disable-on-all'        => esc_html__('Disable on All', 'justg'),
        		'disable-on-home'       => esc_html__('Disable on Home Page', 'justg'),
        		'disable-on-page'       => esc_html__('Disable on Page', 'justg'),
        		'disable-on-post'       => esc_html__('Disable on Post', 'justg'),
        		'disable-on-archive'    => esc_html__('Disable on Archive', 'justg'),
        		'disable-on-404'        => esc_html__('Disable on 404', 'justg'),
			],
		] ); 


// Add Panel footer
Kirki::add_panel('panel_footer', [
	'priority'    => 10,
	'title'       => esc_html__('Footer', 'mjlah'),
	'description' => esc_html__('', 'mjlah'),
]);
	// Add field to header width
	Kirki::add_section( 'footer_color', array(
		'panel'    => 'panel_footer',
		'title'    => __( 'Color', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'background',
			'settings'    => 'background_block_footer',
			'label'       => esc_html__( 'Background Block Footer', 'mjlah' ),
			'description' => esc_html__( 'Set background Footer', 'mjlah' ),
			'section'     => 'footer_color',
			'default'     => [
				'background-color'      => '#333333',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => array('.block-footer'),
				],
			],
			'partial_refresh'    => [
				'partial_background_block_footer' => [
					'selector'        => '.block-footer',
					'render_callback' => '__return_false'
				]
			],
		] );		
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'multicolor',
			'settings'    => 'link_footer',
			'label'       => esc_html__( 'Color Link footer', 'mjlah' ),
			'section'     => 'footer_color',
			'priority'    => 10,
			'choices'     => [
				'link'    => esc_html__( 'Color', 'mjlah' ),
				'hover'   => esc_html__( 'Hover', 'mjlah' ),
				'active'  => esc_html__( 'Active', 'mjlah' ),
			],
			'default'     => [
				'link'    => '#ffffff',
				'hover'   => '#f5f5f5',
				'active'  => '#ffffff',
			],
			'output'    => [
				[
					'choice'    => 'link',
					'element'   => '#wrapper-footer a',
					'property'  => 'color',
				],
				[
					'choice'    => 'hover',
					'element'   => '#wrapper-footer a:hover',
					'property'  => 'color',
				],
				[
					'choice'    => 'active',
					'element'   => '#wrapper-footer a:active',
					'property'  => 'color',
				],
			],
		] );

	//add field to footer widget
	Kirki::add_section( 'footer_widget', array(
		'panel'    => 'panel_footer',
		'title'    => __( 'Widget', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'select',
			'settings'    => 'reg_widget_footer',
			'label'       => esc_html__( 'Widget Footer', 'mjlah' ),
			'section'     => 'footer_widget',
			'default'     => '3',
			'description' => esc_html__( 'Number of footer widgets', 'mjlah' ),
			'priority'    => 10,
			'multiple'    => 1,
			'choices'     => [
				'1' => esc_html__( '1', 'mjlah' ),
				'2' => esc_html__( '2', 'mjlah' ),
				'3' => esc_html__( '3', 'mjlah' ),
				'4' => esc_html__( '4', 'mjlah' ),
				'5' => esc_html__( '5', 'mjlah' ),
			],
		] ); 

	//add field to footer width
	Kirki::add_section( 'footer_width', array(
		'panel'    => 'panel_footer',
		'title'    => __( 'Width', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'select',
			'settings'    => 'lebar_container_footer',
			'label'       => esc_html__( 'Width Container', 'mjlah' ),
			'section'     => 'footer_width',
			'default'     => 'fixed',
			'description' => esc_html__( 'Width Container Footer', 'mjlah' ),
			'priority'    => 10,
			'multiple'    => 1,
			'choices'     => [
				'fixed' => esc_html__( 'Fixed', 'mjlah' ),
				'full' 	=> esc_html__( 'Full', 'mjlah' ),
			],
		] ); 

	//add field to footer typography
	Kirki::add_section( 'footer_typography', array(
		'panel'    => 'panel_footer',
		'title'    => __( 'Typography', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'typography',
			'settings'    => 'typography_footer',
			'label'       => esc_html__( 'Typography', 'mjlah' ),
			'section'     => 'footer_typography',
			'default'     => [
				'font-family'    => '',
				'variant'        => '',
				'font-size'      => '',
				'line-height'    => '',
				'letter-spacing' => '',
				'color'          => '#ffffff',
				'text-transform' => 'none',
				'text-align'     => 'left',
			],
			'priority'    => 10,
			'transport'   => 'auto',
			'output'      => [
				[
					'element' => '#wrapper-footer',
				],
			],
		] );

	//add field to footer scrolltop
	Kirki::add_section( 'footer_scrolltop', array(
		'panel'    => 'panel_footer',
		'title'    => __( 'Scroll to top', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'select',
			'settings'    => 'scrolltotop_footer',
			'label'       => esc_html__( 'Scroll up button', 'mjlah' ),
			'section'     => 'footer_scrolltop',
			'default'     => 'on',
			'description' => esc_html__( 'Activate the Scroll up button', 'mjlah' ),
			'priority'    => 10,
			'multiple'    => 1,
			'choices'     => [
				'on' 		=> esc_html__( 'On', 'mjlah' ),
				'off' 		=> esc_html__( 'Off', 'mjlah' ),
			],
			'partial_refresh'    => [
				'partial_scrolltotop_footer' => [
					'selector'        => '.scrolltoTop',
					'render_callback' => '__return_false'
				]
			],
		] );

// Add Panel Social Media
Kirki::add_panel('panel_sosmed', [
	'priority'    => 10,
	'title'       => esc_html__('Social Media', 'mjlah'),
	'description' => esc_html__('', 'mjlah'),
]);
	// Add field to sosmed link
	Kirki::add_section( 'sosmed_link', array(
		'panel'    => 'panel_sosmed',
		'title'    => __( 'Link', 'mjlah' ),
		'priority' => 10,	
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'     		=> 'link',
			'settings' 		=> 'facebook_sosmed_link',
			'label'    		=> __( 'Facebook', 'mjlah' ),
			'section'  		=> 'sosmed_link',
			'default'  		=> 'https://facebook.com',
			'description' 	=> esc_html__( 'Link Facebook, use https://', 'mjlah' ),
			'priority' 		=> 10,		
			'partial_refresh'    => [
				'partial_sosmed_link' => [
					'selector'        => '.social-media-button',
					'render_callback' => '__return_false'
				]
			],
		] ); 
		Kirki::add_field( 'mjlah_config', [
			'type'     		=> 'link',
			'settings' 		=> 'twitter_sosmed_link',
			'label'    		=> __( 'Twitter', 'mjlah' ),
			'section'  		=> 'sosmed_link',
			'default'  		=> 'https://twitter.com',
			'description' 	=> esc_html__( 'Link Twitter, use https://', 'mjlah' ),
			'priority' 		=> 10,
		] ); 
		Kirki::add_field( 'mjlah_config', [
			'type'     		=> 'link',
			'settings' 		=> 'instagram_sosmed_link',
			'label'    		=> __( 'Instagram', 'mjlah' ),
			'section'  		=> 'sosmed_link',
			'default'  		=> 'https://instagram.com',
			'description' 	=> esc_html__( 'Link Instagram, use https://', 'mjlah' ),
			'priority' 		=> 10,
		] ); 
		Kirki::add_field( 'mjlah_config', [
			'type'     		=> 'link',
			'settings' 		=> 'youtube_sosmed_link',
			'label'    		=> __( 'Youtube', 'mjlah' ),
			'section'  		=> 'sosmed_link',
			'default'  		=> 'https://youtube.com',
			'description' 	=> esc_html__( 'Link Youtube, use https://', 'mjlah' ),
			'priority' 		=> 10,
		] );
		Kirki::add_field( 'mjlah_config', [
			'type'     		=> 'checkbox',
			'settings' 		=> 'rss_sosmed_link',
			'label'    		=> __( 'RSS', 'mjlah' ),
			'section'  		=> 'sosmed_link',
			'default'  		=> true,
			'description' 	=> esc_html__( 'Activate to display', 'mjlah' ),
			'priority' 		=> 10,
		] );  

	// Add field to header width
	Kirki::add_section( 'sosmed_whatsapp', array(
		'panel'    => 'panel_sosmed',
		'title'    => __( 'Whatsapp', 'mjlah' ),
		'priority' => 10,
	) );
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'select',
			'settings'    => 'whatsapp_footer',
			'label'       => esc_html__( 'Whatsapp button', 'mjlah' ),
			'section'     => 'sosmed_whatsapp',
			'default'     => 'off',
			'description' => esc_html__( 'Enable the floating Whatsapp button in the footer', 'mjlah' ),
			'priority'    => 10,
			'multiple'    => 1,
			'choices'     => [
				'on' 		=> esc_html__( 'On', 'mjlah' ),
				'off' 		=> esc_html__( 'Off', 'mjlah' ),
			],		
			'partial_refresh'    => [
				'partial_whatsapp_footer' => [
					'selector'        => '.wa-floating',
					'render_callback' => '__return_false'
				]
			],
		] );
		Kirki::add_field( 'mjlah_config', [
			'type'     		=> 'text',
			'settings' 		=> 'whatsapp_sosmed_number',
			'label'    		=> __( 'Whatsapp Number', 'mjlah' ),
			'section'  		=> 'sosmed_whatsapp',
			'default'  		=> '',
			'description' 	=> esc_html__( 'Number Whatsapp, use +62', 'mjlah' ),
			'priority' 		=> 10,
		] ); 
		Kirki::add_field( 'mjlah_config', [
			'type'     		=> 'textarea',
			'settings' 		=> 'whatsapp_sosmed_message',
			'label'    		=> __( 'Whatsapp message', 'mjlah' ),
			'section'  		=> 'sosmed_whatsapp',
			'default'  		=> 'Hai...',
			'description' 	=> esc_html__( 'Whatsapp message', 'mjlah' ),
			'priority' 		=> 10,
		] ); 
		Kirki::add_field( 'mjlah_config', [
			'type'        => 'select',
			'settings'    => 'whatsapp_footer_position',
			'label'       => esc_html__( 'Whatsapp button position', 'mjlah' ),
			'section'     => 'sosmed_whatsapp',
			'default'     => 'right',
			'description' => esc_html__( 'Position the floating Whatsapp button in the footer', 'mjlah' ),
			'priority'    => 10,
			'multiple'    => 1,
			'choices'     => [
				'right' 	=> esc_html__( 'right', 'mjlah' ),
				'left' 		=> esc_html__( 'left', 'mjlah' ),
			],
		] );

		
// Add Sidebar Setting
Kirki::add_section( 'sidebar_section', array(
	'title'    => __( 'Sidebar', 'mjlah' ),
	'priority' => 10,
) );
	Kirki::add_field( 'mjlah_config', [
		'type'        => 'select',
		'settings'    => 'mjlah_sidebar_position',
		'label'       => esc_html__( 'Default Position Sidebar', 'mjlah' ),
		'section'     => 'sidebar_section',
		'default'     => 'right',
		'placeholder' => esc_html__( 'Right Sidebar', 'mjlah' ),
		'priority'    => 10,
		'multiple'    => 1,
		'choices'     => [
			'no' 		=> esc_html__( 'No Sidebar', 'mjlah' ),
			'left'  	=> esc_html__( 'Left Sidebar', 'mjlah' ),
			'right' 	=> esc_html__( 'Right Sidebar', 'mjlah' ),
		],
	] );
	Kirki::add_field('mjlah_config', [
		'type'        => 'slider',
		'settings'    => 'mjlah_sidebar_width',
		'label'       => esc_html__('Sidebar Width', 'mjlah'),
		'section'     => 'sidebar_section',
		'default'     => 33,
		'transport'   => 'auto',
		'choices'     => [
			'min'  => 20,
			'max'  => 50,
			'step' => 1,
		],
		'output' => [
			[
				'element'  => '.widget-side',
				'property' => 'max-width',
				'units'    => '%',
				'media_query' => '@media (min-width: 768px)',
			],
		],
	]);
	Kirki::add_field('mjlah_config', [
		'type'        => 'background',
		'settings'    => 'background_widget_setting',
		'label'       => esc_html__('Background Widget', 'mjlah'),
		'description' => esc_html__('Atur background widget', 'mjlah'),
		'section'     => 'sidebar_section',
		'default'     => [
			'background-color'      => 'rgba(255,255,255,0)',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		],
		'transport'   => 'auto',
		'output'      => [
			[
				'element' => array('.widget-area .block-widget'),
			],
		],
	]);
	Kirki::add_field('mjlah_config', [
		'type'        => 'dimensions',
		'settings'    => 'dimensions_widget_setting',
		'label'       => esc_html__('Margin Widget', 'mjlah'),
		'description' => esc_html__('Atur Jarak Widget', 'mjlah'),
		'section'     => 'sidebar_section',
		'default'     => [
			'padding-top'    => '0em',
			'padding-bottom' => '0em',
			'padding-left'   => '0em',
			'padding-right'  => '0em',
	
			'margin-top'    => '0em',
			'margin-bottom' => '2em',
			'margin-left'   => '0em',
			'margin-right'  => '0em',
		],
		'transport'   => 'auto',
		'output'      => [
			[
				'element' => array('.widget-area .block-widget'),
			],
		],
	]);