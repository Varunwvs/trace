<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * pesticide Private Primary Serial Model
 */
class PPrimaryserialModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'publicbatchserial';
        // Set orderable column fields
        $this->column_order = array('sbsid', 'batch_id', 'serialno', 'cid', 'api_sent', 'alias', 'ucc_id', 'api_response');
        // Set searchable column fields
        $this->column_search = array('sbsid', 'batch_id', 'serialno', 'cid', 'api_sent', 'alias', 'ucc_id', 'api_response');        
        // Set default order
        $this->order = array('serialno' => 'asc');
    }

    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){        
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->where(array('cid'=>$_SESSION['comid'], 'batch_id'=>$postData['bid']));
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
       
    /*
     * Count all records
     */
    public function countAll($postData){
        $this->db->where(array('cid'=>$_SESSION['comid'], 'batch_id'=>$postData['bid']));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('cid'=>$_SESSION['comid'],'batch_id'=>$postData['bid']));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
        $this->db->where(array('cid'=>$_SESSION['comid'],'batch_id'=>$postData['bid']));
        $this->db->from($this->table);
 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}