jQuery(document).ready(function($) {

// Uploading files
var file_frame;
 
  $('.gg_media_upload').click(function(event){
	  event.preventDefault();
	  
	  	var thisID = $(this).attr('ID');
		var imgID = '#gg_' + thisID + '_img';
		var idID = '#gg_' + thisID + '_id';
 
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: $( this ).data( 'uploader_title' ),
      button: {
        text: $( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
		
        $(imgID).attr('src', attachment.url); //display image
        $(idID).val(attachment.id); //send id to input
 
      // Do something with attachment.id and/or attachment.url here
    });
 
    // Finally, open the modal
    file_frame.open();
	  });

//for more info: http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/

if($('.ggdatepicker').size() > 0){ 		
	//initiate  datepicker
	$('.ggdatepicker').datepicker({
	closeText: languageoptions.closeText,
    currentText: languageoptions.currentText,
    monthNames: languageoptions.monthNames,
    monthNamesShort: languageoptions.monthNamesShort,
    dayNames: languageoptions.dayNames,
    dayNamesShort: languageoptions.dayNamesShort,
    dayNamesMin: languageoptions.dayNamesMin,
    dateFormat: languageoptions.dateFormat,
    firstDay: languageoptions.firstDay,
    isRTL: languageoptions.isRTL,
	onSelect: function ( dateText, inst) { 
		var theID = '#' + $(this).attr('id') + '_standard_format';
		var theDate = inst.selectedYear + '/' + (inst.selectedMonth+1) + '/' + inst.selectedDay;
		$(theID).val(theDate);
		console.log(theDate);
		}//onSelect
	});
}
		$('#gg_is_single_day').change(function(){
			
			if($(this).is(':checked')){
				var startDate = $('#gg_event_date_start').val();
				$('#gg_event_date_end').val(startDate);
				
			}
			
		});	
		
		$('#event_ui_theme').change(function(){
			
			var theTheme = $(this).val();
			var theURL = site_vars.plugin_directory  + '/event-geek/images/' + theTheme + '.jpg';
			$('#gg_ui_theme_thumb').attr('src', theURL);
			
		});			
	
	
if($('.color_picker').size() > 0){ 
$('.color_picker').wpColorPicker();

}

if($('#gg_event_info_boxes').size() > 0){

	$( "#gg_event_info_boxes" ).sortable();

	$('#gg_add_event_info').click(function(){
		var newLi = '<li>Label: ';
			newLi += '<input name="custom_event_inputs[]" type="text" placeholder="label" />';
			newLi += 'Type: ';
			newLi += '<select name="custom_event_types[]">';
				newLi += '<option value="text">Text</option>';
				newLi += '<option value="link">Link</option>';
				newLi += '<option value="email">Email</option>';
			newLi += '</select>';
			newLi += '<span class="gg_delete_event_li">X</span>';
		newLi += '</li>';
		$('#gg_event_info_boxes').append(newLi);
		
		$('.gg_delete_event_li').click(function(){
		 $(this).parent().fadeOut().remove();
		});
	});//$('#gg_add_event_info').click(function(){

}//if($('#gg_event_info_boxes').size()

$('.gg_delete_event_li').click(function(){
 $(this).parent().fadeOut().remove();
});

$('#customize_event_info').change(function(){
	if($(this).val() == 'yes'){
		$('#gg_event_info_options').fadeIn();
	} else {$('#gg_event_info_options').fadeOut();}
});

  
});//end doc ready
	
	


