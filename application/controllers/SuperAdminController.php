<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SuperAdminController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if(empty($this->session->userdata('memlog')) || $this->session->userdata('level')!='1'){
	      header('location:home');
	  	}  
	  	$this->load->helper('url');
		$this->load->model('superadmin/CompanyModel','cm');
		$this->load->model('superadmin/RcholderModel','rm');
		$this->load->model('superadmin/AdminModel','am');
		$this->load->model('superadmin/ProfileModel','pm');
	}

    public function index(){
	    $data['thisPage'] = 'dashboard';
	    $data['pgScript'] = 'dashboard';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Dashboard';  
	    $this->load->dashboard_template('superadmin/dashboard', $data);
	}
/*=-Starts Company-=*/
	public function manageseedcompany(){
	    $data['thisPage'] = 'manageseedcompany';
	    $data['pgScript'] = 'manageseedcompany';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Manage Seed Company'; 
	    $this->load->datatable_template('superadmin/manageseedcompany', $data);
	}

	//Company Datatable View
	function dtCompany(){
		$data=$this->cm->dtCompany();
		echo json_encode($data);
	}

	//Update Company Status
	function updComstatus(){
		$data=$this->cm->updComstatus();
		echo json_encode($data);
	}

	//Update Company Role
	function updComrole(){
		$data=$this->cm->updComrole();
		echo json_encode($data);
	}

	//Get Total Count
	function getTotalCount(){			
		$data=$this->cm->getTotalCount();
		echo json_encode($data);
	}

	//Get Total Count
	function incTotalcount(){			
		$data=$this->cm->incTotalcount();
		echo json_encode($data);
	}
	
	function getQrqty(){
		$data=$this->cm->getQrqty();
		echo json_encode($data);
	}

	function incQrQuantity(){			
		$data=$this->cm->incQrQuantity();
		echo json_encode($data);
	}

	//Get Company Info
	function getCominfo(){			
		$data=$this->cm->getCominfo();
		echo json_encode($data);
	}
	
	function getComdinfo(){			
		$data=$this->cm->getComdinfo();
		echo json_encode($data);
	}

    //Delete Company info
	function delCompany(){
		$data=$this->cm->delCompany();
		echo json_encode($data);
	}

    //Company Add Page
	public function companyadd(){
	    $data['thisPage'] = 'manageseedcompany';
	    $data['pgScript'] = 'companyadd';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='manageseedcompany'>Manage Seed Company</a>";
	    $data['title'] = 'Company Entry';  
        $data['category'] = $this->cm->getCategory()->result();
	    $this->load->formentry_template('superadmin/companyadd', $data);
	}

    //Add New Company
	function addCompany(){
		$data=$this->cm->addCompany();
		echo json_encode($data);
	}

    //Company Edit Page
	public function companyedit(){
	    $data['thisPage'] = 'manageseedcompany';
	    $data['pgScript'] = 'companyedit';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='manageseedcompany'>Manage Seed Company</a>";
	    $data['title'] = 'Company Edit';  
        $data['category'] = $this->cm->getCategory()->result();
	    $this->load->formentry_template('superadmin/companyedit', $data);
	}

    //Update Company Info
	function updCompany(){
		$data=$this->cm->updCompany();
		echo json_encode($data);
	}
/*=-Ends Company-=*/

/*=-Starts Rcholder-=*/
	public function manageseedrcholder(){
		$data['thisPage'] = 'manageseedrcholder';
		$data['pgScript'] = 'manageseedrcholder';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Seed RCholder'; 
		$this->load->datatable_template('superadmin/manageseedrcholder', $data);
	}

	//Rcholder Datatable View
	function dtRcholder(){
		$data=$this->rm->dtRcholder();
		echo json_encode($data);
	}

	//Update rcholde Status
	function updRcstatus(){
		$data=$this->rm->updRcstatus();
		echo json_encode($data);
	}

	//Update rcholder Role
	function updRcrole(){
		$data=$this->rm->updRcrole();
		echo json_encode($data);
	}

	//Get Total Count
	function getrcTotalCount(){			
		$data=$this->rm->getrcTotalCount();
		echo json_encode($data);
	}

	//Get Total Count
	function incrcTotalcount(){			
		$data=$this->rm->incrcTotalcount();
		echo json_encode($data);
	}

	//Get Company Info
	function getRcinfo(){			
		$data=$this->rm->getRcinfo();
		echo json_encode($data);
	}
	
	function getComrinfo(){			
		$data=$this->rm->getComrinfo();
		echo json_encode($data);
	}
	
	function getrcQrqty(){
		$data=$this->rm->getrcQrqty();
		echo json_encode($data);
	}

	function incrcQrQuantity(){			
		$data=$this->rm->incrcQrQuantity();
		echo json_encode($data);
	}

	//Delete RC Holder info
	function delRcholder(){
		$data=$this->rm->delRcholder();
		echo json_encode($data);
	}

	//rcholder Add Page
	public function rcholderadd(){
	    $data['thisPage'] = 'manageseedrcholder';
	    $data['pgScript'] = 'rcholderadd';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='manageseedrcholder'>Manage Seed RC Holder</a>";
	    $data['title'] = 'RC Holder Entry';  
        $data['category'] = $this->cm->getCategory()->result();
	    $this->load->formentry_template('superadmin/rcholderadd', $data);
	}

    //Add New rcholder
	function addRcholder(){
		$data=$this->rm->addRcholder();
		echo json_encode($data);
	}

	//rcholder Edit Page
	public function rcholderedit(){
	    $data['thisPage'] = 'manageseedrcholder';
	    $data['pgScript'] = 'rcholderedit';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='manageseedrcholder'>Manage Seed RC Holder</a>";
	    $data['title'] = 'RC Holder Edit';  
        $data['category'] = $this->cm->getCategory()->result();
	    $this->load->formentry_template('superadmin/rcholderedit', $data);
	}

    //Update rcholder Info
	function updRcholder(){
		$data=$this->rm->updRcholder();
		echo json_encode($data);
	}
