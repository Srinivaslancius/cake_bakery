<?php include_once 'admin_includes/main_header.php'; ?>
<?php $getMaintanceCategoryData = getAllData('truck_maintance'); $i=1; ?>

      <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <a href="add_truck_maintenance_category.php" style="float:right">Add Maintenance Category</a>
            <h3 class="m-t-0 m-b-5">Maintenance Category</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Category Name</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $getMaintanceCategoryData->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php $getMaintanceCategoryName = getDataFromTables('maintance_category',$status=NULL,'id',$row['maintance_category_name'],$activeStatus=NULL,$activeTop=NULL); $getName = $getMaintanceCategoryName->fetch_assoc(); echo $getName['title']; ?></td>
                    <td><?php echo $row['price'];?></td>
                    <td><?php echo $row['date'];?></td>
                    <td><?php echo $row['description'];?></td>
                    <td> <a href="edit_truck_maintenance_category.php?id=<?php echo $row['id']; ?>"><i class="zmdi zmdi-edit"></i></a></td>
                    
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