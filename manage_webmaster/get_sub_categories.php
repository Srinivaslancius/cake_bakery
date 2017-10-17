<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
if(!empty($_POST["category_id"])) {
	$query ="SELECT * FROM sub_categories WHERE category_id = '" . $_POST["category_id"] . "'";
	$results = $conn->query($query);
?>
	<option value="">Select Sub Category</option>
<?php
	foreach($results as $subcategory) {
?>
	<option value="<?php echo $subcategory["id"]; ?>"><?php echo $subcategory["sub_category_name"]; ?></option>
<?php
	}
}
?>
