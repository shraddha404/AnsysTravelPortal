<?php
session_start();
include_once ('../lib/User.class.php');
//echo $_SESSION['user_id'];
$u = new User($_SESSION['user_id']);
if(empty($_SESSION['user_id']))
{
header("location:login.php");
}

if(!$u->isMyProfileComplete()){
    header("location:profile.php");
}
if($_POST){
function filter_callair($val) {
    $val = trim($val);
    return $val != '';
}
//print_r($_POST);
$onwardcity = array_values(array_filter($_POST['onwardcity'], 'filter_callair'));
$pref_hotel = array_values(array_filter($_POST['pref_hotel'], 'filter_callair'));
$car_company = array_values(array_filter($_POST['car_company'], 'filter_callair'));
$travel_to = array_values(array_filter($_POST['travel_to'], 'filter_callair'));
$book_airline = array_values(array_filter($_POST['book_airline'], 'filter_callair'));
$room_type = array_values(array_filter($_POST['room_type'], 'filter_callair'));
$noofguests = array_values(array_filter($_POST['noofguests'], 'filter_callair'));
$noofrooms = array_values(array_filter($_POST['noofrooms'], 'filter_callair'));
$checkouttime = array_values(array_filter($_POST['checkouttime'], 'filter_callair'));
$checkindate = array_values(array_filter($_POST['checkindate'], 'filter_callair'));
$checkoutdate = array_values(array_filter($_POST['checkoutdate'], 'filter_callair'));
$drop_location = array_values(array_filter($_POST['drop_location'], 'filter_callair'));
$pickup_required = array_values(array_filter($_POST['pickup_required'], 'filter_callair'));
$drop_required = array_values(array_filter($_POST['drop_required'], 'filter_callair'));
$pickup_location = array_values(array_filter($_POST['pickup_location'], 'filter_callair'));
$drop_required = array_values(array_filter($_POST['drop_required'], 'filter_callair'));
$pickup_required = array_values(array_filter($_POST['pickup_required'], 'filter_callair'));
$need_car = array_values(array_filter($_POST['need_car'], 'filter_callair'));
$pickup_city = array_values(array_filter($_POST['pickup_city'], 'filter_callair'));
$date = array_values(array_filter($_POST['date'], 'filter_callair'));
$rdate = array_values(array_filter($_POST['rdate'], 'filter_callair'));
$airport_drop_loca = array_values(array_filter($_POST['airport_drop_loca'], 'filter_callair'));
$airport_pickup_loca = array_values(array_filter($_POST['airport_pickup_loca'], 'filter_callair'));
$airport_drop = array_values(array_filter($_POST['airport_drop'], 'filter_callair'));
$airport_pickup = array_values(array_filter($_POST['airport_pickup'], 'filter_callair'));
$car_type = array_values(array_filter($_POST['car_type'], 'filter_callair'));
$car_size = array_values(array_filter($_POST['car_size'], 'filter_callair'));
$late_checkin = array_values(array_filter($_POST['late_checkin'], 'filter_callair'));
$late_checkout = array_values(array_filter($_POST['late_checkout'], 'filter_callair'));
$late_checkin_date = array_values(array_filter($_POST['late_checkin_date'], 'filter_callair'));
$late_checkout_date = array_values(array_filter($_POST['late_checkout_date'], 'filter_callair'));
//echo count($onwardcity);exit;
//echo count($onwardcity);
//print_r($date);print_r($book_airline);print_r($car_company);print_r($pref_hotel);echo $date[0];exit;
$message= " ";
/*if((count($onwardcity) == 0) && (count($travel_to) == 0))
 {
	  $message="Please fill mandatory fields.Please fill From city and To city";
  }
else if((count($travel_to) == 0) ) {
 $message="Please fill mandatory fields.Please fill To city";
  }
else if((count($onwardcity) == 0) ) {
 $message="Please fill mandatory fields.Please fill From city";
  }
else
{   */  
        $details = $u->travelrequestbooking($_POST);if($details){
	//$message=$details['trip_type']."Request booked sucssefully";
    header("location:my-request.php");
        }
/*}*/
}
$cities = $u->cities();
$airlines = $u->airlines();
$hotels = $u->hotels();
$cars = $u->cars();

//echo md5('rupali');
//echo md5('manager123');
//print_r($_SESSION);
//Array ( [city_id] => 1416 [city_name] => Tetri Bazar [city_state] => Uttar Pradesh );?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
<script src="//ajax.googleapis.com/ajax/
libs/jquery/1.9.1/jquery.min.js"></script>

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
  <form id="travel-booking" method="post" action=""  >
  	<div class="row cent clearfix">
	    <div class="in-bloc cent"><img src="img/bag.jpg" alt="profile creation" /><h1 class="in-bloc">Travel Booking</h1>
<?php if(!empty($message)) { echo "<p style='color:green;'>".$message."</p>"; }?></div>
    </div><input type="hidden" id="booking" name="booking" value="air"/>
    <!-- Travel details-->
    <div class="row"> 
