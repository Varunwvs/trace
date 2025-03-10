<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * VendorModel 
 */
class VendorModel extends CI_Model
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
        $this->table = 'vendors';
        // Set orderable column fields
        $this->column_order = array('id');
        // Set searchable column fields
        $this->column_search = array('vendor_name');

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

    public function insertVendor()
    {
        $cid = $this->input->post('cid');
        $appid = 'SD';

        $vendor_name=$this->input->post('vendor_name');
        $gst_no     = $this->input->post('gst_no');
        $address     = $this->input->post('address');
        $contact_person =$this->input->post('contact_person');
        $contact_no=   $this->input->post('contact_no');

        if (empty($vendor_name) || empty($gst_no) || empty($address) || empty($contact_person) || empty($contact_no))  {
            $output['success'] = false;
            $output['messages'] = 'Please fill all the required(*) fields';
            
            return $output;
        }


        $data = [
			'c_id'          =>$cid,
			'applicationid' => $appid,
            'vendor_name'    => $vendor_name,
            'gst_no'         => $gst_no,
            'address'        => $address,
            'contact_person' => $contact_person,
            'contact_no'     => $contact_no,
			'bank_name'      => $this->input->post('bank_name'),
			'bank_branch'    => $this->input->post('bank_branch'),
			'account_no'     => $this->input->post('account_no'),
			'ifsc_code'      => $this->input->post('ifsc_code')
        ];

        // Insert data into the vendors table
        $result= $this->db->insert('vendors', $data);

        if ($result) {
            $output['success'] = true;
            $output['messages'] = 'Successfully added Vendor';
        } else {
            $output['success'] = false;
            $output['messages'] = 'Error While adding Vendor';
        }
        return $output;
    }

    public function get_vendors(){
        $this->db->select('id,vendor_name')->from('vendors')->where(['c_id'=>$this->cid]);
        return $this->db->get()->result();
    }


    public function getVendorsAndMaterials($lot_reference_no)
    {
       $query = $this->db->select('v.id as vendor_id,v.vendor_name, r.id as raw_material_id,r.raw_material_name')
            ->from('sourcing s')
            ->join('vendors v','v.id=s.vendor_id')
            ->join('raw_materials r','r.id=s.raw_material_id')
            ->where(['s.lot_reference_no'=>$lot_reference_no,'s.c_id'=>$this->cid])
            ->get()
            ->result_array();
    
            return $query;
    }

    public function getVendorById($vendor_id)
    {
        $this->db->where('id', $vendor_id);
        $query = $this->db->get('vendors');
        return $query->row();
    }

   public function updateVendor(){

    $cid = $this->input->post('cid');
        $appid = 'SD';
		$vid = $this->input->post('vid');

        $vendor_name=$this->input->post('vendor_name');
        $gst_no     = $this->input->post('gst_no');
        $address     = $this->input->post('address');
        $contact_person =$this->input->post('contact_person');
        $contact_no=   $this->input->post('contact_no');

        if (empty($vendor_name) || empty($gst_no) || empty($address) || empty($contact_person) || empty($contact_no))  {
            $output['success'] = false;
            $output['messages'] = 'Please fill all the required(*) fields';
            
            return $output;
        }


        $data = [
			'c_id'          =>$cid,
			'applicationid' => $appid,
            'vendor_name'    => $vendor_name,
            'gst_no'         => $gst_no,
            'address'        => $address,
            'contact_person' => $contact_person,
            'contact_no'     => $contact_no,
			'bank_name'      => $this->input->post('bank_name'),
			'bank_branch'    => $this->input->post('bank_branch'),
			'account_no'     => $this->input->post('account_no'),
			'ifsc_code'      => $this->input->post('ifsc_code')
        ];

        $result=$this->db->where('id', $vid); 
            $this->db->update('vendors', $data); 

                if ($result) {
                    $output['success'] = true;
                    $output['messages'] = 'Successfully Updated Vendor';
                } else {
                    $output['success'] = false;
                    $output['messages'] = 'Error While updating Vendor';
                }
        
        return $output;

   }


}   