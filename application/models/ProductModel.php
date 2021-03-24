<?php
class ProductModel extends CI_Model
{
	private $_table = 'tb_product';

	public function getAllData()
	{
		$data = $this->db->get('tb_product');
		return $data->result();
	}
	public function insertProduct($arrData)
	{
		$data = $this->db->insert('tb_product', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function deleteData($id)
	{
		return $this->db->delete('tb_product', array('id' => $id));
	}
	public function deleteAllData()
	{
		return $this->db->empty_table('tb_product'); 
	}
}
?>