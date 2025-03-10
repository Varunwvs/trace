<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * pesticide Batch Model
 */
class BatchModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'pesticidebatch';
        // Set orderable column fields
        $this->column_order = array('batch_no', 's_no_qty', 'mfd_date', 'exp_date', 'schedule_cron');
        // Set searchable column fields
        $this->column_search = array('batch_no', 's_no_qty', 'mfd_date', 'exp_date', 'schedule_cron');        
        // Set default order
        $this->order = array('created_at' => 'desc');
    }

    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){        
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->where(array('c_id'=>$_SESSION['comid'], 'pid'=>$postData['pid'],'status'=>'1'));
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
       
    /*
     * Count all records
     */
    public function countAll($postData){
        $this->db->where(array('c_id'=>$_SESSION['comid'], 'pid'=>$postData['pid'],'status'=>'1'));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('c_id'=>$_SESSION['comid'],'pid'=>$postData['pid'],'status'=>'1'));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
        $this->db->where(array('c_id'=>$_SESSION['comid'],'pid'=>$postData['pid'],'status'=>'1'));
        $this->db->from($this->table);
 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_maxalias(){
        $this->db->select_max('alias');
        $this->db->from('pesticidebatchserial');
        $res = $this->db->get()->row();
        if($res->alias!='' || $res->alias !=NULL){
            $rest = $res->alias;
        }else{
            $rest = "70000000";
        }      
        return $rest;  
    }

    //Add New Batch
    function addBatch(){
        $cid = $_SESSION['comid'];
        $pid = $this->input->post('pid');
        $upc = $this->input->post('upc');
        $batch_no = $this->input->post('batch_no');
        $s_no = $this->input->post('s_no');
        $mfg_date = date('Y-m-d', strtotime($this->input->post('mfg_date')));
        $exp_date = date('Y-m-d', strtotime($this->input->post('exp_date')));
        $status = "1";
        $count = (int)$this->input->post('s_no');
        $this->db->trans_start();
        // $result = '';
        $data = array('c_id'=>$cid, 'pid'=>$pid, 'p_code'=>$upc, 'batch_no'=>$batch_no, 's_no_qty'=>$s_no, 
        'mfd_date'=>$mfg_date, 'exp_date'=>$exp_date, 'status'=>$status);
        $result = $this->db->insert('pesticidebatch',$data);
        $insert_id = $this->db->insert_id();
        
        $datat=array();
        $max_alias = $this->get_maxalias();        
        // echo $max_alias; die();
        for($x = 1; $x <= $count; $x++) {            
            $alias = $max_alias + 1;
            $vendor_code = get_settings('vendor_code');
            $comcat = $_SESSION['comcat'];
            $comcat = sprintf('%02s', $comcat); 
            $cid = sprintf("%04d", $cid);
            $pid = sprintf("%04d", $pid);
            $bid = sprintf("%04d", $insert_id);
            $x = sprintf("%04d", $x);
            $y = $vendor_code.$comcat.$cid.$pid.$bid.$x;
	        //prepare array to insert
            $datat[]=array('batch_id'=>$insert_id, 'serialno'=>$y, 'cid'=>$cid,'alias' => $alias);
            $y++;
            $max_alias++;
        }

        if($datat){
            // Insert the data in batch
            $results = $this->db->insert_batch('pesticidebatchserial',$datat);
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

    //get product info
    function getBatchinfo(){
        $id=$this->input->post('member_id');
        $pinfo = $this->db->select('id, c_id, pid, batch_no, mfd_date, exp_date')
                ->from('pesticidebatch')->where(array('id'=> $id, 'c_id' => $_SESSION['comid']))->get();
        return $pinfo->row_array(); 
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
        $result = $this->db->update('pesticidebatch',$data,array('id'=>$edit_bid));
        
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
        ->from('pesticidebatch b')
        ->where('b.c_id',$user_ids)
        ->where('b.status','1')
        ->where('b.api_sent','0')
        ->where('b.container_status','0')
        ->get()->result();
        return $result;
    }
    
    public function get_batch_serial_no($id){
        $result = $this->db->select('sbsid,serialno,alias')
        ->from('pesticidebatchserial')
        ->where('batch_id',$id)
        ->where('api_sent','0')
        ->get()->result();
        return $result;
    }

    public function update_batch_api($sid){
        $data = array('api_sent'=>'1');
        $this->db->where('sbsid',$sid);
        $this->db->update('pesticidebatchserial',$data);
    }
    
    public function update_batch($bid){
        $data = array('api_sent'=>'1', 'schedule_cron'=>'2');
        $this->db->where('id',$bid);
        $this->db->update('pesticidebatch',$data);
    }


    public function label_detail($sno){
        $this->db->select('b.*,p.p_code as productCode,bs.serialno as sr_no,bs.sbsid as sbsid,bs.alias as alias');
        $this->db->where('b.api_sent','0');
        $this->db->where('bs.serialno',$sno);
       // $this->db->where('b.id','519');
        $this->db->join('pesticideproduct p','p.id = b.pid');
        $this->db->join('pesticidebatchserial bs','bs.batch_id = b.id');
        $this->db->from('pesticidebatch b');
        return $this->db->get()->result();
    }
    
    public function batchExport($id,$comid){
        $this->db->select('p.p_name,p.p_code,p.itemcategory,p.subcategory,b.batch_no,b.mfd_date,b.exp_date,b.id as batchid');
        $this->db->where('b.id',$id);
        $this->db->join('pesticideproduct p','p.id = b.pid');
        $this->db->join('pesticidebatchserial bs','bs.batch_id = b.id');
        $this->db->from('pesticidebatch b');
        return $this->db->get()->result();
    }

    public function getSerialNumbers($batchid){
        $this->db->select('serialno,alias');
        $this->db->where('batch_id',$batchid);
        $this->db->from('pesticidebatchserial');
        return $this->db->get()->result();
    }
    
    public function update_batch_api_response($sid,$response){
        $data = array('api_response'=>$response);
        $this->db->where('sbsid',$sid);
        $this->db->update('pesticidebatchserial',$data);
    }
    
    public function pbatchExport($id,$comid){
        $this->db->select('p.id as pid,p.p_name,p.p_code,p.itemcategory,p.subcategory,b.batch_no,b.mfd_date,b.exp_date,b.id as batchid');
        $this->db->where('b.id',$id);
        $this->db->join('publicproduct p','p.id = b.pid');
        $this->db->join('publicbatchserial bs','bs.batch_id = b.id');
        $this->db->from('publicbatch b');
        return $this->db->get()->result();
    }
    
    public function pgetSerialNumbers($batchid){
        $this->db->select('serialno');
        $this->db->where('batch_id',$batchid);
        $this->db->from('publicbatchserial');
        return $this->db->get()->result();
    }
    
    //Datatable View
     function dtlyBatch(){
        $pid = $this->input->post('pid');
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('id, c_id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date, status, api_sent,container_status,schedule_cron')
         ->from('pesticidebatch2324')->where(array('c_id'=>$_SESSION['comid'], 'pid'=>$pid, 'status'=>'1'))
        //  ->order_by("id", "desc")
         ->order_by("batch_no", "desc")
         ->get();
        $i=1;
        $output=[];
        $dis='';
        $link='';
        $is_primary = '0';
        $productDetails = $this->db->select('*')
                          ->from('pesticideproduct')->where(array('id' => $pid,'status' => '1'))
                          ->get()->result();
                if($productDetails){
                    foreach ($productDetails as $prod) {
                        $is_primary = $prod->onlyprimary;
                    }
                }
        foreach ($exp->result() as $row) {
            
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="plybatchview?id='.$row->id.'" data-toggle="tooltip" title="View Batch Details"> <span class="fa fa-eye"></span></a></li>
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
         ->from('pesticidebatchserial2324 sbs')->where(array('sbs.cid'=>$_SESSION['comid'], 'sbs.batch_id'=>$bid, 'sb.id'=>$bid, 'sb.c_id'=>$_SESSION['comid']))
         ->join( 'pesticidebatch2324 sb', 'sb.id = sbs.batch_id' , 'left' )
         ->join( 'pesticideproduct pr', 'pr.id = sb.pid' , 'left' )
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