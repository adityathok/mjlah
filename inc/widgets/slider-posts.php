<?php
/**
 * mjlah functions and definitions
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Creating the widget 
class mjlah_slider_posts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'mjlah_slider_posts_widget', 

            // Widget name will appear in UI
            __('Widget Slider Posts', 'mjlah'), 

            // Widget description
            array( 'description' => __( 'Slider Post di widget', 'mjlah' ), ) 
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $idwidget   = uniqid();
        $thetitle   = isset($instance['title'])?$instance['title']:'';
        $title      = apply_filters( 'widget_title', $thetitle );

        $navigasi   = (isset($instance['navigasi']) && !empty($instance['navigasi']))?$instance['navigasi']:'ya';       
        $dots       = (isset($instance['dots']) && !empty($instance['dots']))?$instance['dots']:'ya';       
        $dotstyle   = (isset($instance['dotstyle']) && !empty($instance['dotstyle']))?$instance['dotstyle']:'ya';
        $lebar_img  = (isset($instance['lebar_img']) && !empty($instance['lebar_img']))?$instance['lebar_img']:630;
        $tinggi_img = (isset($instance['tinggi_img']) && !empty($instance['tinggi_img']))?$instance['tinggi_img']:300;    

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        echo '<div class="widget-'.$idwidget.' slider-post-widget">';

            if ( ! empty( $title ) ):

                if(isset($instance['kategori']) && !empty($instance['kategori'])) {
                    $title = '<a href="'.get_category_link($instance['kategori']).'">'.$title.'</a>';
                    $title .= '<a href="'.get_category_link($instance['kategori']).'feed" class="feed-cat float-right h5 mt-2" target="_blank" title="Technology RSS Feed"><i class="fa fa-rss"></i></a>';
                }             
                echo $args['before_title'] . $title . $args['after_title'];

            endif;
            // This is where you run the code and display the output
            //The Query args
            $query_args                         = array();
            $query_args['post_type']            = 'post';
            $query_args['posts_per_page']       = (isset($instance['jumlah']) && !empty($instance['jumlah']))?$instance['jumlah']:'';
            $query_args['cat']                  = (isset($instance['kategori']) && !empty($instance['kategori']))?$instance['kategori']:'';

            // The Query
            $the_query = new WP_Query( $query_args );
            
            // The Loop
            $i = 1;
            if ( $the_query->have_posts() ) {
            ?>   
                <div id="postslider-<?php echo $idwidget ;?>" class="carousel slide carousel-fade" data-ride="carousel">

                        <div class="carousel-inner">

                            <?php
                            while ( $the_query->have_posts() ) {
                                $the_query->the_post(); ?>
                                    <div class="carousel-item <?php echo $i==1?'active':'';?>">

                                        <div class="list-post list-post-<?php echo $i ;?>">       
                                            <?php echo mjlah_generated_schema(get_the_ID()); ?>        
                                            <div class="position-relative">
                                                <div class="thumb-post">
                                                    <?php echo mjlah_thumbnail( get_the_ID(),array($lebar_img,$tinggi_img), array( 'class' => 'w-100 img-fluid') );?>
                                                </div>
                                                <div class="carousel-caption content-post">                                            
                                                    <a href="<?php echo get_the_permalink(); ?>" class="title-post d-block"><?php echo get_the_title(); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                $i++;
                            } ?>  

                        </div>

                        <?php if($navigasi=='ya'): ?>
                            <a class="carousel-control-prev" href="#postslider-<?php echo $idwidget ;?>" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#postslider-<?php echo $idwidget ;?>" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        <?php endif; ?>

                        <?php if($dots=='ya'): ?>
                            <ol class="carousel-indicators">
                                <?php
                                $in = 0;
                                while ( $the_query->have_posts() ) {
                                    $the_query->the_post(); ?>
                                        <li data-target="#postslider-<?php echo $idwidget ;?>" class="<?php echo $in==0?'active':'';?>" data-slide-to="<?php echo $in ;?>"></li>
                                    <?php
                                    $in++;
                                } ?>
                            </ol>
                        <?php endif; ?>

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
        $title          = isset( $instance[ 'title' ])?$instance[ 'title' ]:'';
        $kategori       = isset( $instance[ 'kategori' ])?$instance[ 'kategori' ]:'';
        $jumlah         = isset( $instance[ 'jumlah' ])?$instance[ 'jumlah' ]:'5';
        $lebar_img      = isset( $instance[ 'lebar_img' ])?$instance[ 'lebar_img' ]:'620';
        $tinggi_img     = isset( $instance[ 'tinggi_img' ])?$instance[ 'tinggi_img' ]:'300';
        $navigasi       = isset( $instance[ 'navigasi' ])?$instance[ 'navigasi' ]:'ya';
        $dots           = isset( $instance[ 'dots' ])?$instance[ 'dots' ]:'ya';
        $dotstyle       = isset( $instance[ 'dotstyle' ])?$instance[ 'dotstyle' ]:'';

        // Widget admin form
        ?>
        <!-- <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Judul:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p> -->
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
            <label for="<?php echo $this->get_field_id( 'lebar_img' ); ?>">Lebar:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'lebar_img' ); ?>" name="<?php echo $this->get_field_name( 'lebar_img' ); ?>" type="number" value="<?php echo esc_attr( $lebar_img ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'tinggi_img' ); ?>">Tinggi:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'tinggi_img' ); ?>" name="<?php echo $this->get_field_name( 'tinggi_img' ); ?>" type="number" value="<?php echo esc_attr( $tinggi_img ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'navigasi' ); ?>">Navigasi :</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'navigasi' ); ?>">
                <option value="tidak"<?php selected($navigasi, "tidak"); ?>>Tidak</option>
                <option value="ya"<?php selected($navigasi, "ya"); ?>>Ya</option>
            </select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'dots' ); ?>">Dots :</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'dots' ); ?>">
                <option value="tidak"<?php selected($dots, "tidak"); ?>>Tidak</option>
                <option value="ya"<?php selected($dots, "ya"); ?>>Ya</option>
            </select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'dotstyle' ); ?>">Dots Style:</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'dotstyle' ); ?>">
                <option value="style1"<?php selected($dotstyle, "style1"); ?>>Style 1</option>
                <option value="style2"<?php selected($dotstyle, "style2"); ?>>Style 2</option>
                <option value="style3"<?php selected($dotstyle, "style3"); ?>>Style 3</option>
            </select>
		</p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['kategori']       = ( ! empty( $new_instance['kategori'] ) ) ? strip_tags( $new_instance['kategori'] ) : '';
        $instance['jumlah']         = ( ! empty( $new_instance['jumlah'] ) ) ? strip_tags( $new_instance['jumlah'] ) : '';
        $instance['lebar_img']      = ( ! empty( $new_instance['lebar_img'] ) ) ? strip_tags( $new_instance['lebar_img'] ) : '';
        $instance['tinggi_img']     = ( ! empty( $new_instance['tinggi_img'] ) ) ? strip_tags( $new_instance['tinggi_img'] ) : '';
        $instance['navigasi']       = ( ! empty( $new_instance['navigasi'] ) ) ? strip_tags( $new_instance['navigasi'] ) : '';
        $instance['dots']           = ( ! empty( $new_instance['dots'] ) ) ? strip_tags( $new_instance['dots'] ) : '';
        $instance['dotstyle']       = ( ! empty( $new_instance['dotstyle'] ) ) ? strip_tags( $new_instance['dotstyle'] ) : '';
        return $instance;
    }

// Class mjlah_slider_posts_widget ends here
} 
     
     
// Register and load the widget
function mjlah_sliderposts_load_widget() {
    register_widget( 'mjlah_slider_posts_widget' );
}
add_action( 'widgets_init', 'mjlah_sliderposts_load_widget' );