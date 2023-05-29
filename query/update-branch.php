<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);

$branch = $conn ->query("SELECT *FROM tbl_branch where br_name = '$br_name");
if($branch ->rowcount()>0)
{
    $res=array("res" => "exist","br name" =>$br_nane);
}

$delExam = $conn->query(" update tbl_branch set 
br_name ='$br_name',br_type='$br_type'  WHERE br_id='$br_id'  ");
if ($delExam) {
    $res = array("res" => "success","br name"=>$br_name);
} else {
    $res = array("res" => "failed","br_name"=>$br_name);
}




echo json_encode($res);
?>
