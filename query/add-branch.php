
<?php 
include("../setting/checksession.php");

include("../setting/conn.php");

 extract($_POST);
 

 $selCourse = $conn->query("SELECT * FROM tbl_branch WHERE br_name='$br_name' ");

 if($selCourse->rowCount() > 0)
 {
	$res = array("res" => "exist", "br_name" => $br_name);
 }
 else
 {
    
	$insCourse = $conn->query("INSERT INTO tbl_branch (  br_name,br_status,br_type,add_by,date_register ) VALUES('$br_name','1','$br_type','$id_users',CURDATE()) ");
	if($insCourse)
	{
		$res = array("res" => "success", "br_name" => $br_name);
	}
	else
	{
		$res = array("res" => "failed", "br_name" => $br_name);
	}


 }




 echo json_encode($res);
 ?>