<?php include_once 'admin_includes/main_header.php'; ?>
<?php $getVendorsData = getDataFromTables('vendor_milk_assign',0,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL); $i=1;?>
     
      <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <a href="add_milk_vendors.php" style="float:right">Add Milk Vendor</a>
            <h3 class="m-t-0 m-b-5">Milk Vendors</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
          <?php $sql = "SELECT vendors.id, vendors.vendor_name FROM vendor_milk_assign LEFT JOIN vendors ON vendors.id=vendor_milk_assign.vendor_id GROUP BY vendors.id";
              $result = $conn->query($sql);
          ?>
          <div class="form-group col-md-4">            
            <select id="vendor-name" name="vendor_id" class="custom-select">
              <option value="">Select Vendor</option>
              <?php while($getAllVendorsList = $result->fetch_assoc()) {  ?>
                <option value="<?php echo $getAllVendorsList['vendor_name']; ?>"><?php echo $getAllVendorsList['vendor_name']; ?></option>
              <?php } ?>
            </select>
            <div class="help-block with-errors"></div>
          </div>
         
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Vendor Name</th>
                    <th>Price</th>
                    <th>Milk in Lts</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $getVendorsData->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php $getVendorName = getDataFromTables('vendors',$status=NULL,'id',$row['vendor_id'],$activeStatus=NULL,$activeTop=NULL); $getName = $getVendorName->fetch_assoc(); echo $getName['vendor_name']; ?></td>
                    <td><?php echo $row['price'];?></td>
                    <td><?php echo $row['milk_in_ltrs'];?></td>
                    <td><?php echo $row['created_date'];?></td>
                    <td> <a href="edit_milk_venodrs.php?id=<?php echo $row['id']; ?>"><i class="zmdi zmdi-edit"></i></a></td>
                    
                  </tr>
                  <?php  $i++; }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>      
      </div>
   <?php include_once 'admin_includes/footer.php'; ?>
   <script src="js/tables-datatables.min.js"></script>