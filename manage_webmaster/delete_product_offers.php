<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
$id = $_GET['oid'];
//echo $music_number;
$target_dir = '../uploads/offer_images/';
$getImgUnlink = getImageUnlink('banner','products_offers','id',$id,$target_dir);
$qry = "DELETE FROM products_offers WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Banner Deleted Successfully');window.location.href='product_offers.php';</script>";
} else {
   echo "<script>alert('Banner Not Deleted');window.location.href='product_offers.php';</script>";
}
?>