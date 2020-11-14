<?php session_start();
 /*include_once ('../lib/db_connect.php');
if($_POST['id'])
{
	$id=$_POST['id'];
		
	$hotels = $u->getHotelsFormCity($id);
	?><option value="">Preferred hotel in the city</option>
		<?php
		foreach($hotels as $hotel) { ?>
		<option value="<?php echo $hotel['id']; ?>" <?php if($hotel['id']==$pref_hotel[0]) {echo "selected='selected'";}?>><?php echo $hotel['hotel_name']; ?></option>
		<?php
		} ?>
	<option value="0">Others</option>
<?php }*/
/*$db = 'atpcarvi_atp';
	$db_host = 'localhost';
	$db_user = 'atpcarvi_atp';
	$db_pass = 'atp123!';*/
/*mysql_connect("localhost", "atp", "atp123") or
    die("Could not connect: " . mysql_error());
mysql_select_db("ansys_travel_portal");*/
include_once ('../lib/Manager.class.php');
if($_SESSION['user_type'] == 'Employee'){
$u = new Employee($_SESSION['user_id']);
}
else if($_SESSION['user_type'] == 'Manager'){
$u = new Manager($_SESSION['user_id']);
}
if(empty($_SESSION['user_id']))
{
 header("location:login.php");
}
	$id=$_POST['id'];

 $hotels=$u->getHoteslFromCity($id);
?>
<option value="">Preferred hotel in the city</option>
<?php
foreach($hotels as $hotel) { ?>
		<option value="<?php echo $hotel['id']; ?>" ><?php echo $hotel['hotel_name']; ?></option>
<?php } ?>
	<option value="0">Others</option>




