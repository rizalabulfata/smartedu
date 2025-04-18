<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class kelas_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'namaLengkap',
				'label' => 'Nama Lengkap',
				'rules' => 'required'
			],
			
		];
	}

    public function insert()
	{
		$uuid = Uuid::uuid4()->toString();
        $namaLengkap = $this->input->post('namaLengkap');
        $username = $this->input->post('username');
        $password = 'edu12345';
		$mapel_uuid = $this->input->post('namaMapel');
        $jenisKelamin = $this->input->post('jenisKelamin');

		$data = array(
			'uuid' => $uuid,
			'nama' => $namaLengkap,
            'username' => $username,
            'mapel_uuid' => $mapel_uuid,
            'password' =>  password_hash($password, PASSWORD_DEFAULT),
            'jenis_kelamin' => $jenisKelamin,
			'created_by' => $this->session->userdata('uuid')
		);

		$this->db->insert('kelas', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function update($uuid)
	{
		$namaLengkap = $this->input->post('namaLengkap');
		$username = $this->input->post('username');
		$mapel_uuid = $this->input->post('namaMapel');
		$jenisKelamin = $this->input->post('jenisKelamin');
		$data = array(
			'nama' => $namaLengkap,
            'username' => $username,
            'mapel_uuid' => $mapel_uuid,
            'jenis_kelamin' => $jenisKelamin,
			'modified_at' => date("Y-m-d H:i:s")
		);
		$this->db->update('kelas', $data, array('uuid' => $uuid));
		return($this->db->affected_rows() > 0) ? true :false;
	}

	public function get_all()
	{
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('modified_at', 'DESC');
		$data = $this->db->get('kelas')->result();

		return $data;
	}

	public function delete_by_uuid($uuid)
	{
		$data = array(
			'deleted_at' => date("Y-m-d H:i:s")
		);
		$this->db->update('kelas', $data, array('uuid' => $uuid));
		return($this->db->affected_rows() > 0) ? true :false;
	}
	public function get_by_uuid($uuid)
	{
		$data = $this->db->get_where('kelas', array('uuid' => $uuid))->row();
		return $data;
	}

}
?>