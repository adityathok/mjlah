<?php
/**
 * Theme customizer
 *
 * @package mjlah
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*
* Add function for counter viewer in single
*/
function mjlah_viewer_post() {
    //if single or page
    if (is_single() || is_page()):
        $key        = 'post_views_count';

        $post_id    = get_the_ID();
        $count      = (int) get_post_meta( $post_id, $key, true );    
        $count++;  

        update_post_meta( $post_id, $key, $count );
    endif;
}
add_action('wp_head', 'mjlah_viewer_post');
///function get viewer
function mjlah_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
    $count = $count > 0 ? $count : 0 ;
    return $count;
}
///set column to dashboard
function mjlah_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}
function mjlah_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo mjlah_get_post_view();
    }
}
add_filter( 'manage_posts_columns', 'mjlah_posts_column_views' );
add_action( 'manage_posts_custom_column', 'mjlah_posts_custom_column_views' );
add_filter( 'manage_page_posts_columns', 'mjlah_posts_column_views' );
add_action( 'manage_page_posts_custom_column', 'mjlah_posts_custom_column_views' );

/*
* Add function for footer
*/
function mjlah_actionfooter() {
    //scroll up button
    $scrollfooter 	= get_theme_mod('scrolltotop_footer');
    if($scrollfooter=='on'): ?>
        <span class="scrolltoTop" onClick="window.scrollTo({top: 100,left: 100,behavior: 'smooth'});">
            <i class="fa fa-caret-up" aria-hidden="true"></i>
        </span>
    <?php
    endif;

    //Wa footer
    $wafooter 	    = get_theme_mod('whatsapp_footer');
    $wafooterpos 	= get_theme_mod('whatsapp_footer_position');
    $nowafooter     = get_theme_mod('whatsapp_sosmed_number');
    $msgwafooter    = get_theme_mod('whatsapp_sosmed_message');

    if (substr($nowafooter, 0, 1) === '0') {
        $nowafooter    = '62' . substr($nowafooter, 1);
    } else if (substr($nowafooter, 0, 1) === '+') {
        $nowafooter    = '' . substr($nowafooter, 1);
    }

    if($wafooter=='on' && $nowafooter): ?>
        <a class="wa-floating wa-floating-<?php echo $wafooterpos; ?>" href="https://wa.me/<?php echo $nowafooter; ?>?text=<?php echo $msgwafooter; ?>" target="_blank" rel="noreferrer">
            <i class="fa fa-whatsapp" aria-hidden="true"></i>
        </a>
    <?php
    endif;
}
add_action('wp_footer', 'mjlah_actionfooter');

/*
*get content of post
*/
function mjlah_getexcerpt($count=150,$idpost=null){
    global $post;
    $html = $idpost=null?get_the_content():get_post_field('post_content',$idpost);
    $html = strip_tags($html);
    $html = substr($html, 0, $count);
    $html = substr($html, 0, strripos($html, " "));
    $html = ''.$html.'...';
    return $html;
}

