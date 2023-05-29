<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ເບີກສິນຄ້າອອກສາງ";
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



                            <div class="    ">
                                <div class="  p-4 p-xl-5">
                                    <div class="email-body-head mb-6 ">
                                        <h4 class="text-dark">ລາຍການອານຸຍາດ</h4>




                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <table id="productsTable2" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ເລກລຳດັບ</th>
                                                    <th>ເລກບິນອານຸມັດ</th>
                                                    <th>ສາຂາ-ແຟນໄຊນ</th>
                                                    <th>ວັນທີຂໍ</th>
                                                    <th>ຈຳນວນເບີກ</th>
                                                    <th>ສະຖານະເບີກ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $i = 1;
                                                $stmt4 = $conn->prepare(" 
                                                SELECT a.apo_id,apo_bill_number,br_name,a.date_register as date_request 
                                                FROM tbl_approve_order a 
                                                left join tbl_branch c on a.br_id = c.br_id 
                                                order by a.apo_id desc ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {

                                                        $apo_id = $row4['apo_id'];


                                                        if (empty($row4['sow_bill_number'])) {
                                                            $sow_bill_number = "ລໍຖ້າກວດສອບ";
                                                            $aos_name = "ລໍຖ້າກວດສອບ";
                                                            $date_check = "ລໍຖ້າກວດສອບ";
                                                        } else {
                                                            $sow_bill_number = $row4['sow_bill_number'];
                                                            $aos_name = $row4['aos_name'];
                                                            }
                                                ?>



                                                        <tr>

                                                            <td><?php echo $row4['apo_id'];?></td>
                                                            <td><?php echo $row4['apo_bill_number']; ?></td>
                                                            <td><?php echo $row4['br_name']; ?></td>
                                                            <td><?php echo $row4['date_request']; ?></td>

                                                            <?php


                                                            $rowio = $conn->query("select    sum(item_values) as item_count
                                                            from tbl_stock_out_warehouse_detail a
                                                            left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
                                                            where apo_id ='$apo_id'
                                                            group by apo_id  ")->fetch(PDO::FETCH_ASSOC);


                                                            if (!empty($rowio['item_count'])) {
                                                                $item_count =  $rowio['item_count'];
                                                            } else {
                                                                $item_count = 0;
                                                            }

                                                            $rowap = $conn->query("
                                                            select sum(item_values) as item_approve
                                                            from tbl_approve_order_detail 
                                                            where apo_id ='$apo_id'
                                                            group by apo_id  ")->fetch(PDO::FETCH_ASSOC);


                                                            if (!empty($rowap['item_approve'])) {
                                                                $item_approve =  $rowap['item_approve'];
                                                            } else {
                                                                $item_approve = 0;
                                                            }

                                                            ?>


                                                            <td>
                                                                <?php
                                                                echo "$item_count";
                                                                echo " / ";
                                                                echo "$item_approve";
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($item_count == $item_approve) {
                                                                    echo "ສິນຄ້າຄົບຖ້ວນ";
                                                                } else {
                                                                    echo "ສິນຄ້າບໍ່ຄົບ";
                                                                }


                                                                ?>
                                                            </td>
                                                         



                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="select-warehouse-stock-out.php?apo_id=<?php echo $row4['apo_id']; ?>">ກວດສອບ</a>

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
        // add item Data 
        $(document).on("submit", "#additemorderfrm", function() {
            $.post("../query/add-purchase-order.php", $(this).serialize(), function(data) {
                if (data.res == "novalue") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລາຍການທີ' + data.list_value.toUpperCase() + 'ມີຂໍ້ມູນວ່າງ',
                        'error'
                    )
                } else if (data.res == "success") {

                    Swal.fire(
                        'ສຳເລັດ',
                        'ລົງບິນຊື້ສິນຄ້າສຳເລັດ',
                        'success'
                    )

                    setTimeout(
                        function() {
                            location.reload();
                        }, 1000);

                }
            }, 'json');

            return false;
        });


        // Delete item
        $(document).on("click", "#deletescan", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-purchase-order.php",
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
                                window.location.href = 'add-purchase-order.php';
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