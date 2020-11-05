<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mjlah_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function mjlah_posted_on() {
		$author = '<span class="author"><i class="fa fa-user text-muted"></i> <a class="url fn n" href="%1$s">%2$s</a></span>';		
		$author = sprintf(
			$author,
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);

		$time = '<time class="entry-date published" datetime="%1$s">%2$s</time>';		
		$time = sprintf(
			$time,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
		);
		$date = '<span class="date"><i class="fa fa-clock-o text-muted"></i> <a href="%1$s" rel="bookmark">%2$s</a></span>';		
		$date = sprintf(
			$date,
			esc_url( get_permalink() ),
			apply_filters( 'mjlah_posted_on_time', $time )
		);

		$cat = '';
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'mjlah' ) );
			if ( $categories_list && mjlah_categorized_blog() ) {
				$cat = '<span class="cat"><i class="fa fa-list-alt text-muted"></i> %s</span>';
				/* translators: %s: Categories of current post */
				$cat = sprintf(
					$cat,
					$categories_list
				);
				// printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'mjlah' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		// output 
		if ( is_single()) {
			printf("<div class='metapost'>%s  %s  %s</div>",$author,$date,$cat);
		} else {
			
			$date = '<span class="date"><a href="%1$s" rel="bookmark">%2$s</a></span>';		
			$date = sprintf(
				$date,
				esc_url( get_permalink() ),
				apply_filters( 'mjlah_posted_on_time', $time )
			);

			printf("<div class='metapost text-muted'>%s</div>",$date);
		}
	}
}

if ( ! function_exists( 'mjlah_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function mjlah_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() && is_single() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list();
			if ( $tags_list ) {
				/* translators: %s: Tags of current post */
				printf( '<span class="tags-links">' . esc_html__( '%s', 'mjlah' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		if ( is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'mjlah' ), esc_html__( '1 Comment', 'mjlah' ), esc_html__( '% Comments', 'mjlah' ) );
			echo '</span>';
		}
		if ( is_single() ) {
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'mjlah' ),
					the_title( '<span class="sr-only">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		}

		if ( ! is_single() ) {			
			$more = '<span class="readmore"><a href="%1$s" rel="bookmark" class="btn btn-sm btn-primary">more</a></span>';		
			$more = sprintf(
				$more,
				esc_url( get_permalink() )
			);
			echo $more;
		}

	}
}

if ( ! function_exists( 'mjlah_categorized_blog' ) ) {
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	function mjlah_categorized_blog() {
		$all_the_cool_cats = get_transient( 'mjlah_categories' );
		if ( false === $all_the_cool_cats ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);
			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );
			set_transient( 'mjlah_categories', $all_the_cool_cats );
		}
		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so mjlah_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so mjlah_categorized_blog should return false.
			return false;
		}
	}
}

if ( ! function_exists( 'mjlah_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function mjlah_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="container navigation post-navigation block-customizer">
			<h2 class="sr-only"><?php esc_html_e( 'Post navigation', 'mjlah' ); ?></h2>
			<div class="row nav-links justify-content-between m-0">
				<?php
				if ( get_previous_post_link() ) {
					previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'mjlah' ) );
				}
				if ( get_next_post_link() ) {
					next_post_link( '<span class="nav-next">%link</span>', _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'mjlah' ) );
				}
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}


if ( ! function_exists( 'mjlah_post_author' ) ) {
	/**
	 * Display authro box post when applicable.
	 */
	function mjlah_post_author() {
		?>
		<div id="author-info" class="card rounded-0 p-3 py-md-4 block-customizer">
			<div class="row">
				<div id="author-avatar" class="col-12 col-md-3 m-md-0 mb-3">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), '80', '', '', array( 'class' => array( 'w-100', 'mx-auto' ) ) ); ?>
				</div>
				<div id="author-description" class="col-12 col-md-9">
					<h4>Author: <?php the_author_posts_link(); ?></h4>
					<?php the_author_meta('description'); ?>
				</div>		
			</div><!-- .row -->
		</div><!-- #author-info -->
		<?php
	}
}

add_action( 'edit_category', 'mjlah_category_transient_flusher' );
add_action( 'save_post', 'mjlah_category_transient_flusher' );

if ( ! function_exists( 'mjlah_category_transient_flusher' ) ) {
	/**
	 * Flush out the transients used in mjlah_categorized_blog.
	 */
	function mjlah_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'mjlah_categories' );
	}
}

if ( ! function_exists( 'mjlah_body_attributes' ) ) {
	/**
	 * Displays the attributes for the body element.
	 */
	function mjlah_body_attributes() {
		/**
		 * Filters the body attributes.
		 *
		 * @param array $atts An associative array of attributes.
		 */
		$atts = array_unique( apply_filters( 'mjlah_body_attributes', $atts = array() ) );
		if ( ! is_array( $atts ) || empty( $atts ) ) {
			return;
		}
		$attributes = '';
		foreach ( $atts as $name => $value ) {
			if ( $value ) {
				$attributes .= sanitize_key( $name ) . '="' . esc_attr( $value ) . '" ';
			} else {
				$attributes .= sanitize_key( $name ) . ' ';
			}
		}
		echo trim( $attributes ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

