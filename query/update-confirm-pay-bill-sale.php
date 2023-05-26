<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);


$sum_total = 0;

$cash_back = 0;

if (empty($_POST['item_id'])) {

    $res = array("res" => "error");
} else {
    $countbox = count($_POST['item_id']);




    $update_bill = $conn->query("
    update tbl_bill_sale
    set payment_type = '$paytype'
    where bs_id = '$bs_id' 
    ");

    if ($update_bill) {

        $clear_detail = $conn->query("delete from tbl_bill_sale_detail where bs_id = '$bs_id'  ");


        if ($clear_detail) {
            for ($i = 0; $i < ($countbox); $i++) {
                extract($_POST);

                $insert_detail = $conn->query(" insert into tbl_bill_sale_detail (bs_id,item_id,item_values,item_total_price)
                 values ('$bs_id','$item_id[$i]','$item_value[$i]','$total_price[$i]') ");

                $sum_total += $total_price[$i];
            }


            $res = array("res" => "success");
        }



        // $res = array("res" => "success");

        // if ($insert_detail) {
        //     $clear_pre = $conn->query("delete from tbl_bill_sale_detail_pre where add_by = '$id_users' ");

        //     if ($clear_pre) {

        //         $cash_back =  $monney_recieve -  $sum_total;

        //         $res = array("res" => "success", "cash_back" => $cash_back);
        //     }
        // }
    }
}








echo json_encode($res);
