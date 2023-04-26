<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ສາງສິນຄ້າ";
$header_click = "4";

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
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
    $(function() {



        $('#pv_id').change(function() {
            var pv_id = $('#pv_id').val();
            $.post('../function/dynamic_dropdown/get_district_name.php', {
                    pv_id: pv_id
                },
                function(output) {
                    $('#dis_id').html(output).show();
                });
        });

        $('#Acc_id').change(function() {
            var Acc_id = $('#Acc_id').val();
            $.post('../function/dynamic_dropdown/get_team_provice_code.php', {
                    Acc_id: Acc_id
                },
                function(output) {
                    $('#tmpv_code').html(output).show();
                });
        });





    });
</script>

<body class="navbar-fixed sidebar-fixed" id="body">




    <div class="wrapper">

        <?php include "menu.php"; ?>

        <div class="page-wrapper">

            <?php
            include "header.php";
            ?>
            <div class="content-wrapper">
                <div class="content">
                    <div class="email-wrapper rounded border bg-white">
                        <div class="row no-gutters justify-content-center">


                            <div class="col-xxl-12">
                                <div class="email-right-column  email-body p-4 p-xl-5">
                                    <div class="email-body-head mb-5 ">
                                        <h4 class="text-dark">ສ້າງສາງ</h4>
                                    </div>
                                    <form method="post" id="addwarehouse">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="firstName">ຊື່ສາງ</label>
                                                    <input type="text" class="form-control" id="wharehouse_name" name="wharehouse_name" required>
                                                </div>
                                            </div>




                                            <?php


                                            if ($role_level <= 2) {

                                            ?>
                                                <div class="form-group col-lg-12">
                                                    <label class="text-dark font-weight-medium">ປະເພດສາງ</label>
                                                    <div class="form-group">

                                                        <select class=" form-control font" name="wh_type" id="wh_type">
                                                            <option value=""> ເລືອກປະເພດ </option>
                                                            <?php
                                                            $stmt5 = $conn->prepare(" SELECT * FROM tbl_warehouse_type ");
                                                            $stmt5->execute();
                                                            if ($stmt5->rowCount() > 0) {
                                                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                                    <option value="<?php echo $row5['wht_id']; ?>"> <?php echo $row5['wht_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <label class="text-dark font-weight-medium">ສາຂາ</label>
                                                    <div class="form-group">

                                                        <select class=" form-control font" name="branch_id" id="branch_id">
                                                            <option value=""> ເລືອກສາຂາ </option>
                                                            <?php
                                                            $stmt5 = $conn->prepare(" SELECT * FROM tbl_branch ");
                                                            $stmt5->execute();
                                                            if ($stmt5->rowCount() > 0) {
                                                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                                    <option value="<?php echo $row5['br_id']; ?>"> <?php echo $row5['br_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <input type="hidden" class="form-control" id="wh_type" name="wh_type" value='2' required>
                                                <input type="hidden" class="form-control" id="branch_id" name="branch_id" value='<?php echo "$br_id"; ?>' required>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="d-flex justify-content-end mt-6">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ເພີ່ມຂໍ້ມູນ</button>
                                        </div>

                                    </form>


                                </div>
                            </div>
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
                                        <th>ເລກທີ</th>
                                        <th>ຊື່ສາງ</th>
                                        <th>ສາຂາ</th>
                                        <th>ສະຖານະ</th>
                                        <th>ວັນລົງທະບຽນ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    if ($role_level <= 2) {
                                        $syntax = "";
                                    } else {
                                        $syntax = "where br_id = '$br_id'";
                                    }

                                    $stmt4 = $conn->prepare("select wh_id,wh_name,a.date_register,br_name,
                                    (case when wh_status = 1 then 'ນຳໃຊ້' else 'ປິດແລ້ວ' end ) as wh_status
                                    from tbl_warehouse a
                                    left join tbl_branch b on a.br_id = b.br_id
                                    $syntax 
                                    order by wh_id desc 
                                    ");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                            $wh_id = $row4['wh_id'];

                                    ?>



                                            <tr>
                                                <td><?php echo "$wh_id"; ?></td>
                                                <td><?php echo $row4['wh_name']; ?></td>
                                                <td><?php echo $row4['br_name']; ?></td>
                                                <td><?php echo $row4['wh_status']; ?></td>
                                                <td><?php echo $row4['date_register']; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-warehouse.php?wh_id=<?php echo "$wh_id"; ?>">ແກ້ໄຂ</a>
                                                            <a class="dropdown-item" type="button" id="activestaffuser" data-id='<?php echo $row4['wh_id']; ?>' class="btn btn-danger btn-sm">ເປິດນຳໃຊ້</a>
                                                            <a class="dropdown-item" type="button" id="deletewarehouse" data-id='<?php echo $row4['wh_id']; ?>' class="btn btn-danger btn-sm" >ລືບ</a>
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
        // Add staff user 
        $(document).on("submit", "#addwarehouse", function() {
            $.post("../query/add-warehouse.php", $(this).serialize(), function(data) {
                if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        'ເພີ່ມຂໍ້ມູນສຳເລັດ',
                        'success'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 1000);
                }
            }, 'json')
            return false;
        });

        $(document).on("click", "#deletewarehouse", function(e) {
                    e.preventDefault();
                    var wh_id = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "../query/delete-warehouse.php",
                        dataType: "json",
                        data: {
                            wh_id: wh_id
                        },
                        cache: false,
                        success: function(data) {
                            if (data.res == "success") {
                                Swal.fire(
                                    'ສຳເລັດ',
                                    'ລືບສຳເລັດ',
                                    'success'
                                )
                                setTimeout(
                                    function() {
                                        window.location.href = 'warehouse.php';
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

    </script>

    <!--  -->


</body>

</html>