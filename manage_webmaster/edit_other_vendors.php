<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
$id = $_GET['id'];
 if (!isset($_POST['submit']))  {
        echo "";
    } else  {
    //Save data into database
    $vendor_id = $_POST['vendor_id'];
    $category_id = $_POST['category_id'];
    $item_weight = $_POST['item_weight'];
    $price = $_POST['price'];
    $item_name  = $_POST['item_name'];
    $date = date_create($_POST['created_date']);
    $created_date = date_format($date,"Y-m-d");
    $status = $_POST['status'];
      $sql = "UPDATE vendor_vegitables_assign SET vendor_id = '$vendor_id',category_id = '$category_id',item_weight = '$item_weight',price = '$price',item_name = '$item_name',created_date = '$created_date',status = '$status' WHERE id='$id'";
      if($conn->query($sql) === TRUE) {
         echo "<script type='text/javascript'>window.location='other_vendors.php?msg=success'</script>";
      }else {
         echo "<script type='text/javascript'>window.location='other_vendors.php?msg=fail'</script>";
    }     
}
?>
	<div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Other Vendors</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">

                  <?php $getVendors = getAllDataCheckActiveRecords('vendors',0);
                  $getOtherVendors = getDataFromTables('vendor_vegitables_assign','0','id',$id,$activeStatus=NULL,$activeTop=NULL); $getOtherVendors1 = $getOtherVendors->fetch_assoc(); 
                  ?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose Vendor</label>
                    <select id="form-control-3" name="vendor_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select vendor</option>
                      <?php while($row = $getVendors->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getOtherVendors1['vendor_id']) { echo "selected=selected"; }?>><?php echo $row['vendor_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <?php $getCategories = getAllDataCheckActiveRecords('categories',0);
                  ?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose Category</label>
                    <select id="form-control-3" name="category_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Category</option>
                      <?php while($row = $getCategories->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getOtherVendors1['category_id']) { echo "selected=selected"; }?>><?php echo $row['category_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <?php $getCategoryItems = getAllDataCheckActiveRecords('category_items',0);
                  ?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose Item</label>
                    <select id="form-control-3" name="item_name" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Item</option>
                      <?php while($row = $getCategoryItems->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getOtherVendors1['item_name']) { echo "selected=selected"; }?>><?php echo $row['item_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Item Weight</label>
                    <input type="text" class="form-control" id="item_weight" name="item_weight" placeholder="Item Weight" data-error="Please enter item weight." required value="<?php echo $getOtherVendors1['item_weight'];?>">
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" data-error="Please enter price." required value="<?php echo $getOtherVendors1['price'];?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Created Date</label>
                    <input type="text" class="form-control" id="created_date" name="created_date" placeholder="Created Date" data-error="Please enter Created Date." required value="<?php echo $getOtherVendors1['created_date'];?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <?php $getStatus = getDataFromTables('user_status',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your status</label>
                    <select id="form-control-3" name="status" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Status</option>
                      <?php while($row = $getStatus->fetch_assoc()) {  ?>
                          <option <?php if($row['id'] == $getOtherVendors1['status']) { echo "Selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
                      <?php } ?>
                   </select>
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