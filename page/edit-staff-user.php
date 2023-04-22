<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຜູ້ໃຊ້";
$header_click = "3";
$us_id = $_GET['us_id'];
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




                            $cusrows = $conn->query(" SELECT  * FROM tbl_user_staff a
                            left join tbl_depart b on a.depart_id =b.dp_id 
                            where usid = '$us_id' ")->fetch(PDO::FETCH_ASSOC);

                            $full_name = $cusrows['full_name'];
                            $role_id = $cusrows['role_id'];
                            $depart_id = $cusrows['depart_id'];
                            $user_name = $cusrows['user_name'];
                            $group_id = $cusrows['group_id'];


                            // echo "$provinces";
                            ?>

                            <div class="col-xxl-12">
                                <div class="email-right-column  email-body p-4 p-xl-5">
                                    <div class="email-body-head mb-5 text-center">
                                        <h4 class="text-dark"> <?php echo "$user_name ($full_name)"; ?> </h4>
                                    </div>
                                    <form method="post" id="updatestaffuser">


                                        <div class="row">



                                            <input type="hidden" class="form-control" id="us_id" name="us_id" value="<?php echo "$us_id"; ?>">



                                            <div class="form-group  col-lg-12">
                                                <label class="text-dark font-weight-medium">ສິດເຂົ້າເຖິງ</label>
                                                <div class="form-group">
                                                    <select class=" form-control font" name="r_id" id="r_id">
                                                        <option value=""> ເລືອກສິດ </option>
                                                        <?php
                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_roles ");
                                                        $stmt5->execute();
                                                        if ($stmt5->rowCount() > 0) {
                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                        ?> <option value="<?php echo $row5['r_id']; ?>" <?php if ($role_id == $row5['r_id']) {
                                                                                                            echo "selected";
                                                                                                        } ?>>
                                                                    <?php echo $row5['role_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group  col-lg-12">
                                                <label class="text-dark font-weight-medium">ກຸ່ມບໍລິສັດ</label>
                                                <div class="form-group">
                                                    <select class=" form-control font" name="group_id" id="group_id">
                                                        <option value=""> ເລືອກກຸ່ມບໍລິສັດ </option>
                                                        <?php
                                                        $stmt6 = $conn->prepare(" SELECT * FROM tbl_group_company ");
                                                        $stmt6->execute();
                                                        if ($stmt6->rowCount() > 0) {
                                                            while ($row6 = $stmt6->fetch(PDO::FETCH_ASSOC)) {
                                                        ?> <option value="<?php echo $row6['gc_id']; ?>" <?php if ($group_id == $row6['gc_id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>> <?php echo $row6['gc_name']; ?></option>
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

                                                    <select class="form-control  font" name="dp_id" id="dp_id">
                                                        <option value=""> ເລືອກພະແນກ </option>
                                                        <?php
                                                        $stmt7 = $conn->prepare(" SELECT * FROM tbl_depart where group_id ='$group_id' ");
                                                        $stmt7->execute();
                                                        if ($stmt7->rowCount() > 0) {
                                                            while ($row7 = $stmt7->fetch(PDO::FETCH_ASSOC)) {
                                                        ?> <option value="<?php echo $row7['dp_id']; ?>" <?php if ($depart_id == $row7['dp_id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>> <?php echo $row7['dp_name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
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
                                        <th>ຊື່ຜູ້ໃຊ້</th>
                                        <th>ຢູສເຊີ້</th>
                                        <th>ບໍລິສັດ</th>

                                        <th>ສະຖານະ</th>
                                        <th>ວັນລົງທະບຽນ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare(" select usid,full_name,user_name,dp_name,role_name,
									(case when user_status = 1 then 'ເປີດນຳໃຊ້' else 'ປິດນຳໃຊ້' end) as user_status,date_register
									from tbl_user_staff a
									LEFT JOIN tbl_depart b on a.depart_id = b.dp_id
									LEFT join tbl_roles c on a.role_id = c.r_id ");
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
                                                            <a class="dropdown-item" href="edit-staff-user.php?us_id=<?php echo "$usid"; ?>">ແກ້ໄຂ</a>
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
        // Add staff user 
        $(document).on("submit", "#updatestaffuser", function() {
            $.post("../query/update-user-staff.php", $(this).serialize(), function(data) {
                if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂສຳເລັດ',
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
    </script>

    <!--  -->


</body>

</html>