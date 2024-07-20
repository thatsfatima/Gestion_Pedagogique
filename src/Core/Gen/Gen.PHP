<?php

namespace Apps\Core\Gen;
use TCPDF;

class PDFGenerator {
    private $pdf;

    public function __construct() {
        $this->pdf = new TCPDF();
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('Votre Nom');
    }

    public function setTitle($title) {
        $this->pdf->SetTitle($title);
    }

    public function setSubject($subject) {
        $this->pdf->SetSubject($subject);
    }

    public function addPage() {
        $this->pdf->AddPage();
    }

    public function writeHTML($html) {
        $this->pdf->writeHTML($html, true, false, true, false, '');
    }

    public function output($filename, $destination = 'I') {
        $this->pdf->Output($filename, $destination);
    }

    public function saveToFile($filepath) {
        $this->output($filepath, 'F');
    }
}







