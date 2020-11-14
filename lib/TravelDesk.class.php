<?php

include_once('User.class.php');

class TravelDesk extends User {

    public function __construct($user_id) {
        parent::__construct($user_id);

        if (!$this->isTravelDesk()) {
            $this->_loginRedirect();
            //log failure
            /*
              $log = debug_backtrace();
              $this->createActionLog($log,0);
             */
            throw new Exception('No privileges');
        }
    }

    public function getTravelRequests($start_from, $limit) {
        try {
            $select = $this->pdo->prepare("select trips.id,	trips.trip_type,trips.booking_type,trips.date,trips.manager_approved,emp_list.firstname,
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

            $select = $this->pdo->prepare("select trips.id,	trips.trip_type,trips.booking_type,trips.date,trips.manager_approved,emp_list.firstname,
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

## function ends

    public function getTravelRequestsreport($data) {
        try {

            $select = $this->pdo->prepare("select trips.id,trips.date,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id WHERE 1=1");
            $select->execute();
            if (!empty($data['stdate'])) {
                $select = $this->pdo->prepare("select trips.id,trips.date,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips left join emp_list on trips.emp_id = emp_list.id WHERE trips.date >= ? AND trips.date <= ?");
                $select->execute(array($data['stdate'], $data['endate']));
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

## function ends

    public function getTravelRequestsplan() {
        try {
            $select = $this->pdo->prepare("select trips.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips 
			left join emp_list on trips.emp_id = emp_list.id");
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

            if ((!empty($data['stdate'])) && (!empty($data['endate']))) {

                if ($data['booking_type'] == 'car') {

                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY trips.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['endate'], $data['stdate'], $data['endate']));
                } else if ($data['booking_type'] == 'hotel') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list,destination_and_departure WHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['endate'], $data['stdate'], $data['endate']));
                } else if ($data['booking_type'] == 'airline') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?))
      GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['endate']));
                } else if ($data['booking_type'] == 'train') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,train_bookings.cost,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,train_bookings,emp_list,destination_and_departure WHERE trips.id = train_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['endate'], $data['stdate'], $data['endate']));
                } else if (empty($data['booking_type']) || $data['booking_type'] == " ") {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list ,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['endate'], $data['stdate'], $data['endate']));
                }
            } elseif ((empty($data['stdate'])) && (!empty($data['endate']))) {
                if ($data['booking_type'] == 'car') {

                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY car_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['endate'], $data['endate'], $data['endate'], $data['endate']));
                } else if ($data['booking_type'] == 'hotel') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list ,destination_and_departureWHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?))GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['endate'], $data['endate'], $data['endate'], $data['endate']));
                } else if ($data['booking_type'] == 'airline') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['endate'], $data['endate'], $data['endate'], $data['endate']));
                } else if ($data['booking_type'] == 'train') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,train_bookings.cost,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,train_bookings,emp_list WHERE trips.id = train_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['endate'], $data['endate'], $data['endate'], $data['endate']));
                } else if (empty($data['booking_type']) || $data['booking_type'] == " ") {//print_r($data);
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id  AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY car_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['endate'], $data['endate'], $data['endate'], $data['endate']));
                }
            } elseif ((!empty($data['stdate'])) && (empty($data['endate']))) {

                if ($data['booking_type'] == 'car') {

                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit, car_bookings.car_company,car_bookings.car_size,car_bookings.need_car,car_bookings.car_pickup_location,car_bookings.destination,car_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename FROM trips, car_bookings,emp_list,destination_and_departure  WHERE  trips.id = car_bookings.trip_id  AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY car_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['stdate'], $data['stdate'], $data['stdate']));
                } else if ($data['booking_type'] == 'hotel') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,hotel_bookings.hotel_id,hotel_bookings.hotel_id,hotel_bookings.check_in,hotel_bookings.check_in,hotel_bookings.check_out,hotel_bookings.hotel_confirmation_num,hotel_bookings.late_checkout,hotel_bookings.cost,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM  trips, hotel_bookings,emp_list,destination_and_departure WHERE trips.id = hotel_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY hotel_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['stdate'], $data['stdate'], $data['stdate']));
                } else if ($data['booking_type'] == 'airline') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['stdate'], $data['stdate'], $data['stdate']));
                } else if ($data['booking_type'] == 'train') {
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,train_bookings.cost,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['stdate'], $data['stdate'], $data['stdate']));
                } else if (empty($data['booking_type']) || $data['booking_type'] == " ") {//print_r($data);
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,air_bookings.travel_from,air_bookings.travel_to,air_bookings.book_airline,air_bookings.meal_preference,air_bookings.cost,air_bookings.ticket_number,emp_list.id as emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,train_bookings,emp_list,destination_and_departure WHERE trips.id = train_bookings.trip_id AND emp_list.id=trips.emp_id  AND  ((trips.date BETWEEN ? AND ?)
     OR(trips.date = ? OR trips.date = ?)) GROUP BY air_bookings.id ORDER BY trips.id DESC");
                    $select->execute(array($data['stdate'], $data['stdate'], $data['stdate'], $data['stdate']));
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
                    $select = $this->pdo->prepare("SELECT trips.id, trips.date,trips.purpose_of_visit,train_bookings.train_from,train_bookings.train_to,train_bookings.class,train_bookings.train_id,train_bookings.boarding_form,train_bookings.train,train_bookings.age,emp_list.id as 				emp_id ,emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename  FROM trips,air_bookings,train_bookings.cost,emp_list,destination_and_departure WHERE trips.id = air_bookings.trip_id AND emp_list.id=trips.emp_id AND ((trips.date BETWEEN ? AND ?)
	     OR(trips.date = ? OR trips.date = ?)) GROUP BY train_bookings.id ORDER BY trips.id DESC");
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

    public function getAirlinebookingreport() {
        try {
            $select = $this->pdo->prepare("select trips.*,air_bookings.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips 
left join air_bookings on trips.id = air_bookings.trip_id
			left join emp_list on trips.emp_id = emp_list.id ");
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

    public function getCarbookingreport() {
        try {
            $select = $this->pdo->prepare("select trips.*,car_bookings.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips 
left join car_bookings on trips.id = car_bookings.trip_id
			left join emp_list on trips.emp_id = emp_list.id ");
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

    public function getHotelbookingreport() {
        try {
            $select = $this->pdo->prepare("select trips.*,hotel_bookings.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from trips 
left join hotel_bookings on trips.id = hotel_bookings.trip_id
			left join emp_list on trips.emp_id = emp_list.id ");
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

    /* added by Rupali */

    public function getTripDetails($trip_id) {

        try {
            $select = $this->pdo->prepare("select trips.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou,emp_list.bu ,emp_list.email ,emp_list.contact_no ,emp_list.address1 ,emp_list.address2 from trips left join emp_list on trips.emp_id = emp_list.id WHERE trips.id = ?");
            $select->execute(array($trip_id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* added by Rupali */

    function getous($id) {

        try {
            $select = $this->pdo->prepare("SELECT * FROM fi_ou WHERE id = ?");
            $select->execute(array($id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* added by Rupali */

    function getbus($id) {

        try {
            $select = $this->pdo->prepare("SELECT * FROM fi_bu WHERE id = ?");
            $select->execute(array($id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* added by Rupali */

    public function getcity($id) {

        try {
            $select = $this->pdo->prepare("SELECT * FROM cities WHERE id = ?");
            $select->execute(array($id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* added by Rupali */

    public function gethotel($id) {

        try {
            $select = $this->pdo->prepare("SELECT * FROM hotels WHERE id = ?");
            $select->execute(array($id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* added by Rupali */

    public function getcars($id) {

        try {
            $select = $this->pdo->prepare("SELECT * FROM car_companies WHERE id = ?");
            $select->execute(array($id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* added by Rupali */

    public function getairlines($id) {

        try {
            $select = $this->pdo->prepare("SELECT * FROM airlines WHERE id = ?");
            $select->execute(array($id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* added by Rupali */

    public function getdestdep($id) {
//echo $id;
        try {
            //$select = $this->pdo->prepare("SELECT destination_and_departure.*,emp_list.* FROM destination_and_departure  left join on emp_list.id=destination_and_departure.emp_id  WHERE destination_and_departure.trip_id = ?");
            /*
              $select = $this->pdo->prepare("select destination_and_departure.*,emp_list.firstname,
             */
            $select = $this->pdo->prepare("select destination_and_departure.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from destination_and_departure left join emp_list on destination_and_departure.emp_id = emp_list.id WHERE destination_and_departure.trip_id = ? ORDER BY destination_and_departure.id ASC");

            $select->execute(array($id));
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
        //$row = $select->fetch(PDO::FETCH_ASSOC);


        $row = $select->fetchAll(PDO::FETCH_ASSOC); //print_r($row);
        return $row;
    }

    /* added by Rupali */

    public function getdestdepairline($id) {
//echo $id;
        try {
            //$select = $this->pdo->prepare("SELECT destination_and_departure.*,emp_list.* FROM destination_and_departure  left join on emp_list.id=destination_and_departure.emp_id  WHERE destination_and_departure.trip_id = ?");
            $select = $this->pdo->prepare("SELECT destination_and_departure . * , trips . * , emp_list.firstname, emp_list.middlename, emp_list.lastname, emp_list.ou
	FROM destination_and_departure
	LEFT JOIN emp_list ON destination_and_departure.emp_id = emp_list.id
	LEFT JOIN trips ON trips.id = destination_and_departure.trip_id
	WHERE destination_and_departure.trip_id =?
	AND (
	trips.only_car_booking = 'no'
	OR trips.only_car_booking IS NULL
	)
	AND (
	trips.only_hotel_booking = 'no'
	OR trips.only_hotel_booking IS NULL
	)");

            $select->execute(array($id));
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
        //$row = $select->fetch(PDO::FETCH_ASSOC);


        $row = $select->fetchAll(PDO::FETCH_ASSOC); //print_r($row);
        return $row;
    }

    /* added by Rupali */

    public function getdestdephotel($id) {
//echo $id;
        try {
            //$select = $this->pdo->prepare("SELECT destination_and_departure.*,emp_list.* FROM destination_and_departure  left join on emp_list.id=destination_and_departure.emp_id  WHERE destination_and_departure.trip_id = ?");
            $select = $this->pdo->prepare("select destination_and_departure.*,trips.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from destination_and_departure left join emp_list on destination_and_departure.emp_id = emp_list.id 
left join trips on trips.id=destination_and_departure.trip_id WHERE destination_and_departure.trip_id = ? AND trips.only_hotel_booking='yes'");

            $select->execute(array($id));
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
        //$row = $select->fetch(PDO::FETCH_ASSOC);


        $row = $select->fetchAll(PDO::FETCH_ASSOC); //print_r($row);
        return $row;
    }

    /* added by Rupali */

    public function getdestdepcar($id) {
//echo $id;
        try {
            //$select = $this->pdo->prepare("SELECT destination_and_departure.*,emp_list.* FROM destination_and_departure  left join on emp_list.id=destination_and_departure.emp_id  WHERE destination_and_departure.trip_id = ?");
            $select = $this->pdo->prepare("select destination_and_departure.*,trips.*,emp_list.firstname,
			emp_list.middlename,emp_list.lastname,emp_list.ou from destination_and_departure left join emp_list on destination_and_departure.emp_id = emp_list.id 
left join trips on trips.id=destination_and_departure.trip_id WHERE destination_and_departure.trip_id = ? AND trips.only_car_booking='yes'");

            $select->execute(array($id));
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
        //$row = $select->fetch(PDO::FETCH_ASSOC);


        $row = $select->fetchAll(PDO::FETCH_ASSOC); //print_r($row);
        return $row;
    }

    /*     * * added by pravin  **** */

    public function getDestDepartReport() {
        try {

            $select = $this->pdo->prepare("SELECT destination_and_departure.id as req_id,trips.date as req_date,air_bookings.ticket_number as ticket_number,
		address1,address2,emp_list.city,fi_bu.bu_short_name as bu_name,trips.purpose_of_visit,emp_list.id as emp_id,
		emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename,emp_list.email,destination_and_departure.return_date,destination_and_departure.book_airline,
		fi_office_locations.location as location_name,airlines.name as airline_name,destination_and_departure.travel_from,destination_and_departure.travel_to,destination_and_departure.car_type,destination_and_departure.car_size,
hotels.hotel_name,destination_and_departure.checkindate,destination_and_departure.checkoutdate,destination_and_departure.late_checkin_date,destination_and_departure.late_checkout_date,destination_and_departure.car_company,destination_and_departure.trip_id,trips.emp_id as trip_emp,destination_and_departure.pref_hotel,destination_and_departure.otherhotel,destination_and_departure.otherair,destination_and_departure.otheronwardcity,destination_and_departure.othertravel_to,
		trips.booking_type
		FROM destination_and_departure
                LEFT JOIN trips ON destination_and_departure.trip_id = trips.id
		LEFT JOIN emp_list ON emp_list.id = trips.emp_id
		LEFT JOIN fi_office_locations ON fi_office_locations.id = emp_list.location
		LEFT JOIN airlines ON airlines.id = destination_and_departure.book_airline
                LEFT JOIN air_bookings ON air_bookings.trip_id = trips.id
		LEFT JOIN fi_bu ON fi_bu.id = emp_list.bu
		LEFT JOIN hotels ON hotels.id = destination_and_departure.pref_hotel
		WHERE 1=1 
		GROUP BY destination_and_departure.id ORDER BY trips.id DESC");

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

    public function getDestDepartByFilter($details) {
        $stdate = date("Y-m-d", strtotime($details['stdate']));
        $endate = date("Y-m-d", strtotime($details['endate']));

        $sel = "SELECT destination_and_departure.id as req_id,trips.date as req_date,air_bookings.ticket_number as ticket_number,
		emp_list.address1,emp_list.address2,emp_list.city,fi_bu.bu_short_name as bu_name,trips.purpose_of_visit,emp_list.id as emp_id,
		emp_list.firstname,emp_list.ou,emp_list.lastname,emp_list.middlename,emp_list.email,destination_and_departure.return_date,destination_and_departure.book_airline,
		fi_office_locations.location as location_name,airlines.name as airline_name,destination_and_departure.travel_from,destination_and_departure.travel_to,destination_and_departure.car_type,destination_and_departure.car_size,hotels.hotel_name,destination_and_departure.checkindate,destination_and_departure.checkoutdate,destination_and_departure.late_checkin_date,destination_and_departure.late_checkout_date,destination_and_departure.car_company,destination_and_departure.trip_id,trips.emp_id as trip_emp,destination_and_departure.pref_hotel,destination_and_departure.otherhotel,destination_and_departure.otherair,destination_and_departure.otheronwardcity,destination_and_departure.othertravel_to,
		trips.booking_type
		FROM destination_and_departure
                LEFT JOIN trips ON destination_and_departure.trip_id = trips.id
		LEFT JOIN emp_list ON emp_list.id = trips.emp_id
		LEFT JOIN fi_office_locations ON fi_office_locations.id = emp_list.location
		LEFT JOIN airlines ON airlines.id = destination_and_departure.book_airline
                LEFT JOIN air_bookings ON air_bookings.dest_dept_id = destination_and_departure.id
		LEFT JOIN fi_bu ON fi_bu.id = emp_list.bu
		LEFT JOIN hotels ON hotels.id = destination_and_departure.pref_hotel
		WHERE 1=1 ";

        if (!empty($details['trip_id'])) {
            $sel .= " AND trips.id = " . $details['trip_id'] . " ";
        }
        if (!empty($details['booking_type'])) {
            $sel .= " AND trips.booking_type = '" . $details['booking_type'] . "' ";
        }
        if (!empty($details['stdate']) && !empty($details['endate'])) {
            $sel .= " AND ((trips.date BETWEEN '" . $stdate . "' AND '" . $endate . "') ";
            $sel .= " OR (trips.date = '" . $stdate . "' OR trips.date = '" . $endate . "' )) ";
        }
        $sel .= " GROUP BY destination_and_departure.id ORDER BY trips.id DESC";

        try {
            $res = $this->pdo->query($sel);
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function deleteAirBooking($id) {
        $this->pdo->delete('air_bookings', "id = $id");
    }

    public function deleteCarBooking($id) {
        $this->pdo->delete('car_bookings', "id = $id");
    }

    public function deleteHotelBooking($id) {
        $this->pdo->delete('hotel_bookings', "id = $id");
    }

    public function deleteTrainBooking($id) {
        $this->pdo->delete('train_bookings', "id = $id");
    }

    /* added by Rupali */

    function travelrequestsuggestedplan($data) {//print_r($data);
        try {
            $id = $data['trip_id'];

            if (is_array($data['book_airline'])) {
                //echo $c=count($data['travel_from']);
                for ($x = 0; $x <= count($data['book_airline']); $x++) {

                    $stmt3 = "INSERT INTO `air_bookings`  (`emp_id`,`book_airline`,`travel_from`,`travel_to`,`date`,`approved`,`trip_id`)VALUES(?,?,?,?,?,?,?)";
                    $stmt3 = $this->pdo->prepare($stmt3);
                    $stmt3->execute(array($_SESSION['user_id'], $data['book_airline'][$x], $data['travel_from'][$x], $data['travel_to'][$x], $data['date'][$x], 'y', $id));

                    $stmt1 = "INSERT INTO hotel_bookings (`emp_id`,`hotel_id`,`booked_by`,`status`,`approved`,`trip_id`)VALUES(?,?,?,?,?,?)";
                    $stmt1 = $this->pdo->prepare($stmt1);
                    $stmt1->execute(array($_SESSION['user_id'], $data['hotel_id'][$x], $_SESSION['user_id'], 'confirmed', 'n', $id));


                    $stmt2 = "INSERT INTO car_bookings (`emp_id`,`car_company`,`approved`,`trip_id`)VALUES(?,?,?,?)";
                    $stmt2 = $this->pdo->prepare($stmt2);
                    $stmt2->execute(array($_SESSION['user_id'], $data['car_company'][$x], 'n', $id));
                }
            }
            return true;
        } catch (PDOException $e) {
            // check if username already exists in the system
            //$this->setError($e->getCode());
            $this->setError($e->getMessage());
        }
    }

    function airBookings($data) {
        try {    //print_r($data);exit;
            $id = $data['trip_id'];
            $stmt3 = "INSERT INTO `air_bookings`  (`emp_id`,`book_airline`,`otherair`,`travel_from`,`travel_to`,`date`,`approved`,`trip_id`,`meal_preference`,`departure_time`,`cost`,`otheronwardcity`,`othertravel_to`,`preferred_airline_time`,`ticket_number`,`dest_dept_id`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt3 = $this->pdo->prepare($stmt3);
            $stmt3->execute(array($data['tripempid'], $data['book_airline'], $data['otherair'], $data['travel_from'], $data['travel_to'], $data['date'], 'y', $id, $data['meal_preference'], $data['departure_time'], $data['cost'], $data['otheronwardcity'], $data['othertravel_to'], $data['preferred_airline_time'], $data['ticket_number'], $data['dest_dept_id']));
            $air_booking_id = $this->pdo->lastInsertId();
            //$this->travelrequestbookinground($data); 
            #################
            $path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/e-tickets/";
            if ($_FILES['e-ticket']['name'] != '') {
                $uid = md5(uniqid(time()));
                $fname = $this->user_id . "_" . $uid . "_" . $id . $_FILES['e-ticket']['name'];
                $ftmpname = $_FILES['e-ticket']['tmp_name'];
                if (move_uploaded_file($ftmpname, $path . $fname)) {
                    $update_qry = $this->pdo->prepare("UPDATE air_bookings SET `e_ticket`=? WHERE id=?");
                    $update_qry->execute(array($fname, $air_booking_id));
                }
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->setError($e->getMessage());
        }
    }

       function carBookings($data) {

     try { //print_r($data);
            $id = $data['trip_id'];
            ###### Newly Added code SKK
            /* if(!empty($data['airport_drop_loca'])){
              $data['airport_pickup']= 'yes';

              }
              else if(!empty($data['from_location'])){
              $data['airport_drop'] = 'yes';

              } */
            ###### Newly Added code ends SKK
      if ($data['trip_type'] == "multicity") {

      $stmt2 = "INSERT INTO car_bookings(`emp_id`,`car_company`,`approved`,`trip_id`,`date`,`car_fromdate`,`car_todate`,`type_of_vehicle`,`pickup_time`,`airport_pickup_loca`,`need_car`,`airport_pickup`,`airport_drop`,`airport_drop_loca`,`car_for_city`,`cost`,
      `car_type`,`car_size`,`car_pickup_location`,`destination`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt2 = $this->pdo->prepare($stmt2);
      $stmt2->execute(array($data['tripempid'], $data['car_company'], 'n', $id, $data['car_pickup_date'], $data['car_fromdate'], $data['car_todate'], $data['type_of_vehicle'], $data['pickup_time'], $data['airport_pickup_loca'], $data['need_car'], $data['airport_pickup'], $data['airport_drop'], $data['airport_drop_loca'], $data['car_city'], $data['cost'], $data['car_type'], $data['car_size'], $data['car_pickup_location'], $data['destination']));
      } else {
      $stmt2 = "INSERT INTO car_bookings (`emp_id`,`car_company`,`approved`,`trip_id`,`date`,`car_fromdate`,`car_todate`,`type_of_vehicle`,`pickup_time`,`airport_pickup_loca`,`need_car`,`airport_pickup`,`airport_drop`,`airport_drop_loca`,`cost`,`car_type`,
      `car_size`,`car_pickup_location`,`destination`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt2 = $this->pdo->prepare($stmt2);
      $stmt2->execute(array($data['tripempid'], $data['car_company'], 'n', $id, $data['car_pickup_date'], $data['car_fromdate'], $data['car_todate'], $data['type_of_vehicle'], $data['pickup_time'], $data['airport_pickup_loca'], $data['need_car'], $data['airport_pickup'], $data['airport_drop'], $data['airport_drop_loca'], $data['cost'], $data['car_type'], $data['car_size'], $data['car_pickup_location'], $data['destination']));
      }
      return true;
      } catch (PDOException $e) {
      echo $e->getMessage();
      $this->setError($e->getMessage());
      }
      } 

    /* function hotelBookings($data) {
      try { //print_r($data);
      $id = $data['trip_id'];

      if ($data['trip_type'] == "multicity") {

      //echo "inside multicity insert";
      $stmt1 = "INSERT INTO hotel_bookings (`request_id`,`emp_id`,`hotel_id`,`status`,`approved`,`noofguests`,`noofrooms`,`room_type`,`otherhotel`,`trip_id`,`check_in`,`check_out`,`hotel_confirmation_num`,`hotel_for_city`,`cost`,`late_checkin`,`late_checkout`,`late_checkin_date`,`late_checkout_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt1 = $this->pdo->prepare($stmt1);
      $stmt1->execute(array($data['bookingrequestid'], $data['tripempid'], $data['hotel_id'], 'confirmed', 'n', $data['noofguests'], $data['noofrooms'], $data['room_type'], $data['otherhotel'], $id, $data['check_in'], $data['check_out'], $data['hotel_confirmation_num'], $data['hotel_city'], $data['cost'], $data['late_checkin'], $data['late_checkout'], $data['late_checkin_date'], $data['late_checkout_date']));
      } else {
      //echo "inside insert";
      $stmt1 = "INSERT INTO hotel_bookings (`request_id`,`emp_id`,`hotel_id`,`status`,`approved`,`noofguests`,`noofrooms`,`room_type`,`otherhotel`,`trip_id`,`check_in`,`check_out`,`hotel_confirmation_num`,`cost`,`late_checkin`,
      `late_checkout`,`late_checkin_date`,`late_checkout_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt1 = $this->pdo->prepare($stmt1);
      $stmt1->execute(array($data['bookingrequestid'], $data['tripempid'], $data['hotel_id'], 'confirmed', 'n', $data['noofguests'], $data['noofrooms'], $data['room_type'], $data['otherhotel'], $id, $data['check_in'], $data['check_out'], $data['hotel_confirmation_num'], $data['cost'], $data['late_checkin'], $data['late_checkout'], $data['late_checkin_date'], $data['late_checkout_date']));
      }
      return true;
      } catch (PDOException $e) {
      echo $e->getMessage();
      $this->setError($e->getMessage());
      }
      }
     */

    //by rutuja
    function hotelBookings($data) {
        try { //print_r($data);
            $id = $data['trip_id'];

            if ($data['trip_type'] == "multicity") {
                $select = $this->pdo->prepare("SELECT count(*) as num_rows FROM `hotel_bookings` WHERE request_id=" . $data['bookingrequestid'] . "");
                $result = $select->execute();
                $num_rows = $select->fetchColumn();

                if ($num_rows == 0) {
                    //echo "inside multicity insert";
                    $stmt1 = "INSERT INTO hotel_bookings (`request_id`,`emp_id`,`hotel_id`,`status`,`approved`,`noofguests`,`noofrooms`,`room_type`,`otherhotel`,`trip_id`,`check_in`,`check_out`,`hotel_confirmation_num`,`hotel_for_city`,`cost`,`late_checkin`,`late_checkout`,`late_checkin_date`,`late_checkout_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt1 = $this->pdo->prepare($stmt1);
                    $stmt1->execute(array($data['bookingrequestid'], $data['tripempid'], $data['hotel_id'], 'confirmed', 'n', $data['noofguests'], $data['noofrooms'], $data['room_type'], $data['otherhotel'], $id, $data['check_in'], $data['check_out'], $data['hotel_confirmation_num'], $data['hotel_city'], $data['cost'], $data['late_checkin'], $data['late_checkout'], $data['late_checkin_date'], $data['late_checkout_date']));
                } else {
                    //echo "inside multicity update";
                    $stmt1 = "UPDATE `hotel_bookings` SET `hotel_id`=" . $data['hotel_id'] . ",`check_in`='" . $data['check_in'] . "',`check_out`='" . $data['check_out'] . "',`status`='confirmed',`approved`='n',`trip_id`=" . $id . ",`cost`=" . $data['cost'] . ",`hotel_confirmation_num`='" . $data['hotel_confirmation_num'] . "',`hotel_for_city`=" . $data['hotel_city'] . ",`late_checkin`='" . $data['late_checkin'] . "',`late_checkout`='" . $data['late_checkout'] . "',`late_checkin_date`='" . $data['late_checkin_date'] . "',`late_checkout_date`='" . $data['late_checkout_date'] . "',`noofguests`=" . $data['noofguests'] . ",`noofrooms`=" . $data['noofrooms'] . ",`room_type`='" . $data['room_type'] . "',`otherhotel`='" . $data['otherhotel'] . "'  WHERE request_id=" . $data['bookingrequestid'] . "";
                    $stmt1 = $this->pdo->prepare($stmt1);
                    $stmt1->execute();
                }
            } else { //print_r($data);exit;
                $select = $this->pdo->prepare("SELECT count(*) as num_rows FROM `hotel_bookings` WHERE request_id=" . $data['bookingrequestid'] . "");
                $result = $select->execute();
                $num_rows = $select->fetchColumn();
                //echo $num_rows;
                if ($num_rows == 0) {
                    //echo "inside insert";
                    $stmt1 = "INSERT INTO hotel_bookings (`request_id`,`emp_id`,`hotel_id`,`status`,`approved`,`noofguests`,`noofrooms`,`room_type`,`otherhotel`,`trip_id`,`check_in`,`check_out`,`hotel_confirmation_num`,`cost`,`late_checkin`,
      `late_checkout`,`late_checkin_date`,`late_checkout_date`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt1 = $this->pdo->prepare($stmt1);
                    $stmt1->execute(array($data['bookingrequestid'], $data['tripempid'], $data['hotel_id'], 'confirmed', 'n', $data['noofguests'], $data['noofrooms'], $data['room_type'], $data['otherhotel'], $id, $data['check_in'], $data['check_out'], $data['hotel_confirmation_num'], $data['cost'], $data['late_checkin'], $data['late_checkout'], $data['late_checkin_date'], $data['late_checkout_date']));
                } else {
                    //echo "inside update";
                    $stmt1 = "UPDATE `hotel_bookings` SET `hotel_id`=" . $data['hotel_id'] . ",`check_in`='" . $data['check_in'] . "',`check_out`='" . $data['check_out'] . "',`status`='confirmed',`approved`='n',`trip_id`=" . $id . ",`cost`=" . $data['cost'] . ",`hotel_confirmation_num`='" . $data['hotel_confirmation_num'] . "',`late_checkin`='" . $data['late_checkin'] . "',`late_checkout`='" . $data['late_checkout'] . "',`late_checkin_date`='" . $data['late_checkin_date'] . "',`late_checkout_date`='" . $data['late_checkout_date'] . "',`noofguests`=" . $data['noofguests'] . ",`noofrooms`=" . $data['noofrooms'] . ",`room_type`='" . $data['room_type'] . "',`otherhotel`='" . $data['otherhotel'] . "'  WHERE request_id=" . $data['bookingrequestid'] . "";
                    $stmt1 = $this->pdo->prepare($stmt1);
                    //print_r($stmt1);
                    $stmt1->execute();
                }
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->setError($e->getMessage());
        }
    }

//by rutuja
    /*
    function carBookings($data) {
        try { //print_r($data);
            $id = $data['trip_id'];
            ###### Newly Added code SKK
            /* if(!empty($data['airport_drop_loca'])){
              $data['airport_pickup']= 'yes';

              }
              else if(!empty($data['from_location'])){
              $data['airport_drop'] = 'yes';

              }
            ###### Newly Added code ends SKK
            if ($data['trip_type'] == "multicity") {
                $select = $this->pdo->prepare("SELECT count(*) as num_rows FROM `car_bookings` WHERE request_id=" . $data['bookingrequestid'] . "");
                $result = $select->execute();
                $num_rows = $select->fetchColumn();
                if ($num_rows == 0) {
                    $stmt2 = "INSERT INTO car_bookings(`request_id`,`emp_id`,`car_company`,`approved`,`trip_id`,`date`,`car_fromdate`,`car_todate`,`type_of_vehicle`,`pickup_time`,`airport_pickup_loca`,`need_car`,`airport_pickup`,`airport_drop`,`airport_drop_loca`,`car_for_city`,`cost`,
		`car_type`,`car_size`,`car_pickup_location`,`destination`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt2 = $this->pdo->prepare($stmt2);
                    $stmt2->execute(array($data['bookingrequestid'], $data['tripempid'], $data['car_company'], 'n', $id, $data['car_pickup_date'], $data['car_fromdate'], $data['car_todate'], $data['type_of_vehicle'], $data['pickup_time'], $data['airport_pickup_loca'], $data['need_car'], $data['airport_pickup'], $data['airport_drop'], $data['airport_drop_loca'], $data['car_city'], $data['cost'], $data['car_type'], $data['car_size'], $data['car_pickup_location'], $data['destination']));
                } else {
                    $stmt1 = "UPDATE `car_bookings` SET `car_company`=" . $data['car_company'] . ",``date``='" . $data['car_pickup_date'] . "',`car_fromdate`='" . $data['check_out'] . "',`car_todate`='confirmed',`type_of_vehicle`='n',`pickup_time`=" . $id . ",`airport_pickup_loca`=" . $data['cost'] . ",`airport_pickup`='" . $data['hotel_confirmation_num'] . "',`airport_drop`='" . $data['late_checkin'] . "',`airport_drop_loca`='" . $data['late_checkout'] . "',`late_checkin_date`='" . $data['late_checkin_date'] . "',`late_checkout_date`='" . $data['late_checkout_date'] . "',`noofguests`=" . $data['noofguests'] . ",`noofrooms`=" . $data['noofrooms'] . ",`room_type`='" . $data['room_type'] . "',`otherhotel`='" . $data['otherhotel'] . "'  WHERE request_id=" . $data['bookingrequestid'] . "";
                    $stmt1 = $this->pdo->prepare($stmt1);
                    //print_r($stmt1);
                    $stmt1->execute();
                }
            } else {
                $select = $this->pdo->prepare("SELECT count(*) as num_rows FROM `car_bookings` WHERE request_id=" . $data['bookingrequestid'] . "");
                $result = $select->execute();
                $num_rows = $select->fetchColumn();
                if ($num_rows == 0) {
                    $stmt2 = "INSERT INTO car_bookings (`request_id`,`emp_id`,`car_company`,`approved`,`trip_id`,`date`,`car_fromdate`,`car_todate`,`type_of_vehicle`,`pickup_time`,`airport_pickup_loca`,`need_car`,`airport_pickup`,`airport_drop`,`airport_drop_loca`,`cost`,`car_type`,
		`car_size`,`car_pickup_location`,`destination`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt2 = $this->pdo->prepare($stmt2);
                    $stmt2->execute(array($data['bookingrequestid'], $data['tripempid'], $data['car_company'], 'n', $id, $data['car_pickup_date'], $data['car_fromdate'], $data['car_todate'], $data['type_of_vehicle'], $data['pickup_time'], $data['airport_pickup_loca'], $data['need_car'], $data['airport_pickup'], $data['airport_drop'], $data['airport_drop_loca'], $data['cost'], $data['car_type'], $data['car_size'], $data['car_pickup_location'], $data['destination']));
                } else {
                    $stmt1 = "UPDATE `hotel_bookings` SET `hotel_id`=" . $data['hotel_id'] . ",`check_in`='" . $data['check_in'] . "',`check_out`='" . $data['check_out'] . "',`status`='confirmed',`approved`='n',`trip_id`=" . $id . ",`cost`=" . $data['cost'] . ",`hotel_confirmation_num`='" . $data['hotel_confirmation_num'] . "',`late_checkin`='" . $data['late_checkin'] . "',`late_checkout`='" . $data['late_checkout'] . "',`late_checkin_date`='" . $data['late_checkin_date'] . "',`late_checkout_date`='" . $data['late_checkout_date'] . "',`noofguests`=" . $data['noofguests'] . ",`noofrooms`=" . $data['noofrooms'] . ",`room_type`='" . $data['room_type'] . "',`otherhotel`='" . $data['otherhotel'] . "'  WHERE request_id=" . $data['bookingrequestid'] . "";
                    $stmt1 = $this->pdo->prepare($stmt1);
                    //print_r($stmt1);
                    $stmt1->execute();
                }
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->setError($e->getMessage());
        }
    }*/

    function trainBookings($data) {
        try { //print_r($data);exit;
            $id = $data['trip_id'];

            $stmt1 = "INSERT INTO train_bookings (`emp_id`,`date`,`approved`,`age`,`train_from`,`train_to`,`trip_id`,`train`,`train_id`,`boarding_form`,`cost`,`class`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt1 = $this->pdo->prepare($stmt1);
            $stmt1->execute(array($data['tripempid'], $data['date'], 'n', $data['age'], $data['travel_from'], $data['travel_to'], $id, $data['train'], $data['train_id'], $data['boarding_form'], $data['cost'], $data['class']));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->setError($e->getMessage());
        }
    }

    function getAirBookingsdetail($trip_id) {
        try {
            $select = $this->pdo->prepare("select air_bookings.*,destination_and_departure.* from air_bookings left join destination_and_departure on air_bookings.trip_id = destination_and_departure.trip_id WHERE destination_and_departure.trip_id = ?");
            $select->execute(array($trip_id));
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function getAirBookings($trip_id) {
        $records = $this->pdo->select('air_bookings', '`trip_id`=' . $trip_id);
        return $records;
    }

    function getCarBookings($trip_id) {
        $records = $this->pdo->select('car_bookings', '`trip_id`=' . $trip_id);
        return $records;
    }

    function getHotelBookings($trip_id) {
        $records = $this->pdo->select('hotel_bookings', '`trip_id`=' . $trip_id);
        return $records;
    }

    function getTrainBookings($trip_id) {
        $records = $this->pdo->select('train_bookings', '`trip_id`=' . $trip_id);
        return $records;
    }

    function getemployeedetails($id) {
        try {
            $select = $this->pdo->prepare("SELECT * FROM emp_list  where id = ?");

            $select->execute(array($id));

            $row = $select->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
    }

    function notifyEmployee($trip_id) {
        ## $to,$sub,$body
        try {  //echo $trip_id;
            //SELECT  emp_list.firstname, lastname, email, trips.*, a.*, h.*,c.* FROM emp_list left join trips on emp_list.id=trips.emp_id  left join air_bookings as a on a.trip_id=trips.id 
            ////left join hotel_bookings as h on h.trip_id = trips.id left join car_bookings as c on c.trip_id = trips.id where trips.id = '64';
            $select = $this->pdo->prepare("SELECT  emp_list.firstname, lastname, email, trips.*, a.*, h.*,c.*,t.* FROM emp_list left join trips on emp_list.id=trips.emp_id  left join air_bookings as a on a.trip_id=trips.id left join hotel_bookings as h on h.trip_id = trips.id left join car_bookings as c on c.trip_id = trips.id left join train_bookings as t on t.trip_id = trips.id where trips.id = ?;");

            $select->execute(array($trip_id));

            $row = $select->fetch(PDO::FETCH_ASSOC);

            $body = '<html><body>';
            $empname = $row['firstname'] . '  ' . $row['lastname'];
            $body .= '<h1>Hello ' . $empname . ',</h1>';
            $trip_type = $row['trip_type'];
            $form = $this->getemployeedetails($row['emp_id']);
            $formemail = $form['email'];
            #$formname=$sender['firstname'].$sender['middlename'].$sender['lastname'];
            $formname = '';
            $id = $trip_id;
            $to = $row['email'];
            $subject = "ANSYS Travel Portal: Suggested plan";

            $air_bookings = $this->getAirBookings($trip_id);
            //print_r($air_bookings);
            $car_bookings = $this->getCarBookings($trip_id);
            //print_r($car_bookings);
            $hotel_bookings = $this->getHotelBookings($trip_id);
            //print_r($hotel_bookings);
            $train_bookings = $this->getTrainBookings($trip_id);
            //print_r($train_bookings);
            /*             * *******************************************************Car Booking details*********************************************************************************** */
#if(($row['only_car_booking']==NULL && $row['only_hotel_booking']==NULL) || ($row['only_car_booking']=='yes' && $row['only_hotel_booking']==NULL))
#if($row['only_car_booking'] == 'yes')
            if ($row['booking_type'] == 'car') {
                foreach ($car_bookings as $car_booking) {
                    ## display the detials
                    $city = $this->getcity($car_booking['car_for_city']);
                    if ($trip['trip_type'] == 'multicity') {
                        $city['city_name'];
                    }
                    $car = $this->getcars($car_booking['car_company']);

                    $body .= '<table border="1" width="500">';

                    if ($trip_type == 'multicity') {
                        $body .= "<tr><th   align='left'> City </th><td>" . $city['city_name'] . "</td></tr>";
                    }
                    $body .= '<tr><td colspan="2" align="center"><h2>Car Booking details</h2></td></tr>';
                    $body .= '<tr><th align="left">Car booking request id</th><td>' . $car_booking['id'] . '</td></tr>';
                    $body .= '<tr><th align="left">Car Vendor Company</th><td>' . $car['name'] . '</td></tr>';
                    $body .= '<tr><th align="left">Pickup Date</th><td>' . $car_booking['date'] . '</td></tr>';
                    $body .= '<tr><th align="left">Car From Date</th><td>' . $car_booking['car_fromdate'] . '</td></tr>';
                    $body .= '<tr><th align="left">Car To Date</th><td>' . $car_booking['car_todate'] . '</td></tr>';
                    $body .= '<tr><th align="left">Pickup Time</th><td>' . $car_booking['pickup_time'] . '</td></tr>';
                    $body .= '<tr><th align="left">Multiple days booking</th><td>' . $car_booking['need_car'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Car Type</th><td>' . $car_booking['car_size'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Cost</th><td>' . $car_booking['cost'] . '</td> </tr>';
                    $body .= "</table><br/><br/>";
                } ## foreach($car_bookings as $car_booking){	
                $flag = 'booking';
                $requestmail = $this->sendemail($formemail, $subject, $body, $formemail, $id, $flag); //Send mail Car Request details 
            }##If

            /*             * *******************************************************Hotel Booking details*********************************************************************************** */
# if(($row['only_car_booking']==NULL && $row['only_hotel_booking']==NULL) || ($row['only_hotel_booking']=='yes' && $row['only_car_booking']==NULL))
#if($row['only_hotel_booking'] == 'yes')
            if ($row['booking_type'] == 'hotel') {
                foreach ($hotel_bookings as $hotel_booking) {
                    ## display the details
                    $city = $this->getcity($hotel_booking['hotel_for_city']);
                    $hotel = $this->gethotel($hotel_booking['hotel_id']);

                    $body .= '<table border="1" width="500">';
                    if ($trip_type == 'multicity') {
                        $body .= "<tr><th   align='left'> City </th><td>" . $city['city_name'] . "</td></tr>";
                    }
                    $body .= '<tr><td colspan="2" align="center"><h2>Hotel Booking details</h2></td></tr>';

                    $body .= '<tr><th align="left">Hotel</th><td>' . $hotel['hotel_name'] . '</td></tr>';
                    if ($row['booking_type'] == 'hotel') {
                        $body .= '<tr><th align="left">Check in date-time</th><td>' . $hotel_booking['check_in'] . '</td></tr>';
                        $body .= '<tr> <th align="left">Check Out date-time</th><td>' . $hotel_booking['check_out'] . '</td></tr>';
                    } else if ($row['booking_type'] != 'hotel') {
                        $body .= '<tr><th align="left">Checkin Date</th><td>' . $hotel_booking['late_checkin_date'] . '</td> </tr>';
                        $body .= '<tr><th align="left">Checkout Date</th><td>' . $hotel_booking['late_checkout_date'] . '</td> </tr>';
                    }
                    $body .= '<tr><th align="left">Confirmation Number</th><td>' . $hotel_booking['hotel_confirmation_num'] . '</td></tr>';
                    $body .= '<tr><th align="left">Check in time</th><td>' . $hotel_booking['late_checkin'] . '</td></tr>';
                    $body .= '<tr><th align="left">Check out time</th><td>' . $hotel_booking['late_checkout'] . '</td></tr>';
                    $body .= '<tr><th align="left">No.of Guests</th><td>' . $hotel_booking['noofguests'] . '</td> </tr>';
                    $body .= '<tr><th align="left">No.of Rooms</th><td>' . $hotel_booking['noofrooms'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Room Type</th><td>' . $hotel_booking['room_type'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Cost</th><td>' . $hotel_booking['cost'] . '</td> </tr>';
                    $body .= '</thead></table><br/><br/>';
                } ## foreach($hotel_bookings as $hotel_booking){
                $flag = 'booking';
                $requestmail = $this->sendemail($formemail, $subject, $body, $formemail, $id, $flag); //Send mail Car Request details 
            }##if

            /*             * ********************************* Train Booking Details ******************************* */
            if ($row['booking_type'] == 'train') {
                foreach ($train_bookings as $train_booking) {
                    ## display the detials
                    $cityto = $this->getcity($train_booking['train_to']);
                    $city = $this->getcity($train_booking['train_from']);

                    $body .= '<table border="1" width="500">';
                    $body .= '<tr><td colspan="2" align="center"><h2>Train Booking details</h2></td></tr>';


                    $body .= '<tr><th align="left">From Location</th><td>' . $city['city_name'] . '</td></tr>';
                    $body .= '<tr><th align="left">Destination Address</th><td>' . $cityto['city_name'] . '</td></tr>';
                    $body .= '<tr><th align="left">Age</th><td>' . $train_booking['age'] . '</td></tr>';
                    $body .= '<tr><th align="left">Train</th><td>' . $train_booking['train'] . '</td></tr>';
                    $body .= '<tr><th align="left">Date</th><td>' . $train_booking['date'] . '</td></tr>';
                    $body .= '<tr><th align="left">Train Id</th><td>' . $train_booking['train_id'] . '</td></tr>';
                    $body .= '<tr><th align="left">Class</th><td>' . $train_booking['class'] . '</td></tr>';
                    $body .= '<tr><th align="left">Boarding From</th><td>' . $train_booking['boarding_form'] . '</td></tr>';
                    $body .= "</table><br/><br/>";
                } ## foreach($train_bookings as $train_booking){	
                $flag = 'booking';
                $requestmail = $this->sendemail($formemail, $subject, $body, $formemail, $id, $flag); //Send mail Car Request details 
            }##If


            /*             * *******************************************************ALL Booking details*********************************************************************************** */
#if($row['only_car_booking']==NULL && $row['only_hotel_booking']==NULL && $row['only_train_booking'] == NULL){ 
            if ($row['booking_type'] == 'airline') {
                #$body = '<html><body>';
                #$body .= '<h3>Hello '.$empname.', </h3>';
                $e_tickets_array = array();

                foreach ($air_bookings as $air_booking) {
                    ## display the detials
                    $airline = $this->getairlines($air_booking['book_airline']);
                    if (empty($air_booking['travel_to'])) {
                        $cto = $air_booking['othertravel_to'];
                    } else {
                        $cityto = $this->getcity($air_booking['travel_to']);
                        $cto = $cityto['city_name'];
                    }
                    if (empty($air_booking['travel_from'])) {
                        $cf = $air_booking['otheronwardcity'];
                    } else {
                        $city = $this->getcity($air_booking['travel_from']);
                        $cf = $city['city_name'];
                    }
                    $e_ticket = $air_booking['e_ticket'];
                    /*                     * *******************************************************Airline Booking details*********************************************************************************** */
                    $body .= '<table border="1" width="500">';
                    $body .= '<tr><td colspan="2" align="center"><h2>Airline Booking details</h2></td></tr>';
                    if ($trip_type == "multicity") {
                        $body .= '<th  align="left"> City </th><td>' . $city['city_name'] . '</td>';
                    }
                    $body .= '<tr><th align="left">Airline</th><td>' . $airline['name'] . '</td></tr>';
                    $body .= '<tr><th align="left">Preferred Airline Time</th><td>' . $air_booking['preferred_airline_time'] . '</td></tr>';
                    $body .= '<tr><th align="left">From location</th><td>' . $cf . '</td></tr>';
                    $body .= '<tr> <th align="left">Destination</th><td>' . $cto . '</td></tr>';
                    $body .= '<tr><th align="left">Departure date</th><td>' . $air_booking['date'] . '</td></tr>';
                    $body .= '<tr><th align="left">Departure time</th><td>' . $air_booking['departure_time'] . '</td></tr>';
                    $body .= '<tr><th align="left">Flight Meal preference</th><td>' . $air_booking['meal_preference'] . '</td></tr>';
                    $body .= '<tr><th align="left">Cost</th><td>' . $air_booking['cost'] . '</td> </tr>';
                    if (!empty($e_ticket)) {
                        $body .= '<tr><th align="left">E Ticket</th><td><a href="http://' . $_SERVER['HTTP_HOST'] . '/uploads/e-tickets/' . $e_ticket . '">View Ticket</a></td></tr>';
                    }
                    $body .= '</table><br/><br/>';
                    $e_tickets_array[] = $air_booking['e_ticket'];
                }## foreach($air_bookings as $air_booking){		
                /*                 * *******************************************************Car Booking details*********************************************************************************** */

                foreach ($car_bookings as $car_booking) {
                    ## display the detials
                    $city = $this->getcity($car_booking['car_for_city']);
                    if ($trip['trip_type'] == 'multicity') {
                        $city['city_name'];
                    }
                    $car = $this->getcars($car_booking['car_company']);
                    $body .= '<table border="1" width="500">';
                    $body .= '<tr><td colspan="2" align="center"><h2>Car Booking details</h2></td></tr>';
                    if ($trip_type == 'multicity') {
                        $body .= "<tr><th   align='left'> City </th><td>" . $city['city_name'] . "</td></tr>";
                    }
                    $body .= '<tr><th align="left">Car booking request id</th><td>' . $car_booking['id'] . '</td></tr>';
                    $body .= '<tr><th align="left">Car Vendor Company</th><td>' . $car['name'] . '</td></tr>';
                    $body .= '<tr><th align="left">Pickup Date</th><td>' . $car_booking['date'] . '</td></tr>';
                    $body .= '<tr><th align="left">Airport Drop</th><td>' . $car_booking['airport_drop'] . '</td></tr>';
                    $body .= '<tr><th align="left">Pickup Address</th><td>' . $car_booking['airport_pickup_loca'] . '</td></tr>';
                    $body .= '<tr><th align="left">Airport Pickup</th><td>' . $car_booking['airport_pickup'] . '</td></tr>';
                    $body .= '<tr><th align="left">Destination</th><td>' . $car_booking['airport_drop_loca'] . '</td></tr>';
                    $body .= '<tr><th align="left">Pickup Time</th><td>' . $car_booking['pickup_time'] . '</td></tr>';
                    $body .= '<tr><th align="left">Multiple days booking</th><td>' . $car_booking['need_car'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Car Type</th><td>' . $car_booking['car_size'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Cost</th><td>' . $car_booking['cost'] . '</td> </tr>';
                    $body .= "</table><br/><br/>";
                } ## foreach($car_bookings as $car_booking){	
                /*                 * *******************************************************Hotel Booking details*********************************************************************************** */

                foreach ($hotel_bookings as $hotel_booking) {
                    ## display the details
                    $city = $this->getcity($hotel_booking['hotel_for_city']);
                    $hotel = $this->gethotel($hotel_booking['hotel_id']);
                    $body .= '<table border="1" width="500">';
                    $body .= '<tr><td colspan="2" align="center"><h2>Hotel Booking details</h2></td></tr>';

                    if ($trip_type == 'multicity') {
                        $body .= "<tr><th   align='left'> City </th><td>" . $city['city_name'] . "</td></tr>";
                    }

                    $body .= '<tr><th align="left">Hotel</th><td>' . $hotel['hotel_name'] . '</td></tr>';
                    if ($row['booking_type'] == 'hotel') {
                        $body .= '<tr><th align="left">Check in date-time</th><td>' . $hotel_booking['check_in'] . '</td></tr>';
                        $body .= '<tr> <th align="left">Check Out date-time</th><td>' . $hotel_booking['check_out'] . '</td></tr>';
                    } else if ($row['booking_type'] != 'hotel') {
                        $body .= '<tr><th align="left">Checkin Date</th><td>' . $hotel_booking['late_checkin_date'] . '</td> </tr>';
                        $body .= '<tr><th align="left">Checkout Date</th><td>' . $hotel_booking['late_checkout_date'] . '</td> </tr>';
                    }
                    $body .= '<tr><th align="left">Confirmation Number</th><td>' . $hotel_booking['hotel_confirmation_num'] . '</td></tr>';
                    $body .= '<tr><th align="left">Check in time</th><td>' . $hotel_booking['late_checkin'] . '</td></tr>';
                    $body .= '<tr><th align="left">Check out time</th><td>' . $hotel_booking['late_checkout'] . '</td></tr>';
                    $body .= '<tr><th align="left">No.of Guests</th><td>' . $hotel_booking['noofguests'] . '</td> </tr>';
                    $body .= '<tr><th align="left">No.of Rooms</th><td>' . $hotel_booking['noofrooms'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Room Type</th><td>' . $hotel_booking['room_type'] . '</td> </tr>';
                    $body .= '<tr><th align="left">Cost</th><td>' . $hotel_booking['cost'] . '</td> </tr>';

                    $body .= '</table>';
                } ## foreach($hotel_bookings as $hotel_booking){
                $body .= '</body></html><br/><br/>';

                $flag = 'booking';
                $requestmail = $this->sendemail($formemail, $subject, $body, $formemail, $id, $flag, $e_ticket, $e_tickets_array); //Send mail Car Request details 
            }##if
//exit;
        }##try
        catch (PDOException $e) {
            //echo $e->getMessage();
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

///////added by rutuja


    function travelrequestbookinground($data) { //print_r($data);exit;
        $datadad0 = ['emp_id' => $this->user_id, 'book_airline' => $data['book_airline'], 'travel_from' => $data['travel_from'], 'travel_to' => $data['travel_to'], 'trip_id' => $data['trip_id'], 'date' => $data['date'], 'return_date' => '', 'pref_hotel' => $data['hotel_id'], 'car_company' => $data['car_company'], 'airport_drop' => $data['airport_drop'], 'airport_pickup' => $data['airport_pickup'], 'airport_pickup_loca' => $data['airport_pickup'], 'airport_drop_loca' => $data['airport_pickup'], 'need_car' => '', 'preferred_airline_time' => '', 'car_type' => '', 'car_size' => '', 'late_checkin' => '', 'late_checkout' => '', 'late_checkin_date' => '', 'late_checkout_date' => '', 'car_pickuptime' => '', 'meal_preference' => $data['meal_preference'], 'otherhotel' => '', 'otherair' => '', 'otheronwardcity' => '', 'othertravel_to' => ''];
        //$this->pdo->insert('destination_and_departure', $datadad0);	
//$destdeptlastInsertId_one=$this->pdo->lastInsertId(); 
        $update_qry = $this->pdo->prepare("UPDATE destination_and_departure SET `book_airline`=" . $data['book_airline'] . ",`travel_from`=" . $data['travel_from'] . ",`travel_to`=" . $data['travel_to'] . ",`date`='" . $data['date'] . "',`meal_preference`='" . $data['meal_preference'] . "' WHERE `id`=" . $data['update_id']);
//print_r($update_qry);print_r($data);echo $this->user_id; exit;
        $update_qry->execute();

        //$update_qry->execute(array($data['book_airline'],$data['travel_from'],$data['travel_to'],$date,$data['meal_preference'],$data['update_id']));
        //print_r($update_qry);exit;
    }

#####################
}

// TravelDesk Class Ends

