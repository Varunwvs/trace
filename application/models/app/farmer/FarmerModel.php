<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * FarmerModel 
 */
class FarmerModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;

    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'farmerprofile';
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

    public function addFarmer($data) {
        $this->db->insert('farmerprofile', $data);
        return $this->db->insert_id(); // Return the inserted farmer's ID
    }

    public function addPlotDivisions($plotDivisions) {
        return $this->db->insert_batch('plot_divisions', $plotDivisions);
    }

    public function getFarmerDetailsById($id) {
        return $this->db->select('fp.full_name, fp.plot_area,fp.latitude,fp.longitude,fp.registration_id,fp.farmer_files,pd.plot_name,pd.plot_division_area,fc.crop_name')
                        ->join('plot_divisions pd','pd.farmer_id=fp.id')
                        ->join('farmercrops fc','fc.id=pd.crop_id','left')
                        ->from('farmerprofile fp','left') 
                        ->where('fp.id', $id)
                        ->get()
                        ->result_array(); 
    }
    

}   