<?php

include("../setting/checksession.php");
include("../setting/conn.php");


$name = "no";
$barcode = "no";
$box = "no";

$data_name = "";
$data_barcode = "";
$data_box = "";

extract($_POST);

$checkname = $conn->query("SELECT * FROM tbl_item_data WHERE item_name = '$item_name' ");
$chkrow = $checkname->fetch(PDO::FETCH_ASSOC);

if ($checkname->rowCount() > 0) {
    $item_edit_id = $chkrow['item_id'];

    if ($item_edit_id == $item_id) {
        $name = "no";
    } else {
        $name = "yes";
        $data_name = $data_name . ' ' . $item_name;
    }
}






if (!empty($bar_code)) {

    $checkbarcode = $conn->query("SELECT * FROM tbl_item_data WHERE barcode = '$bar_code' ");
    $chkbarcode = $checkbarcode->fetch(PDO::FETCH_ASSOC);




    if ($checkbarcode->rowCount() > 0) {

        $item_barcode_id = $chkbarcode['item_id'];

        if ($item_barcode_id == $item_id) {

            $barcode = "no";
        } else {
            $barcode = "yes";
            $data_barcode = $data_barcode . ' ' . $bar_code;
        }
    }
}


if ($item_name == "") {
    $box = "yes";
}

if ($name == "yes") {
    $res = array("res" => "existname", "item_name" => "$data_name");
} elseif ($barcode == "yes") {
    $res = array("res" => "existbarcode", "bar_code_check" => "$data_barcode");
} elseif ($box == "yes") {
    $res = array("res" => "invalid");
} else {


    $insertItem = $conn->query(" 
        update tbl_item_data
        set 
        item_name = '$item_name',
        barcode = '$bar_code',
        ipt_id = '$item_unit'
        where item_id = '$item_id' ");


    $res = array("res" => "success");
}






echo json_encode($res);
