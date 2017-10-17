<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
if(!empty($_POST["sub_category_id"])) {
	$query ="SELECT * FROM sub_sub_categories WHERE sub_category_id = '" . $_POST["sub_category_id"] . "'";
	$results = $conn->query($query);
?>
	<option value="">Select Sub Sub Category</option>
<?php
	foreach($results as $subSubCategory) {
?>
	<option value="<?php echo $subSubCategory["id"]; ?>"><?php echo $subSubCategory["sub_sub_category_name"]; ?></option>
<?php
	}
}
?>
