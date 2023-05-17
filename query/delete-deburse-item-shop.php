<?php


include("../setting/conn.php");

extract($_POST);

$rowdetail = $conn->query("select * from tbl_deburse_item_pre_sale where sow_id = '$id' ")->fetch(PDO::FETCH_ASSOC);


$dips_id = $rowdetail['dips_id'];


$delsow = $conn->query("  delete from tbl_stock_out_warehouse where sow_id = '$id' ");
if ($delsow) {


    $delsowd = $conn->query("  delete from tbl_stock_out_warehouse_detail where sow_id = '$id' ");


    if ($delsowd) {

        $deldb = $conn->query("  delete from tbl_deburse_item_pre_sale where sow_id = '$id' ");

        if($deldb){
            $deldbd = $conn->query("  delete from tbl_deburse_item_pre_sale_detail where dips_id = '$dips_id' ");
        }

        $res = array("res" => "success");
    } else {
        $res = array("res" => "failed");
    }
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
