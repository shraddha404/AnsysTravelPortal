<?php session_start();
if($_SESSION['user_type'] == 'Travel Desk'){
	include_once ('../lib/TravelDesk.class.php');
	$u = new TravelDesk($_SESSION['user_id']);
}
else{
    header("Location:/login.php");
}$trip_id=$_GET['trip_id'];?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<?php $trip=$u->getTripDetails($trip_id);
$getdestdeps=$u->getdestdep($trip_id);
//print_r($getdestdeps);
$cities = $u->cities();
$airlines = $u->airlines();
$hotels = $u->hotels();
$cars = $u->cars();
//print_r($trip);


if($_POST){  //print_r($_POST);exit;
if(isset($_POST['action']) && $_POST['action'] == 'Delete Air Booking'){
	$u->deleteAirBooking($_POST['airbookingid']);
}
if(isset($_POST['action']) && $_POST['action'] == 'Delete Car Booking'){
	$u->deleteCarBooking($_POST['carbookingid']);
}
if(isset($_POST['action']) &&  $_POST['action'] == 'Delete Hotel Booking'){
	$u->deleteHotelBooking($_POST['hotelbookingid']);
}
if(isset($_POST['action']) &&  $_POST['action'] == 'Delete Train Booking'){
	$u->deleteTrainBooking($_POST['trainbookingid']);
}
if(isset($_POST['addair_booking']) &&  $_POST['addair_booking'] == 'ADD'){
$airbookings = $u->airBookings($_POST);
}
if(isset($_POST['addcar_booking']) && $_POST['addcar_booking'] == 'ADD'){
	$carbookings = $u->carBookings($_POST);
}
if(isset($_POST['addhotel_booking']) && $_POST['addhotel_booking'] == 'ADD'){ 
	$hotelbookings = $u->hotelBookings($_POST);
}
if(isset($_POST['addtrain_booking']) && $_POST['addtrain_booking'] == 'ADD'){
	$trainbookings = $u->trainBookings($_POST);
}

if($_POST['notify'] == 'Notify Employee the Suggested Plan'){
$u->notifyEmployee($trip_id);
}

//$details = $u->travelrequestsuggestedplan($_POST);
}

$air_bookings = $u->getAirBookings($trip_id);
//print_r($air_bookings);
$car_bookings = $u->getCarBookings($trip_id);
//print_r($car_bookings);
$hotel_bookings = $u->getHotelBookings($trip_id);
//print_r($hotel_bookings);
$train_bookings = $u->getTrainBookings($trip_id);
//print_r($train_bookings);
?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
<div id="menuinc"></div>
<div class="in-bloc cent row"><img src="img/to-fro.jpg" alt="Travel-plan-suggest" /><h1 class="in-bloc">Suggested Plan for Booking request ID- <?php echo $trip['id'];?><!-- dynamically pulled--></h1></div>
<form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data">
<div class="row"><!--row begins--> <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>
<span class="f-leg"><img src="img/user32.png" />Suggested plan</span>

<table>
<tr>
<td width="22%">Employee Name</td>          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>"></td>
<td width="78%"><?php echo $trip['firstname'].'  '. $trip['middlename'].'  '.$trip['lastname'];?></td>
</tr>
<tr>
<td width="22%">Purpose of visit</td>
<td><?php echo $trip['purpose_of_visit'];?></td>
</tr>
<tr>
<td>Trip type</td>
<td><?php 
if($trip['booking_type']=='airline'){  echo $trip['trip_type'].'   '."Air Booking"; }
else if($trip['booking_type']=='hotel'){  echo "Hotel Booking Only"; }
else if($trip['booking_type']=='car'){  echo "Car Booking Only"; }
else if($trip['booking_type']=='train'){  echo "Train Booking Only"; }?>
</td>
</tr>
<tr>
<td>Special instructions</td>
<td><?php echo $trip['special_mention'];?></td>
</tr>
<tr>
<td>Contact Number</td>
<td><?php echo $trip['contact_no'];?></td>
</tr>
<tr>
<td>Email</td>
<td><?php echo $trip['email'];?></td>
</tr>
 <tr>
    <td>Phone Number</td>
    <td><?php echo $trip['contact_no']; ?></td>
  </tr>
<tr>
<td>Business unit</td>
<td><?php  $bu=$u->getbus($trip['bu']); echo $bu['bu_short_name'];?></td>
</tr>
<td>Organization unit</td>
<td><?php  $ou=$u->getous($trip['ou']); echo $ou['ou_short_name'];?></td>
</tr>
<tr>
<td>Address</td>
<td><?php echo  $trip['address1'].' '.$trip['address2'];?></td>
</tr>
<!--tr>
<td>Need Car for entire duration of stay </td>
<td><?php echo $getdestdeps[0]['need_car'];?></td>
</tr-->
<?php if((empty($air_bookings)&& empty($car_bookings) && empty($hotel_bookings)) && empty($train_bookings)) { ?>
<?php } else  {?>
<tr>
<td colspan="2"><div class="db-btn-set"><input type="SUBMIT" name="notify" value="Notify Employee the Suggested Plan" /></div></td>
</tr>

<?php }?>
</table>
</form>
</div><!-- row ends-->

<div class="row"><!--row begins-->


<?php 
//$getdestdeps=array_reverse($getdestdeps);
#print_r($getdestdeps);
//foreach ($getdestdeps as $getdestdep){
//list($a,$c) = $getdestdep;
//$getdestdep= value_reverse($getdestdep);

 /****************************************************Start Airline Booking ***********************************************************************************/
