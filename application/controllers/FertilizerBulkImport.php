<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FertilizerBulkImport extends CI_Controller {
  public function __construct() {
    parent::__construct();
    if(empty($this->session->userdata('memlog'))){
        header('location:home');
      }  
      $this->load->helper('url','kisaan_helper');
    //   $this->load->model('app/fertilizer/ProductModel','pm');
      $this->load->model('app/fertilizer/BatchModel','bm');
    //   $this->load->model('app/fertilizer/ContainerModel','ccm');
    }
    
    public function sample_csv(){
        $filename = 'uploads/fertilizer_products.csv';
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
                    redirect("flproductimport");
                }
                
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                array_shift($arrResult);
                $keys = array('name', 'marketed_by', 'itemcategoryid', 'itemcategory', 'subcategoryid', 'subcategory', 'p_code', 'itemid', 'itemname','b_name','unit_w','net_w',onlyprimary);
                //var_dump($keys);exit();
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                //var_dump($final);exit();
                $final_count = count($final);
                $pdcount = $this->db->select('count(*) as pcount')->from('fertilizerproduct')->where('c_id', $_SESSION['comid'])->get();
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
                    $onlyprimary = $csv_pr['onlyprimary'];
                    if($onlyprimary === "yes" || $onlyprimary === "Yes" || $onlyprimary === "YES"){
                        $onlyprimary = '1';
                    }else{
                        $onlyprimary = '0';
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
                        //'prdlink' => $csv_pr['prodcutlink'],
                        'c_id' =>  $userid,
                        'uomid' =>  $uomid,
                        'onlyprimary' => $onlyprimary,
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
        
            public function batch_export(){
            // echo 'Hi';exit();
            $id = $_GET['id'];
            $comid = $_SESSION['comid'];
            $vendor_code = get_settings('vendor_code');
            $primary_identifier = get_settings('primary_identifier');
            // echo $id;exit();
            // header("Content-Description: File Transfer"); 
            // header("Content-Disposition: attachment; filename=$filename"); 
            // header("Content-Type: application/csv; ");
        

            $batchData =  $this->bm->batchExport($id,$comid);
            // var_dump($batchData);exit();
            if($batchData){
                foreach($batchData as $b_data){
                    $p_name = $b_data->p_name;
                    $p_code = $b_data->p_code;
                    $p_category = $b_data->itemcategory;
                    $sub_category = $b_data->subcategory;
                    $batch_no = $b_data->batch_no;
                    $batch_id = $b_data->batchid;
                    $mfg_date = date('d-m-y', strtotime($b_data->mfd_date));
                    $exp_date = date('d-m-y', strtotime($b_data->exp_date));
                }
                
            }else{
                $p_name = " ";
                $p_code = " ";
                $p_category = " ";
                $sub_category = " ";
                $batch_no = " ";
                $mfg_date = " ";
                $exp_date = " ";
                $batch_id = '0';
            }
        
        $filename = $batch_no.'-'.date('dmY').'.csv';
        header('Content-type: text/csv');
        header('Content-disposition:attachment; filename="'.$filename.'"');
        
     $file = fopen('php://output', 'w');
     //print_r($file);exit();
            $header = array("Product Name","UPC","Category","Sub Category","Batch Number","Serial Number","Mfg Date","Exp Date","Alias Code");
            fputcsv($file, $header);

            if($batch_id > 0){
                $serialnoData = $this->bm->getSerialNumbers($batch_id);
                if($serialnoData){
                    foreach($serialnoData as $s_data ){
                        $alias = $primary_identifier.$vendor_code.$s_data->alias;
                        fputcsv($file,array($p_name,'="'.$p_code.'"',$p_category,$sub_category,$batch_no,'="'.$s_data->serialno.'"',$mfg_date,$exp_date,'="'.$alias.'"')); 
                    }
                }else{
                    $this->session->set_flashdata('message', 'Something went wrong..');
                    redirect('productmanage');
                }
            }

     fclose($file); 
     exit(); 
        }
        
        
     public function container_export(){
            //echo 'Hi';exit();
            $id = $_GET['id'];
            $comid = $_SESSION['comid'];
            $vendor_code = get_settings('vendor_code');
            $ucc_identifier = get_settings('ucc_identifier');
            //echo $id;exit();
     // header("Content-Description: File Transfer"); 
     // header("Content-Disposition: attachment; filename=$filename"); 
     // header("Content-Type: application/csv; ");
        

        $containerData =  $this->ccm->containerExport($id,$comid);
        //var_dump($batchData);exit();
        if($containerData){
            foreach($containerData as $c_data){
                $ucc = $c_data->ucc;
                $alias = $c_data->alias;
                $qty = $c_data->totalno;
                $batch_no = $c_data->batchno;
            }
            
        }else{
            $ucc = " ";
            $alias = " ";
            $qty = " ";
        }
        
        $filename = $batch_no.'-'.date('dmY').'.csv';
        header('Content-type: text/csv');
        header('Content-disposition:attachment; filename="'.$filename.'"');
        
     $file = fopen('php://output', 'w');
     //print_r($file);exit();
            $header = array("UCC","Alias Code","Quantity/Packet");
            fputcsv($file, $header);

            if($id > 0){
                $containerData =  $this->ccm->containerExport($id,$comid);
                if($containerData){
                    foreach($containerData as $c_data ){
                        $alias = $ucc_identifier.$vendor_code.$c_data->alias;
                        fputcsv($file,array($c_data->ucc,$alias,$c_data->totalno)); 
                    }
                }else{
                    $this->session->set_flashdata('message', 'Something went wrong..');
                    redirect('productmanage');
                }
            }

     fclose($file); 
     exit(); 
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
}