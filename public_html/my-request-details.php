<?php
session_start();
include_once ('../lib/User.class.php');
$u = new User($_SESSION['user_id']);
$trip_id=$_GET['trip_id'];
if(empty($_SESSION['user_id']))
{
header("location:login.php");
}
$trip=$u->getTripDetails($trip_id);
//print_r($trip);
$getdestdeps=$u->getdestdep($trip_id);
//print_r($getdestdeps);
//echo '<br><br>';
//print_r($trip);
$cities = $u->cities();
$airlines = $u->airlines();
$hotels = $u->hotels();
$cars = $u->cars();
//print_r($_POST);
if($_POST){
 $details = $u->updatemyrequestbooking($_POST);
}

$air_bookings = $u->getAirBookings($trip_id);
$air_bookings_count= count($air_bookings);
//print_r($air_bookings);
$car_bookings = $u->getCarBookings($trip_id);
$car_bookings_count= count($car_bookings);
//print_r($car_bookings);
$hotel_bookings = $u->getHotelBookings($trip_id);
//print_r($hotel_bookings);
$train_bookings = $u->getTrainBookings($trip_id);
//print_r($train_bookings);
?><!doctype html>
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
  <div id="menuinc"></div>
  <div class="in-bloc cent row"><img src="img/to-fro.jpg" alt="Travel-plan-suggest" /><h1 class="in-bloc">Suggested Plan for Booking request ID- <?php echo $trip['id'];?><!-- dynamically pulled--></h1></div>

   <div class="row"><!--row begins--> <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>
    <span class="f-leg"><img src="img/user32.png" />Suggested plan</span>
    
  <table>
  <tr>
    <td width="22%">Employee Name</td>
    <td width="78%"><?php echo $trip['firstname'].'  '. $trip['middlename'].'  '.$trip['lastname'];?></td>
  </tr>
  <tr>
    <td>Trip type</td>
    <td><?php  // echo $trip['trip_type'];
if($trip['booking_type']=='airline'){  echo ucfirst($trip['trip_type']).'   '."Travel booking"; }
if($trip['booking_type']=='hotel'){  echo "Hotel Booking Only"; }
if($trip['booking_type']=='car'){  echo "Car Booking Only"; }
if($trip['booking_type']=='train'){  echo "Train Booking Only"; }?>
</td>
  </tr>
  <tr>
    <td>Special instructions</td>
    <td><?php echo $trip['special_mention'];?></td>
  </tr>
<tr>
    <td>Purpose of visit </td>
    <td><?php echo $trip['purpose_of_visit'];?></td>
  </tr>
<tr>
    <td>Cash Advance</td>
    <td><?php echo $trip['cost'];?></td>
  </tr>
   <tr>
    <td>Email</td>
    <td><?php echo $trip['email']; ?></td>
  </tr>
 <tr>
    <td>Phone Number</td>
    <td><?php echo $trip['contact_no']; ?></td>
  </tr>
 <tr>
    <td>Office Location</td>
    <td><?php $l=$u->getoffice_locations($trip['location']); echo $l['location']; ?></td>
  </tr>
<?php if($trip['manager_approval_report'] != ''){?>
 <tr>
    <td>Approval Report</td>
    <td><a href="/uploads/manager-approval-reports/<?php echo $trip['manager_approval_report'];?>" target="_blank">BU budget holder approval report</a> </td>
  </tr>
<?php }?>
   <!--tr>
    <td>Airport Drop Location</td>
    <td><?php echo $getdestdeps[0]['airport_drop_loca'];?></td>
  </tr>
   <tr>
    <td>Airport Pickup </td>
    <td><?php echo $getdestdeps[0]['airport_pickup'];?></td>
  </tr>
   <tr>
    <td>Airport Pickup Location</td>
    <td><?php echo $getdestdeps[0]['airport_pickup_loca'];?></td>
  </tr>
   <tr>
    <td>Need Car for entire duration of stay </td>
    <td><?php echo $getdestdeps[0]['need_car'];?></td>
  </tr-->
</table>

    </div><!-- row ends-->
  <?php $i=0;
  $count=0;
  $bookings_count=0;
$hotel_bookings_count=0;
        foreach($hotel_bookings as $hotel_booking)
            {
              $hotel_bookings_count++;
            }
		## display the details
            //echo $hotel_bookings_count."<br>";
