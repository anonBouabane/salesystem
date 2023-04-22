<?php
include("../setting/checksession.php");

include("../setting/conn.php");

$role_id = $_POST['role_id'];

$delprole = $conn->query("DELETE  FROM tbl_role_page WHERE role_id='$role_id'  ");
if ($delprole) {




    $counitem = count($_POST['pagecheck']);

    for ($i = 0; $i < ($counitem); $i++) {
        extract($_POST);

        $stmt3 = $conn->prepare(" SELECT pt_id,pt_name,a.st_id,ht_id
    FROM  tbl_page_title a
    left join tbl_sub_title b on a.st_id =b.st_id
    where pt_id ='$pagecheck[$i]' ");

        $stmt3->execute();
        if ($stmt3->rowCount() > 0) {
            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {

                $pt_id = $row3['pt_id'];
                $st_id = $row3['st_id'];
                $ht_id = $row3['ht_id'];

                if (!empty($pt_id)) {

                    $insCourse = $conn->query("INSERT INTO tbl_role_page (role_id,ht_id,st_id,pt_id ) VALUES('$role_id','$ht_id','$st_id','$pagecheck[$i]')  ");
                    if ($insCourse) {
                        $res = array("res" => "success");
                    } else {
                        $res = array("res" => "failed");
                    }
                }
            }
        }
    }
}

echo json_encode($res);
?>