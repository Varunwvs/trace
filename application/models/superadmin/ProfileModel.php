<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profile Model
 */
class ProfileModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    //Edit Company
    function updProfile(){
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
            $output['messages'] = 'Successfully updated profile';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating profile';  
        }        
        return $output;
    }

}