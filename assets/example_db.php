<?php
include 'User.class.php';

$u = new User();
// insert 
$u->db->insert('tablename',array('id'=>1, 'name'=>'ketan'));

// update example
$db->update("mytable", array(
    "FName" => "Jane",
    "Gender" => "female"
), "FName = John AND LName = Doe");

// delete

$db->delete("mytable", "FName = Jane AND LName = Doe");
$db->delete("mytable", "id=$id");

// select
$results = $db->select("mytable");

