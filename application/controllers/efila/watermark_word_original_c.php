<?php
//This page contains edit the existing file by using fpdi.
require(APPPATH.'libraries/fpdf/fpdf.php');
require_once (APPPATH.'libraries/fpdi-pass/fpdi.php');
// require_once (APPPATH.'libraries/FPDI/fpdi/FPDI_Protection.php');


class PDF_Rotate extends FPDI {

    var $angle = 0;
    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

}

// $fullPathToFile = APPPATH.'controllers/efila/1.pdf';

class PDF extends PDF_Rotate {
    // global $fullPathToFile;
    var $_tplIdx;
    
    function Header() {
        // echo $file;
        // exit();
        // $fullPathToFile = $this->fullPathToFile;
        // echo $fullPathToFile;        
        //Put the watermark
        // $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 40, 100, 100, 0, 'PNG');
        // chdir("/var/www/aisin-web/AIS_PP/assets/Document/Master_list/");
        // echo getcwd();
        // $fullPathToFile = getcwd().$fullPathToFile;
        global $fullPathToFile;
        echo file_exists($fullPathToFile);
        global $no_doc;
        global $rev;
        global $effective_date;
        $this->SetFont('Courier', 'B', 25);
        $this->SetTextColor(169,169,169);
        $this->RotatedText(35, 200, 'Approved By EFILA Document System', 45);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }

        $this->SetFont('Courier', 'B', 15);
        $this->SetTextColor(30, 144, 255);
        $this->RotatedText(15, 255, 'This sheet is an', 0);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }

        $this->SetFont('Courier', 'B', 30);
        $this->SetTextColor(30, 144, 255);
        $this->RotatedText(15, 265, 'Original', 0);

        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }

        $this->SetFont('Courier', 'B', 15);
        $this->SetTextColor(30, 144, 255);
        $this->RotatedText(15, 275, 'Only if stamped in blue', 0);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }
        // $this->useTemplate($this->_tplIdx, 0, 0, 200);
        // date_default_timezone_set('Asia/Jakarta');
        // $today1 = date("Y-m-d");
        // $today2 = date_create($today1);
        // $tgl = date_format($today2,"d-m-Y");

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->RotatedText(155, 280, "Approved By System", 0);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->RotatedText(155, 18, $no_doc, 0);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->RotatedText(160, 27, $effective_date, 0);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->RotatedText(187, 35, $rev, 0);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            // $this->numPages = $this->setSourceFile(VarStream::createReference($fullPathToFile));
            $this->_tplIdx = $this->importPage(1);
        }

        // $this->SetFont('Courier', 'B', 10);
        // $this->SetTextColor(0, 0, 0);
        // $this->RotatedText(20, 260, 'EFILA Document System', 0);
        
        // if (is_null($this->_tplIdx)) {

        //     // THIS IS WHERE YOU GET THE NUMBER OF PAGES
        //     $this->numPages = $this->setSourceFile($fullPathToFile);
        //     $this->_tplIdx = $this->importPage(1);
        // }

        $this->useTemplate($this->_tplIdx, 0, 0, 200);     
    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

}

# ==========================

$pdf = new PDF();
//$pdf = new FPDI();
$pdf->AddPage();
$pdf->SetFont('Courier', '', 12);


/*$txt = "FPDF is a PHP class which allows to generate PDF files with pure PHP, that is to say " .
        "without using the PDFlib library. F from FPDF stands for Free: you may use it for any " .
        "kind of usage and modify it to suit your needs.\n\n";
for ($i = 0; $i < 25; $i++) {
    $pdf->MultiCell(0, 5, $txt, 0, 'J');
}*/


if($pdf->numPages>1) {
    for($i=2;$i<=$pdf->numPages;$i++) {
        //$pdf->endPage();
        $pdf->_tplIdx = $pdf->importPage($i);
        $pdf->AddPage();
    }
}

// require(APPPATH.'controllers/efila/pdf_protection_c.php');

// $pdfp = new FPDF_Protection();
// $pdfp->SetProtection(array('print'));
// $pdfp->AddPage();
// $pdfp->SetFont('Courier');
// $pdfp->Write(10,'You can print me but not copy my text.');
// $pdfp->Output();

ob_end_clean();
$pdf->Output("/var/www/aisin-web/AIS_PP/assets/Document/Master_list/".$no_doc.".pdf", 'I');
// redirect(base_url('assets/Document/Master_list/'.$no_doc.'.pdf'));
// $pdf->Output("/var/www/aisin-web/AIS-DEV/assets/Document/Master_list/".$no_doc.".pdf", 'F'); //If you Leave blank then it should take default "I" i.e. Browser
//$pdf->Output("sampleUpdated.pdf", 'D'); //Download the file. open dialogue window in browser to save, not open with PDF browser viewer
//$pdf->Output("save_to_directory_path.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
//$pdf->Output("sampleUpdated.pdf", 'I'); //I for "inline" to send the PDF to the browser
//$pdf->Output("", 'S'); //return the document as a string. filename is ignored.
?>
