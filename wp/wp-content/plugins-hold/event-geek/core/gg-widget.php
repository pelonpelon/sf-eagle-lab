<?php
//http://codex.wordpress.org/Widgets_API
class gg_event_widget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
	 		'gg_event_widget', // Base ID
			'Event Geek Calendar Widget', // Name
			array( 'description' => __( 'Show a Calendar of Events')) // Args
		);		
		
	}

/*--------------------------Admin Form------------------------------------------------------*/
 	public function form( $instance ) {
		// outputs the options form on admin

$title = $instance[ 'title' ];

//set default Event ID		

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>



        
		<?php 
		
	}


/*--------------------------save info------------------------------------------------------*/
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;		
	}


/*--------------------------Front End display----------------------------------------------*/
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );
		$title = $instance['title'];

 ?>
 <?php echo $before_widget; ?>

<?php echo $before_title . $title . $after_title; ?>
	
    <div class="gg_widget_calendar"></div>

<?php echo $after_widget; 	
	}

}

add_action('widgets_init', 'register_gg_widget');
function register_gg_widget() {
    register_widget('gg_event_widget');
}

?>