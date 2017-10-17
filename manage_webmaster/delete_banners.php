<?php include_once 'admin_includes/main_header.php'; ?>
<?php
 $getBannersData = getDataFromTables('banners',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);
$id = $_GET['bid'];
//echo $music_number;
$target_dir = '../uploads/banner_images/';
$getImgUnlink = getImageUnlink('banner','banners','id',$id,$target_dir);
$qry = "DELETE FROM banners WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Banner Deleted Successfully');window.location.href='banners.php';</script>";
} else {
   echo "<script>alert('Banner Not Deleted');window.location.href='banners.php';</script>";
}
?>