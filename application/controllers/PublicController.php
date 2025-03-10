<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PublicController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    $this->load->helper(array('form', 'url'));
	  	// $this->load->helper('url','kisaan_helper');
		// $this->load->model('admin/CenterModel','cm');
		// $this->load->model('admin/ProductModel','pm');
		// $this->load->model('admin/UserModel','um');
	    $this->load->model('admin/PharmaModel','phm');
		$this->load->library('form_validation');
	}

    public function index(){
	    $data['thisPage'] = 'k';
	    $data['pgScript'] = 'k';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'k';  
	    $this->load->home_template('public/k', $data);
	}
	
	public function pp(){
	    $data['thisPage'] = 'pp';
	    $data['pgScript'] = 'pp';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Batch View';  
	    $this->load->public_template('public/pp', $data);
	}
	
	public function pps(){
	    $data['thisPage'] = 'pps';
	    $data['pgScript'] = 'pps';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Batch View';  
	    $this->load->public_template('public/pps', $data);
	}

	public function qrcodecheck(){
		$data['thisPage'] = 'qr';
	    $data['pgScript'] = 'qr';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Qrcode Check';  
	    $this->load->home_template('public/qrcodecheck', $data);
	}

	public function get_api_data(){

	$type=$this->input->post('type');
	$product_code=$this->input->post('product_code');
	$alias_no=$this->input->post('alias_no');

	if($type=='product_detail'){
		$url = get_settings("getProductDetail_url");
		$api_url =$url.'='.$product_code;
	}elseif($type=='primary_detail'){
		$url = get_settings("getPrimaryDetail_url");
		$api_url =$url.'='.$alias_no;
	}elseif($type=='primary_detailMi'){
		$url = get_settings("getPrimaryDetailMi_url");
		$api_url =$url.'='.$alias_no;
	}

	    $access_token = $this->generate_token();	
		$auth_key = 'Bearer '.$access_token;

	    $curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    	curl_setopt_array($curl, array(
			CURLOPT_URL =>$api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: $auth_key",
				"content-type: application/json"
			),
    	));

		$response1 = curl_exec($curl);
		$err = curl_error($curl);
        curl_close($curl);

		//unitof measurements
		$uom_url = get_settings("getUnitOfMeasurements_url");

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    	curl_setopt_array($curl, array(
			CURLOPT_URL =>$uom_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				// "Authorization: $auth_key",
				"content-type: application/json"
			),
    	));

		$uom_response = curl_exec($curl);
		$err = curl_error($curl);
        curl_close($curl);

       //from primary details(alias no) to get product details
		if($type!='product_detail'){

			$data=json_decode($response1,true);
			$url = get_settings("getProductDetail_url");
		    $api_url = $url.'='.$data['ProductCode'];

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	
			curl_setopt_array($curl, array(
				CURLOPT_URL =>$api_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Authorization: $auth_key",
					"content-type: application/json"
				),
			));
	
			$response2 = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				//echo "cURL Error #:" . $err;
				echo 'error';
				exit();
			} else {
			   echo json_encode(['alias_details'=>$response1,'product_details'=>$response2,'uom_details'=>$uom_response]);
			return;
			}
		}
      
        if ($err) {
		    // echo "cURL Error #:" . $err;
			echo 'error';
		    exit();
		} else {
		   echo json_encode(['product_details'=>$response1,'uom_details'=>$uom_response]);
		   
		}
	    
	 
	
	    
}




	public function generate_token(){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$method = $_SERVER['REQUEST_METHOD'];

// 		if($method != 'GET'){
// 		   // echo 'Hi';
//       	json_output(200, array('success' => false,'message' => 'Request method not accepted'));exit();
//     } else {
    	$username = get_settings("username");
    	$password = get_settings("password");
    	$grant_type = get_settings("grant_type");
    	$token_expiry = get_settings("token_expiry");
    	$postData = 'username='.$username.'&password='.$password.'&grant_type='.$grant_type;
    	//echo $token_expiry.'<br/>';
    	//$token_expiry = '2023-03-09 09:03:00'.'<br/>';
    	//echo date('Y-m-d H:i:s',$token_expiry);
    	//$today = gmdate('Y-m-d H:i:s');
    	//echo '<br/>'.$today;exit();
    	//if($token_expiry == "" || $token_expiry > $today){
    	
    	//if($token_expiry != ""){
    		$token_gen_url = get_settings("token_gen_url");
    		$curl = curl_init();
    		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    		curl_setopt_array($curl, array(
			    CURLOPT_URL => "$token_gen_url",
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $postData,
			    CURLOPT_HTTPHEADER => array(
			        "content-type: application/x-www-form-urlencoded"
			    ),
			));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		    echo "cURL Error #:" . $err;
		} else {
		    $json_res = json_decode($response,false);
		    //print_r($json_res);
		  //  foreach($json_res as $key=>$val){
		  //  	//echo $key.'<br/>';
		  //  	if($key == '.expires'){
		  //  		update_settings('token_expiry',$val);
		  //  	}
		  //  }
		  //  update_settings('access_token',$json_res->access_token);
		    //update_settings('token_expiry',$json_res->expires);
		    $access_token = $json_res->access_token;
		    //print_r($access_token);
		    return  $access_token; 
    	}
		//}
    	//}

	}//generate_token ends


	public function productcheck(){
		$data['thisPage'] = 'product';
	    $data['pgScript'] = 'pharmaproducts';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Product Check';  
	    $this->load->home_template('public/productcheck', $data);
	}

	public function get_product_data(){

		$data=$this->phm->get_product_details();
		echo json_encode($data);	
		 
		
			
	}


	//register product from public page

public function register_product() {
// 	ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

	// Set validation rules
	$this->form_validation->set_rules('name', 'Name', 'required');
	$this->form_validation->set_rules('mobile', 'Mobile', 'required');
	$this->form_validation->set_rules('location', 'Location', 'required');

	if ($this->form_validation->run() === FALSE) {
		echo json_encode(['status' => false, 'message' => validation_errors()]);
		return;
	}

	// Get POST data
	$data = [
		'name' => $this->input->post('name'),
		'mobile' => $this->input->post('mobile'),
		'location' => $this->input->post('location'),
		'email' => $this->input->post('email'),
		'product_purchased' => $this->input->post('product_purchased'),
		'batch_no' => $this->input->post('batch_no'),
		'purchase_source' => $this->input->post('purchase_source')
	];

	// Save data to the database
	$insert_id = $this->db->insert('registered_products', $data);

	if ($insert_id) {
		echo json_encode(['status' => true, 'message' => 'Product registered successfully!']);
	} else {
		echo json_encode(['status' => false, 'message' => 'Failed to register the product.']);
	}
}

}