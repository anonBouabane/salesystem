<?php


include("../setting/checksession.php");
include("../setting/conn.php");




extract($_POST);


$delete_data = $conn->query(" delete from tbl_stock_in_warehouse_detail_pre where item_id = '$item_id' and add_by = '$id_users' ");
if ($delete_data) {

    $insert_data = $conn->query(" insert into tbl_stock_in_warehouse_detail_pre (item_id,item_values,add_by) 
    values ('$item_id','$item_val','$id_users') ");

    $res = array("res" => "success", "item_name" => $item_name);
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);
