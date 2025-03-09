<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class panduan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('panduan_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$panduan = $this->panduan_model->get_all();

		$data = array(
			'panduan' => $panduan,
			'active_nav' => 'panduan'
		);
		
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar');
        $this->load->view('partials/topbar');
        $this->load->view('panduan/panduan', $data);
		$this->load->view('partials/footer');
	}

	public function tambah()
	{
        $rules = $this->panduan_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {

			$config = array(
                'upload_path' => "./uploads/panduan/",
                'allowed_types' => "jpg|png|jpeg|pdf",
                'overwrite' => TRUE,
                'max_size' => "5120",
                'encrypt_name' => TRUE
            );
			$this->load->library('upload', $config);
			
            if (!$this->upload->do_upload('berkas')) {
				$this->session->set_flashdata('error_msg', 'Gagal mengunggah berkas: ' . $this->upload->display_errors());
			}
			else {
				$data = $this->upload->data();
                $berkas = $data['file_name'];
				$insert = $this->panduan_model->insert($berkas);
				if ($insert) {
					$this->session->set_flashdata('success_msg', 'Data panduan berhasil disimpan');
					// redirect('panduan');
				} else {
					$this->session->set_flashdata('error_msg', 'Data panduan gagal disimpan');
				}
			}
			redirect('panduan');
		}

		$data = array(
			'active_nav' => 'panduan'
		);

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar');
        $this->load->view('partials/topbar');
        $this->load->view('panduan/panduan-tambah', $data);
		$this->load->view('partials/footer');;
	}

	public function edit($uuid){
		$rules = [
			[
				'field' => 'judul',
				'label' => 'Judul',
				'rules' => 'required'
			],
			[
				'field' => 'berkas',
				'label' => 'Berkas Panduan',
				'rules' => 'uploaded[berkas]|max_size[berkas,5120]' // 5MB
			],
			[
				'field' => 'tujuan',
				'label' => 'Tujuan',
				'rules' => 'required'
			]
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->panduan_model->update($uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data Mata Pelajaran berhasil di Update');
				redirect('panduan');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Mata Pelajaran gagal di Update');
				redirect('panduan');
			}
		}

		$data = array(
			'panduan' => $this->panduan_model->get_by_uuid($uuid),
			'active_nav' => 'panduan'
		);
		// 		echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
        $this->load->view('partials/topbar');
        $this->load->view('panduan/panduan-edit', $data);
		$this->load->view('partials/footer');
	}

	public function hapus($uuid)
	{
		$this->load->model('panduan_model');
		$result = $this->panduan_model->delete_by_uuid($uuid);
		if ($result) {
			$this->session->set_flashdata('success_msg', 'Data Panduan berhasil dihapus');
		} else {
			$this->session->set_flashdata('error_msg', 'Gagal menghapus data Panduan');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
    
}