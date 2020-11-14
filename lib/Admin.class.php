<?php
include_once('User.class.php');
class Admin extends User{
	
    public function __construct($user_id){
        parent::__construct($user_id);
        if(!$this->isAdmin()){
            $this->_loginRedirect();
        //log failure
            //$log = debug_backtrace();
            //$this->createActionLog($log,0);
            throw new Exception('No privileges');
        }

    }
/*added by Rupali*/
function cities(){
	return $this->pdo->select('cities', '1 ORDER BY city_name ASC');
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
//Airline
public function addAirline($data){
	$this->pdo->insert('airlines',$data);
}
public function getAirline(){
	return $this->pdo->select('airlines','1 ORDER BY name');
}
public function deleteAirline($airline_id){
	$this->pdo->delete('airlines', "id = $airline_id");
}
public function getAirlineDetails($id){
	$row = $this->pdo->select('airlines', "id=$id");
	return $row[0];
}
public function updateAirline($data){
	$this->pdo->update('airlines', $data, "id=$data[id]");
}

//City
public function addCity($data){
	$this->pdo->insert('cities',$data);
}
public function getCities(){
	return $this->pdo->select('cities', '1 ORDER BY city_name');
}
public function deleteCity($city_id){
	$this->pdo->delete('cities', "id = $city_id");
}
public function updateCity($data){
	$this->pdo->update('cities', $data, "id=$data[id]");
}
public function getCityDetails($id){
	$row = $this->pdo->select('cities', "id=$id");
	return $row[0];
}
//hotels

public function addHotel($data){
	$this->pdo->insert('hotels',$data);
}
public function getHotels(){
	return $this->pdo->select('hotels', '1 ORDER BY hotel_name');
}
public function deleteHotel($hotel_id){
	$this->pdo->delete('hotels', "id = $hotel_id");
}
public function updateHotel($data){
	$this->pdo->update('hotels', $data, "id=$data[id]");
}
public function getHotelDetails($id){
	$row = $this->pdo->select('hotels', "id=$id");
	return $row[0];
}

//Cars

public function addCar($data){
	$this->pdo->insert('car_companies',$data);
}
public function getCarscom(){
	return $this->pdo->select('car_companies', '1 ORDER BY 	name');
}
public function deleteCar($car_id){
	$this->pdo->delete('car_companies', "id = $car_id");
}
public function updateCar($data){
	$this->pdo->update('car_companies', $data, "id=$data[id]");
}
public function getCarDetails($id){
	$row = $this->pdo->select('car_companies', "id=$id");
	return $row[0];
}

/*public function getTraveldatewisereport($data){
	try{
		$select = $this->pdo->prepare("select trips.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname from trips 
left join destination_and_departure on trips.id = destination_and_departure.trip_id
			left join emp_list on trips.emp_id = emp_list.id ORDER BY destination_and_departure.date ASC");
		$select->execute();
if(!empty($data['stdate']) && $data['booking_type']=='car'){
		$select = $this->pdo->prepare("select trips.*,car_bookings.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname from trips 
left join car_bookings on trips.id = car_bookings.trip_id
left join destination_and_departure on trips.id = destination_and_departure.trip_id
			left join emp_list on trips.emp_id = emp_list.id  WHERE trips.date >= ? AND trips.date <= ?  GROUP BY trips.id");
		       $select->execute(array($data['stdate'],$data['endate']));
                       }
if(!empty($data['stdate']) && $data['booking_type']=='hotel'){
		$select = $this->pdo->prepare("select trips.*,hotel_bookings.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname from trips 
left join hotel_bookings on trips.id = hotel_bookings.trip_id
left join destination_and_departure on trips.id = destination_and_departure.trip_id
			left join emp_list on trips.emp_id = emp_list.id WHERE trips.date >= ? AND trips.date <= ? GROUP BY trips.id");
		       $select->execute(array($data['stdate'],$data['endate']));
                       }

if(!empty($data['stdate']) && $data['booking_type']=='airline'){
		$select = $this->pdo->prepare("select trips.*,air_bookings.*,destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname from trips 
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

*/

public function getTravelRequestsreport($data){
	try{
                
                    
		if(!empty($data['stdate'])){
		$select = $this->pdo->prepare("select trips.id,trips.date,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id WHERE trips.date >= ? AND trips.date <= ?");
		       $select->execute(array($data['stdate'],$data['endate']));
                       }
                       else{
                            $select = $this->pdo->prepare("select trips.id,trips.date,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id WHERE 1=1");
		       $select->execute();
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
	} #

public function getTravelRequestsBasicReport($data) {
        try {
            if ($data['stdate']) {
                $select = $this->pdo->prepare("SELECT trips.id as trip_id, trips.date as request_date,trips.purpose_of_visit,air_bookings.date as air_travel_date,air_bookings.cost,air_bookings.e_ticket,emp_list.id as emp_id, emp_list.firstname,emp_list.middlename,emp_list.lastname,emp_list.entity,bu_short_name, car_bookings.date as car_travel_date, car_bookings.type_of_vehicle, car_bookings.car_type, car_bookings.car_pickup_location, car_bookings.car_fromdate, car_bookings.car_todate, car_companies.name as car_service_provider, car_bookings.from_location,car_bookings.airport_drop_loca, car_bookings.airport_pickup_loca, car_bookings.car_pickup_location, car_bookings.destination, hotel_bookings.id, hotel_name,hotel_bookings.check_in, hotel_bookings.check_out, hotel_bookings.late_checkin_date, hotel_bookings.late_checkout_date, hotel_bookings.cost as hotel_cost, `visa-country`,train_bookings.date as train_travel_date, train_bookings.boarding_form, train_bookings.train FROM trips left join air_bookings on trips.id = air_bookings.trip_id left join emp_list on emp_list.id=trips.emp_id left join car_bookings on car_bookings.trip_id = trips.id left join hotel_bookings on hotel_bookings.trip_id = trips.id left join visa on visa.emp_id = emp_list.id left join car_companies on car_companies.id = car_bookings.car_company left join hotels on hotels.id = hotel_bookings.hotel_id left join fi_bu on emp_list.bu = fi_bu.id left join train_bookings on train_bookings.trip_id = trips.id WHERE trips.date >= ? AND trips.date <= ? GROUP BY air_travel_date,car_travel_date,train_travel_date,check_in,late_checkin_date ORDER BY trips.id DESC");
                $select->execute(array($data['stdate'], $data['endate']));
            } else {
                $select = $this->pdo->prepare("SELECT trips.id as trip_id, trips.date as request_date,trips.purpose_of_visit,air_bookings.date as air_travel_date,air_bookings.cost,air_bookings.e_ticket,emp_list.id as emp_id, emp_list.firstname,emp_list.middlename,emp_list.lastname,emp_list.entity,bu_short_name, car_bookings.date as car_travel_date, car_bookings.type_of_vehicle, car_bookings.car_type, car_bookings.car_pickup_location, car_bookings.car_fromdate, car_bookings.car_todate, car_companies.name as car_service_provider, car_bookings.from_location,car_bookings.airport_drop_loca, car_bookings.airport_pickup_loca, car_bookings.car_pickup_location, car_bookings.destination, hotel_bookings.id, hotel_name,hotel_bookings.check_in, hotel_bookings.check_out, hotel_bookings.late_checkin_date, hotel_bookings.late_checkout_date, hotel_bookings.cost as hotel_cost, `visa-country`,train_bookings.date as train_travel_date, train_bookings.boarding_form, train_bookings.train FROM trips left join air_bookings on trips.id = air_bookings.trip_id left join emp_list on emp_list.id=trips.emp_id left join car_bookings on car_bookings.trip_id = trips.id left join hotel_bookings on hotel_bookings.trip_id = trips.id left join visa on visa.emp_id = emp_list.id left join car_companies on car_companies.id = car_bookings.car_company left join hotels on hotels.id = hotel_bookings.hotel_id left join fi_bu on emp_list.bu = fi_bu.id left join train_bookings on train_bookings.trip_id = trips.id WHERE 1=1 ORDER BY trips.id DESC");
                $select->execute();
                //print_r($select);exit;
            }
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $trips[] = $row;
        }
        //print_r($trips);exit;
        return $trips;
    }



public function getTravelRequestsBasicReportPagination($data, $page = 0){
	$end_limit = 10;
	if($page == 0){
	$start_limit = 0;
	}
	else{
	$start_limit = $page*10+1;
	}
	
        try{
$select = $this->pdo->prepare("SELECT trips.id as trip_id, trips.date as request_date,trips.purpose_of_visit,air_bookings.date as air_travel_date,air_bookings.cost,air_bookings.e_ticket,emp_list.id as emp_id, emp_list.firstname,emp_list.middlename,emp_list.lastname,emp_list.entity,bu_short_name, car_bookings.date as car_travel_date, car_bookings.type_of_vehicle, car_bookings.car_type, car_bookings.car_pickup_location, car_bookings.car_fromdate, car_bookings.car_todate, car_companies.name as car_service_provider, car_bookings.from_location,car_bookings.airport_drop_loca, car_bookings.airport_pickup_loca, car_bookings.car_pickup_location, car_bookings.destination, hotel_bookings.id, hotel_name,hotel_bookings.check_in, hotel_bookings.check_out, hotel_bookings.late_checkin_date, hotel_bookings.late_checkout_date, hotel_bookings.cost as hotel_cost, `visa-country`,train_bookings.date as train_travel_date, train_bookings.boarding_form, train_bookings.train FROM trips left join air_bookings on trips.id = air_bookings.trip_id left join emp_list on emp_list.id=trips.emp_id left join car_bookings on car_bookings.trip_id = trips.id left join hotel_bookings on hotel_bookings.trip_id = trips.id left join visa on visa.emp_id = emp_list.id left join car_companies on car_companies.id = car_bookings.car_company left join hotels on hotels.id = hotel_bookings.hotel_id left join fi_bu on emp_list.bu = fi_bu.id left join train_bookings on train_bookings.trip_id = trips.id WHERE trips.date >= ? AND trips.date <= ? GROUP BY air_travel_date,car_travel_date,train_travel_date,check_in,late_checkin_date ORDER BY trips.id DESC LIMIT $start_limit,$end_limit");
                $select->execute(array($data['stdate'],$data['endate']));
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
public function getTraveldatewisereport(){
	try{
		$select = $this->pdo->prepare("SELECT trips.id, trips.date,destination_and_departure.return_date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id, emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id and emp_list.id=trips.emp_id  GROUP BY trips.id ORDER BY trips.id DESC");
			$select->execute();
        }

        catch(PDOException $e){ echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
 return $trips;
} ## function ends
public function getTraveldatewisereportpagination($data){
	try{
//

/*
echo "SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND trips.date BETWEEN ".$data['stdate']." AND ".$data['endate']." ORDER BY trips.id DESC";*/
/*************************************Get all booking Records****************************************************/

if((!empty($data['stdate'])) && (!empty($data['endate']))){

	if($data['booking_type']=='car'){

	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY trips.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['endate'],$data['stdate'],$data['endate']));
	}
	else if($data['booking_type']=='hotel'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list,destination_and_departure WHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['endate'],$data['stdate'],$data['endate']));
	}

	else if($data['booking_type']=='airline'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?))
      GROUP BY air_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['endate']));
	}
	else if($data['booking_type']=='train'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,train_bookings.cost,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,train_bookings,emp_list,destination_and_departure WHERE trips.id = train_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['endate'],$data['stdate'],$data['endate']));
	}
