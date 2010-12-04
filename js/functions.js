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
function rememberMaster(ID) {	
	if (typeof(localStorage) == undefined ) {
		console.log('Your browser does not support HTML5 localStorage. Try upgrading.');
		$.post('/post.php',{
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
function forgetMaster(ID) {
	var saved_url = getMyUrl();
	if (saved_url == ID) {
		localStorage.removeItem("hatchMaster"); //deletes the matching item from the database
		console.log("Forgot master in local storage");
	}
		
}
function getSettings(ID) {
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
   			"h_algorithm"	: algorithm,
   			"r_master"	: parse(r_master),	
   			"r_settings": parse(r_settings),
   			"r_url"		: parse(r_url)	
   		}
	return mySettings;
}
function defaultSettings(ID) {
	$.get('/ajax.php',{
		id: ID,
		action: "getDefaultSettings",
		method: "json"
	},
	 function(data){
		//console.log(data);
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
function checkUrl(ID, m) {
	var saved_url = getMyUrl();
	if (saved_url != ID && saved_url != null) {
		var answer = confirm("You have a saved URL. Would you like to load it instead?");
		if (answer) {
			window.location = "http://"+self.location.hostname+m+"?id="+saved_url;
		}
		$('#r_url').attr('checked', false);
		var msg = "Your saved URL is "+saved_url;
		$('#myUrl .my-url li').empty().append(msg);
		$('#myUrl .whitebutton').attr('href', +m+'/?id='+saved_url).show();
	} else {
		rememberUrl(ID);
		setSettingsForUrl();
	}
}
function getSettingsForUrl() {
	return localStorage.getItem("settingsID");
}
function setSettingsForUrl(ID) {
	var saved_url = getMyUrl();
	if (saved_url == ID) {
		localStorage.setItem("settingsID", ID);
	}
}
function getMyUrl() {
	return localStorage.getItem("rememberUrl");
}
function rememberUrl(ID, m) {
	var saved_url = localStorage.setItem("rememberUrl", ID);
	$('#r_url').attr('checked', true);
	var msg = "Your saved URL is "+ID;
	$('#myUrl .my-url li').empty().append(msg);
	$('#myUrl .whitebutton').attr('href', +m+'/?id='+saved_url).show();
	//$('#loadUrl').parent().hide();
	console.log(msg);
}
function forgetUrl(ID) {
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
function updateSecure(ID) {
	var master = $("#master").val();
	var host = $("#host").val();
	
	if (master != '' && host != '') {
		mySettings = getSettings(ID);
		console.log(mySettings);
		$.post('/post.php',{
			master: master, 
			host: host,
			settings: mySettings,
			action: "makeHash"
		},
		 function(data){
			$("#secure").val(data);
		});
	} else {
	  $('#secure').val('');
	}
}