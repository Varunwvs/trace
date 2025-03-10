<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AnimalInventoryModel 
 */
class AnimalInventoryModel extends CI_Model
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
        $this->table = 'animal_inventory';
        // Set orderable column fields
        $this->column_order = array('id');
        // Set searchable column fields
        $this->column_search = array('animal_id');

        $this->order = array('created_at' => 'desc');

        $this->cid=$_SESSION['comid'];
    }
  
    public function getRows($postData){
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $this->db->where(array($this->table.'.c_id'=>$this->cid));
        $query = $this->db->get();
        return $query->result();
    }

       
    public function countAll(){
        $this->db->from($this->table);
        $this->db->where(array('c_id'=>$this->cid));
        return $this->db->count_all_results();
    }
    
  
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array($this->table.'.c_id'=>$this->cid));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    private function _get_datatables_query($postData){
        $this->db->select($this->table.'.*, a.animal_id as animal_code');
        $this->db->from($this->table);
        $this->db->join('animals a', 'a.id = '.$this->table.'.animal_id', 'left'); 
        $this->db->where(array($this->table.'.c_id' => $this->cid));
 
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

    public function insertAnimalInventoryData()
    {
        $data=[];
        $cid = $this->input->post('cid');
        $animal_id     = $this->input->post('animal_id');

        if (empty($animal_id))  {
            $output['success'] = false;
            $output['messages'] = 'Please enter animal id';
            
            return $output;
        }


        $data = [
            'c_id'                =>$cid,
            'animal_id'           => $animal_id,
            'stock_feed_supplements' => $this->input->post('stock_feed_supplements'),
            'medication_vaccine' => $this->input->post('medication_vaccine'),
            'equipment_machinery' => $this->input->post('equipment_machinery'),
            'fencing_shelter' => $this->input->post('fencing_shelter'),
            'farm_labor' => $this->input->post('farm_labor')
        ];

       


        // Insert data into the vendors table
        $result= $this->db->insert('animal_inventory', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Inventory Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Inventory Details';
        }
        return $output;
    }


    
    public function getAnimalInventoryDataById($id) {
        $this->db->select('a.animal_id as animal_code, ah.*');
        $this->db->from('animal_inventory ah');
        $this->db->join('animals a', 'a.id = ah.animal_id', 'left');
        $this->db->where('ah.id', $id);
        $query = $this->db->get();
        
        return $query->row_array();
    }
    



}   