<?php
$id = $_GET['id'];//batch id
$cid = $_GET['cid'];
// create new PDF document
$width = 60;
$height = 80;
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
$pdf->SetRightMargin(1.5);
$pdf->setLeftMargin(1.5);

$pdf->setHeaderMargin(2);
$pdf->SetFooterMargin(1); //13mm

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 1);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage('L', $pageLayout);
$pdf->SetFont('helvetica', '', 7);
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
    'fontsize' => 6,
    'stretchtext' => 1
);

$counter = 1;
$label_cols = 1; // No. of Columns
$label_w = 60; // Label width
$label_w_base_margin = 3.25; // Label width base margin
$label_h = 80; // Label height
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
$srinfo = $this->db->query("SELECT tbs.serialno as srno, tbs.alias, tb.pid, tb.p_code, tb.batch_no, tb.s_no_qty, tb.mfd_date, tb.exp_date, 
    tp.name, tp.marketed_by, tp.itemcategory, tp.subcategory, tp.p_code, tp.p_name, tp.b_name, tp.unit_w, 
    tp.net_w, tp.cml, tp.cmlbis, tp.licno, tp.gsm FROM tarpaulinbatchserial tbs 
    LEFT JOIN tarpaulinbatch tb ON tb.id=tbs.batch_id 
    LEFT JOIN tarpaulinproduct tp ON tp.id=tb.pid WHERE tbs.batch_id=$id AND tb.id=$id AND tbs.cid=$cid AND tb.c_id=$cid LIMIT 2000");
// $srinfo = $this->db->select('serialno as srno')->from('tarpaulinbatchserial')
// ->where('batch_id', $brow->id)->get();
foreach($srinfo->result_array() as $srrow){ 
    $srno = $srrow['srno'];  
    $alias = '0110'.$srrow['alias'];  
    if ($y > 80) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }
    if ($y > 80) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }

    $text = $alias;
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->setCellMargins(0,0,0,0);
    $pdf->write2DBarcode($text, 'QRCODE,L', $x+45, $y+9, 34, 34, $style, 'N');
    //is number
    if (preg_match('/IS\s(\d+)\/(\d+)/', $srrow['p_name'], $matches)) {
        $is_numbers = "IS " . $matches[1] . " : " . $matches[2];
    }
    //Color
    if (preg_match('/\(([^)]+)\)\s*Multi Layered/i', $srrow['p_name'], $matches1)) {
        $color = $matches1[1];
    } elseif (preg_match('/\b(Black|BLUE|Yellow)\b/i', $srrow['p_name'], $matches2)) {
        $color = $matches2[1];
    } else {
        $color = "Unknown"; // Default value if color is not found
    }
    //Sizes
    if (preg_match('/\b(\d+)\s*GSM\b/', $srrow['p_name'], $matches3)) {
        $gsm_value = $matches3[1] . " GSM";
    }
    //pname
    $hdpe_tarpaulin_found = preg_match('/HDPE Tarpaulin/', $srrow['p_name']);

    if ($hdpe_tarpaulin_found) {
        $phrases = "HDPE Tarpaulin".' '.'(Type-II)'.' '.$gsm_value;
    }else{
        $phrases = "Multi Layered Cross Laminated".' '.$gsm_value;
    }
    $pdf->SetXY($x,$y);
    
    $pdf->setCellPaddings(0, 5);
    $html = '<table border="0" cellpadding="2" width="100%">
            <tr>
                <td width="20%" align="center"><img src="assets/images/CEPL_Logo.jpg"  width="35" height="35" /></td>
                <td align="center" colspan="2" width="80%">';
                    if($_SESSION['role']==='rcholder'){
                        $html .= '<h5 style="font-size:10px;">Manufatured By :<br>'.ucwords($srrow['marketed_by']).'</h5>';
                    }
                    elseif($_SESSION['role']==='company'){                        
                        $html .= '<h5 style="font-size:10px;">Manufatured By :<br>'.ucwords($srrow['name']).'</h5>';
                    }
                    else{
                        $html .= '<h3 style="font-size:10px;">Manufatured By :<br>'.ucwords($srrow['name']).'</h3>';
                    }  
                $html .='</td>
            </tr>
            <tr style="height: auto;">
                <td width="20%" align="center"><img src="assets/images/isi.png" width="22" height="22" /></td>
                <td><div style="font-size:5px;">&nbsp;</div><b>'.$is_numbers.'</b></td>
                <td rowspan="7" align="center"><div style="font-size:80px;">&nbsp;</div>'.$alias.'</td>
            </tr>
            <tr>
                <td width="25%"><b>CM / L - </b></td>
                <td style="border-color:white;"><b>'.$srrow['cml'].'</b></td>
            </tr>
            <tr>
                <td colspan="2" style="border-color:white; font-size:6;"><b>'.$phrases.'</b></td>
            </tr>
            <tr>
                <td width="25%"><b>Color :</b></td>
                <td style="border-color:white;"><b>'.$color.'</b></td>
            </tr>
            <tr>
                <td width="25%"><b>Size :</b></td>
                <td style="border-color:white;"><b>8m x 6m</b></td>
            </tr>
            <tr>
                <td width="25%"><b>Batch No :</b></td>
                <td style="border-color:white;"><b>'.strtoupper($srrow['batch_no']).'</b></td>
            </tr>
            <tr>
                <td width="25%"><b>Year :</b></td>
                <td style="border-color:white;"><b>'.date('Y', strtotime($srrow['mfd_date'])).'</b></td>
            </tr>
            <tr>
                <td colspan="2" width="100%"><img src="assets/images/tpfooter.jpg" style="width:300;height:35;"></td>
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