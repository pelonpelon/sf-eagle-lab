<?php

function gg_eventlist_shortcode( $atts, $content = null ){
 extract( shortcode_atts( array(
      'orderby' => 'meta_value_num',
	  'order' => 'ASC',
	  'limit' => -1
      // ...etc
      ), $atts ) );

$return = apply_filters('gg_shortcode_begin', '<div class="event-listing gg_short">');
	  
	global $post;

	  	$args = array(
	  	'post_type' => 'gg_events',
		'meta_key' => 'gg_event_dates',
		'orderby' => $orderby,
		'order' => $order,
		'posts_per_page' => $limit
	  ); 		  
	$query = new WP_Query($args);

	while ( $query->have_posts() ) { $query->the_post();
		$gg_names = get_post_meta($post->ID, 'gg_names', true); //get list of meta names
		$meta = gg_get_saved_meta($gg_names,$post->ID);// load meta data
		
		$return .= '<div class="event-listing">';
			$return .= apply_filters('gg_before_event_title', '<h4>');
			$return .= get_the_title();
			$return .= apply_filters('gg_after_event_title', '</h4>');
				
			$return .= apply_filters('gg_before_event_dates', '<div class="event_dates">');
		
			$eventStartDate = apply_filters('gg_before_event_start_date' ,'<span class="datestart">') . date(get_option('date_format'),strtotime($meta['gg_event_date_start'])) . apply_filters('gg_after_event_start_date' ,'</span>');
			$eventEndDate = apply_filters('gg_before_event_end_date' , '<span class="dateend"> ' . __('to', 'event_geek')) . ' ' . date(get_option('date_format'),strtotime($meta['gg_event_date_end'])) . apply_filters('gg_after_event_end_date' ,'</span>');
			 
			$return .= apply_filters('gg_event_start_date', $eventStartDate);
			
			if(!$meta['gg_is_single_day']){
				$return .= apply_filters('gg_event_end_date', $eventEndDate);
			 }// end if(!$meta['gg_is_single_day'])
			 
			$return .= apply_filters('gg_after_event_dates', '</div>');	 
		
			$thumb = wp_get_attachment_image_src( $meta['event_image_id'], 'thumbnail'); // returns an array
			if($thumb){
				$return .= '<img class="event_thumb" src="' . $thumb[0] . '" alt="' . get_the_title() . '" />';
				}//end if($thumb)
			
			$return .=  get_event_geek_info($post->ID);
	
			$return .= get_the_content();
			$return .= '<div class="clear"></div>';
		$return .= '</div>';// .event-listing
	  
	  } wp_reset_postdata();	//end while

	$gg_event_options = get_option( 'gg_event_options');
	
	if($gg_event_options['event_promote'] == "yes"){
	
	$return .= '<p class="event_geek_promo"><a href="http://graphicgeek.net/event-geek" target="_blank">' . __('Powered by', 'event_geek') . ' Event Geek</a></p>'; 
	
	}

$return .= apply_filters('gg_shortcode_end', '</div>');

return $return;

}//gg_eventlist_shortcode


add_shortcode( 'event_geek_list', 'gg_eventlist_shortcode' );


 ?>