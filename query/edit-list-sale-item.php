<?php
include("../setting/checksession.php");

include("../setting/conn.php");

extract($_POST);


$res = array("res" => "success");








echo json_encode($res);
