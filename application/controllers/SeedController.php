<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SeedController extends CI_Controller {

	
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog')) || $this->session->userdata('level')!='3'){
	      header('location:home');
	  	}  
	  	$this->load->helper('url');
		$this->load->model('app/seed/DashboardModel','dm');
		$this->load->model('app/seed/ProductModel','pm');
		$this->load->model('app/seed/BatchModel','bm');
		$this->load->model('app/seed/ContainerModel','ccm'); 
		$this->load->model('app/seed/UserModel','um'); 
		$this->load->model('app/seed/PProductModel','ppm');
        $this->load->model('app/seed/PBatchModel','pbm');
        $this->load->model('app/seed/PPrimaryserialModel','ppsm');
        $this->load->model('app/seed/PSecondaryserialModel','pssm');

		$this->load->model('app/seed/SourcingModel','sm');
		$this->load->model('app/seed/ProcessingModel','prom');
		$this->load->model('app/seed/VendorModel','vm');
		$this->load->model('app/seed/SourcingCategoryModel','scm');
		$this->load->model('app/seed/RawMaterialModel','rm');
		$this->load->model('app/seed/TraceProductModel','tpm');

	}

    public function index(){
	    $data['thisPage'] = 'dashboard';
	    $data['pgScript'] = 'dashboard';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Dashboard';  
	    $this->load->dashboard_template('app/seed/dashboard', $data);
	}

/*=-Starts Dashboard-=*/
	//Product active count
	function prdCount(){
		$data = $this->dm->prdCount();
		echo $data;
	}
	//Poduct deleted count
	function dprdCount(){
		$data = $this->dm->dprdCount();
		echo $data;
	}
	//Batch active count
	function bthCount(){
		$data = $this->dm->bthCount();
		echo $data;
	}
	//batch deleted count
	function bthdCount(){
		$data = $this->dm->bthdCount();
		echo $data;
	}
	//Container active count
	function cthCount(){
		$data = $this->dm->cthCount();
		echo $data;
	}
	//Container deleted count
	function cthdCount(){
		$data = $this->dm->cthdCount();
		echo $data;
	}
	//Total active count
	function totCount(){
		$data = $this->dm->totCount();
		echo $data;
	}
	//Total remaining count
	function rtotCount(){
		$data = $this->dm->rtotCount();
		echo $data;
	}
/*=-Ends Dashboard-=*/

/*=-Starts Search-=*/
	public function searchresult(){
		$data['srchcat'] = $this->input->post('srchcat');
        $data['srchterm'] = $this->input->post('srchterm');
		$data['thisPage'] = 'searchresult';
		$data['pgScript'] = 'searchresult';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Search Result';  
		$this->load->formentry_template('app/seed/searchresult', $data);
	}
/*=-Ends Search-=*/

/*=-Starts Help-=*/
	public function help(){
    $data['thisPage'] = 'help';
    $data['pgScript'] = 'help';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Help';  
    $this->load->formentry_template('app/seed/help', $data);
}
/*=-Ends Help-=*/

/*=-Starts Settings-=*/
	//import product
	public function productimport(){
		$data['thisPage'] = 'productimport';
		$data['pgScript'] = 'productimport';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Product Import';  
		$this->load->formentry_template('app/seed/productimport', $data);
	}

	//get company info
	function getCominfo(){
		$data=$this->um->getCominfo();
		echo json_encode($data);
	}
	//Profile view
	public function userprofile(){
		$data['thisPage'] = 'userprofile';
		$data['pgScript'] = 'userprofile';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Profile';  
		$this->load->formentry_template('app/seed/userprofile', $data);
	}
	//Update Profile
	function updProfile(){
		$data=$this->um->updProfile();
		echo json_encode($data);
	}
/*=-Ends Settings-=*/

