<!DOCTYPE html>
<html lang="en">
<?php

include("../setting/checksession.php");
include("../setting/conn.php");

$date_report = date("d/m/Y");


if (empty($_GET['bs_id'])) {

	$cusrows = $conn->query("

    SELECT  max(bs_id) as bs_id,sale_bill_number,total_pay,br_name,payment_name,a.date_register,full_name
	FROM tbl_bill_sale a
	left join tbl_branch b on a.br_id = b.br_id
	left join tbl_payment_type c on a.payment_type = c.pt_id 
	left join tbl_user d on a.sale_by = d.usid 
	where  bs_id = (SELECT  max(bs_id) from tbl_bill_sale where sale_by ='$id_users'  )
	group by sale_bill_number,total_pay,br_name,payment_name,a.date_register,full_name ")->fetch(PDO::FETCH_ASSOC);

} else {

		
	$bill_id = $_GET['bs_id'];

	$cusrows = $conn->query("
	SELECT  max(bs_id) as bs_id,sale_bill_number,total_pay,br_name,payment_name,a.date_register,full_name
	FROM tbl_bill_sale a
	left join tbl_branch b on a.br_id = b.br_id
	left join tbl_payment_type c on a.payment_type = c.pt_id 
	left join tbl_user d on a.sale_by = d.usid 
	where bs_id ='$bill_id' 
	group by sale_bill_number,total_pay,br_name,payment_name,a.date_register,full_name
	")->fetch(PDO::FETCH_ASSOC);


}

?>

<style>
.center {
    text-align: center;
}

.left {
    text-align: left;
}

.right {
    text-align: right;
}

.fs-25 {
    font-size: 25px;
}

.fs-30 {
    font-size: 30px;
}

.fs-35 {
    font-size: 35px;
}

.header {

    text-decoration: underline;

}

.line-hr {
    height: 2px;
    width: 100%;
    border-width: 0;
    color: black;
    background-color: black
}
</style>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body onload="printdiv('divname')">
    <!-- <div class="page-wrapper"> -->
    <div class="row" id="divname" style="font-family: phetsarath OT;">

        <?php

	


		$bs_id = $cusrows['bs_id'];
		$sale_name = $cusrows['full_name'];


		?>

        <div class="">

            <div class="center">

                <img src='../images/logologin.png' width='35%'>

            </div>
            <div class="center fs-35">
                ສາຂາ: <?php echo $cusrows['br_name']; ?>
            </div>
            <div class="center fs-35">
                ບິນເລກທີ: <?php echo $cusrows['sale_bill_number']; ?>
            </div>
            <div class="center fs-35">
                ເບີໂທ: 020 55609011
            </div>

            <br>

            <div class="center fs-35">
                ບິນເກັບເງິນ
            </div>

            <table class="align-middle mb-0 table table-borderless" id="tableList" width="100%">

                <tr>
                    <th class="left" style="font-size: 35px;">ຊື່ສິນຄ້າ</th>
                    <th class="right" style="font-size: 35px;">ຈຳນວນ / ລາຄາ</th>
                </tr>

            </table>

            <hr class="line-hr">

            <table class="align-middle mb-0 table table-borderless" id="tableList" width="100%">




                <?php

				$total_bill_price = 0;
				$total_item = 0;

				$stmt4 = $conn->prepare("
					select item_name,item_values,item_total_price 
					from tbl_bill_sale_detail a
					left join tbl_item_data b on a.item_id = b.item_id
					where bs_id = '$bs_id' ");

				$stmt4->execute();
				$i = 1;
				if ($stmt4->rowCount() > 0) {
					while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
						$item_name = $row4['item_name'];
						$item_values = $row4['item_values'];
						$total_price = $row4['item_total_price'];


				?>
                <tr>
                    <td class="left fs-25">
                        <?php
								echo mb_strimwidth("$item_name", 0, 50, "...");
								?>
                    </td>


                    <td class="right fs-25">

                        <?php
								echo  "$item_values / ";
								echo number_format("$total_price", 0, ",", ".")

								?>
                    </td>

                </tr>

                <?php
						$total_bill_price += $total_price;

						$total_item += $item_values;


						$i++;
					}
				}
				?>



            </table>

            <hr class="line-hr">
            <table class="align-middle mb-0 table table-borderless" id="tableList" width="100%">

                <tr>
                    <th class="right" style="font-size: 35px;">ຈຳນວນສິນຄ້າ: <?php echo "$total_item"; ?></th>
                    <th class="right" style="font-size: 35px;">
                        <?php
						echo number_format("$total_bill_price", 0, ",", ".")
						?>
                    </th>
                </tr>

            </table>

            <br>
            <div style="font-size: 35px;" class="center">
                ຜູ້ຂາຍ: <?php echo "$sale_name"; ?>
            </div>
            <div style="font-size: 35px;" class="center">
                ຂອບໃຈທິດອຸດໜູນ
            </div>
        </div>

        </b>

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