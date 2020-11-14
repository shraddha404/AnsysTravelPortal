<?php session_start();
$limit = 15;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit; 
include_once ('../lib/User.class.php');
$u = new User($_SESSION['user_id']);
if(empty($_SESSION['user_id']))
{
header("location:login.php");
}


//print_r($travel_requests);
?><!DOCTYPE html>
<html>
<head><meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>Anasys Travel Portal</title>
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
<style>

input {
width:100%;
margin-bottom:20px;
padding:5px;
height:30px;
box-shadow:1px 1px 12px gray;
border-radius:3px;
border:none
}
textarea {
width:100%;
height:80px;
margin-top:10px;
padding:5px;
box-shadow:1px 1px 12px gray;
border-radius:3px
}
#send {
height: 58px;
    margin-top: 40px;
    width: 35%;
box-shadow:1px 1px 12px gray;
background-color:#cd853f;
border:1px solid #fff;
color:#fff;

font-size:18px
}
div#feedback {
text-align:center;
height:520px;
width:800px;
padding:20px 25px 20px 15px;
background-color:#f3f3f3;

float:left
}
.container {
width:960px;
height:960px;
margin:40px auto
}</style>
</head>
<body>
<div id="wrapper">
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
  <div role="main">
  <div class="in-bloc cent row"><img src="img/globe.jpg" alt="Travel-desk-view" /><h1 class="in-bloc">FeedBack Form </h1></div>
  <div class="row"><!--row begins--> <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Finance'){?><a href='Finance-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>
<?php $userdetails=$u->getUserDetails($_SESSION['user_id']);
if(isset($_POST["submit"])){
// Checking For Blank Fields..
if($_POST["vname"]==""||$_POST["vemail"]==""||$_POST["sub"]==""||$_POST["msg"]==""){
echo "<font color='red'>Fill All Fields..</font>";
}else{
// Check if the "Sender's Email" input field is filled out
$email=$_POST['vemail'];


if (!$email){
echo "<font color='red'>Invalid Sender's Email.</font>";
}
else{
$subject = $_POST['sub'];
$from_name= $userdetails['firstname'].'  '. $userdetails['lastname'];
$message.= "<html><body><b>User Name : </b>". $userdetails['firstname'].'  '. $userdetails['lastname']."<br/><br/>";
	 $message .= "<b>Phone Number : </b>".$userdetails['contact_no']."<br/><br/>";
        $message .= "<b>Email : </b>".$userdetails['email']."<br/><br/>";

$message.= "<b>Feedback Message : </b>".$_POST['msg'];

$message.= "<body><html>";
// Message lines should not exceed 70 characters (PHP rule), so wrap it
$message = wordwrap($message,200);
// Send Mail By PHP Mail Function

//if($u->sendSMTPEmail($email,$subject, $message)){
if($u->sendFeedBackMail($email,$subject, $message)){
$msg= "<font color='green'>Your mail has been sent successfuly ! Thank you for your feedback.</font>";
}else{
$msg=  "<font color='green'>Mail not sent !Please check.</font>";
}
}
}
}
?>

<div class="container">
<!-- Feedback Form Starts Here -->

<div id="feedback">
<!-- Heading Of The Form --><h3><?php echo $msg;?></h3>
<div class="head">
<h3>FeedBack Form</h3>
<p>This is feedback form. Send us your feedback !</p>
</div>
<!-- Feedback Form -->
<form action="#" id="form" method="post" name="form">
<input name="vname" placeholder="Your Name" type="text" value="<?php echo  $userdetails['firstname'].'  '. $userdetails['lastname'];?>">
<input name="vemail" placeholder="Your Email" type="text" value="<?php echo $userdetails['email'];?>">
<input name="sub" placeholder="Subject" type="text" value="">

<textarea name="msg" placeholder="Type your Suggestion/Feedback ..."></textarea>
<input id="send" name="submit" type="submit" value="Send Feedback">
</form>
</div>
</div>
<!-- Feedback Form Ends Here -->
</div>
</body>
<!-- Body Ends Here -->
</html>
