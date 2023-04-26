<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);



$delExam = $conn->query(" update tbl_item_data set 
item_name ='$item_name', barcode ='$bar_code', ipt_id='$item_unit'  WHERE item_id='$item_id'  ");

if ($delExam) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>
