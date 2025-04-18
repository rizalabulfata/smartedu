<?php
defined('BASEPATH') or exit('No direct script access allowed');

class siswa extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('siswa_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('login');
		}
	}

	public function index()
	{
		$siswa = $this->siswa_model->get_all();

		$data = array(
			'siswa' => $siswa,
			'active_nav' => 'siswa'
		);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');
		$this->load->view('siswa/siswa', $data);
		$this->load->view('partials/footer');
	}

	public function tambah()
	{
		$rules = $this->siswa_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->siswa_model->insert();
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data Siswa berhasil di simpan');
				redirect('siswa');
			} else {
				$this->session->set_flashdata('error_msg', 'Data Siswa gagal di simpan');
				redirect('siswa');
			}
		}

		$data = array(
			'active_nav' => 'siswa'
		);

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');
		$this->load->view('siswa/siswa-tambah', $data);
		$this->load->view('partials/footer');;
	}
}
