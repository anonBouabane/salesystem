<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);


$sum_total = 0;

$cash_back = 0;
 if ($monney_recieve < $monney_pay) {
    $res = array("res" => "notenoughtmoney");
} else {
   

    $countrow = $conn->query(" SELECT max(sale_bill_number)+1 as last_number 
    FROM tbl_bill_sale
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



    $insert_bill = $conn->query("insert into tbl_bill_sale (sale_bill_number,total_pay,br_id,bill_status,payment_type,sale_by,date_register) 
values ('$ref_bill','$monney_pay','$br_id','2','$paytype','$id_users',CURDATE())");
    $lastid = $conn->lastInsertId();

    if ($insert_bill) {

        $countbox = count($_POST['item_id_modal']);

        for ($i = 0; $i < ($countbox); $i++) {
            extract($_POST);

            $insert_detail = $conn->query(" insert into tbl_bill_sale_detail (bs_id,item_id,item_values,item_total_price)
             values ('$lastid','$item_id_modal[$i]','$item_value[$i]','$total_price[$i]') ");

            $sum_total += $total_price[$i];
        }

        // $res = array("res" => "success");

        if ($insert_detail) {
            $clear_pre = $conn->query("delete from tbl_bill_sale_detail_pre where add_by = '$id_users' ");

            if ($clear_pre) {

                $cash_back =  $monney_recieve -  $sum_total;

                $res = array("res" => "success", "cash_back" => $cash_back);
            }
        }
    }
}








echo json_encode($res);
