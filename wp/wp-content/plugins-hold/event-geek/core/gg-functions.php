<?php
//load styles and scripts for admin
function gg_event_admin_scripts(){
	
	$thePage = $_GET['page'];
	if($thePage == 'gg_event_menu'){//register scripts for options page
		wp_enqueue_style( 'wp-color-picker' );          
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
	}

	wp_register_style( 'gg_admin_styles', plugins_url() . '/event-geek/css/admin-styles.css');
	wp_enqueue_style('gg_admin_styles');

	wp_register_script('gg_admin_script', plugins_url() . '/event-geek/js/gg-admin-script.js', array('jquery', 'wp-color-picker'));
	wp_enqueue_script('gg_admin_script');

   //localize our js
	global $post, $wp_locale;
    $languageoptions = array(
		'closeText'         => __( 'Close', 'event_geek'),
		'currentText'       => __( 'Today', 'event_geek'),
		// we must replace the text indices for the following arrays with 0-based arrays
		'monthNames'        => strip_array_indices( $wp_locale->month ),
		'monthNamesShort'   => strip_array_indices( $wp_locale->month_abbrev ),
		'dayNames'          => strip_array_indices( $wp_locale->weekday ),
		'dayNamesShort'     => strip_array_indices( $wp_locale->weekday_abbrev ),
		'dayNamesMin'       => strip_array_indices( $wp_locale->weekday_initial ),
		// the date format must be converted from PHP date tokens to js date tokens
		'dateFormat'        => date_format_php_to_js(get_option('date_format')),
		// First day of the week from WordPress general settings
		'firstDay'          => get_option( 'start_of_week' ),
		// is Right to left language? default is false
		'isRTL'             => $wp_locale->is_rtl,
    );
	
	 // Pass the array to the enqueued JS
    wp_localize_script( 'gg_admin_script', 'languageoptions', $languageoptions );

	$site_vars = array(
		'home_url' => home_url(),
		'plugin_directory' => plugins_url(),
		'admin_url' => admin_url()
	);
	
	wp_localize_script( 'gg_admin_script', 'site_vars', $site_vars );	

}
add_action( 'admin_enqueue_scripts', 'gg_event_admin_scripts' );

	//load styles and scripts for front end
