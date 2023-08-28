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

if(!$u->isMyProfileComplete()){
 header("location:profile.php");
} 
if($_POST){
//print_r( $_POST['late_checkinoneway']);exit;
$message= " ";

$details = $u->travelrequestbooking($_POST);
if($details){
$message=ucfirst($_POST['trip_type'])."  "."Request booked successfully";
header( "refresh:5;url=my-request.php" );
//header("location:my-request.php");
}

}
$cities = $u->cities();
$airlines = $u->airlinesAirlines();
$hotels = $u->hotelHotels();
$cars = $u->cars();
?><!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script-->




<script>




//multiple trip
$(document).ready(function() {
////////////
$('#travel_to').change(function(){
//var st=$('#category option:selected').text();
var id=$('#travel_to').val();
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

/*
$(function () {
            $("input[name='trip_type']").click(function () {
                if ($("#twoway").is(":checked")) {
                    $("#dvPassport2").show();
                } else {
                    $("#dvPassport2").hide();
                }
            });
        });

*/

$(function () {
            $("input[name='longer_journey']").click(function () {
		const input_report = document.getElementById('longer_journey_report');
                if ($("#longer_journey").is(":checked")) {
                    $("#manager_approval_report").show();
		    input_report.setAttribute('required',''); 
                } else {
                    $("#manager_approval_report").hide();
		    input_report.removeAttribute('required'); 
                }
            });
});
$(document).ready(function() {
//$("form input:radio").change(function () {
//$('input[type="radio"]').click(function() {
//$(".rg").change(function () {
$("input[name='trip_type']:radio").change(function () {

if($(this).attr('id') == 'twoway') {  //alert("hiiiiiiiiiiiiroudtrip");
//alert("skktwoway");
}       
else if($(this).attr('id') == 'multi') { //alert("hiiiiiiiiiiiimulty");
//alert("skkmultiway");
}       
else if($(this).attr('id') == 'oneway') { //alert("hiiiiiiiiiiiioneway");
//alert("skkoneway");
//alert($("#onward_cityoneway").attr('id'));
$("#onward_cityoneway").attr('required',true);
}

});
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
<form id="travel-booking" method="post" action=""  onsubmit="return confirm('Are you sure you want to submit this Airline Booking form?');" enctype="multipart/form-data">
<div class="row cent clearfix">
<!---------------------------------------------------------------Main Travel details Start---------------------------------------------------------------------------------------------->
<div class="in-bloc cent"><!--img src="img/bag.jpg" alt="profile creation" /--><h1 class="in-bloc">Travel Booking</h1>
	<?php if(!empty($message)) { echo "<p style='color:green;'>".$message."</p>"; }?></div>
	</div><input type="hidden" id="booking" name="booking" value="air"/>
	<!-- Travel details-->
	<div class="row">

	<h3 align='right'><p style='color:green;'>
	<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
	<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
	<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
	<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
	&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p>
	</h3>

	<span style="color:red;">*<?php echo 'Please fill mandatory fields.';?></span>

	<span class="f-leg"><img src="img/travel_details.png" />Provide travel details</span>

	<fieldset name "travel-details">
	<div class="col-2-grid"><label for "trip-type">Type of trip </label>

<ul class="radio">
<li><input class='rg' type="radio" name="trip_type" value="oneway" id="oneway" checked="checked" <?php if($_POST['trip_type']=='oneway'){ echo "checked='checked'";} else if($_POST['trip_type']==' '){ echo "checked='checked'";} ?>/>
<label for "oneway">Oneway </label>
</li>
<li><input class='rg' type="radio" name="trip_type" value="round trip"  id="twoway" <?php if($_POST['trip_type']=='round trip'){ echo "checked='checked'";}?>/>
 <label for "roundtrip">Round trip</label>
</li>
<li> <input class='rg' type="radio" name="trip_type" value="multicity" id="multi" <?php if($_POST['trip_type']=='multicity'){ echo "checked='checked'";}?>/> 
<label for "multicity">Multi city </label>
</li>
</ul>
	
<p><label for "adv">If cash advance required, please enter the amount</label><input type="text" id="cash_adv" name="cash_adv" placeholder="Cash advance amount" value="<?php echo $_POST['cash_adv']; ?>" autofoucs />
	</div>

	<div class="col-2-grid clearfix">
	<p><label for "tour-purpose"><span style="color:red;">*</span> Purpose of visit </label>
	<br/>
	<select name="purpose_of_visit" required>
		<option value="">Select purpose of visit</option>
		<option value="Annual Sales Conference">Annual Sales Conference</option>
		<option value="Approved Business Relocation">Approved Business Relocation</option>
		<option value="Consulting Project">Consulting Project</option>
		<option value="Customer Meeting">Customer Meeting</option>
		<option value="Customer Training">Customer Training</option>
		<option value="Employee Training">Employee Training</option>
		<option value="Internal Staff Meeting">Internal Staff Meeting</option>
		<option value="Investor Relation">Investor Relation</option>
		<option value="Marketing Event/ UGM">Marketing Event/ UGM</option>
		<option value="President Club">President Club</option>
		<option value="Vendor Meeting">Vendor Meeting</option>
		<option value="Mergers & Acquisition">Mergers & Acquisition</option>
		<option value="Recruiting">Recruiting</option>
	</select>
	</p>
	<!--
	<textarea name="purpose_of_visit" placeholder="Please mention specific purpose of visit; DO NOT mention business visit" rows="3" required><?php echo $_POST['purpose_of_visit']; ?></textarea>
	-->
	</div>
	<!--div class="col-4-grid clearfix"><p><label for "longer-journey">Upload BU budget holder approval?</label-->
	<div class="col-4-grid clearfix"><p><label for "longer-journey">Is your flight duration more than 7 hrs?</label>
        <ul class="radio">
        <li><input class='rg' type="radio" name="longer_journey" value="1" id="longer_journey" required<?php if($_POST['longer_journey']=='1'){ echo "checked='checked'";}?>/><label for "yes">Yes</label>
        </li>
        <li>
        <input class='rg' type="radio" name="longer_journey" value="0" id="longer_journey" required<?php if($_POST['longer_journey']=='0'){ echo "checked='checked'";}?>/><label for "no">No</label>
        </li>
        </ul>
        </div>
        <div class="col-2-grid clearfix" id="manager_approval_report" style="display:none;">
                <p><label>Upload BU budget holder approval report</label> <input type="file" name="manager_approval_report" id="longer_journey_report"></p>
        </div>

	</fieldset>
</div>
<!---------------------------------------------------------------Main Travel details end--------------------------------------------------------------------------------------------------->



<!--------------------------------------------------------Onewaydiv Destination and departure details Start---------------------------------------------------------------------------->
<div class="row">
<div class="onewaydiv" id="onewaydiv" style="display:block;"> 
<!-- Destination and Departure details-->
<span class="f-leg"><img src="img/destination2.png" />Destination and departure details</span>
<fieldset name "dest-dep">
<div class="col-3-grid"><p><label for "from1" name="onwardcity" ><span style="color:red;">*</span> From City</label>
<select name="onwardcityoneway[]" id="onward_cityoneway"><option value=""><!--list to be populated dynamically-->From City</option>

<?php 
foreach($cities as $citie) { ?>
<option value="<?php echo $citie['id']; ?>" <?php if($citie['id']==$onwardcity[0]) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state']; ?></option>
<?php
} ?><option value="0">Others</option>
</select> <div id="divonwardcity" style="display:none;">Other City:<input type="text" name="otheronwardcityoneway[]"></div></p>
<p><label for "TO1" name="travel_to" ><span style="color:red;">*</span> To City</label><select name="travel_tooneway[]" id="traveltooneway" onChange="getHotel(this.value);"><option value="">To City</option><?php
foreach($cities as $citie) { ?>
<option value="<?php echo $citie['id']; ?>"<?php if($citie['id']==$travel_to[0]) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state'];?></option>
<?php
} ?><option value="0">Others</option> </select>
<div id="divtravelto" style="display:none;">Other City:<input type="text" name="othertravel_tooneway[]"></div></p>
<p><label for "dep-date1">Departure Date</label>
<input type="text" id="datedepartureoneway" name="dateoneway[]" value="<?php echo $date[0];?>" placeholder="Departure date dd-mm-yy" autofocus/>

<p><label for "air-co">Select Preferred Airlines</label>
<select name="book_airlineoneway[]" id="book_airlineoneway" class="book_airlineoneway"> <option value="">Select preferred Airlines</option>
<?php
foreach($airlines as $airline) { ?>
<option value="<?php echo $airline['id']; ?>" <?php if($airline['id']==$book_airline[0]) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>
<?php
} ?>

<option value="0">Others</option>
</select> <div id="divaironeway" style="display:none;">Other Airline:<input type="text" name="otheraironeway[]"></div>
</p>

<p><label for "air-pickup">Preferred Flight Time</label>
<input type="text" id="preferred_airline_time" name="preferred_airline_timeoneway[]"  /></p>

</div>
<div class="col-3-grid"><p><strong>Hotel Booking</strong></p>
<p><label for "dep-date1">Check in date</label>
<input type="text" id="datelchkinoneway" name="late_checkin_dateoneway[]"  value="" placeholder="Check in date dd-mm-yy hh:mm"  /><br/>
</p>
<p><label for "air-co"> Check in time</label>
    <input type="text" id="checkintime" name="late_checkinoneway[]" placeholder="hh:mm"  />
    
    <!--<input type="checkbox" name="late_checkinoneway[]" value="yes" <?php //if($late_checkin[0]=='yes'){echo "checked='checked'"; }?>>--></p>
<p><label for "air-co">Flight Meal preference</label><input type="text" name="meal_preferenceoneway[]" value=""></p>
</div>

<div class="col-3-grid"><p><strong><br/></strong></p>
<p><label for "dep-date1">Check out date</label>
<input type="text" id="datelchkoutoneway" name="late_checkout_dateoneway[]" value="<?php echo $late_checkout_date[0]; ?>" placeholder="Check out date dd-mm-yy hh:mm" autofocus />
<!--label for "air-co">Check in time</label>
<input type="time"  id="time" name="checkouttime[]" placeholder="hh:mm" autofocus /-->
</p>
<p><label for "air-co"> Check out time</label><input type="text"  id="time" name="late_checkoutoneway[]" placeholder="hh:mm" >
    <!--<input type="checkbox" name="late_checkoutoneway[]" value="yes" <?php //if($late_checkout[0]=='yes'){echo "checked='checked'"; }?>>--></p>


<p><label for "hotel"> Preferred hotel in the city</label>



<select id="pref_hoteloneway" class="pref_hoteloneway" name="pref_hoteloneway[]"> 
<!--option value="">Preferred hotel in the city</option>
<?php
foreach($hotels as $hotel) { ?>
<option value="<?php echo $hotel['id']; ?>" <?php if($hotel['id']==$pref_hotel[0]) {echo "selected='selected'";}?>><?php echo $hotel['hotel_name']; ?></option>
<?php
} ?>
<option value="0">Others</option-->


        <option selected="selected">--Select Hotels--</option>



</select><div id="divhoteloneway" style="display: none">Other Hotel: <input type="text" name="otherhoteloneway[]"></div></p>

</fieldset>
<span class="f-leg"><img src="img/car.png" width="32px" height="32px"/>Car Booking</span>

<fieldset name "dest-dep">
<div class="col-3-grid">
<p><input type="checkbox" name="airport_droponeway[]" value="yes" <?php if($airport_drop[0]=='yes'){echo "checked='checked'"; }?>> <label for "air-co">Need Airport drop</label>&nbsp;</p>
<p><input type="checkbox" name="airport_pickuponeway[]" <?php if($airport_pickup[0]=='yes'){echo "checked='checked'"; }?> value="yes"> <label for "air-co">Need Airport pick up</label>&nbsp;</p>
<p><label for "air-co"> Multiple days booking</label><input type="checkbox" name="need_caroneway[]" value="yes" <?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p>
<p><label for "car-co">Select preferred car vendor co.</label><select name="car_companyoneway[]" id="car_company" class="car_company">
<option value="">Select preferred car vendor co.</option>
<?php
foreach($cars as $car) { ?>
<option value="<?php echo $car['id']; ?>" <?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
<?php
} ?>
</select> </p>
</div>
<div class="col-3-grid">
<p><label for "air-pickup">Pickup address</label><input type="text" id="airport_pickup_loca" name="airport_pickup_locaoneway[]" value="<?php echo $_POST['airport_pickup_loca']; ?>" placeholder="Please mention pick up address"/></p>

<p><label for "air-pickup">Destination Address</label><input type="text" id="airport_drop_loca" name="airport_drop_locaoneway[]" value="<?php echo $_POST['airport_drop_loca']; ?>" placeholder="Please mention destination / Drop address" /></p>

<p><label for "air-pickup">Car type</label><select name="car_sizeoneway[]" id="car_size" class="car_size">
<option value="">Select Car Type</option>

<option value="Mid Size" <?php if($_POST['car_size']=='Mid Size') {echo "selected='selected'";}?>>Mid Size</option>

<option value="SUV" <?php if($_POST['car_size']=='SUV') {echo "selected='selected'";}?>>SUV</option>
</select></p>
<p><label for "dep-date1">Pickup Time </label><input type="text" id="car_pickuptime" name="car_pickuptimeoneway[]" placeholder="Please mention pick up time for the drop"  autofocus /></p>

<!--/div></fieldset>
--> <!-- SKK -->
</div>
</div> 
<!--------------------------------------------------------Onewaydiv Destination and departure details Ends---------------------------------------------------------------------------->


<!--------------------------------------------------------Round trip Destination and departure details Start---------------------------------------------------------------------------->

<?php //for Round trip section?>
<div id="container1" style="display:none;"> 
<div class="tbBooks" id="tbBooks"> 
<span class="f-leg"><img src="img/destination2.png" />Destination and departure details</span>
<fieldset name "dest-dep"><p><strong>Onward journey</strong></p>
       <!-- Start Onward journey Destination and Departure details first Column-->
<div class="col-3-grid"><p><label for "from1" name="onwardcity" ><span style="color:red;">*</span>From City</label>
<select name="onwardcity[]" id="onward_cityround" <?php echo $val_twoway;?>><option value=""><!--list to be populated dynamically-->From City</option>

<?php
foreach($cities as $citie) { ?>
<option value="<?php echo $citie['id']; ?>" <?php if($citie['id']==$_POST['onwardcity']) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state'];?></option>
<?php
} ?>
<option value="0">Others</option>
</select><div id="divonwardcityround" style="display: none">Other city: <input type="text" name="otheronwardcity[]"></div></p>

<p><label for "dep-date1"><span style="color:red;">*</span>Departure date </label>
<input type="text" id="datedepartureround" name="date[]" placeholder="Departure date" autofocus /></p>
<p><strong>Return journey   </strong></p>
<p><label for "dep-date1">Return date </label>
<input type="text" id="datereturnround" name="rdate[]" placeholder="Return date" value="" /></p>

<p><strong>Hotel Booking   </strong></p>

<p><label for "dep-date1">Check in date time </label>
<input type="text" id="datelchkinround" name="late_checkin_date[]" value="" placeholder="Check in date time"  /></p>
<p><label for "air-co"> Check in time</label>
    <input type="text" id="checkintime" name="late_checkin[]" placeholder="hh:mm"  />
    
    <!--<input type="checkbox" name="late_checkin[]" <?php //if($_POST['late_checkin']=='yes'){echo "checked='checked'"; }?> value="yes">--></p>


<p><label for "hotel"> Preferred hotel in the city</label><select id="pref_hotelround" class="pref_hotelround" name="pref_hotel[]" > 
<option value="">Preferred hotel in the city</option>
<?php/*
foreach($hotels as $hotel) { */?>
<!--option value="<?php echo $hotel['id']; ?>" <?php if($hotel['id']==$_POST['pref_hotel']) {echo "selected='selected'";}?>><?php echo $hotel['hotel_name']; ?></option-->
<?php

/*}*/ ?>

<!---option value="0">Others</option-->        <option selected="selected">--Select Hotels--</option>
</select><div id="divhotelround" style="display: none">Other Hotel: <input type="text" name="otherhotel[]"></div></p>
</div>
       <!-- end Onward journey Destination and Departure details first Column-->

       <!-- Start Onward journey Destination and Departure details Second Column-->
<div class="col-3-grid"><p><label for "TO1" name="travel_to" ><span style="color:red;">*</span>To City</label><select name="travel_to[]" id="traveltoround" <?php echo $valto_twoway;?>  onChange="getHotelround(this.value);" ><option value="">To City</option><?php
foreach($cities as $citie) { ?>
<option value="<?php echo $citie['id']; ?>" <?php if($citie['id']==$_POST['travel_to']) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state'];?></option>
<?php
} ?> 
<option value="0">Others</option>
</select><div id="divtraveltoround" style="display: none">Other city: <input type="text" name="othertravel_to[]"></div></p>

<p><label for "air-co">Select preferred Airlines</label>
<select name="book_airline[]" id="book_airlineround" class="book_airlineround"><option value="">Select preferred Airlines</option>
<?php
foreach($airlines as $airline) { ?>
<option value="<?php echo $airline['id']; ?>"<?php if($airline['id']==$_POST['book_airline']) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>

<?php
} ?><option value="0">Others</option></select> <div id="divairround" style="display:none;">Other Airline:<input type="text" name="otherair[]"></div>
</p>
<p><strong> <br/>    </strong></p>
<p><label for "air-co">Select preferred Airlines</label>

<select name="book_airline[]" id="book_airlineround1" class="book_airlineround1">		<option value="">Select preferred Airline</option>
<?php
foreach($airlines as $airline) { ?>
<option value="<?php echo $airline['id']; ?>" <?php if($airline['id']==$_POST['book_airline']) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>

<?php
} ?><option value="0">Others</option></select>  <div id="divairround1" style="display:none;">Other Airline: <input type="text" name="otherair[]"></div>
</p><p><strong><br/>     </strong></p>

<p><label for "dep-date1">Check out date time</label>
<input type="text" id="datelchkoutround" name="late_checkout_date[]" value="<?php echo $_POST['late_checkout_date']; ?>"placeholder="Check out date time" autofocus /></p>
<p><label for "air-co"> Check out time</label>
    <input type="text"  id="time" name="late_checkout[]" placeholder="hh:mm" >   
    
    <!--<input type="checkbox" name="late_checkout[]" value="yes" <?php //if($_POST['late_checkout']=='yes'){echo "checked='checked'"; }?>>-->

</p>
<p><label for "air-co">Flight Meal preference</label><input type="text" name="meal_preference[]" value=""></p>
</div>
       <!-- End Onward journey Destination and Departure details second Column-->


       <!-- Start Onward journey Destination and Departure details Third Column-->
<div class="col-3-grid">

<p><strong>     </strong></p>
<p><strong>     </strong></p><br /><br />
<p><label for "air-pickup">Preferred Flight Time</label>

<input type="text" id="preferred_airline_time" name="preferred_airline_time[]"  /></p>

<p><strong>     </strong></p><br /><br />

<p><label for "air-pickup">Preferred Flight Time</label>
<input type="text" id="preferred_airline_time" name="preferred_airline_time[]"  /></p>

<p><strong>     </strong></p><br/>		<p>
</div>
</fieldset>

<span class="f-leg"><img src="img/car.png" width="32px" height="32px"/>Car Booking</span>

<!--div class="in-bloc cent"><img src="img/bag.jpg" alt="profile creation" /><h1 class="in-bloc">Car Booking</h1></div-->

<fieldset name "dest-dep"><p><strong>Onward Journey</strong></p>
<div class="col-3-grid">
<p><input type="checkbox" name="airport_drop[]" value="yes"  <?php if($_POST['airport_drop']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport drop</label>&nbsp; <input type="hidden" name="airport_drop[]" value="no"></p>
<p><input type="checkbox" name="airport_pickup[]" value="yes"  <?php if($_POST['airport_pickup']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport pick up</label>&nbsp; <input type="hidden" name="airport_pickup[]" value="no"></p>
<p><label for "air-co">Multiple days booking</label><input type="checkbox" name="need_car[]" value="yes"<?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p>

<p><label for "car-co">Select preferred car vendor co.</label><select name="car_company[]" id="car_company" class="car_company">
<option value="">Select preferred car vendor co.</option>
<?php
foreach($cars as $car) { ?>
<option value="<?php echo $car['id']; ?>"<?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
<?php
} ?>

</select> </p>
<p><strong>Return Journey</strong></p>

<p><input type="checkbox" name="airport_drop[]" value="yes" <?php if($_POST['airport_drop']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport drop</label>&nbsp; <input type="hidden" name="airport_drop[]" value="no"></p>
<p><input type="checkbox" name="airport_pickup[]" value="yes" <?php if($_POST['airport_pickup']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport pick up</label>&nbsp;<input type="hidden" name="airport_pickup[]" value="no"></p>
<!--p><label for "air-co"> Multiple days booking</label><input type="checkbox" name="need_car[]" value="yes"<?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p-->

<p><label for "car-co">Select preferred car vendor co.</label><select name="car_company[]" id="car_company" class="car_company">
<option value="">Select preferred car vendor co.</option>
<?php
foreach($cars as $car) { ?>
<option value="<?php echo $car['id']; ?>"<?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
<?php
} ?>

</select> </p>
</div>
       <!-- end Onward journey Destination and Departure details Third Column-->

       <!-- Start Return journey Destination and Departure details Third Column-->
<div class="col-3-grid">					
<p><label for "air-pickup">Pickup address</label><input type="text" id="airport_pickup_loca" name="airport_pickup_loca[]" value="<?php echo $_POST['airport_pickup_loca']; ?>"autofocus placeholder="Please mention pick up address"/></p>
<p><label for "air-pickup">Destination Address</label><input type="text" id="airport_drop_loca" name="airport_drop_loca[]" value="<?php echo $_POST['airport_drop_loca']; ?>"autofocus placeholder="Please mention destination / Drop address" /></p>

<p><label for "air-pickup">Car type</label>
<select name="car_size[]" id="car_size" class="car_size">
<option value="">Select Car Type</option>

<option value="Mid Size" <?php if($_POST['car_size']=='Mid Size') {echo "selected='selected'";}?>>Mid Size</option>

<option value="SUV" <?php if($_POST['car_size']=='SUV') {echo "selected='selected'";}?>>SUV</option>
</select>


</p><p><label for "dep-date1">Pickup Time </label><input type="text" id="car_pickuptime" name="car_pickuptime[]" placeholder="Please mention pick up time for the drop" " autofocus /></p>
<p><strong>     </strong></p><br/><p><label for "air-pickup">Pickup address</label><input type="text" id="airport_pickup_loca" name="airport_pickup_loca[]" value="<?php echo $_POST['airport_pickup_loca']; ?>"autofocus placeholder="Please mention pick up address"/></p>
<p><label for "air-pickup">Destination Address</label><input type="text" id="airport_drop_loca" value="<?php echo $_POST['airport_drop_loca']; ?>"name="airport_drop_loca[]" autofocus placeholder="Please mention destination / Drop address" /></p>


<p><label for "air-pickup">Car type</label><select name="car_size[]" id="car_size" class="car_size">
<option value="">Select Car Type</option>

<option value="Mid Size" <?php if($_POST['car_size']=='Mid Size') {echo "selected='selected'";}?>>Mid Size</option>

<option value="SUV" <?php if($_POST['car_size']=='SUV') {echo "selected='selected'";}?>>SUV</option>
</select></p>

<p><label for "dep-date1">Pickup Time </label><input type="text" id="car_pickuptime" name="car_pickuptime[]" placeholder="Please mention pick up time for the drop"  autofocus /></p>

</fieldset>
</div></div>
       <!-- End Return journey Destination and Departure details Third Column-->

<!--------------------------------------------------------Round trip Destination and departure details end---------------------------------------------------------------------------->


<!--------------------------------------------------------Multidiv Destination and departure details Start---------------------------------------------------------------------------->
      <div class="row" style="display:none;">
	<div class="multidiv" id="multidiv"> 
<!-- Destination and Departure details-->

	<span class="f-leg"><img src="img/destination2.png" />Destination and departure details</span>
	<fieldset name "dest-dep">
<!-- Start Destination and Departure details first Column-->
	<div class="col-3-grid">
	<p><label for "from1" name="onwardcity"  ><span style="color:red;">*</span>From City</label>
	<select name="onwardcitymulti[]" id="onward_citymulti" <?php echo $val_multiway;?>><option value=""><!--list to be populated dynamically-->From City</option>
	<?php
	foreach($cities as $citie) { ?>
	<option value="<?php echo $citie['id']; ?>"<?php if($citie['id']==$_POST['onwardcity']) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state'];?></option>
	<?php
	} ?>
<option value="0">Others</option>
</select><div id="divonwardcitymulti" style="display: none">Other city: <input type="text" name="otheronwardcitymulti[]"></div></p>


	<p><label for "TO1" name="travel_to"><span style="color:red;">*</span>To City</label><select name="travel_tomulti[]" id="travel_to"   ><option value="">To City</option><?php
	foreach($cities as $citie) { ?>
	<option value="<?php echo $citie['id']; ?>"<?php if($citie['id']==$_POST['travel_to']) {echo "selected='selected'";}?>><?php echo $citie['city_name'].",".$citie['city_state'];?></option>
	<?php
	} ?> 
<option value="0">Others</option>
</select><div id="divtraveltomulti" style="display: none">Other city: <input type="text" name="othertravel_tomulti[]"></div></p>


	<p><label for "dep-date1">Departure date </label>
	<input type="text" id="datedeparturemulti"  class="datepicker" name="datemulti[]" placeholder="Departure date"value="<?php echo $_POST['date']; ?>" /></p>

	<p><label for "air-co">Select preferred Airlines</label>
	<select name="book_airlinemulti[]" id="book_airlinemulti" class="book_airline">
	<option value="">Select preferred Airlines</option>
	<?php
	foreach($airlines as $airline) { ?>
	<option value="<?php echo $airline['id']; ?>" <?php if($airline['id']==$_POST['book_airline']) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>

	<?php
	} ?><option value="0">Others</option></select>  <div id="divairmulti" style="display:none;">Other Airline: <input type="text" name="otherairmulti[]"></div>
	</p>

	<p><label for "air-pickup">Preferred Flight Time</label>
	<input type="text" id="preferred_airline_time" name="preferred_airline_timemulti[]"  /></p>
	<input type="hidden" name="divcount" value="<?php echo $divcount;?>">


	<p><strong>Car Booking</strong></p>
	<p><input type="checkbox" name="airport_dropmulti[]" value="yes"  <?php if($_POST['airport_drop']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport drop</label>&nbsp;<input type="hidden" name="airport_dropmulti[]" value="no"></p>
	<p><input type="checkbox" name="airport_pickupmulti[]" value="yes" <?php if($_POST['airport_pickup']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport pick up</label>&nbsp;<input type="hidden" name="airport_pickupmulti[]" value="no"></p>
	<p><label for "air-co"> Multiple days booking</label><input type="checkbox" name="need_carmulti[]" value="yes"  <?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p>
	</div>
<!-- End Destination and Departure details first Column-->



 <!-- Start Destination and Departure details Second Column-->
	<div class="col-3-grid"><p><strong>Hotel Booking</strong></p>
	<p><label for "dep-date1">Check in date time </label>
	<input type="text" id="datelchkinmulti"  class="datetimepicker" name="late_checkin_datemulti[]" value="" placeholder="Check in date time"  /></p>
	<p><label for "air-co"> Check in time</label>
            <input type="text" id="checkintime" name="late_checkinmulti[]" placeholder="hh:mm"  />
            
            <!--<input type="checkbox" name="late_checkinmulti[]" value="yes"<?php //if($_POST['late_checkin']=='yes'){echo "checked='checked'"; }?> >--></p>
	<p><label for "hotel"> Preferred hotel in the city</label><select id="pref_hotelmulti" class="pref_hotelmulti" name="pref_hotelmulti[]"> 
	<!--option value="">Preferred hotel in the city</option-->
	<?php/*
	foreach($hotels as $hotel) {*/ ?>
	<!--option value="<?php echo $hotel['id']; ?>" <?php if($hotel['id']==$_POST['pref_hotel']) {echo "selected='selected'";}?>><?php echo $hotel['hotel_name']; ?></option-->

	<?php

	/* } */?><!--option value="0">Others</option-->
        <!--option selected="selected">--Select Hotels--</option-->

        <option value="">--Select Hotels--</option>

	</select><div id="divhotelmulti" style="display: none;">Other Hotel: <input type="text" name="otherhotelmulti[]"></div></p>
<p><strong><br/><br/><br/></strong></p>


<p><label for "air-pickup">Pickup address</label><input type="text"  value="<?php echo $_POST['airport_pickup_loca']; ?>" id="airport_pickup_loca" name="airport_pickup_locamulti[]" autofocus placeholder="Please mention pick up address"/></p>
	<p><label for "air-pickup">Destination Address</label><input type="text" id="airport_drop_loca" name="airport_drop_locamulti[]" value="<?php echo $_POST['airport_drop_loca']; ?>" placeholder="Please mention destination / Drop address" /></p>
<p><label for "car-co">Preferred car vendor co.</label><select name="car_companymulti[]" id="car_company" class="car_company">
	<option value="">Preferred car vendor co.</option>
	<?php
	foreach($cars as $car) { ?>
	<option value="<?php echo $car['id']; ?>" <?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
	<?php
	} ?>

	</select> </p>
	</div>

	<div class="col-3-grid"><p><strong><br/></strong></p>
	<p><label for "dep-date1">Check out date time</label>
	<input type="text"  id="datelchkoutmulti" class="datetimepicker" name="late_checkout_datemulti[]"value="<?php echo $_POST['late_checkout_date']; ?>" placeholder="Check out date time" autofocus /></p>
	<p><label for "air-co"> Check out time</label>
            <input type="text"  id="time" name="late_checkoutmulti[]" placeholder="hh:mm" >   
           <!-- <input type="checkbox" name="late_checkoutmulti[]" <?php //if($_POST['late_checkout']=='yes'){echo "checked='checked'"; }?> value="yes">--></p>
<p><label for "air-co">Flight Meal preference</label><input type="text" name="meal_preferencemulti[]"></p>
	</div>
 <!--  Destination and Departure details Second Column End-->

 <!-- Start Destination and Departure details Third Column-->
<div class="col-3-grid">
	<p><strong><br/><br/><br/></strong></p>
<p><label for "air-pickup">Car type</label>
	<select name="car_sizemulti[]" id="car_size" class="car_size">
	<option value="">Select Car Type</option>
	<option value="Mid Size" <?php if($_POST['car_size']=='Mid Size') {echo "selected='selected'";}?>>Mid Size</option>
	<option value="SUV" <?php if($_POST['car_size']=='SUV') {echo "selected='selected'";}?>>SUV</option>
	</select>
	</p><p><label for "dep-date1">Pickup Time </label><input type="text" id="car_pickuptime" name="car_pickuptimemulti[]" placeholder="Please mention pick up time for the drop"  autofocus /></p></div>
</div>

	
	</fieldset>
	</div>
<!-- End Destination and Departure details Third Column-->

        <div id="containerdd"></div>
	<div class="btn-set"> <input type="button" class=""  id="btnadddd"  value="ADD" /></div>



</div> 
<!--------------------------------------------------------Multidiv Destination and departure details Ends---------------------------------------------------------------------------->



<!-----------------------------------------------Cloned Destination and departure details oneway multi round Start-------------------------------------------------------------------->
<div id="container2"style="display:none;"></div> 

<!------------------------------------------------Cloned Destination and departure details oneway multi round End-------------------------------------------------------------------->



<!---------------------------------------------------------------Main Travel details Start----------------------------------------------------------------------------------------------->

<div class="row">
<!-- additional instructions-->
 <p style="color:red;"><strong>NOTE:If car or hotel booking is not for your self please mention the guest name in special mention</strong></p>
<span class="f-leg"><img src="img/note2.png" />Special mention</span>
<fieldset name "special-notes">
<textarea name="special_mention" placeholder="Please mention any depcific requirements" rows="5" ><?php echo $_POST['special_mention']; ?></textarea></p>
</fieldset>
</div>
<div class="row cent"><input type="SUBMIT" value="SUBMIT" id="add"/> 
<?php  $type=$u->getUserType();if($type=='Employee'){?> <input type="button"value="CANCEL"onclick="javascript:window.location='emp-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><input type="button" value="CANCEL" onclick="javascript:window.location='manager-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><input type="button" value="CANCEL"onclick="javascript:window.location='travel-desk-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><input type="button" value="CANCEL" onclick="javascript:window.location='admin-board.php';"><?php }?></div>
</form>


</div>

<!---------------------------------------------------------------Main Travel details end--------------------------------------------------------------------------------------------------->
<footer>

</footer>
</div><!--wrapper ends--> 

<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->

<!--script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script-->


<!-- scripts concatenated and minified via build script -->
<script src="js/plugins.js"></script>
<script src="js/script.js"></script>
<!-- end scripts -->

<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
mathiasbynens.be/notes/async-analytics-snippet -->
<script>
$('#oneway').click();
</script>

<!--script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script-->

<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script-->



<script type="text/javascript">
$(function () {
	$("#pref_hotelround").change(function () { //alert('hiiii');
		var title = $("#pref_hotelround :selected").text();
		if (title=='Others') { //alert(title);
		$("#divhotelround").show();
		} else {
		$("#divhotelround").hide();
		}
	});
});

$(function () {
	$("#book_airlineround").change(function () { //alert('hiiii');
		var title = $("#book_airlineround :selected").text();
		if (title=='Others') { //alert(title);
		$("#divairround").show();
		} else {
		$("#divairround").hide();
		}
	});
});  

$(function () {
	$("#book_airlineround1").change(function () { //alert('hiiii');
		var title = $("#book_airlineround1 :selected").text();
		if (title=='Others') { //alert(title);
		$("#divairround1").show();
		} else {
		$("#divairround1").hide();
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
$(function () {
	$("#pref_hoteloneway").change(function () { //alert('hiiii');
		var title = $("#pref_hoteloneway :selected").text();
		if (title=='Others') { //alert(title);
		$("#divhoteloneway").show();
		} else {
		$("#divhoteloneway").hide();
		}
	});
});
$(function () {
	$("#book_airlineoneway").change(function () { //alert('hiiii');
		var title = $("#book_airlineoneway :selected").text();
		if (title=='Others') { //alert(title);
		$("#divaironeway").show();
		} else {
		$("#divaironeway").hide();
		}
	});
});
$(function () {
	$("#onward_cityoneway").change(function () { //alert('hiiii');
		var title = $("#onward_cityoneway :selected").text();
		if (title=='Others') { //alert(title);
		$("#divonwardcity").show();
		} else {
		$("#divonwardcity").hide();
		}
	});
}); 
$(function () {
	$("#traveltooneway").change(function () { //alert('hiiii');
		var title = $("#traveltooneway :selected").text();
		if (title=='Others') { //alert(title);
		$("#divtravelto").show();
		} else {
		$("#divtravelto").hide();
		}
	});
});
$(function () {  
	$("#pref_hotelmulti").change(function () { 
		var title = $("#pref_hotelmulti :selected").text();//alert(title);
		if (title=='Others') { 
		$("#divhotelmulti").show();
		} else {
		$("#divhotelmulti").hide();
		}
	});
});

$(function () { 
	$("#book_airlinemulti").change(function () {
		var title = $("#book_airlinemulti :selected").text();//alert(title);
		if (title=='Others') { 
		$("#divairmulti").show();
		} else {
		$("#divairmulti").hide();
		}
	});
});
$(function () {
	$("#onwardcitymulti").change(function () { //alert('hiiii');
		var title = $("#onwardcitymulti :selected").text();
		if (title=='Others') { //alert(title);
		$("#divonwardcitymulti").show();
		} else {
		$("#divonwardcitymulti").hide();
		}
	});
}); 
$(function () {
	$("#travel_to").change(function () { //alert('hiiii');
		var title = $("#travel_to :selected").text();
		if (title=='Others') { //alert(title);
		$("#divtraveltomulti").show();
		} else {
		$("#divtraveltomulti").hide();
		}
	});
});
</script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/DateTimePicker.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<script>
$(function() {
    $( "#datedepartureoneway" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#datedepartureround" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
   //$( "#datedeparturemulti" ).datetimepicker();inline: true;
    $( "#datelchkinoneway" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#datelchkoutoneway" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#datereturnround" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#datelchkinround" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#datelchkoutround" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    //$( "#datelchkinmulti" ).datetimepicker();inline: true;
    //$( "#datelchkoutmulti" ).datetimepicker();inline: true;
});
</script>
<script type="text/javascript">
$(document).ready(function () {
var iCnt;
iCnt = 1;
	if(iCnt === 1 || iCnt > 1){
		$('.btn-set').on('click', function () {
			var copy = $('#multidiv').clone(true);
			var new_div_id = 'multidiv'+iCnt;
			copy.attr('id', new_div_id );
			//$('#containerdd').find('#pref_hotelmulti').attr({id: 'pref_hotelmulti'+iCnt, name: "pref_hotel[]"});
			//$('#containerdd').find('#book_airlinemulti').attr({id: 'book_airlinemulti'+iCnt, name: "book_airline[]"}); 
			
			$('#containerdd').append(copy);
			$('#containerdd').find('#divhotelmulti').attr({id: 'divhotelmulti'+iCnt, name: "divhotelmulti"});
			$('#containerdd').find('#divairmulti').attr({id: 'divairmulti'+iCnt, name: "divairmulti"});
			$('#containerdd').find('#divonwardcitymulti').attr({id: 'divonwardcitymulti'+iCnt, name: "divonwardcitymulti"});
			$('#containerdd').find('#divtraveltomulti').attr({id: 'divtraveltomulti'+iCnt, name: "divtraveltomulti"});
			$('#' + new_div_id).find('input,select').each(function(){
			    $(this).attr('id', $(this).attr('id') + iCnt);
			 });
				    	
			var hotel ="pref_hotelmulti"+iCnt;// alert("#"+hotel);
			var air ="book_airlinemulti"+iCnt;
			var divhotel ="divhotelmulti"+iCnt;
			var divair ="divairmulti"+iCnt;
			var divonwardcity ="divonwardcitymulti"+iCnt;
			var divtravelto ="divtraveltomulti"+iCnt;
			var onwardcity ="onward_citymulti"+iCnt;// alert("#"+hotel);
			var travel_to ="travel_to"+iCnt;


			$(document.body).on('change',"#"+onwardcity,function(){
	
				var title = $("#"+onwardcity+" :selected").text();//alert(divhotel);
				if (title=='Others') { 
				$("#"+divonwardcity).show();
				} else {
				$("#"+divonwardcity).hide();
				}
			});

			$(document.body).on('change',"#"+travel_to,function(){
    					var val = $(this).val();
				$.ajax({
				type: "POST",
				url: "gethotels.php",
				data:'id='+val,
				success: function(data){ 
					$("#"+hotel).html(data);
				}
				});
				var title = $("#"+travel_to+" :selected").text();//alert(divhotel);
				if (title=='Others') { 
				$("#"+divtravelto).show();
				} else {
				$("#"+divtravelto).hide();
				}
			});

			$(document.body).on('change',"#"+hotel,function(){
					
	
				var title = $("#"+hotel+" :selected").text();//alert(divhotel);
				if (title=='Others') { 
				$("#"+divhotel).show();
				} else {
				$("#"+divhotel).hide();
				}
			});

			$(document.body).on('change',"#"+air,function(){
			// alert("#"+air);
				var title = $("#"+air+" :selected").text();//alert(divair);
				if (title=='Others') { 
				$("#"+divair).show();
				} else {
				$("#"+divair).hide();
				}
			});
			$("#datedeparturemulti"+iCnt ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
			$("#datelchkinmulti"+iCnt ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
			$("#datelchkoutmulti"+iCnt ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
			$("#onward_citymulti"+iCnt).attr('required', true); 
			$("#traveltoround"+iCnt).attr('required', false);
			$("#traveltomulti"+iCnt).attr('required', true);     
			
			iCnt++;

		});
	}
 });


//round trip
$(document).ready(function() {
	$("#onward_cityoneway").attr('required', true);            
	$("#traveltooneway").attr('required', true);
	$('input[type="radio"]').click(function() {
if($(this).attr('id') == 'twoway') { //alert("hiiiiiiiiiiii");
	$('#container1').show();   	
	$('#onewaydiv').hide();  
	$('#multidiv').hide();  
	$('#containerdd').hide();  
	$("#onward_cityoneway").attr('required', false);
	$("#traveltooneway").attr('required', false);     
	$("#onward_cityround").attr('required', true);
	$("#datedepartureround").attr('required', true);
	$("#onward_citymulti").attr('required', false); 
	$("#traveltoround").attr('required', true);
	$("#traveltomulti").attr('required', false);

}
else if($(this).attr('id') == 'multi') { //alert("hiiiiiiiiiiii");
	$(function() {
	    $('.btn-set').click();
	});
	$('#container1').hide();
	$('#multidiv').show();
	$('#onewaydiv').hide();
	$('#containerdd').show();  

	$("#onward_cityoneway").attr('required', false);
	$("#traveltooneway").attr('required', false);     
	$("#onward_cityround").attr('required', false);
	$("#datedepartureround").attr('required', false);
	$("#traveltoround").attr('required', false);
	//$("#traveltomulti").attr('required', true);     
}
else if($(this).attr('id') == 'oneway') { //alert("hiiiiiiiiiiii");
	$('#container1').hide();
	$('#multidiv').hide();
	$('#onewaydiv').show(); 
	$('#containerdd').hide(); 
	$("#onward_cityoneway").attr('required', true);            
	$("#traveltooneway").attr('required', true);     
	$("#onward_cityround").attr('required', false);
	$("#datedepartureround").attr('required', false);
	$("#onward_citymulti").attr('required', false); 
	$("#traveltoround").attr('required', false);
	$("#traveltomulti").attr('required', false);          
}

});


});

$(document).ready(function() {
	$('.btn-set').hide(); 
	$('input[name="trip_type"]').click(function() {
		if($(this).attr('id') == 'multi') {
		$('.btn-set').show();           
		}
		else {
		$('.btn-set').hide();   
		}
	});
});

/*$(document.body).on('change',"#traveltooneway",function(){
	   var id=$(this).val();
					var dataString = 'id='+ id; 
					    $.ajax
					    ({
						type: "POST",
						url: "gethotels.php",
						data: dataString,
						cache: false,
						success: function(html)
						{
alert(html);
						    $("#pref_hoteloneway").html(html);
						} 
					    });
});*/

function getHotel(val) {
	$.ajax({
	type: "POST",
	url: "gethotels.php",
	data:'id='+val,
	success: function(data){ 
		$("#pref_hoteloneway").html(data);
	}
	});
}
function getHotelround(val) {
	$.ajax({
	type: "POST",
	url: "gethotels.php",
	data:'id='+val,
	success: function(data){ 
		$("#pref_hotelround").html(data);
	}
	});
}




</script>
</body>
</html>
