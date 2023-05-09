<?php


include("../setting/conn.php");

extract($_POST);

$checkitem = $conn->query("SELECT * FROM tbl_stock_out_warehouse where apo_id = '$id' ");

if ($checkitem->rowCount() > 0) {
    $res = array("res" => "used");
} else {


    $del_main = $conn->query(" delete from tbl_approve_order where apo_id = '$id' ");
    if ($del_main) {

        $del_detail = $conn->query(" delete from tbl_approve_order_detail where apo_id = '$id' ");

        if ($del_detail) {
            $res = array("res" => "success");
        }
    } else {
        $res = array("res" => "failed");
    }
}


echo json_encode($res);