/*=-Starts Products-=*/
    public function productmanages(){
	    $data['thisPage'] = 'productmanages';
	    $data['pgScript'] = 'productmanages';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Manage Products';  
	    $this->load->datatable_template('app/seed/productmanages', $data);
	}
	//View Product Manage Page
	public function productmanage(){
	    $data['thisPage'] = 'productmanage';
	    $data['pgScript'] = 'productmanage';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Manage Products';  
	    $this->load->datatable_template('app/seed/productmanage', $data);
	}
	//Product Datatable view
	function dtProduct(){
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->pm->getRows($_POST);        
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
        $admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';
        $apistatus='';
        $dis='';
        $hid='';
        $pinfo='';
        $pname='';
        $pcat='';
        foreach($memData as $row){           
            if($row->api_sent!='0'){
                $dis = "disabled";
                $apistatus = '<li class="list-inline-item"><a class="btn text-success btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> API Sent Successfully</a></li>';                
            }else{
                $dis = "";
                $apistatus = '<li class="list-inline-item"><button class="btn btn-outline-danger btn-xs sendApiDataBtn" data-id="'.$row->id.'" '.$dis.'><span class="fa-solid fa-cloud-arrow-up"></span> Send API Data</button></li>';
            }
            if($_SESSION['role']===$center){
                $hid = "hidden";
            }else{
                $hid="";
            }
            if($row->onlyprimary==='1'){
                $pinfo = '<span class="right badge badge-success">Primary</span>';
            }else{
                $pinfo = '<span class="right badge badge-warning">Secondary</span>';
            }
            $binfo = $this->db->select('*')->from('seedbatch')->where(array('pid'=> $row->id, 'c_id'=>$_SESSION['comid'], 'status'=>'1'))->get();
            $bcount = $binfo->num_rows();
            if($bcount !=0){
                $bc = '<span class="right badge badge-success">'.$bcount.'</span>';
            }else{
                $bc = '<span class="right badge badge-warning">'.$bcount.'</span>';
            }
            $actionButton = '
            <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="productview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.' hidden" role="button" href="miproductedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
                <li class="list-inline-item d-print-none hidden"><a class="btn text-red btn-xs '.$dis.' '.$hid.'" role="button" id="delete_product" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Member"> <span class="fa fa-trash"></span></a></li>
                '.$apistatus.'
            </ul>';
            $pname = ($row->p_name != '') ? strtoupper($row->p_name) : $row->p_name;
            $pcat = ($row->p_category != '') ? ucwords($row->p_category) : $row->p_category;
            $data[] = array(
                $i++, 
                '<strong>'.$pname.'</strong><sup> '.$pinfo.' '.$bc.'</sup>', 
                $row->p_code,       
                $pcat,
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pm->countAll(),
            "recordsFiltered" => $this->pm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
	//UPC No Generation
	function showupc(){
		$data = $this->pm->showupc();
		echo $data;
	}
	//Product Entry Page
// 	public function productentry(){
// 	    $data['thisPage'] = 'productmanage';
// 	    $data['pgScript'] = 'productentry';
// 	    $data['thisPageLevel'] = '2';   
// 	    $data['thisPageMain']="<a href='productmanage'>Manage Product</a>";
// 	    $data['title'] = 'Product Entry';  
// 		$data['uomid'] = $this->pm->getUomid()->result();
// 	    $this->load->formentry_template('app/seed/productentry', $data);
// 	}
	public function productentry(){
	    $data['thisPage'] = 'productmanage';
	    $data['pgScript'] = 'productentry';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='productmanage'>Manage Product</a>";
	    $data['title'] = 'Product Entry';  
	    $data['seedc'] = $this->pm->getSeedclass()->result();
		$data['itemCat'] = $this->pm->getItemCategory()->result();
	    $this->load->formentry_template('app/seed/productentry', $data);
	}
	//Get SubCategory
	function getItemSubCategory(){
		$catid = $this->input->post('id',TRUE);
        $data = $this->pm->getItemSubCat($catid)->result();
        echo json_encode($data);
	}

	//Get Items
	function getItem(){
		$subcatid = $this->input->post('id',TRUE);
        $data = $this->pm->getItem($subcatid)->result();
        echo json_encode($data);
	}

	//get netweight list
    function getNW(){
        $itid = $this->input->post('itid',TRUE);
        $suid = $this->input->post('suid',TRUE);
        $data = $this->pm->getNW($itid, $suid)->result();
        echo json_encode($data);
    }

    //Get net weights
	function getNWs(){
		$itmid = $this->input->post('id',TRUE);
        $subitmid = $this->input->post('subid',TRUE);
        $data = $this->pm->getNWs($itmid, $subitmid)->result();
        echo json_encode($data);
	}

	//Get Items
	function getUomids(){
		$itmid = $this->input->post('id',TRUE);
        $subitmid = $this->input->post('subid',TRUE);
        $data = $this->pm->getUomids($itmid, $subitmid)->result();
        echo json_encode($data);
	}
	//Add New Product
	function addProduct(){
		$data=$this->pm->addProduct();
		echo json_encode($data);
	}
	
	//Delete the product
	function delProduct(){
		$data=$this->pm->delProduct();
		echo json_encode($data);
	}
	//Get Product Info
	function getPrdinfo(){			
		$data=$this->pm->getPrdinfo();
		echo json_encode($data);
	}
	//Edit the product
	public function productedit(){
	    $data['thisPage'] = 'productmanage';
	    $data['pgScript'] = 'productedit';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='productmanage'>Manage Product</a>";
	    $data['title'] = 'Product Edit';  
	    $data['uomid'] = $this->pm->getUomid()->result();
		$data['itemCat'] = $this->pm->getItemCategory()->result();
	    $this->load->formentry_template('app/seed/productedit', $data);
	}	
	//Update the Product
	function editProduct(){		
		$data=$this->pm->editProduct();
		echo json_encode($data);
	}
	//view product and batches
	public function productview(){
	    $data['thisPage'] = 'productmanage';
	    $data['pgScript'] = 'productview';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='productmanage'>Manage Product</a>";
	    $data['title'] = 'Product Details';  
	    $this->load->datatable_template('app/seed/productview', $data);
	}
/*=-Ends Products-=*/

/* Batch Management Starts */
	//Datatable View batch
	function dtBatch(){
		$data=$this->bm->dtBatch();
		echo json_encode($data);
	}
	//Batch Entry
	public function batchentry(){
		// $previous_url = $this->session->userdata('previous_url');
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'productmanage';
		$data['pgScript'] = 'batchentry';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch Entry';  
		$data['processed_lot_no']=$this->prom->get_processed_lot_no();
		$this->load->formentry_template('app/seed/batchentry', $data);
	}

	//Add New Batch
	function addBatch(){
		$data=$this->bm->addBatch();
		echo json_encode($data);
	}

	//Batch Entry
	public function batchview(){
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'productmanage';
		$data['pgScript'] = 'batchview';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch View';  
		$this->load->datatable_template('app/seed/batchview', $data);
	}

	//Datatable View
	function dtSerial(){		
		$data=$this->bm->dtSerial();
		echo json_encode($data);
	}
	//Delete the Serial
	function delSerial(){
		$data=$this->bm->delSerial();
		echo json_encode($data);
	}
	//Delete the Batch
	function delBatch(){
		$data=$this->bm->delBatch();
		echo json_encode($data);
	}

	//Batch Entry
	public function batchedit(){
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'productmanage';
		$data['pgScript'] = 'batchedit';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch Edit';  
		$this->load->formentry_template('app/seed/batchedit', $data);
	}

	//Update the Batch
	function editBatch(){		
		$data=$this->bm->updBatch();
		echo json_encode($data);
	}
/* Batch Management Ends */

/* Container Management Starts */

	public function containermanage(){
		$data['thisPage'] = 'containermanage';
		$data['pgScript'] = 'containermanage';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Container';  
		$this->load->datatable_template('app/seed/containermanage', $data);
	}

	//Container Datatable view
    function dtContainer(){
		$data=$this->ccm->dtContainer();
		echo json_encode($data);
	}

	public function containerentry(){
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'containermanage';
		$data['pgScript'] = 'containerentry';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Add Container';  
		$data['serial'] = $this->ccm->getSerial()->result();
		$this->load->formentry_template('app/seed/containerentry', $data);
	}

	//generate ucc no
	function showucc(){
		$data = $this->ccm->showucc();
		echo $data;
	}

	//get Batch Info 
	function getBinfo(){     
		$data=$this->ccm->getBinfo();
		echo json_encode($data);
	}

	function addContainer(){
		// error_reporting(E_ALL);

		// // Display errors on the screen
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		$data=$this->ccm->addContainer();
		echo json_encode($data);
	}

	//Delete the Batch
	function delContainer(){
		$data=$this->ccm->delContainer();
		echo json_encode($data);
	}

	function containerqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/containerqrcode');
	}

	function containernqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/containernqrcode');
	}

	function batchsmallqrcodepri_sec(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/batchsmallqrcodepri_sec');
	}

	public function containeredit(){
		$data['thisPage'] = 'containermanage';
		$data['pgScript'] = 'containeredit';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='containermanage'>Container Manage</a>";
		$data['title'] = 'Manage Container';  
		$data['serial'] = $this->ccm->getSerial()->result();
		$this->load->formentry_template('app/seed/containeredit', $data);
	}

	//Update the Container
	public function editContainer(){		
		$data=$this->ccm->editContainer();
		echo json_encode($data);
	}
/* Container Management Ends */

	/*Qrcodes*/
	function serialqrcodeprint(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/serialqrcodeprint');
	}

	function serialnqrcodeprint(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/serialnqrcodeprint');
	}	

	function serialgqrcodeprint(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/serialgqrcodeprint');
	}

	//Update the Profile
	function updUserprofile(){		
		$data=$this->um->updUserprofile();
		echo json_encode($data);
	}
	//Serial Full Qrcode
	function batchfullqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/batchfullqrcode');
	}
	//Serial Small Qrcode
	function batchsmallqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/batchsmallqrcode');
	}
	//Serial XSmall Qrcode
	function batchxsmallqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/batchxsmallqrcode');
	}
	//Serial Green Qrcode
	function batchgreenqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/batchgreenqrcode');
	}

	function containersmallqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/containersmallqrcode');
	}
	
	//function to shceudle batch and containers for cron processing
	public function get_container_code(){
	    
	    if(@$_GET['bid']>0){
	        $mv = $this->db->select('MAX(order_by) as order_by')->from('seedbatch')->where('schedule_cron', '1')->get();
			foreach($mv->result() as $obrow){
				$order_by = $obrow->order_by;
			}
	        //update schedule cron status to 1
	        
	        $this->db->update("seedbatch", array("schedule_cron"=>1, "order_by"=>$order_by+1), array("id"=>$_GET['bid']));
	        
	        //update schedule cron status to 1 in container in container table
	        $this->db->update("seedcontainer", array("cron_status"=>1), array("batchno"=>$_GET['bid']));
	    
	        $this->session->set_flashdata('success_message', 'Batch scheduled for sending');
	    
	    } else {
	        
	        $this->session->set_flashdata('failure_message', 'Batch id not selected');
	    }
	    
	    $url = $_SERVER['HTTP_REFERER'];
        redirect($url);
	}
	
	function batchblueqrcode(){
		$this->load->library('Pdfbl');
		$this->load->view('app/seed/batchblueqrcode');
	}
	
	
	

