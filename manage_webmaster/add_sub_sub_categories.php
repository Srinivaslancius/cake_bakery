<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
      if (!isset($_POST['submit']))  {
          //If fail
          echo "fail";
        } else  {
            //If success
            //echo "<pre>";print_r($_POST);
            $category_id = $_POST['category_id'];
            $sub_category_id = $_POST['sub_category_id'];
            $sub_sub_category_name = $_POST['sub_sub_category_name'];
            $frame_type = $_POST['frame_type'];
            $fileToUpload = $_FILES["fileToUpload"]["name"];
            //$background_image = $_POST['background_image'];
            $fileToUpload1 = $_FILES['fileToUpload1']["name"];
            $status = $_POST['status'];
            if ($frame_type == '1') {
              if($fileToUpload!='') {

                $target_dir = "../uploads/background_images/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

                $target_dir1 = "../uploads/sub_sub_banner_images/";
                $target_file1 = $target_dir1 . basename($_FILES["fileToUpload1"]["name"]);
                //$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1);
                   $sql = "INSERT INTO `sub_sub_categories` (`category_id`,`sub_category_id`, `sub_sub_category_name`,`frame_type`,`background_image`,`sub_sub_banner_image`,`status`) VALUES ('$category_id','$sub_category_id','$sub_sub_category_name','$frame_type','$fileToUpload','$fileToUpload1','$status')";
                  if($conn->query($sql) === TRUE){
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=success'</script>";
                  } else {
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=fail'</script>";
                  }
                } else {
                      echo "Sorry, there was an error uploading your file.";
                }
              }
              
            } else {
              if($fileToUpload1!='') {

                // $target_dir = "../uploads/background_images/";
                // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

                $target_dir1 = "../uploads/sub_sub_banner_images/";
                $target_file1 = $target_dir1 . basename($_FILES["fileToUpload1"]["name"]);
                //$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1)) {
                  //move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1);
                   $sql = "INSERT INTO `sub_sub_categories` (`category_id`,`sub_category_id`, `sub_sub_category_name`,`frame_type`,`sub_sub_banner_image`,`status`) VALUES ('$category_id','$sub_category_id','$sub_sub_category_name','$frame_type','$fileToUpload1','$status')";
                  if($conn->query($sql) === TRUE){
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=success'</script>";
                  } else {
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=fail'</script>";
                  }
                } else {
                      echo "Sorry, there was an error uploading your file.";
                }
              }
            }
      }
?>
		<div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0"> Sub Sub Categories</h3>
          </div>
          <div class="panel-body">            
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">
                  <?php $getCategories = getDataFromTables('categories','0',$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your Category</label>
                    <select id="form-control-3" name="category_id" class="custom-select" data-error="This field is required." required onChange="getSubCategories(this.value);">
                      <option value="">Select Category</option>
                      <?php while($row = $getCategories->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  
                  <!-- <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your Sub Category</label>
                    <select id="form-control-3" name="sub_category_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Sub Category</option>
                      <?php while($row = $getCategories->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['sub_category_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div> -->

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select Sub Category</label>
                    <select id="sub_category_id" name="sub_category_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Sub Category</option>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Sub Sub Category Name</label>
                    <input type="text" class="form-control" id="form-control-2" name="sub_sub_category_name" placeholder="Sub Sub Category Name" data-error="Please enter Category Name." required>
                    <div class="help-block with-errors"></div>
                  </div>
				          <!-- <div class="form-group">
                    <label for="form-control-4" class="control-label">Sub Category Image</label>
                    <img id="output" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
						          Choose file...
                        <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="fileToUpload" id="fileToUpload"  onchange="loadFile(event)"  multiple="multiple" required >
                      </label>
                  </div> -->

                  <div class="radio">
                        <label>
                          <input name="frame_type" id="frame1" value="1" type="radio" required > Frame1
                        </label>
                        <label>
                          <input name="frame_type" id="frame2" value="2" type="radio" required > Frame2
                        </label>
                  </div>

                  <div class="form-group" id="background_image">
                    <label for="form-control-4" class="control-label">Background Image</label>
                    <img id="output" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
                      Choose file...
                        <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="fileToUpload" id="fileToUpload"  onchange="loadFile(event)"  multiple="multiple" >
                      </label>
                  </div>

                  <div class="form-group">
                    <label for="form-control-4" class="control-label">Sub Sub Banner Image</label>
                    <img id="output1" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
                      Choose file...
                        <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="fileToUpload1" id="fileToUpload1"  onchange="loadFile1(event)"  multiple="multiple" required >
                      </label>
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
      <script type="text/javascript">
          function getSubCategories(val) {
              $.ajax({
              type: "POST",
              url: "get_sub_categories.php",
              data:'category_id='+val,
              success: function(data){
                  $("#sub_category_id").html(data);
              }
              });
          }
      </script>
      <script type="text/javascript">
        $(document).ready(function () {
          $("input[name='frame_type']").click(function () {
            if ($("#frame1").is(":checked")) {
                $("#background_image").show();
            } else {
                $("#background_image").hide();
            }
          });
        });
      </script>
