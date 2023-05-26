<?php 
include("../setting/checksession.php");

include("../setting/conn.php");

 extract($_POST);
 $swal = $conn->query("SELECT * FROM tbl_depart where dp_name = '$depart_name'");
if ($swal->rowcount()>0)
{
$res = array("res" => "exist", "depart" =>$depart_name);

}
else{
 
	$insCourse = $conn->query("INSERT INTO tbl_depart (dp_name ) VALUES('$depart_name') ");
	if($insCourse)
	{
		$res = array("res" => "success","depart"=>$depart_name );
	}
	else
	{
		$res = array("res" => "failed","depart"=>$depart_name );
	}
}



 echo json_encode($res);
 ?>