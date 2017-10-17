<?php include_once 'admin_includes/main_header.php'; ?>

<?php 
if (!isset($_POST['submit']))  {
  //If fail
  echo "fail";
} else  {
  //If success
    //Save data into database
    $offer_title = $_POST['offer_title'];
    $offer_products = implode(',',$_POST['offer_products']);
    $status = $_POST['status'];
    $created_at = date("Y-m-d h:i:s");

    //save product images into offer_images table
    $offer_images1 = $_FILES['offer_images']['name'];
    $file_tmp = $_FILES["offer_images"]["tmp_name"];
    $file_destination = '../uploads/offer_images/' . $offer_images1;
    move_uploaded_file($file_tmp, $file_destination);
    $sql1 = "INSERT INTO products_offers (`offer_title`,`offer_products`,`status`,`created_at`,`banner` ) VALUES ('$offer_title','$offer_products','$status','$created_at','$offer_images1')";
    $result1 = $conn->query($sql1);
    $last_id = $conn->insert_id;
    echo $result1;
    if( $result1 == 1){
    echo "<script type='text/javascript'>window.location='product_offers.php?msg=success'</script>";
    } else {
       echo "<script type='text/javascript'>window.location='product_offers.php?msg=fail'</script>";
    }
}
?>
		<div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Product Offers</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Offer Title</label>
                    <input type="text" class="form-control" id="form-control-2" name="offer_title" placeholder="Offer Title" data-error="Please enter offer title." required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-4" class="control-label">Banner</label>
                    <img id="output" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
                    Choose file...
                          <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="offer_images" id="banner"  onchange="loadFile(event)"  multiple="multiple" required >
                      </label>
                  </div>


                  <?php $services = getDataFromTables('products',$status='0',$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);  ?>
                  <label for="form-control-2" class="control-label">Choose your Products</label>
                  <?php while($row = $services->fetch_assoc()) { ?> 
                  <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                      <div class="form-group">
                        <span class="form-control"><input type="checkbox" name="offer_products[]" value="<?php echo $row['product_name'] ?>"/>  <?php echo $row['product_name'] ?></span>
                        <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <?php } ?>
                  
                  <?php $getStatus = getDataFromTables('user_status',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Choose your status</label>
                    <select id="form-control-2" name="status" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Status</option>
                      <?php while($row = $getStatus->fetch_assoc()) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
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
   <script src="js/tables-datatables.min.js"></script>





				          

				          

                  

      
       

      
      

      






