<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);



$delExam = $conn->query(" update tbl_page_title set 
st_id='$st_id', pt_name ='$pt_name', ptf_name='$ptf_name' WHERE pt_id='$pt_id'  ");
if ($delExam) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>
 