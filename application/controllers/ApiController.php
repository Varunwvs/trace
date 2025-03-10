<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog'))){
	      header('location:home');
	  	}  
	  	$this->load->helper('url');
		$this->load->model('CompanyModel','cm');
    	$this->load->model('app/seed/ProductModel','pm');
		$this->load->model('app/seed/BatchModel','bm');
		$this->load->model('UserModel','um');
		$this->load->model('app/seed/ContainerModel','ccm');
	}
// 	public function test(){
// 		$alias = '1000000';
// 		$this->db->select('*');
// 		$this->db->from('seedcontainer');
// 		$res = $this->db->get()->result();
// 		//var_dump($res);exit();
// 		foreach($res as $row){
// 			$data = array('alias' => $alias);
// 			$this->db->where('ctid',$row->ctid);
// 			$this->db->update('seedcontainer',$data);
// 			$alias++;
// 		}
		
// 	}

	public function api(){
        //echo $user_id;exit();
		$data['thisPage'] = 'api_page';
	    $data['pgScript'] = 'api_page';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'KKISAN QR API';
	    $this->load->datatable_template('api/apiPage', $data);
	}
	
	//  sending Single Product master data	
	public function sprd_api_post(){
		$pid = $this->input->post('productId');
		$this->get_sproduct($pid);
	}

	public function get_sproduct($pid){
		$user_id='';
		$adminrole = $this->session->userdata('role');
		$admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';
		if($_SESSION['role'] != $center){
			$user_id = $this->session->userdata('comid');
		}else{
			$cinfo = $this->db->select('id as cid')->from('users')->where('role', $admin)->get();
			foreach($cinfo->result() as $crow){
				$cid = $crow->cid;
			}
			$user_id = $cid;
		}
		$productss = $this->pm->getSProduct($user_id, $pid);
// 		var_dump($productss);exit();
		if($productss){
			foreach($productss as $prod){
				//echo $prod->id;
				$id = $prod->id;
				$applicationID=$prod->applicationid;
				$productCode = $prod->p_code;
				$manufacturerID=$prod->mfg_id;
				$manufacturerName = $prod->name;
				$marketedBy = $prod->marketed_by;
				$supplierName = $prod->marketed_by;
				$itemCategoryID=$prod->catid;
				$categoryName = $prod->p_category;
				$subCategoryID=$prod->subcatid;
				$subCategoryName = $prod->sub_category;
				$itemID = $prod->itemid;
				$seedClassID = $prod->itemclassid;
				$productName = $prod->p_name;
				$brandName = $prod->b_name;
				$uomId = $prod->uomid;
				$weight = $prod->net_w;
				$this->saveSProductMaster($applicationID,$productCode,$manufacturerID,$manufacturerName,$marketedBy,$supplierName,$itemCategoryID,
				$categoryName,$subCategoryID,$subCategoryName,$itemID,$seedClassID,$productName,$brandName,$uomId,$weight,$id);
				// $this->saveSProductMaster($productCode,$manufacturerName,$supplierName,$categoryName,$subCategoryName,$productName,$brandName,$uomId,$weight,$id);
			}
		}
	}

	public function saveSProductMaster($applicationID,$productCode,$manufacturerID,$manufacturerName,$marketedBy,$supplierName,$itemCategoryID,
				$categoryName,$subCategoryID,$subCategoryName,$itemID,$seedClassID,$productName,$brandName,$uomId,$weight,$id){
	    $response = '';
	    
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$method = $_SERVER['REQUEST_METHOD'];
		$postData = array(
		    "ApplicationID"=>$applicationID,
            "ProductCode"=>$productCode,
            "ManufacturerID"=>$manufacturerID,
            "ManufacturerName"=>$manufacturerName,
            "MarketedBy"=>$marketedBy,
            "CIBRegistrationCertificate"=>'',
            "LicenseNumber"=>'',
            "SupplierName"=>$supplierName,
            "ItemCategoryID"=>$itemCategoryID,
            "CategoryName"=>$categoryName,
            "SubCategoryID"=>$subCategoryID,
            "SubCategoryName"=>$subCategoryName,
            "ItemID"=>$itemID,
            "SeedClassID"=>$seedClassID,
            "ProductName"=>$productName,
            "BrandName"=>$brandName,
            "UomID"=>$uomId,
            "Weight"=>$weight,
            "GSM"=>'',
            "CM_L_BIS_Number"=>''
			);
		//print_r($auth_key);exit();			
// 		print_r($postData);exit();
		$postDataJson = json_encode($postData);
		if($method != 'POST'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$saveProductMaster_url = get_settings("saveProductMaster_url");
	    	$curl = curl_init();
	    	
	    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    		curl_setopt_array($curl, array(
			    CURLOPT_URL => "$saveProductMaster_url",
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_HTTPHEADER => array(
			    	"Authorization: $auth_key",
			        "content-type: application/json"
			    ),
			));
	      $response = curl_exec($curl);
	      $err = curl_error($curl);
          curl_close($curl);
          //return $response ;
          if ($err) {
		    echo "cURL Error #:" . $err;
		} else {
		    //echo 'got it';
		    $this->pm->update_api_response($id,$response);
		    $resp_len = strlen($response);
			if($resp_len == '0'){
		    $this->pm->update_product_api($id);
			}
		    //print_r($response);
		}
    	}
    	//exit();
	}
	
	// Sending single Batch data 	
	public function sbtch_api_post(){
		$bid = $this->input->post('batchId');
	    $this->get_sbatch($bid);
	}

	public function get_sbatch($bid){
		$user_id='';
		$adminrole = $this->session->userdata('role');
		$admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';
		if($_SESSION['role'] != $center){
			$user_id = $this->session->userdata('comid');
		}else{
			$cinfo = $this->db->select('id as cid')->from('users')->where('role', $admin)->get();
			foreach($cinfo->result() as $crow){
				$cid = $crow->cid;
			}
			$user_id = $cid;
		}
		$batches = $this->bm->getsBatch($user_id, $bid);
		$vendor_code = get_settings('vendor_code');
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$saveQRDetail_url = get_settings("saveQRDetail_url");
		if($batches){
			foreach($batches as $b){
				$manufactureDate = date('d/m/Y',strtotime($b->mfd_date));
				$expiryDate = date('d/m/Y',strtotime($b->exp_date));
				$productCode = $b->p_code;
				$batch_no = $b->batch_no;
				$batch_serialno = $this->bm->get_batch_serial_no($b->id);
				$bid = $b->id;
				$api_data = array();
				$sbsid = array();
				foreach($batch_serialno as $bs){
					$sbsid[] = $bs->sbsid;
					$api_data[] = array(
					'QRCode' => $vendor_code.$bs->alias,
					'ProductCode' => $productCode,
					'BatchNumber' => $batch_no,
					'SerialNumber' => $bs->serialno,
					'ManufactureDate' => $manufactureDate,
					'ExpiryDate' => $expiryDate,
					);
				}
	
				$method = $_SERVER['REQUEST_METHOD'];
				$postDataJson = json_encode($api_data);
				if($method != 'POST'){
					json_output(200, array('success' => false,'message' => 'Request method not accepted'));
				} else {
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt_array($curl, array(
					CURLOPT_URL => "$saveQRDetail_url",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $postDataJson,
					CURLOPT_HTTPHEADER => array(
						"Authorization: $auth_key",
						"content-type: application/json"
					),
					));
					$response = curl_exec($curl);
					
					$err = curl_error($curl);
					curl_close($curl);
	
					if ($err) {
	
					} else {
						if($sbsid){
						foreach($sbsid as $sid){
							$this->bm->update_batch_api_response($sid,$response);
							$resp_len = strlen($response);
							if($resp_len == '0'){
								$this->bm->update_batch_api($sid);
							}
						}
						}
						$resp_len = strlen($response);
						if($resp_len == '0'){
							$this->bm->update_batch($bid);
						}
					}
				}
			}
			
		}
	}
	
