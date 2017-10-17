<?php include_once 'admin_includes/main_header.php'; ?>
<?php
 $getPartnerLogosData = getDataFromTables('partner_logos',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);
$id = $_GET['bid'];
//echo $music_number;
$target_dir = '../uploads/partner_logos/';
$getImgUnlink = getImageUnlink('partner_logo','partner_logos','id',$id,$target_dir);
$qry = "DELETE FROM partner_logos WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Partner Logo Deleted Successfully');window.location.href='partner_logos.php';</script>";
} else {
   echo "<script>alert('Partner Logo Not Deleted');window.location.href='partner_logos.php';</script>";
}
?>