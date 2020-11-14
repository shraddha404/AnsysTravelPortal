<?php
session_start();
$limit = 15;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$status = $_GET['status'];
if ($_SESSION['user_type'] == 'Travel Desk') {
    include_once ('../lib/TravelDesk.class.php');
    $u = new TravelDesk($_SESSION['user_id']);
} elseif ($_SESSION['user_type'] == 'Manager') {
    include_once ('../lib/Manager.class.php');
    $u = new Manager($_SESSION['user_id']);
} elseif ($_SESSION['user_type'] == 'Finance') {
    include_once ('../lib/Finance.class.php');
    $u = new Finance($_SESSION['user_id']);
} elseif ($_SESSION['user_type'] == 'Admin') {
    include_once ('../lib/Admin.class.php');
    $u = new Admin($_SESSION['user_id']);
} else {
    header("Location:/login.php");
}
if ($_POST) {
    $travel_requests = $u->getTraveldatewisereportpagination($_POST);
} else {
//print_r($_POST);
    $travel_requests = $u->getTraveldatewisereport();
}
?>
<!doctype html>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <script src="js/DateTimePicker.js"></script>

        <script>
            $(document).ready(function () {
                $("#stdate").datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                inline:true;
                $("#endate").datetimepicker({timeFormat: "HH:mm:ss", dateFormat: "yy-mm-dd"});
                inline:true;
                


            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
            chromium.org/developers/how-tos/chrome-frame-getting-started -->
            <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
            <header id="header"><img src="img/logo-sml.jpg" alt="Ansys Software" /> </header>
            <div role="main"><h3 align='right'><p style='color:green;'>
                        <?php $type = $u->getUserType();
                        if ($type == 'Employee') { ?><a href='emp-board.php'>Dashboard</a><?php } ?>
                        <?php $type = $u->getUserType();
                        if ($type == 'Manager') { ?><a href='manager-board.php'>Dashboard</a><?php } ?>
                        <?php $type = $u->getUserType();
                        if ($type == 'Travel Desk') { ?><a href='travel-desk-board.php'>Dashboard</a><?php } ?>
<?php $type = $u->getUserType();
if ($type == 'Admin') { ?><a href='admin-board.php'>Dashboard</a><?php } ?>
<?php $type=$u->getUserType();if($type=='Finance'){?><a href='Finance-board.php'>Dashboard</a><?php }?>
                        &nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>
                <div class="in-bloc cent row"><img src="img/globe.jpg" alt="Travel-desk-view" /><h1 class="in-bloc">Date wise travel plan list report</h1></div>

                <table class="resp"><!--rows to be added dynamically as required--> <thead>
                    <form name="requestreceived" method="post">
                        <tr><th colspan="4">Start Date:&nbsp;&nbsp;<input type="text" id="stdate" name="stdate" value="<?php echo $_POST['stdate']; ?>" ></th>
                            <th colspan="3">End Date:&nbsp;&nbsp;<input type="text" name="endate" id="endate" value="<?php echo $_POST['endate']; ?>" ></th>
                            <th colspan="2">Booking type:&nbsp;&nbsp;
                                <select name="booking_type"><option value=" ">Select Booking Type</option> 
                                    <option value="car" <?php if ($_POST['booking_type'] == 'car') {
    echo "selected=selected";
} ?>>Car</option>      
                                    <option value="hotel"<?php if ($_POST['booking_type'] == 'hotel') {
    echo "selected=selected";
} ?>>Hotel</option>      
                                    <option value="airline"<?php if ($_POST['booking_type'] == 'airline') {
    echo "selected=selected";
} ?>>Airline</option>
                                    <option value="train"<?php if ($_POST['booking_type'] == 'train') {
    echo "selected=selected";
} ?>>Train</option>
                                </select> </th><th colspan="2"><input type="submit" name="report" value="Get Report" ></th></tr>
                        <tr><td colspan="11"><span style="float:right; margin-bottom:10px; font-weight:bold; font-color:#43729f;"><a href="export-date-wise-travel-plan-report.php?stdate=<?php echo $_POST['stdate']; ?>&endate=<?php echo $_POST['endate']; ?>&booking_type=<?php echo $_POST['booking_type']; ?>">Export All</a></span></td></tr>

                </table><br/><br/><br/>
                </form>

                <table class="resp">
                    <tr><thead>
<?php /* * ******Comman  booking fields**************** */ ?>
                    <th>Trip Id</th>
                    <th>Date</th>
                    <th>Purpose Of Visit</th>
                    <th>Employee Name</th>
                    <th>Organisation Unit</th>
                    <th>Date of Travel</th>
                    <?php /*                     * ******Airline  booking fields**************** */ ?>
                    <?php if ($_POST['booking_type'] == 'airline' || empty($_POST['booking_type'])) { ?>
                        <th>From Location</th>
                        <th>To Location</th>
                        <th>Preferred Airline</th>
                        <th>Ticket Number</th>
                        <!--th>Airport Drop</th>
                        <th>Pickup Address</th>
                        <th>Airport Pickup</th>
                        <th>Destination</th-->
                    <?php } ?>

<?php /* * ******Car  booking fields**************** */ ?>
<?php if ($_POST['booking_type'] == 'car') { ?> 
                        <th>Prefered Car Vendor</th>
                        <th> Car Size</th>
                        <th>Need car for day</th>
                        <th>Car Pickup Location</th>
                        <th>Destination</th><?php } ?>


                    <?php /*                     * ******Hotel  booking fields**************** */ ?>
                    <?php if ($_POST['booking_type'] == 'hotel') { ?>
                        <th>Preferred Hotel</th>
                        <th>Check in date-time</th>
                        <th>Check Out date-time</th>
                        <th>Confirmation Number</th>
                        <th>Late Checkin</th>
                        <th>Late Checkout</th> 
                        <th>No.Of Guests</th> 
                        <th>No.Of Rooms</th> 
                        <th>Room Type</th> 
                    <?php } ?>
                    <?php /*                     * ******Train  booking fields**************** */ ?>
<?php if ($_POST['booking_type'] == 'train') { ?>
                        <th align='left'>Name of Passenger</th>
                        <th align='left'>From Location</th>
                        <th align='left'>Destination</th>
                        <th align='left'>Age</th>
                        <th align='left'>Train</th>
                        <th align='left'>Date</th>
                        <th align='left'>Train Id</th>
                        <th align='left'>Class</th>
                        <th align='left'>Boarding From</th>
                            <?php } ?>
                    <th align='left'>Cost</th>
                    </tr>
                    </thead>
                    <tbody>
                            <?php if($travel_requests){foreach ($travel_requests as $request) { ?>
                            <tr> 
    <?php /*     * ******Common  booking fields**************** */ ?>
                                <td align="center"><?php echo $request['id']; ?></td>
                                <td align="center"><?php echo $request['date']; ?></td>
                                <td align="center"><?php echo $request['purpose_of_visit']; ?></td>
                                <td align="center"><?php echo $request['firstname'] . "  " . $request['middlename'] . "  " . $request['lastname']; ?></td>
    <?php $orgunit = $u->getous($request['ou']); ?>
                                <td align="center"><?php echo $orgunit['ou_short_name']; ?></td>
                                <td align="center"><?php echo $request['date'] . " To " . $request['return_date']; ?></td>
                                <?php /*                                 * ******Airline  booking fields**************** */ ?>
                                <?php if ($_POST['booking_type'] == 'airline' || empty($_POST['booking_type'])) { ?>         
                                    <td align="center"><?php $city = $u->getcity($request['travel_from']);
                            echo $city['city_name']; ?></td> 
                                    <td align="center"><?php $cityto = $u->getcity($request['travel_to']);
                            echo $cityto['city_name']; ?></td> 
                                    <td align="center"><?php $airline = $u->getairlines($request['book_airline']);
                            echo $airline['name']; ?></td>
                                    <td align="center"><?php echo $request['ticket_number']; ?></td>
                                    <!--td align="center"><?php echo $request['airport_drop']; ?></td>
                                    <td align="center"><?php echo $request['airport_pickup_loca']; ?></td>
                                    <td align="center"><?php echo $request['airport_pickup']; ?></td>
                                    <td align="center"><?php echo $request['airport_drop_loca']; ?></td-->
    <?php } ?>
    <?php /*     * ******Car  booking fields**************** */ ?>
    <?php if ($_POST['booking_type'] == 'car') { ?>
                                    <td align="center"><?php $car = $u->getcars($request['car_company']);
        echo $car['name']; ?></td>
                                    <td align="center"><?php echo $request['car_size']; ?></td>
                                    <td align="center"><?php echo $request['need_car']; ?></td>     
                                    <td align="center"><?php echo $request['car_pickup_location']; ?></td>     
                                    <td align="center"><?php echo $request['destination']; ?></td>  
                                <?php } ?>   
                                <?php /*                                 * ******Hotel booking fields**************** */ ?>
    <?php if ($_POST['booking_type'] == 'hotel') { ?>
                                    <td align="center"><?php $hotel = $u->gethotel($request['hotel_id']);
        echo $hotel['hotel_name']; ?></td>
                                    <td align="center"><?php echo $request['check_in']; ?></td>
                                    <td align="center"><?php echo $request['check_out']; ?></td>
                                    <td align="center"><?php echo $request['hotel_confirmation_num']; ?></td>
                                    <td align="center"><?php echo $request['late_checkin']; ?></td>
                                    <td align="center"><?php echo $request['late_checkout']; ?></td>
                                    <td align="center"><?php echo $request['noofguests']; ?></td>
                                    <td align="center"><?php echo $request['noofrooms']; ?></td>
                                    <td align="center"><?php echo $request['room_type']; ?></td>
                            <?php } ?>
                            <?php /*                             * ******Train booking fields**************** */ ?>
    <?php if ($_POST['booking_type'] == 'train') { ?>
        <?php $cityto = $u->getcity($request['train_to']);
        $city = $u->getcity($request['train_from']);
        $passenger = $request['firstname'] . "  " . $request['middlename'] . "  " . $request['lastname'];
        ?>
                                    <td align="center"><?php echo $passenger; ?></td>
                                    <td align="center"><?php echo $cityto['city_name']; ?></td>
                                    <td align="center"><?php echo $city['city_name']; ?></td>
                                    <td align="center"><?php echo $request['age']; ?></td>
                                    <td align="center"><?php echo $request['train']; ?></td>
                                    <td align="center"><?php echo $request['date']; ?></td>
                                    <td align="center"><?php echo $request['train_id']; ?></td>
                                    <td align="center"><?php echo $request['class']; ?></td>
                                    <td align="center"><?php echo $request['boarding_form']; ?></td>
                    <?php } ?>
                                <td align="center"><?php echo $request['cost']; ?></td>
                            </tr>
                            <?php }} ## foreach ends ?>
                    </tbody>
                </table>

<!--table><tr><td align="center">


<?php
$travelrequests = $u->getTraveldatewisereportpagination($_POST);
$total_records = count($travelrequests);

$total_pages = ceil($total_records / $limit);
$pagLink = "<div class='pagination'><strong>Page No.";
for ($i = 1; $i <= $total_pages; $i++) {

    $pagLink .= "<a href='date-wise-travel-plan-report.php?page=" . $i . "&id=" . $_GET['id'] . "'>" . $i . "</a>" . "     ";
}

echo $pagLink . "</div></strong>";
?></td></tr></table-->


            </div>
            <footer>

            </footer>
        </div><!--wrapper ends--> 

        <!-- JavaScript at the bottom for fast page loading -->

        <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->



        <!-- scripts concatenated and minified via build script -->
        <script src="js/plugins.js"></script>
        <script src="js/script.js"></script>
  
        <!-- end scripts -->

        <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
        mathiasbynens.be/notes/async-analytics-snippet>
        <script>
        var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
        </script -->

    </body>
</html>
