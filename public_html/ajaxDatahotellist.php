<?php

@$id=$_GET['id'];
//$cat_id=2;
/// Preventing injection attack //// 
if(!is_numeric($id)){
echo "Data Error";
exit;
 }
/// end of checking injection attack ////
$db = 'ansys_travel_portal';
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pass = 'root';
	try
{
 $DB_con = new PDO("mysql:host={$db_host};dbname={$db}",$db_user,$db_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 $e->getMessage();
}

//$sql="SELECT * FROM hotels WHERE city ='$id' ORDER BY hotel_name ASC'";
$sql="select * from hotels where city='$id'";
$row=$DB_con->prepare($sql);
$row->execute();
$result=$row->fetchAll(PDO::FETCH_ASSOC);

$main = array('data'=>$result);
echo json_encode($main);




?>
