<?php 
include("../setting/checksession.php");

include("../setting/conn.php");

 extract($_POST);
 $pagerow = $conn->query("SELECT * FROM tbl_page_title where pt_name = '$page_name'");
if ($pagerow ->rowcount()>0)
{
$res = array ("res" => "exist","pt_name" =>$page_name);

}
 else{
	$insCourse = $conn->query("INSERT INTO tbl_page_title (  st_id,pt_name,ptf_name ) VALUES('$sub_title','$page_name','$pf_name') ");
	if($insCourse)
	{
		$res = array("res" => "success","pt_name"=>$page_name);
	}
	else
	{
		$res = array("res" => "failed","pt_name"=>$page_name);
	}
 
 }


 echo json_encode($res);
 ?>