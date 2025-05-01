<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalender extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// $this->load->model('kalender_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		// $kalender = $this->kalender_model->get_all();

		$data = array(
			// 'kalender' => $kalender,
			'active_nav' => 'kalender'
		);
		
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('kalender/kalender');
		$this->load->view('partials/footer');
	}
}