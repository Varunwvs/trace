<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AnimalHealthModel 
 */
class AnimalHealthModel extends CI_Model
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
        $this->table = 'animal_vaccination';
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

    public function insertAnimalVaccinationData()
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
            'health_status'       => $this->input->post('health_status'),
            'vaccination_type'    => $this->input->post('vaccination_type'),
            'vaccination_date'    => $this->input->post('vaccination_date'),
            'next_vaccination_due'=> $this->input->post('next_vaccination_due'),
         
        ];

       
        // Insert data into the vendors table
        $result= $this->db->insert('animal_vaccination', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Health Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Health Details';
        }
        return $output;
    }




    public function getanimalid() {
        return $this->db->select('id,animal_id')->from('animals')->get()->result();
    }
    
    public function getAnimalHealthDataById($id) {
        $this->db->select('a.animal_id as animal_code, ah.*');
        $this->db->from('animal_health_records ah');
        $this->db->join('animals a', 'a.id = ah.animal_id', 'left');
        $this->db->where('ah.id', $id);
        $query = $this->db->get();
        
        return $query->row_array();
    }


    function dtAnimalDeworming(){
   
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $i=1;
        $output=[];

        $exp = $this->db->select('ad.*, a.animal_id as animal_code')
        ->from('animal_deworming ad')
        ->join('animals a', 'a.id = ad.animal_id', 'left') 
        ->where('ad.c_id', $this->cid)
        ->order_by("ad.created_at", "desc")
        ->get();

        foreach ($exp->result() as $row) {
            
           
            $output[] = array(
                    $i++, 
                    $row->animal_code, 
                    $row->health_status, 
                    $row->deworming_type, 
                    !empty($row->deworming_date)? date('d-m-Y',strtotime($row->deworming_date)):'', 
                    !empty($row->next_deworming_due)? date('d-m-Y',strtotime($row->next_deworming_due)):'',  
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;          
    }
    
    public function insertAnimalDewormingData(){
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
            'health_status'       => $this->input->post('health_status'),
            'deworming_type'      => $this->input->post('deworming_type'),
            'deworming_date'      => $this->input->post('deworming_date'),
            'next_deworming_due'  => $this->input->post('next_deworming_due'),
        ];

        $result= $this->db->insert('animal_deworming', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Health Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Health Details';
        }
        return $output;
    }

    function dtAnimalVeterinary(){
   
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $i=1;
        $output=[];

        $exp = $this->db->select('ad.*, a.animal_id as animal_code')
        ->from('animal_veterinary ad')
        ->join('animals a', 'a.id = ad.animal_id', 'left') 
        ->where('ad.c_id', $this->cid)
        ->order_by("ad.created_at", "desc")
        ->get();

        foreach ($exp->result() as $row) {
            
           
            $output[] = array(
                    $i++, 
                    $row->animal_code, 
                    $row->health_status, 
                    !empty($row->vet_visit_date)? date('d-m-Y',strtotime($row->vet_visit_date)):'', 
                    $row->vet_name,    
                    $row->diagnosis,   
                    $row->treatment,  
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;          
    }
    
    public function insertAnimalVeterinaryData(){
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
            'health_status'       => $this->input->post('health_status'),
            'vet_visit_date'      => $this->input->post('vet_visit_date'),
            'vet_name'            => $this->input->post('vet_name'),
            'diagnosis'           => $this->input->post('diagnosis'),
            'treatment'           => $this->input->post('treatment'),
        ];

        $result= $this->db->insert('animal_veterinary', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Health Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Health Details';
        }
        return $output;
    }

    function dtAnimalMedication(){
   
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $i=1;
        $output=[];

        $exp = $this->db->select('ad.*, a.animal_id as animal_code')
        ->from('animal_medication ad')
        ->join('animals a', 'a.id = ad.animal_id', 'left') 
        ->where('ad.c_id', $this->cid)
        ->order_by("ad.created_at", "desc")
        ->get();

        foreach ($exp->result() as $row) {
            
           
            $output[] = array(
                    $i++, 
                    $row->animal_code, 
                    $row->health_status, 
                    $row->medication_name,    
                    $row->medication_dosage,   
                    $row->medication_duration,  
                    $row->reason, 
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;          
    }
    
    public function insertAnimalMedicationData(){
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
            'health_status'       => $this->input->post('health_status'),
            'medication_name'     => $this->input->post('medication_name'),
            'medication_dosage'   => $this->input->post('medication_dosage'),
            'medication_duration' => $this->input->post('medication_duration'),
            'reason'              => $this->input->post('reason'),
        ];

        $result= $this->db->insert('animal_medication', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Health Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Health Details';
        }
        return $output;
    }

    function dtAnimalDisease(){
   
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $i=1;
        $output=[];

        $exp = $this->db->select('ad.*, a.animal_id as animal_code')
        ->from('animal_disease ad')
        ->join('animals a', 'a.id = ad.animal_id', 'left') 
        ->where('ad.c_id', $this->cid)
        ->order_by("ad.created_at", "desc")
        ->get();

        foreach ($exp->result() as $row) {
            
           
            $output[] = array(
                    $i++, 
                    $row->animal_code, 
                    $row->health_status, 
                    $row->disease_symptoms,    
                    $row->disease_diagnosis,   
                    $row->disease_treatment,  
                    $row->disease_isolation, 
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;          
    }
    
    public function insertAnimalDiseaseData(){
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
            'health_status'       => $this->input->post('health_status'),
            'disease_symptoms'    => $this->input->post('disease_symptoms'),
            'disease_diagnosis'   => $this->input->post('disease_diagnosis'),
            'disease_treatment'   => $this->input->post('disease_treatment'),
            'disease_isolation'   => $this->input->post('disease_isolation'),
        ];

        $result= $this->db->insert('animal_disease', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Health Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Health Details';
        }
        return $output;
    }

    function dtAnimalMortality(){
   
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $i=1;
        $output=[];

        $exp = $this->db->select('ad.*, a.animal_id as animal_code')
        ->from('animal_mortality ad')
        ->join('animals a', 'a.id = ad.animal_id', 'left') 
        ->where('ad.c_id', $this->cid)
        ->order_by("ad.created_at", "desc")
        ->get();

        foreach ($exp->result() as $row) {
            
           
            $output[] = array(
                    $i++, 
                    $row->animal_code, 
                    $row->age,    
                    $row->cause_of_death,   
                    !empty($row->death_date)? date('d-m-Y',strtotime($row->death_date)):'',  
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;          
    }
    
    public function insertAnimalMortalityData(){
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
            'cause_of_death'      => $this->input->post('cause_of_death'),
            'death_date'          => $this->input->post('death_date'),
            'age'   => $this->input->post('age'),
        ];

        $result= $this->db->insert('animal_mortality', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Health Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Health Details';
        }
        return $output;
    }
}   