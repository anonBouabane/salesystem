<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຮັບເຄື່ອງເຂົ້າສາງ";
$header_click = "2";

$siw_id = $_GET['siw_id'];

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

                                                <input type="hidden" name="siw_id" id="siw_id" value='<?php echo "$siw_id"; ?>' class="form-control">


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

                                <input type="hidden" name="siw_id" id="siw_id" value='<?php echo "$siw_id"; ?>' class="form-control">

                                <div class="card card-default chat-right-sidebar text-center" style="height: 100%;">

                                    <h2 class="mt-4 "> ສະແກນສິນຄ້າເຂົ້າສາງ </h2>

                                    <?php
                                    $data_row = $conn->query("SELECT * FROM tbl_stock_in_warehouse where siw_id = '$siw_id' ")->fetch(PDO::FETCH_ASSOC);


                                    ?>


                                    <div class="form-group col-lg-12 mt-4">
                                        <div class="form-group">

                                            <select class=" form-control font" name="wh_id" id="wh_id">
                                                <option value=""> ເລືອກສາງ </option>
                                                <?php
                                                $stmt5 = $conn->prepare(" SELECT * FROM tbl_warehouse where br_id ='$br_id'  ");
                                                $stmt5->execute();
                                                if ($stmt5->rowCount() > 0) {
                                                    while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                        <option value="<?php echo $row5['wh_id']; ?>" <?php if ($data_row['wh_id'] == $row5['wh_id']) {
                                                                                                            echo "selected";
                                                                                                        } ?>> <?php echo $row5['wh_name']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

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
                                                        <th>ເພີ່ມເຂົ້າສາງ</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <?php
                                                    $stmt4 = $conn->prepare("
                                                    select a.item_id,item_name,sum(item_values) as item_values,siwd_id
                                                    from tbl_stock_in_warehouse_detail a 
                                                    left join tbl_item_data b on a.item_id = b.item_id
                                                    where siw_id='$siw_id' 
                                                    group by item_name,a.item_id
                                                    order by siwd_id desc
                                                    
                                                      ");
                                                    $stmt4->execute();
                                                    $i = 1;
                                                    if ($stmt4->rowCount() > 0) {
                                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                            $item_id = $row4['item_id'];
                                                            $item_name = $row4['item_name'];
                                                            $item_values = $row4['item_values'];


                                                            $x = 1;
                                                    ?>

                                                            <tr>



                                                                <td><?php echo "$i"; ?></td>
                                                                <input type="hidden" name="item_id[]" id="item_id<?php echo $x; ?>" value='<?php echo "$item_id"; ?>' class="form-control">

                                                                <td>
                                                                    <?php
                                                                    echo mb_strimwidth("$item_name", 0, 50, "...");

                                                                    ?>

                                                                </td>
                                                                <td>
                                                                    <div class="col-lg-5  ">
                                                                        <input type="number" name="item_values[]" id="item_values<?php echo $x; ?>" value='<?php echo "$item_values"; ?>' class="form-control">

                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div class="dropdown">
                                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                        </a>

                                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                            <a class="dropdown-item" type="button" id="delstockinpre" data-id='<?php echo $row4['siwd_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>

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
                    <!-- For Components documentaion -->


                    <div class="card card-default">

                        <div class="card-body">
                            <h4 class="text-dark">ລາຍການໂອນສິນຄ້າເຂົ້າສາງ</h4>
                            <table id="productsTable3" class="table table-hover table-product" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ເລກລຳດັບ</th>
                                        <th>ຊື່ສາງ</th>
                                        <th>ບິນອ້າງອີງ</th>
                                        <th>ຈຳນວນເພິີ່ມເຂົ້າ</th>
                                        <th>ວັນທີ່</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php


                                    $stmt5 = $conn->prepare(" select a.siw_id,siw_bill_number,a.date_register,count(siwd_id) as count_item,wh_name 
                                    from tbl_stock_in_warehouse a
                                    left join tbl_stock_in_warehouse_detail b on a.siw_id = b.siw_id
                                    left join tbl_warehouse c on a.wh_id = c.wh_id
                                    where a.add_by ='$id_users'
                                    group by siw_id desc ");
                                    $stmt5->execute();
                                    $b = 1;
                                    if ($stmt5->rowCount() > 0) {
                                        while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {

                                    ?>

                                            <tr>
                                                <td><?php echo "$b"; ?></td>
                                                <td><?php echo $row5['wh_name']; ?></td>
                                                <td><?php echo $row5['siw_bill_number']; ?></td>
                                                <td><?php echo $row5['count_item']; ?></td>
                                                <td><?php echo $row5['date_register']; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-stock-in-admin.php?siw_id=<?php echo $row5['siw_id']; ?>">ແກ້ໄຂ</a>
                                                            <a class="dropdown-item" type="button" id="delstockin" data-id='<?php echo $row5['siw_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                    <?php
                                            $b++;
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
            $.post("../query/update-scan-stock-in-admin.php", $(this).serialize(), function(data) {
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
                        'ລະຫັດສິນຄ້າ ' + data.item_code.toUpperCase() + ' ບໍ່ມີໃນສາງ',
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
                }
            }, 'json');

            return false;
        });


        // add track check Data
        $(document).on("submit", "#submittrack", function() {
            $.post(
                "../query/update-confirm-add-stock-in-addmin.php",
                $(this).serialize(),
                function(data) {
                    if (data.res == "nowarehouse") {
                        Swal.fire(" ແຈ້ງເຕືອນ",
                            "ກະລຸນາເລືອກສາງ",
                            "error");
                    } else if (data.res == "success") {
                        Swal.fire("ສຳເລັດ", "ເພີ່ມເຄື່ອງເຂົ້າສາງສຳເລັດ", "success");

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
        $(document).on("click", "#delstockin", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-stock-in-admin.php",
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
                                window.location.href = 'stock-in-admin.php';
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
        $(document).on("click", "#delstockinpre", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-edit-detail-stock-in-pre-admin.php",
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