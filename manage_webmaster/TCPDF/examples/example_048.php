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

$sql = "SELECT milk_orders.id,milk_orders.total_ltr as total_ltrs,milk_orders.user_id, extra_milk_orders.extra_ltr, extra_milk_orders.order_date, milk_orders.start_date, milk_orders.end_date,users.user_name,users.id FROM milk_orders LEFT JOIN extra_milk_orders ON milk_orders.user_id=extra_milk_orders.user_id LEFT JOIN users ON users.id=milk_orders.user_id WHERE milk_orders.user_id = $uid AND DATE_FORMAT(order_date,'%Y-%m-%d') between milk_orders.start_date AND milk_orders.end_date ";
if($conn->query($sql)){
    $resultset = $conn->query($sql);
}else{
    die('There was an error running the query [' . $conn->error . ']');
}


$sql1 = "SELECT milk_orders.id,milk_orders.total_ltr as total_ltrs,milk_orders.user_id, cancel_milk_orders.cancel_ltr, cancel_milk_orders.cancel_date, milk_orders.start_date, milk_orders.end_date,users.user_name,users.id FROM milk_orders LEFT JOIN cancel_milk_orders ON milk_orders.user_id=cancel_milk_orders.user_id LEFT JOIN users ON users.id=milk_orders.user_id WHERE milk_orders.user_id = $uid AND DATE_FORMAT(cancel_date,'%Y-%m-%d') between milk_orders.start_date AND milk_orders.end_date ";
if($conn->query($sql1)){
    $resultset1 = $conn->query($sql1);
}else{
    die('There was an error running the query [' . $conn->error . ']');
}

$getTotalLtrs = "SELECT total_ltr,price_ltr from milk_orders WHERE milk_orders.user_id = $uid AND DATE_FORMAT(start_date,'%Y-%m-%d') between milk_orders.start_date AND milk_orders.end_date";
$totalltr = $conn->query($getTotalLtrs);
$gettotal = $totalltr->fetch_array();
$TotalLtrs = $gettotal[0];
$priceinLtr = $gettotal[1];

$getUserName = getIndividualDetails($uid,'users','id'); 
$getGetDate = getIndividualDetails($uid,'milk_orders','user_id'); 
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
  <th colspan="3" align="center" style="font-weight:bold;">User Monthly Milk Report - Order Invoice<br /> '.$getUserName['user_name'].' <br /><span style="text-align:left; font-weight:normal">Bill To : <br />'.$getUserName['street_name'].' , '.$getUserName['street_no'].'<br /> '.$getUserName['flat_name'].', '.$getUserName['flat_no'].'<br /> '.$getUserName['location'].', '.$getUserName['landmark'].'<br /> '.$getUserName['user_mobile'].'<br /> '.$getUserName['user_email'].'</span><p style="text-align:right; font-weight:normal">Start Date :  '.$getGetDate['start_date'].'<br />End Date :  '.$getGetDate['end_date'].' </p></th>
 </tr>
 <tr style="background-color: #4CAF50; color: white; font-weight:bold">
  <th align="center">Package Name</th>  
  <th align="center">Total Ltrs</th>
  <th align="center">Price/Ltr</th>  
 </tr>'; 
$tbl .='<tr style="border-bottom:0;; margin: 0px;">  
  <td>Monthly -  Milk </td>
  <td>'.$TotalLtrs.'</td>
  <td>'.$priceinLtr.'</td>  
 </tr>'; 
$tbl .='</table>';

$cntExtraLtrs = $resultset->num_rows;
$cntCancelLtrs = $resultset1->num_rows;
$total = 0;
$total1 = 0;
if($cntExtraLtrs!=0) {
    $tbl .= '<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";>
     <tr>
      <th colspan="2" align="center" style="font-weight:bold;">Extra Ordered Milk </th>
     </tr>
     <tr style="background-color: #4CAF50; color: white; font-weight:bold">
      <th align="center">Date</th>  
      <th align="center">Ltrs</th>      
     </tr>'; 
    while ($milkOrderData= $resultset->fetch_array()){
        $total += $milkOrderData['extra_ltr'];
        $tbl .='<tr style="border-bottom:0;; margin: 0px;">        
          <td align="center">'.$milkOrderData['order_date'].'</td>
          <td align="center">'.$milkOrderData['extra_ltr'].'</td>  
         </tr>'; 
    }
    $tbl .='<tr style="background-color:#e0e0e0;"><td align="center"><b>Total Extra Lts</b></td><td align="center"><b>'.$total.'</b></td></tr>';
    $tbl .= '</table>';   
}

if($cntCancelLtrs!=0) {
    $tbl .= '<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";>
     <tr>
      <th colspan="2" align="center" style="font-weight:bold;">Cancelled Milk Orders </th>
     </tr>
     <tr style="background-color: #4CAF50; color: white; font-weight:bold">
      <th align="center">Date</th>  
      <th align="center">Ltrs</th>      
     </tr>';     
    while ($milkCancelData= $resultset1->fetch_array()){
        $total1 += $milkCancelData['cancel_ltr'];
        $tbl .='<tr style="border-bottom:0;; margin: 0px;">        
          <td align="center">'.$milkCancelData['cancel_date'].'</td>
          <td align="center">'.$milkCancelData['cancel_ltr'].'</td>  
         </tr>'; 
    }
    $tbl .='<tr style="background-color:#e0e0e0;"><td align="center"><b>Total Cancelled Lts</b></td><td align="center"><b>'.$total1.'</b></td></tr>';
    $tbl .= '</table>';   
}

$grnadTotal =  $TotalLtrs+$total-$total1;
$grnadTotalPrice =  $grnadTotal*$priceinLtr;
$tbl .='<table border="1" cellpadding="6" cellspacing="0" nobr="true" border-collapse: "collapse";>
 <tr>
  <th colspan="5" align="center" style="background-color: #eaa934; color: white; font-weight:bold">Total Ltrs : '.$grnadTotal.'</th>
 </tr>
 <tr>
  <th colspan="5" align="center" style="background-color: #eaa934; color: white; font-weight:bold">Total Price : '.$grnadTotalPrice.'</th>
 </tr></table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+