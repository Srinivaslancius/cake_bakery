<?php include_once 'admin_includes/main_header.php'; ?>
<?php  
$id = $_GET['pid'];
if (!isset($_POST['submit']))  {
            echo "";
} else  {
    
    //Save data into database
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $product_info = $_POST['product_info'];
    $status = $_POST['status'];
    //save product images into product_images table    
    $sql1 = "UPDATE products SET product_name = '$product_name',category_id ='$category_id', product_info = '$product_info', status = '$status' WHERE id = '$id'"; 
    
    if ($conn->query($sql1) === TRUE) {
    echo "Record updated successfully";
    } else {
    echo "Error updating record: " . $conn->error;
    }
    $result1=$conn->query($sql1);

    //Delete weight and prices
    $del = "DELETE FROM product_weight_prices WHERE product_id = '$id' ";
    $result = $conn->query($del);

    $product_weights = $_REQUEST['weight_type_id'];
    foreach($product_weights as $key=>$value){

        $product_weights1 = $_REQUEST['weight_type_id'][$key];
        $price = $_REQUEST['price'][$key];      
        $sql = "INSERT INTO product_weight_prices ( `product_id`,`weight_type_id`,`price`) VALUES ('$id','$product_weights1','$price')";
        $result = $conn->query($sql);
    }

    $product_images = $_FILES['product_images']['name'];
    foreach($product_images as $key=>$value){

        $product_images1 = $_FILES['product_images']['name'][$key];
        $file_tmp = $_FILES["product_images"]["tmp_name"][$key];
        $file_destination = '../uploads/product_images/' . $product_images1;
        if($product_images1!=''){
            move_uploaded_file($file_tmp, $file_destination);        
            $sql = "INSERT INTO product_images ( `product_id`,`product_image`) VALUES ('$id','$product_images1')";
            $result = $conn->query($sql);
        }        
    }
     
     if($result1==1){
        echo "<script type='text/javascript'>window.location='products.php?msg=success'</script>";
    } else {
        echo "<script type='text/javascript'>window.location='products.php?msg=fail'</script>";
    }
}
?>

      <div class="site-content">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="m-y-0">Products</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <?php $getProductsData = getDataFromTables('products','0','id',$id,$activeStatus=NULL,$activeTop=NULL);
                $getProducts = $getProductsData->fetch_assoc();
                $getCategories = getDataFromTables('categories','0',$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);
                ?>
                
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <form data-toggle="validator" method="post" enctype="multipart/form-data">

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your Category</label>
                    <select id="form-control-3" name="category_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Category</option>
                      <?php while($row = $getCategories->fetch_assoc()) {  ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $getProducts['category_id']) { echo "selected=selected"; }?> ><?php echo $row['category_name']; ?></option>
                    <?php } ?>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Product Name</label>
                    <input type="text" class="form-control" id="form-control-2" name="product_name" data-error="Please enter product name." required value="<?php echo $getProducts['product_name']; ?>">
                    <div class="help-block with-errors"></div>
                  </div>
                  <?php $id = $_GET['pid'];
                    $sql2 = "SELECT * FROM product_weight_prices where product_id = '$id'";
                    $result2 = $conn->query($sql2);
                ?>
                <div>

                    <?php while($row2 = $result2->fetch_assoc()) { ?>
                        <div class="input-field form-group col-md-6">                          
                            <?php $result = getDataFromTables('product_weights',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL); ?>                                                
                            <select name="weight_type_id[]" required id="form-control-3" class="custom-select" data-error="This field is required." required>
                                <?php while($row = $result->fetch_assoc()) { ?>
                                <?php $getTermName = getDataFromTables('product_weights',$status=NULL,$clause=NULL,$row2['weight_type_id'],$activeStatus=NULL,$activeTop=NULL); ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $row2['weight_type_id']) { echo "Selected"; } ?>><?php echo $row['weight_type']; ?></option>
                                <?php } ?>
                            </select>  
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6">                         
                          <input type="text" class="form-control" id="form-control-2" name="price[]" required onkeypress="return isNumberKey(event)" data-error="Please enter product name." required value="<?php echo $row2['price']; ?>">
                          <div class="help-block with-errors"></div>
                        </div>                       
                    <?php } ?>

                  <div class="input-field col s4">
                     <a href="javascript:void(0);"  ><img src="add-icon.png" onkeypress="return isNumberKey(event)" onclick="addInput('dynamicInput');" /></a>
                  </div>
                  <div id="dynamicInput" class="input-field col s12"></div>
                 
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Product Info</label>
                    <textarea name="product_info" class="form-control" id="product_info" placeholder="Product Info" data-error="This field is required." required value="<?php echo $getProducts['product_info']; ?>"><?php echo $getProducts['product_info']; ?></textarea>
                    <div class="help-block with-errors"></div>
                  </div>
                
                  <div class="form-group">
                      <?php  $pid = $_GET['pid'];                                                           
                      $sql = "SELECT id,product_image FROM product_images where product_id = '$pid' ";
                      $getImages= $conn->query($sql);                                                             
                      while($row=$getImages->fetch_assoc()) {
                          echo "<img id='output' src= '../uploads/product_images/".$row['product_image']."' width=80px; height=80px;/> <a style='cursor:pointer' class='ajax_img_del' id=".$row['id'].">Delete</a> <br />";
                      }                               
                     ?>
                  </div>
                  <div class="form-group">
                    <label for="form-control-4" class="control-label">Product Image</label>
                    <div>
                      <?php if($getImages->num_rows > 0){ ?>
                        <input type="file" name="product_images[]" accept="image/*" >
                      <?php } else { ?>
                      <label class="btn btn-default file-upload-btn">
                          Choose File...
                        <input type="file" name="product_images[]" accept="image/*" required >
                      </label>
                      <?php } ?>
                      <a style="cursor:pointer" id="add_more" class="add_field_button">Add More Fields</a>
                    </div>
                  </div>

                  <?php $getStatus = getDataFromTables('user_status',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Choose your status</label>
                    <select id="form-control-3" name="status" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Status</option>
                      <?php while($row = $getStatus->fetch_assoc()) {  ?>
                          <option <?php if($row['id'] == $getProducts['status']) { echo "Selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
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
      <script src="//cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>
      <script>          
          CKEDITOR.replace( 'product_info' );           
      </script>
<?php
    $sql1 = "SELECT * FROM product_weights where status = '0'";
    $result1 = $conn->query($sql1);                                    
?>

<?php while($row = $result1->fetch_assoc()) { 
   $choices1[] = $row['id'];
   $choices_names[] = $row['weight_type'];
} ?>


<script type="text/javascript">

function addInput(divName) {
    var choices = <?php echo json_encode($choices1); ?>; 
    var choices_names = <?php echo json_encode($choices_names); ?>;      
    var newDiv = document.createElement('div');
    newDiv.className = 'new_appen_class';
    var selectHTML = "";    
    selectHTML="<div class='input-field form-group col-md-6'><select required name='weight_type_id[]' id='form-control-3' class='custom-select' style='display:block !important'><option value=''>Select Weighy Type</option>";
    var newTextBox = "<div class='form-group col-md-4'><input type='text' onkeypress='return isNumberKey(event)' onclick='addInput('dynamicInput');' required name='price[]' class='form-control' id='form-control-2' placeholder='Price'></div>";
    removeBox="<div class='input-field  form-group col-md-2'><a class='remove_button' ><img src='remove-icon.png'/></a></div><div class='clearfix'></div>";
    for(i = 0; i < choices.length; i = i + 1) {
        selectHTML += "<option value='" + choices[i] + "'>" + choices_names[i] + "</option>";
    }
    selectHTML += "</select></div>";
    newDiv.innerHTML = selectHTML+ " &nbsp;" +newTextBox +" "+ removeBox;
    document.getElementById(divName).appendChild(newDiv);
}

$(document).ready(function() {
    $(dynamicInput).on("click",".remove_button", function(e){ //user click on remove text
        e.preventDefault();
        $(this).parent().parent().remove();
    })
    var abc = 0;
    $('#add_more').click(function () {
        $(this).before("<div><input type='file' id='file' name='product_images[]' accept='image/*' required><a href='#' class='remove_field'>Remove</a> </div>");
    });
    $(this).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
//Multilpe Images Preview script end here
</script>

<script type="text/javascript">
$(function(){
    $(document).on('click','.ajax_img_del',function(){
        var del_id= $(this).attr('id');
        var $ele = $(this).parent().parent();
        var del_confirm = confirm("Are you sure you want to delete?");
        if(del_confirm == true){
        $.ajax({
            type:'POST',
            url:'delete_image.php',
            data:{'del_id':del_id},
            success: function(data){
                 if(data=="YES"){
                    location.reload();
                 }else{
                    alert("Deleted Failed");  
                 }
             }
        });
        }else{
            location.reload();
         }
    });
});
</script>
<script type="text/javascript">

//Script allowed only numeric value
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