//  sending Product master data
	public function api_post(){
		$this->get_product();
		//$this->get_batch();
		$this->session->set_flashdata('success_message', 'Data Sent Successfully');
        redirect('kkisaanapi');
	}
// Sending Batch data 	
	public function batch_api_post(){
	    $this->get_batch();
	    $this->session->set_flashdata('success_message', 'Data Sent Successfully');
        redirect('kkisaanapi');
	}
	
    public function get_product(){
		$user_id='';
		$adminrole = $this->session->userdata('role');
		$admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';
		if($_SESSION['role'] != $center){
			$user_id = $this->session->userdata('comid');
		}else{
			$cinfo = $this->db->select('id as cid')->from('users')->where('role', $admin)->get();
			foreach($cinfo->result() as $crow){
				$cid = $crow->cid;
			}
			$user_id = $cid;
		}
	     
		$products = $this->pm->getProduct($user_id);
// 		var_dump($products);exit();
		
// 		echo $applicationid; die();
		if($products){
			foreach($products as $prod){
				$id = $prod->id;
				$applicationID=$prod->applicationid;
				$productCode = $prod->p_code;
				$manufacturerID=$prod->mfg_id;
				$manufacturerName = $prod->name;
				$marketedBy = $prod->marketed_by;
				$supplierName = $prod->marketed_by;
				$itemCategoryID=$prod->catid;
				$categoryName = $prod->p_category;
				$subCategoryID=$prod->subcatid;
				$subCategoryName = $prod->sub_category;
				$itemID = $prod->itemid;
				$seedClassID = $prod->itemclassid;
				$productName = $prod->p_name;
				$brandName = $prod->b_name;
				$uomId = $prod->uomid;
				$weight = $prod->net_w;
				$this->saveProductMaster($applicationID,$productCode,$manufacturerID,$manufacturerName,$marketedBy,$supplierName,$itemCategoryID,
				$categoryName,$subCategoryID,$subCategoryName,$itemID,$seedClassID,$productName,$brandName,$uomId,$weight,$id);
			}
		}
	}

	public function saveProductMaster($applicationID,$productCode,$manufacturerID,$manufacturerName,$marketedBy,$supplierName,$itemCategoryID,
				$categoryName,$subCategoryID,$subCategoryName,$itemID,$seedClassID,$productName,$brandName,$uomId,$weight,$id){
	    $response = '';
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$method = $_SERVER['REQUEST_METHOD'];
		$postData = array(
		    "ApplicationID"=>$applicationID,
            "ProductCode"=>$productCode,
            "ManufacturerID"=>$manufacturerID,
            "ManufacturerName"=>$manufacturerName,
            "MarketedBy"=>$marketedBy,
            "CIBRegistrationCertificate"=>'',
            "LicenseNumber"=>'',
            "SupplierName"=>$supplierName,
            "ItemCategoryID"=>$itemCategoryID,
            "CategoryName"=>$categoryName,
            "SubCategoryID"=>$subCategoryID,
            "SubCategoryName"=>$subCategoryName,
            "ItemID"=>$itemID,
            "SeedClassID"=>$seedClassID,
            "ProductName"=>$productName,
            "BrandName"=>$brandName,
            "UomID"=>$uomId,
            "Weight"=>$weight,
            "GSM"=>'',
            "CM_L_BIS_Number"=>''
			);
        //print_r($auth_key);exit();			
        // print_r($postData);exit();
		$postDataJson = json_encode($postData);
		if($method != 'POST'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$saveProductMaster_url = get_settings("saveProductMaster_url");
	    	$curl = curl_init();
	    	
	    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    		curl_setopt_array($curl, array(
			    CURLOPT_URL => "$saveProductMaster_url",
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_HTTPHEADER => array(
			    	"Authorization: $auth_key",
			        "content-type: application/json"
			    ),
			));
	      $response = curl_exec($curl);
	      $err = curl_error($curl);
          curl_close($curl);
          //return $response ;
          if ($err) {
		    echo "cURL Error #:" . $err;
		} else {
		    //echo 'got it';
		    $this->pm->update_api_response($id,$response);
		    $resp_len = strlen($response);
			if($resp_len == '0'){
		    $this->pm->update_product_api($id);
			}
		    //print_r($response);
		}
    	}
    	//exit();
	}




