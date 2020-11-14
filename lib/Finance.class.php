<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once('Employee.class.php');

class Finance extends Employee {

    public function __construct($user_id) {
        parent::__construct($user_id);
// echo $_SESSION['user_id'];exit;
        if (!$this->isFinance()) {
            $this->_loginRedirect();
            //log failure
            /*
              $log = debug_backtrace();
              $this->createActionLog($log,0);
              throw new Exception('No privileges');
             */
        }
    }

    public function getTravelRequests($start_from, $limit) {
        try {
            $select = $this->pdo->prepare("select trips.id,	trips.trip_type,trips.date,trips.manager_approved,trips.booking_type,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id  Where trips.status='Open' ORDER BY trips.id DESC LIMIT $start_from, $limit");
            $select->execute();
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $trips[] = $row;
        }
        return $trips;
    }

## function ends

    public function getTravelRequestspagination() {
        try {

            $select = $this->pdo->prepare("select trips.id,	trips.trip_type,trips.date,trips.manager_approved,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id  Where trips.status='Open' ORDER BY trips.id DESC");
            $select->execute();
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $trips[] = $row;
        }
        return $trips;
    }

    public function getTravelRequestsreport($data) {
        try {

 
            if (!empty($data['stdate'])) {
                $select = $this->pdo->prepare("select trips.id,trips.date,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou,emp_list.bu from trips left join emp_list on trips.emp_id = emp_list.id WHERE trips.date >= ? AND trips.date <= ? ORDER BY id DESC");
                $select->execute(array($data['stdate'], $data['endate']));
            } else {
                $select = $this->pdo->prepare("select trips.id,trips.date,trips.manager_approved,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou,emp_list.bu from trips left join emp_list on trips.emp_id = emp_list.id WHERE 1=1 ORDER BY id DESC");
                $select->execute();
            }
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $trips[] = $row;
        }
        return $trips;
    }

#

    public function getTraveldatewisereport() {
        try {
            $select = $this->pdo->prepare("SELECT trips.id, trips.date,destination_and_departure.return_date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id, emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id and emp_list.id=trips.emp_id  GROUP BY trips.id ORDER BY trips.id DESC");
            $select->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $trips[] = $row;
        }
        return $trips;
    }

## function ends

    public function getTraveldatewisereportpagination($data) {
        try {
//

            /*
              echo "SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND trips.date BETWEEN ".$data['stdate']." AND ".$data['endate']." ORDER BY trips.id DESC"; */
            /*             * ***********************************Get all booking Records*************************************************** */
//print_r($data);
            if ((!empty($data['stdate'])) && (!empty($data['endate']))) {
                //$stdate = date('Y-m-d', $data['stdate']); 
                //echo $stdate;
                $now = new DateTime($data['stdate']);
                $sdate = $now->format('Y-m-d');
                $now = new DateTime($data['endate']);
                $edate = $now->format('Y-m-d');
                //echo $timestring;

                if ($data['booking_type'] == 'car') {

                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id AND (trips.date >= '".$sdate."'  AND trips.date <= '".$edate."' ) GROUP BY trips.id ORDER BY trips.id DESC");
                     $select->execute();
                } else if ($data['booking_type'] == 'hotel') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list,destination_and_departure WHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id AND (trips.date >= '".$sdate."'  AND trips.date <= '".$edate."' ) GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
                     $select->execute();
                } else if ($data['booking_type'] == 'airline') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND (trips.date >= '".$sdate."'  AND trips.date <= '".$edate."' )
      GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    
                    //$select->execute(array($data['stdate'], $data['endate']));
                    $select->execute();
                    //echo $data['stdate'];echo $data['endate']; print_r($select);
                } else if ($data['booking_type'] == 'train') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,train_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND (trips.date >= '".$sdate."'  AND trips.date <= '".$edate."' ) GROUP BY train_bookings.id ORDER BY trips.id DESC");
                     $select->execute();
                     //print_r($select);
                                 } else if (empty($data['booking_type']) || $data['booking_type'] == " ") {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list ,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  AND (trips.date >= '".$sdate."'  AND trips.date <= '".$edate."' )  GROUP BY air_bookings.id ORDER BY trips.id DESC");
                     $select->execute();
                }
            } elseif((empty($data['stdate'])) && (!empty($data['endate']))){
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
	$select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,train_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
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
        
            } elseif ((empty($data['stdate'])) && (empty($data['endate']))) {

                if ($data['booking_type'] == 'car') {

                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id GROUP BY car_bookings.id ORDER BY trips.id DESC");
                    $select->execute();
                } else if ($data['booking_type'] == 'hotel') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list,destination_and_departure WHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
                    $select->execute();
                } else if ($data['booking_type'] == 'airline') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    $select->execute();
                } else if ($data['booking_type'] == 'train') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,train_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id GROUP BY train_bookings.id ORDER BY trips.id DESC");
                    $select->execute();
                } else if (empty($data['booking_type']) || $data['booking_type'] == " ") {//print_r($data);
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    $select->execute();
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $trips[] = $row;
        }
        return $trips;
    }

