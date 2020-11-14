<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php'; 
include_once $_SERVER['DOCUMENT_ROOT']."/simplesamlphp/index.php";

$username = $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'][0];
$username = preg_replace('/@ansys.com/','',$username);
$u = new User();
$user_id = $u->getUserIdFromUsername($username);
// start session
if(empty($user_id)){
#$username="aaa";
$user_id = $u->createNewUser($username);
}

$_SESSION['user_id'] = $user_id;
header('location:/emp-board.php');
