<?php
include('../../setting/conn.php');

$dp_id = $_POST['dp_id'];


$i = 1;

$stmt1 = $conn->prepare("select * from tbl_account_company ");
$stmt1->execute();
if ($stmt1->rowCount() > 0) {
    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $ac_ic = $row1['ac_ic'];
        $acc_name = $row1['acc_name'];
        $company_code = $row1['company_code'];
        



        $checkacc = $conn->query("SELECT  * FROM tbl_staff_company where depart_id = '$dp_id' and company_id ='$ac_ic'")->fetch(PDO::FETCH_ASSOC);

        if (!empty($checkacc['company_id'])) {
            $accheck = $checkacc['company_id'];
        } else {
            $accheck = "";
        }


?>
        <div class="col-lg-3">
            <div class="custom-control custom-checkbox checkbox-success d-inline-block mr-3 mb-3">

                <input type="checkbox" class="custom-control-input" <?php if ($accheck == $ac_ic) { echo "checked"; } ?> value='<?php echo "$ac_ic"; ?>' name="itemcheck[]" id='itemcheck<?php echo "$i"; ?>'>
                <label class="custom-control-label" for='itemcheck<?php echo "$i"; ?>'><?php echo "$acc_name ($company_code)"; ?></label>

            </div>
        </div>

<?php

        $i++;
    }
}


?>