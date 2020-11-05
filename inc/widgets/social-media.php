<?php
/**
 * mjlah functions and definitions
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Creating the widget 
class mjlah_sosmed_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'mjlah_sosmed_widget', 

            // Widget name will appear in UI
            __('Widget Social Media', 'mjlah'), 

            // Widget description
            array( 'description' => __( 'Tampilkan Link Social Media dari Pengaturan Tema', 'mjlah' ), ) 
        );
    }

    // Creating widget front-end

    public function widget( $args, $instance ) {

    $title  = apply_filters( 'widget_title', $instance['title'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
            if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

            // This is where you run the code and display the output
            mjlah_socialmedia();

        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {
        //widget data
        $title      = isset( $instance[ 'title' ])?$instance[ 'title' ]:'Follow me';
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }

// Class mjlah_sosmed_widget ends here
} 
     
     
// Register and load the widget
function mjlah_sosmed_load_widget() {
    register_widget( 'mjlah_sosmed_widget' );
}
add_action( 'widgets_init', 'mjlah_sosmed_load_widget' );