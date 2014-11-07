jQuery(document).ready(function($) {
	var SelectedDates = new Array();

	$.each( gg_event_dates, function( key, value ) {
		var year = value.slice(0, 4);
		var month = value.slice(4,6);
		var day = value.slice(6,8);
		var theDate = new Date(year + '/' + month + '/' + day);
		
		SelectedDates[new Date(theDate)] = new Date(theDate); 

	});//$.each( gg_event_dates

	var eventAxaxLoading = $("#gg_event_window").html();

	$( ".gg_widget_calendar" ).datepicker({
	   beforeShowDay: function(date)
	   {
		  var Highlight = SelectedDates[date];
		  if (Highlight) {
			 return [true, "gg_has_event", Highlight];
		  }
		  else {
			 return [true, 'gg_no_event', ''];
		  }
	   },
		
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
	   onSelect: function ( dateText, inst ) { 
		var theDate = inst.selectedYear + '/' + (inst.selectedMonth+1) + '/' +inst.selectedDay;
		
		console.log(theDate);
		var Highlight = SelectedDates[new Date(theDate)];
		if (Highlight) {
			$("#gg_event_window").html(eventAxaxLoading);
			//if this date has an event...
			$("#gg_event_window").fadeIn();	
			var theURL = site_vars.admin_url + 'admin-ajax.php?action=gg_event_ajax';
			//load ajax content:
			$.post(
			   theURL, 
			   {
				  'action':'gg_event_ajax',
				  'clickedDate':theDate
			   }, 
			   function(result){
				
					
				$("#gg_event_window").html(result); //load
				$("html").css('overflow', 'hidden');
				var windowStartPosition= $('#gg_event_window_inner').position();
				var	outerWindowHeight = $('#gg_event_window').height()
				
				//set up scrolling---------------------------------
				$("#gg_event_window .arrow_up").click(function(){
					$('#gg_event_window_inner').stop(true,true);
					var position = $('#gg_event_window_inner').position();
			
					if(position.top != windowStartPosition.top){ $('#gg_event_window_inner').animate({bottom: '-=100'}, 500); }
				});		
				
				$("#gg_event_window .arrow_down").click(function(){
					$('#gg_event_window_inner').stop(true,true);
					var position = $('#gg_event_window_inner').position();
					
					var height = $('#gg_event_window_inner').height()-outerWindowHeight;
					var newheight = -height;
					if(position.top >= newheight){$('#gg_event_window_inner').animate({bottom: '+=100'}, 500);	}
				});

				//set up mousewheel scrolling-------------------------------------------
				$('#gg_event_window').mousewheel(function(event, delta, deltaX, deltaY) {
					
					if (deltaY > 0) {
						$('#gg_event_window_inner').stop(true,true);
						var position = $('#gg_event_window_inner').position();
						if(position.top !=windowStartPosition.top){ $('#gg_event_window_inner').animate({bottom: '-=50'}, 250); }
					} else {
						$('#gg_event_window_inner').stop(true,true);
						var position = $('#gg_event_window_inner').position();
					
						var height = $('#gg_event_window_inner').height()-outerWindowHeight;
						var newheight = -height;
						if(position.top >= newheight){$('#gg_event_window_inner').animate({bottom: '+=50'}, 500);	}
					}
				});				
				
				$(".gg_close_ajax").click(function(){
				//$("#gg_event_window").stop(true,true);	
				$("#gg_event_window").fadeOut();
				$("html").css('overflow', 'auto');
			
				});
			 
			   }
			);// end .post
		  }//end if Highlight
		}//onSelect
	});// end datepicker



});