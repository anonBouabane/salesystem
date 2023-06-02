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
select sum(item_values) as item_values ,apo_id
from tbl_stock_in_warehouse_detail a
left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
where apo_id = '$approve_id' and item_id = '$item_id'
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



	$delete_data = $conn->query(" delete from tbl_stock_in_warehouse_detail_pre where item_id = '$item_id' and add_by = '$id_users' ");

	if ($delete_data) {
		$insert_data = $conn->query("  insert into tbl_stock_in_warehouse_detail_pre 
		(apo_id,item_id,item_values,add_by) 
		values 
		('$approve_id','$item_id','$item_val','$id_users') ");
		$res = array("res" => "success", "item_name" => $item_name);
	}


	//	$res = array("res" => "overrecieve", "item_name" => "val=$item_val / detail=$val_detail / in = $item_in approve = $item_approve");
}





echo json_encode($res);
