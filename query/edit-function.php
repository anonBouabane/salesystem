<?php


include("../setting/conn.php");

extract($_POST);



$insCourse = $conn->query("
update tbl_page_title set st_id ='$st_id',pt_name = '$pt_name' where pt_id = '$pt_id'  
    
    ");
if ($insCourse) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}




echo json_encode($res);
?>