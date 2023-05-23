<?php
include("../setting/checksession.php");
include("../setting/conn.php");



$header_name = "ຂາຍສິນຄ້າ";
$header_click = "5";

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

            <?php

            include "header.php";
            ?>

            <div class="content-wrapper">
                <div class="content">
                    <div class="row no-gutters">


                        <div class="col-lg-12 col-xxl-12">
                            <form method="post" id="editform">
                                <div class="card card-default chat-right-sidebar text-center ">

                                    <h2 class="mt-2"> ລາຍການຊື້ </h2>
                                    <div class="card-body pb-0" data-simplebar style="height: 400px;">

                                        <input type="hidden" id="bill_id_confirm" name="bill_id_confirm" value='<?php echo ""; ?>' class="form-control" autofocus>



                                        <table id="" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="85%">ຊື່ສິນຄ້າ</th>
                                                    <th width="15%">ຈຳນວນ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $total_bill_price = 0;
                                                $stmt4 = $conn->prepare("select a.item_id,sum(item_values) as item_sale, item_name, item_price
                                                from tbl_bill_sale_detail_pre a
                                                left join tbl_item_data b on a.item_id = b.item_id
                                                left join tbl_item_price c on a.item_id = c.item_id  
                                                where a.add_by = '$id_users' and br_id = '$br_id'
                                                group by a.item_id
                                                order by bsdp_id desc");
                                                $stmt4->execute();
                                                $i = 1;
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {

                                                        $item_id = $row4['item_id'];
                                                        $item_name = $row4['item_name'];
                                                        $item_sale = $row4['item_sale'];
                                                        $item_price = $row4['item_price'];

                                                        $total_price = $item_sale * $item_price;


                                                ?>
                                                        <tr>


                                                            <input type="hidden" name="item_id[]" id="item_id<?php echo $x; ?>" value='<?php echo "$item_id"; ?>' class="form-control">
                                                            <td>
                                                                <div class="col-lg-12  ">
                                                                    <label class="text-dark font-weight-medium"><?php echo mb_strimwidth("$item_name", 0, 250, "...");  ?></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-lg-12  ">
                                                                    <input type="number" name="item_value[]" id="item_value<?php echo $x; ?>" value='<?php echo "$item_sale"; ?>' class="form-control">
                                                                </div>
                                                            </td>




                                                        </tr>


                                                <?php

                                                        $total_bill_price += $total_price;
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>



                                    </div>




                                    <div class="card-body  " data-simplebar style="height: 177px;">


                                        <div class="row">


                                            <div class="form-group  col-lg-12">
                                                <label class="text-dark font-weight-medium"></label>
                                                <div class="form-group">
                                                    <button type="submit" name="btn_search" class="btn btn-primary mb-2 btn-pill">ແກ້ໄຂ</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="content-wrapper">
                <div class="content">
                    <!-- For Components documentaion -->


                    <div class="card card-default">

                        <div class="card-body">

                            <table id="productsTable" class="table table-hover table-product" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ລຳດັບ</th>
                                        <th>ເລກບິນ</th>
                                        <th>ລາຍການສິນຄ້າ</th>
                                        <th>ລາຄາລວມ</th>
                                        <th>ວັນທີໃບບິນ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare(" call stp_bill_pay_list('$id_users');");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                            $sbs_id = $row4['bs_id'];
                                            $bs_number = $row4['bs_number'];
                                            $count_item = $row4['count_item'];
                                            $price_total = $row4['price_total'];
                                            $date_sale = $row4['date_sale'];


                                    ?>



                                            <tr>
                                                <td><?php echo "$sbs_id"; ?></td>
                                                <td><?php echo "$bs_number"; ?></td>
                                                <td><?php echo "$count_item"; ?></td>
                                                <td>
                                                    <?php echo number_format("$price_total", 2, ",", ".") ?>
                                                </td>
                                                <td><?php echo "$date_sale"; ?></td>



                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-sale-item-for-customer.php?bs_id=<?php echo "$sbs_id"; ?>">ແກ້ໄຂ</a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                    <?php
                                        }
                                    }
                                    ?>








                                </tbody>
                            </table>

                        </div>
                    </div>


                </div>

            </div>


            <?php include "footer.php"; ?>
        </div>
    </div>




    <?php include("../setting/calljs.php"); ?>

    <script>
        // add item Data 
        $(document).on("submit", "#scanitemfrom", function() {
            $.post("../query/scan-item-to-sale.php", $(this).serialize(), function(data) {
                if (data.res == "success") {

                    location.reload();
                } else if (data.res == "nofound") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ມີໃນລະບົບ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "nostock") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ເບີກເກີນສາງ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "noprice") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ມີການຕັ້ງລາຄາ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                }
            }, 'json');

            return false;
        });

        $(document).on("submit", "#editform", function() {
            $.post("../query/edit-list-sale-item.php", $(this).serialize(), function(data) {
                if (data.res == "success") {

                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂສຳເລັດ',
                        'success'
                    )

                    setTimeout(
                        function() {
                            location.reload();
                            window.location.href = 'sale-item-for-customer.php';
                        }, 1000);

                } else if (data.res == "error") {

                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ບໍ່ສາມາເຮັດລາຍການໄດ້',
                        'error'
                    )

                    setTimeout(
                        function() {
                            location.reload();
                        }, 1000);

                }
            }, 'json');

            return false;
        });



        // Delete item
        $(document).on("click", "#delitemlist", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-item-sale-pre.php",
                dataType: "json",
                data: {
                    id: id
                },
                cache: false,
                success: function(data) {
                    if (data.res == "success") {
                        Swal.fire(
                            'ສຳເລັດ',
                            'ລຶບສິນຄ້າສຳເລັດ',
                            'success'
                        )
                        setTimeout(
                            function() {
                                location.reload();
                            }, 1000);
                    }

                },
                error: function(xhr, ErrorStatus, error) {
                    console.log(status.error);
                }

            });
            return false;
        });
    </script>

    <!--  -->


</body>

</html>