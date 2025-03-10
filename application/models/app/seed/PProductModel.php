<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * pesticide Private Product Model
 */
class PProductModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;
    private $cid;
    public function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'publicproduct';
        // Set orderable column fields
        $this->column_order = array('p_name', 'p_code', 'itemcategory', 'api_sent');
        // Set searchable column fields
        $this->column_search = array('p_name', 'p_code', 'itemcategory', 'api_sent');
        
        // Set default order
        $this->order = array('createdon' => 'desc');
    }

    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'1', 'applicationid'=>'SD'));
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

       
    /*
     * Count all records
     */
    public function countAll(){
        $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'1', 'applicationid'=>'SD'));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'1', 'applicationid'=>'SD'));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
        $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'1', 'applicationid'=>'SD'));
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

    //get item category
    function getItemCategory(){
        $itmcat=$this->db->where(array('status'=>'1', 'applicationid'=>'ps'))->order_by("itemcategoryname", "asc")->get('itemcategory'); 
        return $itmcat;
    }

    //get item subcategory
    function getItemSubCat($catid){
        $itmscat=$this->db->where(array('itemcategoryid' => $catid, 'status'=>'1', 'applicationid'=>'ps'))->order_by("subcategoryname", "asc")->get('itemsubcategory'); 
        return $itmscat;
    }

    //get item
    function getItem($subcatid){
        $itms=$this->db->where(array('subcategoryid' => $subcatid, 'status'=>'1', 'applicationid'=>'ps'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }
    
    function getItems($subcatid, $itmid){
        $itms=$this->db->where(array('subcategoryid' => $subcatid, 'itemid' => $itmid, 'status'=>'1', 'applicationid'=>'ps'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }

    //get unit of measurment
    function getUomid(){
        $uom=$this->db->order_by("uomname", "asc")->get('unitofmeasurements'); 
        return $uom;
    }

    //get item
    function getUomids($itmid,$subitmid){
        $itms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'ps'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }

    //get item
    function getNWs($itmid,$subitmid){
        $nitms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'ps'))->order_by("itemname", "asc")->get('subitem'); 
        return $nitms;
    }

    //get unit of measurment
    function getNW($itid,$suid){
        $nw=$this->db->order_by("nwname", "asc")->where(array('status'=>'1'))->get('net_weight'); 
        return $nw;
    }
    
    function pshowupc(){ 
        $value2 = '';
        $inv = 'SYN'."000";
        $invno = $this->db->select('p_code')
                ->from('publicproduct')
                ->get();
        foreach($invno->result() AS $row){
            $value2 = $row->p_code;            
        }
        if($inv <= $value2){
            $value2 = substr($value2, 3, 6);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = 'SYN'. sprintf('%03s', $value2);//concatenating incremented value
            $newID = $value2; 
        } else{
            $value2 = 'SYN'."001";
            $newID= $value2;
        }
        return $newID;
    }

    //   //UPC No generation
    //   function pshowupc(){ 
    //     $vendor_code = get_settings('vendor_code');
    //     $comcat = $_SESSION['comcat'];
    //     $comcat = sprintf('%02s', $comcat);   
    //     $comid = $_SESSION['comid'];
    //     $comid = sprintf('%03s', $comid);         
    //     $value2 = '';
    //     $inv = 'syn001';
                
    //     $invno=$this->db->query("select p_code from pesticideproduct where c_id=? and p_code not like '180089%' order by p_code desc", $_SESSION['comid']);
    //     $result=$invno->row();
                
    //     if($result){
    //         $value2 = $result->p_code;  
    //         $value2 = substr($value2, 3, 6);//separating numeric part
    //         $value2 = $value2 + 1;//Incrementing numeric part
    //         $value2 = 'syn'.sprintf('%03s', $value2);//concatenating incremented value
    //         $newID = $value2; 
    //     }else{
    //         $value2 = 'syn001';
    //         $newID= $value2;
    //     }        
       
    //     $upcVal = $this->checkUpc($newID);
    //     if($upcVal == '0'){
    //          return $newID;
    //     }else{
    //         return $upcVal;
    //     }
       
    // }
    
    // public function checkUpc($newID){
    //     $upc = $this->db->select('p_code')
    //     ->from('pesticideproduct')
    //     ->where('p_code',$newID)
    //     ->get();        
    //     if($upc->num_rows > 0){
    //         $newID = $newID +1;
    //     }else{
    //         $newID = '0';
    //     }
    //     return $newID;
    // }

    

    function addPProduct(){
        $cid = $this->input->post('cid');
        $appid = 'SD';
        $cname = $this->input->post('cname');
        $marketed_by = $this->input->post('marketed_by');
        $catid = '0';        
        $catname = $this->input->post('p_category');
        $scatid = '0';        
        $scatname = $this->input->post('sub_category');
        $p_code = $this->input->post('p_code');
        $pid = '0';        
        $pname = $this->input->post('p_name');
        $b_name = $this->input->post('b_name');
        // $unit_w = explode('|', $this->input->post('unit_w'));        
        $uomid = '0';        
        $uomw = $this->input->post('unit_w');        
        $net_w = $this->input->post('net_w');
        if($this->input->post('onlyprimary')!='on'){
            $onlyprimary = '0';
        }else{
            $onlyprimary = '1';
        }
        $image = '';
        if(isset($_FILES["leaflet"]["type"]))
        {
            
            $temporary = explode(".", $_FILES["leaflet"]["name"]);
            $file_extension = end($temporary);       
                    
            $sourcePath = $_FILES['leaflet']['tmp_name']; //Store source path in a variable
            $targetPath = "uploads/" . $_FILES['leaflet']['name']; // The Target path where file is to be stored
            
            move_uploaded_file($sourcePath,$targetPath); // Moving Uploaded file
                // The Image Data
            $image = $_FILES['leaflet']['name'];
            // echo $image; exit();
            $formulation = $this->input->post('formulation');
            $cibno = $this->input->post('cibno');
            $mlno = $this->input->post('mlno');
            $chemcom = $this->input->post('chemcom');
            $antst = $this->input->post('antst');
            $dou = $this->input->post('dou');
            $recom = $this->input->post('recom');
            $warst = $this->input->post('warst');
            $prec = $this->input->post('prec');
            $cs = $this->input->post('cs');
            $stdins = $this->input->post('stdins');
            $status = "1";
            // $upcexist = $this->db->select('count(p_code) as upccount')->from('publicproduct')->where('p_code', $p_code)->get();
            // foreach($upcexist->result() as $urow){
            //     if($urow->upccount > 0){
            //         $upc = $this->db->select('MAX(p_code) as upc')->from('publicproduct')->get();
            //         foreach($upc->result() as $row){
            //             $upcs = $row->upc;
            //         }
            //         $p_code = $upcs+1;
            //     }else{
            //         $p_code = $p_code;
            //     }
            // }
            
            $data=array('c_id'=>$cid, 'name'=>$cname, 'applicationid'=>$appid, 'marketed_by'=>$marketed_by, 
            'itemcategoryid'=>$catid, '	itemcategory'=>$catname, 'subcategoryid'=>$scatid, 'subcategory'=>$scatname, 
            'p_code'=>$p_code, 'itemid'=>$pid, 'p_name'=>$pname, 'b_name'=>$b_name, 'unit_w'=>$uomw, 
            'uomid'=>$uomid,'net_w'=>$net_w, 'formulation'=>$formulation, 'cibno'=>$cibno, 'mlno'=>$mlno, 'caution'=>$cs,'status'=>$status,
            'api_sent'=>'0', 'api_response'=>'', 'onlyprimary'=>$onlyprimary, 'is_private'=>'1');
    
            // Insert the data
            $result = $this->db->insert('publicproduct',$data);
            
            $insert_id = $this->db->insert_id();
            $datapi = array('pid'=>$insert_id, 'pname'=>$pname, 'cid'=>$cid, 'dou'=>$dou, 'recom'=>$recom, 'antst'=>$antst, 
            'chemcom'=>$chemcom, 'warst'=>$warst, 'prec'=>$prec, 'stdins'=>$stdins,'leaflet'=>$image);
            $results = $this->db->insert('productinfo',$datapi);
            
            if($result && $results){
                $output['success'] = true;
                $output['messages'] = 'Successfully added!';  
            }
            else{
                $output['success'] = false;
                $output['messages'] = 'Ooops! something went wrong';
            }
            return $output;
        }
    }

    //get product info
    function getPrdinfo(){
        $id=$this->input->post('member_id');
        $pinfo = $this->db->select('id, c_id, name, applicationid, marketed_by, itemcategoryid, 
        itemcategory, subcategoryid, subcategory, p_code, itemid, p_name, b_name, unit_w, 
        uomid, net_w, formulation, cibno, mlno')
                ->from('publicproduct')->where(array('id'=> $id, 'c_id' => $_SESSION['comid']))->get();
        return $pinfo->row_array(); 
    }
    
    public function getProduct($c_id){
        //$c_id = '54';
        $this->db->select('*');
        $this->db->where('api_sent','0');
        $this->db->where('status','1');
        //$this->db->where('id','341');
        $this->db->where('c_id',$c_id);
        $this->db->from('publicproduct');
        return $this->db->get()->result();
    }
    
    public function update_product_api($id){
        $data = array('api_sent'=>'1');
        $this->db->where('id',$id);
        $this->db->update('publicproduct',$data);
    }
    
    public function update_api_response($id,$response){
        $data = array('api_response'=> $response);
        $this->db->where('id',$id);
        $this->db->update('publicproduct',$data);
    }
}