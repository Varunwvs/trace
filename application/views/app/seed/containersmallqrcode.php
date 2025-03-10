<?php


$id = $_GET['id'];//batch id
$cid = $_GET['cid'];//company id
$bid=0;

// create new PDF document
$width = 104.14;
$height = 25.4;
$pageLayout = array($width, $height);
$pdf = new Pdfprs(PDF_PAGE_ORIENTATION, 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Secondary Container QR Code');
$pdf->SetSubject('Secondary Container QR Code');
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
    'fontsize' => 12,
    'stretchtext' => 2
);

$counter = 1;
$label_cols = 2; // No. of Columns
$label_w = 49; // Label width
$label_w_base_margin = 3.25; // Label width base margin
$label_h = 21; // Label height
$label_h_base_margin = 4.7; // Label height base margin - Do not change except you know what you are doing
$label_h_margin = $label_h - 4.7; // Label height margin - Do not change except you know what you are doing

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
$ucc_identifier = get_settings('ucc_identifier');
$primary_identifier = get_settings('primary_identifier');
// for( ; $i < $scount ; $i++)
// {       
 $sql="SELECT `sc`.`ctid`, `sc`.`pid`, `sc`.`ucc`, `sc`.`batchno`, `sc`.`serialno`, 
        `sc`.`alias`, GROUP_CONCAT('0110', `sbs`.`alias` SEPARATOR ', ') as palias, `sc`.`totalno` 
        FROM `seedcontainer` as `sc` LEFT JOIN `seedbatchserial` as `sbs` ON `sbs`.`ucc_id` = `sc`.`ctid` 
        WHERE `sc`.`cid` = $cid AND `sc`.`batchno` = $id AND `sbs`.batch_id=$id GROUP BY `sc`.`alias` ORDER BY `sc`.`ucc` ASC";
        
        //echo $sql; exit;
        
        $query = $this->db->query($sql);
        
//echo var_dump($query->result_array());exit();
//$srinfo = $this->db->select('ctid,alias,totalno')->from('seedcontainer')->where('batchno', $id)->get();
$pid='';
foreach($query->result_array() as $srrow){ 
    $pid = $srrow['pid'];
    //var_dump($srrow['palias']);
   //$first_row =  $this->db->select('alias')->from('seedbatchserial')->where('ucc_id', $srrow['ctid'])->order_by('sbsid','asc')->limit(1)->get()->row();
  // $first_row_data = $first_row->alias;
   //$first_row_value = $primary_identifier.$vendor_code.$first_row_data;
   $palias_arr = explode(', ',$srrow['palias']);
   $first_row_value =  current($palias_arr);
//   $last_row =  $this->db->select('alias')->from('seedbatchserial')->where('ucc_id', $srrow['ctid'])->order_by('sbsid','desc')->limit(1)->get()->row();
//   $last_row_data = $last_row->alias;
//   $last_row_value = $primary_identifier.$vendor_code.$last_row_data;
    $last_row_value = end($palias_arr);

    if ($y > 21) { 
        $pdf->AddPage('L', $pageLayout);
        $y = $pdf->GetY();
    }
    $text = $ucc_identifier.$vendor_code.$srrow['alias'];
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->setCellMargins(0,0,0,0);
    $pdf->write2DBarcode($text, 'QRCODE,L', $x, $y-1, 23, 23, $style, 'N');
    
    // set font
    $pdf->SetFont('helvetica', '', 8);
    $pdf->setCellPaddings( $left = '21', $top = '0', $right = '0', $bottom = '0');
   $pdf->writeHTMLCell($label_w, $label_h, $x, $y, '<br><br>UCC: '.$ucc_identifier.$vendor_code.$srrow['alias'].'<br>Qty: '.$srrow['totalno'].'<br>'.$first_row_value.' - '.$last_row_value, 0, 0, 0, true, $style_label, '', 'M');
    
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
// $id = $_GET['id'];//batch id
// $cid = $_GET['cid'];//company id
$bnfo = $this->db->select('batch_no')->from('seedbatch')->where('id', $id)->get();
foreach($bnfo->result() as $brow){
    $batch_no = $brow->batch_no;
}
$cnfo = $this->db->select('name')->from('users')->where('id', $cid)->get();
foreach($cnfo->result() as $crow){
    $name = $crow->name;
}
$pnfo = $this->db->select('p_name')->from('seedproduct')->where('id', $pid)->get();
foreach($pnfo->result() as $prow){
    $p_name = $prow->p_name;
}

// ob_end_clean();
// output the PDF document
$pdf->Output('SC_'.$name.'_'.$p_name.'_'.$batch_no.'.pdf', 'I');