## function ends

    public function getTravelRequestsBasicReport($data) {
        try {
            if ($data['stdate']) {
                $select = $this->pdo->prepare("SELECT trips.id as trip_id, trips.date as request_date,trips.purpose_of_visit,air_bookings.date as air_travel_date,air_bookings.cost,air_bookings.e_ticket,emp_list.id as emp_id, emp_list.firstname,emp_list.middlename,emp_list.lastname,emp_list.entity,bu_short_name, car_bookings.date as car_travel_date, car_bookings.type_of_vehicle, car_bookings.car_type, car_bookings.car_pickup_location, car_bookings.car_fromdate, car_bookings.car_todate, car_companies.name as car_service_provider, car_bookings.from_location,car_bookings.airport_drop_loca, car_bookings.airport_pickup_loca, car_bookings.car_pickup_location, car_bookings.destination, hotel_bookings.id, hotel_name,hotel_bookings.check_in, hotel_bookings.check_out, hotel_bookings.late_checkin_date, hotel_bookings.late_checkout_date, hotel_bookings.cost as hotel_cost, `visa-country`,train_bookings.date as train_travel_date, train_bookings.boarding_form, train_bookings.train FROM trips left join air_bookings on trips.id = air_bookings.trip_id left join emp_list on emp_list.id=trips.emp_id left join car_bookings on car_bookings.trip_id = trips.id left join hotel_bookings on hotel_bookings.trip_id = trips.id left join visa on visa.emp_id = emp_list.id left join car_companies on car_companies.id = car_bookings.car_company left join hotels on hotels.id = hotel_bookings.hotel_id left join fi_bu on emp_list.bu = fi_bu.id left join train_bookings on train_bookings.trip_id = trips.id WHERE trips.date BETWEEN '".$data['stdate']."' AND  '".$data['endate']."'   ORDER BY trips.id DESC");
                $select->execute();
               //print_r($data);
                //print_r($select);exit;
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

## function ends

    public function getTravelRequestsBasicReportPagination($data, $page = 0) {


        try {
            $select = $this->pdo->prepare("SELECT trips.id as trip_id, trips.date as request_date,trips.purpose_of_visit,air_bookings.date as air_travel_date,air_bookings.cost,air_bookings.e_ticket,emp_list.id as emp_id, emp_list.firstname,emp_list.middlename,emp_list.lastname,emp_list.entity,bu_short_name, car_bookings.date as car_travel_date, car_bookings.type_of_vehicle, car_bookings.car_type, car_bookings.car_pickup_location, car_bookings.car_fromdate, car_bookings.car_todate, car_companies.name as car_service_provider, car_bookings.from_location,car_bookings.airport_drop_loca, car_bookings.airport_pickup_loca, car_bookings.car_pickup_location, car_bookings.destination, hotel_bookings.id, hotel_name,hotel_bookings.check_in, hotel_bookings.check_out, hotel_bookings.late_checkin_date, hotel_bookings.late_checkout_date, hotel_bookings.cost as hotel_cost, `visa-country`,train_bookings.date as train_travel_date, train_bookings.boarding_form, train_bookings.train FROM trips left join air_bookings on trips.id = air_bookings.trip_id left join emp_list on emp_list.id=trips.emp_id left join car_bookings on car_bookings.trip_id = trips.id left join hotel_bookings on hotel_bookings.trip_id = trips.id left join visa on visa.emp_id = emp_list.id left join car_companies on car_companies.id = car_bookings.car_company left join hotels on hotels.id = hotel_bookings.hotel_id left join fi_bu on emp_list.bu = fi_bu.id left join train_bookings on train_bookings.trip_id = trips.id WHERE trips.date >= ? AND trips.date <= ? GROUP BY air_travel_date,car_travel_date,train_travel_date,check_in,late_checkin_date ORDER BY trips.id DESC LIMIT $start_limit,$end_limit");
            $select->execute(array($data['stdate'], $data['endate']));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $trips[] = $row;
        }
        return $trips;
    }
/*added by Rupali*/
/*function getbus($id){

try{
		$select = $this->pdo->prepare("SELECT * FROM fi_bu WHERE id = ?");
	$select->execute(array($id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row;
}*/
## function ends
}
