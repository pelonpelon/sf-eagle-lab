<?php
if(!function_exists('event_geek_list')){
	function event_geek_list($options = array('post_per_page'=>'', 'order_by'=>'meta_value_num', 'order'=>'ASC')){

		global $post;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		if($options['post_per_page']){
			$args = array(
			'post_type' => 'gg_events',
			'meta_key' => 'gg_event_dates',
			'orderby' => $options['orderby'],
			'order' => $options['order'],
		 	'paged' => $paged,			
			'posts_per_page' => $options['post_per_page']
		  ); 				
		} else {
			$args = array(
			'post_type' => 'gg_events',
			'meta_key' => 'gg_event_dates',
			'orderby' => $options['orderby'],
		 	'paged' => $paged,			
			'order' => $options['order']
		  ); 			
		}
	  
	$query = new WP_Query($args);	

	echo apply_filters('gg_shortcode_begin', '<div class="event-listing event_geek_page">');

		while ( $query->have_posts() ) { $query->the_post();
			$gg_names = get_post_meta($post->ID, 'gg_names', true); //get list of meta names
			$meta = gg_get_saved_meta($gg_names,$post->ID);// load meta data
			?>
			<div class="event-listing">
				<?php echo apply_filters('gg_before_event_title', '<h4>') . get_the_title() . apply_filters('gg_after_event_title', '</h4>'); ?>
					
				<?php echo apply_filters('gg_before_event_dates', '<div class="event_dates">');
					
				$eventStartDate = apply_filters('gg_before_event_start_date' ,'<span class="datestart">') . date(get_option('date_format'),strtotime($meta['gg_event_date_start'])) . apply_filters('gg_after_event_start_date' ,'</span>');
				$eventEndDate = apply_filters('gg_before_event_end_date' , '<span class="dateend"> ' . __('to', 'event_geek')) . ' ' . date(get_option('date_format'),strtotime($meta['gg_event_date_end'])) . apply_filters('gg_after_event_end_date' ,'</span>');
				
				echo apply_filters('gg_event_start_date', $eventStartDate);
				
				if(!$meta['gg_is_single_day']){
					echo apply_filters('gg_event_end_date', $eventEndDate);
				 }// end if(!$meta['gg_is_single_day'])
				 
				echo apply_filters('gg_after_event_dates', '</div>');	 
			
				$thumb = wp_get_attachment_image_src( $meta['event_image_id'], 'thumbnail'); // returns an array
				if($thumb){
					echo '<img class="event_thumb" src="' . $thumb[0] . '" alt="' . get_the_title() . '" />';
					}//end if($thumb)
				
				echo get_event_geek_info($post->ID);
		
				the_content();
				?>
				<div class="clear"></div>
			</div><!--.event-listing-->
		  <?php
		  } wp_reset_postdata();	//end while
			?>
		<div class="navigation">
		<?php
		 if (get_next_posts_link('« Previous Arguments', $query->max_num_pages)) { ?>
		  <div class="alignleft"><?php next_posts_link('« Previous Events', $query->max_num_pages); ?></div>
		  <?php } 
		  if (get_previous_posts_link('Next Arguments »', $query->max_num_pages)) { ?>
		  <div class="alignright"><?php previous_posts_link('Next Events »', $query->max_num_pages); ?></div>
		  <?php } ?>
		</div><!--navigation--> 
		<?php
		$gg_event_options = get_option( 'gg_event_options');
		
		if($gg_event_options['event_promote'] == "yes"){
		
		echo '<p class="event_geek_promo"><a href="http://graphicgeek.net/event-geek" target="_blank">' . __('Powered by', 'event_geek') . ' Event Geek</a></p>'; 
		
		}

	echo apply_filters('gg_template_tag_end', '</div>');
		
	}//event_geek_list
}//if(!function_exists('event_geek_list'))

if(!function_exists('get_event_geek_info')){
	function get_event_geek_info($id=''){
		$return = '';
		if(!$id){global $post; $id = $post->ID;}//set default id
        $gg_names = get_post_meta($id, 'gg_names', true); //get list of meta names
        $meta = gg_get_saved_meta($gg_names,$id);// load meta data
		$gg_event_options = get_option( 'gg_event_options');//get current options
		
		if($gg_event_options['customize_event_info']){
			
			//if info customization is turned on--------------------------------------
			
			//get the list of fields
			$saved_inputs = $gg_event_options['custom_event_inputs'];
			$saved_types =  $gg_event_options['custom_event_types'];
			$count = 0;
			if(is_array($saved_inputs)){
				$info = '';
				foreach($saved_inputs as $input){
					$name = 'gg_event_' . strtolower($input);
					$name = str_replace(' ', '_', $name);
					if($meta[$name]){//if this input has a value filled in
						switch($saved_types[$count]){
							case 'link':
								//make sure http is added to the link
								$link = $meta[$name];
								if (strpos($link,'http://') === false){
									$link = 'http://'.$link;
								}
								
								$str = $link;
								$str = preg_replace('#^https?://#', '', $str);
								
								$info .='<p><strong>' . $input . ':  </strong><a href="' . $link . '" target="_blank">' . $str . '</a></p>';
							break;
							
							case 'email':
								$info .='<p><strong>' . $input . ':  </strong><a href="mailto:' . $meta[$name] . '">' . $meta[$name]  . '</a></p>';
							break;
							
							default:
								$info .='<p><strong>' . $input . ':  </strong>' . $meta[$name] . '</p>';
						}//switch
			
						
					}// if($meta[$name]){
					$count++;
				}//foreach
				if($info){
					$return .='<div class="gg_event_info custom">';
					$return .= $info;
					$return .= '</div>'; //.gg_event_info
				}//if $info
			}//if if(is_array($saved_inputs)){
		} else{
			
			//if info customization is not turned on--------------------------------------
			
			if($meta['gg_event_address'] || $meta['gg_event_address2'] || $meta['gg_event_phone'] || $meta['gg_event_web_address']) {
				$return .='<div class="gg_event_info">';
				if($meta['gg_event_address']){
                         $return .= '<p><strong>' . __('Address', 'event_geek') . ': </strong>' . $meta['gg_event_address'] . '</p>';
                    }
                    if($meta['gg_event_address2']){ $return .= '<p>' . $meta['gg_event_address2'] . '</p>'; }
                    if($meta['gg_event_phone']){ $return .= '<p>' . __('Phone', 'event_geek') . ': ' . $meta['gg_event_phone'] . '</p>'; }
                    if($meta['gg_event_web_address']){
                        $link = $meta['gg_event_web_address'];
                        
                        if (strpos($link,'http://') === false){
                        $link = 'http://'.$link;
                        }
                        
                        $str = $link;
                        $str = preg_replace('#^https?://#', '', $str);
                        
                         $return .= '<p><a href="' . $link . '" target="_blank">' . $str . '</a></p>';
					}// if($meta['gg_event_web_address']
				$return .= '</div>'; //.gg_event_info
			}// end if($meta['gg_event_address']
		
		
		}//if($gg_event_options['customize_event_info'])
		return $return;
	}//get_event_geek_info()
}//if(!function_exists('get_event_geek_info')){

?>