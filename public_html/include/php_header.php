<?php
session_start();
if(empty($_SESSION['user_id'])){
header("Location:/login.php");
}
include_once './../../lib/User.class.php';
$u = new User($_SESSION['user_id']);
if($u->isAdmin()){
	include_once './../../lib/Admin.class.php';
	$u = new Admin($_SESSION['user_id']);
}
else if($u->isManager()){
	include_once './../../lib/Manager.class.php';
	$u = new Manager($_SESSION['user_id']);
}
else if ($u->isEmployee()) {
	include_once './../../lib/Employee.class.php';
	$u = new Employee($_SESSION['user_id']);
}
else if($u->isTravelDesk()) {
	include_once './../../lib/TravelDesk.class.php';
	$u = new TravelDesk($_SESSION['user_id']);
}
?>

