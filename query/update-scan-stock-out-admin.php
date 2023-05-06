<?php
include("../setting/checksession.php");
include("../setting/conn.php");


extract($_POST);

$item_out = 0;


if (!empty($box_barcode)) {

    $stmt1 = $conn->prepare(" select  a.item_id,item_name,item_values
    from tbl_approve_order_detail a
    left join tbl_item_data b on a.item_id = b.item_id 
    where barcode ='$box_barcode' and apo_id = '$approve_id' ");
    $stmt1->execute();
    if ($stmt1->rowCount() > 0) {
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

            $item_id  = $row1['item_id'];
            $item_name  = $row1['item_name'];
        }
    }

    if (!empty($item_id)) {

        $stmt2 = $conn->prepare("call stp_caculate_stock_remain('$warehouse_id','$id_users','$item_id');");
        $stmt2->execute();
        if ($stmt2->rowCount() > 0) {
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                $remain_value  = $row2['remain_value'];

                if ($remain_value <= 0) {
                    $remain_value = "nostock";
                }
            }
        } else if (empty($stmt2->rowCount())) {
            $remain_value = "noitem";
        }




        if ($remain_value == "nostock") {
            $res = array("res" => "nostock", "item_code" => "$item_name");
        } else if ($remain_value == "noitem") {
            $res = array("res" => "noitem", "item_code" => "$item_name");
        } else {
            $conn = null;
            include("../setting/conn.php");


            $check_approve = $conn->query("
            SELECT   sum(item_values) as item_values  
            FROM tbl_approve_order_detail
            WHERE apo_id = '$approve_id' and item_id = '$item_id' 
            group by item_id   ")->fetch(PDO::FETCH_ASSOC);

            $item_approve =   $check_approve['item_values'];


            $check_used = $conn->query("
            SELECT   sum(item_values) as item_values  
            FROM tbl_stock_out_warehouse_detail a
            left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
            WHERE apo_id = '$approve_id' and item_id = '$item_id' 
            group by item_id    ")->fetch(PDO::FETCH_ASSOC);


            if (empty($check_used['item_values'])) {
                $item_use = 0;
            } else {
                $item_use =   $check_used['item_values'];
            }




            $check_out = $conn->query("
            SELECT   sum(item_values) as item_values  
            FROM tbl_stock_out_warehouse_detail_pre
            WHERE add_by ='$id_users'  and item_id = '$item_id'
            group by item_id   ")->fetch(PDO::FETCH_ASSOC);



            if (empty($check_out['item_values'])) {
                $item_out = 0;
            } else {
                $item_out = $check_out['item_values'];
            }



            if (($item_out + $item_use) >= $item_approve) {
                $res = array("res" => "orverorder", "item_code" => "$item_name");
            } else {

                $insertSTI = $conn->query(" insert into tbl_stock_out_warehouse_detail  
                (sow_id, item_id,item_values)  
                values ('$sow_id','$item_id','1'); ");

                $res = array("res" => "success");
            }
        }
    } else {
        $res = array("res" => "nofound", "item_code" => "$box_barcode");
    }
}

echo json_encode($res);
