<?php

include("../setting/checksession.php");
include("../setting/conn.php");


$id = $_GET['id'];

$select_item = $conn->query("
select sum(item_values) as item_count,item_name,a.siw_id,a.item_id,apo_id
from tbl_stock_in_warehouse_detail a
left join tbl_item_data b on a.item_id = b.item_id
left join tbl_stock_in_warehouse c on a.siw_id = c.siw_id
WHERE siwd_id='$id'  
group by a.item_id,a.siw_id,apo_id
")->fetch(PDO::FETCH_ASSOC);

?>

<fieldset style="width:543px;">
    <legend><i class="facebox-header"><i class="edit large icon text-center"> <?php echo ($select_item['item_name']); ?> </i></legend>
    <div class="col-md-12 mt-4">
        <form method="post" id="UpdateRecieveItemBranchDetail">

            <input type="hidden" name="item_name" class="form-control" required="" value="<?php echo $select_item['item_name']; ?>">

            <input type="hidden" name="item_id" class="form-control" required="" value="<?php echo $select_item['item_id']; ?>">
 
            <input type="hidden" name="siw_id" class="form-control" required="" value="<?php echo $select_item['siw_id']; ?>">

            <input type="hidden" name="approve_id" class="form-control" required="" value="<?php echo $select_item['apo_id']; ?>">


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