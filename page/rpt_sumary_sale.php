<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ລາຍງານຍອດຂາຍ";
$header_click = "10";

if (isset($_POST['btn_view'])) {

    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
} else {
    $date_from = date("Y-m-d");
    $date_to = date("Y-m-d");
}

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
                                    <h2 class=""> ຍອດຂາຍ </h2>


                                </div>

                                <div class="card-body">
                                    <div class="tab-content">
                                        <form action="" method="post">

                                            <div class="row">
                                            


                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="firstName">ຈາກວັນທີ</label>
                                                        <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo "$date_from"; ?>" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="firstName">ຫາວັນທີ</label>
                                                        <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo "$date_to"; ?>" />
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="d-flex justify-content-end mt-6">
                                                <button type="submit" name="btn_view" class="btn btn-primary mb-2 btn-pill">ສະແດງ</button>
                                            </div>


                                            <table id="" class="table table-product " style="width:100%">
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




                                                    $total_bill_price = 0;
                                                    $total_cash_price  = 0;
                                                    $total_transfer_price = 0;


                                                    $stmt1 = $conn->prepare("  
                                                
                                                    select    a.item_id ,item_name,payment_type,
                                                    sum(item_total_price) as total_sale,
                                                    sum(item_values) as item_sale
                                                    from tbl_bill_sale_detail a                     
                                                    left join tbl_bill_sale b on a.bs_id = b.bs_id 
                                                    left join tbl_item_data c on a.item_id = c.item_id  
                                                    where b.date_register between '$date_from' and '$date_to' and br_id = '$br_id' 
                                                    group by a.item_id,item_name,payment_type


                                                ");
                                                    $stmt1->execute();
                                                    $i = 1;
                                                    if ($stmt1->rowCount() > 0) {
                                                        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                                                            $total_sale = $row1['total_sale'];

                                                            $item_id = $row1['item_id'];

                                                            $payment_type = $row1['payment_type'];

                                                    ?>

                                                            <tr>
                                                                <td><?php echo $row1['item_name']; ?> </td>
                                                                <td>

                                                                    <?php
                                                                    echo number_format("$total_sale", 0, ",", ".");
                                                                    ?>

                                                                </td>
                                                                <td>
                                                                    <?php

                                                                    $row2 = $conn->query("
                                                                    select sum(item_total_price) as cash_price 
                                                                    from tbl_bill_sale_detail a 
                                                                    left join tbl_bill_sale b on a.bs_id = b.bs_id                                                           
                                                                    where payment_type = '1' and item_id ='$item_id'
                                                                    and br_id ='$br_id' and date_register between '$date_from' and '$date_to'
                                                                    group by  item_id ")->fetch(PDO::FETCH_ASSOC);
                                                                    if (!empty($row2['cash_price'])) {
                                                                        $cash_price =  $row2['cash_price'];
                                                                    } else {
                                                                        $cash_price = 0;
                                                                    }


                                                                    echo number_format("$cash_price", 0, ",", ".");
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php

                                                                    $row3 = $conn->query("
                                                                    select sum(item_total_price) as transfer_price 
                                                                    from tbl_bill_sale_detail a 
                                                                    left join tbl_bill_sale b on a.bs_id = b.bs_id                                                           
                                                                    where payment_type = '2'  and item_id ='$item_id'
                                                                    and br_id ='$br_id' and date_register between '$date_from' and '$date_to'
                                                                    group by  item_id ")->fetch(PDO::FETCH_ASSOC);

                                                                    if (!empty($row3['transfer_price'])) {
                                                                        $transfer_price =  $row3['transfer_price'];
                                                                    } else {
                                                                        $transfer_price = 0;
                                                                    }

                                                                    echo number_format("$transfer_price", 0, ",", ".");

                                                                    ?>
                                                                </td>
                                                            </tr>


                                                    <?php

                                                            $total_bill_price += $total_sale;
                                                            $total_cash_price += $cash_price;
                                                            $total_transfer_price += $transfer_price;

                                                            $i++;
                                                        }
                                                    }
                                                    $conn = null;
                                                    include("../setting/conn.php");
                                                    ?>
                                                    <tr>
                                                        <td class="text-right "><b>ລວມ </b></td>
                                                        <td><?php echo number_format("$total_bill_price", 0, ",", ".");   ?></td>
                                                        <td><?php echo number_format("$total_cash_price", 0, ",", ".");   ?></td>
                                                        <td><?php echo number_format("$total_transfer_price", 0, ",", ".");   ?></td>

                                                    </tr>

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