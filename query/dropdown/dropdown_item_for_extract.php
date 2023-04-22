<?php

include("../../setting/checksession.php");
include("../../setting/conn.php");

$stmt1 = $conn->prepare("SELECT item_id,item_name FROM tbl_item_data where ipt_id != '1' ");
$stmt1->execute();

$data = $stmt1->fetchAll();

echo json_encode($data);
