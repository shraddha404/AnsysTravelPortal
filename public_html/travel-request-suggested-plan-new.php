<?php
session_start();
include_once ('../lib/TravelDesk.class.php');
$u = new TravelDesk($_SESSION['user_id']);
$trip_id=$_GET['trip_id'];

$trip=$u->getTripDetails($trip_id);
$getdestdeps=$u->getdestdep($trip_id);
$getdestdepairline=$u->getdestdepairline($trip_id);
$getdestdephotel=$u->getdestdephotel($trip_id);
$getdestdepcar=$u->getdestdepcar($trip_id);
//print_r($getdestdeps);
$cities = $u->cities();
$airlines = $u->airlines();
$hotels = $u->hotels();
$cars = $u->cars();
//print_r($trip);


if($_POST){

if($_POST['air_booking'] == 'ADD'){
$airbookings = $u->airBookings($_POST);
}
if($_POST['car_booking'] == 'ADD'){
$carbookings = $u->carBookings($_POST);
}
if($_POST['hotel_booking'] == 'ADD'){
$hotelbookings = $u->hotelBookings($_POST);
}
//$details = $u->travelrequestsuggestedplan($_POST);
}

$air_bookings = $u->getAirBookings($trip_id);
//print_r($air_bookings);
$car_bookings = $u->getCarBookings($trip_id);
//print_r($car_bookings);
$hotel_bookings = $u->getHotelBookings($trip_id);
//print_r($hotel_bookings);

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

   <div class="row"><!--row begins-->
    <span class="f-leg"><img src="img/user32.png" />Suggested plan</span>
    
  <table>
  <tr>
    <td width="22%">Employee Name</td>
    <td width="78%"><?php echo $trip['firstname'].'  '. $trip['middlename'].'  '.$trip['lastname'];?></td>
  </tr>
  <tr>
    <td>Trip type</td>
    <td><?php echo $trip['trip_type'];?></td>
  </tr>
  <tr>
    <td>Special instructions</td>
    <td><?php echo $trip['special_mention'];?></td>
  </tr>
   <!--tr>
    <td>Airport Drop</td>
    <td><?php echo $getdestdeps[0]['airport_drop'];?></td>
  </tr>
   <tr>
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
 <tr>
    <td>BU</td>
    <td><?php echo $getdestdeps[0]['biz_unit'];?></td>
  </tr>
   <tr>
    <td colspan="2"><div class="db-btn-set"><input type="SUBMIT" name="car_booking" value="Notify Employee the Suggested Plan" /></div></td>
  </tr>
</table>

    </div><!-- row ends-->
    
    <div class="row"><!--row begins-->

    <span class="f-leg"><img src="img/travel_details.png" />Airline  details</span>
  <form id="travel-booking-plan" method="post" action="" enctype="multipart/form-data">
    <table class="resp">
      <thead>
        <tr>
          <th>Airline</th>
          <th>From location</th>
          <th>Destination</th>
          <th>Departure date</th>
          <th>Departure time</th>
	  <th>Meal preference</th>
	  <th>Cost</th>

        </tr>
      </thead>
      <tbody>
	<?php foreach($air_bookings as $air_booking){
		## display the detials
	?>
	<tr>
          <td><?php $airline = $u->getairlines($air_booking['book_airline']); echo $airline['name'];?></td>
          <td><?php //if(empty($air_booking['travel_from'])){ }else{$city=$u->getcity($air_booking['travel_from']); echo $city['city_name'];}
		$city=$u->getcity($air_booking['travel_from']);  echo $city['city_name'];?>
		          </td>
          <td><?php $city=$u->getcity($air_booking['travel_to']); echo $city['city_name'];?>

		
	</td>
          <td><?php echo $air_booking['date'];?></td>
          <td><?php echo $air_booking['departure_time'];?></td>
          <td><?php echo $air_booking['meal_preference'];?></td>
          <td><?php echo $air_booking['cost'];?></td>
        </tr>
	<tr>
          <td colspan="5">E Ticket: <a href="uploads/e-tickets/<?php echo $air_booking['e_ticket'];?>">View E-Ticket </a></td> 
	</tr>
	<?php
	}
	?>	
	<?php foreach ($getdestdepairline as $getdestdep){
?>
        <tr>
          <td>
		<select name="book_airline"> 
<?php $airlinesdel=$u->getairlines($getdestdep['book_airline']); 
    foreach($airlines as $airline) { ?>
      <option value="<?php echo $airline['id']; ?>"  <?php if($airlinesdel['name']==$airline['name']){ echo "selected"; }?> ><?php echo $airline['name']; ?></option>
  <?php
    } ?></select></td>
          <td><input type="hidden" id="travel_from" name="travel_from" value="<?php echo $getdestdep['travel_from'];?>"><?php $city=$u->getcity($getdestdep['travel_from']);  $city['city_name'];?><select name="onwardcity[]" id="onwardcity"><option value=""><!--list to be populated dynamically-->From City</option>

		<?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id'] ?>" <?php if($city['city_name']==$citie['city_name']){echo 'selected=selected';}?>><?php echo $citie['city_name'] ?></option>
		  <?php
		    } ?>
		 </select>