else if(empty($data['booking_type']) || $data['booking_type']==" "){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list ,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['endate'],$data['stdate'],$data['endate']));
	}
}
elseif((empty($data['stdate'])) && (!empty($data['endate']))){
if($data['booking_type']=='car'){

	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY car_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['endate'],$data['endate'],$data['endate'],$data['endate']));
	}
	else if($data['booking_type']=='hotel'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list ,destination_and_departureWHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?))GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['endate'],$data['endate'],$data['endate'],$data['endate']));
	}

	else if($data['booking_type']=='airline'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['endate'],$data['endate'],$data['endate'],$data['endate']));
	}
else if($data['booking_type']=='train'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,train_bookings.cost,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,train_bookings,emp_list WHERE trips.id = train_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['endate'],$data['endate'],$data['endate'],$data['endate']));
	}
else if(empty($data['booking_type']) || $data['booking_type']==" "){//print_r($data);
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY car_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['endate'],$data['endate'],$data['endate'],$data['endate']));
	}

}
elseif((!empty($data['stdate'])) && (empty($data['endate']))){

if($data['booking_type']=='car'){

	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY car_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['stdate'],$data['stdate'],$data['stdate']));
	}
	else if($data['booking_type']=='hotel'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list,destination_and_departure WHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['stdate'],$data['stdate'],$data['stdate']));
	}

	else if($data['booking_type']=='airline'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['stdate'],$data['stdate'],$data['stdate']));
	}
