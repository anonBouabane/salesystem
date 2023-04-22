
<?php
include('../../setting/conn.php');

$group_id = $_POST['group_id'];

echo "<option value='0'> ເລືອກພະແນກ </option>";


$stmt = $conn->prepare(" SELECT * FROM tbl_depart where group_id = '$group_id'  ");
$stmt->execute();
if ($stmt->rowCount() > 0) {
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$dp_id = $row['dp_id'];
		$dp_name = $row['dp_name'];
		echo "<option value='$dp_id'>$dp_name</option>";
	}
}


?> 

