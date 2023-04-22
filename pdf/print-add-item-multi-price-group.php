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
			SELECT  it_id,name_company,company_code,gc_name,ccy, DATE_FORMAT(a.date_register, '%d/%m/%Y') as date_register
			FROM tbl_item_code a 
			left join tbl_item_company_code b on a.icc_id = b.icc_id
			left join tbl_user_staff c on a.add_by = c.usid
			left join tbl_depart d on c.depart_id = d.dp_id
			left join tbl_group_company e on d.group_id = e.gc_id
			where it_id ='$item_id' ")->fetch(PDO::FETCH_ASSOC);
            $it_id = $cusrows['it_id'];
            $name_company = $cusrows['name_company'];
            $staff_company = $cusrows['gc_name'];
            $ccy = $cusrows['ccy'];
            $use_date = $cusrows['date_register'];



            // count item to manage page print
            $rowcp = $conn->query(" 
					select count(item_code) as cout_item
					from tbl_item_code_list a
					left join tbl_item_code b on a.it_id = b.it_id  where a.it_id = '$item_id' 
					
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
                        } else if ($staff_company == "KPLogistic") {
                            $logoname = "KPLogistic.png";
                            $witd_size = "195px";
                            $height_size = "95px";
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
                    <th class="table">ລ/ດ</th>
                    <th class="table">ລະຫັດສິນຄ້າ</th>
                    <th class="table">ຊື່ສິນຄ້າ</th>
                    <th class="table">ການຫໍ່ຫຸ້ມ</th>
                    <th class="table">ຫົວໜ່ວຍໃຫຍ່</th>
                    <th class="table">ຫົວໜ່ວຍນ້ອຍ</th>
                    <th class="table">ຈຳນວນ</th>
                    <th class="table">ລາຄາຊື້</th>
                    <th class="table">ລາຄາຂາຍ</th>
                    <th class="table">Mag_unit</th>
                    <th class="table">ກຸ່ມ</th>
                </tr>

                <?php




                $stmt3 = $conn->prepare("
                select item_code,item_name,weight as packing,buy_unit,sale_unit,pack,item_price, item_price_purchase,
                concat(bu_unit,' ',ma_group,' ',article_group) as mag_unit, bu_group
                from tbl_item_code_list 
                where it_id = '$item_id' ");
                $stmt3->execute();
                $i = 1;

                $row_page = 0;

                if ($stmt3->rowCount() > 0) {
                    while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {

                ?>

                        <tr class="table">


                            <td class="table"> <?php echo $i; ?> </td>
                            <td class="table"> <?php echo $row3['item_code']; ?> </td>
                            <td class="table"><?php echo mb_strimwidth($row3['item_name'], 0, 30, "..."); ?></td>
                            <td class="table"><?php echo $row3['packing']; ?></td>
                            <td class="table"><?php echo $row3['buy_unit']; ?></td>
                            <td class="table"><?php echo $row3['sale_unit']; ?></td>
                            <td class="table"><?php echo $row3['pack']; ?></td>
                            <td class="table"><?php echo  number_format($row3['item_price_purchase'], 2); ?></td>
                            <td class="table"><?php echo  number_format($row3['item_price'], 2); ?></td>
                            <td class="table"><?php echo $row3['mag_unit']; ?></td>
                            <td class="table"><?php echo $row3['bu_group']; ?></td>

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
                            } else if ($staff_company == "KPLogistic") {
								$logoname = "KPLogistic.png";
								$witd_size = "195px";
								$height_size = "95px";
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
                    <th class="table">ລ/ດ</th>
                    <th class="table">ລະຫັດສິນຄ້າ</th>
                    <th class="table">ຊື່ສິນຄ້າ</th>
                    <th class="table">ການຫໍ່ຫຸ້ມ</th>
                    <th class="table">ຫົວໜ່ວຍໃຫຍ່</th>
                    <th class="table">ຫົວໜ່ວຍນ້ອຍ</th>
                    <th class="table">ຈຳນວນ</th>
                    <th class="table">ລາຄາຊື້</th>
                    <th class="table">ລາຄາຂາຍ</th>
                    <th class="table">Mag_unit</th>
                    <th class="table">ກຸ່ມ</th>
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