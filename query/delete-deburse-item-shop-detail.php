<?php


include("../setting/conn.php");

extract($_POST);

$rowdetail = $conn->query("
select  a.sow_id,item_id,dips_id
from tbl_stock_out_warehouse_detail a
left join tbl_deburse_item_pre_sale b on a.sow_id = b.sow_id
where sowd_id = '$id' ")->fetch(PDO::FETCH_ASSOC);

$sow_id = $rowdetail['sow_id'];
$item_id = $rowdetail['item_id'];
$dips_id = $rowdetail['dips_id'];





$delsow = $conn->query("  delete from tbl_stock_out_warehouse_detail where sowd_id = '$id' ");

if ($delsow) {

    $delitem = $conn->query("  delete from tbl_deburse_item_pre_sale_detail where dips_id = '$dips_id' and  item_id = '$item_id' ");

    if ($delitem) {
        $res = array("res" => "success");
    }
}




echo json_encode($res);
