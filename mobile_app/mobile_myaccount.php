<?php 
include "../manage_webmaster/admin_includes/config.php";
include "mobile_common_functions.php";

if($_SERVER['REQUEST_METHOD']=='POST'){

	if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) ) {
		$row = MobileCommonClass::getMobileIndividualDetails($_REQUEST['user_id'],'users','id');	
		$response['name']=$row['user_name'];
        $response['mobile']=$row['user_mobile'];	
		$response['address']=$row['user_address'];
		$response["success"] = 0;
		$response["message"] = "Success";

	} else {
		//If post params empty return below error
		$response["success"] = 3;
	    $response["message"] = "Required field(s) is missing";	    
	}			
	
} else {
	$response["success"] = 3;
	$response["message"] = "Invalid request";
}
echo json_encode($response);

?>