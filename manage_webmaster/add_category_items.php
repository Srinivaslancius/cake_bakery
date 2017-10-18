<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
  if (!isset($_POST['submit']))  {
      echo "fail";
  } else  {
      //If success
      $item_name = $_POST['item_name'];                                   
      $status = $_POST['status'];                                                    
      $sql = "INSERT INTO category_items (`item_name`,`status`) VALUES ('$item_name','$status')";
      if($conn->query($sql) === TRUE){
         echo "<script type='text/javascript'>window.location='category_items.php?msg=success'</script>";
      } else {
         echo "<script type='text/javascript'>window.location='category_items.php?msg=fail'</script>";
      }
  }
?>

      <div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Category Items</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="POST">
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Item Name</label>
                    <input type="text" name="item_name" class="form-control" id="item_name" placeholder="Item Name" data-error="Please enter Name" required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <?php $getStatus = getDataFromTables('user_status',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your status</label>
                    <select id="form-control-3" name="status" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Status</option>
                      <?php while($row = $getStatus->fetch_assoc()) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                
                  <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
                </form>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
  
<?php include_once 'admin_includes/footer.php'; ?>
    
