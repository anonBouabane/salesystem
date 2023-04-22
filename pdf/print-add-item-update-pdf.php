<!DOCTYPE html>
<html lang="en">
<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$date_report = date("d/m/Y");

$item_id = $_GET['item_id'];
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="main-css-href" rel="stylesheet" href="../css/style-pdf-item.css" />
</head>


<body onload="printdiv('divname')">
    <!-- <div class="page-wrapper"> -->
    <div class="row" id="divname" style="font-family: phetsarath OT;">
        <div class="col-12">

            <?php

            $cusrows = $conn->query(" 

            SELECT gc_name FROM tbl_item_edit a 
            left join tbl_user_staff b on a.add_by = b.usid
            left join tbl_depart c on b.depart_id = c.dp_id
            left join tbl_group_company d on c.group_id = d.gc_id
            where ie_id ='$item_id'

		 
            
            ")->fetch(PDO::FETCH_ASSOC);

            $staff_company = $cusrows['gc_name'];


            // count item to manage page print
            $rowcp = $conn->query("
            select count(item_id) as cout_item
					from tbl_item_edit_detail_list a
					left join tbl_item_edit b on a.ie_id = b.ie_id  where a.ie_id = '$item_id' 
 
					")->fetch(PDO::FETCH_ASSOC);

            $cout_item = $rowcp['cout_item'];

            $page  = ceil($cout_item / 10);
            // end



            ?>


            <div>

                <table width="100%" style="border:none;">



                    <tr>
                        <?php
                        // echo "ປປປປ $company_code";

                        if ($staff_company == "KP") {
                            $logoname = "kpicon.png";
                            $witd_size = "100px";
                            $height_size = "100px";
                        } else if ($staff_company == "KPTL") {

                            $logoname = "KPTL-Logo.png";
                            $witd_size = "140px";
                            $height_size = "110px";
                        } else if ($staff_company == "KPLG") {
                            $logoname = "KPLogistic.png";
                            $witd_size = "180px";
                            $height_size = "100px";
                        }






                        ?>
                        <td align="left"> <img src='../images/<?php echo "$logoname"; ?>' width='<?php echo "$witd_size"; ?>' height='<?php echo "$height_size"; ?>'></td>

                        <td align="center"><b>
                                <h1> ຟອມເພີ່ມສິນຄ້າ </h1>
                            </b>
                            <h4>
                                ກຸ່ມສິນຄ້າ
                                <?php

                                $stmtg = $conn->prepare("
                                select name_company
                                from tbl_item_edit_detail_list a
                                left join tbl_item_code_list b on a.item_id = b.icl_id
                                left join tbl_item_company_code c on b.item_header_code = c.item_company_code
                                where ie_id = '$item_id' 
                                group by name_company
                                ");
                                $stmtg->execute();



                                if ($stmtg->rowCount() > 0) {
                                    while ($rowg = $stmtg->fetch(PDO::FETCH_ASSOC)) {

                                        $name_company = $rowg['name_company'];
                                        echo "$name_company";
                                    }
                                }


                              
                                ?>

                            </h4>
                        </td>
                        <td align="right">
                            <b> ເລກທີ: <?php echo "$item_id"; ?> <br>
                                ວັນທີພິມ: <?php echo "$date_report"; ?> <br>
                             
                        </td>
                    </tr>



                </table>
            </div>


            <table class=" table " width="100%">

                <tr class="table">
                    <th width="3%" class="table">ລ/ດ</th>
                    <th width="20%" class="table">ລະຫັດສິນຄ້າ</th>
                    <th width="22%" class="table">ຊື່ສິນຄ້າ</th>
                    <th width="9%" class="table">ການຫໍ່ຫຸ້ມ</th>
                    <th width="10%" class="table">ຫົວໜ່ວຍໃຫຍ່</th>
                    <th width="10%" class="table">ຫົວໜ່ວຍນ້ອຍ</th>
                    <th width="6%" class="table">ຈຳນວນ</th>
                    <th width="12%" class="table">ຍິຫໍ້</th>

                </tr>

                <?php




                $stmt3 = $conn->prepare("  
				select full_code as item_code,a.item_name,a.buy_unit,a.sale_unit,a.pack,a.weight,a.brand_name
                from tbl_item_edit_detail_list a
                left join tbl_item_code_list b on a.item_id = b.icl_id
                where ie_id = '$item_id'  ");
                $stmt3->execute();
                $i = 1;

                $row_page = 0;

                if ($stmt3->rowCount() > 0) {
                    while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {

                ?>

                        <tr class="table">


                            <td class="table"> <?php echo $i; ?> </td>
                            <td class="table"> <?php echo $row3['item_code']; ?> </td>
                            <td class="table"><?php echo $row3['item_name']; ?></td>
                            <td class="table"><?php echo $row3['weight']; ?></td>
                            <td class="table"><?php echo $row3['buy_unit']; ?></td>
                            <td class="table"><?php echo $row3['sale_unit']; ?></td>
                            <td class="table"><?php echo $row3['pack']; ?></td> 
							<td class="table"><?php echo $row3['brand_name']; ?></td>

                        </tr>



                        <?php
                        $row_page++;


                        if ($row_page == 10) {

                        ?>
            </table>
            <br>

            <div class="ridge">
                <table width="100%" style="border:none;">
                    <tr>
                        <td align="left"><b>
                                <p align="center"> ຜູ້ສະເໜີ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກຂາຍ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກບັນຊີ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກສາງ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກໄອທີ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ຜູ້ເຂົ້າລະບົບ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>

                    </tr>
                </table>
            </div>


            <table width="100%" style="border:none;">
                <tr>
                    <td align="left"><b>
                            <p align="left"> ICT Department </p>
                    </td>
                    <td align="right"><b>
                            <p align="right"> FM-GA-IT-SW-01-02<br>19/07/17-00</p>
                    </td>
            </table>
            <br>
            <div>

                <table width="100%" style="border:none;">



                    <tr>
                        <?php
                            // echo "ປປປປ $company_code";

                            if ($staff_company == "KP") {
                                $logoname = "kpicon.png";
                                $witd_size = "100px";
                                $height_size = "100px";
                            } else if ($staff_company == "KPTL") {

                                $logoname = "KPTL-Logo.png";
                                $witd_size = "140px";
                                $height_size = "110px";
                            } else if ($staff_company == "KPLG") {
                                $logoname = "KPLogistic.png";
                                $witd_size = "180px";
                                $height_size = "100px";
                            }

                        ?>
                        <td align="left"> <img src='../images/<?php echo "$logoname"; ?>' width='<?php echo "$witd_size"; ?>' height='<?php echo "$height_size"; ?>'></td>

                        <td align="center"><b>
                                <h1> ຟອມເພີ່ມສິນຄ້າ </h1>
                            </b>
                            <h4>
                                ກຸ່ມສິນຄ້າ
                                <?php
                                echo "$name_company";
                                echo " (" . strtoupper($ccy) . ")";
                                ?>

                            </h4>
                        </td>
                        <td align="right">
                            <b> ເລກທີ: <?php echo "$it_id"; ?> <br>
                                ວັນທີພິມ: <?php echo "$date_report"; ?> <br>
                                ນຳໃຊ້ວັນທີ: <?php echo "$use_date"; ?>
                        </td>
                    </tr>



                </table>
            </div>


            <table class=" table " width="100%">

                <tr class="table">
                    <th width="3%" class="table">ລ/ດ</th>
                    <th width="14%" class="table">ລະຫັດສິນຄ້າ</th>
                    <th width="22%" class="table">ຊື່ສິນຄ້າ</th>
                    <th width="9%" class="table">ການຫໍ່ຫຸ້ມ</th>
                    <th width="10%" class="table">ຫົວໜ່ວຍໃຫຍ່</th>
                    <th width="10%" class="table">ຫົວໜ່ວຍນ້ອຍ</th>
                    <th width="6%" class="table">ຈຳນວນ</th>
                    <th width="12%" class="table">ລາຄາ</th>

                </tr>

    <?php

                            $row_page = 1;
                        }


                        $i++;
                    }
                }

    ?>
            </table>
            <br>

            <div class="ridge">
                <table width="100%" style="border:none;">
                    <tr>
                        <td align="left"><b>
                                <p align="center"> ຜູ້ສະເໜີ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກຂາຍ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກບັນຊີ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກສາງ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ພະແນກໄອທີ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>
                        <td align="left"><b>
                                <p align="center"> ຜູ້ເຂົ້າລະບົບ </p> <br> ເຊັນ:............................ <br> ຊື່:............................... <br> ວັນທີ:.......................... </td>

                    </tr>
                </table>
            </div>


            <table width="100%" style="border:none;">
                <tr>
                    <td align="left"><b>
                            <p align="left"> ICT Department </p>
                    </td>
                    <td align="right"><b>
                            <p align="right"> FM-GA-IT-SW-01-02<br>19/07/17-00</p>
                    </td>
            </table>
            <br>


            <?php


            ?>




            <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
    <!-- /row -->
    <!-- </div> -->
    <!-- </div> -->
    <script type="text/javascript">
        // window.print();
        function printdiv(divname) {
            var printContents = document.getElementById('divname').innerHTML;
            var roiginalContents = document.body.innerHTML;
            setTimeout(function() {
                this.close();
            }, 1000);

            window.print();
            document.body.innerHTML = roiginalContents;
        }
    </script>
    <!-- <script>
		
		 window.close()
		 
	</script> -->
</body>

</html>