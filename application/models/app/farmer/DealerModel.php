<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * dealermodel 
 */
class DealerModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;

    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'dealers';
        // Set orderable column fields
        $this->column_order = array('id');
        // Set searchable column fields
        $this->column_search = array('company_name');

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

    public function get_locations() {
        return $this->db->select('id, location_name')->from('locations')->get()->result();
    }

    public function insertDealer($data) {
        $this->db->insert('dealers', $data);
        return $this->db->insert_id(); // Return last inserted ID
    }

    public function getDealerById($id) {
        $query= $this->db->select('d.*,l.location_name')
                        ->from('dealers d')
                        ->join('locations l','l.id=d.distribution_location')
                        ->where(['d.id' => $id])
                        ->get()->row_array();
        return $query;
    }

}   