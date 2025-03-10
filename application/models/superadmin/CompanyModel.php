<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Company Model
 */
class CompanyModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $output = array('success' => false, 'messages' => array());
    }

    //Datatable View
    function dtCompany(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.category, u.city, u.state, u.pincode, u.address, u.role, 
        u.status, u.totalproduct, u.qr_quantity, c.name as catname, (select count(*) from seedproduct sp where sp.c_id=u.id) as pcount,
        (select count(*) from seedbatch sb where sb.c_id=u.id) as bcount')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where(array('u.role'=>'company', 'u.ulevel'=>'3', 'u.category'=>'1'))
         ->order_by('u.regon', 'desc')
         ->get();
        $i=1;
        $output=[];
        $status = '';
        $cat = '';
        
        foreach ($exp->result() as $row) {
            //status
            if($row->status==='0'){
                $status = '<span class="right badge badge-danger">Inactive</span>';
            }else{
                $status = '<span class="right badge badge-success">Active</span>';
            }
            //Category
            if($row->category==='1'){
                $cat = '<span class="right badge badge-info">Seeds</span>';
            }
            else{
                $cat = '';
            }
            $actionButton = '
              <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu" style="cursor: pointer;">
                <li class=" d-print-none"><a class="btn text-red btn-xs" role="button" id="update_status" data-id="'.$row->id.'" data-toggle="tooltip" title="Update Company Status"> <span class="fa-solid fa-right-left"></span> Update Company Status</a></li>
                <li class=" d-print-none"><a class="btn text-orange btn-xs" role="button" id="update_role" data-id="'.$row->id.'" data-toggle="tooltip" title="Change role"> <span class="fa-solid fa-tent-arrow-left-right"></span> Change Role</a></li>
                <li class=" d-print-none"><a class="btn text-purple btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editModal" data-toggle="tooltip" title="Increase total count" onclick="editMember('.$row->id.')"> <span class="fa-solid fa-arrow-up-right-dots"></span> Increase Total Product Count</a></li>
                <li class=""><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View company details" onclick="viewMember('.$row->id.')"> <span class="fa-regular fa-eye"></span> View Company Details</a></li>
                <li class=""><a class="btn text-info btn-xs" role="button" href="companyedit?id='.$row->id.'" data-toggle="tooltip" title="Update company details"> <span class="fa fa-edit"></span> Update Company Details</a></li>
                <li class=" d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="delete_company" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Company"> <span class="fa fa-trash"></span> Delete Company</a></li>
                <li class=" d-print-none"><a class="btn text-success btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editQr" data-toggle="tooltip" title="Update Qr Quantity" onclick="editQrcode('.$row->id.')"> <span class="fa-solid fa-qrcode"></span> Update QR Quantity</a></li>
            </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span><br /> QR-Quantity: '.$row->qr_quantity.'<br /> Total Product: '.$row->totalproduct.'', 
                '<span class="text-wrap">'.ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode.'</span>',       
                'Product : <strong>'.$row->pcount.'</strong><br> Batch : <strong>'.$row->bcount.'</strong> 
                <br><a class="btn text-info btn-xs" role="button" id="view_ciinfo" data-bs-toggle="modal" data-bs-target="#viewinfoModal" data-toggle="tooltip" title="View rc holder details" onclick="viewiMember('.$row->id.')"> <span class="fa-regular fa-eye"></span> View More</a>',
                $cat,
                $status,
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
    
    function dtFlcompany(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.category, u.city, u.state, u.pincode, u.address, u.role, 
        u.status, u.ulevel, u.totalproduct, u.qr_quantity, c.name as catname, (select count(*) from fertilizerproduct sp where sp.c_id=u.id) as pcount,
        (select count(*) from fertilizerbatch sb where sb.c_id=u.id) as bcount, (select count(*) from fertilizerbatchserial sbs 
        where sbs.cid=u.id) as prcount, (select count(*) from fertilizercontainer sbc where sbc.cid=u.id) as srcount')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where(array('u.role'=>'company', 'u.ulevel'=>'3'))
         ->group_start()
         ->or_where('u.category','2')
         ->or_where('u.category','6')
         ->group_end()
         ->order_by('u.regon', 'desc')
         ->get();
        //  echo $this->db->last_query();die();
        $i=1;
        $output=[];
        $status = '';
        $cat = '';
        foreach ($exp->result() as $row) {
            //status
            if($row->status==='0'){
                $status = '<span class="right badge badge-danger">Inactive</span>';
            }else{
                $status = '<span class="right badge badge-success">Active</span>';
            }
            //Category
            if($row->category==='1'){
                $cat = '<span class="right badge badge-info">Seeds</span>';
            }
            else{
                $cat = '';
            }
            $actionButton = '
              <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu" style="cursor: pointer;">
                <li class=" d-print-none"><a class="btn text-red btn-xs" role="button" id="update_status" data-id="'.$row->id.'" data-toggle="tooltip" title="Update Company Status"> <span class="fa-solid fa-right-left"></span> Update Company Status</a></li>
                <li class=" d-print-none"><a class="btn text-orange btn-xs" role="button" id="update_role" data-id="'.$row->id.'" data-toggle="tooltip" title="Change role"> <span class="fa-solid fa-tent-arrow-left-right"></span> Change Role</a></li>
                <li class=" d-print-none"><a class="btn text-purple btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editModal" data-toggle="tooltip" title="Increase total count" onclick="editMember('.$row->id.')"> <span class="fa-solid fa-arrow-up-right-dots"></span> Increase Total Product Count</a></li>
                <li class=""><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View company details" onclick="viewMember('.$row->id.')"> <span class="fa-regular fa-eye"></span> View Company Details</a></li>
                <li class=""><a class="btn text-info btn-xs" role="button" href="companyedit?id='.$row->id.'" data-toggle="tooltip" title="Update company details"> <span class="fa fa-edit"></span> Update Company Details</a></li>
                <li class=" d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="delete_company" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Company"> <span class="fa fa-trash"></span> Delete Company</a></li>
                <li class=" d-print-none"><a class="btn text-success btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editQr" data-toggle="tooltip" title="Update Qr Quantity" onclick="editQrcode('.$row->id.')"> <span class="fa-solid fa-qrcode"></span> Update QR Quantity</a></li>
            </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span> <br /> QR-Quantity: '.$row->qr_quantity.'<br /> Total Product: '.$row->totalproduct.'', 
                '<span class="text-wrap">'.ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode.'</span>',       
                'Product : <strong>'.$row->pcount.'</strong><br> Batch : <strong>'.$row->bcount.'</strong> 
                <br> Primary : <strong>'.$row->prcount.'</strong><br>Secondary : <strong>'.$row->srcount.'</strong>',
                $cat,
                $status,
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
    
    function dtPscompany(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.category, u.city, u.state, u.pincode, u.address, u.role, 
        u.status, u.ulevel, u.totalproduct, u.qr_quantity, c.name as catname, (select count(*) from pesticideproduct sp where sp.c_id=u.id) as pcount,
        (select count(*) from pesticidebatch sb where sb.c_id=u.id) as bcount, (select count(*) from pesticidebatchserial sbs 
        where sbs.cid=u.id) as prcount, (select count(*) from pesticidecontainer sbc where sbc.cid=u.id) as srcount')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where(array('u.role'=>'company', 'u.ulevel'=>'3'))
         ->group_start()
         ->or_where('u.category','5')
         ->group_end()
         ->order_by('u.regon', 'desc')
         ->get();
        //  echo $this->db->last_query();die();
        $i=1;
        $output=[];
        $status = '';
        $cat = '';
        foreach ($exp->result() as $row) {
            //status
            if($row->status==='0'){
                $status = '<span class="right badge badge-danger">Inactive</span>';
            }else{
                $status = '<span class="right badge badge-success">Active</span>';
            }
            //Category
            if($row->category==='5'){
                $cat = '<span class="right badge badge-info">Pesticide</span>';
            }
            else{
                $cat = '';
            }
            $actionButton = '
              <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu" style="cursor: pointer;">
                <li class=" d-print-none"><a class="btn text-red btn-xs" role="button" id="update_status" data-id="'.$row->id.'" data-toggle="tooltip" title="Update Company Status"> <span class="fa-solid fa-right-left"></span> Update Company Status</a></li>
                <li class=" d-print-none"><a class="btn text-orange btn-xs" role="button" id="update_role" data-id="'.$row->id.'" data-toggle="tooltip" title="Change role"> <span class="fa-solid fa-tent-arrow-left-right"></span> Change Role</a></li>
                <li class=" d-print-none"><a class="btn text-purple btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editModal" data-toggle="tooltip" title="Increase total count" onclick="editMember('.$row->id.')"> <span class="fa-solid fa-arrow-up-right-dots"></span> Increase Total Product Count</a></li>
                <li class=""><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View company details" onclick="viewMember('.$row->id.')"> <span class="fa-regular fa-eye"></span> View Company Details</a></li>
                <li class=""><a class="btn text-info btn-xs" role="button" href="companyedit?id='.$row->id.'" data-toggle="tooltip" title="Update company details"> <span class="fa fa-edit"></span> Update Company Details</a></li>
                <li class=" d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="delete_company" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Company"> <span class="fa fa-trash"></span> Delete Company</a></li>
                <li class=" d-print-none"><a class="btn text-success btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editQr" data-toggle="tooltip" title="Update Qr Quantity" onclick="editQrcode('.$row->id.')"> <span class="fa-solid fa-qrcode"></span> Update QR Quantity</a></li>
            </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span> <br /> QR-Quantity: '.$row->qr_quantity.'<br /> Total Product: '.$row->totalproduct.'', 
                '<span class="text-wrap">'.ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode.'</span>',       
                'Product : <strong>'.$row->pcount.'</strong><br> Batch : <strong>'.$row->bcount.'</strong> 
                <br> Primary : <strong>'.$row->prcount.'</strong><br>Secondary : <strong>'.$row->srcount.'</strong>',
                $cat,
                $status,
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
    
    function dtMicompany(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        // $exp=$this->db->select('u.id, u.name, u.category, u.city, u.state, u.pincode, u.address, u.role, 
        // u.status, u.ulevel, u.totalproduct, u.qr_quantity, c.name as catname, (select count(*) from microirrigationproduct sp where sp.c_id=u.id) as pcount,
        // (select count(*) from microirrigationbatch sb where sb.c_id=u.id) as bcount, (select count(*) from microirrigationbatchserial sbs 
        // where sbs.cid=u.id) as prcount, (select count(*) from microirrigationcontainer sbc where sbc.cid=u.id) as srcount')
        $exp=$this->db->select('u.id, u.name, u.category, u.city, u.state, u.pincode, u.address, u.role, 
        u.status, u.ulevel, u.totalproduct, u.qr_quantity, c.name as catname, (select count(*) from microirrigationproduct sp where sp.c_id=u.id) as pcount,
        (select count(*) from microirrigationbatch sb where sb.c_id=u.id) as bcount')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where(array('u.role'=>'company', 'u.ulevel'=>'3'))
         ->group_start()
         ->or_where('u.category','3')
         ->group_end()
         ->order_by('u.regon', 'desc')
         ->get();
        //  echo $this->db->last_query();die();
        $i=1;
        $output=[];
        $status = '';
        $cat = '';
        foreach ($exp->result() as $row) {
            //status
            if($row->status==='0'){
                $status = '<span class="right badge badge-danger">Inactive</span>';
            }else{
                $status = '<span class="right badge badge-success">Active</span>';
            }
            //Category
            if($row->category==='3'){
                $cat = '<span class="right badge badge-info">Microirrigation</span>';
            }
            else{
                $cat = '';
            }
            
            $actionButton = '
              <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu" style="cursor: pointer;">
                <li class=" d-print-none"><a class="btn text-red btn-xs" role="button" id="update_status" data-id="'.$row->id.'" data-toggle="tooltip" title="Update Company Status"> <span class="fa-solid fa-right-left"></span> Update Company Status</a></li>
                <li class=" d-print-none"><a class="btn text-orange btn-xs" role="button" id="update_role" data-id="'.$row->id.'" data-toggle="tooltip" title="Change role"> <span class="fa-solid fa-tent-arrow-left-right"></span> Change Role</a></li>
                <li class=" d-print-none"><a class="btn text-purple btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editModal" data-toggle="tooltip" title="Increase total count" onclick="editMember('.$row->id.')"> <span class="fa-solid fa-arrow-up-right-dots"></span> Increase Total Product Count</a></li>
                <li class=""><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View company details" onclick="viewMember('.$row->id.')"> <span class="fa-regular fa-eye"></span> View Company Details</a></li>
                <li class=""><a class="btn text-info btn-xs" role="button" href="companyedit?id='.$row->id.'" data-toggle="tooltip" title="Update company details"> <span class="fa fa-edit"></span> Update Company Details</a></li>
                <li class=" d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="delete_company" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Company"> <span class="fa fa-trash"></span> Delete Company</a></li>
                <li class=" d-print-none"><a class="btn text-success btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editQr" data-toggle="tooltip" title="Update Qr Quantity" onclick="editQrcode('.$row->id.')"> <span class="fa-solid fa-qrcode"></span> Update QR Quantity</a></li>
            </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span> <br /> QR-Quantity: '.$row->qr_quantity.'<br /> Total Product: '.$row->totalproduct.'', 
                '<span class="text-wrap">'.ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode.'</span>',       
                'Product : <strong>'.$row->pcount.'</strong><br> Batch : <strong>'.$row->bcount.'</strong>',
                $cat,
                $status,
                $actionButton
            ); 
//             <br> Primary : <strong>'.$row->prcount.'</strong><br>Secondary : <strong>'.$row->srcount.'</strong>
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
    
    function dtTpcompany(){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $exp=$this->db->select('u.id, u.name, u.category, u.city, u.state, u.pincode, u.address, u.role, 
        u.status, u.ulevel, u.totalproduct, u.qr_quantity, u.qr_quantity, c.name as catname, (select count(*) from microirrigationproduct sp where sp.c_id=u.id) as pcount,
        (select count(*) from microirrigationbatch sb where sb.c_id=u.id) as bcount, (select count(*) from microirrigationbatchserial sbs 
        where sbs.cid=u.id) as prcount, (select count(*) from microirrigationcontainer sbc where sbc.cid=u.id) as srcount')
         ->from('users u')
         ->join('categories c', 'c.id=u.category', 'left')
         ->where(array('u.role'=>'company', 'u.ulevel'=>'3'))
         ->group_start()
         ->or_where('u.category','7')
         ->group_end()
         ->order_by('u.regon', 'desc')
         ->get();
        //  echo $this->db->last_query();die();
        $i=1;
        $output=[];
        $status = '';
        $cat = '';
        foreach ($exp->result() as $row) {
            //status
            if($row->status==='0'){
                $status = '<span class="right badge badge-danger">Inactive</span>';
            }else{
                $status = '<span class="right badge badge-success">Active</span>';
            }
            //Category
            if($row->category==='3'){
                $cat = '<span class="right badge badge-info">Microirrigation</span>';
            }
            else{
                $cat = '';
            }
            $actionButton = '
              <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu" style="cursor: pointer;">
                <li class=" d-print-none"><a class="btn text-red btn-xs" role="button" id="update_status" data-id="'.$row->id.'" data-toggle="tooltip" title="Update Company Status"> <span class="fa-solid fa-right-left"></span> Update Company Status</a></li>
                <li class=" d-print-none"><a class="btn text-orange btn-xs" role="button" id="update_role" data-id="'.$row->id.'" data-toggle="tooltip" title="Change role"> <span class="fa-solid fa-tent-arrow-left-right"></span> Change Role</a></li>
                <li class=" d-print-none"><a class="btn text-purple btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editModal" data-toggle="tooltip" title="Increase total count" onclick="editMember('.$row->id.')"> <span class="fa-solid fa-arrow-up-right-dots"></span> Increase Total Product Count</a></li>
                <li class=""><a class="btn text-success btn-xs" role="button" id="view_cinfo" data-bs-toggle="modal" data-bs-target="#viewModal" data-toggle="tooltip" title="View company details" onclick="viewMember('.$row->id.')"> <span class="fa-regular fa-eye"></span> View Company Details</a></li>
                <li class=""><a class="btn text-info btn-xs" role="button" href="companyedit?id='.$row->id.'" data-toggle="tooltip" title="Update company details"> <span class="fa fa-edit"></span> Update Company Details</a></li>
                <li class=" d-print-none hidden"><a class="btn text-red btn-xs" role="button" id="delete_company" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete Company"> <span class="fa fa-trash"></span> Delete Company</a></li>
                <li class=" d-print-none"><a class="btn text-success btn-xs" role="button" id="update_total_count" data-bs-toggle="modal" data-bs-target="#editQr" data-toggle="tooltip" title="Update Qr Quantity" onclick="editQrcode('.$row->id.')"> <span class="fa-solid fa-qrcode"></span> Update QR Quantity</a></li>
            </ul>';

            $output[] = array(
                $i++, 
                '<span class="text-wrap"><strong>'.ucwords($row->name).'</strong></span> <br /> QR-Quantity: '.$row->qr_quantity.'<br /> Total Product: '.$row->totalproduct.'', 
                '<span class="text-wrap">'.ucwords($row->address).', '.ucwords($row->city).', '.ucwords($row->state).' - '.$row->pincode.'</span>',       
                'Product : <strong>'.$row->pcount.'</strong><br> Batch : <strong>'.$row->bcount.'</strong> 
                <br> Primary : <strong>'.$row->prcount.'</strong><br>Secondary : <strong>'.$row->srcount.'</strong>',
                $cat,
                $status,
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
    
    //Update Company public page
    function pubComstatus(){
        $id=$this->input->post('member_id');
        $public_page='1';
        $sinfo = $this->db->select('public_page')->from('users')->where('id', $id)->get();
        foreach($sinfo->result() as $row){
            $public_page = $row->public_page;
        }
        if($public_page==='1'){
            $public_page='0';
        }else{
            $public_page='1';
        }
        $data = array('public_page' => $public_page);
        $result = $this->db->update('users',$data,array('id'=>$id));
        // echo $this->db->last_query();
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully activated the public page';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while activating public page!';
        }

        return($output);
    }

    //Update Company Status
    function updComstatus(){
        $id=$this->input->post('member_id');
        $status='0';
        $sinfo = $this->db->select('status')->from('users')->where('id', $id)->get();
        foreach($sinfo->result() as $row){
            $status = $row->status;
        }
        if($status==='1'){
            $status='0';
        }else{
            $status='1';
        }
        $data = array('status' => $status);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully updated the status';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while updating status!';
        }

        return($output);
    }

    //Update Company Role
    function updComrole(){
        $id=$this->input->post('member_id');
        $role='rcholder';        
        $data = array('role' => $role);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully updated the role';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while updating role!';
        }

        return($output);
    }

    //get total product count
    function getTotalCount(){
        $id=$this->input->post('member_id');
        $gdoc=$this->db->get_where('users', array('id'=>$id));
        return $gdoc->row_array(); 
    }

    //Update total product count
    function incTotalcount(){
        $id=$this->input->post('member_id');
        $totalcount = $this->input->post('totalcount');
        $data = array('totalproduct' => $totalcount);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully updated total count';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating total count';  
        }        
        
        return $output;
    }
    
    //get total product count
    function getQrqty(){
        $id=$this->input->post('member_id');
        $gdoc=$this->db->get_where('users', array('id'=>$id));
        return $gdoc->row_array(); 
    }

    //Update total product count
    function incQrQuantity(){
        $id=$this->input->post('member_id');
        $qrquantity = $this->input->post('qrquantity');
        $data = array('qr_quantity' => $qrquantity);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully updated qr quantity';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating qr quantity';  
        }        
        
        return $output;
    }

    //get company info
    function getCominfo(){
        $id=$this->input->post('member_id');
        $cin = $this->db->select('u.id, u.name, u.category, u.gst, u.contact_person, u.email, 
        u.contact, u.city, u.state, u.pincode, u.address, u.password, u.totalproduct, u.website, c.name as catname')
        ->from('users u')->where(array('u.id'=>$id))->join('categories c', 'c.id=u.category', 'left')->get();
        return $cin->row_array(); 
    }
    
    //get company info
    function getComdinfo(){
        $cid=$this->input->post('member_id');
        $cin = $this->db->select('u.id, u.name, (select count(*) from seedproduct sp where sp.c_id=u.id) as pcount,
                                (select count(*) from seedbatch sb where sb.c_id=u.id) as bcount, 
                                (select count(*) from seedbatchserial sbs where sbs.cid=u.id) as prcount, 
                                (select count(*) from seedcontainer sbc where sbc.cid=u.id) as srcount')
         ->from('users u')->where('u.id', $cid)
         ->get();
        //  echo $this->db->last_query();
        return $cin->row_array(); 
    }

     //Delete Products
     function delCompany(){
        $id=$this->input->post('member_id');
        $this->db->where('id', $id);
        $result=$this->db->delete('users');
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Removed Company';
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error while removing Company!';
        }

        return($output);
    }

    function getCategory(){
        $depart=$this->db->order_by("name", "asc")->get('categories'); 
        return $depart;
    }

    function addCompany(){
        $cname = $this->input->post('cname');
        $category = $this->input->post('category');
        $contact_person = $this->input->post('contact_person');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $phone = $this->input->post('phone');
        $gst = $this->input->post('gst');
        $website = $this->input->post('website');
        $totalproduct = $this->input->post('totalproduct');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $pincode = $this->input->post('pincode');
        $address = $this->input->post('address');
        $status = '0';
        $role = 'company';
        $level = '3';

        $dataemailexists = $this->db->from('users')->where('email',$email)->get();
        $row = $dataemailexists->result();

        if($row !=false){
            $output['success'] = false;
            $output['messages'] = 'Email Id already exists! Please enter different email id';  
        }else{
            $datat=array('name'=>$cname, 'category'=>$category, 'gst'=>$gst, 'contact_person'=>$contact_person, 
            'email'=>$email, 'contact'=>$phone, 'city'=>$city, 'state'=>$state, 'pincode'=>$pincode, 
            'address'=>$address, 'password'=>$password, 'totalproduct'=>$totalproduct, 'role'=>$role, 'website'=>$website,'status'=>$status, 'ulevel'=>$level);

            // Insert the data
            $result = $this->db->insert('users',$datat);

            if($result){
                $output['success'] = true;
                $output['messages'] = 'Successfully added!';  
            }
            else{
                $output['success'] = false;
                $output['messages'] = 'Ooops! something went wrong';
            }
        }
        return $output;
    }

    //Edit Company
    function updCompany(){
        $id=$this->input->post('edit_cid');
        $edit_cname = $this->input->post('edit_cname');
        $edit_category = $this->input->post('edit_category');
        $edit_contact_person = $this->input->post('edit_contact_person');
        $edit_email = $this->input->post('edit_email');
        $edit_password = $this->input->post('edit_password');
        $edit_phone = $this->input->post('edit_phone');
        $edit_gst = $this->input->post('edit_gst');
        $edit_website = $this->input->post('edit_website');
        $edit_totalproduct = $this->input->post('edit_totalproduct');
        $edit_state = $this->input->post('edit_state');
        $edit_city = $this->input->post('edit_city');
        $edit_pincode = $this->input->post('edit_pincode');
        $edit_address = $this->input->post('edit_address');
        $data = array('name'=>$edit_cname, 'category'=>$edit_category, 'gst'=>$edit_gst, 'contact_person'=>$edit_contact_person, 
        'email'=>$edit_email, 'contact'=>$edit_phone, 'city'=>$edit_city, 'state'=>$edit_state, 'pincode'=>$edit_pincode, 
        'address'=>$edit_address, 'password'=>$edit_password, 'totalproduct'=>$edit_totalproduct,'website'=>$edit_website);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated user info';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating user info';  
        }        
        return $output;
    }

    function updUserprofile(){
        $id=$_SESSION['comid'];
        $edit_cname = $this->input->post('edit_cname');
        $edit_contact_person = $this->input->post('edit_contact_person');
        $edit_email = $this->input->post('edit_email');
        $edit_password = $this->input->post('edit_password');
        $edit_phone = $this->input->post('edit_phone');
        $edit_gst = $this->input->post('edit_gst');
        $edit_state = $this->input->post('edit_state');
        $edit_city = $this->input->post('edit_city');
        $edit_pincode = $this->input->post('edit_pincode');
        $edit_address = $this->input->post('edit_address');
        $data = array('name'=>$edit_cname, 'gst'=>$edit_gst, 'contact_person'=>$edit_contact_person, 
        'email'=>$edit_email, 'contact'=>$edit_phone, 'city'=>$edit_city, 'state'=>$edit_state, 'pincode'=>$edit_pincode, 
        'address'=>$edit_address, 'password'=>$edit_password);
        $result = $this->db->update('users',$data,array('id'=>$id));
        if($result){
            $output['success'] = true;
            $output['messages'] = 'Successfully Updated company info';  
        }else{
            $output['success'] = false;
            $output['messages'] = 'Error While updating company info';  
        }        
        return $output;
    }
    
}