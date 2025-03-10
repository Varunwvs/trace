<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pharma Model
 */
class PharmaModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    function get_product_details(){
        $product_code=$this->input->post('product_code');

        $prod = $this->db->select('brand_name as Brand Name,product_name as Generic name of the drug,uid,unique_product_code as Unique product identification code,manufacturer_details as Name and address of manufacturer,
        batch_no as Batch / Lot number,dom as Date of manufaturing,expire_date as Date of expiry,license_no as Manufacturing license number,product_image')
        ->from('pharmaproducts')
        ->where('unique_product_code',$product_code)
        ->get();

        return $prod->row(); 
    }



  



    
}