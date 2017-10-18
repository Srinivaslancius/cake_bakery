<?php
    require_once('../manage_webmaster/admin_includes/config.php');    

if($_SERVER['REQUEST_METHOD']=='POST'){
    $response["success"] = 0;
    $response["message"] = "Success";
    $response["base_url"] = $base_url;

} else {
    $response["success"] = 4;
    $response["message"] = "Invalid request";

}

echo json_encode($response);

?>