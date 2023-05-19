<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);
$countbox = count($_POST['item_id']);

$remain_check = 0;

$show_item = "";





for ($a = 0; $a < ($countbox); $a++) {
    extract($_POST);

    $stmt2 = $conn->prepare("call stp_edit_caculate_shop_stock_remain('$warehouse_id','$item_id[$a]','$sow_id');");
    $stmt2->execute();
    if ($stmt2->rowCount() > 0) {
        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

            $remain_item = $row2['remain_value'];

            $remain_value = $remain_item - $item_values[$a];

            if ($remain_value < 0) {
                $remain_value = "nostock";

                $show_item = $show_item . ' ' . $item_name[$a] . '<br>';
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


    $clear_pre_item = $conn->query(" delete from tbl_stock_out_warehouse_detail where sow_id = '$sow_id' ");
  
        for ($i = 0; $i < ($countbox); $i++) {
            extract($_POST);

            if ($item_values[$i] != 0) {
                $insert = $conn->query(" insert into tbl_stock_out_warehouse_detail  (sow_id,item_id,item_values) values ('$sow_id','$item_id[$i]','$item_values[$i]') ");
            }
        }

 

        
        if ($clear_pre_item) {

        
            $clear_pre_item = $conn->query(" delete from tbl_deburse_item_pre_sale_detail where dips_id = '$dips_id' ");
  

            for ($j = 0; $j < ($countbox); $j++) {
                extract($_POST);

                if ($item_values[$j] != 0) {
                    $insert = $conn->query(" insert into tbl_deburse_item_pre_sale_detail  (dips_id,item_id,item_values) values ('$dips_id','$item_id[$j]','$item_values[$j]') ");
                    $res = array("res" => "success");
                }
            }
        }
    
}




echo json_encode($res);
