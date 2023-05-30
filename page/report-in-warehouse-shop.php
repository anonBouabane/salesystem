<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ລາຍງານຮັບສິນຄ້າເຂົີ້າສາງຮ້ານ";
$header_click = "6";
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
                                    <h2 class=""> ລາຍງານຮັບສິນຄ້າເຂົີ້າສາງຮ້ານ </h2>


                                </div>

                                <div class="card-body">
                                    <div class="tab-content">
                                        <form action="" method="post">

                                            <div class="row">

                                                <div class="form-group  col-lg-12">
                                                    <label class="text-dark font-weight-medium">ສາຂາ</label>
                                                    <div class="form-group">
                                                        <select class=" form-control font" name="wh_name" id="wh_name" required>
                                                            <option value=""> ເລືອກສາຂາ </option>
                                                            <?php
                                                            $stmt5 = $conn->prepare(" SELECT * FROM tbl_warehouse ");
                                                            $stmt5->execute();
                                                            if ($stmt5->rowCount() > 0) {
                                                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                            ?> <option value="<?php echo $row5['wh_name']; ?>"> <?php echo $row5['wh_name']; ?></option>
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
                                                        <th>ລຳດັບ</th>
                                                        <th>ຊື່ສິນຄ້າ</th>
                                                        <th>ຮັບເຂົ້າຮ້ານ</th>
                                                        <th>ຊື່ສາງ</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php

                                                    if (isset($_POST['btn_view'])) {

                                                        $date_from = $_POST['date_from'];
                                                        $date_to = $_POST['date_to'];
                                                        $wh_name = $_POST['wh_name'];
                                                                                                                

                                                        $syntax = "  where b.date_register between '$date_from' and '$date_to' and wh_name like '%$wh_name%'  ";
                                                         echo "$date_from $date_to $wh_name";
                                                    } else {
                                                        $syntax = "";
                                                    }



                                                    $stmt2 = $conn->prepare("  
                                                select sum(item_values) as item_values,a.item_id ,item_name,wh_name from tbl_stock_in_warehouse_detail a 
                                                left join tbl_stock_in_warehouse d on d.siw_id = a.siw_id 
                                                left join tbl_warehouse b on d.wh_id = b.wh_id 
                                                left join tbl_item_data c on a.item_id = c.item_id
                                                $syntax
                                                group by a.item_id
                                            
                                                ");
                                                    $stmt2->execute();

                                                    if ($stmt2->rowCount() > 0) {
                                                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                                                    ?>

                                                            <tr>
                                                                <td><?php echo $row2['item_id']; ?> </td>
                                                                <td><?php echo $row2['item_name']; ?> </td>
                                                                <td><?php echo $row2['item_values']; ?> </td>
                                                                <td><?php echo $row2['wh_name']; ?> </td>


                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    $conn = null;
                                                    include("../setting/conn.php");
                                                    ?>




                                                </tbody>
                                            </table>
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