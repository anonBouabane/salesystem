<?php 
include("../setting/checksession.php");

include("../setting/conn.php");
 extract($_POST);

 

$delExam = $conn->query(" update tbl_depart set dp_name ='$dp_name'   WHERE dp_id='$dp_id'  ");
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