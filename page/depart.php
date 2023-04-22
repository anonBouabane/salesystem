<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ພະແນກ";
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
                                        <h4 class="text-dark">ສ້າງສິດ</h4>



                                    </div>
                                    <form method="post" id="adddepart">


                                        <div class="row"> 
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="firstName">ພະແນກ</label>
                                                    <input type="text" class="form-control" id="depart_name" name="depart_name" required>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="d-flex justify-content-end mt-6">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ສ້າງພະແນກ</button>
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
                                        <th>ພະແນກ</th> 
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare("select dp_id,dp_name
                                    from tbl_depart  
                                    order by dp_id desc ");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                            $dp_id = $row4['dp_id'];
                                            $dp_name = $row4['dp_name']; 

                                    ?>



                                            <tr>
                                                <td><?php echo "$dp_id"; ?></td>
                                                <td><?php echo "$dp_name"; ?></td> 
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
        $(document).on("submit", "#adddepart", function() {
            $.post("../query/add-depart.php", $(this).serialize(), function(data) {
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
    </script>

    <!--  -->


</body>

</html>