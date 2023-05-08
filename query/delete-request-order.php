<?php


include("../setting/conn.php");

extract($_POST);



$delheadbill = $conn->query(" delete from tbl_order_request where or_id = '$id'  ");
if ($delheadbill) {



    $deldetail = $conn->query(" delete from tbl_order_request_detail where or_id = '$id'  ");


    if ($deldetail) {
        $res = array("res" => "success");
    }
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
