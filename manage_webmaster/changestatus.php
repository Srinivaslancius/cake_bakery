<?php
include "admin_includes/config.php";
if(!empty($_POST['check_active_id']) && !empty($_POST['check_active_id']))  {
	//echo "<pre>"; print_r($_POST); die;
	$check_active_id = $_POST['check_active_id'];
	$table_name = $_POST['table_name'];
	$send_status = $_POST['send_status'];
	$sql="UPDATE $table_name SET status = '$send_status' WHERE id='$check_active_id' ";
	if($conn->query($sql) === TRUE){
		$succ = "1";
	} else {
		$succ = "0";
	}
	echo $succ;
}
?>