/* Starts API Requests */
	// Secondary container API code
	public function get_container_code__notused(){
	   // echo "hi";exit();
		$response = '';
		$adminrole = $_SESSION['role'];
		$admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';		
		$cinfo = $this->db->select('id as cid')->from('users')->where('role',$admin)->get();
        foreach($cinfo->result() as $crow){
            $cid=$crow->cid;
        }
		if($_SESSION['role']!=$center){
			$user_id = $this->session->userdata('comid');
		}else{
			$user_id = $cid;
		}
		// echo $user_id;
		$container_code = $this->ccm->getContainer($_GET['bid']);
		$vendor_code = get_settings('vendor_code');
		//var_dump($container_code);exit();
		// echo $vendor_code;
		$access_token = $this->generate_token();
		if($container_code){
		    $api_data = array();
			foreach ($container_code as $container) {
				$serialno_data = $this->ccm->get_serno_by_container($container->ctid, $_GET['bid']);
	    	    $bid = $_GET['bid'];
				//var_dump($serialno_data);
	    		//$serialno_data = $container->serial;
	    		//$serialno = explode(",", $serialno_data);
	    		//print_r($serialno_data);exit();
				$detail_arr = array();
				foreach ($serialno_data as $sno) {
	    			// $label_detail = $this->bm->label_detail($sno->serialno);
	    			//echo $sno->serialno.'<br/>';
	    			
	    			// foreach ($label_detail as $detail) {
	    				$detail_arr[] = array(
	    				    'QRCode' => $vendor_code.$sno->palias,
	    				    'ProductCode' => $sno->productCode,
	    				    'BatchNumber' => $sno->batch_no,
	    				    'SerialNumber' =>$sno->sr_no,
	    				    'ManufactureDate' => date('d/m/Y',strtotime($sno->mfd_date)),
	    				    'ExpiryDate' => date('d/m/Y',strtotime($sno->exp_date)),
	    				    );
	    			// }
	    		}
				//var_dump($detail_arr);exit();
	    		$api_data['secondaryContainerDetail'][] = array(
					'QRCode' => $vendor_code.$container->alias,
					'SecondaryContainerCode' => $container->ucc,
					'SecondaryLabelDetail' => $detail_arr, );
				
			}
			$postDataJson = json_encode($api_data);
			//$postDataJson = '{'.$postDataJson.'}';
			var_dump($postDataJson);
			//  echo '<br><br>';
			$auth_key = 'Bearer '.$access_token;
			$curl = curl_init();
			$method = $_SERVER['REQUEST_METHOD'];	
    		if($method != 'POST'){
      			json_output(200, array('success' => false,'message' => 'Request method not accepted'));
    		}else{
				$saveSecondaryContainerDetail_url = get_settings("saveSecondaryContainerDetail_url");
			// 	$curl = curl_init();
			// 	curl_setopt_array($curl, array(
			// 	CURLOPT_URL => "$saveSecondaryContainerDetail_url",
			// 	CURLOPT_RETURNTRANSFER => true,
			// 	CURLOPT_CUSTOMREQUEST => "POST",
			// 	CURLOPT_POSTFIELDS => $postDataJson,
			// 	CURLOPT_HTTPHEADER => array(
			// 		"Authorization: $auth_key",
			// 		"content-type: application/json"
			// 	),));
			// 	$response = curl_exec($curl);
			// 	$err = curl_error($curl);
			// 	curl_close($curl);
			// 	if ($err) {
			// 		echo "cURL Error #:" . $err;
			// 		exit();
			// 	} else {
			// 		$this->ccm->update_container_api_response($container->ucc,$response);
			// 		$resp_len = strlen($response);
			// 		if($resp_len == '0'){
			// 			$this->ccm->update_container_api($container->ucc); 
			// 			$this->bm->update_batch($bid);							
			// 		}			
			// 	}
			}
			//print_r($response);exit();
			// echo $bid;
		}//container code
		$this->session->set_flashdata('success_message', 'Data Sent Successfully');
		$url = $_SERVER['HTTP_REFERER'];
        redirect($url);
	   // print_r(json_encode($api_data));exit();
	}

	public function generate_token(){
		$curl = curl_init();
		$method = $_SERVER['REQUEST_METHOD'];
    	$username = get_settings("username");
    	$password = get_settings("password");
    	$grant_type = get_settings("grant_type");
    	$token_expiry = get_settings("token_expiry");
    	$postData = 'username='.$username.'&password='.$password.'&grant_type='.$grant_type;
		$token_gen_url = get_settings("token_gen_url");
		$curl = curl_init();
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
		    print_r($access_token);
		    return  $access_token; 
    	}
	}//generate_token ends
/* Ends API Requests */

//sourcing category

public function categorymanage(){

    $data['thisPage'] = 'categorymanage';
    $data['pgScript'] = 'categorymanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Category';  
    $this->load->datatable_template('app/seed/categorymanage', $data);
}

