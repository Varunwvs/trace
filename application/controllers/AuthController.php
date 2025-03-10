<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{

    public function __construct($config = "rest")
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
        parent::__construct();

        $this->load->model('UserModel','um'); 
    }

    public function login()
    {
        if ($this->input->method() === 'post') {
            $data['username'] = $this->input->post('email');
            $data['password'] = $this->input->post('password');

            $res=$this->um->check_login_auth($data);  

            if ($res) {
                $token_data['userEmail'] = $data['username'];
                $token_data['userRole'] = $res['role'];
                $token_data['adminId'] = $res['id'];

                // Extract the first 3 letters of the role
                $rolePrefix = substr($res['role'], 0, 3);
                $centerrole=$rolePrefix.'center';

                $centers = $this->um->get_centers_matching_role($centerrole); 
            
                // Store in token
                $token_data['assignedCenters'] = array_column($centers, 'id'); 

                $tokenData = $this->authorization_token->generateToken($token_data);


                return $this->sendJson(array("token" => $tokenData, "status" => true, "response" => "Login Success!"));
            } else {
                return $this->sendJson(array("token" => null, "status" => false, "response" => "Login Failed!"));
            }
        } else {
            return $this->sendJson(array("message" => "POST Method", "status" => false));
        }
    }

    private function sendJson($data)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}