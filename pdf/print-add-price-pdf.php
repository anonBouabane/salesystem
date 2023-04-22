<!DOCTYPE html>
<html lang="en">
<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$date_report = date("d/m/Y");

$pu_id = $_GET['pu_id'];
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

			$cusrows = $conn->query(" select pu_id,name_company,ccy,gc_name
			from tbl_price_update a
			left join tbl_item_company_code b on a.com_code = b.icc_id
            left join tbl_user_staff c on a.add_by = c.usid
			left join tbl_depart d on c.depart_id = d.dp_id
			left join tbl_group_company e on d.group_id = e.gc_id
			where pu_id ='$pu_id'
						
						")->fetch(PDO::FETCH_ASSOC);
			$pu_id = $cusrows['pu_id'];
			$name_company = $cusrows['name_company'];
			$ccy = $cusrows['ccy'];
			$staff_company = $cusrows['gc_name'];


			// count item to manage page print
			$rowcp = $conn->query("
			select count(item_id) as cout_item
					from tbl_price_update_list a
					left join tbl_price_update b on a.pu_id = b.pu_id
                    where a.pu_id = '$pu_id'
 
					
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
							<h4>ກຸ່ມສິນຄ້າ <?php echo "$name_company"; ?></h4>
						</td>
						<td align="right"><b> ເລກທີ: <?php echo "$pu_id"; ?> <br> ວັນທີພິມ: <?php echo "$date_report"; ?></td>
					</tr>



				</table>
			</div>


			<table class=" table " width="100%">

				<tr class="table">
					<th width="3%" class="table">ລ/ດ</th>
					<th width="20%" class="table">ລະຫັດສິນຄ້າ</th>
					<th width="50%" class="table">ຊື່ສິນຄ້າ</th>
					<th width="17%" class="table">ລາຄາ <?php echo  strtoupper($ccy); ?></th>

				</tr>

				<?php




				$stmt3 = $conn->prepare("  select * from tbl_price_update_list a 
				left join tbl_item_code_list b on a.item_id = b.icl_id 
				where pu_id = '$pu_id' ");
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
							<td class="table"><?php echo $row3['price_update']; ?></td>


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
								<p align="center"> ຜູ້ສະເໜີ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
						<td align="left"><b>
								<p align="center"> ພະແນກຂາຍ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
						<td align="left"><b>
								<p align="center"> ພະແນກບັນຊີ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
						<td align="left"><b>
								<p align="center"> ພະແນກໄອທີ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
						<td align="left"><b>
								<p align="center"> ຜູ້ເຂົ້າລະບົບ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
				</table>
			</div>


			<table width="100%" style="border:none;">
				<tr>
					<td align="left"><b>
							<p align="left"> ICT Department </p>
					</td>
					<td align="right"><b>
							<p align="right"> FM-GA-IT-SW-01-01<br>19/07/17-00</p>
					</td>
			</table>
			<br>

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
						<h4>ກຸ່ມສິນຄ້າ <?php echo "$name_company"; ?></h4> <br><br>
					</td>
					<td align="right"><b> ເລກທີ: <?php echo "$pu_id"; ?> <br> ວັນທີພິມ: <?php echo "$date_report"; ?></td>
				</tr>



			</table>
		</div>


		<table class=" table " width="100%">

			<tr class="table">
				<th width="3%" class="table">ລ/ດ</th>
				<th width="20%" class="table">ລະຫັດສິນຄ້າ</th>
				<th width="50%" class="table">ຊື່ສິນຄ້າ</th>
				<th width="17%" class="table">ລາຄາ <?php echo strtoupper($ccy); ?></th>

			</tr>

		<?php
							$row_page = 1;
						}
		?>



<?php

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
							<p align="center"> ຜູ້ສະເໜີ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
					<td align="left"><b>
							<p align="center"> ພະແນກຂາຍ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
					<td align="left"><b>
							<p align="center"> ພະແນກບັນຊີ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
					<td align="left"><b>
							<p align="center"> ພະແນກໄອທີ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
					<td align="left"><b>
							<p align="center"> ຜູ້ເຂົ້າລະບົບ </p> <br> ເຊັນ:............................. <br> ຊື່:................................ <br> ວັນທີ:........................... </td>
			</table>
		</div>


		<table width="100%" style="border:none;">
			<tr>
				<td align="left"><b>
						<p align="left"> ICT Department </p>
				</td>
				<td align="right"><b>
						<p align="right"> FM-GA-IT-SW-01-01<br>19/07/17-00</p>
				</td>
		</table>


		<br>




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