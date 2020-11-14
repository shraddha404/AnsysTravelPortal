<?php
session_start();
include_once ('../lib/User.class.php');
$u = new User($_SESSION['user_id']);
if(empty($_SESSION['user_id']))
{
header("location:login.php");
}
        $status_msg = 'Please check mandatory fields are filled.';
//print_r($u);
$cities = $u->cities();
$ou = $u->getou();
$bu = $u->getbu();
//print_r($bu);
$airlines = $u->airlines();

$office_locations = $u->office_locations();
if($_POST){

#print_r($_FILES);

if($_POST['delete_visacopy'] == 'Delete'){
    $deleted = $u->deleteVISA($_POST['visa_id']);
}

if($_POST['delete_ffp'] == 'Delete'){
echo $_POST['ffp_id'];
        $deleted = $u->deleteFFP($_POST['ffp_id']);
}
$details = $u->updateMyProfile($_POST);
$msg = '';
if($details){
$msg = "Your Profile Updated Successfully!";
}

}
$user_profile = $u->getUserDetails($u->user_id);
$visaDetails = $u->getVisaDetails($u->user_id);
$getffDetails = $u->getff($u->user_id);

//print_r($user_profile);
//echo $user_profile['user_type'];
//exit;
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="js/script.js"></script>

<script>
function delete_row(id)
{  //alert(id);
 $.ajax
 ({
  type:'post',
  url:'deletevisa.php',
  data:{
   delete_row:'delete_row',
   row_id:id,
  },
  success:function(response) {

    var row=document.getElementById("row"+id);
    row.parentNode.removeChild(row);

  }
 });
}

function delete_rowff(id)
{  
 $.ajax
 ({
  type:'post',
  url:'deletevisa.php',
  data:{
   delete_row:'delete_rowff',
   row_idff:id,
  },
  success:function(response) {

    var row=document.getElementById("rowff"+id);
    row.parentNode.removeChild(row);

  }
 });
}












  $(document).ready(function () {
        var iCnt = 1;

        $('#visaadd').on('click', function () {
var new_ele = $('#tbBooks').clone();
$('input', new_ele).val("");
            $('#tbBooks')
                .clone().val('')      // CLEAR VALUE.
//.find('input').val('')
//.find("input:date").val("").end()
 //$('#tbBooks').find('input').val('')

                .attr('style', 'margin:3px 0;', 'id', 'tbBooks' + iCnt)     // GIVE IT AN ID.
         .appendTo("#container2");

            // ADD A SUBMIT BUTTON IF ATLEAST "1" ELEMENT IS CLONED.
            if (iCnt == 1) {
                var divSubmit = $(document.createElement('div'));

            }
            $('#container2').after(divSubmit);
            $("#container2").attr('style', 'display:block;margin:3px;');

            iCnt = iCnt + 1;        //displayRemove();
        });
    });




