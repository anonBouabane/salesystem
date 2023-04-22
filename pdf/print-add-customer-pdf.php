<!DOCTYPE html>
<html lang="en">
<?php

include("../setting/checksession.php");
include("../setting/conn.php");

$date_report = date("d/m/Y");
?>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link id="main-css-href" rel="stylesheet" href="../css/style-pdf-customer.css" />
</head>


<body onload="printdiv('divname')">
	<!-- <div class="page-wrapper"> -->
	<div class="row" id="divname" style="font-family: phetsarath OT;">
		<div class="col-12">


			<?php

			$i = 1;
			$all_page = count($_POST['check_box']);
			for ($x = 0; $x < count($_POST['check_box']); $x++) {
				$check_box = $_POST['check_box'][$x];
				// echo"$check_box";



				$cusrows = $conn->query(" SELECT * from view_customer_pdf where c_id = '$check_box' ")->fetch(PDO::FETCH_ASSOC);
				$c_id = $cusrows['c_id'];
				$acc_name = $cusrows['acc_name'];
				$c_code = $cusrows['c_code'];
				$c_shop_name = $cusrows['c_shop_name'];
				$gender = $cusrows['gender'];
				$c_name = $cusrows['c_name'];
				$c_eng_name = $cusrows['c_eng_name'];
				$provinces = $cusrows['pv_name'];
				$district = $cusrows['distict_name'];
				$village = $cusrows['village'];
				$street = $cusrows['street'];
				$h_unit = $cusrows['h_unit'];
				$h_number = $cusrows['h_number'];
				$identfy_number = $cusrows['identfy_number'];
				$location_des = $cusrows['location_des'];
				$phone1 = $cusrows['phone1'];
				$phone2 = $cusrows['phone2'];
				$fax = $cusrows['fax'];
				$payment_type = $cusrows['payment_type'];
				$credit_values = $cusrows['credit_values'];
				$payment_term = $cusrows['payment_term'];
				$contact_by = $cusrows['contact_by'];
				$contact_phone = $cusrows['contact_phone'];
				$staff_contact = $cusrows['staff_contact'];
				$shop_type = $cusrows['shop_type'];
				$service_type = $cusrows['service_type'];
				$visit_days = $cusrows['visit_days'];
				$staff_company = $cusrows['gc_name'];
				$ref_number = $cusrows['ref_number'];
				$pt_name = $cusrows['pt_name'];
				$acc_book = $cusrows['acc_book'];
				$bank_code = $cusrows['bank_code'];


			?>

				<div>
					<table width="100%" style="border:none;">



						<tr>
							<?php

					 


							//echo " $staff_company";

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
									<h1> ຟອມລູກຄ້າ </h1>
								</b>
								<h4>ກູ່ມສິນຄ້າ <?php echo "$acc_name"; ?></h4> <br> 
							</td>
							<td align="right"><b> ເລກທີ: <?php echo "$ref_number"; ?> <br> ວັນທີພິມ: <?php echo "$date_report"; ?></td>
						</tr>



					</table>
				</div>

				<div class="container ridge ">

					<table>
						<tr>
							<td>
								<label for="fname">ລະຫັດລູກຄ້າ: <?php echo "$c_code"; ?></label>
							</td>
							<td>
								<label for="fname">ຊື່ຮ້ານ: <?php echo "$c_shop_name" ?></label>
							</td>
							<td>
								<label for="fname">ເພດ: <?php echo "$gender" ?></label>
							</td>
						</tr>
						<tr>
							<td>
								<label for="fname">ເຮືອນເລກທີ: <?php echo "$h_number" ?></label>
							</td>
							<td>
								<label for="fname">ຊື່ເຈົ້າຂອງກິດຈະການ: <?php echo " $c_name" ?></label>
							</td>
							<td>
								<label for="fname">ຊື່ພາສາອັງກິດ: <?php echo "$c_eng_name" ?></label>
							</td>

						</tr>
						<tr>
							<td>
								<label for="fname">ຖະນົນ: <?php echo "$street" ?></label>
							</td>
							<td>
								<label for="fname">ບ້ານ: <?php echo "$village" ?></label>
							</td>
							<td>
								<label for="fname">ໜ່ວຍ: <?php echo "$h_unit" ?></label>
							</td>

						</tr>

						<tr>
							<td>
								<label for="fname">ເມືອງ: <?php echo "$district" ?></label>
							</td>
							<td>
								<label for="fname">ແຂວງ: <?php echo "$provinces" ?></label>
							</td>
							<td>
								<label for="fname">ທີ່ຕັ້ງ: <?php echo "$location_des"; ?></label>
							</td>
						</tr>
						<tr>
							<td>
								<label for="fname">ເບີໂທ1: <?php echo "$phone1" ?></label>
							</td>
							<td>
								<label for="fname">ເບີໂທ2: <?php echo "$phone2" ?></label>
							</td>
							<td>
								<label for="fname">ເລກບັນຊີ: <?php echo "$acc_book" ?></label>
							</td>
						</tr>

						<tr>
							<td>
								<label for="fname">ປະເພດຊຳລະ: <?php echo "$payment_type" ?></label>
							</td>
							<td>
								<label for="fname">ວົງເງິນຕິດໜີ້: <?php if ($payment_type == "ຕິດໜີ້") {
																		echo "$credit_values";
																	} ?></label>
							</td>
							<td>
								<label for="fname">ວັນຕິດໜີ້: <?php if ($payment_type == "ຕິດໜີ້") {
																	echo "$pt_name";
																} ?></label>
							</td>
						</tr>

						<tr>
							<td>
								<label class="m-l-4" for="fname">ເລກປະຈຳຕົວຜູ້ເສຍອາກອນ: <?php echo "$identfy_number" ?></label>
							</td>
							<td>

							</td>
							<td>
								<label class="m-l-4" for="fname">ທະນາຄານ: <?php echo "$bank_code" ?></label>
							</td>
						</tr>

						<tr>
							<td>
								<label for="fname">ຊື່ຜູ້ຕິດຕໍ່: <?php echo "$contact_by" ?></label>
							</td>
							<td>
								<label for="fname">ເບີໂທຜູ້ຕິດຕໍ່: <?php echo "$contact_phone" ?></label>
							</td>
							<td>
								<label class="m-l-4" for="fname">ສະກຸນເງິນ
									<?php
									$ccy_code = substr($acc_book, -3);
									if ($ccy_code == '001') {
										echo "LAK";
									} else if ($ccy_code == '002') {
										echo "THB";
									} else {
										echo "USD";
									}


									?></label>
							</td>

						</tr>

						<tr>
							<td>
								<label for="fname">ລະຫັດພະນັກງານ: <?php echo "$staff_contact" ?></label>
							</td>
							<td>
								<label for="fname">ປະເພດລູກຄ້າ: <?php echo "$shop_type" ?></label>
							</td>
							<td>
								<label for="fname">service type: <?php echo "$service_type" ?></label>
							</td>
							<td>
								<label for="fname">visit days: <?php echo "$visit_days" ?></label>
							</td>
						</tr>



					</table>


				</div>
				<br><br>

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
						<td align="center"><b>
								<p align="center"> Page <?php echo "$i of $all_page"; ?></p>
						</td>
						<td align="right"><b>
								<p align="right"> FM-GA-IT-SW-01-01<br>19/07/17-00</p>
						</td>
				</table>


			<?php
				$i++;
			}

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