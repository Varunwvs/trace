<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog')) || $this->session->userdata('level')!='2'){
	      header('location:home');
	  	}  
	  	$this->load->helper('url','kisaan_helper');
		$this->load->model('admin/CenterModel','cm');
		$this->load->model('admin/ProductModel','pm');
		$this->load->model('admin/UserModel','um');
	}

    public function index(){
	    $data['thisPage'] = 'dashboard';
	    $data['pgScript'] = 'dashboard';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Dashboard';  
	    $this->load->dashboard_template('admin/dashboard', $data);
	}

/*=-Starts Center-=*/
	public function admin_manage_center(){
	    $data['thisPage'] = 'managecenter';
	    $data['pgScript'] = 'managecenter';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Manage Center';  
	    $this->load->datatable_template('admin/admin_manage_center', $data);
	}

	//Center Datatable View
	function dtCenter(){
		$data=$this->cm->dtCenter();
		echo json_encode($data);
	}

	//Add new center
	public function admin_add_center(){
	    $data['thisPage'] = 'managecenter';
	    $data['pgScript'] = 'centeradd';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='admin_manage_center'>Manage Center</a>";
	    $data['title'] = 'Center Entry';  
	    $this->load->formentry_template('admin/admin_add_center', $data);
	}

	//Add New Center
	function addCenter(){
		$data=$this->cm->addCenter();
		echo json_encode($data);
	}

	//Get Center Info
	function getCntinfo(){			
		$data=$this->cm->getCntinfo();
		echo json_encode($data);
	}

	//Add new center
	public function admin_edit_center(){
	    $data['thisPage'] = 'managecenter';
	    $data['pgScript'] = 'centeredit';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='admin_manage_center'>Manage Center</a>";
	    $data['title'] = 'Center Edit';  
	    $this->load->formentry_template('admin/admin_edit_center', $data);
	}

	//Add New Center
	function editCenter(){
		$data=$this->cm->editCenter();
		echo json_encode($data);
	}

	//Delete Center info
	function delCenter(){
		$data=$this->cm->delCenter();
		echo json_encode($data);
	}
/*=-Ends Center -=*/	

/*=-Starts Product-=*/
	public function admin_manage_product(){
		$data['thisPage'] = 'manageproduct';
		$data['pgScript'] = 'manageproduct';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Product';  
		$this->load->datatable_template('admin/admin_manage_product', $data);
	}

	//Product Datatable View
	function dtProduct(){
		$data=$this->pm->dtProduct();
		echo json_encode($data);
	}
	
	//Get SubCategory
// 	function getItemSubCategory(){
// 		$catid = $this->input->post('id',TRUE);
//         $data = $this->pm->getItemSubCat($catid)->result();
//         echo json_encode($data);
// 	}

// 	//Get Items
// 	function getItem(){
// 		$subcatid = $this->input->post('id',TRUE);
//         $data = $this->pm->getItem($subcatid)->result();
//         echo json_encode($data);
// 	}

// 	//get netweight list
//     function getNW(){
//         $itid = $this->input->post('itid',TRUE);
//         $suid = $this->input->post('suid',TRUE);
//         $data = $this->pm->getNW($itid, $suid)->result();
//         echo json_encode($data);
//     }

//     //Get net weights
// 	function getNWs(){
// 		$itmid = $this->input->post('id',TRUE);
//         $subitmid = $this->input->post('subid',TRUE);
//         $data = $this->pm->getNWs($itmid, $subitmid)->result();
//         echo json_encode($data);
// 	}

