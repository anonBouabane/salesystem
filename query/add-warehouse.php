<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);
$selCourse = $conn->query("SELECT * FROM tbl_warehouse WHERE wh_name='$wharehouse_name' ");

 if($selCourse->rowCount() > 0)
 {
	$res = array("res" => "exist", "wh_name" => $wharehouse_name);
 }
 else
 {


$insert = $conn->query("INSERT INTO tbl_warehouse ( wh_name,wh_status,wh_type, br_id,add_by ,date_register ) VALUES('$wharehouse_name','1','$wh_type','$branch_id','$id_users',CURDATE()) ");
if ($insert) {
    $res = array("res" => "success", "wh_name" => $wharehouse_name);
}
else
{
    $res = array("res" => "failed", "wh_name" => $wharehouse_name);
}


}




echo json_encode($res);
?>
