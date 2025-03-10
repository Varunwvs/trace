<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LiveStockManagementController extends CI_Controller {

	
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog')) || $this->session->userdata('level')!='3'){
	      header('location:home');
	  	}  
	  	$this->load->helper('url');
		$this->load->model('app/seed/DashboardModel','dm');
        $this->load->model('app/livestock/AnimalRegistrationModel','arm');
        $this->load->model('app/livestock/AnimalHealthModel','ahm');
        $this->load->model('app/livestock/AnimalBreedingModel','abm');
        $this->load->model('app/livestock/AnimalFeedingModel','afm');
        $this->load->model('app/livestock/AnimalDairyModel','adm');
        $this->load->model('app/livestock/AnimalInventoryModel','aim');
        $this->load->model('app/livestock/AnimalFinanceModel','afnm');
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

    public function animalregistrationmanage(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalregistrationmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animals';  
        $this->load->datatable_template('app/livestock/animalregistrationmanage', $data);
    }

    public function animalregistrationentry(){

        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalregistrationentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Animal Registration';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animalregistrationentry', $data);
    }

    function dtAnimalRegister(){
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->arm->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
        $register_date='';
      
        foreach($memData as $row){           
    
                $actionButton = '
            <ul class="list-inline">  
                <li class="list-inline-item">
                    <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
                        <span class="fa fa-eye"></span>
                    </a>
                </li>         
            </ul>';
            
            $register_date = !empty($row->dob) ? date('d-m-Y', strtotime($row->dob)) : '';

            $data[] = array(
                $i++, 
                $row->animal_id, 
                $row->breed,      
                $register_date,
                $row->gender,
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->arm->countAll(),
            "recordsFiltered" => $this->arm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function addAnimal()
    {
		$data=$this->arm->insertAnimal();
        echo json_encode($data);
        
    }

    public function getAnimalDetails() {
        $id = $this->input->post('id');
        
        $animal = $this->arm->getAnimalById($id);
    
        if ($animal) {
            // Check if photo exists
            $photoPath = !empty($animal['photo']) && file_exists($animal['photo']) ? base_url($animal['photo']) : '';
    
            $animal['photo'] = $photoPath;
            echo json_encode(['status' => 'success', 'data' => $animal]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
        }
    }
    

    public function animalvaccinationmanage(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalvaccinationmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Health';  
        $this->load->datatable_template('app/livestock/animal_health/animalvaccinationmanage', $data);
    }

    public function animalvaccinationentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalvaccinationentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Health & Medical Records';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animal_health/animalvaccinationentry', $data);
    }

    function dtAnimalVaccination(){

        $data = $row = array();        
        // Fetch member's records
        $memData = $this->ahm->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
    
      
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
                $row->animal_code, 
                $row->health_status,    
                $row->vaccination_type,  
                $row->vaccination_date,   
                !empty($row->vaccination_date)? date('d-m-Y',strtotime($row->vaccination_date)):'',  
                !empty($row->next_vaccination_due)? date('d-m-Y',strtotime($row->next_vaccination_due)):'',  
                // $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ahm->countAll(),
            "recordsFiltered" => $this->ahm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function addAnimalVaccination()
    {
		$data=$this->ahm->insertAnimalVaccinationData();
        echo json_encode($data);
        
    }

    public function getAnimalHealthDetails() {
        $id = $this->input->post('id');
        
        $animal = $this->ahm->getAnimalHealthDataById($id);
    
        if ($animal) {
            echo json_encode(['status' => 'success', 'data' => $animal]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
        }
    }

    public function animaldewormingmanage(){
       
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animaldewormingmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Health';  
        $this->load->datatable_template('app/livestock/animal_health/animaldewormingmanage', $data);
    }

    public function animaldewormingentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animaldewormingentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Health & Medical Records';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animal_health/animaldewormingentry', $data);
    }


    public function dtAnimalDeworming(){
       
        $data=$this->ahm->dtAnimalDeworming();
        echo json_encode($data);
    }

    public function addAnimalDeworming()
    {
		$data=$this->ahm->insertAnimalDewormingData();
        echo json_encode($data);
        
    } 

    public function animalveterinarymanage(){
       
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalveterinarymanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Health';  
        $this->load->datatable_template('app/livestock/animal_health/animalveterinarymanage', $data);
    }

    public function animalveterinaryentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalveterinaryentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Health & Medical Records';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animal_health/animalveterinaryentry', $data);
    }


    public function dtAnimalVeterinary(){
       
        $data=$this->ahm->dtAnimalVeterinary();
        echo json_encode($data);
    }

    public function addAnimalVeterinary()
    {
		$data=$this->ahm->insertAnimalVeterinaryData();
        echo json_encode($data);
        
    }

    public function animalmedicationmanage(){
       
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalmedicationmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Health';  
        $this->load->datatable_template('app/livestock/animal_health/animalmedicationmanage', $data);
    }

    public function animalmedicationentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalmedicationentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Health & Medical Records';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animal_health/animalmedicationentry', $data);
    }


    public function dtAnimalMedication(){
       
        $data=$this->ahm->dtAnimalMedication();
        echo json_encode($data);
    }

    public function addAnimalMedication()
    {
		$data=$this->ahm->insertAnimalMedicationData();
        echo json_encode($data);
        
    }

    public function animaldiseasemanage(){
       
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animaldiseasemanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Health';  
        $this->load->datatable_template('app/livestock/animal_health/animaldiseasemanage', $data);
    }

    public function animaldiseaseentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animaldiseaseentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Health & Medical Records';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animal_health/animaldiseaseentry', $data);
    }


    public function dtAnimalDisease(){
       
        $data=$this->ahm->dtAnimalDisease();
        echo json_encode($data);
    }

    public function addAnimalDisease()
    {
		$data=$this->ahm->insertAnimalDiseaseData();
        echo json_encode($data);
        
    }

    public function animalmortalitymanage(){
       
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalmortalitymanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Health';  
        $this->load->datatable_template('app/livestock/animal_health/animalmortalitymanage', $data);
    }

    public function animalmortalityentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animal_health/animalmortalityentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Health & Medical Records';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animal_health/animalmortalityentry', $data);
    }


    public function dtAnimalMortality(){
       
        $data=$this->ahm->dtAnimalMortality();
        echo json_encode($data);
    }

    public function addAnimalMortality()
    {
		$data=$this->ahm->insertAnimalMortalityData();
        echo json_encode($data);
        
    }


    public function animalbreedingmanage(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalbreedingmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Breeding';  
        $this->load->datatable_template('app/livestock/animalbreedingmanage', $data);
    }

    public function animalbreedingentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalbreedingentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Breeding & Reproduction';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animalbreedingentry', $data);
    }


    function dtAnimalBreeding(){

        $data = $row = array();        
        // Fetch member's records
        $memData = $this->abm->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
        $mating_date='';
      
        foreach($memData as $row){           
    
                $actionButton = '
            <ul class="list-inline">  
                <li class="list-inline-item">
                    <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
                        <span class="fa fa-eye"></span>
                    </a>
                </li>         
            </ul>';
            
            $mating_date = !empty($row->mating_date) ? date('d-m-Y', strtotime($row->mating_date)) : '';

            $data[] = array(
                $i++, 
                $row->animal_code, 
                $mating_date,  
                $row->breeding_method,     
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->abm->countAll(),
            "recordsFiltered" => $this->abm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function addAnimalBreeding()
    {
		$data=$this->abm->insertAnimalBreedingData();
        echo json_encode($data);
        
    }

    public function getAnimalBreedingDetails() {
        $id = $this->input->post('id');
        
        $animal = $this->abm->getAnimalBreedingDataById($id);
    
        if ($animal) {
            echo json_encode(['status' => 'success', 'data' => $animal]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
        }
    }


    public function animalfeedingmanage(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalfeedingmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Animal Feeding';  
        $this->load->datatable_template('app/livestock/animalfeedingmanage', $data);
    }

    public function animalfeedingentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalfeedingentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Feeding & Nutrition Management';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animalfeedingentry', $data);
    }

    function dtAnimalFeeding(){

        $data = $row = array();        
        // Fetch member's records
        $memData = $this->afm->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
    
      
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
                $row->animal_code, 
                $row->feed_intake,  
                $row->feed_type,     
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->afm->countAll(),
            "recordsFiltered" => $this->afm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function addAnimalFeeding()
    {
		$data=$this->afm->insertAnimalFeedingData();
        echo json_encode($data);
        
    }

    public function getAnimalFeedingDetails() {
        $id = $this->input->post('id');
        
        $animal = $this->afm->getAnimalFeedingDataById($id);
    
        if ($animal) {
            echo json_encode(['status' => 'success', 'data' => $animal]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
        }
    }

    public function animaldairymanage(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animaldairymanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Dairy';  
        $this->load->datatable_template('app/livestock/animaldairymanage', $data);
    }

    public function animaldairyentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animaldairyentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Milk Production';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animaldairyentry', $data);
    }

    function dtAnimalDairy(){

        $data = $row = array();        
        // Fetch member's records
        $memData = $this->adm->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
    
      
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
                $row->animal_code, 
                $row->milk_yield,     
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->adm->countAll(),
            "recordsFiltered" => $this->adm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function addAnimalDairy()
    {
		$data=$this->adm->insertAnimalDairyData();
        echo json_encode($data);
        
    }

    public function getAnimalDairyDetails() {
        $id = $this->input->post('id');
        
        $animal = $this->adm->getAnimalDairyDataById($id);
    
        if ($animal) {
            echo json_encode(['status' => 'success', 'data' => $animal]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
        }
    }


    public function animalinventorymanage(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalinventorymanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Inventory';  
        $this->load->datatable_template('app/livestock/animalinventorymanage', $data);
    }

    public function animalinventoryentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalinventoryentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Inventory & Resource Management';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animalinventoryentry', $data);
    }

    function dtAnimalInventory(){

        $data = $row = array();        
        // Fetch member's records
        $memData = $this->aim->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
    
      
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
                $row->animal_code, 
                $row->stock_feed_supplements,     
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->aim->countAll(),
            "recordsFiltered" => $this->aim->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function addAnimalInventory()
    {
		$data=$this->aim->insertAnimalInventoryData();
        echo json_encode($data);
        
    }

    public function getAnimalInventoryDetails() {
        $id = $this->input->post('id');
        
        $animal = $this->aim->getAnimalInventoryDataById($id);
    
        if ($animal) {
            echo json_encode(['status' => 'success', 'data' => $animal]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
        }
    }

    public function animalfinancemanage(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalfinancemanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Finance';  
        $this->load->datatable_template('app/livestock/animalfinancemanage', $data);
    }

    public function animalfinanceentry(){
        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'animalfinanceentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Livestock Management";
        $data['title'] = 'Financial Records & Market Sales';  
        $data['animals']=$this->ahm->getanimalid();
        $this->load->formentry_template('app/livestock/animalfinanceentry', $data);
    }


    function dtAnimalFinance(){

        $data = $row = array();        
        // Fetch member's records
        $memData = $this->afnm->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
        $sale_date='';
      
        foreach($memData as $row){           
    
                $actionButton = '
            <ul class="list-inline">  
                <li class="list-inline-item">
                    <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
                        <span class="fa fa-eye"></span>
                    </a>
                </li>         
            </ul>';
            $sale_date = !empty($row->sale_date) ? date('d-m-Y', strtotime($row->sale_date)) : '';

    
            $data[] = array(
                $i++, 
                $row->animal_code, 
                $sale_date,     
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->afnm->countAll(),
            "recordsFiltered" => $this->afnm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function addAnimalFinance()
    {
		$data=$this->afnm->insertAnimalFinanceData();
        echo json_encode($data);
        
    }

    public function getAnimalFinanceDetails() {
        $id = $this->input->post('id');
        
        $animal = $this->afnm->getAnimalFinanceDataById($id);
    
        if ($animal) {
            echo json_encode(['status' => 'success', 'data' => $animal]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
        }
    }

    public function milkingmanage(){

        $data['thisPage'] = 'livestockmanage';
        $data['pgScript'] = 'milkingmanage';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Dairy';  
        $data['animals']=$this->adm->get_all_animals_data();

        $this->load->formentry_template('app/livestock/milkingmanage', $data);
    }

    public function fetch_milking_data()
{
    
    $date = $this->input->post('date');
    $slot = $this->input->post('slot');

    $data = $this->adm->get_milking_data_by_date_slot($date, $slot);
    
    echo json_encode($data);
}

public function save_milking_data()
{
    //  error_reporting(E_ALL);
    //     ini_set('display_errors', 1);
    //     ini_set('display_startup_errors', 1);
    $date = $this->input->post('date');
    $slot = $this->input->post('slot');
    $milking_data = $this->input->post('milking');
    
    // Pass the entire dataset to the model for batch processing
    $data = $this->adm->save_milking_batch($date, $slot, $milking_data);
    

    echo json_encode($data);
}

public function animallabourmanage(){

    $data['thisPage'] = 'livestockmanage';
    $data['pgScript'] = 'animallabourmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Labours';  
    $this->load->datatable_template('app/livestock/animallabourmanage', $data);
}

function dtAnimalLabour(){
    $data = $row = array();        
    $memData = $this->alm->getRows($_POST);   
     
    $i = $_POST['start']+1;
   
   
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
            $row->name,
            $row->phone,
            $row->task,
            $actionButton
        );
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

public function animallabourentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'livestockmanage';
    $data['pgScript'] = 'animallabourentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Labour";
    $data['title'] = 'Labour Entry';  
    $this->load->formentry_template('app/livestock/animallabourentry', $data);
}

public function addAnimalLabour()
{
    $data=$this->alm->insertAnimalLabourData();
    echo json_encode($data);
    
}

public function getAnimalLabourDetails() {
    $id = $this->input->post('id');
    
    $animal = $this->alm->getAnimalLabourDataById($id);

    if ($animal) {
        echo json_encode(['status' => 'success', 'data' => $animal]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Animal not found.']);
    }
}





}