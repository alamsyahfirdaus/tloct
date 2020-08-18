<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
		$this->form_validation->set_error_delimiters('', '');
		$this->load->model('Users_model', 'um');
	}

	private $folder 	= 'Master';
	private $table 		= 'user';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title'			=> 'Pengguna',
			'head'			=> 'Daftar Pengguna',
		];

		$this->library->view('content/users_index', $data);
	}

	public function show_datatables()
	{
		$data = $this->um->get_datatables();
		echo json_encode($data);
	}

	public function administration()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title'			=> 'Administrator',
			'user_type_id' 	=> 1, 
		];

		$this->library->view('content/users_index', $data);
	}

	public function teacher()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title'			=> 'Dosen',
			'user_type_id'	=> 2, 
		];

		$this->library->view('content/users_index', $data);
	}

	public function student()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title'			=> 'Mahasiswa',
			'user_type_id'	=> 3, 
		];

		$this->library->view('content/users_index', $data);
	}

	public function insert($user_type_id = NULL)
	{
		$user_type = $this->mall->get_data('user_type', ['md5(user_type_id)' => $user_type_id])->row();
		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> 'Tambah',
			'title'			=> @$user_type->type_name ? $user_type->type_name : 'Pengguna',
			'user_type'		=> $this->mall->get_data('user_type')->result(),
			'user_type_id'	=> @$user_type->user_type_id ? $user_type->user_type_id : $this->input->post('user_type_id'),
			'prodi' 	  	=> $this->mall->get_data('prodi')->result(),
			'room'			=> $this->mall->get_data('room')->result()
		];

		$this->library->view('content/users_addedit', $data);
	}

	public function edit($user_id = NULL)
	{
		$user = $this->um->get_data($user_id);

		if (!$user->user_id) {
			redirect('users');
		}

		$data = [
			'breadcrumb' => $this->folder,
			'title'		 => $user->type_name,
			'subtitle' 	 => 'Edit',
			'user'  	 => $user, 
			'user_type'	 => $this->mall->get_data('user_type')->result(),
			'prodi' 	 => $this->mall->get_data('prodi')->result(),
			'room'		 => $this->mall->get_data('room')->result()
		];

		if (@$user->user_type_id == 2) {
			$dosen = $this->um->get_dd($user->user_id);

			$data['detail_dosen_id']	= $dosen->detail_dosen_id;
			$data['room_id']			= $dosen->room_id;
			$data['latitude']			= $dosen->latitude;
			$data['longitude']			= $dosen->longitude;
		}

		$this->library->view('content/users_addedit', $data);
	}
	
	public function save()
	{
		$user = $this->um->get_data($this->input->post('user_id'));

		if (@$user) {
			$iu_username 	= $user->username != $this->input->post('username') ? "|is_unique[user.username]" : "";
			$iu_phone 		= $user->phone != $this->input->post('phone') ? "|is_unique[user.phone]" : "";
			$iu_ni 			= $user->phone != $this->input->post('phone') ? "|is_unique[user.phone]" : "";
		} else {
			$iu_username 	= '|is_unique[user.username]';
			$iu_phone 		= '|is_unique[user.phone]';
			$iu_ni 			= '|is_unique[user.no_induk]';
			$required		= '|required';
		}

		$this->form_validation->set_rules('no_induk', 'No. Induk', 'trim|required|min_length[8]|numeric' . $iu_ni, ['min_length' => 'No. Induk minimal {param} angka']);
		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('birth_day', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required' . $iu_username);
		$this->form_validation->set_rules('phone', 'No. Handphone', 'trim|required|min_length[11]|numeric' . $iu_phone, ['min_length' => 'No. Handphone minimal {param} angka']);
		$this->form_validation->set_rules('user_type_id', 'Jenis Pengguna', 'trim|required');
		$this->form_validation->set_rules('prodi_id', 'Program Studi', 'trim|required');
		$this->form_validation->set_rules('password1', 'Password', 'trim|min_length[8]' . @$required, ['min_length' => 'Password minimal {param} karakter']);
		$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|min_length[8]|matches[password1]' . @$required, ['min_length' => 'Konfirmasi Password minimal {param} karakter']);

		if ($this->input->post('detail_dosen_id') > 0 && $this->input->post('user_type_id') == 2) {
			$this->form_validation->set_rules('lat', 'Latitude', 'trim|required');
			$this->form_validation->set_rules('lng', 'Longitude', 'trim|required');
			$this->form_validation->set_rules('room_id', 'Ruangan', 'trim|required');
		}


		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');
		$this->form_validation->set_message('matches', 'Konfirmasi Password tidak sama');
		
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'no_induk'		=> form_error('no_induk'),
					'full_name'		=> form_error('full_name'),
					'username' 		=> form_error('username'),
					'birth_day' 	=> form_error('birth_day'),
					'phone' 		=> form_error('phone'),
					'user_type_id' 	=> form_error('user_type_id'),
					'prodi_id' 		=> form_error('prodi_id'),
					'password1' 	=> form_error('password1'),
					'password2' 	=> form_error('password2'),
				),
			];

			if ($this->input->post('detail_dosen_id') > 0 && $this->input->post('user_type_id') == 2) {
				$data['errors'] = array(
					'lat' 		=> form_error('lat'),
					'lng'		=> form_error('lng'),
					'room_id'	=> form_error('room_id')
				);

			}

			$this->library->output_json($data);
		} else {
			$birth_day = date('Y-m-d', strtotime($this->input->post('birth_day')));
			$prodi 	   = $this->mall->get_data('prodi', ['prodi_id' => $this->input->post('prodi_id')])->row();
			$user_type = $this->mall->get_data('user_type', ['user_type_id' => $this->input->post('user_type_id')])->row();
			$type_name = ucwords($user_type->type_name);


			$data = [
				'no_induk' 		=> $this->input->post('no_induk'),
				'username' 		=> strtolower($this->input->post('username')),
				'full_name'		=> ucwords($this->input->post('full_name')),
				'birth_day'		=> $birth_day,
				'phone'	   		=> $this->input->post('phone'),
				'sex'	   		=> '',
				'user_type_id'	=> $this->input->post('user_type_id'),
				'faculty_id'	=> $prodi->faculty_id,
				'prodi_id'		=> $prodi->prodi_id,
			];

			$this->_do_upload();
			if ($this->upload->do_upload('profile_pic')) {
			    if (isset($user->profile_pic)) {
			        unlink(IMAGE . $user->profile_pic);
			    }
			    $data['profile_pic'] = $this->upload->data('file_name');
			}

			if (@$user) {
				if ($this->input->post('password1')) {
					$data['password'] = md5($this->input->post('password1'));
				}

				$this->mall->update($this->table, ['user_id' => $user->user_id], $data);

				if ($this->input->post('user_type_id') == 2) {
					if ($user->user_type_id != $this->input->post('user_type_id')) {
						$output['id'] = md5($user->user_id);
					} else {
						$this->_detail_dosen($user->user_id);
						$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $type_name);
					}
				} else {
					$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $type_name);
				}

			} else {
				$data['password'] = md5($this->input->post('password1'));
				$insert_id = $this->mall->insert($this->table, $data);

				if ($this->input->post('user_type_id') == 2) {
					$output['id'] = md5($insert_id);
				} else {
					$this->session->set_flashdata('success', 'Berhasil Menambah ' . $type_name);
				}
			}

			$output['status'] = TRUE;
			$this->library->output_json($output);
		}
	}

	private function _do_upload()
	{
        $config['upload_path']   = UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|GIF|JPG|PNG|JPEG|BMP|';
        $config['max_size']    	 = 10000;
        $config['max_width']   	 = 10000;
        $config['max_height']  	 = 10000;
        $config['file_name']     = 'profile_pic_' . time();
        $this->upload->initialize($config);
	}


	private function _detail_dosen($user_id)
	{
		$dosen = $this->um->get_dd($user_id);

		$data = [
			'user_id' 	=> $user_id,
			'latitude'	=> $this->input->post('lat'),
			'longitude'	=> $this->input->post('lng'), 
			'room_id'	=> $this->input->post('room_id'),
			'id_status'	=> 1 // Aktif
		];

		if (@$dosen->detail_dosen_id) {
			$this->mall->update('detail_dosen', ['detail_dosen_id' => $dosen->detail_dosen_id], $data);
		} else {
			$this->mall->insert('detail_dosen', $data);
		}
	}

	public function show($id_user = NULL)
	{
		$user 	= $this->um->get_data($id_user);

		if (!$user->user_id) {
			redirect('users');
		}

		$data = [
			'breadcrumb' => $this->folder,
			'title'		 => $user->type_name,
			'subtitle'	 => 'Detail',
			'user'		 => $user,
		];

		if (@$user->user_type_id == 2) {
			$dosen = $this->um->get_dd($user->user_id);
			$data['detail_dosen_id']	= @$dosen->detail_dosen_id;
			$data['room_name']			= @$dosen->room_name;
			$data['latitude']			= @$dosen->latitude;
			$data['longitude']			= @$dosen->longitude;
		}

		$this->library->view('content/users_detail', $data);
	}

	public function delete($id = NULL)
	{
		$where 	= array('md5(user_id)' => $id);
		$data 	= $this->mall->get_data($this->table, $where)->row();
		if (@$data->profile_pic) {
			unlink(IMAGE . $data->profile_pic);
		}
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus ' . @$data->full_name,
		];
		$this->library->output_json($output);
	}

	public function delete_img()
	{
		$where = ['md5(user_id)' => $this->input->post('user_id')];
		$data  = $this->mall->get_data($this->table, $where)->row();
		unlink(IMAGE . $data->profile_pic);
		$this->mall->update($this->table, $where, ['profile_pic' => NULL]);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus Foto Profile',
		];
		$this->library->output_json($output);
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
