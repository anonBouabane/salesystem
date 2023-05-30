<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ລາຍງານຍອດຂາຍ";
$header_click = "6";
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
            <div class="col-xl-12">

              <div class="card card-default">
                <div class="card-header align-items-center">
                  <h2 class=""> ລາຍງານຍອດຂາຍ </h2>


                </div>
                <div class="card-body">


                  <form action="" method="post">


                    <input type="text" name="para1" />
                    <div class=" d-flex justify-content-end mt-6">s
                      <button type="submit" name="btn_search" class="btn btn-primary mb-2 btn-pill">ເພີ່ມຂໍ້ມູນ</button>
                    </div>


                    <div class="tab-content">
                      <table id="dashboardremain" class="table table-product " style="width:100%">
                        <thead>
                          <tr>
                            <th>ລຳດັບ</th>
                            <th>ຊື່ສາຂາ</th>
                            <th>ຍອດຂາຍ</th>

                          </tr>
                        </thead>
                        <tbody>
                          <?php

                          if ($_POST['btn_search']) {
                            echo "yes";
                          } else {
                            echo "no";
                          }



                          $stmt4 = $conn->prepare(" select sum(total_pay) as total_pay ,bs_id , br_name from tbl_bill_sale a
                      LEFT JOIN tbl_branch b on a.br_id = b.br_id 
                      group by a.br_id 
								 ");
                          $stmt4->execute();
                          if ($stmt4->rowCount() > 0) {
                            while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                              if (empty($sale_total)) {
                                $sale_total = 0;
                              } else {
                                $sale_total = $row4['total_pay'];
                              }

                          ?>



                              <tr>
                                <td><?php echo $row4['bs_id']; ?></td>
                                <td><?php echo $row4['br_name']; ?></td>
                                <td><?php echo $row4['total_pay'], "."; ?>ກີບ</td>
                              </tr>
                          <?php
                            }
                          }
                          $conn = null;
                          include("../setting/conn.php");
                          ?>




                        </tbody>
                        <tfoot>
                          <?php
                          $stmt1 = $conn->prepare(" select sum(total_pay) from tbl_bill_sale 
                                        ");
                          $stmt1->execute();
                          if ($stmt1->rowCount() > 0) {
                            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                          ?>
                              <tr>
                                <td>ຍອດລວມ</td>
                                <td><?php echo $row1['sum(total_pay)'], "."; ?>ກີບ</td>
                              </tr>
                          <?php
                            }
                          }
                          ?>

                        </tfoot>
                      </table>
                    </div>

                  </form>
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