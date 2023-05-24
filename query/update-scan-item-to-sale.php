<?php
include("../setting/checksession.php");
include("../setting/conn.php");


extract($_POST);


if (!empty($box_barcode)) {

    $stmt1 = $conn->prepare("
    select a.item_id,item_name,item_price
    from tbl_deburse_item_pre_sale_detail a
    left join tbl_deburse_item_pre_sale b on a.dips_id = b.dips_id
    left join tbl_item_data c on a.item_id = c.item_id
    left join tbl_item_price d on a.item_id = d.item_id and b.br_id = d.br_id
    where barcode ='$box_barcode' and b.br_id = '$br_id' 
    ");
    $stmt1->execute();
    if ($stmt1->rowCount() > 0) {
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

            $item_id  = $row1['item_id'];
            $item_name  = $row1['item_name'];
            $item_price = $row1['item_price'];
        }
    }

    if (!empty($item_id)) {

        $stmt2 = $conn->prepare("call stp_check_stock_shop_sale_detail('$br_id', '$item_id');");
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



        //   $res = array("res" => "orverorder", "item_code" => "$item_name");

        if ($remain_value == "nostock") {
            $res = array("res" => "nostock", "item_code" => "$item_name");
        } else if ($item_price == 0) {
            $res = array("res" => "noprice", "item_code" => "$item_name");
        } else {
            $conn = null;
            include("../setting/conn.php");


            $check_data = $conn->query("
            select (item_values)+1 as item_values
            from tbl_bill_sale_detail 
            where bs_id = '$bs_id' and item_id = '$item_id' ")->fetch(PDO::FETCH_ASSOC);


            if (empty($check_data['item_values'])) {

                $insertSTI = $conn->query(" insert into tbl_bill_sale_detail  (bs_id,item_id,item_values,item_total_price)
            values ('$bs_id','$item_id','1','0'); ");
                $res = array("res" => "success");

            } else {

                $check_val = $check_data['item_values'];

                $price_update = $check_val * $item_price ;

                $insertSTI = $conn->query(" 
                update tbl_bill_sale_detail
                set  item_values = '$check_val' , item_total_price = '$price_update'
                where bs_id = '$bs_id' and item_id = '$item_id' ");


                
                    $res = array("res" => "success");

            }
        }
    } else {
        $res = array("res" => "nofound", "item_code" => "$box_barcode");
    }
}

echo json_encode($res);
