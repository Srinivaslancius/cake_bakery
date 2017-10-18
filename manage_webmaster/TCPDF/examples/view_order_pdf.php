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
$getUserData = getIndividualDetails($uid,'orders','id');
$getData = $getUserData['order_id'];
 
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srinivas');
$pdf->SetTitle('Palle2Patnam - Invoice');
$pdf->SetSubject('Palle2Patnam');
$pdf->SetKeywords('Palle2Patnam, PDF, example, test, guide');

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
  <th colspan="4" align="center" style="font-weight:bold;">Order Invoice<br /> '.$getUserData['first_name'].' <br /><span style="text-align:left; font-weight:normal">Bill To : <br />'.$getUserData['address1'].' <br/> '.$getUserData['district'].'<br /> '.$getUserData['pin_code'].' <br/> <strong>'.$getUserData['order_id'].'</strong></span><p style="text-align:right; font-weight:normal">Date :  '.$getUserData['order_date'].'</p></th>
 </tr>
 <tr style="background-color: #4CAF50; color: white; font-weight:bold">
  <th align="center">Name</th>  
  <th align="center">Quantity</th>
  <th align="center">Price</th>
  <th align="center">Total Price</th>
    
 </tr>'; 
 $sql = "SELECT * from orders where order_id = '$getData' ";

if($conn->query($sql)){
    $resultset = $conn->query($sql);
}else{
    die('There was an error running the query [' . $conn->error . ']');
}
  $grnadTotal = 0;
  while($row = $resultset->fetch_assoc()){
    $grnadTotal += $row['product_total_price'];
$tbl .='<tr style="border-bottom:0; margin: 0px;"> 
  
  
  <td align="center">'.$row['product_name'].'</td>
  <td align="center">'.$row['product_quantity'].'</td>
  <td align="center">'.$row['product_price'].'</td>
  <td align="center">'.$row['product_total_price'].'</td>
    
 </tr>'; 
 }
$tbl .='</table>';
$tbl .='<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";>
 <tr>
  <td colspan="4" align="right" style="background-color: #eaa934; color: white; font-weight:bold">Grand Total : '.$grnadTotal.'</td>
 </tr>
 </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('view_order_pdf.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+