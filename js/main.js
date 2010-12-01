$(document).ready(function(){		
	// Set some constants
	var ID = $('#id').val();
	var OPT = false;
	var settingsID = getSettingsForUrl();
	var s = defaultSettings();
	
	if (settingsID == ID) {
		var hatchMaster = localStorage.getItem("hatchMaster");
	}
	if (hatchMaster) {
		$('#r_master').attr('toggled', 'true');
		$('#master').val(hatchMaster);
	}
	
	$('#otherButton.blueButton').attr('target', '_self');
	
	// Some functions	
	function parse (str) {
	  switch (str.toString().toLowerCase()) {
	    case "true":
	      return "1";
	    case "false":
	      return "0";
	    default:
	      throw new Error ("Cannot convert string: "+str);
	  }
	}
	function rememberMaster() {	
		if (typeof(localStorage) == undefined ) {
			console.log('Your browser does not support HTML5 localStorage. Try upgrading.');
			$.post('post.php',{
				action		: "rememberMaster",
				id			: ID,
			 	master		: $('#master').val()
			},
			 function(data){
			    console.log(data);
			});
		} else {
			try {
				localStorage.setItem("hatchMaster", $('#master').val());
				console.log('Remembering master in local storage');
			} catch (e) {
				if (e == QUOTA_EXCEEDED_ERR) {
					alert('Quota exceeded!'); 
				}
			}
		}
	}
	function forgetMaster() {
		var saved_url = getMyUrl();
		if (saved_url == ID) {
			localStorage.removeItem("hatchMaster"); //deletes the matching item from the database
			console.log("Forgot master in local storage");
		}
			
	}
	function getSettings() {
		var symbols = $("#symbols").is(':checked');
		var caps = $("#caps").is(':checked');
		var length =  $("#length").val();
		var algorithm = $("input[name='alt']:checked").attr('id');
		var r_master =  $("#r_master").is(':checked');
		var r_settings =  $("#r_settings").is(':checked');
		var r_url =  $("#r_url").is(':checked');

	   var mySettings = {
	   			"id"		: ID,
	   			"symbols"	: parse(symbols),
	   			"caps"		: parse(caps),
	   			"strlen"	: length,
	   			"algorithm"	: algorithm,
	   			"r_master"	: parse(r_master),	
	   			"r_settings": parse(r_settings),
	   			"r_url"		: parse(r_url)	
	   		}
		return mySettings;
	}
	function defaultSettings() {
		$.post('post.php',{
			id: ID,
			action: "getDefaultSettings",
			method: "json"
		},
		 function(data){
			console.log(data);
		});
		
	}
	function myBool(str) {
		switch (str.toString().toLowerCase()) {
		    case "1":
		      return "true";
		    case "0":
		      return "false";
		    default:
		      throw new Error ("Cannot convert int: "+str);
		  }
	}
	function setDefaults() {
		$("#symbols").attr("checked", myBool(s.symbols));
		$("#caps").attr("checked", myBool(s.caps));
		$("#length").val(s.strlen);
		$("#"+s.h_algorithm).attr("checked", true);
		$("#r_settings").attr("checked", myBool(s.r_master));
	}
	function resetSettings(changed) {
		for (var i=0; i < changed.length; i++) {
			switch (changed[i]) {
				case "symbols": case "caps": case "r_settings": case "default": case "legacy":
					$('#'+changed[i]).attr("checked", !$(changed[i]).attr('checked'));
					break;
				case "length":
					$('#'+changed[i]).val(s.strlen);
					break;
				default:
					console.log(changed[i] +"settings not found");
					break;
			}
		}
	}
	function checkUrl() {
		var saved_url = getMyUrl();
		if (saved_url != ID && saved_url != null) {
			var answer = confirm("You have a saved URL. Would you like to load it instead?");
			if (answer) {
				window.location = "http://"+self.location.hostname+"/?id="+saved_url;
			}
			$('#r_url').attr('checked', false);
			var msg = "Your saved URL is "+saved_url;
			$('#myUrl .my-url li').empty().append(msg);
			$('#myUrl .whitebutton').attr('href', '/?id='+saved_url).show();
		} else {
			rememberUrl();
			setSettingsForUrl();
		}
	}
	function getSettingsForUrl() {
		return localStorage.getItem("settingsID");
	}
	function setSettingsForUrl() {
		var saved_url = getMyUrl();
		if (saved_url == ID) {
			localStorage.setItem("settingsID", ID);
		}
	}
	function getMyUrl() {
		return localStorage.getItem("rememberUrl");
	}
	function rememberUrl() {
		var saved_url = localStorage.setItem("rememberUrl", ID);
		$('#r_url').attr('checked', true);
		var msg = "Your saved URL is "+ID;
		$('#myUrl .my-url li').empty().append(msg);
		$('#myUrl .whitebutton').attr('href', '/?id='+saved_url).show();
		//$('#loadUrl').parent().hide();
		console.log(msg);
	}
	function forgetUrl() {
		var saved_url = getMyUrl();
		if (saved_url == ID) {
			$('#r_url').attr('checked', false);
			localStorage.removeItem("rememberUrl");
			var msg = "You chosen not to remember your URL";
			$('#myUrl .my-url li').empty().append(msg);
			$('#myUrl .whitebutton').hide();
		}
		console.log(msg);
	}
	function updateSecure() {
		var id = $("#id").val();
		var master = $("#master").val();
		var host = $("#host").val();
		
		if (master != '' && host != '') {
			mySettings = getSettings();
			$.post('post.php',{
			 	id: id, 
				master: master, 
				host: host,
				settings: mySettings,
				action: "makeHash"
			},
			 function(data){
				$("#secure").val(data);
				console.log("Secure pass updated");
			});	
 		}
	}
	
	// Remember url
	// Set graybutton to current url
	$('#myUrl #saveUrl').attr('href', '/?id='+ID);
	checkUrl();
	
	$('#saveUrl').click(function() {
		rememberUrl();
	});
	
	$('#master').change(function(){
		var r_master =  $("#r_master").attr('checked');
		var master = $('#master').val();
		if (parse(r_master) == "1") {
			if (master != "") {
				rememberMaster();
			}
		}
	});
	
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
		var mySettings = getSettings();

		if (mySettings.r_master == "1") {
			rememberMaster();
		} else {
			forgetMaster();
			$('#master').val('');
		}
		if (mySettings.r_url == "1") {
			rememberUrl();
		} else {
			forgetUrl();
		}
		if(mySettings.r_settings == "1") { // Post to db if we are remembering settings
			//mySettings = getSettings();
			$.post('post.php',{
			 	action: "updateSettings",
				settings: mySettings
				},
				function(msg){
					console.log(msg);
			});
		} else { // Destroy settings
		//	if (settingsChanged) {
				$.post('post.php',{
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
		setSettingsForUrl();
		updateSecure();	
		jQT.goBack();
	});
		
	// Update main form
	$("#hatchForm #host").keyup(function() {
		updateSecure();
	});
	
	// Save phrase for retrieval
	$('#savePhrase').click(function(){
		var savephrase = $('#saveUrl_phrase').val();
		var url = ID;
		$.post("post.php", { action: "saveUrl", phrase: savephrase, url: url},
		  	function(msg) {
				alert(msg);
			});
	});	
});