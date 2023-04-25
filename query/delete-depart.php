<?php


include("../setting/conn.php");

extract($_POST);



$insCourse = $conn->query("

delete from tbl_depart where dp_id = '$kuy_id'
 
    
    ");
if ($insCourse) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>