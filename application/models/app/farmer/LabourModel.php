<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * LabourModel 
 */
class LabourModel extends CI_Model
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
        $this->table = 'farmer_labour';
        // Set orderable column fields
        $this->column_order = array('id');
        // Set searchable column fields
        $this->column_search = array('full_name');

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

        $this->db->from($this->table);
        $this->db->where(array('c_id' => $this->cid));
 
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

    public function addLabour()
    {
        $data=[];
        $cid = $this->input->post('cid');
        $full_name     = $this->input->post('full_name');
        $contact_no      = $this->input->post('contact_no ');

        if (empty($full_name) && empty($contact_no)  )  {
            $output['success'] = false;
            $output['messages']  = 'Please fill all required fields';
            
            return $output;
        }
        $file = null;

        // Handle file upload
        if (isset($_FILES["file"]["type"]) && !empty($_FILES["file"]["tmp_name"])) {
    
            // Upload new file
            $file = $this->uploadFile('file', 'uploads/labour_govt_id/');
            if (!$file) {
                $output['success'] = false;
                $output['messages'] = 'Failed to upload file';
                return $output;
            }
        }


        $data = [
            'c_id'                =>$cid,
           'full_name' => $this->input->post('full_name'),
            'dob' => $this->input->post('dob'),
            'contact_no' => $this->input->post('contact_no'),
            'emergency_contact' => $this->input->post('emergency_contact'),
            'blood_grp' => $this->input->post('blood_grp'),
            'daily_wage' => $this->input->post('daily_wage'),
            'skills' => $this->input->post('skills'),
            'address' => $this->input->post('address'),
            'notes' => $this->input->post('notes'),
            'govt_id'=>$file
        ];

      
       
        // Insert data into the vendors table
        $result= $this->db->insert('farmer_labour', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Labour Details';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Labour Details';
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

    
    public function get_labour_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('farmer_labour');
    
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    
    }
    



}   