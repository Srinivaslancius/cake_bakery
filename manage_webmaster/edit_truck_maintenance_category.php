<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
$id = $_GET['id'];
if (!isset($_POST['submit']))  {
    echo "fail";
} else {
    //Save data into database
    $maintance_category_name = $_POST['maintance_category_name'];
    $price = $_POST['price'];
    $date = date_create($_POST['date']);
    $date1 = date_format($date,"Y-m-d");
    $description = $_POST['description'];
    
    $sql = "UPDATE `truck_maintance` SET maintance_category_name = '$maintance_category_name', price='$price', date='$date1', description='$description' WHERE id = '$id' ";
    if($conn->query($sql) === TRUE) {
      echo "<script type='text/javascript'>window.location='truck_maintenance_category.php?msg=success'</script>";
    }else {
      echo "<script type='text/javascript'>window.location='truck_maintenance_category.php?msg=fail'</script>";
    }
     
}
?>
      <div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Truck Maintenance</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">
                  <?php 
                    $getMaintanceData = getAllData('maintance_category');  
                  ?>
                  <?php $getMaintanceCategoryItems = getIndividualDetails($id,'truck_maintance','id');?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose Category</label>
                    <select id="form-control-3" name="maintance_category_name" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Item</option>
                      <?php while($row = $getMaintanceData->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getMaintanceCategoryItems['maintance_category_name']) { echo "selected=selected"; }?>><?php echo $row['title']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price" data-error="Please enter price." required value="<?php echo $getMaintanceCategoryItems['price'];?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Created Date</label>
                    <input type="text" class="form-control" id="date" name="date" placeholder="Created Date" data-error="Please enter Created Date." required value="<?php echo $getMaintanceCategoryItems['date'];?>">
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Description</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Description" data-error="This field is required." required><?php echo $getMaintanceCategoryItems['description'];?></textarea>
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
      <!-- Below script for ck editor -->
      <script src="//cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>
      <script>
          CKEDITOR.replace( 'description' ); 
      </script>
      <style type="text/css">
          .cke_top, .cke_contents, .cke_bottom {
              border: 1px solid #333;
          }
      </style>