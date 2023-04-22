<?php
include('../../setting/conn.php');

$Acc_id = $_POST['Acc_id'];
?>


<?php

$checkitem = $conn->query("SELECT  * FROM tbl_account_company where company_code = '$Acc_id' ")->fetch(PDO::FETCH_ASSOC);

 

if (!empty($checkitem['code_type'])) {
    $code_type = $checkitem['code_type'];
} else {
    $code_type = "";
}

if ($code_type == "pvcode") {
?>


    <div class="form-group  ">
        <label class="text-dark font-weight-medium">ລະຫັດແຂວງ</label>
        <div class="form-group">
            <select class=" form-control font" name="pv_code" id="pv_code">
                <option value='0'> ເລືອກເມືອງ </option>
                <?php
                $stmt = $conn->prepare(" SELECT pv_code, concat(pv_code,' (',pv_name,') ') as full_pv_code FROM tbl_provinces order by pv_code   ");
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $pv_code = $row['pv_code'];
                        $full_pv_code = $row['full_pv_code'];
                        echo "<option value='$pv_code'>$full_pv_code</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
<?php
} elseif ($code_type == "teamcode") {
?>
    <div class="form-group  ">
        <label class="text-dark font-weight-medium">ລະຫັດແຂວງ</label>
        <div class="form-group">
            <select class=" form-control font" name="pv_code" id="pv_code">
                <option value='0'> ເລືອກເມືອງ </option>
                <?php
                $stmt = $conn->prepare(" SELECT * FROM tbl_kptl_tcode    ");
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $kt_name = $row['kt_name'];
                        echo "<option value='$kt_name'>$kt_name</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
<?php
} else {
?>
    <input type="hidden" class="form-control" id="pv_code" name="pv_code">
<?php
}

?>