<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຂໍ້ມູນພະແນກ";
$header_click = "4";
$dp_id = $_GET['dp_id'];

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
                                        <h4 class="text-dark">ແກ້ໄຂຂໍ້ມູນພະແນກ</h4>
                                        <?php
                                        $depart_rows = $conn->query("SELECT * FROM tbl_depart where dp_id = '$dp_id' ") ->fetch(PDO::FETCH_ASSOC); 
                                        
                                        
                                        ?>



                                    </div>
                                    <form method="post" id="editdepart">

                                    <input type="hidden" class="form-control" id="dp_id" name="dp_id" value="<?php echo $depart_rows['dp_id']; ?>" required>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="firstName">ພະແນກ</label>
                                                    <input type="text" class="form-control" id="dp_name" name="dp_name"value="<?php echo $depart_rows['dp_name']; ?>" required>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="d-flex justify-content-end mt-6">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ແກ້ໄຂຊື່ພະແນກ</button>
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

                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-depart.php?dp_id=<?php echo $row4['dp_id']; ?>">ແກ້ໄຂ</a>
                                                            <a class="dropdown-item" type="button" id="deletedepart" data-id='<?php echo $row4['dp_id']; ?>' class="btn btn-danger btn-sm" >ລືບ</a>

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
        // edit
        $(document).on("submit", "#editdepart", function() {
            $.post("../query/update-depart.php", $(this).serialize(), function(data) {
                if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂຂໍ້ມູນສຳເລັດ',
                        'success'
                    )
                    setTimeout(
                        function() {
                            window.location.href = 'depart.php';
                        }, 1000);
                }
            }, 'json')
            return false;
        });


        // delete 
        $(document).on("click", "#deletedepart", function(e) {
                    e.preventDefault();
                    var dp_id = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "../query/delete-depart.php",
                        dataType: "json",
                        data: {
                            dp_id: dp_id
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
                                        window.location.href = 'depart.php';
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