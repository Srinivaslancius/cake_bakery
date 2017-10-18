<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
error_reporting(0);
 if (!isset($_POST['submit'])) {
      //If fail
        echo "fail";
    } else {
    //If success            
      $user_name = $_POST['user_name'];
      $user_email = $_POST['user_email'];
      $user_mobile = $_POST['user_mobile'];
      $street_name = $_POST['street_name'];
      $street_no = $_POST['street_no'];
      $flat_name = $_POST['flat_name'];
      $flat_no = $_POST['flat_no'];
      $location = $_POST['location'];
      $landmark = $_POST['landmark'];
      $pincode = $_POST['pincode'];
      $status = $_POST['status'];
        $sql = "INSERT INTO users (`user_name`, `user_email`,`user_mobile`,`street_name`,`street_no`,`flat_name`,`flat_no`,`location`,`landmark`,`pincode`,`created_admin_id`, `created_at`, `status`) VALUES ('$user_name', '$user_email','$user_mobile','$street_name','$street_no','$flat_name','$flat_no','$location','$landmark','$pincode','$created_admin_id','$created_at', '$status')";
        if($conn->query($sql) === TRUE){
           echo "<script type='text/javascript'>window.location='users.php?msg=success'</script>";
        } else {
           echo "<script type='text/javascript'>window.location='users.php?msg=fail'</script>";
        }
      }
?>
      <div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Users</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="POST" autocomplete="off">
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Name</label>
                    <input type="text" name="user_name" class="form-control" id="form-control-2" placeholder="User Name" data-error="Please enter user name" required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Email</label>
                    <input type="email" name="user_email" class="form-control" id="form-control-2" placeholder="Email" data-error="Please enter a valid email address." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Mobile</label>
                    <input type="text" name="user_mobile" class="form-control" id="user_mobile" placeholder="Mobile" data-error="Please enter mobile number." required maxlength="10" pattern="[0-9]{10}" onkeypress="return isNumberKey(event)" onkeyup="checkMobile()" >
                    <span id="mobile_status" style="color: red;"></span>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Street Name</label>
                    <input type="text" name="street_name" class="form-control" id="form-control-2" placeholder="Street Name" data-error="Please enter street name." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Street Number</label>
                    <input type="text" name="street_no" class="form-control" id="form-control-2" placeholder="Street Name" data-error="Please enter street number." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Flat Name</label>
                    <input type="text" name="flat_name" class="form-control" id="form-control-2" placeholder="Street Name" data-error="Please enter flat name." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">flat Number</label>
                    <input type="text" name="flat_no" class="form-control" id="form-control-2" placeholder="Street Name" data-error="Please enter flat number." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Location</label>
                    <input type="text" name="location" class="form-control" id="form-control-2" placeholder="Location" data-error="Please enter your location." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Landmark</label>
                    <input type="text" name="landmark" class="form-control" id="form-control-2" placeholder="Landmark" data-error="Please enter your landmark." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Pincode</label>
                    <input type="text" name="pincode" class="form-control" id="form-control-2" placeholder="Pincode" data-error="Please enter pincode number." required maxlength="6" onkeypress="return isNumberKey(event)">
                    <div class="help-block with-errors"></div>
                  </div>
                  <?php $getStatus = getDataFromTables('user_status',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your status</label>
                    <select id="form-control-3" name="status" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Status</option>
                      <?php while($row = $getStatus->fetch_assoc()) {  ?>
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
<!--Script for already existed mobile number checking -->
<script>
  function checkMobile() {
      var mobile1 = document.getElementById("user_mobile").value;
      if (mobile1){
        $.ajax({
        type: "POST",
        url: "check_mobile_avail.php",
        data: {
          user_mobile:mobile1,
        },
        success: function (response) {
          $( '#mobile_status' ).html(response);
          if (response == "Mobile Number Already Exist"){
            $("#user_mobile").val("");
          }
          }
         });
      }
    }
</script>