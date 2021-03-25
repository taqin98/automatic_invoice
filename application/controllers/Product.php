<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->library('session');
		$this->load->model('ProductModel');
	}

	public function index()
	{
		$this->load->view('admin/input_product');
	}

	public function input()
	{
		var_dump($this->input->post('upload_file', TRUE));

		// $config['upload_path'] = './assets/data/';
		// $config['allowed_types'] = 'gif|jpg|png|jpeg';
		// $config['max_size'] = 2000;
		// $config['overwrite'] = TRUE;


		$nm_foto = $_FILES['upload_file']['name'];
		$tmp_lokasi =$_FILES['upload_file']['tmp_name'];

		// $this->load->library('upload', $config);
		// $this->upload->initialize($config);

		$foto = "assets/data/".$nm_foto;
		$destination_path = getcwd().DIRECTORY_SEPARATOR;
		$target_path = $destination_path . 'assets/data/' . basename($_FILES["upload_file"]["name"]);
		// echo $target_path;
		// exit();
		

		// if (!$this->upload->do_upload('upload_file')) 
		if (!move_uploaded_file($tmp_lokasi, $target_path)) 
		{
			// $error = (object) array('error' => $this->upload->display_errors());
			$error = 'gagal upload';
			var_dump($error);
		} 
		else 
		{
			// $data = (object) array('image_metadata' => $this->upload->data());
			// $location = base_url().'assets/data/'.$data->image_metadata['file_name'];
			
			$produk_data = (object) array(
				// 'foto' => $data->image_metadata['file_name'],
				'foto' => $nm_foto,
				'nama' => $this->input->post('nama', TRUE),
				'deskripsi' => $this->input->post('des', TRUE),
				'panjang' => $this->input->post('panjang', TRUE),
				'lebar' => $this->input->post('lebar', TRUE),
				'tinggi' => $this->input->post('tinggi', TRUE),
				'qty' => $this->input->post('qty', TRUE),
				'harga' => $this->input->post('harga', TRUE)
			);

			var_dump($produk_data);
			$condition = $this->ProductModel->insertProduct($produk_data);
			if ($condition) {
				$this->session->set_flashdata('success','Data Berhasil Di Tambahkan');
				return redirect('product');
			}

			
		}
	}

}

/* End of file Invoice.php */
/* Location: ./application/controllers/Invoice.php */