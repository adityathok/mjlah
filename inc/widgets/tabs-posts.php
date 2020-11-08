<?php
/**
 * mjlah functions and definitions
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Creating the widget 
class tabs_posts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'tabs_posts_widget', 

            // Widget name will appear in UI
            __('Widget Tab Posts', 'mjlah'), 

            // Widget description
            array( 'description' => __( 'Tampilkan Tab Post Populer, comments, dan tags di widget', 'mjlah' ), ) 
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $idwidget   = uniqid();
        $thetitle   = isset($instance['title'])?$instance['title']:'';
        $title      = apply_filters( 'widget_title', $thetitle );

        $viewpopular        = isset( $instance[ 'popular' ])?$instance[ 'popular' ]:'';
        $viewcomments       = isset( $instance[ 'comments' ])?$instance[ 'comments' ]:'';
        $viewtags           = isset( $instance[ 'tags' ])?$instance[ 'tags' ]:'';
        $jumlah_popular     = isset( $instance[ 'jumlah_popular' ])?$instance[ 'jumlah_popular' ]:'';
        $jumlah_comments    = isset( $instance[ 'jumlah_comments' ])?$instance[ 'jumlah_comments' ]:'';
        $jumlah_tags        = isset( $instance[ 'jumlah_tags' ])?$instance[ 'jumlah_tags' ]:'';

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        echo '<div class="widget-'.$idwidget.'">';

            if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

            // This is where you run the code and display the output
            ?>

                <ul class="nav nav-tabs nav-fill mb-3 p-0" role="tablist">
                    <?php if($viewpopular==1): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="#popular<?php echo $idwidget;?>" role="tab" data-toggle="tab">POPULAR</a>
                        </li>
                    <?php endif; ?>
                    <?php if($viewcomments==1): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $viewpopular!=1?'active':''; ?>" href="#comments<?php echo $idwidget;?>" role="tab" data-toggle="tab">COMMENTS</a>
                        </li>
                    <?php endif; ?>
                    <?php if($viewtags==1): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $viewpopular!=1&&$viewcomments!=1?'active':''; ?>" href="#tags<?php echo $idwidget;?>" role="tab" data-toggle="tab">TAGS</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <?php if($viewpopular==1): ?>
                        <div role="tabpanel" class="tab-pane fade in active show" id="popular<?php echo $idwidget;?>">
                            <?php
                            //The Query args
                            $query_args                         = array();
                            $query_args['post_type']            = 'post';
                            $query_args['posts_per_page']       = $jumlah_popular;
                            $query_args['orderby']              = 'meta_value';
                            $query_args['meta_key']             = 'post_views_count';
                            // The Query
                            $the_query = new WP_Query( $query_args );
                            // The Loop                            
                            if ( $the_query->have_posts() ) {                                
                                echo '<div class="list-posts">';
                                    while ( $the_query->have_posts() ) {
                                        $the_query->the_post();
                                        ?>
                                        <div class="list-post">
                                            <div class="d-flex border-bottom pb-2 mb-2">
                                                <div class="thumb-post">
                                                    <?php echo mjlah_thumbnail( get_the_ID(),array(70,70), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block mr-2' ) );?>                            
                                                </div>
                                                <div class="content-post">
                                                    <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold d-block"><?php echo get_the_title(); ?></a>
                                                    <small class="d-block text-muted meta-post">
                                                        <span class="date-post"><?php echo get_the_date('F j, Y'); ?></span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                echo '</div>';
                            } else {
                                // no posts found
                            }
                            /* Restore original Post Data */
                            wp_reset_postdata();
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if($viewcomments==1): ?>
                        <div role="tabpanel" class="tab-pane fade <?php echo $viewpopular!=1?'in active show':''; ?>" id="comments<?php echo $idwidget;?>">
                            <?php
                            $argsc = array(
                                'number'  => $jumlah_comments,
                            );
                            $comments = get_comments($argsc); 
                            if($comments): 
                                echo '<div class="list-comments">';                           
                                foreach ( $comments as $comment ) :
                                    echo '<div class="d-flex border-bottom pb-2 mb-2">'; 
                                        echo '<div class="thumb-comment mr-2" style="max-width: 50px;">'.get_avatar( $comment->comment_author_email, 70 ).'</div>';
                                        echo '<div class="content-comment">';
                                            $content = $comment->comment_content;
                                            $content = strip_tags($content);
                                            $content = substr($content, 0, 40);
                                            $content = substr($content, 0, strripos($content, " "));
                                            echo '<a href="'.get_comment_link($comment->comment_ID).'" class="d-block mb-1">'.$content.'</a>';
                                            echo '<small class="d-block text-muted"><i class="fa fa-user"></i> '.$comment->comment_author.'</small>';
                                        echo '</div>';
                                    echo '</div>';
                                endforeach;
                                echo '</div>';
                            endif;
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if($viewtags==1): ?>
                        <div role="tabpanel" class="tab-pane fade <?php echo $viewpopular!=1&&$viewcomments!=1?'in active show':''; ?>" id="tags<?php echo $idwidget;?>">
                        <?php
                        $taxonomies = get_terms([
                            'taxonomy'      => 'post_tag',
                            'hide_empty'    => true,
                            'orderby'       => 'count',
                            'order'         => 'DESC',
                            'number'        => $jumlah_tags,
                        ]);
                        if ( !empty($taxonomies) ) :
                            echo '<div class="list-tags">';
                            foreach( $taxonomies as $category ) {
                                echo '<a href="'.get_term_link($category->term_id).'" class="btn btn-primary btn-sm rounded-0 mr-1 mb-2">';
                                echo $category->name;
                                echo '</a>';
                            }
                            echo '</div>';
                        endif;
                        ?>
                        </div>
                    <?php endif; ?>
                </div>


            <?php

        echo '</div>';

        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {
        //widget data
        $title              = isset( $instance[ 'title' ])?$instance[ 'title' ]:'';
        $popular            = isset( $instance[ 'popular' ])?$instance[ 'popular' ]:1;
        $comments           = isset( $instance[ 'comments' ])?$instance[ 'comments' ]:1;
        $tags               = isset( $instance[ 'tags' ])?$instance[ 'tags' ]:1;
        $jumlah_popular     = isset( $instance[ 'jumlah_popular' ])?$instance[ 'jumlah_popular' ]:'3';
        $jumlah_comments    = isset( $instance[ 'jumlah_comments' ])?$instance[ 'jumlah_comments' ]:'3';
        $jumlah_tags        = isset( $instance[ 'jumlah_tags' ])?$instance[ 'jumlah_tags' ]:'10';

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Judul:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <h4>Pilihan Tab</h4>
        <p>
            <label for="<?php echo $this->get_field_id( 'popular' ); ?>">Popular Tab : </label> 
            <input class="checkbox" id="<?php echo $this->get_field_id( 'popular' ); ?>" name="<?php echo $this->get_field_name( 'popular' ); ?>" type="checkbox" value="1" <?php checked(1,$popular,true); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'comments' ); ?>">Comments Tab : </label> 
            <input class="checkbox" id="<?php echo $this->get_field_id( 'comments' ); ?>" name="<?php echo $this->get_field_name( 'comments' ); ?>" type="checkbox" value="1" <?php checked(1,$comments,true); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'tags' ); ?>">Tags Tab : </label> 
            <input class="checkbox" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" type="checkbox" value="1" <?php checked(1,$tags,true); ?>/>
        </p>
        <h4>Jumlah ditampilkan</h4>
        <p>
            <label for="<?php echo $this->get_field_id( 'jumlah_popular' ); ?>">Jumlah Popular : </label> 
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'jumlah_popular' ); ?>" name="<?php echo $this->get_field_name( 'jumlah_popular' ); ?>" type="number" value="<?php echo esc_attr( $jumlah_popular ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'jumlah_comments' ); ?>">Jumlah Comments : </label> 
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'jumlah_comments' ); ?>" name="<?php echo $this->get_field_name( 'jumlah_comments' ); ?>" type="number" value="<?php echo esc_attr( $jumlah_comments ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'jumlah_tags' ); ?>">Jumlah Tags : </label> 
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'jumlah_tags' ); ?>" name="<?php echo $this->get_field_name( 'jumlah_tags' ); ?>" type="number" value="<?php echo esc_attr( $jumlah_tags ); ?>" />
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']              = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['popular']            = ( ! empty( $new_instance['popular'] ) ) ? strip_tags( $new_instance['popular'] ) : '';
        $instance['comments']           = ( ! empty( $new_instance['comments'] ) ) ? strip_tags( $new_instance['comments'] ) : '';
        $instance['tags']               = ( ! empty( $new_instance['tags'] ) ) ? strip_tags( $new_instance['tags'] ) : '';
        $instance['jumlah_popular']     = ( ! empty( $new_instance['jumlah_popular'] ) ) ? strip_tags( $new_instance['jumlah_popular'] ) : '';
        $instance['jumlah_tags']        = ( ! empty( $new_instance['jumlah_tags'] ) ) ? strip_tags( $new_instance['jumlah_tags'] ) : '';
        $instance['jumlah_comments']    = ( ! empty( $new_instance['jumlah_comments'] ) ) ? strip_tags( $new_instance['jumlah_comments'] ) : '';
        return $instance;
    }

// Class tabs_posts_widget ends here
} 
     
     
// Register and load the widget
function tabs_posts_load_widget() {
    register_widget( 'tabs_posts_widget' );
}
add_action( 'widgets_init', 'tabs_posts_load_widget' );