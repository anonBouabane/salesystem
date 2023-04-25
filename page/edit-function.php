<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຫນ້າຟັງຊັ້ນ";
$header_click = "4";
$page_id = $_GET['page'];
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
<script type="text/javascript" src="../js/jquery.min.js"></script> <!-- jQuery -->




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


                            $cusrows = $conn->query(" SELECT  * FROM tbl_page_title  where pt_id = '$page_id' ")->fetch(PDO::FETCH_ASSOC);



                            ?>

                            <div class="col-xxl-12">
                                <div class="email-right-column  email-body p-4 p-xl-5">
                                    <div class="email-body-head mb-5 ">
                                        <h4 class="text-dark">ຈັດການຫນ້າຟັງຊັ້ນ</h4>

                                    </div>
                                    <form method="post" id="addpage">
                                        <input type="hidden" class="form-control" id="pt_id" name="pt_id" value="<?php echo "$page_id"; ?>" required>

                                        <div class="row">


                                            <div class="form-group  col-lg-12">
                                                <label class="text-dark font-weight-medium">ຫົວຂໍ້</label>
                                                <div class="form-group">
                                                    <select class=" form-control font" name="st_id" id="st_id">
                                                        <option value=""> ເລືອກຫົວຂໍ້ </option>
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_sub_title ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?> <option value="<?php echo $row5['st_id']; ?>"<?php if ($cusrows['st_id'] == $row5['st_id']) {
                                                            echo "selected";
                                                        } ?>> <?php echo $row5['st_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="firstName">ຊື່ຫນ້າ</label>
                                                    <input type="text" class="form-control" id="pt_name" name="pt_name" value="<?php echo $cusrows['pt_name'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-6">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ແກ້ໄຂ</button>
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
                                        <th>ເລກລຳດັບ</th>
                                        <th>ຊື່ຫນ້າ</th>
                                        <th>ຫົວຂໍ້</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare("SELECT  pt_id,pt_name ,st_name
									FROM tbl_page_title a
									left join tbl_sub_title b on a.st_id = b.st_id order by pt_id desc ");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                            $pt_id = $row4['pt_id'];
                                            $pt_name = $row4['pt_name'];
                                            $st_name = $row4['st_name'];

                                    ?>



                                            <tr>
                                                <td><?php echo "$pt_id"; ?></td>
                                                <td><?php echo "$pt_name"; ?></td>
                                                <td><?php echo "$st_name"; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-function.php?page=<?php echo $row4['pt_id']; ?>">ແກ້ໄຂ</a>
                                                            <a class="dropdown-item" type="button" id="deletepage" data-dog='<?php echo $row4['pt_id']; ?>' class="btn btn-danger btn-sm">ລົບ</a>
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
        $(document).on("submit", "#addpage", function() {
            $.post("../query/edit-function.php", $(this).serialize(), function(data) {
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


        // delete function
        $(document).on("click", "#deletepage", function(e) {
            e.preventDefault();
            var id_r = $(this).data("dog");
            $.ajax({
                type: "post",
                url: "../query/delete-function.php",
                dataType: "json",
                data: {
                    dog_id: id_r
                },
                cache: false,
                success: function(data) {
                    if (data.res == "success") {
                        Swal.fire(
                            'ສຳເລັດ',
                            'ເປີດນຳໃຊ້ສຳເລັດ',
                            'success'
                        )
                        setTimeout(
                            function() {
                                window.location.href = 'page-function.php';
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