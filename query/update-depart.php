<?php 
include("../setting/checksession.php");

include("../setting/conn.php");
 extract($_POST);

 $update = $conn ->query("SELECT * FROM tbl_depart where dp_name = '$dp_name'");
if ($update ->rowcount()>0)
{
	$res = array("res" => "exist","depart name"=> $dp_name);
}


else{
$delExam = $conn->query(" update tbl_depart set dp_name ='$dp_name'   WHERE dp_id='$dp_id'  ");
if($delExam)
{
	$res = array("res" => "success","depart name" => $dp_name);
}
else
{
	$res = array("res" => "failed","depart name"=>$dp_name);
}

}
 

	echo json_encode($res);
 ?>