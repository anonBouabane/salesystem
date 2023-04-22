<?php

include("../../setting/checksession.php");
include("../../setting/conn.php");

$stmt1 = $conn->prepare(" SELECT  item_name 
from tbl_item_code_list a
left join tbl_staff_item_code b on a.com_code = b.icc_id
where use_by = '$depart_id' and item_price > 0
order by item_name ");
$stmt1->execute();

$data = $stmt1->fetchAll();

echo json_encode($data);
