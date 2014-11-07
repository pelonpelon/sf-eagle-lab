<?php
add_action('admin_menu', 'gg_add_event_options');

function gg_add_event_options() {
	
	$title = "Event Geek Options";
	$header = "Event Options";
	$parent_slug = 'edit.php?post_type=gg_events';
	$page_title = 'Event Options';
	$menu_title = 'Options';
	$capability = 'manage_options';
	$menu_slug = 'gg_event_menu';
	$function = 'gg_event_options';
	
	add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	
}

function gg_event_options() {
	
	if(isset($_POST['submit'])){
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		$ggNonce = $_POST['gg_event_options_noncename'];
		if (wp_verify_nonce( $ggNonce, 'gg_event_geek-nonce' . plugin_basename(__FILE__) )) {
	   
			$gg_event_posted_options = array();
			$gg_event_posted_options['event_ui_theme'] = $_POST['event_ui_theme'];
			$gg_event_posted_options['event_custom_ui_theme'] = $_POST['event_custom_ui_theme'];
			$gg_event_posted_options['event_highlight_color'] = $_POST['event_highlight_color'];
			$gg_event_posted_options['event_highlight_text_color'] = $_POST['event_highlight_text_color'];	
			$gg_event_posted_options['event_promote'] = $_POST['event_promote'];			
			$gg_event_posted_options['event_language'] = $_POST['event_language'];
			$gg_event_posted_options['customize_event_info'] = $_POST['customize_event_info'];	
			$gg_event_posted_options['custom_event_inputs'] = $_POST['custom_event_inputs'];
			$gg_event_posted_options['custom_event_types'] = $_POST['custom_event_types'];
			
			
			do_action('gg_options_submited');
				
			update_option('gg_event_options', $gg_event_posted_options);
		
		} else{ //verify failed:
			wp_die( __('Security Error. Try again.') );
		}//end verify nonce
	}// end isset submit

	if (!current_user_can('manage_options'))  {
    	wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	$gg_event_options = get_option( 'gg_event_options');
	
	if(!$gg_event_options){
		
		$gg_event_defaults = array();
		$gg_event_defaults['event_ui_theme'] = 'base';
		$gg_event_defaults['event_highlight_color'] = '#FFFFFF';
		$gg_event_defaults['event_highlight_text_color'] = '#000000';
		$gg_event_defaults['event_language'] = 'base';
	
		add_option( "gg_event_options", $gg_event_defaults );
		$gg_event_options = get_option( 'gg_event_options');
	}//if(!$gg_event_options)

?>

    <div class="wrap">
		<?php  $title = "Event Geek Options";  ?>
        
        <h2><?php echo $title; ?></h2>
        <hr />
        
        <?php if(isset($_POST['submit'])){?><div id="message" class="updated"><p><?php echo $title; ?> Updated.</p></div><?php } ?>

        <form id="gg_event-form" method="post">
			<?php 
                
                // Noncename needed to verify where the data originated
                echo '<input type="hidden" name="gg_event_options_noncename" id="gg_event_options_noncename" value="' .
                wp_create_nonce( 'gg_event_geek-nonce' . plugin_basename(__FILE__) ) . '" />';
                
            ?>
            <div class="gg_options_section">
                <h3>Style Options:</h3>
                
                    <p><strong>Select a style: </strong>
                    <select id="event_ui_theme" name="event_ui_theme">
                        <option value="smoothness" <?php selected($gg_event_options['event_ui_theme'], "smoothness"); ?> >Smoothness</option>
                        <option value="ui-lightness" <?php selected($gg_event_options['event_ui_theme'], "ui-lightness"); ?> >UI Lightness</option>
                        <option value="ui-darkness" <?php selected($gg_event_options['event_ui_theme'], "ui-darkness"); ?> >UI Darkness</option>
                        <option value="start" <?php selected($gg_event_options['event_ui_theme'], "start"); ?> >Start</option>
                        <option value="redmond" <?php selected($gg_event_options['event_ui_theme'], "redmond"); ?> >Redmond</option>
                        <option value="sunny" <?php selected($gg_event_options['event_ui_theme'], "sunny"); ?> >Sunny</option>
                        <option value="overcast" <?php selected($gg_event_options['event_ui_theme'], "overcast"); ?> >Overcast</option>
                        <option value="le-frog" <?php selected($gg_event_options['event_ui_theme'], "le-frog"); ?> >Le Frog</option>
                        <option value="flick" <?php selected($gg_event_options['event_ui_theme'], "flick"); ?> >Flick</option>
                        <option value="pepper-grinder" <?php selected($gg_event_options['event_ui_theme'], "pepper-grinder"); ?> >Pepper Grinder</option>
                        <option value="eggplant" <?php selected($gg_event_options['event_ui_theme'], "eggplant"); ?> >Eggplant</option>
                        <option value="dark-hive" <?php selected($gg_event_options['event_ui_theme'], "dark-hive"); ?> >Dark Hive</option>
                        <option value="cupertino" <?php selected($gg_event_options['event_ui_theme'], "cupertino"); ?> >Cupertino</option>
                        <option value="south-street" <?php selected($gg_event_options['event_ui_theme'], "south-street"); ?> >South Street</option>
                        <option value="blitzer" <?php selected($gg_event_options['event_ui_theme'], "blitzer"); ?> >Blitzer</option>
                        <option value="humanity" <?php selected($gg_event_options['event_ui_theme'], "humanity"); ?> >Humanity</option>
                        <option value="hot-sneaks" <?php selected($gg_event_options['event_ui_theme'], "hot-sneaks"); ?> >Hot Sneaks</option>
                        <option value="excite-bike" <?php selected($gg_event_options['event_ui_theme'], "excite-bike"); ?> >Excite Bike</option>
                        <option value="vader" <?php selected($gg_event_options['event_ui_theme'], "vader"); ?> >Vader</option>
                        <option value="dot-luv" <?php selected($gg_event_options['event_ui_theme'], "dot-luv"); ?> >Dot Luv</option>
                        <option value="mint-choc" <?php selected($gg_event_options['event_ui_theme'], "mint-choc"); ?> >mint-choc</option>
                        <option value="black-tie" <?php selected($gg_event_options['event_ui_theme'], "black-tie"); ?> >Black Tie</option>
                        <option value="trontastic" <?php selected($gg_event_options['event_ui_theme'], "trontastic"); ?> >Trontastic</option>
                        <option value="swanky-purse" <?php selected($gg_event_options['event_ui_theme'], "swanky-purse"); ?> >Swanky Purse</option>
                    </select>
                    <img id="gg_ui_theme_thumb" src="<?php echo plugins_url() . '/event-geek/images/' . $gg_event_options['event_ui_theme'] . '.jpg'; ?>" alt="theme preview" />
                    </p>
                        
                    <p><strong>Use your own theme (enter URL):</strong> <input type="text" name="event_custom_ui_theme" value="<?php echo $gg_event_options['event_custom_ui_theme']; ?>" /><br />
                    <a href="http://jqueryui.com/themeroller/" target="_blank">Read more about jQuery UI themes</a></p>
    
                    <?php if($gg_event_options['event_highlight_color']){$background = $gg_event_options['event_highlight_color'];} 
                    else{$background = '#ffffff';}
                    
                    if($gg_event_options['event_highlight_text_color']){$textcolor = $gg_event_options['event_highlight_text_color'];}else{$textcolor = '#000000';}
                    ?>
                    <p><strong>Event Date Background color:</strong> <input type="text" class="color_picker" id="event_highlight_color" name="event_highlight_color" value="<?php echo $background; ?>" /></p> 
                
                    
                    <p><strong>Event Date Text Color:</strong> <input type="text" id="event_highlight_text_color" class="color_picker" name="event_highlight_text_color" value="<?php echo $textcolor; ?>" /></p> 
	            </div>

				<div class="gg_options_section">
					<h3>Other Options:</h3>
				
					<p><strong>Customize Event Info? </strong>
                    <select id="customize_event_info" name="customize_event_info">
                        <option value="">No</option>
                        <option value="yes" <?php selected($gg_event_options['customize_event_info'], "yes"); ?>>Yes</option>
                    </select>
                    </p>
					<?php if($gg_event_options['customize_event_info']){ $class = '';}
							else{$class = ' class="gg_hide"'; }?>
					<div id="gg_event_info_options"<?php echo $class; ?>>
					<p><?php _e('Click and Drag to Sort', 'event_geek'); ?></p>
					<ul id="gg_event_info_boxes">
					<?php
						if(!$gg_event_options['customize_event_info'] && !$gg_event_options['custom_event_inputs']){
						$event_inputs = array(
							array('label' => __('Address', 'event_geek'), 'type' => 'text'),
							array('label' => __('Address Line 2', 'event_geek'),'type' => 'text'),
							array('label' => __('Phone', 'event_geek'),'type' => 'text'),
							array('label' => __('Web Address', 'event_geek'), 'type' => 'link')
						);
						}
						else{
						$event_inputs = array();
						$saved_inputs = $gg_event_options['custom_event_inputs'];
						$saved_types =  $gg_event_options['custom_event_types'];
						$count = 0;
						if(is_array($saved_inputs)){
							foreach($saved_inputs as $input){
								$event_inputs[] = array('label' => $input, 'type'=> $saved_types[$count]);
								$count++;
							}//foreach
						}//if(is_array($saved_inputs){	
						}//end if(!$gg_event_options['customize_event_info']){
						
						foreach($event_inputs as $box){ ?>
							<li>Label: <input name="custom_event_inputs[]" type="text" value="<?php echo $box['label']; ?>">
							Type: <select name='custom_event_types[]'>
								<option value="text">Text</option>
								<option value="link" <?php selected($box['type'],'link'); ?>>Link</option>
								<option value="email" <?php selected($box['type'],'email'); ?>>Email</option>
							</select>
							<span class="gg_delete_event_li">X</span>
							</li>
					<?php	}// foreach
					?>
					</ul>
					<button type="button" id="gg_add_event_info" />Add</button>
                    <p><?php _e('Note: Once you have saved event info using these labels, changing the labels will result in some info no longer appearing.', 'event_geek'); ?></p>
					</div><!--gg_event_info_boxes-->
					
                    <p><strong>Include link to help promote Event Geek? </strong>
                    <select  name="event_promote">
                        <option value="no" <?php selected($gg_event_options['event_promote'], "no"); ?> >No</option>
                        <option value="yes" <?php selected($gg_event_options['event_promote'], "yes"); ?> >Yes (thank you!)</option>
                    </select>
                    </p>
                </div><!--gg_options_section-->
            <?php do_action('gg_options_form'); ?>
         
            <p><input type="submit" name="submit" value="Save Settings"></p>

        </form>
	<p>Thank you for using Event Geek. For support see the <a href="http://wordpress.org/support/plugin/event-geek" target="_blank">WordPress support forum</a>, <a href="http://graphicgeek.net/contact/" target="_blank">contact Graphic Geek</a>, or <a href="http://graphicgeek.net/event-geek/" target="_blank">leave a comment here</a>.</p>
    <p>To help support the continued improvement of this plugin, please consider making a <a href="http://graphicgeek.net/donations/" target="_blank">small donation</a>. Also be sure to give it a <a href="http://wordpress.org/support/view/plugin-reviews/event-geek" target="_blank">good rating and/or review</a> :)</p>

    </div>

<?php 

}//end gg_event_options 

?>