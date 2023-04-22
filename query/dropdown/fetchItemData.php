<?php 	

include("../setting/conn.php");

$stmt1 = $conn->prepare(" SELECT * from tbl_category_type  order by cat_name ");
$stmt1->execute();
								
$data = $stmt1->fetchAll();
 
echo json_encode($data);


?>