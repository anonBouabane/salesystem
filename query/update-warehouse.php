<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);



$delExam = $conn->query(" update tbl_warehouse set 
wh_name ='$wh_name',wh_type='$wh_type',br_id ='$br_id'  WHERE wh_id='$wh_id'  ");
if ($delExam) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>
