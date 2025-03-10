<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model
 */
class UserModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    public function islogin($data){  
        $query=$this->db->get_where('users',array('email'=>$data['username'],'password'=>$data['password'],'status'=>'1'));  
        return $query->row_array();  
    } 

    function getCategory(){
        $depart=$this->db->order_by("name", "asc")->get('categories'); 
        return $depart;
    }
    
    function getrcCategory(){
        $depart=$this->db->order_by("name", "asc")->where('id !=','3')->get('categories'); 
        return $depart;
    }

    function comregister(){
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
        $qr_quantity = $this->input->post('qr_quantity');
        $slug='';
        $status = '0';
        $role = 'company';
        $level = "3";

        $dataemailexists = $this->db->from('users')->where('email',$email)->get();
        $row = $dataemailexists->result();

        if($row !=false){
            $output['success'] = false;
            $output['messages'] = 'Email Id already exists! Please enter different email id';  
        }else{
            $datat=array('name'=>$cname, 'slug'=>$slug, 'category'=>$category, 'gst'=>$gst, 'contact_person'=>$contact_person, 
            'email'=>$email, 'contact'=>$phone, 'city'=>$city, 'state'=>$state, 'pincode'=>$pincode, 
            'address'=>$address, 'password'=>$password, 'totalproduct'=>$totalproduct, 'role'=>$role, 'ulevel'=>$level, 
            'website'=>$website, 'status'=>$status, 'qr_quantity'=>$qr_quantity);

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

    function rcregister(){
        $rcname = $this->input->post('rcname');
        $rccategory = $this->input->post('rccategory');
        $rccontact_person = $this->input->post('rccontact_person');
        $rcemail = $this->input->post('rcemail');
        $rcpassword = $this->input->post('rcpassword');
        $rcphone = $this->input->post('rcphone');
        $rcgst = $this->input->post('rcgst');
        $rcwebsite = $this->input->post('rcwebsite');
        $rctotalproduct = $this->input->post('rctotalproduct');
        $rcstate = $this->input->post('rcstate');
        $rccity = $this->input->post('rccity');
        $rcpincode = $this->input->post('rcpincode');
        $rcaddress = $this->input->post('rcaddress');
        $rcqr_quantity = $this->input->post('rcqr_quantity');
        $slug='';
        $rcstatus = '0';
        $rcrole = 'rcholder';
        $level = "3";

        $dataemailexists = $this->db->from('users')->where('email',$rcemail)->get();
        $row = $dataemailexists->result();

        if($row !=false){
            $output['success'] = false;
            $output['messages'] = 'Email Id already exists! Please enter different email id';  
        }else{
            $datat=array('name'=>$rcname, 'slug'=>'', 'category'=>$rccategory, 'gst'=>$rcgst, 'contact_person'=>$rccontact_person, 
            'email'=>$rcemail, 'contact'=>$rcphone, 'city'=>$rccity, 'state'=>$rcstate, 'pincode'=>$rcpincode, 
            'address'=>$rcaddress, 'password'=>$rcpassword, 'totalproduct'=>$rctotalproduct, 'role'=>$rcrole, 'ulevel'=>$level, 'website'=>$rcwebsite, 
            'status'=>$rcstatus, 'qr_quantity'=>$rcqr_quantity);

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

    public function checkUser($data){
        $query=$this->db->get_where('users',array('email'=>$data['username'],'status'=>'1'));  
        return $query->row_array();  
    }

    public function save_otp($otp, $id) {
        date_default_timezone_set("Asia/kolkata");

        $otp_data = array(
            'otp' => $otp,
            'time' => date('Y-m-d H:i:s')
        );
        $otp_json = json_encode($otp_data);
    
        $this->db->where('id', $id);
        $result = $this->db->update('users', ['otp'=>$otp_json]);
    
        return $result;
    }

    public function check_otp($otp, $db_otp) {
        date_default_timezone_set("Asia/kolkata");

            $otp_data = json_decode($db_otp, true);
    
            $saved_otp = $otp_data['otp'];
            $otp_time = $otp_data['time'];
    
            if ($otp == $saved_otp) {
                $otp_timestamp = strtotime($otp_time);
                $current_timestamp = time();
    
                $time_difference = $current_timestamp - $otp_timestamp;
    
                if ($time_difference <= 600) {
                    return 'success'; 
                } else {
                    return 'failed'; 
                }
            } else {
                return 'invalid';
            }
      
    }

    //for batch api
    public function check_login_auth($data){  
        $query=$this->db->get_where('users',array('email'=>$data['username'],'password'=>$data['password'],'status'=>'1','batch_apiaccess'=>1));  
        return $query->row_array();  
    } 

    public function get_centers_matching_role($centerrole)
{
    return $this->db->select('id')
        ->from('users')
        ->where('role', $centerrole)
        ->get()
        ->result_array();
}
    
}