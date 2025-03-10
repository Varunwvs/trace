<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Micro Irrigation Product Model
 */
class ProductModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'tarpaulinproduct';
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
            $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'0'));
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

       
    /*
     * Count all records
     */
    public function countAll(){
        $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'0'));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'0'));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
        $this->db->where(array('c_id'=>$_SESSION['comid'],'status'=>'1','is_private'=>'0'));
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
        $itmcat=$this->db->where(array('status'=>'1', 'applicationid'=>'ap'))->order_by("itemcategoryname", "asc")->get('itemcategory'); 
        return $itmcat;
    }

    //get item subcategory
    function getItemSubCat($catid){
        $itmscat=$this->db->where(array('itemcategoryid' => $catid, 'status'=>'1', 'applicationid'=>'ap'))->order_by("subcategoryname", "asc")->get('itemsubcategory'); 
        return $itmscat;
    }

    //get item
    function getItem($subcatid){
        $itms=$this->db->where(array('subcategoryid' => $subcatid, 'status'=>'1', 'applicationid'=>'ap'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }
    
    function getItems($subcatid, $itmid){
        $itms=$this->db->where(array('subcategoryid' => $subcatid, 'itemid' => $itmid, 'status'=>'1', 'applicationid'=>'ap'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }

    //get unit of measurment
    function getUomid(){
        $uom=$this->db->order_by("uomname", "asc")->get('unitofmeasurements'); 
        return $uom;
    }

    //get item
    function getUomids($itmid,$subitmid){
        $itms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'ap'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }

    //get item
    function getNWs($itmid,$subitmid){
        $nitms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'ap'))->order_by("itemname", "asc")->get('subitem'); 
        return $nitms;
    }

    //get unit of measurment
    function getNW($itid,$suid){
        $nw=$this->db->order_by("nwname", "asc")->where(array('status'=>'1'))->get('net_weight'); 
        return $nw;
    }

      //UPC No generation
      function showupc(){ 
        $vendor_code = get_settings('vendor_code');
        $comcat = $_SESSION['comcat'];
        $comcat = sprintf('%02s', $comcat);   
        $comid = $_SESSION['comid'];
        $comid = sprintf('%04s', $comid);         
        $value2 = '';
        $inv = '18'.$vendor_code.$comcat.$comid."0000";
                
        $invno=$this->db->query("select p_code from tarpaulinproduct where c_id=? and p_code not like '180089%' order by p_code desc", $_SESSION['comid']);
        $result=$invno->row();
                
        if($result){
            $value2 = $result->p_code;  
            $value2 = substr($value2, 10, 14);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = '18'.$vendor_code.$comcat.$comid. sprintf('%04s', $value2);//concatenating incremented value
            $newID = $value2; 
        }else{
            $value2 = '18'.$vendor_code.$comcat.$comid."0001";
            $newID= $value2;
        }        
       
        $upcVal = $this->checkUpc($newID);
        if($upcVal == '0'){
             return $newID;
        }else{
            return $upcVal;
        }
       
    }
    
    public function checkUpc($newID){
        $upc = $this->db->select('p_code')
        ->from('tarpaulinproduct')
        ->where('p_code',$newID)
        ->get();        
        if($upc->num_rows > 0){
            $newID = $newID +1;
        }else{
            $newID = '0';
        }
        return $newID;
    }

    function addProduct(){
        $cid = $this->input->post('cid');
        $appid = $this->input->post('appid');
        $cname = $this->input->post('cname');
        $marketed_by = $this->input->post('marketed_by');
        $p_category = explode('|', $this->input->post('p_category'));
        $catid = $p_category[0];        
        $catname = $p_category[1];
        $sub_category = explode('|', $this->input->post('sub_category'));
        $scatid = $sub_category[0];        
        $scatname = $sub_category[1];
        $p_code = $this->input->post('p_code');
        $p_name = explode('|', $this->input->post('p_name'));
        $pid = $p_name[0];        
        $pname = $p_name[1];
        $b_name = $this->input->post('b_name');
        // $unit_w = explode('|', $this->input->post('unit_w'));        
        $uomid = $this->input->post('uomid');        
        $uomw = $this->input->post('uomw');        
        $net_w = $this->input->post('net_w');
        if($this->input->post('onlyprimary')!='on'){
            $onlyprimary = '0';
        }else{
            $onlyprimary = '1';
        }
        $cml = $this->input->post('cml');
        $cmlbis = $this->input->post('cmlbis');
        $licno = $this->input->post('licno');
        $gsm = $this->input->post('gsm');
        $status = "1";
        $upcexist = $this->db->select('count(p_code) as upccount')->from('tarpaulinproduct')->where('p_code', $p_code)->get();
        foreach($upcexist->result() as $urow){
            if($urow->upccount > 0){
                $upc = $this->db->select('MAX(p_code) as upc')->from('tarpaulinproduct')->get();
                foreach($upc->result() as $row){
                    $upcs = $row->upc;
                }
                $p_code = $upcs+1;
            }else{
                $p_code = $p_code;
            }
        }
        
        $data=array('c_id'=>$cid, 'name'=>$cname, 'applicationid'=>$appid, 'marketed_by'=>$marketed_by, 
        'itemcategoryid'=>$catid, '	itemcategory'=>$catname, 'subcategoryid'=>$scatid, 'subcategory'=>$scatname, 
        'p_code'=>$p_code, 'itemid'=>$pid, 'p_name'=>$pname, 'b_name'=>$b_name, 'unit_w'=>$uomw, 
        'uomid'=>$uomid,'net_w'=>$net_w, 'cml'=>$cml, 'cmlbis'=>$cmlbis, 'licno'=>$licno,'gsm'=>$gsm,'status'=>$status,
        'api_sent'=>'0', 'api_response'=>'', 
        'onlyprimary'=>$onlyprimary);

        // Insert the data
        $result = $this->db->insert('tarpaulinproduct',$data);
        
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully added!';  
        }
        else{
            $output['success'] = false;
            $output['messages'] = 'Ooops! something went wrong';
        }
        return $output;
    }

    //get product info
    function getPrdinfo(){
        $id=$this->input->post('member_id');
        $pinfo = $this->db->select('id, c_id, name, applicationid, marketed_by, itemcategoryid, 
        itemcategory, subcategoryid, subcategory, p_code, itemid, p_name, b_name, unit_w, 
        uomid, net_w, cml, cmlbis, licno, gsm')
                ->from('tarpaulinproduct')->where(array('id'=> $id, 'c_id' => $_SESSION['comid']))->get();
        return $pinfo->row_array(); 
    }
    
    public function getProduct($c_id){
        //$c_id = '54';
        $this->db->select('*');
        $this->db->where('api_sent','0');
        $this->db->where('status','1');
        //$this->db->where('id','341');
        $this->db->where('c_id',$c_id);
        $this->db->from('tarpaulinproduct');
        return $this->db->get()->result();
    }
    
    public function update_product_api($id){
        $data = array('api_sent'=>'1');
        $this->db->where('id',$id);
        $this->db->update('tarpaulinproduct',$data);
    }
    
    public function update_api_response($id,$response){
        $data = array('api_response'=> $response);
        $this->db->where('id',$id);
        $this->db->update('tarpaulinproduct',$data);
    }
    
     //Datatable View
    function dtlyProduct(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $adminrole = $_SESSION['role'];
        $admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';
        $cinfo = $this->db->select('id as cid')->from('users')->where('role',$admin)->get();
        foreach($cinfo->result() as $crow){
            $cid=$crow->cid;
        }
        if($_SESSION['role']!=$center){
            $exp=$this->db->select('id, c_id, itemcategory, p_code, p_name, api_sent,onlyprimary')
            ->from('tarpaulinproduct')->where(array('c_id'=>$_SESSION['comid'], 'status'=>'1'))
            ->order_by("p_code", "asc")
            ->get();
        }else{
            $exp=$this->db->select('id, c_id, itemcategory, p_code, p_name, api_sent,onlyprimary')
            ->from('tarpaulinproduct')->where(array('c_id'=>$cid, 'status'=>'1'))
            ->order_by("p_code", "asc")
            ->get();
        }
        
        $i=1;
        $output=[];
        $dis="";
        $msg="";
        foreach ($exp->result() as $row) {            
            if($row->onlyprimary==='1'){
                $pinfo = '<span class="right badge badge-success">Primary</span>';
            }else{
                $pinfo = '<span class="right badge badge-warning">Secondary</span>';
            }
            $binfo = $this->db->select('*')->from('tarpaulinbatch2324')->where(array('pid'=> $row->id, 'c_id'=>$_SESSION['comid']))->get();
            $bcount = $binfo->num_rows();
            if($bcount !=0){
                $bc = '<span class="right badge badge-success">'.$bcount.'</span>';
            }else{
                $bc = '<span class="right badge badge-warning">'.$bcount.'</span>';
            }
            
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="tlyproductview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>               
              </ul>';

            $output[] = array(
                $i++, 
                '<strong>'.ucwords($row->p_name).'</strong><sup> '.$pinfo.' '.$bc.'</sup>', 
                $row->p_code,       
                ucwords($row->itemcategory),
                $actionButton
            ); 
        } 
        $result = array(
               "draw" => $draw,
                 "recordsTotal" => $exp->num_rows(),
                 "recordsFiltered" => $exp->num_rows(),
                 "data" => $output
            );
        return $result;  
        exit();
    }
}