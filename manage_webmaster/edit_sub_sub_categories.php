<?php include_once 'admin_includes/main_header.php'; ?>
<?php
$id = $_GET['bid'];
 if (!isset($_POST['submit']))  {
            echo "fail";
    } else  {
        $category_id = $_POST['category_id'];
        $sub_category_id = $_POST['sub_category_id'];
        $sub_sub_category_name = $_POST['sub_sub_category_name'];
        $frame_type = $_POST['frame_type'];
        $fileToUpload = $_FILES["fileToUpload"]["name"];
        //$background_image = $_POST['background_image'];
        $fileToUpload1 = $_FILES['fileToUpload1']["name"];
        $status = $_POST['status'];

        if ($frame_type == '1') {
          if($_FILES["fileToUpload"]["name"]!='') {
            $fileToUpload = $_FILES["fileToUpload"]["name"];
            $target_dir = "../uploads/background_images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $target_dir1 = "../uploads/sub_sub_banner_images/";
            $target_file1 = $target_dir1 . basename($_FILES["fileToUpload1"]["name"]);
            //$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $getImgUnlink = getImageUnlink('background_image','sub_sub_categories','id',$id,$target_dir);
            $getImgUnlink = getImageUnlink('sub_sub_banner_image','sub_sub_categories','id',$id,$target_dir1);
              //Send parameters for img val,tablename,clause,id,imgpath for image ubnlink from folder
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1);
                  $sql = "UPDATE `sub_sub_categories` SET category_id = '$category_id', sub_category_id = '$sub_category_id',sub_sub_category_name='$sub_sub_category_name',frame_type='$frame_type',background_image = '$fileToUpload', sub_sub_banner_image='$fileToUpload1', status='$status' WHERE id = '$id' ";
                  if($conn->query($sql) === TRUE){
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=success'</script>";
                  } else {
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=fail'</script>";
                  }
                  //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              } else {
                  echo "Sorry, there was an error uploading your file.";
              }
          } else {
              $sql = "UPDATE `sub_sub_categories` SET category_id = '$category_id',sub_category_id = '$sub_category_id',sub_sub_category_name='$sub_sub_category_name',frame_type='$frame_type', status='$status' WHERE id = '$id' ";
              if($conn->query($sql) === TRUE){
                 echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=success'</script>";
              } else {
                 echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=fail'</script>";
            }
          }
        } else {
          if($_FILES["fileToUpload1"]["name"]!='') {
            //$fileToUpload = $_FILES["fileToUpload"]["name"];
            //$target_dir = "../uploads/background_images/";
            //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $target_dir1 = "../uploads/sub_sub_banner_images/";
            $target_file1 = $target_dir1 . basename($_FILES["fileToUpload1"]["name"]);
            //$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            //$getImgUnlink = getImageUnlink('background_image','sub_sub_categories','id',$id,$target_dir);
            $getImgUnlink = getImageUnlink('sub_sub_banner_image','sub_sub_categories','id',$id,$target_dir1);
              //Send parameters for img val,tablename,clause,id,imgpath for image ubnlink from folder
            if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1)) {
                  //move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1);
                  $sql = "UPDATE `sub_sub_categories` SET category_id = '$category_id', sub_category_id = '$sub_category_id',sub_sub_category_name='$sub_sub_category_name',frame_type='$frame_type', sub_sub_banner_image='$fileToUpload1', status='$status' WHERE id = '$id' ";
                  if($conn->query($sql) === TRUE){
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=success'</script>";
                  } else {
                     echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=fail'</script>";
                  }
                  //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              } else {
                  echo "Sorry, there was an error uploading your file.";
              }
          } else {
              $sql = "UPDATE `sub_sub_categories` SET category_id = '$category_id',sub_category_id = '$sub_category_id',sub_sub_category_name='$sub_sub_category_name',frame_type='$frame_type', status='$status' WHERE id = '$id' ";
              if($conn->query($sql) === TRUE){
                 echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=success'</script>";
              } else {
                 echo "<script type='text/javascript'>window.location='sub_sub_categories.php?msg=fail'</script>";
            }
          }
        }

      }
