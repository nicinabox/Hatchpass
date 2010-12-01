<?php
require 'functions.php';
if ($_POST['action'] == "updateSettings") {
  $s = $_POST['settings'];
  // Check to see if settings already saved
  $result = mysql_query("SELECT myId FROM settings WHERE myId = '{$s['id']}'");
  if (mysql_num_rows($result) > 0) { // Update
    $sql = "UPDATE settings SET symbols = '{$s['symbols']}', caps = '{$s['caps']}', strlen = '{$s['strlen']}', h_algorithm = '{$s['algorithm']}', r_settings = '{$s['r_settings']}' WHERE myId = '{$s['id']}'";
  } else { // new settings
    $sql = "INSERT INTO settings (myId, symbols, caps, strlen, h_algorithm, r_settings) VALUES ('{$s['id']}', '{$s['symbols']}', '{$s['caps']}', '{$s['strlen']}', '{$s['algorithm']}', '{$s['r_settings']}')";
    
  }
  echo "Settings saved.";
  mysql_query($sql) or die(mysql_error().": ".$sql);
}

if ($_POST['action'] == "destroySettings") {
  $sql = "DELETE FROM settings WHERE myId = '{$_POST['id']}'";
  mysql_query($sql) or die(mysql_result());
  echo "Settings destroyed.";
}

if ($_POST['action'] == "rememberMaster") {
  $master = $_POST['master'];
//  setcookie("hatchMaster", $master, time()+2629743); // Remember for 1 month
  echo "Remembering master.";
}

if ($_POST['action'] == "forgetMaster") {
  setcookie("hatchMaster");
  echo "Forgot master.";
}

if ($_POST['action'] == "makeHash") {
	$master = $_POST['master'];
	$host = strtolower($_POST['host']);
	$s = $_POST['settings'];

	// Select algorithm
	$alg = $s['algorithm']."Hash";
	
	// Create the new password
	$out = $alg($master, $host, $s);	
	echo $out;
}

if ($_POST['action'] == "getDefaultSettings") {
  echo defaultSettings($_POST['id'], $_POST['method']);
}
?>