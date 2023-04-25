<?php


include("../setting/conn.php");

extract($_POST);



$insCourse = $conn->query("
update tbl_roles set  role_name = '$role_name',role_level = '$role_level' where r_id = '$r_id'  
    
    ");
if ($insCourse) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>