<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Company Model
 */
class CompanyModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    //Datatable View
    function dtCompany(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.category, u.city, u.state, u.pincode, u.address, u.role, u.status, c.name as catname')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where('role','company')
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
                $cat = '<span class="right badge badge-warning">Mechanisation</span>';
            }
            elseif($row->category==='4'){
                $cat = '<span class="right badge badge-danger">Chemicals</span>';
            }
            else{
                $cat = '';
            }
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item d-print-none"><a class="btn text-red btn-xs" role="button" id="update_status" data-id="'.$row->id.'" data-toggle="tooltip" title="Update Company Status"> <span class="fa-solid fa-arrow-up-from-bracket"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="companyview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="companyedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
                <li class="list-inline-item d-print-none"><a class="btn text-red btn-xs" role="button" id="delete_company" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Company"> <span class="fa fa-trash"></span></a></li>
              </ul>';

            $output[] = array(
                $i++, 
                '<strong>'.ucwords($row->name).'</strong>', 
                ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode,       
                $cat,
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

    //Update Company Status
    function updComstatus(){
        $id=$this->input->post('member_id');
        $status='0';
        $sinfo = $this->db->select('status')->from('users')->where('id', $id)->get();
        foreach($sinfo->result() as $row){
            $status = $row->status;
        }
        if($status==='1'){
            $status='0';
        }else{
            $status='1';
        }
        $data = array('status' => $status);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully updated the status';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while updating status!';
        }

        return($output);
    }

     //Delete Products
     function delCompany(){
        $id=$this->input->post('member_id');
        $this->db->where('id', $id);
        $result=$this->db->delete('users');
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Removed Company';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing Company!';
        }

        return($output);
    }

    function getCategory(){
        $depart=$this->db->order_by("name", "asc")->get('categories'); 
        return $depart;
    }

    function addCompany(){
        $cname = $this->input->post('cname');
        $category = $this->input->post('category');
        $contact_person = $this->input->post('contact_person');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $phone = $this->input->post('phone');
        $gst = $this->input->post('gst');
        $website = $this->input->post('website');
        $totalproduct = $this->input->post('totalproduct');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $pincode = $this->input->post('pincode');
        $address = $this->input->post('address');
        $status = '0';
        $role = 'company';

        $dataemailexists = $this->db->from('users')->where('email',$email)->get();
        $row = $dataemailexists->result();

        if($row !=false){
            $output['success'] = false;
            $output['messages'] = 'Email Id already exists! Please enter different email id';  
        }else{
            $datat=array('name'=>$cname, 'category'=>$category, 'gst'=>$gst, 'contact_person'=>$contact_person, 
            'email'=>$email, 'contact'=>$phone, 'city'=>$city, 'state'=>$state, 'pincode'=>$pincode, 
            'address'=>$address, 'password'=>$password, 'totalproduct'=>$totalproduct, 'role'=>$role, 'website'=>$website,'status'=>$status);

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

    //Edit Company
    function updCompany(){
        $id=$this->input->post('edit_cid');
        $edit_cname = $this->input->post('edit_cname');
        $edit_category = $this->input->post('edit_category');
        $edit_contact_person = $this->input->post('edit_contact_person');
        $edit_email = $this->input->post('edit_email');
        $edit_password = $this->input->post('edit_password');
        $edit_phone = $this->input->post('edit_phone');
        $edit_gst = $this->input->post('edit_gst');
        $edit_website = $this->input->post('edit_website');
        $edit_totalproduct = $this->input->post('edit_totalproduct');
        $edit_state = $this->input->post('edit_state');
        $edit_city = $this->input->post('edit_city');
        $edit_pincode = $this->input->post('edit_pincode');
        $edit_address = $this->input->post('edit_address');
        $data = array('name'=>$edit_cname, 'category'=>$edit_category, 'gst'=>$edit_gst, 'contact_person'=>$edit_contact_person, 
        'email'=>$edit_email, 'contact'=>$edit_phone, 'city'=>$edit_city, 'state'=>$edit_state, 'pincode'=>$edit_pincode, 
        'address'=>$edit_address, 'password'=>$edit_password, 'totalproduct'=>$edit_totalproduct,'website'=>$edit_website);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated user info';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating user info';  
        }        
        return $output;
    }

    function updUserprofile(){
        $id=$_SESSION['comid'];
        $edit_cname = $this->input->post('edit_cname');
        $edit_contact_person = $this->input->post('edit_contact_person');
        $edit_email = $this->input->post('edit_email');
        $edit_password = $this->input->post('edit_password');
        $edit_phone = $this->input->post('edit_phone');
        $edit_gst = $this->input->post('edit_gst');
        $edit_state = $this->input->post('edit_state');
        $edit_city = $this->input->post('edit_city');
        $edit_pincode = $this->input->post('edit_pincode');
        $edit_address = $this->input->post('edit_address');
        $data = array('name'=>$edit_cname, 'gst'=>$edit_gst, 'contact_person'=>$edit_contact_person, 
        'email'=>$edit_email, 'contact'=>$edit_phone, 'city'=>$edit_city, 'state'=>$edit_state, 'pincode'=>$edit_pincode, 
        'address'=>$edit_address, 'password'=>$edit_password);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated user info';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating user info';  
        }        
        return $output;
    }
    
}