/*
*generated schema content of post
*/
function mjlah_generated_schema($idpost=null){
    $schema = '';
    if($idpost!=null):
        
        $width      = '';
        $height     = '';
        if(get_the_post_thumbnail_url($idpost,'full')) {
            list($width, $height, $type, $attr) = getimagesize(get_the_post_thumbnail_url($idpost,'full'));
        }

        $author_id  = get_post_field( 'post_author', $idpost );
        $schema     .= '<div>';
        $schema     .= '<meta itemscope="" itemprop="mainEntityOfPage" itemtype="https://schema.org/WebPage" itemid="'.get_permalink($idpost).'" content="'.get_the_title($idpost).'">';
        $schema     .= '<meta itemprop="datePublished" content="'.get_the_date( 'Y-m-d', $idpost ).'">';
        $schema     .= '<meta itemprop="dateModified" content="'.get_the_modified_date('Y-m-d', $idpost).'">';
        $schema     .= '<div itemprop="publisher" itemscope="" itemtype="https://schema.org/Organization">';
            $schema .= '<meta itemprop="name" content="'.get_bloginfo( 'name' ).'">';
        $schema     .= '</div>';
        $schema     .= '<div itemscope="" itemprop="author" itemtype="https://schema.org/Person">';
            $schema .= '<meta itemprop="url" content="'.get_the_author_meta( 'url', $author_id ).'">';
            $schema .= '<meta itemprop="name" content="'.get_the_author_meta( 'nicename', $author_id ).'">';
        $schema     .= '</div>';
        $schema     .= '<div itemscope="" itemprop="image" itemtype="https://schema.org/ImageObject">';
            $schema .= '<meta itemprop="url" content="'.get_the_post_thumbnail_url($idpost,'full').'">';
            $schema .= '<meta itemprop="width" content="'.$width.'">';
            $schema .= '<meta itemprop="height" content="'.$height.'">';
        $schema     .= '</div>';
        $schema     .= '<div itemprop="interactionStatistic" itemscope="" itemtype="https://schema.org/InteractionCounter">';
            $schema .= '<meta itemprop="interactionType" content="https://schema.org/CommentAction">';
            $schema .= '<meta itemprop="userInteractionCount" content="'.wp_count_comments($idpost)->total_comments.'">';
        $schema     .= '</div>';
        $schema     .= '</div>';
    endif;
    return $schema;
}

function mjlah_thumbnail( $idpost=null, $size = 'thumbnail' , $attr='' ) {
    //html
    $html       = '';
    //id post
    $idpost     = $idpost=null?get_the_ID(): $idpost;
    // Handling attributes width & height 
    $width      = isset($size[0]) ? $size[0] : '';
    $height     = isset($size[1]) ? $size[1] : '';
    
    //check if size array 
    if (is_array($size)) {
        $url        = get_the_post_thumbnail_url($idpost,'full'); // Get featured image url
        $imgurl     = aq_resize( $url, $width, $height, true, true, true ); // Resize image
    } else {
        $imgurl     = get_the_post_thumbnail_url($idpost,$size); // Get featured image url        
        $width      = get_option( $size.'_size_w');
        $height     = get_option( $size.'_size_h');
    }

    //Class Img
    $class          = 'wp-post-image';
    $class          .= isset($attr['class'])&&!empty($attr['class'])?' '.$attr['class']:'';
    //Class link
    $classlink      = isset($attr['class-link'])&&!empty($attr['class-link'])?'class="'.$attr['class-link'].'"':'';
    
    //output
    $html .= '<a href="'.get_the_permalink($idpost).'" '.$classlink.'>';
    if($imgurl){
        $html .= '<img src="'.$imgurl.'" alt="" class="'.$class.'" loading="lazy"/>';
    } else {
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="10px" y="0px" viewBox="0 0 60 60" style="background-color: #ececec;width: 100%;height: auto;enable-background:new 0 0 60 60;padding: 1rem;" xml:space="preserve" width="'.$width.'" height="'.$height.'"><g><g><path d="M55.201,15.5h-8.524l-4-10H17.323l-4,10H12v-5H6v5H4.799C2.152,15.5,0,17.652,0,20.299v29.368   C0,52.332,2.168,54.5,4.833,54.5h50.334c2.665,0,4.833-2.168,4.833-4.833V20.299C60,17.652,57.848,15.5,55.201,15.5z M8,12.5h2v3H8   V12.5z M58,49.667c0,1.563-1.271,2.833-2.833,2.833H4.833C3.271,52.5,2,51.229,2,49.667V20.299C2,18.756,3.256,17.5,4.799,17.5H6h6   h2.677l4-10h22.646l4,10h9.878c1.543,0,2.799,1.256,2.799,2.799V49.667z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#f3f3f3"/><path d="M30,14.5c-9.925,0-18,8.075-18,18s8.075,18,18,18s18-8.075,18-18S39.925,14.5,30,14.5z M30,48.5c-8.822,0-16-7.178-16-16   s7.178-16,16-16s16,7.178,16,16S38.822,48.5,30,48.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#f3f3f3"/><path d="M30,20.5c-6.617,0-12,5.383-12,12s5.383,12,12,12s12-5.383,12-12S36.617,20.5,30,20.5z M30,42.5c-5.514,0-10-4.486-10-10   s4.486-10,10-10s10,4.486,10,10S35.514,42.5,30,42.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#f3f3f3"/><path d="M52,19.5c-2.206,0-4,1.794-4,4s1.794,4,4,4s4-1.794,4-4S54.206,19.5,52,19.5z M52,25.5c-1.103,0-2-0.897-2-2s0.897-2,2-2   s2,0.897,2,2S53.103,25.5,52,25.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#f3f3f3"/></g></g> </svg>';
    }
    $html .= '</a>';

  return $html;
}

