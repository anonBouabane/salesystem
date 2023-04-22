<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);



$delExam = $conn->query(" update tbl_user_staff set user_status = '1'  WHERE usid='$id'  ");
if ($delExam) {
	$res = array("res" => "success");
} else {
	$res = array("res" => "failed");
}


echo json_encode($res);
?>