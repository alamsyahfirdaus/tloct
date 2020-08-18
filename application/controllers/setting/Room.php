<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Pengaturan';
	private $title 		= 'Ruangan';
	private $table 		= 'room';

	public function index()
	{
		$data = [
			'breadcrumb' => $this->folder,
			'title' => $this->title
		];
		$this->library->view('content/ruangan_view', $data);
	}
	
	public function show_datatables()
	{
		$this->load->model('Ruangan_model');
		$data = $this->Ruangan_model->get_datatables();
		echo json_encode($data);
	}

	public function get_ruangan($id = NULL)
	{
		$where = array('md5(room_id)' => $id);
		$data = $this->mall->get_data($this->table, $where)->row();
		$output = [
			'room_id' 		=> md5($data->room_id),
			'room_name' 	=> $data->room_name,
			'lantai' 		=> $data->lantai,
			'building_id' 	=> $data->building_id
		];
		$this->library->output_json($output);
	}

	public function save_ruangan()
	{
		$this->form_validation->set_error_delimiters('', '');
		$where = array('md5(room_id)' => $this->input->post('room_id'));
		$bangunan = $this->mall->get_data($this->table, $where)->row();

		$this->form_validation->set_rules('room_name', 'Ruangan', 'trim|required');
		$this->form_validation->set_rules('lantai', 'Lantai', 'trim|required');
		$this->form_validation->set_rules('building_id', 'Bangunan', 'trim|required');
		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status' => FALSE,
				'errors' => array(
					'room_name'	 	=> form_error('room_name'),
					'lantai' 		=> form_error('lantai'),
					'building_id' 	=> form_error('building_id')
				)
			];
			$this->library->output_json($data);
		} else {
			$data = [
				'room_name' 	=> ucwords($this->input->post('room_name')),
				'lantai' 		=> $this->input->post('lantai'),
				'building_id'	=> $this->input->post('building_id')
			];

			if (@$bangunan) {
				$this->mall->update($this->table, $where, $data);
				$set_message = 'Berhasil Mengubah Ruangan';
			} else {
				$this->mall->insert($this->table, $data);
				$set_message = 'Berhasil Menambah Ruangan';
			}

			$output = [
				'status' => TRUE,
				'message' => $set_message
			];
			$this->library->output_json($output);
		}
	}

	public function delete_ruangan($id = NULL)
	{
		$where = array('md5(room_id)' => $id);
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus Ruangan',
		];
		$this->library->output_json($output);
	}

	public function get_bangunan()
	{
		$data = $this->mall->get_data('building')->result();
		$this->library->output_json($data);
	}
}

/* End of file Room.php */
/* Location: ./application/controllers/setting/Room.php */