function mjlah_related_post() {
    echo '<div class="related-post">';

        //Output Title
        echo '<h3 class="widget-title"><span>Related Post</span></h3>';

        //args query
        $args                       = [];
        $args['posts_per_page']     = 4;
        $args['post__not_in']       = array(get_the_ID());
        
        //get tags from post
        $tags  = wp_get_post_tags(get_the_ID());
        if ($tags) {
            $first_tag = $tags[0]->term_id;
        }
        //get list category from post
        $cat  = wp_get_post_categories(get_the_ID());

        //if have tags and category not just Uncategory(1)
        if (in_array('1', $cat) && count($cat)==1 && !empty($tags)) {
            $args['tag__in']        = array($first_tag);
        } else {
            $args['category__in']   = $cat;
        }

        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) { ?>

            <div class="row">

                <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
                    <div class="col-6 col-md-3 mb-3">
                        <?php echo mjlah_thumbnail( get_the_ID(),'thumbnail' , array( 'class' => 'w-100 mx-auto' ) );?>                        
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </div>
            
                <?php endwhile; ?>

            </div>

            <?php
        }
        wp_reset_query();

    echo '</div>';
}


//remove category: in title archive category
function mjlah_prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'mjlah_prefix_category_title' );


/**
 * function to get button social sharing
 * use $list as array social media , ['facebook','twitter'] 
 */
