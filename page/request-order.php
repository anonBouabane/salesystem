<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຂໍເບີກສິນຄ້າ";
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
                                    <form method="post" id="additemorderfrm">



                                        <div class="card p-4">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class=" ">
                                                        <div class="card-title">
                                                            <div class="form-group col-lg-12 mt-4">
                                                                <div class="form-group">

                                                                    <select class=" form-control font" name="wh_id" id="wh_id">
                                                                        <option value=""> ເລືອກສາງ </option>
                                                                        <?php
                                                                        $stmt5 = $conn->prepare(" SELECT * FROM tbl_warehouse where br_id ='$br_id'  ");
                                                                        $stmt5->execute();
                                                                        if ($stmt5->rowCount() > 0) {
                                                                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                                                        ?>
                                                                                <option value="<?php echo $row5['wh_id']; ?>"> <?php echo $row5['wh_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="add-brand-messages"></div>
                                                        <div class="card-body">
                                                            <div class="input-states">

                                                                <table class="table" id="productTable">

                                                                    <tbody>
                                                                        <?php
                                                                        $arrayNumber = 0;
                                                                        for ($x = 1; $x < 2; $x++) { ?>

                                                                            <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">

                                                                                <td>

                                                                                    <div class="form-group "> <?php echo "ລາຍການທີ: $x"; ?> <br>
                                                                                        <div class="row p-2">


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
                                                                                                        ?> <option value="<?php echo $row2['item_id']; ?>"> <?php echo $row2['item_name']; ?></option>
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
                                                                                                    <input type="number" step="any" name="item_value[]" id="item_value<?php echo $x; ?>" autocomplete="off" class="form-control" />
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
                                                                        } // /for
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
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ຂໍເບີກສິນຄ້າ</button>
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
                                        <th>ປະເພດລາຍການ</th>
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
                                    where a.br_id = '$id_users'
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
                                                            <a class="dropdown-item" href="edit-purchase-order.php?or_id=<?php echo  $row4['or_id']; ?>">ແກ້ໄຂ</a>

                                                            <a class="dropdown-item" type="button" id="deletepo" data-id='<?php echo $row4['or_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>
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
            $.post("../query/add-request-order.php", $(this).serialize(), function(data) {
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

                }else if (data.res == "nowarehouse") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ກະລຸນາເລືອກສາງ',
                        'error'
                    )
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