<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຂໍເບີກສິນຄ້າ";
$header_click = "2";


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

                            <?php

                            $cusrows = $conn->query("SELECT or_id,or_bill_number,a.br_id,br_name,a.wh_id,wh_name,or_status,os_name,a.date_register 
                            FROM  tbl_order_request a
                            left join tbl_branch b on a.br_id = b.br_id
                            left join tbl_warehouse c on a.wh_id = c.wh_id
                            left join tbl_order_status d on a.or_status = d.os_id 
                            where or_id = '$or_id'
                            ")->fetch(PDO::FETCH_ASSOC);

                            $or_id = $cusrows['or_id'];
                            $or_bill_number = $cusrows['or_bill_number'];
                            $br_name = $cusrows['br_name'];
                            $wh_name = $cusrows['wh_name'];
                            $os_name = $cusrows['os_name'];
                            $date_register = $cusrows['date_register'];

                            ?>

                            <div class="">
                                <div class="  p-4 p-xl-5">
                                    <div class="email-body-head mb-6 ">
                                        <h4 class="text-dark">ເພີ່ມລາຍການຂໍເບີກສິນຄ້າ</h4>
                                    </div>


                                    <form method="post" id="additemorderfrm">

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-title">

                                                    </div>
                                                    <div id="add-brand-messages"></div>
                                                    <div class="card-body">
                                                        <div class="input-states">
                                                            <div class="form-group">
                                                                <div class="row">

                                                                    <div class="form-group  col-lg-6  text-center">
                                                                        <label class="text-dark font-weight-medium ">
                                                                            <h4 class="text-dark"> <?php echo "ເລກບິນຄຳຂໍ: $or_bill_number"; ?> </h4>
                                                                        </label>
                                                                        <div class="form-group">

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group  col-lg-6  text-center">
                                                                        <label class="text-dark font-weight-medium ">
                                                                            <h4 class="text-dark"> <?php echo "ສາຂາ: $br_name"; ?> </h4>
                                                                        </label>
                                                                        <div class="form-group">

                                                                        </div>
                                                                    </div>



                                                                    <input type="hidden" class="form-control" id="or_id" name="or_id" autocomplete="off" value="<?php echo $or_id ?>" />



                                                                    <div class="form-group  col-lg-12">
                                                                        <label class="text-dark font-weight-medium">ຊື່ສາງລົງສິນຄ້າ</label>
                                                                        <div class="form-group">
                                                                            <select class=" form-control font" name="wh_id" id="wh_id">
                                                                                <option value="0"> ເລືອກສາງ </option>
                                                                                <?php
                                                                                $stmt5 = $conn->prepare(" SELECT * FROM tbl_warehouse where br_id ='$br_id'  ");
                                                                                $stmt5->execute();
                                                                                if ($stmt5->rowCount() > 0) {
                                                                                    while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                                                ?>
                                                                                        <option value="<?php echo $row5['wh_id']; ?>" <?php if ($row5['wh_id'] == $cusrows['wh_id']) {
                                                                                                                                            echo "selected";
                                                                                                                                        } ?>> <?php echo $row5['wh_name']; ?></option>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>


                                                        </div>

                                                        <table class="table" id="productTable">

                                                            <tbody>
                                                                <?php
                                                                $arrayNumber = 0;

                                                                $stmt3 = $conn->prepare(" SELECT * FROM tbl_order_request_detail where or_id ='$or_id' ");
                                                                $stmt3->execute();
                                                                $x = 1;
                                                                if ($stmt3->rowCount() > 0) {
                                                                    while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {


                                                                ?>


                                                                        <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">

                                                                            <td>

                                                                                <div class="form-group "> <?php echo "ລາຍການທີ: $x"; ?> <br>
                                                                                    <div class="row p-2">
                                                                                        <input type="hidden" step="any" name="list_box[]" id="list_box<?php echo $x; ?>" value='<?php echo "$x"; ?>' autocomplete="off" class="form-control" />

                                                                                        <div class="col-lg-7">
                                                                                            <div class="form-group">
                                                                                                <label for="firstName">ຊື່ສິນຄ້າ</label>
                                                                                                <select class="form-control" name="item_name[]" id="item_name<?php echo $x; ?>">
                                                                                                    <option value="">ເລືອກສິນຄ້າ</option>
                                                                                                    <?php
                                                                                                    $stmt2 = $conn->prepare("
                                                                                                        select a.item_id ,item_name
                                                                                                        from tbl_item_price a
                                                                                                        left join tbl_item_data b on a.item_id = b.item_id  
                                                                                                        where br_id = '$br_id' and status_item_price = '1' ");
                                                                                                    $stmt2->execute();
                                                                                                    if ($stmt2->rowCount() > 0) {
                                                                                                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                                                                    ?> <option value="<?php echo $row2['item_id']; ?>" <?php if ($row2['item_id'] == $row3['item_id']) {
                                                                                                                                                            echo "selected";
                                                                                                                                                        } ?>> <?php echo $row2['item_name']; ?></option>
                                                                                                    <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>



                                                                                        <div class="form-group  col-lg-2">
                                                                                            <label class="text-dark font-weight-medium">ຈຳນວນ</label>
                                                                                            <div class="form-group">
                                                                                                <input type="number" step="any" name="item_value[]" id="item_value<?php echo $x; ?>" value='<?php echo $row3["item_values"]; ?>' autocomplete="off" class="form-control" />
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-3">
                                                                                            <div class="form-group p-6">
                                                                                                <button type="button" class="btn btn-primary btn-flat " onclick="addRow()" id="addRowBtn" data-loading-text="Loading...">
                                                                                                    <i class="mdi mdi-briefcase-plus"></i>
                                                                                                </button>

                                                                                                <button type="button" class="btn btn-danger  removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)">
                                                                                                    <i class="mdi mdi-briefcase-remove"></i>
                                                                                                </button>
                                                                                            </div>

                                                                                        </div>



                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                        </tr>

                                                                <?php
                                                                        $arrayNumber++;
                                                                        $x++;
                                                                    }
                                                                }
                                                                ?>



                                                            </tbody>
                                                        </table>
                                                    </div>



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

                            <table id="productsTable2" class="table table-hover table-product" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ເລກລຳດັບ</th>
                                        <th>ບິນອ້າງອີງ</th>
                                        <th>ສາຂາ</th>
                                        <th>ຈຳນວນສິນຄ້າ</th>
                                        <th>ລາຄາ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $stmt4 = $conn->prepare(" 
                                    SELECT or_id,or_bill_number,wh_name,a.date_register, os_name
                                    FROM tbl_order_request a
                                    left join tbl_warehouse b on a.wh_id = b.wh_id
                                    left join tbl_order_status c on a.or_status = c.os_id
                                    where a.br_id = '$br_id'
                                    order by or_id desc
                                    ");
                                    $stmt4->execute();
                                    if ($stmt4->rowCount() > 0) {
                                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {


                                    ?>



                                            <tr>
                                                <td><?php echo $row4['or_id']; ?></td>
                                                <td><?php echo $row4['or_bill_number']; ?></td>
                                                <td><?php echo $row4['wh_name']; ?></td>
                                                <td><?php echo $row4['os_name']; ?></td>
                                                <td><?php echo $row4['date_register']; ?></td>



                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="edit-request-order.php?or_id=<?php echo  $row4['or_id']; ?>">ແກ້ໄຂ</a>

                                                            <a class="dropdown-item" type="button" id="delro" data-id='<?php echo $row4['or_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>
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
        // add item Data 
        $(document).on("submit", "#additemorderfrm", function() {
            $.post("../query/update-request-order.php", $(this).serialize(), function(data) {
                if (data.res == "novalue") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລາຍການທີ' + data.list_value.toUpperCase() + 'ມີຂໍ້ມູນວ່າງ',
                        'error'
                    )
                } else if (data.res == "success") {

                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂສຳເລັດ',
                        'success'
                    )

                    setTimeout(
                        function() {
                            location.reload();
                        }, 1000);

                } else if (data.res == "nowarehouse") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ກະລຸນາເລືອກສາງ',
                        'error'
                    )
                } else if (data.res == "emptylist") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລາຍການເລກທີ ' + data.item_code.toUpperCase() + ' ມີຂໍ້ມູນວ່າງ',
                        'error'
                    );
                }
            }, 'json');

            return false;
        });


        // Delete item
        $(document).on("click", "#delro", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "../query/delete-request-order.php",
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
                                window.location.href = 'request-order.php';
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
                url: '../query/dropdown/item_list_branch.php',
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    $("#addRowBtn").button("reset");



                    var tr = '<tr id="row' + count + '" class="' + arrayNumber + '">' +


                        '<td>' +
                        '<div class="form-group">ລາຍການທີ: ' + count +
                        '<div class="row p-2">' +

                        '<div class="col-lg-7">' +
                        '<div class="form-group">' +
                        '<label for="firstName">ຊື່ສິນຄ້າ</label>' +


                        '<select class="form-control" name="item_name[]" id="item_name' + count + '"required >' +
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
                        '<input type="number" step ="any" name="item_value[]" id="item_value' + count + '" autocomplete="off" class="form-control"required />' +
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