<?php include_once 'admin_includes/main_header.php'; ?>
      <div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Mobile Push notifications</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="POST" autocomplete="off" action="FcmExample/sendMultiplePush.php">
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Title</label>
                    <input type="text" name="title" class="form-control" id="form-control-2" placeholder="Enter Title" data-error="Please Enter Title" required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Message</label>
                    <input type="text" name="message" class="form-control" id="form-control-2" placeholder="Message" data-error="Please enter a message." required>
                    <div class="help-block with-errors"></div>
                  </div>                  
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Image</label>
                    <input type="text" name="image" class="form-control" id="form-control-2" placeholder="Image" value="https://lanciussolutions.com/FcmExample/download.png" >
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