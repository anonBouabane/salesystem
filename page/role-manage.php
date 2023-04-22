<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຈັດການສິດ";
$header_click = "3";

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
<script>
    $(function() {



        $('#role_id').change(function() {
            var role_id = $('#role_id').val();
            $.post('../function/dynamic_dropdown/get_page_function.php', {
                    role_id: role_id
                },
                function(output) {
                    $('#dis_id').html(output).show();
                });
        });




    });
</script>


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
                                    <form method="post" id="addrolemanage">

                                        <div class="form-footer  d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary btn-pill" formaction="list-add-price.php">ຈັດການ</button>
                                        </div><br>


                                        <div class="form-group  col-lg-12">
                                            <label class="text-dark font-weight-medium">ສິດນຳໃຊ້</label>
                                            <div class="form-group">
                                                <select class=" form-control font" name="role_id" id="role_id">
                                                    <option value=""> ເລຶອກສິດນຳໃຊ້ </option>
                                                    <?php
                                                    $stmt = $conn->prepare(" select * from tbl_roles");
                                                    $stmt->execute();
                                                    if ($stmt->rowCount() > 0) {
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    ?> <option value="<?php echo $row['r_id']; ?>"> <?php echo $row['role_name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-lg-12" id="dis_id">



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
        // join staff and company code
        $(document).on("submit", "#addrolemanage", function() {
            $.post("../query/role-mange-page.php", $(this).serialize(), function(data) {
                if (data.res == "exist") {
                    Swal.fire(
                        'ບໍ່ສາມາດຜູກໄດ້',
                        'ຢູສເຊີ້ ແລະ ລະຫັດແມ່ນຖືກຜູກແລ້ວ',
                        'error'
                    )
                } else if (data.res == "success") {
                    Swal.fire(
                        'ສຳເລັດ',
                        'ຈັດການສິດສຳເລັດ',
                        'success'
                    )
                    setTimeout(
                        function() {
                            location.reload();
                        }, 1000);
                }
            }, 'json')
            return false;
        });
    </script>


</body>

</html>