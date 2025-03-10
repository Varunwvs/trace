<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * FarmerActivityModel 
 */
class FarmerActivityModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;

    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'farmingactivities';
        // Set orderable column fields
        $this->column_order = array('fp.full_name');
        // Set searchable column fields
        $this->column_search = array('fp.full_name');

        $this->order = array('farmingactivities.created_at' => 'desc');
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
    
    private function _get_datatables_query($postData) {
        // Select specific columns
        $this->db->select('farmingactivities.*,fp.id as farmer_id,fp.full_name AS farmer_name, fc.crop_name, pd.plot_name, pd.plot_division_area');
    
        // Set the base table
        $this->db->from($this->table);
    
        // Join the farmerprofile table
        $this->db->join('farmerprofile fp', 'fp.id = farmingactivities.farmer_id', 'left');
        
        // Join the crop table
        $this->db->join('farmercrops fc', 'fc.id = farmingactivities.crop_id', 'left');
        
        // Join the plot_divisions table
        $this->db->join('plot_divisions pd', 'pd.id = farmingactivities.plot_division_id','left');
       
        $this->db->group_by('pd.id');
        $i = 0;
    
        // Loop searchable columns
        foreach ($this->column_search as $item) {
            if ($postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
    
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    
        // Order by logic
        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    

    public function get_farmers() {
        return $this->db->select('id, full_name')->from('farmerprofile')->get()->result();
    }
    
    public function get_plot_division($farmer_id) {
        $this->db->select('id,plot_name');
        $this->db->where('farmer_id', $farmer_id);
        $query = $this->db->get('plot_divisions');
        return $query->result();
    }
    public function get_crops() {
        return $this->db->select('id, crop_name')->from('farmercrops')->get()->result();
    }

    public function addFarmingActivities($farmingActivities) {
        // Insert multiple rows into the farming_activities table
        return $this->db->insert_batch('farmingactivities', $farmingActivities);
    }

    public function getDetailsById($id) {
        $this->db->select('farmingactivities.*, fp.full_name AS farmer_name, fc.crop_name, pd.plot_name');
        $this->db->from('farmingactivities');
        $this->db->join('farmerprofile fp', 'fp.id = farmingactivities.farmer_id', 'left');
        $this->db->join('farmercrops fc', 'fc.id = farmingactivities.crop_id', 'left');
        $this->db->join('plot_divisions pd', 'pd.id = farmingactivities.plot_division_id', 'left');
        $this->db->where('farmingactivities.plot_division_id', $id);
        // $this->db->group_by('farmingactivities.plot_division_id');
        return $this->db->get()->result_array();
    }
    
    public function get_farming_inputs() {
        return $this->db->select('id, product, brand')->from('farmerinputs')->get()->result();
    }



}   