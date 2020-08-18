<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder = 'Pengaturan';
	private $title 	= 'Fakultas';
	private $table 	= 'faculty';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('content/fakultas_view', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Fakultas_model');
		$data = $this->Fakultas_model->get_datatables();
		echo json_encode($data);
	}

	public function get_fakultas($id = NULL)
	{
		$where 	= array('md5(faculty_id)' => $id);
		$data 	= $this->mall->get_data($this->table, $where)->row();
		$output = [
			'faculty_id' 		=> md5($data->faculty_id),
			'faculty_name' 	=> $data->faculty_name
		]; 
		echo json_encode($output);
	}

	public function save_fakultas()
	{
		$this->form_validation->set_error_delimiters('', '');
		
		$where = array('md5(faculty_id)' => $this->input->post('faculty_id'));
		$fakultas = $this->mall->get_data($this->table, $where)->row();

		if (@$fakultas) {
			$iu_fakultas 	= $fakultas->faculty_name == $this->input->post('faculty_name') ? "" : "|is_unique[faculty.faculty_name]";
		} else {
			$iu_fakultas = '|is_unique[faculty.faculty_name]';
		}

		$this->form_validation->set_rules('faculty_name', 'Fakultas', 'trim|required' . $iu_fakultas);
		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'faculty_name' => form_error('faculty_name'),
				),
			];
			$this->library->output_json($data);
		} else {
			$data = array('faculty_name' => ucwords($this->input->post('faculty_name')));
			if (@$fakultas) {
				$this->mall->update($this->table, $where, $data);
				$set_message = 'Berhasil Mengubah Fakultas';
			} else {
				$this->mall->insert($this->table, $data);
				$set_message = 'Berhasil Menambah Fakultas';
			}

			$output = [
				'status' 	=> TRUE,
				'message'	=> $set_message,
			];

			$this->library->output_json($output);
		}
	}

	public function delete_fakultas($id = NULL)
	{
		$where 	= array('md5(faculty_id)' => $id);
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus Fakultas'
		];
		$this->library->output_json($output);
	}
}

/* End of file Faculty.php */
/* Location: ./application/controllers/setting/Faculty.php */
