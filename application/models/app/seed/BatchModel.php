<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Batch Model
 */
class BatchModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    } 
    
     //Datatable View
    function dtBatch(){
        $pid = $this->input->post('pid');
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date, status, api_sent,container_status,schedule_cron')
         ->from('seedbatch')->where(array('c_id'=>$_SESSION['comid'], 'pid'=>$pid, 'status'=>'1'))
        //  ->order_by("id", "desc")
         ->order_by("batch_no", "desc")
         ->get();
        $i=1;
        $output=[];
        $dis='';
        $link='';
        $is_primary = '0';
        $productDetails = $this->db->select('*')
                          ->from('seedproduct')->where(array('id' => $pid,'status' => '1'))
                          ->get()->result();
                if($productDetails){
                    foreach ($productDetails as $prod) {
                        $is_primary = $prod->onlyprimary;
                    }
                }
        foreach ($exp->result() as $row) {
            if($row->api_sent!=0){
                $dis = "disabled";
            }else{
                $dis = "";
            }
            if($row->schedule_cron=='1'){
                 $link = '<li class="text-xs">Scheduled</li>';
            }
            elseif($row->schedule_cron=='2'){
                $link = '<li class="list-inline-item"><a class="btn text-success btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> API Sent Successfully</a></li>';
            }elseif($row->schedule_cron=='3'){
                $link = '<li class="list-inline-item"><a class="btn text-warning btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> Something went wrong</a></li>';
            }else{
                if($row->container_status == '0'){
                    if($row->api_sent == '0'){
                        $link='<li class="list-inline-item"><button class="btn btn-outline-danger btn-xs sendApiBatchBtn" data-id="'.$row->id.'"><span class="fa-solid fa-cloud-arrow-up"></span> Send API Data</button></li>';
                    }else{
                        $link = '<li class="list-inline-item"><a class="btn text-success btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> API Sent Successfully</a></li>';
                    }
                }else{
                $link = '<li class="list-inline-item"><a class="btn text-red btn-xs" role="button" href="save_secondary_container_details?bid='.$row->id.'" data-toggle="tooltip" title="send secondary api data"> <span class="fa-solid fa-cloud-arrow-up"></span> API not sent</a></li>';
                }
            }
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="batchview?id='.$row->id.'" data-toggle="tooltip" title="View Batch Details"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="batchedit?id='.$row->id.'"> <span class="fa fa-edit" data-toggle="tooltip" title="Edit Batch Info"></span></a></li>';

                if($is_primary == '0' && $row->container_status == '0' && $row->api_sent == '0'){
                    $actionButton .= '<li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="containerentry?id='.$row->id.'"> <span class="fa-solid fa-plus" data-toggle="tooltip" title="Add Container"></span></a></li> </ul>';  
                }else{
                    $actionButton .=$link;
                }
            $output[] = array(
                $i++, 
                '<strong>'.ucwords($row->batch_no).'</strong>', 
                $row->s_no_qty,
                date('d-m-y', strtotime($row->mfd_date)),       
                date('d-m-Y', strtotime($row->exp_date)),
                $actionButton
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;  
        exit();
    }

    //Datatable View
    function dtSerial(){
        $vendor_code = get_settings('vendor_code');
        $primary_identifier = get_settings('primary_identifier');
        $bid = $this->input->post('bid');
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('sbs.sbsid, sbs.batch_id, sbs.serialno, sbs.cid, sbs.alias, sbs.api_sent, sb.pid, sb.batch_no, pr.p_name')
         ->from('seedbatchserial sbs')->where(array('sbs.cid'=>$_SESSION['comid'], 'sbs.batch_id'=>$bid, 'sb.id'=>$bid, 'sb.c_id'=>$_SESSION['comid']))
         ->join( 'seedbatch sb', 'sb.id = sbs.batch_id' , 'left' )
         ->join( 'seedproduct pr', 'pr.id = sb.pid' , 'left' )
         ->order_by("sbs.serialno", "asc")
         ->get();
         
        // echo $this->db->last_query(); exit;
         
        $i=1;
        $output=[];
        $dis='';
        foreach ($exp->result() as $row) {
            if($row->api_sent!=0){
                $dis = "disabled";
            }else{
                $dis = "";
            }
            $actionButton = '
              <ul class="list-inline"> 
                <li class="list-inline-item d-print-none"><a class="btn text-red btn-xs hidden" role="button" id="delete_serial" data-id="'.$row->sbsid.'" data-toggle="tooltip" title="Delete Serial Nos."> <span class="fa fa-trash"></span></a></li>
                <li class="list-inline-item"><a class="btn text-blue btn-xs" role="button" href="serialqrcodeprint?id='.$row->sbsid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print QRcode full label"> <span class="fa fa-qrcode"></span></a></li>
                <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" href="serialnqrcodeprint?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode small label"> <span class="fa fa-qrcode"></span></a></li>
                <li class="list-inline-item hidden"><a class="btn text-purple btn-xs" role="button" href="serialgqrcodeprint?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode green label"> <span class="fa fa-qrcode"></span></a></li>
              </ul>';

            $output[] = array(
                $i++, 
                '<strong>'.$row->serialno.'</strong>', 
                '<strong>'.$primary_identifier.$vendor_code.$row->alias.'</strong>',
                $actionButton
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        
        return $result;  
        exit();
    }
    
    public function get_maxalias(){
        $this->db->select_max('alias');
        $this->db->from('seedbatchserial');
        $res = $this->db->get()->row();
        return $res->alias;
     }
    
    //Add New Batch
      function addBatch(){
        $this->db->trans_start();
        $cid = $_SESSION['comid'];
        $pid = $this->input->post('pid');
        $upc = $this->input->post('upc');
        $batch_no = $this->input->post('batch_no');
        $s_no = $this->input->post('s_no');
        $mfg_date = date('Y-m-d', strtotime($this->input->post('mfg_date')));
        $exp_date = date('Y-m-d', strtotime($this->input->post('exp_date')));
        $status = "1";
        $count = (int)$this->input->post('s_no');
        
         $certno = $this->input->post('certno');
        $issue_date = date('Y-m-d', strtotime($this->input->post('issue_date')));
        $test_date = date('Y-m-d', strtotime($this->input->post('test_date')));
        $valid_date = date('Y-m-d', strtotime($this->input->post('valid_date')));

        $processed_lot_no = $this->input->post('processed_lot_no');

        $image=null;
        if(isset($_FILES["file"]["type"]) && !empty($_FILES["file"]["tmp_name"])) {
            $image = $this->uploadFile('file', 'uploads/lab_certification/');
            if(!$image) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

        // $result = '';
        $data = array('c_id'=>$cid, 'pid'=>$pid, 'p_code'=>$upc, 'batch_no'=>$batch_no, 's_no_qty'=>$s_no, 
        'mfd_date'=>$mfg_date, 'exp_date'=>$exp_date, 'status'=>$status, 'processed_lot_no'=>$processed_lot_no,
        'lab_certification'=>$image,
        'certno' => $certno,
        'issue_date'=>$issue_date,
        'test_date'=>$test_date,
        'valid_date'=>$valid_date
        );
        $result = $this->db->insert('seedbatch',$data);
        $insert_id = $this->db->insert_id();
        $srno = "18";
        
        $datat=array();
        $max_alias = $this->get_maxalias();
        for($x = 1; $x <= $count; $x++) {            
            $alias = $max_alias + 1;
            $cid = sprintf("%04d", $cid);
            $pid = sprintf("%04d", $pid);
            $bid = sprintf("%04d", $insert_id);
            $x = sprintf("%04d", $x);
            $y = $srno.$cid.$pid.$bid.$x;

	    //prepare array to insert
            $datat[]=array('batch_id'=>$insert_id, 'serialno'=>$y, 'cid'=>$cid,'alias' => $alias);
            $y++;
            $max_alias++;
        }

        if($datat){
        // Insert the data in batch
        $results = $this->db->insert_batch('seedbatchserial',$datat);

        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $output['success'] = false;
            $output['messages'] = 'Ooops! something went wrong';
        }else{
            $output['success'] = true;
            $output['messages'] = 'Successfully added!'; 
        }
        return $output;
    }

    function uploadFile($fileInputName, $targetDirectory) {
        $targetPath = $targetDirectory . basename($_FILES[$fileInputName]["name"]);
        $fileExtension = strtolower(pathinfo($targetPath,PATHINFO_EXTENSION));
        $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
    
        $targetPath = $targetDirectory . $newFileName;
    
        if(move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetPath)) {
            return $newFileName;
        } else {
            return false;
        }
    }
    //Delete Batch
    function delBatch(){
        $id=$this->input->post('member_id');
        $cid = $_SESSION['comid'];
        //for product
        $data = array('status'=>'0');
        $result = $this->db->update('seedbatch',$data,array('id'=>$id,'c_id'=>$cid));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Removed Batch';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing Batch!';
        }

        return($output);
    }

    //Delete Batch
    function delSerial(){
        $id=$this->input->post('member_id');
        $this->db->where('sbsid', $id);
        $result=$this->db->delete('seedbatchserial');
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Removed Serail';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing Serail!';
        }

        return($output);
    }

    //Edit Batch
    function updBatch(){
        $cid = $_SESSION['comid'];
        $edit_bid = $this->input->post('edit_bid');
        $edit_batch_no = $this->input->post('edit_batch_no');
        $edit_mfg_date = date('Y-m-d', strtotime($this->input->post('edit_mfg_date')));
        $edit_exp_date = date('Y-m-d', strtotime($this->input->post('edit_exp_date')));
        
        // $result = '';
        $data = array('batch_no'=>$edit_batch_no, 'mfd_date'=>$edit_mfg_date, 'exp_date'=>$edit_exp_date);
        $result = $this->db->update('seedbatch',$data,array('id'=>$edit_bid));
        
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully added!';  
        }
        else{
            $output['success'] = false;
            $output['messages'] = 'Ooops! something went wrong';
        }
        return $output;
    }
    
    public function getBatches($user_id){
        $user_ids = $this->session->userdata('comid');
        $result = $this->db->select('b.*')
        ->from('seedbatch b')
        ->where('b.c_id',$user_ids)
        // ->where('b.status','1')
        ->where('b.api_sent','0')
        // ->where('b.container_status','0')
        ->get()->result();
        return $result;
    }
    
    public function getsBatch($user_id, $bid){
        $user_ids = $this->session->userdata('comid');
        $result = $this->db->select('b.*')
        ->from('seedbatch b')
        ->where(array('b.c_id'=>$user_ids, 'b.id'=>$bid))
        // ->where('b.status','1')
        ->where('b.api_sent','0')
        // ->where('b.container_status','0')
        ->get()->result();
        return $result;
    }
    
    public function get_batch_serial_no($id){
        $result = $this->db->select('sbsid,serialno,alias')
        ->from('seedbatchserial')
        ->where('batch_id',$id)
        ->where('api_sent','0')
        ->get()->result();
        return $result;
    }

    public function update_batch_api($sid){
        $data = array('api_sent'=>'1');
        $this->db->where('sbsid',$sid);
        $this->db->update('seedbatchserial',$data);
    }
    
    public function update_batch($bid){
        $data = array('api_sent'=>'1');
        $this->db->where('id',$bid);
        $this->db->update('seedbatch',$data);
    }


    public function label_detail($sno){
        $this->db->select('b.*,p.p_code as productCode,bs.serialno as sr_no,bs.sbsid as sbsid,bs.alias as alias');
        $this->db->where('b.api_sent','0');
        $this->db->where('bs.serialno',$sno);
       // $this->db->where('b.id','519');
        $this->db->join('seedproduct p','p.id = b.pid');
        $this->db->join('seedbatchserial bs','bs.batch_id = b.id');
        $this->db->from('seedbatch b');
        return $this->db->get()->result();
    }
    
    public function batchExport($id,$comid){
        $this->db->select('p.p_name,p.p_code,p.p_category,p.sub_category,b.batch_no,b.mfd_date,b.exp_date,b.id as batchid');
        $this->db->where('b.id',$id);
        $this->db->join('seedproduct p','p.id = b.pid');
        $this->db->join('seedbatchserial bs','bs.batch_id = b.id');
        $this->db->from('seedbatch b');
        return $this->db->get()->result();
    }

    public function getSerialNumbers($batchid){
        $this->db->select('serialno,alias');
        $this->db->where('batch_id',$batchid);
        $this->db->from('seedbatchserial');
        return $this->db->get()->result();
    }
    
    public function update_batch_api_response($sid,$response){
        $data = array('api_response'=>$response);
        $this->db->where('sbsid',$sid);
        $this->db->update('seedbatchserial',$data);
    }
    
    //Datatable View
     function dtlyBatch(){
        $pid = $this->input->post('pid');
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date, status, api_sent,container_status,schedule_cron')
         ->from('seedbatch2324')->where(array('c_id'=>$_SESSION['comid'], 'pid'=>$pid, 'status'=>'1'))
        //  ->order_by("id", "desc")
         ->order_by("batch_no", "desc")
         ->get();
        $i=1;
        $output=[];
        $dis='';
        $link='';
        $is_primary = '0';
        $productDetails = $this->db->select('*')
                          ->from('seedproduct')->where(array('id' => $pid,'status' => '1'))
                          ->get()->result();
                if($productDetails){
                    foreach ($productDetails as $prod) {
                        $is_primary = $prod->onlyprimary;
                    }
                }
        foreach ($exp->result() as $row) {
            
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="lybatchview?id='.$row->id.'" data-toggle="tooltip" title="View Batch Details"> <span class="fa fa-eye"></span></a></li>
            </ul>';
            $output[] = array(
                $i++, 
                '<strong>'.ucwords($row->batch_no).'</strong>', 
                $row->s_no_qty,
                date('d-m-y', strtotime($row->mfd_date)),       
                date('d-m-Y', strtotime($row->exp_date)),
                $actionButton
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;  
        exit();
    }

    function dtlySerial(){
        $vendor_code = get_settings('vendor_code');
        $primary_identifier = get_settings('primary_identifier');
        $bid = $this->input->post('bid');
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('sbs.sbsid, sbs.batch_id, sbs.serialno, sbs.cid, sbs.alias, sbs.api_sent, sb.pid, sb.batch_no, pr.p_name')
         ->from('seedbatchserial2324 sbs')->where(array('sbs.cid'=>$_SESSION['comid'], 'sbs.batch_id'=>$bid, 'sb.id'=>$bid, 'sb.c_id'=>$_SESSION['comid']))
         ->join( 'seedbatch2324 sb', 'sb.id = sbs.batch_id' , 'left' )
         ->join( 'seedproduct pr', 'pr.id = sb.pid' , 'left' )
         ->order_by("sbs.serialno", "asc")
         ->get();
         
        // echo $this->db->last_query(); exit;
         
        $i=1;
        $output=[];
        $dis='';
        foreach ($exp->result() as $row) {        
            

            $output[] = array(
                $i++, 
                '<strong>'.$row->serialno.'</strong>', 
                '<strong>'.$primary_identifier.$vendor_code.$row->alias.'</strong>'
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        
        return $result;  
        exit();
    }
}