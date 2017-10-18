<?php 
error_reporting(0);
require_once('../manage_webmaster/admin_includes/config.php');
require_once('../manage_webmaster/admin_includes/common_functions.php');
//Set Array for list
$lists = array();
$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){	

		$result = getAllDataWithActiveRecent("products");	
		if ($result->num_rows > 0) {
				$response["lists"] = array();
				while($row = $result->fetch_assoc()) {
					//Chedck the condioton for emptty or not		
					$lists = array();
			    	$lists["id"] = $row["id"];
			    	$lists["product_name"] = $row["product_name"];
			    	//$lists["product_info"] = strip_tags($row["product_info"]);
			    	$getPriceDetails = getAllDataWhere('product_weight_prices','product_id',$row['id']);
		    		$getPriceDet = array();
			    	while($getPriceDet = $getPriceDetails->fetch_assoc()) {
			    		$lists["price"] .=  $getPriceDet['price'] .",";
			    		$lists["price_id"] .=  $getPriceDet['id'] .",";
				    	$getWeights = getIndividualDetails($getPriceDet['weight_type_id'],'product_weights','id');
				    	$lists["weight_type_id"] .=  $getWeights['id'] .",";
			    		$lists["weight_type"] .=  $getWeights['weight_type'] .",";		    		
			    	}
			    	$getImgDetails = getAllDataWhere('product_images','product_id',$row['id']);
		    		$getImgDet = array();
			    	while($getImgDet = $getImgDetails->fetch_assoc()) {
			    		$lists["image"] = $base_url."uploads/product_images/".$getImgDet["product_image"];				    			    		
			    	}
					array_push($response["lists"], $lists);		 
				}
				$response["success"] = 0;	
				$response["message"] = "Success";		
		} else {
		    $response["success"] = 1;
		    $response["message"] = "No Records found";	    
		}
		
	
} else {
	$response["success"] = 3;
	$response["message"] = "Invalid request";
}
echo json_encode($response); 

?>