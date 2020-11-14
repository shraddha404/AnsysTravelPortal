<?php
session_start();
include_once ('../lib/Manager.class.php');
$u = new Manager($_SESSION['user_id']);
$trip_id=$_GET['trip_id'];
$trip=$u->getTripDetails($trip_id);
$getdestdeps=$u->getdestdep($trip_id);
//print_r($getdestdeps);
$getdestdeps['date'];
$cities = $u->cities();
$airlines = $u->airlines();
$hotels = $u->hotels();
$cars = $u->cars();
$manager = $u->getUserDetails($_SESSION['user_id']);
if($_POST){
//print_r($_POST);exit;
$details = $u->travelrequestsuggestedplanmanager($_POST);
header("Location:/travel-requests-received.php");
}

?><!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->


<head>

<script>
function goBack() {
window.history.back();
}
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
<div class="in-bloc cent row"><img src="img/to-fro.jpg" alt="Travel-plan-suggest" /><h1 class="in-bloc">Travel Reqest ID - <?php echo $_GET['trip_id'];?></h1></div>
<div class="row"><!--row begins--><h3 align='right'><p style='color:green;'>
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
<td>Purpose of visit</td>
<td><?php echo $trip['purpose_of_visit'];?></td>
</tr>
<tr>
<td>Business unit</td>
<td><?php  $ou=$u->getous($trip['ou']); echo $ou['ou_short_name'];?></td>
</tr>
<tr>
<td>Cash advance details</td>
<td><?php 
#echo $trip['cash_adv'];
echo $trip['cost'];
?></td>
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
<!--<tr>
<td>Meal preference</td>
<td><?php echo $getdestdeps['meal_preference'];?></td>
</tr>-->
<tr>
<td>Special instructions</td>
<td><?php echo $trip['special_mention'];?></td>
</tr>
</table>

</div><!-- row ends-->

<div class="row"><!--row begins-->
<span class="f-leg"><img src="img/travel_details.png" />Travel details</span>
<table class="resp">
<thead>
<tr>
<?php if($trip['booking_type']!='train'){?>
<?php if($trip['booking_type'] == 'car'){?>
<th>Car Pickup Location</th>
<th>Destination</th>
<th>Car Vendor Company</th>
<th>Pickup Time</th>
<th>Date</th>
<th>Car Type</th>
<th>Need Car for Entire Stay</th>
<?php } else{?>
<th>From location</th>
<th>Destination</th>
<th>Departure date</th>
<th>Preferred airline</th>
<th>Meal Preference</th>
<th>Preferred hotel</th>
<th>Preferred car vendor</th>
<?php } }else { ?>
<th >Date</th>
<th>Name of Passenger</th>
<th >Age</th>
<th>Train</th>
<th>Train Id</th>
<th>Class</th>
<th>Boarding From</th>
<?php }?>
<!--th>Action</th-->
</tr>
</thead>
<tbody>

