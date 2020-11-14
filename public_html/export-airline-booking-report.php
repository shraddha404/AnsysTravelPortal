<?php
session_start();
if($_SESSION['user_type'] == 'Travel Desk'){
include_once ('../lib/TravelDesk.class.php');
$u = new TravelDesk($_SESSION['user_id']);
$travel_requests = $u->getAirlinebookingreport();
}
else if($_SESSION['user_type'] == 'Manager'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Manager.class.php';
$u = new Manager($_SESSION['user_id']);
$travel_requests = $u->getAirlinebookingreport();
}
//print_r($travel_requests);

if(empty($travel_requests)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."airline-booking-report.csv";
# output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
# Start the ouput


$content = '';
$title = '';
      
foreach($travel_requests as $requests){
$content .= stripslashes($requests['id']). ',';
$content .= stripslashes($requests['firstname']." ".$requests['middlename']." ".$requests['lastname']). ',';
$city=$u->getcity($request['travel_from']);
$cityto=$u->getcity($request['travel_to']);
$content .= stripslashes($requests['date']);
$content .= stripslashes($city['city_name']). ',';
$content .= stripslashes($request['date']). ',';
$content .= stripslashes($request['departure_time']). ',';
$content .= stripslashes($request['meal_preference']). ',';
$content .= stripslashes($requests['e_ticket']). ',';
$content .= stripslashes($requests['cost']). ',';
$content .= "\n";
}
$title .= "Trip Id,Employee Name,From Location,To Location,Departure Date,Departure Time,Meal Preference,E-ticket,Cost"."\n";
echo $title;
echo $content;
}
	
?>


