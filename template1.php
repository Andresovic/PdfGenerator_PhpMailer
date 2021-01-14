<?php
// PHPMailer files.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
// first require the constants file TCPDF/files/config/tcpdf_config_alt.php
require_once('TCPDF/files/config/tcpdf_config_alt.php');
// then require the principal class to create PDF File
require_once('TCPDF/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// // set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// // set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('helvetica', '', 10);
$pdf->SetMargins(10, 16, 10, 0);
// add a page
$pdf->AddPage();
// define some HTML content with style
$html = file_get_contents('template.html');
//
$pdf->SetCellPadding(0);
//
$tagvs = array(
				'h1' => array(0 => array('h' => 1, 'n' => 3), 1 => array('h' => 1, 'n' => 2)),
				'h2' => array(0 => array('h' => 1, 'n' => 1), 1 => array('h' => 1, 'n' => 1)), 
				'p' =>  array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 1))
			  );
$pdf->setHtmlVSpace($tagvs);
//
$pdf->setCellHeightRatio(1.3);
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();
// output
$pdf->Output('reporte.pdf', 'I');
//Close and output PDF document
// $filename = 'report.pdf'; 
// $pdfString = $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/'. $filename, 'S');

// // ---------------------------------------------------------
// // Instantiation and passing `true` enables exceptions
// $mail = new PHPMailer(true);
// try {
//     // Server settings
//     $mail->SMTPDebug = 2;                                       // Enable verbose debug output
//     $mail->isSMTP();
//     $mail->SMTPKeepAlive = true;                                // Send using SMTP
//     $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//     $mail->Username   = 'juarezp.david@gmail.com';              // SMTP username
//     $mail->Password   = '***';                     // SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//     $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//     //Recipients
//     $mail->setFrom('juarezp.david@gmail.com');
//     $mail->addAddress('juarezp.david@gmail.com');               // Add a recipient

//     // Attachments
//     $mail->AddStringAttachment($pdfString, $filename);

//     // Content
//     $mail->isHTML(true);                                  		// Set email format to HTML
//     $mail->Subject = 'Profauna | Laboratorios';
//     $mail->Body    = 'Estudio Espermatobioscopia';
//     $mail->AltBody = 'Este es ele reporte digital de la evaluacion del paciente.';

//     // Activo condificacción utf-8
//     $mail->CharSet = 'UTF-8';

//     $mail->send();
//     $mail->SmtpClose();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }