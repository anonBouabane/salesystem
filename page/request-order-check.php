<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ກວດສອບອໍເດີ້";
$header_click = "2";


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

                    <div class="email-wrapper rounded border bg-white">
                        <div class="  no-gutters justify-content-center">



                            <div class="">
                                <div class="  p-4 p-xl-5">
                                    <div class="email-body-head mb-6 ">
                                        <h4 class="text-dark">ລາຍການຄຳຂໍ</h4>




                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <table id="productsTable" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ເລກລຳດັບ</th>
                                                    <th>ເລກບິນຂໍ</th>
                                                    <th>ສາຂາ-ແຟນໄຊນ</th>
                                                    <th>ວັນທີຂໍ</th>
                                                    <th>ເລກບິນເບີກ</th>
                                                    <th>ສະຖານະເບີກ</th>
                                                    <th>ວັນທີເບີກ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $i = 1;
                                                $stmt4 = $conn->prepare(" SELECT  a.or_id,or_bill_number,br_name,a.date_register as date_request,apo_id
                                                ,apo_bill_number,b.date_register as date_check
                                                FROM tbl_order_request a
                                                left join tbl_approve_order b on a.or_id = b.or_id
                                                left join tbl_branch c on a.br_id = c.br_id 
                                                order by a.or_id desc");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {


                                                        if (empty($row4['apo_bill_number'])) {
                                                            $apo_bill_number = "ລໍຖ້າກວດສອບ";
                                                            $aos_name = "ລໍຖ້າກວດສອບ";
                                                            $date_check = "ລໍຖ້າກວດສອບ";
                                                            $apo_id = 0;
                                                        } else {
                                                            $apo_bill_number = $row4['apo_bill_number'];
                                                            $aos_name = "ກວດສອບແລ້ວ";
                                                            $date_check = $row4['date_check'];

                                                            $apo_id = $row4['apo_id'];
                                                        }


                                                ?>



                                                        <tr>
                                                            <td><?php echo $row4['or_id']; ?></td>
                                                            <td><?php echo $row4['or_bill_number']; ?></td>
                                                            <td><?php echo $row4['br_name']; ?></td>
                                                            <td><?php echo $row4['date_request']; ?></td>
                                                            <td><?php echo "$apo_bill_number"; ?></td>
                                                            <td><?php echo "$aos_name"; ?></td>
                                                            <td><?php echo "$date_check"; ?></td>



                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="check-order-request.php?or_id=<?php echo $row4['or_id']; ?>">ກວດສອບ</a>
                                                                        <a class="dropdown-item" type="button" id="delrochk" data-id='<?php echo "$apo_id";  ?>' class="btn btn-danger btn-sm">ຍົກເລີກ</a>

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                <?php

                                                        $i++;
                                                    }
                                                }
                                                $conn = null;
                                                ?>

                                            </tbody>
                                        </table>




                                    </form>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <?php include "footer.php"; ?>
        </div>
    </div>




    <?php include("../setting/calljs.php"); ?>

    <script>
        // Delete item
        $(document).on("click", "#delrochk", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-approve-order-request.php",
                dataType: "json",
                data: {
                    id: id
                },
                cache: false,
                success: function(data) {
                    if (data.res == "success") {
                        Swal.fire(
                            'ສຳເລັດ',
                            'ຍົກເລີກສຳເລັດ',
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