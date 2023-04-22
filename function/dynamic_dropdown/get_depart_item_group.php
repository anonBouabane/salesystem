<?php
include('../../setting/conn.php');

$dp_id = $_POST['dp_id'];


$i = 1;

$stmt1 = $conn->prepare("select * from tbl_item_company_code ");
$stmt1->execute();
if ($stmt1->rowCount() > 0) {
    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $icc_id = $row1['icc_id'];
        $name_company = $row1['name_company'];
        $item_company_code = $row1['item_company_code'];
        



        $checkitem = $conn->query("SELECT  * FROM tbl_staff_item_code where use_by = '$dp_id' and icc_id ='$icc_id'")->fetch(PDO::FETCH_ASSOC);

        if (!empty($checkitem['icc_id'])) {
            $icheck = $checkitem['icc_id'];
        } else {
            $icheck = "";
        }


?>
        <div class="col-lg-3">
            <div class="custom-control custom-checkbox checkbox-success d-inline-block mr-3 mb-3">

                <input type="checkbox" class="custom-control-input" <?php if ($icheck == $icc_id) { echo "checked"; } ?> value='<?php echo "$icc_id"; ?>' name="itemcheck[]" id='itemcheck<?php echo "$i"; ?>'>
                <label class="custom-control-label" for='itemcheck<?php echo "$i"; ?>'><?php echo "$name_company (S$item_company_code)"; ?></label>

            </div>
        </div>

<?php

        $i++;
    }
}


?>