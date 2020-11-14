<?php
include_once "../lib/db_connect.php";
$pdo = new db("mysql:host=localhost;dbname=$db", $db_user, $db_pass);
$leave_data = $argv[1];
 if (($file = fopen($argv[1], "r")) !== FALSE)
 { $id='';
    while (($data = fgetcsv($file)) !== FALSE)
           {
//print_r($data );
		 if(!empty($data[0])){
				$city=$data[1];
				$id.=$data[0].",";
$select_cities = $pdo->prepare("SELECT * FROM `cities`");
$select_cities->execute();
$rows = $select_cities->fetchALL(PDO::FETCH_ASSOC);


/*

foreach($rows as $row){  

  $csvcity=strtolower($row['id']);
   $city=strtolower($city);
 $c =strcasecmp(trim($csvcity),trim($city));
$rowid=$row['id'];
	if($rowid==$id){continue;
	}else {
	$sql = $pdo->prepare("DELETE FROM `cities` WHERE `id` = '$rowid' ");
			$sql->execute();
			echo "Updated!";						
	}
}*/
		       
	} 
}
//echo $id;


 }
$id=rtrim($id,',');


$sql = $pdo->prepare("DELETE FROM cities WHERE id NOT IN  ($id) ");
	$sql->execute();
fclose($file);  //php -f cities.php  cities.csv?>
