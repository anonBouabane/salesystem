<?php 
include("../setting/checksession.php");

include("../setting/conn.php");
 extract($_POST);

 $user = $conn->query("SELECT *FROM tbl_user where user_name = '$user_name'");
 if ($user -> rowcount()>0){
$res = array("res" => "exist","users name" => $user_name);
 }else{


$delExam = $conn->query(" update tbl_user set 
full_name ='$full_name' , user_name ='$user_name' ,   
role_id ='$r_id', depart_id ='$dp_id' WHERE usid='$usid' ");

if($delExam)
{
	$res = array("res" => "success","user name" => $user_name);
}
else
{
	$res = array("res" => "failed", "user name" => $username);
}
 }

	echo json_encode($res);
 ?>