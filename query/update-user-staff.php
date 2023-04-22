<?php 
include("../setting/checksession.php");

include("../setting/conn.php");
 extract($_POST);

 

$delExam = $conn->query(" update tbl_user_staff set role_id = '$r_id' , depart_id ='$dp_id'   WHERE usid='$us_id'  ");
if($delExam)
{
	$res = array("res" => "success");
}
else
{
	$res = array("res" => "failed");
}


	echo json_encode($res);
 ?>