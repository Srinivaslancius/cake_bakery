<?php include_once 'admin_includes/main_header.php'; ?>
<?php $getCustomerEnquiriesData = getDataFromTables('customer_enqueries',$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL);?>
     <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <h3 class="m-t-0 m-b-5">Customer Enqueries</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>Customer Name</th>
                    <th>Customer Mobile</th>
                    <th>Customer Address</th>
                    <th>Created Date</th>
                    <th>Customer Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $getCustomerEnquiriesData->fetch_assoc()) { ?>
                  <tr>
                      <td><?php echo $row['customer_name'];?></td>
                      <td><?php echo $row['customer_mobile'];?></td>
                      <td><?php echo $row['customer_feedback'];?></td>
                      <td><?php echo $row['created_at'];?></td>
                      <td><a href="mailto:<?php echo $row['customer_email'];?>" target="_top"><?php echo $row['customer_email'];?></a></td>
                      </tr>    
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
   <?php include_once 'admin_includes/footer.php'; ?>
   <script src="js/tables-datatables.min.js"></script>