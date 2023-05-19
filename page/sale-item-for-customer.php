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
                        <div class="col-lg-4 col-xxl-3">

                            <?php




                            ?>


                            <div class="card card-default chat-left-sidebar" style="height: 625px;">



                                <div class="card-default text-center">
                                    <div class="card-header">

                                        <br>

                                        <div class="form-group  col-lg-12">
                                            <img src="../images/Kp-Logo.png" width="100%" height="100%" alt="Mono">
                                        </div>

                                        <div class="row">




                                            <form method="post" class=" card-header px-4 " id="scanitemfrom">


                                                <input type="hidden" id="bill_id" name="bill_id" value='<?php echo ""; ?>' class="form-control" autofocus>

                                                <div class="input-group px-5">
                                                    <label class="text-dark font-weight-medium">ລະຫັດສິນຄ້າ</label>
                                                </div>
                                                <div class="input-group px-5 p-4">
                                                    <input type="text" id="box_barcode" name="box_barcode" class="form-control" autofocus>
                                                </div>




                                                <div class="form-group  col-lg-12">
                                                    <label class="text-dark font-weight-medium">
                                                        <button type="submit" name="btn_search" class="btn btn-primary mb-2 btn-pill">ສະແກນ</button>
                                                    </label>

                                                </div>
                                            </form>




                                        </div>


                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-lg-8 col-xxl-9">
                            <form method="post" id="confirmpay">
                                <div class="card card-default chat-right-sidebar text-center ">

                                    <h2 class="mt-2"> ລາຍການຊື້ </h2>
                                    <div class="card-body pb-0" data-simplebar style="height: 400px;">

                                        <input type="hidden" id="bill_id_confirm" name="bill_id_confirm" value='<?php echo ""; ?>' class="form-control" autofocus>



                                        <table id="" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ຊື່ສິນຄ້າ</th>
                                                    <th>ຈຳນວນ</th>
                                                    <th>ລາຄາ</th>
                                                    <th>ລວມ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $stmt4 = $conn->prepare("select a.item_id,sum(item_values) as item_sale, item_name, item_price
                                                from tbl_bill_sale_detail_pre a
                                                left join tbl_item_data b on a.item_id = b.item_id
                                                left join tbl_item_price c on a.item_id = c.item_id  
                                                where a.add_by = '$id_users' and br_id = '$br_id'
                                                group by a.item_id");
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
                                                                <?php
                                                                echo mb_strimwidth("$item_name", 0, 50, "...");
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="item_value[]" id="item_value<?php echo $x; ?>" value='<?php echo "$item_sale"; ?>' class="form-control">

                                                                <?php echo "$item_sale"; ?>
                                                            </td>
                                                            <td>
                           
                                                                <?php echo number_format("$item_price", 2, ",", ".") ?>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="total_price[]" id="item_price_total<?php echo $x; ?>" value='<?php echo "$total_price"; ?>' class="form-control">

                                                                <?php echo number_format("$total_price", 2, ",", ".") ?>
                                                            </td>


                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="edit-scan-sale-item.php?bill_id=<?php echo "$bill_id"; ?>">ແກ້ໄຂ</a>
                                                                        <a class="dropdown-item" type="button" id="delitemlist" data-id='<?php echo $row4['item_id']; ?>' class="btn btn-danger btn-sm">ຍົກເລີກ</a>

                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>


                                                <?php

                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>



                                    </div>




                                    <div class="card-body  " data-simplebar style="height: 177px;">

                                        <div class="row   no-gutters justify-content-center">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                                                        <input type="radio" id="cash" name="paytype" value="1" class="custom-control-input" checked>
                                                        <label class="custom-control-label" for="cash">ເງິນສົດ</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                                                        <input type="radio" id="tran" name="paytype" value="2" class="custom-control-input">
                                                        <label class="custom-control-label" for="tran">ເງິນໂອນ</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group  col-lg-6">
                                                <label class="text-dark font-weight-medium">ມູນຄ່າທັງໝົດ</label>
                                                <div class="form-group">
                                                    <input type="hidden" id="bs_total_price" name="bs_total_price" value='<?php echo ""; ?>' class="form-control" autofocus>

                                                    <label class="text-dark font-weight-medium">
                                                        <td><?php echo number_format("10000", 0, ",", ".") ?> ກີບ</td>
                                                    </label>

                                                </div>
                                            </div>

                                            <div class="form-group  col-lg-6">
                                                <label class="text-dark font-weight-medium"></label>
                                                <div class="form-group">
                                                    <button type="submit" name="btn_search" class="btn btn-primary mb-2 btn-pill">ຊຳລະເງິນ</button>
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

        $(document).on("submit", "#confirmpay", function() {
            $.post("../query/confirm-pay-bill-sale.php", $(this).serialize(), function(data) {
                if (data.res == "success") {

                    Swal.fire(
                        'ສຳເລັດ',
                        'ຊຳລະເງິນສຳເລັດ',
                        'success'
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
                url: "../query/delete-item-sale-list.php",
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



        function addRow() {
            $("#addRowBtn").button("loading");

            var tableLength = $("#productTable tbody tr").length;

            var tableRow;
            var arrayNumber;
            var count;

            if (tableLength > 0) {
                tableRow = $("#productTable tbody tr:last").attr('id');
                arrayNumber = $("#productTable tbody tr:last").attr('class');
                count = tableRow.substring(3);
                count = Number(count) + 1;
                arrayNumber = Number(arrayNumber) + 1;
            } else {
                // no table row
                count = 1;
                arrayNumber = 0;
            }

            $.ajax({
                url: '../query/item_list.php',
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    $("#addRowBtn").button("reset");



                    var tr = '<tr id="row' + count + '" class="' + arrayNumber + '">' +


                        '<td>' +
                        '<div class="form-group">ລາຍການທີ: ' + count +
                        '<div class="row p-2">' +

                        '<div class="col-lg-3">' +
                        '<div class="form-group">' +
                        '<label for="firstName">ຊື່ສິນຄ້າ</label>' +


                        '<select class="form-control" name="item_name[]" id="item_name' + count + '" >' +
                        '<option value="">ເລືອກສິນຄ້າ</option>';
                    $.each(response, function(index, value) {
                        tr += '<option value="' + value[0] + '">' + value[1] + '</option>';
                    });
                    tr += '</select>' +

                        '</div>' +
                        '</div>' +

                        '<div class="form-group  col-lg-3">' +
                        '<label class="text-dark font-weight-medium">ຈຳນວນ</label>' +
                        '<div class="form-group">' +
                        '<input type="number" step ="any" name="item_value[]" id="item_value' + count + '" autocomplete="off" class="form-control" />' +
                        '</div>' +
                        '</div>' +

                        '<div class="form-group  col-lg-3">' +
                        '<label class="text-dark font-weight-medium">ລາຄາລວມ</label>' +
                        '<div class="form-group">' +
                        '<input type="number" step ="any" name="price_total[]" id="price_total' + count + '" autocomplete="off" class="form-control" />' +
                        '</div>' +
                        '</div>' +




                        '<div class="col-lg-3">' +

                        '<div class="form-group p-6">' +
                        '<button type="button" class="btn btn-primary btn-flat removeProductRowBtn"   onclick="addRow(' + count + ')"> <i class="mdi mdi-briefcase-plus"></i></button>' +

                        '<button type="button" class="btn btn-danger removeProductRowBtn ml-1" type="button" onclick="removeProductRow(' + count + ')"><i class="mdi mdi-briefcase-remove"></i></i></button>' +

                        '</div>' +
                        '</div>' +







                        '</div>' +
                        '</div>' +




                        '</td>' +


                        '</tr>';
                    if (tableLength > 0) {
                        $("#productTable tbody tr:last").after(tr);
                    } else {
                        $("#productTable tbody").append(tr);
                    }

                } // /success
            }); // get the product data

        } // /add row

        function removeProductRow(row = null) {
            if (row) {
                $("#row" + row).remove();


                subAmount();
            } else {
                alert('error! Refresh the page again');
            }
        }
    </script>

    <!--  -->


</body>

</html>