public function get_batch(){
		if($_SESSION['role'] != 'kssccenter'){
			$user_id = $this->session->userdata('comid');
		}else{
			$cinfo = $this->db->select('id as cid')->from('users')->where('role', 'ksscadmin')->get();
			foreach($cinfo->result() as $crow){
				$cid = $crow->cid;
			}
			$user_id = $cid;
		}
		$batches = $this->bm->getBatches($user_id);
		$vendor_code = get_settings('vendor_code');
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$saveQRDetail_url = get_settings("saveQRDetail_url");
		if($batches){
			foreach($batches as $b){
				$manufactureDate = date('d/m/Y',strtotime($b->mfd_date));
				$expiryDate = date('d/m/Y',strtotime($b->exp_date));
				$productCode = $b->p_code;
				$batch_no = $b->batch_no;
				$batch_serialno = $this->bm->get_batch_serial_no($b->id);
				$bid = $b->id;
				$api_data = array();
				$sbsid = array();
				foreach($batch_serialno as $bs){
					$sbsid[] = $bs->sbsid;
					$api_data[] = array(
					'QRCode' => $vendor_code.$bs->alias,
			    	'ProductCode' => $productCode,
			    	'BatchNumber' => $batch_no,
			    	'SerialNumber' => $bs->serialno,
			    	'ManufactureDate' => $manufactureDate,
			    	'ExpiryDate' => $expiryDate,
			    	);
				}

				$method = $_SERVER['REQUEST_METHOD'];
				$postDataJson = json_encode($api_data);
				if($method != 'POST'){
	      			json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    		} else {
	    			$curl = curl_init();
	    			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    			curl_setopt_array($curl, array(
				    CURLOPT_URL => "$saveQRDetail_url",
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_CUSTOMREQUEST => "POST",
				    CURLOPT_POSTFIELDS => $postDataJson,
				    CURLOPT_HTTPHEADER => array(
				    	"Authorization: $auth_key",
				        "content-type: application/json"
				    ),
					));
					$response = curl_exec($curl);
					
					$err = curl_error($curl);
					curl_close($curl);

					if ($err) {

					} else {
					    if($sbsid){
						foreach($sbsid as $sid){
 			   			 $this->bm->update_batch_api_response($sid,$response);
 			    		 $resp_len = strlen($response);
				 			if($resp_len == '0'){
				 				$this->bm->update_batch_api($sid);
				 			}
				 		}
					    }
				 		$resp_len = strlen($response);
				 		if($resp_len == '0'){
				 			$this->bm->update_batch($bid);
				 		}
					}
	    		}
			}
			
		}
	}
	
	
