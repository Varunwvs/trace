<?php
$id = $_GET['id'];//batch id
$adminrole = $_SESSION['role'];
$admin=substr($adminrole, 0, -6).'admin';
$center=substr($adminrole, 0, -6).'center';
// echo $admin;
if($_SESSION['role']==='company' || $_SESSION['role']==='rcholder'){
    $cid = $_GET['cid'];//company id
}else{
    $ccinfo = $this->db->select('id as cid')->from('users')
    ->where('role', $admin)
    ->get();
    foreach($ccinfo->result() as $ccrow){
        $cid = $ccrow->cid;
    }
}
// echo $cid;
$bid=0;
//batch info
// $btinfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date,certno, lotno, issue_date, test_date, valid_date')->from('seedbatch')
// ->where(array('id'=> $id, 'c_id'=>$_GET['cid']))->get();
$btinfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date, certno,processed_lot_no, issue_date, test_date, valid_date')->from('seedbatch')
->where(array('id'=> $id, 'c_id'=>$_GET['cid']))->get();
// echo $this->db->last_query();
foreach($btinfo->result() as $brow){
    $bid = $brow->id;
    $pid = $brow->pid;
    $p_code = $brow->p_code;
    $batch_no = $brow->batch_no;
    $mfd_date = $brow->mfd_date;
    $exp_date = $brow->exp_date;
    $certno  = $brow->certno;
    $lotno = $brow->processed_lot_no;
    $issue_date  = $brow->issue_date;
    $test_date  = $brow->test_date;
    $valid_date = $brow->valid_date;
}

//product info
$pinfo = $this->db->select('name, marketed_by, p_category, sub_category, p_code, p_name, b_name, unit_w, net_w, 
blkind, blvariety, blseedclass, blsign,c_id')
->from('seedproduct')->where(array('id'=>$pid,'c_id'=>$cid))->get();
foreach($pinfo->result() as $prow){
    $name = $prow->name;
	$marketed_by = $prow->marketed_by;
	$p_category = $prow->p_category;
	$sub_category = $prow->sub_category;
    $p_name = $prow->p_name;
    $b_name = $prow->b_name;
    $unit_w = $prow->unit_w;
    $net_w = $prow->net_w;
    $blkind = $prow->blkind;
    $blvariety = $prow->blvariety;
    $blseedclass = $prow->blseedclass;
    $blsign = $prow->blsign;
}
//serial info
$sinfo = $this->db->select('count(*) as scount,sbsid, batch_id, serialno, cid, created_at')->from('seedbatchserial')->where('batch_id', $brow->id)->get();
foreach($sinfo->result() as $srow){ 
    $scount = $srow->scount; 
    $serialno = $srow->serialno;
    $created_at = $srow->created_at;
}
/*Company Information*/
$cinfo = $this->db->select('name,address, city, state, pincode')->from('users')->where('id', $cid)->get();
foreach($cinfo->result() as $crow){
    $address = $crow->address;
    $city = $crow->city;
    $state = $crow->state;
    $pincode = $crow->pincode;
}
$addresslabel = ucwords($address).', '.ucwords($city).', '.ucwords($state).' - '.$pincode;
// create new PDF document
$width = 140.2;
$height = 75.2;
$pageLayout = array($width, $height);
$pdf = new Pdfbl(PDF_PAGE_ORIENTATION, 'mm', $pageLayout, true, 'UTF-8', false);
// $pdf = new Pdfprs(PDF_PAGE_ORIENTATION, 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Blue Label');
$pdf->SetSubject('Blue Label');
$pdf->SetKeywords('TCPDF, PDF, label, codeigniter, sql');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// // set margins
// $pdf->setTopMargin(1.0);
// $pdf->SetRightMargin(0.0);
// $pdf->setLeftMargin(2.8);

// $pdf->setHeaderMargin(1.0);
// $pdf->SetFooterMargin(1.3); //13mm

// // $pdf->SetMargins(0, 0, 0);
// $pdf->SetAutoPageBreak(false, 0);

$pdf->SetMargins(6.35, 6.35, 6.35); // 6.35mm margin on each side
$pdf->SetAutoPageBreak(false, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// add a page
$pdf->AddPage('L', $pageLayout);

$counter = 1;
$label_cols = 1; // No. of Columns
$label_w = 140.2; // Label width
$label_w_base_margin = 2.25; // Label width base margin
$label_h = 75.2; // Label height
$label_h_base_margin = 2.25; // Label height base margin - Do not change except you know what you are doing
$label_h_margin = $label_h - 2.25; // Label height margin - Do not change except you know what you are doing

$x = $pdf->GetX();
$y = $pdf->GetY();

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
    'fontsize' => 7,
    'stretchtext' => 2
);

$style = array(
    'border' => 0,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 0.2, // width of a single module in points
    'module_height' => 0.2, // height of a single module in points
    'stretchtext'=>2
);

$vendor_code = get_settings('vendor_code');
$srinfo = $this->db->select('serialno as srno, alias')->from('seedbatchserial')->where('batch_id', $brow->id)->get();
foreach($srinfo->result_array() as $srrow){ 
    $srno = $srrow['srno'];  
    $alias = $srrow['alias'];
    if ($y > 75.2) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }
    $text = '01'.$vendor_code.$srrow['alias'];
    
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    $pdf->SetXY($x,$y);
    
    $html = '<div style="font-size:10;">&nbsp;</div><table border="0" cellpadding="2.5" width="100%" style="font-size:11px">
                <tr>
                    <td align="center"></td>
                    <td align="right" style="font-size:8;">'.$blseedclass.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>'.$certno.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><h4 style="font-size:13; font-weight:700;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$blkind.'</h4></td>
                    <td align="right" style="font-size:8;">'.date('d-m-Y', strtotime($issue_date)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>'.date('d-m-Y', strtotime($test_date)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><h4 style="font-size:13; font-weight:700;">&nbsp;&nbsp;&nbsp;&nbsp;'.$blvariety.'</h4></td>
                    <td align="right" style="font-size:8;">'.date('d-m-Y', strtotime($valid_date)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>  
                <tr>
                    <td align="center"><h4 style="font-size:13; font-weight:700;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$lotno.'</h4></td>
                    <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="./uploads/blimg/'.$blsign.'" style="width:100px; height:20px;"/></td>
                </tr>  
                <tr>
                    <td align="center"><h4></h4></td>
                    <td align="center"></td>
                </tr>
                <tr>
                    <td align="center"><h4></h4></td>
                    <td align="center"></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><p style="margin:0;padding:0;font-size:8;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>01'.$vendor_code.$alias.'</strong></p></td>
                </tr>  
                <tr>
                    <td align="center" colspan="2"><h3 style="font-size:14; font-weight:700;"><strong>'.ucwords($marketed_by).'</strong></h3></td>
                </tr> 
            ';
    $html.='</table>';
    $pdf->write2DBarcode($text, 'QRCODE,L', $x+58, $y+28, 22, 22, $style, '');
    
    $pdf->writeHTML($html, true, false, true, false, '');
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


$pdf->Output('GR_'.$marketed_by.'_'.$p_name.'_'.$batch_no.'.pdf', 'I');