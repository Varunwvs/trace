<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Model
 */
class SourcingModel extends CI_Model
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
        $this->table = 'seedproduct';
        // Set orderable column fields
        $this->column_order = array('p_name', 'p_code', 'itemcategory', 'api_sent');
        // Set searchable column fields
        $this->column_search = array('p_name', 'p_code', 'itemcategory', 'api_sent');
        // Set default order
        $this->order = array('created_at' => 'desc');
        // $adminrole = $_SESSION['role'];
        // $admin=substr($adminrole, 0, -6).'admin';
        // $center=substr($adminrole, 0, -6).'center';
        $this->cid=$_SESSION['comid'];
        // $cinfo = $this->db->select('id as cid')->from('users')->where('role',$admin)->get();
        // // foreach($cinfo->result() as $crow){
        // //     if($crow->cid !=''){
        // //         $this->cid=$crow->cid;
        // //     }
        // // }
    }
    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

       
    /*
     * Count all records
     */
    public function countAll(){
        $this->db->where(array('c_id'=>$this->cid));
        $this->db->from('sourcing');
        // $this->db->group_by('lot_reference_no');
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('s.c_id'=>$this->cid));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){

        $this->db->select('s.id,s.lot_reference_no,s.date_of_sourcing,s.grn_file,sp.p_name,v.vendor_name,s.created_at,r.raw_material_name');
        $this->db->from('sourcing s');
        $this->db->join('vendors v','v.id=s.vendor_id');
        $this->db->join('seedproduct sp','sp.id=s.product_id');
        $this->db->join('raw_materials r','r.id=s.raw_material_id');
        $this->db->where(array('s.c_id'=>$this->cid));
        // $this->db->group_by('s.lot_reference_no');
 
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

    public function insertSourcing($data)
    {
        return $this->db->insert_batch('sourcing', $data);
    }
   
    public function get_sourcing_lot_no(){
        $this->db->select('DISTINCT(lot_reference_no)')->from('sourcing')->where('c_id',$_SESSION['comid']);
        return $this->db->get()->result();
    }
    
        public function getSourcingDetails() {
        $id = $this->input->post('id'); // Get the ID from POST data
        $query = $this->db->select('s.lot_reference_no, v.vendor_name, sp.name as product_name, r.raw_material_name, s.qty, u.uomname, s.date_of_sourcing')
                          ->from('sourcing s')
                          ->join('seedproduct sp', 'sp.id = s.product_id')
                          ->join('unitofmeasurements u', 'u.uomid = s.uom_id')
                          ->join('vendors v', 'v.id = s.vendor_id')
                          ->join('raw_materials r', 'r.id = s.raw_material_id')
                          ->where(['s.id'=>$id,'s.c_id'=>$this->cid])
                          ->get();
                          
        if ($query->num_rows() > 0) {
            return $query->row_array(); // Return the result as an associative array
        } else {
            return null; // Return null if no data is found
        }
    }


    public function getSourcingById($id){
        $this->db->where('id', $id);
        $query = $this->db->get('sourcing');
        return $query->row();
    }

    public function updateSourcing(){

        $sid = $this->input->post('sid');
        $cid = $this->input->post('cid');
	$appid = 'SD';
    $vendor_ids = $this->input->post('vendor_id');
    $raw_material_ids = $this->input->post('raw_material_id');
    $quantities = $this->input->post('qty');
    $uom_ids = $this->input->post('uom');
    $dates_of_sourcing = $this->input->post('date_of_sourcing');
    $product_id = $this->input->post('product_id');
    $lot_reference_no = $this->input->post('lot_reference_no');

    if(empty($product_id) || empty($lot_reference_no) ){
        $output['success'] = false;
        $output['messages'] = 'Please fill all the required(*) fields';
        return $output;
	}

    $data = [];
    
    $oldFile = $this->input->post('grn_file'); 
    $image = null;

    // Handle file upload
    if (isset($_FILES["file"]["type"]) && !empty($_FILES["file"]["tmp_name"])) {
        // Delete the old file if it exists
        if (!empty($oldFile) && file_exists('uploads/grn_files/' . $oldFile)) {
            unlink('uploads/grn_files/' . $oldFile);
        }

        // Upload new file
        $image = $this->uploadFile('file', 'uploads/grn_files/');
        if (!$image) {
            $output['success'] = false;
            $output['messages'] = 'Failed to upload file';
            return $output;
        }
    } else {
        // Keep the old file if no new file is uploaded
        $image = $oldFile;
    }

    // Validate and prepare data for insertion
        if (
            !empty($vendor_ids) &&
            !empty($raw_material_ids) &&
            !empty($quantities) &&
            !empty($uom_ids) &&
            !empty($dates_of_sourcing)
        ) {
            $data = [
				
                'product_id' => $product_id,
                'lot_reference_no' => $lot_reference_no,
                'vendor_id' => $vendor_ids,
                'raw_material_id' => $raw_material_ids,
                'qty' => $quantities,
                'uom_id' => $uom_ids,
                'date_of_sourcing' => $dates_of_sourcing,
                'grn_file'=>$image
            ];
        }else{
            $output['success'] = false;
            $output['messages'] = 'Please fill all the required(*) fields';
            return $output;
        }
    

        $result=$this->db->where('id', $sid); 
        $this->db->update('sourcing', $data); 

            if ($result) {
                $output['success'] = true;
                $output['messages'] = 'Successfully Updated Sourcing';
            } else {
                $output['success'] = false;
                $output['messages'] = 'Error While updating Sourcing';
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


    public function deleteSourcing(){
        $id = $this->input->post('id');

    if ($id) {
        // Fetch the file name from the database
        $this->db->select('grn_file');
        $this->db->where('id', $id);
        $query = $this->db->get('sourcing');
        $row = $query->row();

        if ($row) {
            $filePath = 'uploads/grn_files/' . $row->grn_file;

            // Delete the file if it exists
            if (!empty($row->grn_file) && file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the record from the database
            $this->db->where('id', $id);
            $delete = $this->db->delete('sourcing');

            if ($delete) {
                $output['success'] = true;
                $output['messages'] = 'Sourcing deleted successfully';
            } else {
                $output['success'] = false;
                $output['messages'] = 'Error deleting Sourcing';
            }
        } else {
            $output['success'] = false;
            $output['messages'] = 'Sourcing ID not found';
        }
    } else {
        $output['success'] = false;
        $output['messages'] = 'Invalid Sourcing ID';
    }

    return $output;

    }

}