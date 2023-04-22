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
            $item_name  = $row1['item_name'];
            
        }
    }

    if (!empty($item_id)) {

        $insertSTI = $conn->query(" insert into tbl_stock_in_warehouse_detail_pre  
        ( item_id,item_values,add_by)  
         values ('$item_id','1','$id_users'); ");

        $res = array("res" => "success");

 
    } else {
        $res = array("res" => "nofound", "item_code" => "$box_barcode");
    }
}

echo json_encode($res);
