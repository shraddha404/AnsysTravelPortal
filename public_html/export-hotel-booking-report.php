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
$filename=date('Y-m-d')."hotel-booking-report.csv";
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
$hotel=$u->gethotel($requests['hotel_id']);
$city=$u->getcity($requests['from_location']);
$content .= stripslashes($requests['id']). ',';
$content .= stripslashes($requests['firstname']." ".$requests['middlename']." ".$requests['lastname']). ',';
$content .= stripslashes($hotel['hotel_name']);
$content .= stripslashes($requests['hotel_address']). ',';
$content .= stripslashes($request['check_in']). ',';
$content .= stripslashes($request['check_out']). ',';
$content .= stripslashes($requests['hotel_confirmation_num']). ',';
$content .= stripslashes($requests['cost']). ',';
$content .= "\n";
}
$title .= "Trip Id,Employee Name,Hotel Name,Hotel Address,Check in Date-Time,From Location,Airport drop location,Pickup Time,Need car,Cost"."\n";
echo $title;
echo $content;
}
	
?>
   

