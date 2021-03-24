<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->library('session');
		$this->load->model('PelangganModel');
	}

	public function index()
	{
		// $pelanggan = $this->PelangganModel->num_rows();
		// echo $pelanggan;
		if($this->PelangganModel->num_rows() == 0){
			$this->load->view('admin/input_pelanggan');
		} else {
			$this->session->set_flashdata('danger','Anda Sudah Memasukkan Pemesan '. $this->PelangganModel->num_rows());
			return redirect('users/dashboard_admin', $data);
		}
			
	}

	public function input()
	{
		$pelanggan_data = (object) array(
			'nama' => $this->input->post('nama', TRUE),
			'alamat' => $this->input->post('alm', TRUE),
			'hp' => $this->input->post('hp', TRUE)
		);

		$condition = $this->PelangganModel->insertPelanggan($pelanggan_data);
		if ($condition) {
			$this->session->set_flashdata('success','Data Berhasil Di Tambahkan');
			return redirect('users/dashboard_admin');
		}
	}

}

/* End of file Pelanggan.php */
/* Location: ./application/controllers/Pelanggan.php */