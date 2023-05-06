<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);

$countbox = count($_POST['item_id']);

$clear_pre_item = $conn->query(" delete from tbl_stock_out_warehouse_detail where sow_id = '$sow_id' ");


for ($i = 0; $i < ($countbox); $i++) {
    extract($_POST);

    $update = $conn->query(" insert into tbl_stock_out_warehouse_detail  (sow_id,item_id,item_values) values ('$sow_id','$item_id[$i]','$item_values[$i]') ");
}


if ($clear_pre_item) {
    $res = array("res" => "success");
}




echo json_encode($res);
