<?php session_start();
include_once ('../lib/User.class.php');
$id=base64_decode($_GET["id"]);
$uid= base64_decode($_GET["uid"]);
$u = new User($uid);
if($_GET['flag']=='App'){
$a=$u->requestapproved($id);
}
if($_GET['flag']=='dis'){
$b=$u->requestdisapproved($id);}

?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script-->



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

</head>
<body>
<div id="wrapper">
<?php if($a){
?>
<h1>Request <?php echo $id;?> Approved!</h1>
<?php }else {?><h1>Request <?php echo $id;?> Not Approved!</h1><?php }?>
</div><!--wrapper ends--> 

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->

  <!--script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script-->

 

</body>
</html>
