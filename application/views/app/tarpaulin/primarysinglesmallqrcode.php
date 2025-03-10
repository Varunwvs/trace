<?php
$id = $_GET['id'];
/*Serial Information*/
$sinfo = $this->db->select('sbsid, batch_id, serialno, cid,alias')->from('tarpaulinbatchserial')
->where('sbsid', $id)->get();
foreach($sinfo->result() as $srow){
    $batch_id = $srow->batch_id;
    $serialno = $srow->serialno;
    $cid = $srow->cid;
    $alias = $srow->alias;
}
/*Company Information*/
$cinfo = $this->db->select('address, city, state, pincode')->from('users')->where('id', $cid)->get();
foreach($cinfo->result() as $crow){
    $address = $crow->address;
    $city = $crow->city;
    $state = $crow->state;
    $pincode = $crow->pincode;
}
/*Batch Information*/
$binfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date')
->from('tarpaulinbatch')->where(array('id'=> $batch_id, 'c_id'=>$cid))->get();
foreach($binfo->result() as $brow){
    $pid = $brow->pid;
    $p_code = $brow->p_code;
    $batch_no = $brow->batch_no;
    $mfd_date = $brow->mfd_date;
    $exp_date = $brow->exp_date;
}
$pinfo = $this->db->select('name, marketed_by, itemcategory, subcategory, p_code, p_name, b_name, unit_w, net_w, 
c_id,cml, cmlbis, licno, gsm')->from('tarpaulinproduct')->where(array('id'=>$pid,'c_id'=>$cid))->get();
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
    $gsm = $row->gsm;
}
$vendor_code = get_settings('vendor_code');
//$text = '01'.$p_code.'10'.$batch_no.'21'.$serialno;
$text = '01'.$vendor_code.$alias.PHP_EOL.
'Product Name : '.$p_name.PHP_EOL.
'Brand Name : '.$b_name.PHP_EOL.
'Supplier Name : '.$marketed_by.PHP_EOL.
'UPC : '.$p_code.PHP_EOL.
'Batch No : '.$batch_no.PHP_EOL.
'CML : '.$cml.PHP_EOL.
'CM L BIS No. : '.$cmlbis.PHP_EOL.
'Mfg. Lic. No. : '.$licno.PHP_EOL.
'Serial No : '.$serialno.PHP_EOL.
'Mfg Date : '.$mfd_date.PHP_EOL.
'Exp Date : '.$exp_date;
// create new PDF document
$width = 104.14;
$height = 31.4;
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
$pdf->setTopMargin(2);
$pdf->SetRightMargin(3);
$pdf->setLeftMargin(3);

$pdf->setHeaderMargin(2);
$pdf->SetFooterMargin(4); //13mm

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 2);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('times', '', 8);

// add a page
$pdf->AddPage('L', $pageLayout);

$html = '<table border="0" cellpadding="5" style="width:60mm; height:25mm;">
           <tr>
            <td width="40%"></td>
            <td width="60%">
                <div style="font-size:1pt">&nbsp;</div>  
                <div style="font-size:0.5pt">&nbsp;</div> 
                01'.$vendor_code.$alias.'
                <div style="font-size:2pt">&nbsp;</div>
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
    'stretchtext'=>3
);

// QRCODE,L : QR-CODE Low error correction
$pdf->write2DBarcode($text, 'QRCODE,L', 1, 1, 50, 50, $style, 'N');
//(left, top,)

// output the PDF document
$pdf->Output('label_'.$name.'_'.$p_name.'_'.$batch_no.'_'.$serialno.'.pdf', 'I');