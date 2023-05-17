<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);


$deldbd = $conn->query("  delete from tbl_stock_out_warehouse_detail_pre where item_id = '$id' and add_by = '$id_users' ");



if ($deldbd) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}


echo json_encode($res);
