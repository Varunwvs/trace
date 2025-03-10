<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Model
 */
class ProductModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    //Datatable View
    function dtProduct(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        if($_SESSION['comcat']==='1'){
            $exp=$this->db->select('id, c_id, name, marketed_by, p_category, sub_category, p_code, p_name, b_name, unit_w, net_w, status, api_sent')
         ->from('seedproduct')->where(array('c_id'=>$_SESSION['comid'], 'status'=>'1'))
         ->order_by("p_code", "asc")
         ->get();
        }
        elseif($_SESSION['comcat']==='3'){
            $exp=$this->db->select('id, c_id, name, applicationid, marketed_by, itemcategoryid, itemcategory, subcategoryid, subcategory, p_code, itemid, p_name, b_name, unit_w, uomid, net_w, cml, cmlbis, licno, status, api_sent, api_response, onlyprimary')
         ->from('microirrigationproduct')->where(array('c_id'=>$_SESSION['comid'], 'status'=>'1'))
         ->order_by("p_code", "asc")
         ->get();
        }else{
            $exp='';
        }
        $i=1;
        $output=[];
        $status = '';
        $cat = '';
        $msg="";
        // echo $this->db->last_query();exit();
        foreach ($exp->result() as $row) {
            if($row->api_sent!=0){
                $dis = "hidden";
            }else{
                $dis = "";
            }
            if($_SESSION['comcat']==='1'){
                $cat = $row->p_category;
            }
            elseif($_SESSION['comcat']==='3'){
                $cat = $row->itemcategory;
            }else{
                $cat='';
            }
            if($row->api_sent==="1"){
                $msg = "<span class='text-sm text-success'>Api sent successfully</span>";
            }else{$msg="<span class='text-sm text-danger'>Api not sent</span>";}
            $actionButton = '
              <ul class="list-inline"> 
                <li class="list-inline-item"><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View company details" onclick="viewMember('.$row->id.')"> <span class="fa-regular fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="admin_edit_product?id='.$row->id.'" data-toggle="tooltip" title="Edit Product"> <span class="fa fa-edit"></span></a></li>
                <li class="list-inline-item d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="admin_delete_product" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Product"> <span class="fa fa-trash"></span></a></li>
                <li>'.$msg.'</li>
              </ul>';

            $output[] = array(
                $i++, 
                '<strong>'.ucwords($row->p_name).'</strong>', 
                $row->p_code,       
                ucwords($cat),
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
    
    //get item category
    function getItemCategory(){
        $itmcat=$this->db->where(array('status'=>'1', 'applicationid'=>'sd'))->order_by("itemcategoryname", "asc")->get('itemcategory'); 
        return $itmcat;
    }

    //get Seed Class
    function getSeedclass(){
        $seedc=$this->db->where(array('status'=>'1'))->order_by("classname", "asc")->get('seedclass'); 
        return $seedc;
    }

    //get item subcategory
    function getItemSubCat($catid){
        $itmscat=$this->db->where(array('itemcategoryid' => $catid, 'status'=>'1', 'applicationid'=>'sd'))->order_by("subcategoryname", "asc")->get('itemsubcategory'); 
        return $itmscat;
    }

    //get item
    function getItem($subcatid){
        $itms=$this->db->where(array('subcategoryid' => $subcatid, 'status'=>'1', 'applicationid'=>'sd'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }

    //get item
    function getUomids($itmid,$subitmid){
        $itms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'sd'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }

    //get item
    function getNWs($itmid,$subitmid){
        $nitms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'sd'))->order_by("itemname", "asc")->get('subitem'); 
        return $nitms;
    }

    //get unit of measurment
    function getNW($itid,$suid){
        $nw=$this->db->order_by("nwname", "asc")->where(array('status'=>'1'))->get('net_weight'); 
        return $nw;
    }
    
    function showupc(){ 
        $vendor_code = get_settings('vendor_code');
        $vendor_code = sprintf('%04s', $vendor_code);
        $comid = $_SESSION['comid'];
        $comid = sprintf('%04s', $comid);
        $value2 = '';
        $inv = '18'.$vendor_code.$comid."0000";
        
        /*$invno = $this->db->select_max('p_code')
                ->from('seedproduct')
                ->where('c_id', $_SESSION['comid'])
                ->where('p_code not like',)
                ->get(); */
                
        $invno=$this->db->query("select p_code from seedproduct where c_id=? and p_code not like '180089%' order by p_code desc", $_SESSION['comid']);
        $result=$invno->row();
                
        if($result){
            //foreach($invno->result() AS $row){
                
                $value2 = $result->p_code;            
            //}
        //if($inv <= $value2){
            $value2 = substr($value2, 10, 14);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = '18'.$vendor_code.$comid. sprintf('%04s', $value2);//concatenating incremented value
            $newID = $value2; 
        // } else{
        //     $value2 = '18'.$vendor_code.$comid."0001";
        //     $newID= $value2;
        // }
        }else{
            $value2 = '18'.$vendor_code.$comid."0001";
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
        ->from('seedproduct')
        ->where('p_code',$newID)
        ->get();
        
        if($upc->num_rows > 0){
            $newID = $newID +1;
        }else{
            $newID = '0';
        }
        return $newID;
    }

    function getUomid(){
        $uom=$this->db->order_by("uomname", "asc")->get('unitofmeasurements'); 
        return $uom;
    }

    //Add New Products
    function addProduct(){
        $cid = $this->input->post('cid');
        $cname = $this->input->post('cname');
        $marketed_by = $this->input->post('marketed_by');
        $p_category = $this->input->post('p_category');
        $sub_category = $this->input->post('sub_category');
        $p_code = $this->input->post('p_code');
        $p_name = $this->input->post('p_name');
        $b_name = $this->input->post('b_name');
        $unit_w = explode('|', $this->input->post('unit_w'));        
        $uomid = $unit_w[0];        
        $uomw = $unit_w[1];
        $net_w = $this->input->post('net_w');
        if($this->input->post('onlyprimary')!='on'){
            $onlyprimary = '0';
        }else{
            $onlyprimary = '1';
        }
        $prdlink = $this->input->post('prdlink');
        if($this->input->post('mrp')!=''){
            $mrp = $this->input->post('mrp');
        }else{
            $mrp = '0.00';
        }
        if($this->input->post('germination')!=''){
            $germination = $this->input->post('germination');
        }else{
            $germination = '0.00';
        }
        if($this->input->post('phypurity')!=''){
            $phypurity = $this->input->post('phypurity');
        }else{
            $phypurity = '0.00';
        }
        if($this->input->post('moisture')!=''){
            $moisture = $this->input->post('moisture');
        }else{
            $moisture = '0.00';
        }
        if($this->input->post('inertmatter')!=''){
            $inertmatter = $this->input->post('inertmatter');
        }else{
            $inertmatter = '0.00';
        }
        if($this->input->post('othercrop')!=''){
            $othercrop = $this->input->post('othercrop');
        }else{
            $othercrop = '0.00';
        }
        $status = "1";
        $datat=array('c_id'=>$cid, 'name'=>$cname, 'marketed_by'=>$marketed_by, 'p_category'=>$p_category, 
        'sub_category'=>$sub_category, 'p_code'=>$p_code, 'p_name'=>$p_name, 'b_name'=>$b_name, 'unit_w'=>$uomw, 
        'uomid'=>$uomid,'net_w'=>$net_w,'mrp'=>$mrp, 'germination'=>$germination, 'phypurity'=>$phypurity, 
        'moisture'=>$moisture, 'inertmatter'=>$inertmatter, 'othercrop'=>$othercrop,'prdlink'=>$prdlink,
        'status'=>$status,'api_sent'=>'0', 'api_response'=>'', 'onlyprimary'=>$onlyprimary);

        // Insert the data
        $result = $this->db->insert('seedproduct',$datat);

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

    function getPrdinfo(){
        $id=$this->input->post('member_id');
        $pinfo = $this->db->select('id, c_id, name, marketed_by, p_category, sub_category, p_code, p_name, b_name, 
                unit_w, uomid, net_w,mrp, germination, phypurity, moisture, inertmatter, othercrop,prdlink,onlyprimary')
                ->from('seedproduct')->where(array('id'=> $id, 'c_id' => $_SESSION['comid']))->get();
        return $pinfo->row_array(); 
    }

    //Delete Products
    function delProduct(){
        $id=$this->input->post('member_id');
        $data = array('status'=>'0');
        $result = $this->db->update('seedproduct',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Removed Product';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing Product!';
        }

        return($output);
    }

    //Edit Product
    function editProduct(){
        $id=$this->input->post('edit_pid');
        $edit_cid = $this->input->post('edit_cid');
        $edit_cname = $this->input->post('edit_cname');
        $edit_marketed_by = $this->input->post('edit_marketed_by');
        $edit_p_category = $this->input->post('edit_p_category');
        $edit_sub_category = $this->input->post('edit_sub_category');
        $edit_p_code = $this->input->post('edit_p_code');
        $edit_p_name = $this->input->post('edit_p_name');
        $edit_b_name = $this->input->post('edit_b_name');
        $edit_unit_w = explode('|', $this->input->post('edit_unit_w'));        
        $edit_uomid = $edit_unit_w[0];        
        $edit_uomw = $edit_unit_w[1];
        $edit_net_w = $this->input->post('edit_net_w');
        $edit_prdlink = $this->input->post('edit_prdlink');
        if($this->input->post('edit_onlyprimary')==='0'){
            $edit_onlyprimary = '1';
        }else{
            $edit_onlyprimary = '0';
        }
        if($this->input->post('edit_mrp')!=''){
            $edit_mrp = $this->input->post('edit_mrp');
        }else{
            $edit_mrp = '0.00';
        }
        if($this->input->post('edit_germination')!=''){
            $edit_germination = $this->input->post('edit_germination');
        }else{
            $edit_germination = '0.00';
        }
        if($this->input->post('edit_phypurity')!=''){
            $edit_phypurity = $this->input->post('edit_phypurity');
        }else{
            $edit_phypurity = '0.00';
        }
        if($this->input->post('edit_moisture')!=''){
            $edit_moisture = $this->input->post('edit_moisture');
        }else{
            $edit_moisture = '0.00';
        }
        if($this->input->post('edit_inertmatter')!=''){
            $edit_inertmatter = $this->input->post('edit_inertmatter');
        }else{
            $edit_inertmatter = '0.00';
        }
        if($this->input->post('edit_othercrop')!=''){
            $edit_othercrop = $this->input->post('edit_othercrop');
        }else{
            $edit_othercrop = '0.00';
        }
        $data = array('name'=>$edit_cname, 'marketed_by'=>$edit_marketed_by, 'p_category'=>$edit_p_category, 
        'sub_category'=>$edit_sub_category, 'p_name'=>$edit_p_name, 'b_name'=>$edit_b_name, 'unit_w'=>$edit_uomw, 'uomid'=>$edit_uomid, 'net_w'=>$edit_net_w, 'mrp'=>$edit_mrp, 'germination'=>$edit_germination, 'phypurity'=>$edit_phypurity, 
        'moisture'=>$edit_moisture, 'inertmatter'=>$edit_inertmatter, 'othercrop'=>$edit_othercrop,'prdlink'=>$edit_prdlink, 'onlyprimary'=>$edit_onlyprimary);
        
        $result = $this->db->update('seedproduct',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated Product';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating Product';  
        }        
        return $output;
    }    
    
    public function getProduct($c_id){
        $this->db->select('*');
        $this->db->where('api_sent','0');
        $this->db->where('c_id',$c_id);
        $this->db->from('seedproduct');
        return $this->db->get()->result();
    }
        
    public function update_product_api($id){
        $data = array('api_sent'=>'1');
        $this->db->where('id',$id);
        $this->db->update('seedproduct',$data);
    }
    
    //get item category
    // function getItemCategory(){
    //     $itmcat=$this->db->where(array('status'=>'1', 'applicationid'=>'mi'))->order_by("itemcategoryname", "asc")->get('itemcategory'); 
    //     return $itmcat;
    // }

    //get item subcategory
    // function getItemSubCat($catid){
    //     $itmscat=$this->db->where(array('itemcategoryid' => $catid, 'status'=>'1', 'applicationid'=>'mi'))->order_by("subcategoryname", "asc")->get('itemsubcategory'); 
    //     return $itmscat;
    // }

    //get item
    // function getItem($subcatid){
    //     $itms=$this->db->where(array('subcategoryid' => $subcatid, 'status'=>'1', 'applicationid'=>'mi'))->order_by("itemname", "asc")->get('subitem'); 
    //     return $itms;
    // }
    
    function getItems($subcatid, $itmid){
        $itms=$this->db->where(array('subcategoryid' => $subcatid, 'itemid' => $itmid, 'status'=>'1', 'applicationid'=>'mi'))->order_by("itemname", "asc")->get('subitem'); 
        return $itms;
    }

    //get item
    // function getUomids($itmid,$subitmid){
    //     $itms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'mi'))->order_by("itemname", "asc")->get('subitem'); 
    //     return $itms;
    // }

    //get item
    // function getNWs($itmid,$subitmid){
    //     $nitms=$this->db->where(array('itemid' => $itmid, 'subcategoryid'=>$subitmid, 'status'=>'1', 'applicationid'=>'mi'))->order_by("itemname", "asc")->get('subitem'); 
    //     return $nitms;
    // }

    //get unit of measurment
    // function getNW($itid,$suid){
    //     $nw=$this->db->order_by("nwname", "asc")->where(array('status'=>'1'))->get('net_weight'); 
    //     return $nw;
    // }

      //UPC No generation
      function showupcmi(){ 
        $vendor_code = get_settings('vendor_code');
        $comcat = $_SESSION['comcat'];
        $comcat = sprintf('%02s', $comcat);   
        $comid = $_SESSION['comid'];
        $comid = sprintf('%04s', $comid);         
        $value2 = '';
        $inv = '18'.$vendor_code.$comcat.$comid."0000";
                
        $invno=$this->db->query("select p_code from microirrigationproduct where c_id=? and p_code not like '180089%' order by p_code desc", $_SESSION['comid']);
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
    
    public function checkUpcmi($newID){
        $upc = $this->db->select('p_code')
        ->from('microirrigationproduct')
        ->where('p_code',$newID)
        ->get();        
        if($upc->num_rows > 0){
            $newID = $newID +1;
        }else{
            $newID = '0';
        }
        return $newID;
    }
    
    function addProductmi(){
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
        $status = "1";
        $upcexist = $this->db->select('count(p_code) as upccount')->from('microirrigationproduct')->where('p_code', $p_code)->get();
        foreach($upcexist->result() as $urow){
            if($urow->upccount > 0){
                $upc = $this->db->select('MAX(p_code) as upc')->from('microirrigationproduct')->get();
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
        'uomid'=>$uomid,'net_w'=>$net_w, 'cml'=>$cml, 'cmlbis'=>$cmlbis, 'licno'=>$licno,'status'=>$status,
        'api_sent'=>'0', 'api_response'=>'', 
        'onlyprimary'=>$onlyprimary);

        // Insert the data
        $result = $this->db->insert('microirrigationproduct',$data);
        
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


  


}