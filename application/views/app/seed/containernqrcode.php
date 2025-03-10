<?php
$ctid = $_GET['ctid'];
$sr_no = '';
//container info
$ctinfo = $this->db->select('ctid, ucc, serialno, totalno,cid,alias')->from('seedcontainer')->where('ctid', $ctid)->get();
foreach($ctinfo->result() as $ctrow){
    $ucc = $ctrow->ucc;
    $cid = $ctrow->cid;
    $alias = $ctrow->alias;
}

//company info
$cinfo = $this->db->select('name,address, city, state, pincode')->from('users')->where('id', $cid)->get();
foreach($cinfo->result() as $crow){
    $name = $crow->name;
    $address = $crow->address;
    $city = $crow->city;
    $state = $crow->state;
    $pincode = $crow->pincode;
}
$vendor_code = get_settings('vendor_code');
$ucc_identifier = get_settings('ucc_identifier');
$text = $ucc_identifier.$vendor_code.$alias;
// create new PDF document
$width = 101.6;
$height = 152.4;
$pageLayout = array($width, $height);
$pdf = new Pdfprs(PDF_PAGE_ORIENTATION, 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Label PDF');
$pdf->SetSubject('Label PDF');
$pdf->SetKeywords('TCPDF, PDF, label, codeigniter, sql');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setTopMargin(8.7);
$pdf->SetRightMargin(1.3);
$pdf->setLeftMargin(1.3);

$pdf->setHeaderMargin(8.7);
$pdf->SetFooterMargin(13); //13mm

// $pdf->SetMargins(7.25, 8.7);

// // set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 8.7);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('times', '', 11);

// add a page
$pdf->AddPage('P', $pageLayout);   

$html = '<table border="0" cellpadding="2" width="100%">
           <tr>
            <td width="35%"></td>
            <td width="65%">
                <div style="font-size:10pt">&nbsp;</div>
                UCC: '.$text.'
                <div style="font-size:10pt">&nbsp;</div>
                <div style="font-size:10pt">&nbsp;</div>
            </td>
           </tr>
        </table>';
$pdf->writeHTML($html, true, false, true, false, '');

// BARCODE

// set style for barcode
$style = array(
    'border' => 0,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1, // height of a single module in points
    'stretchtext'=>2
);

// QRCODE,L : QR-CODE Low error correction
$pdf->write2DBarcode($text, 'QRCODE,L', 6, 9, 27, 27, $style, 'N');


// output the PDF document
$pdf->Output('sec_label_'.$name.'.pdf', 'I');