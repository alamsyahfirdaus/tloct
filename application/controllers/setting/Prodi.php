<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Pengaturan';
	private $title 		= 'Program Studi';
	private $table 		= 'prodi';

	public function index()
	{
		$data = [
			'breadcrumb' => $this->folder,
			'title' => $this->title
		];
		$this->library->view('content/prodi_view', $data);
	}
	
	public function show_datatables()
	{
		$this->load->model('Prodi_model');
		$data = $this->Prodi_model->get_datatables();
		echo json_encode($data);
	}

	public function get_prodi($id = NULL)
	{
		$where = array('md5(prodi_id)' => $id);
		$data = $this->mall->get_data($this->table, $where)->row();
		$output = [
			'prodi_id' 		=> md5($data->prodi_id),
			'prodi_name' 	=> $data->prodi_name,
			'faculty_id' 	=> $data->faculty_id
		];
		$this->library->output_json($output);
	}

	public function save_prodi()
	{
		$this->form_validation->set_error_delimiters('', '');
		$where = array('md5(prodi_id)' => $this->input->post('prodi_id'));
		$prodi = $this->mall->get_data($this->table, $where)->row();

		if (@$prodi) {
			$iu_prodi = $prodi->prodi_name == $this->input->post('prodi_name') ? "" : "|is_unique[prodi.prodi_name]";
		} else {
			$iu_prodi = '|is_unique[prodi.prodi_name]';
		}

		$this->form_validation->set_rules('prodi_name', 'Program Studi', 'trim|required' . $iu_prodi);
		$this->form_validation->set_rules('faculty_id', 'Fakultas', 'trim|required');
		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status' => FALSE,
				'errors' => array(
					'prodi_name' => form_error('prodi_name'),
					'faculty_id' => form_error('faculty_id')
				)
			];
			$this->library->output_json($data);
		} else {
			$data = [
				'prodi_name' => ucwords($this->input->post('prodi_name')),
				'faculty_id' => $this->input->post('faculty_id')
			];

			if (@$prodi) {
				$this->mall->update($this->table, $where, $data);
				$set_message = 'Berhasil Mengubah Program Studi';
			} else {
				$this->mall->insert($this->table, $data);
				$set_message = 'Berhasil Menambah Program Studi';
			}

			$output = [
				'status' => TRUE,
				'message' => $set_message
			];
			$this->library->output_json($output);
		}
	}

	public function delete_prodi($id = NULL)
	{
		$where = array('md5(prodi_id)' => $id);
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus Program Studi',
		];
		$this->library->output_json($output);
	}

	public function get_fakultas()
	{
		$data = $this->mall->get_data('faculty')->result();
		$this->library->output_json($data);
	}
}

/* End of file Prodi.php */
/* Location: ./application/controllers/setting/Prodi.php */