else if($data['booking_type']=='train'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,train_bookings.cost,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['stdate'],$data['stdate'],$data['stdate']));
	}
else if(empty($data['booking_type']) || $data['booking_type']==" "){//print_r($data);
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,train_bookings,emp_list,destination_and_departure WHERE trips.id = train_bookings.trip_id AND emp_list.id=trips.emp_id  AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
	$select->execute(array($data['stdate'],$data['stdate'],$data['stdate'],$data['stdate']));
	}
}
elseif((empty($data['stdate'])) && (empty($data['endate']))){

if($data['booking_type']=='car'){

	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id GROUP BY car_bookings.id ORDER BY trips.id DESC");
	$select->execute();
	}
	else if($data['booking_type']=='hotel'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list,destination_and_departure WHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
	$select->execute();
	}

	else if($data['booking_type']=='airline'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  GROUP BY air_bookings.id ORDER BY trips.id DESC");
	$select->execute();
	}
else if($data['booking_type']=='train'){
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,train_bookings.cost,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
	$select->execute();
	}
else if(empty($data['booking_type']) || $data['booking_type']==" "){//print_r($data);
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  GROUP BY air_bookings.id ORDER BY trips.id DESC");
	$select->execute();
	}
}

        }
        catch(PDOException $e){ echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)){
		$trips[] = $row;
	}
		return $trips;
} ## function ends


}// Admin class ends

