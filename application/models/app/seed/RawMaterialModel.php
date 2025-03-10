<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RawMaterialModel 
 */
class RawMaterialModel extends CI_Model
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
        $this->table = 'raw_materials';
        // Set orderable column fields
        $this->column_order = array('id');
        // Set searchable column fields
        $this->column_search = array('raw_material_name');

        $this->order = array('created_at' => 'desc');
        $this->cid=$_SESSION['comid'];
    }
  
    public function getRows($postData){
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $this->db->where(array('raw_materials.c_id'=>$this->cid));
        $query = $this->db->get();
        return $query->result();
    }

       
    public function countAll(){
        $this->db->where(array('c_id'=>$this->cid));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
  
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('raw_materials.c_id'=>$this->cid));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    private function _get_datatables_query($postData){
        
        $this->db->select($this->table . '.*, sc.name as category');
        $this->db->from($this->table);
        $this->db->join('sourcing_category sc', 'sc.id = ' . $this->table . '.category_id');
        $this->db->where(array('sc.c_id'=>$this->cid));
        
 
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

    public function insertRawMaterials($data)
    {
        return $this->db->insert_batch('raw_materials', $data); // Batch insert
    }

    public function get_raw_materials(){
        $this->db->select('id,raw_material_name')->from('raw_materials')->where(['c_id'=>$this->cid]);
        return $this->db->get()->result();
    }

    public function get_categories(){
        $this->db->select('id,name')->from('sourcing_category')->where(['category_type'=>'Raw Material','c_id'=>$this->cid]);
        return $this->db->get()->result();
    }


    public function updateRawMaterial(){

        $r_id = $this->input->post('r_id');

        $category = $this->input->post('category');
        $raw_material = $this->input->post('raw_material'); 

        if (empty($raw_material)) {
            $output['success'] = false;
            $output['messages']='Please add at least one raw material';
            return $output;
        }

        $data = [
            'category_id' => $category,
            'raw_material_name' => trim($raw_material)
        ];
    
        $this->db->where('id', $r_id);
        $update = $this->db->update('raw_materials', $data);

        if ($update) {
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated Raw Material';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While updating Raw Material';
        }

return $output;
    }

    public function getRawMaterialById($r_id)
    {
        $this->db->where('id', $r_id);
        $query = $this->db->get('raw_materials');
        return $query->row();
    }

}   