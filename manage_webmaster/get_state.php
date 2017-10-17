<?php
include_once('admin_includes/config.php');
include_once('admin_includes/common_functions.php');
if(!empty($_POST["country_id"])) {
	$query ="SELECT * FROM lkp_states WHERE lkp_country_id = '" . $_POST["country_id"] . "'";
	$results = $conn->query($query);
?>
	<option value="">Select State</option>
<?php
	foreach($results as $state) {
?>
	<option value="<?php echo $state["id"]; ?>"><?php echo $state["state_name"]; ?></option>
<?php
	}
}
?>