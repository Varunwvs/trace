<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Model
 */
class AdminModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    //Datatable View
    function dtAdmin(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.slug, u.category, u.city, u.state, u.pincode, u.address, u.role, u.status, c.name as catname')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where(array('u.ulevel'=>'2'))
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
                <li class="list-inline-item d-print-none"><a class="btn text-red btn-xs" role="button" id="update_admin_status" data-id="'.$row->id.'" data-toggle="tooltip" title="Update admin status"> <span class="fa-solid fa-right-left"></span></a></li>              
                <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View admin details" onclick="viewAdmin('.$row->id.')"> <span class="fa-regular fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" id="view_cntinfo" data-toggle="tooltip" title="View center details" href="centerview?slug='.$row->slug.'"> <span class="fa-solid fa-street-view"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="adminedit?id='.$row->id.'" data-toggle="tooltip" title="Update admin details"> <span class="fa fa-edit"></span></a></li>
                <li class="list-inline-item d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="delete_admin" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Admin"> <span class="fa fa-trash"></span></a></li>
              </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span>', 
                '<span class="text-wrap">'.ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode.'</span>',       
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

    //Update admin Status
    function updAdminstatus(){
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

    //Datatable View
    function dtcenter(){
        $slug = $this->input->post('slug');
        $cname = $slug.'center';
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.slug, u.category, u.city, u.state, u.pincode, u.address, u.role, u.status, c.name as catname')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where('u.role',$cname)
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
                <li class="list-inline-item hidden"><a class="btn text-info btn-xs" role="button" href="adminedit?id='.$row->id.'" data-toggle="tooltip" title="Update admin details"> <span class="fa fa-edit"></span></a></li>
                <li class="list-inline-item d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="delete_admin" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Admin"> <span class="fa fa-trash"></span></a></li>
              </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span>', 
                '<span class="text-wrap">'.ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode.'</span>',       
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

    function addAdmin(){
        $cname = $this->input->post('cname');
        $slug = $this->input->post('slug');
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
        $role = $slug.'admin';
        $level = '2';

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

    //Edit Company
    function updAdmin(){
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
            $output['messages'] = 'Successfully updated admin info';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating admin info';  
        }        
        return $output;
    }

    //Delete Products
    function delAdmin(){
        $id=$this->input->post('member_id');
        $this->db->where('id', $id);
        $result=$this->db->delete('users');
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully removed admin';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing admin!';
        }

        return($output);
    }
}