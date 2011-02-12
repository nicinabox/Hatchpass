<?php
// Generate new ID on refresh
if (!isset($_GET['id'])) {
  $url = newUrl();
  $browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
  $ipod = strstr($_SERVER['HTTP_USER_AGENT'],'iPod');
  if ($browser || $ipod)  {
    header("Location: /m/".$url);
  } else {
    header("Location: /".$url);
  }
}

$uri = parse_url($_SERVER['REQUEST_URI']);
$view = $_GET['v'];

// Figure out which assets to load
switch ($uri['path']) {
  case '/m':
    $mobile = true;
    break;
  default:
    $desktop = true;
    break;
}

?>
<!docytype html>
<html manifest="/cache.manifest">
<head>
	<title>HatchPass</title>
	<link rel="icon" type="image/png" href="/favicon.png">	
	
	<script src="/jqtouch/jquery.1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/init.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/functions.js" type="text/javascript" charset="utf-8"></script>
	
	<?php if($mobile): ?>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
  	<meta name="apple-mobile-web-app-capable" content="yes" />
	
    <link rel="stylesheet" href="/css/iphone.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/jqtouch/jqtouch.min.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/themes/apple/theme.css" type="text/css" media="screen" title="no title" charset="utf-8">
  
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
	
  <?php else: ?>
    <?php if ($view == "sidebar"): ?>
      <link rel="stylesheet" href="/css/sidebar.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <?php elseif($view == "minimal"): ?>
      <link rel="stylesheet" href="/css/minimal.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <?php else: ?>
      <link rel="stylesheet" href="/css/desktop.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <?php endif ?>
    
    <script src="/js/desktop.js" type="text/javascript" charset="utf-8"></script>
  
  <?php endif ?>
  
  <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-20072687-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
</head>
<body>
  <?php  
  // Load default settings
  $sql = "SELECT * FROM settings WHERE myId = '{$_GET['id']}'";
  $result = mysql_query($sql) or die(mysql_error());
  $num = mysql_num_rows($result);
  if ($num > 0) {
    $s = mysql_fetch_object($result);
  } else {
    $s = defaultSettings($_GET['id']);
  }
    
  ?>