foreach ($getdestdeps as $getdestdep){  //echo $i;
//print_r($getdestdep);?>   
    <div class="row"><!--row begins-->
<?php if($trip['booking_type']=='airline'){ 
    if($i==2 && $trip['trip_type']=='Round trip'){ ?>
        <br><br>
    <?php }?>
   <br><br> <span class="f-leg"><img src="img/travel_details.png" /><?php if($i==0 && $trip['trip_type']=='Round trip') { ?>Onward Journey <?php }?>
<?php if($i==2 && $trip['trip_type']=='Round trip') { ?>Return Journey <?php }?>Airline  details</span>
  <form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data">

   <table class="resp">
      <thead><tr>
          <th colspan="8">Airline Request details</th></tr>
        <tr>
          <th>Airline</th>
          <th>From location</th>
          <th>Destination</th>
          <?php if($i==0 && $trip['trip_type']=='Round trip') { ?><th>Departure date</th><?php } else if($i==2 && $trip['trip_type']=='Round trip') { ?><th>Return date</th><?php }else{?>           <th>Departure date</th><?php } ?>
          <th>Departure time</th>
	  <th>Preferred Flight Time</th>
	  <th>Preferred hotel in the city</th>
	  <th>Flight Meal preference</th>
        </tr>
      </thead>
      <tbody>
    <?php // ******************************************** Airline details by employee********************************************************************************************?>
          <tr>
          <td><?php $airline = $u->getairlines($getdestdep['book_airline']); if($getdestdep['book_airline']==0){echo $getdestdep['otherair'];  }else { echo $airline['name'];}?> </td>
<?php if($trip['trip_type']=='Round trip' && $i==2) { ?>

          <td><?php $cityto=$u->getcity($getdestdep['travel_to']); if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
          <td><?php $city=$u->getcity($getdestdep['travel_from']); if($getdestdep['travel_from']==0){echo $getdestdep['otheronwardcity'];  }else {echo $city['city_name'];}?></td><!--col elements should be editable if employee clicks on Amend plan-->
	<?php } else {?>
          <td><?php $city=$u->getcity($getdestdep['travel_from']); if($getdestdep['travel_from']==0){echo $getdestdep['otheronwardcity'];  }else {echo $city['city_name'];}?></td><!--col elements should be editable if employee clicks on Amend plan-->
          <td><?php $cityto=$u->getcity($getdestdep['travel_to']);  if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
	<?php }?>

          <?php if($i==0 && $trip['trip_type']=='Round trip' || $trip['trip_type']=='Oneway' || $trip['trip_type']=='multicity') { ?><td><?php if($getdestdep['date']=="0000-00-00 00:00:00"){echo " ";}else {echo $getdestdep['date']; }?></td><?php }
if($i==2 && $trip['trip_type']=='Round trip') { ?> <td><?php echo $getdestdep['return_date'];?></td><?php }?>
          <td>N/A</td>
          <td><?php echo $getdestdep['preferred_airline_time'];?></td>
          <td><?php $hotel=$u->gethotel($getdestdep['pref_hotel']);  if($getdestdep['pref_hotel']==0){echo $getdestdep['otherhotel'];  }else { echo $hotel['hotel_name'];}?></td>
          <td><?php echo $getdestdep['meal_preference'];?></td>  
        </tr>
	
	</table>

<br/><br/>
    <?php // ********************************************End  Airline details by employee********************************************************************************************?>
<?php if(!empty($air_bookings)){?>
	<table> <thead>
        <tr>
          <th colspan="7">Airline Booking details</th></tr>
		<tr>
          <th>Airline</th>
          <th>From location</th>
          <th>Destination</th>
          <th>Departure date</th>
          <th>Departure time</th>
	  <th>Flight Meal preference</th>
	 <?php $e=$u->isEmployee();if(!$e){?><th>Cost</th><?php } ?>
        </tr>
      </thead><?php //foreach($air_bookings as $air_booking){
		## display the detials
	?>
	<tr>
          <td><?php $airline = $u->getairlines($air_bookings[$bookings_count]['book_airline']); if($airline['id']==0){echo $airline['otherair'];  }else { echo $airline['name'];}?></td>
<?php //if($trip['trip_type']=='Round trip' && $i==2) {?>
	<!--<td><?php $cityto=$u->getcity($air_bookings[$bookings_count]['travel_to']); //echo $cityto['city_name'];?></td>-->
		<!--<td><?php //if(empty($air_bookings[$bookings_count]['travel_from'])){ }else{$city=$u->getcity($air_bookings[$bookings_count]['travel_from']); echo $city['city_name'];}?></td>-->
	<?php // } else {?>
		  <!--<td><?php //$city=$u->getcity($air_bookings[$bookings_count]['travel_from']); if($getdestdep['travel_from']==0){echo $getdestdep['otheronwardcity'];  }else {echo $city['city_name'];}?></td>-->
		  <!--<td><?php //$cityto=$u->getcity($air_bookings[$bookings_count]['travel_to']); if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>-->
	<?php //}?>
        
         
<?php if($trip['trip_type']=='Round trip' && $i==2) {?>
	
		<td><?php if(empty($air_bookings[$bookings_count]['travel_from'])){ }else{$city=$u->getcity($air_bookings[$bookings_count]['travel_from']); echo $city['city_name'];}?></td>
                <td><?php $cityto=$u->getcity($air_bookings[$bookings_count]['travel_to']); echo $cityto['city_name'];?></td>
	<?php  } else {?>
		  <td><?php $city=$u->getcity($air_bookings[$bookings_count]['travel_from']); if($getdestdep['travel_from']==0){echo $getdestdep['otheronwardcity'];  }else {echo $city['city_name'];}?></td>
		  <td><?php $cityto=$u->getcity($air_bookings[$bookings_count]['travel_to']); if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
	<?php }?>
	                  
                  
          <td><?php echo $air_bookings[$bookings_count]['date'];?></td>
          <td><?php echo $air_bookings[$bookings_count]['departure_time'];?></td>
          <td><?php echo $air_bookings[$bookings_count]['meal_preference'];?></td>
          
	 <?php $e=$u->isEmployee();if(!$e){?><td><?php echo $air_bookings[$bookings_count]['cost'];?></td><?php } ?>
        </tr>
	<tr>
          <td colspan="6">E Ticket: <a href="uploads/e-tickets/<?php echo $air_bookings[$bookings_count]['e_ticket'];?>">View E-Ticket </a></td> 
	</tr>
	<?php
	}
	?>	<?php }?>
	
       </tbody>
    </table>
</form>
<?php //} ## if ends for checking $air_bookings is empty?>
<br/><br/>
<?php if($trip['booking_type']=='car' || $trip['booking_type']=='airline'){ ?>
    <span class="f-leg"><img src="img/travel_details.png" /> <?php if($i==0 && $trip['trip_type']=='Round trip') { ?>Onward Journey <?php }?>
<?php if($i==2 && $trip['trip_type']=='Round trip') { ?>Return Journey <?php }?>Car details</span>
  <form id="travel-booking-plan" method="post" action="">
 

    <table class="resp">
      <thead>
        <tr>
          <th colspan="12">Car Request details</th></tr> <tr>
<?php if($trip['trip_type'] == 'multicity'){?>
	<th> City </th>
<?php } ?>

          <th>Car Vendor Company</th>

          <?php if($trip['multiple_days_car']==1){?><th>From Date</th><?php }?>
          <?php if($trip['multiple_days_car']==1){?><th>To Date</th><?php }?>

           <?php if($trip['booking_type']=='car'){?> <th>Pickup Date</th><?php }?>
         <?php if($trip['booking_type']!='car'){?>
	<th>Airport Drop</th>
          <th>Pickup Address</th>
          <th>Airport Pickup</th>
          <th>Destination Address</th>
	<?php } ?>
          <th>Pickup Time</th>
         <?php if($trip['booking_type']=='car'){?>  <th>Car Pickup Location</th>
          <th>Destination Address</th><?php }?>
          <th>Multiple days booking</th>
	  <th>Car Type</th>
          <?php $e=$u->isEmployee();if(!$e){?><th> Cost</th><?php } ?>
        </tr>
      </thead>
	<tbody>  <tr>  
    <?php // ********************************************Edit Car details by employee********************************************************************************************?>
        <?php if($trip['trip_type'] == 'multicity'){?>
<!--td>	
<?php echo $cityto['city_name'];?>
</td-->
          <td><?php $cityto=$u->getcity($getdestdep['travel_to']); if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
<?php } #if ends for multicity ?>
          <td> <?php $car=$u->getcars($getdestdep['car_company']);?><?php echo $car['name']; ?></td>

       
<?php if($trip['multiple_days_car']==1){ ?><td><?php echo $getdestdep['car_fromdate']; ?></td><?php }?>

          <?php if($trip['multiple_days_car']==1){?><td><?php echo $getdestdep['car_todate']; ?></td><?php }?>


          <?php if($trip['booking_type']=='car'){?> <td><?php if($getdestdep['date']=='0000-00-00 00:00:00' || $getdestdep['date']=='NULL'){ echo " ";}else{ echo $getdestdep['date']; }?></td><?php }?>
         <?php if($trip['booking_type']!='car'){?>
          <td><?php echo $getdestdep['airport_drop'];?></td>
          <td><?php echo $getdestdep['airport_pickup_loca'];?></td>
          <td> <?php echo $getdestdep['airport_pickup']; ?></td>
          <td><?php echo $getdestdep['airport_drop_loca'];?></td>          
	<?php } ?>
           <td><?php echo $getdestdep['car_pickuptime'];?></td>
    <?php if($trip['booking_type']=='car'){?><td><?php echo $getdestdep['car_pickup_location'];?></td>
          <td><?php echo $getdestdep['destination'];?></td><?php } ?>
          <td><?php echo $getdestdep['need_car'];?></td>
          <td><?php echo $getdestdep['car_size'];?></td>
          <?php $e=$u->isEmployee();if(!$e){?><td><?php echo $getdestdep['cost'];?></td><?php } ?>    
	</tr>
	</tbody>
	</table>


<br/><br/>
    <?php // ********************************************End Edit Airline details by employee********************************************************************************************?>
<?php if(!empty($car_bookings)){?>

<table>
	 <thead>
        <tr>
          <th colspan="13">Car Booking details</th></tr>
         <th>Car Booking Requset Id</th>
<?php if($trip['trip_type'] == 'multicity'){?>
	<th> City </th>
<?php } ?>
         
          <th>Car Vendor Company</th>
	 <?php if($trip['multiple_days_car']==1){ ?> <th>From Date</th><?php }?>
          <?php if($trip['multiple_days_car']==1){ ?><th>To Date</th><?php }?>
     	  <?php if($trip['booking_type']!='car'){?>   
	  <th>Airport Drop</th>
          <th>Pickup Address</th>
          <th>Airport Pickup</th>
          <th>Destination Address</th>
      <?php } ?>
          <th>Pickup Time</th>
 <?php if($trip['booking_type']=='car'){?><th>Car Pickup Location</th>
<th>Destination</th><?php }?>
          <th>Multiple days booking</th>
          <th>Car Type</th>
          <?php $e=$u->isEmployee();if(!$e){?><th>Cost</th><?php } ?>
        </tr>
      </thead><?php //foreach($car_bookings as $car_booking){
		## display the detials
	 $city=$u->getcity($car_bookings[$bookings_count]['car_for_city']); ?><tr>
          <td><?php echo $car_bookings[$bookings_count]['id'];?></td>
       <?php if($trip['trip_type'] == 'multicity'){ ?><td><?php echo $city['city_name'];?></td><?php } ?>         
          <td><?php $car=$u->getcars($car_bookings[$bookings_count]['car_company']); echo $car['name'];?></td>
<?php if($trip['multiple_days_car']==1){ ?><td><?php if($car_bookings[$bookings_count]['car_fromdate']=='0000-00-00'){ echo " - ";}else{ echo $car_bookings[$bookings_count]['car_fromdate'];}?></td><?php } ?>
  <?php if($trip['multiple_days_car']==1){  ?><td><?php if($car_bookings[$bookings_count]['car_todate']=='0000-00-00'){ echo " - ";}else{ echo $car_bookings[$bookings_count]['car_todate'];}?></td><?php }?>
         <?php if($trip['booking_type']!='car'){?>
          <td><?php echo $car_bookings[$bookings_count]['airport_drop'];?></td>
          <td><?php echo $car_bookings[$bookings_count]['airport_pickup_loca'];?></td>
          <td><?php echo $car_bookings[$bookings_count]['airport_pickup'];?></td>
          <td><?php echo $car_bookings[$bookings_count]['airport_drop_loca'];?></td>
          <?php } ?>
           <td><?php echo $car_bookings[$bookings_count]['pickup_time'];?></td>
           <?php if($trip['booking_type']=='car'){?><td><?php echo $car_bookings[$bookings_count]['car_pickup_location'];?></td>
          <td><?php echo $car_bookings[$bookings_count]['destination'];?></td><?php } ?>
          <td><?php echo $car_bookings[$bookings_count]['need_car'];?></td>
          <td><?php echo $car_bookings[$bookings_count]['car_size'];?></td>          
	<?php $e=$u->isEmployee();if(!$e){?><td><?php echo $car_bookings[$bookings_count]['cost'];?></td><?php } ?>    
        </tr>
<?php //} ## car_bookings foreach ends ?>
	</tbody>
	</table>
        
	</form>

<br/><br/>
<?php } 
}// echo $i;?>

<?php if($i!=2 && $trip['trip_type']!='Round trip' || $i==0 &&  $trip['trip_type']=='Round trip') { ?>
<?php if($trip['booking_type']=='hotel' || $trip['booking_type']=='airline'){ ?>
<span class="f-leg"><img src="img/travel_details.png" /> <?php if($i==0 && $trip['trip_type']=='Round trip') { ?>Onward Journey <?php }?>
<?php if($i==2 && $trip['trip_type']=='Round trip') { ?>Return Journey <?php }?>Hotel details</span>
  <form id="travel-booking-plan" method="post" action="">
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">      
    <table class="resp">
      <thead>
 <tr>
         <th colspan="6">Hotel Request details</th>

</tr>
<tr>
<?php if($trip['trip_type'] == 'multicity'){?>
	<th> City </th>
<?php } ?>
          <th>Hotel</th>
         <?php if($trip['booking_type']=='hotel'){?> 
          <th>Checkin Date</th>
          <th>CheckOut Date</th>
	 <th> City</th>
	<?php } ?>

 	 <?php if($trip['booking_type']=='hotel'){?><th>Checkin Time</th>
          <th>CheckOut Time</th>  <?php } ?>
 <?php if($trip['booking_type']!='hotel'){?>
          <th>Confirmation Number</th>
          <th>Checkin Time</th>
           <th>CheckOut Time</th> 
		<!--<th> Late Checkin</th>
         	 <th>Late Checkout</th>-->
	<?php } ?>
         <!--th>Late Checkin Date</th>
          <th>Late Checkout Date</th-->
        </tr>
      </thead>
	<tbody> 
 <?php // ********************************************Edit Hotel details employee**********************************************************************************?>
        <tr>
<?php if($trip['trip_type'] == 'multicity'){?>
<!--td><?php echo $cityto['city_name']; ?></td--> 
          <td><?php $cityto=$u->getcity($getdestdep['travel_to']); if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
<?php } ?>
<?php $city=$u->getcity($getdestdep['travel_to']);?>
          <td><?php $hotel=$u->gethotel($getdestdep['pref_hotel']); if($getdestdep['pref_hotel']==000){echo $getdestdep['otherhotel'];  }else { echo $hotel['hotel_name'];}?></td>
         <?php if($trip['booking_type']=='hotel'){?> 
			<td><?php echo $getdestdep['checkindate'];?></td>
         	 	<td><?php echo $getdestdep['checkoutdate'];?></td>
         	 <td> <?php echo $city['city_name'];?></td> 
	<?php } ?>

	<?php if($trip['booking_type']=='hotel'){?>
		<td> <?php echo $getdestdep['checkintime'];?></td>
         	 <td> <?php echo $getdestdep['checkouttime'];?></td> 

	 <?php } ?>
          <?php if($trip['booking_type']!='hotel'){?>
          <td><?php if($getdestdep['hotel_confirmation_num']){echo $getdestdep['hotel_confirmation_num'];} else{ echo "Not Applicable";}?></td>
		<td> <?php echo $getdestdep['late_checkin'];?></td>
         	 <td> <?php echo $getdestdep['late_checkout'];?></td>
	<?php } ?>

         </tr>
         <tr>
          <?php if($trip['booking_type']!='hotel'){?>
          <td> Checkin Date:<?php if($getdestdep['late_checkin_date']=='0000-00-00 00:00:00'){ echo " "; }else{echo $getdestdep['late_checkin_date'];}?></td>
          <td> Checkout Date:<?php if($getdestdep['late_checkout_date']=='0000-00-00 00:00:00'){ echo " "; }else{echo $getdestdep['late_checkout_date'];}?></td>
	 <?php } ?>
 	<td>No.of.Guests:<?php if($getdestdep['noofguests']){echo $getdestdep['noofguests'];} else{ echo '   -';}?></td>
          <td>No.of.Rooms:<?php if($getdestdep['noofrooms']){echo $getdestdep['noofrooms'];} else{ echo "   -";}?></td>
         	<?php if($trip['booking_type']=='hotel'){?> <td>Room Type:<?php echo $getdestdep['room_type']; ?></td>	 <?php } ?>
         <?php $e=$u->isEmployee();if(!$e){?> <td>Cost:<td><?php echo $getdestdep['cost'];?></td><?php } ?>    </tr>      
	</tbody>
	</table>

<br/><br/>
    <?php // ********************************************End Edit Hotel details by employee********************************************************************************************?>
<?php if( !empty($hotel_bookings)) { ?><table><thead><tr>
          <th colspan="7">Hotel Booking details</th></tr><tr>

<?php if($trip['trip_type'] == 'multicity'){?>
	<th> City </th>
<?php } ?>
        <th>Hotel</th>
         <?php if($trip['booking_type']=='hotel'){?> 
          <th>Checkin Date</th>
          <th>CheckOut Date</th>
	<?php } ?>
       
 	 <?php if($trip['booking_type']=='hotel'){?><th>Checkin Time</th>
          <th>CheckOut Time</th>  <?php } ?>
      <?php if($trip['booking_type']!='hotel'){?>
          <th>Confirmation Number</th>
          <th>Checkin Date</th>
          <th>CheckOut Date</th>
          <th>Checkin Time</th>
           <th>CheckOut Time</th> 
		<!--<th> Late Checkin</th>
         	 <th>Late Checkout</th>-->
	<?php } ?>
        </tr>
      </thead>
	<?php //foreach($hotel_bookings as $hotel_booking){
		## display the details
	$city=$u->getcity($hotel_bookings[$count]['hotel_for_city']); ?>        <tr>
       <?php if($trip['trip_type'] == 'multicity'){ ?><td><?php echo $city['city_name'];?></td><?php } ?>  

          <td><?php $hotel=$u->gethotel($hotel_bookings[$count]['hotel_id']); if($hotel['hotel_name']=='Other'){echo $hotel_booking['otherhotel'];  }else { echo $hotel['hotel_name'];}?></td>
                  <?php if($trip['booking_type']=='hotel'){?>  
<td><?php echo $hotel_bookings[$count]['check_in'];?></td>
          <td><?php echo $hotel_bookings[$count]['check_out'];?></td>
	<?php } ?>
          <?php if($trip['booking_type']!='hotel'){?><td><?php echo $hotel_bookings[$count]['hotel_confirmation_num'];?></td><?php } ?>
	 
 	 <?php if($trip['booking_type']!='hotel'){?>
	<td><?php echo $hotel_bookings[$count]['late_checkin_date'];?></td>
          <td><?php echo $hotel_bookings[$count]['late_checkout_date'];?></td>
	<?php } ?>
          <?php if($trip['booking_type']!='hotel'){?>
		<td> <?php echo $hotel_bookings[$count]['late_checkin'];?></td>
         	 <td> <?php echo $hotel_bookings[$count]['late_checkout'];?></td>
	<?php } ?>
 	
       
        </tr>
<tr>
 <td>No.of Guests:<?php echo $hotel_bookings[$count]['noofguests'];?></td>
          <td>No.of Rooms:<?php echo $hotel_bookings[$count]['noofrooms'];?></td> <td>Room Type:<?php echo $hotel_bookings[$count]['room_type'];?></td>
<td><?php $e=$u->isEmployee();if(!$e){?> Cost:<?php echo $hotel_bookings[$count]['cost'];?><?php } ?></td>
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>"></td>
	</tr>
<?php //} ## car_bookings foreach ends?>
	</tbody>
	</table>
	</form><?php }?>
<?php 
} $count++;// END  if($i!=2 && $trip['trip_type']!='Round trip') {  ?>
<?php }  if($trip['trip_type']=='Round trip') { $i++;  }

 // ******************************************** train details by employee********************************************************************************************
 if($trip['booking_type']=='train'){ ?>

  <form id="travel-booking-plan" method="post" action="">
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">      
    <table class="resp">
      <thead>
 <tr><th colspan="8">Train Request details</th></tr>
	<tr>
           <th>Name of Passenger</th>

	<th align='left'>From Location</th>
	<th align='left'>Destination</th>
	<th align='left'>Age</th>
	<th align='left'>Train</th>
	<th align='left'>Date</th>
	<th align='left'>Class</th>
	<th align='left'>Boarding From</th>

         </tr>
      </thead>

 <?php // ********************************************Edit train details employee**********************************************************************************?>
        <tr>
<?php $uid=$_SESSION['user_id'];$row = $u->pdo->select('emp_list', '`id`='.$uid);
	$to=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
	$cityto=$u->getcity($getdestdep['travel_to']);$city=$u->getcity($getdestdep['travel_from']);//print_r($getdestdeps);?>
          <td><?php echo $passenger;?></td>
          
 	<td><?php  if($getdestdep['travel_from']==0){echo $getdestdep['otheronwardcity'];  }else {echo $city['city_name'];}?></td><!--col elements should be editable if employee clicks on Amend plan-->
          <td><?php if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
          <td><?php echo $getdestdep['age'];?></td>
          <td> <?php echo $getdestdep['train'];?></td>
          <td> <?php echo $getdestdep['date'];?></td>
          <td> <?php echo $getdestdep['class'];?></52td>
          <td><?php echo $getdestdep['boarding_form'];?></td>
   </tr>        

	</table>

<br/><br/><?php }?>
    <?php // ********************************************End Edit Hotel details by employee********************************************************************************************?>
<?php if($trip['booking_type']=='train' && !empty($train_bookings)) { ?><table><thead><tr>
         <tr><th colspan="9">Train Booking details</th></tr>
	<tr>
           <th>Name of Passenger</th>

	<th align='left'>From Location</th>
	<th align='left'>Destination</th>
	<th align='left'>Age</th>
	<th align='left'>Train</th>
	<th align='left'>Date</th>
	<th align='left'>Class</th>
	<th align='left'>Boarding From</th>
	<?php $e=$u->isEmployee();if(!$e){?><th align='left'>cost</th><?php } ?>
         </tr>
      </thead>
	<?php foreach($train_bookings as $train_booking){
		## display the details ?>        <tr>

          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
         <?php $cityto=$u->getcity($train_booking['train_to']);$city=$u->getcity($train_booking['train_from']);?>
          <td><?php echo $passenger;?></td>
      
 	<td><?php $city=$u->getcity($train_booking['train_from']); if($getdestdep['travel_from']==0){echo $getdestdep['otheronwardcity'];  }else {echo $city['city_name'];}?></td>
	<td><?php $cityto=$u->getcity($train_booking['train_to']); if($getdestdep['travel_to']==0){echo $getdestdep['othertravel_to'];  }else { echo $cityto['city_name'];}?></td>
          <td><?php echo $train_booking['age'];?></td>
          <td> <?php echo $train_booking['train'];?></td>
          <td> <?php echo $train_booking['date'];?></td>

          <td> <?php echo $train_booking['class'];?></td>
          <td><?php echo $train_booking['boarding_form'];?></td>
     <?php $e=$u->isEmployee();if(!$e){?><td><?php echo $train_booking['cost'];?></td><?php } ?>
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
	</tr>
<?php } ## train_bookings foreach ends ?>
	</tbody>
	</table>
	</form><?php }?>

<?php  if($trip['trip_type']=='Round trip') { $i++;  }
$bookings_count++;

}## getdestdeps ends?>

<!-- Add all the html before this line -->
    </div><!-- row ends-->
    <!--div class="db-btn-set"><input type="SUBMIT" value="SUBMIT" /-->
</div>
  </div><!--main div ends-->
  <footer>
  </footer>
</div><!--wrapper ends--> 


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
