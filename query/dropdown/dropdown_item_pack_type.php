<?php

include("../../setting/checksession.php");
include("../../setting/conn.php");

$stmt1 = $conn->prepare("SELECT * FROM tbl_item_pack_type");
$stmt1->execute();

$data = $stmt1->fetchAll();

echo json_encode($data);
