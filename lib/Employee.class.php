<?php
include_once('User.class.php');

class Employee extends User{

    public function __construct($user_id){
        parent::__construct($user_id);
        if(!$this->isEmployee()){
            $this->_loginRedirect();
         //log failure
	/*
            $log = debug_backtrace();
            $this->createActionLog($log,0);
	*/
            throw new Exception('No privileges');
        }
    }


function travelrequestbooking($data){//print_r($data);exit;
if($data['booking']=='hotel'){   $details = $this->travelrequestonlyhotel($data);}
else if($data['booking']=='car') { $details = $this->travelrequestonlycar($data);}
else if($data['booking']=='train') { $details = $this->travelrequestonlytrain($data);}
else if($data['trip_type']=='oneway' && $data['booking']=='air'){$details = $this->travelrequestbookingoneway($data);}
 else if($data['trip_type']=='multicity' && $data['booking']=='air'){ $details = $this->travelrequestbookingmulticity($data); }
else if($data['trip_type']=='round trip' && $data['booking']=='air'){$details = $this->travelrequestbookinground($data); }

	return true;
}
 function travelrequestonlytrain($data){ 
function filter_travelrequestonlytrain($val) {
    $val = trim($val);
    return $val != '';
}
$onwardcity = @array_values(array_filter($data['onwardcity'], 'filter_travelrequestonlytrain'));
$travel_to = @array_values(array_filter($data['travel_to'], 'filter_travelrequestonlytrain'));
$train = @array_values(array_filter($data['train'], 'filter_travelrequestonlytrain'));
$class = @array_values(array_filter($data['class'], 'filter_travelrequestonlytrain'));
$boarding_form = @array_values(array_filter($data['boarding_form'], 'filter_travelrequestonlytrain'));
$age = @array_values(array_filter($data['age'], 'filter_travelrequestonlytrain'));
$date = @array_values(array_filter($data['date'], 'filter_travelrequestonlytrain'));
$otheronwardcitys = @array_values(array_filter($data['otheronwardcity'], 'filter_travelrequestonlytrain'));
$othertraveltos = @array_values(array_filter($data['othertravel_to'], 'filter_travelrequestonlytrain'));

  //********************trip instration for only Train booking*******************************//
try{
	$data=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'train' ,'purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'status'=>'Open'];
	$this->pdo->insert('trips', $data);		
	$id = $this->pdo->lastInsertId();

		
//********************destination_and_departure instration for only Train booking*******************************//

	$body .="<html><body>";
	$subject .= 'ANSYS Travel Portal: New request';

	$body .= '<b>Visit details</b><br/><br/>';
        $body .= "<b>Purpose Of Visit : </b>".$data['purpose_of_visit'].'<br/>';
        $body .= "<b>Special Remarks : </b>".$data['special_mention'].'<br/><br/>';

	$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);
	$l=$this->getoffice_locations($row[0]['location']);
        $body .= "<b>Office Location : </b>".$l['location'].'<br/><br/>';
	$to=$row[0]['email'];
	$formemail=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
	 $body .= "<b>Phone Number : </b>".$row[0]['contact_no']."<br/><br/>";
        $body .= "<b>Email : </b>".$row[0]['email']."<br/><br/>";
        $body .= "<b>Trip Id : </b>".$id."<br/><br/>";
	$zc=count($onwardcity);
	for($z = 0; $z < $zc; $z++ )
	{ 


$ocity=$this->getcity($onwardcity[$z]);
	if($onwardcity[$z]==0){ $otheronwardcity = array_shift($otheronwardcitys);}else{ $otheronwardcity = 'NULL';}  

$tocity=$this->getcity($travel_to[$z]);
	if($travel_to[$z]==0){ $othertravel_to = array_shift($othertraveltos);}else{ $othertravel_to = 'NULL';}  
//$date=(date('Y-m-d H:i:s', strtotime($date[$z])));
	$datadad=['emp_id'=>$this->user_id,'travel_from'=>$onwardcity[$z],'travel_to'=>$travel_to[$z],'age'=>$age[$z],'trip_id'=>$id,'train'=>$train[$z],'class'=>$class[$z],'boarding_form'=>$boarding_form[$z],'date'=>$date[$z],'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];
	$this->pdo->insert('destination_and_departure', $datadad);

	### Request ID added in body
	$request_id = $this->pdo->lastInsertId();
       // $body .= "<b>Request ID : </b>".$request_id."<br/><br/>";

if(!empty($date[$z])){ $dd= date("F j, Y", strtotime($date[$z])) ; }else{ $dd= " "; }

/*****************************************************Train Request details for mail body********************************************************************************************/
$cityto=$this->getcity($travel_to[$z]);$city=$this->getcity($onwardcity[$z]);
if($otheronwardcity!='NULL'){ $otheronwardcity= $otheronwardcity; }else{ $otheronwardcity= ' '; }
	if($othertravel_to!='NULL'){ $othertravel_to= $othertravel_to; }else{ $othertravel_to= ' '; }
	$body .= '<table border="1" width="400">';	
	$body .= '<tr><td colspan="2" align="center"><h2>Train Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
       	$body .='<tr><th align="left">Request Id</th><td>'.$request_id.'</td></tr>';
	$body .= "<tr><th align='left'>From Location</th><td>".$city['city_name'].$otheronwardcity."</td></tr>";
	$body .= "<tr><th align='left'>Destination</th><td>".$cityto['city_name'].$othertravel_to."</td></tr>";
	$body .= "<tr><th align='left'>Age</th><td>".$age[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Train</th><td>".$train[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Date</th><td>".$dd."</td></tr>";
	$body .= "<tr><th align='left'>Class</th><td>".$class[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Boarding From</th><td>".$boarding_form[$z]."</td></tr>";
	$body .= "</table><br/><br/>";
	$body .= '</body></html>';
	}// end for
$flag='request';
	$requestmail= $this->sendemail($to,$subject,$body,$formemail,$id,$flag);//Send mail Car Request details 
	return true;

}catch(PDOException $e){
//echo $e->getMessage();exit;
                $this->setError($e->getMessage());
                return false;
        }



}


function travelrequestonlyhotel($data){

function filter_callbackhotel($val) {
    $val = trim($val);
    return $val != '';
}
$pref_hotel = @array_values(array_filter($data['pref_hotel'], 'filter_callbackhotel'));
$travel_to = @array_values(array_filter($data['travel_to'], 'filter_callbackhotel'));
$room_type = @array_values(array_filter($data['room_type'], 'filter_callbackhotel'));
$noofguests = @array_values(array_filter($data['noofguests'], 'filter_callbackhotel'));
$noofrooms = @array_values(array_filter($data['noofrooms'], 'filter_callbackhotel'));
$checkintime = @array_values(array_filter($data['checkintime'], 'filter_callbackhotel'));
$checkouttime = @array_values(array_filter($data['checkouttime'], 'filter_callbackhotel'));
$checkindate = @array_values(array_filter($data['checkindate'], 'filter_callbackhotel'));
$checkoutdate = @array_values(array_filter($data['checkoutdate'], 'filter_callbackhotel'));
$otherhotels = @array_values(array_filter($data['otherhotel'], 'filter_callbackhotel'));

  //********************trip instration for only hotel booking*******************************//
try{
$data=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'hotel' ,'purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'status'=>'Open'];
				$this->pdo->insert('trips', $data);		
				$id = $this->pdo->lastInsertId();

		
//********************destination_and_departure instration for only hotel booking*******************************//
		                                     //print_r($pref_hotel);exit;
$body .="<html><body>";
$subject .= 'ANSYS Travel Portal: New request';

	$body .= '<b>Visit details</b><br/><br/>';
	$body .= "<b>Purpose Of Visit : </b>".$data['purpose_of_visit'].'<br/>';
	$body .= "<b>Special Remarks : </b>".$data['special_mention'].'<br/><br/>';
$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);

	$l=$this->getoffice_locations($row[0]['location']);
        $body .= "<b>Office Location : </b>".$l['location'].'<br/><br/>';
	
	$to=$row[0]['email'];
	$formemail=$row[0]['email'];

	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
	 $body .= "<b>Phone Number : </b>".$row[0]['contact_no']."<br/><br/>";
        $body .= "<b>Email : </b>".$row[0]['email']."<br/><br/>";
        $body .= "<b>Trip Id : </b>".$id."<br/><br/>";
	$zc=count($pref_hotel);
	for($z = 0; $z < $zc; $z++ )
	{ 
	//print_r($data);exit;
//$checkindate=(date('Y-m-d H:i:s', strtotime($checkindate[$z])));
//$checkoutdate=(date('Y-m-d H:i:s', strtotime($checkoutdate[$z])));
	$hotel=$this->gethotel($pref_hotel[$z]);
	if($hotel['hotel_name']=='Other'){ $otherhotel = array_shift($otherhotels);}else{ $otherhotel = 'NULL';}  


	$datadad=['emp_id'=>$this->user_id,'pref_hotel'=>$pref_hotel[$z],'travel_to'=>$travel_to[$z],'trip_id'=>$id,'room_type'=>$room_type[$z],'noofguests'=>$noofguests[$z],'noofrooms'=>$noofrooms[$z],'checkintime'=>$checkintime[$z],'checkouttime'=>$checkouttime[$z],'checkoutdate'=>$checkoutdate[$z],'checkindate'=>$checkindate[$z],'otherhotel'=>$otherhotel];
	$this->pdo->insert('destination_and_departure', $datadad);
	### Request ID added in body
	$request_id = $this->pdo->lastInsertId();
        //$body .= "<b>Request ID : </b>".$request_id."<br/><br/>";

if(!empty($checkindate[$z])){ $lcd= date("F j, Y", strtotime($checkindate[$z])) ; }else{ $lcd= " "; }
if(!empty($checkoutdate[$z])){ $lchd= date("F j, Y", strtotime($checkoutdate[$z])) ; }else{ $lchd= " "; }

/*****************************************************Hotel Request details for mail body********************************************************************************************/
	$city=$this->getcity($travel_to[$z]);$hotel=$this->gethotel($pref_hotel[$z]);
	$body .= '<table border="1" width="400">';	
	$body .= '<tr><td colspan="2" align="center"><h2>Hotel Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	$body .= "<tr><th align='left'>Room Type</th><td>".$room_type[$z]."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}

	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }
	$body .='<tr><th align="left">Request Id</th><td>'.$request_id.'</td></tr>';
	$body .= "<tr><th align='left'>Hotel</th><td>".$hotel['hotel_name'].$otherhotel."</td></tr>";
	$body .= "<tr><th align='left'>City</th><td>".$city['city_name']."</td></tr>";
	$body .= "<tr><th align='left'>Room Type</th><td>".$room_type[$z]."</td></tr>";
	$body .= "<tr><th align='left'>No.of Guests</th><td>".$noofguests[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$checkintime[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check Out time</th><td>".$checkouttime[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in date</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check Out date</th><td>".$lchd."</td></tr>";

	$body .= "</tbody align='left'></table><br/><br/>";
	$body .= '</body></html>';
	}// end forz
$flag='request';
	$requestmail= $this->sendemail($to,$subject,$body,$formemail,$id,$flag);//Send mail Car Request details 
	return true;

}catch(PDOException $e){
//echo $e->getMessage();exit;
                $this->setError($e->getMessage());
                return false;
        }



}
//Added By Rupali Request booking onlycar
function travelrequestonlycar($data){
//print_r($data);
function filter_callbackcar($val) {
$val = trim($val);
return $val != '';
}
$car_company = @array_values(array_filter($data['car_company'], 'filter_callbackcar'));
$car_pickup_location = @array_values(array_filter($data['car_pickup_location'], 'filter_callbackcar'));
$destination = @array_values(array_filter($data['destination'], 'filter_callbackcar'));
$car_pickuptime = @array_values(array_filter($data['car_pickuptime'], 'filter_callbackcar'));
$pickup_date = @array_values(array_filter($data['pickup_date'], 'filter_callbackcar'));
$need_car = @array_values(array_filter($data['need_car'], 'filter_callbackcar'));
$pickup_city = @array_values(array_filter($data['pickup_city'], 'filter_callbackcar'));
$fromdate = @array_values(array_filter($data['fromdate'], 'filter_callbackcar'));
$todate = @array_values(array_filter($data['todate'], 'filter_callbackcar'));
#echo $data['fromdate']."<br />".$data['todate'];
$car_size = @array_values(array_filter($data['car_size'], 'filter_callbackcar'));

#### Posted array assigned to another array for from date and to date 
$from_to_date_data = $data;
$multiple=$data['multiple'];
//********************trip instration for only car booking*******************************//		
$data=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'multiple_days_car'=>$data['multiple'],'booking_type'=>'car' ,'purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'status'=>'Open'];                                 
$this->pdo->insert('trips', $data);
$id = $this->pdo->lastInsertId();
//********************destination_and_departure instration for only car booking*******************************//
$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);

	//$sendername=$row[0]['firstname'].'  '. $row[0]['lastname'];

	$formemail=$row[0]['email'];
	$to=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
	$body .="<html><body>";
	$subject .= 'ANSYS Travel Portal : New request';
	$body .= '<b>Visit details</b><br/><br/>';
	$body .= "<b>Purpose Of Visit : </b>".$data['purpose_of_visit'].'<br/>';

	$body .= "<b>Special Remarks : </b>".$data['special_mention'].'<br/><br/>';
	$l=$this->getoffice_locations($row[0]['location']);
        $body .= "<b>Office Location : </b>".$l['location'].'<br/><br/>';
	 $body .= "<b>Phone Number : </b>".$row[0]['contact_no']."<br/><br/>";
        $body .= "<b>Email : </b>".$row[0]['email']."<br/><br/>";
        $body .= "<b>Trip Id : </b>".$id."<br/><br/>";
$zcx=count($car_company);
for($z = 0; $z < $zcx; $z++ )
{

	
	//$pickup_date=(date('Y-m-d H:i:s', strtotime($pickup_date[$z])));
	//$fromdate=(date('Y-m-d H:i:s', strtotime($fromdate[$z])));
	//$todate=(date('Y-m-d H:i:s', strtotime($todate[$z])));
	$datadad=['emp_id'=>$this->user_id,'car_company'=>$car_company[$z],'date'=>$pickup_date[$z],'trip_id'=>$id,'car_pickuptime'=>$car_pickuptime[$z],'car_pickup_location'=>$car_pickup_location[$z],'destination'=>$destination[$z],'need_car'=>$need_car[$z],'pickup_city'=>$pickup_city[$z],'car_fromdate'=>$from_to_date_data[fromdate],'car_todate'=>$from_to_date_data[todate],'car_size'=>$car_size[$z]];
	$this->pdo->insert('destination_and_departure', $datadad);		
	### Request ID added in body
	$request_id = $this->pdo->lastInsertId();
        $body .= "<b>Request ID : </b>".$request_id."<br/><br/>";
$destdeptlastInsertId=$this->pdo->lastInsertId(); 
## display the detials
$city=$this->getcity($pickup_city[$z]); if($trip['trip_type'] == 'multicity'){ $city['city_name'];}
$car=$this->getcars($car_company[$z]);
/*****************************************************Car Request details for mail body********************************************************************************************/
	$body .= '<table border="1" width="400">';	
	$body .= '<tr><td colspan="2" align="center"><h2>Car Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
           if(date("F j, Y", strtotime($from_to_date_data[fromdate])) =='January 1, 1970')
		{
                   $fdate="";
		}
		else{
			$fdate=date("F j, Y", strtotime($from_to_date_data[fromdate])) ;
		}
           if(date("F j, Y", strtotime($from_to_date_data[todate])) =='January 1, 1970')
		{
                   $tdate="";
		}
		else{
			$tdate=date("F j, Y", strtotime($from_to_date_data[todate])) ;
		}
 		 if(date("F j, Y", strtotime($pickup_date[$z])) =='January 1, 1970')
		{
                   $pdate="";
		}
		else{
			$pdate=date("F j, Y", strtotime($pickup_date[$z])) ;
		}
	$body .='<tr><th align="left">Car Vendor Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Car Request Id</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	if(!empty($multiple)){$body .='<tr><th align="left">Car From Date</th><td>'.$fdate.'</td></tr>';
	$body .='<tr><th align="left">Car To Date</th><td>'.$tdate.'</td></tr>'; }
	$body .='<tr><th align="left">Pickup Date</th><td>'.$pdate.'</td></tr>';
	$body .='<tr> <th align="left">Pickup Address</th><td>'.$car_pickup_location[$z].'</td></tr>';
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[$z].'</td></tr>';
	$body .='<tr><th align="left">Destination</th><td>'.$destination[$z].'</td></tr>';
	$body .='<tr><th align="left">Need car for the entire day</th><td>'.$need_car[$z].'</td> </tr>'; 
$body .="</table><br/><br/>";

	} ## foreach($car_bookings as $car_booking){	
$body .="</html></body>";
$flag='request';
	$requestmail= $this->sendemail($to,$subject,$body,$formemail,$id,$flag);//Send mail Car Request details 
}

//Added By Rupali Request booking oneway
function travelrequestbookingoneway($data){
function filter_callbackoneway($val) {
    $val = trim($val);
    return $val != '';
}
$onwardcity = @array_values(array_filter($data['onwardcityoneway'], 'filter_callbackoneway'));
$pref_hotel = @array_values(array_filter($data['pref_hoteloneway'], 'filter_callbackoneway'));
$car_company = @array_values(array_filter($data['car_companyoneway'], 'filter_callbackoneway'));
$travel_to = @array_values(array_filter($data['travel_tooneway'], 'filter_callbackoneway'));
$book_airline = @array_values(array_filter($data['book_airlineoneway'], 'filter_callbackoneway'));
$checkintime = @array_values(array_filter($data['checkintimeoneway'], 'filter_callbackoneway'));
$checkouttime = @array_values(array_filter($data['checkouttimeoneway'], 'filter_callbackoneway'));
$checkindate = @array_values(array_filter($data['checkindateoneway'], 'filter_callbackoneway'));
$checkoutdate = @array_values(array_filter($data['checkoutdateoneway'], 'filter_callbackoneway'));
$pickup_city = @array_values(array_filter($data['pickup_cityoneway'], 'filter_callbackoneway'));
$date = @array_values(array_filter($data['dateoneway'], 'filter_callbackoneway'));
$rdate = @array_values(array_filter($data['rdateoneway'], 'filter_callbackoneway'));
$airport_drop_loca = @array_values(array_filter($data['airport_drop_locaoneway'], 'filter_callbackoneway'));
$airport_pickup_loca = @array_values(array_filter($data['airport_pickup_locaoneway'], 'filter_callbackoneway'));
$airport_drop = @array_values(array_filter($data['airport_droponeway'], 'filter_callbackoneway'));
$airport_pickup = @array_values(array_filter($data['airport_pickuponeway'], 'filter_callbackoneway'));
$car_type = @array_values(array_filter($data['car_typeoneway'], 'filter_callbackoneway'));
$car_size = @array_values(array_filter($data['car_sizeoneway'], 'filter_callbackoneway'));
$late_checkin = @array_values(array_filter($data['late_checkinoneway'], 'filter_callbackoneway'));
$late_checkout = @array_values(array_filter($data['late_checkoutoneway'], 'filter_callbackoneway'));
$late_checkin_date = @array_values(array_filter($data['late_checkin_dateoneway'], 'filter_callbackoneway'));
$late_checkout_date = @array_values(array_filter($data['late_checkout_dateoneway'], 'filter_callbackoneway'));
$drop_location = @array_values(array_filter($data['drop_locationoneway'], 'filter_callbackoneway'));
$pickup_location = @array_values(array_filter($data['pickup_locationoneway'], 'filter_callbackoneway'));
$pickup_date = @array_values(array_filter($data['pickup_dateoneway'], 'filter_callbackoneway'));
$need_car = @array_values(array_filter($data['need_caroneway'], 'filter_callbackoneway'));
$preferred_airline_time = @array_values(array_filter($data['preferred_airline_timeoneway'], 'filter_callbackoneway'));
$otherhotels = @array_values(array_filter($data['otherhoteloneway'], 'filter_callbackoneway'));
$otherairs = @array_values(array_filter($data['otheraironeway'], 'filter_callbackoneway'));
$otheronwardcitys = @array_values(array_filter($data['otheronwardcityoneway'], 'filter_callbackoneway'));
$othertraveltos = @array_values(array_filter($data['othertravel_tooneway'], 'filter_callbackoneway'));
$car_pickuptime = @array_values(array_filter($data['car_pickuptimeoneway'], 'filter_callbackoneway'));
$meal_preference = @array_values(array_filter($data['meal_preferenceoneway'], 'filter_callbackoneway'));
/*$old_date = date('y-m-d-h-i-s');              // works

$out = explode('-', $old_date);
$time = mktime($out[3], $out[4], $out[5], $out[1], $out[2], $out[0]);

$new_date = date('Y-m-d H:i:s', $time); */
//print_r($data);print_r($preferred_airline_time);exit;
//print_r($data);exit;

###### Code added  on 24 May 2023 to attach Manager Approval Report for longer journey
                //$path = "uploads/";
                //SKK
                $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/manager-approval-reports/";
                if($_FILES['manager_approval_report']['name']!=''){
                        $utime = md5(uniqid(time()));
                        $fname=$this->user_id."_".$utime."_".$_FILES['manager_approval_report']['name'];
                        $report_name=$fname;
                        $allowed_file_types = array('jpeg','jpg','png','pdf');
                        $filecheck = basename($_FILES['manager_approval_report']['name']);
                        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                        //echo $fname;exit;
                        $ftmpname=$_FILES['manager_approval_report']['tmp_name'];
                        //echo $fname;exit;

                        if(move_uploaded_file($ftmpname, $path.$fname)){
/*
      $insert = "INSERT INTO trips
      (`emp_id`,`purpose_of_visit`,`special_mention`,`trip_type`,`date`,`cost`,`status`,`manager_approval_report`,`booking_type`,`manager_approved`,`cash_adv`,`preferred_airline_time`,`multiple_days_car`)
      VALUES(?,?,?,?,NOW(),?,'Open',?,'airline','0','0','0','0')";
        $insert_args = [$this->user_id,$data['purpose_of_visit'],$data['special_mention'],$data['trip_type'],$data['cash_adv'],$report_name];
      try{
      $stmt=$this->pdo->prepare($insert);
      $stmt->execute($insert_args);
      }
      catch(PDOException $e){
        echo $e->getMessage(); exit;
      $this->setError($e->getMessage());
      return false;
      }
*/
 $datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open','manager_approval_report'=>$report_name,'manager_approved'=>'1','cash_adv'=>'0','preferred_airline_time'=>'0','multiple_days_car'=>0];
                        $this->pdo->insert('trips', $datat);
                        }
                        else{
                        echo $e->getMessage();
                        $this->setError('File Not uploaded');
                        }
                }
                else{
                        $datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open','manager_approval_report'=>'','manager_approved'=>0,'cash_adv'=>'0','preferred_airline_time'=>'0','multiple_days_car'=>0];
                        $this->pdo->insert('trips', $datat);
                }       # Managerapprovalreport else ends

//	$datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open'];                         
//	$this->pdo->insert('trips', $datat);

	$id = $this->pdo->lastInsertId();

	$c=count($onwardcity);
	for($z = 0; $z <  $c; $z++ )
	{   
//$date=(date('Y-m-d H:i:s', strtotime($date[$z])));
//$late_checkout_date=(date('Y-m-d H:i:s', strtotime($late_checkout_date[$z])));
       //  $late_checkin_date=(date('Y-m-d H:i:s', strtotime($late_checkin_date[$z])));	 
	$airline=$this->getairlines($book_airline[$z]);
	if($book_airline[$z]==0){ $otherair = array_shift($otherairs); }else{ $otherair = 'NULL';}  

	$hotel=$this->gethotel($pref_hotel[$z]);
	if($pref_hotel[$z]==0){ $otherhotel = array_shift($otherhotels);}else{ $otherhotel = 'NULL';}  

$ocity=$this->getcity($onwardcity[$z]);
	if($onwardcity[$z]==0){ $otheronwardcity = array_shift($otheronwardcitys);}else{ $otheronwardcity = 'NULL';}  

$tocity=$this->getcity($travel_to[$z]);
	if($travel_to[$z]==0){ $othertravel_to = array_shift($othertraveltos);}else{ $othertravel_to = 'NULL';}  


	#if(!empty($data['airport_drop_loca'][$z])){ //22Nov2017 SKK
	if(!empty($data['airport_drop_locaoneway'][$z])){
	$airport_pickup[$z] = 'yes';
	//$airport_drop[$z] = '';$data['airport_pickup_loca'][$z]='';
	}
	#else if(!empty($data['airport_pickup_loca'][$z])){//22Nov2017 SKK
	else if(!empty($data['airport_pickup_locaoneway'][$z])){
	$airport_drop[$z] = 'yes';
	//$airport_pickup[$z] = '';$data['airport_drop_loca'][$z]='';
	}
$datadad=['emp_id'=>$this->user_id,'book_airline'=>$book_airline[$z],'travel_from'=>$onwardcity[$z],'travel_to'=>$travel_to[$z],'trip_id'=>$id,'date'=>$date[$z],'return_date'=>$rdate[$z],'pref_hotel'=>$pref_hotel[$z],'car_company'=>$car_company[$z],'airport_drop'=>$airport_drop[$z],'airport_pickup'=>$airport_pickup[$z],'airport_pickup_loca'=>$airport_pickup_loca[$z],'airport_drop_loca'=>$airport_drop_loca[$z],'need_car'=>$need_car[$z],'preferred_airline_time'=>$preferred_airline_time[$z],'car_type'=>$car_type[$z],'car_size'=>$car_size[$z],'late_checkin'=>$late_checkin[$z],'late_checkout'=>$late_checkout[$z],'late_checkin_date'=>$late_checkin_date[$z],'late_checkout_date'=>$late_checkout_date[$z],'car_pickuptime'=>$car_pickuptime[$z],'meal_preference'=>$meal_preference[$z],'otherhotel'=>$otherhotel,'otherair'=>$otherair,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];
	$this->pdo->insert('destination_and_departure', $datadad);	
$destdeptlastInsertId=$this->pdo->lastInsertId(); 
/*****************************************************Oneway Request details for mail body********************************************************************************************/

	$body .="<html><body>";
	$subject .= 'ANSYS Travel Portal: New request';
	$body .= '<b>Visit details</b><br/><br/>';
        $body .= "<b>Purpose Of Visit : </b>".$data['purpose_of_visit'].'<br/>';

        $body .= "<b>Cash Advance Amount : </b>".$data['cash_adv'].'<br/>';
	$body .= "<b>Special Remarks : </b>".$data['special_mention'].'<br/><br/>';
	$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);
	$l=$this->getoffice_locations($row[0]['location']);
        $body .= "<b>Office Location : </b>".$l['location'].'<br/><br/>';
	 $body .= "<b>Phone Number : </b>".$row[0]['contact_no']."<br/><br/>";
        $body .= "<b>Email : </b>".$row[0]['email']."<br/><br/>";
        $body .= "<b>Trip Id : </b>".$id."<br/><br/>";

	$row_trip_details = $this->pdo->select('trips', '`id`=' . $id);
	$manager_approval_report = $row_trip_details[0]['manager_approval_report'];
//echo $manager_approval_report;
//exit;

                if(!empty($manager_approval_report)){
                  $body .= "<b>BU Budget Holder Approval Report : </b><a href='http://".$_SERVER['HTTP_HOST']."/uploads/manager-approval-reports/".$manager_approval_report."' target='_blank'>View</a><br /><br />";
                }

	//$sendername=$row[0]['firstname'].'  '. $row[0]['lastname'];
	### Request ID added in body
	//$request_id = $this->pdo->lastInsertId();
        //$body .= "<b>Request ID : </b>".$destdeptlastInsertId."<br/><br/>";

	$formemail=$row[0]['email'];
	$to=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
	## display the detials
	$airline = $this->getairlines($book_airline[$z]);$cityto=$this->getcity($travel_to[$z]);$city=$this->getcity($onwardcity[$z]);
	$e_ticket=$air_booking['e_ticket'];
	$hotel=$this->gethotel($pref_hotel[$z]);$car=$this->getcars($car_company[$z]);
if(!empty($date[$z])){ $dd= date("F j, Y", strtotime($date[$z])) ; }else{ $dd= " "; }
if(!empty($late_checkin_date[$z])){ $lcd= date("F j, Y", strtotime($late_checkin_date[$z])) ; }else{ $lcd= " "; }
if(!empty($late_checkout_date[$z])){ $lchd= date("F j, Y", strtotime($late_checkout_date[$z])) ; }else{ $lchd= " "; }
   $body .= '<table border="1" width="400">';
	$body .= '<tr><td colspan="2" align="center"><h2>Oneway Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }

	if($otheronwardcity!='NULL'){ $otheronwardcity= $otheronwardcity; }else{ $otheronwardcity= ' '; }
	if($othertravel_to!='NULL'){ $othertravel_to= $othertravel_to; }else{ $othertravel_to= ' '; }
	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[$z].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$city['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$cityto['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Prefered hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[0].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Car Request Id</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop[$z]."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$airport_pickup_loca[$z]."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup[$z]."</td>";
	$body .= "<tr><th align='left'>Drop Location</th><td>".$airport_drop_loca[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[$z]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[$z].'</td></tr>';
	$body .= "<tr><th align='left'>Car Size</th><td>".$car_size[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/>";

                           }
      	$body .="</html></body>";                 
#echo $body;
#exit;
if($_FILES['manager_approval_report']['name']!=''){ //Manager approval report
$flag='Longer Journey Manager Approval';
$subject = 'ANSYS Travel Portal: New booking with manager approval report';		    
}else{
$flag='request';
}
	$requestmail= $this->sendemail($to,$subject,$body,$formemail,$id,$flag);//Send mail Car Request details 

  }   

////Added By Rupali Request booking round                 
 function travelrequestbookinground($data){ //print_r($data);exit;

function filter_callbackround($val) {
    $val = trim($val);
    return $val != '';
}
$onwardcity = @array_values(array_filter($data['onwardcity'], 'filter_callbackround'));
$pref_hotel = @array_values(array_filter($data['pref_hotel'], 'filter_callbackround'));
$car_company = @array_values(array_filter($data['car_company'], 'filter_callbackround'));
$travel_to = @array_values(array_filter($data['travel_to'], 'filter_callbackround'));
$book_airline = @array_values(array_filter($data['book_airline'], 'filter_callbackround'));
$checkintime = @array_values(array_filter($data['checkintime'], 'filter_callbackround'));
$checkouttime = @array_values(array_filter($data['checkouttime'], 'filter_callbackround'));
$checkindate = @array_values(array_filter($data['checkindate'], 'filter_callbackround'));
$checkoutdate = @array_values(array_filter($data['checkoutdate'], 'filter_callbackround'));
$pickup_city = @array_values(array_filter($data['pickup_city'], 'filter_callbackround'));
$date = @array_values(array_filter($data['date'], 'filter_callbackround'));
$rdate = @array_values(array_filter($data['rdate'], 'filter_callbackround'));
$airport_drop_loca = @array_values(array_filter($data['airport_drop_loca'], 'filter_callbackround'));
$airport_pickup_loca = @array_values(array_filter($data['airport_pickup_loca'], 'filter_callbackround'));
$airport_drop = @array_values(array_filter($data['airport_drop'], 'filter_callbackround'));
$airport_pickup = @array_values(array_filter($data['airport_pickup'], 'filter_callbackround'));
$car_type = @array_values(array_filter($data['car_type'], 'filter_callbackround'));
$car_size = @array_values(array_filter($data['car_size'], 'filter_callbackround'));
$late_checkin = @array_values(array_filter($data['late_checkin'], 'filter_callbackround'));
$late_checkout = @array_values(array_filter($data['late_checkout'], 'filter_callbackround'));
$late_checkin_date = @array_values(array_filter($data['late_checkin_date'], 'filter_callbackround'));
$late_checkout_date = @array_values(array_filter($data['late_checkout_date'], 'filter_callbackround'));
$drop_location = @array_values(array_filter($data['drop_location'], 'filter_callbackround'));
$pickup_location = @array_values(array_filter($data['pickup_location'], 'filter_callbackround'));
$pickup_date = @array_values(array_filter($data['pickup_date'], 'filter_callbackround'));
$need_car = @array_values(array_filter($data['need_car'], 'filter_callbackround'));
$preferred_airline_time = @array_values(array_filter($data['preferred_airline_time'], 'filter_callbackround'));
$otherhotels = @array_values(array_filter($data['otherhotel'], 'filter_callbackround'));
$otherairs = @array_values(array_filter($data['otherair'], 'filter_callbackround'));
$otheronwardcitys = @array_values(array_filter($data['otheronwardcity'], 'filter_callbackround'));
$othertravel_tos = @array_values(array_filter($data['othertravel_to'], 'filter_callbackround'));
$car_pickuptime = @array_values(array_filter($data['car_pickuptime'], 'filter_callbackround'));
$meal_preference = @array_values(array_filter($data['meal_preference'], 'filter_callbackround'));
  //********************destination_and_departure instration for round trip Trip*******************************//

###### Code added  on 24 May 2023 to attach Manager Approval Report for longer journey
                //$path = "uploads/";
                //SKK
                $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/manager-approval-reports/";
                if($_FILES['manager_approval_report']['name']!=''){
                        $utime = md5(uniqid(time()));
                        $fname=$this->user_id."_".$utime."_".$_FILES['manager_approval_report']['name'];
                        $report_name=$fname;
                        $allowed_file_types = array('jpeg','jpg','png','pdf');
                        $filecheck = basename($_FILES['manager_approval_report']['name']);
                        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                        //echo $fname;exit;
                        $ftmpname=$_FILES['manager_approval_report']['tmp_name'];
                        //echo $fname;exit;

                        if(move_uploaded_file($ftmpname, $path.$fname)){
/*
      $insert = "INSERT INTO trips
      (`emp_id`,`purpose_of_visit`,`special_mention`,`trip_type`,`date`,`cost`,`status`,`manager_approval_report`,`booking_type`,`manager_approved`,`cash_adv`,`preferred_airline_time`,`multiple_days_car`)
      VALUES(?,?,?,?,NOW(),?,'Open',?,'airline','0','0','0','0')";
        $insert_args = [$this->user_id,$data['purpose_of_visit'],$data['special_mention'],$data['trip_type'],$data['cash_adv'],$report_name];
      try{
      $stmt=$this->pdo->prepare($insert);
      $stmt->execute($insert_args);
      }
      catch(PDOException $e){
        echo $e->getMessage(); exit;
      $this->setError($e->getMessage());
      return false;
      }
*/
 $datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open','manager_approval_report'=>$report_name,'manager_approved'=>'1','cash_adv'=>'0','preferred_airline_time'=>'0','multiple_days_car'=>0];
                        $this->pdo->insert('trips', $datat);
                        }
                        else{
                        echo $e->getMessage();
                        $this->setError('File Not uploaded');
                        }
                }
                else{
                        $datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open','manager_approval_report'=>'','manager_approved'=>0,'cash_adv'=>'0','preferred_airline_time'=>'0','multiple_days_car'=>0];
                        $this->pdo->insert('trips', $datat);
                }       # Managerapprovalreport else ends


////////////////
//		$datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open'];   
//		$this->pdo->insert('trips', $datat);

		$id = $this->pdo->lastInsertId();
$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);$to=$row[0]['email'];
	$formemail=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
	//$sendername=$row[0]['firstname'].'  '. $row[0]['lastname'];
/*	print_r($data);
	print_r($otherairs);
	exit;


	#print_r($data);
	#print_r($otherairs);
	#exit;*/

########## Important lines 
array_pop($airport_pickup);
array_pop($airport_drop);
$airport_pickup0 = $airport_pickup1 = 'no'; 
$airport_drop0 = $airport_drop1 = 'no'; 

/*
	echo "airport drop";print_r($airport_drop);
	echo "<br />";
	print_r($airport_pickup_loca);
	echo "<br />";
	echo "airport pickup";print_r($airport_pickup);
	echo "<br />";
	print_r($airport_drop_loca);
	echo "<hr />";	
*/

/*
	$ocity=$this->getcity($onwardcity[1]);

	if($onwardcity[1]==0){ $otheronwardcity = array_shift($otheronwardcitys);}else{ $otheronwardcity = 'NULL';}  

	$tocity=$this->getcity($travel_to[1]);
	if($travel_to[1]==0){ $othertravel_to = array_shift($othertraveltos);}else{ $othertravel_to = 'NULL';} 

 */


	if($data['otheronwardcity'][0]!='NULL'){ $otheronwardcity= $data['otheronwardcity'][0]; }else{ $otheronwardcity= ' '; }
	if($data['othertravel_to'][0]!='NULL'){ $othertravel_to= $data['othertravel_to'][0]; }else{ $othertravel_to= ' '; }

	$ca=count($car_company);
	$airline=$this->getairlines($data['book_airline'][0]);
	if($data['book_airline'][0]==0){ $otherair = $data['otherair'][0]; }else{ $otherair = 'NULL';}  

	$hotel=$this->gethotel($data['pref_hotel'][0]);
	if($pref_hotel[0]==0){ $otherhotel = $data['otherhotel'][0];}else{ $otherhotel = 'NULL';}  

	if(empty($date[0])){
		$airport_pickup0 = '';
		$airport_drop0= '';
		$a_drop_loca0= '' ;
		$a_pickup_loca0='';	
	}
	else
	{ 
		if($data['airport_drop'][0] == 'yes' ){ $airport_drop0 = 'yes'; $a_pickup_loca0 = array_shift($airport_pickup_loca); }
		if($data['airport_drop'][0] == 'no'){ $airport_drop0 = 'no'; $a_pickup_loca0 = "";}
		if($data['airport_pickup'][0] == 'yes'){ $airport_pickup0 = 'yes'; $a_drop_loca0 = array_shift($airport_drop_loca); }
		if($data['airport_pickup'][0] == 'no'){ $airport_pickup0 = 'no'; $a_drop_loca0 = ''; }

	}

	$airline=$this->getairlines($data['book_airline'][1]);
	if($data['book_airline'][1]==0){ $otherair1 = $data['otherair'][1]; }else{ $otherair1 = 'NULL';}  

	//$hotel=$this->gethotel($pref_hotel[0]);
	//if($pref_hotel[0]==0){ $otherhotel = array_shift($otherhotels);}else{ $otherhotel = 'NULL';}    

	#if(empty($date[0]) || $airport_pickup[0] == 'yes'){
	if($airport_drop[1] == 'yes' ){ $airport_drop1 = 'yes'; $a_pickup_loca1 = array_shift($airport_pickup_loca); }
	if($airport_drop[1] == 'no'){ $airport_drop1 = 'no'; $a_pickup_loca1 = ''; }
	if($airport_pickup[1] == 'yes'){$airport_pickup1 = 'yes'; $a_drop_loca1 = array_shift($airport_drop_loca); }
	if($airport_pickup[1] == 'no'){ $airport_pickup1 = 'no'; $a_drop_loca1 = ''; }
	#}
	#else {
	if($airport_drop[2] == 'yes' ){ $airport_drop1 = 'yes'; $a_pickup_loca1 = array_shift($airport_pickup_loca); }
	if($airport_drop[2] == 'no'){ $airport_drop1 = 'no'; $a_pickup_loca1 = ''; }
	if($airport_pickup[2] == 'yes'){$airport_pickup1 = 'yes'; $a_drop_loca1 = array_shift($airport_drop_loca); }
	if($airport_pickup[2] == 'no'){ $airport_pickup1 = 'no'; $a_drop_loca1 = ''; }
	#}

	//$date=(date('Y-m-d H:i:s', strtotime($date[0])));
	//$late_checkout_date=(date('Y-m-d H:i:s', strtotime($late_checkout_date[0])));
	// $late_checkin_date=(date('Y-m-d H:i:s', strtotime($late_checkin_date[0])));	 
	// $rdate1=(date('Y-m-d H:i:s', strtotime($rdate[1])));	
	// $rdate0=(date('Y-m-d H:i:s', strtotime($rdate[0])));	
if(!empty($late_checkin_date[0])){ $lcd= date("F j, Y", strtotime($late_checkin_date[0])) ; }else{ $lcd= " "; }
if(!empty($late_checkout_date[0])){ $lchd= date("F j, Y", strtotime($late_checkout_date[0])) ; }else{ $lchd= " "; }

if(!empty($date[0])){ $dd= date("F j, Y", strtotime($date[0])) ; }else{ $dd= " "; }
if(!empty($rdate[0])){ $rd= date("F j, Y", strtotime($rdate[0])) ; }else{ $rd= " "; }
$datadad0=['emp_id'=>$this->user_id,'book_airline'=>$data['book_airline'][0],'travel_from'=>$onwardcity[0],'travel_to'=>$travel_to[0],'trip_id'=>$id,'date'=>$date[0],'return_date'=>$rdate[0],'pref_hotel'=>$data['pref_hotel'][0],'car_company'=>$car_company[0],'airport_drop'=>$airport_drop0,'airport_pickup'=>$airport_pickup0,'airport_pickup_loca'=>$a_pickup_loca0,'airport_drop_loca'=>$a_drop_loca0,'need_car'=>$need_car[0],'preferred_airline_time'=>$preferred_airline_time[0],'car_type'=>$car_type[0],'car_size'=>$car_size[0],'late_checkin'=>$late_checkin[0],'late_checkout'=>$late_checkout[0],'late_checkin_date'=>$late_checkin_date[0],'late_checkout_date'=>$late_checkout_date[0],'car_pickuptime'=>$car_pickuptime[0],'meal_preference'=>$meal_preference[0],'otherhotel'=>$otherhotel,'otherair'=>$otherair,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];
	$this->pdo->insert('destination_and_departure', $datadad0);	
$destdeptlastInsertId_one=$this->pdo->lastInsertId(); 

	$datadad=['emp_id'=>$this->user_id,'book_airline'=>$data['book_airline'][1],'travel_from'=>$onwardcity[0],'travel_to'=>$travel_to[0],'trip_id'=>$id,'date'=>$date[0],'return_date'=>$rdate[0],'pref_hotel'=>$data['pref_hotel'][0],'car_company'=>$car_company[1],'airport_drop'=>$airport_drop1,'airport_pickup'=>$airport_pickup1,'airport_pickup_loca'=>$a_pickup_loca1,'airport_drop_loca'=>$a_drop_loca1,'need_car'=>$need_car[1],'preferred_airline_time'=>$preferred_airline_time[1],'car_type'=>$car_type[1],'car_size'=>$car_size[1],'late_checkin'=>$late_checkin[0],'late_checkout'=>$late_checkout[0],'late_checkin_date'=>$late_checkin_date[1],'late_checkout_date'=>$late_checkout_date[1],'car_pickuptime'=>$car_pickuptime[1],'meal_preference'=>$meal_preference[0],'otherhotel'=>$otherhotel,'otherair'=>$otherair1,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];
	$this->pdo->insert('destination_and_departure', $datadad);
$destdeptlastInsertId=$this->pdo->lastInsertId(); 

	$subject .= 'ANSYS Travel Portal: New request';		    
	$body = '<html><body>';


	$body .= '<b>Visit details</b><br/><br/>';
        $body .= "<b>Purpose Of Visit : </b>".$data['purpose_of_visit'].'<br/>';
        $body .= "<b>Cash Advance Amount : </b>".$data['cash_adv'].'<br/><br/>';
	$body .= "<b>Special Remarks : </b>".$data['special_mention'].'<br/><br/>';
$l=$this->getoffice_locations($row[0]['location']);
        $body .= "<b>Office Location : </b>".$l['location'].'<br/><br/>';
  $body .= "<b>Phone Number : </b>".$row[0]['contact_no']."<br/><br/>";
        $body .= "<b>Email : </b>".$row[0]['email']."<br/><br/>";
        $body .= "<b>Trip Id : </b>".$id."<br/><br/>";
	$row_trip_details = $this->pdo->select('trips', '`id`=' . $id);
	$manager_approval_report = $row_trip_details[0]['manager_approval_report'];
//echo $manager_approval_report;
//exit;

                if(!empty($manager_approval_report)){
                  $body .= "<b>BU Budget Holder Approval Report : </b><a href='http://".$_SERVER['HTTP_HOST']."/uploads/manager-approval-reports/".$manager_approval_report."' target='_blank'>View</a><br /><br />";
                }
	### Request ID added in body
	//$request_id = $this->pdo->lastInsertId();
       // $body .= "<b>Request ID Onward Journey: </b>".$destdeptlastInsertId_one."<br/><br/>";
       // $body .= "<b>Request ID Return Journey: </b>".$destdeptlastInsertId."<br/><br/>";


	$body .= '<table border="1" width="400">';
	$airline = $this->getairlines($book_airline[0]);$cityto=$this->getcity($travel_to[0]);$city=$this->getcity($onwardcity[0]);
	$hotel=$this->gethotel($pref_hotel[0]);$car=$this->getcars($car_company[0]);
	$body .= '<tr><td colspan="2" align="center"><h2>Onward Journey Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }
	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[0].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$city['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$cityto['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Return date</th><td>'.$rd.'</td></tr>';
	$body .='<tr><th align="left">Prefered hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[0].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Request ID Onward Journey</th><td>'.$destdeptlastInsertId_one.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop0."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$a_pickup_loca0."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup0."</td>";
	$body .= "<tr><th align='left'> Drop Location</th><td>".$a_drop_loca0."</td></tr>";
	$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[0]."</td></tr>";
	$body .= "<tr><th align='left'>Car Type</th><td>".$car_size[0]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[0].'</td></tr>';
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[0]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[0]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/>";
	

	$body .= '<table border="1" width="400">';
	$airline = $this->getairlines($book_airline[0]);$cityto=$this->getcity($travel_to[0]);$city=$this->getcity($onwardcity[0]);
	$hotel=$this->gethotel($pref_hotel[0]);$car=$this->getcars($car_company[0]);
	$body .= '<tr><td colspan="2" align="center"><h2>Return Journey Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }

	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[1].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$cityto['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$city['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Return date</th><td>'.$rd.'</td></tr>';
	$body .='<tr><th align="left">Prefered hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[0].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Request ID Return Journey</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop1."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$a_pickup_loca1."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup1."</td>";
	$body .= "<tr><th align='left'>Drop Location</th><td>".$a_drop_loca1."</td></tr>";
	#$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[1]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[1].'</td></tr>';
	$body .= "<tr><th align='left'>Car Type</th><td>".$car_size[1]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[0]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[0]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/></html></body>";
 

#echo $body;
#exit;
if($_FILES['manager_approval_report']['name']!=''){ //Manager approval report
$flag='Longer Journey Manager Approval';
$subject = 'ANSYS Travel Portal: New booking with manager approval report';		    
}else{
$flag='request';
}
	$requestmail= $this->sendemail($to,$subject,$body,$formemail,$id,$flag);//Send mail Car Request details 

 }


function travelrequestbookingmulticity($data){ 
#000;
#print_r($data);

################
array_shift($data['airport_dropmulti']); 
array_shift($data['airport_pickupmulti']);
############


#echo "<hr />";
//exit;
	function filter_callbackmulticity($val) {
    		$val = trim($val);
    		return $val != '';
	}
$onwardcity = @array_values(array_filter($data['onwardcitymulti'], 'filter_callbackmulticity'));
$pref_hotel = @array_values(array_filter($data['pref_hotelmulti'], 'filter_callbackmulticity'));
$car_company = @array_values(array_filter($data['car_companymulti'], 'filter_callbackmulticity'));
$travel_to = @array_values(array_filter($data['travel_tomulti'], 'filter_callbackmulticity'));
$book_airline = @array_values(array_filter($data['book_airlinemulti'], 'filter_callbackmulticity'));
$checkintime = @array_values(array_filter($data['checkintimemulti'], 'filter_callbackmulticity'));
$checkouttime = @array_values(array_filter($data['checkouttimemulti'], 'filter_callbackmulticity'));
$checkindate = @array_values(array_filter($data['checkindatemulti'], 'filter_callbackmulticity'));
$checkoutdate = @array_values(array_filter($data['checkoutdatemulti'], 'filter_callbackmulticity'));
$pickup_city = @array_values(array_filter($data['pickup_citymulti'], 'filter_callbackmulticity'));
$date = @array_values(array_filter($data['datemulti'], 'filter_callbackmulticity'));
$rdate = @array_values(array_filter($data['rdatemulti'], 'filter_callbackmulticity'));
$airport_drop_loca = @array_values(array_filter($data['airport_drop_locamulti'], 'filter_callbackmulticity'));
$airport_pickup_loca = @array_values(array_filter($data['airport_pickup_locamulti'], 'filter_callbackmulticity'));
$airport_drop = @array_values(array_filter($data['airport_dropmulti'], 'filter_callbackmulticity'));
$airport_pickup = @array_values(array_filter($data['airport_pickupmulti'], 'filter_callbackmulticity'));
$car_type = @array_values(array_filter($data['car_typemulti'], 'filter_callbackmulticity'));
$car_size = @array_values(array_filter($data['car_sizemulti'], 'filter_callbackmulticity'));
$late_checkin = @array_values(array_filter($data['late_checkinmulti'], 'filter_callbackmulticity'));
$late_checkout = @array_values(array_filter($data['late_checkoutmulti'], 'filter_callbackmulticity'));
$late_checkin_date = @array_values(array_filter($data['late_checkin_datemulti'], 'filter_callbackmulticity'));
$late_checkout_date = @array_values(array_filter($data['late_checkout_datemulti'], 'filter_callbackmulticity'));
$drop_location = @array_values(array_filter($data['drop_locationmulti'], 'filter_callbackmulticity'));
$pickup_location = @array_values(array_filter($data['pickup_location'], 'filter_callbackmulticity'));
$pickup_date = @array_values(array_filter($data['pickup_datemulti'], 'filter_callbackmulticity'));
$need_car = @array_values(array_filter($data['need_carmulti'], 'filter_callbackmulticity'));
$preferred_airline_time = @array_values(array_filter($data['preferred_airline_timemulti'], 'filter_callbackmulticity'));
$otherhotels = @array_values(array_filter($data['otherhotelmulti'], 'filter_callbackmulticity'));
$otheronwardcitys = @array_values(array_filter($data['otheronwardcitymulti'], 'filter_callbackmulticity'));
$othertraveltos = @array_values(array_filter($data['othertravel_tomulti'], 'filter_callbackmulticity'));

$otherairs = @array_values(array_filter($data['otherairmulti'], 'filter_callbackmulticity'));
$car_pickuptime = @array_values(array_filter($data['car_pickuptimemulti'], 'filter_callbackmulticity'));
$meal_preference = @array_values(array_filter($data['meal_preferencemulti'], 'filter_callbackmulticity'));
//print_r($otheronwardcitys);
//print_r($othertraveltos);
//print_r($data['otherhotelmulti']);
//print_r($onwardcity);exit;

###### Code added  on 24 May 2023 to attach Manager Approval Report for longer journey
                //$path = "uploads/";
                //SKK
                $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/manager-approval-reports/";
                if($_FILES['manager_approval_report']['name']!=''){
                        $utime = md5(uniqid(time()));
                        $fname=$this->user_id."_".$utime."_".$_FILES['manager_approval_report']['name'];
                        $report_name=$fname;
                        $allowed_file_types = array('jpeg','jpg','png','pdf');
                        $filecheck = basename($_FILES['manager_approval_report']['name']);
                        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                        //echo $fname;exit;
                        $ftmpname=$_FILES['manager_approval_report']['tmp_name'];
                        //echo $fname;exit;

                        if(move_uploaded_file($ftmpname, $path.$fname)){
/*
      $insert = "INSERT INTO trips
      (`emp_id`,`purpose_of_visit`,`special_mention`,`trip_type`,`date`,`cost`,`status`,`manager_approval_report`,`booking_type`,`manager_approved`,`cash_adv`,`preferred_airline_time`,`multiple_days_car`)
      VALUES(?,?,?,?,NOW(),?,'Open',?,'airline','0','0','0','0')";
        $insert_args = [$this->user_id,$data['purpose_of_visit'],$data['special_mention'],$data['trip_type'],$data['cash_adv'],$report_name];
      try{
      $stmt=$this->pdo->prepare($insert);
      $stmt->execute($insert_args);
      }
      catch(PDOException $e){
        echo $e->getMessage(); exit;
      $this->setError($e->getMessage());
      return false;
      }
*/
 $datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open','manager_approval_report'=>$report_name,'manager_approved'=>'1','cash_adv'=>'0','preferred_airline_time'=>'0','multiple_days_car'=>0];
                        $this->pdo->insert('trips', $datat);
                        }
                        else{
                        echo $e->getMessage();
                        $this->setError('File Not uploaded');
                        }
                }
                else{
                        $datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open','manager_approval_report'=>'','manager_approved'=>0,'cash_adv'=>'0','preferred_airline_time'=>'0','multiple_days_car'=>0];
                        $this->pdo->insert('trips', $datat);
                }       # Managerapprovalreport else ends



///////////////////////
//	$datat=['emp_id'=>$this->user_id,'date'=>date('Y-m-d'),'booking_type'=>'airline','purpose_of_visit'=>$data['purpose_of_visit'] ,'special_mention'=>$data['special_mention'],'trip_type'=>$data['trip_type'],'cost'=>$data['cash_adv'],'status'=>'Open']; 
//	$this->pdo->insert('trips', $datat);

	$id = $this->pdo->lastInsertId();
	$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);$to=$row[0]['email'];
	$formemail=$row[0]['email'];
	$passenger=$row[0]['firstname'].'  '. $row[0]['lastname'];
	$subject .= 'ANSYS Travel Portal: New request';
	$body .="<html><body>";

	$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);

	//$sendername=$row[0]['firstname'].'  '. $row[0]['lastname'];
	$body .= '<b>Visit details</b><br/><br/>';
        $body .= "<b>Purpose Of Visit : </b>".$data['purpose_of_visit'].'<br/>';
        $body .= "<b>Cash Advance Amount : </b>".$data['cash_adv'].'<br/>';
	$body .= "<b>Special Remarks : </b>".$data['special_mention'].'<br/><br/>';
	$to=$row[0]['email'];	$formemail=$row[0]['email'];
	$l=$this->getoffice_locations($row[0]['location']);
        $body .= "<b>Office Location : </b>".$l['location'].'<br/><br/>';
	$body .= "<b>Phone Number : </b>".$row[0]['contact_no']."<br/><br/>";
        $body .= "<b>Email : </b>".$row[0]['email']."<br/><br/>";
        $body .= "<b>Trip Id : </b>".$id."<br/><br/>";
	$row_trip_details = $this->pdo->select('trips', '`id`=' . $id);
	$manager_approval_report = $row_trip_details[0]['manager_approval_report'];
//echo $manager_approval_report;
//exit;

                if(!empty($manager_approval_report)){
                  $body .= "<b>BU Budget Holder Approval Report : </b><a href='http://".$_SERVER['HTTP_HOST']."/uploads/manager-approval-reports/".$manager_approval_report."' target='_blank'>View</a><br /><br />";
                }

	//********************destination_and_departure instration for multicity Trip*******************************//

	$drop_multi_count = count($data['airport_dropmulti']);
	$pickup_multi_count = count($data['airport_pickupmulti']);

	if($drop_multi_count > $pickup_multi_count){
		$need_pickup = $drop_multi_count - $pickup_multi_count;
		for($i=0;$i< $need_pickup;$i++){
		array_push($data['airport_pickupmulti'],'no');	
		array_push($airport_pickup,'no');	
		}
	//print_r($data['airport_pickupmulti']);
	//exit;
	}
	else if ($pickup_multi_count > $drop_multi_count){
		$need_drop = $pickup_multi_count - $drop_multi_count;
		for($i=0;$i< $need_drop;$i++){
		array_push($data['airport_dropmulti'],'no');	
		array_push($airport_drop,'no');	
		}
	//print_r($data['airport_dropmulti']);
	//exit;
	}
/*
echo "<br />";
	echo "Airport Drop ";print_r($data['airport_dropmulti']);
echo "<br />";
	echo "Airport Pickup ";print_r($data['airport_pickupmulti']);
echo "<br />";
*/

$temp_z = 0;

	 $c=count($onwardcity);
	for($z=0; $z < $c*2; $z++)  
	{
#echo "<hr />z=".$z;

$otherhotel = '';
$otheronwardcity = '';
$othertravel_to = '';
$otherair = '';

          #if(!empty($onwardcity[$z])){
	$ocity=$this->getcity($onwardcity[$z]);
	if($onwardcity[$z]==='0'){ $otheronwardcity = array_shift($otheronwardcitys);}else{ $otheronwardcity = 'NULL';}  

	#if(($onwardcity[$z]==='0' && $onwardcity[$z-1] == 'No Booking') || ($data['airport_dropmulti'][$z-1] == 'no' && $data['airport_pickupmulti'][$z-1] == 'no')){ $otheronwardcity = array_shift($otheronwardcitys);}else{ $otheronwardcity = 'NULL';}  

	$tocity=$this->getcity($travel_to[$z]);
	if($travel_to[$z]==='0'){ $othertravel_to = array_shift($othertraveltos);}else{ $othertravel_to = 'NULL';}  

	#if(($travel_to[$z]==='0' && $travel_to[$z-1] == 'No Booking') || ($data['airport_dropmulti'][$z-1] == 'no' && $data['airport_pickupmulti'][$z-1] == 'no')){ $othertravel_to = array_shift($othertraveltos);}else{ $othertravel_to = 'NULL';}  

	$airline=$this->getairlines($book_airline[$z]);//echo $data['otherair'][$xx]."<br/>";
	if($book_airline[$z]==='0'){ $otherair = array_shift($otherairs); }else{ $otherair = 'NULL';}  

	#if(($book_airline[$z]==='0' && $book_airline[$z-1] == 'No Booking') || ($data['airport_dropmulti'][$z-1] == 'no' && $data['airport_pickupmulti'][$z-1] == 'no')){ $otherair = array_shift($otherairs); }else{ $otherair = 'NULL';}  


	$hotel=$this->gethotel($pref_hotel[$z]);//echo $data['otherhotel'][$xx]."<br/>";
	if($pref_hotel[$z]==='0'){ $otherhotel = array_shift($otherhotels);}else{ $otherhotel = 'NULL';}

	#if($pref_hotel[$z]==='0' && $pref_hotel[$z-1] == 'No Booking'){ echo "Harry"; $otherhotel = array_shift($otherhotels);}else{ $otherhotel = 'NULL';}
	#if(($pref_hotel[$z]==='0' && $pref_hotel[$z-1] == 'No Booking') || ($data['airport_dropmulti'][$z-1] == 'no' && $data['airport_pickupmulti'][$z-1] == 'no')){ echo "Harry"; $otherhotel = array_shift($otherhotels);}else{ $otherhotel = 'NULL';}
	#if((($pref_hotel[$z]==='0' && $pref_hotel[$z-1] == 'No Booking') || ($data['airport_dropmulti'][$z-1] == 'no' && $data['airport_pickupmulti'][$z-1] == 'no')) && !empty($otherhotels)){ echo "Harry1"; $otherhotel = array_shift($otherhotels);}
	#else if((($pref_hotel[$z]==='0' && $pref_hotel[$z-1] == 'No Booking') || ($data['airport_dropmulti'][$z] == 'no' && $data['airport_pickupmulti'][$z] == 'no')) && !empty($otherhotels)){ echo "Harry2"; $otherhotel = array_shift($otherhotels);}elseif($pref_hotel[$z]==='0'){ $otherhotel = 'NULL';}

/*
echo "<br />";
print_r($pref_hotel);
echo "<br />";
echo "pref hotel: ".$pref_hotel[$z]."<br />";
echo "pref hotel z-1: ".$pref_hotel[$z-1];
echo "<br />Other Hotels Array: ";
print_r($otherhotels);
echo "<br />";
echo "other hotel:". $otherhotel." z= ".$z."<br />";
echo "<br />";
echo $book_ailine[$z];
echo "<br />";
print_r($otherairs);
echo "<br />";
echo "other air:". $otherair." z= ".$z."<br />";
*/

$empty_value = array( 'No Booking' );
//echo $othertravel_to;
//echo $otheronwardcity;

	if($data['airport_dropmulti'][$z] == 'yes' && $data['airport_pickupmulti'][$z] == 'yes'){
#echo "111";
#echo "<br />";
#print_r($onwardcity);
#echo $onwardcity[$z];
#echo "<br />Yes  Yes ".$z."<br />";
#print_r($pref_hotel);
#print_r($otherhotels);
#echo "Other Hotel: ".$otherhotel;
#echo "<br />";
#echo "Airport Drop:".$airport_drop[$z];
#echo "<br />";
#echo "Airport Pickup:".$airport_pickup[$z];
#echo "<br />";

#print_r($data);
#echo "<hr />";
#exit;


	$datadad=['emp_id'=>$this->user_id,'book_airline'=>$book_airline[$z],'travel_from'=>$onwardcity[$z],'travel_to'=>$travel_to[$z],'trip_id'=>$id,'date'=>$date[$z],'rdate'=>$rdate[$z],'pref_hotel'=>$pref_hotel[$z],'car_company'=>$car_company[$z],'airport_drop'=>$airport_drop[$z],'airport_pickup'=>$airport_pickup[$z],'airport_pickup_loca'=>$airport_pickup_loca[$z],'airport_drop_loca'=>$airport_drop_loca[$z],'need_car'=>$need_car[$z],'preferred_airline_time'=>$preferred_airline_time[$z],'car_type'=>$car_type[$z],'car_size'=>$car_size[$z],'late_checkin'=>$late_checkin[$z],'late_checkout'=>$late_checkout[$z],'late_checkin_date'=>$late_checkin_date[$z],'late_checkout_date'=>$late_checkout_date[$z],'car_pickuptime'=>$car_pickuptime[$z],'meal_preference'=>$meal_preference[$z],'otherhotel'=>$otherhotel,'otherair'=>$otherair,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];

#print_r($datadad);
#echo "<hr />";

	$this->pdo->insert('destination_and_departure', $datadad);
$destdeptlastInsertId=$this->pdo->lastInsertId(); 	
	if($airport_drop_loca[$z+1] != 'No Booking' && empty($airport_drop_loca[$z+1]))@array_splice($airport_drop_loca,$z+1,0,$empty_value);
	if($airport_pickup_loca[$z+1] != 'No Booking' && empty($airport_pickup_loca[$z+1]))@array_splice($airport_pickup_loca,$z+1,0,$empty_value);
	if($book_airline[$z+1] != 'No Booking' && isset($book_airline[$z+1]))@array_splice($book_airline,$z+1,0,$empty_value);
	if($onwardcity[$z+1] != 'No Booking' && isset($onwardcity[$z+1]))@array_splice($onwardcity,$z+1,0,$empty_value);
	if($travel_to[$z+1] != 'No Booking' && isset($travel_to[$z+1]))@array_splice($travel_to,$z+1,0,$empty_value);
	if($date[$z+1] != 'No Booking' && !empty($date[$z+1]))@array_splice($date,$z+1,0,$empty_value);
	if($rdate[$z+1] != 'No Booking' && !empty($rdate[$z+1]))@array_splice($rdate,$z+1,0,$empty_value);
	if($pref_hotel[$z+1] != 'No Booking' && isset($pref_hotel[$z+1]))@array_splice($pref_hotel,$z+1,0,$empty_value);
	if($car_company[$z+1] != 'No Booking' && !empty($car_company[$z+1]))@array_splice($car_company,$z+1,0,$empty_value);
	if($need_car[$z+1] != 'No Booking' && !empty($need_car[$z+1]))@array_splice($need_car,$z+1,0,$empty_value);
	if($preferred_airline_time[$z+1] != 'No Booking' && !empty($preferred_airline_time[$z+1]))@array_splice($preferred_airline_time,$z+1,0,$empty_value);
	if($car_type[$z+1] != 'No Booking' && !empty($car_type[$z+1]))@array_splice($car_type,$z+1,0,$empty_value);
	if($car_size[$z+1] != 'No Booking' && !empty($car_size[$z+1]))@array_splice($car_size,$z+1,0,$empty_value);
	if($late_checkin[$z+1] != 'No Booking' && !empty($late_checkin[$z+1]))@array_splice($late_checkin,$z+1,0,$empty_value);
	if($late_checkout[$z+1] != 'No Booking' && !empty($late_checkout[$z+1]))@array_splice($late_checkout,$z+1,0,$empty_value);
	if($late_checkin_date[$z+1] != 'No Booking' && !empty($late_checkin_date[$z+1]))@array_splice($late_checkin_date,$z+1,0,$empty_value);
	if($late_checkout_date[$z+1] != 'No Booking' && !empty($late_checkout_date[$z+1]))@array_splice($late_checkout_date,$z+1,0,$empty_value);
	if($car_pickuptime[$z+1] != 'No Booking' && !empty($car_pickuptime[$z+1]))@array_splice($car_pickuptime,$z+1,0,$empty_value);
	if($meal_preference[$z+1] != 'No Booking' && !empty($meal_preference[$z+1]))@array_splice($meal_preference,$z+1,0,$empty_value);

/*****************************************************Multi City Request details for mail body********************************************************************************************/
		### Request ID added in body
	//$request_id = $this->pdo->lastInsertId();
        //$body .= "<b>Request ID : </b>".$destdeptlastInsertId."<br/><br/>";

	## display the detials
	$airline = $this->getairlines($book_airline[$z]);$cityto=$this->getcity($travel_to[$z]);$city=$this->getcity($onwardcity[$z]);
	$e_ticket=$air_booking['e_ticket'];
	$hotel=$this->gethotel($pref_hotel[$z]);$car=$this->getcars($car_company[$z]);
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }
	if($otheronwardcity!='NULL'){ $otheronwardcity= $otheronwardcity; }else{ $otheronwardcity= ' '; }
	if($othertravel_to!='NULL'){ $othertravel_to= $othertravel_to; }else{ $othertravel_to= ' '; }
	if(!empty($date[$z])){ $dd= date("F j, Y", strtotime($date[$z])) ; }else{ $dd= " "; }
	if(!empty($late_checkin_date[$z])){ $lcd= date("F j, Y", strtotime($late_checkin_date[$z])) ; }else{ $lcd= " "; }
	if(!empty($late_checkout_date[$z])){ $lchd= date("F j, Y", strtotime($late_checkout_date[$z])) ; }else{ $lchd= " "; }

        $body .= '<table border="1" width="400">';
	$body .= '<tr><td colspan="2" align="center"><h2>Multi City Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th  align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[$z].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$city['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$cityto['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Preferred hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[$z].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Car Request Id</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop[$z]."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$airport_pickup_loca[$z]."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup[$z]."</td>";
	$body .= "<tr><th align='left'>Drop Location</th><td>".$airport_drop_loca[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[$z]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[$z].'</td></tr>';
	$body .= "<tr><th align='left'>Car Size</th><td>".$car_size[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/></html></body>";
	//print_r($data['airport_dropmulti']);
	//print_r($data['airport_pickupmulti']);
	//print_r($airport_pickup_loca);
	//print_r($airport_drop_loca);
	//echo "<br />";
	//exit;

	}
	else if($data['airport_dropmulti'][$z] == 'yes' && $data['airport_pickupmulti'][$z] == 'no'){
	#echo "222";
	#echo "<br />";
/*
	print_r($data);
	echo "<hr />Yes  no".$z."<br /><br />SKK123";
	print_r($airport_pickup);
	echo "<br />";
	print_r($airport_drop);
	echo "<br />";
	print_r($onwardcity);
	echo "<br />";
	print_r($travel_to);
	echo "<br />";
	print_r($date);
	echo "<br />";
	print_r($rdate);
echo "<br />";
print_r($pref_hotel);
echo "<br />";
*/
	@array_splice($data['airport_pickupmulti'],$z+1,0,'no');	##Added 'no' to the next z+1 for Yes No pair.
	@array_splice($airport_pickup,$z+1,0,'no');	##Added 'no' to the next z+1 for Yes No pair.

/*
echo "<br />Airport Drop Multi: ";
	print_r($data['airport_dropmulti']);
echo "<br />Airport Pickup Multi: ";
	print_r($data['airport_pickupmulti']);
echo "<br />";
*/

	array_unshift($airport_drop_loca,"No Booking");
	$airport_drop_loca[$z] = "No Booking";

	$datadad=['emp_id'=>$this->user_id,'book_airline'=>$book_airline[$z],'travel_from'=>$onwardcity[$z],'travel_to'=>$travel_to[$z],'trip_id'=>$id,'date'=>$date[$z],'rdate'=>$rdate[$z],'pref_hotel'=>$pref_hotel[$z],'car_company'=>$car_company[$z],'airport_drop'=>$airport_drop[$z],'airport_pickup'=>$airport_pickup[$z],'airport_pickup_loca'=>$airport_pickup_loca[$z],'airport_drop_loca'=>$airport_drop_loca[$z],'need_car'=>$need_car[$z],'preferred_airline_time'=>$preferred_airline_time[$z],'car_type'=>$car_type[$z],'car_size'=>$car_size[$z],'late_checkin'=>$late_checkin[$z],'late_checkout'=>$late_checkout[$z],'late_checkin_date'=>$late_checkin_date[$z],'late_checkout_date'=>$late_checkout_date[$z],'car_pickuptime'=>$car_pickuptime[$z],'meal_preference'=>$meal_preference[$z],'otherhotel'=>$otherhotel,'otherair'=>$otherair,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];

	$this->pdo->insert('destination_and_departure', $datadad);	
	$destdeptlastInsertId=$this->pdo->lastInsertId(); 
	if($airport_pickup_loca[$z+1] != 'No Booking' && !empty($airport_pickup_loca[$z+1]))@array_splice($airport_pickup_loca,$z+1,0,$empty_value);
	if($book_airline[$z+1] != 'No Booking' && isset($book_airline[$z+1]))@array_splice($book_airline,$z+1,0,$empty_value);
	if($onwardcity[$z+1] != 'No Booking' && isset($onwardcity[$z+1]))@array_splice($onwardcity,$z+1,0,$empty_value);
	if($travel_to[$z+1] != 'No Booking' && isset($travel_to[$z+1]))@array_splice($travel_to,$z+1,0,$empty_value);
	if($date[$z+1] != 'No Booking' && !empty($date[$z+1]))@array_splice($date,$z+1,0,$empty_value);
	if($rdate[$z+1] != 'No Booking' && !empty($rdate[$z+1]))@array_splice($rdate,$z+1,0,$empty_value);
	#if($pref_hotel[$z+1] != 'No Booking' && !empty($pref_hotel[$z+1]))@array_splice($pref_hotel,$z+1,0,$empty_value);
	if($pref_hotel[$z+1] != 'No Booking' && isset($pref_hotel[$z+1]))@array_splice($pref_hotel,$z+1,0,$empty_value);
/*
echo "<br />";
print_r($pref_hotel);
echo "<br />";
*/
	if($car_company[$z+1] != 'No Booking' && !empty($car_company[$z+1]))@array_splice($car_company,$z+1,0,$empty_value);
	if($need_car[$z+1] != 'No Booking' && !empty($need_car[$z+1]))@array_splice($need_car,$z+1,0,$empty_value);
	if($preferred_airline_time[$z+1] != 'No Booking' && !empty($preferred_airline_time[$z+1]))@array_splice($preferred_airline_time,$z+1,0,$empty_value);
	if($car_type[$z+1] != 'No Booking' && !empty($car_type[$z+1]))@array_splice($car_type,$z+1,0,$empty_value);
	if($car_size[$z+1] != 'No Booking' && !empty($car_size[$z+1]))@array_splice($car_size,$z+1,0,$empty_value);
	if($late_checkin[$z+1] != 'No Booking' && !empty($late_checkin[$z+1]))@array_splice($late_checkin,$z+1,0,$empty_value);
	if($late_checkout[$z+1] != 'No Booking' && !empty($late_checkout[$z+1]))@array_splice($late_checkout,$z+1,0,$empty_value);
	if($late_checkin_date[$z+1] != 'No Booking' && !empty($late_checkin_date[$z+1]))@array_splice($late_checkin_date,$z+1,0,$empty_value);
	if($late_checkout_date[$z+1] != 'No Booking' && !empty($late_checkout_date[$z+1]))@array_splice($late_checkout_date,$z+1,0,$empty_value);
	if($car_pickuptime[$z+1] != 'No Booking' && !empty($car_pickuptime[$z+1]))@array_splice($car_pickuptime,$z+1,0,$empty_value);
	if($meal_preference[$z+1] != 'No Booking' && !empty($meal_preference[$z+1]))@array_splice($meal_preference,$z+1,0,$empty_value);
/*****************************************************Multicity Request details for mail body********************************************************************************************/
		### Request ID added in body
	//$request_id = $this->pdo->lastInsertId();
       // $body .= "<b>Request ID : </b>".$destdeptlastInsertId."<br/><br/>";
	## display the detials
	$airline = $this->getairlines($book_airline[$z]);$cityto=$this->getcity($travel_to[$z]);$city=$this->getcity($onwardcity[$z]);
	$e_ticket=$air_booking['e_ticket'];
	$hotel=$this->gethotel($pref_hotel[$z]);$car=$this->getcars($car_company[$z]);
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }
if($otheronwardcity!='NULL'){ $otheronwardcity= $otheronwardcity; }else{ $otheronwardcity= ' '; }
	if($othertravel_to!='NULL'){ $othertravel_to= $othertravel_to; }else{ $othertravel_to= ' '; }
if(!empty($date[$z])){ $dd= date("F j, Y", strtotime($date[$z])) ; }else{ $dd= " "; }
if(!empty($late_checkin_date[$z])){ $lcd= date("F j, Y", strtotime($late_checkin_date[$z])) ; }else{ $lcd= " "; }
if(!empty($late_checkout_date[$z])){ $lchd= date("F j, Y", strtotime($late_checkout_date[$z])) ; }else{ $lchd= " "; }

        $body .= '<table border="1" width="400">';
	$body .= '<tr><td colspan="2" align="center"><h2>Multi City Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th  align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[$z].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$city['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$cityto['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Preferred hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[$z].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Car Request Id</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop[$z]."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$airport_pickup_loca[$z]."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup[$z]."</td>";
	$body .= "<tr><th align='left'>Drop Location</th><td>".$airport_drop_loca[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[$z]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[$z].'</td></tr>';
	$body .= "<tr><th align='left'>Car Size</th><td>".$car_size[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/></html></body>";
	//print_r($airport_pickup_loca);
	//print_r($airport_drop_loca);
	//echo "<br />";
#echo "<hr />";
#print_r($book_airline);
#echo "<br />";
#print_r($onwardcity);
#exit;
	}
	else if($data['airport_dropmulti'][$z] == 'no' && $data['airport_pickupmulti'][$z] == 'yes'){
	#echo "333";
	#echo "<br />no  Yes".$z."<br />";
	#print_r($data);
	#exit;


	@array_splice($data['airport_dropmulti'],$z+1,0,'no');	##Added 'no' to the next z+1 for No Yes pair.
	@array_splice($airport_drop,$z+1,0,'no');	##Added 'no' to the next z+1 for No Yes pair.

	array_unshift($airport_pickup_loca,"No Booking");
	$airport_pickup_loca[$z] = "No Booking";

	#if($onwardcity[$z]==0){ $onwardcity[$z] = $otheronwardcity;}  
	#if($travel_to[$z]==0){ $travel_to[$z] = $othertravel_to;}  

	$datadad=['emp_id'=>$this->user_id,'book_airline'=>$book_airline[$z],'travel_from'=>$onwardcity[$z],'travel_to'=>$travel_to[$z],'trip_id'=>$id,'date'=>$date[$z],'rdate'=>$rdate[$z],'pref_hotel'=>$pref_hotel[$z],'car_company'=>$car_company[$z],'airport_drop'=>$airport_drop[$z],'airport_pickup'=>$airport_pickup[$z],'airport_pickup_loca'=>$airport_pickup_loca[$z],'airport_drop_loca'=>$airport_drop_loca[$z],'need_car'=>$need_car[$z],'preferred_airline_time'=>$preferred_airline_time[$z],'car_type'=>$car_type[$z],'car_size'=>$car_size[$z],'late_checkin'=>$late_checkin[$z],'late_checkout'=>$late_checkout[$z],'late_checkin_date'=>$late_checkin_date[$z],'late_checkout_date'=>$late_checkout_date[$z],'car_pickuptime'=>$car_pickuptime[$z],'meal_preference'=>$meal_preference[$z],'otherhotel'=>$otherhotel,'otherair'=>$otherair,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];

#echo "<hr />";
#print_r($datadad);
#exit;
#print_r($onwardcity);
	$this->pdo->insert('destination_and_departure', $datadad);
$destdeptlastInsertId=$this->pdo->lastInsertId(); 	

/*
print_r($pref_hotel);
echo "<br />";
print_r($onwardcity);
echo "<br />";
*/


	if($airport_drop_loca[$z+1] != 'No Booking' && !empty($airport_drop_loca[$z+1]))@array_splice($airport_drop_loca,$z+1,0,$empty_value);
	if($book_airline[$z+1] != 'No Booking' && isset($book_airline[$z+1]))@array_splice($book_airline,$z+1,0,$empty_value);
	if($onwardcity[$z+1] != 'No Booking' && isset($onwardcity[$z+1]))@array_splice($onwardcity,$z+1,0,$empty_value);
	if($travel_to[$z+1] != 'No Booking' && isset($travel_to[$z+1]))@array_splice($travel_to,$z+1,0,$empty_value);
	if($date[$z+1] != 'No Booking' && !empty($date[$z+1]))@array_splice($date,$z+1,0,$empty_value);
	if($rdate[$z+1] != 'No Booking' && !empty($rdate[$z+1]))@array_splice($rdate,$z+1,0,$empty_value);
	if($pref_hotel[$z+1] != 'No Booking' && isset($pref_hotel[$z+1]))@array_splice($pref_hotel,$z+1,0,$empty_value);

	#if($pref_hotel[$z+1] != 'No Booking' && !empty($pref_hotel[$z+1]) && empty($data['otherhotelmulti'][$z]) && $data['airport_dropmulti'][$z] != 'no' && $data['airport_pickupmulti'][$z] != 'no')@array_splice($pref_hotel,$z+1,0,$empty_value);

/*
echo "<br /> No Yes Pref Hotel";
print_r($pref_hotel);
echo "<br />";
print_r($onwardcity);
echo "<br />";
echo "Drop Multi: ".$data['airport_dropupmulti'][$z];
echo "<br />";
echo "Pickup Multi: ".$data['airport_pickupmulti'][$z];
echo "<br />";
echo $data['otherhotelmulti'][$z];
echo "<br />";
*/
	if($car_company[$z+1] != 'No Booking' && !empty($car_company[$z+1]))@array_splice($car_company,$z+1,0,$empty_value);
	if($need_car[$z+1] != 'No Booking' && !empty($need_car[$z+1]))@array_splice($need_car,$z+1,0,$empty_value);
	if($preferred_airline_time[$z+1] != 'No Booking' && !empty($preferred_airline_time[$z+1]))@array_splice($preferred_airline_time,$z+1,0,$empty_value);
	if($car_type[$z+1] != 'No Booking' && !empty($car_type[$z+1]))@array_splice($car_type,$z+1,0,$empty_value);
	if($car_size[$z+1] != 'No Booking' && !empty($car_size[$z+1]))@array_splice($car_size,$z+1,0,$empty_value);
	if($late_checkin[$z+1] != 'No Booking' && !empty($late_checkin[$z+1]))@array_splice($late_checkin,$z+1,0,$empty_value);
	if($late_checkout[$z+1] != 'No Booking' && !empty($late_checkout[$z+1]))@array_splice($late_checkout,$z+1,0,$empty_value);
	if($late_checkin_date[$z+1] != 'No Booking' && !empty($late_checkin_date[$z+1]))@array_splice($late_checkin_date,$z+1,0,$empty_value);
	if($late_checkout_date[$z+1] != 'No Booking' && !empty($late_checkout_date[$z+1]))@array_splice($late_checkout_date,$z+1,0,$empty_value);
	if($car_pickuptime[$z+1] != 'No Booking' && !empty($car_pickuptime[$z+1]))@array_splice($car_pickuptime,$z+1,0,$empty_value);
	if($meal_preference[$z+1] != 'No Booking' && !empty($meal_preference[$z+1]))@array_splice($meal_preference,$z+1,0,$empty_value);
/*****************************************************Multicity Request details for mail body********************************************************************************************/

	### Request ID added in body
	//$request_id = $this->pdo->lastInsertId();
        $body .= "<b>Request ID : </b>".$destdeptlastInsertId."<br/><br/>";
	## display the detials
	$airline = $this->getairlines($book_airline[$z]);$cityto=$this->getcity($travel_to[$z]);$city=$this->getcity($onwardcity[$z]);
	$e_ticket=$air_booking['e_ticket'];
	$hotel=$this->gethotel($pref_hotel[$z]);$car=$this->getcars($car_company[$z]);
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }
if($otheronwardcity!='NULL'){ $otheronwardcity= $otheronwardcity; }else{ $otheronwardcity= ' '; }
	if($othertravel_to!='NULL'){ $othertravel_to= $othertravel_to; }else{ $othertravel_to= ' '; }
if(!empty($date[$z])){ $dd= date("F j, Y", strtotime($date[$z])) ; }else{ $dd= " "; }
if(!empty($late_checkin_date[$z])){ $lcd= date("F j, Y", strtotime($late_checkin_date[$z])) ; }else{ $lcd= " "; }
if(!empty($late_checkout_date[$z])){ $lchd= date("F j, Y", strtotime($late_checkout_date[$z])) ; }else{ $lchd= " "; }


        $body .= '<table border="1" width="400">';
	$body .= '<tr><td colspan="2" align="center"><h2>Multi City Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th  align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[$z].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$city['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$cityto['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Preferred hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[$z].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Car Request Id</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop[$z]."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$airport_pickup_loca[$z]."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup[$z]."</td>";
	$body .= "<tr><th align='left'>Drop Location</th><td>".$airport_drop_loca[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[$z]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[$z].'</td></tr>';
	$body .= "<tr><th align='left'>Car Size</th><td>".$car_size[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/></html></body>";	
	//print_r($airport_pickup_loca);
	//print_r($airport_drop_loca);
	//echo "<br />";

	}
	else if($data['airport_dropmulti'][$z] == 'no' && $data['airport_pickupmulti'][$z] == 'no'){
#echo "<br />SKK444<br />";
#print_r($data['airport_dropmulti']);
#echo "<br />";
#print_r($data['airport_pickupmulti']);
#echo "<br />";
		if($airport_drop_loca[$z] != 'No Booking' && !empty($airport_drop_loca[$z])){
		array_splice($airport_drop_loca,$z,0,$empty_value);
		}
		if($airport_pickup_loca[$z] != 'No Booking' && !empty($airport_pickup_loca[$z])){
		array_splice($airport_pickup_loca,$z,0,$empty_value);
		}
		if($airport_drop_loca[$z] != 'No Booking' && empty($airport_drop_loca[$z])){
		array_splice($airport_drop_loca,$z,0,$empty_value);
		}
		if($airport_pickup_loca[$z] != 'No Booking' && empty($airport_pickup_loca[$z])){
		array_splice($airport_pickup_loca,$z,0,$empty_value);
		}


		if($z != 0){

		#if($book_airline[$z] != 'No Booking' && !empty($book_airline[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))@array_splice($book_airline,$z,0,$empty_value);
		if($book_airline[$z] != 'No Booking' && isset($book_airline[$z]) && ($temp_z+1) != $z)@array_splice($book_airline,$z,0,$empty_value);
#echo "No No Book Airline".$z." ".$book_airline[$z]."<br />";
#print_r($book_airline);
#echo "<br />";
#print_r($onwardcity);
#echo "<br />";
		#if($onwardcity[$z] != 'No Booking' && !empty($onwardcity[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))@array_splice($onwardcity,$z,0,$empty_value);
		if($onwardcity[$z] != 'No Booking' && isset($onwardcity[$z]) && ($temp_z+1) != $z)@array_splice($onwardcity,$z,0,$empty_value);

#print_r($onwardcity);
#echo "<br />";
		#if($travel_to[$z] != 'No Booking' && !empty($travel_to[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))@array_splice($travel_to,$z,0,$empty_value);
		if($travel_to[$z] != 'No Booking' && isset($travel_to[$z]) && ($temp_z+1) != $z)@array_splice($travel_to,$z,0,$empty_value);

		#if($date[$z] != 'No Booking' && !empty($date[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))@array_splice($date,$z,0,$empty_value);
		if($date[$z] != 'No Booking' && !empty($date[$z]) && ($temp_z+1) != $z)@array_splice($date,$z,0,$empty_value);

		#if($rdate[$z] != 'No Booking' && !empty($rdate[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($rdate,$z,0,$empty_value);
		if($rdate[$z] != 'No Booking' && !empty($rdate[$z]) && ($temp_z+1) != $z)	@array_splice($rdate,$z,0,$empty_value);

		#if($preferred_airline_time[$z] != 'No Booking' && !empty($preferred_airline_time[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($preferred_airline_time,$z,0,$empty_value);
		if($preferred_airline_time[$z] != 'No Booking' && !empty($preferred_airline_time[$z]) && ($temp_z+1) != $z)	@array_splice($preferred_airline_time,$z,0,$empty_value);

		#if($pref_hotel[$z] != 'No Booking' && !empty($pref_hotel[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))@array_splice($pref_hotel,$z,0,$empty_value);
		if($pref_hotel[$z] != 'No Booking' && isset($pref_hotel[$z]) && ($temp_z+1) != $z)@array_splice($pref_hotel,$z,0,$empty_value);

		#if($pref_hotel[$z] != 'No Booking' && isset($pref_hotel[$z]))@array_splice($pref_hotel,$z,0,$empty_value);
/*
echo "31 July No No ".$z." ".$pref_hotel[$z]."<br />";
print_r($pref_hotel);
echo "<br />";
print_r($onwardcity);
echo "<br />";
echo $temp_z;
echo "<br />";
*/

		
/*
echo "<br />";
echo "No No".$z;
echo "Airport Pickup Location:".$airport_pickup_loca[$z];
echo "<br />";
*/
		#if($late_checkin[$z] != 'No Booking' && !empty($late_checkin[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($late_checkin,$z,0,$empty_value);
		if($late_checkin[$z] != 'No Booking' && !empty($late_checkin[$z]) && ($temp_z+1) != $z)	@array_splice($late_checkin,$z,0,$empty_value);

		#if($late_checkout[$z] != 'No Booking' && !empty($late_checkout[$z])  ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($late_checkout,$z,0,$empty_value);
		if($late_checkout[$z] != 'No Booking' && !empty($late_checkout[$z]) && ($temp_z+1) != $z)	@array_splice($late_checkout,$z,0,$empty_value);

		#if($late_checkin_date[$z] != 'No Booking' && !empty($late_checkin_date[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($late_checkin_date,$z,0,$empty_value);
		if($late_checkin_date[$z] != 'No Booking' && !empty($late_checkin_date[$z]) && ($temp_z+1) != $z)	@array_splice($late_checkin_date,$z,0,$empty_value);

		#if($late_checkout_date[$z] != 'No Booking' && !empty($late_checkout_date[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($late_checkout_date,$z,0,$empty_value);
		if($late_checkout_date[$z] != 'No Booking' && !empty($late_checkout_date[$z]) && ($temp_z+1) != $z)	@array_splice($late_checkout_date,$z,0,$empty_value);

		#if($car_pickuptime[$z] != 'No Booking' && !empty($car_pickuptime[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z]))){ $empty_value = ''; @array_splice($car_pickuptime,$z,0,$empty_value);}
		if($car_pickuptime[$z] != 'No Booking' && !empty($car_pickuptime[$z]) && ($temp_z+1) != $z){ $empty_value = ''; @array_splice($car_pickuptime,$z,0,$empty_value);}

		#if($car_company[$z] != 'No Booking' && !empty($car_company[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($car_company,$z,0,$empty_value);
		if($car_company[$z] != 'No Booking' && !empty($car_company[$z]) && ($temp_z+1) != $z)	@array_splice($car_company,$z,0,$empty_value);

		#if($need_car[$z] != 'No Booking' && !empty($need_car[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($need_car,$z,0,$empty_value);
		if($need_car[$z] != 'No Booking' && !empty($need_car[$z]) && ($temp_z+1) != $z)	@array_splice($need_car,$z,0,$empty_value);

		#if($car_type[$z] != 'No Booking' && !empty($car_type[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($car_type,$z,0,$empty_value);
		if($car_type[$z] != 'No Booking' && !empty($car_type[$z]) && ($temp_z+1) != $z)	@array_splice($car_type,$z,0,$empty_value);

		#if($car_size[$z] != 'No Booking' && !empty($car_size[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))	@array_splice($car_size,$z,0,$empty_value);
		if($car_size[$z] != 'No Booking' && !empty($car_size[$z]) && ($temp_z+1) != $z)	@array_splice($car_size,$z,0,$empty_value);

		#if($meal_preference[$z] != 'No Booking' && !empty($meal_preference[$z]) ||  (empty($airport_pickup_loca[$z]) || empty($airport_drop_loca[$z])))@array_splice($meal_preference,$z,0,$empty_value);
		if($meal_preference[$z] != 'No Booking' && !empty($meal_preference[$z]) && ($temp_z+1) != $z)@array_splice($meal_preference,$z,0,$empty_value);

		$temp_z = $z; ## Added when subsequent divs with no-no condition comes pickup and drop boxes unchecked.
		} ## if of $z != 0 ends
	#echo "<br />";

		#print_r($meal_preference);
		#echo "Airport Pickup Locations:<br />";
		#print_r($airport_pickup_loca);
		#echo "<br />";
		#echo "Airport Drop Locations:<br />";
		#print_r($airport_drop_loca);
		#echo "<br />";
		#echo "Onward City:<br />";
		#print_r($onwardcity);
		#echo "<br />";
		#echo $z;

		#exit;
		#if($airport_pickup_loca[$z] != "No Booking" && $airport_drop_loca[$z] != "No Booking"){


		if(($z == 0) || (!empty($onwardcity[$z]) && $onwardcity[$z] != 'No Booking') && ($airport_pickup_loca[$z] != "No Booking" && $airport_drop_loca[$z] != "No Booking")){
/*
echo "<br />";
echo "Inside No No ".$z;
echo $airport_pickup_loca[$z];
echo "<br />";
echo $airport_drop_loca[$z];
echo "<br />";
*/
			$datadad=['emp_id'=>$this->user_id,'book_airline'=>$book_airline[$z],'travel_from'=>$onwardcity[$z],'travel_to'=>$travel_to[$z],'trip_id'=>$id,'date'=>$date[$z],'rdate'=>$rdate[$z],'pref_hotel'=>$pref_hotel[$z],'car_company'=>$car_company[$z],'airport_drop'=>$airport_drop[$z],'airport_pickup'=>$airport_pickup[$z],'airport_pickup_loca'=>$airport_pickup_loca[$z],'airport_drop_loca'=>$airport_drop_loca[$z],'need_car'=>$need_car[$z],'preferred_airline_time'=>$preferred_airline_time[$z],'car_type'=>$car_type[$z],'car_size'=>$car_size[$z],'late_checkin'=>$late_checkin[$z],'late_checkout'=>$late_checkout[$z],'late_checkin_date'=>$late_checkin_date[$z],'late_checkout_date'=>$late_checkout_date[$z],'car_pickuptime'=>$car_pickuptime[$z],'meal_preference'=>$meal_preference[$z],'otherhotel'=>$otherhotel,'otherair'=>$otherair,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];



		$this->pdo->insert('destination_and_departure', $datadad);
$destdeptlastInsertId=$this->pdo->lastInsertId(); 	
/*****************************************************Multicity Request details for mail body********************************************************************************************/
		
$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);
if(!empty($date[$z])){ $dd= date("F j, Y", strtotime($date[$z])) ; }else{ $dd= " "; }
if(!empty($late_checkin_date[$z])){ $lcd= date("F j, Y", strtotime($late_checkin_date[$z])) ; }else{ $lcd= " "; }
if(!empty($late_checkout_date[$z])){ $lchd= date("F j, Y", strtotime($late_checkout_date[$z])) ; }else{ $lchd= " "; }
	$to=$row[0]['email'];	$formemail=$row[0]['email'];
	## display the detials
	$airline = $this->getairlines($book_airline[$z]);$cityto=$this->getcity($travel_to[$z]);$city=$this->getcity($onwardcity[$z]);
	$e_ticket=$air_booking['e_ticket'];
	$hotel=$this->gethotel($pref_hotel[$z]);$car=$this->getcars($car_company[$z]);
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }
	if($otheronwardcity!='NULL'){ $otheronwardcity= $otheronwardcity; }else{ $otheronwardcity= ' '; }
	if($othertravel_to!='NULL'){ $othertravel_to= $othertravel_to; }else{ $othertravel_to= ' '; }
        $body .= '<table border="1" width="400">';
	$body .= '<tr><td colspan="2" align="center"><h2>Multi City Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th  align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[$z].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$city['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$cityto['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Preferred hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[$z].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Car Request Id</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop[$z]."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$airport_pickup_loca[$z]."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup[$z]."</td>";
	$body .= "<tr><th align='left'>Drop Location</th><td>".$airport_drop_loca[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[$z]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[$z].'</td></tr>';
	$body .= "<tr><th align='left'>Car Size</th><td>".$car_size[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/></html></body>";
		//array_splice($airport_pickup_loca,$z+1,0,$empty_value);
		//array_splice($airport_drop_loca,$z+1,0,$empty_value);
		//echo "<br />";
		} ## if of onwardcity not empty ends
else if(($z == 0) || (!empty($onwardcity[$z]) && $onwardcity[$z] != 'No Booking') && ($airport_pickup_loca[$z] == "No Booking" && $airport_drop_loca[$z] == "No Booking")){

/*
echo "<br />";
echo "Inside second NO NO ".$z;
echo "<br />";
print_r($onwardcity);
echo "<br />";
echo "Other Hotel:".$otherhotel;
echo "<br />";
echo $airport_pickup_loca[$z];
echo "<br />";
echo $airport_drop_loca[$z];
echo "<br />";
*/

			$datadad=['emp_id'=>$this->user_id,'book_airline'=>$book_airline[$z],'travel_from'=>$onwardcity[$z],'travel_to'=>$travel_to[$z],'trip_id'=>$id,'date'=>$date[$z],'rdate'=>$rdate[$z],'pref_hotel'=>$pref_hotel[$z],'car_company'=>$car_company[$z],'airport_drop'=>$airport_drop[$z],'airport_pickup'=>$airport_pickup[$z],'airport_pickup_loca'=>$airport_pickup_loca[$z],'airport_drop_loca'=>$airport_drop_loca[$z],'need_car'=>$need_car[$z],'preferred_airline_time'=>$preferred_airline_time[$z],'car_type'=>$car_type[$z],'car_size'=>$car_size[$z],'late_checkin'=>$late_checkin[$z],'late_checkout'=>$late_checkout[$z],'late_checkin_date'=>$late_checkin_date[$z],'late_checkout_date'=>$late_checkout_date[$z],'car_pickuptime'=>$car_pickuptime[$z],'meal_preference'=>$meal_preference[$z],'otherhotel'=>$otherhotel,'otherair'=>$otherair,'otheronwardcity'=>$otheronwardcity,'othertravel_to'=>$othertravel_to];



		$this->pdo->insert('destination_and_departure', $datadad);	
$destdeptlastInsertId=$this->pdo->lastInsertId(); 
/*****************************************************Multicity Request details for mail body********************************************************************************************/


	$row = $this->pdo->select('emp_list', '`id`='.$this->user_id);

if(!empty($date[$z])){ $dd= date("F j, Y", strtotime($date[$z])) ; }else{ $dd= " "; }
if(!empty($late_checkin_date[$z])){ $lcd= date("F j, Y", strtotime($late_checkin_date[$z])) ; }else{ $lcd= " "; }
if(!empty($late_checkout_date[$z])){ $lchd= date("F j, Y", strtotime($late_checkout_date[$z])) ; }else{ $lchd= " "; }

	### Request ID added in body
	//$request_id = $this->pdo->lastInsertId();
       // $body .= "<b>Request ID : </b>".$destdeptlastInsertId."<br/><br/>";
	$to=$row[0]['email'];	$formemail=$row[0]['email'];
	## display the detials
	$airline = $this->getairlines($book_airline[$z]);$cityto=$this->getcity($travel_to[$z]);$city=$this->getcity($onwardcity[$z]);
	$e_ticket=$air_booking['e_ticket'];
	$hotel=$this->gethotel($pref_hotel[$z]);$car=$this->getcars($car_company[$z]);
	if($otherair!='NULL'){ $otherair= $otherair; }else{ $otherair= ' '; }
	if($otherhotel!='NULL'){ $otherhotel= $otherhotel; }else{ $otherhotel= ' '; }
if($otheronwardcity!='NULL'){ $otheronwardcity= $otheronwardcity; }else{ $otheronwardcity= ' '; }
	if($othertravel_to!='NULL'){ $othertravel_to= $othertravel_to; }else{ $othertravel_to= ' '; }
        $body .= '<table border="1" width="400">';
	$body .= '<tr><td colspan="2" align="center"><h2>Multi City Travel Request Details</h2></td></tr>';
        $body .= "<tr><th align='left'>Name of Employee</th><td>".$passenger."</td></tr>";
	if($trip['trip_type'] == 'multicity'){
	$body .="<tr><th  align='left'> City </th><td>".$city['city_name']."</td></tr>";
	}
	$body .= '<tr><th align="left">Airline</th><td>'.$airline['name'].$otherair.'</td></tr>';
	$body .= '<tr><th align="left">Preferred Airline Time</th><td>'.$preferred_airline_time[$z].'</td></tr>';
	$body .='<tr><th align="left">From location</th><td>'.$city['city_name'].$otheronwardcity.'</td></tr>';
	$body .= '<tr><th align="left">Destination</th><td>'.$cityto['city_name'].$othertravel_to.'</td></tr>';
	$body .= '<tr><th align="left">Departure date</th><td>'.$dd.'</td></tr>';
	$body .='<tr><th align="left">Preferred hotel</th><td>'.$hotel['hotel_name'].$otherhotel.'</td></tr>';
	$body .='<tr><th align="left">Flight Meal preference</th><td>'.$meal_preference[$z].'</td></tr>';
	$body .= '<tr><th align="left">Car Company</th><td>'.$car['name'].'</td></tr>';
	$body .='<tr><th align="left">Car Request Id</th><td>'.$destdeptlastInsertId.'</td></tr>';
	//$body .='<tr><th align="left">Trip Id</th><td>'.$id.'</td></tr>';
	$body .= "<tr><th align='left'>Airport Drop</th><td>".$airport_drop[$z]."</td></tr>";
	$body .="<tr><th align='left'>Pick up Location</th><td>".$airport_pickup_loca[$z]."</td></tr>";
	$body .=  "<tr><th align='left'>Airport Pickup</th><td>".$airport_pickup[$z]."</td>";
	$body .= "<tr><th align='left'>Drop Location</th><td>".$airport_drop_loca[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Multiple days booking</th><td>".$need_car[$z]."</td></tr>";
	$body .= '<tr><th align="left">Pickup Time</th><td>'.$car_pickuptime[$z].'</td></tr>';
	$body .= "<tr><th align='left'>Car Size</th><td>".$car_size[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check in time</th><td>".$late_checkin[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check out time</th><td>".$late_checkout[$z]."</td></tr>";
	$body .= "<tr><th align='left'>Check-in date/time</th><td>".$lcd."</td></tr>";
	$body .= "<tr><th align='left'>Check-out date/time</th><td>".$lchd."</td></tr>";
	$body .="</table><br/><br/></html></body>";
		//array_splice($airport_pickup_loca,$z+1,0,$empty_value);
		//array_splice($airport_drop_loca,$z+1,0,$empty_value);
		//echo "<br />";
		} ## if of onwardcity not empty ends
#echo "<br />";
#echo "At the end";
#echo "<br />";
#echo $z;
	}	## $data['airport_dropmulti'] ends
#echo "<br />";
#echo $z;

	}### foreach of $z ends	

#echo $body;
if($_FILES['manager_approval_report']['name']!=''){ //Manager approval report
$flag='Longer Journey Manager Approval';
$subject = 'ANSYS Travel Portal: New booking with manager approval report';		    
}else{
$flag='request';
}
	$requestmail= $this->sendemail($to,$subject,$body,$formemail,$id,$flag);//Send mail Car Request details 
//exit;
#echo "<br />";
#echo $z;
 }  

########################################################################
}// Employee class ends

