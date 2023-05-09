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



                            <div class="    ">
                                <div class="  p-4 p-xl-5">
                                    <div class="email-body-head mb-6 ">
                                        <h4 class="text-dark">ລາຍການຄຳຂໍ</h4>




                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <table id="productsTable2" class="table table-hover table-product" style="width:100%">
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
                                                $stmt4 = $conn->prepare(" SELECT  a.or_id,or_bill_number,br_name,a.date_register as date_request
                                                ,apo_bill_number,aos_name,b.date_register as date_check
                                                FROM tbl_order_request a
                                                left join tbl_approve_order b on a.or_id = b.or_id
                                                left join tbl_branch c on a.br_id = c.br_id
                                                left join tbl_approve_order_status d on b.ar_status = d.aos_id ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {


                                                        if (empty($row4['apo_bill_number'])) {
                                                            $apo_bill_number = "ລໍຖ້າກວດສອບ";
                                                            $aos_name = "ລໍຖ້າກວດສອບ";
                                                            $date_check = "ລໍຖ້າກວດສອບ";
                                                        } else {
                                                            $apo_bill_number = $row4['apo_bill_number'];
                                                            $aos_name = $row4['aos_name'];
                                                            $date_check = $row4['date_check'];
                                                        }


                                                ?>



                                                        <tr>

                                                            <td><?php echo "$i"; ?></td>
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
                                                                        <a class="dropdown-item" type="button" id="delrochk" data-id='<?php echo $row4['or_id']; ?>' class="btn btn-danger btn-sm">ຍົກເລີກ</a>
                                                      
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
                            'ລຶບຂໍ້ມູນສຳເລັດ',
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



        function addRow() {
            $("#addRowBtn").button("loading");

            var tableLength = $("#productTable tbody tr").length;

            var tableRow;
            var arrayNumber;
            var count;

            if (tableLength > 0) {
                tableRow = $("#productTable tbody tr:last").attr('id');
                arrayNumber = $("#productTable tbody tr:last").attr('class');
                count = tableRow.substring(3);
                count = Number(count) + 1;
                arrayNumber = Number(arrayNumber) + 1;
            } else {
                // no table row
                count = 1;
                arrayNumber = 0;
            }

            $.ajax({
                url: '../query/item_list.php',
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    $("#addRowBtn").button("reset");



                    var tr = '<tr id="row' + count + '" class="' + arrayNumber + '">' +


                        '<td>' +
                        '<div class="form-group">ລາຍການທີ: ' + count +
                        '<div class="row p-2">' +

                        '<div class="col-lg-3">' +
                        '<div class="form-group">' +
                        '<label for="firstName">ຊື່ສິນຄ້າ</label>' +


                        '<select class="form-control" name="item_name[]" id="item_name' + count + '" >' +
                        '<option value="">ເລືອກສິນຄ້າ</option>';
                    $.each(response, function(index, value) {
                        tr += '<option value="' + value[0] + '">' + value[1] + '</option>';
                    });
                    tr += '</select>' +

                        '</div>' +
                        '</div>' +

                        '<div class="form-group  col-lg-3">' +
                        '<label class="text-dark font-weight-medium">ຈຳນວນ</label>' +
                        '<div class="form-group">' +
                        '<input type="number" step ="any" name="item_value[]" id="item_value' + count + '" autocomplete="off" class="form-control" />' +
                        '</div>' +
                        '</div>' +

                        '<div class="form-group  col-lg-3">' +
                        '<label class="text-dark font-weight-medium">ລາຄາລວມ</label>' +
                        '<div class="form-group">' +
                        '<input type="number" step ="any" name="price_total[]" id="price_total' + count + '" autocomplete="off" class="form-control" />' +
                        '</div>' +
                        '</div>' +




                        '<div class="col-lg-3">' +

                        '<div class="form-group p-6">' +
                        '<button type="button" class="btn btn-primary btn-flat removeProductRowBtn"   onclick="addRow(' + count + ')"> <i class="mdi mdi-briefcase-plus"></i></button>' +

                        '<button type="button" class="btn btn-danger removeProductRowBtn ml-1" type="button" onclick="removeProductRow(' + count + ')"><i class="mdi mdi-briefcase-remove"></i></i></button>' +

                        '</div>' +
                        '</div>' +







                        '</div>' +
                        '</div>' +




                        '</td>' +


                        '</tr>';
                    if (tableLength > 0) {
                        $("#productTable tbody tr:last").after(tr);
                    } else {
                        $("#productTable tbody").append(tr);
                    }

                } // /success
            }); // get the product data

        } // /add row

        function removeProductRow(row = null) {
            if (row) {
                $("#row" + row).remove();


                subAmount();
            } else {
                alert('error! Refresh the page again');
            }
        }
    </script>

    <!--  -->


</body>

</html>