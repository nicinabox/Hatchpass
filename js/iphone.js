$(document).ready(function(){		

	$('#otherButton.blueButton').attr('target', '_self');
	
	// Check if settings changed
	var changed = [];
	$('#settings input').change(function() {
		changed.push($(this).attr('id'));
	});
	
	$('#cancelSettings').click(function() {
		console.log(changed);
		resetSettings(changed);
	});
	
	// Update settings
	$('#saveSettings').click(function(){
		var mySettings = getSettings(ID);

		if (mySettings.r_master == "1") {
			rememberMaster(ID);
		} else {
			forgetMaster(ID);
			$('#master').val('');
		}
		if (mySettings.r_url == "1") {
			rememberUrl(ID, m);
		} else {
			forgetUrl(ID, m);
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
		jQT.goBack();
	});
	
	// Update main form
	$("#master, #host").keyup(function() {
		updateSecure(ID);
	});
	
});