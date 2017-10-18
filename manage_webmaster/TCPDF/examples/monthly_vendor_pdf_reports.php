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
include_once('../../admin_includes/common_functions.php');
require_once('tcpdf_include.php');

$from_change_format =  date("Y-m-d", strtotime($_GET['start_date']));
$to_change_format =  date("Y-m-d", strtotime($_GET['end_date']));
if($from_change_format!='1970-01-01' && $to_change_format!='1970-01-01') {
    $getSelData = "SELECT vendors.id,vendors.vendor_name, sum(vendor_milk_assign.milk_in_ltrs) AS totalMilk, vendor_milk_assign.price FROM vendor_milk_assign LEFT JOIN vendors ON vendor_milk_assign.vendor_id=vendors.id WHERE DATE_FORMAT(vendor_milk_assign.created_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY vendor_milk_assign.vendor_id";
} else {
     $getSelData = "SELECT vendors.id,vendors.vendor_name, sum(vendor_milk_assign.milk_in_ltrs) AS totalMilk, vendor_milk_assign.price FROM vendor_milk_assign LEFT JOIN vendors ON vendor_milk_assign.vendor_id=vendors.id GROUP BY vendor_milk_assign.vendor_id";
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
    width: 100%;
}
th, td {
    text-align: left;
    padding: 4px;
}
tr:nth-child(even){background-color: #f2f2f2} 

</style>';

$tbl .= '<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";>
 <tr>
  <th colspan="5" align="center" style="font-weight:bold;">All Vendors Monthly Milk Reports </th>
 </tr>
 <tr style="background-color: #4CAF50; color: white; font-weight:bold">
  <th align="center">S.NO</th>  
  <th align="center">Vendor Name</th>
  <th align="center">Total Monthly Ltrs</th>
  <th align="center">Price/Ltr</th>
  <th align="center">Total Price</th>
 </tr>';
 $i=1;
 $totalLtrs=0;
 $grandTotal=0;
while ($row= $resultset->fetch_array()){
    $getVendorName = getIndividualDetails($row['id'],'vendors','id');  
    $totalLtrs += $row['totalMilk'];
    $grandTotal += $row['totalMilk']*$row['price'];
    //echo "<pre>"; print_r($milkOrderData); die;
$tbl .='<tr style="border-bottom:0">
  <td>'.$i.'</td>  
  <td>'.$getVendorName['vendor_name'].'</td>
  <td>'.$row['totalMilk'].'</td>
  <td>'.$row['price'].'</td>
  <td>'.$row['totalMilk']*$row['price'].'</td>
 </tr>'; 

$i++; }
$tbl .='</table>';
$tbl .='<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";>
 <tr>
  <th colspan="5" align="center" style="background-color: #eaa934; color: white; font-weight:bold">Grand Total</th>
 </tr>
 <tr>
  <td></td>  
  <td></td>
  <td>'.$totalLtrs.'</td>
  <td></td> 
  <td>'.$grandTotal.'</td>
 </tr></table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+