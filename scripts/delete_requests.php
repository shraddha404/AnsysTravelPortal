<?php
$username=$argv[1];
include_once("../lib/db_connect.php");
$pdo = new db("mysql:host=localhost;dbname=$db", $db_user, $db_pass);
$select = $pdo->prepare("SELECT id FROM emp_list WHERE username = ? AND status = 1");
$select->execute(array($username));
$row = $select->fetch(PDO::FETCH_ASSOC);

$select_trip_ids = $pdo->prepare("SELECT trips.id FROM trips LEFT JOIN emp_list ON trips.emp_id=emp_list.id WHERE emp_list.username=? ORDER BY id DESC LIMIT 5");
$select_trip_ids->execute(array($username));
$row = $select_trip_ids->fetchALL(PDO::FETCH_ASSOC);

#print_r($row);

foreach($row as $trip_id){
	$delete_dd = $pdo->prepare("DELETE FROM destination_and_departure WHERE trip_id=?");
	$delete_dd->execute(array($trip_id['id']));

	$delete_trip = $pdo->prepare("DELETE FROM trips WHERE id=?");
	$delete_trip->execute(array($trip_id['id']));
echo "Deleted Trip Id is :".$trip_id['id']."\n";
}

?>
