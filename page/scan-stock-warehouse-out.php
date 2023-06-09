<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ເບີກສິນຄ້າອອກສາງ";
$header_click = "2";

$apo_id = $_POST['apo_id'];
$wh_id = $_POST['wh_id'];

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


                            <div class="card card-default chat-left-sidebar" style="height: 100%;">

                                <div class="form-status-holder"></div>

                                <div class="card-default ">
                                    <div class="card-header">





                                        <div class="form-group  col-lg-12">
                                            <img src="../images/Kp-Logo.png" width="100%" height="100%" alt="Mono">

                                        </div>

                                        <div class="row">




                                            <form method="post" class="contact-form card-header px-0  text-center" id="scanitemfrom">



                                                <div class="input-group px-5 mt-1">
                                                    <label class="text-dark font-weight-medium"> ສະແກນບາໂຄດ </label>


                                                </div>



                                                <input type="hidden" id="warehouse_id" name="warehouse_id" class="form-control" value='<?php echo "$wh_id"; ?>' autofocus>


                                                <input type="hidden" id="approve_id" name="approve_id" class="form-control" autofocus value='<?php echo "$apo_id"; ?>'>

                                                <div class="input-group px-5 p-4">
                                                    <input type="text" id="box_barcode" name="box_barcode" class="form-control" autofocus>
                                                </div>




                                                <div class="form-group  col-lg-12">
                                                    <label class="text-dark font-weight-medium">
                                                        <button type="submit" name="btn_add" id="btn_add" class="btn btn-primary mb-2 btn-pill">ສະແກນ </button>
                                                    </label>

                                                </div>

                                            </form>

                                        </div>


                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-lg-8 col-xxl-9">


                            <form method="post" id="submittrack">


                                <div class="card card-default chat-right-sidebar text-center" style="height: 100%;">

                                    <?php
                                    $rowwh = $conn->query("select * from tbl_warehouse where wh_id ='$wh_id' ")->fetch(PDO::FETCH_ASSOC);


                                    ?>

                                    <h2 class="mt-4 "> ສະແກນອອກສາງ <?php echo "(" . $rowwh['wh_name'] . ")";  ?></h2>



                                    <input type="hidden" id="warehouse_id" name="warehouse_id" class="form-control" value='<?php echo "$wh_id"; ?>' autofocus>

                                    <input type="hidden" id="approve_id" name="approve_id" class="form-control" autofocus value='<?php echo "$apo_id"; ?>'>

                                    <div class="d-flex justify-content-center mt-6">
                                        <button type="submit" class="btn btn-primary mb-2 btn-pill">ເບີກສິນຄ້າ</button>
                                    </div>

                                    <div class="card-body pb-0 " data-simplebar data-simplebar style="height: 550px;">

                                        <div class="card-body">

                                            <table id="" class="table table-hover table-product" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ເລກລຳດັບ</th>
                                                        <th>ຊື່ສິນຄ້າ</th>
                                                        <th>ເບີກອອກສາງ</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php

                                                    $item_values = 0;



                                                    $stmt4 = $conn->prepare("select a.item_id,item_name,sum(item_values) as item_values 
                                                    from tbl_approve_order_detail a
                                                    left join tbl_item_data b on a.item_id = b.item_id
                                                    where apo_id='$apo_id' 
                                                    group by item_name,a.item_id
                                                    order by apod_id  desc ");
                                                    $stmt4->execute();
                                                    $i = 1;
                                                    if ($stmt4->rowCount() > 0) {
                                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                            $item_id = $row4['item_id'];
                                                            $item_name = $row4['item_name'];


                                                            $x = 1;
                                                    ?>

                                                            <tr>


                                                                <?php

                                                                $check_apo_id = 0;


                                                                $rowpre = $conn->query("
                                                                select item_id,sum(item_values) as item_values
                                                                from tbl_stock_out_warehouse_detail_pre
                                                                where add_by = '$id_users' and item_id = '$item_id'
                                                                group by item_id 
                                                                            ")->fetch(PDO::FETCH_ASSOC);

                                                                if (empty($rowpre['item_values'])) {
                                                                    $val_pre = 0;
                                                                } else {
                                                                    $val_pre = $rowpre['item_values'];
                                                                }



                                                                $row_detail = $conn->query("
                                                                select sum(item_values) as item_values , apo_id
                                                                from tbl_stock_out_warehouse_detail a
                                                                left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
                                                                where apo_id = '$apo_id' and item_id = '$item_id'
                                                                group by item_id 
                                                                             ")->fetch(PDO::FETCH_ASSOC);

                                                                if (empty($row_detail['item_values'])) {
                                                                    $val_detail = 0;
                                                                } else {
                                                                    $val_detail = $row_detail['item_values'];
                                                                    $check_apo_id =  $row_detail['apo_id'];
                                                                }


                                                                $item_values = $val_pre + $val_detail;

                                                                $rowap = $conn->query("
                                                                select sum(item_values) as item_approve
                                                                from tbl_approve_order_detail 
                                                                where apo_id ='$apo_id' and item_id = '$item_id'
                                                                group by apo_id  ")->fetch(PDO::FETCH_ASSOC);


                                                                if (!empty($rowap['item_approve'])) {
                                                                    $item_approve =  $rowap['item_approve'];
                                                                } else {
                                                                    $item_approve = 0;
                                                                }



                                                                ?>
                                                                <td><?php echo "$i"; ?></td>
                                                                <input type="hidden" name="item_id[]" id="item_id<?php echo $x; ?>" value='<?php echo "$item_id"; ?>' class="form-control">
                                                                <input type="hidden" name="item_values[]" id="item_values<?php echo $x; ?>" value='<?php echo "$val_pre"; ?>' class="form-control">

                                                        
                                                                <td>
                                                                    <?php
                                                                    echo mb_strimwidth("$item_name", 0, 50, "...");

                                                                    ?>

                                                                </td>
                                                                <td>


                                                                    <?php

                                                                    echo "$item_values / $item_approve";
                                                                    ?>
                                                                </td>
                                                                <?php
                                                                if ($val_pre != 0 ) {

                                                                ?>
                                                                    <td>

                                                                        <div class="dropdown">
                                                                            <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                            </a>

                                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

                                                                                <a rel="facebox" href="../modal/edit-stock-warehouse-out-pre.php?id=<?php echo $row4['item_id']; ?>" class="dropdown-item">ແກ້ໄຂ</a>

                                                                                <a class="dropdown-item" type="button" id="delstockoutpre" data-id='<?php echo $rowpre['item_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>

                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <td>
                                                                    </td>
                                                                <?php
                                                                }
                                                                ?>

                                                            </tr>



                                                    <?php

                                                            $i++;
                                                            $x++;
                                                        }
                                                    }
                                                    ?>



                                                </tbody>
                                            </table>

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

                    <div class="email-wrapper rounded border bg-white">
                        <div class="  no-gutters justify-content-center">



                            <div class="    ">
                                <div class="  p-4 p-xl-5">
                                    <div class="email-body-head mb-6 ">
                                        <h4 class="text-dark">ລາຍການເບີກ</h4>




                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <table id="productsTable4" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ເລກລຳດັບ</th>
                                                    <th>ເລກບິນເບີກ</th>
                                                    <th>ເບີກຈາກສາງ</th>
                                                    <th>ຈຳນວນເບີກ</th>
                                                    <th>ວັນທີເບີກ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $i = 1;
                                                $stmt4 = $conn->prepare(" 
                                                select sow_id,sow_bill_number,wh_name,a.date_register 
                                                from tbl_stock_out_warehouse a
                                                left join tbl_warehouse b on a.wh_id = b.wh_id
                                                where  apo_id = '$apo_id'
                                                order by sow_id desc
                                           ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {

                                                        $sow_id =  $row4['sow_id'];


                                                        $rowio = $conn->query("select sum(item_values) as item_values
                                                        from tbl_stock_out_warehouse_detail
                                                        where sow_id ='$sow_id' 
                                                        group by sow_id
                                                        ")->fetch(PDO::FETCH_ASSOC);

                                                ?>



                                                        <tr>

                                                            <td><?php echo $row4['sow_id']; ?></td>
                                                            <td><?php echo $row4['sow_bill_number']; ?></td>
                                                            <td><?php echo $row4['wh_name']; ?></td>
                                                            <td><?php echo $rowio['item_values']; ?></td>
                                                            <td><?php echo $row4['date_register']; ?></td>



                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="edit-scan-stock-warehouse-out.php?sow_id=<?php echo $row4['sow_id']; ?>">ແກ້ໄຂ</a>
                                                                        <a class="dropdown-item" type="button" id="deleteitem" data-id='<?php echo $row4['sow_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>

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

    <script>
        $(function() {
            $('a[rel*=facebox]').facebox();
        });


        $(document).on("submit", "#updatestockoutpre", function() {
            $.post("../query/update-item-stock-warehouse-out-pre.php", $(this).serialize(), function(data) {
                if (data.res == "success") {

                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: 'ສຳເລັດ',
                        html: 'ແກ້ໄຂສຳເລັດ',
                        // timer: 10000,
                        timerProgressBar: true,
                        showConfirmButton: true,
                        showCloseButton: true,
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

                } else if (data.res == "limnitapprove") {

                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                         'ບໍ່ສາມາດເບີກເກີນຈຳນວນອານຸຍາດໄດ້',
                     //   'ສິນຄ້າ ' + data.item_name.toUpperCase() + ' ບໍ່ສາມາດເພິ່ມເກີນໃບບິນ',
                        'error'
                    )


                } else if (data.res == "nostock") {

                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ເບີກສິນຄ້າເກີນສາງ',
                        'error'
                    )


                }
            }, 'json');

            return false;
        });


        // add item Data 
        $(document).on("submit", "#scanitemfrom", function() {
            $.post("../query/scan-stock-out-admin.php", $(this).serialize(), function(data) {
                if (data.res == "success") {

                    location.reload();
                } else if (data.res == "limit") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ສິນຄ້າ ' + data.limit_item.toUpperCase() + ' ບໍ່ສາມາດເພິ່ມເກີນໃບບິນ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "nofound") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ມີໃນບິນຂໍ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "nostock") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ພຽງພໍ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "noitem") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ມີໃນສາງ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "orverorder") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ເບີກເກີນບິນຂໍ',
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


        // add track check Data
        $(document).on("submit", "#submittrack", function() {
            $.post(
                "../query/confirm-add-stock-out-admin.php",
                $(this).serialize(),
                function(data) {
                    if (data.res == "errorwarehouse") {
                        Swal.fire(" ແຈ້ງເຕືອນ",
                            "ບໍ່ມີສິນຄ້າເບີກ",
                            "error");
                    } else if (data.res == "success") {
                        Swal.fire("ສຳເລັດ", "ເບີກເຄື່ອງອອກສາງສຳເລັດ", "success");

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                "json"
            );

            return false;
        });

        // Delete item
        $(document).on("click", "#delstockoutpre", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-detail-stock-out-pre-admin.php",
                dataType: "json",
                data: {
                    id: id
                },
                cache: false,
                success: function(data) {
                    if (data.res == "success") {
                        Swal.fire(
                            'ສຳເລັດ',
                            'ລຶບຂໍ້ມູນສຳເລັດ',
                            'success'
                        )
                        setTimeout(
                            function() {
                                location.reload();
                            }, 1000);

                    } else if (data.res == "used") {
                        Swal.fire(
                            'ນຳໃຊ້ແລ້ວ',
                            'ບໍ່ສາມາດລຶບໄດ້ເນື່ອງຈາກນຳໃຊ້ໄປແລ້ວ',
                            'error'
                        )
                    }

                },
                error: function(xhr, ErrorStatus, error) {
                    console.log(status.error);
                }

            });
            return false;
        });


        // Delete item
        $(document).on("click", "#deleteitem", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-stock-out-admin.php",
                dataType: "json",
                data: {
                    id: id
                },
                cache: false,
                success: function(data) {
                    if (data.res == "success") {
                        Swal.fire(
                            'ສຳເລັດ',
                            'ລຶບຂໍ້ມູນສຳເລັດ',
                            'success'
                        )
                        setTimeout(
                            function() {
                                location.reload();
                            }, 1000);

                    } else if (data.res == "used") {
                        Swal.fire(
                            'ນຳໃຊ້ແລ້ວ',
                            'ບໍ່ສາມາດລຶບໄດ້ເນື່ອງຈາກນຳໃຊ້ໄປແລ້ວ',
                            'error'
                        )
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