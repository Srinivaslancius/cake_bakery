<?php include_once 'admin_includes/main_header.php'; ?>
<?php
 $getBannersData = getDataFromTables('coverage_areas',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);
$id = $_GET['cid'];
$qry = "DELETE FROM coverage_areas WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Coverage Area Deleted Successfully');window.location.href='coverage_areas.php';</script>";
} else {
   echo "<script>alert('Coverage Area Not Deleted');window.location.href='coverage_areas.php';</script>";
}
?>