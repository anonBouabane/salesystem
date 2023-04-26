<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);

if ($wh_id == 0) {
    $res = array("res" => "nowarehouse");
} else {


    $countrow = $conn->query(" SELECT max(or_bill_number)+1 as last_number 
    FROM tbl_order_request
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
 

    $insert_hod = $conn->query("INSERT INTO tbl_order_request 
    (or_bill_number,br_id,wh_id,or_status,add_by,date_register ) 
    VALUES('$ref_bill','$br_id','$wh_id','1','$id_users',CURDATE()) ");

    $lastid = $conn->lastInsertId();

    if ($insert_hod) {
        $countbox = count($_POST['item_name']);

        for ($i = 0; $i < ($countbox); $i++) {
            extract($_POST);
            $insert_rod = $conn->query("INSERT INTO tbl_order_request_detail (or_id,item_id,item_values) VALUES ('$lastid','$item_name[$i]','$item_value[$i]')");
        }

        $res = array("res" => "success");
    } else {
        $res = array("res" => "failed");
    }
}

echo json_encode($res);