function mjlah_sharing($list = '') {
    if ( ! $list ) {
		$list = ['facebook','twitter'];
    }
    
    $media_url  = get_the_post_thumbnail_url();
    $post_link  = get_permalink(); 
    $post_title = get_the_title();

	if ( '' !== $post_link ) {
		$permalink = $post_link;
	} else {
		$permalink = ( class_exists( 'WooCommerce' ) && is_checkout() || is_front_page() ) ? home_url() : get_permalink();

		if ( class_exists( 'BuddyPress' ) && is_buddypress() ) {
			$permalink = bp_get_requested_url();
		}
	}

    $permalink = rawurlencode( $permalink );
    
    if ( '' !== $post_title ) {
		$title = $post_title;
	} else {
		$title = class_exists( 'WooCommerce' ) && is_checkout() || is_front_page() ? get_bloginfo( 'name' ) : get_the_title();
	}

    $title = rawurlencode( wp_strip_all_tags( html_entity_decode( $title, ENT_QUOTES, 'UTF-8' ) ) );
    
    $twitter_username = get_bloginfo( 'name' );

    $button = [];

    foreach($list as $network) {

        $link   = '';
        $icon   = '';
        $color  = '';

        switch ( $network ) {
            case 'facebook' :
                $link   = sprintf( 'http://www.facebook.com/sharer.php?u=%1$s&t=%2$s', esc_attr( $permalink ), esc_attr( $title ) );
                $color  = '#4065ad';
                break;
            case 'twitter' :
                $link   = sprintf( 'http://twitter.com/share?text=%2$s&url=%1$s&via=%3$s', esc_attr( $permalink ), esc_attr( $title ), ! empty( $twitter_username ) ? esc_attr( $twitter_username ) : get_bloginfo( 'name' ) );
                $color  = '#1c9ceb';
                break;
            case 'whatsapp' :
                $link   = sprintf( 'https://wa.me/?text=%1$s', esc_attr( $permalink ));
                $color  = '#25cb64';
                break;
            case 'pinterest' :
                $link   = $media_url ? sprintf( 'http://www.pinterest.com/pin/create/button/?url=%1$s&media=%2$s&description=%3$s', esc_attr( $permalink ), esc_attr( urlencode( $media_url ) ), esc_attr( $title ) ) : '#';
                $color  = '#c51f27';
                break;
            case 'email' :
                $link   = sprintf( 'mailto:?subject=%1$s &amp;body=Check out this site %1$s', esc_attr( $title ), esc_attr( $permalink ) );
                $icon   = 'envelope';
                break;
            case 'linkedin' :
                $link   = sprintf( 'http://www.linkedin.com/shareArticle?mini=true&url=%1$s&title=%2$s', esc_attr( $permalink ), esc_attr( $title ) );
                $color  = '#4065ad';
                break;
            case 'tumblr' :
                $link   = sprintf( 'https://www.tumblr.com/share?v=3&u=%1$s&t=%2$s', esc_attr( $permalink ), esc_attr( $title ) );
                $color  = '#0072ae';
                break;
            case 'blogger' :
                $link   = sprintf( 'https://www.blogger.com/blog_this.pyra?t&u=%1$s&n=%2$s', esc_attr( $permalink ), esc_attr( $title ) );
                $icon   = 'rss';    
                $color  = '#f48120';
                break;            
            case 'gmail' :
                $link   = sprintf( 'https://mail.google.com/mail/u/0/?view=cm&fs=1&su=%2$s&body=%1$s&ui=2&tf=1', esc_attr( $permalink ), esc_attr( $title ) );
                $icon   = 'google';    
                $color  = '#d04041';
                break;
            case 'reddit' :
                $link   = sprintf( 'http://www.reddit.com/submit?url=%1$s&title=%2$s', esc_attr( $permalink ), esc_attr( $title ) );
                $color  = '#f74300';
                break;
        }

        $icon   = $icon?$icon:$network;
        $color  = $color?'style="background: '.$color.';border-color: '.$color.';"':'';

        $outputlink = '<a href="%1$s" title="%2$s" target="_blank" class="btn btn-sm btn-secondary mr-1 mb-1 rounded-0 py-1 px-2" %3$s rel="noreferrer"><i class="fa fa-%4$s"></i></a>';		
		$outputlink = sprintf(
			$outputlink,
			$link,
            'Share to '.$network,
            $color,
            $icon,
        );
        
        $button[] = $outputlink;

    }

    printf("<div class='sharing-button'>%s</div>",implode('',$button));

}

/**
 * function to get date today, indonesia
 */
function mjlah_date_today() {
    //array hari
    $hari       = ['','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
    //array bulan
    $bulan      = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    //today
    $today      = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
    
    $split 	    = explode('-', $today);
    $output     = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    $num        = date('N', strtotime($today));

    echo $hari[$num] . ' ' . $output;
}

/**
 * function to get scial media button from Customizer
 */
function mjlah_socialmedia() {

    //array social media
    $arraynetwork    = [
        'facebook'  => [
            'color' => '#4065ad',
        ],
        'twitter'  => [
            'color' => '#1c9ceb',            
        ],
        'instagram'  => [
            'color' => '#c353a0', 
        ],
        'youtube'  => [
            'color' => '#ea4436', 
        ],
        'rss'  => [
            'color' => '#f48120', 
        ],
    ];

    $button = [];

    //looping
    foreach($arraynetwork as $network => $attr) {
        $metaname   = $network.'_sosmed_link';
        $link       = $network=='rss'?''.home_url().'/rss':get_theme_mod($metaname);

        $color      = 'style="background: '.$attr['color'].';border-color: '.$attr['color'].'"';

        $outputlink = '<a href="%1$s" title="%2$s" target="_blank" class="btn btn-sm btn-secondary" %3$s rel="noreferrer"><i class="fa fa-%4$s"></i></a>';		
		$outputlink = sprintf(
			$outputlink,
			$link,
            $network,
            $color,
            $network,
        );

        $button[] = $outputlink;

    }

    printf("<div class='social-media-button'>%s</div>",implode('',$button));
}