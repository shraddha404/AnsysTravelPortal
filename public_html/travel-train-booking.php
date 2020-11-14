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

	$details = $u->travelrequestbooking($_POST);if($details){

$message=ucfirst($_POST['trip_type'])."   "."Request booked successfully";
header( "refresh:5;url=my-request.php" );

}
}
$cities = $u->cities();
$airlines = $u->airlines();
$hotels = $u->hotels();
$cars = $u->cars();
$user=$u->getuserdetails($_SESSION['user_id']);
$city=$u->getcity($user['city']);
$employee_age = $u->getEmployeeAge($user['dob']);
//echo $employee_age['age'];

//print_r($_SESSION);
//Array ( [city_id] => 1416 [city_name] => Tetri Bazar [city_state] => Uttar Pradesh );?><!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]--><head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

<script>
//multiple trip
$(document).ready(function() {
////////////
$('#travel_to').change(function(){
//var st=$('#category option:selected').text();
var id=$('#travel_to').val();
$('#pref_hotel').empty(); //remove all existing options
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
<form id="travel-booking" method="post" action="" onsubmit="return confirm('Are you sure you want to submit this Train Booking form?');">
<div class="row cent clearfix">
<div class="in-bloc cent"><!--img src="img/train.png" width="50px" height=50px" alt="profile creation" /--><h1 class="in-bloc">Train Booking</h1><?php if(!empty($message)) { echo "<p style='color:green;'>".$message."</p>"; }?></div>
</div><input type="hidden" id="booking" name="booking" value="train"/>
<!-- Travel details-->
<div class="row"> <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>






<span class="f-leg"><img src="img/travel_details.png" />Provide visit details</span>
<fieldset name "travel-details">
<div class="col-2-grid"></div>

<div class="col-2-grid clearfix">  <p><label for "tour-purpose">Purpose of visit </label>
<textarea name="purpose_of_visit" placeholder="Please mention specific purpose of visit; DO NOT mention business visit" rows="3" required></textarea></p>
</div>


</fieldset>
</div>
<!-- Travel details end-->


<div class="row" style="display:none;">
<div class="tbBooks" id="tbBooks"> 
<!-- Destination and Departure details-->
<span class="f-leg"><img src="img/train.png" width="32px" height="32px"/>Train details</span>
<fieldset name "dest-dep">
<div class="col-3-grid"> 
<p><label for "from1" name="onwardcity" ><span style="color:red;">*</span>From City</label>
<select name="onwardcity[]" id="onward_citytrain"><option value=""><!--list to be populated dynamically-->From City</option>

<?php
foreach($cities as $citie) { ?>
<option value="<?php echo $citie['id']; ?>" <?php if($citie['id']==$onwardcity[0]) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state']; ?></option>
<?php
} ?><option value="0">Others</option> 
</select> <div id="divonwardcity" style="display:none;">Other City:<input type="text" name="otheronwardcity[]"></div></p>
<p><label for "TO1" name="travel_to" ><span style="color:red;">*</span>To City</label><select name="travel_to[]" id="traveltotrain"><option value="">To City</option><?php
foreach($cities as $citie) { ?>
<option value="<?php echo $citie['id']; ?>"<?php if($citie['id']==$travel_to[0]) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state']; ?></option>
<?php
} ?><option value="0">Others</option>  </select><div id="divtravelto" style="display:none;">Other City:<input type="text" name="othertravel_to[]"></div></p></div>
<div class="col-3-grid">
<p><label for "air-co">Date</label><input type="text" id="date" name="date[]" ></p>
<p><label for "car-co"><span style="color:red;">*</span>Preferred train</label><input type="text" name="train[]" id="train" autofocus >
<p><label for "car-co"><span style="color:red;">*</span>Age</label><input type="text" name="age[]" id="age" value="<?php echo $employee_age['age'];?>" autofocus ></p>
</div>

<div class="col-3-grid"> 
<p><label for "air-co">Class</label>
<select name="class[]" id="class" class="class">
<option value="">Select Class</option>
<option value="SL" <?php if($_POST['class']=='SL') {echo "selected='selected'";}?>>SL - Sleeper class</option>
<option value="1A" <?php if($_POST['class']=='1A') {echo "selected='selected'";}?>>1A - The First class AC</option>
<option value="2A" <?php if($_POST['class']=='2A') {echo "selected='selected'";}?>>2A - AC-Two tier</option>
<option value="3A" <?php if($_POST['class']=='3A') {echo "selected='selected'";}?>>3A - AC three tier</option>
<option value="2S" <?php if($_POST['class']=='2S') {echo "selected='selected'";}?>>2S - Seater class</option>
<option value="CC" <?php if($_POST['class']=='CC') {echo "selected='selected'";}?>>CC - AC chair cars</option>
</select>

</p>
<p><label for "air-co">Boarding from</label><input type="text" name="boarding_form[]" value=""></p>
</div></div></div> 

<!--/div--> 
<div id="container2"></div> 
<div class="btn-set"> <input type="button" class="" value="ADD Booking" /></div> 
<div class="row">
<!-- additional instructions-->
<span class="f-leg"><img src="img/note2.png" />Special mention</span>
<fieldset name "special-notes">
<textarea name="special_mention" placeholder="Please mention any depcific requirements" rows="5" ></textarea></p>
</fieldset>

</div>
<div class="row cent"><input type="SUBMIT" value="SUBMIT" /><?php  $type=$u->getUserType();if($type=='Employee'){?> <input type="button"value="CANCEL"onclick="javascript:window.location='emp-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><input type="button" value="CANCEL" onclick="javascript:window.location='manager-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><input type="button" value="CANCEL"onclick="javascript:window.location='travel-desk-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><input type="button" value="CANCEL" onclick="javascript:window.location='admin-board.php';"><?php }?></div>
</form>


</div>
<footer>

</footer>
</div><!--wrapper ends--> 

<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline>

<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script -->
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
			copy.attr('id', new_div_id );
			$('#container2').append(copy);
			$('#container2').find('#divonwardcity').attr({id: 'divonwardcity'+iCnt, name: "divonwardcity"});
			$('#container2').find('#divtravelto').attr({id: 'divtravelto'+iCnt, name: "divtravelto"});
			$('#' + new_div_id).find('input,select').each(function(){
			    $(this).attr('id', $(this).attr('id') + iCnt);
			 });

			$("#date"+iCnt).datepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
			$("#onward_citytrain"+iCnt).attr('required', true); 		
			$("#traveltotrain"+iCnt).attr('required', true); 
			$("#train"+iCnt).attr('required', true); 		
			$("#age"+iCnt).attr('required', true); 
			var divonwardcity ="divonwardcity"+iCnt;
			var divtravelto ="divtravelto"+iCnt;
			var onwardcity ="onward_citytrain"+iCnt;// alert("#"+hotel);
			var travel_to ="traveltotrain"+iCnt;

			$(document.body).on('change',"#"+onwardcity,function(){
	
				var title = $("#"+onwardcity+" :selected").text();//alert(divhotel);
				if (title=='Others') { 
				$("#"+divonwardcity).show();
				} else {
				$("#"+divonwardcity).hide();
				}
			});

			$(document.body).on('change',"#"+travel_to,function(){
	
				var title = $("#"+travel_to +" :selected").text();//alert(divhotel);
				if (title=='Others') { 
				$("#"+divtravelto).show();
				} else {
				$("#"+divtravelto).hide();
				}
			});
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

$(function () {
	$("#onward_cityround").change(function () { //alert('hiiii');
		var title = $("#onward_cityround :selected").text();
		if (title=='Others') { //alert(title);
		$("#divonwardcityround").show();
		} else {
		$("#divonwardcityround").hide();
		}
	});
}); 
$(function () {
	$("#traveltoround").change(function () { //alert('hiiii');
		var title = $("#traveltoround :selected").text();
		if (title=='Others') { //alert(title);
		$("#divtraveltoround").show();
		} else {
		$("#divtraveltoround").hide();
		}
	});
}); 
</script>

<!-- scripts concatenated and minified via build script -->
<script src="js/plugins.js"></script>
<script src="js/script.js"></script>
<!-- end scripts -->

<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
mathiasbynens.be/notes/async-analytics-snippet>
<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script >
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script-->
<script type="text/javascript">  
$(document).ready(function() {                                       
$("#onwardcity").live("change", function() {
$("#pickupcity").val($(this).find("option:selected").text());
$("#myselect :selected").text();

})
});                                     
</script>


</body>
</html>


