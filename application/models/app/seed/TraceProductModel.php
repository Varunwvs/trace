<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product Model
 */
class TraceProductModel extends CI_Model
{
    private $table;
    private $column_order;
    private $column_search;
    private $order;
    private $cid;
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
        // Set table name
        $this->table = 'seedproduct';
        // Set orderable column fields
        $this->column_order = array('p_name', 'p_code');
        // Set searchable column fields
        $this->column_search = array('p_name', 'p_code');
        // Set default order
        $this->order = array('created_at' => 'desc');
        $adminrole = $_SESSION['role'];
        $admin=substr($adminrole, 0, -6).'admin';
        $center=substr($adminrole, 0, -6).'center';
        $this->cid=$_SESSION['comid'];
        $cinfo = $this->db->select('id as cid')->from('users')->where('role',$admin)->get();
        foreach($cinfo->result() as $crow){
            if($crow->cid !=''){
                $this->cid=$crow->cid;
            }
        }
    }
    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){
        $this->_get_datatables_query($postData);        
        if($postData['length'] != -1){
            $this->db->where(array('c_id'=>$this->cid,'status'=>'1'));
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

       
    /*
     * Count all records
     */
    public function countAll(){
        $this->db->where(array('c_id'=>$this->cid,'status'=>'1'));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $this->db->where(array('c_id'=>$this->cid,'status'=>'1','is_trace'=>1));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
        $this->db->where(array('c_id'=>$this->cid,'status'=>'1','is_trace'=>1));
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
    public function add_products($data){
        if ($this->db->insert_batch('seedproduct', $data)) {
            return true;
        }
        return false;
    }
    
     public function update_upc($max_upc){
        $data = array('value' => $max_upc);
        $this->db->where('name','max_upc');
        $result = $this->db->update('settings',$data);
    }  
    
    //get item category
    function getSourcingCategory(){
        $itmcat=$this->db->where(array('c_id'=>$_SESSION['comid'], 'applicationid'=>'sd','category_type'=>'Product'))->order_by("name", "asc")->get('sourcing_category'); 
        return $itmcat;
    }

    //get Seed Class
    function getSeedclass(){
        $seedc=$this->db->order_by("scname", "asc")->get('seedclass'); 
        return $seedc;
    }

    //get item subcategory
    function getSourcingSubCat($catid){
        $itmscat=$this->db->where(array('category_id' => $catid, 'c_id'=>$_SESSION['comid'], 'applicationid'=>'sd'))->order_by("sub_name", "asc")->get('sourcing_sub_category'); 
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

      //UPC No generation
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

        $appid = "SD";
        $trace= 1;
        $cid = $this->input->post('cid');
        $mfg_id = $this->input->post('mfg_id');
        $cname = $this->input->post('cname');
        $marketed_by = $this->input->post('marketed_by');
        $p_category = explode('|', $this->input->post('p_category'));
        $catid = isset($p_category[0]) ? $p_category[0] : null;        
        $catname = isset($p_category[1]) ? $p_category[1] : null;
        
        $sub_category = explode('|', $this->input->post('sub_category'));
        $scatid = isset($sub_category[0]) ? $sub_category[0] : null;        
        $scatname = isset($sub_category[1]) ? $sub_category[1] : null;
        
        $uom = explode('|', $this->input->post('uom'));
        $uomid = isset($uom[0]) ? $uom[0] : null;        
        $uomw = isset($uom[1]) ? $uom[1] : null;
        
        $pc_name = explode('|', $this->input->post('pc_name'));
        $scid = isset($pc_name[0]) ? $pc_name[0] : null;
        $scname = isset($pc_name[1]) ? $pc_name[1] : null;
        $p_code = $this->input->post('p_code');
        $p_name = explode('|', $this->input->post('p_name'));
        $pid = $p_name[0]; 
        
        $prod_description = $this->input->post('prod_description');


        $p_name=$this->input->post('p_name');

        if($scid!=0){
            $pname = $p_name.' '.$scname;
        }else{
            $pname = $p_name;
        }
       
        $b_name = $this->input->post('b_name');
             
        $net_w = $this->input->post('net_w');
        if($this->input->post('onlyprimary')!='on'){
            $onlyprimary = '0';
        }else{
            $onlyprimary = '1';
        }
        $prdlink = $this->input->post('prdlink');
        $mrp = $this->input->post('mrp') ?: '0.00';
        $phypurity = $this->input->post('phypurity') ?: '0.00';
        $germination = $this->input->post('germination') ?: '0.00';
        $genpur = $this->input->post('genpur') ?: '0.00';
        $moisture = $this->input->post('moisture') ?: '0.00';
        $inertmatter = $this->input->post('inertmatter') ?: '0.00';
        $othercrop = $this->input->post('othercrop') ?: '0.00';
        $weedseed = $this->input->post('weedseed') ?: 'none';


        $registration_no = $this->input->post('registration_no');
        $prd_leaflet = $this->input->post('prd_leaflet');
        $prd_video = $this->input->post('prd_video');
        $usage_instructions = $this->input->post('usage_instructions');

        $image = null;
        $blkind = $this->input->post('blkind');
        $blvariety = $this->input->post('blvariety');
        $blseedclass = $this->input->post('blseedclass');
        // Handle file uploads for image
        if(isset($_FILES["blsign"]["type"]) && !empty($_FILES["blsign"]["tmp_name"])) {
            $image = $this->uploadFile('blsign', 'uploads/blimg/');
            if(!$image) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

        

        $gi_checkbox = ($this->input->post('gi_checkbox') == 'on') ? 1 : 0;
       
         //if checkbox is checked take values otherwise null
        $gi_description = $gi_checkbox ? $this->input->post('gi_description') : null;
        $gi_geographical_area = $gi_checkbox ? $this->input->post('gi_geographical_area') : null;
        $gi_latitude = $gi_checkbox ? $this->input->post('gi_latitude') : null;
        $gi_longitude = $gi_checkbox ? $this->input->post('gi_longitude') : null;
        $gi_product_specifications = $gi_checkbox ? $this->input->post('gi_product_specifications') : null;
        $gi_packed_date = $gi_checkbox ? date('Y-m-d', strtotime($this->input->post('gi_packed_date'))): null;
        $gi_expire_date = $gi_checkbox ? date('Y-m-d', strtotime($this->input->post('gi_expire_date'))) : null;
        $gi_processing_facility = $gi_checkbox ? $this->input->post('gi_processing_facility') : null;
        $gi_origin_country = $gi_checkbox ? $this->input->post('gi_origin_country') : null;
        $gi_fssai_license_no = $gi_checkbox ? $this->input->post('gi_fssai_license_no') : null;

        $gi_source_info=null;
        $gi_authorities_certificate=null;
        if(isset($_FILES["gi_source_info"]["type"]) && !empty($_FILES["gi_source_info"]["tmp_name"])) {
            $gi_source_info = $this->uploadFile('gi_source_info', 'uploads/gi_source_info/');
            if(!$gi_source_info) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }
        if(isset($_FILES["gi_authorities_certificate"]["type"]) && !empty($_FILES["gi_authorities_certificate"]["tmp_name"])) {
            $gi_authorities_certificate = $this->uploadFile('gi_authorities_certificate', 'uploads/gi_authorities_certificate/');
            if(!$gi_authorities_certificate) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

        $fssai_checkbox = ($this->input->post('fssai_checkbox') == 'on') ? 1 : 0;

        $fs_license_no = $fssai_checkbox ? $this->input->post('fs_license_no') : null;
        $fs_allergens = $fssai_checkbox ? $this->input->post('fs_allergens') : null;
        $fs_allergen_warning = $fssai_checkbox ? $this->input->post('fs_allergen_warning') : null;
        $fs_ingredients=null;
        $fs_nutri_info=null;

        if(isset($_FILES["fs_ingredients"]["type"]) && !empty($_FILES["fs_ingredients"]["tmp_name"])) {
            $fs_ingredients = $this->uploadFile('fs_ingredients', 'uploads/fs_ingredients/');
            if(!$fs_ingredients) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }
        if(isset($_FILES["fs_nutri_info"]["type"]) && !empty($_FILES["fs_nutri_info"]["tmp_name"])) {
            $fs_nutri_info = $this->uploadFile('fs_nutri_info', 'uploads/fs_nutri_info/');
            if(!$fs_nutri_info) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

        // US FDA Checkbox Handling
        $usfda_checkbox = ($this->input->post('usfda_checkbox') == 'on') ? 1 : 0;

        $us_fda_no = $usfda_checkbox ? $this->input->post('us_fda_no') : null;
        $us_allergens = $usfda_checkbox ? $this->input->post('us_allergens') : null;
        $us_allergen_warning = $usfda_checkbox ? $this->input->post('us_allergen_warning') : null;
        $us_storage_info = $usfda_checkbox ? $this->input->post('us_storage_info') : null;
        $us_ingredients =  null;
        $us_nutri_info =  null;

        if(isset($_FILES["us_ingredients"]["type"]) && !empty($_FILES["us_ingredients"]["tmp_name"])) {
            $us_ingredients = $this->uploadFile('us_ingredients', 'uploads/us_ingredients/');
            if(!$us_ingredients) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }
        if(isset($_FILES["us_nutri_info"]["type"]) && !empty($_FILES["us_nutri_info"]["tmp_name"])) {
            $us_nutri_info = $this->uploadFile('us_nutri_info', 'uploads/us_nutri_info/');
            if(!$us_nutri_info) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }




        $status = "1";
        $upcexist = $this->db->select('count(p_code) as upccount')->from('seedproduct')->where('p_code', $p_code)->get();
        foreach($upcexist->result() as $urow){
            if($urow->upccount > 0){
                $upc = $this->db->select('MAX(p_code) as upc')->from('seedproduct')->get();
                foreach($upc->result() as $row){
                    $upcs = $row->upc;
                }
                $p_code = $upcs+1;
            }else{
                $p_code = $p_code;
            }
        }
        $datat=array('applicationid'=>$appid, 'c_id'=>$cid, 'mfg_id'=>$mfg_id, 'name'=>$cname, 'marketed_by'=>$marketed_by, 
        'catid' =>$catid, 'p_category'=>$catname, 'subcatid'=>$scatid, 'sub_category'=>$scatname, 
        'p_code'=>$p_code, 'itemid'=>$pid, 'itemclassid'=>$scid, 'itemclassname'=>$scname,'p_name'=>$pname, 'b_name'=>$b_name, 'unit_w'=>$uomw, 
        'uomid'=>$uomid,'net_w'=>$net_w,'mrp'=>$mrp, 'germination'=>$germination, 'phypurity'=>$phypurity, 
        'moisture'=>$moisture, 'inertmatter'=>$inertmatter, 'othercrop'=>$othercrop, 'genpur'=>$genpur, 'weedseed'=>$weedseed,
        'prdlink'=>$prdlink,  'prod_description'=>$prod_description,
        'status'=>$status,'api_sent'=>'0', 'api_response'=>'', 'onlyprimary'=>$onlyprimary,
        'blkind'=>$blkind,
        'blvariety'=>$blvariety,
        'blseedclass'=>$blseedclass,
        'blsign'=>$image,
        'registration_no'=>$registration_no,
        'prd_leaflet'=>$prd_leaflet,
        'prd_video'=>$prd_video,
        'usage_instructions'=>$usage_instructions,
        'gi_checkbox'=>$gi_checkbox,
        'gi_description' => $gi_description,
        'gi_geographical_area' => $gi_geographical_area,
        'gi_latitude' => $gi_latitude,
        'gi_longitude' => $gi_longitude,
        'gi_product_specifications' => $gi_product_specifications,
        'gi_packed_date' => $gi_packed_date,
        'gi_expire_date' => $gi_expire_date,
        'gi_processing_facility' => $gi_processing_facility,
        'gi_origin_country' => $gi_origin_country,
        'gi_authorities_certificate'=>$gi_authorities_certificate,
        'gi_source_info'=>$gi_source_info,
        'gi_fssai_license_no'=>$gi_fssai_license_no,
        'fssai_checkbox' => $fssai_checkbox,
        'fs_license_no' => $fs_license_no,
        'fs_ingredients' => $fs_ingredients,
        'fs_nutri_info' => $fs_nutri_info,
        'fs_allergens' => $fs_allergens,
        'fs_allergen_warning' => $fs_allergen_warning,
        'usfda_checkbox' => $usfda_checkbox,
        'us_fda_no' => $us_fda_no,
        'us_ingredients' => $us_ingredients,
        'us_nutri_info' => $us_nutri_info,
        'us_allergens' => $us_allergens,
        'us_allergen_warning' => $us_allergen_warning,
        'us_storage_info' => $us_storage_info,
        'is_trace'=>$trace

        


        );
        // print_r($datat);die();
        // Insert the data
        $result = $this->db->insert('seedproduct',$datat);
        // echo $this->db->last_query();die();
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully added!';  
        }
        else{
            $db_error = $this->db->error();
            $output['success'] = false;
            $output['messages'] = 'Database error: ' . $db_error['message'];
        }
        return $output;
    }

    function uploadFile($fileInputName, $targetDirectory) {
        $targetPath = $targetDirectory . basename($_FILES[$fileInputName]["name"]);
        $fileExtension = strtolower(pathinfo($targetPath,PATHINFO_EXTENSION));
        $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
    
        $targetPath = $targetDirectory . $newFileName;
    
        if(move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetPath)) {
            return $newFileName;
        } else {
            return false;
        }
    }

    //Delete Products
    function delProduct(){
        $id=$this->input->post('member_id');
        $cid = $_SESSION['comid'];        

        //for product
        $data = array('status'=>'0');
        $result = $this->db->update('seedproduct',$data,array('id'=>$id,'c_id'=>$cid));
        $results = $this->db->update('seedbatch',$data,array('pid'=>$id,'c_id'=>$cid));
        if($result && $results){
            $output['success'] = true;
            $output['messages'] = 'Successfully Removed Product';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing Product!';
        }

        return($output);
    }

    //get product info
    function getPrdinfo(){
        $id=$this->input->post('member_id');
        $pinfo = $this->db->select('*')
                ->from('seedproduct')->where(array('id'=> $id, 'c_id' => $_SESSION['comid'],'is_trace'=>1))->get();
        return $pinfo->row_array(); 
    }

    //Edit Product
    function editProduct(){
        $id=$this->input->post('edit_pid');
        $edit_cid = $this->input->post('edit_cid');
        $edit_cname = $this->input->post('edit_cname');
        $edit_marketed_by = $this->input->post('edit_marketed_by');
       

        $edit_p_category = explode('|', $this->input->post('edit_p_category'));
        $catid = isset($edit_p_category[0]) ? $edit_p_category[0] : null;        
        $catname = isset($edit_p_category[1]) ? $edit_p_category[1] : null;
        
        $edit_sub_category = explode('|', $this->input->post('edit_sub_category'));
        $scatid = isset($edit_sub_category[0]) ? $edit_sub_category[0] : null;        
        $scatname = isset($edit_sub_category[1]) ? $edit_sub_category[1] : null;

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

        $prod_description = $this->input->post('edit_prod_description');
        $registration_no = $this->input->post('edit_registration_no');
        $prd_leaflet = $this->input->post('edit_prd_leaflet');
        $prd_video = $this->input->post('edit_prd_video');
        $usage_instructions = $this->input->post('edit_usage_instructions');

        $image = null;
        $blkind = $this->input->post('edit_blkind');
        $blvariety = $this->input->post('edit_blvariety');
        $blseedclass = $this->input->post('edit_blseedclass');


        $blsign = $this->input->post('blsign');

        // Handle file uploads for image
        if(isset($_FILES["edit_blsign"]["type"]) && !empty($_FILES["edit_blsign"]["tmp_name"])) {

            if (!empty($blsign) && file_exists('uploads/blimg/' . $blsign)) {
                unlink('uploads/blimg/' . $blsign);
            }

            $image = $this->uploadFile('edit_blsign', 'uploads/blimg/');
            if(!$image) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }else{
            $image =$blsign;
        }

        

        $gi_checkbox = ($this->input->post('edit_gi_checkbox') == 'on') ? 1 : 0;
       
         //if checkbox is checked take values otherwise null
        $gi_description = $gi_checkbox ? $this->input->post('edit_gi_description') : null;
        $gi_geographical_area = $gi_checkbox ? $this->input->post('edit_gi_geographical_area') : null;
        $gi_latitude = $gi_checkbox ? $this->input->post('edit_gi_latitude') : null;
        $gi_longitude = $gi_checkbox ? $this->input->post('edit_gi_longitude') : null;
        $gi_product_specifications = $gi_checkbox ? $this->input->post('edit_gi_product_specifications') : null;
        $gi_packed_date = $gi_checkbox ? date('Y-m-d', strtotime($this->input->post('edit_gi_packed_date'))): null;
        $gi_expire_date = $gi_checkbox ? date('Y-m-d', strtotime($this->input->post('edit_gi_expire_date'))) : null;
        $gi_processing_facility = $gi_checkbox ? $this->input->post('edit_gi_processing_facility') : null;
        $gi_origin_country = $gi_checkbox ? $this->input->post('edit_gi_origin_country') : null;
        $gi_fssai_license_no = $gi_checkbox ? $this->input->post('edit_gi_fssai_license_no') : null;

        $gi_source_info=$this->input->post('gi_source_info');
        $gi_authorities_certificate=$this->input->post('gi_authorities_certificate');

        if(isset($_FILES["edit_gi_source_info"]["type"]) && !empty($_FILES["edit_gi_source_info"]["tmp_name"])) {

            if (!empty($gi_source_info) && file_exists('uploads/gi_source_info/' . $gi_source_info)) {
                unlink('uploads/gi_source_info/' . $gi_source_info);
            }

            $gi_source_info = $this->uploadFile('edit_gi_source_info', 'uploads/gi_source_info/');
            if(!$gi_source_info) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

        if(isset($_FILES["edit_gi_authorities_certificate"]["type"]) && !empty($_FILES["edit_gi_authorities_certificate"]["tmp_name"])) {
           
            if (!empty($gi_authorities_certificate) && file_exists('uploads/gi_authorities_certificate/' . $gi_authorities_certificate)) {
                unlink('uploads/gi_authorities_certificate/' . $gi_authorities_certificate);
            }

            $gi_authorities_certificate = $this->uploadFile('edit_gi_authorities_certificate', 'uploads/gi_authorities_certificate/');
            if(!$gi_authorities_certificate) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

        $fssai_checkbox = ($this->input->post('edit_fssai_checkbox') == 'on') ? 1 : 0;

        $fs_license_no = $fssai_checkbox ? $this->input->post('edit_fs_license_no') : null;
        $fs_allergens = $fssai_checkbox ? $this->input->post('edit_fs_allergens') : null;
        $fs_allergen_warning = $fssai_checkbox ? $this->input->post('edit_fs_allergen_warning') : null;
        $fs_ingredients=$this->input->post('fs_ingredients');
        $fs_nutri_info=$this->input->post('fs_nutri_info');

        if(isset($_FILES["edit_fs_ingredients"]["type"]) && !empty($_FILES["edit_fs_ingredients"]["tmp_name"])) {

            if (!empty($fs_ingredients) && file_exists('uploads/fs_ingredients/' . $fs_ingredients)) {
                unlink('uploads/fs_ingredients/' . $fs_ingredients);
            }

            $fs_ingredients = $this->uploadFile('edit_fs_ingredients', 'uploads/fs_ingredients/');
            if(!$fs_ingredients) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }
        if(isset($_FILES["edit_fs_nutri_info"]["type"]) && !empty($_FILES["edit_fs_nutri_info"]["tmp_name"])) {
            if (!empty($fs_nutri_info) && file_exists('uploads/fs_nutri_info/' . $fs_nutri_info)) {
                unlink('uploads/fs_nutri_info/' . $fs_nutri_info);
            }

            $fs_nutri_info = $this->uploadFile('edit_fs_nutri_info', 'uploads/fs_nutri_info/');
            if(!$fs_nutri_info) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

        // US FDA Checkbox Handling
        $usfda_checkbox = ($this->input->post('edit_usfda_checkbox') == 'on') ? 1 : 0;

        $us_fda_no = $usfda_checkbox ? $this->input->post('edit_us_fda_no') : null;
        $us_allergens = $usfda_checkbox ? $this->input->post('edit_us_allergens') : null;
        $us_allergen_warning = $usfda_checkbox ? $this->input->post('edit_us_allergen_warning') : null;
        $us_storage_info = $usfda_checkbox ? $this->input->post('edit_us_storage_info') : null;
        $us_ingredients=$this->input->post('us_ingredients');
        $us_nutri_info=$this->input->post('us_nutri_info');

        if(isset($_FILES["edit_us_ingredients"]["type"]) && !empty($_FILES["edit_us_ingredients"]["tmp_name"])) {

            if (!empty($us_ingredients) && file_exists('uploads/us_ingredients/' . $us_ingredients)) {
                unlink('uploads/us_ingredients/' . $us_ingredients);
            }

            $us_ingredients = $this->uploadFile('edit_us_ingredients', 'uploads/us_ingredients/');
            if(!$us_ingredients) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }
        if(isset($_FILES["edit_us_nutri_info"]["type"]) && !empty($_FILES["edit_us_nutri_info"]["tmp_name"])) {

            if (!empty($us_nutri_info) && file_exists('uploads/us_nutri_info/' . $us_nutri_info)) {
                unlink('uploads/us_nutri_info/' . $us_nutri_info);
            }

            $us_nutri_info = $this->uploadFile('edit_us_nutri_info', 'uploads/us_nutri_info/');
            if(!$us_nutri_info) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }


        $data = array('name'=>$edit_cname,'marketed_by'=>$edit_marketed_by, 'catid' =>$catid, 'p_category'=>$catname, 'subcatid'=>$scatid, 'sub_category'=>$scatname, 'p_name'=>$edit_p_name, 'b_name'=>$edit_b_name, 
        'unit_w'=>$edit_uomw, 'uomid'=>$edit_uomid, 'net_w'=>$edit_net_w, 'mrp'=>$edit_mrp, 
        'germination'=>$edit_germination, 'phypurity'=>$edit_phypurity, 
        'moisture'=>$edit_moisture, 'inertmatter'=>$edit_inertmatter, 'othercrop'=>$edit_othercrop,
        'prdlink'=>$edit_prdlink, 'onlyprimary'=>$edit_onlyprimary,
        'prod_description'=>$prod_description,
        'blkind'=>$blkind,
        'blvariety'=>$blvariety,
        'blseedclass'=>$blseedclass,
        'blsign'=>$image,
        'registration_no'=>$registration_no,
        'prd_leaflet'=>$prd_leaflet,
        'prd_video'=>$prd_video,
        'usage_instructions'=>$usage_instructions,
        'gi_checkbox'=>$gi_checkbox,
        'gi_description' => $gi_description,
        'gi_geographical_area' => $gi_geographical_area,
        'gi_latitude' => $gi_latitude,
        'gi_longitude' => $gi_longitude,
        'gi_product_specifications' => $gi_product_specifications,
        'gi_packed_date' => $gi_packed_date,
        'gi_expire_date' => $gi_expire_date,
        'gi_processing_facility' => $gi_processing_facility,
        'gi_origin_country' => $gi_origin_country,
        'gi_authorities_certificate'=>$gi_authorities_certificate,
        'gi_source_info'=>$gi_source_info,
        'gi_fssai_license_no'=>$gi_fssai_license_no,
        'fssai_checkbox' => $fssai_checkbox,
        'fs_license_no' => $fs_license_no,
        'fs_ingredients' => $fs_ingredients,
        'fs_nutri_info' => $fs_nutri_info,
        'fs_allergens' => $fs_allergens,
        'fs_allergen_warning' => $fs_allergen_warning,
        'usfda_checkbox' => $usfda_checkbox,
        'us_fda_no' => $us_fda_no,
        'us_ingredients' => $us_ingredients,
        'us_nutri_info' => $us_nutri_info,
        'us_allergens' => $us_allergens,
        'us_allergen_warning' => $us_allergen_warning,
        'us_storage_info' => $us_storage_info   
    
    );
        $result = $this->db->update('seedproduct',$data,array('id'=>$id));
        // echo $this->db->last_query();
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
        //$c_id = '54';
        $this->db->select('*');
        $this->db->where('api_sent','0');
        $this->db->where('status','1');
        //$this->db->where('id','341');
        $this->db->where('c_id',$c_id);
        $this->db->from('seedproduct');
        return $this->db->get()->result();
    }
    
    public function getSProduct($c_id,$pid){
        $this->db->select('*');
        $this->db->where('api_sent','0');
        $this->db->where('status','1');
        //$this->db->where('id','341');
        $this->db->where(array('c_id'=>$c_id,'id'=>$pid));
        $this->db->from('seedproduct');
        return $this->db->get()->result();
    }

    public function getUSProduct($c_id,$pid){
        $this->db->select('*');
        $this->db->where('status','1');
        //$this->db->where('id','341');
        $this->db->where(array('c_id'=>$c_id,'id'=>$pid));
        $this->db->from('seedproduct');
        return $this->db->get()->result();
    }
        
         public function update_product_api($id){
             $data = array('api_sent'=>'1');
            $this->db->where('id',$id);
            $this->db->update('seedproduct',$data);
        }
        
        public function update_api_response($id,$response){
            $data = array('api_response'=> $response);
            $this->db->where('id',$id);
            $this->db->update('seedproduct',$data);
        }

        public function update_uapi_response($id,$response){
            $data = array('api_response'=> $response,'updapi'=>'1');
            $this->db->where('id',$id);
            $this->db->update('seedproduct',$data);
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
            $exp=$this->db->select('id, c_id, p_category, p_code, p_name, api_sent,onlyprimary')
            ->from('seedproduct')->where(array('c_id'=>$_SESSION['comid'], 'status'=>'1'))
            ->order_by("p_code", "asc")
            ->get();
        }else{
            $exp=$this->db->select('id, c_id, p_category, p_code, p_name, api_sent,onlyprimary')
            ->from('seedproduct')->where(array('c_id'=>$cid, 'status'=>'1'))
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
            $binfo = $this->db->select('*')->from('seedbatch2324')->where(array('pid'=> $row->id, 'c_id'=>$_SESSION['comid']))->get();
            $bcount = $binfo->num_rows();
            if($bcount !=0){
                $bc = '<span class="right badge badge-success">'.$bcount.'</span>';
            }else{
                $bc = '<span class="right badge badge-warning">'.$bcount.'</span>';
            }
            
            $actionButton = '
              <ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="lyproductview?id='.$row->id.'"> <span class="fa fa-eye"></span></a></li>               
              </ul>';

            $output[] = array(
                $i++, 
                '<strong>'.ucwords($row->p_name).'</strong><sup> '.$pinfo.' '.$bc.'</sup>', 
                $row->p_code,       
                ucwords($row->p_category),
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

    public function get_products(){
     
            $this->db->select('id,p_name')->from('seedproduct')->where(array('c_id'=>$this->cid,'status'=>'1','is_trace'=>1));
            return $this->db->get()->result();
        
    }

    public function get_unit_of_measurements(){
        $this->db->select('uomid,uomname')->from('unitofmeasurements')->where('uomid!=',0);
        return $this->db->get()->result();
    }

   

   

    







}