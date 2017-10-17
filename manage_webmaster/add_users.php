<?php include_once 'admin_includes/main_header.php'; ?>
<?php 
  error_reporting(0);
  if (!isset($_POST['submit']))  {
    //If fail
    echo "fail";
  } else  { 
      // //If success
      $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_mobile = $_POST['user_mobile'];
    $user_country_id = $_POST['user_country_id'];
    $user_state_id = $_POST['user_state_id'];
    $user_city_id = $_POST['user_city_id'];
    $user_location_id = $_POST['user_location_id'];
    $user_password = encryptPassword($_POST['user_password']);
    $user_address = $_POST['user_address'];
    $created_admin_id = $_SESSION['admin_user_id'];
    $created_at = date("Y-m-d h:i:s");
      $sql = "INSERT INTO users (`user_name`, `user_email`, `user_mobile`, `user_country_id`, `user_state_id`, `user_city_id`, `user_location_id`, `user_password`, `user_address`,`created_admin_id`, `created_at`, `status`) VALUES ('$user_name', '$user_email', '$user_mobile', '$user_country_id', '$user_state_id', '$user_city_id', '$user_location_id', '$user_password', '$user_address', '$created_admin_id', '$created_at', 1)";
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
                <form data-toggle="validator" method="POST">
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Name</label>
                    <input type="text" name="user_name" class="form-control" id="form-control-2" placeholder="User Name" data-error="Please enter Name" required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Email</label>
                    <input type="email" name="user_email" class="form-control" id="user_email" placeholder="Email" data-error="Please enter valid email address." required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Password</label>
                    <input type="password" name="user_password" class="form-control" id="form-control-2" placeholder="Password" data-error="Please enter Password." required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Mobile</label>
                    <input type="text" name="user_mobile" class="form-control" id="form-control-2" placeholder="Mobile" data-error="Please enter mobile number." required maxlength="10" pattern="[0-9]{10}" onkeypress="return isNumberKey(event)">
                    <div class="help-block with-errors"></div>
                  </div>

                  <?php $getCountries = getDataFromTables('lkp_countries',$status='0',$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select Country</label>
                    <select id="user_country_id" name="user_country_id" class="custom-select" data-error="This field is required." required onChange="getState(this.value);">
                      <option value="">Select Country</option>
                      <?php while($row = $getCountries->fetch_assoc()) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['country_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select State</label>
                    <select id="user_state_id" name="user_state_id" class="custom-select" data-error="This field is required." required onChange="getCities(this.value);">
                      <option value="">Select Country</option>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select City</label>
                    <select id="user_city_id" name="user_city_id" class="custom-select" data-error="This field is required." required onChange="getLocations(this.value);">
                      <option value="">Select City</option>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select Location</label>
                    <select id="user_location_id" name="user_location_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Location</option>
                   </select>
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

                  <div class="form-group">
                    <label for="form-control-4" class="control-label">Address</label>
                    <textarea type="text" name="user_address" class="form-control" id="form-control-2" placeholder="Address" data-error="This field is required." required></textarea>
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
<script type="text/javascript">
function getState(val) {
    $.ajax({
    type: "POST",
    url: "get_state.php",
    data:'country_id='+val,
    success: function(data){
        $("#user_state_id").html(data);
    }
    });
}

function getCities(val) { 
    $.ajax({
    type: "POST",
    url: "get_cities.php",
    data:'state_id='+val,
    success: function(data){
        $("#user_city_id").html(data);
    }
    });
}

function getLocations(val) { 
    $.ajax({
    type: "POST",
    url: "get_locations.php",
    data:'city_id='+val,
    success: function(data){
        $("#user_location_id").html(data);
    }
    });
}
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
  function checkemail() {
    var email1 = document.getElementById("user_email").value;
    if (email1){
      $.ajax({
      type: "POST",
      url: "check_email_avail.php",
      data: {
        user_email:email1,
      },
      success: function (response) {
        $( '#email_status' ).html(response);
        if (response == "Email Already Exist"){
          $("#user_email").val("");
        }
        }
       });
    }
  }
</script>