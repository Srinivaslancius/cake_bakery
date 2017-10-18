<?php include_once "admin_includes/config.php"; 
    include_once('admin_includes/common_functions.php');
?>

<?php 
if(isset($_POST['search']) && $_POST['search']!='' ) {

  //Date format changes
  $table = "vendor_milk_assign";
  $user_id = $_POST['vendor_id'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  //echo "<pre>"; print_r($_REQUEST); die;
  //Set From and To dates depends on databse search results
  $from_change_format =  date("Y-m-d", strtotime($start_date));                        
  $to_change_format   =  date("Y-m-d", strtotime($end_date));  

  if(isset($user_id) && $user_id!='' && isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='' ) {
    $statement = "`$table` WHERE `vendor_id` = '$user_id' AND DATE_FORMAT(created_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY `vendor_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs FROM {$statement} ");
  } elseif(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='' ) {
    $statement = "`$table` WHERE DATE_FORMAT(created_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY `vendor_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs FROM {$statement} ");
  } elseif(isset($start_date) && $start_date!='' && isset($user_id) && $user_id!='' ) {
    $statement = "`$table` WHERE `vendor_id` = '$user_id' AND DATE_FORMAT(created_date,'%Y-%m-%d') = '$from_change_format' GROUP BY `vendor_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs FROM {$statement} ");
  } elseif(isset($user_id) && $user_id!='') {
    $statement = "`$table` WHERE `vendor_id` = '$user_id' GROUP BY `vendor_id` ";
    $getData = $conn->query("SELECT *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs FROM {$statement} ");
  } elseif(isset($start_date) && $start_date!='' ) {
    $statement = "`$table` WHERE DATE_FORMAT(created_date,'%Y-%m-%d') = '$from_change_format' GROUP BY `vendor_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs FROM {$statement} ");   
  } elseif(isset($end_date) && $end_date!='' ) {
    $statement = "`$table` WHERE DATE_FORMAT(created_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY `vendor_id` ";
    //echo "SELECT * FROM {$statement} "; 
    $getData = $conn->query("SELECT *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs FROM {$statement} ");   
  } else {
    $sql="select *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs from `vendor_milk_assign` GROUP BY vendor_id ";
    $getData = $conn->query($sql);
  }
} else {
    $sql="select *,SUM(milk_in_ltrs) AS total_milk_vendor_ltrs from `vendor_milk_assign` GROUP BY vendor_id ";
    $getData = $conn->query($sql);
}
?>
<html lang="en">
<head>
  <title>New vendor Milk Reports</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
	border-bottom:2px solid #D3D3D3	;
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
<div class="row">
  <form name="search" method="post" autocomplete="off">
  <div class="col-sm-3">
    <select class="form-control" id="select-users" name="vendor_id">
      <option value=" ">Select vendar</option>
      <?php while ($getAllUsers = $result->fetch_assoc()) { ?>
      <option <?php if(isset($_REQUEST['vendor_id']) && $_REQUEST['vendor_id']==$getAllUsers['id']) { echo "selected='selected'"; } ?> value="<?php echo $getAllUsers['id']; ?>"><?php echo $getAllUsers['vendor_name']; ?></option>
          <?php } ?>
    </select>     
  </div>      
  <div class="col-sm-3">
    <input type="text" class="form-control" name="start_date" placeholder="Start Date" id="start_date" required value="<?php if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!='') { echo $_REQUEST['start_date'];  } ?>">
  </div>
  <div class="col-sm-3">
    <input class="form-control"type="text" id="end_date" name="end_date" placeholder="End Date" required value="<?php if(isset($_REQUEST['end_date']) && $_REQUEST['end_date']!='') { echo $_REQUEST['end_date'];  } ?>">
  </div>
  <div class="col-sm-3">
    <input type="submit" name="search" value="Search" class="btn btn-default" >
    <input type="submit" name="reset" value="Reset" id="reset" class="btn btn-default">
  </div>
</form>
</div>
</div>
</div>
</div>
<div class="container-fluid two">
<center><table>
  <tr>
    <th>Id</th>
    <th>Vendor Name</th>
    <th>Total Ltrs</th>
    <th>Print</th>
	</tr>
  <?php   
        $i=1; 
        $vendor_id = array(); 
        $total_ltrs = 0;
        while ($row = $getData->fetch_assoc()) {           
        $vendor_id[] = serialize($row['vendor_id']);        

  ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php $getVendorName = getIndividualDetails($row['vendor_id'],'vendors','id'); echo $getVendorName['vendor_name']; ?></td>    
    <td><?php echo $row['total_milk_vendor_ltrs']; ?></td>    
    <td> <a href="TCPDF/examples/view_vendor_milk_pdf.php?uid=<?php echo $row['vendor_id']; ?>" target="_blank">Print</a></td>
  </tr>
  <?php $i++;  } ?>
</table></center>
</div>
<div class="container-fluid footer">
    <center><a href="TCPDF/examples/monthly_vendor_pdf_reports.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" target="_blank" class="btn btn-default btn-lg" style="background-color:#35b863; color:white">Generate Reports</a></center>
</div>
</body>
</html>
