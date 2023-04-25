<?php


include("../setting/conn.php");

extract($_POST);



$insCourse = $conn->query("
update tbl_depart set  dp_name = '$dp_name' where dp_id = '$dp_id'  
    
    ");
if ($insCourse) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>