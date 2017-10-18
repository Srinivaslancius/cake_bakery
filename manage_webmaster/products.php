<?php include_once 'admin_includes/main_header.php'; ?>
<?php $getProductsData = getAllDataWithActiveRecent('products'); $i=1; ?>
     
      <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <a href="add_products.php" style="float:right">Add Products</a>
            <h3 class="m-t-0 m-b-5">Products</h3>
          </div>
           <div class="panel-body">
            <div class="table-responsive">
          <?php $sql = "SELECT products.category_id, categories.category_name FROM products LEFT JOIN categories ON products.category_id=categories.id GROUP BY products.category_id";
            $result = $conn->query($sql);
          ?>
          <div class="form-group col-md-4">            
            <select id="select-category" class="custom-select">
              <option value="">Select Category</option>
              <?php while($getAllCategories = $result->fetch_assoc()) {  ?>
                <option value="<?php echo $getAllCategories['category_name']; ?>"><?php echo $getAllCategories['category_name']; ?></option>
              <?php } ?>
            </select>           
          </div>
          <div class="clear_fix"></div>
          <!-- <div class="form-group col-md-4">
              <div class="custom-controls-stacked checkbox_new_div">
                <label class="custom-control custom-control-primary custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="test5" name="type" onchange="filterme()" value="Active">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-label" for="test5">Active Products</span>
                </label>
                <label class="custom-control custom-control-primary custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="test6" name="type" onchange="filterme()" value="In Active">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-label" for="test6">In Active Products</span>
                </label>
              </div>
            </div> -->

         
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $getProductsData->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $row['product_name'];?></td>
                    <td><?php $getCategories = getDataFromTables('categories',$status=NULL,'id',$row['category_id'],$activeStatus=NULL,$activeTop=NULL);
              $getCategory = $getCategories->fetch_assoc(); echo $getCategory['category_name']; ?></td>
                    <td><?php if ($row['status']==0) { echo "<span class='label label-outline-success check_active open_cursor' data-incId=".$row['id']." data-status=".$row['status']." data-tbname='products
                    '>Active</span>" ;} else { echo "<span class='label label-outline-info check_active open_cursor' data-status=".$row['status']." data-incId=".$row['id']." data-tbname='products'>In Active</span>" ;} ?></td>
                    <td> <a href="edit_products.php?pid=<?php echo $row['id']; ?>"><i class="zmdi zmdi-edit"></i></a> &nbsp; <a href="#"><i class="zmdi zmdi-eye zmdi-hc-fw" data-toggle="modal" data-target="#<?php echo $row['id']; ?>" class=""></i></a></td>
                     <!-- Open Modal Box  here -->
                    <div id="<?php echo $row['id']; ?>" class="modal fade" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content animated flipInX">
                          <div class="modal-header bg-success">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">
                                <i class="zmdi zmdi-close"></i>
                              </span>
                            </button>
                            <center><h4 class="modal-title">Product Information</h4></center>
                          </div>
                        <div class="modal-body" id="modal_body">
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Name: </div>
                            <div class="col-sm-6"><?php echo $row['product_name'];?></div>
                          </div>  
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Category Name: </div>
                            <div class="col-sm-6"><?php $getCategories = getDataFromTables('categories',$status=NULL,'id',$row['category_id'],$activeStatus=NULL,$activeTop=NULL);
              $getCategory = $getCategories->fetch_assoc(); echo $getCategory['category_name']; ?> </div>
                          </div>                                                
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Product Info: </div>
                            <div class="col-sm-6"><?php echo $row['product_info'];?></div>
                          </div>                         
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Status: </div>
                            <div class="col-sm-6"><?php if($row['status'] == 0){ echo "Active";}else{ echo "InActive";}?></div>
                          </div>                          

                          <?php $getAllWeightTypes = getDataFromTables('product_weight_prices',$status=NULL,'product_id',$row['id'],$activeStatus=NULL,$activeTop=NULL);
                           ?>
                          
                              <div class="div-table">
                                    <div class="div-table-row">                                        
                                        <div  class="div-table-col">Weight Type</div>
                                        <div  class="div-table-col">Price</div>
                                    </div>
                                    <?php while ($getWeight = $getAllWeightTypes->fetch_assoc()) { ?>
                                    <div class="div-table-row">
                                        <div class="div-table-col"><?php $getWeightType = getDataFromTables('product_weights',$status=NULL,'id',$getWeight['weight_type_id'],$activeStatus=NULL,$activeTop=NULL);
              $getWeightTypes = $getWeightType->fetch_assoc(); echo $getWeightTypes['weight_type']; ?></div>
                                        <div class="div-table-col"><?php echo $getWeight['price']; ?></div>
                                    </div> 
                                    <?php } ?>                                                                      
                              </div>     

                          
                          <div class="clearfix"></div>
                         
                        </div>
                        <div class="modal-footer">
                          <!--<button type="button" data-dismiss="modal" class="btn btn-success">Continue</button>-->
                          <button type="button" data-dismiss="modal" class="btn btn-success">Close</button>
                          <style>
                            #modal_body{
                              font-size:14px;
                              padding-top:30px;
                              padding-left: 0px;
                              font-family:Roboto,sans-serif;
                            }
                            .div-table {
                              display: table;         
                              /*width: auto;*/
                              width: 64%;
                             margin: auto;
                              background-color: #eee;         
                              border: 1px solid #666666;         
                              border-spacing: 5px; /* cellspacing:poor IE support for  this */
                            }
                            .div-table-row {
                              display: table-row;
                              width: auto;
                              clear: both;
                            }
                            .div-table-col {
                              float: left; /* fix for  buggy browsers */
                              display: table-column;         
                              /*width: 150px;*/
                              width: 180px;
                              background-color: #ccc;  
                            }
                          </style>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal Box  here -->
                  </tr>
                  <?php  $i++; } ?>
                </tbody>     
              </table>
            </div>
          </div>
        </div>
      </div>
   <?php include_once 'admin_includes/footer.php'; ?>
   <script src="js/tables-datatables.min.js"></script>