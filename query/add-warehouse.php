<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);



$insert = $conn->query("INSERT INTO tbl_warehouse ( wh_name,wh_status,wh_type, br_id,add_by ,date_register ) VALUES('$wharehouse_name','1','$wh_type','$branch_id','$id_users',CURDATE()) ");
if ($insert) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>