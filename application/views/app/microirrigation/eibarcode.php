<?php
$id = $_GET['id'];//batch id
if($_SESSION['role']!='kssccenter'){
    $cid = $_GET['cid'];//company id
}else{
    $ccinfo = $this->db->select('id as cid')->from('users')->where('role', 'ksscadmin')->get();
    foreach($ccinfo->result() as $ccrow){
        $cid = $ccrow->cid;
    }
}
$bid=0;
//batch info
// $btinfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, bno,mfgdate')->from('microirrigationbatch')
$btinfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty')->from('microirrigationbatch')
->where(array('id'=> $id, 'c_id'=>$_GET['cid']))->get();
foreach($btinfo->result() as $brow){
    $bid = $brow->id;
    $pid = $brow->pid;
    $p_code = $brow->p_code;
    $batch_no = $brow->batch_no;
    // $bno = $brow->bno;
    // $mfgdate = date('M-y',strtotime($brow->mfgdate));
}

//product info
$pinfo = $this->db->select('name, marketed_by, itemcategory, subcategory, p_code, p_name, b_name, unit_w, 
net_w, c_id, cml, cmlbis, licno, spacingcm,diameter, wallthick,netquantity,discharge,usp,mrp,website')->from('microirrigationproduct')->where(array('id'=>$pid,'c_id'=>$cid))->get();
foreach($pinfo->result() as $prow){
	$marketed_by = $prow->marketed_by;
	$p_category = $prow->itemcategory;
	$sub_category = $prow->subcategory;
    $p_name = $prow->p_name;
    $b_name = $prow->b_name;
    $unit_w = $prow->unit_w;
    $net_w = $prow->net_w;
    $cml = $prow->cml;
    $cmlbis = $prow->cmlbis;
    $licno = $prow->licno;
    $spacingcm = $prow->spacingcm;
    $diameter = $prow->diameter;
    $netquantity = $prow->netquantity;
    $discharge = $prow->discharge;
    $usp = $prow->usp;
    $mrp = $prow->mrp;
    $website = $prow->website;
    $wallthick = $prow->wallthick;
}
//serial info
$sinfo = $this->db->select('count(*) as scount,sbsid, batch_id, serialno, cid')->from('microirrigationbatchserial')
->where('batch_id', $brow->id)->get();
foreach($sinfo->result() as $srow){ 
    $scount = $srow->scount; 
    $serialno = $srow->serialno;            
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
$width = 101.6;
$height = 101.6;
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
$pdf->setTopMargin(4);
$pdf->SetRightMargin(2.5);
$pdf->setLeftMargin(2.5);

$pdf->setHeaderMargin(4);
$pdf->SetFooterMargin(1.3); //13mm

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 1.3);

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
    'fontsize' => 7,
    'stretchtext' => 2
);

$counter = 1;
$label_cols = 1; // No. of Columns
$label_w = 101.6; // Label width
$label_w_base_margin = 3.25; // Label width base margin
$label_h = 101.6; // Label height
$label_h_base_margin = 7.25; // Label height base margin - Do not change except you know what you are doing
$label_h_margin = $label_h - 7.25; // Label height margin - Do not change except you know what you are doing

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

