<?php
include("../setting/checksession.php");
include("../setting/conn.php");


extract($_POST);


if (!empty($box_barcode)) {

    $stmt1 = $conn->prepare("
    select c.item_id,item_name,item_values
    from tbl_stock_out_warehouse_detail a
    left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
    left join tbl_item_data c  on a.item_id = c.item_id
    where barcode ='$box_barcode' and apo_id = '$approve_id'
      ");
    $stmt1->execute();
    if ($stmt1->rowCount() > 0) {
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

            $item_id  = $row1['item_id'];
            $item_name  = $row1['item_name'];
        }
    }

    if (!empty($item_id)) {


        $check_out = $conn->query("
        select c.item_id,sum(a.item_values) as item_values
        from tbl_stock_out_warehouse_detail a
        left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
        left join tbl_item_data c  on a.item_id = c.item_id
        WHERE apo_id = '$approve_id' and a.item_id = '$item_id' 
        group by c.item_id 
         ")->fetch(PDO::FETCH_ASSOC);

        $item_out =   $check_out['item_values'];


        $check_in_pre = $conn->query("
        SELECT   sum(item_values) as item_values  
        FROM tbl_stock_in_warehouse_detail_pre
        WHERE add_by ='$id_users'  and item_id = '$item_id'
        group by item_id   ")->fetch(PDO::FETCH_ASSOC);



        if (empty($check_in_pre['item_values'])) {
            $item_in_pre = 0;
        } else {
            $item_in_pre = $check_in_pre['item_values'];
        }

        $check_in = $conn->query("
        SELECT   sum(item_values) as item_values  
        FROM tbl_stock_in_warehouse_detail a
        left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
        WHERE   item_id = '$item_id' and apo_id = '$approve_id'
        group by item_id   ")->fetch(PDO::FETCH_ASSOC);



        if (empty($check_in['item_values'])) {
            $item_in = 0;
        } else {
            $item_in = $check_in['item_values'];
        }

        $total_in = $item_in + $item_in_pre;


        if ($total_in >= $item_out) {
            $res = array("res" => "orverorder", "item_code" => "$item_name");
        } else {


            $check_insert = $conn->query("
            
            select item_id,(item_values)+1 as item_values
            from tbl_stock_in_warehouse_detail
            where siw_id = '$siw_id' and  item_id = '$item_id'
            group by item_id ")->fetch(PDO::FETCH_ASSOC);


            if (empty($check_insert['item_values'])) {



                $insert_detail = $conn->query(" insert into tbl_stock_in_warehouse_detail  ( siw_id,item_id,item_values) values ('$siw_id','$item_id','1'); ");
                $res = array("res" => "success");

            } else {
               
                $val_update = $check_insert['item_values'];

                $update_detail = $conn->query(" 
                update tbl_stock_in_warehouse_detail
                set item_values = '$val_update'
                where siw_id = '$siw_id' and  item_id = '$item_id'   ");
                $res = array("res" => "success");

            }
    

         


          
        }



       
    } else {
        $res = array("res" => "nofound", "item_code" => "$box_barcode");
    }
}

echo json_encode($res);
