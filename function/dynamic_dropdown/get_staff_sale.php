
<?php
include('../../setting/conn.php');

$dp_id = $_POST['dp_id'];

echo "<option value='0'> ເລືອກຜູ້ໃຊ້ </option>";


$stmt = $conn->prepare(" select usid,full_name
from tbl_user_staff a
left join tbl_staff_sale b on a.usid = b.user_ids
where role_id = 4 and b.user_ids is null
order by full_name ");
$stmt->execute();
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usid = $row['usid'];
        $full_name = $row['full_name'];
        echo "<option value='$usid'>$full_name</option>";
    }
}



?> 
					
					 