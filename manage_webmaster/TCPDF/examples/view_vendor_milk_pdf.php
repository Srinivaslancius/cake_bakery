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
$uid = $_GET['uid'];

$getSelData = "SELECT vendor_milk_assign.id,vendors.vendor_name,vendor_milk_assign.created_date,vendor_milk_assign.milk_in_ltrs, vendor_milk_assign.price, vendor_milk_assign.milk_in_ltrs*vendor_milk_assign.price AS TotalLtrPrice From vendor_milk_assign LEFT JOIN  vendors on vendor_milk_assign.vendor_id = vendors.id  WHERE vendor_milk_assign.vendor_id ='$uid'"; 
if($conn->query($getSelData)){
    $resultset = $conn->query($getSelData);
}else{
    die('There was an error running the query [' . $conn->error . ']');
}

$getVendorName = getIndividualDetails($uid,'vendors','id'); 
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srinivas');
$pdf->SetTitle('Palle2Patnam');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

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
  <th colspan="5" align="center" style="font-weight:bold;">Milk Vendors Monthly Report <br /> '.$getVendorName['vendor_name'].'</th>
 </tr>
 <tr style="background-color: #4CAF50; color: white; font-weight:bold">
  <th align="center">S.NO</th>  
  <th align="center">Date</th>
  <th align="center">Milk In Ltrs</th>
  <th align="center">Price</th>
  <th align="center">Total</th>
 </tr>';
 $i=1;
 $totalLtrs=0;
 $grandTotal=0;
 $x=0;
while ($milkOrderData= $resultset->fetch_array()){
    /*$x++; 
    $class = ($x%2 == 0)? '#dfebff': '#FFFFFF';*/
    $totalLtrs += $milkOrderData['milk_in_ltrs'];
    $grandTotal += $milkOrderData['TotalLtrPrice'];
    //echo "<pre>"; print_r($milkOrderData); die;
$tbl .='<tr style="border-bottom:0;; margin: 0px;">
  <td align="center">'.$i.'</td>  
  <td align="center">'.$milkOrderData['created_date'].'</td>
  <td align="center">'.$milkOrderData['milk_in_ltrs'].'</td>
  <td align="center">'.$milkOrderData['price'].'</td>
  <td align="center">'.$milkOrderData['TotalLtrPrice'].'</td>
 </tr>'; 

$i++; }
$tbl .='</table>';
$tbl .='<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";>
 <tr>
  <th colspan="5" align="right" style="background-color: #eaa934; color: white; font-weight:bold">Total Ltrs : '.$totalLtrs.'</th></tr>
  <tr><th colspan="5" align="right" style="background-color: #eaa934; color: white; font-weight:bold">Total Price : '.$grandTotal.'</th>
 </tr></table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+