</td><!--col elements should be editable if employee clicks on Amend plan-->

          <td><input type="hidden" id="travel_to" name="travel_to" value="<?php echo $getdestdep['travel_to'];?>"><?php $city=$u->getcity($getdestdep['travel_to']);  
 $city['city_name'];?><select name="travel_to[]" id="travel_to" ><option value="">To city</option><?php
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id'] ?>" <?php if($city['city_name']==$citie['city_name']){echo 'selected=selected';}?>><?php echo $citie['city_name'] ?></option>
		  <?php
		    } ?> </select></td>

          <td><input type="date" id="date" name="date" placeholder="Departure date"  autofocus /></td>
          <td><input type="text" id="departure_time" name="departure_time" />
          <td><input type="text" id="meal_preference" name="meal_preference"  value=""/>
          <td><input type="text" id="cost" name="cost" />
        </tr>
	<tr>
          <td colspan="5">E Ticket: <input type="file" id="e-ticket" name="e-ticket" />
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>"></td>
	</tr>
<?php }?>
       </tbody>
    </table>
         <div class="db-btn-set"><input type="SUBMIT" name="air_booking" value="ADD" /></div>
</form>
<br/>
    <span class="f-leg"><img src="img/travel_details.png" />Car Booking details</span>
  <form id="travel-booking-plan" method="post" action="">
  <table>
  <tr>
	</tr>
</table>
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
    <table class="resp">
      <thead>
        <tr>
