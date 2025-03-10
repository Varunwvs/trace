<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeedBatchApiController extends CI_Controller {
    
    public function __construct($config = "rest")
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
        parent::__construct();

        $this->load->model('app/seed/BatchApiModel','bam');
    }

    public function batch_insert() {

        $headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $response = [
                'status' => 405,
                'message' => 'Method Not Allowed'
            ];
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(405)
                ->set_output(json_encode($response));
        }
    
        $data = json_decode($this->input->raw_input_stream, true);
    
        if (empty($data) || !is_array($data)) {
            $response = [
                'status' => 400,
                'message' => 'Invalid input data'
            ];
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($response));
        }
    

        $assignedCenters = $decodedToken['data']->assignedCenters;

        // Prepare batch insert data
        $batch_data = [];
        foreach ($data as $row) {
            if (!isset($row['productCode'], $row['batchNumber'], $row['quantity'], $row['mfgDate'], $row['expDate'], $row['centreCode'])) {
                $response = [
                    'status' => 400,
                    'message' => 'Missing required fields'
                ];
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode($response));
            }

                 // Fetch center ID using centreCode
                 $centerId = $this->bam->get_center_id_by_code($row['centreCode']);

                 // Check if the center ID is in the token's assigned centers
                 if (!in_array($centerId, $assignedCenters)) {
                     return $this->output
                         ->set_content_type('application/json')
                         ->set_status_header(403)
                         ->set_output(json_encode(['status' => 403, 'message' => 'Access Denied']));
                 }
    
            $batch_data[] = [
                'product_code' => $row['productCode'],
                'batch_number' => $row['batchNumber'],
                'quantity' => (int) $row['quantity'],
                'mfg_date' => date('Y-m-d', strtotime($row['mfgDate'])), 
                'exp_date' => date('Y-m-d', strtotime($row['expDate'])), 
                'centre_code' => $row['centreCode'],
            ];
        }

        // $role = $decodedToken['data']->userRole;
        $admin_id=$decodedToken['data']->adminId;
    
        // Insert into database
        $results = $this->bam->add_batch_data($batch_data,$centerId,$admin_id);
    
        $success = true;
        $messages = [];
        $aliasCodes = [];
        
    
        foreach ($results as $result) {
            if (!$result['success']) {
                $success = false;
            }
            $messages[] = $result['message'];
            $aliasCodes = array_merge($aliasCodes, $result['aliasCodes']);
        }
    
        if ($success) {
            $response = [
                'status' => 200,
                'message' => implode('; ', $messages),
                'aliasCodes' => $aliasCodes
            ];
        } else {
            $response = [
                'status' => 500,
                'message' => implode('; ', $messages),
                'aliasCodes' => $aliasCodes
            ];
        }
    
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($response['status'])
            ->set_output(json_encode($response));


        } else {
            return $this->sendJson(array("status" => false, "response" => "Invalid Token"));
        }
        } else {
        return $this->sendJson(array("status" => true, "response" => "Token Required"));
        }      
    }

    private function sendJson($data)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
    
    
}
