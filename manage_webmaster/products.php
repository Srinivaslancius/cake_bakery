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
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Sub Sub Category Name</th>
                    <th>Product Price</th>
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

                    <td><?php $getSubCategories = getDataFromTables('sub_categories',$status=NULL,'id',$row['sub_category_id'],$activeStatus=NULL,$activeTop=NULL);
                    $getSubCategory = $getSubCategories->fetch_assoc(); echo $getSubCategory['sub_category_name']; ?></td>

                    <td><?php $getSubSubCategories = getDataFromTables('sub_sub_categories',$status=NULL,'id',$row['sub_sub_category_id'],$activeStatus=NULL,$activeTop=NULL);
                    $getSubSubCategory = $getSubSubCategories->fetch_assoc(); echo $getSubSubCategory['sub_sub_category_name']; ?></td>

                    <td><?php echo $row['product_price'];?></td>
                                       
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
                            <div class="col-sm-4">Price: </div>
                            <div class="col-sm-6"><?php echo $row['product_price'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Offer Price: </div>
                            <div class="col-sm-6"><?php echo $row['offer_price'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Selling Price: </div>
                            <div class="col-sm-6"><?php echo $row['selling_price'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Start Date: </div>
                            <div class="col-sm-6"><?php echo $row['deal_start_date'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">End Date: </div>
                            <div class="col-sm-6"><?php echo $row['deal_end_date'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Quantity: </div>
                            <div class="col-sm-6"><?php echo $row['quantity'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Minimum Order Quantity: </div>
                            <div class="col-sm-6"><?php echo $row['minimum_order_quantity'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Key Features: </div>
                            <div class="col-sm-6"><?php echo $row['key_features'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Product Inforamtion: </div>
                            <div class="col-sm-6"><?php echo $row['product_info'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Specifications: </div>
                            <div class="col-sm-6"><?php echo $row['specifications'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Availability: </div>
                            <div class="col-sm-6"><?php if($row['availability_id'] == 0 ){ echo "In Stock";} else{ echo "Out Of Stock";}?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Status: </div>
                            <div class="col-sm-6"><?php if($row['status'] == 0 ){ echo "Active";} else{ echo "InActive";}?></div>
                          </div>
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

