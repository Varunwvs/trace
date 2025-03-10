<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FLCronController extends CI_Controller {
	
	public function __construct(){
	    
	    parent::__construct();
	  	
	  	$this->load->helper('url');
		$this->load->model('CompanyModel','cm');
    	$this->load->model('app/fertilizer/ProductModel','pm');
		$this->load->model('app/fertilizer/BatchModel','bm');
		$this->load->model('UserModel','um');
		$this->load->model('app/fertilizer/SecondaryserialModel','ccm');
	}
	
	public function generate_token(){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
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
	
	//function to process batch	
	public function process_batch_containers(){	   
	   //fetch 1 batch where schedule_cron = 1	   
	   $query = $this->db->query("select id, (select count(ctid) from fertilizercontainer where batchno=sb.id and cron_status=1) as pending_containers from fertilizerbatch sb where schedule_cron=1 ORDER BY sb.order_by DESC");
	   $fertilizerbatch=$query->row_array();
	   
	   if(@$fertilizerbatch['id']>0){	       
	       //fetch 1 container if pending containers > 0
	       if($fertilizerbatch['pending_containers']>0){	           
	            $query = $this->db->query("select ctid from fertilizercontainer sc where cron_status=1 and batchno=?", $fertilizerbatch['id']);
	            $fertilizercontainer=$query->row_array();	           
	            if($fertilizercontainer){	               
	               $this->push_containers_to_api($fertilizercontainer['ctid']);	           
	            }	           
	        } else {	           
	            //mark fertilizerbatch as processed
	            $this->db->update("fertilizerbatch", array("schedule_cron"=>2), array("id"=>$fertilizerbatch['id']));	            
	            $this->bm->update_batch($fertilizerbatch['id']);	       
	        }       
	    }	   
	}
		
    // push containers to api
	public function push_containers_to_api($container_id){ 
	    // fetch container	
	    $query = $this->db->query("select * from fertilizercontainer sc where ctid=?", $container_id);
        $container=$query->row();	
	    $vendor_code = get_settings('vendor_code');	
	    $access_token = $this->generate_token();

	    if($container){	    
	        $api_data = array();		
			$serialno_data = $this->ccm->get_serno_by_container($container->ctid, $container->batchno);
    	    $bid =  $container->batchno;			
			$detail_arr = array();
			foreach ($serialno_data as $sno) {   	
                $detail_arr[] = array(
                    'QRCode' => $vendor_code.$sno->palias,
                    'ProductCode' => $sno->productCode,
                    'BatchNumber' => $sno->batch_no,
                    'SerialNumber' =>$sno->sr_no,
                    'ManufactureDate' => date('d/m/Y',strtotime($sno->mfd_date)),
                    'ExpiryDate' => date('d/m/Y',strtotime($sno->exp_date)),
                );    		
    		}
			
    		$api_data['secondaryContainerDetail'][] = array(
				'QRCode' => $vendor_code.$container->alias,
				'SecondaryContainerCode' => $container->ucc,
				'SecondaryLabelDetail' => $detail_arr);
		
		    $postDataJson = json_encode($api_data);
	
		    $auth_key = 'Bearer '.$access_token;
		    $curl = curl_init();
		
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
		 	)));
		 	$response = curl_exec($curl);
		 	$err = curl_error($curl);
		 	curl_close($curl);
		 	
		 	if ($err) {		 	    
		 		echo "cURL Error #:" . $err;
		 		exit();		 		
		 	} else {		 	    
		 		$this->ccm->update_container_api_response($container->ucc,$response);
		 		$resp_len = strlen($response);
		 		
		 		if($resp_len == '0'){		 			
		 			$this->ccm->update_container_api($container->ucc); 
		 		}		 		
		 		//update container cron status = 2
		 		//update schedule cron status to 2 in container in container table
                $this->db->update("fertilizercontainer", array("cron_status"=>2), array("ctid"=>$container->ctid));
		 	}		
	    } //container code	   
	}
	
	public function process_batch_primary(){	    
	    $query = $this->db->query("select id,batch_no,mfd_date,exp_date,p_code from fertilizerbatch sb where schedule_cron=1 ORDER BY sb.order_by ASC");
	    $fertilizerbatch=$query->row_array();
	    $batchcnt = $query->num_rows();
	   
	    if($batchcnt>0){	       
	           $this->push_primary_to_api($fertilizerbatch['id'],$fertilizerbatch['batch_no'],$fertilizerbatch['mfd_date'],$fertilizerbatch['exp_date'],$fertilizerbatch['p_code']);
	           //exit();	       
	    } else {	           
	            //mark fertilizerbatch as processed
	            //$this->db->update("fertilizerbatch", array("schedule_cron"=>2), array("id"=>$fertilizerbatch['id']));	            
	            //$this->bm->update_batch($fertilizerbatch['id']);	       
	    }
	}
	
	
	public function push_primary_to_api($batch_id,$batch_no,$mfd_date,$exp_date,$p_code){ 
        $vendor_code = get_settings('vendor_code');
		$access_token = $this->generate_token();
		$auth_key = 'Bearer '.$access_token;
		$saveQRDetail_url = get_settings("saveQRDetail_url");
	    if($batch_id){
			$manufactureDate = date('d/m/Y',strtotime($mfd_date));
			$expiryDate = date('d/m/Y',strtotime($exp_date));
			$productCode = $p_code;
			$batch_no = $batch_no;
			$batch_serialno = $this->bm->get_batch_serial_no($batch_id);
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
			//print_r($postDataJson);exit();
				
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
                    $this->bm->update_batch($batch_id);
                    $this->db->update("fertilizerbatch", array("schedule_cron"=>2), array("id"=>$batch_id));
                }else{
                    $this->db->update("fertilizerbatch", array("schedule_cron"=>3), array("id"=>$batch_id));
                }
			}					
			print_r($response);
	    } //container code
	}
	
    public function auto_send_container_api(){
        $data['title'] = 'Container api';  
        $this->load->api_template('api/fl_container_api',$data);
    }

}	