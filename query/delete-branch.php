<?php 
 include("../setting/conn.php");
 extract($_POST);

$delbranch = $conn->query("DELETE  FROM tbl_branch WHERE br_id = '$id'  ");
if($delbranch)
{
	$res = array("res" => "success");
}
else
{
	$res = array("res" => "failed");
}

	echo json_encode($res);
?>