<form id="travel-booking-plan" method="post" action="travel-request--suggested-plan.php">
<input type="hidden" id="trip_id" name="trip_id" value="<?php echo $trip_id;?>">
<input type="hidden" id="emp_email" name="emp_email" value="<?php echo $trip['email'];?>">
<input type="hidden" id="manager_email" name="manager_email" value="<?php echo $manager['email'];?>">
<?php 
foreach ($getdestdeps as $getdestdep){
?>
<?php $uid=$_SESSION['user_id'];$row = $u->pdo->select('emp_list', '`id`='.$getdestdep['emp_id']);
	$to=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
$pt=$trip['firstname'].'  '. $trip['middlename'].'  '.$trip['lastname'];
	$m=$manager['firstname'].'  '. $manager['lastname'];?>
<?php if($trip['booking_type']!='train'){?>
	<tr>
	<?php if($trip['booking_type'] == 'car'){?>
		<td><input type="hidden" name="car_pickup_location[]" id="car_pickup_location" value="<?php echo $getdestdep['car_pickup_location'];?>"><?php echo $getdestdep['car_pickup_location'];?></td> 
		<td><input type="hidden" name="destination[]" id="destination" value="<?php echo $getdestdep['destination'];?>"><?php echo $getdestdep['destination'];?></td> 
<?php  $cardel=$u->getcars($getdestdep['car_company']); ?>
	<td><input type="hidden" name="car_company[]" id="car_company" value="<?php echo $cardel['name'];?>">
	<?php echo $cardel['name'];?></td>
	<td><input type="hidden" name="car_pickuptime[]" id="car_pickuptime" value="<?php echo $getdestdep['car_pickuptime'];?>"><?php echo $getdestdep['car_pickuptime'];?></td> 
	<td><input type="hidden" id="date" name="date[]" value="<?php echo $getdestdep['date'];?>"><?php echo $getdestdep['date']; ?></td>
	<td><input type="hidden" name="car_pickup_location[]" id="car_size" value="<?php echo $getdestdep['car_size'];?>"><?php echo $getdestdep['car_size'];?></td> 
	<td><input type="hidden" name="need_car[]" id="need_car" value="<?php echo $getdestdep['need_car'];?>"><?php echo $getdestdep['need_car'];?></td> 

	<?php } else{?>
	<td><input type="hidden" id="travel_from" name="travel_from[]" value="<?php echo $getdestdep['travel_from'];?>"><?php $city=$u->getcity($getdestdep['travel_from']); echo $city['city_name'];?></td><!--col elements should be editable if employee clicks on Amend plan-->
	<td><input type="hidden" id="travel_to" name="travel_to[]" value="<?php echo $getdestdep['travel_to'];?>"><?php $cityto=$u->getcity($getdestdep['travel_to']);  echo $cityto['city_name'];?></td>
	<td><input type="hidden" id="date" name="date[]" value="<?php echo $getdestdep['date'];?>"><?php echo $getdestdep['date']; ?></td>

	<td><input type="hidden" name="book_airline[]" value="<?php echo $getdestdep['book_airline'];?>">
	<?php $airlinesdel=$u->getairlines($getdestdep['book_airline']);?>  <?php echo $airlinesdel['name']; ?></td>
        <td><input type="hidden" id="meal_preference" name="meal_preference[]"  value="<?php echo $getdestdep['meal_preference'];?>"/><?php echo $getdestdep['meal_preference'];?></td>
	<td><input type="hidden" id="hotel_id" name="hotel_id[]" value="<?php echo $getdestdep['hotel_id'];?>">
	<?php $hoteldel=$u->gethotel($getdestdep['pref_hotel']); echo $hoteldel['hotel_name'];?></td>
	<td>
	<input type="hidden" id="car_company" name="car_company[]" value="<?php echo $car_company;?>"><?php $cardel=$u->getcars($getdestdep['car_company']); echo $cardel['name'];?>
	</td>

	<?php } }
else {?>

	<td><input type="hidden" id="date" name="date[]" value="<?php echo $getdestdep['date'];?>"><?php echo $getdestdep['date']; ?></td>
	<td><input type="hidden" name="passenger" value="<?php echo $passenger;?>"><?php echo $passenger;?></td>
	<td><input type="hidden" name="age[]" value="<?php echo $getdestdep['age'];?>"><?php echo $getdestdep['age'];?></td>
	<td><input type="hidden" name="train[]" value="<?php echo $getdestdep['train'];?>"><?php echo $getdestdep['train'];?></td>

	<td><input type="hidden" id="train_id" name="train_id[]" value="<?php echo $getdestdep['train_id'];?>"><?php echo $getdestdep['train_id'];?></td>
	<td><input type="hidden" id="class" name="class[]" value="<?php echo $getdestdep['class'];?>"><?php echo $getdestdep['class'];?></td>
	<td><input type="hidden" id="boarding_form" name="boarding_form[]" value="<?php echo $getdestdep['boarding_form'];?>"><?php echo $getdestdep['boarding_form'];?></td>

	<?php }?>	
	</tr>	
<?php 
}
?>

<input type="hidden" name="passenger" value="<?php echo $pt;?>">
<input type="hidden" name="manager" value="<?php echo $m;?>">
    <?php if($trip['manager_approved']=='0'){?><td colspan="7"><div class="btn-set"><input type="submit" name="submit" class="" value="Approve" /><input type="button" class="" onclick="goBack()" value="Cancel" /></div></td>
<?php }else{?>
    <td colspan="7"><div class="btn-set"><input type="button" class="" onclick="goBack()" value="Cancel" /></div></td><?php }?>

</tbody>

</form>
</table></div><!-- row ends--></div><!--main div ends-->
<footer>

</footer>
</div><!--wrapper ends--> 

<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->

<script src="js/libs/jquery-1.7.1.min.js"></script>
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
<!-- end scripts -->

<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
mathiasbynens.be/notes/async-analytics-snippet >
<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script-->


</body>
</html>