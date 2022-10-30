<?php
error_reporting( E_ALL ^ E_DEPRECATED );
//http://www.setasign.de/products/pdf-php-solutions/fpdi-protection-128/

function pdfEncrypt ($origFile, $password, $destFile){

	// require_once('fpdi/FPDI_Protection.php');
	require_once (APPPATH.'libraries/fpdi-pass/FPDI_Protection.php');
	$pdff = new FPDI_Protection();

	$pdff->FPDF("P", "in", array('8.27','11.69'));

	$pagecount = $pdff->setSourceFile($origFile);

	for ($loop = 1; $loop <= $pagecount; $loop++) {
   	 	$tplidx = $pdff->importPage($loop);
    	$pdff->addPage();
    	$pdff->useTemplate($tplidx);
	}

	$pdff->SetProtection(array(),$password);
	$pdff->Output($destFile,'I');

	return $destFile;
}

	$password = "aisin@2018";
	$origFile = "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/".$no_doc.".pdf";
	$destFile = $no_doc.".pdf";

	pdfEncrypt($origFile, $password, $destFile );
	// $pdff->Output("/var/www/aisin-web/AIS_PP/assets/Document/Master_list/".$no_doc.".pdf", 'F');
	// redirect(base_url('assets/Document/Master_list/'.$no_doc.'.pdf'));
?>