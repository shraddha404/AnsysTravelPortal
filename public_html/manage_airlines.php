<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
$u = new Admin($_SESSION['user_id']);
if(!empty($_POST)){
	if($_POST['action'] == 'DELETE'){
		$u->deleteAirline($_POST['id']);
	}
	else if($_POST['action'] == 'UPDATE'){
		$u->updateAirline($_POST);
	}
	else{
	$u->addAirline($_POST);
	}
}
if(!empty($_GET['id'])){
	$selection = $u->getAirlineDetails($_GET['id']);
}
$airlines=$u->getAirline();
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
<?php include 'include/admin_menu.php'; ?>
  <div role="main">
  <form id="profile" method="post" action="/manage_airlines.php">
  	<div class="row cent">
	    <div class="in-bloc cent">
		<h1 class="in-bloc">Manage Airlines</h1></div>
        </div>
    <div class="row">
<h3 align='right'><p style='color:green;'>
	<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
	<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
	<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
	<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
	&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p>
	</h3>
    <span class="f-leg"><img src="img/user32.png" />Add Airline</span>
    <fieldset name "personal-info">
         <div class="col-3-grid"><p><label for "fname">Airline</label>
           <input type="text" id="fname" name="name" placeholder="Name of the Airline" tabindex="1" value="<?php echo $selection['name']; ?>" autofocus /></p>
          	<p><label for "bunit">Type</label>
           	<input type="radio" id="bunit" name="type" value="D" <?php if($selection['type']=='D') echo 'checked'; ?>/>Domestic
           	<input type="radio" id="bunit" name="type" value="I" <?php if($selection['type']=='I') echo 'checked'; ?>/>International
		</p>
         </div>
     </fieldset>
    </div>
    <!-- Personal Login details end-->
    <!-- Passport details-->
    <div class="row clearfix">
      <div class="row">
    <div class="row cent">
	<?php if(!empty($_GET['id'])){ ?>
	<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
	<input type="hidden" name="action" value="UPDATE" />
	<input type="SUBMIT" value="UPDATE" />
	<?php } else { ?>
	<input type="SUBMIT" value="ADD" />
	<?php } ?>
    </div>
 </form>
	
<table class="resp">
	<thead>
	</thead>
	<tr>
	<th>Airline</th>
	<th>Type</th>
	<th>Action</th>
	</tr>
	<tbody>
	<?php foreach($airlines as $a){ ?>
	<tr>
		<td data-th="Airline"><?php echo $a['name']; ?></td>
		<td data-th="Type"><?php echo $a['type']; ?></td>
		<td data-th="Action" align="center">
		<form method="post" action="/manage_airlines.php">
		<input type="hidden" name="id" value="<?php echo $a['id']; ?>" />
		<input type="submit" name="action" value="DELETE" />
		<a href="/manage_airlines.php?action=update&id=<?php echo $a['id']; ?>"><input type="button" name="action" value="UPDATE" /></a>
		</form>
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>
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
