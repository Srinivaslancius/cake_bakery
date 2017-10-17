<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
if(!empty($_POST["city_id"])) {
	$query ="SELECT * FROM lkp_locations WHERE lkp_city_id = '" . $_POST["city_id"] . "'";
	$results = $conn->query($query);
?>
	<option value="">Select Location</option>
<?php
	foreach($results as $location) {
?>
	<option value="<?php echo $location["id"]; ?>"><?php echo $location["location_name"]; ?></option>
<?php
	}
}
?>
