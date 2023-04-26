<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);



$delExam = $conn->query(" update tbl_branch set 
br_name ='$br_name',br_type='$br_type'  WHERE br_id='$br_id'  ");
if ($delExam) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>
