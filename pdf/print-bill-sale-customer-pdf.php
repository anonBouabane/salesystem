<!DOCTYPE html>
<html lang="en">
<?php

include("../setting/checksession.php");
include("../setting/conn.php");

$date_report = date("d/m/Y");


include("../setting/callcss.php");

?>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body onload="printdiv('divname')">
	<!-- <div class="page-wrapper"> -->
	<div class="row" id="divname" style="font-family: phetsarath OT;">

		<?php

		$cusrows = $conn->query("select * from tbl_bill_sale")->fetch(PDO::FETCH_ASSOC);


		$sale_bill_number = $cusrows['sale_bill_number'];


		?>

		<div class="col-12">
			<table width="100%" style="border:none;">
				<tr class="table" align="center">

					<td> <img src='../images/logologin.png' width='80%'></td>

				</tr>
				<tr style="font-size: 35px;">
					<td align="center">ບິນເລກທີ: </td>
				</tr>
				<tr style="font-size: 30px;">
					<td align="center">ສາຂາ: </td>
				</tr>
				<tr style="font-size: 27px;">
					<td align="center">ເບີໂທ: </td>
				</tr>
			</table>

			<?php
			$row_price = $conn->query("

				select sum(item_price) as total_price
				from tbl_bill_sale_detail_pre a
				left join tbl_item_price b on a.item_id = b.item_id and a.br_id = b.br_id 
				group by a.add_by
				")->fetch(PDO::FETCH_ASSOC);

			if (empty($row_price['total_price'])) {
				$total_price = 0;
			} else {
				$total_price = $row_price['total_price'];
			}




			?>

			<fieldset style=" ">

				<div class="col-md-12 mt-4">
					<form method="post" id="confirmpay" name="pricecalculator">


						<table class="align-middle mb-0 table table-borderless  " id="tableList">
							<thead>
								<tr>
									<th>ຊື່ສິນຄ້າ</th>
									<th>ລາຄາ</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$total_bill_price = 0;
								$stmt4 = $conn->prepare("select a.item_id,sum(item_values) as item_sale, item_name, item_price
                    from tbl_bill_sale_detail_pre a
                    left join tbl_item_data b on a.item_id = b.item_id
                    left join tbl_item_price c on a.item_id = c.item_id and a.br_id = c.br_id 
                    group by a.item_id
                    order by bsdp_id desc ");

								$stmt4->execute();
								$i = 1;
								if ($stmt4->rowCount() > 0) {
									while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
										$item_id = $row4['item_id'];
										$item_name = $row4['item_name'];
										$item_sale = $row4['item_sale'];
										$item_price = $row4['item_price'];

										$total_price = $item_sale * $item_price;

								?>
										<tr>
											<input type="hidden" name="item_id[]" id="item_id<?php echo $x; ?>" value='<?php echo "$item_id"; ?>' class="form-control">
											<td>
												<?php
												echo mb_strimwidth("$item_name", 0, 50, "...");
												?>
											</td>


											<td>

												<?php echo number_format("$total_price", 0, ",", ".") ?>
											</td>


										</tr>
								<?php
										$total_bill_price += $total_price;
										$i++;
									}
								}
								?>
							</tbody>
						</table>



					</form>
				</div>
			</fieldset>


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