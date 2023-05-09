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


    <script src="../plugins/nprogress/nprogress.js"></script>
</head>

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
                                    <form method="post" target="_blank">

                                        <div class="form-footer  d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary btn-pill" formaction="manage-item-price.php">ຈັດການສິນຄ້າ</button>
                                        </div><br>

  
                                        <table id="productsTable3" class="table table-hover table-product" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ລຳດັບ</th> 
                                                    <th>ຊື່ສິນຄ້າ</th>
                                                    <th>ບາດໂຄດ</th>
                                                    <th>ຫົວໜ່ວຍ</th>
                                                    <th></th>   
                                                </tr>
                                            </thead>
                                            <tbody id="dis_id">


                                                <?php
                                                $i = 1;
                                                $stmt4 = $conn->prepare(" SELECT item_id,item_name,barcode,ipt_name 
                                                from tbl_item_data a
                                                left join tbl_item_pack_type b on a.ipt_id = b.ipt_id
                                                where status_item ='1' 
                                                order by item_id desc ");
                                                $stmt4->execute();
                                                if ($stmt4->rowCount() > 0) {
                                                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {


                                                ?>



                                                        <tr>
                                                            <td><?php echo "$i"; ?></td> 
                                                            <td><?php echo $row4['item_name']; ?></td>
                                                            <td><?php echo $row4['barcode']; ?></td>
                                                            <td><?php echo $row4['ipt_name']; ?></td>



                                                            <td>
                                                                <div class="form-check d-inline-block mr-3 mb-3">
                                                                    <input class="form-check-input" type="checkbox" value="<?php echo $row4['item_id']; ?>" name="check_box[]" id="check_box<?php echo $row4['item_id']; ?>">
                                                                    <label class="form-check-label" for="check_box<?php echo $row4['item_id'];  ?>">

                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                <?php

                                                        $i++;
                                                    }
                                                }
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


</body>

</html>