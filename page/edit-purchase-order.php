<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = " ຂໍ້ມູນຂໍເບີກສິນຄ້າ";
$header_click = "4";
$or_id = $_GET['or_id'];


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
                                        <h4 class="text-dark">ແກ້ໄຂຂໍ້ມູນຂໍເບີກສິນຄ້າ</h4>
                                    </div>
                                    <?php
                                        $order_rows = $conn->query("SELECT * FROM tbl_order_request where or_id = '$or_id' ") ->fetch(PDO::FETCH_ASSOC); 
                                        
                                        ?>
                                    <form method="post" id="editorder">
                                        <div class="row">
                                        <input type="hidden" class="form-control" id="or_id" name="or_id" value="<?php echo $order_rows['or_id']; ?>" required>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="firstName">ເລກບີນອໍເດີ</label>
                                                    <input type="text" class="form-control" id="or_bill_number" name="or_bill_number" value="<?php echo $order_rows['or_bill_number']; ?>"  required>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group col-lg-6">
                                                <label class="text-dark font-weight-medium">ສາຂາ</label>
                                                <div class="form-group">

                                                    <select class=" form-control font" name="br_id" id="br_id">
                                                    
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_branch ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['br_id']; ?>" <?php if ($order_rows['br_id'] == $row5['br_id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>> <?php echo $row5['br_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="text-dark font-weight-medium">ໄອດີສາງ</label>
                                                <div class="form-group">

                                                    <select class=" form-control font" name="wh_id" id="wh_id">
                                                    
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_warehouse ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['wh_id']; ?>" <?php if ($order_rows['wh_id'] == $row5['wh_id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>> <?php echo $row5['wh_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark font-weight-medium">ສະຖານະບິນ</label>
                                                    <div class="form-group">
                                                    <select class="form-control font" name="or_status" id="or_status" required>
                                                    <option value="1" <?php if ($order_rows["or_status"] == "1") {
                                                                                    echo "SELECTED";
                                                                                } ?>>ກຳລັງສັງ</option>
                                                    <option value="2" <?php if ($order_rows["or_status"] == "2") {
                                                                                    echo "SELECTED";
                                                                                } ?>>ເບີກຈ່າຍແລ້ວ</option>
                                                    <option value="3" <?php if ($order_rows["or_status"] == "3") {
                                                                                    echo "SELECTED";
                                                                                } ?>>ຍົກເລີກ</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="text-dark font-weight-medium">ເລກໄອດີຜູ້ເພີ່ມຂໍ້ມູນ</label>
                                                <div class="form-group">

                                                    <select class=" form-control font" name="add_by" id="add_by">
                                                    
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_user ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['usid']; ?>" <?php if ($order_rows['add_by'] == $row5['usid']) {
                                                                                                                echo "selected";
                                                                                                            } ?>> <?php echo $row5['user_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="firstName">ວັນລົງທະບຽນ</label>
                                                    <input type="hidden" class="form-control" id="date_register" name="date_register" value="<?php echo $order_rows['date_register']; ?>" required>
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
                                        <th>ໄອດີສັັ່ງຂໍສິນຄ້າ</th>
                                        <th>ເລກບີນອໍເດີ</th>
                                        <th>ເລກໄອດີສາຂາ</th>
                                        <th>ໄອດີສາງ</th>
                                        <th>ສະຖານະບິນ</th>
                                        <th>ເລກໄອດີຜູ້ເພີ່ມຂໍ້ມູນ</th>
                                        <th>ວັນລົງທະບຽນ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $stmt4 = $conn->prepare("SELECT * FROM tbl_order_request
        
                                    ");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {


                                    ?>
                               



                                            <tr>
                                                <td><?php echo $row4['or_id']; ?></td>
                                                <td><?php echo $row4['or_bill_number']; ?></td>
                                                <td><?php echo $row4['br_id']; ?></td>
                                                <td><?php echo $row4['wh_id']; ?></td>
                                                <td><?php echo $row4['or_status']; ?></td>
                                                <td><?php echo $row4['add_by']; ?></td>
                                                <td><?php echo $row4['date_register']; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-order.php?or_id=<?php echo $row4['or_id']; ?>">ແກ້ໄຂ</a>
                                                            
                                                            <a class="dropdown-item" type="button" id="deleteorder" data-id='<?php echo $row4['or_id']; ?>' class="btn btn-danger btn-sm" >ລືບ</a>

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
       // edit ex
       $(document).on("submit", "#editorder", function() {
            $.post("../query/update-order.php", $(this).serialize(), function(data) {
                if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂຂໍ້ມູນສຳເລັດ',
                        'success'
                    )
                    setTimeout(
                        function() {
                            window.location.href = '2_2order.php';
                        }, 1000);
                }
            }, 'json')
            return false;
        });
         // delete 
         $(document).on("click", "#deleteorder", function(e) {
                    e.preventDefault();
                    var or_id = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "../query/delete-order.php",
                        dataType: "json",
                        data: {
                            or_id: or_id
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
                                        window.location.href = 'request-order.php';
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