<?php
/**
 * @package Event_Geek
 * @version 1.7
 */
/*
Plugin Name: Event Geek
Description: An easy to use events plugin built with jQuery UI and AJAX. Includes a calendar widget and a shortcode to display a list of events on a post or page. Several styles to choose from, or you can use your own. Includes hooks for even more customization.
Author: Graphic Geek
Plugin URI: http://www.graphicgeek.net/event-geek
Version: 1.7
Author URI: http://graphicgeek.net
*/

define('GG_ABSPATH', dirname(__FILE__));
define('GG_CORE_ABSPATH', GG_ABSPATH . '/core');
require_once GG_CORE_ABSPATH . '/gg-options.php';
require_once GG_CORE_ABSPATH . '/gg-functions.php';
require_once GG_CORE_ABSPATH . '/gg-post-type.php';
require_once GG_CORE_ABSPATH . '/gg-widget.php';
require_once GG_CORE_ABSPATH . '/gg-ajax.php';
require_once GG_CORE_ABSPATH . '/gg-shortcodes.php';
require_once GG_CORE_ABSPATH . '/gg-template-functions.php';

function gg_event_housekeeping(){

	$gg_event_options = get_option( 'gg_event_options');//get current options
	
	if(!$gg_event_options['gg_event_date_format']){
		$gg_event_options['gg_event_date_format'] = 'Ymd'; //set date format
		update_option('gg_event_options', $gg_event_options); //update version	
		}
	
	if(!$gg_event_options['gg_event_version'] || $gg_event_options['gg_event_version'] == '1.3'){ //if no version is recorded
			
		global $post;
	
		$args = array(
			'post_type' => 'gg_events',
			'posts_per_page' => -1
		); 		  
		
		$query = new WP_Query($args);
		
		while ( $query->have_posts() ) { $query->the_post();
			$gg_names = get_post_meta($post->ID, 'gg_names', true); //get list of meta names
			$meta = gg_get_saved_meta($gg_names,$post->ID);// load meta data
			$gg_names .= ',gg_event_sort_date';
			update_post_meta($post->ID, 'gg_event_sort_date', date_i18n($gg_event_options['gg_event_date_format'], strtotime($meta['gg_event_date_start'])));
			update_post_meta($post->ID, 'gg_names', $gg_names);	
		} wp_reset_postdata();	
		
	}//end if(!$gg_event_options['gg_event_version']){

	if(floatval($gg_event_options['gg_event_version']) <= 1.5){
		//for version 1.4.1 and lower, fix the gg_event_dates field of all events

		global $post;
	
		$args = array(
			'post_type' => 'gg_events',
			'posts_per_page' => -1
		); 		  
		
		$query = new WP_Query($args);//query all events
		
		while ( $query->have_posts() ) { $query->the_post();
			$gg_names = get_post_meta($post->ID, 'gg_names', true); //get list of meta names
			$meta = gg_get_saved_meta($gg_names,$post->ID);// load meta data

			if($meta['gg_is_single_day']){ 
				$meta['gg_event_dates'] = date_i18n($gg_event_options['gg_event_date_format'], strtotime($meta['gg_event_date_start']));
			} else{
				$meta['gg_event_dates'] = '';
				$startDate = strtotime($meta['gg_event_date_start']);
				$endDate = strtotime($meta['gg_event_date_end']);
				
				while($startDate <= $endDate){
					$meta['gg_event_dates'] .= date_i18n($gg_event_options['gg_event_date_format'], $startDate);
					
					if($startDate != $endDate){$meta['gg_event_dates'] .= '|';}
					
					$startDate =  strtotime(date_i18n($gg_event_options['gg_event_date_format'], $startDate) . ' + 1 day');//add one day
				}//end while

			}//end if($events_meta['gg_is_single_day']

			update_post_meta($post->ID, 'gg_event_dates', $meta['gg_event_dates']);	

		} wp_reset_postdata();			
		
	}//end if(version <= 1.5

	$gg_event_options['gg_event_version'] = '1.7'; //set version
	update_option('gg_event_options', $gg_event_options); //update version	
	
	if(!get_option('date_format')){update_option('date_format', 'd/m/Y');}//set a date format if none is set
	
}
add_action( 'admin_init', 'gg_event_housekeeping');
?>