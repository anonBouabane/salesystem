<?php
include('../../setting/conn.php');

$com_code = $_POST['com_code'];



$i = 1;
$stmt4 = $conn->prepare(" SELECT full_code,name_company,icl_id,item_code,item_name,item_price,buy_unit,sale_unit,concat(pack,'X',weight) as packing
FROM tbl_item_code_list a
left join tbl_item_company_code b on a.com_code = icc_id 
where com_code ='$com_code'   ");
$stmt4->execute();
if ($stmt4->rowCount() > 0) {
	while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
		$icl_id = $row4['icl_id'];
		$full_code = $row4['full_code'];
		$item_name = $row4['item_name'];
		$item_price = $row4['item_price'];
		$buy_unit = $row4['buy_unit'];
		$sale_unit = $row4['sale_unit'];
		$packing = $row4['packing'];
		$name_company = $row4['name_company'];


?>

		<tr>
			<td><?php echo "$i"; ?></td>
			<td><?php echo "$full_code"; ?></td>
			<td><?php echo "$item_name"; ?></td>
			<td><?php echo "$item_price"; ?></td>
			<td><?php echo "$name_company"; ?></td>
			<td><?php echo "$packing"; ?></td>
			<td><?php echo "$buy_unit"; ?></td>
			<td><?php echo "$sale_unit"; ?></td>



			<td>
				<div class="form-check d-inline-block mr-3 mb-3">
					<input class="form-check-input" type="checkbox" value="<?php echo "$icl_id"; ?>" name="check_box[]" id="check_box<?php echo "$icl_id"; ?>">
					<label class="form-check-label" for="check_box<?php echo "$icl_id"; ?>">

					</label>
				</div>
			</td>
		</tr>


<?php
		$i++;
	}
}


?>