<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ApiDataController extends CI_Controller {
	public function __construct(){
	    parent::__construct();	    
	  	$this->load->helper('url');
		$this->load->model('ApiModel','apm');
	}

    public function generate_token(){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$method = $_SERVER['REQUEST_METHOD'];
    	$username = get_settings("username");
    	$password = get_settings("password");
    	$grant_type = get_settings("grant_type");
    	$token_expiry = get_settings("token_expiry");
    	$postData = 'username='.$username.'&password='.$password.'&grant_type='.$grant_type;
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
		    $access_token = $json_res->access_token;
		    //print_r($access_token);
		    return  $access_token; 
    	}
	}//generate_token ends

    public function item_details(){
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$curl = curl_init();
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'GET'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$getflitemdetails_url = get_settings("getflitemdetails_url");	    		
    	}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$getflitemdetails_url",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: $auth_key",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		// print_r($response); die();
		$err = curl_error($curl);
		curl_close($curl);
		//return $response ;
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// echo 'got it';die();
			$this->apm->update_Itemdetails($response);
			$resp_len = strlen($response);
			if($resp_len == '0'){
				$this->apm->update_product_api($response);
			}
			//print_r($response);
		}
		
	}

	public function item_sub_cat(){
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$curl = curl_init();
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'GET'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$getflitemsubcat_url = get_settings("getflitemsubcat_url");	    		
    	}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$getflitemsubcat_url",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: $auth_key",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		// print_r($response); die();
		$err = curl_error($curl);
		curl_close($curl);
		//return $response ;
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// echo 'got it';die();
			$this->apm->update_Itemsubcat($response);
			$resp_len = strlen($response);
			if($resp_len == '0'){
				$this->apm->update_product_api($response);
			}
			//print_r($response);
		}
		
	}
}