if($trip['booking_type']=='airline'){ # If Airline ?>
    
<span class="f-leg"><img src="img/travel_details.png" />Airline details</span>
<?php /****************************************************Airline Booking List***********************************************************************************/?>
	<table class="resp">
	<thead>
	<tr>
	<th>Airline</th>
	<th>Preferred Airline Time</th>
	<th>From location</th>
	<th>Destination Address</th>
	<th>Departure date</th>
	<th>Departure time</th>
	<th>Flight Meal preference</th>
	<th>Cost</th>	  
	<th>Action</th>
	</tr>
	</thead>
	<tbody>
<?php $i=0;
$s=0;
foreach($air_bookings as $air_booking){# foreach air booking list
## display the detials
//echo $s;?>
	<form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data">
		<tr>
		<!--td><?php $airline = $u->getairlines($air_booking['book_airline']); echo $airline['name'];?></td-->
		<td><?php $airline = $u->getairlines($air_booking['book_airline']); if($airline['id']==0){echo $air_booking['otherair'];  }else { echo $airline['name'];}?> </td>
		<input type="hidden" name="preferred_airline_time" value="<?php echo $air_booking['preferred_airline_time'];?>">


<td><?php echo $air_booking['preferred_airline_time'];?></td>
	<?php /*if($trip['trip_type']=='Round trip' && $s==1) {?>
		<td><?php $cityto=$u->getcity($air_booking['travel_to']); if($air_booking['travel_to']==0){echo $air_booking['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
		<td><?php $city=$u->getcity($air_booking['travel_from']);if($air_booking['travel_from']==0){echo $air_booking['otheronwardcity'];  }else { echo $city['city_name'];}?></td>
	<?php }else{?>
		<td><?php $city=$u->getcity($air_booking['travel_from']);if($air_booking['travel_from']==0){echo $air_booking['otheronwardcity'];  }else { echo $city['city_name'];}?></td>
		<td><?php $cityto=$u->getcity($air_booking['travel_to']); if($air_booking['travel_to']==0){echo $air_booking['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
	<?php }*/ ?>
		<td><?php $city=$u->getcity($air_booking['travel_from']);if($air_booking['travel_from']==0){echo $air_booking['otheronwardcity'];  }else { echo $city['city_name'];}?></td>
		<td><?php $cityto=$u->getcity($air_booking['travel_to']); if($air_booking['travel_to']==0){echo $air_booking['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>

		<td><?php echo $air_booking['date'];?></td>
		<td><?php echo $air_booking['departure_time'];?></td>
		<td><?php echo $air_booking['meal_preference'];?></td>
		<td><?php echo $air_booking['cost'];?></td>	
		<input type="hidden" name="airbookingid" value="<?php echo $air_booking['id'];?>">
		<?php if(empty($air_bookings)) { ?>
		<?php } else  {?><td><input type="submit" name="action" value="Delete Air Booking" /></td><?php } ?>
		</tr>

		<tr>
		<td colspan="4">E Ticket: <?php if(!empty($air_booking['e_ticket'])){ ?><a href="uploads/e-tickets/<?php echo $air_booking['e_ticket'];?>">View E-Ticket </a> <?php } ?></td><td>Ticket Number:<?php echo $air_booking['ticket_number'];?></td> 
		</tr>
	</form>
<?php $s++;}# End foreach air booking list

 /****************************************************Added Airline Booking***********************************************************************************/?>	
<?php foreach ($getdestdeps as $getdestdep){ # foreach insert Airline Booking?>
<form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data">
	<tr>
	<td>	
            <input type="hidden" id="trip_type" name="trip_type" value="<?php echo $trip['trip_type'];?>">
<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip['id'];?>">
<input type="hidden" id="hotel_id" name="hotel_id" value="<?php echo $hotel_bookings['hotel_id'];?>">
<input type="hidden" id="car_company" name="car_company" value="<?php echo $car_bookings['car_company'];?>">
<input type="hidden" id="airport_drop" name="airport_drop" value="<?php echo $car_bookings['airport_drop'];?>">
<input type="hidden" id="airport_pickup" name="airport_pickup" value="<?php echo $car_bookings['airport_pickup'];?>">
<input type="hidden" id="airport_drop_lc" name="airport_drop_lc" value="<?php echo $car_bookings['airport_drop_loca'];?>">
<input type="hidden" id="airport_pickup_lc" name="airport_pickup_lc" value="<?php echo $car_bookings['airport_pickup_loca'];?>">
<input type="hidden" id="travel_from" name="travel_from" value="<?php echo $getdestdep['travel_from'];?>">
<input type="hidden" id="travel_to" name="travel_to" value="<?php echo $getdestdep['travel_to'];?>">
<input type="hidden" id="update_id" name="update_id" value="<?php echo $getdestdep['id'];?>">
<input type="hidden" name="bookingrequestid" value="<?php echo $getdestdep['id'];?>">

	<select name="book_airline" id="book_airline"> 
	<?php $airlinesdel=$u->getairlines($getdestdep['book_airline']); 
        
	foreach($airlines as $airline) { ?>
            
	<option value="<?php echo $airline['id']; ?>"  <?php if($airlinesdel['name']==$airline['name']){ echo "selected"; }?> ><?php echo $airline['name']; ?></option>
	<?php
	} ?><option value="0"  <?php if($getdestdep['book_airline']==0) { echo "selected"; }?>>Others</option></select>
<?php if($airlinesdel['id']==0) { ?><div id="divairtext" style="display:block;"><?php echo $getdestdep['otherair'];?></div><?php }?>
	<div id="divair" style="display:none;">Other Airline:<input type="text" id="otherair" name="otherair" placeholder="Other Airline"  value="<?php echo $getdestdep['otherair'];?>" autofocus /></div></td>
		<input type="hidden" name="preferred_airline_time" value="<?php echo $getdestdep['preferred_airline_time'];?>">
	<td><?php echo $getdestdep['preferred_airline_time'];?></td>
<!-----for round trip travel to and form city -------->

<?php if(($i==1 && $trip['trip_type']=='Round trip')) { ?><input type="hidden" id="travel_to" name="travel_to" value="<?php echo $getdestdep['travel_from'];?>">
<input type="hidden" id="travel_from" name="travel_from" value="<?php echo $getdestdep['travel_to'];?>">



<input type="hidden" id="travel_from" name="travel_from" value="<?php echo $getdestdep['travel_to'];?>">

	<td><?php $cityto=$u->getcity($getdestdep['travel_to']); if($getdestdep['travel_to']==0) { echo $getdestdep['othertravel_to']; }else{echo $cityto['city_name'];}?></td>
<td><?php $city=$u->getcity($getdestdep['travel_from']);  if($getdestdep['travel_from']==0) { echo $getdestdep['otheronwardcity']; }else{echo $city['city_name'];}?></td><!--col elements should be editable if employee clicks on Amend plan-->
<?php  } else {?><!-----for Othre than round trip travel to and form city -------->
<td><?php $city=$u->getcity($getdestdep['travel_from']); if($getdestdep['travel_from']==0) { echo $getdestdep['otheronwardcity'];?> <input type="hidden" id="travel_from" name="otheronwardcity" value="<?php echo $getdestdep['otheronwardcity'];?>"><?php }
else{echo $city['city_name'];?> <input type="hidden" id="travel_from" name="travel_from" value="<?php echo $getdestdep['travel_from'];?>"><?php }?></td><!--col elements should be editable if employee clicks on Amend plan-->

	<td><?php $cityto=$u->getcity($getdestdep['travel_to']);if($getdestdep['travel_to']==0) { echo $getdestdep['othertravel_to']; ?> <input type="hidden" id="travel_to" name="othertravel_to" value="<?php echo $getdestdep['othertravel_to'];?>"><?php }else{echo $cityto['city_name'];?> <input type="hidden" id="travel_to" name="travel_to" value="<?php echo $cityto['id'];?>"><?php }?></td>

<?php }?>

<input type="hidden" name="dest_dept_id" value="<?php echo $getdestdep['id'];?>">
	<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
	<input type="hidden" name="tripempid" value="<?php echo $trip['emp_id'];?>"></td>
<!-----for round trip Departure date -------->
	<?php if($trip['trip_type']=='Round trip'){ if(($i==1 && $trip['trip_type']=='Round trip')) { ?>
<td><input type="text" id="date<?php echo $i.$getdestdep['id'];?>" class="datepick" name="date" placeholder="Departure date"  value="<?php echo $getdestdep['return_date'];?>" autofocus /></td><?php }else{?>
<td><input type="text" id="date<?php echo $i.$getdestdep['id'];?>" class="datepick" name="date" placeholder="Departure date"  value="<?php echo $getdestdep['date'];?>" autofocus /></td><?php }?>
<!-----for Other all trips Departure date -------->
<?php }else {?><td><input type="text" id="date<?php echo $getdestdep['id'];?>" class="datepick" name="date" placeholder="Departure date"  value="<?php echo $getdestdep['date'];?>" autofocus /></td><?php }?>
	



<td><input type="text" id="departure_time" name="departure_time" value="">
	<td><input type="text" id="meal_preference" name="meal_preference"  value="<?php echo $getdestdep['meal_preference'];?>"/>
	<td><input type="text" id="cost" name="cost" value="<?php if(empty($getdestdep['cost'])){ echo  'N/A'; }else{ echo $getdestdep['cost']; }?>"/>
	<td><div class="db-btn-set"><input type="SUBMIT" name="addair_booking" value="ADD" onclick="return confirm('Are you sure you want to add air booking?');"/></div></td>
	</tr>
	<tr>
	<td colspan="4">E Ticket: <input type="file" id="e-ticket" name="e-ticket" required></td><td>Ticket Number:<input type="text" id="ticket_number" name="ticket_number" value="<?php echo $getdestdep['ticket_number'];?>" required>
	</tr>
</form>
<?php   # End foreach getdestdeps Airline Booking
if($trip['trip_type']=='Round trip') {  $i++;  }
}?>
</tbody>
</table>
<br/><?php } # End If Airline
 /****************************************************End Airline Booking ***********************************************************************************/



 /****************************************************Start Car Booking ***********************************************************************************/?>
<?php if($trip['booking_type']=='car'  || $trip['booking_type']=='airline'){  #Only car Booking?>

	<span class="f-leg"><img src="img/travel_details.png" />Car details</span>
<?php /****************************************************Car Booking List***********************************************************************************/?>
	<table class="resp" width="800">
	<thead>
	<tr>
	<?php if($trip['trip_type'] == 'multicity'){?>
	<th> City </th>
	<?php } ?>
	<?php if(!empty($car_bookings)){?><th>Car Booking Requset Id</th><?php }?>
	<th>Car Vendor Company</th>
	  <?php if($trip['multiple_days_car']==1){?>  <th>From Date</th><?php }?>
     <?php if($trip['multiple_days_car']==1){?>      <th>To Date</th><?php }?>
	<th>Pickup Date</th>
	<?php if($trip['booking_type']!='car'){?>
	<th>Airport Drop</th>
	<th>Pickup Address</th>
	<th>Airport Pickup</th>
	<th>Destination Address</th><?php } ?>
	<th>Pickup Time</th>
	<?php if($trip['booking_type']=='car'){?> <th>Car Pickup Location</th>
	<th>Destination Address</th><?php } ?>
	<?php if($trip['booking_type']=='car'){?><th>Need car for the entire day</th><?php }else{  if($trip['multiple_days_car']==1){?> ><th>Multiple days booking</th><?php } }?>
	<th>Car Type</th>
	<th>Cost</th>
	<th>Action</th>
	</tr>
	</thead>
	<tbody>
<?php $j=0;
foreach($car_bookings as $car_booking){
## display the detials?>
<form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data"><tr>
	<?php  $city=$u->getcity($car_booking['car_for_city']);	 
	if($trip['trip_type'] == 'multicity'){ ?> <td> <?php echo $city['city_name'];?></td><?php } ?>
	<td><?php echo $car_booking['id']; ?></td>
	<td><?php $car=$u->getcars($car_booking['car_company']); echo $car['name'];?></td>
	<?php if($trip['multiple_days_car']==1){?> <td><?php echo $car_booking['car_fromdate'];?></td><?php }?>
    <?php if($trip['multiple_days_car']==1){?> <td><?php echo $car_booking['car_todate'];?></td><?php }?>
          <td><?php echo $car_booking['date'];?></td>
	<?php if($trip['booking_type']!='car'){?>
	<td><?php echo $car_booking['airport_drop'];?></td>
	<td><?php echo $car_booking['airport_pickup_loca'];?></td>
	<td><?php echo $car_booking['airport_pickup'];?></td>
	<td><?php echo $car_booking['airport_drop_loca'];?></td>
	<?php } ?>
	<td><?php echo $car_booking['pickup_time'];?></td>
		<?php if($trip['booking_type']=='car'){?> <td><?php echo $car_booking['car_pickup_location'];?></td>
	<td><?php echo $car_booking['destination'];?></td><?php }?>
	<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
	<?php if($trip['multiple_days_car']==1){?><td><?php echo $car_booking['need_car'];?></td><?php }?>

	<td><?php echo $car_booking['car_size'];?></td>
	<td><?php echo $car_booking['cost'];?></td><input type="hidden" name="carbookingid" value="<?php echo $car_booking['id'];?>">
	<td><!--a href="travel-request-suggested-plan.php?carbookingid=<?php echo $car_booking['id'];?>"><img src="img/delete.png" width="15px" height="15px"></a--><?php if(empty($car_bookings)) { ?>
	<?php } else  {?><input type="submit" name="action" value="Delete Car Booking" /></td><?php } ?>
	</tr>
</form>
<?php } ## car_bookings foreach ends ?>

<?php /****************************************************End Car Booking List***********************************************************************************/?>

<?php /****************************************************Added Car Booking***********************************************************************************/?>
<?php  foreach ($getdestdeps as $getdestdep){ # Car Booking insertion?>  
<form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data"><tr>
	<?php if(!empty($car_bookings)){?><td></td><?php }?>
        <input type="hidden" name="bookingrequestid" value="<?php echo $getdestdep['id'];?>">
	<?php if($trip['trip_type'] == 'multicity'){?>
	<td>	
	<select id="city" class="city" name="car_city"> 
	<option>Choose City</option>
	<?php
	foreach($cities as $city){
	?>
	<option value="<?php echo $city['id']; ?>" <?php if($city['id']==$getdestdep['travel_from']){ echo "selected='selected'"; }?>><?php echo $city['city_name']; ?></option>
	<?php
	}
	?>
	</select></td>
	<?php } #if ends for multicity ?>
	<td> <input type="hidden" name="trip_type" value="<?php echo $trip['trip_type'];?>">
	<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>"><input type="hidden" name="tripempid" value="<?php echo $trip['emp_id'];?>">
	<select id="car_company" class="car_company" name="car_company"> 
	<?php $cardel=$u->getcars($getdestdep['car_company']); 
	foreach($cars as $car) { ?>

	<option value="<?php echo $car['id']; ?>" <?php if($cardel['name']==$car['name']){ echo "selected='selected'"; }?>><?php echo $car['name']; ?></option>
	<?php
	} ?></select></td>
	  <?php if($trip['multiple_days_car']==1){?> <td><input type="text" id="car_fromdate<?php echo $getdestdep['id'];?>" name="car_fromdate" class="datepick" value="<?php echo $getdestdep['car_fromdate'];?>"></td><?php }?>
	<?php if($trip['multiple_days_car']==1){?> <td><input type="text" id="car_todate<?php echo $getdestdep['id'];?>" name="car_todate" class="datepick" value="<?php echo $getdestdep['car_todate'];?>"></td><?php }?>




<!-----for round trip Departure date -------->
	<?php if($trip['trip_type']=='Round trip'){ if(($j==1 && $trip['trip_type']=='Round trip')) { ?>
<td><input type="text" id="car_pickup_date<?php echo $getdestdep['id'];?>" name="car_pickup_date" class="datepick"  value="<?php echo $getdestdep['return_date'];?>" autofocus /></td><?php }else{?>
	<td><input type="text" id="car_pickup_date<?php echo $getdestdep['id'];?>" name="car_pickup_date" class="datepick" value="<?php echo $getdestdep['date'];?>"></td><?php }?>
<!-----for Other all trips Departure date -------->
<?php }else if($trip['trip_type']!='Round trip'){?>	<td><input type="text" id="car_pickup_date<?php echo $getdestdep['id'];?>" name="car_pickup_date" class="datepick" value="<?php echo $getdestdep['date'];?>"></td><?php }?>
	



	<?php if($trip['booking_type']!='car'){?>
	<td><input type="checkbox" name="airport_drop" value="yes" <?php if($getdestdep['airport_drop']=='yes'){echo 'checked=checked';}  ?>></td>

	<td><input type="text" name="airport_pickup_loca"  placeholder="Please mention pick up address" value="<?php echo $getdestdep['airport_pickup_loca'];?>"></td>
	<td><input type="checkbox" name="airport_pickup" value="yes" <?php if($getdestdep['airport_pickup']=='yes'){echo 'checked=checked';}  ?>></td>
	<td><input type="text" name="airport_drop_loca" placeholder="Please mention destination / Drop address" value="<?php echo $getdestdep['airport_drop_loca'];?>"></td><?php } ?>
	<td><input type="text" name="pickup_time" placeholder="Please mention pick up time for the drop" value="<?php echo $getdestdep['car_pickuptime'];?>"></td>
		<?php if($trip['booking_type']=='car'){?> 
			<td><input type="text" name="car_pickup_location" placeholder="Please mention pick up address" value="<?php echo $getdestdep['car_pickup_location'].','.$getdestdep['pickup_city'];?>"></td>
			<td><input type="text" name="destination"  placeholder="Please mention destination / Drop address" value="<?php echo $getdestdep['destination'];?>" ></td>
		<?php }?>
	<input type="hidden" name="tripempid" value="<?php echo $trip['emp_id'];?>">
	<?php if($trip['multiple_days_car']==1){?><td><input type="checkbox" name="need_car" value="yes" <?php if($getdestdep['need_car']=='yes'){echo 'checked=checked';}  ?>></td><?php }?>

	<td><!--input type="text" name="car_size" value="<?php echo $getdestdep['car_size'];?>"--><select name="car_size" id="car_size" >
	<option value="">Select Car Size</option>

	<option value="Mid Size" <?php if($getdestdep['car_size']=='Mid Size') {echo "selected='selected'";}?>>Mid Size</option>

	<option value="SUV" <?php if($getdestdep['car_size']=='SUV') {echo "selected='selected'";}?>>SUV</option> 
	</select></td>
	<td><input type="text" name="cost"  value="<?php if(empty($getdestdep['cost'])){ echo  'N/A'; }else{ echo $getdestdep['cost']; }?>"></td>
	<td><div class="db-btn-set"><input type="SUBMIT" name="addcar_booking" value="ADD" onclick="return confirm('Are you sure you want to add car booking?');"/></div></td>
	</tr>
</form>
</tbody>
<?php } # foreach end getdestdeps Car Booking insertion ?>
<?php if($trip['trip_type']=='Round trip') { $j++;  }?>
</table>


<?php } #If end Only car Booking?><br/><br/><?php
 /****************************************************End Car Booking ***********************************************************************************/

 /****************************************************Start Hotel Booking ***********************************************************************************/
if($trip['booking_type']=='hotel'  || $trip['booking_type']=='airline'){ ?>
<span class="f-leg"><img src="img/travel_details.png" />Hotel details</span>
<?php /****************************************************Hotel Booking List***********************************************************************************/?>

	<table class="resp">
	<thead>
	<tr>
	<?php if($trip['trip_type'] == 'multicity'){?>
	<th> City </th>
	<?php } ?>
	<th>Hotel</th>
	<th>Check in date-time</th>
	<th>Check Out date-time</th>
	<th>Confirmation Number</th>
	<th>Check in time</th>
	<th>Check out time</th>  
	<th>Action</th>
	</tr>
	</thead>
	<tbody>
<?php 
foreach($hotel_bookings as $hotel_booking){ ## $hotel_bookings foreach Starts?>

<form id="travel-booking-plan" method="post" action="">
	<tr>	
	<?php ## display the details
	$city=$u->getcity($hotel_booking['hotel_for_city']); ?>
	<?php if($trip['trip_type'] == 'multicity'){ ?> <td> <?php echo $city['city_name'];?></td><?php } ?>
	<td><?php $hotel=$u->gethotel($hotel_booking['hotel_id']); if($hotel['id']==127){echo $hotel_booking['otherhotel'];  }else { echo $hotel['hotel_name'];}?>
	</td>
	<?php if($trip['booking_type']=='hotel'){?>  
	<td><?php echo $hotel_booking['check_in'];?></td>
	<td><?php echo $hotel_booking['check_out'];?></td>
	<?php }
	else if($trip['booking_type']!='hotel'){?> 
 	<td> Checkin Date:<?php echo $hotel_booking['late_checkin_date'];?></td>  <td> Checkout Date:<?php echo $hotel_booking['late_checkout_date'];?></td>
	<?php }?>
	<td><?php echo $hotel_booking['hotel_confirmation_num'];?></td>
	<td><?php echo $hotel_booking['late_checkin'];?></td><input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
	<td><?php echo $hotel_booking['late_checkout'];?></td><input type="hidden" name="hotelbookingid" value="<?php echo $hotel_booking['id'];?>">
	<td><!--a href="travel-request-suggested-plan.php?hotelbookingid=<?php echo $hotel_booking['id'];?>"><img src="img/delete.png" width="15px" height="15px"></a-->
	<?php if(empty($hotel_bookings)) { ?>
	<?php } else  {?><input type="submit" name="action" value="Delete Hotel Booking" /> <?php } ?></td> 
	</tr>
	<tr><?php ?>
	<td>No.of Guests:<?php echo $hotel_booking['noofguests'];?></td>
	<td>No.of Rooms:<?php echo $hotel_booking['noofrooms'];?></td> <td>Room Type:<?php echo $hotel_booking['room_type'];?></td><td>Cost:<?php echo $hotel_booking['cost'];?></td>	<td></td><td></td><td></td>
	<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
        <input type="hidden" name="bookingrequestid" value="<?php echo $getdestdep['id'];?>">
	</tr>
</form>
<?php } ## $hotel_bookings foreach ends ?>


<?php /****************************************************End Hotel Booking List***********************************************************************************/?>



<?php /****************************************************Added Hotel Booking***********************************************************************************/?>

<?php $k=0; foreach ($getdestdeps as $getdestdep){ # hotel booking insertion 
//echo $k;
 if($k!=1 && $trip['trip_type']!='Round trip' || $k==0 &&  $trip['trip_type']=='Round trip') { 

//print_r($getdestdep);?> 
 <form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data">
	<tr>
	<?php if($trip['trip_type'] == 'multicity'){?>
	<td>
	<select id="city" class="city" name="hotel_city"> 
	<option>Choose City</option>
	<?php foreach($cities as $city){?>
	<option value="<?php echo $city['id']; ?>" <?php if($getdestdep['travel_to']==$city['id']){ echo "selected"; }?>><?php echo $city['city_name']; ?></option>
	<?php } ?>
	</select></td>
	<?php } #if ends for multicity ?>
	<input type="hidden" name="trip_type" value="<?php echo $trip['trip_type'];?>"> <td>
	<select id="hotel_id" class="hotel_id" name="hotel_id"> 
	<option value="">Preferred hotel in the city</option>
	<?php $hoteldel=$u->gethotel($getdestdep['pref_hotel']); 
	foreach($hotels as $hotel) { ?>
	<option value="<?php echo $hotel['id']; ?>" <?php if($hoteldel['id']==$hotel['id']){ echo "selected"; }?>><?php echo $hotel['hotel_name']; ?></option>
	<?php
	} ?>
        <option value="127" <?php if($getdestdep['pref_hotel']==0) { echo "selected"; }?>>Other</option>
        <!--<option value="0" <?php //if($getdestdep['pref_hotel']==0) { echo "selected"; }?>>Other</option>-->
	</select><?php if($getdestdep['pref_hotel']==0) { ?><div id="divhoteltext" style="display:block;">Other Hotel: <?php echo $getdestdep['otherhotel'];?></div><?php }?><div id="divhotel" style="display:none;">Other Hotel:<input type="text" id="otherhotel" name="otherhotel" placeholder="Other Hotel"  value="<?php echo $getdestdep['otherhotel'];?>" autofocus /></div></td> 
	<?php if($trip['booking_type']=='hotel'){?> 
	<td><input type="text" class="datepick" id="check_in<?php echo $getdestdep['id'];?>" name="check_in" value="<?php echo $getdestdep['checkindate'];?>"></td>
	<td><input type="text" class="datepick" id="check_out<?php echo $getdestdep['id'];?>" name="check_out" value="<?php echo $getdestdep['checkoutdate'];?>"></td>
	<?php }else if($trip['booking_type']!='hotel'){?> 
<td>  Checkin Date:<input type="text" id="late_checkin_date<?php echo $getdestdep['id'];?>" class="datepick" name="late_checkin_date" value="<?php echo $getdestdep['late_checkin_date'];?>"placeholder="Check in date time" autofocus /></td>
	<td>  Checkout Date:<input type="text" id="late_checkout_date<?php echo $getdestdep['id'];?>" class="datepick" name="late_checkout_date" value="<?php echo $getdestdep['late_checkout_date'];?>" placeholder="Check Out date time" autofocus /></td>
<?php }?>
	<td><input type="text" name="hotel_confirmation_num" value="<?php echo $getdestdep['hotel_confirmation_num'];?>" required></td>
	<td>
            <input type="text" id="checkintime" name="late_checkin" placeholder="hh:mm"  value="<?php echo $getdestdep['late_checkin'];?>"/>
            <!--<input type="checkbox" name="late_checkin" value="yes" <?php //if($getdestdep['late_checkin']=='yes'){ echo 'checked=checked';} ?>>-->
        </td>
	<td>
            <input type="text"  id="time" name="late_checkout" placeholder="hh:mm" value="<?php echo $getdestdep['late_checkout'];?>">
            <!--<input type="checkbox" name="late_checkout" value="yes" <?php // if($getdestdep['late_checkout']=='yes'){ echo 'checked=checked';} ?>>--></td><td></td>

	</tr>
<tr><input type="hidden" name="tripempid" value="<?php echo $trip['emp_id'];?>">
<input type="hidden" name="bookingrequestid" value="<?php echo $getdestdep['id'];?>">

	<td>NO.Of.Guests<input type="text" name="noofguests" value="<?php if(empty($getdestdep['noofguests'])){ echo  'N/A'; }else{ echo $getdestdep['noofguests']; }?> "></td>
	<td>No.of.Rooms<input type="text" name="noofrooms" value="<?php if(empty($getdestdep['noofrooms'])){ echo  'N/A'; }else{ echo $getdestdep['noofrooms']; }?> " ></td>
	<td>Room Type<select id="room_type" class="room_type" name="room_type"> 
	<option value="">Room Type</option>
	<option value="Smoking Room" <?php if($getdestdep['room_type']=='Smoking Room'){ echo 'selected=selected';} ?>>Smoking Room</option>
	<option value="Non Smoking Room" <?php if($getdestdep['room_type']=='Non Smoking Room'){ echo 'selected=selected';} ?>>Non Smoking Room</option>
	</select></td>	<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
        </td><td></td>
	<td>Cost:<input type="text" name="cost"  value="<?php if(empty($getdestdep['cost'])){ echo  'N/A'; }else{ echo $getdestdep['cost']; }?>"></td><td></td>	<?php if($trip['trip_type'] == 'multicity'){?><td></td><?php }?>
	<td> <div class="db-btn-set"><input type="SUBMIT" name="addhotel_booking" value="ADD" onclick="return confirm('Are you sure you want to add hotel booking?');"/></div></td>
	</tr>
</form><?php if($trip['trip_type']=='Round trip') { $k++;  } 
} #end foreach getdestdeps hotel booking insertion

 }#END  if($k!=2 && $trip['trip_type']!='Round trip' || $k==0 &&  $trip['trip_type']=='Round trip') { 

 /****************************************************End Added Hotel Booking***********************************************************************************/?>
</tbody>
</table>

<?php } # End if Only hotel Booking
 /****************************************************End Hotel Booking ***********************************************************************************/

/****************************************************Start train Booking ***********************************************************************************/
$k=0;if($trip['booking_type']=='train'){ ?>
<span class="f-leg"><img src="img/train.png" width="50px" height="50px"/><?php if(($k==0 && $trip['trip_type']=='Round trip')) { ?>Onward Journey <?php }?>
	<?php if(($k==1 && $trip['trip_type']=='Round trip')) { ?>Return Journey <?php }?>Train details</span>
<?php /****************************************************train Booking List***********************************************************************************/?>

	<table class="resp">
	<thead>
	<tr>
           <th>Name of Passenger</th>

	<th align='left'>From Location</th>
	<th align='left'>Destination Address</th>
	<th align='left'>Age</th>
	<th align='left'>Train</th>
	<th align='left'>Date</th>
	<th>Action</th></tr><!--tr>
	<th align='left'>Train Id</th>
	<th align='left'>Class</th>
	<th align='left'>Boarding From</th>
	<th align='left'>cost</th>
	<th>Action</th>
	</tr-->
	</thead>
	<tbody>
<?php foreach($train_bookings as $train_booking){//print_r($train_booking);
		## display the details?>

<form id="travel-booking-plan" method="post" action="">
        <tr><?php $uid=$_SESSION['user_id'];$row = $u->pdo->select('emp_list', '`id`='.$train_booking['emp_id']);
	$to=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];?>
         <?php $cityto=$u->getcity($train_booking['train_to']);$city=$u->getcity($train_booking['train_from']);?>
          <td><?php echo $passenger;?></td>
       
<td><input type="hidden" id="travel_from" name="travel_from" value="<?php echo $getdestdep['travel_from'];?>"><?php $city=$u->getcity($train_booking['train_from']); if($train_booking['train_from']==0) { echo $train_booking['otheronwardcity']; }
else{echo $city['city_name'];}?></td><!--col elements should be editable if employee clicks on Amend plan-->

	<td><input type="hidden" id="travel_to" name="travel_to" value="<?php echo $getdestdep['travel_to'];?>"><?php $cityto=$u->getcity($train_booking['train_to']);if($train_booking['train_to']==0) { echo $train_booking['othertravel_to']; }else{echo $cityto['city_name'];}?></td>
<input type="hidden" name="trainbookingid" value="<?php echo $train_booking['id'];?>">
          <td><?php echo $train_booking['age'];?></td>
          <td> <?php echo $train_booking['train'];?></td>
          <td> <?php echo $train_booking['date'];?></td><td></td></tr><tr>
          <td>Train Id: <?php echo $train_booking['train_id'];?></td>
          <td>Class: <?php echo $train_booking['class'];?></td>
          <td>Boarding From:<?php echo $train_booking['boarding_form'];?></td><input type="hidden" id="boarding_form" name="boarding_form" value="<?php echo $getdestdep['boarding_form'];?>">	<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
     <td>Cost:<?php echo $train_booking['cost'];?></td><td></td><td></td>
<?php if(empty($train_bookings)) { ?>
	<?php } else  {?> <td><input type="submit" name="action" value="Delete Train Booking" /></td>  <?php } ?>
	
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
	</tr></form>
<?php } ## train_bookings foreach ends ?>


<?php /****************************************************End train Booking List***********************************************************************************/?>



<?php /****************************************************Added train Booking***********************************************************************************/?>

<?php foreach ($getdestdeps as $getdestdep){ # train booking insertion?> 
 <form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data">
	<tr><?php $uid=$_SESSION['user_id'];$row = $u->pdo->select('emp_list', '`id`='.$getdestdep['emp_id']);
	$to=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];?>
	<td><?php echo $passenger;?></td>
	          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip['id'];?>">
	<td><input type="hidden" id="travel_from" name="travel_from" value="<?php echo $getdestdep['travel_from'];?>"><?php $city=$u->getcity($getdestdep['travel_from']); if($getdestdep['travel_from']==0) { echo $getdestdep['otheronwardcity']; }
else{echo $city['city_name'];}?></td><!--col elements should be editable if employee clicks on Amend plan-->

	<td><input type="hidden" id="travel_to" name="travel_to" value="<?php echo $getdestdep['travel_to'];?>"><?php $cityto=$u->getcity($getdestdep['travel_to']);if($getdestdep['travel_to']==0) { echo $getdestdep['othertravel_to']; }else{echo $cityto['city_name'];}?></td>
	<input type="hidden" name="trip_type" value="<?php echo $trip['trip_type'];?>"> 
	<td><input type="text" name="age" value="<?php echo $getdestdep['age'];?>"></td>
	<td><input type="text" name="train" value="<?php echo $getdestdep['train'];?>"></td>
	<td><input type="text" id="date<?php echo $getdestdep['id'];?>" class="datepick" name="date" value="<?php echo $getdestdep['date'];?>"></td></tr><tr>
	<td>Train Id: <input type="text" name="train_id" ></td>
	<td>Class: <select name="class" id="class" class="class">
	<option value="">Select Class</option>
	<option value="SL" <?php if($getdestdep['class']=='SL') {echo "selected='selected'";}?>>SL - Sleeper class</option>
	<option value="1A" <?php if($getdestdep['class']=='1A') {echo "selected='selected'";}?>>1A - The First class AC</option>
	<option value="2A" <?php if($getdestdep['class']=='2A') {echo "selected='selected'";}?>>2A - AC-Two tier</option>
	<option value="3A" <?php if($getdestdep['class']=='3A') {echo "selected='selected'";}?>>3A - AC three tier</option>
	<option value="2S" <?php if($getdestdep['class']=='2S') {echo "selected='selected'";}?>>2S - Seater class</option>
	<option value="CC" <?php if($getdestdep['class']=='CC') {echo "selected='selected'";}?>>CC - AC chair cars</option>
	</select></td>
	<td>Boarding From:<input type="text" name="boarding_form" value="<?php echo $getdestdep['boarding_form'];?>"></td>
	<input type="hidden" name="tripempid" value="<?php echo $trip['emp_id'];?>">
	<td>Cost:<input type="text" name="cost"  value="<?php if(empty($getdestdep['cost'])){ echo  'N/A'; }else{ echo $getdestdep['cost']; }?>"></td><td></td><td></td>
	<td>    <div class="db-btn-set"><input type="SUBMIT" name="addtrain_booking" value="ADD" onclick="return confirm('Are you sure you want to add train booking?');"/></div></td>
	</tr>
</form><?php } #end foreach getdestdeps train booking insertion
if($trip['trip_type']=='Round trip') { $k++;  }
 /****************************************************End Added train Booking***********************************************************************************/?>
</tbody>
</table>

<?php } # End if Only train Booking
 /****************************************************End Train Booking ***********************************************************************************/


