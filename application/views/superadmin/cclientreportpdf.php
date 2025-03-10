<?php
set_time_limit(600);
ignore_user_abort(true);
ob_start();
$pdf = new Pdfprs(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('WVS');
$pdf->SetTitle('Client Report');
$pdf->SetSubject('Client Report');
$pdf->SetKeywords('PDF, Client Report');
// remove default header/footer
$pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(12, 8, 12);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//font
$pdf->SetFont('helvetica', '', 9); 

// add a page
$pdf->AddPage('L');
$pdf->SetFont('helvetica', '', 10); 

$cat = $this->input->post('client_id');

$contentp1 = '<table border="0" cellpadding="5" cellspacing="0" style="width:100%;"> 
                <tr><td align="center"><h3>KisaanQR Client Details</h3></td></tr>';
                if($cat==='1'){                                                        
                    $contentp1 .='<tr><td align="center">(Seeds Company & RC Holders details)</td></tr>';
                }
                elseif($cat==='2' || $cat==='6'){                                                        
                    $contentp1 .='<tr><td align="center">(Fertilizers Company & RC Holders details)</td></tr>';
                }
                elseif($cat==='3'){                                                        
                    $contentp1 .='<tr><td align="center">(Micro Irrigations Company & RC Holders details)</td></tr>';
                }
                elseif($cat==='5'){                                                        
                    $contentp1 .='<tr><td align="center">(Pesticides Company & RC Holders details)</td></tr>';
                }
                elseif($cat==='7'){                                                        
                    $contentp1 .='<tr><td align="center">(Agro Processing Company & RC Holders details)</td></tr>';
                }
                else{
                    $prdcount = 0;
                }
                
                $contentp1 .='<tr>
                    <td>
                        <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
                            <tr>
                                <th align="center">S.No.</th>
                                <th>Client Name</th>
                                <th align="center">Phone No.</th>
                                <th>Email ID</th>
                                <th>Address</th>
                                <th align="center">Category</th>
                                <th align="center">Product Count</th>
                                <th align="center">Product Count Used</th>
                                <th align="center">QR Quantity</th>
                                <th align="center">QR Quantity Used</th>
                            </tr>';
                            $cinfo = $this->db->select('u.id, u.name, u.category, u.email, u.contact, u.city, u.state, 
                            u.pincode, u.address, u.totalproduct, u.status, u.qr_quantity, ct.name as catname')->from('users u')
                            ->join('categories ct','ct.id=u.category','left')
                            ->where(array('u.status'=>'1', 'category'=>$cat))->order_by('u.category', 'asc')->get();
                            $ccount = $cinfo->num_rows();
                            if($ccount>0){
                                $i=1;
                                $catname='';
                                foreach($cinfo->result() as $row){                                    
                                    $contentp1.= '<tr>
                                                    <td align="center">'.$i++.'</td>
                                                    <td>'.$row->name.'</td>
                                                    <td align="center">'.$row->contact.'</td>
                                                    <td>'.$row->email.'</td>
                                                    <td>'.$row->address.'</td>
                                                    <td align="center">'.$row->catname.'</td>
                                                    <td align="center">'.$row->totalproduct.'</td>';
                                                    if($row->category==='1'){                                                        
                                                        $prcount = $this->db->select('*')->from('seedproduct')->where(array('c_id'=>$row->id, 'status'=>'1'))->get();                                                        
                                                        $prdcount = $prcount->num_rows();
                                                    }
                                                    elseif($row->category==='2' || $row->category==='6'){                                                        
                                                        $prcount = $this->db->select('*')->from('fertilizerproduct')->where(array('c_id'=>$row->id, 'status'=>'1'))->get();                                                        
                                                        $prdcount = $prcount->num_rows();
                                                    }
                                                    elseif($row->category==='3'){                                                        
                                                        $prcount = $this->db->select('*')->from('microirrigationproduct')->where(array('c_id'=>$row->id, 'status'=>'1'))->get();                                                        
                                                        $prdcount = $prcount->num_rows();
                                                    }
                                                    elseif($row->category==='5'){                                                        
                                                        $prcount = $this->db->select('*')->from('pesticideproduct')->where(array('c_id'=>$row->id, 'status'=>'1'))->get();                                                        
                                                        $prdcount = $prcount->num_rows();
                                                    }
                                                    elseif($row->category==='7'){                                                        
                                                        $prcount = $this->db->select('*')->from('tarpaulinproduct')->where(array('c_id'=>$row->id, 'status'=>'1'))->get();                                                        
                                                        $prdcount = $prcount->num_rows();
                                                    }
                                                    else{
                                                        $prdcount = 0;
                                                    }
                                                    if($prdcount > 0){
                                                        $contentp1.= '<td align="center">'.$prdcount.'</td>';
                                                    }
                                                    else{
                                                        $contentp1.= '<td align="center">0</td>';
                                                    }
                                                    $contentp1.= '
                                                    <td align="center">'.$row->qr_quantity.'</td>';
                                                    if($row->category==='1'){
                                                        $lbl='seed';
                                                        $pqrqty = $this->db->select('*')->from('seedbatchserial')->where(array('cid'=>$row->id))->get();                                                        
                                                        $pqrcount = $pqrqty->num_rows();
                                                        $sqrqty = $this->db->select('*')->from('seedcontainer')->where(array('cid'=>$row->id))->get();
                                                        $sqrcount = $sqrqty->num_rows();
                                                        $qrcount = $pqrcount + $sqrcount;
                                                    }
                                                    elseif($row->category==='2' || $row->category==='6'){
                                                        $lbl='fertilizer';
                                                        $pqrqty = $this->db->select('*')->from('fertilizerbatchserial')->where(array('cid'=>$row->id))->get();                                                        
                                                        $pqrcount = $pqrqty->num_rows();
                                                        $sqrqty = $this->db->select('*')->from('fertilizercontainer')->where(array('cid'=>$row->id))->get();                                                        
                                                        $sqrcount = $sqrqty->num_rows();
                                                        $qrcount = $pqrcount+$sqrcount;
                                                    }
                                                    elseif($row->category==='3'){
                                                        $lbl='micro_irrigation';
                                                        $qrqty = $this->db->select('*')->from('microirrigationbatchserial')->where(array('cid'=>$row->id))->get();                                                        
                                                        $qrcount = $qrqty->num_rows();
                                                    }
                                                    elseif($row->category==='5'){
                                                        $lbl='pesticide';
                                                        $pqrqty = $this->db->select('*')->from('pesticidebatchserial')->where(array('cid'=>$row->id))->get();                                                        
                                                        $pqrcount = $pqrqty->num_rows();
                                                        $sqrqty = $this->db->select('*')->from('pesticidecontainer')->where(array('cid'=>$row->id))->get();                                                        
                                                        $sqrcount = $sqrqty->num_rows();
                                                        $qrcount = $pqrcount+$sqrcount;
                                                    }
                                                    elseif($row->category==='7'){
                                                        $lbl='agro_processing';
                                                        $qrqty = $this->db->select('*')->from('tarpaulinbatchserial')->where(array('cid'=>$row->id))->get();                                                        
                                                        $qrcount = $qrqty->num_rows();
                                                    }
                                                    else{
                                                        $qrcount = 0;
                                                    }
                                                    if($qrcount > 0){
                                                        $contentp1.= '<td align="center">'.$qrcount.'</td>';
                                                    }
                                                    else{
                                                        $contentp1.= '<td align="center">0</td>';
                                                    }
                                                $contentp1.='</tr>';
                                }

                            }else{
                                $contentp1.='<tr><td colspan="10">No Data Exists!</td></tr>';
                            }
                        $contentp1 .='</table>
                    </td>
                </tr>
            </table>';

$pdf->writeHTML($contentp1, true, false, true, false, '');

$pdf_file_name = $lbl.'_client_report.pdf';
$pdf->Output($pdf_file_name, 'I');
ob_end_flush();