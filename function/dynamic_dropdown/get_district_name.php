
<?php
include('../../setting/conn.php');

$pv_id = $_POST['pv_id'];

echo "<option value='0'> ເລືອກເມືອງ </option>";


$stmt = $conn->prepare(" SELECT dis_id,distict_name FROM tbl_districts where pv_id = '$pv_id' order by distict_name  ");
$stmt->execute();
if ($stmt->rowCount() > 0) {
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$dis_id = $row['dis_id'];
		$distict_name = $row['distict_name'];
		echo "<option value='$dis_id'>$distict_name</option>";
	}
}


?> 

