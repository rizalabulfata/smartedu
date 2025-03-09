<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class panduan_model extends CI_Model {

    public function rules()
	{
		return[
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
	}

    public function insert($berkas)
	{
		$uuid = Uuid::uuid4()->toString();
        $judul = $this->input->post('judul');
        $tujuan = $this->input->post('tujuan');

		$data = array(
			'uuid' => $uuid,
			'judul' => $judul,
			'berkas' => $berkas,
			'tujuan' => $tujuan
		);

		$this->db->insert('panduan', $data);
		$this->db->last_query();  // Menampilkan query terakhir yang dijalankan

		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function get_all()
	{
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('modified_at', 'DESC');
		$data = $this->db->get('panduan')->result();

		foreach ($data as $key) {
			$key->tujuan = ($key->tujuan == 1) ? 'Guru' : 'Siswa';
		}

		return $data;
	}

	public function delete_by_uuid($uuid)
	{
		$this->db->where('uuid', $uuid);
		return $this->db->delete('panduan');
	}
}
?>