<?php  $type=$u->getUserType();if($type=='Employee'){?><h3 align='right'><p style='color:green;'><a href='emp-board.php'>Dashboard</a></p></h3><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><h3 align='right'><p style='color:green;'><a href='manager-board.php'>Dashboard</a></p></h3><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><h3 align='right'><p style='color:green;'><a href='travel-desk-board.php'>Dashboard</a></p></h3><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><h3 align='right'><p style='color:green;'><a href='admin-board.php'>Dashboard</a></p></h3><?php }?>


<span style="color:red;">*<?php echo 'Please fill mandatory fields.';?></span>
    <span class="f-leg"><img src="img/travel_details.png" />Provide travel details</span>
    <fieldset name "travel-details">
              <div class="col-2-grid"><label for "trip-type">Type of trip </label>
           <ul class="radio"><li><input type="radio" name="trip_type" value="oneway" id="oneway" checked="checked" <?php if($_POST['trip_type']=='oneway'){ echo "checked='checked'";} else if($_POST['trip_type']==' '){ echo "checked='checked'";} ?>/><label for "oneway">Oneway </label></li><li><input type="radio" name="trip_type" value="round trip"  id="twoway" <?php if($_POST['trip_type']=='round trip'){ echo "checked='checked'";}?>/> <label for "roundtrip">Round trip</label></li><li> <input type="radio" name="trip_type" value="multicity" id="multi" <?php if($_POST['trip_type']=='multicity'){ echo "checked='checked'";}?>/> <label for "multicity">Multi city </label></li></ul>
           <p><label for "adv">If cash advance required, please enter the amount</label><input type="text" id="cash_adv" name="cash_adv" placeholder="Cash advance amount" value="<?php echo $_POST['cash_adv']; ?>" autofoucs />
         </div>
         
          <div class="col-2-grid clearfix">  <p><label for "tour-purpose">Purpose of visit </label>
        <textarea name="purpose_of_visit" placeholder="Please mention specific purpose of visit; DO NOT mention business visit" rows="3" ><?php echo $_POST['purpose_of_visit']; ?></textarea></p>

<!--label for "adv">Cost of hotel, please enter the amount</label>&nbsp;&nbsp;<input type="text" id="cost" name="cost"  autofoucs /></p-->

         </div>
       
          
     </fieldset>
    </div>
    <!-- Travel details end-->
    

      <div class="row">
 <div class="onewaydiv" id="onewaydiv" style="display:none;"> 
   <!-- Destination and Departure details-->
		<span class="f-leg"><img src="img/destination2.png" />Destination and departure details</span>
		      <fieldset name "dest-dep">
			<div class="col-3-grid"><p><label for "from1" name="onwardcity" ><span style="color:red;">*</span>From City</label>
<select name="onwardcity[]" id="onward_cityoneway" ><option value="blank"><!--list to be populated dynamically-->From City</option>

		<?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id']; ?>" <?php if($citie['id']==$onwardcity[0]) {echo "selected='selected'";}?>><?php echo $citie['city_name'] ?></option>
		  <?php
		    } ?>
		 </select> </p>
			<p><label for "TO1" name="travel_to" ><span style="color:red;">*</span>To City</label><select name="travel_to[]" id="traveltooneway"><option value=" ">To City</option><?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id']; ?>"<?php if($citie['id']==$travel_to[0]) {echo "selected='selected'";}?>><?php echo $citie['city_name']; ?></option>
		  <?php
		    } ?> </select></p>
		<p><label for "dep-date1">Departure date </label>
				 	<input type="date" id="date" name="date[]" value="<?php echo $date[0];?>"placeholder="Departure date" autofocus /></p>
		<!--p><label for "dep-date1">Return date </label>
				 	<input type="date" id="date" name="rdate[]" placeholder="Return date" autofocus /></p-->

		<p><label for "air-co">Select preferred Airlines</label>
		<select name="book_airline[]"> <option value="">Select preferred Airlines</option>
		<?php
		    foreach($airlines as $airline) { ?>
		      <option value="<?php echo $airline['id']; ?>" <?php if($airline['id']==$book_airline[0]) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>
		  <?php
		    } ?></select> 
		</p>
		   
		<p><label for "air-pickup">Preferred Airline Time</label><select name="preferred_airline_time[]"><option value="">Select Airline Time</option>
 <option value="1" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>12:00am to 3:000am</option>     
 <option value="2" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>03:00am to 6:000am</option>      
<option value="3" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>06:00am to 9:000am</option> 
<option value="4" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>9:00am to 12:000pm</option>
 <option value="5" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>12:00pm to 3:000pm</option>
 <option value="6" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>03:00pm to 6:000pm</option> 
