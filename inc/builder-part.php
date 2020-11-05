<?php
/**
 * Theme basic setup
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function mjlah_the_header_content() {
	$logo = get_theme_mod('custom_logo')?wp_get_attachment_image_src(get_theme_mod('custom_logo'),'full')[0]:'';
	$lebarheader 	= get_theme_mod('lebar_container_header');
	$header_full	= $lebarheader=='full'?'block-header':'';
	$header_fix		= $lebarheader=='fixed'?'block-header':'';
    ?>
        <header id="wrapper-header" class="<?php echo $header_full;?>">	

			<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">				

				<div class="container <?php echo $header_fix;?>">

					<div class="row align-items-center">

						<div class="header-secondary col-12 bg-primary text-white py-2 d-flex justify-content-between align-items-center">
							<div class="header-tanggal">
								<?php mjlah_date_today(); ?>
							</div>	
							<div class="header-sosmed">
								<?php mjlah_socialmedia(); ?>
							</div>	
						</div>
						
						<div class="header-logo col-12 py-2 py-md-3">
							<?php if($logo) {
								$title = '<img src="'.$logo.'" alt="'.get_bloginfo( 'name' ).'">';
							} else {
								$title = get_bloginfo( 'name' );
							}
							?>
							<a class="navbar-brand" rel="home" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php echo $title ?></a>
						</div>

						<div class="header-menu col-12">
							<nav class="navbar navbar-expand-md px-0">
									<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'mjlah'); ?>">
										<i class="fa fa-align-right" aria-hidden="true"></i>
									</button>
					
									<!-- The WordPress Menu goes here -->
									<?php wp_nav_menu(
										array(
											'theme_location'  => 'primary',
											'container_class' => 'collapse navbar-collapse',
											'container_id'    => 'navbarNavDropdown',
											'menu_class'      => 'navbar-nav mr-auto',
											'fallback_cb'     => '',
											'menu_id'         => 'main-menu',
											'depth'           => 4,
											'walker'          => new mjlah_WP_Bootstrap_Navwalker(),
										)
									); ?>
							</nav><!-- .site-navigation -->
						</div>
						
					</div>

				</div><!-- .container end -->
        
			</div><!-- #wrapper-navbar end -->
			
		</header>

		<div id="wrapper-main"><!-- #wrapper-main start -->
		
    <?php
}
add_action( 'mjlah_do_header', 'mjlah_the_header_content' );

function mjlah_the_footer_content() {
	// if ( ! function_exists( 'mjlah_the_footer_content' ) ) :
	$lebarfooter 	= get_theme_mod('lebar_container_footer');
	$footer_full	= $lebarfooter=='full'?'block-footer py-4':'';
	$footer_fix		= $lebarfooter=='fixed'?'block-footer py-4':'';
    ?>
	
		</div><!-- #wrapper-main End -->
	
        <div id="wrapper-footer" class="wrapper p-0 <?php echo $footer_full;?>">

				<div class="container <?php echo $footer_fix;?>">

					<?php
					//looping get widget footer
					$widgetfooter = get_theme_mod('reg_widget_footer');
						if($widgetfooter):
						echo '<div class="row mb-3 px-3">';
							for ($x = 1; $x <= $widgetfooter; $x++) {	
								echo '<div class="col-12 col-md">';
								dynamic_sidebar( 'footer-sidebar-'.$x );
								echo '</div>';
							}
						echo '</div>';
						endif;
					?>
		
					<div class="row">
			
						<div class="col-12">
			
							<footer class="site-footer" id="colophon">
			
								<div class="site-info">
			
									<div class="text-center">© <?php echo date("Y"); ?> <?php echo get_bloginfo('name');?>. All Rights Reserved.</div>
			
								</div><!-- .site-info -->
			
							</footer><!-- #colophon -->
			
						</div><!--col end -->
			
					</div><!-- row end -->

				</div><!-- container end -->
        
        </div><!-- wrapper end -->
        
    <?php
    // endif;
}
add_action( 'mjlah_do_footer', 'mjlah_the_footer_content' );


///Before Content
function mjlah_the_before_content() {

	$sidebar_pos = get_theme_mod( 'mjlah_sidebar_position' );
	?>

	<?php if ( 'left' === $sidebar_pos && is_active_sidebar( 'main-sidebar' )  ) : ?>
		<div class="col-md-4 widget-area" id="left-sidebar" role="complementary">
			<?php dynamic_sidebar( 'main-sidebar' ); ?> 
		</div>
	<?php endif; ?>

	<div class="col-md content-area" id="primary">	

	<?php
}
add_action( 'mjlah_before_content', 'mjlah_the_before_content' );


///After Content
function mjlah_the_after_content() {

	$sidebar_pos = get_theme_mod( 'mjlah_sidebar_position' );
	?>

	</div><!-- End #primary -->

	<?php if ( 'right' === $sidebar_pos && is_active_sidebar( 'main-sidebar' )  ) : ?>
		<div class="col-md-4 widget-area" id="right-sidebar" role="complementary">
			<?php dynamic_sidebar( 'main-sidebar' ); ?> 
		</div>
	<?php endif; ?>	

	<?php
}
add_action( 'mjlah_after_content', 'mjlah_the_after_content' );