?>
<?php $getSubCategoriesData = getDataFromTables('sub_sub_categories',$status=NULL,'id',$id,$activeStatus=NULL,$activeTop=NULL);
$getSubCategories = $getSubCategoriesData->fetch_assoc();
$getCategories = getDataFromTables('categories','0',$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);

$getsubCategoriesData = getDataFromTables('sub_categories','0',$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);

 ?>
<div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Sub Sub Categories</h3>
          </div>
          <div class="panel-body">            
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your Category</label>
                    <select id="form-control-3" name="category_id" class="custom-select" data-error="This field is required." required onChange="getSubCategories(this.value);">
                      <option value="">Select Category</option>
                      <?php while($row = $getCategories->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getSubCategories['category_id']) { echo "selected=selected"; }?> ><?php echo $row['category_name']; ?></option>
                    <?php } ?>
                    </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select Sub Category</label>
                    <select id="sub_category_id" name="sub_category_id" class="custom-select" data-error="This field is required." required onChange="getSubSubCategories(this.value);">
                       <option value="">Select Sub Category</option>
                      <?php while($row = $getsubCategoriesData->fetch_assoc()) {  ?>
                      <option <?php if($row['id'] == $getSubCategories['sub_category_id']) { echo "Selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['sub_category_name']; ?></option>
                      <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Sub Category Name</label>
                    <input type="text" class="form-control" id="form-control-2" name="sub_sub_category_name" required value="<?php echo $getSubCategories['sub_sub_category_name'];?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <!-- <div class="form-group">
                    <label for="form-control-4" class="control-label">Sub Category Image</label>
                    <img src="<?php echo $base_url . 'uploads/sub_category_images/'.$getSubCategories['sub_category_image'] ?>"  id="output" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
                        Choose file...
                        <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="fileToUpload" id="fileToUpload"  onchange="loadFile(event)"  multiple="multiple" >
                      </label>
                  </div> -->

                  <div class="radio">
                        <label>
                          <input name="frame_type" id="frame1" value="1" type="radio" <?php if($getSubCategories['frame_type']  == 1){ echo "checked=checked"; }?> required> Frame1
                        </label>
                        <label>
                          <input name="frame_type" id="frame2" value="2" type="radio" <?php if($getSubCategories['frame_type']  == 2){ echo "checked=checked"; }?> required> Frame2
                        </label>
                  </div>
                  
                  <div class="form-group" id="background_image">
                    <label for="form-control-4" class="control-label">Background Image</label>   
                    <?php if($getSubCategories['background_image']!=''){ ?>
                      <img src="<?php echo $base_url . 'uploads/background_images/'.$getSubCategories['background_image'] ?>"  id="output" height="100" width="100"/>  
                    <?php } ?>     

                    <label class="btn btn-default file-upload-btn">
                      Choose file...
                        <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="fileToUpload" id="fileToUpload"  onchange="loadFile(event)"  multiple="multiple">
                      </label>
                  </div>
                  
                  <div class="form-group">
                    <label for="form-control-4" class="control-label">Sub Sub Banner Image</label>
                    <img src="<?php echo $base_url . 'uploads/sub_sub_banner_images/'.$getSubCategories['sub_sub_banner_image'] ?>"  id="output1" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
                      Choose file...
                        <input id="form-control-22" class="file-upload-input" type="file" accept="image/*" name="fileToUpload1" id="fileToUpload1"  onchange="loadFile1(event)"  multiple="multiple">
                      </label>
                  </div>
                  
                  <?php $getStatus = getDataFromTables('user_status',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your status</label>
                    <select id="form-control-3" name="status" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Status</option>
                      <?php while($row = $getStatus->fetch_assoc()) {  ?>
                          <option <?php if($row['id'] == $getSubCategories['status']) { echo "Selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
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
          
            if ($("input[type=radio][name='frame_type']:checked").val() == 1) {
                $("#background_image").show();
            } else {
                $("#background_image").hide();
            }
          
          $("input[name='frame_type']").click(function () {            
            if ($("input[type=radio][name='frame_type']:checked").val() == 1) {
                $("#background_image").show();
            } else {
                $("#background_image").hide();
            }
          });

        });
      </script>