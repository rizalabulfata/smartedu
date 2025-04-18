<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proyek extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mapel_model');
		$this->load->model('proyek_model');
		$this->load->model('guru_model');
		$this->load->model('komentar_model');
		$this->load->model('kelompok_model');
		$this->load->model('jawaban_model');
		$this->load->model('siswa_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('login');
		}
	}

	public function index()
	{
		$user_login = $this->session->userdata('uuid');
		$proyek =  $this->proyek_model->get_all();
		foreach ($proyek as $py) {
			$pengerjaan = 0;
			$peserta = $this->kelompok_model->is_siswa_exist($user_login, $py->uuid);
			if (!empty($peserta)) {
				$pengerjaan = 1;
			}
			$py->pengerjaan = $pengerjaan;

			if ($py->mapel_uuid != NULL) {
				$mapel = $this->mapel_model->get_by_uuid($py->mapel_uuid);
				$py->mapel = $mapel->nama;
			}
			$guru = $this->guru_model->get_by_uuid($py->created_by);
			$py->guru = $guru->nama;
		}

		$data = array(
			'proyek' => $proyek,
			'guru' => $guru,
			'active_nav' => 'proyek'
		);

		// echo"<pre>";
		// print_r($data);
		// echo"</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');
		$this->load->view('proyek/proyek', $data);
		$this->load->view('partials/footer');
	}

	public function tambah()
	{
		$rules = $this->proyek_model->rules();
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {
			$this->load->library('upload');

			$config = array(
				'upload_path' => "./uploads/proyek/",
				'allowed_types' => "jpg|png|jpeg|pdf|docx|pptx|mp4|avi|mov|mkv",
				'max_size'      => 50000,
				'encrypt_name'  => TRUE
			);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('berkas')) {
				$this->session->set_flashdata('error_msg', 'Gagal mengunggah berkas: ' . $this->upload->display_errors());
			} else {
				$data = $this->upload->data();
				$berkas = $data['file_name'];
				$insert = $this->proyek_model->insert($berkas);
				if ($insert) {
					$this->session->set_flashdata('success_msg', 'Data proyek berhasil disimpan');

					$action = $this->input->post('action');
					if ($action == 'simpan') {
						redirect('proyek');
					} elseif ($action == 'simpan_detail') {
						redirect('proyek/detail/' . $insert);
					}
				} else {
					$this->session->set_flashdata('error_msg', 'Gagal menyimpan data proyek');
					redirect('proyek/tambah');
				}
			}
		}
		$mapel = $this->mapel_model->get_all();
		$data = array(
			'mapel' => $mapel,
			'active_nav' => 'proyek'
		);

		$this->load->view('partials/header', $data);
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar', $data);
		$this->load->view('proyek/proyek-tambah', $data);
		$this->load->view('partials/footer');
	}

	public function hapus($uuid)
	{ {
			$result = $this->proyek_model->delete_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data proyek berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data proyek');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function detail($proyek_uuid)
	{
		$proyek = $this->proyek_model->get_by_uuid($proyek_uuid);
		$kelompok = $this->kelompok_model->get_by_proyek_uuid($proyek_uuid);
		$user_login = $this->session->userdata('uuid');
		$komentar = $this->komentar_model->get_by_proyek_uuid($proyek_uuid);

		$pengerjaan = false;
		$kelompok_nama = null;
		$kelompok_siswa = null;

		foreach ($kelompok as &$k) {
			$peserta = $this->siswa_model->get_by_kelompok_uuid($k['kelompok_uuid']);
			foreach ($peserta as &$s) {
				if ($s->siswa_uuid == $user_login) {
					$kelompok_nama = $k['kelompok'];
					$kelompok_siswa = $k['kelompok_uuid'];
					$pengerjaan = true;
					break 2;
				}
			}
		}

		//cek apakah sudah mengumpulkan
		$pengumpulan = false;
		if ($this->jawaban_model->get_by_kelompok_uuid($kelompok_siswa)) {
			$pengumpulan = true;
		}

		//cari nama pengomentar
		foreach ($komentar as $kom) {
			$nama_guru = $this->guru_model->get_by_uuid($kom->created_by);
			if (!$nama_guru) {
				$nama_siswa = $this->siswa_model->get_by_uuid($kom->created_by);
				$kom->pengomen = $nama_siswa->nama;
			} else {
				$kom->pengomen = $nama_guru->nama;
			}
		}

		$data = array(
			'kelompok_nama' => $kelompok_nama,
			'kelompok_siswa' => $kelompok_siswa,
			'pengumpulan' => $pengumpulan,
			'pengerjaan' => $pengerjaan,
			'proyek' => $proyek,
			'kelompok' => $kelompok,
			'komentar' => $komentar,
			'jawaban' => $this->jawaban_model->get_by_proyek_uuid($proyek->uuid),
			'guru' => $this->guru_model->get_by_uuid($proyek->created_by),
			'active_nav' => 'proyek'
		);

		// echo "<pre>";
		// print_r($data['jawaban']);
		// echo "</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');
		$this->load->view('proyek/proyek-detail', $data);
		$this->load->view('partials/footer');
	}

	public function pilih_siswa($proyek_uuid)
	{
		$proyek = $this->proyek_model->get_by_uuid($proyek_uuid);
		$kelompok = $this->kelompok_model->get_by_proyek_uuid($proyek_uuid);
		$siswa = $this->siswa_model->get_all();
		$data = array(
			'proyek' => $proyek,
			'kelompok' => $kelompok,
			'siswa' => $siswa,
			'active_nav' => 'proyek'
		);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
		$this->load->view('partials/topbar');
		$this->load->view('proyek/proyek-pilih-siswa', $data);
		$this->load->view('partials/footer');
	}

	public function kumpulkan($proyek_uuid)
	{

		$jawaban_text = $this->input->post('jawaban_text');
		$this->load->library('upload');

		if (!empty($_FILES['jawaban_file']['name'])) {
			// Konfigurasi upload
			$config['upload_path']   = './uploads/jawaban/';
			$config['allowed_types'] = 'jpg|png|jpeg|pdf|docx|pptx|mp4|avi|mov|mkv';
			$config['max_size']      = 50000;
			$config['file_name']     = uniqid();

			$this->upload->initialize($config);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('jawaban_file')) {
				$file_data = $this->upload->data();
				$jawaban_file = $file_data['file_name']; // Nama file yang tersimpan
			} else {
				$this->session->set_flashdata('error_msg', $this->upload->display_errors());
				redirect('proyek/detail/' . $proyek_uuid);
			}
		} else {
			$jawaban_file = NULL;
		}
		if (empty($jawaban_text) && empty($jawaban_file)) {
			$this->session->set_flashdata('error_msg', 'Harap isi jawaban atau upload file.');
			redirect('proyek/detail/' . $proyek_uuid);
		}

		$kumpul = $this->jawaban_model->submit_proyek_answer($proyek_uuid, $jawaban_text, $jawaban_file);
		if ($kumpul) {
			$this->session->set_flashdata('success_msg', 'Jawaban berhasil disimpan');
		} else {
			echo $kumpul;
			die;
			$this->session->set_flashdata('error_msg', 'Jawaban gagal disimpan');
		}
		redirect('proyek/detail/' . $proyek_uuid);
	}

	public function hapus_jawaban_proyek($uuid)
	{ {
			$result = $this->jawaban_model->delete_jawaban_proyek_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data jawaban proyek berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data jawaban proyek');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function nilai_jawaban_proyek($jawaban_uuid)
	{ {
			$nilai = $this->input->post('nilai_kelompok');

			$result = $this->jawaban_model->insert_nilai_jawaban_proyek_by_uuid($jawaban_uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Berhasil menilai jawaban proyek');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menilai jawaban proyek');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function komentar_tambah($proyek_uuid)
	{
		$rules = $this->komentar_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->komentar_model->insert($proyek_uuid);
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data komentar berhasil di simpan');
			} else {
				$this->session->set_flashdata('error_msg', 'Data komentar gagal di simpan');
			}
			redirect('proyek/detail/' . $proyek_uuid);
		}
		redirect('proyek/detail/' . $proyek_uuid);
	}
}
