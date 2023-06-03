<?php

include("../setting/checksession.php");
include("../setting/conn.php");


$id = $_GET['id'];

$select_item = $conn->query(" SELECT a.item_id, item_name,sum(item_values) as item_values,wh_id
FROM tbl_stock_out_warehouse_detail_pre a
left join tbl_item_data b on a.item_id = b.item_id
WHERE a.item_id = '$id' and add_by = '$id_users' 
group by a.item_id,wh_id ")->fetch(PDO::FETCH_ASSOC);


?>

<fieldset style="width:543px;">
    <legend><i class="facebox-header"><i class="edit large icon text-center"> <?php echo ($select_item['item_name']); ?> </i></legend>
    <div class="col-md-12 mt-4">
        <form method="post" id="updateItemDebursePre">

            <input type="hidden" name="item_name" class="form-control" required="" value="<?php echo $select_item['item_name']; ?>">
            <input type="hidden" name="warehouse_id" class="form-control" required="" value="<?php echo $select_item['wh_id']; ?>">
            <input type="hidden" name="item_id" class="form-control" required="" value="<?php echo $select_item['item_id']; ?>">

            <div class="form-group">
                <legend>ຈຳນວນ</legend>
                <input type="number" name="item_val" class="form-control" required="" value="<?php echo $select_item['item_values']; ?>">
            </div>


            <div class="form-group" align="right">
                <button type="submit" class="btn btn-sm btn-primary">ແກ້ໄຂ</button>
            </div>
        </form>
    </div>
</fieldset>