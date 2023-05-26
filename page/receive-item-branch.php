<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຮັບເຄື່ອງເຂົ້າຮ້ານ";
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
                                        <h4 class="text-dark">ລາຍການສິນຄ້າຕ້ອງຮັບ</h4>




                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <table id="productsTable2" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ເລກລຳດັບ</th>
                                                    <th>ເລກບິນຂໍ</th>
                                                    <th>ວັນທີຂໍ</th>
                                                    <th>ວັນທີອານຸມັດ</th>
                                                    <th>ວັນທີ່ອອກສູນ</th>
                                                    <th>ສະຖານະເບີກ</th>
                                                    <th>ຈຳນວນເບີກ</th> 
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $i = 1;
                                                $stmt4 = $conn->prepare(" 
                                                select DISTINCT a.or_id, b.apo_id, or_bill_number,a.date_register as date_request, 
                                                (case when b.date_register is null then 'ລໍຖ້າອານຸມັດ' else b.date_register end) as date_approve,  
                                                (case when c.date_register is null then 'ລໍຖ້າເບີກສິນຄ້າ' else c.date_register end) as date_stock_out
                                                from tbl_order_request a 
                                                left join tbl_approve_order b on a.or_id = b.or_id
                                                left join tbl_stock_out_warehouse c on b.apo_id = c.apo_id
                                                where a.add_by = '$id_users'
                                                order by a.or_id desc

                                                  ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {

                                                        $apo_id = $row4['apo_id'];
                                                        





                                                ?>



                                                        <tr>

                                                            <td><?php echo $row4['or_id']; ?></td>
                                                            <td><?php echo $row4['or_bill_number']; ?></td>
                                                            <td><?php echo $row4['date_request']; ?></td>
                                                            <td><?php echo $row4['date_approve']; ?></td>
                                                            <td><?php echo $row4['date_stock_out']; ?></td>

                                                            <?php


                                                            $rowap = $conn->query("select    sum(item_values) as item_count
                                                            from tbl_stock_out_warehouse_detail a
                                                            left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
                                                            where apo_id ='$apo_id'
                                                            group by apo_id  ")->fetch(PDO::FETCH_ASSOC);


                                                            if (!empty($rowap['item_count'])) {
                                                                $item_approve =  $rowap['item_count'];
                                                            } else {
                                                                $item_approve = 0;
                                                            }

                                                            $rowio = $conn->query("
                                                            select sum(item_values) as item_approve
                                                            from tbl_stock_in_warehouse_detail a
                                                            left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
                                                            where apo_id ='$apo_id'
                                                            group by apo_id  ")->fetch(PDO::FETCH_ASSOC);


                                                            if (!empty($rowio['item_approve'])) {
                                                                $item_count =  $rowio['item_approve'];
                                                            } else {
                                                                $item_count = 0;
                                                            }

                                                            ?>

                                                            <td>
                                                                <?php
                                                                if ($item_count == $item_approve) {
                                                                    echo "ຮັບສິນຄ້າຄົບຖ້ວນ";
                                                                } else {
                                                                    echo "ຮັບສິນຄ້າບໍ່ຄົບ";
                                                                }


                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo "$item_count";
                                                                echo " / ";
                                                                echo "$item_approve";
                                                                ?>
                                                            </td>




                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="scan-recieve-item-branch.php?apo_id=<?php echo $row4['apo_id']; ?>">ກວດສອບ</a>

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