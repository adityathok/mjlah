<?php
/**
 * mjlah functions and definitions
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Creating the widget 
class mjlah_tags_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'mjlah_tags_widget', 

            // Widget name will appear in UI
            __('Widget Tags', 'mjlah'), 

            // Widget description
            array( 'description' => __( 'Tampilkan Tags berdasarkan jumlah', 'mjlah' ), ) 
        );
    }

    // Creating widget front-end

    public function widget( $args, $instance ) {

    $title  = apply_filters( 'widget_title', $instance['title'] );
    $number = $instance['number'];

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
            if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

            // This is where you run the code and display the output
            $taxonomies = get_terms([
                'taxonomy'      => 'post_tag',
                'hide_empty'    => true,
                'orderby'       => 'count',
                'order'         => 'DESC',
                'number'        => $number,
            ]);
            // print_r($taxonomies);
            if ( !empty($taxonomies) ) :
                echo '<div class="list-content">';
                foreach( $taxonomies as $category ) {
                    echo '<a href="'.get_term_link($category->term_id).'" class="d-block py-1">';
                    echo '<span class="text-muted mr-2">#</span>';
                    echo '<span class="font-weight-bold">'.$category->name.'</span>';
                    echo '</a>';
                }
                echo '</div>';
            endif;

        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {
        //widget data
        $title      = isset( $instance[ 'title' ])?$instance[ 'title' ]:'Tags';
        $number     = isset( $instance[ 'number' ])?$instance[ 'number' ]:5;
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>">Jumlah:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number']     = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
        return $instance;
    }

// Class mjlah_tags_widget ends here
} 
     
     
// Register and load the widget
function mjlah_tags_load_widget() {
    register_widget( 'mjlah_tags_widget' );
}
add_action( 'widgets_init', 'mjlah_tags_load_widget' );