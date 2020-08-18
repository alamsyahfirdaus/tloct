<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
		$this->form_validation->set_error_delimiters('', '');
	}

	private $folder = 'Halaman Utama';
	private $table  = 'user';


	public function index()
	{
		$data['breadcrumb'] 	= $this->folder;
		$data['users'] 			= $this->mall->count_data($this->table);
		$data['administration'] = $this->mall->count_data($this->table, ['user_type_id' => 1]);
		$data['teacher'] 		= $this->mall->count_data($this->table, ['user_type_id' => 2]);
		$data['student'] 		= $this->mall->count_data($this->table, ['user_type_id' => 3]);

		$this->library->view('content/home_view', $data);
	}

	public function profile()
	{
		$data   = [
			'breadcrumb' 	=> $this->folder, 
			'subtitle' 		=> 'Profile',
			'user' 			=> $this->library->session(),
		];
		
		$this->library->view('content/profile_index', $data);
	}

	public function editprofile()
	{
		$data = [
			'breadcrumb' 	=> $this->folder, 
			'subtitle' 		=> 'Profile',
			'user' 			=> $this->library->session(),
		];
		
		$this->library->view('content/profile_edit', $data);
	}

	public function editpassword()
	{
		$this->form_validation->set_rules('password', 'Password Lama', 'trim|required');
		$this->form_validation->set_rules('new_password1', 'Password Baru', 'trim|required|min_length[8]');

		$this->form_validation->set_rules('new_password2', 'Konfirmasi Password', 'trim|required|min_length[8]|matches[new_password1]', ['matches' => 'Konfirmasi Password tidak sama Password Baru']);

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('min_length', '{field} minimal {param} karakter');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'password' 		=> form_error('password'),
					'new_password1' => form_error('new_password1'),
					'new_password2' => form_error('new_password2')
				),
			];
			$this->library->output_json($data);
		} else {
			$user = $this->library->session();

			if ($user['password'] != md5($this->input->post('password'))) {
				$output = [
					'status'	=> FALSE,
					'errors'	=> array('password' => 'Password salah'),
				];
			} else {
				if ($user['password'] == md5($this->input->post('new_password1'))) {
					$output = [
						'status'	=> FALSE,
						'errors'	=> array('new_password1' => 'Password Baru tidak boleh sama dengan Password Lama'),
					];
				} else {
					$output = [
						'status' 	=> TRUE,
						'message'	=> 'Berhasil Mengubah Password',
					];
					$this->mall->update('user', array('user_id' => $user['user_id']), ['password' => md5($this->input->post('new_password1'))]);
				}
			}

			$this->library->output_json($output);
		}
	}

	public function save_editprofile($id = NULL)
	{
		$row = $this->mall->get_data('user', ['md5(user_id)' => $id])->row();

		if (!$row->user_id) {
			redirect('home/profile');
		}

		$iu_no_induk = @$row->no_induk == $this->input->post('no_induk') ? "" : "|is_unique[user.no_induk]";
		$iu_username	= @$row->username == $this->input->post('username') ? "" : "|is_unique[user.username]";
		$iu_phone	= @$row->phone == $this->input->post('phone') ? "" : "|is_unique[user.phone]";

		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('no_induk', 'No. Induk', 'trim|required|min_length[8]|numeric' . $iu_no_induk);
		$this->form_validation->set_rules('username', 'Username', 'trim|required' . $iu_username);
		$this->form_validation->set_rules('phone', 'No. Handphone', 'trim|required|min_length[11]|numeric' . $iu_phone);
		$this->form_validation->set_rules('birth_day', 'Tanggal Lahir', 'trim|required');

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('valid_email', '{field} tidak valid');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');
		$this->form_validation->set_message('min_length', '{field} minimal {param} angka');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'no_induk'		=> form_error('no_induk'),
					'full_name'		=> form_error('full_name'),
					'username'		=> form_error('username'),
					'phone'			=> form_error('phone'),
					'birth_day'	 	=> form_error('birth_day')
				),
			];
			$this->library->output_json($data);
		} else {
			$birth_day = date('Y-m-d', strtotime($this->input->post('birth_day')));

			$data = [
				'full_name' 	=> ucwords($this->input->post('full_name')),
				'no_induk' 		=> $this->input->post('no_induk'),
				'username'		=> strtolower($this->input->post('username')),
				'phone' 		=> $this->input->post('phone'),
				'birth_day' 	=> $birth_day
			];

			$this->_do_upload();
			if ($this->upload->do_upload('profile_pic')) {
			    if (@$row->profile_pic) {
			        unlink(IMAGE . $row->profile_pic);
			    }
			    $data['profile_pic'] = $this->upload->data('file_name');
			}

			$this->mall->update('user', ['user_id' => @$row->user_id], $data);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Profile');
			$this->library->output_json(['status' => TRUE]);
		}
	}

	private function _do_upload()
	{
        $config['upload_path']   = 	UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|GIF|JPG|PNG|JPEG|BMP|';
        $config['max_size']    	 = 10000;
        $config['max_width']   	 = 10000;
        $config['max_height']  	 = 10000;
        $config['file_name']     = 'profile_pic_' . time();
        $this->upload->initialize($config);
	}

	public function map()
	{
		$data = [
			'lat' 	=> $this->input->get_post('lat'),
			'lng' 	=> $this->input->get_post('lng'),
		];

	    $this->load->view('content/maps_view', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
