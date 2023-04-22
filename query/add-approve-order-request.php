<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);

$countbox = count($_POST['item_id']);

if ($apo_id == 0) {


    $countrow = $conn->query(" SELECT max(apo_bill_number)+1 as last_number 
FROM tbl_approve_order
where date_register =  CURDATE() and br_id = '$br_id' ")->fetch(PDO::FETCH_ASSOC);


    if (empty($countrow['last_number'])) {
        $last_num = 1;
        $right_code = str_pad($last_num, 4, '0', STR_PAD_LEFT);
        $gendate_number = date("Ymd");
        $ref_bill = "$gendate_number$right_code";
    } else {
        $last_num  = $countrow['last_number'];
        $ref_bill = "$last_num";
    }


    $insert_hod = $conn->query("INSERT INTO tbl_approve_order 
   (apo_bill_number,or_id,br_id,wh_id,ar_status,add_by,date_register ) 
   VALUES('$ref_bill','$or_id','$branch_id','$wh_id','1','$id_users',CURDATE()) ");
    $lastid = $conn->lastInsertId();



    if ($insert_hod) {

        $update_order = $conn->query("update tbl_order_request set or_status = '2'
   where or_id ='$or_id'  ");

        if ($update_order) {




            for ($i = 0; $i < ($countbox); $i++) {
                extract($_POST);

                $insert_detail = $conn->query(" insert into tbl_approve_order_detail (apo_id,item_id,item_values) 
           values ('$lastid','$item_id[$i]','$value_approve[$i]') ");
            }


            $res = array("res" => "insertpass");
        } else {
            $res = array("res" => "failed");
        }
    } else {
        $res = array("res" => "failed");
    }
} else {

    $insert_detail = $conn->query(" delete from  tbl_approve_order_detail where $apo_id= '$apo_id' ");

    for ($i = 0; $i < ($countbox); $i++) {
        extract($_POST);

        $insert_detail = $conn->query(" insert into tbl_approve_order_detail (apo_id,item_id,item_values) 
        values ('$apo_id','$item_id[$i]','$value_approve[$i]') ");
    }

    $res = array("res" => "updatepass");
}




echo json_encode($res);
