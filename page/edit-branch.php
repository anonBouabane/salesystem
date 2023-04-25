<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ສາຂາແຟນຊາຍ";
$header_click = "4";

$branch_id = $_GET['branch_id'];

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

                            <?php


                            $cusrows = $conn->query(" SELECT  * FROM tbl_branch  where br_id = '$branch_id' ")->fetch(PDO::FETCH_ASSOC);

                        

                            ?>


                            <div class="col-xxl-12">
                                <div class="email-right-column  email-body p-4 p-xl-5">
                                    <div class="email-body-head mb-5 ">
                                        <h4 class="text-dark">ສ້າງສາຂາ-ແຟນຊາຍ</h4>
                                    </div>
                                    <form id="editbranch">

                                    <input type="hidden" class="form-control" id="id_branch" name="id_branch" value="<?php echo "$branch_id"; ?>" required>


                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="firstName">ຊື່ສາຂາ-ແຟນຊາຍ</label>
                                                    <input type="text" class="form-control" id="br_name" name="br_name" value="<?php echo $cusrows['br_name'] ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label class="text-dark font-weight-medium">ປະເພດສາຂາ</label>
                                                <div class="form-group">

                                                    <select class=" form-control font" name="br_type" id="br_type">
                                                        <option value=""> ເລືອກປະເພດ </option>
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_branch_type ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['brt_id']; ?>" <?php if ($cusrows['br_type'] == $row5['brt_id']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>> <?php echo $row5['brt_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


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
                                        <th>ປະເພດ</th>
                                        <th>ສະຖານະ</th>
                                        <th>ວັນລົງທະບຽນ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare("SELECT  br_id,br_name,brt_name,
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
                                                <td><?php echo $row4['brt_name']; ?></td>
                                                <td><?php echo $row4['br_status']; ?></td>
                                                <td><?php echo $row4['date_register']; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-branch.php?branch_id=<?php echo $row4['br_id']; ?>">ແກ້ໄຂ</a>
                                                            <a class="dropdown-item" type="button" id="delbranch" data-kai='<?php echo $row4['br_id']; ?>' class="btn btn-danger btn-sm">ລົບ</a>
                                                            <a class="dropdown-item" type="button" id="activestaffuser" data-id='<?php echo $row4['br_id']; ?>' class="btn btn-danger btn-sm">ເປິດນຳໃຊ້</a>
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
        // ສະຄຣິບເອີ້ນໄຟຣແອັດ
        $(document).on("submit", "#editbranch", function() {
            $.post("../query/edit-branch.php", $(this).serialize(), function(data) {
                if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂສຳເລັດ',
                        'success'
                    )
                    setTimeout(
                        function() {
                            //ຣີເຟສຫນ້າ
                            location.reload();
                        }, 1000);
                }
            }, 'json')
            return false;
        });


        // ສະຄິບເອີ້ນໄຟຣລົບ
        $(document).on("click", "#delbranch", function(e) {
            e.preventDefault();
            var id = $(this).data("kai");
            $.ajax({
                type: "post",
                url: "../query/delete-branch.php",
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
                                //ໂຢນຫນ້າ
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