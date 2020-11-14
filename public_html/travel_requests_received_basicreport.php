<?php
session_start();
 if($_SESSION['user_type'] == 'Admin'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
$u = new Admin($_SESSION['user_id']);
 }
else if($_SESSION['user_type'] == 'Finance'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Finance.class.php';
$u = new Finance($_SESSION['user_id']);
}

if($_GET){
$page = $_GET['page'];
}
else{
$page = 0;
}

## Submit button for $_POST need to be added.
if($_POST){
 $travel_requests = $u->getTravelRequestsBasicReport($_POST);
}
else
{
 $travel_requests = $u->getTravelRequestsBasicReport($_POST);   
}

//print_r($travel_requests);
?>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <script type="text/javascript">

$("#EndDate").change(function () {
    var startDate = document.getElementById("StartDate").value;
    var endDate = document.getElementById("EndDate").value;

    if ((Date.parse(startDate) >= Date.parse(endDate))) {
        alert("End date should be greater than Start date");
        document.getElementById("EndDate").value = "";
    }
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
<?php $type=$u->getUserType();if($type=='Finance'){?><a href='Finance-board.php'>Dashboard</a><?php }?>

&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>

  <div class="in-bloc cent row"><img src="img/globe.jpg" alt="Travel-desk-view" /><h1 class="in-bloc">Basic Travel Plan List report</h1></div>
  
<form name="basic_report" method="post">
  <table class="resp"><!--rows to be added dynamically as required-->
 
<tr><th colspan="10">Start Date:&nbsp;&nbsp;<input type="date" id="stdate" name="stdate" value="<?php echo $_POST['stdate'];?>" ></th>
<th colspan="10">End Date:&nbsp;&nbsp;<input type="date" name="endate" id="endate" value="<?php echo $_POST['endate'];?>" ></th>
        <th colspan="2"><input type="submit" name="report" value="Get Report" ></th></tr>
    <tr><td colspan="22"><span style="float:right; margin-bottom:10px; font-weight:bold; font-color:#43729f;"><a href="export-travel-request-recived-basicreport.php?stdate=<?php echo $_POST['stdate'];?>&endate=<?php echo $_POST['endate'];?>">Export All</a></span></td></tr>

  </table>
    </form> 
 
  <table class="resp"><thead>

<h2>Report contains following columns.</h2>

<tr>
      <th>Request ID</th>
      <th>Request Date</th>
      <th>Entity</th>
      <th>Business unit</th>
      <th>Employee Name</th>
      <th>Purpose of Visit</th>
      <th>Travel Date</th>
      <th>Airline Booking Done (Yes/No)</th>	
      <th>E-Ticket</th>
      <th>Air Fare</th>
      <th>Car Booking Done (Yes/No)</th>	
      <th>Car Utilization Details</th>	
      <th>Car Service Provider</th>
      <th>Hotel Booking Done (Yes/No)</th>	
      <th>Hotel Name</th>	
      <th>Check In Date</th>	
      <th>Check Out Date</th>	
      <th>Visa Applied for Country</th>	
	<th>Train Booking Done(Yes/No)</th>
	<th> Train Travel Date</th>
	<th> Boarding From</th>
	<th> Train</th>
</tr></thead>
  <tbody>
	<?php 
	foreach ($travel_requests as $request){
	?>
    <tr>
      <td align="center"><?php echo $request['trip_id']; ?></td>
      <td align="center"><?php echo $request['request_date']; ?></td>
      <td align="center"><?php echo $request['entity']; ?></td>
      <td align="center"><?php echo $request['bu_short_name']; ?></td>
      <td align="center"><?php echo $request['firstname']." ".$request['middlename']." ".$request['lastname']; ?></td>
      <td align="center"><?php echo $request['purpose_of_visit']; ?></td>
      <td align="center"><?php echo $request['air_travel_date']; ?></td>
      <td align="center"><?php if($request['air_travel_date'] != ''){ echo "Yes";} else{ echo "No"; }?></td>
      <td align="center"><?php echo $request['e_ticket']; ?></td>
      <td align="center"><?php echo $request['cost']; ?></td>
      <td align="center"><?php if($request['car_service_provider'] != ''){ echo "Yes";} else{ echo "No"; }?></td>
      <td align="center">
	<?php 
		if($request['airport_drop'] == 'yes'){echo "Pickup Address: ".$request['airport_pickup_loca']."<br />";} 
		if($request['airport_pickup'] == 'yes'){ echo "Destination Address".$request['airport_drop_loca']."<br />";} 
		if($request['type_of_vehicle'] != ''){ echo "Type of vehicle: ".$request['type_of_vehicle']."<br />";} 
		if($request['car_type'] != ''){ echo "Car Type: ".$request['car_type']."<br />";} 
		if($request['car_pickup_location'] != ''){ echo "Pickup Address: ".$request['car_pickup_location']."<br />";} 
		if($request['car_fromdate'] != ''){ echo "Car From Date: ".$request['car_fromdate']."<br />";} 
		if($request['car_todate'] != ''){ echo "Car To Date: ".$request['car_todate']."<br />";} 
	?>

      </td>
      <td align="center"><?php echo $request['car_service_provider']; ?></td>
      <td align="center"><?php if($request['hotel_name'] != ''){ echo "Yes";} else{ echo "No"; }?></td>
      <td align="center"><?php echo $request['hotel_name']; ?></td>
      <td align="center"><?php echo $request['check_in']; ?></td>
      <td align="center"><?php echo $request['check_out']; ?></td>
      <td align="center"><?php echo $request['visa-country']; ?></td>
      <td align="center"><?php if($request['train_travel_date'] != ''){ echo "Yes";} else{ echo "No"; }?></td>
      <td align="center"><?php echo $request['train_travel_date']; ?></td>
      <td align="center"><?php echo $request['boarding_from']; ?></td>
      <td align="center"><?php echo $request['train']; ?></td>
    </tr>
	<?php } ## foreach ends ?>
   </tbody>
</table>

<table><tr><td align="center">
<?php
$limit = 10;
$travelrequests = $u->getTravelRequestsBasicReportPagination($data);
$total_records = count($travelrequests);

$total_pages = ceil($total_records / $limit);
$pagLink = "<div class='pagination'><strong>Page No.";
for ($i = 1; $i <= $total_pages; $i++) {

    $pagLink .= "<a href='?page=" . $i . "&id=" . $_GET['id'] . "'>" . $i . "</a>" . "     ";
}

echo $pagLink . "</div></strong>";;
?></td></tr>
</table>

  </div>
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
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  
  
</body>
</html>
