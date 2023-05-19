<?php
include("../setting/checksession.php");
include("../setting/conn.php");


extract($_POST);

$item_out = 0;


if (!empty($box_barcode)) {

    $stmt1 = $conn->prepare(" 
    
    SELECT DISTINCT a.item_id, item_name, wh_id
    FROM  tbl_stock_in_warehouse_detail a
    left join tbl_item_data b on a.item_id = b.item_id
    left join tbl_stock_in_warehouse c on a.siw_id = c.siw_id
    where barcode ='$box_barcode' and wh_id = '$warehouse_id' ");
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


            $rowcheck = $conn->query(" select (item_values+1) as item_values,item_id from tbl_stock_out_warehouse_detail
             where sow_id = '$sow_id' and  item_id = '$item_id' ")->fetch(PDO::FETCH_ASSOC);

            if (empty($rowcheck['item_id'])) {

                $insertSTI = $conn->query("   insert into tbl_stock_out_warehouse_detail (sow_id,item_id,item_values) values ('$sow_id','$item_id','1');  ");
                $res = array("res" => "success");
            } else {

                $item_values = $rowcheck['item_values'];
 

                $update = $conn->query(" update tbl_stock_out_warehouse_detail set item_values = '$item_values' where sow_id = '$sow_id' and  item_id = '$item_id' ");
                $res = array("res" => "success");
            }
        }
    } else {
        $res = array("res" => "nofound", "item_code" => "$box_barcode");
    }
}

echo json_encode($res);
