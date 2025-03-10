<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api Model
 */
class ApiModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    public function update_Itemdetails($response){
        // $data = json_decode($response, true);  
        $data = json_decode($response, true);
        // var_dump($data);              
        $itid = $this->db->select('*')->from('subitem')->get();
        // $itmid = array();
        $data3= '';
        foreach($itid->result_array() as $row){
            $itmid[] = array(
                'ApplicationID' => $row['applicationid'],
                'ItemCategoryID' => (int)$row['itemcategoryid'],
                'SubCategoryID' => (int)$row['subcategoryid'],
                'ItemID' => (int)$row['itemid'],
                'ItemName' => $row['itemname'],
                'PacketSize' => (float)$row['packetsize'],
                'UomID' => (int)$row['UomID'],
                'Status' => (int)$row['status'],
            );
        }        

        $array_diff = $this->check_diff_multi($data, $itmid);
        
        foreach($array_diff as $key=>$value)
        {
            // print_r($contact);die();
            $data = array(
                'applicationid' => $value['ApplicationID'],
                'itemcategoryid' => $value['ItemCategoryID'],
                'subcategoryid' => $value['SubCategoryID'],
                'itemid' => $value['ItemID'],
                'itemname' => $value['ItemName'],
                'packetsize' => $value['PacketSize'],
                'UomID' => $value['UomID'],
                'status' => $value['Status'],
            ); 

            $this->db->insert('subitem', $data);
        }   

        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;
    }   
    
    public function update_Itemsubcat($response){
        $subdata = json_decode($response, true);
        // var_dump($subdata);            
        $sitid = $this->db->select('*')->from('itemsubcategory')->get();
        // $itmid = array();
        $data3= '';
        foreach($sitid->result_array() as $row){
            $subitmid[] = array(
                'ApplicationID' => $row['applicationid'],
                'ItemCategoryID' => (int)$row['itemcategoryid'],
                'SubCategoryID' => (int)$row['subcategoryid'],
                'SubCategoryName' => $row['subcategoryname'],
                'Status' => (int)$row['status'],
            );
        }        
        // print_r($subitmid);die();
        $array_diff = $this->check_diff_multi($subdata, $subitmid);
        
        foreach($array_diff as $key=>$value)
        {
            
            $data = array(
                'applicationid' => $value['ApplicationID'],
                'itemcategoryid' => $value['ItemCategoryID'],
                'subcategoryid' => $value['SubCategoryID'],
                'subcategoryname' => $value['SubCategoryName'],
                'status' => $value['Status'],
            ); 

            $this->db->insert('itemsubcategory', $data);
        }   

        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;
    }  

    function check_diff_multi($array1, $array2){
        $result = [];
        foreach($array1 as $key => $val) {
            if(array_key_exists($key, $array2)){
                if(is_array($val) || is_array($array2[$key])) {
                    if (false === is_array($val) || false === is_array($array2[$key])) {
                        $result[$key] = $val;
                    } else {
                        $result[$key] = $this->check_diff_multi($val, $array2[$key]);
                        if (sizeof($result[$key]) === 0) {
                            unset($result[$key]);
                        }
                    }
                }
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
    }
}
