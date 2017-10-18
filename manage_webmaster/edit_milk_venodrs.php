<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
$id = $_GET['id'];
 if (!isset($_POST['submit']))  {
        echo "";
    } else  {
    //Save data into database
    
    $vendor_id = $_POST['vendor_id'];
    $price = $_POST['price'];
    $milk_in_ltrs  = $_POST['milk_in_ltrs'];
    $date = date_create($_POST['created_date']);
    $created_date = date_format($date,"Y-m-d");
        $sql = "UPDATE vendor_milk_assign SET vendor_id = '$vendor_id',price = '$price',milk_in_ltrs = '$milk_in_ltrs',created_date = '$created_date' WHERE id='$id'";
        if($conn->query($sql) === TRUE) {
           echo "<script type='text/javascript'>window.location='milk_vendors.php?msg=success'</script>";
        }else {
           echo "<script type='text/javascript'>window.location='milk_vendors.php?msg=fail'</script>";
    }
     
}
?>
	<div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Milk Vendors</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">

                  <?php $getVendors = getAllDataCheckActiveRecords('vendors',0);
                  $getMilkVendors = getDataFromTables('vendor_milk_assign',$status=NULL,'id',$id,$activeStatus=NULL,$activeTop=NULL); $getMilkVendors1 = $getMilkVendors->fetch_assoc(); 
                  ?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose Vendor</label>
                    <select id="form-control-3" name="vendor_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select vendor</option>
                      <?php while($row = $getVendors->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getMilkVendors1['vendor_id']) { echo "selected=selected"; }?>><?php echo $row['vendor_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Milk in Ltrs</label>
                    <input type="text" class="form-control" id="milk_in_ltrs" name="milk_in_ltrs" placeholder="Milk in ltrs" data-error="Please enter Milk in Ltrs." value="<?php echo $getMilkVendors1['milk_in_ltrs'];?>"  required onkeypress="return isNumberKey(event)">
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" data-error="Please enter Price." value="<?php echo $getMilkVendors1['price'];?>"  required >
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Created Date</label>
                    <input type="text" class="form-control" id="created_date" name="created_date" placeholder="Created Date" data-error="Please enter Created Date." required value="<?php echo $getMilkVendors1['created_date'];?>">
                    <div class="help-block with-errors"></div>
                  </div>

                  <button type="submit" name="submit" value="Submit"  class="btn btn-primary btn-block">Submit</button>
                </form>
              </div>
            </div>
            <hr>
          </div>
        </div>
    </div>
    <?php include_once 'admin_includes/footer.php'; ?>
    <!--Script allowed only numeric values-->
	<script type="text/javascript">
	function isNumberKey(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	} 
	</script>
