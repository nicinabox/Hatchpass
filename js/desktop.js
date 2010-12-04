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
  
  $('#settingsBtn').click(function(){
    if ($('#settings').is(":visible")) {
      $('#settings').slideUp(100);
    } else {
      $('#settings').slideDown(100);
    }
  });
  
  // Update settings
	$('#saveSettings').click(function(){
		var mySettings = getSettings();

		if (mySettings.r_master == "1") {
			rememberMaster(ID);
		} else {
			forgetMaster(ID);
			$('#master').val('');
		}
		if (mySettings.r_url == "1") {
			rememberUrl(ID, m);
		} else {
			forgetUrl(ID);
		}
		if(mySettings.r_settings == "1") { // Post to db if we are remembering settings
			//mySettings = getSettings(ID);
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
		updateSecure(ID);	
		$("#settings").slideUp(100);
		return false;
	});
});