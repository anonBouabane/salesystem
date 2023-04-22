<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ຫນ້າຟັງຊັ້ນ";
$header_click = "4";

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
<script type="text/javascript" src="../js/jquery.min.js"></script> <!-- jQuery -->




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


							<div class="col-xxl-12">
								<div class="email-right-column  email-body p-4 p-xl-5">
									<div class="email-body-head mb-5 ">
										<h4 class="text-dark">ຈັດການຫນ້າຟັງຊັ້ນ</h4>

									</div>
									<form method="post" id="addpage">


										<div class="row">


											<div class="form-group  col-lg-12">
												<label class="text-dark font-weight-medium">ຫົວຂໍ້</label>
												<div class="form-group">
													<select class=" form-control font" name="sub_title" id="sub_title">
														<option value=""> ເລືອກຫົວຂໍ້ </option>
														<?php
														$stmt5 = $conn->prepare(" SELECT * FROM tbl_sub_title ");
														$stmt5->execute();
														if ($stmt5->rowCount() > 0) {
															while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
														?> <option value="<?php echo $row5['st_id']; ?>"> <?php echo $row5['st_name']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
											</div>

											<div class="col-lg-12">
												<div class="form-group">
													<label for="firstName">ຊື່ຫນ້າ</label>
													<input type="text" class="form-control" id="page_name" name="page_name" required>
												</div>
											</div>

											<div class="col-lg-12">
												<div class="form-group">
													<label for="firstName">ຊື່ໄຟຣ</label>
													<input type="text" class="form-control" id="pf_name" name="pf_name" required>
												</div>
											</div>

										</div>

										<div class="d-flex justify-content-end mt-6">
											<button type="submit" class="btn btn-primary mb-2 btn-pill">ເພີ່ມຂໍ້ມູນ</button>
										</div>

									</form>


								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="content-wrapper">
				<div class="content">
					<!-- For Components documentaion -->


					<div class="card card-default">

						<div class="card-body">

							<table id="productsTable" class="table table-hover table-product" style="width:100%">
								<thead>
									<tr>
										<th>ເລກລຳດັບ</th>
										<th>ຊື່ຫນ້າ</th>
										<th>ຫົວຂໍ້</th>
									</tr>
								</thead>
								<tbody>


									<?php
									$stmt4 = $conn->prepare("SELECT  pt_id,pt_name ,st_name
									FROM tbl_page_title a
									left join tbl_sub_title b on a.st_id = b.st_id order by pt_id desc ");
									$stmt4->execute();
									if ($stmt4->rowCount() > 0) {
										while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
											$pt_id = $row4['pt_id'];
											$pt_name = $row4['pt_name'];
											$st_name = $row4['st_name'];

									?>



											<tr>
												<td><?php echo "$pt_id"; ?></td>
												<td><?php echo "$pt_name"; ?></td>
												<td><?php echo "$st_name"; ?></td>


											</tr>


									<?php
										}
									}
									?>


								</tbody>
							</table>

						</div>
					</div>


				</div>

			</div>

			<?php include "footer.php"; ?>
		</div>
	</div>

	<?php include("../setting/calljs.php"); ?>

	<script>
		// Add staff user 
		$(document).on("submit", "#addpage", function() {
			$.post("../query/add-page.php", $(this).serialize(), function(data) {
				if (data.res == "exist") {
					Swal.fire(
						'ລົງທະບຽນຊ້ຳ',
						'ຜູ້ໃຊ້ນີ້ຖືກລົງທະບຽນແລ້ວ',
						'error'
					)
				} else if (data.res == "success") {
					Swal.fire(
						'ສຳເລັດ',
						'ເພິ່ມຜູ້ໃຊ້ສຳເລັດ',
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

	<!--  -->


</body>

</html>