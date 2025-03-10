<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FarmerController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog'))){
	      header('location:home');
	  	}  

          $this->load->library('form_validation');

	  	$this->load->helper('url');
		$this->load->model('app/farmer/FarmerModel','fm');
		$this->load->model('app/farmer/FarmerCropModel','fcm');
		$this->load->model('app/farmer/FarmerActivityModel','fam');
        $this->load->model('app/farmer/FarmerInputModel','fim');
        $this->load->model('app/farmer/FarmerExportImportModel','feim');
        $this->load->model('app/farmer/FarmerProductOrderModel','fpom');
        $this->load->model('app/farmer/FarmerDispatchModel','fdm');
        $this->load->model('app/farmer/FarmerRegisteredProductModel','frpm');
        $this->load->model('app/farmer/LocationModel','lm');
        $this->load->model('app/farmer/DealerModel','dm');
        $this->load->model('app/farmer/DispatchModel','dspm');
        $this->load->model('app/farmer/LabourModel','lbm');


	}

    public function farmermanage(){
        $data['thisPage'] = 'farmermanage';
        $data['pgScript'] = 'farmermanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Farmer';  
        $this->load->datatable_template('app/farmer/farmermanage', $data);
    }
    //Product Datatable view
    function dtFarmer(){
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->fm->getRows($_POST);   
         
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
            $full_name = ($row->full_name != '') ? strtoupper($row->full_name) : $row->full_name;
    
            $data[] = array(
                $i++, 
                $full_name, 
                $row->plot_area,      
                $row->contact_no,
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->fm->countAll(),
            "recordsFiltered" => $this->fm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
    
    public function farmerprofileentry(){
        // $previous_url = $this->session->userdata('previous_url');
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'farmerentry';
        $data['pgScript'] = 'farmerentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Farmer";
        $data['title'] = 'Farmer Enrollment';  
        $data['crops']=$this->fam->get_crops();
        $this->load->formentry_template('app/farmer/farmerentry', $data);
    }

    public function addFarmer() {
    //   error_reporting(E_ALL);
    //     ini_set('display_errors', 1);
    //     ini_set('display_startup_errors', 1);
        // Validate the form inputs
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('contact_no', 'Contact No.', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required');
        $this->form_validation->set_rules('plot_area', 'Plot Area', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Return validation errors
            echo json_encode(['status' => false, 'message' => validation_errors()]);
            return;
        }

        $filePath=null;
        if(isset($_FILES["farmer_files"]["type"]) && !empty($_FILES["farmer_files"]["tmp_name"])) {
            $filePath = $this->uploadFile('farmer_files', 'uploads/farmer_files/');
            if(!$filePath) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }
    
        // Gather farmer data
        $farmerData = [
            'full_name' => $this->input->post('full_name'),
            'contact_no' => $this->input->post('contact_no'),
            'email' => $this->input->post('email'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'plot_area' => $this->input->post('plot_area'),
            'address' => $this->input->post('address'),
            'registration_id' => $this->input->post('registration_id'),
            'farmer_files' => $filePath
        ];

       
    
        // Get plot division data
        $plotNames = $this->input->post('plot_name');
        $plotdivisionAreas = $this->input->post('division_area');
        $cropIds = $this->input->post('crop_id');
        $plotDivisions = [];
    
        if (!empty($plotNames) && !empty($plotdivisionAreas)) {
            foreach ($plotNames as $index => $plotName) {
                $plotDivisions[] = [
                    'plot_name' => $plotName,
                    'plot_division_area' => $plotdivisionAreas[$index],
                    'crop_id' => $cropIds[$index],
                ];
            }
        }
    
        $this->db->trans_start(); // Start transaction
    
        // Insert farmer data
        $farmerId = $this->fm->addFarmer($farmerData);
    
        if ($farmerId) {
            // Prepare plot division data for insertion
            foreach ($plotDivisions as &$plotDivision) {
                $plotDivision['farmer_id'] = $farmerId; // Associate with the farmer
            }
    
            // Insert plot divisions
            $this->fm->addPlotDivisions($plotDivisions);
        }
    
        $this->db->trans_complete(); // Complete transaction
    
        if ($this->db->trans_status() === FALSE) {
            // Transaction failed
            echo json_encode(['status' => false, 'message' => 'Some error occurred. Please try again!']);
        } else {
            // Transaction successful
            echo json_encode(['status' => true, 'message' => 'Farmer profile and plot divisions saved successfully.']);
        }
    }
    
    public function getFarmerPlotDetails() {
        $id = $this->input->post('id');
        if ($id) {
            $farmerDetails = $this->fm->getFarmerDetailsById($id); // Fetch farmer details from the model
            if ($farmerDetails) {
                echo json_encode(['status' => true, 'data' => $farmerDetails]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Farmer not found.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Invalid request.']);
        }
    }
    
    

    public function cropmanage(){
        $data['thisPage'] = 'cropmanage';
        $data['pgScript'] = 'cropmanage';
        $data['thisPageLevel'] = '1';   
        $data['thisPageMain']="";
        $data['title'] = 'Manage Crop';  
        $this->load->datatable_template('app/farmer/cropmanage', $data);
    }
    //Product Datatable view
    function dtCrop(){
        $data = $row = array();        
        // Fetch member's records
        $memData = $this->fcm->getRows($_POST);   
         
        $i = $_POST['start']+1;
        $adminrole = $_SESSION['role'];
    
        $apistatus='';
        $dis='';
        $hid='';
        $pinfo='';
        $pname='';
        $pcat='';
        foreach($memData as $row){    
            
            $file_name = $row->crop_schedule; 
            $file_path = base_url('uploads/crop_schedule/' . $file_name); 
    
            // Check if the file exists before rendering the link
            $crop_schedule = '';
            if (!empty($file_name)) {
                $crop_schedule = '<a class="btn btn-xs text-info" target="_blank" href="' . $file_path . '">View Calendar</a>';
            } else {
                $crop_schedule = 'No File Available'; 
            }
    
                $actionButton = '
            <ul class="list-inline">  
             <li class="list-inline-item">
                    <a class="btn text-info btn-xs" data-id="' . $row->id . '" role="button" href="#">
                        <span class="fa fa-edit"></span>
                    </a>
                </li>         
            </ul>';
            $crop_name = ($row->crop_name != '') ? strtoupper($row->crop_name) : $row->crop_name;
    
            $data[] = array(
                $i++, 
                $crop_name, 
                $crop_schedule,
                $actionButton
            );
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->fcm->countAll(),
            "recordsFiltered" => $this->fcm->countFiltered($_POST),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);
    }
    
    public function cropentry(){
        // $previous_url = $this->session->userdata('previous_url');
        $url= $_SERVER['HTTP_REFERER'];
        $data['thisPage'] = 'cropentry';
        $data['pgScript'] = 'cropentry';
        $data['thisPageLevel'] = '2';   
        $data['thisPageMain']="Crop";
        $data['title'] = 'Crop Entry';  
        $this->load->formentry_template('app/farmer/cropentry', $data);
    }

    public function addCrop()
{
   
    // Set form validation rules
    $this->form_validation->set_rules('crop_name', 'Crop Name', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Return validation errors
        echo json_encode(['status' => false, 'message' => validation_errors()]);
        return;
    }

    $filePath=null;
        if(isset($_FILES["file"]["type"]) && !empty($_FILES["file"]["tmp_name"])) {
            $filePath = $this->uploadFile('file', 'uploads/crop_schedule/');
            if(!$filePath) {
                $output['success'] = false;
                $output['message'] = 'Failed to upload image file';
                return $output;
            }
        }

    // Gather crop data
    $cropData = [
        'crop_name' => $this->input->post('crop_name'),
        'crop_schedule' => $filePath,
    ];

    $result = $this->fcm->addCrop($cropData);

    if ($result) {
        echo json_encode(['status' => true, 'message' => 'Crop added successfully.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to add crop. Please try again.']);
    }
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


public function farmingactivitymanage(){
    
    
    $data['thisPage'] = 'farmingactivitymanage';
    $data['pgScript'] = 'farmingactivitymanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Farming Activity';  
    
    $this->load->datatable_template('app/farmer/farmingactivitymanage', $data);
}

//Product Datatable view
function dtFarmingActivity(){
    //  error_reporting(E_ALL);
    //     ini_set('display_errors', 1);
    //     ini_set('display_startup_errors', 1);
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->fam->getRows($_POST);   
     
    $i = $_POST['start']+1;
    $adminrole = $_SESSION['role'];

    $apistatus='';
    $dis='';
    $hid='';
    $pinfo='';
    $pname='';
    $pcat='';
    foreach($memData as $row){    
        //taking farming activity as per the plot division
        $actionButton = '
        <ul class="list-inline">  
            <li class="list-inline-item">
                <a class="btn text-info btn-xs view-details" data-id="' . $row->plot_division_id. '" role="button" href="#">
                    <span class="fa fa-eye"></span>
                </a>
            </li>         
        </ul>';
    
        $farmer_name = ($row->farmer_name != '') ? strtoupper($row->farmer_name) : $row->farmer_name;
        $crop_name = ($row->crop_name != '') ? strtoupper($row->crop_name) : $row->crop_name;

        $data[] = array(
            $i++, 
            $farmer_name,
            $crop_name, 
            $row->plot_name,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->fam->countAll(),
        "recordsFiltered" => $this->fam->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function farmingactivityentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'farmingactivityentry';
    $data['pgScript'] = 'farmingactivityentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Farming Activity";
    $data['title'] = 'Farming Activity Entry';  
    $data['farmers']=$this->fam->get_farmers();
    $data['crops']=$this->fam->get_crops();
    $data['farminginputs']=$this->fam->get_farming_inputs();
    $this->load->formentry_template('app/farmer/farmingactivityentry', $data);
}

public function get_plot_division() {
    
    $farmer_id = $this->input->post('farmer_id');
    $plot_division = $this->fam->get_plot_division($farmer_id);

    if ($plot_division) {
        echo json_encode(['status' => true, 'data' => $plot_division]);
    } else {
        echo json_encode(['status' => false, 'message' => 'No data found.']);
    }
}
public function getCropSchedule() {
    $crop_id = $this->input->post('crop_id');
    
    // Fetch crop schedule filename from the farmercrops table
    $this->db->select('crop_schedule');
    $this->db->from('farmercrops');
    $this->db->where('id', $crop_id);
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        // If the file is found, send it back in the response
        $file_name = $query->row()->crop_schedule;
        echo json_encode(['status' => true, 'file_name' => $file_name]);
    } else {
        // If no file found, return a failure status
        echo json_encode(['status' => false, 'file_name' => '']);
    }
}

public function addFarmingActivity() {
  
        // Capture form data from the POST request
        $farmer_id = $this->input->post('farmer_id');
        $plot_division_id = $this->input->post('plot_division_id');
        $crop_id = $this->input->post('crop_id');

        // Prepare the farming activity data
        $activities = $this->input->post('activity');
        $activity_dates = $this->input->post('activity_date');
        $brands = $this->input->post('brand');
        $products = $this->input->post('product');
        $purposes = $this->input->post('purpose');

        // Validate the inputs (example)
        if (empty($farmer_id) || empty($plot_division_id) || empty($crop_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Farmer, plot, or crop information is missing.']);
            return;
        }

        // Loop through the activities and save each activity
        $farmingActivities = [];
        for ($i = 0; $i < count($activities); $i++) {
            $farmingActivities[] = [
                'farmer_id' => $farmer_id,
                'plot_division_id' => $plot_division_id,
                'crop_id' => $crop_id,
                'activity' => $activities[$i],
                'activity_date' => $activity_dates[$i],
                'brand' => $brands[$i],
                'product' => $products[$i],
                'purpose' => $purposes[$i]
            ];
        }

        $inserted = $this->fam->addFarmingActivities($farmingActivities);

        if ($inserted) {
            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'Farming activities added successfully']);
        } else {
            // Return error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to add farming activities.']);
        }
   
}

public function getFarmingActivityDetails() {
    $id = $this->input->post('id');
    $details = $this->fam->getDetailsById($id); // Adjust the model method as needed

    if ($details) {
        echo json_encode(['status' => true, 'data' => $details]);
    } else {
        echo json_encode(['status' => false, 'message' => 'No details found.']);
    }
}

public function getCropByPlotDivision() {
    $plotDivisionId = $this->input->post('plot_division_id');

    if ($plotDivisionId) {
        // Fetch crops associated with the plot division
        $this->db->select('fc.id, fc.crop_name');
        $this->db->from('plot_divisions pd');
        $this->db->join('farmercrops fc', 'pd.crop_id = fc.id');
        $this->db->where('pd.id', $plotDivisionId);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Return crops as response
            echo json_encode(['status' => true, 'crops' => $query->result()]);
        } else {
            // No crops found for the selected plot division
            echo json_encode(['status' => false, 'message' => 'No crops found']);
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Invalid plot division']);
    }
}


public function inputmanage(){

    $data['thisPage'] = 'inputmanage';
    $data['pgScript'] = 'inputmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Inputs';  
    $this->load->datatable_template('app/farmer/inputmanage', $data);
}
//Product Datatable view
function dtInput(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->fim->getRows($_POST);   
     
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
        $product = ($row->product != '') ? strtoupper($row->product) : $row->product;
        $brand = ($row->brand != '') ? strtoupper($row->brand) : $row->brand;
        $category_type = ($row->category_name != '') ? strtoupper($row->category_name) : $row->category_name;


        $data[] = array(
            $i++, 
            $product, 
            $brand,
            $category_type,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->fim->countAll(),
        "recordsFiltered" => $this->fim->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function inputentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'inputentry';
    $data['pgScript'] = 'inputentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Input";
    $data['title'] = 'Input Entry';  
    $data['categories']=$this->fim->get_categories();
    $this->load->formentry_template('app/farmer/inputentry', $data);
}

public function addFarmerInput() {
    // Set validation rules for the form inputs
    $this->form_validation->set_rules('product', 'Product', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required|integer');
    $this->form_validation->set_rules('description', 'Description', 'required');
    $this->form_validation->set_rules('brand', 'Brand', 'required');
    $this->form_validation->set_rules('usage_instructions', 'Usage Instructions', 'required');

    // Check if validation is successful
    if ($this->form_validation->run() == FALSE) {
        // Return validation errors
        echo json_encode(['status' => false, 'message' => validation_errors()]);
        return;
    }

    // Gather data from the form inputs
    $data = [
        'product' => $this->input->post('product'),
        'category' => $this->input->post('category'),
        'description' => $this->input->post('description'),
        'brand' => $this->input->post('brand'),
        'usage_instructions' => $this->input->post('usage_instructions')
    ];

    // Insert data into the database through the model
    $insertId = $this->fim->add_farmer_input($data);

    // Check if the insertion was successful
    if ($insertId) {
        echo json_encode(['status' => true, 'message' => 'Farmer input saved successfully.']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to save farmer input.']);
    }
}

public function getInputDetails() {
    $id = $this->input->post('id');

    $result=$this->fim->get_input_details_by_id($id);

    if ($result) {
        echo json_encode(['status' => true,'data' => $result]);
    } else {
        // If no data found, return a failure response
        echo json_encode(['status' => false, 'message' => 'No data found']);
    }
}


// Export and Import Module
public function eiprofilemanage(){

    $data['thisPage'] = 'eiprofilemanage';
    $data['pgScript'] = 'eiprofilemanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Profile';  
    $this->load->datatable_template('app/farmer/eiprofilemanage', $data);
}
//Product Datatable view
function dteiProfile(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->feim->getRows($_POST);   
     
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
        $full_name = ($row->full_name != '') ? strtoupper($row->full_name) : $row->full_name;


        $data[] = array(
            $i++, 
            $full_name, 
            $row->contact_no,
            $row->email,
            $row->user_type,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->feim->countAll(),
        "recordsFiltered" => $this->feim->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function eiprofileentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'eiprofileentry';
    $data['pgScript'] = 'eiprofileentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Profile";
    $data['title'] = 'Exporter - Importer Profile';  
    $data['categories']=$this->fim->get_categories();
    $this->load->formentry_template('app/farmer/eiprofileentry', $data);
}

public function addeiProfileUser() {
    // Get form data from POST request
    $full_name = $this->input->post('full_name');
    $contact_no = $this->input->post('contact_no');
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $website = $this->input->post('website');
    $license_no = $this->input->post('license_no');
    $register_no = $this->input->post('register_no');
    $notes = $this->input->post('notes');
    $company_name = $this->input->post('company_name');
    $user_type = $this->input->post('user_type');
    $address = $this->input->post('address');
    $tax_id = $this->input->post('tax_id');
    
    // Validate required fields (this is basic validation, you can improve it)
    if (empty($full_name) || empty($contact_no) || empty($email)) {
        echo json_encode(['status' => false, 'message' => 'Required fields are missing']);
        return;
    }

    // Prepare the data to be saved
    $data = [
        'full_name' => $full_name,
        'contact_no' => $contact_no,
        'email' => $email,
        'password' => $password,  // Consider hashing the password before storing it
        'website' => $website,
        'license_no' => $license_no,
        'register_no' => $register_no,
        'notes' => $notes,
        'company_name' => $company_name,
        'user_type' => $user_type,
        'address' => $address,
        'tax_id'=>$tax_id
    ];

    // Save the data to the database using the model
    $insert = $this->feim->insertUserProfile($data);

    if ($insert) {
        // Return success response
        echo json_encode(['status' => true, 'message' => 'User profile added successfully']);
    } else {
        // Return failure response
        echo json_encode(['status' => false, 'message' => 'Failed to add user profile']);
    }
}


public function geteiProfileDetails() {
    $id = $this->input->post('id'); // Get the id from the POST data

    // Fetch the user details from the database
    $profileData = $this->feim->getProfileById($id);

    if ($profileData) {
        // If data is found, return it in JSON format
        echo json_encode(['status' => true, 'data' => $profileData]);
    } else {
        // If no data found, return an error message
        echo json_encode(['status' => false, 'message' => 'No profile found']);
    }
}


public function ordersmanage(){

    $data['thisPage'] = 'ordermanage';
    $data['pgScript'] = 'ordermanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Orders';  
    $this->load->datatable_template('app/farmer/ordersmanage', $data);
}
//Product Datatable view
function dtOrders(){
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

public function orderentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'orderentry';
    $data['pgScript'] = 'orderentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Orders";
    $data['title'] = 'Order Entry';  
    $data['customers']=$this->fpom->get_customers();
    $data['currencies']=$this->fpom->get_currencies();
    $data['units']=$this->fpom->get_unit_of_measurements();
    $this->load->formentry_template('app/farmer/orderentry', $data);
}

public function get_customer_address()
{
    $customerId = $this->input->post('customer_id');
    
    if ($customerId) {
        
        $customer = $this->fpom->get_customer_address($customerId);
        
        if ($customer) {
            echo json_encode(['status' => 'success', 'address' => $customer->address]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Customer not found.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID.']);
    }
}

public function get_last_order_number()
{
    // Query the database to get the last order number
    $lastOrder = $this->db->select('order_no')
                          ->from('orderinvoices') // Replace 'orders' with your table name
                          ->order_by('id', 'DESC')
                          ->limit(1)
                          ->get()
                          ->row();

    if ($lastOrder) {
        $lastOrderNumber = intval(str_replace("Ki-", "", $lastOrder->order_no));
        $newOrderNumber = str_pad($lastOrderNumber + 1, 8, "0", STR_PAD_LEFT);
    } else {
        $newOrderNumber = "00000001"; // Default starting value
    }

    echo json_encode(['order_no' => "Ki-" . $newOrderNumber]);
}

public function get_batch_numbers()
{
    $searchTerm = $this->input->get('term'); // Get the search term from the request
    $this->db->select('batch_no');
    $this->db->like('batch_no', $searchTerm);
    $this->db->limit(10); // Limit results to 10 for efficiency
    $query = $this->db->get('seedbatch'); // Replace 'batches' with your table name

    $result = [];
    foreach ($query->result() as $row) {
        $result[] = $row->batch_no;
    }

    echo json_encode($result);
}


public function dispatchmanage(){

    $data['thisPage'] = 'dispatchmanage';
    $data['pgScript'] = 'dispatchmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Dispatch';  
    $this->load->datatable_template('app/farmer/dispatchmanage', $data);
}
//Product Datatable view
function dtDispatch(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->dspm->getRows($_POST);   
     
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
            $row->order_no,
            $row->batch_no,
            $row->dispatch_no,
            $row->qty_shipped,
            
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->dspm->countAll(),
        "recordsFiltered" => $this->dspm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function dispatchentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'dispatchentry';
    $data['pgScript'] = 'dispatchentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Dispatch";
    $data['title'] = 'Dispatch Entry';  
    $data['crops']=$this->fam->get_crops();
    $data['orders']=$this->dspm->get_order_id();
    $data['units']=$this->fpom->get_unit_of_measurements();
    $this->load->formentry_template('app/farmer/dispatchentry', $data);
}


public function add_dispatchdata() {
    // Get posted data
    $order_no = $this->input->post('order_no');
    $dispatch_no = $this->input->post('dispatch_no');
    $batch_no = $this->input->post('batch_no');
    $crop_id = $this->input->post('crop_id');
    $qty_shipped = $this->input->post('qty_shipped');
    $vehicle_no = $this->input->post('vehicle_no');
    

    $imagePath=null;
    if(isset($_FILES["imagePath"]["type"]) && !empty($_FILES["imagePath"]["tmp_name"])) {
        $imagePath = $this->uploadFile('imagePath', 'uploads/dispatch_files/');
        if(!$imagePath) {
            $output['success'] = false;
            $output['message'] = 'Failed to upload image file';
            return $output;
        }
    }
    $certificate=null;
    if(isset($_FILES["certificate"]["type"]) && !empty($_FILES["certificate"]["tmp_name"])) {
        $certificate = $this->uploadFile('certificate', 'uploads/dispatch_files/');
        if(!$certificate) {
            $output['success'] = false;
            $output['message'] = 'Failed to upload image file';
            return $output;
        }
    }

    $other_files=null;
    if(isset($_FILES["other_file"]["type"]) && !empty($_FILES["other_file"]["tmp_name"])) {
        $other_files = $this->uploadFile('other_file', 'uploads/dispatch_files/');
        if(!$other_files) {
            $output['success'] = false;
            $output['message'] = 'Failed to upload image file';
            return $output;
        }
    }

 

    // Insert the dispatch data into your database
    $dispatch_data = [
        'order_no' => $order_no,
        'dispatch_no' => $dispatch_no,
        'batch_no' => $batch_no,
        'crop_id' => $crop_id,
        'qty_shipped' => $qty_shipped,
        'vehicle_no' => $vehicle_no,
        'images' => $imagePath,
        'certificate' => $certificate,
        'other_files' => $other_files
    ];

    // Call the model method to insert the data
    if ($this->dspm->insert_dispatch($dispatch_data)) {
        $response = ['status' => 'success', 'message' => 'Data submitted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to submit data'];
    }

    echo json_encode($response);
}

public function fetch_dispatch_data() {
    $id = $this->input->post('id');

    $query = $this->db->select('d.*,c.crop_name')
            ->from('dispatch d')
            ->join('farmercrops c','c.id=d.crop_id')
            ->where('d.id', $id)->get();

    if ($query->num_rows() > 0) {
        $data = $query->row();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}



public function dealermanage(){

    $data['thisPage'] = 'dealermanage';
    $data['pgScript'] = 'dealermanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Dealers';  
    $this->load->datatable_template('app/farmer/dealermanage', $data);
}
//Product Datatable view
function dtDealer(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->dm->getRows($_POST);   
     
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
            $row->company_name,
            $row->contact_person,
            $row->mobile,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->dm->countAll(),
        "recordsFiltered" => $this->dm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function dealerentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'dealerentry';
    $data['pgScript'] = 'dealerentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Dealer";
    $data['title'] = 'Dealer';  
    $data['locations']=$this->dm->get_locations();
    $this->load->formentry_template('app/farmer/dealerentry', $data);
}

public function addDealer() {

    // Get POST data
    $data = [
        'company_name'         => $this->input->post('company_name', TRUE),
        'gstin'                => $this->input->post('gstin', TRUE),
        'pan'                  => $this->input->post('pan', TRUE),
        'distribution_location' => $this->input->post('distribution_location', TRUE),
        'contact_person'       => $this->input->post('contact_person', TRUE),
        'mobile'               => $this->input->post('mobile', TRUE),
        'email'                => $this->input->post('email', TRUE),
        'distributor_status'   => $this->input->post('distributor_status', TRUE),
        'address'              => $this->input->post('address', TRUE)
    ];

    // Insert into database using model
    $insert_id = $this->dm->insertDealer($data);

    if ($insert_id) {
        echo json_encode(["status" => "success", "message" => "Dealer added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add dealer"]);
    }
}

public function getDealerDetails() {
    $id = $this->input->post('id', TRUE);
    $dealer = $this->dm->getDealerById($id);

    if ($dealer) {
        echo json_encode(["status" => "success", "data" => $dealer]);
    } else {
        echo json_encode(["status" => "error", "message" => "Dealer not found"]);
    }
}


public function locationmanage(){

    $data['thisPage'] = 'locationmanage';
    $data['pgScript'] = 'locationmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Locations';  
    $this->load->datatable_template('app/farmer/locationmanage', $data);
}
//Product Datatable view
function dtLocation(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->lm->getRows($_POST);   
     
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
            $row->state_name,
            $row->location_name,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->lm->countAll(),
        "recordsFiltered" => $this->lm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function locationentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'locationentry';
    $data['pgScript'] = 'locationentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Location";
    $data['title'] = 'Location Entry';  
    $data['states']=$this->lm->get_states();
    $this->load->formentry_template('app/farmer/locationentry', $data);
}


public function addlocation() {

    $location_name = $this->input->post('location_name');
    $state = $this->input->post('state');

    if (empty($location_name) || empty($state)) {
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
        return;
    }

    // Save data in the database
    $data = [
        'location_name' => $location_name,
        'state' => $state
    ];

    $insert = $this->lm->add_location($data);

    if ($insert) {
        echo json_encode(["status" => "success", "message" => "Location added successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add location. Try again!"]);
    }
}


public function regproductmanage(){

    $data['thisPage'] = 'regproductmanage';
    $data['pgScript'] = 'regproductmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Product Registrations';  
    $this->load->datatable_template('app/farmer/regproductmanage', $data);
}

function dtRegProduct(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->frpm->getRows($_POST);  
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
            $row->name,
            $row->mobile,
            $row->product_purchased,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->frpm->countAll(),
        "recordsFiltered" => $this->frpm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function getRegProductDetails(){
    $id = $this->input->post('id');


    // Fetch the product details from the database
    $product = $this->db->get_where('registered_products', ['id' => $id])->row();

    if ($product) {
        echo json_encode([
            'status' => true,
            'data' => $product
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Product not found.'
        ]);
    }
}


//harvesting manage

public function harvestingmanage(){

    $data['thisPage'] = 'harvestingmanage';
    $data['pgScript'] = 'harvestingmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Harvesting';  
    $this->load->datatable_template('app/farmer/harvestingmanage', $data);
}

function dtHarvest(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->fpom->getRows($_POST);   
     
    $i = $_POST['start']+1;
    $adminrole = $_SESSION['role'];

   
    // foreach($memData as $row){    
        

    //         $actionButton = '
    //     <ul class="list-inline">  
    //      <li class="list-inline-item">
    //             <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
    //                 <span class="fa fa-eye"></span>
    //             </a>
    //         </li>         
    //     </ul>';


    //     $data[] = array(
    //         $i++, 
    //         '',
    //         '',
    //         '',
    //         '',
    //         $actionButton
    //     );
    // }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->fpom->countAll(),
        "recordsFiltered" => $this->fpom->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function harvestentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'harvestentry';
    $data['pgScript'] = 'harvestentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Harvest";
    $data['title'] = 'Harvesting Record';  
    $data['crops']=$this->fam->get_crops();
    $data['units']=$this->fpom->get_unit_of_measurements();
    $data['farmers']=$this->fam->get_farmers();
    $this->load->formentry_template('app/farmer/harvestentry', $data);
}

public function get_farmer_and_plot_details()
{
    $farmer_id = $this->input->post('farmer_id');
    if ($farmer_id) {
        // Fetch farmer details
        $farmer = $this->db->get_where('farmerprofile', ['id' => $farmer_id])->row();

        // Fetch plots under the farmer
        $plots = $this->db->get_where('plot_divisions', ['farmer_id' => $farmer_id])->result();

        echo json_encode(['farmer' => $farmer, 'plots' => $plots]);
    } else {
        echo json_encode(['error' => 'Farmer ID is required']);
    }
}


public function labourmanage(){

    $data['thisPage'] = 'labourmanage';
    $data['pgScript'] = 'farming/labourmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Labours';  
    $this->load->datatable_template('app/farmer/labourmanage', $data);
}

function dtLabour(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->lbm->getRows($_POST);   
     
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
            $row->full_name,
            $row->contact_no,
            $actionButton
        );
    }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->lbm->countAll(),
        "recordsFiltered" => $this->lbm->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function labourentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'labourmanage';
    $data['pgScript'] = 'farming/labourentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Labour";
    $data['title'] = 'Labour Entry';  
    $this->load->formentry_template('app/farmer/labourentry', $data);
}

public function addLabour()
    {
		$data=$this->lbm->addLabour();
        echo json_encode($data);
        
    }

    public function get_labour_data() {
        $id = $this->input->post('id');
        $data = $this->lbm->get_labour_by_id($id);
    
        if($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data found']);
        }
    }
    

public function taskmanage(){

    $data['thisPage'] = 'labourmanage';
    $data['pgScript'] = 'taskmanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Tasks';  
    $this->load->datatable_template('app/farmer/taskmanage', $data);
}

function dtTask(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->fpom->getRows($_POST);   
     
    $i = $_POST['start']+1;
   
   
    // foreach($memData as $row){    
        

    //         $actionButton = '
    //     <ul class="list-inline">  
    //      <li class="list-inline-item">
    //             <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
    //                 <span class="fa fa-eye"></span>
    //             </a>
    //         </li>         
    //     </ul>';


    //     $data[] = array(
    //         $i++, 
    //         '',
    //         '',
    //         '',
    //         $actionButton
    //     );
    // }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->fpom->countAll(),
        "recordsFiltered" => $this->fpom->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function taskentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'labourmanage';
    $data['pgScript'] = 'taskentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Task";
    $data['title'] = 'Task Entry';  
    $this->load->formentry_template('app/farmer/taskentry', $data);
}

public function labourhygiene(){

    $data['thisPage'] = 'labourmanage';
    $data['pgScript'] = 'labourhygiene';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Dairy';  
    $data['animals']=$this->adm->get_all_animals_data();

    $this->load->formentry_template('app/farmer/labourhygiene', $data);
}

public function fetch_milking_data()
{

$date = $this->input->post('date');
$slot = $this->input->post('slot');

$data = $this->adm->get_milking_data_by_date_slot($date, $slot);

echo json_encode($data);
}



public function warehousemanage(){

    $data['thisPage'] = 'warehousemanage';
    $data['pgScript'] = 'warehousemanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Warehouse';  
    $this->load->datatable_template('app/farmer/warehousemanage', $data);
}

function dtWarehouse(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->fpom->getRows($_POST);   
     
    $i = $_POST['start']+1;
   
   
    // foreach($memData as $row){    
        

    //         $actionButton = '
    //     <ul class="list-inline">  
    //      <li class="list-inline-item">
    //             <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
    //                 <span class="fa fa-eye"></span>
    //             </a>
    //         </li>         
    //     </ul>';


    //     $data[] = array(
    //         $i++, 
    //         '',
    //         '',
    //         '',
    //         '',
    //         $actionButton
    //     );
    // }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->fpom->countAll(),
        "recordsFiltered" => $this->fpom->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function warehouseentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'warehouseentry';
    $data['pgScript'] = 'warehouseentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Warehouse";
    $data['title'] = 'Warehouse Entry';  
    $this->load->formentry_template('app/farmer/warehouseentry', $data);
}

public function transfermanage(){

    $data['thisPage'] = 'transfermanage';
    $data['pgScript'] = 'transfermanage';
    $data['thisPageLevel'] = '1';   
    $data['thisPageMain']="";
    $data['title'] = 'Manage Transfer';  
    $this->load->datatable_template('app/farmer/transfermanage', $data);
}

function dtTransfer(){
    $data = $row = array();        
    // Fetch member's records
    $memData = $this->fpom->getRows($_POST);   
     
    $i = $_POST['start']+1;
   
   
    // foreach($memData as $row){    
        

    //         $actionButton = '
    //     <ul class="list-inline">  
    //      <li class="list-inline-item">
    //             <a class="btn text-info btn-xs open-modal" data-id="' . $row->id . '" role="button" href="#">
    //                 <span class="fa fa-eye"></span>
    //             </a>
    //         </li>         
    //     </ul>';


    //     $data[] = array(
    //         $i++, 
    //         '',
    //         '',
    //         '',
    //         '',
    //         $actionButton
    //     );
    // }
    
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->fpom->countAll(),
        "recordsFiltered" => $this->fpom->countFiltered($_POST),
        "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
}

public function transferentry(){
    // $previous_url = $this->session->userdata('previous_url');
    $url= $_SERVER['HTTP_REFERER'];
    $data['thisPage'] = 'transferentry';
    $data['pgScript'] = 'transferentry';
    $data['thisPageLevel'] = '2';   
    $data['thisPageMain']="Transfer";
    $data['title'] = 'Transfer Entry';  
    $this->load->formentry_template('app/farmer/transferentry', $data);
}


}