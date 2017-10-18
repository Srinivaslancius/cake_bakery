<?php
    
include "../manage_webmaster/admin_includes/config.php";  

if($_SERVER['REQUEST_METHOD']=='POST'){
    
    if (isset($_REQUEST['rating']) && !empty($_REQUEST['user_id']) && !empty($_REQUEST['feedback_message']) ) {
            //Check Auth key valid or not    
            $rating = $_REQUEST['rating'];
            $user_id = $_REQUEST['user_id'];
            $feedback_message = $_REQUEST['feedback_message'];
            $created_at = date("Y-m-d h:i:s");    
            $saveFeedback = "INSERT INTO users_freedback (`user_id`,`rating`, `message`, `created_at`) VALUES ('$user_id','$rating', '$feedback_message', '$created_at')";

            if ($conn->query($saveFeedback) === TRUE) {

                $response["success"] = 0;
                $response["message"] = "Feedback submit successfully.";
            } else {

                $response["success"] = 1;
                $response["message"] = "An error occurred during registration.";
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