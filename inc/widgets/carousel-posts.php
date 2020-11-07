<?php
/**
 * mjlah functions and definitions
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Creating the widget 
class mjlah_carousel_posts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'mjlah_carousel_posts_widget', 

            // Widget name will appear in UI
            __('Widget Carousel Posts', 'mjlah'), 

            // Widget description
            array( 'description' => __( 'Carousel Post di widget', 'mjlah' ), ) 
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $idwidget   = uniqid();
        $title      = apply_filters( 'widget_title', $instance['title'] );

        $viewdate   = $instance['viewdate']?$instance['viewdate']:'ya';       
        $items      = $instance['items']?$instance['items']:2;

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        echo '<div class="widget-'.$idwidget.' carousel-post-widget">';

            if ( ! empty( $title ) ):

                if($instance['kategori']) {
                    $title = '<a href="'.get_category_link($instance['kategori']).'">'.$title.'</a>';
                    $title .= '<a href="'.get_category_link($instance['kategori']).'feed" class="feed-cat float-right h5 mt-2" target="_blank" title="Technology RSS Feed"><i class="fa fa-rss"></i></a>';
                }             
                echo $args['before_title'] . $title . $args['after_title'];

            endif;
            // This is where you run the code and display the output
            //The Query args
            $query_args                         = array();
            $query_args['post_type']            = 'post';
            $query_args['posts_per_page']       = $instance['jumlah'];
            $query_args['cat']                  = $instance['kategori'];

            // The Query
            $the_query = new WP_Query( $query_args );
            
            // The Loop
            $i = 1;
            if ( $the_query->have_posts() ) {
            ?>   
                <div id="postcarousel-<?php echo $idwidget ;?>">

                        <div class="carousel-post mx-3" data-items="<?php echo $items; ?>">

                            <?php
                            while ( $the_query->have_posts() ) {
                                $the_query->the_post(); ?>
                                    <div class="carousel-item-post">
                                        <div class="list-post list-post-<?php echo $i ;?>">       
                                            <?php echo mjlah_generated_schema(get_the_ID()); ?>        
                                            <div class="position-relative clearfix">
                                                <div class="thumb-post float-left pr-2">
                                                    <?php echo mjlah_thumbnail( get_the_ID(),array(70,70), array( 'class' => 'w-100 img-fluid','class-link' => '' ) );?>
                                                </div>
                                                <div class="content-post">
                                                    
                                                    <?php if($viewdate == 'ya'): ?>
                                                        <small class="d-block text-muted meta-post mb-1">
                                                            <span class="date-post"><?php echo get_the_date('F j, Y'); ?></span>
                                                        </small>        
                                                    <?php endif; ?>

                                                    <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold h4 d-block"><?php echo get_the_title(); ?></a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                $i++;
                            } ?>  

                        </div>
                </div>
            <?php
            } else {
                // no posts found
            }
            /* Restore original Post Data */
            wp_reset_postdata();

        echo '</div>';
        
        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {
        //widget data
        $title          = isset( $instance[ 'title' ])?$instance[ 'title' ]:'New Post';
        $kategori       = isset( $instance[ 'kategori' ])?$instance[ 'kategori' ]:'';
        $jumlah         = isset( $instance[ 'jumlah' ])?$instance[ 'jumlah' ]:'5';
        $viewdate       = isset( $instance[ 'viewdate' ])?$instance[ 'viewdate' ]:'ya';
        $items          = isset( $instance[ 'items' ])?$instance[ 'items' ]:'2';

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Judul:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'kategori' ); ?>">Kategori:</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'kategori' ); ?>">
            <option value="">Semua Kategori</option>
                <?php
                $categories = get_terms( array(
			        'taxonomy'      => 'category',
					'orderby'       => 'name',
					'parent'        => 0,
                    'hide_empty'    => 0,
                    'exclude'       => 1,
				) );
				foreach($categories as $category): ?>

                    <option value="<?php echo $category->term_id;?>" <?php selected($kategori, $category->term_id); ?>><?php echo $category->name;?> (<?php echo $category->count;?>)</option>

                    <?php
                    $taxonomies = array( 
                        'taxonomy' => 'category'
                    );
                    $args = array(
                         'child_of'      => $category->term_id,
                         'hide_empty'    => 0,
                    ); 
                    $terms = get_terms($taxonomies, $args);
                    ?>
                    <?php foreach($terms as $term): ?>
                        <option value="<?php echo $term->term_id;?>" <?php selected($kategori, $term->term_id); ?>>&nbsp;&nbsp;&nbsp;<?php echo $term->name;?> (<?php echo $term->count;?>)</option>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'jumlah' ); ?>">Jumlah:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'jumlah' ); ?>" name="<?php echo $this->get_field_name( 'jumlah' ); ?>" type="number" value="<?php echo esc_attr( $jumlah ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'viewdate' ); ?>">Tampilkan tanggal:</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'viewdate' ); ?>">
                <option value="tidak"<?php selected($viewdate, "tidak"); ?>>Tidak</option>
                <option value="ya"<?php selected($viewdate, "ya"); ?>>Ya</option>
            </select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'items' ); ?>">Items per Slide:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>" type="number" value="<?php echo esc_attr( $items ); ?>" />
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['kategori']       = ( ! empty( $new_instance['kategori'] ) ) ? strip_tags( $new_instance['kategori'] ) : '';
        $instance['jumlah']         = ( ! empty( $new_instance['jumlah'] ) ) ? strip_tags( $new_instance['jumlah'] ) : '';
        $instance['viewdate']       = ( ! empty( $new_instance['viewdate'] ) ) ? strip_tags( $new_instance['viewdate'] ) : '';
        $instance['items']          = ( ! empty( $new_instance['items'] ) ) ? strip_tags( $new_instance['items'] ) : '';
        return $instance;
    }

// Class mjlah_carousel_posts_widget ends here
} 
     
     
// Register and load the widget
function mjlah_carouselposts_load_widget() {
    register_widget( 'mjlah_carousel_posts_widget' );
}
add_action( 'widgets_init', 'mjlah_carouselposts_load_widget' );