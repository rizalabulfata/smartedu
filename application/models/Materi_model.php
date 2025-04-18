<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class materi_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'judul',
				'label' => 'Judul materi',
				'rules' => 'required'
			],
			[
				'field' => 'namaMapel',
				'label' => 'Mata Pelajaran',
				'rules' => 'required'
			],
			// [
			// 	'field' => 'berkas',
			// 	'label' => 'File materi'
			// ],
			// [
			// 	'field' => 'thumbnail',
			// 	'label' => 'File thumbnail'
			// ]
        ];
	}

	public function insert($thumbnail, $berkas) {
		$uuid = Uuid::uuid4()->toString();
		$judul = $this->input->post('judul');
		$mapel_uuid = $this->input->post('namaMapel');

		$data = array(
			'uuid'      => $uuid,
			'mapel_uuid'     => $mapel_uuid,
			'judul'     => $judul,
			'thumbnail' => $thumbnail,
			'berkas'      => $berkas,
			'created_by' => $this->session->userdata('uuid')
		);
		$this->db->insert('materi', $data);
		return ($this->db->affected_rows() > 0);
	}

	public function get_all()
	{
		
		$this->db->join('guru g', 'm.created_by = g.uuid', 'left');
		$this->db->where('m.deleted_at', NULL, FALSE);
		$this->db->order_by('m.modified_at', 'DESC');
		$data = $this->db->get('materi m')->result();

		return $data;
	} 

	
}
?>