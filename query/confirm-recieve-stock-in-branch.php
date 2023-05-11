<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);



$countbox = count($_POST['item_id']);

$countrow = $conn->query(" SELECT max(siw_bill_number)+1 as last_number 
    FROM tbl_stock_in_warehouse
    where date_register =  CURDATE() and br_id = '$br_id'  ")->fetch(PDO::FETCH_ASSOC);



if (empty($countrow['last_number'])) {
    $last_num = 1;

    $right_code = str_pad($last_num, 4, '0', STR_PAD_LEFT);
    $gendate_number = date("Ymd");

    $ref_bill = "$gendate_number$right_code";
} else {
    $last_num  = $countrow['last_number'];
    $ref_bill = "$last_num";
}




$insertDSS = $conn->query(" insert into tbl_stock_in_warehouse  (siw_bill_number,apo_id,bill_type,br_id,wh_id,add_by,date_register) 
    values ('$ref_bill','$approve_id','2','$br_id','$warehouse_id','$id_users',CURDATE()); ");
$lastid = $conn->lastInsertId();

if ($insertDSS) {

    for ($i = 0; $i < ($countbox); $i++) {
        extract($_POST);

        $update = $conn->query(" insert into tbl_stock_in_warehouse_detail  (siw_id,item_id,item_values) values ('$lastid','$item_id[$i]','$item_values[$i]') ");
    }

    $clear_pre_item = $conn->query(" delete from tbl_stock_in_warehouse_detail_pre where add_by = '$id_users' ");

    if ($clear_pre_item) {
        $res = array("res" => "success");
    }
}

echo json_encode($res);
