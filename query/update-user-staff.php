<?php 
include("../setting/checksession.php");

include("../setting/conn.php");
 extract($_POST);

 

$delExam = $conn->query(" update tbl_user set 
full_name ='$full_name' , user_name ='$user_name' ,   
role_id ='$r_id', depart_id ='$dp_id' WHERE usid='$usid' ");

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