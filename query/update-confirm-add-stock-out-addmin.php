<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);

$countbox = count($_POST['item_id']);


$nostock = 0;
$noremain = 0;
$noitem = 0;
$limit = 0;
$show_item_name = "";

for ($h = 0; $h < ($countbox); $h++) {

    $stmt2 = $conn->prepare("call stp_edit_caculate_stock_remain('$warehouse_id','$id_users','$item_id[$h]','$sow_id');");
    $stmt2->execute();
    if ($stmt2->rowCount() > 0) {
        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

            $remain_value  = $row2['remain_value'];

            $conn = null;
            include("../setting/conn.php");



            if ($remain_value <= 0) {
                // $res = array("res" => "nostock", "item_code" => "$item_name[$h]");
                 $show_item_name = $show_item_name . ' ' . $item_name[$h] . "<br>";

                $nostock++;
            } else {


                $remain =   $remain_value - $item_values[$h];

                if ($remain <= 0) {

                    $show_item_name = $show_item_name . ' ' . $item_name[$h] . "<br>";
                    $noremain++;

                    // 
                }
            }

            $rowchk = $conn->query("select item_values as app_item_app 
            from tbl_approve_order_detail
            where apo_id = '$approve_id' and item_id = '$item_id[$h]' ")->fetch(PDO::FETCH_ASSOC);

            $app_item_app = $rowchk['app_item_app'];

            if ($item_values[$h] > $app_item_app) {

                $show_item_name = $show_item_name . ' ' . $item_name[$h] . "<br>";
                $limit++;
            }
        }
    } else if (empty($stmt2->rowCount())) {

        $noitem++;
    }
}

if ($noremain > 0) {
    $res = array("res" => "noremain", "item_code" => "$show_item_name");
} else if ($nostock > 0) {
    $res = array("res" => "nostock", "item_code" => "$show_item_name");
} else if ($noitem > 0) {
    $res = array("res" => "noitem", "item_code" => "$show_item_name");
} else if ($limit > 0) {
    $res = array("res" => "limit", "item_code" => "$show_item_name");
} else {

    $clear_pre_item = $conn->query(" delete from tbl_stock_out_warehouse_detail where sow_id = '$sow_id' ");


    for ($i = 0; $i < ($countbox); $i++) {
        extract($_POST);



        $update = $conn->query(" insert into tbl_stock_out_warehouse_detail  (sow_id,item_id,item_values) values ('$sow_id','$item_id[$i]','$item_values[$i]') ");
    }


    if ($clear_pre_item) {
        $res = array("res" => "success");
    }
}




echo json_encode($res);
