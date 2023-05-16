<?php
include("../setting/checksession.php");

include("../setting/conn.php");
extract($_POST);

if ($wh_id == 0) {
    $res = array("res" => "nowarehouse");
} else {
    $countbox = count($_POST['item_id']);
 

  

    $insertDSS = $conn->query(" 
    update tbl_stock_in_warehouse 
    set wh_id  = '$wh_id'
    where siw_id ='$siw_id'
 
    ");

    $clear_item = $conn->query(" delete from tbl_stock_in_warehouse_detail where siw_id = '$siw_id' ");
 

    if ($clear_item) {

        for ($i = 0; $i < ($countbox); $i++) {
            extract($_POST);

            $update = $conn->query(" insert into tbl_stock_in_warehouse_detail  (siw_id,item_id,item_values) values ('$siw_id','$item_id[$i]','$item_values[$i]') ");
           
        }

        
            $res = array("res" => "success");
        
    }
}

echo json_encode($res);
