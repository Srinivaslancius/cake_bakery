<?php
//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
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
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

$price = 0;

// Include the main TCPDF library (search for installation path).
include_once('../../admin_includes/config.php');
require_once('tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData() {
        // Read file lines
        global $conn;
        /*$from_change_format =  date("Y-m-d", strtotime($_GET['start_date']));
        $to_change_format =  date("Y-m-d", strtotime($_GET['end_date']));
        if($from_change_format!='1970-01-01' && $to_change_format!='1970-01-01') {

        $getSelData = "SELECT users.user_name,users.street_name,users.user_mobile,milk_orders.start_date,milk_orders.end_date,IFNULL(milk_orders.total_ltr,0) as actual_ltrs,IFNULL(milk_orders.price_ltr,0)as price_ltr,sum(IFNULL(extra_milk_orders.extra_ltr,0)) as extra_ltrs,sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) as cancel_ltrs,milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) AS grand_total_milk,milk_orders.price_ltr *( milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0) ))as total_order_price,users.id FROM  milk_orders LEFT JOIN  users ON users.id = milk_orders.user_id LEFT JOIN extra_milk_orders ON milk_orders.user_id = extra_milk_orders.user_id LEFT JOIN cancel_milk_orders ON milk_orders.user_id= cancel_milk_orders.user_id WHERE DATE_FORMAT(milk_orders.start_date,'%Y-%m-%d') between '$from_change_format' AND '$to_change_format' GROUP BY users.id";        

        } else {

        $getSelData = "SELECT users.user_name,users.street_name,users.user_mobile,milk_orders.start_date,milk_orders.end_date,IFNULL(milk_orders.total_ltr,0) as actual_ltrs,IFNULL(milk_orders.price_ltr,0)as price_ltr,sum(IFNULL(extra_milk_orders.extra_ltr,0)) as extra_ltrs,sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) as cancel_ltrs,milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0)) AS grand_total_milk,milk_orders.price_ltr *( milk_orders.total_ltr+ sum(IFNULL(extra_milk_orders.extra_ltr,0)) - sum(IFNULL(cancel_milk_orders.cancel_ltr,0) ))as total_order_price,users.id FROM  milk_orders LEFT JOIN  users ON users.id = milk_orders.user_id LEFT JOIN extra_milk_orders ON milk_orders.user_id = extra_milk_orders.user_id LEFT JOIN cancel_milk_orders ON milk_orders.user_id= cancel_milk_orders.user_id GROUP BY users.id";
           
        }*/
        $getSelData = "SELECT first_name,city,mobile,order_id,product_name,product_quantity,product_price,product_total_price From orders";
        if($conn->query($getSelData)){
        $resultset = $conn->query($getSelData);
        }else{
        die('There was an error running the query [' . $conn->error . ']');
        }
        //$resultset = mysqli_query($conn, $getSelData) or die("database error:". mysqli_error($conn));
        //$lines = file($resultset);
        //echo "<pre>"; print_r($resultset); die;
        $data = array();
        while ($OrderData= $resultset->fetch_array()){
            //echo "<pre>"; print_r($milkOrderData);    
            //$values = implode(';', $milkOrderData);
            //array_push($data, $values);
            $data[] = $OrderData;
        }
        /*foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }*/
        return $data;
    }

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(53, 184, 99);
        $this->SetTextColor(255);
        $this->SetDrawColor(173, 169, 162);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(25, 25, 20, 20, 25, 18,18,20,);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row[6], 'LR', 0, 'C', $fill);
            $this->Cell($w[7], 6, $row[7], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Srinivas');
$pdf->SetTitle('Palle2Patnam');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

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
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();

// column titles
$header = array('Name', 'Address', 'Mobile', 'Order Id', 'Product Name', 'Quantity', 'Price', 'Total Price');

// data loading
$data = $pdf->LoadData();

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('monthly_order_pdf_reports.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
