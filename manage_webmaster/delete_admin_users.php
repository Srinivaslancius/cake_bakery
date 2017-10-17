<?php include_once 'admin_includes/main_header.php'; ?>
<?php
 $getBannersData = getDataFromTables('admin_users',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);
$id = $_GET['uid'];
$qry = "DELETE FROM admin_users WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Admin User Deleted Successfully');window.location.href='admin_users.php';</script>";
} else {
   echo "<script>alert('Admin user Not Deleted');window.location.href='admin_users.php';</script>";
}
?>