function displayRemove() {
    if($('#tbBooks').length === 1) {
$('#tbBooks')
               // .clone().val('')      // CLEAR VALUE.
.find('input').val('')
    } 
}


  $(document).ready(function () {
        var iCnt = 1;

        $('#Frequent-Flyer').on('click', function () {


      $('#ffp')
                .clone().val('')      // CLEAR VALUE.
// $('#ffp').find('input').val('')
                .attr('style', 'margin:3px 0;', 'id', 'tbBooks' + iCnt)     // GIVE IT AN ID.
                .appendTo("#containerffp");

            // ADD A SUBMIT BUTTON IF ATLEAST "1" ELEMENT IS CLONED.
            if (iCnt == 1) {
                var divSubmit = $(document.createElement('div'));

            }
            $('#containerffp').after(divSubmit);
            $("#containerffp").attr('style', 'display:block;margin:3px;');

            iCnt = iCnt + 1;
        });
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
<!-- form starts here -->
  <form id="profile" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
	<input type="hidden" name="user_type" value="<?php echo $user_profile['user_type'];?>">
  	<div class="row cent">
	    <div class="in-bloc cent">
		<!--img src="img/person.jpg" alt="profile creation" /-->
		<h1 class="in-bloc">Create your profile</h1>
		<?php echo "<p style='color:green;'>".$msg."</p>"; ?>
            </div>
    </div>
    <!-- Personal details-->
    <div class="row">            <h3 align='right'><p style='color:green;'>
<?php  $type=$u->getUserType();if($type=='Employee'){?><a href='emp-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Manager'){?><a href='manager-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Travel Desk'){?><a href='travel-desk-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Admin'){?><a href='admin-board.php'>Dashboard</a><?php }?>
<?php $type=$u->getUserType();if($type=='Finance'){?><a href='Finance-board.php'>Dashboard</a><?php }?>
&nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></p></h3>
            
            </div>

    <!-- Personal details-->
    <div class="row">
        <font color="red">* </font> <?php echo $status_msg; ?>
    <span class="f-leg"><img src="img/user32.png" />Tell us about yourself</span>
    <fieldset name "personal-info">
              <div class="col-3-grid">
		<p><label for "fname">First Name <font color="red">*</font></span></label>
                <input type="text" id="fname" name="firstname" placeholder="First Name" tabindex="1" value="<?php echo $user_profile['firstname']; ?>" autofocus /></p>
          	<p><label for "bunit">Business Unit <font color="red">*</font></label>
           	<!--input type="text" id="bunit" name="biz_unit" placeholder="Business Unit" tabindex="4" value="<?php echo $user_profile['biz_unit'];?>" autofocus /-->
           	
           	<select name="bu" id="biz_unit" ><option value="">Business Unit</option><?php $bizunit=$u->getbus($user_profile['bu']); 
		    foreach($bu as $bus) { ?>
		      <option value="<?php echo $bus['id']; ?>" <?php if($bus['bu_short_name']==$bizunit['bu_short_name']){echo 'selected=selected';} ?>><?php echo $bus['bu_short_name']; ?></option>
		  <?php
		    } ?> </select>
          	<p><label for "bunit">Organisation Unit <font color="red">*</font></label>
           	<select name="ou" id="org_unit" ><option value="">Organisation Unit</option><?php $orgunit=$u->getous($user_profile['ou']); 
		    foreach($ou as $ous) { ?>
		      <option value="<?php echo $ous['id']; ?>" <?php if($ous['ou_short_name']==$orgunit['ou_short_name']){echo 'selected=selected';} ?>><?php echo $ous['ou_short_name']; ?></option>
		  <?php
		    } ?> </select>
           	
           	
           	
          	<p> <label for "home-add1">Home Address 1 </label>
           	<input type="text" id="home-add1" name="address1" placeholder="Home Address 1" tabindex="7" value="<?php echo $user_profile['address1'];?>" autofocus /></p> 
           	<p><label for "pincode">pincode </label>
           	<input type="text" id="pincode" name="pincode" placeholder="Pincode" tabindex="10" value="<?php echo $user_profile['pincode']; ?>" autofocus /></p>
           	<p><label for "Alt-no">Alternate Contact no. </label>
           	<input type="text" id="alt-no" name="alt_contact_no" placeholder="Alternate Contact no." tabindex="14" value="<?php echo $user_profile['alt_contact_no']; ?>" autofocus /></p>         
         </div>
         
          <div class="col-3-grid">  <p><label for "mname">Middle Name </label>
         <input type="text" id="mname" name="middlename" placeholder="Middle Name" tabindex="2" value="<?php echo $user_profile['middlename']; ?>" autofocus /></p>
         <p><label for "off-loc">Office Location </label><?php $location=$u->getoffice_locations($user_profile['location']);?>
         <!--input type="text" id="off-loc" name="location" placeholder="Main Office Location" tabindex="5" value="<?php echo $user_profile['location']; ?>" autofocus  /-->



<select name="location" id="off-loc" ><option value="">Office Location</option><?php 
		    foreach($office_locations as $office_location) { ?>
		      <option value="<?php echo $office_location['id']; ?>" <?php if($office_location['id']==$location['id']){echo "selected='selected'";} ?>><?php echo $office_location['location']; ?></option>
		  <?php
		    } ?> </select></p>
         <p><label for "home-add2">Home Address 2 </label>
         <input type="text" id="home-add2" name="address2" placeholder="Home Address 2" tabindex="8" value="<?php echo $user_profile['address2']; ?>" autofocus /></p>
          <p><label for "email-id">Email add <font color="red">*</font></label>
         <input type="email" id="email-id" name="email" placeholder="Email add" tabindex="11" value="<?php echo $user_profile['email']; ?>" autofocus /></p>
         <p><label for "emergency-no">Emergency Contact no. </label>
         <input type="text" id="emergency-no" name="emergency_no" placeholder="Emergency no." tabindex="13" value="<?php echo $user_profile['emergency_no']; ?>" autofocus /></p></div>
         
          <div class="col-3-grid"><p><label for "lname">Last Name <font color="red">*</font></label>
         <input type="text" id="lname" name="lastname" placeholder="Last Name" tabindex="3" value="<?php echo $user_profile['lastname']; ?>" autofocus /></p>
         <p><label for "bdate">Birthdate </label>
         <input type="date" id="bdate" name="dob" placeholder="Birthdate YY-MM-DD" tabindex="6" value="<?php echo $user_profile['dob']; ?>" autofocus /></p>
         <p><label for "city">City </label>
<select name="city" id="city" ><option value="">City</option><?php $city=$u->getcity($user_profile['city']); 
		    foreach($cities as $citie) { ?>
		      <option value="<?php echo $citie['id']; ?>" <?php if($city['city_name']==$citie['city_name']){echo 'selected=selected';} ?>><?php echo $citie['city_name']; ?></option>
		  <?php
		    } ?> </select>
         <!--input type="text" id="city" name="city" placeholder="City" tabindex="9" value="<?php echo $user_profile['city']; ?>" autofocus /--></p> 
          <p><label for "cell-no">Contact no. <font color="red">*</font></label>
         <input type="text" id="cell-no" name="contact_no" placeholder="Cell number" tabindex="12" value="<?php echo $user_profile['contact_no']; ?>" autofocus /></p>
 <p><label for "cell-no">Manager Email</label>
         <!--input type="text" id="entity" name="entity" placeholder="Entity" tabindex="12" value="<?php echo $user_profile['entity']; ?>" autofocus /-->
<?php $manager_email=$u->getUserDetailsid($user_profile['manager']); //echo $user_profile['manager'];  print_r($manager_email);?>
<input type="text" id="manager" name="manager_email" placeholder="manager email" tabindex="12" value="<?php echo  $user_profile['manager_email']; ?>" autofocus />
</p>
         
         </div>
     </fieldset>
    </div>
    <!-- Personal details end-->
    <!-- Passport details-->
    <div class="row clearfix">
    <!--div class="col-3-grid"-->
    <span class="f-leg"><img src="img/passport32.png" /> Passport details</span>
    <fieldset name "passport">
    <div class="col-3-grid">
       	<p><label for "pp-no">Passport No </label>
        <input type="text" id="pp-no" name="passport_no" placeholder="Passport No " value="<?php echo $user_profile['passport_no']; ?>" autofocus /></p>
    </div>
    <div class="col-3-grid">
        <p><label for "pp-exp-date">Passport expiry date </label>
        <input type="date" id="pp-exp-date" name="passport_expiry_date" placeholder="Passport exp date YY-MM-DD" value="<?php echo $user_profile['passport_expiry_date']; ?>" autofocus /></p>
    </div>
    <div class="col-3-grid">
        <p><label for "pp-copy">Upload passport </label>
        <input type="file" id="pp-copy" name="passport_copy" placeholder="Upload passport copy" autofocus /> 
<?php if(!empty($user_profile['passport_copy'])){?><a href="/uploads/passport-copy/<?php echo $user_profile['passport_copy'];?>" target="_blank">View Passport Copy</a><?php } ?></p>
    </div>
    </fieldset>
    <!--/div-->
    <!--div class="col-6-grid clearfix"-->


<?php if(!empty($visaDetails)){ ?>
<fieldset name "visa">
 <table class="resp">
      <thead>
        <tr>
          <th>Visa Number</th>
          <th>Visa country</th>
          <th>Visa Expiry Date</th>
          <th>Visa copy</th>
        <th style="width:15%">Delete</th>
        </tr>
      </thead>
<?php foreach($visaDetails as $visaDetail){?>
<tr id="row<?php echo $visaDetail['id']; ?>">
<td align="center"><?php echo $visaDetail['visa_no'];?></td>
<td align="center"><?php echo $visaDetail['visa-country'];?></td>
<td align="center"><?php echo $visaDetail['visa-exp-date'];?></td>
<td align="center"><a href="uploads/visa-copy/<?php echo $visaDetail['visa_copy'];?>" target="_blank">View visa_copy</a></td>
<td align="center"><input type="hidden" name="visa_id" value="<?php echo $visaDetail['id']; ?>">
   <input type='button' class="delete_button" id="delete_button<?php echo $visaDetail['id']; ?>" value="delete" onclick="delete_row('<?php echo $visaDetail['id']; ?>');"></td>
</tr>
<?php } ## foreach ends ?>
</table>
</fieldset>
<?php } ## empty visa array check ends ?>

<div class="tbBooks" id="tbBooks"> 
   <!-- Passport details end-->
   <!-- Visa details-->
   <span class="f-leg"><img src="img/Visa32.png" />Visa details</span>




    <fieldset name "visa">
    	
        	<div class="col-6-grid"><p><label for "vis-ct">Select country</label>
            	<select name="visa-country[]">
                  <option value="AF">Afghanistan</option>
                  <option value="AX">Åland Islands</option>
                  <option value="AL">Albania</option>
                  <option value="DZ">Algeria</option>
                  <option value="AS">American Samoa</option>
                  <option value="AD">Andorra</option>
                  <option value="AO">Angola</option>
                  <option value="AI">Anguilla</option>
                  <option value="AQ">Antarctica</option>
                  <option value="AG">Antigua and Barbuda</option>
                  <option value="AR">Argentina</option>
                  <option value="AM">Armenia</option>
                  <option value="AW">Aruba</option>
                  <option value="AU">Australia</option>
                  <option value="AT">Austria</option>
                  <option value="AZ">Azerbaijan</option>
                  <option value="BS">Bahamas</option>
                  <option value="BH">Bahrain</option>
                  <option value="BD">Bangladesh</option>
                  <option value="BB">Barbados</option>
                  <option value="BY">Belarus</option>
                  <option value="BE">Belgium</option>
                  <option value="BZ">Belize</option>
                  <option value="BJ">Benin</option>
                  <option value="BM">Bermuda</option>
                  <option value="BT">Bhutan</option>
                  <option value="BO">Bolivia, Plurinational State of</option>
                  <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                  <option value="BA">Bosnia and Herzegovina</option>
                  <option value="BW">Botswana</option>
                  <option value="BV">Bouvet Island</option>
                  <option value="BR">Brazil</option>
                  <option value="IO">British Indian Ocean Territory</option>
                  <option value="BN">Brunei Darussalam</option>
                  <option value="BG">Bulgaria</option>
                  <option value="BF">Burkina Faso</option>
                  <option value="BI">Burundi</option>
                  <option value="KH">Cambodia</option>
                  <option value="CM">Cameroon</option>
                  <option value="CA">Canada</option>
                  <option value="CV">Cape Verde</option>
                  <option value="KY">Cayman Islands</option>
                  <option value="CF">Central African Republic</option>
                  <option value="TD">Chad</option>
                  <option value="CL">Chile</option>
                  <option value="CN">China</option>
                  <option value="CX">Christmas Island</option>
                  <option value="CC">Cocos (Keeling) Islands</option>
                  <option value="CO">Colombia</option>
                  <option value="KM">Comoros</option>
                  <option value="CG">Congo</option>
                  <option value="CD">Congo, the Democratic Republic of the</option>
                  <option value="CK">Cook Islands</option>
                  <option value="CR">Costa Rica</option>
                  <option value="CI">Côte d'Ivoire</option>
                  <option value="HR">Croatia</option>
                  <option value="CU">Cuba</option>
                  <option value="CW">Curaçao</option>
                  <option value="CY">Cyprus</option>
                  <option value="CZ">Czech Republic</option>
                  <option value="DK">Denmark</option>
                  <option value="DJ">Djibouti</option>
                  <option value="DM">Dominica</option>
                  <option value="DO">Dominican Republic</option>
                  <option value="EC">Ecuador</option>
                  <option value="EG">Egypt</option>
                  <option value="SV">El Salvador</option>
                  <option value="GQ">Equatorial Guinea</option>
                  <option value="ER">Eritrea</option>
                  <option value="EE">Estonia</option>
                  <option value="ET">Ethiopia</option>
                  <option value="FK">Falkland Islands (Malvinas)</option>
                  <option value="FO">Faroe Islands</option>
                  <option value="FJ">Fiji</option>
                  <option value="FI">Finland</option>
                  <option value="FR">France</option>
                  <option value="GF">French Guiana</option>
                  <option value="PF">French Polynesia</option>
                  <option value="TF">French Southern Territories</option>
                  <option value="GA">Gabon</option>
                  <option value="GM">Gambia</option>
                  <option value="GE">Georgia</option>
                  <option value="DE">Germany</option>
                  <option value="GH">Ghana</option>
                  <option value="GI">Gibraltar</option>
                  <option value="GR">Greece</option>
                  <option value="GL">Greenland</option>
                  <option value="GD">Grenada</option>
                  <option value="GP">Guadeloupe</option>
                  <option value="GU">Guam</option>
                  <option value="GT">Guatemala</option>
                  <option value="GG">Guernsey</option>
                  <option value="GN">Guinea</option>
                  <option value="GW">Guinea-Bissau</option>
                  <option value="GY">Guyana</option>
                  <option value="HT">Haiti</option>
                  <option value="HM">Heard Island and McDonald Islands</option>
                  <option value="VA">Holy See (Vatican City State)</option>
                  <option value="HN">Honduras</option>
                  <option value="HK">Hong Kong</option>
                  <option value="HU">Hungary</option>
                  <option value="IS">Iceland</option>
                  <option value="IN">India</option>
                  <option value="ID">Indonesia</option>
                  <option value="IR">Iran, Islamic Republic of</option>
                  <option value="IQ">Iraq</option>
                  <option value="IE">Ireland</option>
                  <option value="IM">Isle of Man</option>
                  <option value="IL">Israel</option>
                  <option value="IT">Italy</option>
                  <option value="JM">Jamaica</option>
                  <option value="JP">Japan</option>
                  <option value="JE">Jersey</option>
                  <option value="JO">Jordan</option>
                  <option value="KZ">Kazakhstan</option>
                  <option value="KE">Kenya</option>
                  <option value="KI">Kiribati</option>
                  <option value="KP">Korea, Democratic People's Republic of</option>
                  <option value="KR">Korea, Republic of</option>
                  <option value="KW">Kuwait</option>
                  <option value="KG">Kyrgyzstan</option>
                  <option value="LA">Lao People's Democratic Republic</option>
                  <option value="LV">Latvia</option>
                  <option value="LB">Lebanon</option>
                  <option value="LS">Lesotho</option>
                  <option value="LR">Liberia</option>
                  <option value="LY">Libya</option>
                  <option value="LI">Liechtenstein</option>
                  <option value="LT">Lithuania</option>
                  <option value="LU">Luxembourg</option>
                  <option value="MO">Macao</option>
                  <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                  <option value="MG">Madagascar</option>
                  <option value="MW">Malawi</option>
                  <option value="MY">Malaysia</option>
                  <option value="MV">Maldives</option>
                  <option value="ML">Mali</option>
                  <option value="MT">Malta</option>
                  <option value="MH">Marshall Islands</option>
                  <option value="MQ">Martinique</option>
                  <option value="MR">Mauritania</option>
                  <option value="MU">Mauritius</option>
                  <option value="YT">Mayotte</option>
                  <option value="MX">Mexico</option>
                  <option value="FM">Micronesia, Federated States of</option>
                  <option value="MD">Moldova, Republic of</option>
                  <option value="MC">Monaco</option>
                  <option value="MN">Mongolia</option>
                  <option value="ME">Montenegro</option>
                  <option value="MS">Montserrat</option>
                  <option value="MA">Morocco</option>
                  <option value="MZ">Mozambique</option>
                  <option value="MM">Myanmar</option>
                  <option value="NA">Namibia</option>
                  <option value="NR">Nauru</option>
                  <option value="NP">Nepal</option>
                  <option value="NL">Netherlands</option>
                  <option value="NC">New Caledonia</option>
                  <option value="NZ">New Zealand</option>
                  <option value="NI">Nicaragua</option>
                  <option value="NE">Niger</option>
                  <option value="NG">Nigeria</option>
                  <option value="NU">Niue</option>
                  <option value="NF">Norfolk Island</option>
                  <option value="MP">Northern Mariana Islands</option>
                  <option value="NO">Norway</option>
                  <option value="OM">Oman</option>
                  <option value="PK">Pakistan</option>
                  <option value="PW">Palau</option>
                  <option value="PS">Palestinian Territory, Occupied</option>
                  <option value="PA">Panama</option>
                  <option value="PG">Papua New Guinea</option>
                  <option value="PY">Paraguay</option>
                  <option value="PE">Peru</option>
                  <option value="PH">Philippines</option>
                  <option value="PN">Pitcairn</option>
                  <option value="PL">Poland</option>
                  <option value="PT">Portugal</option>
                  <option value="PR">Puerto Rico</option>
                  <option value="QA">Qatar</option>
                  <option value="RE">Réunion</option>
                  <option value="RO">Romania</option>
                  <option value="RU">Russian Federation</option>
                  <option value="RW">Rwanda</option>
                  <option value="BL">Saint Barthélemy</option>
                  <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                  <option value="KN">Saint Kitts and Nevis</option>
                  <option value="LC">Saint Lucia</option>
                  <option value="MF">Saint Martin (French part)</option>
                  <option value="PM">Saint Pierre and Miquelon</option>
                  <option value="VC">Saint Vincent and the Grenadines</option>
                  <option value="WS">Samoa</option>
                  <option value="SM">San Marino</option>
                  <option value="ST">Sao Tome and Principe</option>
                  <option value="SA">Saudi Arabia</option>
                  <option value="SN">Senegal</option>
                  <option value="RS">Serbia</option>
                  <option value="SC">Seychelles</option>
                  <option value="SL">Sierra Leone</option>
                  <option value="SG">Singapore</option>
                  <option value="SX">Sint Maarten (Dutch part)</option>
                  <option value="SK">Slovakia</option>
                  <option value="SI">Slovenia</option>
                  <option value="SB">Solomon Islands</option>
                  <option value="SO">Somalia</option>
                  <option value="ZA">South Africa</option>
                  <option value="GS">South Georgia and the South Sandwich Islands</option>
                  <option value="SS">South Sudan</option>
                  <option value="ES">Spain</option>
                  <option value="LK">Sri Lanka</option>
                  <option value="SD">Sudan</option>
                  <option value="SR">Suriname</option>
                  <option value="SJ">Svalbard and Jan Mayen</option>
                  <option value="SZ">Swaziland</option>
                  <option value="SE">Sweden</option>
                  <option value="CH">Switzerland</option>
                  <option value="SY">Syrian Arab Republic</option>
                  <option value="TW">Taiwan, Province of China</option>
                  <option value="TJ">Tajikistan</option>
                  <option value="TZ">Tanzania, United Republic of</option>
                  <option value="TH">Thailand</option>
                  <option value="TL">Timor-Leste</option>
                  <option value="TG">Togo</option>
                  <option value="TK">Tokelau</option>
                  <option value="TO">Tonga</option>
                  <option value="TT">Trinidad and Tobago</option>
                  <option value="TN">Tunisia</option>
                  <option value="TR">Turkey</option>
                  <option value="TM">Turkmenistan</option>
                  <option value="TC">Turks and Caicos Islands</option>
                  <option value="TV">Tuvalu</option>
                  <option value="UG">Uganda</option>
                  <option value="UA">Ukraine</option>
                  <option value="AE">United Arab Emirates</option>
                  <option value="GB">United Kingdom</option>
                  <option value="US">United States</option>
                  <option value="UM">United States Minor Outlying Islands</option>
                  <option value="UY">Uruguay</option>
                  <option value="UZ">Uzbekistan</option>
                  <option value="VU">Vanuatu</option>
                  <option value="VE">Venezuela, Bolivarian Republic of</option>
                  <option value="VN">Viet Nam</option>
                  <option value="VG">Virgin Islands, British</option>
                  <option value="VI">Virgin Islands, U.S.</option>
                  <option value="WF">Wallis and Futuna</option>
                  <option value="EH">Western Sahara</option>
                  <option value="YE">Yemen</option>
                  <option value="ZM">Zambia</option>
                  <option value="ZW">Zimbabwe</option>
                </select> </p>


      
                <p><label for "visa-copy">Upload Visa document </label>
         <input type="file" id="visa-copy" name="visa-copy[]" placeholder="Upload Visa copy " autofocus /></p>
                
                </div><!--visa col 1 ends-->
                
        
         <div class="col-3-grid"><p><label for "pp-copy">Enter Visa No.</label>
         <input type="text" id="visa-no" name="visa-no[]" placeholder="Visa No" autofocus /></p>
         
         <p><label for "visa-exp-date">Visa expiry date </label>
         <input type="date" id="visa-exp-date" name="visa-exp-date[]" placeholder="Visa expiry date YY-MM-DD" autofocus /></p></div><!--visa col 2 ends-->
        <!--input type="button" class="" value="EDIT" /><input type="button" class="" value="DELETE" /-->
  	<!--/fieldset></div--> 
   <!--/div--> 
    <!-- Visa details end-->
    </div></div>
<div id="container2" style="display:none;"></div> <div class="btn-set" id="visaadd"> <input type="button" class="" value="ADD" /></div>
<br />
      <div class="row">
    
<?php if(!empty($getffDetails)){?>
<fieldset name "ffp">
 <table class="resp">
      <thead>
        <tr>
          <th>FFP ID</th>
          <th>Air Company</th>
          <th>FFP Name</th>
          <th style="width:14%;">Delete</th>
        </tr>
      </thead>
<?php
foreach($getffDetails as $getffDetail){?>
<tr id="rowff<?php echo $getffDetail['id'];?>">
<td align="center"><?php echo $getffDetail['ffp-id'];?></td>
<td align="center"><?php $airline = $u->getairlines($getffDetail['air-co']); echo $airline['name'];?></td>
<td align="center"><?php echo $getffDetail['ffp-name'];?></td>
<td align="center"><input type="hidden" name="ffp_id" value="<?php echo $getffDetail['id'];?>"> <!--input type="submit" name="delete_ffp" value="Delete"-->
<input type='button' class="delete_buttonff" id="delete_buttonff<?php echo $getffDetail['id']; ?>" value="delete" onclick="delete_rowff('<?php echo $getffDetail['id'];?>');">
<!--a href="deletevisa.php?delete_rowff=delete&delff=<?php echo $getffDetail['id']; ?>" id="<?php echo $getffDetail['id']; ?>" class="trash">Delete<?php echo $getffDetail['id']; ?></a-->
</td>
</tr>
<?php } ## foreach ends?>
</table>
</fieldset>
<?php } ## empty array cehck ends ?>



    <!-- Frequent flyer program details-->
<div class="ffp" id="ffp">
<span class="f-leg"><img src="img/program_details32.png" />Frequent-Flyer Program Details</span>

      <fieldset name "ffp">
        <div class="col-3-grid"><p><label for "vis-ct">Select Air travel co.</label>
<select name="air-co[]"> <option value="">Select preferred Airlines</option>
		<?php
		    foreach($airlines as $airline) { ?>
		      <option value="<?php echo $airline['id']; ?>"><?php echo $airline['name']; ?></option>
		  <?php
		    } ?></select> 


<!--select name="air-co[]"><option value="Air India">Air India</option> </select---> </p></div>
          	<div class="col-3-grid"><p><label for "ffp-name">Name of the FFP program</label>
         	<input type="text" id="ffp-name" name="ffp-name[]" placeholder="FFP name" autofocus /></p></div>
         	<div class="col-3-grid"><p><label for "ffp-id">FFP program id </label>
         	<input type="text" id="ffp-id" name="ffp-id[]" placeholder="FFP program id" autofocus /></p></div>
             
  </fieldset>
  </div></div><div id="containerffp" style="display:none;"></div> <div class="btn-set" id="Frequent-Flyer"> <input type="button" class="" value="ADD" /><!--input type="button" class="" value="EDIT" /><input type="button" class="" value="DELETE" /--></div></div><br/>
    <!-- Frequent flyer program details end-->
    <!-- Preferneces
    <fieldset name "preferences">
    	<legend class="ans-fs-legend">Let us know about your preferences</legend>
        	<p><select name="air-co"><option value="">Air India</option> </select> </p>
    		<p><select name="meal preference">
            	<option value="veg">Veg</option> 
                <option value="non-veg">Non-Veg</option> 
                <option value="both">Both</option> 
               </select> </p>
               
    </fieldset>-->
    <div class="row cent"><input type="SUBMIT" value="SUBMIT" /></div>
 </form>
  

  </div>
  <footer>

  </footer>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

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
  </div><!--wrapper ends--> 
</body>
</html>