/*=-Ends Rcholder-=*/

/*=-Starts Fertilizer-=*/
	public function manageflcompany(){
		$data['thisPage'] = 'manageflcompany';
		$data['pgScript'] = 'manageflcompany';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Fertilizer Company'; 
		$this->load->datatable_template('superadmin/manageflcompany', $data);
	}

	//Rcholder Datatable View
	function dtFlcompany(){
		$data=$this->cm->dtFlcompany();
		echo json_encode($data);
	}

	public function manageflrcholder(){
		$data['thisPage'] = 'manageflrcholder';
		$data['pgScript'] = 'manageflrcholder';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Fertilizer RCHolder'; 
		$this->load->datatable_template('superadmin/manageflrcholder', $data);
	}

	//Rcholder Datatable View
	function dtFlrcholder(){
		$data=$this->rm->dtFlrcholder();
		echo json_encode($data);
	}
/*=-Ends Fertilizer-=*/

/*=-Starts Pesticide-=*/
	public function managepscompany(){
		$data['thisPage'] = 'managepscompany';
		$data['pgScript'] = 'managepscompany';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Pesticide Company'; 
		$this->load->datatable_template('superadmin/managepscompany', $data);
	}

	//Rcholder Datatable View
	function dtPscompany(){
		$data=$this->cm->dtPscompany();
		echo json_encode($data);
	}
	
	//Update Company Role
	function pubComstatus(){
		$data=$this->cm->pubComstatus();
		echo json_encode($data);
	}

	public function managepsrcholder(){
		$data['thisPage'] = 'managepsrcholder';
		$data['pgScript'] = 'managepsrcholder';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Pesticide RCHolder'; 
		$this->load->datatable_template('superadmin/managepsrcholder', $data);
	}

	//Rcholder Datatable View
	function dtPsrcholder(){
		$data=$this->rm->dtPsrcholder();
		echo json_encode($data);
	}
	
	//Update rcholder Role
	function pubRcstatus(){
		$data=$this->rm->pubRcstatus();
		echo json_encode($data);
	}
/*=-Ends Pesticides-=*/
/*=-Starts Microirrigation-=*/
	public function managemicompany(){
		$data['thisPage'] = 'managemicompany';
		$data['pgScript'] = 'managemicompany';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Microirrigation Company'; 
		$this->load->datatable_template('superadmin/managemicompany', $data);
	}

	//Rcholder Datatable View
	function dtMicompany(){
		$data=$this->cm->dtMicompany();
		echo json_encode($data);
	}

	//Update Company Role
	function mipubComstatus(){
		$data=$this->cm->pubComstatus();
		echo json_encode($data);
	}

	public function managemircholder(){
		$data['thisPage'] = 'managemircholder';
		$data['pgScript'] = 'managemircholder';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Microirrigation RCHolder'; 
		$this->load->datatable_template('superadmin/managemircholder', $data);
	}

	//Rcholder Datatable View
	function dtMircholder(){
		$data=$this->rm->dtMircholder();
		echo json_encode($data);
	}

	//Update rcholder Role
	function mipubRcstatus(){
		$data=$this->rm->pubRcstatus();
		echo json_encode($data);
	}
/*=-Ends Microirrigation-=*/