<option value="7" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>06:00pm to 9:000pm</option>
 <option value="8" <?php if($preferred_airline_time[0]) {echo "selected='selected'";}?>>09:00pm to 12:000am</option>
		</select> </p>

		<p><label for "hotel"> Preferred hotel in the city</label><select id="pref_hotel" class="pref_hotel" name="pref_hotel[]"> 
		<option value="">Preferred hotel in the city</option>
		<?php
		    foreach($hotels as $hotel) { ?>
		      <option value="<?php echo $hotel['id']; ?>" <?php if($hotel['id']==$pref_hotel[0]) {echo "selected='selected'";}?>><?php echo $hotel['hotel_name']; ?></option>
		  <?php
		    } ?>

		</select></p>
		</div>
	      <div class="col-3-grid"><p><strong>Hotel Booking</strong></p><p><label for "air-co"> Late Checkin</label><input type="checkbox" name="late_checkin[]" value="yes" <?php if($late_checkin[0]=='yes'){echo "checked='checked'"; }?>></p>
		<p><label for "dep-date1">Check in date time </label>
			 	<input type="date" id="date" name="late_checkin_date[]"  value="<?php echo $late_checkin_date[0]; ?>" placeholder="Check in date time" autofocus /></p>

		<p><label for "air-co"> Late Checkout</label><input type="checkbox" name="late_checkout[]" value="yes" <?php if($late_checkout[0]=='yes'){echo "checked='checked'"; }?>></p>
		<p><label for "dep-date1">Check out date time</label>
			 	<input type="date" id="date" name="late_checkout_date[]" value="<?php echo $late_checkout_date[0]; ?>" placeholder="Check out date time" autofocus /></p>
</div></fieldset>
			<span class="f-leg"><img src="img/car.png" width="32px" height="32px"/>Car Booking</span>

	    <!--div class="in-bloc cent"><img src="img/bag.jpg" alt="profile creation" /><h1 class="in-bloc">Car Booking</h1></div-->
			      <fieldset name "dest-dep">
				<div class="col-3-grid">
	<p><input type="checkbox" name="airport_drop[]" value="yes" <?php if($airport_drop[0]=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport drop</label>&nbsp;</p>
			<p><input type="checkbox" name="airport_pickup[]" <?php if($airport_pickup[0]=='yes'){echo "checked='checked'"; }?> value="yes"><label for "air-co">Need Airport pick up</label>&nbsp;</p>
			<p><label for "air-co"> Need car for the entire day</label><input type="checkbox" name="need_car[]" value="yes" <?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p>

<!--p><label for "dep-date1">Departure date </label>9764734488
				 	<input type="date" id="date" name="date[]" placeholder="Departure date" autofocus /></p>
<p><label for "dep-date1">Return date </label>
				 	<input type="date" id="date" name="rdate[]" placeholder="Return date" autofocus /></p-->
				<p><label for "car-co">Select preferred car vendor co.</label><select name="car_company[]" id="car_company" class="car_company">
<option value="">Select preferred car vendor co.</option>
			<?php
			    foreach($cars as $car) { ?>
			      <option value="<?php echo $car['id']; ?>" <?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
			  <?php
			    } ?>

			</select> </p>
			</div>
			<div class="col-3-grid">
			<p><label for "air-pickup">Pickup Location</label><input type="text" id="airport_pickup_loca" name="airport_pickup_loca[]" value="<?php echo $_POST['airport_pickup_loca']; ?>" autofocus /></p>

			<p><label for "air-pickup">Drop Location</label><input type="text" id="airport_drop_loca" name="airport_drop_loca[]" value="<?php echo $_POST['airport_drop_loca']; ?>" autofocus /></p>
	
			<p><label for "car-co">Pick up City</label><input type="text" id="pickupcity" name="pickupcity[]" value="<?php echo $_POST['pickupcity']; ?>" readonly="readonly"></p>
<p><label for "air-pickup">Car type</label><input type="text" id="car_type" name="car_type[]" value="<?php echo $_POST['car_type']; ?>" autofocus />
<label for "air-pickup">Car size</label><input type="text" id="car_size" name="car_size[]" value="<?php echo $_POST['car_size']; ?>" autofocus /></p>
<!--/div></fieldset>
--> <!-- SKK -->
</div>
     </div> 


<?php //for Round trip section?>
<div id="container1" style="display:none;"> 
	<div class="tbBooks" id="tbBooks"> 
   		<span class="f-leg"><img src="img/destination2.png" />Destination and departure details</span>
<fieldset name "dest-dep"><p><strong>Onward journey</strong></p>
			<div class="col-3-grid"><p><label for "from1" name="onwardcity" ><span style="color:red;">*</span>Onward City</label>
<select name="onwardcity[]" id="onward_cityround" ><option value=""><!--list to be populated dynamically-->From City</option>

		<?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id']; ?>" <?php if($citie['id']==$_POST['onwardcity']) {echo "selected='selected'";}?>><?php echo $citie['city_name']; ?></option>
		  <?php
		    } ?>
		 </select> </p><p><label for "dep-date1">Departure date </label>
				 	<input type="date" id="date" name="date[]" placeholder="Departure date" autofocus /></p>
