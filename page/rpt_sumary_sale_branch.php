<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ລາຍງານຍອດຂາຍ";
$header_click = "10";
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

                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card card-default">
                                <div class="card-header align-items-center">
                                    <h2 class=""> ຍອດຂາຍສາຂາ </h2>


                                </div>

                                <div class="card-body">
                                    <div class="tab-content">
                                        <form action="" method="post">

                                            <div class="row">

                                                <div class="form-group  col-lg-12">
                                                    <label class="text-dark font-weight-medium">ສາຂາ</label>
                                                    <div class="form-group">
                                                        <select class=" form-control font" name="br_name" id="br_name" required>
                                                            <option value=""> ເລືອກສາຂາ </option>
                                                            <?php
                                                            $stmt5 = $conn->prepare(" SELECT * FROM tbl_branch ");
                                                            $stmt5->execute();
                                                            if ($stmt5->rowCount() > 0) {
                                                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                            ?> <option value="<?php echo $row5['br_name']; ?>"> <?php echo $row5['br_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

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


                                            <table id="dashboardremain" class="table table-product " style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ຊື່ສິນຄ້າ</th>
                                                        <th>ຍອດຂາຍ</th>
                                                        <th>ເງີນສົດ</th>
                                                        <th>ເງີນໂອນ</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php

                                                    if (isset($_POST['btn_view'])) {

                                                        $date_from = $_POST['date_from'];
                                                        $date_to = $_POST['date_to'];
                                                        $br_name = $_POST['br_name'];


                                                        $syntax = "  where b.date_register between '$date_from' and '$date_to' and br_name like '%$br_name%'  ";
                                                        echo "$date_from $date_to $br_name";
                                                    } else {
                                                        $syntax = "";
                                                    }


                                                    $total_bill_price = 0;
                                                    $stmt2 = $conn->prepare("  
                                                    select sum(item_values) as item_sale,a.item_id ,item_name,br_name,item_total_price,payment_type from tbl_bill_sale_detail a                     
                                                    left join tbl_bill_sale b on a.bs_id = b.bs_id 
                                                    left join tbl_item_data c on a.item_id = c.item_id
                                                    left join tbl_branch d on b.br_id = d.br_id
                                                    $syntax
                                                    group by a.item_id
                                                    
                                                ");
                                                    $stmt2->execute();
                                                    $i = 1;
                                                    if ($stmt2->rowCount() > 0) {
                                                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                            $item_total_price = $row2['item_total_price'];
                                                            $item_sale = $row2['item_sale'];
                                                            $item_id = $row2['item_id'];
                                                            $payment_type = $row2['payment_type'];

                                                            $total_price = $item_sale * $item_total_price;
                                                    ?>

                                                            <tr>
                                                                <td><?php echo $row2['item_name']; ?> </td>
                                                                <td><?php echo $row2['item_total_price']; ?></td>
                                                                <?php


                                                                $rowio = $conn->query("select sum(item_total_price) as payment_type 
                                                                from tbl_bill_sale_detail a 
                                                                left join tbl_bill_sale b on a.bs_id = b.bs_id  
                                                                where payment_type = '1'
                                                                group by a.item_id ")->fetch(PDO::FETCH_ASSOC);


                                                                if (!empty($rowio['payment_type'])) {
                                                                    $payment_one =  $rowio['payment_type'];
                                                                } else {
                                                                    $payment_one = 0;
                                                                }



                                                                $rowap = $conn->query("
                                                                select sum(item_total_price) as payment_type 
                                                                from tbl_bill_sale_detail a 
                                                                left join tbl_bill_sale b on a.bs_id = b.bs_id  
                                                                where payment_type = '2'
                                                                group by a.item_id")->fetch(PDO::FETCH_ASSOC);

                                                                if (!empty($rowap['payment_type'])) {
                                                                    $payment_two =  $rowap['payment_type'];
                                                                } else {
                                                                    $payment_two = 0;
                                                                }

                                                                ?>
                                                                <td>
                                                                <?php
                                                                if ($payment_type == 1) {
                                                                    echo "$item_total_price";
                                                                } else {
                                                                    echo "-";
                                                                }


                                                                ?>

                                                                </td>
                                                                <td>
                                                                <?php
                                                                if ($payment_type == 2) {
                                                                    echo "$item_total_price";
                                                                } else {
                                                                    echo "-";
                                                                }


                                                                ?>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                            $total_bill_price += $item_total_price;
                                                            $i++;
                                                        }
                                                    }
                                                    $conn = null;
                                                    include("../setting/conn.php");
                                                    ?>




                                                </tbody>
                                            </table>
                                            <div class="card-body  " data-simplebar style="height: 120px;">



                                                <div class="row">
                                                    <div class="form-group  col-lg-6">
                                                        <label class="text-dark font-weight-medium">ລວມຍອດຂາຍທັ້ງຫມົດ</label>
                                                        <div class="form-group">
                                                            <input type="hidden" id="bs_total_price" name="bs_total_price" value='<?php echo ""; ?>' class="form-control" autofocus>

                                                            <label class="text-dark font-weight-medium">
                                                                <td><?php echo number_format("$total_bill_price", 0, ",", ".") ?> ກີບ</td>
                                                            </label>

                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                        </form>
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