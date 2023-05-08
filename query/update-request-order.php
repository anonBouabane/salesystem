<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);
$countbox = count($_POST['item_name']);

$empty_item = 0;
$empty_value = 0;
$show_item_name = "";

for ($h = 0; $h < ($countbox); $h++) {

    if (empty($item_name[$h])) {
        $show_item_name = $show_item_name . ' ' . $list_box[$h]  ;
        $empty_item++;
    }
    if (empty($item_value[$h])) {
        $show_item_name = $show_item_name . ' ' . $list_box[$h]  ;
        $empty_value++;
    }
}

if ($empty_item > 0) {
    $res = array("res" => "emptylist", "item_code" => "$show_item_name");
} else if ($empty_value > 0) {
    $res = array("res" => "emptylist", "item_code" => "$show_item_name");
} else {
    if ($wh_id == 0) {
        $res = array("res" => "nowarehouse");
    } else {

        $update_data = $conn->query("
        update tbl_order_request set
        wh_id = '$wh_id'
        where or_id = '$or_id' ");

        if ($update_data) {

            $clear_data = $conn->query(" delete from tbl_order_request_detail where or_id = '$or_id' ");

            if ($clear_data) {

                for ($i = 0; $i < ($countbox); $i++) {
                    extract($_POST);
                    $insert_rod = $conn->query("INSERT INTO tbl_order_request_detail (or_id,item_id,item_values) VALUES ('$or_id','$item_name[$i]','$item_value[$i]')");
                }

                $res = array("res" => "success");
            }
        }
    }
}


echo json_encode($res);
