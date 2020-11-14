<?php session_start();
include_once ('../lib/Manager.class.php');
if($_SESSION['user_type'] == 'Employee'){
$u = new Employee($_SESSION['user_id']);
}
else if($_SESSION['user_type'] == 'Manager'){
$u = new Manager($_SESSION['user_id']);
}

if(empty($_SESSION['user_id']))
{
header("location:login.php");
}
//$u = new User($_SESSION['user_id']);

if(!$u->isMyProfileComplete()){
header("location:profile.php");
}
if($_POST){
//print_r($_POST);
//$details = $u->travelrequestbooking($_POST);
/*function filter_callhotel($val) {
$val = trim($val);
return $val != '';
}
$pref_hotel = array_values(array_filter($_POST['pref_hotel'], 'filter_callhotel'));
if(count($pref_hotel) == 0) {
$message="Plese fill required details.Please fill Prefered hotel";
}
else
{      
$details = $u->travelrequestbooking($_POST);if($details){
$message=$details['trip_type']."Request booked sucssefully";
header("location:my-request.php");
}
}*/

$details = $u->travelrequestbooking($_POST);if($details){

$message=ucfirst($_POST['trip_type'])."   "."Request booked successfully";
header( "refresh:5;url=my-request.php" );
}

}
$cities = $u->cities();
$airlines = $u->airlinesAirlines();
$hotels = $u->hotelHotels();
$cars = $u->cars();
//print_r($_SESSION);
//Array ( [city_id] => 1416 [city_name] => Tetri Bazar [city_state] => Uttar Pradesh );?><!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]--><head>
<!--script src="//ajax.googleapis.com/ajax/
libs/jquery/1.8.1/jquery.min.js"></script-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
//multiple trip
$(document).ready(function() {
////////////
$('#travel_to').change(function(){
//var st=$('#category option:selected').text();
var id=$('#travel_to').val();

//$('#pref_hotel').empty(); //remove all existing options SKK commented this line for time being

//$('#pref_hotel').empty(); //remove all existing options

///////
$.get('ajaxDatahotellist.php',{'id':id},function(return_data){
$.each(return_data.data, function(key,value){
$("#pref_hotel").append("<option value='" + value.id +"'>"+value.hotel_name+"</option>");
});
}, "json");
///////
});
/////////////////////
});


</script>
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
<form id="travel-booking" method="post" action="" onsubmit="return confirm('Are you sure you want to submit this Hotel Booking form?');">
<div class="row cent clearfix">
<div class="in-bloc cent"><!--img src="img/hotel.png" width="50px" height="50px"alt="profile creation" /--><h1 class="in-bloc">Hotel Booking</h1><?php if(!empty($message)) { echo "<p style='color:green;'>".$message."</p>"; }?></div>
</div><input type="hidden" id="booking" name="booking" value="hotel"/>
<!-- Travel details-->
<div class="row"> <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>

<span class="f-leg"><img src="img/travel_details.png" />Provide visit details</span>
<fieldset name "travel-details">
<div class="col-2-grid"><!--label for "trip-type">Type of trip </label>
<ul class="radio"><li><input type="radio" name="trip_type" value="oneway" id="oneway" /><label for "oneway">Oneway </label></li><li><input type="radio" name="trip_type" value="round trip"  id="twoway" /> <label for "roundtrip">Round trip</label></li><li> <input type="radio" name="trip_type" value="multicity" id="multi" /> <label for "multicity">Multi city </label></li></ul-->
<!--p><label for "adv">Cost of hotel, please enter the amount</label><input type="text" id="cost" name="cost"  autofoucs /></p-->
</div>

<div class="col-2-grid clearfix">  <p><label for "tour-purpose">Purpose of visit </label>
<textarea name="purpose_of_visit" placeholder="Please mention specific purpose of visit; DO NOT mention business visit" rows="3" required></textarea></p>

</div>

<div class="col-3-grid"> 
<!--ul class="radio"><li><input type="radio" name="multiple" class="multiple" id="multiple" value="" /><label for "oneway">Add more days </label></li></ul-->
</div>
</fieldset>
</div>
<!-- Travel details end-->


<div class="row" style="display:none;">
<div class="tbBooks" id="tbBooks"> 
<!-- Destination and Departure details-->
<span class="f-leg"><img src="img/hotel.png" width="32px" height="32px"/>Hotel details</span>
<fieldset name "dest-dep">
<div class="col-3-grid">
	<p><label for "TO1">City</label><select name="travel_to[]" id="travel_to" ><option value="">City</option><?php
	foreach($cities as $citie) { ?>
	<option value="<?php echo $citie['id']; ?>"><?php echo $citie['city_name'].",".$citie['city_state']; ?></option>
	<?php }?></select></p>

	<p><label for "hotel"><span style="color:red;">*</span>Preferred hotel</label><select id="pref_hotel" class="pref_hotel" name="pref_hotel[]" autofocus  > 
	<option value="">Preferred hotel</option>
	<?php
	foreach($hotels as $hotel) { ?>
	<option value="<?php echo $hotel['id']; ?>"><?php echo $hotel['hotel_name']; ?></option>
	<?php
	} ?>
