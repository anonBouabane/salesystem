<?php


include("../setting/checksession.php");
include("../setting/conn.php");




extract($_POST);

$stmt2 = $conn->prepare("call stp_edit_check_stock_shop_sale('$br_id','$id_users','$item_id');");
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
$conn = null;
include("../setting/conn.php");

if ($remain_value == "nostock") {
	$res = array("res" => "failed");
} else {
	if ($remain_value < $item_val) {
		$res = array("res" => "failed");
	} else {

		$delete_data = $conn->query(" delete from tbl_bill_sale_detail_pre where item_id = '$item_id' and add_by = '$id_users' ");
		if ($delete_data) {

			$insert_data = $conn->query("  insert into tbl_bill_sale_detail_pre (item_id,item_values,br_id,add_by) values ('$item_id','$item_val','$br_id','$id_users') ");

			$res = array("res" => "success", "item_name" => $item_name);
		} else {
			$res = array("res" => "failed");
		}
	}
}




echo json_encode($res);
