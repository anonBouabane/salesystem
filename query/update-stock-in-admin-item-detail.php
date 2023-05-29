<?php


include("../setting/checksession.php");
include("../setting/conn.php");




extract($_POST);


$update_data = $conn->query(" 
update tbl_stock_in_warehouse_detail set item_values = '$item_val' 
where siwd_id = '$siwd_id' ");

if ($update_data) {

    

    $res = array("res" => "success", "item_name" => $item_name);
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);
