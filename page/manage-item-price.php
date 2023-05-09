<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ສິນຄ້າ-ລາຄາ";
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
                                        <h4 class="text-dark">ເພີ່ມລາຍການຂໍເບີກສິນຄ້າ</h4>




                                    </div>
                                    <form method="post" id="additemprice">



                                        <div class="card p-4">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class=" ">
                                                        <div class="card-title">

                                                        </div>
                                                        <div id="add-brand-messages"></div>
                                                        <div class="card-body">
                                                            <div class="input-states">

                                                                <table class="table" id="productTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:65%;">ລະຫັດສິນຄ້າ</th>
                                                                            <th style="width:35%;">ລາຄາ</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        for ($y = 0; $y < count($_POST['check_box']); $y++) {
                                                                            $check_box = $_POST['check_box'][$y];




                                                                            $arrayNumber = 0;

                                                                            $item_data = $conn->query(" SELECT item_id,item_name,barcode,ipt_name 
                                                                            from tbl_item_data a
                                                                            left join tbl_item_pack_type b on a.ipt_id = b.ipt_id
                                                                            where status_item ='1' and item_id = '$check_box' ")->fetch(PDO::FETCH_ASSOC);


                                                                            $price_data = $conn->query("
                                                                            select (case when item_price is null then 0 else item_price end) as item_price
                                                                            from tbl_item_price
                                                                            where item_id = '$check_box' and br_id ='$br_id' ")->fetch(PDO::FETCH_ASSOC);



                                                                            if (empty($price_data['item_price'])) {
                                                                                $item_price = 0;
                                                                            } else {
                                                                                $item_price = $price_data['item_price'];
                                                                            }


                                                                        ?>
                                                                            <tr>

                                                                                <input type="hidden" name="item_id[]" id="item_id<?php echo $y; ?>" autocomplete="off" class="form-control" value="<?php echo "$check_box"; ?>" readonly />

                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="itemname[]" id="itemname<?php echo $y; ?>" autocomplete="off" class="form-control" value="<?php echo $item_data['item_name']; ?>" readonly />
                                                                                    </div>
                                                                                </td>


                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="number" step="any" name="item_price[]" id="item_price<?php echo $y; ?>" autocomplete="off" class="form-control" value='<?php echo "$item_price"; ?>' required />
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php

                                                                        }
                                                                        ?>



                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-end mt-6">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ຈັດການຂໍ້ມູນ</button>
                                        </div>

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
        $(document).on("submit", "#additemprice", function() {
            $.post("../query/add-item-price.php", $(this).serialize(), function(data) {
                if (data.res == "novalue") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລາຍການທີ' + data.list_value.toUpperCase() + 'ມີຂໍ້ມູນວ່າງ',
                        'error'
                    )
                } else if (data.res == "success") {

                    Swal.fire(
                        'ສຳເລັດ',
                        'ເພິ່ມຂໍ້ມູນສຳເລັດ',
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
        $(document).on("click", "#deletepo", function(e) {
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

                        '<div class="col-lg-5">' +
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

                        '<div class="form-group  col-lg-2">' +
                        '<label class="text-dark font-weight-medium">ຈຳນວນ</label>' +
                        '<div class="form-group">' +
                        '<input type="number" step ="any" name="item_value[]" id="item_value' + count + '" autocomplete="off" class="form-control" />' +
                        '</div>' +
                        '</div>' +

                        '<div class="form-group  col-lg-2">' +
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