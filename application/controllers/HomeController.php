<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    $this->load->helper('url');
	    $this->load->model('UserModel','um');  	    
	}

	public function index()
	{
		$data['title'] = "Login";
		$this->load->home_template('home', $data);
	}

	public function check_login(){       
	    $data['username']=htmlspecialchars($_POST['name']);  
	    $data['password']=htmlspecialchars($_POST['pwd']);  
	    $res=$this->um->islogin($data);  
		
	    if($res){  
	    	$data = array(
	    				'comid' => $res['id'],
	    				'mfg_id' => $res['mfg_id'],
	    				'comname' => $res['name'],
						'comcat' => $res['category'],
						'comtotprd' => $res['totalproduct'],
						'comtotqr' => $res['qr_quantity'],
						'role' => $res['role'],
                        'level' => $res['ulevel'],
						'status' => $res['status'],
						'regon' => $res['regon'],
						'memlog' => true
	    			); 
	    	$this->session->set_userdata($data);
			if($_SESSION['level']==="1"){
				echo base_url()."super_admin_dashboard";
			}
			elseif($_SESSION['level']==="2"){
				echo base_url()."admin_dashboard";
			}
			else{
				if($_SESSION['memlog']!="" && $_SESSION['comcat']==="1"){
					echo base_url()."sdashboard";	      		
				}
				elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="2"){
					echo base_url()."fldashboard";	      		
				}
				elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="3"){
					echo base_url()."midashboard";	      		
				}
				elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="4"){
					echo base_url()."cdashboard";	      		
				}
				elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="5"){
					echo base_url()."psdashboard";	      		
				}
				elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="6"){
					echo base_url()."fldashboard";	      		
				}
				elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="7"){
					echo base_url()."tpdashboard";	      		
				}
				else{
					echo base_url()."home";
				}
			}
	    }  
	    else{  
	       echo 0;  
	    }   
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->unset_userdata('memlog');
		redirect('home', 'refresh');
	}

	public function signup(){
		$data['title'] = "Sign Up";
		$data['category'] = $this->um->getCategory()->result();
		$data['rccategory'] = $this->um->getrcCategory()->result();
		$this->load->home_template('signup', $data);
	}

	function comregister(){
		$data=$this->um->comregister();
		echo json_encode($data);
	}

	function rcregister(){
		$data=$this->um->rcregister();
		echo json_encode($data);
	}

// 	public function check_login(){       
// 	    $data['username']=htmlspecialchars($_POST['name']);  
// 	    $res=$this->um->checkUser($data);  

// 		if (!filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
// 			echo 0;
// 			return;
// 		}

// 		$bypass_emails=['admin@wvs.in','sdtest@gmail.com','mitest@gmail.com','pstest@gmail.com','tptest@gmail.com','fltest@gmail.com'];

// 	    if($res){  

// 			if(in_array($data['username'],$bypass_emails)){

// 			  echo 'test_emails';
// 			  return;
			
// 			}else{
			
// 			$otp = rand(100000, 999999);

// 			$res2=$this->um->save_otp($otp,$res['id']);

//             if($res2){
// 				$this->load->library('email');

// 				$config = array(
// 					'protocol'  => 'smtp',
// 					'smtp_host' => 'smtp.gmail.com',
// 					'smtp_port' => 465,
// 					'smtp_user' => 'varun@wvs.in', 
// 					'smtp_pass' => 'Varunwvs28', 
// 					'smtp_crypto' => 'ssl',
// 					'mailtype'  => 'html',
// 					'charset'   => 'utf-8'
// 				);
// 				$this->email->initialize($config);
		
// 				$this->email->set_newline("\r\n");
// 				$this->email->from('varun@wvs.in', 'Kisaan QR');
// 				$this->email->to('varunss28299@gmail.com');
// 				$this->email->subject('Your OTP Code');
// 				$this->email->message('<p>Your OTP is: <strong>' . $otp . '</strong></p>');
		
// 				if ($this->email->send()) {
					
// 					echo 'success';
// 				} else {
// 					echo 'failed';
// 				}
	
// 			}else{
// 				echo 'error';
// 			}

// 		}
	
// 	}else{  
// 	       echo 0;  
// 	}   
// }

	public function verify_login_otp(){
		$data['username']=htmlspecialchars($_POST['name']);  
		$input_otp=htmlspecialchars($_POST['otp']);  

		$res=$this->um->checkUser($data);  

	if($res){  
		$res2= $this->um->check_otp($input_otp,$res['otp']);

		if ($res2=='success') {
			
				$data = array(
							'comid' => $res['id'],
							'mfg_id' => $res['mfg_id'],
							'comname' => $res['name'],
							'comcat' => $res['category'],
							'comtotprd' => $res['totalproduct'],
							'comtotqr' => $res['qr_quantity'],
							'role' => $res['role'],
							'level' => $res['ulevel'],
							'status' => $res['status'],
							'regon' => $res['regon'],
							'memlog' => true
						); 
				$this->session->set_userdata($data);
				if($_SESSION['level']==="1"){
					echo base_url()."super_admin_dashboard";
				}
				elseif($_SESSION['level']==="2"){
					echo base_url()."admin_dashboard";
				}
				else{
					if($_SESSION['memlog']!="" && $_SESSION['comcat']==="1"){
						echo base_url()."sdashboard";	      		
					}
					elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="2"){
						echo base_url()."fldashboard";	      		
					}
					elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="3"){
						echo base_url()."midashboard";	      		
					}
					elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="4"){
						echo base_url()."cdashboard";	      		
					}
					elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="5"){
						echo base_url()."psdashboard";	      		
					}
					elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="6"){
						echo base_url()."fldashboard";	      		
					}
					elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="7"){
						echo base_url()."tpdashboard";	      		
					}
					else{
						echo base_url()."home";
					}
				}
			  
			
		}elseif($res2=='invalid'){
			echo 'otp_invalid';
		}else{
			echo 'timeUp';
		}
	}else{  
		echo 0;  
	 } 

	   

	}

public function check_password_login(){
	$data['username']=htmlspecialchars($_POST['name']);  
	$data['password']=htmlspecialchars($_POST['pwd']);  
	$res=$this->um->islogin($data);  
	
	if($res){  
		$data = array(
					'comid' => $res['id'],
					'mfg_id' => $res['mfg_id'],
					'comname' => $res['name'],
					'comcat' => $res['category'],
					'comtotprd' => $res['totalproduct'],
					'comtotqr' => $res['qr_quantity'],
					'role' => $res['role'],
					'level' => $res['ulevel'],
					'status' => $res['status'],
					'regon' => $res['regon'],
					'memlog' => true
				); 
		$this->session->set_userdata($data);
		if($_SESSION['level']==="1"){
			echo base_url()."super_admin_dashboard";
		}
		elseif($_SESSION['level']==="2"){
			echo base_url()."admin_dashboard";
		}
		else{
			if($_SESSION['memlog']!="" && $_SESSION['comcat']==="1"){
				echo base_url()."sdashboard";	      		
			}
			elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="2"){
				echo base_url()."fldashboard";	      		
			}
			elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="3"){
				echo base_url()."midashboard";	      		
			}
			elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="4"){
				echo base_url()."cdashboard";	      		
			}
			elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="5"){
				echo base_url()."psdashboard";	      		
			}
			elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="6"){
				echo base_url()."fldashboard";	      		
			}
			elseif($_SESSION['memlog']!="" && $_SESSION['comcat']==="7"){
				echo base_url()."tpdashboard";	      		
			}
			else{
				echo base_url()."home";
			}
		}
	}  
	else{  
	   echo 0;  
	}  
}	


	
}