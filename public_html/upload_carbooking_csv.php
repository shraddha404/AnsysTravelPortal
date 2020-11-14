<?php
session_start();
include_once ('../lib/User.class.php');
$u = new User($_SESSION['user_id']);

if(empty($_SESSION['user_id']))
{
header("location:login.php");
}
if($_POST['submit']=='submit')
{

	if (is_uploaded_file($_FILES['carcsv']['tmp_name'])) {
			if(isset($_FILES['carcsv'])){  //print_r($_POST); print_r($_FILES);

					if ($_FILES['carcsv']['type'] != "text/csv") {
							 $msg="<p>Class notes must be uploaded in csv format.</p>";
					} else {
							 $name = $_FILES['carcsv']['name'];
							//$path = $u->createUserLeavesFolder($_POST['emp_id']);

							//if($path){
							$result = move_uploaded_file($_FILES['carcsv']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/uploads/car-booking-csv/'.$name);
							if ($result == 1){ 
							$msg= "<p>Csv File Uploaded Successfully .</p>";
							rename($_SERVER['DOCUMENT_ROOT'].'/uploads/car-booking-csv/'.$name, $_SERVER['DOCUMENT_ROOT'].'/uploads/car-booking-csv/car_booking.csv');
							}
							else{ $msg= "<p>Sorry, Error happened while uploading . </p>";}
							//}#end if($path){
						} #endIF
			} #endIF*
	         } #endIF	if (is_uploaded_file($_FILES['carcsv']['tmp_name'])) {
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/car-booking-csv/car_booking.csv')) { 
 if (($file = fopen($_SERVER['DOCUMENT_ROOT'].'/uploads/car-booking-csv/car_booking.csv', "r")) !== FALSE)
 {
    while (($data = fgetcsv($file)) !== FALSE)
           {
	
			$select = $u->pdo->prepare("select destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from destination_and_departure left join emp_list on destination_and_departure.emp_id = emp_list.id WHERE destination_and_departure.id = ? ORDER BY destination_and_departure.id ASC");
	
				$select->execute(array($data[0]));

				 while ($row = $select->fetch(PDO::FETCH_ASSOC)){
					$trips[] = $row;

			 $stmt2 = "INSERT INTO car_bookings(`emp_id`,`car_company`,`approved`,`trip_id`,`date`,`car_fromdate`,`car_todate`,`type_of_vehicle`,`pickup_time`,`airport_pickup_loca`,`need_car`,`airport_pickup`,`airport_drop`,`airport_drop_loca`,`car_for_city`,`cost`,
					`car_type`,`car_size`,`car_pickup_location`,`destination`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$stmt2 = $u->pdo->prepare($stmt2);
					$stmt2->execute(array($row['tripempid'],$row['car_company'],'n',$row['trip_id'],$row['car_pickup_date'],$row['car_fromdate'],$row['car_todate'],$row['type_of_vehicle'],$row['pickup_time'],$row['airport_pickup_loca'],$row['need_car'],$row['airport_pickup'],$row['airport_drop'],$row['airport_drop_loca'],$row['car_city'],$row['cost'],$row['car_type'],$row['car_size'],$row['car_pickup_location'],$row['destination']));

				}
//$u->pdo->update('car_bookings', array('cost'=>$data[1]), '`id`='.$data[0]); return true;	
//$update= "UPDATE car_bookings SET cost = ".$data[1]."  WHERE id = ".$data[0];
//$update_qry = $u->pdo->prepare("UPDATE car_bookings SET cost =?  WHERE id =?");	

        }

    }   

}


}
?><!doctype html>
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
  <script src="js/libs/jquery-1.7.1.min.js"></script>
</head>
<body>
<div id="wrapper">
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
 <div role="main">



   <div class="row"><!--row begins--> <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<form name='form1' action='' method="POST" enctype="multipart/form-data">
<font color="green"><div style="font-color:green; font-weight:bold;"><?php echo $msg;?></div></font>
<div style="font-size:16px; font-weight:bold;">Please upload car bookings CSV file :-- <input type="file" name="carcsv">
<input type="submit" name="submit" value="submit"></div>
</form>
  </div>
  </div>
  </div>
