<?php
include("../setting/conn.php");
extract($_POST);


$delitem = $conn->query("DELETE  FROM tbl_stock_in_warehouse WHERE siw_id ='$id'  ");
if ($delitem) {



    $delitemdetail = $conn->query("DELETE  FROM tbl_stock_in_warehouse_detail WHERE siw_id ='$id'  ");
    if ($delitemdetail) {
        $res = array("res" => "success");
    }
} else {
    $res = array("res" => "failed");
}



echo json_encode($res);
?>