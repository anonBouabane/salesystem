<?php

include("../setting/checksession.php");
include("../setting/conn.php");


$id = $_GET['id'];

$select_item = $conn->query(" 
select  sum(item_values) as item_count,item_name,apo_id,wh_id,a.sow_id,a.item_id
from tbl_stock_out_warehouse_detail a
left join tbl_item_data b on a.item_id = b.item_id
left join tbl_stock_out_warehouse c on a.sow_id = c.sow_id
where sowd_id = '$id'
group by a.item_id,apo_id,wh_id,a.sow_id
")->fetch(PDO::FETCH_ASSOC);

?>

<fieldset style="width:543px;">
    <legend><i class="facebox-header"><i class="edit large icon text-center"> <?php echo ($select_item['item_name']); ?> </i></legend>
    <div class="col-md-12 mt-4">
        <form method="post" id="updatestockoutdetail">

            <input type="hidden" name="item_name" class="form-control" required="" value="<?php echo $select_item['item_name']; ?>">
            <input type="hidden" name="approve_id" class="form-control" required="" value="<?php echo $select_item['apo_id']; ?>">
            <input type="hidden" name="warehouse_id" class="form-control" required="" value="<?php echo $select_item['wh_id']; ?>">
            <input type="hidden" name="sow_id" class="form-control" required="" value="<?php echo $select_item['sow_id']; ?>">

            <input type="hidden" name="item_id" class="form-control" required="" value="<?php echo $select_item['item_id']; ?>">
 

            <div class="form-group">
                <legend>ຈຳນວນ</legend>
                <input type="number" name="item_val" class="form-control" required="" value="<?php echo $select_item['item_count']; ?>">
            </div>


            <div class="form-group" align="right">
                <button type="submit" class="btn btn-sm btn-primary">ແກ້ໄຂ</button>
            </div>
        </form>
    </div>
</fieldset>