<?php session_start();
include_once ('../lib/Manager.class.php');
if($_SESSION['user_type'] == 'Employee'){
$u = new Employee($_SESSION['user_id']);
}
else if($_SESSION['user_type'] == 'Manager'){
$u = new Manager($_SESSION['user_id']);
}

if(empty($_SESSION['user_id']))
{
header("location:login.php");
}
//$u = new User($_SESSION['user_id']);
if(!$u->isMyProfileComplete()){
    header("location:profile.php");
}
if($_POST){
#print_r($_POST);
#exit;
/*function filter_callcar($val) {
    $val = trim($val);
    return $val != '';
}
	$car_company = array_values(array_filter($_POST['car_company'], 'filter_callcar'));
	if(count($car_company) == 0) {
		 $message="Plese fill required details.Please fill Car Company";
	}
	else
	{   */   
		$details = $u->travelrequestbooking($_POST);

		if($details){

			$message=ucfirst($_POST['trip_type'])."   "."Request booked successfully";
			header( "refresh:5;url=my-request.php" );
		/*}*/
	}
}
$cities = $u->cities();
$airlines = $u->airlinesAirlines();
$hotels = $u->hotels();
$cars = $u->cars();
//print_r($_SESSION);
//Array ( [city_id] => 1416 [city_name] => Tetri Bazar [city_state] => Uttar Pradesh );?><!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]--><head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
//multiple trip
$(document).ready(function() {
////////////
$('#travel_to').change(function(){
//var st=$('#category option:selected').text();
var id=$('#travel_to').val();
$('#pref_hotel').empty(); //remove all existing options
///////
$.get('ajaxDatahotellist.php',{'id':id},function(return_data){
$.each(return_data.data, function(key,value){
		$("#pref_hotel").append("<option value='" + value.id +"'>"+value.hotel_name+"</option>");
	});
}, "json");
///////
});
/////////////////////
});


</script>
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
</head>
<body>
<div id="wrapper">
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
  <div role="main">
  <form id="travel-booking" method="post" action="" onsubmit="return confirm('Are you sure you want to submit this Car Booking form?');">
  	<div class="row cent clearfix">
	    <div class="in-bloc cent"><!--img src="img/car.png" alt="profile creation" /--><h1 class="in-bloc">Car Booking</h1><?php if(!empty($message)) { echo "<p style='color:green;'>".$message."</p>"; }?></div>
    </div><input type="hidden" id="booking" name="booking" value="car"/>
    <!-- Travel details-->
    <div class="row"> <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>






    <span class="f-leg"><img src="img/travel_details.png" />Provide Visit Details</span>
    <fieldset name "travel-details">
              <div class="col-2-grid"><!--label for "trip-type">Type of trip </label>
           <ul class="radio"><li><input type="radio" name="trip_type" value="oneway" id="oneway" /><label for "oneway">Oneway </label></li><li><input type="radio" name="trip_type" value="round trip"  id="twoway" /> <label for "roundtrip">Round trip</label></li><li> <input type="radio" name="trip_type" value="multicity" id="multi" /> <label for "multicity">Multi city </label></li></ul-->
           <!--p><label for "adv">Cost of hotel, please enter the amount</label><input type="text" id="cost" name="cost"  autofoucs /></p-->
         </div>
         
          <div class="col-2-grid clearfix">  <p><label for "tour-purpose">Purpose of visit </label>
        <textarea name="purpose_of_visit" placeholder="Please mention specific purpose of visit; DO NOT mention business visit" rows="3" required></textarea></p>
         </div>
          
<div class="col-3-grid"> 

<p><label for "air-co">Multiple Days Booking :</label><input type="checkbox" name="multiple" class="multiple" id="multiple" value="1"></p>
<p><label for="fromdate">From Date:</label><input id="fromdate" name="fromdate" value="" type="date" class="cal_from_date" /></p>
<p><label for="todate">To Date:</label><input type="date" id="todate" name="todate" value="" ></p>

</div>
     </fieldset>
    </div>
    <!-- Travel details end-->
    

      <div class="row" style="display:none;">
      <div class="tbBooks" id="tbBooks"> 
   <!-- Destination and Departure details-->
<span class="f-leg"><img src="img/car.png" width="32px" height="32px"/>Car details</span>
      <fieldset name "dest-dep">
       	<div class="col-3-grid">
	<h3>Individual Day Booking</h3>
   <p><label for "air-co">Pickup Date</label><input type="text" class="cal_pickup_date" id="pickup_date" name="pickup_date[]" value="" ></p>
        <p><label for "air-co"> Need car for the entire day</label><input type="checkbox" name="need_car[]" value="yes"></p>
	<p><label for "car-co"><span style="color:red;">*</span>Car Vendor</label><select name="car_company[]" id="car_company" class="car_company" autofocus >
<option value="">Select preferred car vendor co.</option>
<?php
    foreach($cars as $car) { ?>
      <option value="<?php echo $car['id']; ?>"><?php echo $car['name']; ?></option>
  <?php
    } ?>

