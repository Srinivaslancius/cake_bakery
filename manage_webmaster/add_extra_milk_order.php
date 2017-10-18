<?php include_once 'admin_includes/main_header.php'; ?>
<?php 
if (!isset($_POST['submit']))  {
    echo " ";
} else  {
        //echo "<pre>"; print_r($_POST); die;
        $user_id = $_POST['user_id'];
        $product_id = $_POST['product_id'];
        $total_ltr = $_POST['total_ltr'];
        $extra_ltr = $_POST['extra_ltr'];
        $date = date_create($_POST['order_date']);
        $order_date = date_format($date,"Y-m-d");            
        $created_at = date("Y-m-d h:i:s");          
        //$status = $_POST['status'];                                           
        $sql = "INSERT INTO extra_milk_orders (`user_id`, `product_id`, `total_ltr`, `extra_ltr`, `order_date`, `created_at`) VALUES ('$user_id','$product_id', '$total_ltr','$extra_ltr', '$order_date', '$created_at')";
        if($conn->query($sql) === TRUE){
            echo "<script type='text/javascript'>window.location='extra_milk_orders.php?msg=success'</script>";
        } else {
            echo "<script type='text/javascript'>window.location='extra_milk_orders.php?msg=fail'</script>";
        }           
    }
?>
    <div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Milk Orders</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">

                  <?php $getUserData = getAllDataCheckActiveRecords('users','0');
                        $getProductData = getAllDataCheckActiveRecords('products','0');
                        $sql = "SELECT users.id,users.user_name FROM milk_orders LEFT JOIN users ON milk_orders.user_id=users.id GROUP BY milk_orders.user_id";
                        $result = $conn->query($sql);
                  ?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose User</label>
                    <select id="user_id" name="user_id" class="get_total_milk_ltrs custom-select" data-error="This field is required." required>
                      <option value="">Select User</option>
                      <?php while($getUser = $result->fetch_assoc()) { ?> 
                        <option value="<?php echo $getUser['id']; ?>"><?php echo $getUser['user_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose Product</label>
                    <select id="form-control-3" name="product_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Product</option>
                      <?php while($row = $getProductData->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Total Ltrs</label>
                    <input type="text" class="form-control" id="total_ltr" name="total_ltr" placeholder="Total ltrs" data-error="Please enter Milk in Ltrs." required readonly>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Extra Ltrs</label>
                    <input type="text" class="form-control" id="extra_ltr" name="extra_ltr" placeholder="Extra ltrs" data-error="Please enter Milk in Ltrs." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Order Date</label>
                    <input type="text" class="form-control" id="order_date1" name="order_date" placeholder="Order Date" data-error="Please enter Order Date." required>
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
    <script type="text/javascript">
        $('.get_total_milk_ltrs').change(function() {
            var selectUserId = $(this).val();
            if(selectUserId != '') {
                $.ajax({
                    type: 'POST',
                    url: 'get_total_milkltr.php',
                    dataType: 'json',
                    data: { 'user_id' : selectUserId },
                    success : function(result){
                        if(result!=0){
                            $('#total_ltr').val(result);
                        } else {
                            alert("Please Select Valid User");
                            $('#total_ltr').val('');
                        }
                    }
                });
            }
        });
    </script>
    <script type="text/javascript">
      $( function() {
          $('#order_date1').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, stepMonths: 0 });
      });
    </script>