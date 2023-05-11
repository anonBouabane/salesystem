<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ກວດສອບອໍເດີ້";
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



                            <div class="    ">
                                <div class="  p-4 p-xl-5">
                                    <div class="email-body-head mb-6 ">
                                        <h4 class="text-dark">ເພີ່ມລາຍການຊື້ສິນຄ້າ</h4>
                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <?php
                                        $rowod = $conn->query("select a.or_id,a.br_id,a.wh_id,(case when apo_id is null then 0 else apo_id end) as apo_id,or_bill_number
                                        from tbl_order_request a
                                        left join tbl_approve_order b on a.or_id = b.or_id
                                        where a.or_id ='$or_id' ")->fetch(PDO::FETCH_ASSOC);
                                        $apo_id = $rowod['apo_id'];


                                        ?>

                                        <div class="card p-4">


                                            <div class="row   no-gutters justify-content-center">

                                                <input type="hidden" name="apo_id" id="apo_id" value='<?php echo  "$apo_id"; ?>' />
                                                <input type="hidden" name="or_id" id="or_id" value='<?php echo "$or_id" ?>' />
                                                <input type="hidden" name="branch_id" id="branch_id" value='<?php echo $rowod['br_id']; ?>' />
                                                <input type="hidden" name="wh_id" id="wh_id" value='<?php echo $rowod['wh_id']; ?>' />

                                                <div class="col-lg-12 text-center">
                                                    <div class="form-group">
                                                        <label for="firstName">
                                                            <h1> ເລກບິນ <?php echo $rowod['or_bill_number']; ?> </h1>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class=" ">
                                                        <div class="card-title">
                                                        </div>
                                                        <div id="add-brand-messages"></div>
                                                        <div class="card-body">
                                                            <div class="input-states">

                                                                <table class="table" id="productTable">

                                                                    <tbody>
                                                                        <?php
                                                                        $arrayNumber = 0;

                                                                        $stmt3 = $conn->prepare(" 
                                                                        SELECT   a.item_id,item_name,item_values 
                                                                        FROM tbl_order_request_detail a
                                                                        left join tbl_item_data b on a.item_id = b.item_id
                                                                        where or_id ='$or_id' ");
                                                                        $stmt3->execute();
                                                                        $x = 1;
                                                                        if ($stmt3->rowCount() > 0) {
                                                                            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {

                                                                                $item_rq_id = $row3['item_id'];

                                                                                $approw = $conn->query("
                                                                                select a.apo_id,item_values 
                                                                                from tbl_approve_order_detail a
                                                                                left join tbl_approve_order b on a.apo_id = b.apo_id
                                                                                where or_id = '$or_id' and  item_id = '$item_rq_id' and  a.apo_id ='$apo_id'  ")->fetch(PDO::FETCH_ASSOC);

                                                                                if (empty($approw['apo_id'])) {
                                                                                    $app_value = $row3['item_values'];
                                                                                } else {
                                                                                    $app_value = $approw['item_values'];
                                                                                }
                                                                        ?>


                                                                                <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
                                                                                    <td>
                                                                                        <div class="form-group "> <?php echo "ລາຍການທີ: $x"; ?> <br>
                                                                                            <div class="row p-2">

                                                                                                <div class="form-group  col-lg-8">
                                                                                                    <label class="text-dark font-weight-medium">ຈຳນວນ</label>
                                                                                                    <div class="form-group">
                                                                                                        <input type="hidden" name="item_id[]" id="item_id<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $row3['item_id']; ?>" readonly />
                                                                                                        <input type="text" name="item_name[]" id="item_name<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $row3['item_name']; ?>" readonly />
                                                                                                    </div>
                                                                                                </div>



                                                                                                <div class="form-group  col-lg-2">
                                                                                                    <label class="text-dark font-weight-medium">ຈຳນວນຂໍ</label>
                                                                                                    <div class="form-group">
                                                                                                        <input type="number" step="any" name="value_request[]" id="value_request<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $row3['item_values']; ?>" readonly />
                                                                                                    </div>
                                                                                                </div>


                                                                                                <div class="col-lg-2">
                                                                                                    <div class="form-group">
                                                                                                        <label for="firstName">ຈຳນວນເບີກ</label>
                                                                                                        <input type="number" step="any" name="value_approve[]" id="value_approve<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo "$app_value";  ?>" />
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
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-end mt-6">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">ເບີກສິນຄ້າ</button>
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
                                                left join tbl_approve_order_status d on b.ar_status = d.aos_id 
                                                order by a.or_id desc ");
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
            $.post("../query/add-approve-order-request.php", $(this).serialize(), function(data) {
                if (data.res == "novalue") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ລາຍການທີ' + data.list_value.toUpperCase() + 'ມີຂໍ້ມູນວ່າງ',
                        'error'
                    )
                } else if (data.res == "used") {
                    Swal.fire(
                        'ແຈ້ງເຕືອນ',
                        'ບໍ່ສາມາດແກ້ໃຂໄດ້ມີການຮັບເຂົ້າສາງແລ້ວ',
                        'error'
                    )
                } else if (data.res == "insertpass") {

                    Swal.fire(
                        'ສຳເລັດ',
                        'ເພີ່ມຂໍ້ມູນສຳເລັດ',
                        'success'
                    )

                    setTimeout(
                        function() {
                            window.location.href = 'request-order-check.php';
                        }, 1000);
                } else if (data.res == "updatepass") {

                    Swal.fire(
                        'ສຳເລັດ',
                        'ແກ້ໄຂສຳເລັດ',
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