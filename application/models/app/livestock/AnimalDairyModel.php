<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AnimalDairyModel 
 */
class AnimalDairyModel extends CI_Model
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
        $this->table = 'animal_dairy';
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

    public function insertAnimalDairyData()
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
            'milk_yield'          => $this->input->post('milk_yield'),
            // 'milking_time'        => $this->input->post('milking_time'),
            // 'fat_percentage'      => $this->input->post('fat_percentage'),
            // 'snf_percentage'      => $this->input->post('snf_percentage'),
            // 'contamination'       => $this->input->post('contamination'),
            'storage_distribution'=> $this->input->post('storage_distribution'),
            'lactation_period'    => $this->input->post('lactation_period'),
            'milk_sales_revenue'  => $this->input->post('milk_sales_revenue'),
        ];

    
        $result= $this->db->insert('animal_dairy', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Dairy Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Dairy Details';
        }
        return $output;
    }


    
    public function getAnimalDairyDataById($id) {
        $this->db->select('a.animal_id as animal_code, ah.*');
        $this->db->from('animal_dairy ah');
        $this->db->join('animals a', 'a.id = ah.animal_id', 'left');
        $this->db->where('ah.id', $id);
        $query = $this->db->get();
        
        return $query->row_array();
    }

    // public function get_all_animals_data() {
    //     return $this->db->get('animals')->result_array();
    // }
    public function get_all_animals_data() {
        $this->db->select('animals.*'); // Select required fields from animals
        $this->db->from('animals');
        $this->db->join('animal_dairy', 'animal_dairy.animal_id = animals.id');
        $this->db->where('animal_dairy.lactation_period','active');
        
        return $this->db->get()->result_array();
    }
    
    
    public function get_milking_data_by_date_slot($date, $slot)
    {
        $this->db->select('mr.*,a.animal_id as animal_code');
        $this->db->from('milking_records mr');
        $this->db->join('animals a','a.id=mr.animal_id');
        $this->db->where('mr.date', $date);
        $this->db->where('mr.slot', $slot);
        $query = $this->db->get();

         $data=  $query->result_array();

        if ($data) {
            $output['success'] = true;
            $output['date'] = $date;  //passing here so that i can access easily in response
            $output['slot'] = $slot;  
            $output['messages'] = $data;
        } else {
            $output['success'] = false;
            $output['messages'] = 'No data found';
        }
        return $output;
    }

    public function check_existing_entry($animal_id, $date, $slot)
    {
        $this->db->where('animal_id', $animal_id);
        $this->db->where('date', $date);
        $this->db->where('slot', $slot);
        $query = $this->db->get('milking_records');
        return $query->num_rows() > 0;
    }

    public function save_milking_batch($date, $slot, $milking_data)
    {
        $insert_data = [];
        $update_data = [];

        $cid = $this->input->post('cid');

        foreach ($milking_data as $entry) {
            $id = isset($entry['id']) ? $entry['id'] : null;  // Get ID if exists
            $animal_id = $entry['animal_id'];
            $milk_yield = $entry['milk_yield'];
            $snf = $entry['snf'];
            $fat = $entry['fat'];
            $contamination = $entry['contamination'];
    
              // Check if the record exists and retrieve its ID
                    $query = $this->db->select('id')->from('milking_records')
                    ->where(['animal_id' => $animal_id, 'date' => $date, 'slot' => $slot])
                    ->get();
                $existing_record = $query->row();

                if ($existing_record) {
                    // Update existing record
                    $update_data[] = [
                        'id' => $existing_record->id, // Use the existing ID
                        'c_id' => $cid,
                        'animal_id' => $animal_id,
                        'date' => $date,
                        'slot' => $slot,
                        'milk_yield' => $milk_yield,
                        'snf' => $snf,
                        'fat' => $fat,
                        'contamination' => $contamination
                    ];
                } else {
                    // Insert new record
                    $insert_data[] = [
                        'c_id' => $cid,
                        'animal_id' => $animal_id,
                        'date' => $date,
                        'slot' => $slot,
                        'milk_yield' => $milk_yield,
                        'snf' => $snf,
                        'fat' => $fat,
                        'contamination' => $contamination
                    ];
                }
 
       
        }
    
        // Batch insert if there are new records
        if (!empty($insert_data)) {
            $result=   $this->db->insert_batch('milking_records', $insert_data);
        }
    
        // Batch update if there are existing records
        if (!empty($update_data)) {
            $result=$this->db->update_batch('milking_records', $update_data, 'id'); 
        }
    
        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully saved the details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While saving Details';
        }
        
        return $output;
    }
    



}   