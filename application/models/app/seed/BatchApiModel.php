<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BatchApiModel
 */
class BatchApiModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        
    } 

    public function add_batch_data($batch_data,$center_id,$admin_id) {
        $results = [];

        foreach ($batch_data as $data) {
            $product = $this->db->select('id')
                ->where('p_code', $data['product_code'])
                ->where('c_id', $admin_id)
                ->get('seedproduct')
                ->row_array();
    
            if (!$product) {
                $results[] = [
                    'success' => false,
                    'message' => 'Product not found for code: ' . $data['product_code'],
                    'aliasCodes' => []
                ];
                continue;
            }

            $company = $this->db->select('id')
            ->where(array('id'=>$center_id))
            ->get('users')
            ->row_array();

            if (!$company) {
                $results[] = [
                    'success' => false,
                    'message' => 'Center code  not found for '. $data['centre_code'],
                    'aliasCodes' => []
                ];
                continue;
            }
    
            $pid = $product['id'];
            $cid = $company['id'];
            $upc = $data['product_code'];
            $batch_no = $data['batch_number'];
            $s_no = $data['quantity'];
            $mfg_date = $data['mfg_date'];
            $exp_date = $data['exp_date'];
    
            $result = $this->addBatch($pid, $cid, $upc, $batch_no, $s_no, $mfg_date, $exp_date);
            $results[] = $result;
        }
        return $results;
    }
    


    function addBatch($pid,$cid,$upc,$batch_no,$s_no,$mfg_date,$exp_date){
        $this->db->trans_start();
    
        $status = "1";
        $count = $s_no;
        // $result = '';
        $data = array('c_id'=>$cid, 'pid'=>$pid, 'p_code'=>$upc, 'batch_no'=>$batch_no, 's_no_qty'=>$s_no, 
        'mfd_date'=>$mfg_date, 'exp_date'=>$exp_date, 'status'=>$status);

        $result = $this->db->insert('seedbatch',$data);
        $insert_id = $this->db->insert_id();

        $srno = "18";

        $vendor_code = get_settings('vendor_code');
        $primary_identifier = get_settings('primary_identifier');
        
        $datat=array();
        $alias_codes = [];
        $max_alias = $this->get_maxalias();

        for($x = 1; $x <= $count; $x++) {            
            $alias = $max_alias + 1;
            $cid = sprintf("%04d", $cid);
            $pid = sprintf("%04d", $pid);
            $bid = sprintf("%04d", $insert_id);
            $x = sprintf("%04d", $x);
            $y = $srno.$cid.$pid.$bid.$x;

           $alias_no=$primary_identifier.$vendor_code.$alias;
	    //prepare array to insert
            $datat[]=array('batch_id'=>$insert_id, 'serialno'=>$y, 'cid'=>$cid,'alias' => $alias);

            $alias_codes[] = ['aliasCode' =>$alias_no];//to return alias


            $y++;
            $max_alias++;
        }

        if($datat){
        // Insert the data in batch
        $results = $this->db->insert_batch('seedbatchserial',$datat);

        }
        $this->db->trans_complete();
          if ($this->db->trans_status() === FALSE) {
                return [
                    'success' => false,
                    'message' => 'Oops! Something went wrong',
                    'aliasCodes' => []
                ];
            } else {
                return [
                    'success' => true,
                    'message' => 'Successfully added!',
                    'aliasCodes' => $alias_codes
                ];
            }
        
    }

    public function get_maxalias(){
        $this->db->select_max('alias');
        $this->db->from('seedbatchserial');
        $res = $this->db->get()->row();
        return $res->alias;
     }

     public function get_center_id_by_code($centreCode)
{
    return $this->db->select('id')
        ->from('users')
        ->where('LOWER(name)', strtolower($centreCode))
        ->get()
        ->row('id'); // Return only the ID
}

}