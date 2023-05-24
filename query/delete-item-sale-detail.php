<?php

include("../setting/checksession.php");
include("../setting/conn.php");
extract($_POST);



$delitemdetail = $conn->query("DELETE  FROM tbl_bill_sale_detail WHERE bsd_id ='$id' ");
if ($delitemdetail) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}


echo json_encode($res);
