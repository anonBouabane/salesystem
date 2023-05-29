<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);
$ware = $conn->query("SELECT * FROM tbl_warehouse where wh_name = '$wh_name'");
if ($ware ->rowcount()>0)
{
    $res = array("res" => "exist","wh_name"=>$wh_name) ;
}
else{
$delExam = $conn->query(" update tbl_warehouse set 
wh_name ='$wh_name',wh_type='$wh_type',br_id ='$br_id'  WHERE wh_id='$wh_id'  ");
if ($delExam) {
    $res = array("res" => "success","wh_name"=>$wh_name);
} else {
    $res = array("res" => "failed","wh_name" =>$wh_name);
}
}



echo json_encode($res);
?>
