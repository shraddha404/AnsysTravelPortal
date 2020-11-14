<?php
include_once('Employee.class.php');
class Manager extends Employee{   
    public function __construct($user_id){
        parent::__construct($user_id);
// echo $_SESSION['user_id'];exit;
       if(!$this->isManager()){
            $this->_loginRedirect();
        //log failure
	/*
            $log = debug_backtrace();
            $this->createActionLog($log,0);
            throw new Exception('No privileges');
	*/
        }
    }


	public function getTravelRequests($start_from, $limit){
	try{
		$select = $this->pdo->prepare("select trips.id,	trips.trip_type,trips.date,trips.manager_approved,trips.booking_type,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id  Where trips.status='Open' ORDER BY trips.id DESC LIMIT $start_from, $limit");
		       $select->execute();
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends
public function getTravelRequestspagination(){
	try{
		
$select = $this->pdo->prepare("select trips.id,	trips.trip_type,trips.date,trips.manager_approved,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id  Where trips.status='Open' ORDER BY trips.id DESC");
		$select->execute();


        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends
public function getTravelRequestsreport($data){
	try{
                
                     $select = $this->pdo->prepare("select trips.id,trips.date,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips left join emp_list on trips.emp_id = emp_list.id");
		       $select->execute();
		if(!empty($data['stdate'])){
		$select = $this->pdo->prepare("select trips.id,trips.date,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips left join emp_list on trips.emp_id = emp_list.id WHERE trips.date >= ? AND trips.date <= ?");
		       $select->execute(array($data['stdate'],$data['endate']));
                       }

        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends



public function getTravelRequestsplan(){
	try{
		$select = $this->pdo->prepare("select trips.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
			left join emp_list on trips.emp_id = emp_list.id");
		$select->execute();
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends

public function getTraveldatewisereport($data){
	try{
		$select = $this->pdo->prepare("select trips.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
left join destination_and_departure on trips.id = destination_and_departure.trip_id
			left join emp_list on trips.emp_id = emp_list.id ORDER BY destination_and_departure.date ASC");
		$select->execute();
if(!empty($data['stdate']) && $data['booking_type']=='car'){
		$select = $this->pdo->prepare("select trips.*,car_bookings.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
left join car_bookings on trips.id = car_bookings.trip_id
left join destination_and_departure on trips.id = destination_and_departure.trip_id
			left join emp_list on trips.emp_id = emp_list.id  WHERE trips.date >= ? AND trips.date <= ?  GROUP BY trips.id");
		       $select->execute(array($data['stdate'],$data['endate']));
                       }
if(!empty($data['stdate']) && $data['booking_type']=='hotel'){
		$select = $this->pdo->prepare("select trips.*,hotel_bookings.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
left join hotel_bookings on trips.id = hotel_bookings.trip_id
left join destination_and_departure on trips.id = destination_and_departure.trip_id
			left join emp_list on trips.emp_id = emp_list.id WHERE trips.date >= ? AND trips.date <= ? GROUP BY trips.id");
		       $select->execute(array($data['stdate'],$data['endate']));
                       }

if(!empty($data['stdate']) && $data['booking_type']=='airline'){
		$select = $this->pdo->prepare("select trips.*,air_bookings.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
left join air_bookings on trips.id = air_bookings.trip_id
left join destination_and_departure on trips.id = destination_and_departure.trip_id
			left join emp_list on trips.emp_id = emp_list.id WHERE trips.date >= ? AND trips.date <= ? GROUP BY trips.id");
		       $select->execute(array($data['stdate'],$data['endate']));
                       }




        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends
 
        


public function getAirlinebookingreport(){
	try{
		$select = $this->pdo->prepare("select trips.*,air_bookings.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
left join air_bookings on trips.id = air_bookings.trip_id
			left join emp_list on trips.emp_id = emp_list.id ");
		$select->execute();
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends
public function getCarbookingreport(){
	try{
		$select = $this->pdo->prepare("select trips.*,car_bookings.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
left join car_bookings on trips.id = car_bookings.trip_id
			left join emp_list on trips.emp_id = emp_list.id ");
		$select->execute();
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends


public function getHotelbookingreport(){
	try{
		$select = $this->pdo->prepare("select trips.*,hotel_bookings.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.biz_unit from trips 
left join hotel_bookings on trips.id = hotel_bookings.trip_id
			left join emp_list on trips.emp_id = emp_list.id ");
		$select->execute();
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
	} ## function ends

/*added by Rupali*/
function getous($id){

try{
		$select = $this->pdo->prepare("SELECT * FROM fi_ou WHERE id = ?");
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
			emp_list.middlename,emp_list.lastname,emp_list.ou,emp_list.bu ,emp_list.email ,emp_list.contact_no ,emp_list.address1 ,emp_list.address2 from trips left join emp_list on trips.emp_id = emp_list.id WHERE trips.id = ?");
	$select->execute(array($trip_id));
	}
	catch(PDOException $e){
	$this->setError($e->getMessage());
	return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row;


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
public function getdestdep($id){
//echo $id;
	try{
	//$select = $this->pdo->prepare("SELECT * FROM destination_and_departure WHERE trip_id = ?");
	//$select->execute(array($id));
        $select = $this->pdo->prepare("select destination_and_departure.*,emp_list.firstname,air_bookings.*, emp_list.middlename,emp_list.lastname,emp_list.ou from destination_and_departure left join emp_list on destination_and_departure.emp_id = emp_list.id LEFT JOIN air_bookings ON air_bookings.dest_dept_id = destination_and_departure.id WHERE destination_and_departure.trip_id = ? ORDER BY destination_and_departure.id ASC");
	
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
function travelrequestsuggestedplanmanager($data){
//echo $data['trip_id'];
//print_r($data);exit;
        try{

		 	$id = $data['trip_id'];
$manager_email = $data['manager_email'];
$emp_email = $data['emp_email'];
$finance=$this->getallFinance();
$finance_email = $finance['email'];
$p=$data['passenger'];
$m=$data['manager'];

			$query1 = $this->pdo->prepare("UPDATE trips SET `manager_approved` = '1' WHERE `id` = ?");	
			$query1->execute(array($id));

			##### Updates requested on 10May 2018
			$to = $manager_email.",".$emp_email.",".$finance_email;
			$flag = 'Request Approval';
			$subject = 'Approval of travel request id '.$id;
		//	$body = '<html><body>Travel Request having ID '.$id.' has been<br/> approved by the manager.<br/>';
				$body = '<html><body>Hello '.$p.',<br/><br/>

Travel Request having ID '.$id.' has been approved by the manager.<br/><br/>

Regards,<br/>

'.$m.'</body></html>';
		//	$requestmail= $this->sendSMTPEmail($to,$subject,$body
		$requestmail= $this->sendSMTPEmail($to,$subject,$body);
		//	$requestmail= $this->sendemail($to,$subject,$body,$formemail,$id,$flag);
		
/*
		for($x = 0; $x < count($data['travel_to']); $x++ )
		    {
 			$id = $data['trip_id'][$x];
			$query1 = $this->pdo->prepare("UPDATE trips SET `manager_approved` = '1' WHERE `id` = ?");	
			$query1->execute(array($id));
				//$this->pdo->update('trips', array('manager_approved'=>1),  array('id'=>$id)); 
		   }
*/

		return true;
        }
        catch(PDOException $e){// echo $e->getMessage();//print_r($data);exit;
            // check if username already exists in the system
            //$this->setError($e->getCode());
          		$this->setError($e->getMessage());
        }
}








}
