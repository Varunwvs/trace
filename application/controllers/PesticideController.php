<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PesticideController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog')) || $this->session->userdata('level')!='3' || $_SESSION['comcat']!="5"){
	      header('location:home');
	  	}  
	  	$this->load->helper('url');
	  	$this->load->model('app/pesticide/DashboardModel','dm');
		$this->load->model('app/pesticide/UserModel','um');
        $this->load->model('app/pesticide/ProductModel','pm');
        $this->load->model('app/pesticide/BatchModel','bm');
        $this->load->model('app/pesticide/PrimaryserialModel','psm');
        $this->load->model('app/pesticide/SecondaryserialModel','ssm');
        $this->load->model('app/pesticide/PProductModel','ppm');
        $this->load->model('app/pesticide/PBatchModel','pbm');
        $this->load->model('app/pesticide/PPrimaryserialModel','ppsm');
        $this->load->model('app/pesticide/PSecondaryserialModel','pssm');
	}

    public function index(){
	    $data['thisPage'] = 'dashboard';
	    $data['pgScript'] = 'dashboard';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Dashboard';  
	    $this->load->dashboard_template('app/pesticide/dashboard', $data);
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
		$this->load->formentry_template('app/pesticide/searchresult', $data);
	}
/*=-Ends Search-=*/
public function help(){
    $data['thisPage'] = 'help';
    $data['pgScript'] = 'help';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Help';  
    $this->load->formentry_template('app/pesticide/help', $data);
}

/*=-Starts Settings-=*/
	//import product
	public function productimport(){
		$data['thisPage'] = 'productimport';
		$data['pgScript'] = 'productimport';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Product Import';  
		$this->load->formentry_template('app/pesticide/productimport', $data);
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
		$this->load->formentry_template('app/pesticide/userprofile', $data);
	}
	//Update Profile
	function updProfile(){
		$data=$this->um->updProfile();
		echo json_encode($data);
	}
/*=-Ends Settings-=*/

