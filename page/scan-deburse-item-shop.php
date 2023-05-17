<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ເບີກສິນຄ້າເພື່ອຂາຍ";
$header_click = "2";

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

                                        <?php
                                        $rowedit = $conn->query(" select * from tbl_warehouse where wh_id = '$wh_id'  ")->fetch(PDO::FETCH_ASSOC);



                                        ?>



                                        <div class="form-group  col-lg-12">
                                            <img src="../images/Kp-Logo.png" width="100%" height="100%" alt="Mono">

                                        </div>

                                        <div class="row">

                                            <form method="post" class="contact-form card-header px-0  text-center" id="scanitemfrom">

                                                <input type="hidden" id="warehouse_id" name="warehouse_id" class="form-control" autofocus value='<?php echo "$wh_id" ?>'>


                                                <div class="input-group px-5 mt-1">
                                                    <label class="text-dark font-weight-medium"> ສະແກນບາໂຄດ </label>
                                                </div>
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

                                    <h2 class="mt-4 "> ເບີກສິນຄ້າເພື່ອຂາຍ (<?php echo $rowedit['wh_name'] ?>) </h2>

                                    <input type="hidden" id="siw_id" name="siw_id" class="form-control" autofocus value='<?php echo "$siw_id" ?>'>

                                    <input type="hidden" id="warehouse_id" name="warehouse_id" class="form-control" autofocus value='<?php echo  $rowedit["wh_id"]; ?>'>

                                    <input type="hidden" id="approve_id" name="approve_id" class="form-control" autofocus value='<?php echo "$apo_id"; ?>'>

                                    <div class="d-flex justify-content-center mt-6">
                                        <button type="submit" class="btn btn-primary mb-2 btn-pill">ຮັບເຂົ້າສາງ</button>
                                    </div>



                                    <div class="card-body pb-0 " data-simplebar>

                                        <div class="card-body">

                                            <table id="" class="table table-hover table-product" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ເລກລຳດັບ</th>
                                                        <th>ຊື່ສິນຄ້າ</th>
                                                        <th>ຈຳນວນເບີກ</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <?php
                                                    $stmt4 = $conn->prepare("
                                                     
                                                    SELECT a.item_id,sum(item_values) as item_values,item_name
                                                    FROM tbl_stock_out_warehouse_detail_pre a
                                                    left join tbl_item_data b on a.item_id = b.item_id
                                                    where add_by = '$id_users' and wh_id ='$wh_id'
                                                    group by item_id,wh_id


                                                     ");
                                                    $stmt4->execute();
                                                    $i = 1;
                                                    if ($stmt4->rowCount() > 0) {
                                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                            $item_id = $row4['item_id'];
                                                            $item_name = $row4['item_name'];
                                                            $item_values =  $row4['item_values'];

                                                            $x = 1;
                                                    ?>

                                                            <tr>

                                                                <td><?php echo "$i"; ?></td>
                                                                <input type="hidden" name="item_id[]" id="item_id<?php echo $x; ?>" value='<?php echo "$item_id"; ?>' class="form-control">
                                                                <input type="hidden" name="item_name[]" id="item_name<?php echo $x; ?>" value='<?php echo "$item_name"; ?>' class="form-control">

                                                                <td>
                                                                    <?php
                                                                    echo mb_strimwidth("$item_name", 0, 50, "...");

                                                                    ?>

                                                                </td>
                                                                <td>
                                                                    <input type="number" name="item_values[]" id="item_values<?php echo $x; ?>" value='<?php echo "$item_values"; ?>' class="form-control">
                                                                </td>

                                                                <td>
                                                                    <div class="dropdown">
                                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                        </a>

                                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                            <a class="dropdown-item" type="button" id="delitempre" data-id='<?php echo $row4['item_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>

                                                                        </div>
                                                                    </div>
                                                                </td>



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

                                        <table id="productsTable2" class="table table-hover table-product" style="width:100%">
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
                                                select dips_bill_number,sow_id, wh_name, a.date_register,dips_id
                                                from tbl_deburse_item_pre_sale a
                                                left join tbl_warehouse b on a.wh_id = b.wh_id
                                                where a.add_by = '$id_users' 
                                                order by dips_id desc
                                           ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {

                                                        $dips_id =  $row4['dips_id'];


                                                        $rowio = $conn->query("select sum(item_values) as item_values
                                                        from tbl_deburse_item_pre_sale_detail
                                                        where dips_id ='$dips_id' 
                                                        group by dips_id
                                                        ")->fetch(PDO::FETCH_ASSOC);

                                                ?>



                                                        <tr>

                                                            <td><?php echo "$i"; ?></td>
                                                            <td><?php echo $row4['dips_bill_number']; ?></td>
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
        // add item Data 
        $(document).on("submit", "#scanitemfrom", function() {
            $.post("../query/scan-deburse-item-shop.php", $(this).serialize(), function(data) {
                if (data.res == "success") {

                    location.reload();
                } else if (data.res == "noitem") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ພົບໃນສາງ',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "nofound") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ມີໃນສາງ',
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
                } else if (data.res == "noorder") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ມີການຈັດຊື້',
                        'error'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 2000);
                } else if (data.res == "orverorder") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ຮັບເກີນບິນເບີກ',
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
                "../query/confirm-deburse-item-shop.php",
                $(this).serialize(),
                function(data) {
                    if (data.res == "recieved") {
                        Swal.fire(" ແຈ້ງເຕືອນ",
                            "ບໍ່ສາມາດເຮັດລາຍການໄດ້",
                            "error");
                    } else if (data.res == "over_use") {
                        Swal.fire(
                            'ແຈ້ງເຕືອນ',
                            data.item_name.toUpperCase() + ' ຮັບເກີນບິນສົ່ງ',
                            'error'
                        )
                    } else if (data.res == "success") {
                        Swal.fire("ສຳເລັດ", "ເບີກໜ້າຮ້ານສຳເລັດ", "success");

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else if (data.res == "errorwarehouse") {
                        Swal.fire("ສຳເລັດ", "ບໍ່ສາມາດເພີ່ມໄດ້", "error");

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else if (data.res == "nostock") {
                        Swal.fire(
                            'ແຈ້ງເຕືອນ',
                            'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ພຽງພໍ',
                            'error'
                        )
                        setTimeout(
                            function() {

                            }, 2000);
                    }
                },
                "json"
            );

            return false;
        });


        // Delete item
        $(document).on("click", "#deleteitem", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-deburse-item-shop.php",
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
                                window.location.href = 'deburse-item-shop.php';
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
        $(document).on("click", "#delitempre", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-deburse-item-shop-pre.php",
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