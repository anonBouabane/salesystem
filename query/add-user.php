<?php 
include("../setting/checksession.php");

include("../setting/conn.php");

 extract($_POST);
 

 $selCourse = $conn->query("SELECT * FROM tbl_user WHERE user_name='$user_name' ");

 if($selCourse->rowCount() > 0)
 {
	$res = array("res" => "exist", "user name" => $user_name);
 }
 else
 {
    
	$insCourse = $conn->query("INSERT INTO tbl_user(full_name,user_name,user_password,user_status,role_id,depart_id,br_id,add_by,date_register)
	VALUES('$full_name','$user_name','123','1','$r_id','$dp_id','$br_id','$id_users',now()) ");
	if($insCourse)
	{
		$res = array("res" => "success", "user name" => $user_name);
	}
	else
	{
		$res = array("res" => "failed", "user name" => $user_name);
	}


 }




 echo json_encode($res);
 ?>