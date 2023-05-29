<?php


include("../setting/conn.php");

extract($_POST);
 
 

$checkitem = $conn->query("SELECT * FROM tbl_item_price where item_id = '$id' ");

if ($checkitem->rowCount() > 0) {
    $res = array("res" => "used");
} else {


    $insCourse = $conn->query(" delete from tbl_item_data where item_id = '$id' ");
    if ($insCourse) {
        $res = array("res" => "success");
    } else {
        $res = array("res" => "failed");
    }
}



echo json_encode($res);