<p><label for "hotel"> Preferred hotel in the city</label><select id="pref_hotel" class="pref_hotel" name="pref_hotel[]"> 
		<option value="">Preferred hotel in the city</option>
		<?php
		    foreach($hotels as $hotel) { ?>
		      <option value="<?php echo $hotel['id']; ?>" <?php if($hotel['id']==$_POST['pref_hotel']) {echo "selected='selected'";}?>><?php echo $hotel['hotel_name']; ?></option>
		  <?php
		    } ?>

		</select></p>




<p><strong>Return journey   </strong></p>
<p><label for "dep-date1">Return date </label>
<input type="date" id="date" name="rdate[]" placeholder="Return date" value="<?php echo $_POST['rdate']; ?>" autofocus /></p>
<p><strong>Hotel Booking   </strong></p>

<p><label for "air-co"> Late Checkin</label><input type="checkbox" name="late_checkin[]" <?php if($_POST['late_checkin']=='yes'){echo "checked='checked'"; }?> value="yes"></p>
<p><label for "dep-date1">Check out date time</label>
			 	<input type="date" id="date" name="late_checkout_date[]" value="<?php echo $_POST['late_checkout_date']; ?>"placeholder="Check out date time" autofocus /></p>

</div>







			<div class="col-3-grid"><p><label for "TO1" name="travel_to" ><span style="color:red;">*</span>Return City</label><select name="travel_to[]" id="traveltoround" ><option value="">To City</option><?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id']; ?>" <?php if($citie['id']==$_POST['travel_to']) {echo "selected='selected'";}?>><?php echo $citie['city_name']; ?></option>
		  <?php
		    } ?> </select></p><p><label for "dep-date1">Return date </label>
				 	<input type="date" id="date" name="rdate[]" placeholder="Return date" value="<?php echo $_POST['rdate']; ?>" autofocus /></p><p><strong>     </strong></p><br/><p><strong>     </strong></p><br/><p><strong>     </strong></p><br/>
<p><label for "air-co">Select preferred Airlines</label>

		<select name="book_airline[]"> 		<option value="">Select preferred Airline</option>
		<?php
		    foreach($airlines as $airline) { ?>
		      <option value="<?php echo $airline['id']; ?>" <?php if($airline['id']==$_POST['book_airline']) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>
		  <?php
		    } ?></select> 
		</p><p><strong>     </strong></p><br/><p><label for "dep-date1">Check in date time </label>
			 	<input type="date" id="date" name="late_checkin_date[]" value="<?php echo $_POST['late_checkin_date']; ?>" placeholder="Check in date time" autofocus /></p>

</div>








			<div class="col-3-grid"><p><label for "air-co">Select preferred Airlines</label>
		<select name="book_airline[]"> <option value="">Select preferred Airlines</option>
		<?php
		    foreach($airlines as $airline) { ?>
		      <option value="<?php echo $airline['id']; ?>"<?php if($airline['id']==$_POST['book_airline']) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>
		  <?php
		    } ?></select> 
		</p>

<p><label for "air-pickup">Preferred Airline Time</label><select name="preferred_airline_time[]"><option value="">Select Airline Time</option>
 <option value="1" <?php if($_POST['preferred_airline_time']==1) {echo "selected='selected'";}?>>12:00am to 3:000am</option>     
 <option value="2" <?php if($_POST['preferred_airline_time']==2) {echo "selected='selected'";}?>>03:00am to 6:000am</option>      
<option value="3" <?php if($_POST['preferred_airline_time']==3) {echo "selected='selected'";}?>>06:00am to 9:000am</option> 
<option value="4" <?php if($_POST['preferred_airline_time']==4) {echo "selected='selected'";}?>>9:00am to 12:000pm</option>
 <option value="5" <?php if($_POST['preferred_airline_time']==5) {echo "selected='selected'";}?>>12:00pm to 3:000pm</option>
 <option value="6" <?php if($_POST['preferred_airline_time']==6) {echo "selected='selected'";}?>>03:00pm to 6:000pm</option> 
<option value="7" <?php if($_POST['preferred_airline_time']==7) {echo "selected='selected'";}?>>06:00pm to 9:000pm</option>
 <option value="8" <?php if($_POST['preferred_airline_time']==8) {echo "selected='selected'";}?>>09:00pm to 12:000am</option>
		</select>  </p>

<p><strong>     </strong></p><br/><p><strong>     </strong></p><br/><p><strong>     </strong></p><br/>

<p><label for "air-pickup">Preferred Airline Time</label><select name="preferred_airline_time[]"><option value="">Select Airline Time</option>
 <option value="1" <?php if($_POST['preferred_airline_time']==1) {echo "selected='selected'";}?>>12:00am to 3:000am</option>     
 <option value="2" <?php if($_POST['preferred_airline_time']==2) {echo "selected='selected'";}?>>03:00am to 6:000am</option>      
