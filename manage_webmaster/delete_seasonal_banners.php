<?php include_once 'admin_includes/main_header.php'; ?>
<?php
 $getBannersData = getDataFromTables('seasonal_banners',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);
$id = $_GET['bid'];
//echo $music_number;
$target_dir = '../uploads/seasonal_banner_images/';
$getImgUnlink = getImageUnlink('banner','seasonal_banners','id',$id,$target_dir);
$qry = "DELETE FROM seasonal_banners WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Seasonal Offer Banner Deleted Successfully');window.location.href='seasonal_banners.php';</script>";
} else {
   echo "<script>alert('Seasonal Offer Banner Not Deleted');window.location.href='seasonal_banners.php';</script>";
}
?>