<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
$id = $_POST['del_id'];
//echo $music_number;
$target_dir = '../uploads/product_images/';
$getImgUnlink = getImageUnlink('product_image','product_images','id',$id,$target_dir);
$qry = "DELETE FROM product_images WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "YES";
} else {
   echo "NO";
}
?>