/*=-Starts Products-=*/
	//View Product Manage Page
	public function productmanage(){
	    $data['thisPage'] = 'productmanage';
	    $data['pgScript'] = 'productmanage';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Manage Products';  
	    $this->load->datatable_template('app/pesticide/productmanage', $data);
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
        foreach($memData as $row){           
            if($row->api_sent!='0'){
                $dis = "disabled";
                $apistatus = '<li class="list-inline-item"><a class="btn text-success btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> API Sent Successfully</a></li>';                
            }else{
                $dis = "";
                $apistatus = '<li class="list-inline-item"><a class="btn text-danger btn-xs" role="button" href="pskkisaanapi"> <span class="fa-solid fa-cloud-arrow-up"></span> Api not sent</a></li>';
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
            $binfo = $this->db->select('*')->from('pesticidebatch')->where(array('pid'=> $row->id, 'c_id'=>$_SESSION['comid']))->get();
            $bcount = $binfo->num_rows();
            if($bcount !=0){
                $bc = '<span class="right badge badge-success">'.$bcount.'</span>';
            }else{
                $bc = '<span class="right badge badge-warning">'.$bcount.'</span>';
            }
            $actionButton = '
            <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="psproductview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.' hidden" role="button" href="psproductedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>
                <li class="list-inline-item d-print-none hidden"><a class="btn text-red btn-xs '.$dis.' '.$hid.'" role="button" id="delete_product" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Member"> <span class="fa fa-trash"></span></a></li>
                '.$apistatus.'
            </ul>';
            $data[] = array(
                $i++, 
                '<strong>'.ucwords($row->p_name).'</strong><sup> '.$pinfo.' '.$bc.'</sup>', 
                $row->p_code,       
                ucwords($row->itemcategory),
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
	
	function getItems(){
		$subcatid = $this->input->post('id',TRUE);
		$itmid = $this->input->post('pid',TRUE);
        $data = $this->pm->getItems($subcatid, $itmid)->result();
        echo json_encode($data);
	}

    //get uomid list
    function getUomid(){
        $data = $this->pm->getUomid()->result();
        echo json_encode($data);
    }

    //Get Items
	function getUomids(){
		$itmid = $this->input->post('id',TRUE);
        $subitmid = $this->input->post('subid',TRUE);
        $data = $this->pm->getUomids($itmid, $subitmid)->result();
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

    //Product Entry Page
	public function productentry(){
	    $data['thisPage'] = 'productmanage';
	    $data['pgScript'] = 'productentry';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='psproductmanage'>Product Manage</a>";
	    $data['title'] = 'Product Entry';  
        $data['itemCat'] = $this->pm->getItemCategory()->result();
	    $this->load->formentry_template('app/pesticide/productentry', $data);
	}
    
	//Add New Product
	function addProduct(){
		$data=$this->pm->addProduct();
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
	    $data['thisPageMain']="<a href='psproductmanage'>Product Manage</a>";
	    $data['title'] = 'Product Edit';  
	    $data['itemCat'] = $this->pm->getItemCategory()->result();
	    $this->load->formentry_template('app/pesticide/productedit', $data);
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
	    $data['thisPageMain']="<a href='psproductmanage'>Product Manage</a>";
	    $data['title'] = 'Product Details';  
	    $this->load->datatable_template('app/pesticide/productview', $data);
	}
/*=-Ends Products-=*/

/* Starts Batch Management */
	//Datatable View batch
	function dtBatch(){
        $pid = $this->input->post('pid');
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->bm->getRows($_POST);  
        $i = $_POST['start']+1;
        $apistatus='';
        $dis='';
        $link='';
        $is_primary = '0';
        $productDetails = $this->db->select('*')
                          ->from('pesticideproduct')->where(array('id' => $pid,'status' => '1'))
                          ->get()->result();
        if($productDetails){
            foreach ($productDetails as $prod) {
                $is_primary = $prod->onlyprimary;
            }
        }
        foreach($memData as $row){           
            if($row->api_sent!=0){
                $dis = "disabled";
            }else{
                $dis = "";
            }
            if($row->schedule_cron=='1'){
                 $link = '<li class="text-xs">Scheduled</li>';
            }
            elseif($row->schedule_cron=='2'){
                $link = '<li class="list-inline-item"><a class="btn text-success btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> API Sent Successfully</a></li>';
            }elseif($row->schedule_cron=='3'){
                $link = '<li class="list-inline-item"><a class="btn text-warning btn-xs disabled" role="button"> <span class="fa-solid fa-cloud-arrow-up"></span> Something went wrong</a></li>';
            }else{
                if($row->container_status == '0'){
                    $link='<li class="list-inline-item"><a class="btn text-danger btn-xs" role="button" href="pskkisaanapi"> <span class="fa-solid fa-cloud-arrow-up"></span> Api not sent</a></li>';
                }else{
                    $link = '<li class="list-inline-item"><a class="btn text-red btn-xs" role="button" href="ps_save_secondary_container_details?bid='.$row->id.'" data-toggle="tooltip" title="send secondary api data"> 
                    <span class="fa-solid fa-cloud-arrow-up"></span> Api not sent</a></li>';
                }
            }
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="psbatchview?id='.$row->id.'" data-toggle="tooltip" title="View Batch Details"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="psbatchedit?id='.$row->id.'"> <span class="fa fa-edit" data-toggle="tooltip" title="Edit Batch Info"></span></a></li>
                ';
                if($is_primary == '0' && $row->container_status == '0' && $row->api_sent == '0'){
                    $actionButton .= '<li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="pscontainerentry?id='.$row->id.'"> <span class="fa-solid fa-plus" data-toggle="tooltip" title="Add Container"></span></a></li> </ul>';  
                }else{
                    $actionButton .=$link;
                }
            $data[] = array(
                $i++, 
                '<strong>'.ucwords($row->batch_no).'</strong>', 
                $row->s_no_qty,
                date('d-m-y', strtotime($row->mfd_date)),       
                date('d-m-Y', strtotime($row->exp_date)),
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->bm->countAll($_POST),
            "recordsFiltered" => $this->bm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
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
		$this->load->formentry_template('app/pesticide/batchentry', $data);
	}

    //Add New Batch
	function addBatch(){
		$data=$this->bm->addBatch();
		echo json_encode($data);
	}

    //Batch View
	public function batchview(){
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'productmanage';
		$data['pgScript'] = 'batchview';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch View';  
		$this->load->datatable_template('app/pesticide/batchview', $data);
	}

    //Batch Edit
    //Get bacth Info
	function getBatchinfo(){		
		$data=$this->bm->getBatchinfo();
		echo json_encode($data);
	}

	public function batchedit(){
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'productmanage';
		$data['pgScript'] = 'batchedit';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch Edit';  
		$this->load->formentry_template('app/pesticide/batchedit', $data);
	}

	//Update the Batch
	function editBatch(){		
		$data=$this->bm->updBatch();
		echo json_encode($data);
	}

    //Datatable View batch primary serial
	function dtSerial(){
        $bid = $this->input->post('bid');
        $vendor_code = get_settings('vendor_code');
        $primary_identifier = get_settings('primary_identifier');
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->psm->getRows($_POST);  
        $i = $_POST['start']+1;
        $dis='';        
        foreach($memData as $row){           
            if($row->api_sent!=0){
                $dis = "disabled";
            }else{
                $dis = "";
            }
            $actionButton = '
              <ul class="list-inline"> 
                <li class="list-inline-item d-print-none"><a class="btn text-red btn-xs hidden" role="button" id="delete_serial" data-id="'.$row->sbsid.'" data-toggle="tooltip" title="Delete Serial Nos."> <span class="fa fa-trash"></span></a></li>
                <li class="list-inline-item"><a class="btn text-blue btn-xs" role="button" href="psprimarysinglefullqrcode?id='.$row->sbsid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print QRcode full label"> <span class="fa fa-qrcode"></span></a></li>
                <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" href="psprimarysinglesmallqrcode?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode small label"> <span class="fa fa-qrcode"></span></a></li>
                <li class="list-inline-item hidden"><a class="btn text-purple btn-xs" role="button" href="serialgqrcodeprint?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode green label"> <span class="fa fa-qrcode"></span></a></li>
              </ul>';
            $data[] = array(
                $i++, 
                '<strong>'.$row->serialno.'</strong>', 
                '<strong>'.$vendor_code.$row->alias.'</strong>',
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->psm->countAll($_POST),
            "recordsFiltered" => $this->psm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }

    //Container Datatable view
    function dtContainer(){
		$data=$this->ssm->dtContainer();
		echo json_encode($data);
	}
    //Datatable View batch secondary serial
	// function dtContainer(){
    //     $bid = $this->input->post('bid');
    //     $vendor_code = get_settings('vendor_code');
    //     $data = $row = array();        
    //     // Fetch member's records
    //     $memData = $this->ssm->getRows($_POST);  
    //     $i = $_POST['start']+1;
    //     $dis='';        
    //     foreach($memData as $row){           
    //         $actionButton = '
    //           <ul class="list-inline">
    //             <li class="list-inline-item d-print-none"><a class="btn text-info btn-xs" role="button" href="containerqrcode?ctid='.$row->ctid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print Secondary Label"> <span class="fas fa-print"></span></a></li>
    //             <li class="list-inline-item d-print-none"><a class="btn text-success btn-xs" role="button" href="containernqrcode?ctid='.$row->ctid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print Secondary Label"> <span class="fas fa-print"></span></a></li>
    //           </ul>';

    //         $output[] = array(
    //             $i++,
    //             $row->ucc,
    //             $vendor_code.$row->alias,
    //             $row->alias,
    //             $actionButton
    //         ); 
    //     }
        
    //     $output = array(
    //         "draw" => $_POST['draw'],
    //         "recordsTotal" => $this->ssm->countAll($_POST),
    //         "recordsFiltered" => $this->ssm->countFiltered($_POST),
    //         "data" => $data,
    //     );
        
    //     // Output to JSON format
    //     echo json_encode($output);
    // }
/* Ends Batch Management */

/*Starts Container Entry*/
    public function containerentry(){
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'containermanage';
        $data['pgScript'] = 'containerentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="<a href='".$url."'>Product View</a>";
        $data['title'] = 'Add Container';  
        $data['serial'] = $this->ssm->getSerial()->result();
        $this->load->formentry_template('app/pesticide/containerentry', $data);
    }

    //generate ucc no
	function showucc(){
		$data = $this->ssm->showucc();
		echo $data;
	}

	//get Batch Info 
	function getBinfo(){     
		$data=$this->ssm->getBinfo();
		echo json_encode($data);
	}

	function addContainer(){
		$data=$this->ssm->addContainer();
		echo json_encode($data);
	}
/*Ends Container Entry*/

/* Starts primary serial qrcode print */
    //primary single small qrcode
    function primarysinglesmallqrcode(){
        $this->load->library('Pdfprs');
        $this->load->view('app/pesticide/primarysinglesmallqrcode');
    }
    //primary single full qrcode
    function primarysinglefullqrcode(){
        $this->load->library('Pdfprs');
        $this->load->view('app/pesticide/primarysinglefullqrcode');
    }
    //primary full batch qrcode
    function primaryfullbatchqrcode(){
        $this->load->library('Pdfprs');
        $this->load->view('app/pesticide/primaryfullbatchqrcode');
    }
    //primary full batch small qrcode
    function primaryfullsmallqrcode(){
        $this->load->library('Pdfprs');
        $this->load->view('app/pesticide/primaryfullsmallqrcode');
    }
    //secondary full batch small qrcode
    function secondaryfullqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/pesticide/secondaryfullqrcode');
	}
	//secondary full batch small qrcode
    function publicpageqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/pesticide/publicpageqrcode');
	}
/* Ends primary serial qrcode print*/

    //function to shceudle batch and containers for cron processing
    public function get_container_code(){
            
        if(@$_GET['bid']>0){
            $mv = $this->db->select('MAX(order_by) as order_by')->from('pesticidebatch')->where('schedule_cron', '1')->get();
            foreach($mv->result() as $obrow){
                $order_by = $obrow->order_by;
            }
            //update schedule cron status to 1
            
            $this->db->update("pesticidebatch", array("schedule_cron"=>1, "order_by"=>$order_by+1), array("id"=>$_GET['bid']));
            
            //update schedule cron status to 1 in container in container table
            $this->db->update("pesticidecontainer", array("cron_status"=>1), array("batchno"=>$_GET['bid']));
        
            $this->session->set_flashdata('success_message', 'Batch scheduled for sending');
        
        } else {
            
            $this->session->set_flashdata('failure_message', 'Batch id not selected');
        }
        
        $url = $_SERVER['HTTP_REFERER'];
        redirect($url);
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
    
    //View private Product Manage Page
    //import product
	public function psbproductimport(){
		$data['thisPage'] = 'psbproductimport';
		$data['pgScript'] = 'psbproductimport';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Product Bulk Import';  
		$this->load->formentry_template('app/pesticide/psbproductimport', $data);
	}
	public function ppsproductmanage(){
	    $data['thisPage'] = 'ppsproductmanage';
	    $data['pgScript'] = 'ppsproductmanage';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Manage Products(Private Sale)';  
	    $this->load->datatable_template('app/pesticide/ppsproductmanage', $data);
	}

    //private Product Datatable view
	function dtPProduct(){
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->ppm->getRows($_POST);        
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
        $admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';
        $apistatus='';
        $dis='';
        $hid='';
        $pinfo='';
        foreach($memData as $row){       
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
            $binfo = $this->db->select('*')->from('publicbatch')->where(array('pid'=> $row->id, 'c_id'=>$_SESSION['comid']))->get();
            $bcount = $binfo->num_rows();
            if($bcount !=0){
                $bc = '<span class="right badge badge-success">'.$bcount.'</span>';
            }else{
                $bc = '<span class="right badge badge-warning">'.$bcount.'</span>';
            }
            $actionButton = '
            <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="ppsproductview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.' hidden" role="button" href="ppsproductedit?id='.$row->id.'"> <span class="fa fa-edit"></span></a></li>                
            </ul>';
            $data[] = array(
                $i++, 
                '<strong>'.ucwords($row->p_name).'</strong><sup> '.$pinfo.' '.$bc.'</sup>', 
                $row->p_code,       
                ucwords($row->itemcategory),
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ppm->countAll(),
            "recordsFiltered" => $this->ppm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }

    //Private Product Entry Page
	public function ppsproductentry(){
	    $data['thisPage'] = 'ppsproductmanage';
	    $data['pgScript'] = 'ppsproductentry';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='ppsproductmanage'>Product Manage</a>";
	    $data['title'] = 'Product Entry';  
        $data['itemCat'] = $this->pm->getItemCategory()->result();
	    $this->load->formentry_template('app/pesticide/ppsproductentry', $data);
	}
	
	function pshowupc(){
		$data = $this->ppm->pshowupc();
		echo $data;
	}

    //Add New PrivateProduct
	function addPProduct(){
		$data=$this->ppm->addPProduct();
		echo json_encode($data);
	}

    //view product and batches
	public function ppsproductview(){
	    $data['thisPage'] = 'ppsproductmanage';
	    $data['pgScript'] = 'ppsproductview';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='ppsproductmanage'>Product Manage</a>";
	    $data['title'] = 'Product Details';  
	    $this->load->datatable_template('app/pesticide/ppsproductview', $data);
	}

    //Private Batch Entry
	public function ppsbatchentry(){
		// $previous_url = $this->session->userdata('previous_url');
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'ppsproductmanage';
		$data['pgScript'] = 'ppsbatchentry';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch Entry';  
		$this->load->formentry_template('app/pesticide/ppsbatchentry', $data);
	}

    //Datatable View batch
	function dtPBatch(){
        $pid = $this->input->post('pid');
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->pbm->getRows($_POST);  
        $i = $_POST['start']+1;
        $apistatus='';
        $dis='';
        $link='';
        $is_primary = '0';
        $productDetails = $this->db->select('*')
                          ->from('pesticideproduct')->where(array('id' => $pid,'status' => '1'))
                          ->get()->result();
        if($productDetails){
            foreach ($productDetails as $prod) {
                $is_primary = $prod->onlyprimary;
            }
        }
        foreach($memData as $row){      
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="ppsbatchview?id='.$row->id.'" data-toggle="tooltip" title="View Batch Details"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="psbatchedit?id='.$row->id.'"> <span class="fa fa-edit" data-toggle="tooltip" title="Edit Batch Info"></span></a></li>
                ';                
            $data[] = array(
                $i++, 
                '<strong>'.ucwords($row->batch_no).'</strong>', 
                $row->s_no_qty,
                date('d-m-y', strtotime($row->mfd_date)),       
                date('d-m-Y', strtotime($row->exp_date)),
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pbm->countAll($_POST),
            "recordsFiltered" => $this->pbm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }

    //Add New private Batch
	function addPBatch(){
		$data=$this->pbm->addPBatch();
		echo json_encode($data);
	}

    //private Batch View
	public function ppsbatchview(){
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'ppsproductmanage';
		$data['pgScript'] = 'ppsbatchview';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch View';  
		$this->load->datatable_template('app/pesticide/ppsbatchview', $data);
	}
    //private serials
    function dtPSerial(){
        $bid = $this->input->post('bid');
        $vendor_code = get_settings('vendor_code');
        $primary_identifier = get_settings('primary_identifier');
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->ppsm->getRows($_POST);  
        $i = $_POST['start']+1;
        $dis='';        
        foreach($memData as $row){           
            if($row->api_sent!=0){
                $dis = "disabled";
            }else{
                $dis = "";
            }
            $actionButton = '
              <ul class="list-inline"> 
                <li class="list-inline-item d-print-none"><a class="btn text-red btn-xs hidden" role="button" id="delete_serial" data-id="'.$row->sbsid.'" data-toggle="tooltip" title="Delete Serial Nos."> <span class="fa fa-trash"></span></a></li>
                <li class="list-inline-item"><a class="btn text-blue btn-xs" role="button" href="psprimarysinglefullqrcode?id='.$row->sbsid.'&cid='.$_SESSION['comid'].'" target="_blank" data-toggle="tooltip" title="Print QRcode full label"> <span class="fa fa-qrcode"></span></a></li>
                <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" href="psprimarysinglesmallqrcode?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode small label"> <span class="fa fa-qrcode"></span></a></li>
                <li class="list-inline-item hidden"><a class="btn text-purple btn-xs" role="button" href="serialgqrcodeprint?id='.$row->sbsid.'" target="_blank" data-toggle="tooltip" title="Print QRcode green label"> <span class="fa fa-qrcode"></span></a></li>
              </ul>';
            $data[] = array(
                $i++, 
                '<strong>'.$row->serialno.'</strong>', 
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ppsm->countAll($_POST),
            "recordsFiltered" => $this->ppsm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }

    //Container Datatable view
    function dtPContainer(){
		$data=$this->pssm->dtPContainer();
		echo json_encode($data);
	}
	
	//Serial XSmall Qrcode
	function batchxsmallqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/pesticide/batchxsmallqrcode');
	}
	
	/* Last Financial Year Data */
/*=-Starts Products-=*/
	//View Product Manage Page
	public function lyproductmanage(){
	    $data['thisPage'] = 'lyproductmanage';
	    $data['pgScript'] = 'lyproductmanage';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Manage Products';  
	    $this->load->datatable_template('app/pesticide/lyproductmanage', $data);
	}
	//Product Datatable view
	function dtlyProduct(){
		$data=$this->pm->dtlyProduct();
		echo json_encode($data);
	}
	
	//view product and batches
	public function lyproductview(){
	    $data['thisPage'] = 'lyproductmanage';
	    $data['pgScript'] = 'lyproductview';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='plyproductmanage'>Product Manage</a>";
	    $data['title'] = 'Product Details';  
	    $this->load->datatable_template('app/pesticide/lyproductview', $data);
	}

	function dtlyBatch(){
		$data=$this->bm->dtlyBatch();
		echo json_encode($data);
	}

	public function lybatchview(){
		$url= $_SERVER['HTTP_REFERER'];
		$data['thisPage'] = 'lyproductmanage';
		$data['pgScript'] = 'lybatchview';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='".$url."'>Product View</a>";
		$data['title'] = 'Batch View';  
		$this->load->datatable_template('app/pesticide/lybatchview', $data);
	}

	//Datatable View
	function dtlySerial(){		
		$data=$this->bm->dtlySerial();
		echo json_encode($data);
	}
	
	//last year Serial XSmall Qrcode
	function plybatchxsmallqrcode(){
		$this->load->library('Pdfprs');
		$this->load->view('app/pesticide/plybatchxsmallqrcode');
	}
/*=-Ends Products-=*/
}