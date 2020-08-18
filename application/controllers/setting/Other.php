<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
		$this->load->model('Pengaturan_model', 'pm');
	}

	private $folder = 'Pengaturan';
	private $table  = 'setting';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'subtitle'		=> 'Lainnya',
		];

		$this->library->view('content/pengaturan_index', $data);
	}

	public function show_datatables()
	{
		$data = $this->pm->get_datatables();
		echo json_encode($data);
	}

	public function edit($id = NULL)
	{
		$query  = $this->pm->get_data($id);

		if (!$query->setting_id) {
			redirect('setting/other');
		}

		$data = [
			'breadcrumb' 	=> $this->folder,
			'subtitle'		=> 'Lainnya / Edit',

			'setting_id'	=> md5(@$query->setting_id),
			'setting_name'	=> @$query->setting_name,
			'setting_value'	=> @$query->setting_value,
			'description'	=> @$query->description ? $query->description : '-',
		];

		$this->library->view('content/pengaturan_edit', $data);
	}

	public function save_setting($id = NULL)
	{
		$query  = $this->pm->get_data($id);

		if (!$query->setting_id) {
			redirect('setting/other');
		}

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('setting_value', 'Pengaturan', 'required');
		$this->form_validation->set_rules('description', 'Keterangan', 'required');
		$this->form_validation->set_message('required', '{field} harus diisi');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status' => FALSE,
				'errors' => array(
					'setting_value' => form_error('setting_value'),
					'description' 	=> form_error('description'),
				), 
			];
			$this->library->output_json($data);
		} else {
			$data 	= [
				'setting_value' => $this->input->post('setting_value'),
				'description' 	=> htmlspecialchars($this->input->post('description')),
			];

			$this->mall->update($this->table, ['setting_id' => $query->setting_id], $data);
			$this->session->set_flashdata('success', 'Berhasil Mengubah Pengaturan');
			$this->library->output_json(['status' => TRUE]);
		}
	}

	public function latlng()
	{	
		$query1  		= $this->pm->get_data(md5(2));
		$query2   		= $this->pm->get_data(md5(3));
		$setting_name 	= strtoupper($query1->setting_name) . '_' . strtoupper($query2->setting_name);
		$latitude 		= $query1->setting_value;
		$longitude 		= $query2->setting_value;
		$description	= $this->library->null($query1->description);
		$address		= $query2->description;

		$data = [
			'breadcrumb' 	=> $this->folder,
			'subtitle'		=> 'Lainnya / Edit',

			'setting_name'	=> $setting_name,
			'latitude'		=> $latitude,
			'longitude'		=> $longitude,
			'description'	=> $description,
			'address'		=> $address
		];

		$this->library->view('content/pengaturan_latlng', $data);
	}

	public function save_latlng()
	{
		$latitude 	= $this->input->post('lat');
		$longitude 	= $this->input->post('lng');
		
		if (!$latitude && !$longitude) {
			redirect('setting/other');
		}

		$data1 = [
			'setting_value' => $latitude,
			'description'	=> $this->input->post('description'), 
		];

		$data2 = [
			'setting_value' => $longitude,
			'description'	=> $this->input->post('address') 
		];

		$this->mall->update($this->table, ['setting_id' => 2], $data1);
		$this->mall->update($this->table, ['setting_id' => 3], $data2);
		$this->session->set_flashdata('success', 'Berhasil Mengubah Pengaturan');
		redirect('setting/other');

	}

	public function map()
	{
		$query1  		= $this->pm->get_data(md5(2));
		$query2   		= $this->pm->get_data(md5(3));
		
		$data = [
			'lat' 		=> $query1->setting_value,
			'lng' 		=> $query2->setting_value,
			'address'	=> $query2->description
		];

	    $this->load->view('content/maps_view', $data);
	}
}

/* End of file Other.php */
/* Location: ./application/controllers/setting/Other.php */
