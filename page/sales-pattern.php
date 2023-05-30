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

                    <div class="row">

                      <div class="form-group  col-lg-12">
                        <label class="text-dark font-weight-medium">ສາຂາ</label>
                        <div class="form-group">
                          <select class=" form-control font" name="br_name" id="br_name" required>
                            <option value=""> ເລືອກສາຂາ </option>
                            <?php
                            $stmt5 = $conn->prepare(" SELECT * FROM tbl_branch ");
                            $stmt5->execute();
                            if ($stmt5->rowCount() > 0) {
                              while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                            ?> <option value="<?php echo $row5['br_name']; ?>"> <?php echo $row5['br_name']; ?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="firstName">ຈາກວັນທີ</label>
                          <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="firstName">ຫາວັນທີ</label>
                          <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                      </div>


                    </div>

                    <div class="d-flex justify-content-end mt-6">
                      <button type="submit" name="btn_view" class="btn btn-primary mb-2 btn-pill">ສະແດງ</button>
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

                          if (isset($_POST['btn_view'])) {

                            $date_from = $_POST['date_from'];
                            $date_to = $_POST['date_to'];
                            $br_name = $_POST['br_name'];


                            $syntax = "  where a.date_register between '$date_from' and '$date_to' and br_name like '%$br_name%'  ";
                            echo "$date_from $date_to $br_name";
                          } else {
                            $syntax = "";
                          }



                          $stmt2 = $conn->prepare("  select sum(total_pay) as total_pay ,bs_id , br_name from tbl_bill_sale a
                      LEFT JOIN tbl_branch b on a.br_id = b.br_id 
                      $syntax
                      group by a.br_id
                  
                      ");
                          $stmt2->execute();
                          if ($stmt2->rowCount() > 0) {
                            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                              if (empty($sale_total)) {
                                $sale_total = 0;
                              } else {
                                $sale_total = $row2['total_pay'];
                              }

                          ?>



                              <tr>
                                <td><?php echo $row2['bs_id']; ?></td>
                                <td><?php echo $row2['br_name']; ?></td>
                                <td><?php echo $row2['total_pay'], "."; ?>ກີບ</td>
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
                              if (empty($sale_total)) {
                                $sale_total = 0;
                              } else {
                                $sale_total = $row1['total_pay'];
                              }
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