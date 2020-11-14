<?php
session_start();
$_SESSION['user_id'] = null;
 $_SESSION['user_type'] = null;
header('location:index.php');
exit;
