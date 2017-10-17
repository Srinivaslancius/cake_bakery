<?php include_once 'admin_includes/main_header.php'; ?>
      <div class="site-content">
        <div class="row">
          <a href="users.php">
          <div class="col-md-4 col-sm-5">
            <div class="widget widget-tile-2 bg-primary m-b-30">
              <div class="wt-content p-a-20 p-b-50">
                <div class="wt-title">Users
                  <span class="t-caret text-success">
                    <i class="zmdi zmdi-caret-up"></i>
                  </span>
                </div>
                <div class="wt-number"><?php echo getRowsCount('users')?></div>
              </div>
              <div class="wt-icon">
                <i class="zmdi zmdi-accounts"></i>
              </div>
            </div>
          </div>
          </a>
          <a href="admin_users.php">
          <div class="col-md-4 col-sm-5">
            <div class="widget widget-tile-2 bg-warning m-b-30">
              <div class="wt-content p-a-20 p-b-50">
                <div class="wt-title">Admin Users</div>
                <div class="wt-number"><?php echo getRowsCount('admin_users')?></div>
              </div>
              <div class="wt-icon">
                <i class="zmdi zmdi-accounts"></i>
              </div>
            </div>
          </div>
          </a>
          <a href="orders.php">
          <div class="col-md-4 col-sm-4">
            <div class="widget widget-tile-2 bg-danger m-b-30">
              <div class="wt-content p-a-20 p-b-50">
                <div class="wt-title">Orders</div>
                <div class="wt-number"><?php echo getRowsCount('orders')?></div>
              </div>
              <div class="wt-icon">
                <i class="zmdi zmdi-shopping-cart-plus zmdi-hc-fw"></i>
              </div>
            </div>
          </div>
          </a>
          <a href="products.php">
          <div class="col-md-4 col-sm-4">
            <div class="widget widget-tile-2 bg-danger m-b-30">
              <div class="wt-content p-a-20 p-b-50">
                <div class="wt-title">Products</div>
                <div class="wt-number"><?php echo getRowsCount('products')?></div>
              </div>
              <div class="wt-icon">
                <i class="zmdi zmdi-shopping-basket zmdi-hc-fw"></i>
              </div>
            </div>
          </div>
          </a>
        </div>

        <div class="col-md-6 m-b-30">
          <h4 class="m-t-0 m-b-30">Pie chart</h4>
          <div id="pie" style="height: 300px"></div>
        </div>


      </div>
     <?php include_once 'admin_includes/footer.php'; ?>
     <script src="js/charts-flot.min.js"></script>
     <script type="text/javascript">
            $(document).ready(function() {
                
                var pie = function () {
                    var data = [{
                        label: "Admin Users",
                        data: <?php echo getRowsCount('admin_users')?>,
                        color: "#1d87e4",
                    }, {
                        label: "Orders",
                        data: <?php echo getRowsCount('orders')?>,
                        color: "#34a853",
                    }, {
                        label: "Products",
                        data: <?php echo getRowsCount('products')?>,
                        color: "#7d57c1",
                    }];
                    var options = {
                        series: {
                            pie: {
                                show: true
                            }
                        },
                        legend: {
                            labelFormatter: function(label, series){
                                return '<span class="pie-chart-legend">'+label+'</span>';
                            }
                        },
                        grid: {
                            hoverable: true
                        },
                        tooltip: true,
                        tooltipOpts: {
                            content: "%p.0%, %s",
                            shifts: {
                                x: 20,
                                y: 0
                            },
                            defaultTheme: false
                        }
                    };
                    $.plot($("#pie"), data, options);
                };

                pie();
               
            });
        </script>