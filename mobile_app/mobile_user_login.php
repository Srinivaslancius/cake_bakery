<?php
    error_reporting(0);
    require_once('../manage_webmaster/admin_includes/config.php');
    require_once('../manage_webmaster/admin_includes/common_functions.php');
    
if($_SERVER['REQUEST_METHOD']=='POST'){

    if (isset($_REQUEST['mobile']) && !empty($_REQUEST['mobile']) && !empty($_REQUEST['password']) )  {

            $mobile= $_REQUEST['mobile'];
            $password = encryptPassword($_REQUEST['password']);           
            $sql = "SELECT * FROM users WHERE user_mobile = '$mobile' AND user_password = '$password' AND status=0 ";
            $result = $conn->query($sql);   

            if($result->num_rows > 0) {

                $response["success"] = 0;
                $response["message"] = "Success.";
            } else {
                $response["success"] = 1;
                $response["message"] = "Invalid Credentials.";
            }            

    }  else {
        $response["success"] = 3;
        $response["message"] = "Required field(s) is missing";

    } 
    
} else {
    $response["success"] = 4;
    $response["message"] = "Invalid request";

}

echo json_encode($response);

?>