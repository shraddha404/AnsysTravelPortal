<?php
session_start();
if($_SESSION['user_type'] == 'Travel Desk'){
	include_once ('../lib/TravelDesk.class.php');
	$u = new TravelDesk($_SESSION['user_id']);
}else if($_SESSION['user_type'] == 'Admin'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
$u = new Admin($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsreport($_GET);
}
else if($_SESSION['user_type'] == 'Finance'){
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Finance.class.php';
$u = new Finance($_SESSION['user_id']);
 $travel_requests = $u->getTravelRequestsreport($_GET);
}

	$travel_requests = $u->getTraveldatewisereportpagination($_GET);   

if(empty($travel_requests)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."date-wise-travel-plan-report.csv";
header('Content-Type: application/csv');
header('Content-Disposition: attachement; filename='.$filename);

$content = '';
$title = '';
      //print_r($travel_requests);
foreach($travel_requests as $requests){
$travel_date = $requests['date']." To ".$requests['return_date'];
$purpose_of_visit= $requests['purpose_of_visit'];
$purpose_of_visit = preg_replace("/, */", ' ', $purpose_of_visit);
$purpose_of_visit = preg_replace('/^[ \t]*[\r\n]+/m', '', $purpose_of_visit);
$meal_preference = preg_replace("/, */", ' ', $requests['meal_preference']);
$meal_preference = preg_replace('/^[ \t]*[\r\n]+/m', '', $meal_preference);


$orgunit=$u->getous($requests['ou']);
$city=$u->getcity($requests['travel_from']);
$cityto=$u->getcity($requests['travel_to']);
$airline=$u->getairlines($requests['book_airline']); 
$car=$u->getcars($requests['car_company']); 
$hotel=$u->gethotel($requests['hotel_id']); 

/********Comman  booking fields*****************/
$name=$requests['firstname']."  ".$requests['middlename']."  ".$requests['lastname'];
$content .= '"'.stripslashes($requests['date']). '",';
$content .= '"'.stripslashes($requests['id']). '",';
$content .= '"'.stripslashes($requests['purpose_of_visit']). '",';
$content .= '"'.stripslashes($name). '",';
$content .= '"'.stripslashes($orgunit['ou_short_name']). '",';
$content .= '"'.stripslashes($travel_date). '",';
 /********Airline  booking fields*****************/
if ($_GET['booking_type']=='airline'|| empty($_GET['booking_type'])){
$content .= '"'.stripslashes($city['city_name']). '",';
$content .= '"'.stripslashes($cityto['city_name']). '",';
$content .= '"'.stripslashes($airline['name']). '",';
$content .= '"'.stripslashes($requests['ticket_number']). '",';

}
/********Car  booking fields*****************/
 if($_GET['booking_type']=='car'){
$content .= '"'.stripslashes($car['name']). '",';
$content .= '"'.stripslashes($requests['car_size']). '",';
$content .= '"'.stripslashes($requests['need_car']). '",';
$content .= '"'.stripslashes($requests['car_pickup_location']). '",';
$content .= '"'.stripslashes($requests['destination']). '",';
}
/********Hotel booking fields*****************/
if($_GET['booking_type']=='hotel'){
$content .= '"'.stripslashes($hotel['hotel_name']). '",';
$content .= '"'.stripslashes($requests['check_in']). '",';
$content .= '"'.stripslashes($requests['check_out']). '",';
$content .= '"'.stripslashes($requests['hotel_confirmation_num']). '",';
$content .= '"'.stripslashes($requests['late_checkin']). '",';
$content .= '"'.stripslashes($requests['late_checkout']). '",';
$content .= '"'.stripslashes($requests['noofguests']). '",';
$content .= '"'.stripslashes($requests['noofrooms']). '",';
$content .= '"'.stripslashes($requests['room_type']). '",';
}
/********Train booking fields*****************/
if($_GET['booking_type']=='train'){ 
$cityto=$u->getcity($requests['train_to']);
$city=$u->getcity($requests['train_from']);
$passenger=$requests['firstname']."  ".$requests['middlename']."  ".$requests['lastname'];
$content .= '"'.stripslashes($passenger). '",';
$content .= '"'.stripslashes($city['city_name']). '",';
$content .= '"'.stripslashes($cityto['city_name']). '",';
$content .= '"'.stripslashes($requests['age']). '",';
$content .= '"'.stripslashes($requests['train']). '",';
$content .= '"'.stripslashes($requests['date']). '",';
$content .= '"'.stripslashes($requests['train_id']). '",';
$content .= '"'.stripslashes($requests['class']). '",';
$content .= '"'.stripslashes($requests['boarding_form']). '",';
}
$content .= stripslashes($requests['cost']). ',';
$content .= "\n";
}
if($_GET['booking_type']=='airline' || empty($_GET['booking_type'])){
$title .= "Date,Trip Id,Purpose Of Visit,Name,Org Unit,Date of Travel,From Location,To Location,Preferred Airline,Ticket Number,Cost"."\n";
}
if($_GET['booking_type']=='car'){
$title .= "Date,Trip Id,Purpose Of Visit,Name,Org Unit,Date of Travel,Preferred Car vendor,Car Size,Need Car For Day,Car Pickup Location,Destination,Cost"."\n";
}
if($_GET['booking_type']=='hotel'){
$title .= "Date,Trip Id,Purpose Of Visit,Name,Org Unit,Date of Travel,Preferred Hotel,Check in date-time,Check Out date-time,Confirmation Number,Late Checkin,Late Checkout,No.Of Guests,No.Of Rooms,Room Type,Cost"."\n";
}
if($_GET['booking_type']=='train'){
$title .= "Date,Trip Id,Purpose Of Visit,Name,Org Unit,Date of Travel,Name of Passenger,From Location,Destination,Age,Train,Date,Train Id,Class,Boarding From,Cost"."\n";
}
echo $title;
echo $content;
}
	
?>
