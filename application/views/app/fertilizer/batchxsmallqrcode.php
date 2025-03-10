<?php
$id = $_GET['id'];//batch id
$cid = $_GET['cid'];//company id
$bid=0;
//batch info
$btinfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date')->from('fertilizerbatch')->where(array('id'=> $id, 'c_id'=>$cid))->get();
foreach($btinfo->result() as $brow){
    $bid = $brow->id;
    $pid = $brow->pid;
    $p_code = $brow->p_code;
    $batch_no = $brow->batch_no;
    $mfd_date = $brow->mfd_date;
    $exp_date = $brow->exp_date;
}
//product info
$pinfo = $this->db->select('name, marketed_by, itemcategory, subcategory, p_code, p_name, b_name, unit_w, net_w, c_id')->from('fertilizerproduct')->where(array('id'=>$pid,'c_id'=>$cid))->get();
foreach($pinfo->result() as $prow){
	$marketed_by = $prow->marketed_by;
	$p_category = $prow->itemcategory;
	$sub_category = $prow->subcategory;
    $p_name = $prow->p_name;
    $b_name = $prow->b_name;
    $unit_w = $prow->unit_w;
    $net_w = $prow->net_w;
}
//serial info
$sinfo = $this->db->select('count(*) as scount,sbsid, batch_id, serialno, cid, alias')->from('fertilizerbatchserial')->where('batch_id', $brow->id)->get();
foreach($sinfo->result() as $srow){ 
    $scount = $srow->scount; 
    $serialno = $srow->serialno;  
    $alias = $srow->alias;
}
/*Company Information*/
$cinfo = $this->db->select('name,address, city, state, pincode')->from('users')->where('id', $cid)->get();
foreach($cinfo->result() as $crow){
    $name = $crow->name;
    $address = $crow->address;
    $city = $crow->city;
    $state = $crow->state;
    $pincode = $crow->pincode;
}
$addresslabel = ucwords($address).', '.ucwords($city).', '.ucwords($state).' - '.$pincode;
// create new PDF document
$width = 104.14;
$height = 25.4;
$pageLayout = array($width, $height);
$pdf = new Pdfprs(PDF_PAGE_ORIENTATION, 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('1x1 inch QR Code');
$pdf->SetSubject('1x1 inch QR Code');
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
$pdf->SetFooterMargin(2); //13mm

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 2);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage('L', $pageLayout);

$style_label = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 1
);

$counter = 1;
$label_cols = 4; // No. of Columns
$label_w = 25.4; // Label width
$label_w_base_margin = 2.5; // Label width base margin
$label_h = 25.4; // Label height
$label_h_base_margin = 2.5; // Label height base margin - Do not change except you know what you are doing
$label_h_margin = $label_h - 2.5; // Label height margin - Do not change except you know what you are doing

$x = $pdf->GetX();
$y = $pdf->GetY();

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

$i = 0;
$vendor_code = get_settings('vendor_code');
// for( ; $i < $scount ; $i++)
// {       
$srinfo = $this->db->select('alias')->from('fertilizerbatchserial')->where('batch_id', $brow->id)->get();
foreach($srinfo->result_array() as $srrow){ 
    if ($y > 25.4) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }
    $text = '01'.$vendor_code.$srrow['alias'];
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    $pdf->setCellMargins(0,0,0,0);
    $pdf->write2DBarcode($text, 'QRCODE,L', $x, $y-2, 30, 30, $style, '');
    
    // set font
    $pdf->SetFont('helvetica', '', 7);
    $pdf->setCellPaddings( $left = '3', $top = '0', $right = '0', $bottom = '0');
    $pdf->writeHTMLCell($label_w, $label_h, $x, $y, '<div style="font-size:40pt">&nbsp;</div>01'.$vendor_code.$srrow['alias'], 0, 0, 0, true, $style_label, '', '');
    $x = $x + $label_w + $label_w_base_margin;
    if($counter == $label_cols)
    {
        $pdf->Ln($label_h);
        $counter = 1;
        $x = $pdf->GetX();
        $y = $y + $label_h_base_margin + $label_h_margin;
    }else{
        $counter++;
    }
}




// ob_end_clean();
// output the PDF document
$pdf->Output('PR_XS_'.$marketed_by.'_'.$p_name.'_'.$batch_no.'.pdf', 'I');