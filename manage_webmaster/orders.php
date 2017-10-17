<?php include_once 'admin_includes/main_header.php'; ?>

      <style>
        .table1 {
          display: table;
          border: 1px solid #808080;
          text-align: center;
          border-top-left-radius: 3px;
          border-top-right-radius: 3px;
          padding: 0px;
          margin-bottom: 0;
        }
        .table1-row {
            display: table-row;
        }
        .table1-cell {
          display: table-cell;
          border-bottom: 1px solid #b2b2b2;
          padding: 6px;
        }
        .table1-footer .table1-cell{
          border-bottom: 0;
          padding-top:4px;
        }
        .table1-header {
          font-weight: bold;
          background-color: #d8d8d8;
        }
      </style>

      <div class="site-content">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <!-- <a href="add_orders.php" style="float:right">Add Order</a> -->
            <h3 class="m-t-0 m-b-5">Orders</h3> 
            <?php $sql ="SELECT * from orders GROUP BY order_id  ORDER BY id DESC";
              $res = $conn->query($sql);
              $i=1; 
            ?>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <?php $sql1 = "SELECT orders.order_status, order_status.id,order_status.status FROM orders LEFT JOIN order_status ON orders.order_status=order_status.id GROUP BY orders.order_status";
            $result1 = $conn->query($sql1);
          ?>
          <div class="form-group col-md-4">                    
            <select id="select-order" class="custom-select">
               <option value="">Choose status</option>
                <?php while ($getAllStatus = $result1->fetch_assoc()) { ?>
                  <option value="<?php echo $getAllStatus['status']; ?>"><?php echo $getAllStatus['status']; ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="clear_fix"></div>
              <table class="table table-striped table-bordered dataTable" id="table-1">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Order Id</th>
                    <th>Mobile No</th>
                    <th>created Date</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($res1 = $res->fetch_assoc()) { ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $res1['first_name'];?></td>
                    <td><?php echo $res1['order_id'];?></td>
                    <td><?php echo $res1['mobile'];?></td>
                    <td><?php echo $res1['order_date'];?></td>                 
                    <td><?php if ($res1['order_status']==1) { echo "Pending" ;} elseif($res1['order_status']==2) { echo "Completed" ;} else{ echo "Cancelled";}?></td>
                    <td><a href="edit_orders.php?oid=<?php echo $res1['id'];?>"><i class="zmdi zmdi-edit"></i></a> &nbsp;<a href="#" class="click_view" data-modalId="<?php echo $res1['id']?>"><i class="zmdi zmdi-eye zmdi-hc-fw" data-toggle="modal" data-target="#successModal2" class=""></i></a></td>
                     <!-- Open Modal Box  here -->
                    <div id="myModal_<?php echo $res1['id']; ?>" class="modal fade" >
                          <div class="modal-dialog" Style="margin-top:10%;">
                              <div class="modal-content">
                                  <div class="modal-header">
                                  <h3 class="modal-title" style="text-align: center;"><b>Order Information</b></h3>
                                  </div>
                                  <div class="modal-body" style="padding-left: 15px;padding-top: 5px">
                                    <div class="table1" style="width:100%">
                                      <div class="table1-row table1-header" >
                                          <div class="table1-cell">Shipping</div>
                                          <div class="table1-cell">Order Id</div>
                                          <div class="table1-cell">Order Status</div>
                                          <div class="table1-cell">Billing</div>
                                      </div>
                                      <div class="table1-row table1-footer">
                                          <div class="table1-cell"><?php echo $res1['first_name'];?></div>
                                          <div class="table1-cell"><?php echo $res1['order_id']; ?></div>
                                           <div class="table1-cell"><?php if ($res1['order_status']==1) { echo "Pending" ;} elseif($res1['order_status']==2) { echo "Completed" ;} else{ echo "Cancelled";} ?></div>
                                          <div class="table1-cell"><?php echo $res1['first_name'];?></div>
                                      </div>
                                      <div class="table1-row table1-footer">
                                          <div class="table1-cell"><?php echo $res1['address1'];?></div>
                                          <div class="table1-cell"></div>
                                          <div class="table1-cell"></div>
                                          <div class="table1-cell"><?php echo $res1['address1'];?></div>
                                      </div>
                                      <div class="table1-row table1-footer">
                                          <div class="table1-cell"><?php echo $res1['district'];?></div>
                                          <div class="table1-cell"></div>
                                          <div class="table1-cell"></div>
                                          <div class="table1-cell"><?php echo $res1['district'];?></div>
                                      </div>
                                      <div class="table1-row table1-footer">
                                          <div class="table1-cell"><?php echo $res1['pin_code'];?></div>
                                          <div class="table1-cell"></div>
                                           <div class="table1-cell"></div>
                                          <div class="table1-cell"><?php echo $res1['pin_code'];?></div>
                                      </div>
                                      <div class="table1-row table1-header">
                                          <div class="table1-cell">Item Name</div>
                                          <div class="table1-cell">Quantity</div>
                                          <div class="table1-cell">Price</div>
                                          <div class="table1-cell">Total</div>
                                      </div>
                                        <?php $proInfo = getDataFromTables('orders',$status=NULL,'order_id',$res1['order_id'],$activeStatus=NULL,$activeTop=NULL); ?>
                                        <?php while($getAllProInfo = $proInfo->fetch_assoc()) { ?>
                                        <div class="table1-row">
                                            <div class="table1-cell"><?php echo $getAllProInfo['product_name']; ?></div>
                                            <div class="table1-cell"><?php echo $getAllProInfo['product_quantity']; ?></div>
                                            <div class="table1-cell"><?php echo $getAllProInfo['product_price']; ?></div>
                                            <div class="table1-cell"><?php echo $getAllProInfo['product_total_price']; ?></div>
                                        </div>
                                        <?php } ?>
                                        <div class="table1-row table1-header" style="width:100%">
                                            <div class="table1-cell"></div>
                                            <div class="table1-cell">Order Total</div>
                                            <div class="table1-cell"></div>
                                            <div class="table1-cell"></div>
                                        </div>
                                        <div class="table1-row table1-footer">
                                            <div class="table1-cell">Sub Total</div>
                                            <div class="table1-cell"></div>
                                            <div class="table1-cell"><?php echo $res1['cart_sub_total']; ?></div>
                                            <div class="table1-cell"></div>
                                        </div>  
                                        <div class="table1-row table1-footer">
                                            <div class="table1-cell">Delivery Charges</div>
                                            <div class="table1-cell"></div>
                                            <div class="table1-cell"><?php echo $res1['delivery_charges']; ?></div>
                                            <div class="table1-cell"></div>
                                        </div>
                                        <div class="table1-row table1-footer">
                                            <div class="table1-cell">Packaging Charges</div>
                                            <div class="table1-cell"></div>
                                            <div class="table1-cell"><?php echo $res1['packaging_charges']; ?></div>
                                            <div class="table1-cell"></div>
                                        </div>
                                        <div class="table1-row table1-footer">
                                            <div class="table1-cell">Order Total</div>
                                            <div class="table1-cell"></div>
                                            <div class="table1-cell"><?php echo $res1['order_total']; ?></div>
                                            <div class="table1-cell"></div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn" data-dismiss="modal" style="background-color:#f00; color:#fff">Close</button>
                                  </div>
                              </div>
                          </div>
                      </div>
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