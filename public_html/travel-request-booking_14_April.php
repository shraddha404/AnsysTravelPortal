<?php
session_start();
include_once ('../lib/User.class.php');
$u = new User($_SESSION['user_id']);


if($_POST){
//print_r($_POST);
$details = $u->travelrequestbooking($_POST);
}
$cities = $u->cities();
$airlines = $u->airlines();
$hotels = $u->hotels();
//echo md5('rupali');
 //echo md5('manager123');
//print_r($_SESSION);
//Array ( [city_id] => 1416 [city_name] => Tetri Bazar [city_state] => Uttar Pradesh );?>

<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->






<head>
<script src="//ajax.googleapis.com/ajax/
libs/jquery/1.8.1/jquery.min.js"></script>

<script>
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
  <form id="travel-booking" method="post" action="">
  	<div class="row cent clearfix">
	    <div class="in-bloc cent"><img src="img/bag.jpg" alt="profile creation" /><h1 class="in-bloc">Book your travel request</h1></div>
    </div>
    <!-- Travel details-->
    <div class="row">
    <span class="f-leg"><img src="img/travel_details.png" />Provide travel details</span>
    <fieldset name "travel-details">
              <div class="col-2-grid"><label for "trip-type">Type of trip </label>
           <ul class="radio"><li><input type="radio" name="trip_type" value="oneway" id="oneway" /><label for "oneway">Oneway </label></li><li><input type="radio" name="trip_type" value="round trip"  id="twoway" /> <label for "roundtrip">Round trip</label></li><li> <input type="radio" name="trip_type" value="multicity" id="multi" /> <label for "multicity">Multi city </label></li></ul>
           <p><label for "adv">If cash advance required, please enter the amount</label><input type="text" id="cash_adv" name="cash_adv" placeholder="Cash advance amount" autofoucs /></p>
          	       
         </div>
         
          <div class="col-2-grid clearfix">  <p><label for "tour-purpose">Purpose of visit </label>
        <textarea name="purpose_of_visit" placeholder="Please mention specific purpose of visit; DO NOT mention business visit" rows="3" ></textarea></p>
         </div>
       
          
     </fieldset>
    </div>
    <!-- Travel details end-->
    

      <div class="row">
      <div class="tbBooks" id="tbBooks"> 
   <!-- Destination and Departure details-->
<span class="f-leg"><img src="img/destination2.png" />Destination and departure details</span>
      <fieldset name "dest-dep">
        <div class="col-3-grid"><p><label for "from1">From</label><select name="travel_from[]"><option value=""><!--list to be populated dynamically-->From City</option>

<?php
    foreach($cities as $citie) { ?>
      <option value="<?php echo $citie['city_id'] ?>"><?php echo $citie['city_name'] ?></option>
  <?php
    } ?>
 </select> </p>
        <p><label for "TO1">To</label><select name="travel_to[]" id="travel_to" ><option value=""><!--list to be populated dynamically-->To city</option><?php
    foreach($cities as $citie) { ?>
      <option value="<?php echo $citie['city_id']; ?>"><?php echo $citie['city_name']; ?></option>
  <?php
    } ?> </select></p></div>
          	<div class="col-3-grid">
         	<p><label for "air-co">Select preferred Airlines</label>
<select name="book_airline[]"> 

<?php
    foreach($airlines as $airline) { ?>
      <option value="<?php echo $airline['id']; ?>"><?php echo $airline['name']; ?></option>
  <?php
    } ?></select> 
</p>
	<p><label for "hotel">Preferred hotel in the city</label><select id="pref_hotel" class="pref_hotel" name="pref_hotel[]"> 
<option value="">Preferred hotel in the city</option>
<?php
    foreach($hotels as $hotel) { ?>
      <option value="<?php echo $hotel['id']; ?>"><?php echo $hotel['hotel_name']; ?></option>
  <?php
    } ?>


</select></p>
            
            </div>
         	<div class="col-3-grid"><p><label for "dep-date1">Departure date </label>
         	<input type="date" id="date" name="date[]" placeholder="Departure date" autofocus /></p>
            <p><label for "car-co">Select preferred car vendor co.</label><select name="car_company[]">

<?php
    foreach($cars as $car) { ?>
      <option value="<?php echo $car['id']; ?>"><?php echo $car['name']; ?></option>
  <?php
    } ?>

</select> </p></div>
             
            
             
  </fieldset>
     <!-- Destination and Departure details end-->
        
  </div>  </div>   <div id="container2" style="display:none;"></div> 
<div class="btn-set"> <input type="button" class="" value="ADD CITY" /></div>
   <div class="row">
       <!-- additional instructions-->
       <span class="f-leg"><img src="img/note2.png" />Special mention</span>
      <fieldset name "special-notes">
        <textarea name="special_mention" placeholder="Please mention any depcific requirements" rows="5" ></textarea></p>
      </fieldset>
       
   </div>
    <div class="row cent"><input type="SUBMIT" value="SUBMIT" /></div>
 </form>
  

  </div>
  <footer>

  </footer>
</div><!--wrapper ends--> 

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
  
  <script type="text/javascript">
$(document).ready(function() {
	
	$('.btn-set').hide(); 
   	$('input[name="trip_type"]').click(function() {
		
	   
       if($(this).attr('id') == 'multi') {
		  
            $('.btn-set').show();           
       }

       else {
            $('.btn-set').hide();   
       }
   });
});



    $(document).ready(function () {
        var iCnt = 1;

        $('.btn-set').on('click', function () {
            $('#tbBooks')
                .clone().val('')      // CLEAR VALUE.
                .attr('style', 'margin:3px 0;', 'id', 'tbBooks' + iCnt)     // GIVE IT AN ID.
                .appendTo("#container2");

            // ADD A SUBMIT BUTTON IF ATLEAST "1" ELEMENT IS CLONED.
            if (iCnt == 1) {
                var divSubmit = $(document.createElement('div'));

            }
            $('#container2').after(divSubmit);
            $("#container2").attr('style', 'display:block;margin:3px;');

            iCnt = iCnt + 1;
        });
    });
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
