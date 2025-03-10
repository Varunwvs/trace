<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Center Model
 */
class CenterModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    //Datatable View
    function dtCenter(){
        $adminrole = $_SESSION['role'];
        $center=substr($adminrole, 0, -5).'center';
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.category, u.contact_person, u.email, u.contact, u.city, u.state, u.pincode, u.address, u.role, u.status, c.name as catname')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where(array('u.role'=>$center, 'u.status'=>'1'))
         ->order_by('u.regon', 'desc')
         ->get();
        $i=1;
        $output=[];
        $status = '';
        $cat = '';
        foreach ($exp->result() as $row) {
            //status
            if($row->status==='0'){
                $status = '<span class="right badge badge-danger">Inactive</span>';
            }else{
                $status = '<span class="right badge badge-success">Active</span>';
            }
            //Category
            if($row->category==='1'){
                $cat = '<span class="right badge badge-info">Seeds</span>';
            }
            elseif($row->category==='2'){
                $cat = '<span class="right badge badge-success">Fertilizers</span>';
            }
            elseif($row->category==='3'){
                $cat = '<span class="right badge badge-warning">Micro Irrigation</span>';
            }
            elseif($row->category==='4'){
                $cat = '<span class="right badge badge-danger">Chemicals</span>';
            }
            elseif($row->category==='5'){
                $cat = '<span class="right badge badge-danger">Pesticide</span>';
            }
            elseif($row->category==='6'){
                $cat = '<span class="right badge badge-danger">INM</span>';
            }
            elseif($row->category==='7'){
                $cat = '<span class="right badge badge-danger">Agro Processing</span>';
            }
            else{
                $cat = '';
            }
            $actionButton = '
              <ul class="list-inline">                  
              <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View admin details" onclick="viewCenter('.$row->id.')"> <span class="fa-regular fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="admin_edit_center?id='.$row->id.'" data-toggle="tooltip" title="Edit Center info."> <span class="fa fa-edit"></span></a></li>
                <li class="list-inline-item d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="admin_delete_center" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Center"> <span class="fa fa-trash"></span></a></li>
              </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span>', 
                $row->contact_person,
                $row->email,
                $row->contact, 
                $status,
                $actionButton
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;  
        exit();
    }    

    //add center
    function addCenter(){
        $cname = $this->input->post('cname');
        $slug = '';
        
        $category = $_SESSION['comcat'];
        // echo $category; exit();
        $contact_person = $this->input->post('contact_person');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $phone = $this->input->post('phone');
        $gst = $this->input->post('gst');
        $website = $this->input->post('website');
        $totalproduct = '0';
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $pincode = $this->input->post('pincode');
        $address = $this->input->post('address');
        $status = '1';
        $adminrole = $_SESSION['role'];
        $role=substr($adminrole, 0, -5).'center';
        $level = '3';

        $dataemailexists = $this->db->from('users')->where('email',$email)->get();
        $row = $dataemailexists->result();

        if($row !=false){
            $output['success'] = false;
            $output['messages'] = 'Email Id already exists! Please enter different email id';  
        }else{
            $datat=array('name'=>$cname, 'slug'=>$slug, 'category'=>$category, 'gst'=>$gst, 'contact_person'=>$contact_person, 
            'email'=>$email, 'contact'=>$phone, 'city'=>$city, 'state'=>$state, 'pincode'=>$pincode, 
            'address'=>$address, 'password'=>$password, 'totalproduct'=>$totalproduct, 'role'=>$role, 'website'=>$website,'status'=>$status, 'ulevel'=>$level);

            // Insert the data
            $result = $this->db->insert('users',$datat);

            if($result){
                $output['success'] = true;
                $output['messages'] = 'Successfully added!';  
            }
            else{
                $output['success'] = false;
                $output['messages'] = 'Ooops! something went wrong';
            }
        }
        return $output;
    }

    //get company info
    function getCntinfo(){
        $id=$this->input->post('member_id');
        $cin = $this->db->select('u.id, u.name, u.category, u.gst, u.contact_person, u.email, 
        u.contact, u.city, u.state, u.pincode, u.address, u.password, u.totalproduct, u.website')
        ->from('users u')->where(array('u.id'=>$id))->get();
        return $cin->row_array(); 
    }

    //Delete Products
    function delCenter(){
        $id=$this->input->post('member_id');
        $this->db->where('id', $id);
        $data = array('status'=>'0');
        $result=$this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully removed center';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing center!';
        }

        return($output);
    }

    //Edit Center
    function editCenter(){
        $id=$this->input->post('edit_cid');
        $edit_cname = $this->input->post('edit_cname');
        $edit_contact_person = $this->input->post('edit_contact_person');
        $edit_email = $this->input->post('edit_email');
        $edit_password = $this->input->post('edit_password');
        $edit_phone = $this->input->post('edit_phone');
        $edit_gst = $this->input->post('edit_gst');
        $edit_website = $this->input->post('edit_website');
        $edit_state = $this->input->post('edit_state');
        $edit_city = $this->input->post('edit_city');
        $edit_pincode = $this->input->post('edit_pincode');
        $edit_address = $this->input->post('edit_address');
        $data = array('name'=>$edit_cname, 'gst'=>$edit_gst, 'contact_person'=>$edit_contact_person, 
        'email'=>$edit_email, 'contact'=>$edit_phone, 'city'=>$edit_city, 'state'=>$edit_state, 'pincode'=>$edit_pincode, 
        'address'=>$edit_address, 'password'=>$edit_password, 'website'=>$edit_website);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated center';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating center';  
        }        
        return $output;
    }
}