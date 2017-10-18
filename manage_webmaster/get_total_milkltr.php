<?php
include_once('admin_includes/config.php');
$user_id =  $_POST['user_id'];
$sql = "SELECT total_ltr FROM milk_orders WHERE user_id = '$user_id' ";
$result = $conn->query($sql);
$val=  $result->fetch_assoc();
echo $val['total_ltr'];
?>