<?php
$browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
if ($browser == true)  {
  header("Location: http://hatchpass.org/m/");
}
?>
<?php 

// Include all the pages
require_once 'functions.php';
include 'header.php';
include 'home.php';
// include 'options.php';
// include 'settings.php';
// include 'retrieve_url.php';
include 'footer.php';

?>