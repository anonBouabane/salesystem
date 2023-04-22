<?php
include('../../setting/conn.php');

$role_id = $_POST['role_id'];

$pcheck = "";

$i = 1;
$stmt = $conn->prepare("select * from tbl_sub_title ");
$stmt->execute();
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $st_id = $row['st_id'];
        $st_name = $row['st_name'];

?>

        <div class="form-group">
            <label for="firstName"><?php echo  "$st_name"; ?></label>
            <br>

            <?php

            $stmt1 = $conn->prepare("select * from tbl_page_title where st_id ='$st_id'");
            $stmt1->execute();
            if ($stmt1->rowCount() > 0) {
                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $pt_id = $row1['pt_id'];
                    $pt_name = $row1['pt_name'];


                    $stmt2 = $conn->prepare(" SELECT  * FROM tbl_role_page where role_id = '$role_id' and pt_id ='$pt_id'  ");
                    $stmt2->execute();
                    if ($stmt2->rowCount() > 0) {
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            
                            
                            if (!empty($row2['pt_id'])) {
                                $pcheck = $row2['pt_id'];
                            } else {
                                $pcheck = "";
                            }
        

                        }
                    }

               


            ?>
                    <div class="custom-control custom-checkbox checkbox-success d-inline-block mr-3 mb-3">

                        <input type="checkbox" class="custom-control-input" <?php if ($pcheck == $pt_id) {
                                                                                echo "checked";
                                                                            } ?> value='<?php echo "$pt_id"; ?>' name="pagecheck[]" id='pagecheck<?php echo "$i"; ?>'>
                        <label class="custom-control-label" for='pagecheck<?php echo "$i"; ?>'><?php echo "$pt_name"; ?></label>
                    </div>

            <?php

                    $i++;
                }
            }


            ?>


        </div>


<?php

    }
}


?>