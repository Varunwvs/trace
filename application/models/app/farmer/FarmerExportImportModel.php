<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * FarmerModel 
 */
class FarmerExportImportModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;

    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'eiprofileusers';
        // Set orderable column fields
        $this->column_order = array('full_name');
        // Set searchable column fields
        $this->column_search = array('full_name');

        $this->order = array('created_at' => 'desc');
    }
  
    public function getRows($postData){
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

       
    public function countAll(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
  
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    private function _get_datatables_query($postData){

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

    public function insertUserProfile($data) {
        $this->db->insert('eiprofileusers', $data);  
        
        // Check if the insertion was successful
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function getProfileById($id) {
        $this->db->select('full_name, contact_no, email, user_type, company_name, website, license_no, register_no, notes, address');
        $this->db->from('eiprofileusers');
        $this->db->where('id', $id);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row(); // Return the profile data as an object
        } else {
            return null; // No data found
        }
    }
    

    

}   