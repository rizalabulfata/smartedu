<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class ujian_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'namaUjian',
				'label' => 'Nama Ujian',
				'rules' => 'required'
			],
			[
				'field' => 'tgl_mulai',
				'label' => 'Tanggal Mulai',
				'rules' => 'required'
			],
			[
				'field' => 'tgl_selesai',
				'label' => 'Tanggal Selesai',
				'rules' => 'required'
			]
		];
	}

	public function get_all()
	{
		$this->db->select("u.*,m.nama AS mapel_nama, DATE_FORMAT(u.tgl_mulai, '%d-%m-%Y %H:%m') as tgl_mulai_formatted, DATE_FORMAT(u.tgl_selesai, '%d-%m-%Y %H:%m') as tgl_selesai_formatted, g.nama AS guru_nama", FALSE);
		$this->db->from('ujian u');
		$this->db->join('guru g', 'g.uuid = u.created_by', 'left');
		$this->db->join('mapel m', 'm.uuid = u.mapel_uuid', 'left');
		$this->db->where('u.deleted_at', NULL, FALSE);
		$this->db->order_by('u.modified_at', 'DESC');
		
		return $this->db->get()->result();
	}
	
    public function insert()
	{
		$uuid = Uuid::uuid4()->toString();
        $mapel_uuid = $this->input->post('namaMapel');
		$namaUjian = $this->input->post('namaUjian');
		$tgl_mulai = $this->input->post('tgl_mulai');
		$tgl_selesai = $this->input->post('tgl_selesai');
		$user = $this->session->userdata('uuid');

		$data = array(
			'uuid' => $uuid,
			'mapel_uuid' => $mapel_uuid,
			'nama' => $namaUjian,
			'tgl_mulai' => $tgl_mulai,
			'tgl_selesai' => $tgl_selesai,
			'created_by' => $user
		);

		$this->db->insert('ujian', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_by_uuid($uuid)
	{
		$data = array(
			'deleted_at' => date("Y-m-d H:i:s")
		);
		$this->db->update('ujian', $data, array('uuid' => $uuid));
		return($this->db->affected_rows() > 0) ? true :false;
	}

	public function get_by_uuid($uuid)
	{
		$data = $this->db->get_where('ujian', array('uuid' => $uuid))->row();
		
		return $data;
	}

	// public function get_all_ujian_with_peserta()
	// {
	// 	$this->db->select("
	// 		u.uuid AS ujian_uuid,
	// 		u.nama AS nama_ujian,
	// 		g.nama AS guru_nama,
	// 		m.nama AS mapel_nama,
	// 		GROUP_CONCAT(s.uuid ORDER BY s.nama SEPARATOR ',') AS peserta_uuid,
	// 		GROUP_CONCAT(s.nama ORDER BY s.nama SEPARATOR ', ') AS peserta_nama
	// 	");
	// 	$this->db->from('ujian u');
	// 	$this->db->join('ujian_siswa us', 'us.ujian_uuid = u.uuid', 'left');
	// 	$this->db->join('siswa s', 's.uuid = us.siswa_uuid', 'left');
	// 	$this->db->join('guru g', 'g.uuid = u.created_by', 'left');
	// 	$this->db->join('mapel m', 'm.uuid = u.mapel_uuid', 'left');
	// 	$this->db->group_by('u.uuid');
	// 	$this->db->order_by('u.id', 'ASC');

	// 	$query = $this->db->get();
	// 	$result = $query->result_array();

	// 	// **Proses hasil query agar peserta tetap berbentuk array**
	// 	foreach ($result as &$row) {
	// 		$peserta_uuid = !empty($row['peserta_uuid']) ? explode(',', $row['peserta_uuid']) : [];
	// 		$peserta_nama = !empty($row['peserta_nama']) ? explode(', ', $row['peserta_nama']) : [];
		
	// 		$row['peserta'] = [];
	// 		foreach ($peserta_uuid as $index => $uuid) {
	// 			$row['peserta'][] = [
	// 				'siswa_uuid' => $uuid,
	// 				'nama_siswa' => $peserta_nama[$index] ?? ''
	// 			];
	// 		}
		
	// 		unset($row['peserta_uuid'], $row['peserta_nama']);
	// 	}
		

	// 	return $result;
	// }


	// public function pengerjaan()
	// {
    // $ujian_uuid = $this->input->post('ujian_uuid');
    // $jawaban = $this->input->post('jawaban');

    // foreach ($jawaban as $soal_uuid => $jawaban_siswa) {
    //     $data = [
    //         'ujian_uuid' => $ujian_uuid,
    //         'soal_uuid' => $soal_uuid,
    //         'jawaban_siswa' => $jawaban_siswa,
    //         'created_by' => $this->session->userdata('uuid')
    //     ];
    //     $this->db->insert('ujian_jawaban', $data);
    // }

    // redirect('ujian');
	// }

	public function get_jawaban_siswa_by_ujian_siswa_uuid($ujian_uuid , $siswa_uuid)
	{
		$this->db->select(
			'uj.*, uo.*, u.*'
		);
		$this->db->from('ujian u');
		$this->db->join('ujian_soal uo', 'uo.ujian_uuid = u.uuid', 'left');
		$this->db->join('ujian_jawaban uj', 'uj.soal_uuid = uo.uuid', 'left');
		$this->db->where('u.uuid', $ujian_uuid);
		$this->db->where('uj.created_by', $siswa_uuid);
		$this->db->order_by('uj.created_by', 'DESC');
		
		return $this->db->get()->result();
	}

}
?>