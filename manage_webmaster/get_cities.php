<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
if(!empty($_POST["state_id"])) {
	$query ="SELECT * FROM lkp_cities WHERE lkp_state_id = '" . $_POST["state_id"] . "'";
	$results = $conn->query($query);
?>
	<option value="">Select City</option>
<?php
	foreach($results as $city) {
?>
	<option value="<?php echo $city["id"]; ?>"><?php echo $city["city_name"]; ?></option>
<?php
	}
}
?>
