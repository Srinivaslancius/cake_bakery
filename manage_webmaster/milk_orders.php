<?php include_once 'admin_includes/main_header.php'; ?>
<?php $getMilkOrdersData = getAllDataWithActiveRecent('milk_orders'); $i=1; ?>
     <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <a href="add_milk_order.php" style="float:right">Add Milk Order</a>
            <h3 class="m-t-0 m-b-5">Milk Orders</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>User Name</th>
                    <th>Total Ltrs</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $getMilkOrdersData->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php $getUserName =  getDataFromTables('users',$status=NULL,'id',$row['user_id'],$activeStatus=NULL,$activeTop=NULL); $getUserName1 = $getUserName->fetch_assoc(); echo $getUserName1['user_name']?></td>
                    <td><?php echo $row['total_ltr'];?></td>
                    <td><?php echo $row['start_date'];?></td>
                    <td><?php echo $row['end_date'];?></td>
                    <td> <a href="edit_milk_order.php?id=<?php echo $row['id']; ?>"><i class="zmdi zmdi-edit"></i></a></td>
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