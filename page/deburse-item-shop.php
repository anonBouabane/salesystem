<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ເບີກສິນຄ້າເພື່ອຂາຍ";
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
<script type="text/javascript" src="../js/jquery.min.js"></script>



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



                            <div class="  col-xxl-12">
                                <div class="email-right-column  email-body p-4 p-xl-5">
                                    <form method="post">





                                        <input type="hidden" id="apo_id" name="apo_id" class="form-control" autofocus value='<?php echo "$apo_id"; ?>'>


                                        <div class="form-group  col-lg-12">
                                            <label class="text-dark font-weight-medium">ສາງສິນຄ້າ</label>
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

                                        <div class="form-footer  d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary btn-pill" formaction="scan-deburse-item-shop.php">ເບີກສິນຄ້າ</button>
                                        </div><br>





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
                                        <h4 class="text-dark">ລາຍການເບີກ</h4>




                                    </div>
                                    <form method="post" id="additemorderfrm">

                                        <table id="productsTable2" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ເລກລຳດັບ</th>
                                                    <th>ເລກບິນເບີກ</th>
                                                    <th>ເບີກຈາກສາງ</th>
                                                    <th>ຈຳນວນເບີກ</th>
                                                    <th>ວັນທີເບີກ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $i = 1;
                                                $stmt4 = $conn->prepare(" 
                                                select sow_id,sow_bill_number,wh_name,a.date_register 
                                                from tbl_stock_out_warehouse a
                                                left join tbl_warehouse b on a.wh_id = b.wh_id
                                                where  a.add_by = '$id_users'
                                                order by sow_id desc
                                           ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {

                                                        $sow_id =  $row4['sow_id'];


                                                        $rowio = $conn->query("select sum(item_values) as item_values
                                                        from tbl_stock_out_warehouse_detail
                                                        where sow_id ='$sow_id' 
                                                        group by sow_id
                                                        ")->fetch(PDO::FETCH_ASSOC);

                                                ?>



                                                        <tr>

                                                            <td><?php echo "$i"; ?></td>
                                                            <td><?php echo $row4['sow_bill_number']; ?></td>
                                                            <td><?php echo $row4['wh_name']; ?></td>
                                                            <td><?php echo $rowio['item_values']; ?></td>
                                                            <td><?php echo $row4['date_register']; ?></td>



                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="edit-scan-stock-warehouse-out.php?sow_id=<?php echo $row4['sow_id']; ?>">ແກ້ໄຂ</a>
                                                                        <a class="dropdown-item" type="button" id="deleteitem" data-id='<?php echo $row4['sow_id']; ?>' class="btn btn-danger btn-sm">ລຶບ</a>

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

            <script>
                // Delete item
                $(document).on("click", "#deleteitem", function(e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    $.ajax({
                        type: "post",
                        url: "../query/delete-stock-out-admin.php",
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
            </script>


            <?php include "footer.php"; ?>
        </div>
    </div>
    <?php include("../setting/calljs.php"); ?>




</body>

</html>