<option value="0">Others</option>
	</select><div id="divhotel" style="display: none;">Other Hotel: <input type="text" name="otherhotel[]"></div></p>
	
	<p><label for "air-co"> Room Type</label><select id="room_type" class="room_type" name="room_type[]"> 
	<option value="">Room Type</option>

	<option value="Smoking Room">Smoking Room</option>
	<option value="Non Smoking Room">Non Smoking Room</option>
	</select></p>
</div>


<div class="col-3-grid">
	<p><label for "dep-date1">Checkin Date</label>
	<input type="text" id="checkindate" name="checkindate[]" placeholder="Check in date"  /></p>
	<p><label for "dep-date1">Checkin Time</label>
	<input type="text" id="checkintime" name="checkintime[]" placeholder="Checkin Time"  /></p>
	<p><label for "dep-date1">No Of Guests</label>
	<input type="text" id="noofguests" name="noofguests[]" placeholder="No Of Guests"  /></p>

	<!--p><label for "dep-date1">Booking date </label>
	<input type="date" id="date" name="bookingdate[]" placeholder="Booking date" autofocus /></p-->

</div>

<div class="col-3-grid">

	<p><label for "dep-date1">Checkout Date</label>
	<input type="text" id="checkoutdate" name="checkoutdate[]" placeholder="Checkout date"  /></p>

	<p><label for "dep-date1">Checkout Time</label>
	<input type="text" id="checkouttime" name="checkouttime[]" placeholder="Checkout Time"  /></p>

	<p><label for "dep-date1">No Of Rooms</label>
	<input type="text" id="noofrooms" name="noofrooms[]" placeholder="No Of Rooms"  /></p>
</div>



</fieldset>
<!-- Destination and Departure details end-->

</div>  </div> 
<div id="container2" ></div> 
<div class="btn-set"> <input type="button" class="" id="btnadddd" value="ADD Booking" /></div> 

<div class="row">
<!-- additional instructions-->
 <p style="color:red;"><strong>NOTE:If hotel booking is not for your self please mention the guest name in special mention</strong></p>
       <span class="f-leg"><img src="img/note2.png" />Special mention   </span>
<fieldset name "special-notes">
<textarea name="special_mention" placeholder="Please mention any depcific requirements" rows="5" ></textarea></p>
</fieldset>

</div>
<div class="row cent"><input type="SUBMIT" value="SUBMIT" /> <?php  $type=$u->getUserType();if($type=='Employee'){?> <input type="button"value="CANCEL"onclick="javascript:window.location='emp-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><input type="button" value="CANCEL" onclick="javascript:window.location='manager-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><input type="button" value="CANCEL"onclick="javascript:window.location='travel-desk-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><input type="button" value="CANCEL" onclick="javascript:window.location='admin-board.php';"><?php }?></div>
</form>


</div>
<footer>

</footer>
</div><!--wrapper ends--> 

<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
<!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script-->
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/DateTimePicker.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function () {
	var iCnt = 1;
	$(function() {
    $('.btn-set').click();
});
	if(iCnt => 1){
		$('.btn-set').on('click', function () {
			var copy = $('#tbBooks').clone(true);
			var new_div_id = 'tbBooks'+iCnt;
			var hotel ="pref_hotel"+iCnt;//alert("#"+hotel);
			var divhotel ="divhotel"+iCnt;
			copy.attr('id', new_div_id );
			$('#container2').append(copy);
			$('#' + new_div_id).find('input,select').each(function(){
			$(this).attr('id', $(this).attr('id') + iCnt);
			});
			$('#container2').find('#divhotel').attr({id: 'divhotel'+iCnt, name: "divhotel"});
			$(document.body).on('change',"#"+hotel,function(){
				var title = $("#"+hotel+" :selected").text();//
				if (title=='Others') { //alert(title);
				$("#"+divhotel).show();
				} else {
				$("#"+divhotel).hide();
				}
			});
			$("#checkindate"+iCnt).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true; 
			$("#checkoutdate"+iCnt).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});  inline:true;
			$("#pref_hotel"+iCnt).attr('required', true); 

			iCnt++;

		});

	}
});
//round trip
$(document).ready(function() {
$('input[type="radio"]').click(function() {
if($(this).attr('id') == 'twoway') {
$('#container1').show();   
}

else {
$('#container1').hide();   
}
});
});


</script>
<script type="text/javascript">
$(function () {
$("#pref_hotel").change(function () { //alert('hiiii');
var title = $("#pref_hotel :selected").text();
if (title=='Other') { //alert(title);
$("#divhotel").show();
} else {
$("#divhotel").hide();
}
});
});


</script>
<!-- scripts concatenated and minified via build script -->
<script src="js/plugins.js"></script>
<script src="js/script.js"></script>

<!-- end scripts -->

<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
mathiasbynens.be/notes/async-analytics-snippet -->
<!--script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script-->


</body>
</html>

