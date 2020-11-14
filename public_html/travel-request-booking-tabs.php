<?php
session_start();
include_once ('../lib/Manager.class.php');
if ($_SESSION['user_type'] == 'Employee') {
    $u = new Employee($_SESSION['user_id']);
} else if ($_SESSION['user_type'] == 'Manager') {
    $u = new Manager($_SESSION['user_id']);
}
if (empty($_SESSION['user_id'])) {
    header("location:login.php");
}

if (!$u->isMyProfileComplete()) {
    header("location:profile.php");
}
if ($_POST) {
//print_r( $_POST['late_checkinoneway']);exit;
    $message = " ";

    $details = $u->travelrequestbooking($_POST);
    if ($details) {
        $message = ucfirst($_POST['trip_type']) . "  " . "Request booked successfully";
        header("refresh:5;url=my-request.php");
//header("location:my-request.php");
    }
}

$cities = $u->cities();
$airlines = $u->airlinesAirlines();
$hotels = $u->hotelHotels();
$cars = $u->cars();
?><!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"> <!--<![endif]-->
    <head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>



        <script type="text/javascript">
            $(document).ready(function () { $("#datetrain").datepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;
                var iCnt = 1; 
               
                $('#btn-train').on('click', function () {       iCnt++;   //alert("hiii");
                    var copy = $('#tbBookstrain').clone(true);
                    var new_div_id = '#tbBookstrain' + iCnt;
                    copy.attr('id', new_div_id);
                    
   $('#containertrain').append(copy);
    $('#containertrain').append('<br/><input type="button" name="btndelete_train[]" id="btndelete_train' + iCnt + '" value="DELETE" style="margin: 20px;"><br/>');    
  
                    $('#containertrain').find('#divonwardcity').attr({id: 'divonwardcity' + iCnt, name: "divonwardcity"});
                    $('#containertrain').find('#divtravelto').attr({id: 'divtravelto' + iCnt, name: "divtravelto"});
                    $('#containertrain').find('#datetrain').attr({id: 'datetrain' + iCnt, name: "datetrain"});

                    $(new_div_id).find('input,select').each(function () {
                        $(this).attr('id', $(this).attr('id') + iCnt);
                    });

                    $("#datetrain" + iCnt).datepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;
                    $("#onward_citytrain" + iCnt).attr('required', true);
                    $("#traveltotrain" + iCnt).attr('required', true);
                    $("#train" + iCnt).attr('required', true);
                    $("#age" + iCnt).attr('required', true);
                    var divonwardcity = "divonwardcity" + iCnt;
                    var divtravelto = "divtravelto" + iCnt;
                    var onwardcity = "onward_citytrain" + iCnt;// alert("#"+hotel);
                    var travel_to = "traveltotrain" + iCnt;
                  //  $('#containertrain').find('#btndelete_train').attr({id: 'btndelete_train' + iCnt, name: "btndelete_train[]"});
                    
   var delete_train = "btndelete_train" + iCnt;
        

               // Remove element
                     $(document.body).on('click', "#" + delete_train, function () {
                     
                        document.getElementById(new_div_id).remove();
                      $(this).remove();

                    });
                    
                  
           $(document.body).on('change', "#" + onwardcity, function () {

                        var title = $("#" + onwardcity + " :selected").text();//alert(divhotel);
                        if (title == 'Others') {
                            $("#" + divonwardcity).show();
                        } else {
                            $("#" + divonwardcity).hide();
                        }
                    });

                    $(document.body).on('change', "#" + travel_to, function () {

                        var title = $("#" + travel_to + " :selected").text();//alert(divhotel);
                        if (title == 'Others') {
                            $("#" + divtravelto).show();
                        } else {
                            $("#" + divtravelto).hide();
                        }
                    });


                });
                

       

            });
            $(document).ready(function () {
                $('#multiple').change(function () {
                    if (!$(this).is(':checked')) {
                        $('#add_button').show();
                        $("#fromdate").prop("disabled", true);
                        document.getElementById("fromdate").value = '';
                        $('#fromdate').attr('disabled', '');
                        document.getElementById("todate").value = '';
                        $("#todate").prop("disabled", true);
                        document.getElementById("#pickup_date" + '1').value = '';
                    }
                });

                $('input[type="checkbox"]').click(function () {

                    if ($(this).attr('id') == 'multiple')
                    {
                        $("#fromdate").datepicker({
                            inline: true,
                            timeFormat: "HH:mm:ss",
                            dateFormat: "yy-mm-dd",
                            onSelect: function () {
                                var pickupDate = $(this).datepicker('getDate');
                                $("#pickup_date" + '1').datepicker("setDate", new Date(pickupDate.getTime()));

                            }
                        });
                        $("#fromdate").prop("disabled", false);
                        $("#todate").prop("disabled", false);
                        //$('#add_button').hide();           
                    } else {
                        //$('#add_button').show();   
                    }
                });
            });

            $(document).ready(function () {
                $("#fromdate").prop("disabled", true);
                $("#todate").prop("disabled", true);
 $("#pickup_date").datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;
                var iCnt = 0;


                $('#add_button').on('click', function () { iCnt++; 
                    var copy = $('#tbBookscar').clone(true);
                    var new_div_id = 'tbBookscar' + iCnt;
                    copy.attr('id', new_div_id);
                    $('#containercar').append(copy);
                    $('#containercar').append('<br/><input type="button" name="btndelete_car[]" id="btndelete_car' + iCnt + '" value="DELETE" style="margin: 20px;"><br/>');

                    $('#' + new_div_id).find('input,select').each(function () {
                        $(this).attr('id', $(this).attr('id') + iCnt);
                    });
                    //$('#containercar').find('#btndelete_car').attr({id: 'btndelete_car' + iCnt, name: "btndelete_car[]"});
                    var delete_car = "btndelete_car" + iCnt;


               // Remove element
   $(document.body).on('click', "#" +delete_car, function () {
                       // alert(btndelete_hotel);alert(new_div_id);
                        document.getElementById(new_div_id).remove();
                        $(this).remove();
                    });
                    $("#pickup_date" + iCnt).datepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;

                    $("#car_company" + iCnt).attr('required', true);
                    //iCnt++;

                });


                $("#todate").datepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                inline:true;

            });


            $(document).ready(function () {
            $("#checkindate").datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;
                    $("#checkoutdate").datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;


                var iCnt = 0;
                $('#btnaddddhotel').on('click', function () {iCnt++; 
                    var copy = $('#tbBooks').clone(true);
                    var new_div_id = 'tbBooks' + iCnt;
                    var hotel = "pref_hotel" + iCnt;//alert("#"+hotel);
                    var divhotel = "divhotel" + iCnt;
                   
                    copy.attr('id', new_div_id);
                    $("#container2").append(copy);
                    $('#container2').append('<br/><input type="button" name="btndelete_hotel[]" id="btndelete_hotel' + iCnt + '" value="DELETE" style="margin: 20px;"><br/>');

                    $('#' + new_div_id).find('input,select').each(function () {
                        $(this).attr('id', $(this).attr('id') + iCnt);
                    });
                    $('#container2').find('#divhotel').attr({id: 'divhotel' + iCnt, name: "divhotel"});
                    $('#container2').find('#btndelete_hotel').attr({id: 'btndelete_hotel' + iCnt, name: "btndelete_hotel[]"});
                    
                     var btndelete_hotel= "btndelete_hotel" + iCnt;
        

               // Remove element
   $(document.body).on('click', "#" +btndelete_hotel, function () {
                       // alert(btndelete_hotel);alert(new_div_id);
                        document.getElementById(new_div_id).remove();
                        $(this).remove();
                    });
                    $(document.body).on('change', "#" + hotel, function () {
                        var title = $("#" + hotel + " :selected").text();//
                        if (title == 'Others') { //alert(title);
                            $("#" + divhotel).show();
                        } else {
                            $("#" + divhotel).hide();
                        }
                    });
                    $("#checkindate" + iCnt).datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;
                    $("#checkoutdate" + iCnt).datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;
                    $("#pref_hotel" + iCnt).attr('required', true);
                    $(document.body).on('click', "#" + delete_hotel, function () {

                        $(this).closest('#' + new_div_id).remove();
                    });
                    iCnt++;

                });

            });
            $(document).ready(function () { //alert("hiii");
            var iCnt;
iCnt = 1;
	if(iCnt === 1 || iCnt > 1){
                $('#btnadd_air').on('click', function () { iCnt++;
                    var copy = $('#multidiv').clone(true);
                    var new_div_id = 'multidiv' + iCnt;
                    copy.attr('id', new_div_id);
                    //$('#containerdd').find('#pref_hotelmulti').attr({id: 'pref_hotelmulti'+iCnt, name: "pref_hotel[]"});
                    //$('#containerdd').find('#book_airlinemulti').attr({id: 'book_airlinemulti'+iCnt, name: "book_airline[]"}); 

                    $('#containerdd').append(copy);                    
                    $('#containerdd').append('<br/><input type="button" name="btndelete_air[]" id="btndelete_air' + iCnt + '" value="DELETE" style="margin: 20px;"><br/>');

                    $('#containerdd').find('#divhotelmulti').attr({id: 'divhotelmulti' + iCnt, name: "divhotelmulti"});
                    //	$('#containerdd').find('#btndelete_air').attr({id: 'btndelete_air'+iCnt, name: "btndelete_air[]"});
                    $('#containerdd').find('#divairmulti').attr({id: 'divairmulti' + iCnt, name: "divairmulti"});
                    $('#containerdd').find('#divonwardcitymulti').attr({id: 'divonwardcitymulti' + iCnt, name: "divonwardcitymulti"});
                    $('#containerdd').find('#divtraveltomulti').attr({id: 'divtraveltomulti' + iCnt, name: "divtraveltomulti"});
                    $('#' + new_div_id).find('input,select').each(function () {
                        $(this).attr('id', $(this).attr('id') + iCnt);
                    });

                    var hotel = "pref_hotelmulti" + iCnt;// alert("#"+hotel);
                    var air = "book_airlinemulti" + iCnt;
                    var divhotel = "divhotelmulti" + iCnt;
                    var divair = "divairmulti" + iCnt;
                    var divonwardcity = "divonwardcitymulti" + iCnt;
                    var divtravelto = "divtraveltomulti" + iCnt;
                    var onwardcity = "onward_citymulti" + iCnt;// alert("#"+hotel);
                    var travel_to = "travel_to" + iCnt;
                    var delete_air = "btndelete_air" + iCnt;
                 
        

               // Remove element
   $(document.body).on('click', "#" +delete_air, function () {
                       // alert(btndelete_hotel);alert(new_div_id);
                        document.getElementById(new_div_id).remove();
                        $(this).remove();
                    });
                    
                    
                    $(document.body).on('change', "#" + onwardcity, function () {

                        var title = $("#" + onwardcity + " :selected").text();//alert(divhotel);
                        if (title == 'Others') {
                            $("#" + divonwardcity).show();
                        } else {
                            $("#" + divonwardcity).hide();
                        }
                    });

                    $(document.body).on('change', "#" + travel_to, function () {
                        var val = $(this).val();
                        $.ajax({
                            type: "POST",
                            url: "gethotels.php",
                            data: 'id=' + val,
                            success: function (data) {
                                $("#" + hotel).html(data);
                            }
                        });
                        var title = $("#" + travel_to + " :selected").text();//alert(divhotel);
                        if (title == 'Others') {
                            $("#" + divtravelto).show();
                        } else {
                            $("#" + divtravelto).hide();
                        }
                    });

                    $(document.body).on('change', "#" + hotel, function () {


                        var title = $("#" + hotel + " :selected").text();//alert(divhotel);
                        if (title == 'Others') {
                            $("#" + divhotel).show();
                        } else {
                            $("#" + divhotel).hide();
                        }
                    });

                    $(document.body).on('change', "#" + air, function () {
                        // alert("#"+air);
                        var title = $("#" + air + " :selected").text();//alert(divair);
                        if (title == 'Others') {
                            $("#" + divair).show();
                        } else {
                            $("#" + divair).hide();
                        }
                    });
                    $("#datedeparturemulti" + iCnt).datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                    inline:true;
                    $("#datelchkinmulti" + iCnt).datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"}); inline:true;
                    $("#datelchkoutmulti" + iCnt).datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"}); inline:true;
                    $("#onward_citymulti" + iCnt).attr('required', true);
                    $("#traveltoround" + iCnt).attr('required', false);
                    $("#traveltomulti" + iCnt).attr('required', true);

			iCnt++;

		});
	}
 });






        </script>

        <script>
            //multiple trip
            $(document).ready(function () {
                ////////////
                $('#travel_to').change(function () {
                    //var st=$('#category option:selected').text();
                    var id = $('#travel_to').val();
                    //$('#pref_hotel').empty(); //remove all existing options
                    ///////
                    $.get('ajaxDatahotellist.php', {'id': id}, function (return_data) {
                        $.each(return_data.data, function (key, value) {
                            $("#pref_hotel").append("<option value='" + value.id + "'>" + value.hotel_name + "</option>");
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




        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Travel request booking form</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#tabs").tabs();
            });
        </script>
    </head>
    <body>
        <div id="wrapper">

            <header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
            <div role="main">
                <form id="travel-booking" method="post" action=""  onsubmit="return confirm('Are you sure you want to submit this Airline booking form?');">
                    <div class="row cent clearfix">
                        <!---------------------------------------------------------------Main Travel details Start---------------------------------------------------------------------------------------------->
                        <div class="in-bloc cent"><h1 class="in-bloc">Travel Booking</h1>
                            <?php if (!empty($message)) {
                                echo "<p style='color:green;'>" . $message . "</p>";
                            } ?></div>
                    </div><input type="hidden" id="booking" name="booking" value="air"/>
                    <!-- Travel details-->


                    <h3 align='right'><p style='color:green;'>
<?php $type = $u->getUserType();
if ($type == 'Employee') { ?><a href='emp-board.php'>Dashboard</a><?php } ?>
<?php $type = $u->getUserType();
if ($type == 'Manager') { ?><a href='manager-board.php'>Dashboard</a><?php } ?>
<?php $type = $u->getUserType();
if ($type == 'Travel Desk') { ?><a href='travel-desk-board.php'>Dashboard</a><?php } ?>
<?php $type = $u->getUserType();
if ($type == 'Admin') { ?><a href='admin-board.php'>Dashboard</a><?php } ?>
                            &nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p>
                    </h3>
                    <div id="tabs">
                        <ul>
                          <li style="background-color: #ffce58;border:#333;color:#000;"><!--span class="f-leg"><img src="img/destination2.png"--><a href="#tabs-1" style="color:#000;">Air travel details</a><!--/span--></li>
                          <li style="background-color: #ffce58;border:#333;color:#000;"><!--span class="f-leg"><img src="img/destination2.png"--><a href="#tabs-2" style="color:#000;">Hotel details</a><!--/span--></li>
                          <li style="background-color: #ffce58;border:#333;color:#000;"><!--span class="f-leg"><img src="img/destination2.png"--><a href="#tabs-3" style="color:#000;">Car details</a><!--/span--></li>
                          <li style="background-color: #ffce58;border:#333;color:#000;"><!--span class="f-leg"><img src="img/destination2.png"--><a href="#tabs-4" style="color:#000;">Train details</a><!--/span--></li>

                        </ul>
                        <div id="tabs-1">
                            

                            <p><div class="row" >
                                <div class="multidiv" id="multidiv"> 
                                    <!-- Destination and Departure details-->

                                    <span class="f-leg"><img src="img/destination2.png" />Air travel details</span>
                                                <fieldset name "dest-dep">
                                                        <!-- Start Destination and Departure details first Column-->
                                                        <div class="col-4-grid">
                                                            <p><label for "from1" name="onwardcity"  ><span style="color:red;">*</span>From city</label>
                                                            <select name="onwardcitymulti[]" id="onward_citymulti" <?php echo $val_multiway; ?>><option value=""><!--list to be populated dynamically-->From city</option>
                                                            <?php foreach ($cities as $citie) { ?>
                                                            <option value="<?php echo $citie['id']; ?>"<?php if ($citie['id'] == $_POST['onwardcity']) {
                                                            echo "selected='selected'";
                                                            } ?>><?php echo $citie['city_name'] . "," . $citie['city_state']; ?></option>
                                                            <?php }
                                                            ?>
                                                            <option value="0">Others</option>
                                                            </select><div id="divonwardcitymulti" style="display: none">Other city: <input type="text" name="otheronwardcitymulti[]"></div></p>
                                                            
                                                            
                                                            <p><label for "TO1" name="travel_to"><span style="color:red;">*</span>To city</label><select name="travel_tomulti[]" id="travel_to"   ><option value="">To city</option><?php foreach ($cities as $citie) { ?>
                                                            <option value="<?php echo $citie['id']; ?>"<?php if ($citie['id'] == $_POST['travel_to']) {
                                                            echo "selected='selected'";
                                                            } ?>><?php echo $citie['city_name'] . "," . $citie['city_state']; ?></option>
                                                            <?php }
                                                            ?> 
                                                            <option value="0">Others</option>
                                                            </select><div id="divtraveltomulti" style="display: none">Other city: <input type="text" name="othertravel_tomulti[]"></div></p>
                                                        </div>
                                                        <div class="col-4-grid">
                                                            <p><label for "dep-date1">Departure date </label>
                                                            <input type="text" id="datedeparturemulti"  class="datepicker" name="datemulti[]" placeholder="Departure date"value="<?php echo $_POST['date']; ?>" /></p>
                                                            
                                                            <p><label for "air-co">Select preferred airlines</label>
                                                            <select name="book_airlinemulti[]" id="book_airlinemulti" class="book_airline">
                                                            <option value="">Select preferred airlines</option>
                                                            <?php foreach ($airlines as $airline) { ?>
                                                            <option value="<?php echo $airline['id']; ?>" <?php if ($airline['id'] == $_POST['book_airline']) {
                                                            echo "selected='selected'";
                                                            } ?>><?php echo $airline['name']; ?></option>
                                                            
                                                            <?php }
                                                            ?><option value="0">Others</option></select>  
                                                            <div id="divairmulti" style="display:none;">Other airline: <input type="text" name="otherairmulti[]"></div>
                                                            </p>
                                                        
                                                            <p><label for "air-pickup">Preferred flight time</label>
                                                            <input type="text" id="preferred_airline_time" name="preferred_airline_timemulti[]"  /></p>
                                                            <p><label for "air-co">Flight meal preference</label><input type="text" name="meal_preferenceoneway[]" value=""></p>
                                                        
                                                        
                                                        <input type="hidden" name="divcount" value="<?php echo $divcount; ?>">
                                                    </div>
                                                </fieldset>

                                        </div>
                                        <!-- End Destination and Departure details first Column-->
                                        <div id="containerdd"></div>
                                        <div class="btn-set"> <input type="button" class=""  id="btnadd_air"  value="ADD" /></div></br>
                                        <div class="btn-set"> <input type="button" class=""  id="air_submit"  value="SUBMIT" /></div>

                                </div> </p>
                            </div>


                            <div id="tabs-2">
                                <p> <div class="row" >
                                    <div class="tbBooks" id="tbBooks"> 
                                        <!-- Destination and Departure details-->
                                        <span class="f-leg"><img src="img/hotel.png" width="32px" height="32px"/>Hotel details</span>
                                        <fieldset name "dest-dep">
                                                  <div class="col-6-grid">
                                                <p><label for "TO1">City</label><select name="travel_to[]" id="travel_to" ><option value="">City</option><?php foreach ($cities as $citie) { ?>
                                                            <option value="<?php echo $citie['id']; ?>"><?php echo $citie['city_name'] . "," . $citie['city_state']; ?></option>
<?php } ?></select></p>

                                                <p><label for "hotel"><span style="color:red;">*</span>Preferred hotel</label><select id="pref_hotel" class="pref_hotel" name="pref_hotel[]" autofocus > 
                                                        <option value="">Preferred hotel</option>
<?php foreach ($hotels as $hotel) { ?>
                                                            <option value="<?php echo $hotel['id']; ?>"><?php echo $hotel['hotel_name']; ?></option>
    <?php }
?>
                                                        <option value="0">Others</option>
                                                    </select><div id="divhotel" style="display: none;">Other hotel: <input type="text" name="otherhotel[]"></div></p>

                                                <p><label for "air-co"> Room type</label><select id="room_type" class="room_type" name="room_type[]"> 
                                                        <option value="">Room type</option>

                                                        <option value="Smoking Room">Smoking room</option>
                                                        <option value="Non Smoking Room">Non smoking room</option>
                                                    </select></p>
                                            </div>


                                            <div class="col-6-grid">
                                                <p><label for "dep-date1">Checkin date</label>
                                                    <input type="text" id="checkindate" name="checkindate[]" placeholder="Check in date"  /></p>
                                                <p><label for "dep-date1">Checkin time</label>
                                                    <input type="text" id="checkintime" name="checkintime[]" placeholder="Checkin Time"  /></p>
                                                <p><label for "dep-date1">No of guests</label>
                                                    <input type="text" id="noofguests" name="noofguests[]" placeholder="No Of Guests"  /></p>

                                               
                                            </div>

                                            <div class="col-6-grid">

                                                <p><label for "dep-date1">Checkout date</label>
                                                    <input type="text" id="checkoutdate" name="checkoutdate[]" placeholder="Checkout date"  /></p>

                                                <p><label for "dep-date1">Checkout time</label>
                                                    <input type="text" id="checkouttime" name="checkouttime[]" placeholder="Checkout Time"  /></p>

                                                <p><label for "dep-date1">No of rooms</label>
                                                    <input type="text" id="noofrooms" name="noofrooms[]" placeholder="No Of Rooms"  /></p>
                                            </div>



</fieldset>
                                        <!-- Destination and Departure details end-->

                                    </div>  </div> 
                                <div id="container2" ></div> 
                                <div class="btn-set"> <input type="button" class="" id="btnaddddhotel" value="ADD" /></div>
                                </br>
                                        <div class="btn-set"> <input type="button" class=""  id="hotel_submit"  value="SUBMIT" /></div>
                            </p>
                            </div>
                            <div id="tabs-3">
                                <p> <div class="row" >
                                    <div class="tbBookscar" id="tbBookscar"> 
                                        <!-- Destination and Departure details-->
                                        <span class="f-leg"><img src="img/car.png" width="32px" height="32px"/>Car details</span>
                                        <fieldset name "dest-dep">
                                                  <div class="col-6-grid">
                                                <h3>Individual day booking</h3>
                                                <p><label for "air-co">Pickup date</label><input type="text" class="cal_pickup_date" id="pickup_date" name="pickup_date[]" value="" ></p>                                                    
                                                <p><label for "air-co"> Need car for the entire day</label><input type="checkbox" name="need_car[]" value="yes"></p>
                                                <p><label for "car-co"><span style="color:red;">*</span>Car vendor</label><select name="car_company[]" id="car_company" class="car_company" autofocus >
                                                        <option value="">Select preferred car vendor co.</option>
<?php foreach ($cars as $car) { ?>
                                                            <option value="<?php echo $car['id']; ?>"><?php echo $car['name']; ?></option>
                                                    <?php }
                                                ?>

                                                    </select> </p>
                                                <p><label for "air-pickup">Car type</label><select name="car_size[]" id="car_size" class="car_size">
                                                        <option value="">Select car type</option>
                                                        <option value="Mid Size" <?php if ($_POST['car_size'] == 'Mid Size') {
                                                    echo "selected='selected'";
                                                } ?>>Mid size</option>
                                                        <option value="SUV" <?php if ($_POST['car_size'] == 'SUV') {
                                                    echo "selected='selected'";
                                                } ?>>SUV</option>
                                                    </select></p>
                                            </div>

                                            <div class="col-6-grid"> <?php $user = $u->getuserdetails($_SESSION['user_id']);
                                                $city = $u->getcity($user['city']);
                                                ?>
                                               
                                                <p><label for "air-co">Pickup city</label><input type="text" name="pickup_city[]" value="<?php echo $city['city_name']; ?>"></p>
                                                <!--p><label for "air-co">Drop Location</label><input type="text" name="drop_location[]" value=""></p-->
                                                <p><label for "dep-date1">Pickup time </label><input type="text" id="car_pickuptime" name="car_pickuptime[]" placeholder="Please mention pick up time for the drop" autofocus /></p>
                                                <p><label for "air-co">Pickup address</label><input type="text" name="car_pickup_location[]" value="" placeholder="Please mention pick up address" ></p>
                                                <p><label for "air-co">Destination address</label><input type="text" name="destination[]" value="" placeholder="Please mention destination / Drop address" ></p>

                                            </div>
                                    </div>  

                                </div> 


                                <!--/div--> 
                                <div id="containercar"></div> 
                                <div class="btn-set" id="add_button"> <input type="button" class="" value="ADD" /></div>
                             </br>
                                        <div class="btn-set"> <input type="button" class=""  id="car_submit"  value="SUBMIT" /></div></p>
                            </div>
                   
         <div id="tabs-4">
                                <p>

                                <div class="row" >
                                    <div class="tbBookstrain" id="tbBookstrain"> 
                                        <!-- Destination and Departure details-->
                                        <span class="f-leg"><img src="img/train.png" width="32px" height="32px"/>Train details</span>
                                        <fieldset name "dest-dep">
                                                  <div class="col-6-grid"> 
                                                <p><label for "from1" name="onwardcity" ><span style="color:red;">*</span>From city</label>
                                                    <select name="onwardcity[]" id="onward_citytrain"><option value=""><!--list to be populated dynamically-->From city</option>

<?php foreach ($cities as $citie) { ?>
                                                            <option value="<?php echo $citie['id']; ?>" <?php if ($citie['id'] == $onwardcity[0]) {
        echo "selected='selected'";
    } ?>><?php echo $citie['city_name'] . "," . $citie['city_state']; ?></option>
    <?php }
?><option value="0">Others</option> 
                                                    </select> <div id="divonwardcity" style="display:none;">Other city:<input type="text" name="otheronwardcity[]"></div></p>
                                                <p><label for "TO1" name="travel_to" ><span style="color:red;">*</span>To City</label><select name="travel_to[]" id="traveltotrain"><option value="">To city</option><?php foreach ($cities as $citie) { ?>
                                                            <option value="<?php echo $citie['id']; ?>"<?php if ($citie['id'] == $travel_to[0]) {
        echo "selected='selected'";
    } ?>><?php echo $citie['city_name'] . "," . $citie['city_state']; ?></option>
    <?php }
?><option value="0">Others</option>  </select><div id="divtravelto" style="display:none;">Other city:<input type="text" name="othertravel_to[]"></div></p></div>
                                            <div class="col-6-grid">                                               
                                            <p><label for "air-co">Date</label><input type="text" class="cal_pickup_date" id="datetrain" name="datetrain[]" value="" ></p>                                                    


                                                
                                                <p><label for "car-co"><span style="color:red;">*</span>Preferred train</label><input type="text" name="train[]" id="train" autofocus >
                                                <p><label for "car-co"><span style="color:red;">*</span>Age</label><input type="text" name="age[]" id="age" value="<?php echo $employee_age['age']; ?>" autofocus ></p>
                                            </div>

                                            <div class="col-6-grid"> 
                                                <p><label for "air-co">Class</label>
                                                    <select name="class[]" id="class" class="class">
                                                        <option value="">Select class</option>
                                                        <option value="SL" <?php if ($_POST['class'] == 'SL') {
    echo "selected='selected'";
} ?>>SL - Sleeper class</option>
                                                        <option value="1A" <?php if ($_POST['class'] == '1A') {
    echo "selected='selected'";
} ?>>1A - The First class AC</option>
                                                        <option value="2A" <?php if ($_POST['class'] == '2A') {
    echo "selected='selected'";
} ?>>2A - AC-Two tier</option>
                                                        <option value="3A" <?php if ($_POST['class'] == '3A') {
    echo "selected='selected'";
} ?>>3A - AC three tier</option>
                                                        <option value="2S" <?php if ($_POST['class'] == '2S') {
    echo "selected='selected'";
} ?>>2S - Seater class</option>
                                                        <option value="CC" <?php if ($_POST['class'] == 'CC') {
    echo "selected='selected'";
} ?>>CC - AC chair cars</option>
                                                    </select>

                                                </p>
                                                <p><label for "air-co">Boarding from</label><input type="text" name="boarding_form[]" value=""></p>
                                            </div>
                                        </fieldset>
                                        </div></div> 

                                <!--/div--> 
                                <div id="containertrain"></div> 
                                <div class="btn-set" id="btn-train"> <input type="button" class=""  value="ADD" /></div> 
                                 </br>
                                        <div class="btn-set"> <input type="button" class=""  id="train_submit"  value="SUBMIT" /></div>
                                </p>
                            </div>
                        </div>



                        <!-- scripts concatenated and minified via build script -->
                        <script src="js/plugins.js"></script>
                        <script src="js/script.js"></script>
                        <!-- end scripts -->

                        <script>
                    $('#oneway').click();
                        </script>
                        <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
                        <script src="/js/DateTimePicker.js"></script>
                        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style type="text/css">
     .pref_hotel select {
        width: 150px;
        min-width: 150px;
        margin: 10px;
    }
     /* .pref_hotel select:focus  {
        min-width: 150px;
        width: auto;
    }  */  
</style>
                        <script>
                    $(function () {
                        $("#datedeparturemulti").datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                        inline:true;
                  
                         $("#datetrain").datepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"}); inline: true;
});
                        </script>

                        </body>
                        </html>
