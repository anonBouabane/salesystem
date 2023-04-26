<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);



$delExam = $conn->query(" update tbl_roles set 
role_name ='$role_name',role_level='$role_level' WHERE r_id='$r_id'  ");
if ($delExam) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>