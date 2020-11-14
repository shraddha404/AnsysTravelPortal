<?php
chdir(dirname(__FILE__));
include_once 'lib.php';
class User{
	//class variables
	var $user_id = null;
	var $user_type = null;
	var $error = null;
	var $error_code = null;
	var $app_config = null;
	var $pdo = null;


public function __construct($user_id=null){
	$this->user_id = $user_id;
	$this->initializeDB();
	if(!empty($user_id)){
		$this->user_profile = $this->getUserDetails($user_id);
		$this->user_type = $this->getUserType();
	}
	//some initialization stuff here
	$this->app_config = $this->getConfig();
}

function initializeDB(){
    include_once 'db_connect.php';
	try{
        $this->pdo = new db("mysql:host=localhost;dbname=$db", $db_user, $db_pass);
	//$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
        echo "Err: " . $e->getMessage();
        }
}

function __call($functionName, $argumentsArray ){
	//$log = debug_backtrace();
	//$this->createActionLog($log,0);
	//$this->setStdError('undefined_function');
}

function getConfig(){
	#return $this->pdo->select('config');
}

/*
function setError() 
	assign error to the class variable $error.
*/
function setError($error){
	$this->error = $error;
}

/*
function getError() 
	return true if class varible has some error value else return false. 
*/
	function hasError(){
		if(empty($this->error)){
			return false;
		}
		return true;
	}

public	function authenticate($username, $password){

##### newly added code on 8 June 2017
	$ldap_server = "pundc2.win.ansys.com";
        $ldap_port = '389';
        $ldap_user = 'ansys\\'.$username;
        $ds=ldap_connect($ldap_server, $ldap_port) or die("Could not connect to LDAP server.");
        //bind only if password is not empty
        // and connection with LDAP server is established
        if($ds && !empty($password)){
                ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                if(!ldap_bind($ds, $ldap_user, $password)){
                        $this->setError(ldap_error($ds));
                        // Can not bind to LDAP
                        // Try local authentication
                        if($this->authenticateLocal($username, $password)){
				//echo $this->user_id;
                                //$this->user_id = $this->getUserIdFromUsername($username);
                                return true;
                        }
                        // at this point, local authentication has also failed
                        return false;
                }
                // set the user_id and return true
                $this->user_id = $this->getUserIdFromUsername($username);
                if(empty($this->user_id)){
                        $this->setError('Could not find your account in Leave Management System');
                        return false;
                }
                // sync local db with info from LDAP
                //pass the LDAP connection object
                $this->syncWithLDAP($username,$password);
                //Unbind LDAP
                ldap_unbind($ds);
                return true;
        }

}


###################################
public function authenticateLocal($username, $password){

	try{
		$select = $this->pdo->prepare("SELECT id FROM emp_list WHERE username = ? AND password = ? AND status = 1");
		$select->execute(array($username, md5($password)));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	if($row['id']){
		$this->user_id = $row['id'];
		$user_profile = $this->getUserDetails($row['id']);
		$this->user_type = $user_profile['user_type'];
		$action_details=array();
/*
		$action_details['table_name']='users';
		$action_details['row_id']=$this->user_id;
		$action_details['operation']='Logged In';
		$this->createActionLog($action_details);
*/
		return true;
	}
	$this->setError("Invalid username or password.");
	return false;
}

/* 
    Create New User Single Sign On
*/

function createNewUser($username){
	$user_types = $this->getUserTypes();
	$user_type_id = 0;
	foreach($user_types as $k=>$v){
		if($v['type'] == 'Employee'){
			$user_type_id = $v['id'];
		}
	}
        try{
	$stmt = "INSERT INTO emp_list
            (`username`, `status`, `joining_date`, `user_type`)
            VALUES(?,1,NOW(),?)";
	    $stmt = $this->pdo->prepare($stmt);
            $stmt->execute(array($username,$user_type_id));
            $user_id = $this->pdo->lastInsertId();
        }
        catch(PDOException $e){
            // check if username already exists in the system
            //$this->setError($e->getCode());
		//echo $e->getMessage();
            if($e->getCode() == 23000){
                $this->setStdError('user_exists');
            }
            else{
                //$this->setError($e->getMessage());
                $this->setStdError('user_not_created');
            }
            return false;
        }
	return $user_id;
}

/*
	Get user id from username
*/
public function getUserIdFromUsername($username){
	
	try{
	$select = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
	$select->execute(array($username));
	}
	catch(PDOException $e){
	$this->setError($e->getMessage());
	return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row['id'];
}

/* function logout
	added for activity logging purpose
*/
function logout(){
	$action_details=array();
	$action_details['table_name']='users';
	$action_details['row_id']=$this->user_id;
	$action_details['operation']='Logged Out';
	$this->createActionLog($action_details);
	//$_SESSION['user_id'] = null;
	return true;
}

/*
function isAdmin() 
	return true if logged in user type is Admin other wise return false with error message.
*/
	function isAdmin(){

		if($this->user_type == 'Admin'){
			return true;
		}
		return false;
	}

public	function isManager(){

		if($this->user_type == 'Manager'){
			return true;
		}
		return false;
	}
	function isEmployee(){

		if($this->user_type == 'Employee'){
			return true;
		}
		return false;
	}
public	function isTravelDesk(){
		if($this->user_type == 'Travel Desk'){
			return true;
		}
		return false;
	}
/*
function getUserType() 
	return user type of logged in user.
*/
function getUserType(){
	//return $this->user_profile['user_type'];
	$select = $this->pdo->prepare("SELECT user_types.type FROM user_types, emp_list
	WHERE user_types.id = emp_list.user_type
	AND emp_list.id = ?");
	$select->execute(array($this->user_id));
	$row = $select->fetch(PDO::FETCH_ASSOC);
//echo $row['type'];
	return $row['type'];	
}

/*
function _loginRedirect() 
	function redirect user to the index page. 
*/
    function _loginRedirect(){
        	// send user to the login page
        	header("Location:/login.php");
    }
    
/*
function getUserDetails($user_id) 
	function accept the user id as parameter and return the users details of that user id. 
*/
    function getUserDetails($userid){
	$records = $this->pdo->select('emp_list', '`id`='.$this->user_id);
	return $records[0];
}
	
        
	
/*
function updateMyProfile($data) 
	function accept the data array as parameter and update the logged in user information
	with data in parameter array and return true if update user information successfully else return false with error message. 
*/
function updateMyProfile($data){
	// use $this->pdo->update
	//print_r($data);
	//print_r($_FILES);
	
	try{
	$path = $_SERVER['DOCUMENT_ROOT']."/uploads/passport-copy/";
                if($_FILES['passport_copy']['name']!=''){
                        $fname=$this->user_id."_".$_FILES['passport_copy']['name'];
                        $ftmpname=$_FILES['passport_copy']['tmp_name'];
			if(move_uploaded_file($ftmpname, $path.$fname)){
				$update_qry = $this->pdo->prepare("UPDATE emp_list SET passport_copy=? WHERE id=?");	
				$update_qry->execute(array($fname,$this->user_id));
			}
		}


	$this->pdo->update('emp_list', $data, '`id`='.$this->user_id);
	$pathvisa = $_SERVER['DOCUMENT_ROOT']."/uploads/visa-copy/";
		if(is_array($data['visa-no'])){ //print_r($data);
		//echo $c=count($data['visa-no']);
			for($x = 0; $x < count($data['visa-no']); $x++ )
			{ //echo $c=count($data['visa-no']);
			if($_FILES['visa-copy']['name'][$x]!=''){
                        $f=$this->user_id."_".$_FILES['visa-copy']['name'][$x];
                        $ftmpn=$_FILES['visa-copy']['tmp_name'][$x];

			 $visa_number = $data['visa-no'][$x];
			$stmt3 = "INSERT INTO `visa`  (`emp_id`,`visa_no`,`visa-exp-date`,`visa-country`)VALUES(?,?,?,?)";
			$stmt3 = $this->pdo->prepare($stmt3);
			#$stmt3->execute(array($_SESSION['user_id'],$visa_number,$data['visa-exp-date'][$x],$data['visa-country'][$x]));  
			if(!empty($data['visa-no'][$x])){ //print_r($data);
				$stmt3->execute(array($_SESSION['user_id'],$data['visa-no'][$x],$data['visa-exp-date'][$x],$data['visa-country'][$x]));  
			}
			#$stmt3->execute(array($_SESSION['user_id'],$visa_number,$data['visa-exp-date'][$x],$data['visa-country'][$x]));  
			if(move_uploaded_file($ftmpn, $pathvisa.$f)){
				$updateqry = $this->pdo->prepare("UPDATE visa SET visa_copy=? WHERE emp_id=?");	
				$updateqry->execute(array($f,$this->user_id));
			} # move_uploaded_file ends
			} # $_FILES['visa-copy']['name'][$x] if ends

			} # foreach ends
                
                } #$data['visa-no'] if ends
if(is_array($data['air-co'])){
                     for($y = 0; $y < count($data['air-co']); $y++ )
			{
                            $ff = "INSERT INTO `frequent_flyer`  (`emp_id`,`air-co`,`ffp-name`,`ffp-id`)VALUES(?,?,?,?)";   
			   $ff = $this->pdo->prepare($ff);
		            $ff->execute(array($_SESSION['user_id'],$data['air-co'][$y],$data['ffp-name'][$y],$data['ffp-id'][$y]));  
                        } 
                  }

	}
	catch(PDOException $e){
		//echo "error: ".$e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
	
	
	return true;
}

/*
function resetPassword($username,$userEmail)
	function accept three parameters username password and email address
	and reset the user password and return true after successfully password reset other wise retun false 
	with error message.
*/
public function resetPassword($userName,$userEmail){
    
    $code = generatePassword(64);
	$select = $this->pdo->prepare("SELECT * FROM users 
        WHERE username = ? AND email = ?");
    $select->execute(array($userName, $userEmail));
    $row = $select->fetch(PDO::FETCH_ASSOC);
		if(count($row)!= 0){
		   $update=$this->pdo->prepare("UPDATE users 
                   SET `password`=?  
                   WHERE username=? AND email = ?");
        	        if($update->execute(array($this->getPasswordHashOfUser($userName,$code), $userName, $userEmail))){
						$log = debug_backtrace();
						$this->createActionLog($log);

                        // add to Reset Queue
                        $data['user_id'] = $this->getUserIdFromUsername($userName);
                        $data['code'] = $code;
                        $this->addToPasswordResetQueue($data);
                        //template var data
                        $userid = $this->getUserIdFromUsername($userName);
                        $user_details = $this->getUserDetails($userid);
                        $data = array(
                                'userName'=>$userName,
                                'pwd'=>$code,
                                'name'=> $user_details['first_name'],
                                'last_name'=> $user_details['last_name']
                            );
                        $this->sendTemplateEmail($userEmail, $this->app_config['password_retrieval_subject_path'],
                            $this->app_config['password_retrieval_body_path'],$data);
               	        return true;
	                }else{
                        $this->setError($update);
               	         return false;
	                }
		 }# if of not empty array check
	         else{
        	       $this->setStdError("reset_password_error");
                       return false;
	        }
    }

function aasort (&$array, $key){
	$sorter=array();
	$ret=array();
	reset($array);
	foreach ($array as $ii => $va){
		$sorter[$ii]=$va[$key];
	}
	asort($sorter);
	foreach ($sorter as $ii => $va){
	$ret[$ii]=$array[$ii];
	}
	$array=$ret;
}


/*function createActionLog($details){
            
		$insert = "INSERT INTO action_log 
				(`table_name`,`row_id`,`operation`,`created_on`,`created_by`)
				VALUES(?,?,?,NOW(),?)";
		$insert_args = array($details['table_name'],$details['row_id'],$details['operation'],$this->user_id);
        try{
		    $stmt=$this->pdo->prepare($insert);		
		    $stmt->execute($insert_args);
        }
        catch(PDOException $e){
				$this->setError($e->getMessage());
				return false;
			}	
			return true;
}*/

function getAllUsers(){
	$per_page=10;
	$p =1;
	$offset = ($p - 1) * $per_page;
	$select = "SELECT * ,users.id as user_id, user_types.type AS user_type FROM users 
		LEFT JOIN user_types ON user_types.id=users.type WHERE username !='cron'";
		//LIMIT $offset, $per_page";
		
		$res = $this->pdo->query($select);
		return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getUserTypes(){
	return $this->pdo->select('user_types');
}

function sendTemplateEmail($to,$subject_path,$body_path,$template_vars){
$app_config = $this->app_config;
$email_from_address='no-reply@aad.org';
//include 'config.php';
$subject_path = $app_config['document_root']."/../".$subject_path;
$body_path = $app_config['document_root']."/../".$body_path;
//$headers = "From:$email_from_address\n";
$headers = "From:$email_from_address\n";
$email_subject_body = getEmailTemplateBody($subject_path);
$email_template_body = getEmailTemplateBody($body_path);
$email_body = $this->getEmailBody($email_template_body,$template_vars);
$email_subject = $this->getEmailBody($email_subject_body,$template_vars);
$this->sendSMTPEmail($to, $email_subject, $email_body);
}

public function getEmailBody($template_body,$arr_of_variable){
$body = $template_body;
//$subdomain = $this->getMySubdomain().'.'.$this->app_config['http_host'];
#$http_host = empty($_SERVER['HTTP_HOST'] || preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_SERVER['HTTP_HOST']))?$subdomain:$_SERVER['HTTP_HOST'];
//$http_host = !empty($this->getMySubdomain())?$subdomain:$_SERVER['HTTP_HOST'];

foreach($arr_of_variable as $k => $v){
        $pattern[$k]="/\[\[$k\]\]/";
        $replacement[$k] = str_replace('$', '\$', $v);
        $body = preg_replace($pattern,$replacement,$body);
}
$pattern= '/\[\[server\]\]/';
$body = preg_replace($pattern,$http_host,$body);
return $body;
}


public function sendSMTPEmail($to, $email_subject, $email_body){
if(empty($to)){return false;}
############ Send mail by SMTP
$app_config = $this->app_config;
$mail = new PHPMailer(true);
$mail->IsSMTP(); // set mailer to use SMTP
//$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true;
$mail->SMTPKeepAlive = true;
$mail->SMTPSecure = $app_config['smtp_protocol'];
$mail->Port = $app_config['smtp_port'];
//echo $app_config['smtp_host'];
$mail->Host = $app_config['smtp_host']; // specify main and backup server
$mail->Username = $app_config['smtp_username'];
$mail->Password = $app_config['smtp_password'];
$mail->From = $app_config['smtp_from'];
$mail->FromName = $app_config['smtp_fromname'];
$mail->AddAddress($to);   // name is optional
$mail->IsHTML(false);    // set email format to HTML
$mail->Subject = $email_subject;
$mail->Body = $email_body;
try{
    $mail->Send();
}
catch(Exception $e){
	logMessage($to.' | '.$email_subject. ' | '.$e->getMessage());
	return false;
}
/*
if(!$mail->Send())
{
    //echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
    //echo 'Mail sent!';
}
*/
return true;
}

/*
Functions related to parameter tables
*/
function getParamInfo($type='case'){ // default type = case
    
#### returns all the info stored in params table
	if($type == 'all'){
		$select = "SELECT * FROM parameters 
            WHERE `org_id` = $this->org_id";
        $args = array();
	}
	else{
		$select = "SELECT parameters.* FROM parameters, parameter_classes 
		WHERE parameter_classes.id = parameters.class 
        AND `org_id` = $this->org_id 
		AND parameter_classes.name = ?";
        $args = array($type);
	}

	try{
	$stmt = $this->pdo->prepare($select);
    	$stmt->execute($args);
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
	}
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
prepareParams(data)
accepts an array which has param names as keys
and returns an array of arrays which has param ids as keys 
names are replaced with ids from the db table parameters
first value of each 2 element array is text value and the second is option value (an int)
*/
function prepareParams($data){
	$param_info = $this->getParamInfo();
	$param_ids = array();
	$param_types = array();

	foreach($param_info as $p_i){
		$param_ids[$p_i['param']] = $p_i['id'];
		$param_types[$p_i['param']] = $p_i['param_type'];
	}
	$new_params = array();
	foreach($data as $k=>$v){
		if(isset($param_ids[$k]) && $param_types[$k] == 'text'){
			$new_params[$param_ids[$k]][0] = $v;
		}
		elseif(isset($param_ids[$k])){
			if(is_array($v)){
				$v = implode(',',$v);
			}
			$new_params[$param_ids[$k]][1] = $v;
			$new_params[$param_ids[$k]][0] = $data[$k.'_text_value'];
		}
	}
	return $new_params;
}
/*
Does reverse of prepareParams.
*/
function prepareParamsReverse($data){
	$param_info = $this->getParamInfo();
	$param_ids = array();
	foreach($param_info as $p_i){
		$param_ids[$p_i['id']] = $p_i['param'];
	}
	$new_params = array();
	foreach($data as $k=>$v){
		if(isset($param_ids[$k])){
		#	$new_params[$param_ids[$k]] = $v;//this is the text value
			$new_params[$param_ids[$k]][0] = $v[0];//this is the text value
			$new_params[$param_ids[$k]][1] = $v[1];//this is the option value
		}
	}
	return $new_params;
}

/*
    Create password hash of user
*/
public function getPasswordHashOfUser($username,$password){
	$options = array('cost'=>12, 'salt'=>md5(strtolower($username)));
	return password_hash($password, PASSWORD_DEFAULT, $options);
}

/*
Inform user that their password has been updated
*/
public function notifyPasswordUpdate($data){
	$this->sendTemplateEmail($data['email'], $this->app_config['password_reset_notification_subject'], $this->app_config['password_reset_notification_body'], $data);
}


/*added by Rupali*/
function airlines(){
	return $this->pdo->select('airlines',' 1 ORDER BY name ASC');
}

/*added by Rupali*/
function cities(){
	return $this->pdo->select('cities', '1 ORDER BY city_name ASC');
}
/*added by Rupali*/
function hotels(){
	return $this->pdo->select('hotels', '1 ORDER BY hotel_name ASC');
}
/*added by Rupali*/
function cars(){
	return $this->pdo->select('car_companies', '1 ORDER BY name ASC');
}
/*added by Rupali*/
function travelrequestbooking($data){ //print_r($data);
        try{
		//$date = date('Y-m-d', get_strtotime($data['date']));
//if()

		if($data['booking']=='hotel')
		{
                   //trip instration for only hotel booking
			$stmt = "INSERT INTO trips (`emp_id`,`purpose_of_visit`,`special_mention`,`only_hotel_booking`)VALUES(?,?,?,?)";
			$stmt = $this->pdo->prepare($stmt);
			$stmt->execute(array($_SESSION['user_id'],$data['purpose_of_visit'],$data['special_mention'],'yes'));
			$id = $this->pdo->lastInsertId();

	           //destination_and_departure instration for only hotel booking
		if(is_array($data['pref_hotel']))
		     {
		       $zc=count($data['pref_hotel']);//print_r($data);    error_reporting(E_ALL); 
			for($z = 0; $z < $zc; $z++ )
		   	 {
		$stmt4 = "INSERT INTO `destination_and_departure`(`emp_id`,`pref_hotel`,`travel_to`,`trip_id`,`room_type`,`noofguests`,`noofrooms`,`checkintime`,`checkouttime`,`checkindate`,`checkoutdate`)VALUES(?,?,?,?,?,?,?,?,?,?,?)";
		$stmt4 = $this->pdo->prepare($stmt4);
		$stmt4->execute(array($_SESSION['user_id'],$data['pref_hotel'][$z],$data['travel_to'][$z],$id,$data['room_type'][$z],$data['noofguests'][$z],$data['noofrooms'][$z],$data['checkintime'][$z],$data['checkouttime'][$z],$data['checkindate'][$z],$data['checkoutdate'][$z]));
                          }
                       }

		}
		else if($data['booking']=='car') 
		{//print_r($data);
                        //trip instration for only car booking		
				$stmt = "INSERT INTO trips (`emp_id`,`purpose_of_visit`,`special_mention`,`only_car_booking`)VALUES(?,?,?,?)";
			
	$stmt = $this->pdo->prepare($stmt);
				$stmt->execute(array($_SESSION['user_id'],$data['purpose_of_visit'],$data['special_mention'],'yes'));
				$id = $this->pdo->lastInsertId();
	           //destination_and_departure instration for only car booking
		if(is_array($data['car_company']) )
		     {
		  	   $zcx=count($data['car_company']);//print_r($data);
			for($zx = 0; $zx < $zcx; $zx++ )
		   	 {
###### Newly Added code SKK
if(!empty($data['drop_location'][$zx])){
	$data['pickup_required'][$zx] = 'yes';
	$data['drop_required'][$zx] = '';
}
else if(!empty($data['pickup_location'][$zx])){
	$data['drop_required'][$zx] = 'yes';
	$data['pickup_required'][$zx] = '';
}
###### Newly Added code ends SKK
				 $stmtx = "INSERT INTO `destination_and_departure`(`emp_id`,`car_company`,`trip_id`,`airport_drop`,`airport_pickup`,`airport_pickup_loca`,`airport_drop_loca`,`need_car`,`pickup_city`)VALUES(?,?,?,?,?,?,?,?,?)";
				$stmtx = $this->pdo->prepare($stmtx);
				$stmtx->execute(array($_SESSION['user_id'],$data['car_company'][$zx],$id,$data['drop_required'][$zx],$data['pickup_required'][$zx],$data['pickup_location'][$zx],$data['drop_location'][$zx],$data['need_car'][$zx],$data['pickup_city'][$zx]));  
			}
                       }
		}
		else{
		//trip instration for only airline booking
		$stmt = "INSERT INTO trips (`emp_id`,`purpose_of_visit`,`special_mention`,`trip_type`,`date`,`cash_adv`,`preferred_airline_time`)VALUES(?,?,?,?,NOW(),?,?)";
		$stmt = $this->pdo->prepare($stmt);
		$stmt->execute(array($_SESSION['user_id'],$data['purpose_of_visit'],$data['special_mention'],$data['trip_type'],$data['cash_adv'],$data['preferred_airline_time']));
		$id = $this->pdo->lastInsertId();
		}
		if($data['trip_type']=='oneway'){   $c=count($data['pref_hotel']);//print_r($data);
					for($x = 0; $x <  $c; $x++ )
				    {
				 $stmt5 = "INSERT INTO `destination_and_departure`(`emp_id`,`book_airline`,`travel_from`,`travel_to`,`date`,`return_date`,`pref_hotel`,`car_company`,
		`airport_drop_loca`,`airport_pickup_loca`,`airport_drop`,`airport_pickup`,`need_car`,`trip_id`,`car_type`,`car_size`,`late_checkin`,`late_checkout`,`late_checkin_date`,`late_checkout_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$stmt5 = $this->pdo->prepare($stmt5);
				$stmt5->execute(array($_SESSION['user_id'],$data['book_airline'][$x],$data['onwardcity'][$x],$data['travel_to'][$x],$data['date'][$x],$data['rdate'][$x],$data['pref_hotel'][$x],$data['car_company'][$x],$data['airport_drop_loca'][$x],$data['airport_pickup_loca'][$x],$data['airport_drop'][$x],$data['airport_pickup'][$x],$data['need_car'][$x],$id,$data['car_type'][$x],$data['car_size'][$x],$data['late_checkin'][$x],$data['late_checkout'][$x],$data['late_checkin_date'][$x],$data['late_checkout_date'][$x]));  

					}
				}

		if(is_array($data['onwardcity']) && $data['trip_type']=='multicity'){
		  $cxx=count($data['onwardcity']);
//print_r($data);
		for($xx = 0; $xx < $cxx; $xx++ )
		    {
			//$request_date = date('Y-m-d', get_strtotime($data['date'][$x]));
		$stmt3 = "INSERT INTO `destination_and_departure`(`emp_id`,`book_airline`,`travel_from`,`travel_to`,`date`,`return_date`,`pref_hotel`,`car_company`,
`airport_drop_loca`,`airport_pickup_loca`,`airport_drop`,`airport_pickup`,`need_car`,`trip_id`,`car_type`,`car_size`,`late_checkin`,`late_checkout`,`late_checkin_date`,`late_checkout_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt3 = $this->pdo->prepare($stmt3);
		$stmt3->execute(array($_SESSION['user_id'],$data['book_airline'][$xx],$data['onwardcity'][$xx],$data['travel_to'][$xx],$data['date'][$xx],$data['rdate'][$xx],$data['pref_hotel'][$xx],$data['car_company'][$xx],$data['airport_drop_loca'][$xx],$data['airport_pickup_loca'][$xx],$data['airport_drop'][$xx],$data['airport_pickup'][$xx],$data['need_car'][$xx],$id,$data['car_type'][$xx],$data['car_size'][$xx],$data['late_checkin'][$xx],$data['late_checkout'][$xx],$data['late_checkin_date'][$xx],$data['late_checkout_date'][$xx]));
		    }

		}

		if(is_array($data['book_airline']) && $data['trip_type']=='round trip'){
  $ca=count($data['book_airline']);print_r($data);
			for($xa = 0; $xa <  $ca; $xa++ )
		    {   $a=$xa.'stmt';
			//$request_date = date('Y-m-d', get_strtotime($data['date'][$x]));
		 $a = "INSERT INTO `destination_and_departure`(`emp_id`,`book_airline`,`travel_from`,`travel_to`,`date`,`return_date`,`pref_hotel`,`car_company`,
`airport_drop_loca`,`airport_pickup_loca`,`airport_drop`,`airport_pickup`,`need_car`,`trip_id`,`car_type`,`car_size`,`late_checkin`,`late_checkout`,`late_checkin_date`,`late_checkout_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$a= $this->pdo->prepare($a);
		$a->execute(array($_SESSION['user_id'],$data['book_airline'][$xa],$data['onwardcity'][$xa],$data['travel_to'][$xa],$data['date'][$xa],$data['rdate'][$xa],$data['pref_hotel'][$xa],$data['car_company'][$xa],$data['airport_drop_loca'][$xa],$data['airport_pickup_loca'][$xa],$data['airport_drop'][$xa],$data['airport_pickup'][$xa],$data['need_car'][$xa],$id,$data['car_type'][$xa],$data['car_size'][$xa],$data['late_checkin'][$xa],$data['late_checkout'][$xa],$data['late_checkin_date'][$xa],$data['late_checkout_date'][$xa]));  
		    }
		}

        }
        catch(PDOException $e){
            // check if username already exists in the system
            //$this->setError($e->getCode());
			echo $e->getMessage();
          		$this->setError($e->getMessage());
	return false;
        }
	return true;
}
public function getTravelRequestsById(){
	try{
		$select = $this->pdo->prepare("select trips.id,trips.date,trips.manager_approved,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit,emp_list.entity from trips 
			left join emp_list on emp_list.id = trips.emp_id Where emp_list.id = ? ORDER BY trips.id DESC");
		$select->execute(array($_SESSION['user_id']));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} 
public function getVisaDetails(){
	try{
		$select = $this->pdo->prepare("select * from visa where emp_id = ?");
		$select->execute(array($_SESSION['user_id']));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	}
/*added by Rupali*/

public function getcity($id){

try{
		$select = $this->pdo->prepare("SELECT * FROM cities WHERE id = ?");
	$select->execute(array($id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row;
}
/*added by Rupali*/
public function gethotel($id){

try{
		$select = $this->pdo->prepare("SELECT * FROM hotels WHERE id = ?");
	$select->execute(array($id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row;
}

/*added by Rupali*/
public function getcars($id){

try{
		$select = $this->pdo->prepare("SELECT * FROM car_companies WHERE id = ?");
	$select->execute(array($id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row;
}
/*added by Rupali*/
public function getairlines($id){

try{
		$select = $this->pdo->prepare("SELECT * FROM airlines WHERE id = ?");
	$select->execute(array($id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row;
}

/*added by Rupali*/
  public function getTripDetails($trip_id){

	try{
	$select = $this->pdo->prepare("select trips.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips left join emp_list on trips.emp_id = emp_list.id WHERE trips.id = ?");
	$select->execute(array($trip_id));
	}
	catch(PDOException $e){
	$this->setError($e->getMessage());
	return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row;


}/*added by Rupali*/
public function getdestdep($id){
//echo $id;
	try{
	$select = $this->pdo->prepare("SELECT * FROM destination_and_departure WHERE trip_id = ?");
	$select->execute(array($id));
	}
	catch(PDOException $e){
	$this->setError($e->getMessage());
	return false;
	}
	//$row = $select->fetch(PDO::FETCH_ASSOC);


$row = $select->fetchAll(PDO::FETCH_ASSOC);//print_r($row);
	return $row;
}
/*added by Rupali*/
function travelrequestsuggestedplan($data){//print_r($data);
        try{
		$id = $data['trip_id'];

		if(is_array($data['book_airline'])){
		//echo $c=count($data['travel_from']);
		for($x = 0; $x < count($data['book_airline']); $x++ )
		    {

			$query1 = $this->pdo->prepare("UPDATE trips SET `manager_approved` = '1' WHERE `id` = ?");	
			$query1->execute(array($id));

		    }


		}

		return true;


        }
        catch(PDOException $e){
            // check if username already exists in the system
            //$this->setError($e->getCode());
          		$this->setError($e->getMessage());

        }
}
## function ends

function getAirBookings($trip_id){
        $records = $this->pdo->select('air_bookings', '`trip_id`='.$trip_id);
        return $records;
}

function getCarBookings($trip_id){
        $records = $this->pdo->select('car_bookings', '`trip_id`='.$trip_id);
        return $records;
}

function getHotelBookings($trip_id){
        $records = $this->pdo->select('hotel_bookings', '`trip_id`='.$trip_id);
        return $records;
}
################################################
}//User class ends here
?>

