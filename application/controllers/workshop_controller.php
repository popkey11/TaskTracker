<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class workshop_controller extends CI_Controller {

	public function __construct()
	{
			parent::__construct();

			$this->load->model('Task_model');

	}
    function index(){
		
        $this->load->view('workshop_LiveSearch');
    }

	function workshopAPI(){
		$this->load->view('workshop_api');
	}

	function sendURL(){
		$method = $this->input->post('method'); //GET,POST
		$url = $this->input->post('url');
		$body = $this->input->post('body')??'';
		$body = json_decode($body, true);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST => strtoupper($method),
			CURLOPT_SSL_VERIFYPEER => false, 
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH']) && !empty($body)) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
		}

		$response = curl_exec($curl);

		if (curl_errno($curl)) {
			$error = curl_error($curl);
			curl_close($curl);

			http_response_code(500);
			echo json_encode(['error' => $error]);
			exit;
		}

		curl_close($curl);

		http_response_code(200);
		echo $response;
	}
}
?>