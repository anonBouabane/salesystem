<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);
$countbox = count($_POST['item_id']);

$remain_check = 0;

$show_item ="";

$stmt1 = $conn->prepare(" select distinct wh_id from tbl_stock_out_warehouse_detail_pre where add_by = '$id_users' ");
$stmt1->execute();
if ($stmt1->rowCount() == 1) {
    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

        if ($row1['wh_id'] ==  $warehouse_id) {



            for ($a = 0; $a < ($countbox); $a++) {
                extract($_POST);

                $stmt2 = $conn->prepare("call stp_caculate_shop_stock_remain('$warehouse_id','$item_id[$a]');");
                $stmt2->execute();
                if ($stmt2->rowCount() > 0) {
                    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                        $remain_item = $row2['remain_value'];

                        $remain_value = $remain_item - $item_values[$a];

                        if ($remain_value < 0) {
                            $remain_value = "nostock";

                            $show_item = $show_item .' ' . $item_name[$a] . '<br>';
                            $remain_check++;
                        }
                    }
                }  
                $conn = null;
                include("../setting/conn.php");
            }

            if ($remain_check > 0) {
                $res = array("res" => "nostock", "item_code" => "$show_item");
            } else {



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




                $insertDSS = $conn->query(" insert into tbl_stock_out_warehouse  (sow_bill_number,bill_type,br_id,wh_id,add_by,date_register) 
                values ('$ref_bill','1','$br_id','$warehouse_id','$id_users',CURDATE()); ");
                $lastid = $conn->lastInsertId();

                if ($insertDSS) {

                    for ($i = 0; $i < ($countbox); $i++) {
                        extract($_POST);

                        if ($item_values[$i] != 0) {
                            $insert = $conn->query(" insert into tbl_stock_out_warehouse_detail  (sow_id,item_id,item_values) values ('$lastid','$item_id[$i]','$item_values[$i]') ");
                        }
                    }

                    $clear_pre_item = $conn->query(" delete from tbl_stock_out_warehouse_detail_pre where add_by = '$id_users' ");

                    if ($clear_pre_item) {

                        $rowdb = $conn->query(" 
                    SELECT max(dips_bill_number)+1 as last_number 
                    FROM tbl_deburse_item_pre_sale
                    where date_register =  CURDATE() and br_id = '$br_id'  ")->fetch(PDO::FETCH_ASSOC);


                        if (empty($rowdb['last_number'])) {
                            $last_num = 1;

                            $right_code = str_pad($last_num, 4, '0', STR_PAD_LEFT);
                            $gendate_number = date("Ymd");

                            $bill_deburse = "$gendate_number$right_code";
                        } else {
                            $last_num  = $rowdb['last_number'];

                            $bill_deburse = "$last_num";
                        }




                        $insertDSS = $conn->query(" insert into tbl_deburse_item_pre_sale  (dips_bill_number,sow_id,br_id,wh_id,add_by,date_register) 
                    values ('$bill_deburse','$lastid','$br_id','$warehouse_id','$id_users',CURDATE()); ");
                        $deburse_id = $conn->lastInsertId();

                        for ($j = 0; $j < ($countbox); $j++) {
                            extract($_POST);

                            if ($item_values[$j] != 0) {
                                $insert = $conn->query(" insert into tbl_deburse_item_pre_sale_detail  (dips_id,item_id,item_values) values ('$deburse_id','$item_id[$j]','$item_values[$j]') ");
                                $res = array("res" => "success");
                            }
                        }
                    }
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
