<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);


$stmt1 = $conn->prepare(" select distinct wh_id from tbl_stock_out_warehouse_detail_pre where add_by = '$id_users' ");
$stmt1->execute();
if ($stmt1->rowCount() == 1) {
    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

        if ($row1['wh_id'] ==  $warehouse_id) {

            $countbox = count($_POST['item_id']);

            $countrow = $conn->query(" SELECT max(sow_bill_number)+1 as last_number 
        FROM tbl_stock_out_warehouse
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




            $insertDSS = $conn->query(" insert into tbl_stock_out_warehouse  (sow_bill_number,bill_type,apo_id,br_id,wh_id,add_by,date_register) 
         values ('$ref_bill','1','$approve_id','$br_id','$warehouse_id','$id_users',CURDATE()); ");
            $lastid = $conn->lastInsertId();

            if ($insertDSS) {

                for ($i = 0; $i < ($countbox); $i++) {
                    extract($_POST);

                    if (($item_values[$i] != 0) && ($check_apo[$i] == 0)) {
                        $insert = $conn->query(" insert into tbl_stock_out_warehouse_detail  (sow_id,item_id,item_values) values ('$lastid','$item_id[$i]','$item_values[$i]') ");
                    }
                }

                $clear_pre_item = $conn->query(" delete from tbl_stock_out_warehouse_detail_pre where add_by = '$id_users' ");

                if ($clear_pre_item) {
                    $res = array("res" => "success");
                }
            }
        } else {
            $res = array("res" => "errorwarehouse");
        }
    }
} else {
    $res = array("res" => "errorwarehouse");
}




echo json_encode($res);
