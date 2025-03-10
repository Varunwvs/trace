<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * FarmerModel 
 */
class FarmerInputModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;

    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'farmerinputs';
        // Set orderable column fields
        $this->column_order = array('product');
        // Set searchable column fields
        $this->column_search = array('product');

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
        $this->db->select("{$this->table}.*, categories.name as category_name");
        $this->db->from($this->table);
        $this->db->join('categories', "categories.id = {$this->table}.category", 'left'); 
 
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

    public function get_categories() {
        return $this->db->select('id, name')->from('categories')->get()->result();
    }

    public function add_farmer_input($data) {
        $this->db->insert('farmerinputs', $data);
        return $this->db->insert_id();  // Return the inserted row ID
    }

    public function get_input_details_by_id($id){
        $this->db->select('fi.product, fi.brand, fi.description, fi.usage_instructions,c.name as category');
        $this->db->from('farmerinputs fi');
        $this->db->join('categories c','c.id= fi.category');
        $this->db->where('fi.id', $id);
        $query = $this->db->get()->row();
        return $query;
    }

    

}   