<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);

$countbox = count($_POST['item_id']);

for ($i = 0; $i < ($countbox); $i++) {
    extract($_POST);

    $check_price = $conn->query("select * from tbl_item_price where br_id = '$br_id' and item_id = '$item_id[$i]' ")->fetch(PDO::FETCH_ASSOC);


    if (empty($check_price['ip_id'])) {

        $item_price = $conn->query("INSERT INTO tbl_item_price (item_id,item_price,br_id,status_item_price,add_by,date_register ) 
        VALUES('$item_id[$i]','$item_price[$i]','$br_id','1','$id_users',CURDATE()) ");
        if ($item_price) {
            $res = array("res" => "success");
        } else {
            $res = array("res" => "failed");
        }
    } else {

        $item_price = $conn->query("update tbl_item_price set item_price ='$item_price[$i]' where  item_id = '$item_id[$i]' and br_id = '$br_id' ");
        $res = array("res" => "success");
    }
}

echo json_encode($res);