/*=-Starts Tarpaulin-=*/
	public function managetpcompany(){
		$data['thisPage'] = 'managetpcompany';
		$data['pgScript'] = 'managetpcompany';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Tarpaulin Company'; 
		$this->load->datatable_template('superadmin/managetpcompany', $data);
	}

	//Rcholder Datatable View
	function dtTpcompany(){
		$data=$this->cm->dtTpcompany();
		echo json_encode($data);
	}

	//Update Company Role
	function tppubComstatus(){
		$data=$this->cm->pubComstatus();
		echo json_encode($data);
	}

	public function managetprcholder(){
		$data['thisPage'] = 'managetprcholder';
		$data['pgScript'] = 'managetprcholder';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Tarpaulin RCHolder'; 
		$this->load->datatable_template('superadmin/managetprcholder', $data);
	}

	//Rcholder Datatable View
	function dtTprcholder(){
		$data=$this->rm->dtTprcholder();
		echo json_encode($data);
	}

	//Update rcholder Role
	function tppubRcstatus(){
		$data=$this->rm->pubRcstatus();
		echo json_encode($data);
	}
/*=-Ends Microirrigation-=*/

/*=-Starts Admins-=*/
	public function manageadmin(){
		$data['thisPage'] = 'manageadmin';
		$data['pgScript'] = 'manageadmin';
		$data['thisPageLevel'] = '1';   
		$data['thisPageMain']="";
		$data['title'] = 'Manage Admins'; 
		$this->load->datatable_template('superadmin/manageadmin', $data);
	}

	//admin Datatable View
	function dtAdmin(){
		$data=$this->am->dtAdmin();
		echo json_encode($data);
	}

	//Update Company Status
	function updAdminstatus(){
		$data=$this->am->updAdminstatus();
		echo json_encode($data);
	}

	public function centerview(){
		$data['thisPage'] = 'manageadmin';
		$data['pgScript'] = 'centerview';
		$data['thisPageLevel'] = '2';   
		$data['thisPageMain']="<a href='manageadmin'>Manage Admin</a>";
		$data['title'] = 'Manage Center'; 
		$this->load->datatable_template('superadmin/centerview', $data);
	}

	//center Datatable View
	function dtcenter(){
		$data=$this->am->dtcenter();
		echo json_encode($data);
	}

	//Delete Admin info
	function delAdmin(){
		$data=$this->am->delAdmin();
		echo json_encode($data);
	}

	//Admin Add Page
	public function adminadd(){
	    $data['thisPage'] = 'manageadmin';
	    $data['pgScript'] = 'adminadd';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='manageadmin'>Manage Admin</a>";
	    $data['title'] = 'Admin Entry';  
        $data['category'] = $this->cm->getCategory()->result();
	    $this->load->formentry_template('superadmin/adminadd', $data);
	}

    //Add New Admin
	function addAdmin(){
		$data=$this->am->addAdmin();
		echo json_encode($data);
	}

	 //Company Edit Page
	 public function adminedit(){
	    $data['thisPage'] = 'manageadmin';
	    $data['pgScript'] = 'adminedit';
	    $data['thisPageLevel'] = '2';   
	    $data['thisPageMain']="<a href='manageadmin'>Manage Admin</a>";
	    $data['title'] = 'Admin Edit';  
        $data['category'] = $this->cm->getCategory()->result();
	    $this->load->formentry_template('superadmin/adminedit', $data);
	}

    //Update Company Info
	function updAdmin(){
		$data=$this->am->updAdmin();
		echo json_encode($data);
	}
/*=-Ends Admins-=*/

/*=-Starts Report-=*/
	//Client Report
	public function client_report(){
	    $data['thisPage'] = 'client_report';
	    $data['pgScript'] = 'client_report';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Client Report';  
		$data['category'] = $this->cm->getCategory()->result();
	    $this->load->formentry_template('superadmin/client_report', $data);
	}
	function genClientReport(){
		if(isset($_POST['submitpdf'])){
			$this->load->library('Pdfprs');
			$this->load->view('superadmin/clientreportpdf');
		}else{
			echo "excel";
		}
	}
	
	function genCClientReport(){
		if(isset($_POST['submitpdf'])){
			$this->load->library('Pdfprs');
			$this->load->view('superadmin/cclientreportpdf');
		}else{
			echo "excel";
		}
	}
/*=-Ends Report-=*/

/*=-Starts Profile Edit-=*/
	//Profile Add Page
	public function super_admin_profile(){
	    $data['thisPage'] = 'userprofile';
	    $data['pgScript'] = 'super_admin_profile';
	    $data['thisPageLevel'] = '1';   
	    $data['thisPageMain']="";
	    $data['title'] = 'Profile View';  
	    $this->load->formentry_template('superadmin/super_admin_profile', $data);
	}

    //Update Profile
	function updProfile(){
		$data=$this->pm->updProfile();
		echo json_encode($data);
	}
/*=-Ends Profile Edit-=*/
}