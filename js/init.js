$(document).ready(function() {
  // Set some constants
  ID = $('#url').val();
  OPT = false;
  settingsID = getSettingsForUrl();
  s = defaultSettings(ID);
  if (self.location.pathname == "m") {
    m = self.location.pathname; // are we mobile?
  } else {
    m = "/";
  }
  
  loadUrl = "http://"+self.location.hostname+"/ajax.php";
  
  // Remember master
  $('#master').change(function(){
		var r_master =  $("#r_master").attr('checked');
		var master = $('#master').val();
		if (parse(r_master) == "1") {
			if (master != "") {
				rememberMaster(ID);
			}
		}
	});
	
  // My url
	$('#saveUrl').attr('href', m+'?id='+ID);
	$('#loadUrl').attr('href', m+'?id='+localStorage.getItem('rememberUrl'));
	
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
	
  $('#master, #host').keyup(function(){
    if ($(this).val() == "") {
      $('#secure').val('');
    }
  });
		
});
