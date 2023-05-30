<?php
include("../setting/checksession.php");
include("../setting/conn.php");

extract($_POST);

$nostock = 0;

$stmt2 = $conn->prepare("call stp_edit_caculate_stock_remain('$warehouse_id','$id_users','$item_id','0');");
$stmt2->execute();
if ($stmt2->rowCount() > 0) {
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

        $remain_value  = $row2['remain_value'];

        $conn = null;
        include("../setting/conn.php");



        if ($remain_value <= 0) {
            // $res = array("res" => "nostock", "item_code" => "$item_name[$h]");

            $nostock++;
        } else {
        }
    }
}

if ($nostock != 0) {
    $res = array("res" => "nostock");
} elseif ($remain_value < $item_val) {
    $res = array("res" => "nostock");
} else {

    $rowap = $conn->query("select * from tbl_approve_order_detail where apo_id ='$approve_id' and item_id = '$item_id' ")->fetch(PDO::FETCH_ASSOC);

    if (empty($rowap['item_values'])) {
        $item_approve = 0;
    } else {
        $item_approve = $rowap['item_values'];
    }



    $rowitemid = $conn->query("
    select sum(item_values) as item_detail
    from tbl_stock_out_warehouse_detail a
    left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
    where apo_id ='$approve_id' and item_id = '$item_id'
    group by item_id  ")->fetch(PDO::FETCH_ASSOC);

    if (empty($rowitemid['item_detail'])) {
        $item_detail = 0;
    } else {
        $item_detail = $rowitemid['item_detail'];
    }

    $item_out = $item_detail + $item_val;


    if ($item_approve < $item_out) {
         $res = array("res" => "limnitapprove");
 
     //    $res = array("res" => "limnitapprove", "item_name" => "$item_approve > $item_out");
    } else {
        $delete_data = $conn->query(" delete from tbl_stock_out_warehouse_detail_pre where item_id = '$item_id' and add_by = '$id_users' ");
        if ($delete_data) {

            $insert_data = $conn->query(" insert into tbl_stock_out_warehouse_detail_pre (wh_id, item_id,item_values,apo_id,add_by) 
            values ('$warehouse_id','$item_id','$item_val','$approve_id','$id_users') ");

            $res = array("res" => "success", "item_name" => $item_name);
        } else {
            $res = array("res" => "failed");
        }
    }
}





echo json_encode($res);
