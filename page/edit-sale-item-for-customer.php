<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຂາຍສິນຄ້າ";
$header_click = "5";

$bs_id = $_GET['bs_id'];

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


<body class="navbar-fixed sidebar-fixed" id="body">

    <script src="../plugins/nprogress/nprogress.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script> <!-- jQuery -->

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
                            $rowedit = $conn->query("select * from tbl_bill_sale where bs_id = '$bs_id' ")->fetch(PDO::FETCH_ASSOC);



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



                                                <input type="hidden" id="bs_id" name="bs_id" class="form-control" value='<?php echo "$bs_id" ?>'>

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

                                    <input type="hidden" id="bs_id" name="bs_id" class="form-control" value='<?php echo "$bs_id" ?>'>


                                    <h2 class="mt-2"> ລາຍການຊື້ </h2>
                                    <div class="card-body pb-0" data-simplebar style="height: 400px;">

                                        <table class="align-middle mb-0 table table-borderless  " id="tableList">
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

                                                $total_bill_price = 0;
                                                $stmt4 = $conn->prepare("
                                                select a.item_id,item_price,item_name,item_values,bsd_id
                                                from tbl_bill_sale_detail a
                                                left join tbl_bill_sale b on a.bs_id = b.bs_id
                                                left join tbl_item_price c on a.item_id = c.item_id and b.br_id = c.br_id
                                                left join tbl_item_data d on a.item_id = d.item_id
                                                where a.bs_id = '$bs_id'
                                                order by bsd_id desc ");

                                                $stmt4->execute();
                                                $i = 1;
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                        $item_id = $row4['item_id'];
                                                        $item_name = $row4['item_name'];
                                                        $item_sale = $row4['item_values'];
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


                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a rel="facebox" href="../modal/edit-sale-item-detail.php?id=<?php echo $row4['bsd_id']; ?>" class="dropdown-item">ແກ້ໄຂ</a>
                                                                        <a class="dropdown-item" type="button" id="delitemlist" data-id='<?php echo $row4['bsd_id']; ?>' class="btn btn-danger btn-sm">ຍົກເລີກ</a>

                                                                    </div>
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

                                        <div class="row   no-gutters justify-content-center">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                                                        <input type="radio" id="cash" name="paytype" value="1" class="custom-control-input" <?php if ($rowedit['payment_type'] == 1) {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>
                                                        <label class="custom-control-label" for="cash">ເງິນສົດ</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                                                        <input type="radio" id="tran" name="paytype" value="2" class="custom-control-input" <?php if ($rowedit['payment_type'] == 2) {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>
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
                                                        <td><?php echo number_format("$total_bill_price", 0, ",", ".") ?> ກີບ</td>
                                                    </label>

                                                </div>
                                            </div>

                                            <div class="form-group  col-lg-6">
                                                <div class="form-group">
                                                    <!-- <a rel="facebox" href="../modal/payment-recieve-cash.php?bs_id" class="btn btn-primary mb-2 btn-pill">ຊຳລະເງິນ</a> -->

                                                    <button type="submit" name="btn_search" class="btn btn-primary mb-2 btn-pill">ແກ້ໄຂ / ພິນບິນ</button>
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
                    <div class="card card-default">

                        <div class="card-body">

                            <table id="productsTable" class="table table-hover table-product" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ລຳດັບ</th>
                                        <th>ເລກບິນ</th>
                                        <th>ລາຍການຊື້</th>
                                        <th>ການຊຳລະ</th>
                                        <th>ລາຄາລວມ</th>
                                        <th>ວັນທີໃບບິນ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare("
                                    select bs_id,sale_bill_number,total_pay,date_register,payment_name
                                    from tbl_bill_sale a
                                    left join tbl_payment_type b on a.payment_type = b.pt_id
                                    where sale_by ='$id_users'
                                    order by bs_id desc

                                     
                                    ");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                            $tbs_id = $row4['bs_id'];
                                            $bs_number = $row4['sale_bill_number'];
                                            $price_total = $row4['total_pay'];
                                            $date_sale = $row4['date_register'];
                                            $payment_name = $row4['payment_name'];



                                    ?>



                                            <tr>
                                                <td><?php echo "$tbs_id"; ?></td>
                                                <td><?php echo "$bs_number"; ?></td>
                                                <td>
                                                    <?php
                                                    $row_values = $conn->query(" 
                                                    select count(bsd_id) as item_values 
                                                    from tbl_bill_sale_detail 
                                                    where bs_id = '$tbs_id'
                                                    ")->fetch(PDO::FETCH_ASSOC);

                                                    echo $row_values['item_values'];
                                                    ?>
                                                </td>
                                                <td><?php echo "$payment_name"; ?></td>

                                                <td>
                                                    <?php echo number_format("$price_total", 2, ",", ".") ?>
                                                </td>
                                                <td><?php echo "$date_sale"; ?></td>



                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="../pdf/print-bill-sale-customer-pdf.php?bs_id=<?php echo "$tbs_id"; ?>" target="_blank">ພິນບິນ</a>
                                                            <a class="dropdown-item" href="edit-sale-item-for-customer.php?bs_id=<?php echo "$bs_id"; ?>">ແກ້ໄຂ</a>

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
            $.post("../query/update-scan-item-to-sale.php", $(this).serialize(), function(data) {
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
            $.post("../query/update-confirm-pay-bill-sale.php", $(this).serialize(), function(data) {
                if (data.res == "success") {

                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: 'ສຳເລັດ',
                        html: 'ແກ້ໄຂສຳເລັດ',
                        // timer: 10000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        showCloseButton: true,
                        footer: ' <a rel="facebox" href="../pdf/print-bill-sale-customer-pdf.php?bs_id='+<?php echo "$bs_id"?>+'" target="_blank" class="btn btn-primary mb-2 btn-pill">ກົດເພິ່ອພິນບິນ</a>',
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        location.reload();
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    })
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

                } else if (data.res == "notenoughtmoney") {

                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ຮັບເງິນບໍ່ພໍ',
                        'error'
                    )


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
                url: "../query/delete-item-sale-detail.php",
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


        $(function() {
            $('a[rel*=facebox]').facebox();
        });


        // Update Examinee
        $(document).on("submit", "#updateDetailFrm", function() {
            $.post("../query/update-sale-item-detail.php", $(this).serialize(), function(data) {
                if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        data.item_name + ' <br> ແກ້ໄຂສຳເລັດ',
                        'success'
                    )
                    refreshDiv();
                    setTimeout(
                        function() {
                            location.reload();
                        }, 1000);
                } else if (data.res == "failed") {

                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ບໍ່ສາມາດເບີກເກີນສາງໄດ້',
                        'error'
                    )

                }
            }, 'json')
            return false;
        });



        function refreshDiv() {
            $('#tableList').load(document.URL + ' #tableList');
            $('#refreshData').load(document.URL + ' #refreshData');

        }
    </script>



</body>

</html>