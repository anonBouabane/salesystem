<?php


include("../setting/checksession.php");
include("../setting/conn.php");




extract($_POST);

$stmt2 = $conn->prepare("call stp_edit_check_stock_shop_sale_detail('$br_id','$item_id','$bs_id');");
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

        $update_data = $conn->query(" update tbl_bill_sale_detail set item_values = '$item_val' where bs_id = '$bs_id' and  item_id = '$item_id'  ");

        if ($update_data) {

           
            $res = array("res" => "success", "item_name" => $item_name);
        } else {
            $res = array("res" => "failed");
        }
    }
}




echo json_encode($res);
