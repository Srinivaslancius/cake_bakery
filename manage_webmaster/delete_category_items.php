<?php include_once 'admin_includes/main_header.php'; ?>
<?php
$id = $_GET['uid'];
$qry = "DELETE FROM category_items WHERE id ='$id'";
$result = $conn->query($qry);
if(isset($result)) {
   echo "<script>alert('Category Item Deleted Successfully');window.location.href='category_items.php';</script>";
} else {
   echo "<script>alert('Category Item Not Deleted');window.location.href='category_items.php';</script>";
}
?>