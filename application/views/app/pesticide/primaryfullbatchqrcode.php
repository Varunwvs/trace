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
$btinfo = $this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date')->from('pesticidebatch')
->where(array('id'=> $id, 'c_id'=>$_GET['cid']))->get();
foreach($btinfo->result() as $brow){
    $bid = $brow->id;
    $pid = $brow->pid;
    $p_code = $brow->p_code;
    $batch_no = $brow->batch_no;
    $mfd_date = $brow->mfd_date;
    $exp_date = $brow->exp_date;
}

//product info
$pinfo = $this->db->select('name, marketed_by, itemcategory, subcategory, p_code, p_name, b_name, unit_w, net_w, c_id, formulation, cibno, mlno')->from('pesticideproduct')->where(array('id'=>$pid,'c_id'=>$cid))->get();
foreach($pinfo->result() as $prow){
	$marketed_by = $prow->marketed_by;
	$p_category = $prow->itemcategory;
	$sub_category = $prow->subcategory;
    $p_name = $prow->p_name;
    $b_name = $prow->b_name;
    $unit_w = $prow->unit_w;
    $net_w = $prow->net_w;
    $formulation = $prow->formulation;
    $cibno = $prow->cibno;
    $mlno = $prow->mlno;
}
//serial info
$sinfo = $this->db->select('count(*) as scount,sbsid, batch_id, serialno, cid')->from('pesticidebatchserial')->where('batch_id', $brow->id)->get();
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
$width = 150;
$height = 100;
$pageLayout = array($width, $height);
$pdf = new Pdfprs(PDF_PAGE_ORIENTATION, 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Full Label QR Code');
$pdf->SetSubject('Full Label QR Code');
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
    'fontsize' => 8,
    'stretchtext' => 4
);

$counter = 1;
$label_cols = 1; // No. of Columns
$label_w = 150; // Label width
$label_w_base_margin = 3.25; // Label width base margin
$label_h = 100; // Label height
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
$srinfo = $this->db->select('serialno as srno')->from('pesticidebatchserial')->where('batch_id', $brow->id)->get();
foreach($srinfo->result_array() as $srrow){ 
    $srno = $srrow['srno'];  
    if ($y > 100) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }
    if ($y > 100) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }

    $text = 'Product Name : '.$p_name.PHP_EOL.
    'Brand Name : '.$b_name.PHP_EOL.
    'UPC : '.$p_code.PHP_EOL.
    'Batch No : '.$batch_no.PHP_EOL.
    'Formulation : '.$formulation.PHP_EOL.
    'C.I.B No. : '.$cibno.PHP_EOL.
    'Mfg. Lic. No. : '.$mlno.PHP_EOL.
    'Serial No : '.$srrow['srno'].PHP_EOL.
    'Mfg Date : '.$mfd_date.PHP_EOL.
    'Exp Date : '.$exp_date;
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->setCellMargins(0,0,0,0);
    $pdf->write2DBarcode($text, 'QRCODE,L', $x+110, $y-2, 27, 27, $style, 'N');
    
    $pdf->SetXY($x,$y);
    $html = '<table border="0" cellpadding="5" width="100%">
            <tr>
                <td align="left" width="75%" style="border-bottom: 1px solid black;">';
                    if($_SESSION['role']==='rcholder'){
                        $html .= '<h1>'.ucwords($marketed_by).'</h1> <br>'.ucwords($addresslabel);
                    }
                    elseif($_SESSION['role']==='company'){                        
                        $html .= '<h1>'.ucwords($name).'</h1> <br>'.ucwords($addresslabel);
                    }
                    else{
                        $html .= '<h1>'.ucwords($name).'</h1> <br>'.ucwords($addresslabel);
                    }  
                    
                $html .='</td>
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
                <td style="border-color:white"><h4>Mfg Date : '.date('d-m-Y', strtotime($mfd_date)).'</h4></td>
            </tr>
            <tr>
                <td style="border-color:white;"><h4>Net Weight / Packet : '.$net_w.' '.$unit_w.'</h4></td>
                <td style="border-color:white;"><h4>Exp Date : '.date('d-m-Y', strtotime($exp_date)).'</h4></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid black;"><h4>UPC : '.$p_code.'</h4></td>
                <td style="border-bottom: 1px solid black;"><h4>Serial No : '.$srrow['srno'].'</h4></td> 
            </tr>
            <tr>
                <td align="center" colspan="4" width="100%">';
                    if($_SESSION['role']==='rcholder'){
                        $html .= '<h4>Produced By: <br> '.strtoupper($name).'</h4>';
                    }
                    elseif($_SESSION['role']==='company'){                        
                        $html .= '<h4>Marketed By/RC Holders: <br> '.strtoupper($marketed_by).'</h4>';
                    }
                    else{
                        $html .= '<h4>Marketed By/RC Holders: <br> '.strtoupper($marketed_by).'</h4>';
                    }                    
                $html.='</td>
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
$pdf->Output('PR_FL_'.$marketed_by.'_'.$p_name.'_'.$batch_no.'.pdf', 'I');