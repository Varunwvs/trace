<?php
$ctid = $_GET['ctid'];
$sr_no = '';
//container info
$ctinfo = $this->db->select('ctid, ucc, serialno, totalno,cid')->from('seedcontainer')->where('ctid', $ctid)->get();
foreach($ctinfo->result() as $ctrow){
    $serialno = $ctrow->serialno;
    $totalno = $ctrow->totalno;
    $cid = $ctrow->cid;
}
$sr_no = explode(',', $serialno);
$sno = $sr_no[0];
//company info
$cinfo = $this->db->select('address, city, state, pincode')->from('users')->where('id', $cid)->get();
foreach($cinfo->result() as $crow){
    $address = $crow->address;
    $city = $crow->city;
    $state = $crow->state;
    $pincode = $crow->pincode;
}
//Serail info
$batch_id='';
$bsinfo = $this->db->select('batch_id, serialno, cid')->from('seedbatchserial')
        ->where(array('serialno'=>$sno, 'cid'=>$cid))->get();
foreach($bsinfo->result() as $bsrow){
    $batch_id = $bsrow->batch_id;
}
//Batch Info
$pid='';
$batch_no='';
$binfo = $this->db->select('pid,batch_no,mfd_date, exp_date')->from('seedbatch')->where('id', $batch_id)->get();
foreach($binfo->result() as $brow){
    $pid = $brow->pid;
    $batch_no = $brow->batch_no;
    $mfd_date = date('d-m-Y', strtotime($brow->mfd_date));
    $exp_date = date('d-m-Y', strtotime($brow->exp_date));
}
//Product Info
$name='';
$p_name='';
$b_name='';
$p_category='';
$sub_category='';
$mfd_date='';
$exp_date='';
$net_w='';
$unit_w='';
$marketed_by='';
$pinfo = $this->db->select('name, marketed_by, p_category, sub_category, p_code, p_name, b_name, unit_w, net_w, c_id')->from('seedproduct')->where('id',$pid)->get();
foreach($pinfo->result() as $row){
	$name = $row->name;//cname
	$marketed_by = $row->marketed_by;
	$p_category = $row->p_category;
	$sub_category = $row->sub_category;
    $p_name = $row->p_name;
    $b_name = $row->b_name;
    $unit_w = $row->unit_w;
    $net_w = $row->net_w;
    $cid = $row->c_id;
}

$addresslabel = ucwords($address).', '.ucwords($city).', '.ucwords($state).' - '.$pincode;
$text = 'Batch No : '.$batch_no.PHP_EOL.'Serial No : '.$serialno;
// // create new PDF document
$pdf = new Pdfprs(PDF_PAGE_ORIENTATION, 'mm', 'A4', true, 'UTF-8', false);

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
$pdf->SetRightMargin(7.25);
$pdf->setLeftMargin(7.25);

$pdf->setHeaderMargin(8.7);
$pdf->SetFooterMargin(13); //13mm

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 8.7);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('times', '', 11);

// add a page
$pdf->AddPage('P', 'A4');   

$html = '<table border="1" cellpadding="6">
            <tr>
                <td colspan="4" align="center"><h1>'.$name.'</h1> <br> '.$addresslabel.'</td>
            </tr>
            <tr>
                <td style="border-color:white; width:22%;"><h4>Product Name : </h4></td>
                <td style="border-color:white; width:21%;"><h4>'.ucwords($p_name).'</h4></td>
                <td style="border-color:white; width:17%;"><h4>Brand Name : </h4></td>
                <td style="border-color:white; width:40%;"><h4>'.ucwords($b_name).'</h4></td>
            </tr>
            <tr>
                <td style="border-color:white;"><h4>Product Category : </h4></td>
                <td style="border-color:white;"><h4>'.ucwords($p_category).'</h4></td>
                <td style="border-color:white;"><h4>Batch No : </h4></td>
                <td style="border-color:white;"><h4>'.$batch_no.'</h4></td>
            </tr>
            <tr>
                <td style="border-color:white"><h4>Sub Category :</h4></td>
                <td style="border-color:white"><h4>'.ucwords($sub_category).'</h4></td>
                <td style="border-color:white"><h4>Mfg Date :</h4></td>
                <td style="border-color:white"><h4>'.$mfd_date.'</h4></td>
            </tr>
            <tr>
                <td style="border-color:white;"><h4>Net Weight / Packet :</h4></td>
                <td style="border-color:white;"><h4>'.$net_w.' '.$unit_w.'</h4></td>
                <td style="border-color:white;"><h4>Exp Date :</h4></td>
                <td style="border-color:white;"><h4>'.$exp_date.'</h4></td>
            </tr>
            <tr>
                <td style="border-color:white"><h4>Serial No :</h4></td>
                <td style="border-color:white"><h4>'.$serialno.'</h4></td>  
                <td style="border-color:white" colspan="2" rowspan="5">

                </td>              
            </tr>
            <tr>
                <td style="border-color:white"><h4>Total no of packets:</h4></td>
                <td style="border-color:white"><h4>'.$totalno.' PKT</h4></td>
            </tr>
            <tr>
                <td style="border-color:white" colspan="2"></td>
            </tr>
            <tr>
                <td style="border-color:white" colspan="2"></td>
            </tr>
            <tr>
                <td style="border-color:white" colspan="2"><h4>Marketed By/RC Holders: <br> '.strtoupper($marketed_by).'</h4></td>
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
$pdf->write2DBarcode($text, 'QRCODE,L', 110, 70, 35, 35, $style, 'N');


// output the PDF document
$pdf->Output('sec_label_.pdf', 'I');