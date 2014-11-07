<?php
// Register the events post type
function gg_events_posttype() {
    register_post_type( 'gg_events',
        array(
            'labels' => array(
                'name' => __( 'Events', 'event_geek'),
                'singular_name' => __( 'Event', 'event_geek'),
                'add_new' => __( 'Add New Event', 'event_geek'),
                'add_new_item' => __( 'Add New Event', 'event_geek'),
                'edit_item' => __( 'Edit Event', 'event_geek'),
                'new_item' => __( 'Add New Event', 'event_geek'),
                'view_item' => __( 'View Event', 'event_geek'),
                'search_items' => __( 'Search Events', 'event_geek'),
                'not_found' => __( 'No Events found', 'event_geek'),
                'not_found_in_trash' => __( 'No Events found in trash', 'event_geek')
            ),
            'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'has_archive' => false,
            'supports' => array( 'title', 'editor', 'revisions'),
            'capability_type' => 'post',
            'menu_position' => 5,
            //'menu_icon' => get_bloginfo('template_directory') . '/inc/icons/events.png',
            'register_meta_box_cb' => 'add_gg_events_metaboxes'
        )
    );
}
add_action( 'init', 'gg_events_posttype' );

// Add the events Meta Boxes
 
function add_gg_events_metaboxes() {
    add_meta_box('gg_events_options', __('Options', 'event_geek'), 'gg_events_options', 'gg_events', 'side', 'default');
}

// The events options Metabox
 
