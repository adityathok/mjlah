<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class('block-customizer'); ?> id="post-<?php the_ID(); ?>">

	<div class="row">

		<div class="col-md-3 col-4 entry-thumbnail">
			<?php echo mjlah_thumbnail( get_the_ID(),'thumbnail' , array( 'class' => 'w-100 mx-auto' ) );?>   
		</div>

		<div class="col-md-9 col-7 pl-0 pl-md-2 entry-content">

			<header class="entry-header">

				<?php
				the_title(
					sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
					'</a></h3>'
				);
				?>

				<?php if ( 'post' === get_post_type() ) : ?>

					<div class="entry-meta">
						<?php mjlah_posted_on(); ?>
					</div><!-- .entry-meta -->

				<?php endif; ?>

			</header><!-- .entry-header -->

			<div class="entry-excerpt my-2"> 
				<?php echo mjlah_getexcerpt(80,get_the_ID()); ?>
			</div>

			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'mjlah' ),
					'after'  => '</div>',
				)
			);
			?>

			<footer class="entry-footer">
		
				<?php mjlah_entry_footer(); ?>
		
			</footer><!-- .entry-footer -->

		</div><!-- .entry-content -->

	</div><!-- .row-->

</article><!-- #post-## -->
