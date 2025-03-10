<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CarbonAccountingController extends CI_Controller {

	
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog')) || $this->session->userdata('level')!='3'){
	      header('location:home');
	  	}  
	  	$this->load->helper('url');
		$this->load->model('app/seed/DashboardModel','dm');
        $this->load->model('app/livestock/AnimalLabourModel','alm');

	
	}

    public function index(){
	    $data['thisPage'] = 'dashboard';
	    $data['pgScript'] = 'dashboard';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Dashboard';  
	    $this->load->dashboard_template('app/seed/dashboard', $data);
	}

    public function scope1entry(){
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'scope1entry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Carbon  Accounting";
        $data['title'] = 'Scope1 Entry';  
      
        $this->load->formentry_template('app/carbonaccounting/scope1entry', $data);
    }

    public function scope2entry(){
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'scope2entry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Carbon  Accounting";
        $data['title'] = 'Scope2 Entry';  
      
        $this->load->formentry_template('app/carbonaccounting/scope2entry', $data);
    }

    public function scope3entry(){
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'scope3entry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Carbon  Accounting";
        $data['title'] = 'Scope3 Entry';  
      
        $this->load->formentry_template('app/carbonaccounting/scope3entry', $data);
    }

    public function calocationmanage(){
  
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'carbonaccounting/calocationmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Location';  
        $this->load->datatable_template('app/carbonaccounting/calocationmanage', $data);
    }
    
    function dtCaLocation(){
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        $data = $row = array();        
        $memData = $this->alm->getRows($_POST);   
         
        $i = $_POST['start']+1;
       
       
        foreach($memData as $row){    
            
    
            //     $actionButton = '
            //         <ul class="list-inline">  
            //         <li class="list-inline-item">
            //                 <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
            //                     <span class="fa fa-eye"></span>
            //                 </a>
            //             </li>         
            //         </ul>';
    
    
            // $data[] = array(
            //     $i++, 
            //     $row->name,
            //     $row->phone,
            //     $row->task,
            //     $actionButton
            // );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->alm->countAll(),
            "recordsFiltered" => $this->alm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
    
    public function calocationentry(){
        // $previous_url = $this->session->userdata('previous_url');
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'carbonaccounting/calocationentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Location";
        $data['title'] = 'Location Entry';  
        $this->load->formentry_template('app/carbonaccounting/calocationentry', $data);
    }
    

    public function cavehiclemanage(){
  
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'carbonaccounting/cavehiclemanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Vehicles';  
        $this->load->datatable_template('app/carbonaccounting/cavehiclemanage', $data);
    }
    
    function dtCaVehicle(){
        
        $data = $row = array();        
        $memData = $this->alm->getRows($_POST);   
         
        $i = $_POST['start']+1;
       
       
        foreach($memData as $row){    
            
    
            //     $actionButton = '
            //         <ul class="list-inline">  
            //         <li class="list-inline-item">
            //                 <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
            //                     <span class="fa fa-eye"></span>
            //                 </a>
            //             </li>         
            //         </ul>';
    
    
            // $data[] = array(
            //     $i++, 
            //     $row->name,
            //     $row->phone,
            //     $row->task,
            //     $actionButton
            // );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->alm->countAll(),
            "recordsFiltered" => $this->alm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
    
    public function cavehicleentry(){
        // $previous_url = $this->session->userdata('previous_url');
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'carbonaccounting/cavehicleentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Vehicle";
        $data['title'] = 'Vehicle Data';  
        $this->load->formentry_template('app/carbonaccounting/cavehicleentry', $data);
    }


    public function caequipmentmanage(){
  
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'carbonaccounting/caequipmentmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Equipments';  
        $this->load->datatable_template('app/carbonaccounting/caequipmentmanage', $data);
    }
    
    function dtCaEquipment(){
        
        $data = $row = array();        
        $memData = $this->alm->getRows($_POST);   
         
        $i = $_POST['start']+1;
       
       
        foreach($memData as $row){    
            
    
            //     $actionButton = '
            //         <ul class="list-inline">  
            //         <li class="list-inline-item">
            //                 <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
            //                     <span class="fa fa-eye"></span>
            //                 </a>
            //             </li>         
            //         </ul>';
    
    
            // $data[] = array(
            //     $i++, 
            //     $row->name,
            //     $row->phone,
            //     $row->task,
            //     $actionButton
            // );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->alm->countAll(),
            "recordsFiltered" => $this->alm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
    
    public function caequipmententry(){
        // $previous_url = $this->session->userdata('previous_url');
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'carbonaccmanage';
        $data['pgScript'] = 'carbonaccounting/caequipmententry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Vehicle";
        $data['title'] = 'Vehicle Data';  
        $this->load->formentry_template('app/carbonaccounting/caequipmententry', $data);
    }

}