function gg_event_scripts() {
	//load jquery scripts
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');

	
	//load jquery styles
	$gg_event_options = get_option( 'gg_event_options');
	if($gg_event_options['event_ui_theme']){$uiTheme = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/' .  $gg_event_options['event_ui_theme'] . '/jquery-ui.css';}
	else{$uiTheme = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css';}
	
	if($gg_event_options['event_custom_ui_theme']){$uiTheme = $gg_event_options['event_custom_ui_theme'];}; 
	
	wp_enqueue_style('jquery-style', $uiTheme);

	//load event styles
	wp_register_style( 'gg_styles', plugins_url() . '/event-geek/css/gg_event_styles.css');
	wp_enqueue_style('gg_styles');
	
	//load scripts
	$mousewheel = plugins_url() . '/event-geek/js/jquery.mousewheel.js';
    wp_deregister_script( 'mousewheel' );
    wp_register_script( 'mousewheel', $mousewheel);
    wp_enqueue_script( 'mousewheel' );	

	wp_register_script('gg_script', plugins_url() . '/event-geek/js/gg_script.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'));
	wp_enqueue_script('gg_script');	

    //localize our js
	global $post, $wp_locale;
    $languageoptions = array(
		'closeText'         => __( 'Close', 'event_geek'),
		'currentText'       => __( 'Today', 'event_geek'),
		// we must replace the text indices for the following arrays with 0-based arrays
		'monthNames'        => strip_array_indices( $wp_locale->month ),
		'monthNamesShort'   => strip_array_indices( $wp_locale->month_abbrev ),
		'dayNames'          => strip_array_indices( $wp_locale->weekday ),
		'dayNamesShort'     => strip_array_indices( $wp_locale->weekday_abbrev ),
		'dayNamesMin'       => strip_array_indices( $wp_locale->weekday_initial ),
		// the date format must be converted from PHP date tokens to js date tokens
		'dateFormat'        => date_format_php_to_js(get_option('date_format')),
		// First day of the week from WordPress general settings
		'firstDay'          => get_option( 'start_of_week' ),
		// is Right to left language? default is false
		'isRTL'             => $wp_locale->is_rtl,
    );
	
	 // Pass the array to the enqueued JS
    wp_localize_script( 'gg_script', 'languageoptions', $languageoptions );
	
	$site_vars = array(
		'home_url' => home_url(),
		'plugin_directory' => plugins_url(),
		'admin_url' => admin_url(),
		'plugin_version' => $gg_event_options['gg_event_version']
	);
	
	wp_localize_script( 'gg_script', 'site_vars', $site_vars );
	
	wp_localize_script( 'gg_script', 'gg_event_dates', gg_event_dates() );
	
}

add_action( 'wp_enqueue_scripts', 'gg_event_scripts' );


//add custom color and other custom styles
function gg_frontend_styles(){
	$gg_event_options = get_option( 'gg_event_options');
	 ?>
	<style type="text/css">
    
	.gg_widget_calendar .gg_has_event a{
	background:<?php echo $gg_event_options ['event_highlight_color']; ?>;
	color:<?php echo $gg_event_options ['event_highlight_text_color']; ?>;
	}
	
    </style>
<?php }

add_action( 'wp_head', 'gg_frontend_styles' );

//set up post type custom meta functions
function gg_get_saved_meta($names, $id){
	$return = array();
	
	if(!is_array($names)){$names = explode(",", $names);}
		
		foreach($names as $name){
			$return[$name] = get_post_meta($id, $name, true);
		}
		
	$return['gg_names'] = get_post_meta($id, 'gg_names', true);		
	return $return;
}

function gg_get_posted_meta(){
	$return = array();
	$names = $_POST['gg_names'];
	if(!is_array($names)){$names = explode(",", $names);}
		foreach($names as $name){
			$return[$name] = $_POST[$name];
		}
		
	$return['gg_names'] = $names;
	return $return;
}



//localization functions
function strip_array_indices( $ArrayToStrip ) {
    foreach( $ArrayToStrip as $objArrayItem) {
        $NewArray[] =  $objArrayItem;
    }
 
    return( $NewArray );
}

function date_format_php_to_js( $php_format ) {
    $PHP_matching_JS = array(
            // Day
            'd' => 'dd',
            'D' => 'D',
            'j' => 'd',
            'l' => 'DD',
            'N' => '',
            'S' => '',
            'w' => '',
            'z' => 'o',
            // Week
            'W' => '',
            // Month
            'F' => 'MM',
            'm' => 'mm',
            'M' => 'M',
            'n' => 'm',
            't' => '',
            // Year
            'L' => '',
            'o' => '',
            'Y' => 'yy',
            'y' => 'y',
            // Time
            'a' => '',
            'A' => '',
            'B' => '',
            'g' => '',
            'G' => '',
            'h' => '',
            'H' => '',
            'i' => '',
            's' => '',
            'u' => ''
    );

    $js_format = "";
    $escaping = false;

    for($i = 0; $i < strlen($php_format); $i++)
    {
        $char = $php_format[$i];
        if($char === '\\') // PHP date format escaping character
        {
            $i++;
            if($escaping) $js_format .= $php_format[$i];
            else $js_format .= '\'' . $php_format[$i];
            $escaping = true;
        }
        else
        {
            if($escaping) { $js_format .= "'"; $escaping = false; }
            if(isset($PHP_matching_JS[$char]))
                $js_format .= $PHP_matching_JS[$char];
            else
            {
                $js_format .= $char;
            }
        }
    }

    return $js_format;
}

function gg_event_dates(){
	global $post;
	$event_dates = array();

	$args = array(
		'post_type' => 'gg_events',
		'posts_per_page' => -1
	); 
	$gg_event_options = get_option( 'gg_event_options');//get current options
	$query = new WP_Query($args);	
		
	while ( $query->have_posts() ) { $query->the_post();
		$gg_names = get_post_meta($post->ID, 'gg_names', true); //get list of meta names
		$meta = gg_get_saved_meta($gg_names,$post->ID);// load meta data		
		$dates = explode('|', $meta['gg_event_dates']);
		foreach($dates as $date){
		if(!in_array($date, $event_dates)){$event_dates[] = $date;}
		
		}

	}wp_reset_postdata();	
	
	
	return $event_dates;
	
} //gg_event_dates

function gg_event_footer(){ ?>
	<div id="gg_event_window"><img class="ajax_loader" src="<?php echo plugins_url(); ?>/event-geek/images/ajax-loader.gif" alt="loading" /></div>
<?php }

add_action( 'wp_footer', 'gg_event_footer' );
?>