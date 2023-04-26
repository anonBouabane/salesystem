<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຂໍ້ມູນຜູ້ໃຊ້ລະບົບ";
$header_click = "3";
$usid = $_GET['usid'];

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


                            <div class="col-xxl-12">
                                <div class="email-right-column  email-body p-4 p-xl-5">
                                    <div class="email-body-head mb-5 ">
                                        <h4 class="text-dark">ແກ້ໄຂຜູ້ໃຊ້</h4>
                                        <?php
                                        $user_rows = $conn->query("SELECT * FROM tbl_user where usid = '$usid' ")->fetch(PDO::FETCH_ASSOC);

                                        ?>



                                    </div>
                                    <form method="post" id="editstaffuserFrm">


                                        <div class="row">
                                            <input type="hidden" class="form-control" id="usid" name="usid" value="<?php echo $user_rows['usid']; ?>">

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="firstName">ຊື່ນາມສະກຸນພະນັກງານ</label>
                                                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $user_rows['full_name']; ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="firstName">ຢູສເຊີ້</label>
                                                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user_rows['user_name']; ?>" required>
                                                </div>
                                            </div>




                                            <div class="form-group  col-lg-12">
                                                <label class="text-dark font-weight-medium">ສິດເຂົ້າເຖິງ</label>
                                                <div class="form-group">
                                                    <select class=" form-control font" name="r_id" id="r_id">

                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_roles $syntax ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?> <option value="<?php echo $row5['r_id']; ?>" <?php if ($user_rows['role_id'] == $row5['r_id']) {
                                                                                                            echo "selected";
                                                                                                        } ?>> <?php echo $row5['role_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label class="text-dark font-weight-medium">ພະແນກ</label>
                                                <div class="form-group">

                                                    <select class=" form-control font" name="dp_id" id="dp_id">
                                                        <option value=""> ເລືອກພະແນກ </option>
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_depart ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['dp_id']; ?>" <?php if ($user_rows['depart_id'] == $row5['dp_id']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>> <?php echo $row5['dp_name']; ?></option>
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

                                                    <select class=" form-control font" name="br_id" id="br_id">
                                                        <option value=""> <?php echo $user_rows['br_id']; ?></option>
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_branch ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <option value="<?php echo $row5['br_id']; ?>" <?php if ($user_rows['br_id'] == $row5['br_id']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>> <?php echo $row5['br_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                        </div>








                                </div>

                                <div class="d-flex justify-content-end mt-6">
                                    <button type="submit" class="btn btn-primary mb-2 btn-pill">ແກ້ໄຂຜູ້ໃຊ້</button>
                                </div>

                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
   
  
    <div class="content-wrapper">
        <div class="content-wrapper">
            <div class="content">
                <!-- For Components documentaion -->
                <div class="card card-default">

                <div class="card card-default">


                    <div class="card-body">
                        <table id="productsTable" class="table table-hover table-product" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ເລກລຳດັບ</th>
                                    <th>ຊື່ຜູ້ໃຊ້</th>
                                    <th>ຢູສເຊີ້</th>
                                    <th>ພະແນກ</th>

                                    <th>ສະຖານະ</th>
                                    <th>ສິດຈັດການ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                if ($role_level == 5) {
                                    $syntax_user = " where role_level = 5 and br_id = '$br_id' ";
                                } else {
                                    $syntax_user = "";
                                }


                                $stmt4 = $conn->prepare(" select usid,full_name,user_name,dp_name,role_name,
									(case when user_status = 1 then 'ເປີດນຳໃຊ້' else 'ປິດນຳໃຊ້' end) as user_status,date_register
									from tbl_user a
									LEFT JOIN tbl_depart b on a.depart_id = b.dp_id
									LEFT join tbl_roles c on a.role_id = c.r_id 
									$syntax_user ");
                                $stmt4->execute();
                                if ($stmt4->rowCount() > 0) {
                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                        $usid = $row4['usid'];
                                        $full_name = $row4['full_name'];
                                        $user_name = $row4['user_name'];
                                        $dp_name = $row4['dp_name'];
                                        $user_status = $row4['user_status'];
                                        $role_name = $row4['role_name'];

                                ?>



                                        <tr>
                                            <td><?php echo "$usid"; ?></td>
                                            <td><?php echo "$full_name"; ?></td>
                                            <td><?php echo "$user_name"; ?></td>
                                            <td><?php echo "$dp_name"; ?></td>
                                            <td> <span class="badge <?php
                                                                    if ($user_status == 'ປິດນຳໃຊ້') {
                                                                        echo "badge-secondary";
                                                                    } else {
                                                                        echo "badge-success";
                                                                    }

                                                                    ?>">
                                                    <?php echo "$user_status"; ?></span></td>
                                            <td><?php echo "$role_name"; ?></td>



                                            <td>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="edit-staff-user.php?usid=<?php echo "$usid"; ?>">ແກ້ໄຂ</a>
                                                        <a class="dropdown-item" type="button" id="deleteuser" data-id='<?php echo $row4['usid']; ?>' class="btn btn-danger btn-sm" >ລືບ</a>
                                                        <a class="dropdown-item" type="button" id="activestaffuser" data-id='<?php echo $row4['usid']; ?>' class="btn btn-danger btn-sm">ເປິດນຳໃຊ້</a>
                                                        <a class="dropdown-item" type="button" id="inactivestaffuser" data-id='<?php echo $row4['usid']; ?>' class="btn btn-danger btn-sm">ປິດນຳໃຊ້</a>
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
        // edit staff user 
        $(document).on("submit", "#editstaffuserFrm", function() {
            $.post("../query/update-user-staff.php", $(this).serialize(), function(data) {
                if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂຂໍ້ມູນສຳເລັດ',
                        'success'
                    )
                    setTimeout(
                        function() {
                            window.location.href = 'user-staff.php';
                        }, 1000);
                }
            }, 'json')
            return false;
        });


        // delete 
        $(document).on("click", "#deleteuser", function(e) {
            e.preventDefault();
            var usid = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-user.php",
                dataType: "json",
                data: {
                    usid: usid
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
                                window.location.href = 'user-staff.php';
                            }, 1000);

                    }
                },
                error: function(xhr, ErrorStatus, error) {
                    console.log(status.error);
                }

            });


            return false;
        });


        // active user
        $(document).on("click", "#activestaffuser", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/activestaffuser.php",
                dataType: "json",
                data: {
                    id: id
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
                                window.location.href = 'user-staff.php';
                            }, 1000);

                    }
                },
                error: function(xhr, ErrorStatus, error) {
                    console.log(status.error);
                }

            });



            return false;
        });


        // inactive user
        $(document).on("click", "#inactivestaffuser", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/inactivestaffuser.php",
                dataType: "json",
                data: {
                    id: id
                },
                cache: false,
                success: function(data) {
                    if (data.res == "success") {
                        Swal.fire(
                            'ສຳເລັດ',
                            'ປິດນຳໃຊ້ສຳເລັດ',
                            'success'
                        )
                        setTimeout(
                            function() {
                                window.location.href = 'user-staff.php';
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