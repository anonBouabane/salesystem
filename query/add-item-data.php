<?php

include("../setting/checksession.php");
include("../setting/conn.php");



$countbox = count($_POST['item_name']);

$name = "no";
$barcode = "no";
$box = "no";

$data_name = "";
$data_barcode = "";
$data_box = "";

for ($j = 0; $j < ($countbox); $j++) {

    extract($_POST);

    $checkname = $conn->query("SELECT * FROM tbl_item_data WHERE item_name = '$item_name[$j]' ");

    if ($checkname->rowCount() > 0) {
        $name = "yes";

        $data_name = $data_name . ' ' . $item_name[$j];
    }
}

for ($k = 0; $k < ($countbox); $k++) {

    extract($_POST);

    if (!empty($bar_code[$k])) {
        $checkbarcode = $conn->query("SELECT * FROM tbl_item_data WHERE barcode = '$bar_code[$k]' ");

        if ($checkbarcode->rowCount() > 0) {
            $barcode = "yes";

            $data_barcode = $data_barcode . ' ' . $bar_code[$k];
        }
    }
}

 
for ($a = 0; $a < ($countbox); $a++) {
    extract($_POST);
    if ($item_name[$a] == "") {
        $box = "yes";
        $b = $a+1;
        $data_box = $data_box . ' ' . $b;
    }
}

if ($name == "yes") {
    $res = array("res" => "existname", "item_name" => "$data_name");
} elseif ($barcode == "yes") {
    $res = array("res" => "existbarcode", "bar_code_check" => "$data_barcode");
} elseif ($box == "yes") {
    $res = array("res" => "invalid", "list_num" => "$data_box");
} else {

    for ($i = 0; $i < ($countbox); $i++) {

        extract($_POST);



        $insertItem = $conn->query(" insert into tbl_item_data  (item_name,barcode,ipt_id) values ('$item_name[$i]','$bar_code[$i]','$item_unit[$i]'); ");
    }

    $res = array("res" => "success");
}






echo json_encode($res);
