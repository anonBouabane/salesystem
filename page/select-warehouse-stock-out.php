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

            <div class="content-wrapper">
                <div class="content">

                    <div class="email-wrapper rounded border bg-white">
                        <div class="  no-gutters justify-content-center">



                            <div class="    ">
                                <div class="  p-4 p-xl-5">
                                    <div class="email-body-head mb-6 ">
                                        <h4 class="text-dark">ລາຍການຄຳຂໍ</h4>




                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <table id="productsTable2" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ເລກລຳດັບ</th>
                                                    <th>ເລກບິນຂໍ</th>
                                                    <th>ສາຂາ-ແຟນໄຊນ</th>
                                                    <th>ວັນທີຂໍ</th>
                                                    <th>ເລກບິນເບີກ</th>
                                                    <th>ສະຖານະເບີກ</th>
                                                    <th>ວັນທີເບີກ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $i = 1;
                                                $stmt4 = $conn->prepare(" 
                                                SELECT a.apo_id,apo_bill_number,br_name,ar_status,a.date_register as date_request,
                                                sow_id,sow_bill_number,b.date_register as date_check,aos_name
                                                FROM tbl_approve_order a
                                                left join tbl_stock_out_warehouse b on a.apo_id = b.apo_id
                                                left join tbl_branch c on a.br_id = c.br_id
                                                left join tbl_approve_order_status d on a.ar_status = d.aos_id 
                                                where a.apo_id = '$apo_id'
                                           ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {


                                                        if (empty($row4['sow_bill_number'])) {
                                                            $sow_bill_number = "ລໍຖ້າກວດສອບ";
                                                            $aos_name = "ລໍຖ້າກວດສອບ";
                                                            $date_check = "ລໍຖ້າກວດສອບ";
                                                        } else {
                                                            $sow_bill_number = $row4['sow_bill_number'];
                                                            $aos_name = $row4['aos_name'];
                                                            $date_check = $row4['date_check'];
                                                        }


                                                ?>



                                                        <tr>

                                                            <td><?php echo "$i"; ?></td>
                                                            <td><?php echo $row4['apo_bill_number']; ?></td>
                                                            <td><?php echo $row4['br_name']; ?></td>
                                                            <td><?php echo $row4['date_request']; ?></td>
                                                            <td><?php echo "$sow_bill_number"; ?></td>
                                                            <td><?php echo "$aos_name"; ?></td>
                                                            <td><?php echo "$date_check"; ?></td>



                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="select-warehouse-stock-out.php?apo_id=<?php echo $row4['apo_id']; ?>">ກວດສອບ</a>

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                <?php

                                                        $i++;
                                                    }
                                                }
                                                $conn = null;
                                                ?>

                                            </tbody>
                                        </table>




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