<?php if($trip['trip_type'] == 'multicity'){?>
	<th> City </th>
<?php } ?>
          <th>Car Vendor Company</th>
          <th>Date</th>
          <th>Type of Vehicle</th>
          <th>Airport Drop</th>
          <th>Pickup</th>
          <th>From Location</th>
          <th>Pickup Time</th>
          <th>Need Car for entire duration of stay</th>
          <th>Car Type</th>
          <th>Car Size</th>
          <th>Cost</th>
        </tr>
      </thead>
	<tbody>
	<?php foreach($car_bookings as $car_booking){
		## display the detials
	?><tr>
          <td><?php $car=$u->getcars($car_booking['car_company']); echo $car['name'];?></td>
          <td><?php echo $car_booking['date'];?></td>
          <td><?php echo $car_booking['type_of_vehicle'];?></td>
          <td><?php echo $car_booking['airport_drop'];?></td>
          <td><?php echo $car_booking['airport_pickup'];?></td>
          <td><?php echo $car_booking['from_location'];?></td>
          <td><?php echo $car_booking['pickup_time'];?></td>
          <td><?php echo $car_booking['need_car'];?></td>
          <td><?php echo $car_booking['car_type'];?></td>
          <td><?php echo $car_booking['car_size'];?></td>
          <td><?php echo $car_booking['cost'];?></td>
        </tr>
<?php } ## car_bookings foreach ends ?>
		<?php foreach ($getdestdepcar as $getdestdepcars){?>
<tr>
<?php if($trip['trip_type'] == 'multicity'){?>
<td>
<select id="city" class="city" name="car_city"> 
<option>Choose City</option>
<?php
	foreach($cities as $city){
?>
	<option value="<?php echo $city['id']; ?>"><?php echo $city['city_name']; ?></option>
<?php
	}
?>
</select></td>
<?php } #if ends for multicity ?>
          <td>
<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
<select id="car_company" class="car_company" name="car_company"> 
<?php $cardel=$u->getcars($getdestdeps[0]['car_company']); 
    foreach($cars as $car) { ?>
      <option value="<?php echo $car['id']; ?>" <?php if($cardel['name']==$car['name']){ echo "selected"; }?>><?php echo $car['name']; ?></option>
  <?php
    } ?></select></td>
          <td><input type="date" name="car_pickup_date" value=""></td>
          <td><input type="text" name="type_of_vehicle" value=""></td>
          <td><input type="checkbox" name="airport_drop" value="yes"></td>
          <td><input type="checkbox" name="airport_pickup" value="yes"></td>
          <td><input type="text" name="car_from_location" value="<?php echo $getdestdeps[0]['airport_pickup_loca'];?>"></td>
          <td><input type="text" name="car_pickup_time" value=""></td>
          <td><input type="checkbox" name="need_car" value="yes"></td>
          <td><input type="text" name="car_type" value=""></td>
          <td><input type="text" name="car_size" value=""></td>
          <td><input type="text" name="cost" value=""></td>
	</tr><?php }?>
	</tbody>
	</table>
    <div class="db-btn-set"><input type="SUBMIT" name="car_booking" value="ADD" /></div>
	</form>

    <span class="f-leg"><img src="img/travel_details.png" />Hotel Booking details</span>
  <form id="travel-booking-plan" method="post" action="">
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
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
          <th>Late Checkin</th>
          <th>Late Checkout</th>  
       
        </tr>
      </thead>
	<tbody>
	<?php foreach($hotel_bookings as $hotel_booking){
		## display the details
	?>
          <td><?php $hotel=$u->gethotel($hotel_booking['hotel_id']); echo $hotel['hotel_name'];?></td>
          <td><?php echo $hotel_booking['check_in'];?></td>
          <td><?php echo $hotel_booking['check_out'];?></td>
          <td><?php echo $hotel_booking['hotel_confirmation_num'];?></td>
          <td><?php echo $hotel_booking['late_checkin'];?></td>
          <td><?php echo $hotel_booking['late_checkout'];?></td>
	
        </tr>

	<tr><td>Late Checkin Date:<?php echo $hotel_booking['late_checkin_date'];?></td>  <td>Late Checkout Date;<?php echo $hotel_booking['late_checkout_date'];?></td><td>Cost:<?php echo $hotel_booking['cost'];?></td>
          <input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>"></td>
	</tr>
<?php } ## car_bookings foreach ends ?>
	
		<?php foreach ($getdestdephotel as $getdestdephotels){
//print_r($getdestdephotels);

?>
	<tr>
<?php if($trip['trip_type'] == 'multicity'){?>
<td>
<select id="city" class="city" name="hotel_city"> 
<option>Choose City</option>
<?php
	foreach($cities as $city){
?>
	<option value="<?php echo $city['id']; ?>"><?php echo $city['city_name']; ?></option>
<?php
	}
?>
</select></td>
<?php } #if ends for multicity ?>
         <input type="hidden" name="trip_type" value="<?php echo $trip['trip_type'];?>"> <td>
	<select id="hotel_id" class="hotel_id" name="hotel_id"> 
	<option value="">Preferred hotel in the city</option>
	<?php $hoteldel=$u->gethotel($getdestdephotels['pref_hotel']); 
    	foreach($hotels as $hotel) { ?>
      	<option value="<?php echo $hotel['id']; ?>" <?php if($hoteldel['hotel_name']==$hotel['hotel_name']){ echo "selected"; }?>><?php echo $hotel['hotel_name']; ?></option>
  	<?php
    	} ?>
	</select>
</td>
          <td><input type="date" name="check_in" value="<?php //echo $getdestdephotels['check_in'];?>"></td>
          <td><input type="date" name="check_out" value="<?php //echo $getdestdephotels['check_out'];?>"></td>
          <td><input type="text" name="hotel_confirmation_num" value="<?php //echo $getdestdephotels['hotel_confirmation_num'];?>"></td>
          <td><input type="checkbox" name="late_checkin" value="yes" <?php //if($getdestdephotels['late_checkin']=='yes'){ echo 'checked=checked';} ?>></td>
          <td><input type="checkbox" name="late_checkout" value="yes" <?php //if($getdestdephotels['late_checkout']=='yes'){ echo 'checked=checked';} ?>></td></tr><tr>
          <td> Late Checkin Date:<input type="date" id="date" value="<?php ////echo $getdestdephotels['late_checkin_date'];?>" name="late_checkin_date" placeholder="Check in date time" autofocus /></td>
          <td> Late Checkout Date:<input type="date" id="date" value="<?php //echo $getdestdephotels['late_checkout_date'];?>" name="late_checkout_date" placeholder="Check Out date time" autofocus /></td>
          <td>Cost:<input type="text" name="cost" value="<?php //echo $getdestdephotels['cost'];?>"></td>
		</tr><?php }   ?>
	</tbody>
	</table>
    <div class="db-btn-set"><input type="SUBMIT" name="hotel_booking" value="ADD" /></div>
	</form>

<?php //} ## getdestdeps ends?>

<!-- Add all the html before this line -->
    </div><!-- row ends-->
    <!--div class="db-btn-set"><input type="SUBMIT" value="SUBMIT" /-->
</div>
  </div><!--main div ends-->
  <footer>
  </footer>
</div><!--wrapper ends--> .


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
