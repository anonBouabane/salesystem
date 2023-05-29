<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຂໍ້ມູນສາຂາແຟນຊາຍ";
$header_click = "4";
$br_id = $_GET['br_id']

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
                                        <h4 class="text-dark">ແກ້ໄຂຂໍ້ມູນສາຂາ-ແຟນຊາຍ</h4>
                                        <?php
                                        $branch_rows = $conn->query("SELECT * FROM tbl_branch where br_id = '$br_id' ")->fetch(PDO::FETCH_ASSOC);


                                        ?>
                                    </div>
                                    <form method="post" id="editbranch">
                                        <input type="hidden" class="form-control" id="br_id" name="br_id" value="<?php echo $branch_rows['br_id']; ?>" required>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="firstName">ຊື່ສາຂາ-ແຟນຊາຍ</label>
                                                    <input type="text" class="form-control" id="br_name" name="br_name" value=" <?php echo $branch_rows['br_name']; ?>" required>
                                                </div>
                                            </div>

                                            <!-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark font-weight-medium">ສະຖານະ</label>
                                                    <div class="form-group">
                                                    <select class="form-control font" name="br_status" id="br_status" required>
                                                    <option value="1" <?php if ($branch_rows["br_status"] == "1") {
                                                                            echo "SELECTED";
                                                                        } ?>>ນຳໃຊ້</option>
                                                    <option value="2" <?php if ($branch_rows["br_status"] == "2") {
                                                                            echo "SELECTED";
                                                                        } ?>>ຢຸດບໍລິການ</option>
                                                    
                                                    </select>
                                                    
                                                </div>
                                            </div> -->

                                            <div class="form-group col-lg-6">
                                                <label class="text-dark font-weight-medium">ປະເພດສາຂາ</label>
                                                <div class="form-group">

                                                    <select class=" form-control font" name="br_type" id="br_type">

                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_branch_type ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['brt_id']; ?>" <?php if ($branch_rows['br_type'] == $row5['brt_id']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>>
                                                                    <?php echo $row5['brt_name']; ?></option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group col-lg-6">
                                                <label class="text-dark font-weight-medium">ເລກໄອດີຜູ້ເພີ່ມຂໍ້ມູນ</label>
                                                <div class="form-group">

                                                    <select class=" form-control font" name="add_by" id="add_by">
                                                    
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_user ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['usid']; ?>" <?php if ($branch_rows['add_by'] == $row5['usid']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>> <?php echo $row5['user_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> -->


                                            <!-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="firstName">ວັນລົງທະບຽນ</label>
                                                    <input type="hidden" class="form-control" id="date_register" name="date_register" value=" <?php echo $branch_rows['date_register']; ?>" required>
                                                </div>
                                            </div> -->


                                        </div>
                                        <div class="d-flex justify-content-end mt-6">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ແກ້ໄຂຂໍ້ມູນ</button>
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
                                        <th>ສາຂາ</th>
                                        <th>ສະຖານະ</th>
                                        <th>ປະເພດ</th>
                                        <th>ເລກໄອດີຜູ້ເພີ່ມຂໍ້ມູນ</th>
                                        <th>ວັນລົງທະບຽນ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare("SELECT  br_id,br_name,brt_name,add_by,
                                    (case when br_status = 1 then 'ນຳໃຊ້' else 'ຫຍຸດນຳໃຊ້' end) as br_status,
                                    date_register FROM tbl_branch a
                                    left join tbl_branch_type b on a.br_type = b.brt_id
                                    order by br_id desc
                                    ");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {


                                    ?>



                                            <tr>
                                                <td><?php echo $row4['br_id']; ?></td>
                                                <td><?php echo $row4['br_name']; ?></td>
                                                <td><?php echo $row4['br_status']; ?></td>
                                                <td><?php echo $row4['brt_name']; ?></td>
                                                <td><?php echo $row4['add_by']; ?></td>
                                                <td><?php echo $row4['date_register']; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-branch.php?br_id=<?php echo $row4['br_id']; ?>">ແກ້ໄຂ</a>
                                                            <a class="dropdown-item" type="button" id="activestaffuser" data-id='<?php echo $row4['br_id']; ?>' class="btn btn-danger btn-sm">ເປິດນຳໃຊ້</a>
                                                            <a class="dropdown-item" type="button" id="deletebranch" data-id='<?php echo $row4['br_id']; ?>' class="btn btn-danger btn-sm">ລືບ</a>

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
        // Add branch
        $(document).on("submit", "#editbranch", function() {
            $.post("../query/update-branch.php", $(this).serialize(), function(data) {
                if (data.res == "exist") {
                    Swal.fire(
                        'ລົງທະບຽນຊ້ຳ',
                        'ສາຂາຫຼືແຟນຊາຍນີ້ລົງທະບຽນແລ້ວ',
                        'error'
                    )
                } else if (data.res == "success") {
                    swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂສຳເລັດ',
                        'success'
                    )

                    setTimeout(
                        function() {
                            window.location.href = 'branch.php';
                        }, 1000);
                }
            }, 'json')
            return false;
        });
        // delete 
        $(document).on("click", "#deletebranch", function(e) {
            e.preventDefault();
            var br_id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-branch.php",
                dataType: "json",
                data: {
                    br_id: br_id
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
                                window.location.href = 'branch.php';
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