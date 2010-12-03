<?php
// Generate new ID on refresh
if (!isset($_GET['id']) || $_GET['action'] == "newUrl") {
  $url = newUrl();
  header("Location: /?id=".$url);
}
$uri = parse_url($_SERVER['REQUEST_URI']);
?>
<!docytype html>
<html manifest="/cache.manifest">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<title>HatchPass</title>
	
	<link rel="icon" type="image/png" href="/favicon.png">	
	
	<?php if($uri['path'] != "/"): ?>
  <link rel="stylesheet" href="/jqtouch/jqtouch.min.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="/themes/apple/theme.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <?php else: ?>
  <link rel="stylesheet" href="/css/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <?php endif ?>
  
	<script src="/jqtouch/jquery.1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
	
	<?php if($uri['path'] != "/"): ?>
	<script src="/jqtouch/jqtouch.js" type="application/x-javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
	  var jQT = new $.jQTouch({
        icon: '/apple-touch-icon.png',
        addGlossToIcon: false,
        startupScreen: 'jqt_startup.png',
        statusBar: 'black',
        preloadImages: [
            // '/themes/apple/img/back_button.png',
            // '/themes/apple/img/back_button_clicked.png',
            // '/themes/apple/img/button_clicked.png',
            '/themes/apple/img/on_off.png',
            '/themes/apple/img/grayButton.png',
            '/themes/apple/img/whiteButton.png',
            '/themes/apple/img/loading.gif'
            ]
    });
	</script>
	<script src="/js/iphone.js" type="text/javascript" charset="utf-8"></script>
	<?php endif; ?>
</head>
<body>
  <?php  
  $sql = "SELECT * FROM settings WHERE myId = '{$_GET['id']}'";
  $result = mysql_query($sql) or die(mysql_error());
  $num = mysql_num_rows($result);
  if ($num > 0) {
    $s = mysql_fetch_object($result);
  } else {
    $s = defaultSettings($_GET['id']);
  }
    
  ?>