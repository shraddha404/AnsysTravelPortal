<?php
session_start();
if($_SESSION['user_type'] == 'Travel Desk'){
include_once ('../lib/TravelDesk.class.php');
$u = new TravelDesk($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsreport($_GET);
}
else if($_SESSION['user_type'] == 'Manager'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Manager.class.php';
$u = new Manager($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsreport($_GET);
}
else if($_SESSION['user_type'] == 'Admin'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
$u = new Admin($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsreport($_GET);
}
else if($_SESSION['user_type'] == 'Finance'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Finance.class.php';
$u = new Finance($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsreport($_GET);
}

if(empty($travel_requests)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."travel-request-received-report.csv";
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
 if($requests['manager_approved']==0){ $a= "Pending";} else{ $a= "Approved";}
$content .= stripslashes($requests['id']). ',';
$content .= stripslashes($requests['date']). ',';
$content .= stripslashes($requests['firstname']." ".$requests['middlename']." ".$requests['lastname']). ',';
$content .= stripslashes($requests['biz_unit']). ',';
$content .= stripslashes($a). ',';
$content .= "\n";
}
$title .= "Request ID,Request Date,Generated by,Business unit,Approval status"."\n";
echo $title;
echo $content;
}
	
?>
