<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SourcingCategoryModel 
 */
class SourcingCategoryModel extends CI_Model
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
        $this->table = 'sourcing_category';
        // Set orderable column fields
        $this->column_order = array('id');
        // Set searchable column fields
        $this->column_search = array('name');

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
        $this->db->where(array('c_id'=>$this->cid));
        $this->db->from($this->table);
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

    public function get_categories(){
        $this->db->select('id,name')->from('sourcing_category')->where(array('c_id'=>$this->cid));
        return $this->db->get()->result();
    }


  
   public function insertCategory()
   {

    $cid = $this->input->post('cid');
    $appid = 'SD';

    $name = $this->input->post('name');
    $code = $this->input->post('code');
    $parent_category = $this->input->post('parent_category');
    $category_type = $this->input->post('category_type'); // Checkbox values array

    if (empty($name) || empty($code)) {
        $output['success'] = false;
        $output['message'] = 'Name and Code are required';
        
        return $output;
    }

    // Validate category type selection
    if (empty($parent_category) && (empty($category_type) || !is_array($category_type))) {
        $output['success'] = false;
        $output['message'] = 'At least one category type (Raw Material or Product) must be selected for a main category.';
        
        return $output;
    }

    // Determine Category Type (if both checked, store as "Both")
    $categoryType = "";
    if (is_array($category_type)) {
        if (in_array('Raw Material', $category_type) && in_array('Product', $category_type)) {
            $categoryType = "Both";
        } else {
            $categoryType = implode(", ", $category_type);
        }
    }

    if (empty($parent_category)) {
        // Insert into sourcing_category table
        $data = [
            'c_id'          =>$cid,
			'applicationid' => $appid,
            'name' => $name,
            'code' => $code,
            'category_type' => $categoryType
        ];
        //category
        $insert = $this->db->insert('sourcing_category',$data);
    } else {
        // Insert into sourcing_sub_category table
        $data = [
            'c_id'          =>$cid,
			'applicationid' => $appid,
            'sub_name' => $name,
            'sub_code' => $code,
            'category_id' => $parent_category
        ];
        //sub category
        $insert = $this->db->insert('sourcing_sub_category',$data);
    }


    if ($insert) {
        $output['success'] = true;
        $output['message'] = 'Category added successfully';
    } else {
        $output['success'] = false;
        $output['message'] = 'Failed to add category';
    }
        
        return $output;

   }


   public function updateCategory()
   {

    $categoryId = $this->input->post('catid');
    $cid = $this->input->post('cid');
    $appid = 'SD';

    $name = $this->input->post('name');
    $code = $this->input->post('code');
    $parent_category = $this->input->post('parent_category');
    $category_type = $this->input->post('category_type'); // Checkbox values array

    if (empty($name) || empty($code)) {
        $output['success'] = false;
        $output['message'] = 'Name and Code are required';
        
        return $output;
    }


    if (empty($parent_category) && (empty($category_type) || !is_array($category_type))) {
        $output['success'] = false;
        $output['message'] = 'At least one category type (Raw Material or Product) must be selected for a main category.';
        
        return $output;
    }

    // Determine Category Type (if both checked, store as "Both")
    $categoryType = "";
    if (is_array($category_type)) {
        if (in_array('Raw Material', $category_type) && in_array('Product', $category_type)) {
            $categoryType = "Both";
        } else {
            $categoryType = implode(", ", $category_type);
        }
    }

    if (empty($parent_category)) {
        // Insert into sourcing_category table
        $data = [
            'c_id'          =>$cid,
			'applicationid' => $appid,
            'name' => $name,
            'code' => $code,
            'category_type' => $categoryType
        ];
        //category
        $this->db->where('id', $categoryId);
        $update =$this->db->update('sourcing_category', $data);
    } 


    if ($update) {
        $output['success'] = true;
        $output['message'] = 'Category updated successfully';
    } else {
        $output['success'] = false;
        $output['message'] = 'Failed to add category';
    }
        
        return $output;

   }

   public function updateSubCategory()
   {

    $subcategoryId = $this->input->post('s_catid');
    $cid = $this->input->post('cid');
    $appid = 'SD';

    $name = $this->input->post('name');
    $code = $this->input->post('code');

    if (empty($name) || empty($code)) {
        $output['success'] = false;
        $output['message'] = 'Name and Code are required';
        
        return $output;
    }

    if (empty($parent_category)) {
        // Insert into sourcing_category table
        $data = [
            'sub_name' => $name,
            'sub_code' => $code,
        ];
        //category
        $this->db->where('id', $subcategoryId);
        $update =$this->db->update('sourcing_sub_category', $data);
    } 


    if ($update) {
        $output['success'] = true;
        $output['message'] = 'Sub Category updated successfully';
    } else {
        $output['success'] = false;
        $output['message'] = 'Failed to add category';
    }
        
        return $output;

   }
}   