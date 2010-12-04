$(document).ready(function() {
  $('input').keyup(function(){
    var val = $(this).val();
    if (val != "") {
     $(this).next('.clearinput').fadeIn(50); 
    } else {
      $(this).next('.clearinput').fadeOut(50); 
    }
  });
  $('.clearinput').click(function() {
    $(this).prev('input').val('').focus();
    $(this).fadeOut(50);
    $('#secure').val('');
    return false;
  });
  
  // Settings keyboard activation
	$(document).keyup(function(e) {
	  var code = e.which;
		var focusedInputs = $("input:focus");
		if (focusedInputs != null && focusedInputs.length > 0) { 
			inputHasFocus = true; 
			if (code == 27) { $(':focus').blur(); }
		} else {
			inputHasFocus = false;
			if (code == 27) { 
			  if ($('.panel').is(':visible')) {
			    $('.panel').slideUp(100);
			  }
			  if ($('#help').is(':visible')) {
		      $('#help').fadeOut('fast');
		    }
			  if ($('#master').val().length > 0) {
			    $('#host').focus();
			  } else {
			    $('#master').focus();
			  }
			}
		}				
		if (inputHasFocus != true) {
			switch(code) {
			  case 83: // s
			    showToolbar("#settings");
			    break;
			  case 85: // u
			    showToolbar("#myUrl");
			    break;
			  case 191: // foward slash
			    if ($('#help').is(':visible')) {
			      $('#help').fadeOut('fast');
			    } else {
			      $('#help').fadeIn('fast');
			    }
			    
			  default:
			    break;
			}
		}
	});
	
	// Panel activation
  $('#home .toolbar a').click(function() {
    var id = $(this).attr('href'); // activate this
    showToolbar(id);
    return false;
  });
  
  
  // Update settings
	$('#settings').click(function(){
		var mySettings = getSettings(ID);

		if (mySettings.r_master == "1") {
			rememberMaster(ID);
		} else {
			forgetMaster(ID);
			$('#master').val('');
		}
		if (mySettings.r_url == "1") {
			rememberUrl(ID);
		} else {
			forgetUrl(ID, m);
		}
		if(mySettings.r_settings == "1") { // Post to db if we are remembering settings
			$.post('/post.php',{
			 	action: "updateSettings",
				settings: mySettings
				},
				function(msg){
					console.log(msg);
			});
		} else { // Destroy settings
		//	if (settingsChanged) {
				$.post('/post.php',{
				 	action: "destroySettings",
					id: ID
					},
					function(msg){
						console.log(msg);
				});
		//	}
		}
		// These settings are specific to this url
		var settingsChanged = false;
		setSettingsForUrl(ID);
		updateSecure(ID, m);	
//		$("#settings").slideUp(100);
//		return false;
	});
	
	// Update main form
	$("#master, #host").change(function() {
		updateSecure(ID, m);
	});
	
});