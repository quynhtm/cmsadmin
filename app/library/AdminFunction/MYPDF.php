<?php
/**
 * Created by PhpStorm.
 * User: MT969
 * Date: 4/22/2015
 * Time: 10:07 AM
 */

class MYPDF extends TCPDF {
    protected $background_img;

    public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false, $background=null) {
        $this->background_img = $background;
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $this->SetAlpha(0.08);
        //$VCCorp = public_path().'/assets/images/pdf/logo_vc_vi.jpg';
        $this->StartTransform();
        $w = 173;
        $h = 50;
        $this->Rotate(45,$w >> 1, $h >> 1);
//        for ($i = 0; $i < 5; $i++){
//            $this->Image($VCCorp, -350 + $i*$w, 240, $w, $h, '', '', '', false, 300, '', false, false, 0);
//            $this->Image($VCCorp, -500 + $i*$w, 640, $w, $h, '', '', '', false, 300, '', false, false, 0);
//        }
        $this->StopTransform();
        if ($this->background_img){
            $this->SetAlpha(0.5);
            $this->Image($this->background_img, 530, 780, 64, 64, '', '', '', false, 72, '', false, false, 0);
        }
        $this->SetAlpha(1.0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}