function dtCategory(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->scm->getRows($_POST);   
     
    $i = $_POST['start']+1;
   
    foreach($memData as $row){    
        

        $actionButton = '
        <ul class="list-inline">  
       <li class="list-inline-item">
        <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#" data-toggle="modal" data-target="#subCategoryModal">
            <span class="fa fa-eye"></span>
        </a>
    </li>     
		<li class="list-inline-item"><a class="btn text-info btn-xs edit-category" role="button" href="categoryedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
   		<li class="list-inline-item"><a class="btn text-red btn-xs" role="button" id="delete_category" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Category"> <span class="fa fa-trash"></span></a></li>

        </ul>';


        $data[] = array(
            $i++, 
			$row->category_type,
            $row->name,
            $row->code,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->scm->countAll(),
        "recordsFiltered" => $this->scm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function categoryentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'categorymanage';
    $data['pgScript'] = 'categoryentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Category";
    $data['title'] = 'Category Entry';  
	$data['categories']=$this->scm->get_categories();
    $this->load->formentry_template('app/seed/categoryentry', $data);
}

public function addCategory()
{
	
    $data=$this->scm->insertCategory();
    echo json_encode($data);
  
}

public function categoryedit(){
		
	$data['thisPage'] = 'categorymanage';
	$data['pgScript'] = 'categoryedit';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Category";
	$data['title'] = 'Sourcing Category Edit';  
	$data['categories']=$this->scm->get_categories();
	$this->load->formentry_template('app/seed/categoryedit', $data);
}

public function editCategory()
{
	$data=$this->scm->updateCategory();
	echo json_encode($data);
	  
}

public function deleteCategory()
{
    $categoryId = $this->input->post('id');

    if ($categoryId) {
        $this->db->where('id', $categoryId);
        $delete = $this->db->delete('sourcing_category');

        if ($delete) {
            $output = ['success' => true, 'message' => 'Vendor deleted successfully'];
        } else {
            $output = ['success' => false, 'message' => 'Error deleting vendor'];
        }
    } else {
        $output = ['success' => false, 'message' => 'Invalid vendor ID'];
    }

    echo json_encode($output);
}

public function getCategoryDetails()
{
    $categoryId = $this->input->post('id');

    if ($categoryId) {
        $category = $this->db->get_where('sourcing_category', ['id' => $categoryId,'c_id'=>$_SESSION['comid']])->row();

        if ($category) {
            $output = [
                'success' => true,
                'data' => $category
            ];
        } else {
            $output = ['success' => false, 'message' => 'Category not found'];
        }
    } else {
        $output = ['success' => false, 'message' => 'Invalid Category ID'];
    }

    echo json_encode($output);
}


public function subcategoryedit(){
		
	$data['thisPage'] = 'categorymanage';
	$data['pgScript'] = 'categoryedit';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Category";
	$data['title'] = 'Sourcing Category Edit';  
	$data['categories']=$this->scm->get_categories();
	$this->load->formentry_template('app/seed/categoryedit', $data);
}

public function editSubCategory()
{
	$data=$this->scm->updateSubCategory();
	echo json_encode($data);
	  
}

public function getSubCategoryDetails()
{
    $subcategoryId = $this->input->post('id');

    if ($subcategoryId) {
		$subcategory = $this->db->select('c.name, sc.*')
					->from('sourcing_sub_category sc')
					->join('sourcing_category c', 'c.id = sc.category_id')
					->where(['sc.id' => $subcategoryId,'sc.c_id'=>$_SESSION['comid']])
					->get()
					->row_array();
        if ($subcategory) {
            $output = [
                'success' => true,
                'data' => $subcategory
            ];
        } else {
            $output = ['success' => false, 'message' => 'Category not found'];
        }
    } else {
        $output = ['success' => false, 'message' => 'Invalid Category ID'];
    }

    echo json_encode($output);
}

public function getSubcategories()
{
    $category_id = $this->input->post('category_id');
    
    $this->db->where(['category_id'=>$category_id,'c_id'=>$_SESSION['comid']]);
    $query = $this->db->get('sourcing_sub_category');

    if ($query->num_rows() > 0) {
        echo json_encode($query->result());
    } else {
        echo json_encode([]);
    }
}

public function deleteSubcategory()
{
    $id = $this->input->post('id');

    $this->db->where('id', $id);
    if ($this->db->delete('sourcing_sub_category')) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}

//vendor

public function vendormanage(){
	$data['thisPage'] = 'vendormanage';
	$data['pgScript'] = 'vendormanage';
	$data['thisPageLevel'] = '1';   
	$data['thisPageMain']="";
	$data['title'] = 'Manage Vendors';  
	$this->load->datatable_template('app/seed/vendormanage', $data);
}

function dtVendor(){

    $data = $row = array();        
    // Fetch member's records
    $memData = $this->vm->getRows($_POST);   
     
    $i = $_POST['start']+1;
    $adminrole = $_SESSION['role'];

    foreach($memData as $row){    
        
            $actionButton = '
        <ul class="list-inline">  
         <li class="list-inline-item">
                <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
                    <span class="fa fa-eye"></span>
                </a>
        </li>  
		<li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="vendoredit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
		<li class="list-inline-item"><a class="btn text-red btn-xs" role="button" id="delete_vendor" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Vendor"> <span class="fa fa-trash"></span></a></li>

        </ul>';

        $data[] = array(
            $i++, 
            $row->vendor_name, 
			$row->gst_no,
            $row->contact_no,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->vm->countAll(),
        "recordsFiltered" => $this->vm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}


public function vendorentry(){
	// $previous_url = $this->session->userdata('previous_url');
	$url= $_SERVER['HTTP_REFERER'];
	$data['thisPage'] = 'vendormanage';
	$data['pgScript'] = 'vendorentry';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Vendor";
	$data['title'] = 'Sourcing Vendor Entry';  
	$this->load->formentry_template('app/seed/vendorentry', $data);
}



public function addVendor()
    {
		$data=$this->vm->insertVendor();
        echo json_encode($data);
        
    }

	public function vendoredit(){
		
		$data['thisPage'] = 'vendormanage';
		$data['pgScript'] = 'vendoredit';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="Vendor";
		$data['title'] = 'Sourcing Vendor Edit';  
		$this->load->formentry_template('app/seed/vendoredit', $data);
	}

	public function editVendor()
    {
		$data=$this->vm->updateVendor();
        echo json_encode($data);
          
    }


	public function getVendorInfo()
{
    $vendor_id = $this->input->post('vendor_id');

    if (!empty($vendor_id)) {
        $vendor = $this->vm->getVendorById($vendor_id);

        if (!empty($vendor)) {
            echo json_encode($vendor);
        } else {
            echo json_encode(['error' => 'Vendor not found']);
        }
    } else {
        echo json_encode(['error' => 'Invalid vendor ID']);
    }
}
public function deleteVendor()
{
    $vendorId = $this->input->post('id');

    if ($vendorId) {
        $this->db->where('id', $vendorId);
        $delete = $this->db->delete('vendors');

        if ($delete) {
            $output = ['success' => true, 'message' => 'Vendor deleted successfully'];
        } else {
            $output = ['success' => false, 'message' => 'Error deleting vendor'];
        }
    } else {
        $output = ['success' => false, 'message' => 'Invalid vendor ID'];
    }

    echo json_encode($output);
}

public function getVendorDetails()
{
    $vendorId = $this->input->post('id');

    if ($vendorId) {
        $vendor = $this->db->get_where('vendors', ['id' => $vendorId,'c_id'=>$_SESSION['comid']])->row();

        if ($vendor) {
            $output = [
                'success' => true,
                'data' => $vendor
            ];
        } else {
            $output = ['success' => false, 'message' => 'Vendor not found'];
        }
    } else {
        $output = ['success' => false, 'message' => 'Invalid vendor ID'];
    }

    echo json_encode($output);
}


public function rawmaterialmanage(){
	$data['thisPage'] = 'rawmaterialmanage';
	$data['pgScript'] = 'rawmaterialmanage';
	$data['thisPageLevel'] = '1';   
	$data['thisPageMain']="";
	$data['title'] = 'Manage Raw Materials';  
	$this->load->datatable_template('app/seed/rawmaterialmanage', $data);
}

function dtRawMaterial(){

    $data = $row = array();        
    // Fetch member's records
    $memData = $this->rm->getRows($_POST);   
     
    $i = $_POST['start']+1;
    $adminrole = $_SESSION['role'];

    foreach($memData as $row){    
        
            $actionButton = '
        <ul class="list-inline">  
       
		<li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="rawmaterialedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
		<li class="list-inline-item"><a class="btn text-red btn-xs" role="button" id="delete_rawmaterial" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Raw Material"> <span class="fa fa-trash"></span></a></li>

        </ul>';

        $data[] = array(
            $i++, 
            $row->category, 
			$row->raw_material_name,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->rm->countAll(),
        "recordsFiltered" => $this->rm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}


public function rawmaterialentry(){
	// $previous_url = $this->session->userdata('previous_url');
	$url= $_SERVER['HTTP_REFERER'];
	$data['thisPage'] = 'rawmaterialmanage';
	$data['pgScript'] = 'rawmaterialentry';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Raw Materials";
	$data['title'] = 'Raw Materials Entry';  
	$data['categories']=$this->rm->get_categories();
	$this->load->formentry_template('app/seed/rawmaterialentry', $data);
}

public function addRawMaterials()
{
	$cid = $this->input->post('cid');
	$appid = 'SD';
  
	    $category = $this->input->post('category');
        $raw_materials = $this->input->post('raw_materials'); // Array of raw materials

        if (empty($raw_materials)) {
            echo json_encode(['success' => false, 'messages' => 'Please add at least one raw material.']);
            return;
        }

        $data = [];
        foreach ($raw_materials as $material) {
            if (!empty($material)) {
                $data[] = [
					'c_id'          =>$cid,
					'applicationid' => $appid,
					'category_id'=>$category,
					'raw_material_name' => trim($material)];
            }
        }

        if (empty($data)) {
            echo json_encode(['success' => false, 'messages' => 'All raw material fields are empty.']);
            return;
        }

        // Insert data using the model
        if ($this->rm->insertRawMaterials($data)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'messages' => 'Failed to add raw materials. Please try again.']);
        }
   
}


public function rawmaterialedit(){
		
	$data['thisPage'] = 'rawmaterialmanage';
	$data['pgScript'] = 'rawmaterialedit';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Raw Material";
	$data['title'] = 'Raw Material Edit';  
	$data['categories']=$this->rm->get_categories();
	$this->load->formentry_template('app/seed/rawmaterialedit', $data);
}

public function editRawMaterial()
{
	$data=$this->rm->updateRawMaterial();
	echo json_encode($data);
	  
}


public function getRawMaterialInfo()
{
$r_id = $this->input->post('r_id');

if (!empty($r_id)) {
	$raw_material = $this->rm->getRawMaterialById($r_id);

	if (!empty($raw_material)) {
		echo json_encode($raw_material);
	} else {
		echo json_encode(['error' => 'Raw material not found']);
	}
} else {
	echo json_encode(['error' => 'Invalid Raw material ID']);
}
}
public function deleteRawMaterial()
{
	$r_id = $this->input->post('id');

if ($r_id) {
	$this->db->where('id', $r_id);
	$delete = $this->db->delete('raw_materials');

	if ($delete) {
		$output = ['success' => true, 'message' => 'Raw Material deleted successfully'];
	} else {
		$output = ['success' => false, 'message' => 'Error deleting Material'];
	}
} else {
	$output = ['success' => false, 'message' => 'Invalid Raw material ID'];
}

echo json_encode($output);
}


public function sourcingmanage(){
	$data['thisPage'] = 'sourcingmanage';
	$data['pgScript'] = 'sourcingmanage';
	$data['thisPageLevel'] = '1';   
	$data['thisPageMain']="";
	$data['title'] = 'Manage Sourcing';  
	$this->load->datatable_template('app/seed/sourcingmanage', $data);
}
//Product Datatable view
function dtSourcing(){

// 	error_reporting(E_ALL);

// // Display errors on the screen
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
	$data = $row = array();        
	// Fetch member's records
	$memData = $this->sm->getRows($_POST);   
	// print_r($memData);
	// exit;     
	$i = $_POST['start']+1;
	$adminrole = $_SESSION['role'];


	$pname='';
	$pcat='';
	foreach($memData as $row){           

			$actionButton = '
		<ul class="list-inline">  
		 <li class="list-inline-item">
				<a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
					<span class="fa fa-eye"></span>
				</a>
			</li>
			<li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="sourcingedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
		<li class="list-inline-item"><a class="btn text-red btn-xs" role="button" id="delete_sourcing" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Raw Material"> <span class="fa fa-trash"></span></a></li>
		';
			if(!empty($row->grn_file)){
$actionButton .= '<li class="list-inline-item">
					<a href="' . base_url('uploads/grn_files/' . $row->grn_file) . '" target="_blank" class="btn text-danger btn-xs" role="button" title="View GRN PDF"> 
					<span class="fa fa-file-pdf"></span>
				</a>
			</li>';	
			}else{
				$actionButton .= '<li class="list-inline-item">
				<a href="#" class="btn text-danger btn-xs disabled-link" role="button" title="No GRN PDF Available"> 
                <span class="fa fa-file-pdf"></span>
            </a>
		</li>';	
			}
					
		// 	$actionButton .='<li class="list-inline-item">
		// 		<a href="processingentry?lot_reference_no='.$row->lot_reference_no.'" 
		// 		class="btn btn-outline-success btn-xs">
		// 			<span class="fa-solid fa-truck"></span> Send API
		// 		</a>
		// 	</li>
		// </ul>';
		$pname = ($row->p_name != '') ? strtoupper($row->p_name) : $row->p_name;
		$vendor_name = ($row->vendor_name != '') ? ucwords($row->vendor_name) : $row->vendor_name;
		$raw_material_name = ($row->raw_material_name != '') ? ucwords($row->raw_material_name) : $row->raw_material_name;
		$date_of_sourcing = ($row->date_of_sourcing != '') ? date('d-m-Y',strtotime($row->date_of_sourcing)) : $row->date_of_sourcing;

		$data[] = array(
			$i++, 
			$row->lot_reference_no, 
			$pname,      
			$vendor_name,
			$raw_material_name,
			$date_of_sourcing,
			$actionButton
		);
	}
	
	$output = array(
		"draw" => $_POST['draw'],
		"recordsTotal" => $this->sm->countAll(),
		"recordsFiltered" => $this->sm->countFiltered($_POST),
		"data" => $data,
	);
	
	// Output to JSON format
	echo json_encode($output);
}

public function sourcingentry(){
	// $previous_url = $this->session->userdata('previous_url');
	$url= $_SERVER['HTTP_REFERER'];
	$data['thisPage'] = 'sourcingentry';
	$data['pgScript'] = 'sourcingentry';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Sourcing";
	$data['title'] = 'Sourcing Entry';  
	$data['products']=$this->tpm->get_products();
	$data['units']=$this->pm->get_unit_of_measurements();
	$data['vendors']=$this->vm->get_vendors();
	$data['materials']=$this->rm->get_raw_materials();
	$this->load->formentry_template('app/seed/sourcingentry', $data);
}

public function addSourcing()
{
	$cid = $this->input->post('cid');
	$appid = 'SD';
    $vendor_ids = $this->input->post('vendor_id');
    $raw_material_ids = $this->input->post('raw_material_id');
    $quantities = $this->input->post('qty');
    $uom_ids = $this->input->post('uom');
    $dates_of_sourcing = $this->input->post('date_of_sourcing');
    $product_id = $this->input->post('product_id');
    $lot_reference_no = $this->input->post('lot_reference_no');

	if(empty($product_id) || empty($lot_reference_no) ){
		$response = ['success' => false, 'messages' => 'Please fill all the required(*) fields.'];
		echo json_encode($response);
		return;
	}

    $data = [];
    
    $image=null;
        if(isset($_FILES["file"]["type"]) && !empty($_FILES["file"]["tmp_name"])) {
            $image = $this->uploadFile('file', 'uploads/grn_files/');
            if(!$image) {
                $output['success'] = false;
                $output['messages'] = 'Failed to upload image file';
                return $output;
            }
        }

    // Validate and prepare data for insertion
    for ($i = 0; $i < count($vendor_ids); $i++) {
        if (
            !empty($vendor_ids[$i]) &&
            !empty($raw_material_ids[$i]) &&
            !empty($quantities[$i]) &&
            !empty($uom_ids[$i]) &&
            !empty($dates_of_sourcing[$i])
        ) {
            $data[] = [
				'c_id'          =>$cid,
				'applicationid' => $appid,
                'product_id' => $product_id,
                'lot_reference_no' => $lot_reference_no,
                'vendor_id' => $vendor_ids[$i],
                'raw_material_id' => $raw_material_ids[$i],
                'qty' => $quantities[$i],
                'uom_id' => $uom_ids[$i],
                'date_of_sourcing' => $dates_of_sourcing[$i],
                'grn_file'=>$image
            ];
        }else{
			$response = ['success' => false, 'messages' => 'Please fill all the required(*) fields.'];
			echo json_encode($response);
			return;
		}
    }

    // Check if data is prepared and insert into the database
    if (!empty($data)) {
        if ($this->sm->insertSourcing($data)) {
            $response = ['success' => true, 'messages' => 'Sourcing data saved successfully.'];
        } else {
            $response = ['success' => false, 'messages' => 'Database error occurred.'];
        }
    } else {
        $response = ['success' => false, 'messages' => 'No valid data provided.'];
    }

    echo json_encode($response);
}


function uploadFile($fileInputName, $targetDirectory) {
	$targetPath = $targetDirectory . basename($_FILES[$fileInputName]["name"]);
	$fileExtension = strtolower(pathinfo($targetPath,PATHINFO_EXTENSION));
	$newFileName = uniqid() . '_' . time() . '.' . $fileExtension;

	$targetPath = $targetDirectory . $newFileName;

	if(move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetPath)) {
		return $newFileName;
	} else {
		return false;
	}
}

public function getSourcingDetails() {
	
	$details = $this->sm->getSourcingDetails();
	echo json_encode($details);
	
}

public function generateLotReference()
{
    $company_id = $_SESSION['comid']; // Fetch session company ID

    // Get the maximum lot_reference_no for the given c_id
    $this->db->select_max('lot_reference_no');
    $this->db->where('c_id', $company_id);
    $query = $this->db->get('sourcing');

    $result = $query->row();
    $max_lot_no = $result->lot_reference_no;

    // Generate new lot_reference_no
    if ($max_lot_no) {
        $new_lot_no = str_pad($max_lot_no + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $new_lot_no = '000001'; // First entry
    }

    $output = [
        'success' => true,
        'lot_reference_no' => $new_lot_no
    ];

    echo json_encode($output);
}

public function getSourcingInfo(){

	$id = $this->input->post('id');

	if (!empty($id)) {
		$sourcing = $this->sm->getSourcingById($id);

		if (!empty($sourcing)) {
			echo json_encode($sourcing);
		} else {
			echo json_encode(['error' => 'Sourcing not found']);
		}
	} else {
		echo json_encode(['error' => 'Invalid Sourcing ID']);
	}

}


public function sourcingedit(){
		
	$data['thisPage'] = 'sourcingmanage';
	$data['pgScript'] = 'sourcingedit';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Sourcing";
	$data['title'] = 'Sourcing Edit';  
	$data['products']=$this->pm->get_products();
	$data['units']=$this->pm->get_unit_of_measurements();
	$data['vendors']=$this->vm->get_vendors();
	$data['materials']=$this->rm->get_raw_materials();
	$this->load->formentry_template('app/seed/sourcingedit', $data);
}

public function editSourcing()
{
	
	$data=$this->sm->updateSourcing();
	echo json_encode($data);
	  
}

public function deleteSourcing()
{
	$data=$this->sm->deleteSourcing();
    echo json_encode($data);
}



public function processingmanage(){
	$data['thisPage'] = 'processingmanage';
	$data['pgScript'] = 'processingmanage';
	$data['thisPageLevel'] = '1';   
	$data['thisPageMain']="";
	$data['title'] = 'Manage Processing';  
	$this->load->datatable_template('app/seed/processingmanage', $data);
}
//Product Datatable view
function dtProcessing(){
// 	error_reporting(E_ALL);

// // // Display errors on the screen
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->prom->getRows($_POST);   

    $i = $_POST['start'] + 1;
    $adminrole = $_SESSION['role'];
    

	foreach($memData as $row){           

		$actionButton = '
        <ul class="list-inline">  
           <li class="list-inline-item">
				<a class="btn text-info btn-xs open-modal" data-processed-lot-no="' . $row->processed_lot_no . '" role="button" href="#">
					<span class="fa fa-eye"></span>
				</a>
			</li>
           <li class="list-inline-item">
				<a class="btn text-primary btn-xs" role="button" href="addmoresourcing?p_lot='.$row->processed_lot_no.'" title="Add more sourcing data">
					<span class="fa fa-plus"></span>
				</a>
			</li>
			<li class="list-inline-item">
				<a class="btn text-danger btn-xs" id="delete_processing" data-id="'.$row->processed_lot_no.'" role="button" href="#" title="Delete">
					<span class="fa fa-trash"></span>
				</a>
			</li>
        </ul>';
	// 	<li class="list-inline-item">
	// 	<a href="batchentry?id=' . $row->product_id . '&upc=' . $row->p_code.'&processed_lot_no=' . $row->processed_lot_no . '" 
	// 	class="btn btn-outline-success btn-xs">
	// 		<span class="fa-solid fa-layer-group"></span> Send API
	// 	</a>
	// </li>
		$vendor_name = ($row->vendor_name != '') ? ucwords($row->vendor_name) : $row->vendor_name;
		$raw_material_name = ($row->raw_material_name != '') ? ucwords($row->raw_material_name) : $row->raw_material_name;

		$data[] = array(
			$i++, 
            $row->sourcing_lot_id, 
             $row->processed_lot_no, 
            $vendor_name,  
			$raw_material_name, 
            $actionButton
		);
	}
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->prom->countAll(),
        "recordsFiltered" => $this->prom->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}
public function processingentry(){
	// $previous_url = $this->session->userdata('previous_url');
	$url= $_SERVER['HTTP_REFERER'];
	$data['thisPage'] = 'processingmanage';
	$data['pgScript'] = 'processingentry';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Processing";
	$data['title'] = 'Processing Entry'; 
	$data['reference_no']=$this->sm->get_sourcing_lot_no(); 
	$data['units']=$this->pm->get_unit_of_measurements();
	$this->load->formentry_template('app/seed/processingentry', $data);
}

public function getVendorsAndMaterials()
{
    $lot_reference_no = $this->input->post('lot_reference_no');
    if (!$lot_reference_no) {
        echo json_encode(['success' => false, 'message' => 'Lot reference number is required.']);
        return;
    }

    $data = $this->vm->getVendorsAndMaterials($lot_reference_no);

    if (!empty($data)) {
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found for the given lot.']);
    }
}

public function getProcessingDetails() {

    $processed_lot_no = $this->input->post('processed_lot_no');

    if ($processed_lot_no) {
        // Fetch data from the database
        $details = $this->prom->getProcessingDetailsByLot($processed_lot_no);

        // Return JSON response
        echo json_encode($details);
    } else {
        echo json_encode([]);
    }
}


// public function addProcessing() {


// 	$sourcing_lot_id = $this->input->post('sourcing_lot_id');
// 	$processed_lot_no = $this->input->post('processed_lot_no');
// 	$vendor_id = $this->input->post('vendor_id');
// 	$raw_material_id = $this->input->post('raw_material_id');
	
// 	// Retrieve processing details (dynamic fields)
// 	$process_names = $this->input->post('process_name');
// 	$process_types = $this->input->post('process_type');
// 	$process_qty = $this->input->post('process_qty');
// 	$final_qty = $this->input->post('final_qty');
// 	$wastage = $this->input->post('wastage');
// 	$uom = $this->input->post('uom');
	
// 	// Loop through each processing detail and insert it
// 	for ($i = 0; $i < count($process_names); $i++) {
// 		// Prepare data for each row to insert
// 		$processing_data = [
// 			'sourcing_lot_id' => $sourcing_lot_id,
// 			'processed_lot_no' => $processed_lot_no,
// 			'vendor_id' => $vendor_id,
// 			'raw_material_id' => $raw_material_id,
// 			'process_name' => $process_names[$i],
// 			'process_type' => $process_types[$i],
// 			'process_qty' => $process_qty[$i],
// 			'final_qty' => $final_qty[$i],
// 			'wastage' => $wastage[$i],
// 			'uom' => $uom[$i]
// 		];

// 		// Insert each processing detail into the processing table
// 		$result = $this->prom->insertProcessData($processing_data);
// 	}

// 	if ($result) {
// 		$response = ['success' => true, 'message' => 'Processing data saved successfully.'];
// 	} else {
// 		$response = ['success' => false, 'message' => 'Database error occurred.'];
// 	}
// echo json_encode($response);
// }


public function addProcessing()
{
    $processed_lot_no = $this->input->post('processed_lot_no');
    $cid = $this->input->post('cid');
	$appid = 'SD';
    $sourcing_lots = $this->input->post('sourcing_lot_id');

	if (empty($processed_lot_no)) {
        echo json_encode(['success' => false, 'messages' => 'Please select process lot no']);
        return;
    }

    $process_data = [];
    $error_lots = [];

	
    if (!empty($sourcing_lots)) {
		
        foreach ($sourcing_lots as $sourcing_index => $lot_id) {
            $vendor_id = $_POST['vendor_id'][$sourcing_index];
            $raw_material_id = $_POST['raw_material_id'][$sourcing_index];

            if (!empty($_POST['process_name'][$sourcing_index]) && !empty($_POST['process_qty'][$sourcing_index]) && !empty($_POST['final_qty'][$sourcing_index]) && !empty($_POST['wastage'][$sourcing_index]) && !empty($_POST['uom'][$sourcing_index])) {
                foreach ($_POST['process_name'][$sourcing_index] as $process_index => $process_name) {
                    $process_data[] = [
                        'processed_lot_no' => $processed_lot_no,
                        'sourcing_lot_id' => $lot_id,
                        'vendor_id' => $vendor_id,
                        'raw_material_id' => $raw_material_id,
                        'process_name' => $process_name,
                        'process_type' => $_POST['process_type'][$sourcing_index][$process_index],
                        'process_qty' => $_POST['process_qty'][$sourcing_index][$process_index],
                        'final_qty' => $_POST['final_qty'][$sourcing_index][$process_index],
                        'wastage' => $_POST['wastage'][$sourcing_index][$process_index],
                        'uom' => $_POST['uom'][$sourcing_index][$process_index],
                        'c_id' => $cid,
						'applicationid'=>$appid
                    ];
                }
            }else {
				// If sourcing lot ID is present but no process data, add to error_lots
				$error_lots[] = $lot_id;
			}
        }

		if (!empty($error_lots)) {
			echo json_encode([
				'success' => false,
				'messages' => 'Processing data missing for sourcing lot IDs: ' . implode(', ', $error_lots)
			]);
			return;
		}


        if (!empty($process_data)) {
            $this->db->insert_batch('processing', $process_data);
            echo json_encode(['success' => true, 'messages' => 'Processing data saved successfully!']);
        } else {
            echo json_encode(['success' => false, 'messages' => 'No processing data found!']);
        }
    } else {
        echo json_encode(['success' => false, 'messages' => 'No sourcing lots found!']);
    }
}


public function generate_unique_processed_lot_no() {

	$company_id = $_SESSION['comid']; 

    $this->db->select_max('processed_lot_no');
    $this->db->where('c_id', $company_id);
    $query = $this->db->get('processing');

    $result = $query->row();
    $max_lot_no = $result->processed_lot_no;

    // Generate new lot_reference_no
    if ($max_lot_no) {
        $new_lot_no = str_pad($max_lot_no + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $new_lot_no = '000001'; // First entry
    }

    $output = [
        'success' => true,
        'processed_lot_no' => $new_lot_no
    ];

    echo json_encode($output);
}


public function processingedit(){
		
	$data['thisPage'] = 'processingmanage';
	$data['pgScript'] = 'processingedit';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="Processing";
	$data['title'] = 'Processing Edit';  
	$data['reference_no']=$this->sm->get_sourcing_lot_no(); 
	$data['units']=$this->pm->get_unit_of_measurements();
	$this->load->formentry_template('app/seed/processingedit', $data);
}

public function editProcessing()
{
	
	$data=$this->prom->updateProcessing();
	echo json_encode($data);
	  
}

//for source lot processing details
public function deleteProcessData()
{
	$processingId = $this->input->post('id');

    if ($processingId) {
        $this->db->where('id', $processingId);
        $delete = $this->db->delete('processing');

        if ($delete) {
            $output = ['success' => true, 'message' => 'Process Data deleted successfully'];
        } else {
            $output = ['success' => false, 'message' => 'Error deleting Process'];
        }
    } else {
        $output = ['success' => false, 'message' => 'Invalid Process ID'];
    }

    echo json_encode($output);
}

//for processed lot no
public function deleteProcessing()
{
	$processed_lot = $this->input->post('processed_lot');

    if ($processed_lot) {
        $this->db->where('processed_lot_no', $processed_lot);
        $delete = $this->db->delete('processing');

        if ($delete) {
            $output = ['success' => true, 'message' => 'Processing deleted successfully'];
        } else {
            $output = ['success' => false, 'message' => 'Error deleting Process'];
        }
    } else {
        $output = ['success' => false, 'message' => 'Invalid Process ID'];
    }

    echo json_encode($output);
}

public function getProcessingDataById(){

	
	$id = $this->input->post('id');

	if (!empty($id)) {
		$processing = $this->prom->getProcessingById($id);

		if (!empty($processing)) {
			echo json_encode($processing);
		} else {
			echo json_encode(['error' => 'Processing not found']);
		}
	} else {
		echo json_encode(['error' => 'Invalid Processing ID']);
	}

}


//trace product manage

public function tproductmanage(){
	$data['thisPage'] = 'tproductmanage';
	$data['pgScript'] = 'tproductmanage';
	$data['thisPageLevel'] = '1';   
	$data['thisPageMain']="";
	$data['title'] = 'Manage Products';  
	$this->load->datatable_template('app/seed/tproductmanage', $data);
}
//Product Datatable view
function tdtProduct(){
	
	$data = $row = array();        
	// Fetch member's records
	$memData = $this->tpm->getRows($_POST);        
	$i = $_POST['start']+1;
	$adminrole = $_SESSION['role'];
	$admin=substr($adminrole, 0, -6).'admin';
	$center=substr($adminrole, 0, -6).'center';
	$apistatus='';
	$dis='';
	$hid='';
	$pinfo='';
	$pname='';
	$pcat='';
	foreach($memData as $row){           
		// if($row->api_sent!='0'){
		// 	$dis = "disabled";
		// 	$apistatus = '<li class="list-inline-item"><a class="btn text-success btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> API Sent Successfully</a></li>';                
		// }else{
		// 	$dis = "";
		// 	$apistatus = '<li class="list-inline-item"><button class="btn btn-outline-danger btn-xs sendApiDataBtn" data-id="'.$row->id.'" '.$dis.'><span class="fa-solid fa-cloud-arrow-up"></span> Send API Data</button></li>';
		// }
		if($_SESSION['role']===$center){
			$hid = "hidden";
		}else{
			$hid="";
		}
		if($row->onlyprimary==='1'){
			$pinfo = '<span class="right badge badge-success">Primary</span>';
		}else{
			$pinfo = '<span class="right badge badge-warning">Secondary</span>';
		}
		$binfo = $this->db->select('*')->from('seedbatch')->where(array('pid'=> $row->id, 'c_id'=>$_SESSION['comid'], 'status'=>'1'))->get();
		$bcount = $binfo->num_rows();
		if($bcount !=0){
			$bc = '<span class="right badge badge-success">'.$bcount.'</span>';
		}else{
			$bc = '<span class="right badge badge-warning">'.$bcount.'</span>';
		}
		$actionButton = '
		<ul class="list-inline">  
			<li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="tproductview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>
			<li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.' hidden" role="button" href="miproductedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
			<li class="list-inline-item d-print-none "><a class="btn text-red btn-xs '.$dis.' '.$hid.'" role="button" id="delete_product" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Member"> <span class="fa fa-trash"></span></a></li>
			'.$apistatus.'
		</ul>';
		$pname = ($row->p_name != '') ? strtoupper($row->p_name) : $row->p_name;
		$pcat = ($row->p_category != '') ? ucwords($row->p_category) : $row->p_category;
		$data[] = array(
			$i++, 
			'<strong>'.$pname.'</strong><sup> '.$pinfo.' '.$bc.'</sup>', 
			$row->p_code,       
			$pcat,
			$actionButton
		);
	}
	
	$output = array(
		"draw" => $_POST['draw'],
		"recordsTotal" => $this->tpm->countAll(),
		"recordsFiltered" => $this->tpm->countFiltered($_POST),
		"data" => $data,
	);
	
	// Output to JSON format
	echo json_encode($output);
}
//UPC No Generation
function tshowupc(){
	$data = $this->tpm->showupc();
	echo $data;
}

public function tproductentry(){
	$data['thisPage'] = 'tproductmanage';
	$data['pgScript'] = 'tproductentry';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="<a href='tproductmanage'>Manage Product</a>";
	$data['title'] = 'Product Entry';  
	$data['seedc'] = $this->pm->getSeedclass()->result();
	$data['itemCat'] = $this->tpm->getSourcingCategory()->result();
	$data['units'] = $this->tpm->get_unit_of_measurements();
	$this->load->formentry_template('app/seed/tproductentry', $data);
}
//Get SubCategory
function getSourcingSubCategory(){
	$catid = $this->input->post('id',TRUE);
	$data = $this->tpm->getSourcingSubCat($catid)->result();
	echo json_encode($data);
}



function taddProduct(){
	$data=$this->tpm->addProduct();
	echo json_encode($data);
}

//Delete the product
function tdelProduct(){
	$data=$this->tpm->delProduct();
	echo json_encode($data);
}
//Get Product Info
function tgetPrdinfo(){			
	$data=$this->tpm->getPrdinfo();
	echo json_encode($data);
}
//Edit the product
public function tproductedit(){
	$data['thisPage'] = 'tproductmanage';
	$data['pgScript'] = 'tproductedit';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="<a href='productmanage'>Manage Product</a>";
	$data['title'] = 'Product Edit';  
	$data['itemCat'] = $this->tpm->getSourcingCategory()->result();
	$data['uomid'] = $this->tpm->get_unit_of_measurements();
	$this->load->formentry_template('app/seed/tproductedit', $data);
}	
//Update the Product
function teditProduct(){		
	// error_reporting(E_ALL);

	// 	// Display errors on the screen
	// 	ini_set('display_errors', 1);
	// 	ini_set('display_startup_errors', 1);
	$data=$this->tpm->editProduct();
	echo json_encode($data);
}
public function tproductview(){
	$data['thisPage'] = 'tproductmanage';
	$data['pgScript'] = 'tproductview';
	$data['thisPageLevel'] = '2';   
	$data['thisPageMain']="<a href='tproductmanage'>Manage Product</a>";
	$data['title'] = 'Product Details';  
	$this->load->datatable_template('app/seed/tproductview', $data);
}
//View private Product Manage Page
// 	public function psdproductmanage(){
// 	    $data['thisPage'] = 'psdproductmanage';
// 	    $data['pgScript'] = 'psdproductmanage';
// 	    $data['thisPageLevel'] = '1';   
// 	    $data['thisPageMain']="";
// 	    $data['title'] = 'Manage Products(Private Sale)';  
// 	    $this->load->datatable_template('app/seed/psdproductmanage', $data);
// 	}

//     //private Product Datatable view
// 	function dtPProduct(){
//         $data = $row = array();        
//         // Fetch member's records
//         $memData = $this->ppm->getRows($_POST);        
//         $i = $_POST['start']+1;
//         $adminrole = $_SESSION['role'];
//         $admin=substr($adminrole, 0, -6).'admin';
//         $center=substr($adminrole, 0, -6).'center';
//         $apistatus='';
//         $dis='';
//         $hid='';
//         $pinfo='';
//         foreach($memData as $row){       
//             if($_SESSION['role']===$center){
//                 $hid = "hidden";
//             }else{
//                 $hid="";
//             }
//             if($row->onlyprimary==='1'){
//                 $pinfo = '<span class="right badge badge-success">Primary</span>';
//             }else{
//                 $pinfo = '<span class="right badge badge-warning">Secondary</span>';
//             }
//             $binfo = $this->db->select('*')->from('publicbatch')->where(array('pid'=> $row->id, 'c_id'=>$_SESSION['comid']))->get();
//             $bcount = $binfo->num_rows();
//             if($bcount !=0){
//                 $bc = '<span class="right badge badge-success">'.$bcount.'</span>';
//             }else{
//                 $bc = '<span class="right badge badge-warning">'.$bcount.'</span>';
//             }
//             $actionButton = '
//             <ul class="list-inline">  
//                 <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="psdproductview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>
//                 <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.' hidden" role="button" href="psdproductedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>                
//             </ul>';
//             $data[] = array(
//                 $i++, 
//                 '<strong>'.ucwords($row->p_name).'</strong><sup> '.$pinfo.' '.$bc.'</sup>', 
//                 $row->p_code,       
//                 ucwords($row->itemcategory),
//                 $actionButton
//             );
//         }
        
//         $output = array(
//             "draw" => $_POST['draw'],
//             "recordsTotal" => $this->ppm->countAll(),
//             "recordsFiltered" => $this->ppm->countFiltered($_POST),
//             "data" => $data,
//         );
        
//         // Output to JSON format
//         echo json_encode($output);
//     }

//     //Private Product Entry Page
// 	public function psdproductentry(){
// 	    $data['thisPage'] = 'psdproductmanage';
// 	    $data['pgScript'] = 'psdproductentry';
// 	    $data['thisPageLevel'] = '2';   
// 	    $data['thisPageMain']="<a href='psdproductmanage'>Manage Product</a>";
// 	    $data['title'] = 'Product Entry'; 
// 	    $data['uomid'] = $this->pm->getUomid()->result();
// 	    $this->load->formentry_template('app/seed/psdproductentry', $data);
// 	}
	
// 	function pshowupc(){
// 		$data = $this->ppm->pshowupc();
// 		echo $data;
// 	}

//     //Add New PrivateProduct
// 	function addPProduct(){
// 		$data=$this->ppm->addPProduct();
// 		echo json_encode($data);
// 	}

//     //view product and batches
// 	public function psdproductview(){
// 	    $data['thisPage'] = 'psdproductmanage';
// 	    $data['pgScript'] = 'psdproductview';
// 	    $data['thisPageLevel'] = '2';   
// 	    $data['thisPageMain']="<a href='psdproductmanage'>Manage Product</a>";
// 	    $data['title'] = 'Product Details';  
// 	    $this->load->datatable_template('app/seed/psdproductview', $data);
// 	}

//     //Private Batch Entry
// 	public function psdbatchentry(){
// 		// $previous_url = $this->session->userdata('previous_url');
// 		$url= $_SERVER['HTTP_REFERER'];
// 		$data['thisPage'] = 'psdproductmanage';
// 		$data['pgScript'] = 'psdbatchentry';
// 		$data['thisPageLevel'] = '2';   
// 		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
// 		$data['title'] = 'Batch Entry';  
// 		$this->load->formentry_template('app/seed/psdbatchentry', $data);
// 	}

//     //Datatable View batch
// 	function dtPBatch(){
//         $pid = $this->input->post('pid');
//         $data = $row = array();        
//         // Fetch member's records
//         $memData = $this->pbm->getRows($_POST);  
//         $i = $_POST['start']+1;
//         $apistatus='';
//         $dis='';
//         $link='';
//         $is_primary = '0';
//         $productDetails = $this->db->select('*')
//                           ->from('publicproduct')->where(array('id' => $pid,'status' => '1'))
//                           ->get()->result();
//         if($productDetails){
//             foreach ($productDetails as $prod) {
//                 $is_primary = $prod->onlyprimary;
//             }
//         }
//         foreach($memData as $row){      
//             $actionButton = '
//               <ul class="list-inline">  
//                 <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="psdbatchview?id='.$row->id.'" data-toggle="tooltip" title="View Batch Details"> <span class="fa fa-eye"></span></a></li>
//                 <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="psbatchedit?id='.$row->id.'"> <span class="fa fa-edit" data-toggle="tooltip" title="Edit Batch Info"></span></a></li>
//                 ';                
//             $data[] = array(
//                 $i++, 
//                 '<strong>'.ucwords($row->batch_no).'</strong>', 
//                 $row->s_no_qty,
//                 date('d-m-y', strtotime($row->mfd_date)),       
//                 date('d-m-Y', strtotime($row->exp_date)),
//                 $actionButton
//             );
//         }
        
//         $output = array(
//             "draw" => $_POST['draw'],
//             "recordsTotal" => $this->pbm->countAll($_POST),
//             "recordsFiltered" => $this->pbm->countFiltered($_POST),
//             "data" => $data,
//         );
        
//         // Output to JSON format
//         echo json_encode($output);
//     }

//     //Add New private Batch
// 	function addPBatch(){
// 		$data=$this->pbm->addPBatch();
// 		echo json_encode($data);
// 	}

//     //private Batch View
// 	public function psdbatchview(){
// 		$url= $_SERVER['HTTP_REFERER'];
// 		$data['thisPage'] = 'psdproductmanage';
// 		$data['pgScript'] = 'psdbatchview';
// 		$data['thisPageLevel'] = '2';   
// 		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
// 		$data['title'] = 'Batch View';  
// 		$this->load->datatable_template('app/seed/psdbatchview', $data);
// 	}
//     //private serials
//     function dtPSerial(){
//         $bid = $this->input->post('bid');
//         $vendor_code = get_settings('vendor_code');
//         $primary_identifier = get_settings('primary_identifier');
//         $data = $row = array();        
//         // Fetch member's records
//         $memData = $this->ppsm->getRows($_POST);  
//         $i = $_POST['start']+1;
//         $dis='';        
//         foreach($memData as $row){           
//             if($row->api_sent!=0){
//                 $dis = "disabled";
//             }else{
//                 $dis = "";
//             }
//             $actionButton = '
//               <ul class="list-inline"> 
//                 <li class="list-inline-item d-print-none"><a class="btn text-red btn-xs hidden" role="button" id="delete_serial" data-id="'.$row->sbsid.'" data-toggle="tooltip" title="Delete Serial Nos."> <span class="fa fa-trash"></span></a></li>
//                 <li class="list-inline-item"><a class="btn text-blue btn-xs" role="button" href="psprimarysinglefullqrcode?id='.$row->sbsid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print QRcode full label"> <span class="fa fa-qrcode"></span></a></li>
//                 <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" href="psprimarysinglesmallqrcode?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode small label"> <span class="fa fa-qrcode"></span></a></li>
//                 <li class="list-inline-item hidden"><a class="btn text-purple btn-xs" role="button" href="serialgqrcodeprint?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode green label"> <span class="fa fa-qrcode"></span></a></li>
//               </ul>';
//             $data[] = array(
//                 $i++, 
//                 '<strong>'.$row->serialno.'</strong>', 
//                 $actionButton
//             );
//         }
        
//         $output = array(
//             "draw" => $_POST['draw'],
//             "recordsTotal" => $this->ppsm->countAll($_POST),
//             "recordsFiltered" => $this->ppsm->countFiltered($_POST),
//             "data" => $data,
//         );
        
//         // Output to JSON format
//         echo json_encode($output);
//     }

//     //Container Datatable view
//     function dtPContainer(){
// 		$data=$this->pssm->dtPContainer();
// 		echo json_encode($data);
// 	}
	
	function publicpageqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/seed/publicpageqrcode');
	}
	
// 	/* Last Financial Year Data */
// /*=-Starts Products-=*/
// 	//View Product Manage Page
// 	public function lyproductmanage(){
// 	    $data['thisPage'] = 'lyproductmanage';
// 	    $data['pgScript'] = 'lyproductmanage';
// 	    $data['thisPageLevel'] = '1';   
// 	    $data['thisPageMain']="";
// 	    $data['title'] = "Manage Products - Archive";  
// 	    $this->load->datatable_template('app/seed/lyproductmanage', $data);
// 	}
// 	//Product Datatable view
// 	function dtlyProduct(){
// 		$data=$this->pm->dtlyProduct();
// 		echo json_encode($data);
// 	}
	
// 	//view product and batches
// 	public function lyproductview(){
// 	    $data['thisPage'] = 'lyproductmanage';
// 	    $data['pgScript'] = 'lyproductview';
// 	    $data['thisPageLevel'] = '2';   
// 	    $data['thisPageMain']="<a href='lyproductmanage'>Product Manage - Archive</a>";
// 	    $data['title'] = 'Product Details - Archive';  
// 	    $this->load->datatable_template('app/seed/lyproductview', $data);
// 	}

// 	function dtlyBatch(){
// 		$data=$this->bm->dtlyBatch();
// 		echo json_encode($data);
// 	}

// 	public function lybatchview(){
// 		$url= $_SERVER['HTTP_REFERER'];
// 		$data['thisPage'] = 'lyproductmanage';
// 		$data['pgScript'] = 'lybatchview';
// 		$data['thisPageLevel'] = '2';   
// 		$data['thisPageMain']="<a href='".$url."'>Product View- Archive</a>";
// 		$data['title'] = 'Batch View - Archive';  
// 		$this->load->datatable_template('app/seed/lybatchview', $data);
// 	}

// 	//Datatable View
// 	function dtlySerial(){		
// 		$data=$this->bm->dtlySerial();
// 		echo json_encode($data);
// 	}
/*=-Ends Products-=*/
}