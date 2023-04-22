<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);



$insert = $conn->query("INSERT INTO tbl_branch (  br_name,br_status,br_type,add_by,date_register ) VALUES('$br_name','1','$br_type','$id_users',CURDATE()) ");
if ($insert) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>