<?php include_once 'admin_includes/main_header.php'; ?>
<?php $getSubCategoriesData = getAllDataWithActiveRecent('sub_sub_categories'); $i=1; ?>
     <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <a href="add_sub_sub_categories.php" style="float:right">Add Sub Sub Categories</a>
            <h3 class="m-t-0 m-b-5">Sub Categories</h3>            
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Sub Sub Banner Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $getSubCategoriesData->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php $getCategories = getDataFromTables('categories',$status=NULL,'id',$row['category_id'],$activeStatus=NULL,$activeTop=NULL);
                    $getCategory = $getCategories->fetch_assoc(); echo $getCategory['category_name']; ?></td>
                    <td><?php echo $row['sub_sub_category_name'];?></td>
                    <td><img src="<?php echo $base_url . 'uploads/sub_sub_banner_images/'.$row['sub_sub_banner_image'] ?>" height="100" width="100"/></td>
                    <td><?php if ($row['status']==0) { echo "<span class='label label-outline-success check_active open_cursor' data-incId=".$row['id']." data-status=".$row['status']." data-tbname='sub_sub_categories'>Active</span>" ;} else { echo "<span class='label label-outline-info check_active open_cursor' data-status=".$row['status']." data-incId=".$row['id']." data-tbname='sub_sub_categories'>In Active</span>" ;} ?></td>
                    <td> <a href="edit_sub_sub_categories.php?bid=<?php echo $row['id']; ?>"> <i class="zmdi zmdi-edit"></i></a> </td>
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