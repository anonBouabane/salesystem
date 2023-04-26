<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ເບີກສິນຄ້າອອກສາງ";
$header_click = "2";

$apo_id = $_GET['apo_id'];

?>

<!DOCTYPE html>


<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />



    <?php

    include("../setting/callcss.php");

    ?>



</head>
<script src="../plugins/nprogress/nprogress.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>



<body class="navbar-fixed sidebar-fixed" id="body">




    <div class="wrapper">

        <?php include "menu.php"; ?>

        <div class="page-wrapper">

            <?php

            include "header.php";
            ?>
            <div class="content-wrapper">
                <div class="content">
                    <div class="email-wrapper rounded border bg-white">
                        <div class="row no-gutters justify-content-center">



                            <div class="  col-xxl-12">
                                <div class="email-right-column  email-body p-4 p-xl-5">
                                    <form method="post" >





                                        <input type="hidden" id="apo_id" name="apo_id" class="form-control" autofocus value='<?php echo "$apo_id"; ?>'>


                                        <div class="form-group  col-lg-12">
                                            <label class="text-dark font-weight-medium">ສາງສິນຄ້າ</label>
                                            <div class="form-group">
                                                <select class=" form-control font" name="wh_id" id="wh_id">
                                                    <option value=""> ເລືອກສາງ </option>
                                                    <?php
                                                    $stmt5 = $conn->prepare(" SELECT * FROM tbl_warehouse where br_id ='$br_id'  ");
                                                    $stmt5->execute();
                                                    if ($stmt5->rowCount() > 0) {
                                                        while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                            <option value="<?php echo $row5['wh_id']; ?>"> <?php echo $row5['wh_name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-footer  d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary btn-pill" formaction="scan-stock-warehouse-out.php">ເບີກສິນຄ້າ</button>
                                        </div><br>





                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <?php include "footer.php"; ?>
        </div>
    </div>
    <?php include("../setting/calljs.php"); ?>

 


</body>

</html>