<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LogisticsController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog'))){
	      header('location:home');
	  	}  

          $this->load->library('form_validation');

	  	$this->load->helper('url');
		$this->load->model('app/farmer/FarmerModel','fm');
        $this->load->model('app/farmer/FarmerProductOrderModel','fpom');

	}

    public function vehiclemanage(){
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        $data['thisPage'] = 'vehiclemanage';
        $data['pgScript'] = 'vehiclemanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="Logistics";
        $data['title'] = 'Manage Vehicles';  
        $this->load->datatable_template('app/logistics/vehiclemanage', $data);
    }
    //Product Datatable view
    function dtVehicle(){
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->fpom->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
    
        $apistatus='';
        $dis='';
        $hid='';
        $pinfo='';
        $pname='';
        $pcat='';
        foreach($memData as $row){    
            
    
                $actionButton = '
            <ul class="list-inline">  
             <li class="list-inline-item">
                    <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
                        <span class="fa fa-eye"></span>
                    </a>
                </li>         
            </ul>';
    
    
            $data[] = array(
                $i++, 
                '',
                '',
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->fpom->countAll(),
            "recordsFiltered" => $this->fpom->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
    
    public function vehicleentry(){
        // $previous_url = $this->session->userdata('previous_url');
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'farmerentry';
        $data['pgScript'] = 'farmerentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Logistics";
        $data['title'] = 'Vehicle Entry';  
        $this->load->formentry_template('app/logistics/vehicleentry', $data);
    }


    public function drivermanage(){
        $data['thisPage'] = 'drivermanage';
        $data['pgScript'] = 'drivermanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="Logistics";
        $data['title'] = 'Manage Drivers';  
        $this->load->datatable_template('app/logistics/drivermanage', $data);
    }
    //Product Datatable view
    function dtDriver(){
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->fpom->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
    
        $apistatus='';
        $dis='';
        $hid='';
        $pinfo='';
        $pname='';
        $pcat='';
        foreach($memData as $row){    
            
    
                $actionButton = '
            <ul class="list-inline">  
             <li class="list-inline-item">
                    <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
                        <span class="fa fa-eye"></span>
                    </a>
                </li>         
            </ul>';
    
    
            $data[] = array(
                $i++, 
                '',
                '',
                '',
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->fpom->countAll(),
            "recordsFiltered" => $this->fpom->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
    
    public function driverentry(){
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // $previous_url = $this->session->userdata('previous_url');
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'farmerentry';
        $data['pgScript'] = 'farmerentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Logistics";
        $data['title'] = 'Driver Entry';  
        $this->load->formentry_template('app/logistics/driverentry', $data);
    }



}