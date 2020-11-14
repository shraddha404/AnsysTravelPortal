<?php
session_start();
if($_SESSION['user_type'] == 'Travel Desk'){
	include_once ('../lib/TravelDesk.class.php');
	$u = new TravelDesk($_SESSION['user_id']);
}

	//$travel_requests = $u->getTraveldatewisereportpagination($_GET);   
	$travel_requests = $u->getDestDepartByFilter($_GET);   

if(empty($travel_requests)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."date-wise-dest-dep-report.csv";
header('Content-Type: application/csv');
header('Content-Disposition: attachement; filename='.$filename);

$content = '';
$title = '';
      //print_r($travel_requests);
foreach($travel_requests as $requests){

//$location = $requests['address1']."- ".$requests['address2']."- ".$requests['city'];
$location = $requests['address1']." - ".$requests['city'];
$name =$requests['firstname']."  ".$requests['middlename']."  ".$requests['lastname'];
$travel_date = $requests['req_date']." To ".$requests['return_date'];
$fromcity = $u->getcity($requests['travel_from']);
$tocity = $u->getcity($requests['travel_to']);
$sector = $fromcity['city_name']." To ".$tocity['city_name'];
$car_usage = $requests['car_type']." - ".$requests['car_size'];
$car=$u->getcars($requests['car_company']);
$carbooking=$u->carBooking($requests['trip_id']); 
if(empty($carbooking['id'])){ $carBook =  "No"; } else { $carBook = "Yes"; }
$hotelbooking=$u->HotelBooking($requests['trip_id']); 
if(empty($hotelbooking['id'])){ $hotelBook = "No"; } else { $hotelBook = "Yes"; }
$visa=$u->visaList($requests['emp_id']); 
//$trip=$u->getTripDetails($requests['trip_id']);

if($requests['booking_type'] == 'airline'){
$checkindate = $requests['late_checkin_date']; 
$checkoutdate = $requests['late_checkout_date'];
}else{
$checkindate = $requests['checkindate']; 
$checkoutdate = $requests['checkoutdate'];
}
$hotel = $u->gethotel($requests['pref_hotel']); 
if($requests['pref_hotel']==000){ $hotel_name = $requests['otherhotel'];  }else { $hotel_name = $hotel['hotel_name']; }

$purpose_of_visit= $requests['purpose_of_visit'];
$purpose_of_visit = preg_replace("/, */", ' ', $purpose_of_visit);
$purpose_of_visit = preg_replace('/^[ \t]*[\r\n]+/m', '', $purpose_of_visit);
/********Comman  booking fields*****************/
$content .= '"'.stripslashes($requests['trip_id']). '",';
$content .= '"'.stripslashes($requests['req_id']). '",';
$content .= '"'.stripslashes($requests['booking_type']). '",';
$content .= '"'.stripslashes($requests['req_date']). '",';
$content .= '"'.stripslashes($location). '",';
$content .= '"'.stripslashes($requests['bu_name']). '",';
$content .= '"'.stripslashes($name). '",';
$content .= '"'.stripslashes($requests['email']). '",';
$content .= '"'.$purpose_of_visit. '",';
$content .= '"'.stripslashes($travel_date). '",';
$content .= '"'.stripslashes($sector). '",';
$content .= '"'.stripslashes($requests['airline_name']). '",';
$content .= '"'.stripslashes($requests['ticket_number']). '",';
$content .= '"'.stripslashes($requests['air_fare']). '",';
$content .= '"'.stripslashes($carBook). '",';
$content .= '"'.stripslashes($car_usage). '",';
$content .= '"'.stripslashes($car['name']). '",';
$content .= '"'.stripslashes($hotelBook). '",';
$content .= '"'.stripslashes($hotel_name). '",';
$content .= '"'.stripslashes($checkindate). '",';
$content .= '"'.stripslashes($checkoutdate). '",';
$content .= '"'.stripslashes($requests['hotel_pernight']). '",';
$content .= '"'.stripslashes($visa['visa-country']). '",';
$content .= '"'.stripslashes($requests['visa_fees']). '",';
$content .= "\n";
}
if($_GET['booking_type']=='airline' || empty($_GET['booking_type'])){
$title .= "Trip ID,Request No,Booking Type, Date of Request,Employee Location,Business Unit (BU),Guest Name,Guest email id,Purpose of visit,Date of Travel,Sector,Airline,Air ticket no,Air fare,Car booking done,Car usage details,Car-Service Provider,Hotel booking done,Hotel Name,Check in Date,Check out Date,Hotel Pernight tariff,VISA applied for country,Tentative VISA Fees "."\n\n";
}
echo $title;
echo $content;
}
	
?>
