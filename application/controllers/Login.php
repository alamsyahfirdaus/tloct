<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	private $table = 'user';

	public function index()
	{
		logout();
		$data = array('title' => 'Login');

		$this->form_validation->set_rules('username', '', 'trim|required');
		$this->form_validation->set_rules('password', '', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/login_view', $data);
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$user  = $this->mall->get_data($this->table, ['username' => $this->input->post('username')])->row();

		if ($user) {
			if ($user->user_type_id == 1) {
				if ($user->password == md5($this->input->post('password'))) {
					$this->session->set_userdata('login', $user->user_id);
					redirect('home');
				} else {
					$this->session->set_flashdata('error', 'Password Salah');
					redirect('login');
				}
			} else {
				$this->session->set_flashdata('error', 'Login Gagal');
				redirect('login');
			}
		} else {
			$this->session->set_flashdata('error', 'Username Belum Terdaftar');
			redirect('login');
		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
