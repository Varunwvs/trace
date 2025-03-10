<?php
$id = $_GET['id'];
$cid = $_GET['cid'];
/*Serial Information*/
$sinfo = $this->db->select('sbsid, batch_id, serialno, cid')->from('microirrigationbatchserial')->where('sbsid', $id)
->get();
foreach($sinfo->result() as $srow){
    $batch_id = $srow->batch_id;
    $serialno = $srow->serialno;
}
/*Company Information*/
$cinfo = $this->db->select('address, city, state, pincode')->from('users')->where('id', $_GET['cid'])->get();
foreach($cinfo->result() as $crow){
    $address = $crow->address;
    $city = $crow->city;
    $state = $crow->state;
    $pincode = $crow->pincode;
}
/*Batch Information*/
$binfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty')
->from('microirrigationbatch')
->where(array('id'=> $batch_id, 'c_id'=>$_GET['cid']))->get();
foreach($binfo->result() as $brow){
    $pid = $brow->pid;
    $p_code = $brow->p_code;
    $batch_no = $brow->batch_no;
}

$pinfo = $this->db->select('name, marketed_by, itemcategory, subcategory, p_code, p_name, b_name, unit_w, net_w, 
c_id, cml, cmlbis, licno')->from('microirrigationproduct')->where(array('id'=>$pid,'c_id'=>$cid))->get();
foreach($pinfo->result() as $row){
	$name = $row->name;//cname
	$marketed_by = $row->marketed_by;
	$p_category = $row->itemcategory;
	$sub_category = $row->subcategory;
    $p_name = $row->p_name;
    $b_name = $row->b_name;
    $unit_w = $row->unit_w;
    $net_w = $row->net_w;
    $cid = $row->c_id;
    $cml = $row->cml;
    $cmlbis = $row->cmlbis;
    $licno = $row->licno;
}


$addresslabel = ucwords($address).', '.ucwords($city).', '.ucwords($state).' - '.$pincode;
$text = 'Product Name : '.$p_name.PHP_EOL.
'Brand Name : '.$b_name.PHP_EOL.
'UPC : '.$p_code.PHP_EOL.
'Batch No : '.$batch_no.PHP_EOL.
'cml : '.$cml.PHP_EOL.
'C.I.B No. : '.$cmlbis.PHP_EOL.
'Mfg. Lic. No. : '.$licno.PHP_EOL.
'Serial No : '.$serialno;
// create new PDF document
$width = 150;
$height = 100;
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
$pdf->SetRightMargin(2.3);
$pdf->setLeftMargin(2.3);

$pdf->setHeaderMargin(1.3);
$pdf->SetFooterMargin(13); //13mm

// $pdf->SetMargins(7.25, 8.7);

// // set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 8.7);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L', $pageLayout);


$html = '<table border="0" cellpadding="5" width="100%">
            <tr>
                <td align="left" width="75%" style="border-bottom: 1px solid black;"><h1>'.ucwords($name).'</h1> <br> '.ucwords($addresslabel).'</td>
                <td width="25%" style="border-bottom: 1px solid black;">
                    <div style="font-size:5pt">&nbsp;</div>
                    <div style="font-size:5pt">&nbsp;</div>
                    <div style="font-size:5pt">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td style="border-color:white; width:50%;"><h4>Product Name : '.ucwords($p_name).'</h4></td>
                <td style="border-color:white; width:50%;"><h4>Brand Name : '.ucwords($b_name).'</h4></td>
            </tr>
            <tr>
                <td style="border-color:white;"><h4>Product Category : '.ucwords($p_category).'</h4></td>
                <td style="border-color:white;"><h4>Batch No : '.strtoupper($batch_no).'</h4></td>
            </tr>
            <tr>
                <td style="border-color:white"><h4>Sub Category : '.ucwords($sub_category).'</h4></td>
                <td style="border-color:white;"><h4>Net Weight / Packet : '.$net_w.' '.$unit_w.'</h4></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid black;"><h4>UPC : '.$p_code.'</h4></td>
                <td style="border-bottom: 1px solid black;"><h4>Serial No : '.$serialno.'</h4></td> 
            </tr>
            <tr>
                <td align="center" colspan="4" width="100%"><h4>Marketed By/RC Holders: <br> '.strtoupper($marketed_by).'</h4></td>
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
$pdf->write2DBarcode($text, 'QRCODE,L', 115, 4, 27, 27, $style, 'N');


// output the PDF document
$pdf->Output('label_'.$name.'_'.$p_name.'_'.$batch_no.'_'.$serialno.'.pdf', 'I');