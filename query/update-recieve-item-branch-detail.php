<?php
include("../setting/checksession.php");
include("../setting/conn.php");


extract($_POST);
 
 


$rowap = $conn->query("
select sum(item_values) as item_approve
from tbl_stock_out_warehouse_detail a
left join tbl_stock_out_warehouse b on a.sow_id  = b.sow_id 
where apo_id = '$approve_id' and item_id = '$item_id'
group by apo_id  ")->fetch(PDO::FETCH_ASSOC);


if (!empty($rowap['item_approve'])) {
    $item_approve =  $rowap['item_approve'];
} else {
    $item_approve = 0;
}

$row_detail = $conn->query("
select sum(item_values) as item_values ,apo_id,a.siw_id
from tbl_stock_in_warehouse_detail a
left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
where apo_id = '$approve_id' and item_id = '$item_id' and a.siw_id != '$siw_id'
group by item_id 
")->fetch(PDO::FETCH_ASSOC);

if (empty($row_detail['item_values'])) {
    $val_detail = 0;
} else {
    $val_detail = $row_detail['item_values'];
    $check_apo = $row_detail['apo_id'];
}

$item_in = $item_val + $val_detail;

if ($item_approve < $item_in) {
    $res = array("res" => "overrecieve");
    // $res = array("res" => "overrecieve", "item_name" => "val $item_val - detail - $val_detail in - $item_in");
} else {


 

        $update_data = $conn->query("
        update tbl_stock_in_warehouse_detail
        set item_values = '$item_val'
        where item_id = '$item_id' and siw_id ='$siw_id' ");


        $res = array("res" => "success", "item_name" => $item_name);
     


    //	$res = array("res" => "overrecieve", "item_name" => "val=$item_val / detail=$val_detail / in = $item_in approve = $item_approve");
}





echo json_encode($res);
