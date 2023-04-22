<?php
include("../setting/checksession.php");
include("../setting/conn.php");
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
      $header_name = "Dashboard";
      include "header.php";
      ?>

      <div class="content-wrapper">
        <div class="content">





          <div class="row">
            <div class="col-xl-12">

              <div class="card card-default">

                <div class="card-body">
                  <div class="chart-wrapper">
                    <div class="card-default text-center">
                      <div class="card-header">

                        <br>

                        <div class="form-group  col-lg-12">
                          <img src="../images/ic_launcher.png" width="40%" height="100%" alt="Mono">

                        </div>

                        <div class="row">








                        </div>


                      </div>
                    </div>
                  </div>
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