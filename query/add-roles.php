<?php 
include("../setting/checksession.php");

include("../setting/conn.php");

 extract($_POST);
 
 $role = $conn-> query("SELECT * FROM tbl_roles where role_name = '$role_name'");
 if ($role->rowcount()>0)
 {
$res = array("res" => "exist", "role name" => $role_name);

 }
 else{
 
	$insCourse = $conn->query("INSERT INTO tbl_roles (role_name,role_level ) VALUES('$role_name','$role_level') ");
	if($insCourse)
	{
		$res = array("res" => "success","role name" => $role_name );
	}
	else
	{
		$res = array("res" => "failed" , "role name" => $role_name);
	}
}



 echo json_encode($res);
 ?>