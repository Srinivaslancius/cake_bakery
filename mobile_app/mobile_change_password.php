<?php
error_reporting(1);
include "../manage_webmaster/admin_includes/config.php";
require_once('../manage_webmaster/admin_includes/common_functions.php');

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_REQUEST['userid']) && !empty($_REQUEST['userid']) && isset($_REQUEST['opassword']) && !empty($_REQUEST['opassword']) && isset($_REQUEST['npassword']) && !empty($_REQUEST['npassword'])) {

        $userid = $_REQUEST["userid"];
        $opassword = encryptPassword($_REQUEST["opassword"]);
        $npassword = encryptPassword($_REQUEST["npassword"]);

        $sql    = "SELECT * FROM users WHERE id = '$userid' AND status=0 ";
        $result = $conn->query($sql);
        $row    = $result->fetch_assoc();
        if($row['user_password'] ==  $opassword) {

            $sql1= "UPDATE users SET user_password = '$npassword' where id = '$userid'";
            $result = $conn->query($sql1);
            $response["success"] = 0;
            $response["message"] = "Success.";
        } else {

            $response["success"] = 1;
            $response["message"] = "Invalid Old Password.";
        }

    } else {

        $response["success"] = 3;
        $response["message"] = "Required field(s) is missing";
    }

} else {

    $response["success"] = 4;
    $response["message"] = "Invalid request";
}

echo json_encode($response);
?>