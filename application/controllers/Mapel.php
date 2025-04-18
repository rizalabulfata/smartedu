<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapel extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('mapel_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('login');
		}
	}

	public function index()
	{
		$data = array(
			'mapel' => $this->mapel_model->get_all(),
			'active_nav' => 'mapel'
		);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');
		$this->load->view('mapel/mapel', $data);
		$this->load->view('partials/footer');
	}

	public function tambah()
	{
		$rules = $this->mapel_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->mapel_model->insert();
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data mata pelajaran berhasil di simpan');
				// redirect('mapel');
			} else {
				$this->session->set_flashdata('error_msg', 'Data mata pelajaran gagal di simpan');
			}
			redirect('mapel');
		}

		$data = array(
			'active_nav' => 'mapel'
		);

		$this->load->view('partials/header', $data);
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar', $data);
		$this->load->view('mapel/mapel-tambah', $data);
		$this->load->view('partials/footer');
	}

	public function edit($uuid)
	{
		$rules = [
			[
				'field' => 'namaMapel',
				'label' => 'Nama Mata Pelajaran',
				'rules' => 'required'
			]
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->mapel_model->update($uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data Mata Pelajaran berhasil di Update');
				redirect('mapel');
			} else {
				$this->session->set_flashdata('error_msg', 'Data Mata Pelajaran gagal di Update');
				redirect('mapel');
			}
		}

		$data = array(
			'mapel' => $this->mapel_model->get_by_uuid($uuid),
			'active_nav' => 'mapel'
		);

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');
		$this->load->view('mapel/mapel-edit', $data);
		$this->load->view('partials/footer');
	}

	public function hapus($uuid)
	{ {
			$result = $this->mapel_model->delete_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data mata pelajaran berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data mata pelajaran');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}