## getdestdeps ends?>
<!-- Add all the html before this line -->
</div><!-- row ends-->
<!--div class="db-btn-set"><input type="SUBMIT" value="SUBMIT" /-->
</div>
</div><!--main div ends-->
<footer>
</footer>
</div><!--wrapper ends--> .
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/DateTimePicker.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<script>



/*alert(id);
    $(id).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#late_checkout_date" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#check_in" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#check_out" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#late_checkin_date" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;
    $( "#car_pickup_date" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});inline: true;


}*/

$('.datepick').each(function(){
    $(this).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
});


</script>

  <script>
(function () {
	var headertext = [];
	var headers = document.querySelectorAll("thead");
	var tablebody = document.querySelectorAll("tbody");
	
	for(var i = 0; i < headers.length; i++) {
		headertext[i]=[];
		for (var j = 0, headrow; headrow = headers[i].rows[0].cells[j]; j++) {
		  var current = headrow;
		  headertext[i].push(current.textContent.replace(/\r?\n|\r/,""));
		  }
	} 
	
	if (headers.length > 0) {
		for (var h = 0, tbody; tbody = tablebody[h]; h++) {
			for (var i = 0, row; row = tbody.rows[i]; i++) {
			  for (var j = 0, col; col = row.cells[j]; j++) {
			    col.setAttribute("data-th", headertext[h][j]);
			  } 
			}
		}
	}
} ());
</script>
  <script type="text/javascript">
 $(function () {
        $("#hotel_id").change(function () { //alert('hiiii');
var title = $("#hotel_id :selected").text();
            if (title=='Other') { //alert(title);
                $("#divhotel").show();$("#divhoteltext").hide();
            } else {
                $("#divhotel").hide();
            }
        });
    });
   $(function () {
        $("#book_airline").change(function () { //alert('hiiii');
         var title = $("#book_airline :selected").text();//alert(title);
            if (title=='Others') { 
                $("#divair").show();$("#divairtext").hide();
            } else {
                $("#divair").hide();
            }
        });
    });
</script>
  

  <!-- scripts concatenated and minified via build script -->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <script src="js/menu.js"></script>  <!-- end scripts -->

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
