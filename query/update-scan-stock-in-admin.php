<?php
include("../setting/checksession.php");
include("../setting/conn.php");


extract($_POST);


if (!empty($box_barcode)) {

    $stmt1 = $conn->prepare(" select item_id,item_name
    from tbl_item_data 
    where barcode ='$box_barcode' ");
    $stmt1->execute();
    if ($stmt1->rowCount() > 0) {
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

            $item_id  = $row1['item_id'];
        }
    }

    if (!empty($item_id)) {

        $stmt2 = $conn->prepare(" 
        select (item_values+1) as item_values from tbl_stock_in_warehouse_detail
        where item_id = '$item_id' and siw_id ='$siw_id' ");
        $stmt2->execute();
        if ($stmt2->rowCount() > 0) {
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                $item_values  = $row2['item_values'];
 

                $insertSTI = $conn->query("
                update tbl_stock_in_warehouse_detail set 
                item_values = '$item_values'
                where item_id ='$item_id' and siw_id ='$siw_id'
                 ");
    
                $res = array("res" => "success");

            }
        } else {

            $insertSTI = $conn->query(" insert into tbl_stock_in_warehouse_detail  
            (siw_id,item_id,item_values)  
             values ('$siw_id','$item_id','1'); ");

             $res = array("res" => "success");
        }
    } else {
        $res = array("res" => "nofound", "item_code" => "$box_barcode");
    }
}

echo json_encode($res);
