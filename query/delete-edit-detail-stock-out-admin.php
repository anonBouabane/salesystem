<?php

include("../setting/checksession.php");
include("../setting/conn.php");
extract($_POST);



$delitemdetail = $conn->query("DELETE  FROM tbl_stock_out_warehouse_detail WHERE sowd_id ='$id' ");
if ($delitemdetail) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}


echo json_encode($res);
