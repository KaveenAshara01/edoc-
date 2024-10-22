<?php
// Include TCPDF library
require_once('../../libs/tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Edoc Today Report');
$pdf->SetSubject('Simple Report');
$pdf->SetKeywords('PDF, report, simple');

// Disable header and footer for simplicity
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(15, 20, 15);

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

session_start();

$doctorCount=$_SESSION["doccount"];
$patcount=$_SESSION["patcount"];
$appcount=$_SESSION["appcount"];
$schedulecount=$_SESSION["schedulecount"];
// Add some basic content
$html = <<<EOD
<h2>Today Report</h2>
<p>This report provides an overview of the current statistics on the dashboard.</p>
<h3>Statistics</h3>
<table border="1" cellpadding="4">
    <tr>
        <th><b>Statistic</b></th>
        <th><b>Count</b></th>
    </tr>
    <tr>
        <td>Total Doctors</td>
        <td>{$doctorCount}</td>
    </tr>
    <tr>
        <td>Total Patients</td>
        <td>{$patcount}</td>
    </tr>
    <tr>
        <td>Total Appointments Today</td>
        <td>{$appcount}</td>
    </tr>
    <tr>
        <td>Total Sessions Today</td>
        <td>{$schedulecount}</td>
    </tr>
</table>

EOD;

// Output the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF as a download
$pdf->Output('Edoc_Today_Report.pdf', 'D');
?>
