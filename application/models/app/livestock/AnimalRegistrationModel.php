<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AnimalRegistrationModel 
 */
class AnimalRegistrationModel extends CI_Model
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
        $this->table = 'animals';
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
        $this->db->where(array('c_id'=>$this->cid));
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
        $this->db->where(array('c_id'=>$this->cid));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    private function _get_datatables_query($postData){
        $this->db->where(array('c_id'=>$this->cid));
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

    public function insertAnimal()
    {
        $data=[];
        $cid = $this->input->post('cid');
        $animal_id     = $this->input->post('animal_id');

        if (empty($animal_id))  {
            $output['success'] = false;
            $output['messages'] = 'Please enter animal id';
            
            return $output;
        }

        
        $image = null;

        // Handle file upload
        if (isset($_FILES["photo"]["type"]) && !empty($_FILES["photo"]["tmp_name"])) {
    
            // Upload new file
            $image = $this->uploadFile('photo', 'uploads/animals/');
            if (!$image) {
                $output['success'] = false;
                $output['messages'] = 'Failed to upload file';
                return $output;
            }
        }

        $data = [
            'c_id'          =>$cid,
            'animal_id'     => $animal_id,
            'species'       => $this->input->post('species'),
            'breed'         => $this->input->post('breed'),
            'dob'           => $this->input->post('dob'),
            'gender'        => $this->input->post('gender'),
            'parent_details'=> $this->input->post('parent_details'),
            'ear_tag'       => $this->input->post('ear_tag'),
            'farm_location' => $this->input->post('farm_location'),
            'owner'         => $this->input->post('owner'),
            'photo'         => $image
        ];

       


        // Insert data into the vendors table
        $result= $this->db->insert('animals', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Animal Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Animal Details';
        }
        return $output;
    }


    function uploadFile($fileInputName, $targetDirectory) {
        $targetPath = $targetDirectory . basename($_FILES[$fileInputName]["name"]);
        $fileExtension = strtolower(pathinfo($targetPath,PATHINFO_EXTENSION));
        $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
    
        $targetPath = $targetDirectory . $newFileName;
    
        if(move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetPath)) {
            return $newFileName;
        } else {
            return false;
        }
    }

    public function getAnimalById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('animals');
        return $query->row_array();
    }
    



}   