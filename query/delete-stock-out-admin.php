<?php


include("../setting/conn.php");

extract($_POST);



$delsow = $conn->query("  delete from tbl_stock_out_warehouse where sow_id = '$id' ");
if ($delsow) {


    $delsowd = $conn->query("  delete from tbl_stock_out_warehouse_detail where sow_id = '$id' ");


    if ($delsowd) {
        $res = array("res" => "success");
    } else {
        $res = array("res" => "failed");
    }
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
