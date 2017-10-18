<?php include_once 'admin_includes/main_header.php'; ?>
<?php
$id = $_GET['uid'];
$qry = "DELETE FROM maintance_category WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Maintenance Category Deleted Successfully');window.location.href='truck_maintenance.php';</script>";
} else {
   echo "<script>alert('Maintenance Category Not Deleted');window.location.href='truck_maintenance.php';</script>";
}
?>