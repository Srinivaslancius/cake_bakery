<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
error_reporting(0);
$id = $_GET['oid'];
 if (!isset($_POST['submit']))  {
            echo "";
    } else  {            

            $order_id = $_POST['order_id'];            
            $order_status = $_POST['order_status'];
            if($order_status==1) {
                $checkStatus = 'Pending';
            } else if($order_status==2){
                $checkStatus = 'Delivered';
            } else {
                $checkStatus = 'Cancelled';
            }            
            $mobile = $_POST['mobile'];
            $sql = "UPDATE `orders` SET order_status = '$order_status' WHERE order_id = '$order_id' ";
            if($conn->query($sql) === TRUE){
                //$message = urlencode('Your Order Was Successfully ' .$checkStatus); // Message text required to deliver on mobile number
                //$sendSMS = sendMobileOTP($message,$mobile);
               echo "<script type='text/javascript'>window.location='orders.php?msg=success'</script>";
            } else {
               echo "<script type='text/javascript'>window.location='orders.php?msg=fail'</script>";
            }
        }
?>
<div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Orders</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <?php $getOrders = getDataFromTables('orders',$status=NULL,'id',$id,$activeStatus=NULL,$activeTop=NULL);
              $getOrders1 = $getOrders->fetch_assoc(); ?>
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="POST">
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Order Id</label>
                    <input type="text" readonly name="order_id" class="form-control" id="form-control-2" placeholder="order_id" data-error="Please enter Name" required value="<?php echo $getOrders1['order_id'];?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your status</label>
                    <select id="form-control-3" name="order_status" class="custom-select" data-error="This field is required." required>
                      <option value="" disabled selected>Choose your status</option>
                      <option value="1" <?php if($getOrders1['order_status'] == 1) { echo "Selected"; }?>>Pending</option>
                      <option value="2" <?php if($getOrders1['order_status'] == 2) { echo "Selected"; }?>>Completed</option>
                      <option value="3" <?php if($getOrders1['order_status'] == 3) { echo "Selected"; }?>>Cancelled</option>
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