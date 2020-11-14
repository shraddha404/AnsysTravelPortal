<?php
session_start();
if($_SESSION['user_type'] == 'Travel Desk'){
include_once ('../lib/TravelDesk.class.php');
$u = new TravelDesk($_SESSION['user_id']);
$travel_requests = $u->getTravelRequestsplan();
}
else if($_SESSION['user_type'] == 'Manager'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Manager.class.php';
$u = new Manager($_SESSION['user_id']);
$travel_requests = $u->getTravelRequestsplan();
}
//print_r($travel_requests);


if(empty($travel_requests)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."_detailed-travel-plan-report.csv";

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
$content = '';
$title = '';
foreach ($travel_requests as $request){
$travel_date = $request['date']." To ".$request['return_date'];
$content .=stripslashes($request['id']);
$content .= stripslashes($request['firstname']." ".$request['middlename']." ".$request['lastname']). ',';
$content .= stripslashes($request['purpose_of_visit']). ',';
$content .= stripslashes($request['biz_unit']). ',';
$content .= $travel_date;
$content .= stripslashes($request['trip_type']). ',';
$content .= stripslashes($request['special_mention']). ',';
$content .= stripslashes('Cost:'.$request['cost'].'  '.'Cash in advance:'.$request['cash_adv']);

$content .= "\n";
}
$title .= "Trip Id,Employee Name,Purpose of visit,Business unit,Date of Travel,Trip Type,Special Mention,Cash Details"."\n";
echo $title;
echo $content;
}
?>


