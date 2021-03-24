<?php
class PelangganModel extends CI_Model
{
	private $_table = 'tb_pelanggan';

	public function num_rows()
	{
		$data = $this->db->get('tb_pelanggan');
		return $data->num_rows();
	}
	public function getAllData()
	{
		$data = $this->db->get('tb_pelanggan');
		return $data->result();
	}
	public function insertPelanggan($arrData)
	{
		$data = $this->db->insert('tb_pelanggan', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function deleteData($id)
	{
		return $this->db->delete('tb_pelanggan', array('id' => $id));
	}

	public function deleteAllData()
	{
		return $this->db->empty_table('tb_pelanggan'); 
	}
}
?>