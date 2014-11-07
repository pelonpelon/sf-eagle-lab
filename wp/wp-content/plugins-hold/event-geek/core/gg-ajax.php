<?php
function gg_event_ajax(){
	$clickedDate = $_POST['clickedDate'];
	$gg_event_options = get_option( 'gg_event_options');//get event plugin options
	
	global $post;

	$post_per_page = -1; 
	
	$meta_query =  array(
		array(
			'key' => 'gg_event_dates',
			'value' => date($gg_event_options['gg_event_date_format'], strtotime($clickedDate)),
			'compare' => 'LIKE'
		)
	);
		
	$args = array(
		'post_type' => 'gg_events',
		'posts_per_page' => $post_per_page,
		'meta_key' => 'gg_event_dates',
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'meta_query' => $meta_query,
	); 
	  
	$query = new WP_Query($args);

?>
	<img class="gg_close_ajax" src="<?php echo apply_filters('gg_ajax_close_image', plugins_url() . '/event-geek/images/close.png'); ?>" align="close" />

    <div id="gg_event_window_inner">
    
    <?php echo apply_filters('gg_before_clicked_date', '<h3>') . date_i18n(get_option('date_format'), strtotime($clickedDate)) . apply_filters('gg_after_clicked_date', '</h3>'); ?>
    
    <?php
    
    while ( $query->have_posts() ) { $query->the_post();
        $gg_names = get_post_meta($post->ID, 'gg_names', true); //get list of meta names
        $meta = gg_get_saved_meta($gg_names,$post->ID);// load meta data
    
       ?>
            <div class="event-listing">
            <?php
			echo apply_filters('gg_before_event_title', '<h4>');
            	the_title();
            echo apply_filters('gg_after_event_title', '</h4>');
                
            echo apply_filters('gg_before_event_dates', '<div class="event_dates">');
			
				$eventStartDate = apply_filters('gg_before_event_start_date' ,'<span class="datestart">') . date_i18n(get_option('date_format'),strtotime($meta['gg_event_date_start'])) . apply_filters('gg_after_event_start_date' ,'</span>');
				$eventEndDate = apply_filters('gg_before_event_end_date' , '<span class="dateend"> ' . __('to', 'even_geek')) . ' ' . date_i18n(get_option('date_format'),strtotime($meta['gg_event_date_end'])) . apply_filters('gg_after_event_end_date' ,'</span>');
				 
				echo apply_filters('gg_event_start_date', $eventStartDate);
			   
				if(!$meta['gg_is_single_day']){
					echo apply_filters('gg_event_end_date', $eventEndDate);
				 }
			   
		    echo apply_filters('gg_after_event_dates', '</div>');	 
             ?>
        
            <?php
            	$thumb = wp_get_attachment_image_src( $meta['event_image_id'], 'thumbnail'); // returns an array
            
            if($thumb){
            ?><img class="event_thumb" src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" /><?php } ?>
            
          <?php echo get_event_geek_info($post->ID); ?>
            
            <div class="event_content">
            <?php the_content(); ?>
            </div>
            
            <div class="clear"></div>
            </div>
      
    <?php
       
     }wp_reset_postdata();	?>
    
    <?php 
               
        if($gg_event_options['event_promote'] == "yes"){
        
        echo '<p class="event_geek_promo"><a href="http://graphicgeek.net/event-geek" target="_blank">' . __('Powered by', 'event_geek') . ' Event Geek</a></p>'; 
        
        }
    ?>
    
    <?php do_action('gg_event_ajax'); ?>
    </div><!--#gg_event_window_inner-->
    <img class="arrow_up" src="<?php echo plugins_url() . '/event-geek/images/arrow-up.png'; ?>" alt="arrow up" />
    <img class="arrow_down" src="<?php echo plugins_url() . '/event-geek/images/arrow-down.png'; ?>" alt="arrow up" />
 <?php   exit;
}

// for logged in users
add_action('wp_ajax_gg_event_ajax', 'gg_event_ajax');
// for non-logged in users
add_action('wp_ajax_nopriv_gg_event_ajax', 'gg_event_ajax');

?>