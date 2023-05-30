<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ລາຍງານຍອດຂາຍຂອງສາຂາ";
$header_click = "0";
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

<body class="navbar-fixed sidebar-fixed" id="body">


    <div class="wrapper">

        <?php include "menu.php"; ?>

        <div class="page-wrapper">

            <?php include "header.php"; ?>

            <div class="content-wrapper">
                <div class="content">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-xl-12">

                                <div class="card card-default">
                                    <div class="card-header align-items-center">
                                        <h2 class=""> ຍອດການຂາຍຂອງສາຂາ </h2>


                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="firstName">ຈາກວັນທີ</label>
                                                <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo date('Y-m-d'); ?>" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="firstName">ຫາວັນທີ</label>
                                                <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo date('Y-m-d'); ?>" />
                                            </div>
                                        </div>


                                    </div>

                                    <div class="d-flex justify-content-end mt-6">
                                        <button type="submit" name="btn_view" class="btn btn-primary mb-2 btn-pill">ສະແດງ</button>
                                    </div>
                                    <div class="card-body pb-0" data-simplebar style="height: 457px;">

                                        <table class="align-middle mb-0 table table-borderless  " id="tableList">
                                            <thead>
                                                <tr>
                                                    <th>ຊື່ສິນຄ້າ</th>
                                                    <th>ຍອດຂາຍ</th>
                                                    <th>ເງີນສົດ</th>
                                                    <th>ເງີນໂອນ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST['btn_view'])) {

                                                    $date_from = $_POST['date_from'];
                                                    $date_to = $_POST['date_to'];



                                                    $syntax = "  where b.date_register between '$date_from' and '$date_to' ";
                                                    echo "$date_from $date_to ";
                                                } else {
                                                    $syntax = "";
                                                }
                                                $total_bill_price = 0;
                                                $stmt4 = $conn->prepare("select a.item_id,sum(item_values) as item_sale, item_name, item_total_price
                                                from tbl_bill_sale_detail a
                                                left join tbl_item_data b on a.item_id = b.item_id
                                                $syntax
                                                 
                                                group by a.item_id
                                                order by bsd_id desc");

                                                $stmt4->execute();
                                                $i = 1;
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                        $item_id = $row4['item_id'];
                                                        $item_total_price = $row4['item_total_price'];
                                                        $item_sale = $row4['item_sale'];
                                                        $item_name = $row4['item_name'];

                                                        $total_price = $item_sale * $row4['item_total_price'];
                                                ?>
                                                        <tr>
                                                            <input type="hidden" name="item_id[]" id="item_id<?php echo $x; ?>" value='<?php echo "$item_id"; ?>' class="form-control">
                                                            <td>
                                                                <?php
                                                                echo mb_strimwidth("$item_name", 0, 50, "...");
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="item_price_total[]" id="item_price_total<?php echo $x; ?>" value='<?php echo "$item_total_price"; ?>' class="form-control">

                                                                <?php echo number_format("$total_price", 2, ",", ".") ?>
                                                            </td>



                                                            <td>


                                                            </td>

                                                        </tr>
                                                <?php
                                                        $total_bill_price = $total_bill_price + $total_price;
                                                    }
                                                }
                                                $conn = null;
                                                include("../setting/conn.php");
                                                ?>
                                            </tbody>
                                        </table>
                                        </from>

                                    </div>
                                    <div class="card-body  " data-simplebar style="height: 120px;">



                                        <div class="row">
                                            <div class="form-group  col-lg-6">
                                                <label class="text-dark font-weight-medium">ລວມຍອດເງີນ</label>
                                                <div class="form-group">
                                                    <input type="hidden" id="bs_total_price" name="bs_total_price" value='<?php echo ""; ?>' class="form-control" autofocus>

                                                    <label class="text-dark font-weight-medium">
                                                        <td><?php echo number_format("$total_bill_price", 0, ",", ".") ?> ກີບ</td>
                                                    </label>

                                                </div>
                                            </div>


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