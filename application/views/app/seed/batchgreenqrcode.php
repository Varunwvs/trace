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
$btinfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date')->from('seedbatch')
->where(array('id'=> $id, 'c_id'=>$_GET['cid']))->get();
// echo $this->db->last_query();
foreach($btinfo->result() as $brow){
    $bid = $brow->id;
    $pid = $brow->pid;
    $p_code = $brow->p_code;
    $batch_no = $brow->batch_no;
    $mfd_date = $brow->mfd_date;
    $exp_date = $brow->exp_date;
}

//product info
$pinfo = $this->db->select('name, marketed_by, p_category, sub_category, p_code, p_name, b_name, unit_w, net_w, 
mrp, germination, phypurity, moisture, inertmatter, othercrop, genpur, weedseed,c_id')
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
    $mrp = $prow->mrp;
    $germination = $prow->germination;
    $phypurity = $prow->phypurity;
    $moisture = $prow->moisture;
    $inertmatter = $prow->inertmatter;
    $othercrop = $prow->othercrop;
    $genpur = $prow->genpur;
    $weedseed = $prow->weedseed;
}
if($weedseed > 0){
    $weedseed=$weedseed;
}else{
    $weedseed="NONE";
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
$width = 146;
$height = 96;
$pageLayout = array($width, $height);
$pdf = new Pdfprs(PDF_PAGE_ORIENTATION, 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Green Label');
$pdf->SetSubject('Green Label');
$pdf->SetKeywords('TCPDF, PDF, label, codeigniter, sql');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(6.35, 6.35, 6.35); // 6.35mm margin on each side
$pdf->SetAutoPageBreak(false, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage('L', $pageLayout);

$counter = 1;
$label_cols = 1; // No. of Columns
$label_w = 146; // Label width
$label_w_base_margin = 3.25; // Label width base margin
$label_h = 96; // Label height
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
    if ($y > 96) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }
    $text = '01'.$vendor_code.$srrow['alias'];
    
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    $pdf->SetXY($x,$y);
    
    $html = '<table border="0" cellpadding="2" width="100%" style="font-size:11px">
                <tr>
                    <td width="25%" style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;">
                    <strong>Label No.: '.$pdf->getAliasNumPage().'</strong></td>
                    <td width="75%" align="center" style="border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;font-size:13px;">
                    <strong>Label</strong></td>
                </tr>
                <tr>
                <td style="border-left:1px solid black; width:50%;"><h4>PURE SEED (Min):  '.$phypurity.'%</h4></td>
                <td style="border-right:1px solid black; width:50%;"><h4>CROP NAME: '.ucwords($p_name).'</h4></td>
            </tr>
            <tr>
                <td style="border-left:1px solid black;"><h4>INNERT MATTER (Max): '.$inertmatter.'%</h4></td>
                <td style="border-right:1px solid black;"><h4>CLASS OF SEEDS: '.ucwords($sub_category).'</h4></td>
            </tr>
            <tr>
                <td style="border-left:1px solid black;"><h4>OTHER CROP (Max): '.$othercrop.'%</h4></td>
                <td style="border-right:1px solid black;"><h4>VARIETY: '.ucwords($b_name).'</h4></td>
            </tr>
            <tr>
                <td style="border-left:1px solid black;"><h4>WEED SEED (Max): '.$weedseed.'</h4></td>
                <td style="border-right:1px solid black;"><h4>LOT NO: '.strtoupper($batch_no).'</h4></td>
            </tr>
            <tr>
                <td style="border-left:1px solid black;"><h4>GERMINATION (Min): '.$germination.'%</h4></td>
                <td style="border-right:1px solid black;"><h4>DATE OF TEST: '.date('d-m-Y', strtotime($mfd_date)).'</h4></td> 
            </tr>
            <tr>
                <td style="border-left:1px solid black;"><h4>Gen. Purity (Min): '.$genpur.'%</h4></td>
                <td style="border-right:1px solid black;"><h4>DATE OF PACKING: '.date('M-Y', strtotime($created_at)).'</h4></td>
            </tr>
            <tr>
                <td style="border-left:1px solid black;"><h4>MOISTURE (Min): '.$moisture.'%</h4></td> 
                <td style="border-right:1px solid black;"><h4>VALID UPTO : '.date('d-m-Y', strtotime($exp_date)).'</h4></td> 
            </tr>
            <tr>
                <td style="border-left:1px solid black;"><h4>NET WEIGHT: '.$net_w.' '.$unit_w.'</h4></td>
                <td style="border-right:1px solid black;" align="right">';
                if($cid==='24' || $cid==='116' || $cid==='117' || $cid==='314'){
                    $html.='<img src="./assets/images/sign.png" style="width:120px; height:29px;"/>';
                }
                elseif($cid==='175'){
                    $html.='<img src="./assets/images/gowrishankarsign.png" style="width:120px; height:29px;"/>';
                }
                else{
                    $html.='';
                }
                // $x = $pdf->GetX();
                // $y = $pdf->GetY();
                // $pdf->setCellMargins(0,0,0,0);
                
                $html.='</td>
            </tr>
            <tr>
                <td style="border-left:1px solid black;border-bottom:1px solid black;"><h4>M.R.P.: '.$mrp.'/- (inc. of all taxes)</h4></td>
                <td style="border-right:1px solid black;border-bottom:1px solid black;" align="right">Sig. of Processing Plant Incharge</td>
            </tr>
            <tr>
                <td align="center" width="75%" style="font-size:13px;">';
                    $pdf->setCellMargins(0,0,0,0);
                    $html.='<h5 style="margin:0;padding:0;">Marketed By/RC Holder</h5>
                    <h3>'.ucwords($marketed_by).'</h3>
                    <h5>'.ucwords($addresslabel).'</h5> 
                </td>
                <td width="25%" align="center">
                    <div style="font-size:12px;">&nbsp;</div>
                    <div><p style="margin:0px;padding:0px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>01'.$vendor_code.$alias.'</strong></p></div>
                </td>
            </tr>
            ';
    $html.='</table>';
    $pdf->write2DBarcode($text, 'QRCODE,L', $x+107, $y+57, 22, 22, $style, '');
    
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