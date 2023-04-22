<?php

include("../../setting/checksession.php");
include("../../setting/conn.php");

$stmt1 = $conn->prepare(" 
select a.item_id ,item_name
from tbl_item_price a
left join tbl_item_data b on a.item_id = b.item_id  
where br_id = '$br_id' and status_item_price = '1' 
");
$stmt1->execute();

$data = $stmt1->fetchAll();

echo json_encode($data);

?>
