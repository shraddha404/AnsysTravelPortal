<?php
session_start();
include_once ('../lib/User.class.php');

$u = new User($_SESSION['user_id']);

if($_POST['delete_row']=='delete_row')
{
 echo $row_no=$_POST['row_id']; 
 $u->deleteVISA($row_no); 
 echo "success";exit();
}

if($_POST['delete_row']=='delete_rowff')
{
 echo $row_no=$_POST['row_idff']; 
 $u->deleteFFP($row_no);
 echo "success";exit();
}