// for( ; $i < $scount ; $i++)
// {    
$srinfo = $this->db->select('serialno as srno,alias as alias_no')->from('microirrigationbatchserial')
->where('batch_id', $brow->id)->get();
foreach($srinfo->result_array() as $srrow){ 
    $srno = $srrow['srno'];  
    if ($y > 101.6) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }
    

    $text = 'Product Name : '.$p_name.PHP_EOL.
    'Brand Name : '.$b_name.PHP_EOL.
    'UPC : '.$p_code.PHP_EOL.
    'Batch No : '.$batch_no.PHP_EOL.
    'CML : '.$cml.PHP_EOL.
    'CM L BIS No. : '.$cmlbis.PHP_EOL.
    'Lic. No. : '.$licno.PHP_EOL.
    'Serial No : '.$srrow['srno'].PHP_EOL.
    'Alias No : '.$srrow['alias_no'];
    
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->setCellMargins(0,0,0,0);
    $pdf->write2DBarcode($text, 'QRCODE,L', $x+65, $y+62, 27, 27, $style, 'N');
    
    $pdf->SetXY($x,$y);
    $html = '<table border="0" cellpadding="2" width="100%" style="font-size:14px;">
            <tr>
                <td colspan="2" align="center" style="border-bottom: 1px solid black;">
                    <img src="assets/images/ei.jpg">
                ';
                $html .='</td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: 1px solid black;font-size:8px;">
                    Registered Office Address: No 293/1, 50th CROSS, 18th main rd, 3rd block, Rajajinagar, Bengaluru, Karnataka 560010, 
                    <br>visit: '.$website.'
                </td>
            </tr>
            <tr>
                <td style="border-color:white;font-size:8px; width:70%;">Spacing Centimeter (cm)</td>
                <td align="center" style="border-color:white;font-size:8px; width:30%;">IS:13488</td>
            </tr>
            <tr>
                <td align="center" style="border-color:white;font-size:13px;">'.$spacingcm.'</td>
                <td align="center" style="border-color:white;font-size:8px;"><img src="assets/images/isi.png" style="width:20px; height:20px;">
                <br/>CML: '.$cml.'</td>
            </tr>
            <tr>
                <td width="30%" style="border-color:white;font-size:8px;">Product Name :</td>
                <td colspan="2" width="70%" style="border-color:white;font-size:8px;">'.$p_name.'</td>
            </tr>
            <tr>
                <td width="30%" style="border-color:white;font-size:8px;">Diameter : </td>
                <td width="50%" style="border-color:white;font-size:8px;">'.$diameter.'</td>
                <td width="20%" style="border-color:white;font-size:8px;">Tested Ok.</td> 
            </tr>
            <tr>
                <td style="border-color:white;font-size:8px;">Wall Thickness (MM/MIL) :</td>
                <td colspan="2" style="border-color:white;font-size:8px;">'.$wallthick.'</td>
            </tr>
            <tr>
                <td width="30%" style="border-color:white;font-size:8px;">Net Quantity(Coil Length) :</td>
                <td width="30%" style="border-color:white;font-size:8px;">'.$netquantity.'</td>
                <td width="40%" align="center" style="border-color:white;font-size:8px;">&nbsp; &nbsp;'.$srrow['alias_no'].'</td>
            </tr> 
            <tr>
                <td style="border-color:white;font-size:8px;">Discharge :</td>
                <td colspan="2" style="border-color:white;font-size:8px;">'.$discharge.'</td>
            </tr>
            <tr>
                <td style="border-color:white;font-size:8px;">Month & Year of Manufacture :</td>
                <td colspan="2" style="border-color:white;font-size:8px;"></td>
            </tr>
            <tr>
                <td style="border-color:white;font-size:8px;">Unit Sale Price :</td>
                <td colspan="2" style="border-color:white;font-size:8px;">Rs '.number_format($usp,2).' per meter</td>
            </tr>
            <tr>
                <td style="border-color:white;font-size:8px;">Maximum Retail Price :</td>
                <td colspan="2" style="border-color:white;font-size:8px;">Rs '.number_format($mrp,2).'(inclusive of all taxes)</td>
            </tr>
            <tr>
                <td style="border-color:white;font-size:9px;">Batch No :</td>
                <td colspan="2" style="border-color:white;font-size:9px;"></td>
            </tr>
            <tr>
                <td colspan="3" style="border-color:white; font-size:8px;">For more details visit www.bis.gov.in</td>
            </tr>
            </table>';
            
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




// ob_end_clean();
// output the PDF document
$pdf->Output('labels.pdf', 'I');