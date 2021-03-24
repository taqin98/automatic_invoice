<?php
class UserModel extends CI_Model
{
	private $_table = 'tb_users';
	
	public function login($email, $pass)
	{
		$data = $this->db->get_where('tb_users',array('email'=>$email,'password' => md5($pass)));
		if ($data->row() !== NULL) {
			//berhasil login
			return $data->row();
		} else {
			//gagal login
			return $data->row();
		}
	}

	public function check_login($level)
	{
		if ($this->session->userdata('level') == 1) {
			# code...
			// echo "<script>";
			// echo "alert('admin');";
			// echo "</script>";
			return $this->load->view('admin/dashboard_admin');
		} else {
			// echo "<script>";
			// echo "alert('gagal');";
			// echo "</script>";
			return redirect('users','refresh');
		}
		// switch ($this->session->userdata('level')) {
		// 	case 1:
		// 		$this->load->view('admin/dashboard_admin');
		// 		break;
		// 	case 2:
		// 		$this->load->view('admin/dashboard_user');
		// 		break;
		// 	default:
		// 	$this->session->set_flashdata('danger','Anda Harus login');
		// 	return $this->load->view('login');
		// 	// return redirect('users','refresh');
		// 	// $data["heading"] = "404 Page Not Found";
		// 	// $data["message"] = "The page you requested was not found";
		// 	// $this->load->view('errors/html/mobile_404',$data);
		// 	break;
		// }
	}
}
?>