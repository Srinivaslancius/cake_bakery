<?php include_once "admin_includes/config.php"; 
    include_once('admin_includes/common_functions.php');
?>

<?php 
if(isset($_POST['search']) && $_POST['search']!='' ) {

  //Date format changes
  $table = "orders";
  $user_id = $_POST['user_id'];
  $start_date = $_POST['start_date']; 
  $end_date = $_POST['end_date'];
  //echo "<pre>"; print_r($_REQUEST); die;
  //Set From and To dates depends on databse search results
  $from_change_format =  date("Y-m-d", strtotime($start_date));                        
  $to_change_format   =  date("Y-m-d", strtotime($end_date));  

  if(isset($user_id) && $user_id!='' && isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='' ) {
    $statement = "`$table` WHERE `user_id` = '$user_id' AND DATE_FORMAT(order_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY `user_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT * FROM {$statement} ");
  } elseif(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='' ) {
    $statement = "`$table` WHERE DATE_FORMAT(order_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY `user_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT * FROM {$statement} ");
  } elseif(isset($start_date) && $start_date!='' && isset($user_id) && $user_id!='' ) {
    $statement = "`$table` WHERE `user_id` = '$user_id' AND DATE_FORMAT(order_date,'%Y-%m-%d') = '$from_change_format' GROUP BY `user_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT * FROM {$statement} ");
  } elseif(isset($user_id) && $user_id!='') {
    $statement = "`$table` WHERE `user_id` = '$user_id' GROUP BY `user_id` ";
    $getData = $conn->query("SELECT * FROM {$statement} ");
  } elseif(isset($start_date) && $start_date!='' ) {
    $statement = "`$table` WHERE DATE_FORMAT(order_date,'%Y-%m-%d') = '$from_change_format' GROUP BY `user_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT * FROM {$statement} ");   
  } elseif(isset($end_date) && $end_date!='' ) {
    $statement = "`$table` WHERE DATE_FORMAT(order_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY `user_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT * FROM {$statement} ");   
  } else {
    $sql="SELECT * from `orders` GROUP BY user_id ";
    $getData = $conn->query($sql);
  }
} else {
    $sql="SELECT * from `orders` GROUP BY user_id ";
    $getData = $conn->query($sql);
}
?>
  
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
table {
    width: 53%;
  border: 2px solid gray;
  border-collapse:collapse;
}

td {
    text-align: center;
    padding: 8px;
    font-size:14px;
}
tr:nth-child(odd){background-color:#faab19 ;}

th {
    background-color: #35b863 ;
    color: white;
     text-align: center;
    padding: 8px;
}
.one{
  margin-top:20px;
  border-bottom:2px solid #DCDCDC;
  padding-top:2px;
  padding-bottom:10px;
  }
.two{
  margin-top:20px;
  
}
.header{
  background-color:#DCDCDC;
  border-bottom:2px solid #D3D3D3 ;
  }
.footer{
  margin-top:20px;
  background-color:#DCDCDC;
  padding:15px;
  border-bottom:2px solid #D3D3D3;
  border-top:2px solid #D3D3D3;
  }
h3{
  color:#faab19;
  }
  .btn-default{
  padding-left:30px; 
  padding-right:30px
  }
  a{
  color:black;}
</style>
</head>
<body>
  <?php $sql = "SELECT users.id,users.user_name FROM orders LEFT JOIN users ON orders.user_id=users.id GROUP BY orders.user_id";
      $result = $conn->query($sql);
?>
<div class="container-fluid header">
  <div class="row">
    <div class="col-sm-5">
      <center><img src="logo.png"></center>
    </div>
    <div class="col-sm-3">
      <center><h3><b>INVOICE REPORT</b></h3></center>
    </div>
    <div class="col-sm-4">
    </div>
  </div>
</div>
<div class="container-fluid one">
<div class="form-group">
<form name="search" method="post" autocomplete="off">
<div class="row">
  
  <div class="col-sm-3">
    <select class="form-control" id="select-users" name="user_id">
      <option value="">Select User</option>
      <?php while ($getAllUsers = $result->fetch_assoc()) { ?>
      <option <?php if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']==$getAllUsers['id']) { echo "selected='selected'"; } ?> value="<?php echo $getAllUsers['id']; ?>"><?php echo $getAllUsers['user_name']; ?></option>
          <?php } ?>
    </select>     
  </div>      
  <div class="col-sm-3">
    <input type="text" class="form-control" name="start_date" placeholder="Start Date" id="start_date"  value="<?php if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!='') { echo $_REQUEST['start_date'];  } ?>">
  </div>
  <div class="col-sm-3">
    <input class="form-control" type="text" id="end_date" name="end_date" placeholder="End Date"  value="<?php if(isset($_REQUEST['end_date']) && $_REQUEST['end_date']!='') { echo $_REQUEST['end_date'];  } ?>">
  </div>
  <div class="col-sm-3">
    <input class="btn btn-primary" type="submit" name="search" value="Search">
    <input class="btn btn-primary" type="submit" name="reset" value="Reset" id="reset">
  </div>
  
</div>
</div>
</form>
</div>
</div>
<div class="container-fluid two">
<form method="POST">  
<center><table>
  <tr>
    <th>Id</th>
    <th>Name</th>
    <th>Order Id</th>
    <th>Total Price</th>
    <th>Print</th>
  </tr>
  <?php   
        $i=1; 
        $user_id = array(); 
        //$total_ltrs = 0;
        while ($row = $getData->fetch_assoc()) {           
        $user_id[] = serialize($row['user_id']);        

  ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php $getUserName = getIndividualDetails($row['user_id'],'users','id'); echo $getUserName['user_name']; ?></td> 
    <td><?php echo $row['order_id']; ?></td>   
    <td><?php echo $row['product_total_price']; ?></td>    
    <td> <a href="TCPDF/examples/view_order_pdf.php?uid=<?php echo $row['user_id']; ?>" target="_blank">Print</a></td>
  </tr>
  <?php $i++;  } ?>
</table>
  <?php 
    if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!='' && isset($_REQUEST['end_date']) && $_REQUEST['end_date']!='') {
      $start_date = $_REQUEST['start_date'];
      $end_date = $_REQUEST['end_date'];
    } else {
      $start_date = '';
      $end_date = '';
    }
  ?>
</center>
</form>
</div>
<div class="container-fluid footer">
    <center><a href="TCPDF/examples/monthly_order_pdf_reports.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" target="_blank" class="btn btn-default btn-lg" style="background-color:#35b863; color:white">Generate Reports</a></center>
</div>
</body>
</html>
<script>
  $( function() {
    $( "#end_date , #start_date" ).datepicker();
  } );

  $(document).ready(function() {
  //End date should be greater than Start date
    $("#end_date").change(function () {
        var startDate = document.getElementById("start_date").value;
        if ($('#start_date').val()=='') {
        alert("Please Enter Start date");
        document.getElementById("end_date").value = "";
    };
        var endDate = document.getElementById("end_date").value;
     
        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("end_date").value = "";
        }
    });
  });
  $("#reset").click(function () {
    document.getElementById("select-users").value = "";
    document.getElementById("start_date").value = "";
    document.getElementById("end_date").value = "";
  });
</script>
