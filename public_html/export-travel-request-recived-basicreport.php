<?php
session_start();
 if($_SESSION['user_type'] == 'Admin'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
$u = new Admin($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsBasicReport($_GET);
}
else if($_SESSION['user_type'] == 'Finance'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Finance.class.php';
$u = new Finance($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsBasicReport($_GET);
 //print_r($travel_requests);
}

if(empty($travel_requests)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."travel-request-received-basicreport.csv";
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
 
$content .= stripslashes( $requests['trip_id']). ',';
$content .= stripslashes($requests['request_date']). ',';
$content .= stripslashes($requests['firstname']." ".$requests['middlename']." ".$requests['lastname']). ',';
$content .= stripslashes($requests['purpose_of_visit']). ',';

$content .= "\n";
}
$title .= "Request ID,Request Date,Generated by,Purpose of Visit"."\n";
echo $title;
echo $content;
}
	
?>
