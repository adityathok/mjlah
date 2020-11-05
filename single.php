<?php
/**
 * The template for displaying all single posts
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'mjlah_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<?php mjlah_breadcrumbs();?>

		<div class="row">

			<!-- Do the Before content -->
			<?php do_action( 'mjlah_before_content'); ?>

			<main class="site-main" id="main">

				<?php
				while ( have_posts() ) {
					the_post();

					get_template_part( 'loop-templates/content', 'single' );

					//get info author
					mjlah_post_author();

					//navigation post,
					mjlah_post_nav();
					
					//Related Post
					echo '<div class="my-4">';
						mjlah_related_post();
					echo '</div>';

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				}

				?>

			</main><!-- #main -->

			<!-- Do the After content -->
			<?php do_action( 'mjlah_after_content'); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
