<?php
require_once 'functions.php';

if ($_GET['action'] == "makeHash") {
  $master = $_GET['master'];
	$host = strtolower($_GET['host']);
	$s = $_GET['settings'];

	// Select algorithm
	$alg = $s['h_algorithm']."Hash";

	// Create the new password
	$out = $alg($master, $host, $s);	
	echo $out;
}
if ($_GET['action'] == "getDefaultSettings") {
//  print_r($_GET);
  echo defaultSettings($_GET['id'], $_GET['method']);
}
?>