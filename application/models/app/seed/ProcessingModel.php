<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Model
 */
class ProcessingModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;
    private $cid;
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'seedproduct';
        // Set orderable column fields
        $this->column_order = array('p_name', 'p_code', 'itemcategory', 'api_sent');
        // Set searchable column fields
        $this->column_search = array('p_name', 'p_code', 'itemcategory', 'api_sent');
        // Set default order
        $this->order = array('created_at' => 'desc');
        // $adminrole = $_SESSION['role'];
        // $admin=substr($adminrole, 0, -6).'admin';
        // $center=substr($adminrole, 0, -6).'center';
        $this->cid=$_SESSION['comid'];
        // $cinfo = $this->db->select('id as cid')->from('users')->where('role',$admin)->get();
        // // foreach($cinfo->result() as $crow){
        // //     if($crow->cid !=''){
        // //         $this->cid=$crow->cid;
        // //     }
        // // }
    }
    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

       
    /*
     * Count all records
     */
    public function countAll(){
        $this->db->from('processing');
        $this->db->where(array('c_id'=>$this->cid));
        $this->db->group_by('processed_lot_no');
       
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('p.c_id'=>$this->cid));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){

        $this->db->select('p.id,p.sourcing_lot_id,p.processed_lot_no,v.vendor_name,p.created_at,r.raw_material_name,sp.p_code,s.product_id');
        $this->db->from('processing p');
        $this->db->join('vendors v','v.id=p.vendor_id');
        $this->db->join('raw_materials r','r.id=p.raw_material_id');
        $this->db->join('sourcing s','s.lot_reference_no=p.sourcing_lot_id');
        $this->db->join('seedproduct sp','sp.id=s.product_id');
        $this->db->where(array('p.c_id'=>$this->cid));

        $this->db->group_by('p.processed_lot_no');
 
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
    
    public function getProcessingDetailsByLot($processed_lot_no) {
        $this->db->select('p.process_name, p.process_type, p.process_qty, p.final_qty, p.wastage, u.uomname,v.vendor_name,r.raw_material_name,p.processed_lot_no,p.id as processing_id,p.sourcing_lot_id');
        $this->db->from('processing p'); 
        $this->db->join('unitofmeasurements u','u.uomid = p.uom');
        $this->db->join('vendors v','v.id = p.vendor_id');
        $this->db->join('raw_materials r','r.id = p.raw_material_id');
        $this->db->where(['p.processed_lot_no'=>$processed_lot_no,'p.c_id'=>$this->cid]);
        $query = $this->db->get();
    
        return $query->result_array();
    }

    public function insertProcessData($data)
{
    return $this->db->insert('processing', $data);
}

public function get_processed_lot_no(){
    $this->db->select('processed_lot_no')->from('processing');
    $this->db->group_by('processed_lot_no');
    return $this->db->get()->result();
}

public function getProcessingById($id){

    $this->db->select('p.process_name, p.process_type, p.process_qty, p.final_qty, p.wastage, u.uomname,v.vendor_name,r.raw_material_name,p.processed_lot_no,p.id as processing_id,p.sourcing_lot_id,p.uom');
    $this->db->from('processing p'); 
    $this->db->join('unitofmeasurements u','u.uomid = p.uom');
    $this->db->join('vendors v','v.id = p.vendor_id');
    $this->db->join('raw_materials r','r.id = p.raw_material_id');
    $this->db->where(['p.id'=>$id,'p.c_id'=>$this->cid]);
    $query = $this->db->get();

    return $query->row();

}

public function updateProcessing(){

    $pid = $this->input->post('pid');
    $cid = $this->input->post('cid');
    $appid = 'SD';

    $sourcing_lot = $this->input->post('sourcing_lot_id');
    $processed_lot_no = $this->input->post('processed_lot_no');
    $vendor_id = $this->input->post('vendor_id');
    $raw_material_id = $this->input->post('raw_material_id');
    $process_name = $this->input->post('process_name');
    $process_type = $this->input->post('process_type');
    $process_qty = $this->input->post('process_qty');
    $final_qty = $this->input->post('final_qty');
    $wastage = $this->input->post('wastage');
    $uom = $this->input->post('uom');

$data = [];

        if(!empty($process_name) && !empty($process_type) && !empty($process_qty) && !empty($final_qty) && !empty($wastage) && !empty($uom)){

            $data = [
                'process_name' => $process_name,
                'process_type' => $process_type,
                'process_qty' => $process_qty,
                'final_qty' => $final_qty,
                'wastage' => $wastage,
                'uom' => $uom,
            ];


        $result=$this->db->where('id', $pid); 
        $this->db->update('processing', $data); 
    }else{
        $output['success'] = false;
        $output['messages'] = 'Please fill all the process details';
    }

        

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated Processing';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While updating Processing';
        }

return $output;

}

}