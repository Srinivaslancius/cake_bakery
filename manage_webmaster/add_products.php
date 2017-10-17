<?php include_once 'admin_includes/main_header.php'; ?>

<?php 
if (!isset($_POST['submit']))  {
            echo "";
} else  {
    //Save data into database
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    $sub_sub_category_id = $_POST['sub_sub_category_id'];
    $product_price = $_POST['product_price'];
    $price_type = $_POST['price_type'];
    $offer_price = $_POST['offer_price'];
    $selling_price = $_POST['selling_price'];
    $deal_start_date = $_POST['deal_start_date'];
    $deal_end_date = $_POST['deal_end_date'];
    $quantity = $_POST['quantity'];
    $minimum_order_quantity = $_POST['minimum_order_quantity'];
    $key_features = $_POST['key_features'];
    $product_info = $_POST['product_info'];
    $specifications = $_POST['specifications'];
    $availability_id = $_POST['availability_id'];
    $status = $_POST['status'];
    $created_at = date("Y-m-d h:i:s");
    $t = time();
    $created_by = $_SESSION['admin_user_id'];
    //save product images into product_images table    
    
    $sql1 = "INSERT INTO products (`product_name`,`category_id`,`sub_category_id`,`sub_sub_category_id`,`product_price`,`price_type`,`offer_price`,`selling_price`,`quantity`, `minimum_order_quantity`, `key_features`,`product_info`,`specifications`,`availability_id`,`status`,`created_by`,`created_at`) VALUES ('$product_name','$category_id','$sub_category_id','$sub_sub_category_id','$product_price','$price_type','$offer_price','$selling_price','$quantity', '$minimum_order_quantity', '$key_features','$product_info','$specifications','$availability_id','$status','$created_by','$created_at')";
    $result1 = $conn->query($sql1);
    $last_id = $conn->insert_id;

    $product_images = $_FILES['product_images']['name'];
    foreach($product_images as $key=>$value){

        $product_images1 = time().'_'.$_FILES['product_images']['name'][$key];
        $file_tmp = $_FILES["product_images"]["tmp_name"][$key];
        $file_destination = '../uploads/product_images/' . $product_images1;
        move_uploaded_file($file_tmp, $file_destination);        
        $sql = "INSERT INTO product_images ( `product_id`,`product_image`) VALUES ('$last_id','$product_images1')";
        $result = $conn->query($sql);
    }
    
    if( $result1 == 1){
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

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select Sub Category</label>
                    <select id="sub_category_id" name="sub_category_id" class="custom-select" data-error="This field is required." required onChange="getSubSubCategories(this.value);">
                      <option value="">Select Sub Category</option>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select Sub Sub Category</label>
                    <select id="sub_sub_category_id" name="sub_sub_category_id" class="custom-select" data-error="This field is required." required >
                      <option value="">Select Sub Sub Category</option>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" data-error="Please enter product name." required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Product Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Product Price" data-error="Please enter product price." required>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Select Price Type</label>
                    <select id="price_type" name="price_type" class="custom-select" data-error="This field is required." required>
                      <option value="">Select Price Type</option>
                        <option value="1">Price</option>
                        <option value="2">Percentage</option>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Discount Price</label>
                    <input type="text" class="form-control" id="offer_price" name="offer_price" placeholder="Product Price" data-error="Please enter product price." required onkeypress="return isNumberKey(event)">
                    <div class="help-block with-errors"></div>
                  </div>

                  <div id="clickview"></div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Selling Price</label>
                    <input type="text" class="form-control" readonly id="selling_price" name="selling_price" placeholder="Product Price" data-error="Please enter Selling price." required onkeypress="return isNumberKey(event)">
                    <div class="help-block with-errors"></div>
                  </div>
                  <!-- <div class="form-group">
                    <label for="form-control-2" class="control-label">Select Deal Start Date</label>
                    <input type="text" class="form-control" id="deal_start_date" name="deal_start_date" placeholder="Select deal start date" data-error="Please enter deal start date." required>
                    <div class="help-block with-errors"></div>
                  </div> -->

                  <!-- <div class="form-group">
                    <label for="form-control-2" class="control-label">Select Deal End Date</label>
                    <input type="text" class="form-control" id="deal_end_date" name="deal_end_date" placeholder="Select deal end date" data-error="Please enter deal end date." required>
                    <div class="help-block with-errors"></div>
                  </div> -->

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Quantity</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity" data-error="Please enter Quantity." required onkeypress="return isNumberKey(event)">
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Minimum Order Quantity</label>
                    <input type="text" class="form-control" id="minimum_order_quantity" name="minimum_order_quantity" placeholder="minimum order quantity" data-error="Please enter minimum quantity order." required onkeypress="return isNumberKey(event)">
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Key Features</label>
                    <textarea name="key_features" class="form-control" id="key_features" placeholder="Product Info" data-error="This field is required." required></textarea>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Product Info</label>
                    <textarea name="product_info" class="form-control" id="product_info" placeholder="Product Info" data-error="This field is required." required></textarea>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-2" class="control-label">Specifications</label>
                    <textarea name="specifications" class="form-control" id="specifications" placeholder="Product Info" data-error="This field is required." required></textarea>
                    <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label for="form-control-3" class="control-label">Avalability</label>
                    <select id="form-control-3" name="availability_id" class="custom-select" data-error="This field is required." required>
                      <option value="">Avalability</option>
                        <option value="0">In Stock</option>
                        <option value="1">Out Of Stock</option>
                   </select>
                    <div class="help-block with-errors"></div>
                  </div>

                  <!-- <div class="form-group">
                    <label for="form-control-4" class="control-label">Product Images</label>
                    <img id="output" height="100" width="100"/>
                    <label class="btn btn-default file-upload-btn">
                    Choose file...
                          <input id="product_images" class="file-upload-input" type="file" accept="image/*" name="product_images[]" id="product_images"  onchange="loadFile(event)"  multiple="multiple" required >
                      </label>
                      <a style="cursor:pointer" id="add_more" class="add_field_button">Add More Fields</a>
                  </div> -->

                    <div id="formdiv">                   
                          <div id="filediv"><input required name="product_images[]" accept="image/*" type="file" id="file" /></div><br/>               
                          <input type="button" id="add_more" class="upload" value="Add More Files"/>                                                    
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
   <script src="js/multi_image_upload.js"></script>
   <link rel="stylesheet" type="text/css" href="css/multi_image_upload.css">
   <!-- Below script for ck editor -->
<script src="//cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'key_features' );
    CKEDITOR.replace( 'product_info' ); 
    CKEDITOR.replace( 'specifications' );
</script>

<!-- <script type="text/javascript">
$(document).ready(function() {
var abc = 0;
    $('#add_more').click(function () {
        $(this).before("<div><input type='file' id='file' name='product_images[]' accept='image/*'required><a href='#' class='remove_field'>Remove</a> </div>");
    });
    $(this).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
  });
</script> -->
<!--Multiple images script end here -->
<script type="text/javascript">

$(document).ready(function() {

    //Change price type starts here
    $("#price_type").change(function () {
        if ($(this).val() == 1) {
            $(".show_price").show();
            $('.price_change_text').html('Enter Discount Price');
        } else if($(this).val() == 2) {
            $(".show_price").show();
            $('.price_change_text').html('Enter Offer Percentage');
        } else {
            $(".show_price").hide();
        }
        $('#offer_price, #selling_price').val('');
    });
    //End
    //Check validation for prodcut price empty or not and calaculate selling price
    $('#offer_price').keyup(function() {
        if($('#product_price').val()==''){
            alert("Please Enter Product Price");
            $('#offer_price').val('');
            return false;
        } else if($('#price_type').val() == 1) {
            calcPrice = ($('#product_price').val() - $('#offer_price').val());
        } else if($('#price_type').val() == 2) {
            calcPrice = $('#product_price').val() - ( ($('#product_price').val()/100) * $('#offer_price').val());
            if (parseInt($('#offer_price').val())>99) {
                alert("Please enter the percentage less than 100 ");
                $('#selling_price').val('');
                $('#offer_price').val('');
                return false;
            };
        }
        discountPrice = calcPrice.toFixed(2);
        $('#selling_price').val(discountPrice);
        if(parseInt($('#offer_price').val()) > parseInt($('#product_price').val())) {
            alert("Please Enter Discount value less than Product Price");
            $('#selling_price').val('');
            $('#offer_price').val('');
        }
    });
    //End
    
    //End date should be greater than Start date
    $("#deal_end_date").change(function () {
        var startDate = document.getElementById("deal_start_date").value;
        if ($('#deal_start_date').val()=='') {
        alert("Please Enter Deal Start date");
        document.getElementById("deal_end_date").value = "";
    };
        var endDate = document.getElementById("deal_end_date").value;
     
        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            alert("Deal End date should be greater than Deal Start date");
            document.getElementById("deal_end_date").value = "";
        }
    });
    
   //Minimum order quantity should be less than quantity
   $("#minimum_order_quantity").keyup(function () {
        if($('#quantity').val()==''){
            alert("Please Enter Quantity");
            $('#minimum_order_quantity, #quantity').val('');
        } else {
            if(parseInt($('#minimum_order_quantity').val()) > parseInt($('#quantity').val())) {
                alert("The quantity value must be larger than the minimum quantity");
                $('#minimum_order_quantity').val('');
                return false;
            }
        }
   });
   
  });
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

function getSubSubCategories(val) {
    $.ajax({
    type: "POST",
    url: "get_sub_sub_categories.php",
    data:'sub_category_id='+val,
    success: function(data){
        $("#sub_sub_category_id").html(data);
    }
    });
}
</script>





				          

				          

                  

      
       

      
      

      






