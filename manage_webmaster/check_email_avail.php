<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
if(isset($_POST['user_email'])) {
	$email=$_POST['user_email'];
	$checkdata=" SELECT user_email FROM users WHERE user_email='$email' ";
	$query=$conn->query($checkdata);
	if($query->num_rows>0) {
	    echo "Email Already Exist";
	} else {
	}
exit();
}