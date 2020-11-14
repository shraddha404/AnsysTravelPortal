<?php
session_start();
$limit = 15;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
$status=$_GET['status'];
if($_SESSION['user_type'] == 'Travel Desk'){
	include_once ('../lib/TravelDesk.class.php');
	$u = new TravelDesk($_SESSION['user_id']);
}
else{
        	header("Location:/login.php");
}
if($_POST){
	//$travel_requests = $u->getTraveldatewisereportpagination($_POST);   
	$travel_requests = $u->getDestDepartByFilter($_POST);   
}
else{
//print_r($_POST);
	//$travel_requests = $u->getTraveldatewisereport(); 
	$travel_requests = $u->getDestDepartReport(); 
}
//print_r($travel_requests);?>
<!doctype html>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/DateTimePicker.js"></script>
               
<script>
$(document).ready(function () {
$( "#stdate" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
$( "#endate" ).datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
});
</script>
</head>
<body>
<div id="wrapper">
<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
<div role="main"><h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>
<div class="in-bloc cent row"><img src="img/globe.jpg" alt="Travel-desk-view" /><h1 class="in-bloc">Date wise Destination and Departure report</h1></div>

<table class="resp"><!--rows to be added dynamically as required--> <thead>
<form name="requestreceived" method="post">
<tr>
<th colspan="2">Trip ID:&nbsp;&nbsp;<input type="text" id="trip_id" name="trip_id" value="<?php echo $_POST['trip_id'];?>" ></th>
<th colspan="2">Start Date:&nbsp;&nbsp;<input type="text" id="stdate" name="stdate" value="<?php echo $_POST['stdate'];?>" ></th>
<th colspan="3">End Date:&nbsp;&nbsp;<input type="text" name="endate" id="endate" value="<?php echo $_POST['endate'];?>" ></th>
<th colspan="2">Booking type:&nbsp;&nbsp;
<select name="booking_type">
<option value="">Select Booking Type</option> 
<option value="car" <?php if($_POST['booking_type']=='car'){ echo "selected=selected";}?>>Car</option>      
<option value="hotel"<?php if($_POST['booking_type']=='hotel'){ echo "selected=selected";}?>>Hotel</option>      
<option value="airline"<?php if($_POST['booking_type']=='airline'){ echo "selected=selected";}?>>Airline</option>
<option value="train"<?php if($_POST['booking_type']=='train'){ echo "selected=selected";}?>>Train</option>
</select> </th>
<th colspan="2"><input type="submit" name="report" value="Get Report" ></th></tr>
<tr><td colspan="11"><span style="float:right; margin-bottom:10px; font-weight:bold; font-color:#43729f;"><a href="export-date-wise-dest-dep-report.php?stdate=<?php echo $_POST['stdate'];?>&endate=<?php echo $_POST['endate'];?>&booking_type=<?php echo $_POST['booking_type'];?>&trip_id=<?php echo $_POST['trip_id'];?>">Export All</a></span></td></tr>

</table><br/><br/><br/>
</form>

<table class="resp">
<tr><thead>
<?php /********Comman  booking fields*****************/?>
<th>Trip ID</th>
<th>Request No.</th>
<th>Booking Type.</th>
<th>Date of Request</th>
<th>Employee Location</th>
<th>Business Unit (BU)</th>
<th>Guest Name</th>
<th>Guest email id</th>
<th>Purpose of visit</th>
<th>Date of Travel</th>
<th>Sector</th>
<th>Airline</th>
<th>Air ticket no</th>
<th>Air fare</th>
<th>Car booking</th>
<th>Car usage details</th>
<th>Car - Service Provider</th>
<th>Hotel booking done</th>
<th>Hotel Name</th>
<?php //if($trip['booking_type']=='hotel'){ ?>
<th>Check in Date</th>
<th>Check out Date</th>
<?php //} ?>
<th>Hotel Pernight tariff</th>
<th>VISA applied for country</th>
<th>Tentative VISA Fees</th>
</tr>
</thead>
<tbody>
<?php foreach($travel_requests as $request){ 

$trip=$u->getTripDetails($request['trip_id']);

 ?>
	<tr> 
	<?php /********Common  booking fields*****************/?>
	<td align="center"><?php echo $request['trip_id']; ?></td>
	<td align="center"><?php echo $request['req_id']; ?></td>
	<td align="center"><?php echo $request['booking_type']; ?></td>
	<td align="center"><?php echo $request['req_date']; ?></td>
	<td align="center"><?php $requestcity=$u->getcity($request['city']);echo $request['address1'].", ".$request['address2'].", ".$requestcity['city_name'];?></td>
	<td align="center"><?php echo $request['bu_name']; ?></td>
	<td align="center"><?php echo $request['firstname']."  ".$request['middlename']."  ".$request['lastname']; ?></td>
	<td align="center"><?php echo $request['email']; ?></td>

		<td align="center"><?php echo $request['purpose_of_visit']; ?></td>
		<td align="center"><?php echo $request['req_date']." To ".$request['return_date'];?></td>
		<td align="center"><?php $fromcity=$u->getcity($request['travel_from']);
					 $tocity=$u->getcity($request['travel_to']);
					 echo $fromcity['city_name']." To ".$tocity['city_name'];?></td>     
		<td align="center"><?php echo $request['airline_name'];?></td>     
		<td align="center"><?php echo $request['ticket_number'];?></td>  
		<td align="center"><?php echo $request['air_fare'];?></td>
		<td align="center"><?php $carbooking=$u->carBooking($request['trip_id']); if(empty($carbooking['id'])){ echo "No"; } else { echo "Yes"; }?></td>
		<td align="center"><?php echo $request['car_type']." - ".$request['car_size'];?></td>
		<td align="center"><?php $car=$u->getcars($request['car_company']); echo $car['name']; ?></td>
		<td align="center"><?php $hotelbooking=$u->HotelBooking($request['trip_id']); if(empty($hotelbooking['id'])){ echo "No"; } else { echo "Yes"; } ?></td>
		<!--td align="center"><?php echo $request['hotel_name'];?></td-->
		<td><?php $hotel=$u->gethotel($request['pref_hotel']); if($request['pref_hotel']==0){echo $request['otherhotel'];  }else { echo $hotel['hotel_name'];}?></td>
		<?php //if($trip['booking_type'] == 'airline'){ ?>
		<?php if($request['booking_type'] == 'airline'){ ?>
		<td align="center"><?php echo $request['late_checkin_date'];?></td>
		<td align="center"><?php echo $request['late_checkout_date'];?></td>
		<?php } else { ?>
		<td align="center"><?php echo $request['checkindate'];?></td>
		<td align="center"><?php echo $request['checkoutdate'];?></td>
		<?php }?>
		<td align="center"><?php echo $request['hotel_pernight'];?></td>
          	<td align="center"><?php $visa=$u->visaList($request['emp_id']); echo $visa['visa-country']; ?></td>
		<td align="center"><?php echo $request['visa_fees'];?></td>

	</tr>
<?php } ## foreach ends ?>
</tbody>
</table>

<!--table><tr><td align="center">


<?php 

$travelrequests = $u->getTraveldatewisereportpagination($_POST);
 $total_records = count($travelrequests);  

$total_pages = ceil($total_records / $limit);
$pagLink = "<div class='pagination'><strong>Page No.";  
for ($i=1; $i<=$total_pages; $i++) {  

$pagLink .= "<a href='date-wise-travel-plan-report.php?page=".$i."&id=".$_GET['id']."'>".$i."</a>"."     ";
}

echo $pagLink ."</div></strong>";  
?></td></tr></table-->


</div>
<footer>

</footer>
</div><!--wrapper ends--> 

<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->



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
</script -->

</body>
</html>
