<?php
include("../setting/checksession.php");
include("../setting/conn.php");

$header_name = "ສ້າງສິດ";
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
										<h4 class="text-dark">ສ້າງສິດ</h4>



									</div>
									<form method="post" id="addrole">


										<div class="row">

											<div class="col-lg-6">
												<div class="form-group">
													<label for="firstName">ຊື່ສິດ</label>
													<input type="text" class="form-control" id="role_name" name="role_name" required>
												</div>
											</div>

											<div class="form-group col-lg-6">
												<label class="text-dark font-weight-medium">ລະດັບສິດ</label>
												<div class="form-group">

													<select class=" form-control font" name="role_level" id="role_level">
														<option value=""> ເລືອກລະດັບ </option>
														<?php
														$stmt5 = $conn->prepare(" SELECT * FROM tbl_role_level ");
														$stmt5->execute();
														if ($stmt5->rowCount() > 0) {
															while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
														?>
																<option value="<?php echo $row5['rl_id']; ?>"> <?php echo $row5['rl_name']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
											</div>


										</div>








										<div class="d-flex justify-content-end mt-6">
											<button type="submit" class="btn btn-primary mb-2 btn-pill">ສ້າງສິດ</button>
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
										<th>ຊື່ສິດ</th>
										<th>ລະດັບສິດ</th>
									</tr>
								</thead>
								<tbody>


									<?php
									$stmt4 = $conn->prepare("select r_id,role_name, rl_name 
									from tbl_roles a
									left join tbl_role_level b on a.role_level = b.rl_id order by r_id desc");
									$stmt4->execute();
									if ($stmt4->rowCount() > 0) {
										while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
											$r_id = $row4['r_id'];
											$role_name = $row4['role_name'];

									?>



											<tr>
												<td><?php echo "$r_id"; ?></td>
												<td><?php echo "$role_name"; ?></td>
												<td><?php echo $row4['rl_name']; ?></td>
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
		$(document).on("submit", "#addrole", function() {
			$.post("../query/add-roles.php", $(this).serialize(), function(data) {
				if (data.res == "success") {
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


		// active user
		$(document).on("click", "#activestaffuser", function(e) {
			e.preventDefault();
			var id = $(this).data("id");
			$.ajax({
				type: "post",
				url: "../query/activestaffuser.php",
				dataType: "json",
				data: {
					id: id
				},
				cache: false,
				success: function(data) {
					if (data.res == "success") {
						Swal.fire(
							'ສຳເລັດ',
							'ເປີດນຳໃຊ້ສຳເລັດ',
							'success'
						)
						setTimeout(
							function() {
								window.location.href = 'staff.php';
							}, 1000);

					}
				},
				error: function(xhr, ErrorStatus, error) {
					console.log(status.error);
				}

			});



			return false;
		});


		// inactive user
		$(document).on("click", "#inactivestaffuser", function(e) {
			e.preventDefault();
			var id = $(this).data("id");
			$.ajax({
				type: "post",
				url: "../query/inactivestaffuser.php",
				dataType: "json",
				data: {
					id: id
				},
				cache: false,
				success: function(data) {
					if (data.res == "success") {
						Swal.fire(
							'ສຳເລັດ',
							'ປິດນຳໃຊ້ສຳເລັດ',
							'success'
						)
						setTimeout(
							function() {
								window.location.href = 'staff.php';
							}, 1000);

					}
				},
				error: function(xhr, ErrorStatus, error) {
					console.log(status.error);
				}

			});



			return false;
		});
	</script>

	<!--  -->


</body>

</html>