<?php include_once 'admin_includes/main_header.php'; ?>
<?php
$id = $_GET['uid'];
$qry = "DELETE FROM lkp_services WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Services Item Deleted Successfully');window.location.href='services.php';</script>";
} else {
   echo "<script>alert('Services Item Not Deleted');window.location.href='services.php';</script>";
}
?>