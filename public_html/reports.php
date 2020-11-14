<?php
session_start();
 if($_SESSION['user_type'] == 'Admin'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
$u = new Admin($_SESSION['user_id']);
 }
else if($_SESSION['user_type'] == 'Finance'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Finance.class.php';
$u = new Finance($_SESSION['user_id']);
}
else if($_SESSION['user_type'] == 'Manager'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Manager.class.php';
$u = new Manager($_SESSION['user_id']);
}
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->


<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">

  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <link rel="stylesheet" href="css/style.css">

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except this Modernizr build.
       Modernizr enables HTML5 elements & feature detects for optimal performance.
       Create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="js/libs/modernizr-2.5.3.min.js"></script>
  <script src="js/libs/jquery-1.7.1.min.js"></script>
</head>
<body>
<div id="wrapper">
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
 <div role="main">
     <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Finance'){?><a href='Finance-board.php'>Dashboard</a><?php }?>

&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>

  <div id="menuinc"></div>
      <div class="row">
         <div id="login-box">
		<span class="f-leg"><img src="img/mgr.png" />Reports</span>
            <div class="db-btn-set">
              <a href="travel-requests-received-report.php">Travel Request Received Report</a>
              <a href="date-wise-travel-plan-report.php">Date Wise Travel Plan Report</a>
              <a href="travel_requests_received_basicreport.php">Basic Travel Plan Report</a>
               <a href='logout.php'>Logout</a>

         </div><!-- db-btn-set ends-->
         </div><!-- login-box ends-->
      </div><!-- row ends-->
  </div><!--main div ends-->
  <footer>

  </footer>
</div><!--wrapper ends--> 


  
  

  <!-- scripts concatenated and minified via build script -->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <script src="js/menu.js"></script>  <!-- end scripts -->

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  
  
</body>
</html>
