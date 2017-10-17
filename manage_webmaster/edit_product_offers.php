<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
$id = $_GET['uid'];
if (!isset($_POST['submit']))  {
  //If fail
  echo "fail";
} else  {
  //If success
    //echo "<pre>"; print_r($_POST); die;
    //Save data into database
    $offer_title = $_POST['offer_title'];
    $offer_products = implode(',',$_POST['offer_products']);
    $status = $_POST['status'];
    $created_at = date("Y-m-d h:i:s");


    //save product images into offer_images table
    $offer_images1 = $_FILES['offer_images']['name'];
    if($offer_images1 !='') {
      $target_dir = "../uploads/offer_images/";
      $target_file = $target_dir . basename($_FILES["offer_images"]["name"]);
      $getImgUnlink = getImageUnlink('banner','products_offers','id',$id,$target_dir);
      if(move_uploaded_file($_FILES["offer_images"]["tmp_name"], $target_file)){
        
        $sql1 = "UPDATE products_offers SET offer_title = '$offer_title', offer_products ='$offer_products',status = '$status',banner = '$offer_images1' WHERE id = '$id'";
        
          if ($conn->query($sql1) === TRUE) {
            echo "<script type='text/javascript'>window.location='product_offers.php?msg=success'</script>";
          } else {
            echo "<script type='text/javascript'>window.location='product_offers.php?msg=fail'</script>";
          }
      }else{
        echo "Sorry, there was an error uploading your file.";
      }
    } else {
     $sql1 = "UPDATE products_offers SET offer_title = '$offer_title',offer_products ='$offer_products',status = '$status'WHERE id = '$id'"; 
     if ($conn->query($sql1) === TRUE) {
      echo "<script type='text/javascript'>window.location='products_offers.php?msg=success'</script>";
    } else {
      echo "<script type='text/javascript'>window.location='products_offers.php?msg=fail'</script>";
    }
  }
}
?>

<?php $getProductOffersData = getDataFromTables('products_offers',$status=NULL,'id',$id,$activeStatus=NULL,$activeTop=NULL);
$getProductOffers = $getProductOffersData->fetch_assoc();
?>
      <div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">product Offers</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Offer Title</label>
                    <input type="text" class="form-control" id="form-control-2" name="offer_title" data-error="Please enter product name." required value="<?php echo $getProductOffers['offer_title']; ?>">
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-4" class="control-label">Product Image</label>
                    <img src="<?php echo $base_url . 'uploads/offer_images/'.$getProductOffers['banner'] ?>"  id="output" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
                      Choose file...
                      <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="offer_images" id="banner"  onchange="loadFile(event)"  multiple="multiple" >
                    </label>
                  </div>

                  <?php $services = getDataFromTables('products',$status='0',$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);  ?>
                  <label for="form-control-2" class="control-label">Choose your Products</label>
                  <?php while($row = $services->fetch_assoc()) { ?> 
                  <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                      <div class="form-group">
                        <span class="form-control"><input type="checkbox" name="offer_products[]" value="<?php echo $row['product_name'] ?>"/> <?php if($row['product_name'] == $getProductOffers['offer_products']) { echo "checked=checked"; }?> <?php echo $row['product_name'] ?></span>
                        <div class="help-block with-errors"></div>
                      </div>
                  </div>
                  <?php } ?>

                  <?php $getStatus = getDataFromTables('user_status',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your status</label>
                    <select id="form-control-3" name="status" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Status</option>
                      <?php while($row = $getStatus->fetch_assoc()) {  ?>
                          <option <?php if($row['id'] == $getProductOffers['status']) { echo "Selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
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













                  




                      

                  
