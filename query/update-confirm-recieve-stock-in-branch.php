<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);

$countbox = count($_POST['item_id']);

$check_insert = "";

$over_use = 0;

$data_show ="";




for ($h = 0; $h < ($countbox); $h++) {
    extract($_POST);


    $row_count_out = $conn->query(" 
    SELECT item_id,sum(item_values) as item_values
    FROM tbl_stock_out_warehouse_detail a
    left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
    where apo_id = '$approve_id' and item_id = '$item_id[$h]'
    group by item_id  ")->fetch(PDO::FETCH_ASSOC);

    if (empty($row_count_out['item_values'])) {

        $item_out_detail = 0;
    } else {
        $item_out_detail = $row_count_out['item_values'];
    }


    $row_count_in = $conn->query(" 
    select  item_id,sum(item_values) as item_values
    from tbl_stock_in_warehouse_detail a
    left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
    where apo_id = '$approve_id' and a.siw_id != '$siw_id' and  item_id = '$item_id[$h]'
    group by item_id  ")->fetch(PDO::FETCH_ASSOC);

    if (empty($row_count_in['item_values'])) {

        $item_detail_in = 0;
    } else {
        $item_detail_in = $row_count_in['item_values'];
    }

    $item_detail = $item_values[$h]  + $item_detail_in;

    if (  $item_detail > $item_out_detail) { 

        $data_show = $data_show . ' ' . $item_name[$h] . ' <br>';
        $over_use++;
    }
}






if ($over_use > 0) { 
    $res = array("res" => "over_use", "item_name" => "$data_show");
} else {



    $clear_pre_item = $conn->query(" delete from tbl_stock_in_warehouse_detail where siw_id = '$siw_id' ");


    if ($clear_pre_item) {

        for ($i = 0; $i < ($countbox); $i++) {
            extract($_POST);

            $insert_detail = $conn->query(" insert into tbl_stock_in_warehouse_detail  (siw_id,item_id,item_values) values ('$siw_id','$item_id[$i]','$item_values[$i]') ");
        }



        if ($insert_detail) {
            $res = array("res" => "success");
        }
    }
}



echo json_encode($res);