// 	//Get Items
// 	function getUomids(){
// 		$itmid = $this->input->post('id',TRUE);
//         $subitmid = $this->input->post('subid',TRUE);
//         $data = $this->pm->getUomids($itmid, $subitmid)->result();
//         echo json_encode($data);
// 	}

	//Add new product page
	public function admin_add_product(){
		$data['thisPage'] = 'manageproduct';
		$data['pgScript'] = 'productadd';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='admin_manage_product'>Manage Product</a>";
		$data['title'] = 'Product Entry';  
// 		$data['seedc'] = $this->pm->getSeedclass()->result();
// 		$data['itemCat'] = $this->pm->getItemCategory()->result();
		$this->load->formentry_template('admin/admin_add_product', $data);
	}

	//UPC No Generation
	function showupc(){
		$data = $this->pm->showupc();
		echo $data;
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

	//Update Product
	public function admin_edit_product(){
		$data['thisPage'] = 'manageproduct';
		$data['pgScript'] = 'productedit';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='admin_manage_product'>Manage Product</a>";
		$data['title'] = 'Product Edit';  
		$data['uomid'] = $this->pm->getUomid()->result();
		$this->load->formentry_template('admin/admin_edit_product', $data);
	}

	//edit Product
	function editProduct(){
		$data=$this->pm->editProduct();
		echo json_encode($data);
	}

	//Delete Product info
	function delProduct(){
		$data=$this->pm->delProduct();
		echo json_encode($data);
	}

	//Import Product
	public function admin_import_product(){
		$data['thisPage'] = 'productimport';
		$data['pgScript'] = 'productimport';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Product Import';  
		$this->load->formentry_template('admin/admin_import_product', $data);
	}
	
	//for mi products
	//UPC No Generation
	function showupcmi(){
		$data = $this->pm->showupcmi();
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
	//Add new product page
	public function admin_add_product_mi(){
		$data['thisPage'] = 'manageproduct';
		$data['pgScript'] = 'productaddmi';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='admin_manage_product'>Manage Product</a>";
		$data['title'] = 'Product Entry';  
		$data['itemCat'] = $this->pm->getItemCategory()->result();
		$this->load->formentry_template('admin/admin_add_product_mi', $data);
	}
	
	function addProductmi(){
		$data=$this->pm->addProductmi();
		echo json_encode($data);
	}
/*=-Ends Product -=*/

	//get company info
	function getCominfo(){
		$data=$this->um->getCominfo();
		echo json_encode($data);
	}
	//Admin Profile
	public function admin_profile(){
		$data['thisPage'] = 'admin_profile';
		$data['pgScript'] = 'admin_profile';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Profile View';  
		$this->load->formentry_template('admin/admin_profile', $data);
	}
	//Update Profile
	function updProfile(){
		$data=$this->um->updProfile();
		echo json_encode($data);
	}

/*=-Starts Import Product-=*/
	public function sample_csv(){
		$filename = 'uploads/seed_sample_products.csv';
		header('Content-type: text/csv');
		header('Content-disposition:attachment; filename="'.$filename.'"');
		readfile($filename);
	}

	function import() {
        if (isset($_FILES["file"])) {
            $this->load->library('upload');
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '500';
            $config['overwrite'] = TRUE;
            
            $csv = $this->upload->file_name;
            $filename=$_FILES["file"]["tmp_name"];
            $arrResult = array();
            $handle = fopen($filename, "r");
			if($_FILES["file"]["type"] != 'text/csv'){
				$this->session->set_flashdata('error_message','file type should be csv');
				redirect("productimport");
			}
                
			if ($handle) {
				while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$arrResult[] = $row;
				}
				fclose($handle);
			}
			array_shift($arrResult);                
			//var_dump($arrResult);
			// $keys = array('name', 'marketed_by', 'p_category', 'sub_category', 'p_code', 'p_name','b_name','unit_w','net_w','mrp','germination','phypurity','moisture','inertmatter','othercrop');
			$keys = array('name', 'marketed_by', 'p_category', 'sub_category', 'p_code', 'p_name','b_name','unit_w','net_w');
			//var_dump($keys);exit();
			$final = array();
			foreach ($arrResult as $key => $value) {
				$final[] = array_combine($keys, $value);
			}
            //var_dump($final);exit();
			$final_count = count($final);
			$pdcount = $this->db->select('count(*) as pcount')->from('seedproduct')->where('c_id', $_SESSION['comid'])->get();
			foreach($pdcount->result() as $pcrow){
				$pcount = $pcrow->pcount;
			}
            $upcount = $this->db->select('totalproduct')->from('users')->where('id', $_SESSION['comid'])->get();
			foreach($upcount->result() as $pcrow){
				$ucount = $pcrow->totalproduct;
			} 
			$count_prod = $ucount - $pcount;
			if($count_prod < 0){
				$count_prod = '0';
			}
			if($count_prod == '0'){
				$this->session->set_flashdata('error_message','You have already reached the maximum number of products. Please contact us for further detail');
				redirect("productimport");
			}
			if($count_prod < $final_count){
				$this->session->set_flashdata('error_message','You have more products on the file. Please remove it.');
				redirect("productimport");
			}
            //echo $ucount;exit();
			//echo $final_count;exit();
			if (sizeof($final) > 1001) {
				$this->session->set_flashdata('error_message','Please upload less file size file');
				redirect("productimport");
			}
                
			$userid = $this->session->userdata('comid');
          
			foreach ($final as $csv_pr) {
				$max_upc = get_settings("max_upc");
				$output['max_upc'] = $max_upc + 1;
				$this->pm->update_upc($output['max_upc']);
				$unit_w = $csv_pr['unit_w'];
				$unit_w = strtolower($unit_w);
				if($unit_w == 'kg' || $unit_w == 'kgs' || $unit_w == 'kilogram'){
					$uomid = '2';
				}elseif($unit_w == 'liter' || $unit_w == 'ltr' || $unit_w == 'litre'){
					$uomid = '4';
				}elseif($unit_w == 'gram' || $unit_w == 'gm' || $unit_w == 'grams'){
					$uomid = '1';
				}elseif($unit_w == 'milliliter' || $unit_w == 'ml'){
					$uomid = '3';
				}else{
						$uomid = '2';
				}
				
				$data[] = array(
					'name' => $csv_pr['name'],
					'marketed_by' => $csv_pr['marketed_by'],
					'p_category' => $csv_pr['p_category'],
					'sub_category' => $csv_pr['sub_category'],
					'p_code' => $output['max_upc'],
					'p_name' => $csv_pr['p_name'],
					'b_name' => $csv_pr['b_name'],
					'unit_w' => $csv_pr['unit_w'],
					'net_w' => $csv_pr['net_w'],
					// 'mrp' => $csv_pr['mrp'],
					// 'germination' => $csv_pr['germination'],
					// 'phypurity' => $csv_pr['phypurity'],
					// 'moisture' => $csv_pr['moisture'],
					// 'inertmatter' => $csv_pr['inertmatter'],
					// 'othercrop' => $csv_pr['othercrop'],
					// 'prdlink' => $csv_pr['prodcutlink'],
					'c_id' =>  $userid,
					'uomid' =>  $uomid,
				);
			}
			// print_r($data); exit();
               
			if ($this->pm->add_products($data)) {	
				$output['success'] = true;
				$output['messages'] = 'Successfully added!';  
				$this->session->set_flashdata('success_message', 'Product imported successfully');
				redirect('productimport');
	
			} else{
				$this->session->set_flashdata('error_message', 'Something went wrong.Please try again');
				redirect('productimport');
			}
		}else{
			$data['thisPage'] = 'bulkimport';
			$data['icon'] = '<i class="icofont icofont-dashboard" tabindex="-1"></i>';
			$data['thisPageLevel'] = '1'; 
			$data['thisPageMain']="";
			$data['title'] = 'Import Products';
			$this->load->home_single_template('user/productImport', $data);
		}
    }

	public function product_import(){
		if(isset($_POST["import"])){
			$filename=$_FILES["file"]["tmp_name"];

			$config['allowed_types'] = 'xlsx|csv|xls';
			if($_FILES["file"]["size"] > 0){
				$file = fopen($filename, "r");

				while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE)
				{
				print_r($importdata);exit();
				}                    
				fclose($file);
				$this->session->set_flashdata('message', 'Data are imported successfully..');
				redirect('BulkImport/index');
			}else{
				$this->session->set_flashdata('message', 'Something went wrong..');
				redirect('BulkImport/index');
			}
		}
	}
/*=-Ends Import Product-=*/
}