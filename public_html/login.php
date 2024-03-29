<?php session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
$u = new User();
if(!empty($_POST)){
        $loginname = $_POST['loginname'];
        $password = $_POST['password'];
        if(!empty($_POST['loginname']) && $u->authenticate($loginname,$password)){
                $_SESSION['user_id']=$u->user_id;
                $user_details = $u->getUserDetails($u->user_id);
                $_SESSION['location'] = $user_details['location'];
		//echo $u->user_type;
		$user_type = $u->getUserType();
		$_SESSION['user_type'] = $user_type;

		if($user_type == 'Employee'){
                header("Location:emp-board.php");
		}elseif($user_type == 'Travel Desk'){
                header("Location:travel-desk-board.php");
		}elseif($user_type == 'Manager'){
                header("Location:manager-board.php");
		}elseif($user_type == 'Admin'){
                header("Location:admin-board.php");
		}elseif($user_type == 'Finance'){
                header("Location:Finance-board.php");
                }
        }
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
</head>
<body>
<div id="wrapper">
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
  <div role="main">
  <form id="profile" method="post" action="">
  	<div class="row cent">
	    <div class="in-bloc cent"><!--img src="img/person.jpg" alt="profile creation" /--><h1 class="in-bloc">Login Form</h1></div>
        </div>
    <!-- Personal Login details-->
    <div class="row">
    <span class="f-leg"><img src="img/user32.png" />Login </span>
    <fieldset name "personal-info">
         <div class="col-3-grid"><p><label for "fname">Username</label>
           <input type="text" id="fname" name="loginname" placeholder="User Name" tabindex="1" autofocus /></p>
          	<p><label for "bunit">Password</label>
           	<input type="password" id="bunit" name="password" placeholder="Password" tabindex="4"autofocus /></p>
         </div>
     </fieldset>
    </div>
    <!-- Personal Login details end-->
    <!-- Passport details-->
    <div class="row clearfix">
      <div class="row">
    <div class="row cent"><input type="SUBMIT" value="SUBMIT" /></div>
 </form>
  </div>
  <footer>

  </footer>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via build script -->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <!-- end scripts -->

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  </div><!--wrapper ends--> 
</body>
</html>