function gg_events_options() {
    global $post;
 
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="event_meta_noncename" id="event_meta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
 
if(function_exists( 'wp_enqueue_media' )){

   wp_enqueue_media();//Make the WordPress Media Uploader available for use

}

	//load support for the required jQuery UI components
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');	
	
	$uiTheme = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css';
	wp_enqueue_style('jquery-style', apply_filters('gg_admin_ui_theme', $uiTheme));

	$gg_event_options = get_option( 'gg_event_options');//get current options
 
//delare meta variable names
	$names = array(
	'event_image_id',
	'gg_is_single_day',
	'gg_event_date_start',
	'gg_event_date_start_standard_format',
	'gg_event_date_end',
	'gg_event_date_end_standard_format',
	'gg_event_dates',
	'gg_event_sort_date'
	);
	if(!$gg_event_options['customize_event_info']){ //if info customization is not turned on
		//add standard info fields
		$names[] = 'gg_event_address';
		$names[] = 'gg_event_address2';
		$names[] = 'gg_event_web_address';
		$names[] = 'gg_event_phone';
	} else { //if info customization is turned on
		//add custom info fields
		$saved_inputs = $gg_event_options['custom_event_inputs'];
		$saved_types =  $gg_event_options['custom_event_types'];
		$count = 0;		
		//print_r($saved_inputs);
		foreach($saved_inputs as $input){
			$name = 'gg_event_' . strtolower($input);
			$name = str_replace(' ', '_', $name);
			$names[] = $name;
			$names[] = $name . '_type';
			//save the type of input (text, link, or email)
			echo '<input type="hidden" name="' . $name . '_type' . '" value="'. $saved_types[$count]. '">';
	    	$count++;
	    }//foreach
		
	}//end else !$gg_event_options['customize_event_info']
    // Get the meta data if its already been entered
	$meta = gg_get_saved_meta($names,$post->ID); //load saved data

foreach($names as $value)
{
  echo '<input type="hidden" name="gg_names[]" value="'. $value. '">';
}

if($meta['gg_is_single_day']){$endDate = $meta['gg_event_date_start'];}else{$endDate = $meta['gg_event_date_end'];}
    // Show the fields
	   	?>
<h3><?php _e('Event Date', 'event_geek'); ?>:</h3>
<p><?php _e('Start', 'event_geek'); ?>: <input id="gg_event_date_start" name="gg_event_date_start" class="ggdatepicker" type="text" value="<?php echo $meta['gg_event_date_start']; ?>" /></p>
<input id="gg_event_date_start_standard_format" name="gg_event_date_start_standard_format" type="hidden" value="<?php echo $meta['gg_event_date_start_standard_format']; ?>" />

<p><?php _e('End', 'event_geek'); ?>: <input id="gg_event_date_end" name="gg_event_date_end" class="ggdatepicker" type="text" value="<?php echo $endDate; ?>" /></p>
<input id="gg_event_date_end_standard_format" name="gg_event_date_end_standard_format" type="hidden" value="<?php echo $meta['gg_event_date_end_standard_format']; ?>" />
<p><?php _e('Single Day Event', 'event_geek'); ?>: <input type="checkbox" id="gg_is_single_day" name="gg_is_single_day" value="yes"<?php checked($meta['gg_is_single_day'],'yes');?>></p>
 
<?php
if($gg_event_options['customize_event_info']){ //if info customization is turned on
	//display customized fields
			foreach($saved_inputs as $input){
			$name = 'gg_event_' . strtolower($input);
			$name = str_replace(' ', '_', $name); ?>
			
			<p><?php echo $input; ?>: <input name="<?php echo $name; ?>" type="text" value="<?php echo $meta[$name]; ?>" /></p>
			
		<?php }//foreach
	
	
 } else {
 //display standard fields
 ?>
<p><?php _e('Address', 'event_geek'); ?>: <input name="gg_event_address" type="text" value="<?php echo $meta['gg_event_address']; ?>" /></p>
<p><?php _e('Address Line 2', 'event_geek'); ?>: <input name="gg_event_address2" type="text" value="<?php echo $meta['gg_event_address2']; ?>" /></p>
<p><?php _e('Phone', 'event_geek'); ?>: <input name="gg_event_phone" type="text" value="<?php echo $meta['gg_event_phone']; ?>" /></p>
<p><?php _e('Website', 'event_geek'); ?>: <input name="gg_event_web_address" type="text" value="<?php echo $meta['gg_event_web_address']; ?>" /></p>
<?php } //end else($gg_event_options['customize_event_info']  ?>
       
<p><strong><?php _e('Event Image', 'event_geek'); ?>:</strong><a href="#" class="gg_media_upload" id="event_image" data-uploader_button_text="<?php echo __('Set Event Thumbnail'); ?>"><?php echo __('Upload'); ?></a></p>

<?php if($meta['event_image_id']) {
	//if an image is already set, load it now
	$eventImg = wp_get_attachment_image_src( $meta['event_image_id'], 'thumbnail'); // returns an array
	 ?><img id="gg_event_image_img" class="gg_media_image" src="<?php echo $eventImg[0]; ?>" /><?php } else {?>
<img id="gg_event_image_img" class="gg_media_image" src="" /><?php } ?>

<input class="gg_media_id" type="hidden" name="event_image_id" id="gg_event_image_id" value="<?php echo $meta['event_image_id']; ?>">



<?php 
}



// Save the Metabox Data
 
function gg_save_events_meta($post_id, $post) {
 
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['event_meta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
 
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
 
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
	$gg_event_options = get_option( 'gg_event_options');//get current options
    
	$events_meta = gg_get_posted_meta();

 	
		if($events_meta['gg_is_single_day']){ 
			$events_meta['gg_event_dates'] = date($gg_event_options['gg_event_date_format'], strtotime($events_meta['gg_event_date_start']));
		} else{
			$startDate = strtotime($events_meta['gg_event_date_start']);
			$endDate = strtotime($events_meta['gg_event_date_end']);
			
			while($startDate <= $endDate){
				$events_meta['gg_event_dates'] .= date($gg_event_options['gg_event_date_format'], $startDate);
				
				if($startDate!= $endDate){$events_meta['gg_event_dates'] .= '|';}
				
				$startDate =  strtotime(date($gg_event_options['gg_event_date_format'], $startDate) . ' + 1 day');//add one day
			}//end while

		}//end if($events_meta['gg_is_single_day']


    // Add values of $events_meta as gg fields
 
    foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store gg data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the gg field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the gg field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
// gg_event_dates
}
 
add_action('save_post', 'gg_save_events_meta', 1, 2); // save the gg fields

?>