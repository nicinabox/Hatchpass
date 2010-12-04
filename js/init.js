$(document).ready(function() {
  // Set some constants
  ID = $('#url').val();
  OPT = false;
  settingsID = getSettingsForUrl();
  s = defaultSettings(ID);
  m = self.location.pathname; // are we mobile?
//  loadUrl = "http://hatchpass.org/ajax.php";
  loadUrl = "http://"+self.location.hostname+"/ajax.php";
  
  checkUrl(ID, m);
  
  if (settingsID == ID) {
  	var hatchMaster = localStorage.getItem("hatchMaster");
  }
  if (hatchMaster) {
  	$('#r_master').attr('toggled', 'true');
  	$('#master').val(hatchMaster);
  	$('#master').next('.clearinput').show();
  	$('#host').focus();
  } else {
    $('#master').focus();
  }
  
  $('#saveUrl').click(function() {
		rememberUrl(ID, m);
	});
	
	// Update main form
	$("#master, #host").keyup(function() {
		updateSecure(ID);
	});
	
});