</select> </p>
<p><label for "air-pickup">Car type</label><select name="car_size[]" id="car_size" class="car_size">
<option value="">Select Car Type</option>
<option value="Mid Size" <?php if($_POST['car_size']=='Mid Size') {echo "selected='selected'";}?>>Mid Size</option>
<option value="SUV" <?php if($_POST['car_size']=='SUV') {echo "selected='selected'";}?>>SUV</option>
</select></p>
            </div>

       	<div class="col-3-grid"> <?php $user=$u->getuserdetails($_SESSION['user_id']);
$city=$u->getcity($user['city']); ?>
	<p>&nbsp</p>
        <p><label for "air-co">Pickup city</label><input type="text" name="pickup_city[]" value="<?php echo $city['city_name'];?>"></p>
        <!--p><label for "air-co">Drop Location</label><input type="text" name="drop_location[]" value=""></p-->
        <p><label for "dep-date1">Pickup Time </label><input type="text" id="car_pickuptime" name="car_pickuptime[]" placeholder="Please mention pick up time for the drop" autofocus /></p>
        <p><label for "air-co">Pickup Address</label><input type="text" name="car_pickup_location[]" value="" placeholder="Please mention pick up address" ></p>
       <p><label for "air-co">Destination Address</label><input type="text" name="destination[]" value="" placeholder="Please mention destination / Drop address" ></p>

</div>
        
  </div>  

</div> 


<!--/div--> 
<div id="container2"></div> 
<div class="btn-set" id="add_button"> <input type="button" class="" value="ADD Booking" /></div> <br/>
   <div class="row">
       <!-- additional instructions-->
 <p style="color:red;"><strong>NOTE:If car booking is not for your self please mention the guest name in special mention</strong></p>
       <span class="f-leg"><img src="img/note2.png" />Special mention</span>
      <fieldset name "special-notes">
        <textarea name="special_mention" placeholder="Please mention any depcific requirements" rows="5" ></textarea></p>
      </fieldset>
       
   </div>
    <div class="row cent"><input type="SUBMIT" value="SUBMIT" /><?php  $type=$u->getUserType();if($type=='Employee'){?> <input type="button"value="CANCEL"onclick="javascript:window.location='emp-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><input type="button" value="CANCEL" onclick="javascript:window.location='manager-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><input type="button" value="CANCEL"onclick="javascript:window.location='travel-desk-board.php';"><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><input type="button" value="CANCEL" onclick="javascript:window.location='admin-board.php';"><?php }?></div>
 </form>
  

  </div>
  <footer>

  </footer>
</div><!--wrapper ends--> 
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/DateTimePicker.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script> -->
  
  <script type="text/javascript">





$(document).ready(function () {
    $( "#fromdate" ).prop( "disabled", true );
    $( "#todate" ).prop( "disabled", true );
$(function() {
    $('.btn-set').click();
});
var iCnt = 1;
             	
	if(iCnt => 1){ 
		$('#add_button').on('click', function () {
			var copy = $('#tbBooks').clone(true);
			var new_div_id = 'tbBooks'+iCnt;
			copy.attr('id', new_div_id );
			$('#container2').append(copy);
			$('#' + new_div_id).find('input,select').each(function(){
			    $(this).attr('id', $(this).attr('id') + iCnt);
			 });			

			$("#pickup_date"+iCnt  ).datepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;
 			
			$("#car_company"+iCnt).attr('required', true); 
			iCnt++;

		});
	
	}		
			$( "#todate" ).datepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"}); inline:true;

 });


//round trip


$(document).ready(function() {
$('#multiple').change(function () {
if (!$(this).is(':checked')) {
	$('#add_button').show();   
	 $( "#fromdate" ).prop( "disabled", true );
	document.getElementById("fromdate").value =''; 
	$('#fromdate').attr('disabled', '');
	document.getElementById("todate").value =''; 
	    $( "#todate" ).prop( "disabled", true );
	document.getElementById("#pickup_date"+'1' ).value =''; 
}
});

   $('input[type="checkbox"]').click(function() {

       if($(this).attr('id') == 'multiple') 
		{
			$("#fromdate").datepicker({  
				inline:true,            
				timeFormat: "HH:mm:ss",
				dateFormat: "yy-mm-dd",
				onSelect: function(){   
				var pickupDate = $(this).datepicker('getDate');  
				$( "#pickup_date"+'1' ).datepicker("setDate", new Date(pickupDate.getTime()));  

				}  
			});	
  $( "#fromdate" ).prop( "disabled", false );
    $( "#todate" ).prop( "disabled", false );
		//$('#add_button').hide();           
		}
		else {
		//$('#add_button').show();   
		}
	});
});

 
</script>

  <!-- scripts concatenated and minified via build script -->
  <!-- script src="js/plugins.js"></script -->
  <!-- end scripts -->

<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/DateTimePicker.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
</script>
<script>
	//date time picker
	/*$(function(){
		//$( "#fromdate" ).datetimepicker(); inline:true;
		//$( "#todate" ).datetimepicker(); inline:true;
		//$( "#pickup_date" ).datetimepicker(); inline:true;
	});*/
</script>

  <script type="text/javascript">  
     $(document).ready(function() {                                       
        $("#onwardcity").live("change", function() {
        $("#pickupcity").val($(this).find("option:selected").text());
	$("#myselect :selected").text();
	
	$('#add_button').click();
        })
                                
</script>




</body>
</html>


