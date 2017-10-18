<?php
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
// Include the main TCPDF library (search for installation path).
include_once('../../admin_includes/config.php');
require_once('tcpdf_include.php');

$from_change_format =  date("Y-m-d", strtotime($_GET['start_date']));
$to_change_format =  date("Y-m-d", strtotime($_GET['end_date']));
if($from_change_format!='1970-01-01' && $to_change_format!='1970-01-01') {

$getSelData = "SELECT users.user_name,users.street_name,users.user_mobile,milk_orders.start_date,milk_orders.end_date,IFNULL(milk_orders.total_ltr,0) as actual_ltrs,IFNULL(milk_orders.price_ltr,0)as price_ltr,sum(IFNULL(extra_milk_orders.extra_ltr,0)) as extra_ltrs,sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) as cancel_ltrs,milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) AS grand_total_milk,milk_orders.price_ltr *( milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0) ))as total_order_price,users.id FROM  milk_orders LEFT JOIN  users ON users.id = milk_orders.user_id LEFT JOIN extra_milk_orders ON milk_orders.user_id = extra_milk_orders.user_id LEFT JOIN cancel_milk_orders ON milk_orders.user_id= cancel_milk_orders.user_id WHERE DATE_FORMAT(milk_orders.start_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY users.id";        

} else {

$getSelData = "SELECT users.user_name,users.street_name,users.user_mobile,milk_orders.start_date,milk_orders.end_date,IFNULL(milk_orders.total_ltr,0) as actual_ltrs,IFNULL(milk_orders.price_ltr,0)as price_ltr,sum(IFNULL(extra_milk_orders.extra_ltr,0)) as extra_ltrs,sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) as cancel_ltrs,milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) AS grand_total_milk,milk_orders.price_ltr *( milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0) ))as total_order_price,users.id FROM  milk_orders LEFT JOIN  users ON users.id = milk_orders.user_id LEFT JOIN extra_milk_orders ON milk_orders.user_id = extra_milk_orders.user_id LEFT JOIN cancel_milk_orders ON milk_orders.user_id= cancel_milk_orders.user_id GROUP BY users.id";
   
}
if($conn->query($getSelData)){
$resultset = $conn->query($getSelData);
}else{
die('There was an error running the query [' . $conn->error . ']');
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srinivas');
$pdf->SetTitle('Palle2Patnam');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 8);

// NON-BREAKING TABLE (nobr="true")

$tbl ='<style type="text/css">
table {
    border-collapse: collapse;
    
}

</style>';

$tbl .= '<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";  >
 <tr>
  <th colspan="17" align="center" style="font-weight:bold;">All Users Monthly Milk Reports </th>
 </tr>
 <tr style="background-color: #4CAF50; color: white; font-weight:bold">
  <th align="center" width="37">S.NO</th>  
  <th align="center" width="65">User Name</th>
  <th align="center" width="65">Address</th>
  <th align="center" width="69">Mobile</th>
  <th align="center" width="70">Start Date</th>
  <th align="center" width="70">End Date</th>
  <th align="center">Actual Ltrs</th>
  <th align="center" width="45">Price/Ltr</th>
  <th align="center">Extra Ltrs</th>
  <th align="center">Cancelled Ltrs</th>
  <th align="center">Total Ltrs</th>
  <th align="center" width="65">Grand Total</th>
 </tr>';
 $i=1;
 $totalLtrs=0;
 $grandTotal=0;
while ($row= $resultset->fetch_array()){
  $totalLtrs += $row['grand_total_milk'];
  $grandTotal += $row['grand_total_milk']*$row['price_ltr']; 
    //echo "<pre>"; print_r($row); die;
$tbl .='<tr style="border-bottom:0">
  <td width="37" align="center">'.$i.'</td>  
  <td width="65" align="center">'.$row['user_name'].'</td>
  <td align="center" width="65">'.$row['street_name'].'</td>
  <td width="69" align="center">'.$row['user_mobile'].'</td>
  <td width="70" align="center">'.$row['start_date'].'</td>
  <td width="70" align="center">'.$row['end_date'].'</td>
  <td align="center">'.$row['actual_ltrs'].'</td>
  <td width="45" align="center">'.$row['price_ltr'].'</td>
  <td align="center">'.$row['extra_ltrs'].'</td>
  <td align="center">'.$row['cancel_ltrs'].'</td>
  <td align="center">'.$row['grand_total_milk'].'</td>
  <td align="center" width="65">'.$row['total_order_price'].'</td>
 </tr>'; 

$i++; }
$tbl .='</table>';
$tbl .='<table border="1" cellpadding="16" cellspacing="0" nobr="true" border-collapse: "collapse"; >
 <tr>
  <th colspan="4" align="center" style="background-color: #eaa934; color: white; font-weight:bold">Grand Total</th>
 </tr>
 <tr>
  <td></td>  
  <td></td>
  <td style="font-weight:bold;">Total Ltrs : '.$totalLtrs.'</td>
  <td style="font-weight:bold;">Grand Total : '.$grandTotal.'</td>   
 </tr></table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+