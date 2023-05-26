<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ກະດານສັງລວມ";
$header_click = "0";
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

      <?php include "header.php"; ?>

      <div class="content-wrapper">
        <div class="content">

          <div class="row">
            <div class="col-xl-8">

              <div class="card card-default">
                <div class="card-header align-items-center">
                  <h2 class=""> ສິນຄ້າໜ້າຮ້ານ </h2>


                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <table id="dashboardremain" class="table table-product " style="width:100%">
                      <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>ຈຳນວນຄົງເຫຼືອ</th>
                          <th class="th-width-250">ຍັງເຫຼືອ (ໜ້າຮ້ານ)</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $stmt3 = $conn->prepare(" call stp_dash_board_shop_remain('$br_id')");
                        $stmt3->execute();

                        if ($stmt3->rowCount() > 0) {
                          while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {

                            $item_name =   $row3['item_name'];
                            $item_in_count = $row3['item_in_count'];

                            $remain_value =  $row3['remain_value'];

                            $item_out_count =  $row3['item_out_count'];

                            if ($item_out_count == 0) {
                              $percent_used = 100;
                            } else {
                              $percent_item =  (($item_out_count * 100) / $item_in_count);
                              $percent_used = 100 - $percent_item;
                            }




                        ?>
                            <tr>
                              <td><?php echo mb_strimwidth("$item_name", 0, 50, "...");   ?></td>
                              <td><?php echo "$remain_value"; ?> </td>


                              <td><?php echo number_format("$percent_used", 2, ",", ".") ?>% <?php if ($percent_used <= 0) {
                                                                                                echo "( ສິນຄ້າໝົດ )";
                                                                                              } ?>
                                <div class="progress progress-md rounded-0">
                                  <div class="progress-bar" role="progressbar" style='width: <?php echo "$percent_used%"; ?>' aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>
                            </tr>
                        <?php
                          }
                        }
                        $conn = null;
                        include("../setting/conn.php");
                        ?>


 

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-xl-4">
              <div class="card card-default">
                <div class="card-header">
                  <h2>ສັງລວມການຂາຍ</h2>
                </div>

                <div class="col-xl-12 col-sm-6">
                  <div class="card-header">
                    <h2>ລວມຍອດຂາຍ</h2>


                    <?php

                    $row1 = $conn->query("
                    select sum(total_pay) as total_pay
                    from tbl_bill_sale 
                    where sale_by = '$id_users' and date_register = CURDATE()
                    group by sale_by,date_register ")->fetch(PDO::FETCH_ASSOC);



                    if (empty($sale_total)) {
                      $sale_total = 0;
                    } else {
                      $sale_total = $row1['total_pay'];
                    }

                    ?>


                    <div class="sub-title">
                      <span class="mr-1"> <?php echo number_format("$sale_total", 0, ",", "."); ?> ກີບ</span>
                      <!-- | <span class="mx-1">45%</span> -->
                      <i class="mdi mdi-arrow-up-bold text-success"></i>
                    </div>
                  </div>


                </div>


                <div class="card-body">
                  <table class="table table-borderless table-thead-border">
                    <thead>
                      <tr>
                        <th>ສິນຄ້າຂາຍດີ</th>
                        <th class="text-right"> ຈຳນວນ</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $stmt2 = $conn->prepare("  
                      select sum(item_values) as sale_item ,item_name
                      from tbl_bill_sale_detail a
                      left join tbl_bill_sale b on a.bs_id = b.bs_id
                      left join tbl_item_data c on a.item_id = c.item_id
                      where sale_by = '$id_users' and date_register = CURDATE()
                      group by a.item_id

                      ");
                      $stmt2->execute();

                      if ($stmt2->rowCount() > 0) {
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                      ?>

                          <tr>
                            <td class="text-dark font-weight-bold text-left"><?php echo $row2['item_name']; ?></td>
                            <td class="text-dark font-weight-bold text-right"><?php echo $row2['sale_item']; ?></td>
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


        </div>

        <?php include "footer.php"; ?>

      </div>
    </div>



    <?php include("../setting/calljs.php"); ?>


</body>

</html>