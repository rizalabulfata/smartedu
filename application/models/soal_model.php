<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class soal_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'soal',
				'label' => 'Soal',
				'rules' => 'required'
			]
		];
	}

	public function insert()
	{
		$uuid = Uuid::uuid4()->toString();
		$soal = $this->input->post('soal');
		$ujian_uuid = $this->input->post('ujian_uuid');
		$user = $this->session->userdata('uuid');

		$data = [
			'uuid' => $uuid,
			'ujian_uuid' => $ujian_uuid,
			'soal' => $soal,
			'created_by' => $user
		];
		
		$this->db->insert('ujian_soal', $data);
		if ($this->db->affected_rows() > 0) {
			return $uuid; 
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
	
	public function get_by_ujian_uuid($ujian_uuid)
	{
		$this->db->select("soal, uuid");
		$this->db->where('ujian_uuid', $ujian_uuid);
		$data = $this->db->get('ujian_soal');

		return $data->result();
	}

}
?>