<option value="3" <?php if($_POST['preferred_airline_time']==3) {echo "selected='selected'";}?>>06:00am to 9:000am</option> 
<option value="4" <?php if($_POST['preferred_airline_time']==4) {echo "selected='selected'";}?>>9:00am to 12:000pm</option>
 <option value="5" <?php if($_POST['preferred_airline_time']==5) {echo "selected='selected'";}?>>12:00pm to 3:000pm</option>
 <option value="6" <?php if($_POST['preferred_airline_time']==6) {echo "selected='selected'";}?>>03:00pm to 6:000pm</option> 
<option value="7" <?php if($_POST['preferred_airline_time']==7) {echo "selected='selected'";}?>>06:00pm to 9:000pm</option>
 <option value="8" <?php if($_POST['preferred_airline_time']==8) {echo "selected='selected'";}?>>09:00pm to 12:000am</option>
		</select>  </p>

<p><strong>     </strong></p><br/>		<p><label for "air-co"> Late Checkout</label><input type="checkbox" name="late_checkout[]" value="yes" <?php if($_POST['late_checkout']=='yes'){echo "checked='checked'"; }?>></p>

		</div>
</fieldset>

<span class="f-leg"><img src="img/car.png" width="32px" height="32px"/>Car Booking</span>

	    <!--div class="in-bloc cent"><img src="img/bag.jpg" alt="profile creation" /><h1 class="in-bloc">Car Booking</h1></div-->

			      <fieldset name "dest-dep"><p><strong>Onward Journey</strong></p>
				<div class="col-3-grid">
	<p><input type="checkbox" name="airport_drop[]" value="yes"  <?php if($_POST['airport_drop']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport drop</label>&nbsp;</p>
			<p><input type="checkbox" name="airport_pickup[]" value="yes"  <?php if($_POST['airport_pickup']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport pick up</label>&nbsp;</p>
			<p><label for "air-co"> Need car for the entire day</label><input type="checkbox" name="need_car[]" value="yes"<?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p>

<!--p><label for "dep-date1">Departure date </label>
				 	<input type="date" id="date" name="date[]" placeholder="Departure date" autofocus /></p>
<p><label for "dep-date1">Return date </label>
				 	<input type="date" id="date" name="rdate[]" placeholder="Return date" autofocus /></p-->
				<p><label for "car-co">Select preferred car vendor co.</label><select name="car_company[]" id="car_company" class="car_company">
<option value="">Select preferred car vendor co.</option>
			<?php
			    foreach($cars as $car) { ?>
			      <option value="<?php echo $car['id']; ?>"<?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
			  <?php
			    } ?>

			</select> </p>
<p><strong>Return Journey</strong></p>

	<p><input type="checkbox" name="airport_drop[]" value="yes" <?php if($_POST['airport_drop']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport drop</label>&nbsp;</p>
			<p><input type="checkbox" name="airport_pickup[]" value="yes" <?php if($_POST['airport_pickup']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport pick up</label>&nbsp;</p>
			<p><label for "air-co"> Need car for the entire day</label><input type="checkbox" name="need_car[]" value="yes"<?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p>

<!--p><label for "dep-date1">Departure date </label>
				 	<input type="date" id="date" name="date[]" placeholder="Departure date" autofocus /></p>
<p><label for "dep-date1">Return date </label>
				 	<input type="date" id="date" name="rdate[]" placeholder="Return date" autofocus /></p-->
				<p><label for "car-co">Select preferred car vendor co.</label><select name="car_company[]" id="car_company" class="car_company">
<option value="">Select preferred car vendor co.</option>
			<?php
			    foreach($cars as $car) { ?>
			      <option value="<?php echo $car['id']; ?>"<?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
			  <?php
			    } ?>

			</select> </p>
			</div>



<div class="col-3-grid">					
<p><label for "air-pickup">Pickup Location</label><input type="text" id="airport_pickup_loca" name="airport_pickup_loca[]" value="<?php echo $_POST['airport_pickup_loca']; ?>"autofocus /></p>
			<p><label for "air-pickup">Drop Location</label><input type="text" id="airport_drop_loca" name="airport_drop_loca[]" value="<?php echo $_POST['airport_drop_loca']; ?>"autofocus /></p>
		<p><label for "car-co">Pick up City</label><input type="text" id="pickupcity" name="pickupcity[]" value="" readonly="readonly"value="<?php echo $_POST['pickupcity']; ?>"></p>
<p><label for "air-pickup">Car type</label><input type="text" id="car_type" name="car_type[]" value="<?php echo $_POST['car_type']; ?>"autofocus />
<label for "air-pickup">Car size</label><input type="text" id="car_size" name="car_size[]" value="<?php echo $_POST['car_size']; ?>"autofocus /></p>
					<p><strong>     </strong></p><br/><p><label for "air-pickup">Pickup Location</label><input type="text" id="airport_pickup_loca" name="airport_pickup_loca[]" value="<?php echo $_POST['airport_pickup_loca']; ?>"autofocus /></p>
			<p><label for "air-pickup">Drop Location</label><input type="text" id="airport_drop_loca" value="<?php echo $_POST['airport_drop_loca']; ?>"name="airport_drop_loca[]" autofocus /></p>



		<p><label for "car-co">Pick up City</label><input type="text" id="pickupcity" name="pickupcity[]" value="" readonly="readonly"value="<?php echo $_POST['pickupcity']; ?>"></p>
<p><label for "air-pickup">Car type</label><input type="text" id="car_type" name="car_type[]" value="<?php echo $_POST['car_type']; ?>"autofocus />
<label for "air-pickup">Car size</label><input type="text" id="car_size" name="car_size[]" value="<?php echo $_POST['car_size']; ?>"autofocus /></p>
</fieldset>
</div></div>
<div class="row">
<div class="multidiv" id="multidiv" style="display:block;"> 
   <!-- Destination and Departure details--><div id="multidivdd" class="multidivdd">
		<span class="f-leg"><img src="img/destination2.png" />Destination and departure details</span>
		      <fieldset name "dest-dep">
			<div class="col-3-grid"><p><label for "from1" name="onwardcity"  ><span style="color:red;">*</span>From City</label>
<select name="onwardcity[]" id="onward_citymulti" ><option value=""><!--list to be populated dynamically-->From City</option>

		<?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id']; ?>"<?php if($citie['id']==$_POST['onwardcity']) {echo "selected='selected'";}?>><?php echo $citie['city_name'] ?></option>
		  <?php
		    } ?>
		 </select> </p>
			<p><label for "TO1" name="travel_to"><span style="color:red;">*</span>To City</label><select name="travel_to[]" id="travel_to" ><option value="">To City</option><?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id']; ?>"<?php if($citie['id']==$_POST['travel_to']) {echo "selected='selected'";}?>><?php echo $citie['city_name']; ?></option>
		  <?php
		    } ?> </select></p>
<p><label for "dep-date1">Departure date </label>
				 	<input type="date" id="date" name="date[]" placeholder="Departure date"value="<?php echo $_POST['date']; ?>" autofocus /></p>
<!--p><label for "dep-date1">Return date </label>
				 	<input type="date" id="date" name="rdate[]" placeholder="Return date" autofocus /></p-->

				

		<p><label for "air-co">Select preferred Airlines</label>
		<select name="book_airline[]"> <option value="">Select preferred Airlines</option>
		<?php
		    foreach($airlines as $airline) { ?>
		      <option value="<?php echo $airline['id']; ?>" <?php if($airline['id']==$_POST['book_airline']) {echo "selected='selected'";}?>><?php echo $airline['name']; ?></option>
		  <?php
		    } ?></select> 
		</p>
		   


			<p><label for "air-pickup">Preferred Airline Time</label><select name="preferred_airline_time[]">
<option value="">Select Airline Time</option>
 <option value="1" <?php if($_POST['preferred_airline_time']==1) {echo "selected='selected'";}?>>12:00am to 3:000am</option>     
 <option value="2" <?php if($_POST['preferred_airline_time']==2) {echo "selected='selected'";}?>>03:00am to 6:000am</option>      
<option value="3" <?php if($_POST['preferred_airline_time']==3) {echo "selected='selected'";}?>>06:00am to 9:000am</option> 
<option value="4" <?php if($_POST['preferred_airline_time']==4) {echo "selected='selected'";}?>>9:00am to 12:000pm</option>
 <option value="5" <?php if($_POST['preferred_airline_time']==5) {echo "selected='selected'";}?>>12:00pm to 3:000pm</option>
 <option value="6" <?php if($_POST['preferred_airline_time']==6) {echo "selected='selected'";}?>>03:00pm to 6:000pm</option> 
<option value="7" <?php if($_POST['preferred_airline_time']==7) {echo "selected='selected'";}?>>06:00pm to 9:000pm</option>
 <option value="8" <?php if($_POST['preferred_airline_time']==8) {echo "selected='selected'";}?>>09:00pm to 12:000am</option>
		</select> </p>

			<p><label for "hotel"> Preferred hotel in the city</label><select id="pref_hotel" class="pref_hotel" name="pref_hotel[]"> 
		<option value="">Preferred hotel in the city</option>
		<?php
		    foreach($hotels as $hotel) { ?>
		      <option value="<?php echo $hotel['id']; ?>" <?php if($hotel['id']==$_POST['pref_hotel']) {echo "selected='selected'";}?>><?php echo $hotel['hotel_name']; ?></option>
		  <?php
		    } ?>

		</select></p>
		</div>
		      <div class="col-3-grid"><p><strong>Hotel Booking</strong></p><p><label for "air-co"> Late Checkin</label><input type="checkbox" name="late_checkin[]" value="yes"<?php if($_POST['late_checkin']=='yes'){echo "checked='checked'"; }?> ></p>
		<p><label for "dep-date1">Check in date time </label>
			 	<input type="date" id="date" name="late_checkin_date[]" value="<?php echo $_POST['late_checkin_date']; ?>"placeholder="Check in date time" autofocus /></p>

		<p><label for "air-co"> Late Checkout</label><input type="checkbox" name="late_checkout[]" <?php if($_POST['late_checkout']=='yes'){echo "checked='checked'"; }?> value="yes"></p>
		<p><label for "dep-date1">Check out date time</label>
			 	<input type="date" id="date" name="late_checkout_date[]"value="<?php echo $_POST['late_checkout_date']; ?>" placeholder="Check out date time" autofocus /></p>
</div></fieldset></div><div id="containerdd" style="display:none;"></div>
<div class="btn-set"> <input type="button" class=""  id="btnadddd"  value="ADD" /></div>


<div id="multidivcar" class="multidivcar">
			<span class="f-leg"><img src="img/car.png" width="32px" height="32px"/>Car Booking</span>

	    <!--div class="in-bloc cent"><img src="img/bag.jpg" alt="profile creation" /><h1 class="in-bloc">Car Booking</h1></div-->
			      <fieldset name "dest-dep">
				<div class="col-3-grid">
	<p><input type="checkbox" name="airport_drop[]" value="yes"  <?php if($_POST['airport_drop']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport drop</label>&nbsp;</p>
			<p><input type="checkbox" name="airport_pickup[]" value="yes" <?php if($_POST['airport_pickup']=='yes'){echo "checked='checked'"; }?>><label for "air-co">Need Airport pick up</label>&nbsp;</p>
			<p><label for "air-co"> Need car for the entire day</label><input type="checkbox" name="need_car[]" value="yes"  <?php if($_POST['need_car']=='yes'){echo "checked='checked'"; }?>></p>

<!--p><label for "dep-date1">Departure date </label>
				 	<input type="date" id="date" name="date[]" placeholder="Departure date" autofocus /></p>
<p><label for "dep-date1">Return date </label>
				 	<input type="date" id="date" name="rdate[]" placeholder="Return date" autofocus /></p-->
				<p><label for "car-co">Select preferred car vendor co.</label><select name="car_company[]" id="car_company" class="car_company">
<option value="">Select preferred car vendor co.</option>
			<?php
			    foreach($cars as $car) { ?>
			      <option value="<?php echo $car['id']; ?>" <?php if($car['id']==$_POST['car_company']) {echo "selected='selected'";}?>><?php echo $car['name']; ?></option>
			  <?php
			    } ?>

			</select> </p>
			</div>
<div class="col-3-grid">				 	<p><label for "air-pickup">Pickup Location</label><input type="text"  value="<?php echo $_POST['airport_pickup_loca']; ?>" id="airport_pickup_loca" name="airport_pickup_loca[]" autofocus /></p>


			<p><label for "air-pickup">Drop Location</label><input type="text" id="airport_drop_loca" name="airport_drop_loca[]" value="<?php echo $_POST['airport_drop_loca']; ?>"autofocus /></p>



		<p><label for "car-co">Pick up City</label><input type="text" id="pickupcity" name="pickupcity[]" value="<?php echo $_POST['pickupcity']; ?>" readonly="readonly"></p>
<p><label for "air-pickup">Car type</label><input type="text" id="car_type" name="car_type[]" value="<?php echo $_POST['car_type']; ?>" autofocus />
<label for "air-pickup">Car size</label><input type="text" id="car_size" name="car_size[]" value="<?php echo $_POST['car_size']; ?>"autofocus /></p>
<!--/div></fieldset>
--> <!-- SKK -->
</div></div>
     </div> 
 




<div id="container2" style="display:none;"></div> 




<div id="containercar" style="display:none;"></div>
<div class="btn-set"> <input type="button" class="" id="btnaddcar" value="Add car booking" /></div>
   <div class="row">
       <!-- additional instructions-->
       <span class="f-leg"><img src="img/note2.png" />Special mention</span>
      <fieldset name "special-notes">
        <textarea name="special_mention" placeholder="Please mention any depcific requirements" rows="5" ><?php echo $_POST['special_mention']; ?></textarea></p>
      </fieldset>
       
   </div>
    <div class="row cent"><input type="SUBMIT" value="SUBMIT" id="add" onclick="return validateform();"/> <?php  $type=$u->getUserType();if($type=='Employee'){?> <input type="button"value="CANCEL"onclick="javascript:window.location='emp-board.php';"><?php }?>
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

  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script type="text/javascript">

$(document).ready(function () {
        var iCnt = 1;

        $('#btnaddcar').on('click', function () { //alert("hiii");


      $('#multidivcar')
                .clone().val('')      // CLEAR VALUE.
// $('#ffp').find('input').val('')
                .attr('style', 'margin:3px 0;', 'id', 'multidivcar' + iCnt)     // GIVE IT AN ID.
                .appendTo("#containercar");

            // ADD A SUBMIT BUTTON IF ATLEAST "1" ELEMENT IS CLONED.
            if (iCnt == 1) {
                var divSubmit = $(document.createElement('div'));

            }
            $('#containercar').after(divSubmit);
            $("#containercar").attr('style', 'display:block;margin:3px;');

            iCnt = iCnt + 1;
        });
    });



    $(document).ready(function () {
        var iCnt = 1;

        $('#btnadddd').on('click', function () {
            $('#multidivdd')
                .clone().val('')      // CLEAR VALUE.
                .attr('style', 'margin:3px 0;', 'id', 'multidivdd' + iCnt)     // GIVE IT AN ID.
                .appendTo("#containerdd");

            // ADD A SUBMIT BUTTON IF ATLEAST "1" ELEMENT IS CLONED.
            if (iCnt == 1) {
                var divSubmit = $(document.createElement('div'));

            }
            $('#containerdd').after(divSubmit);
            $("#containerdd").attr('style', 'display:block;margin:3px;');

            iCnt = iCnt + 1;
        });
    });
//round trip
$(document).ready(function() {
   $('input[type="radio"]').click(function() {
       if($(this).attr('id') == 'twoway') { //alert("hiiiiiiiiiiii");
	$('#container1').show();   	
	$('#onewaydiv').hide();  
	$('#multidiv').hide();    
       }
       else if($(this).attr('id') == 'multi') { //alert("hiiiiiiiiiiii");
        $('#container1').hide();
	$('#multidiv').show();
	$('#onewaydiv').hide();         
       }
 	else if($(this).attr('id') == 'oneway') { //alert("hiiiiiiiiiiii");
        $('#container1').hide();
	$('#multidiv').hide();
	$('#onewaydiv').show();         
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



</script>

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

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


  <script>

/*$(document).ready(function () {

    $('#travel-booking').validate({
        rules: {
            onward_cityoneway: {
                required: true
            },
            
        },
    });

});*/

/*$(document).ready(function(){ 
   $("#add").click(function() { 
    //var trip_type = document.getElementsByName('oneway').value;
//var trip_type = document.getElementsByName('trip_type');

 var onward_cityoneway = $("#onward_cityoneway").val();
var traveltooneway = $("#traveltooneway").val();

var onward_cityround =$('#onward_cityround').val();
var traveltoround =$('#traveltoround').val();

var onward_citymult =$('#onward_citymult').val();
var traveltomulti =$('#traveltomulti').val();





	//For Oneway
         if(document.getElementById('oneway').checked) {
 
alert(onward_cityoneway);
			if (onward_cityoneway == ''){
            			alert("Dont leave blank From City!");return false;
        	            }
			if (traveltooneway == ''){
            			alert("Dont leave blank To City!");return false;
        	            }
          }
//For Round
         if(document.getElementById('twoway').checked) {
			if (onward_cityround == ''){
            			alert("Dont leave blank Onward City!");return false;
        	            }
			if (traveltoround == ''){
            			alert("Dont leave blank Return City!");return false;
        	            }
          }
//For Multi
         if(document.getElementById('multi').checked) {
			if (onward_citymult == ''){
            			alert("Dont leave blank From City!");return false;
        	            }
			if (traveltomulti == ''){
            			alert("Don leave blank To City!");return false;
        	            }
          }

        }); 
   
});*/

/*function validateform(){  
   var onwardcity = new Array();
    <?php foreach($onwardcity as $key => $val){ ?>
        onwardcity.push('<?php echo $val; ?>');
    <?php } ?>
	var travel_to = new Array();
    <?php foreach($travel_to as $key => $val){ ?>
        travel_to.push('<?php echo $val; ?>');
    <?php } ?>
alert(onwardcity);
	if (onwardcity.length == 0) {
	alert("From City can't be blank");  
return false;
	}
	if (travel_to.length == 0) {
	alert("To City can't be blank");  
  	return false; 
	}
}*/

function validateform(){  
alert('hii');
/*var card = document.getElementById("onward_cityoneway")[0].value;
var strUser = card.options[card.selectedIndex].value;alert(strUser);
if(strUser=='blank') {
     alert('select one answer');  	return false; 
}
else {
    var selectedText = card.options[card.selectedIndex].text;
    alert(selectedText);
}*/
//	var selectedanswer=document.getElementById("onward_cityoneway").selectedIndex;

	var x = document.getElementById("onward_cityoneway");

	for(var i = 0; i < x.length; i++) { 
 var xx =  x.options[i].text;	alert(xx);
	  if(xx == 'blank'){
	alert('select one answer');  	return false;  }
			
		}
}
</script>

</body>
</html>
