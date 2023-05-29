<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);

$stmt =$conn ->query("SELECT * FROM tbl_roles where role_name = '$role_name'");
if ($stmt->rowcount()>0){
{
$res= array("res" => "exist","role name" => $role_name);

}
}else{

$delExam = $conn->query(" update tbl_roles set 
role_name ='$role_name',role_level='$role_level' WHERE r_id='$r_id'  ");
if ($delExam) {
    $res = array("res" => "success","role name" =>$role_name);
} else {
    $res = array("res" => "failed", "role name" => $role_name);
}


}

echo json_encode($res);
?>