// Secondary container code
public function get_container_code(){
    
        $response = '';
	    //$user_id = $this->session->userdata('comid');
// 	    if($_SESSION['role'] == 'kssccenter'){
// 			$user_id = $this->session->userdata('comid');
			
// 		}else{
// 			$cinfo = $this->db->select('id as cid')->from('users')->where('role', 'ksscadmin')->get();
			
// 			foreach($cinfo->result() as $crow){
// 				$cid = $crow->cid;
// 			}
// 			$user_id = $cid;
// 		}

$user_id = $this->session->userdata('comid');
		//echo $user_id;exit();
	    $container_code = $this->ccm->getContainer($user_id);
	    $vendor_code = get_settings('vendor_code');
	    //var_dump($container_code);exit();
	    $access_token = $this->generate_token();
	    if($container_code){
	    	foreach ($container_code as $container) {
	    	    //echo 'cmc '.$container->ctid.'<br/>';
	    	    $serialno_data = $this->ccm->get_serno_by_container($container->ctid);
	    	    $bid = $container->batchno;
	    	    $api_data = array();
	    	    //var_dump($serialno_data);
	    		//$serialno_data = $container->serial;
	    		//$serialno = explode(",", $serialno_data);
	    		//print_r($serialno_data);exit();
	    		$detail_arr = array();
	    		foreach ($serialno_data as $sno) {
	    			$label_detail = $this->bm->label_detail($sno->serialno);
	    			//echo $sno->serialno.'<br/>';
	    			
	    			foreach ($label_detail as $detail) {
	    				$detail_arr[] = array(
	    				    'QRCode' => $vendor_code.$detail->alias,
	    				    'ProductCode' => $detail->productCode,
	    				    'BatchNumber' => $detail->batch_no,
	    				    'SerialNumber' =>$detail->sr_no,
	    				    'ManufactureDate' => date('d/m/Y',strtotime($detail->mfd_date)),
	    				    'ExpiryDate' => date('d/m/Y',strtotime($detail->exp_date)),
	    				    );
	    			}
	    		}
	   // 		var_dump($detail_arr);exit();
	    		$api_data['secondaryContainerDetail'] = array(array(
	    				'QRCode' => $vendor_code.$container->alias,
	    				'SecondaryContainerCode' => $container->ucc,
	    				'SecondaryLabelDetail' => $detail_arr,
	    			)	
	    		);
	    			$postDataJson = json_encode($api_data);
	    			//$postDataJson = '{'.$postDataJson.'}';
	    			//  print_r($postDataJson);
	    			//  echo '<br><br>';
	    		
		$auth_key = 'Bearer '.$access_token;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$method = $_SERVER['REQUEST_METHOD'];	
	    		if($method != 'POST'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$saveSecondaryContainerDetail_url = get_settings("saveSecondaryContainerDetail_url");
	    	$curl = curl_init();
	    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    		curl_setopt_array($curl, array(
			    CURLOPT_URL => "$saveSecondaryContainerDetail_url",
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_HTTPHEADER => array(
			    	"Authorization: $auth_key",
			        "content-type: application/json"
			    ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
          curl_close($curl);
          //return $response ;
          if ($err) {
		    echo "cURL Error #:" . $err;
		    exit();
		} else {
		    $this->ccm->update_container_api_response($container->ucc,$response);
			$resp_len = strlen($response);
			if($resp_len == '0'){
			    $this->ccm->update_container_api($container->ucc); 
			}
		}
	    }
	   // 		print_r($response);exit();
	    	}
	    }
            $this->session->set_flashdata('success_message', 'Data Sent Successfully');
        redirect('kkisaanapi');
	   // print_r(json_encode($api_data));exit();
	    
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




	public function getUnitOfMeasurements(){
		$access_token = $this->generate_token();
		echo $access_token;exit();
		$curl = curl_init();
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'GET'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$getUnitOfMeasurements_url = get_settings("getUnitOfMeasurements_url");
	    		
    	}
	}

	

	public function saveQRDetail($productCode,$batchNumber,$serialNumber,$manufactureDate,$expiryDate,$id){
		$access_token = $this->generate_token();
		$auth_key = 'Bearer'.$access_token;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$method = $_SERVER['REQUEST_METHOD'];
		$manufactureDate = date('d-m-Y',strtotime($manufactureDate));
		$expiryDate = date('d-m-Y',strtotime($expiryDate));
		$postData = array(
			"ProductCode"=>$productCode,
			"BatchNumber"=>$batchNumber,
			"SerialNumber"=>$serialNumber,
			"ManufactureDate"=>$manufactureDate,
			"ExpiryDate"=>$expiryDate
			);
		$postDataJson = json_encode($postData);
		if($method != 'POST'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$saveQRDetail_url = get_settings("saveQRDetail_url");
	    	$curl = curl_init();
	    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    		curl_setopt_array($curl, array(
			    CURLOPT_URL => "$saveQRDetail_url",
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_HTTPHEADER => array(
			    	"Authorization: $auth_key",
			        "content-type: application/json"
			    ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
          curl_close($curl);
          //return $response ;
          if ($err) {
		    //echo "cURL Error #:" . $err;
		} else {
		    $this->bm->update_batch_api($id);
		}
	    }
	}

	public function saveSecondaryContainerDetail($secondaryContainerCode){
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$method = $_SERVER['REQUEST_METHOD'];
		$manufactureDate = date('d-m-Y',strtotime($manufactureDate));
		$expiryDate = date('d-m-Y',strtotime($expiryDate));
		$postData = array(
			"ProductCode"=>$productCode,
			"SecondaryContainerCode"=>$secondaryContainerCode,
			"Quantity"=>$quantity
			);
		$postDataJson = json_encode($postData);
		if($method != 'POST'){
	      json_output(200, array('success' => false,'message' => 'Request method not accepted'));
	    } else {
	    	$saveSecondaryContainerDetail_url = get_settings("saveSecondaryContainerDetail_url");
	    	$curl = curl_init();
	    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    		curl_setopt_array($curl, array(
			    CURLOPT_URL => "$saveSecondaryContainerDetail_url",
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $postDataJson,
			    CURLOPT_HTTPHEADER => array(
			    	"Authorization: $auth_key",
			        "content-type: application/json"
			    ),
			));
			$response = curl_exec($curl);
          curl_close($curl);
          return $response ;
	    }
	}
}	