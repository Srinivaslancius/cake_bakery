<?php
    error_reporting(1);
    require_once('../manage_webmaster/admin_includes/config.php');
    require_once('../manage_webmaster/admin_includes/common_functions.php');
    require_once('mobile_common_functions.php');
    //require_once('mobile_email_templates.php');

if($_SERVER['REQUEST_METHOD']=='POST'){

    if (isset($_REQUEST['name']) && !empty($_REQUEST['email']) && !empty($_REQUEST['mobile']) && !empty($_REQUEST['password']) ) {

            $getUserCnt = MobileCommonClass::checkIpExists($_REQUEST['mobile']);
            if($getUserCnt > 0) {

                $response["success"] = 2;
                $response["message"] = "This device already exists, Please register with another device.";
            } else {

                $adduser = MobileCommonClass::addUser($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['mobile'], 
                    encryptPassword($_REQUEST['password']) );
                if($adduser == 1){
                    $response["success"] = 0;
                    $response["message"] = "You have successfully registered and logged in";
                    //Send email for user after registraion
                    $bodyMessage = 'Dear '.$_REQUEST['name'].', <br />Thank you for signing up at Open Library. <br />Thanks & Regards,
Open Library Team';
                    $subject='User Registration';
                    $toEmail ='srinivas@lanciussolutions.com';
                    $fromEmail ='srinivas@lanciussolutions.com';
                    //$sendEmail = getEmailTemplate($toEmail,$bodyMessage,$fromEmail,$subject);

                } else {
                    $response["success"] = 1;
                    $response["message"] = "An error occurred during registration.";
                }
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