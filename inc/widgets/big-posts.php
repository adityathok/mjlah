<?php
/**
 * mjlah functions and definitions
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Creating the widget 
class mjlah_bigposts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'mjlah_bigposts_widget', 

            // Widget name will appear in UI
            __('Widget Big Posts', 'mjlah'), 

            // Widget description
            array( 'description' => __( 'Tampilkan Big Post widget', 'mjlah' ), ) 
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $idwidget   = uniqid();
        $title      = apply_filters( 'widget_title', $instance['title'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        echo '<div class="widget-'.$idwidget.' posts-widget-'.$instance['layout'].'">';

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
            $query_args['cat']                  = $instance['kategori'];
            $query_args['order']                = $instance['order'];

            ///urutkan berdasarkan view
            if ($instance['orderby']=="view") {                
                $query_args['orderby']          = 'meta_value';
                $query_args['meta_key']         = 'post_views_count';
            }

            //jumlah post
            $layoutpost    = [
                'layout1'   => 5,
                'layout2'   => 6,
                'layout3'   => 9,
                'layout4'   => 3,
                'gallery1'  => 4,
                'gallery2'  => 5,
            ];
            $query_args['posts_per_page']   = $layoutpost[$instance['layout']];

            // The Query
            $the_query = new WP_Query( $query_args );
            
            // The Loop
            $i = 1;
            if ( $the_query->have_posts() ) {

                echo '<div class="list-posts" data-count="'.$the_query->post_count.'">';
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                            $this->layoutpost($instance['layout'],$instance,$i,$the_query->post_count);
                        $i++;
                    }
                echo '</div>';
            } else {
                // no posts found
            }
            /* Restore original Post Data */
            wp_reset_postdata();

        echo '</div>';

        echo $args['after_widget'];
    }

    //widget Layout Post
    public function layoutpost( $layout='layout1',$instance,$i=null,$count) {

        //Layout 1
        if($layout=='layout1') {

            if($i==1) {
                echo '<div class="row">';
                echo '<div class="col-md-6 first-column">';
            }

            if($i==2) {
                echo '</div>';
                echo '<div class="col-md-6 second-column">';
            }

            echo '<div class="list-post list-post-'.$i.'">'; 
                echo mjlah_generated_schema(get_the_ID());

                //first loop
                if($i == 1){
                ?>    

                    <div class="row mb-3 mb-md-0">
                        <div class="col-12 thumb-post">
                            <?php echo mjlah_thumbnail( get_the_ID(),array(300,200), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                        </div>
                        <div class="col-12 content-post">
                            <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold h4 mt-2 d-block"><?php echo get_the_title(); ?></a>
                            
                            <small class="d-block text-muted meta-post">
                                <span class="date-post"><?php echo get_the_date('F j, Y'); ?></span>
                                <span class="mx-1 separator">/</span>
                                <span class="view-post"><?php echo mjlah_get_post_view(); ?> views</span>
                            </small>
                            <div class="exceprt-post"><?php echo mjlah_getexcerpt(100,get_the_ID()); ?></div>
                        </div>
                    </div>

                <?php } else { ?>

                    <div class="row">
                        <div class="col-4 pr-0 thumb-post">
                            <?php echo mjlah_thumbnail( get_the_ID(),array(125,70), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                        </div>
                        <div class="col-8 content-post">
                            <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold h4 d-block"><?php echo get_the_title(); ?></a>
                            
                            <small class="d-block text-muted meta-post">
                                <span class="date-post"><?php echo get_the_date('F j, Y'); ?></span>
                                <span class="mx-1 separator">/</span>
                                <span class="view-post"><?php echo mjlah_get_post_view(); ?> views</span>
                            </small>
                        </div>
                        <span class="col-12"><hr class="my-2"></span>
                    </div> 

                <?php } ?>

            <?php
            
            echo '</div>';

            if($i==$count) {
                echo '</div>';
                echo '</div>';
            }
        
        ///Layout 2
        } else if($layout=='layout2') {

            if($i==1) {
                echo '<div class="row">';
                echo '<div class="col-md-6 first-column">';
            }

            if($i==2) {
                echo '</div>';
                echo '<div class="col-md-6 second-column">';
            }

            echo '<div class="list-post list-post-'.$i.'">'; 
                echo mjlah_generated_schema(get_the_ID());

                //first loop
                if($i == 1){
                ?>    

                    <div class="row mb-3 mb-md-0">
                        <div class="col-12 thumb-post">
                            <?php echo mjlah_thumbnail( get_the_ID(),array(300,200), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                        </div>
                        <div class="col-12 content-post">
                            <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold h3 mt-2 d-block"><?php echo get_the_title(); ?></a>
                            <div class="exceprt-post"><?php echo mjlah_getexcerpt(100,get_the_ID()); ?></div>
                            <small class="d-block text-muted meta-post">
                                <span class="date-post"><?php echo get_the_date('F j, Y'); ?></span>
                                <span class="mx-1 separator">/</span>
                                <span class="view-post"><?php echo mjlah_get_post_view(); ?> views</span>
                            </small>
                        </div>
                    </div>

                <?php } else { ?>

                    <div class="row">
                        <div class="col-3 col-md-2 pr-0 thumb-post">
                            <?php echo mjlah_thumbnail( get_the_ID(),array(70,70), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                        </div>
                        <div class="col-9 col-md-10 content-post">                            
                            <small class="d-block text-muted meta-post">
                                <span class="date-post"><?php echo get_the_date('F j, Y'); ?></span>
                                <span class="mx-1 separator">/</span>
                                <span class="view-post"><?php echo mjlah_get_post_view(); ?> views</span>
                            </small>
                            <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold h4 d-block"><?php echo get_the_title(); ?></a>
                        </div>
                        <span class="col-12"><hr class="my-2"></span>
                    </div> 

                <?php } ?>

            <?php
            
            echo '</div>';

            if($i==$count) {
                echo '</div>';
                echo '</div>';
            }

         ///Layout 3
        } else if($layout=='layout3') {

            if($i==1) {
                echo '<div class="row">';
                echo '<div class="col-md-6 first-column">';
            }

            if($i==2) {
                echo '</div>';
                echo '<div class="col-md-6 second-column">';
            }

            echo '<div class="list-post list-post-'.$i.'">'; 
                echo mjlah_generated_schema(get_the_ID());

                //first loop
                if($i == 1){
                ?>    

                    <div class="row mb-3 mb-md-0">
                        <div class="col-12 thumb-post">
                            <?php echo mjlah_thumbnail( get_the_ID(),array(300,200), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                        </div>
                        <div class="col-12 content-post">
                            <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold h3 d-block"><?php echo get_the_title(); ?></a>
                            
                            <small class="d-block text-muted meta-post">
                                <span class="date-post"><?php echo get_the_date('F j, Y'); ?></span>
                                <span class="mx-1 separator">/</span>
                                <span class="view-post"><?php echo mjlah_get_post_view(); ?> views</span>
                            </small>

                            <div class="exceprt-post"><?php echo mjlah_getexcerpt(100,get_the_ID()); ?></div>
                        </div>
                    </div>

                <?php } else { ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="content-post border-bottom py-2 px-3 bg-secondary">
                            <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold text-white d-block"><?php echo get_the_title(); ?></a>
                            </div>
                        </div>
                    </div> 

                <?php } ?>

            <?php
            
            echo '</div>';

            if($i==$count) {
                echo '</div>';
                echo '</div>';
            }

        ///Layout 4
        } else if($layout=='layout4') {

            if($i==1) {
                echo '<div class="row">';
                    echo '<div class="col-md-6 first-column">';
                        echo '<div class="thumb-post list-post-'.$i.'">';
                            echo mjlah_thumbnail( get_the_ID(),array(300,200), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="col-md-6 second-column">';
                        echo '<div class="content-post list-post-'.$i.' mb-3">';
                            echo '<a href="'.get_the_permalink().'" class="title-post font-weight-bold h3 mt-2 d-block">'.get_the_title().'</a>';
                            echo '<div class="exceprt-post">'.mjlah_getexcerpt(100,get_the_ID()).'</div>';
                        echo '</div>';
            }

                    if($i==2) {
                        echo '<div class="row">';
                            echo '<div class="col-6 list-post-'.$i.'">';
                            echo '<a href="'.get_the_permalink().'" class="title-post font-weight-bold d-block">'.get_the_title().'</a>';
                            echo '</div>';
                        
                    }
                    if($i==3) {
                            echo '<div class="col-6 list-post-'.$i.'">';
                            echo '<a href="'.get_the_permalink().'" class="title-post font-weight-bold d-block">'.get_the_title().'</a>';
                            echo '</div>';                        
                        echo '</div>';
                    }

            if($i==$count) {
                    echo '</div>';
                echo '</div>';
            }
            
        //Gallery 1
        } else if($layout=='gallery1') {

            if($i==1) {
                echo '<div class="row">';
                echo '<div class="col-md-9 first-column align-items-stretch">';
            }

            if($i==2) {
                echo '</div>';
                echo '<div class="col-md-3 pl-md-1 second-column">';
                echo '<div class="row mx-0">';
            }

                $klas = $i==1?'h-100':'col-4 px-1 py-0 col-md-12';
                echo '<div class="list-post list-post-'.$i.' '.$klas.'">'; 
                    echo mjlah_generated_schema(get_the_ID());

                    //first loop
                    if($i == 1){
                    ?>    

                        <div class="h-100" style="overflow: hidden;">
                            <div class="thumb-post">
                                <?php echo mjlah_thumbnail( get_the_ID(),array(460,310), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                            </div>
                            <div class="content-post h-100">
                                <div class="bg-primary p-3 text-white h-100">
                                    <a href="<?php echo get_the_permalink(); ?>" class="title-post font-weight-bold h4 text-white d-block"><?php echo get_the_title(); ?></a>
                                    <div class="exceprt-post"><?php echo mjlah_getexcerpt(100,get_the_ID()); ?></div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="gallery-posts position-relative mt-2 mt-md-0  <?= $i!=$count?'mb-md-3':'';?>">
                            <?php echo mjlah_thumbnail( get_the_ID(),array(140,140), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                            <a href="<?php echo get_the_permalink(); ?>" class="mask-post bg-primary"><span><?php echo get_the_title(); ?></span></a>
                        </div>

                    <?php } ?>

                <?php
            
            echo '</div>';

            if($i==$count) {
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            
            //Gallery 2
            } else if($layout=='gallery2') {
    
                if($i==1) {
                    echo '<div class="row">';
                    echo '<div class="col-md-6 first-column align-items-stretch p-0">';
                }
    
                if($i==2) {
                    echo '</div>';
                    echo '<div class="col-md-6 second-column align-items-stretch p-md-0 pr-0 pl-3 pt-1">';
                    echo '<div class="row m-0">';
                }
    
                    $klas   = $i==1?'h-100 px-3':'col-6 pr-3 pl-0';
                    echo '<div class="list-post list-post-'.$i.' align-items-stretch '.$klas.'">'; 
                        echo mjlah_generated_schema(get_the_ID());
    
                        //first loop
                        if($i == 1){
                        ?>    
    
                            <div class="gallery-posts position-relative mb-3 mb-md-0 <?php echo $i==1?'h-100':'';?>">
                                <?php echo mjlah_thumbnail( get_the_ID(),array(300,300), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                                <a href="<?php echo get_the_permalink(); ?>" class="mask-post bg-primary">
                                    <div class="title-post font-weight-bold h4"><?php echo get_the_title(); ?></div>
                                    <div class="exceprt-post"><?php echo mjlah_getexcerpt(100,get_the_ID()); ?></div>
                                </a>
                            </div>
    
                        <?php } else { ?>
    
                            <div class="gallery-posts position-relative mt-2 mt-md-0  <?= ($i==2 || $i==3)?'mb-3':'';?>">
                                <?php echo mjlah_thumbnail( get_the_ID(),array(140,140), array( 'class' => 'w-100 img-fluid','class-link' => 'd-block' ) );?>
                                <a href="<?php echo get_the_permalink(); ?>" class="mask-post bg-primary"><span><?php echo get_the_title(); ?></span></a>
                            </div>
    
                        <?php } ?>
    
                    <?php
                
                echo '</div>';
    
                if($i==$count) {
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

        //Endif layout    
        };
    }

    // Widget Backend 
    public function form( $instance ) {
        //widget data
        $title          = isset( $instance[ 'title' ])?$instance[ 'title' ]:'New Post';
        $layout         = isset( $instance[ 'layout' ])?$instance[ 'layout' ]:'';
        $kategori       = isset( $instance[ 'kategori' ])?$instance[ 'kategori' ]:'';
        $orderby        = isset( $instance[ 'orderby' ])?$instance[ 'orderby' ]:'';
        $order          = isset( $instance[ 'order' ])?$instance[ 'order' ]:'';

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Judul:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'layout' ); ?>">Layout:</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'layout' ); ?>">
                <option value="layout1"<?php selected($layout, "layout1"); ?>>Layout 1</option>
                <option value="layout2"<?php selected($layout, "layout2"); ?>>Layout 2</option>
                <option value="layout3"<?php selected($layout, "layout3"); ?>>Layout 3</option>
                <option value="layout4"<?php selected($layout, "layout4"); ?>>Layout 4</option>
                <option value="gallery1"<?php selected($layout, "gallery1"); ?>>Gallery 1</option>
                <option value="gallery2"<?php selected($layout, "gallery2"); ?>>Gallery 2</option>
            </select>
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
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>">Urutkan Berdasarkan:</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <option value="date"<?php selected($orderby, "date"); ?>>Tanggal</option>
                <option value="view"<?php selected($orderby, "view"); ?>>Populer</option>
            </select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'order' ); ?>">Urutan:</label>        
            <select class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>">
                <option value="DESC"<?php selected($order, "DESC"); ?>>DESC</option>
                <option value="ASC"<?php selected($order, "ASC"); ?>>ASC</option>
            </select>
		</p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['layout']         = ( ! empty( $new_instance['layout'] ) ) ? strip_tags( $new_instance['layout'] ) : '';
        $instance['kategori']       = ( ! empty( $new_instance['kategori'] ) ) ? strip_tags( $new_instance['kategori'] ) : '';
        $instance['orderby']        = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
        $instance['order']          = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
        return $instance;
    }

// Class mjlah_bigposts_widget ends here
} 
     
     
// Register and load the widget
function mjlah_bigposts_load_widget() {
    register_widget( 'mjlah_bigposts_widget' );
}
add_action( 'widgets_init', 'mjlah_bigposts_load_widget' );