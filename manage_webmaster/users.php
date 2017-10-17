<?php include_once 'admin_includes/main_header.php'; ?>
<?php $getUsersData = getAllDataWithActiveRecent('users'); $i=1; ?>
     
      <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <a href="add_users.php" style="float:right">Add User</a>
            <h3 class="m-t-0 m-b-5">Users</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <?php $sql = "SELECT users.user_country_id, lkp_countries.country_name FROM users LEFT JOIN lkp_countries ON users.user_country_id=lkp_countries.id GROUP BY users.user_country_id";
                  $result = $conn->query($sql);

                  $sql1 = "SELECT users.user_state_id, lkp_states.state_name FROM users LEFT JOIN lkp_states ON users.user_state_id=lkp_states.id GROUP BY users.user_state_id";
                  $result1 = $conn->query($sql1);

                  $sql2 = "SELECT users.user_city_id, lkp_cities.city_name FROM users LEFT JOIN lkp_cities ON users.user_city_id=lkp_cities.id GROUP BY users.user_city_id";
                  $result2 = $conn->query($sql2);
              ?>

                <div class="col s12 m12 l12">                  

                  <div class="form-group col-md-4">                    
                    <select id="select-country" class="custom-select">
                       <option value="">Select Country</option>
                        <?php while ($getAllCountries = $result->fetch_assoc()) { ?>
                          <option value="<?php echo $getAllCountries['country_name']; ?>"><?php echo $getAllCountries['country_name']; ?></option>
                        <?php } ?>
                    </select>                    
                  </div>

                  <div class="form-group col-md-4">                    
                    <select id="select-state" class="custom-select">
                       <option value="">Select State</option>
                        <?php while ($getAllStates = $result1->fetch_assoc()) { ?>
                          <option value="<?php echo $getAllStates['state_name']; ?>"><?php echo $getAllStates['state_name']; ?></option>
                        <?php } ?>
                    </select>                    
                  </div>

                  <div class="form-group col-md-4">                    
                    <select id="select-cities" class="custom-select">
                        <option value="">Select City</option>
                        <?php while ($getAllCities = $result2->fetch_assoc()) { ?>
                          <option value="<?php echo $getAllCities['city_name']; ?>"><?php echo $getAllCities['city_name']; ?></option>
                        <?php } ?>
                    </select>                    
                  </div>

                </div>

                <div class="clear_fix"></div>

                <div class="form-group col-md-4">
                  <div class="custom-controls-stacked checkbox_new_div">
                    <label class="custom-control custom-control-primary custom-checkbox">
                      <input class="custom-control-input" type="checkbox" id="test5" name="type" onchange="filterme()" value="Active">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-label" for="test5">Verified Users</span>
                    </label>
                    <label class="custom-control custom-control-primary custom-checkbox">
                      <input class="custom-control-input" type="checkbox" id="test6" name="type" onchange="filterme()" value="In Active">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-label" for="test6">Non Verified Users</span>
                    </label>
                  </div>
                </div>
              
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>User Name</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = $getUsersData->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $row['user_name'];?></td>
                    <td><?php $getCountryData =  getDataFromTables('lkp_countries',$status=NULL,'id',$row['user_country_id'],$activeStatus=NULL,$activeTop=NULL); $country = $getCountryData->fetch_assoc(); echo $country['country_name']?></td>
                    <td><?php $getStateData =  getDataFromTables('lkp_states',$status=NULL,'id',$row['user_state_id'],$activeStatus=NULL,$activeTop=NULL); $state = $getStateData->fetch_assoc(); echo $state['state_name']?></td>
                    <td><?php $getCityData =  getDataFromTables('lkp_cities',$status=NULL,'id',$row['user_city_id'],$activeStatus=NULL,$activeTop=NULL); $city = $getCityData->fetch_assoc(); echo $city['city_name']?></td>
                    <td><?php echo $row['user_address'];?></td> 
                    <td><?php if ($row['status']==0) { echo "<span class='label label-outline-success check_active open_cursor' data-incId=".$row['id']." data-status=".$row['status']." data-tbname='users'>Active</span>" ;} else { echo "<span class='label label-outline-info check_active open_cursor' data-status=".$row['status']." data-incId=".$row['id']." data-tbname='users'>In Active</span>" ;} ?></td>
                    <td> <a href="edit_users.php?uid=<?php echo $row['id']; ?>"><i class="zmdi zmdi-edit"></i></a> &nbsp; <a href="#"><i class="zmdi zmdi-eye zmdi-hc-fw" data-toggle="modal" data-target="#<?php echo $row['id']; ?>" class=""></i></a></td>
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
                            <center><h4 class="modal-title">User Information</h4></center>
                          </div>
                        <div class="modal-body" id="modal_body">
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Name: </div>
                            <div class="col-sm-6"><?php echo $row['user_name'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Email: </div>
                            <div class="col-sm-6"><?php echo $row['user_email'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Mobile: </div>
                            <div class="col-sm-6"><?php echo $row['user_mobile'];?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Country: </div>
                            <div class="col-sm-6"><?php $getCountryData =  getDataFromTables('lkp_countries',$status=NULL,'id',$row['user_country_id'],$activeStatus=NULL,$activeTop=NULL); $country = $getCountryData->fetch_assoc(); echo $country['country_name']?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">State: </div>
                            <div class="col-sm-6"><?php $getStateData =  getDataFromTables('lkp_states',$status=NULL,'id',$row['user_state_id'],$activeStatus=NULL,$activeTop=NULL); $state = $getStateData->fetch_assoc(); echo $state['state_name']?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">City: </div>
                            <div class="col-sm-6"><?php $getCityData =  getDataFromTables('lkp_cities',$status=NULL,'id',$row['user_city_id'],$activeStatus=NULL,$activeTop=NULL); $city = $getCityData->fetch_assoc(); echo $city['city_name']?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Location: </div>
                            <div class="col-sm-6"><?php $getLocationData =  getDataFromTables('lkp_locations',$status=NULL,'id',$row['user_location_id'],$activeStatus=NULL,$activeTop=NULL); $loaction = $getLocationData->fetch_assoc(); echo $loaction['location_name']?></div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">Address: </div>
                            <div class="col-sm-6"><?php echo $row['user_address'];?></div>
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
  