<?php include_once 'admin_includes/main_header.php'; ?>
<?php
error_reporting(0);
$id = $_GET['id'];
 if (!isset($_POST['submit']))  {
    echo " ";
    } else  {
      $user_id = $_POST['user_id'];
      $product_id = $_POST['product_id'];
      $total_ltr = $_POST['total_ltr'];
      $price_per_ltr = $_POST['price_ltr'];
      $total_ltr_price = $_POST['total_ltr_price'];
      $date = date_create($_POST['start_date']);
      $start_date = date_format($date,"Y-m-d");
      $date = date_create($_POST['end_date']);
      $end_date = date_format($date,"Y-m-d");
      $created_at = date("Y-m-d h:i:s");
      $sql = "UPDATE `milk_orders` SET user_id='$user_id', product_id='$product_id', total_ltr='$total_ltr', price_ltr='$price_per_ltr', total_ltr_price='$total_ltr_price',start_date = '$start_date', end_date='$end_date' WHERE id = '$id' ";
      if($conn->query($sql) === TRUE){
         echo "<script type='text/javascript'>window.location='milk_orders.php?msg=success'</script>";
      } else {
         echo "<script type='text/javascript'>window.location='milk_orders.php?msg=fail'</script>";
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

                  <?php $getUserData = getAllDataCheckActiveRecords('users',0);
                  $getMilkOrderUsers = getDataFromTables('milk_orders',$status=NULL,'id',$id,$activeStatus=NULL,$activeTop=NULL); $getMilkOrderUsers1 = $getMilkOrderUsers->fetch_assoc();

                  $getProductsData = getAllDataCheckActiveRecords('products',0);
                  $getMilkOrderProducts = getDataFromTables('milk_orders',$status=NULL,'id',$id,$activeStatus=NULL,$activeTop=NULL); $getMilkOrderProducts1 = $getMilkOrderProducts->fetch_assoc(); 
                  ?>
                  <?php $getTotalLtrsData = getDataFromTables('milk_orders',$status=NULL,'id',$id,$activeStatus=NULL,$activeTop=NULL);
                  $getTotalLtrsData1 = $getTotalLtrsData->fetch_assoc();
                ?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose User</label>
                    <select id="user_id" name="user_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select User</option>
                      <?php while($row = $getUserData->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getMilkOrderUsers1['user_id']) { echo "selected=selected"; }?>><?php echo $row['user_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose Product</label>
                    <select id="form-control-3" name="product_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Product</option>
                      <?php while($row = $getProductsData->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getMilkOrderProducts1['product_id']) { echo "selected=selected"; }?>><?php echo $row['product_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Total Ltrs</label>
                    <input type="text" class="form-control" id="total_ltr" name="total_ltr" placeholder="Total ltrs" data-error="Please enter Milk in Ltrs." required value="<?php echo $getTotalLtrsData1['total_ltr']; ?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Price per Ltr</label>
                    <input type="text" class="form-control" id="price_ltr" name="price_ltr" placeholder="Price per Ltr" data-error="Please enter Milk in Ltrs." required value="<?php echo $getTotalLtrsData1['price_ltr']; ?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Total Price per Ltr</label>
                    <input type="text" class="form-control" id="total_ltr_price" name="total_ltr_price" placeholder="Total Price per Ltr" data-error="Please enter Milk in Ltrs." readonly required value="<?php echo $getTotalLtrsData1['total_ltr_price']; ?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Start Date</label>
                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date" data-error="Please enter Start Date." required value="<?php echo $getTotalLtrsData1['start_date']; ?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">End Date</label>
                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date" data-error="Please enter End Date." required value="<?php echo $getTotalLtrsData1['end_date']; ?>">
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
      $(document).ready(function() {
      //End date should be greater than Start date
        $("#end_date").change(function () {
            var startDate = document.getElementById("start_date").value;
            if ($('#start_date').val()=='') {
            alert("Please Enter Start date");
            document.getElementById("end_date").value = "";
        };
            var endDate = document.getElementById("end_date").value;
         
            if ((Date.parse(endDate) <= Date.parse(startDate))) {
                alert("End date should be greater than Start date");
                document.getElementById("end_date").value = "";
            }
        });
      });
        $('#price_ltr').on('keyup', function(){
            if($('#total_ltr').val()!='') {
                var total = 0.00;
                var total_ltr = parseInt($('#total_ltr').val());
                var price_ltr = parseInt($('#price_ltr').val());
                total += parseFloat(price_ltr*total_ltr);
                textbox3= $("#total_ltr_price").val((total).toFixed(2));
            } else {
                alert("Please Enter total Ltrs");
                $('#price_ltr').val('');
                $('#total_ltr_price').val('');
            }
        });
        //Script allowed only numeric value
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>