<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder = 'Pengaturan';
	private $title 	= 'Gedung';
	private $table 	= 'building';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('content/bangunan_view', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Bangunan_model');
		$data = $this->Bangunan_model->get_datatables();
		echo json_encode($data);
	}

	public function get_bangunan($id = NULL)
	{
		$where 	= array('md5(building_id)' => $id);
		$data 	= $this->mall->get_data($this->table, $where)->row();

		$image 	= site_url(IMAGE . @$data->image); 

		$output = [
			'building_id' 		=> md5(@$data->building_id),
			'building_name' 	=> @$data->building_name,
			'url_image'			=> @$data->image ? $image : '',
			'image'				=> @$data->image ? $data->image : '',
		]; 
		echo json_encode($output);
	}

	public function save_bangunan()
	{
		$this->form_validation->set_error_delimiters('', '');
		
		$where = array('md5(building_id)' => $this->input->post('building_id'));
		$bangunan = $this->mall->get_data($this->table, $where)->row();

		if (@$bangunan) {
			$iu_bangunan 	= $bangunan->building_name == $this->input->post('building_name') ? "" : "|is_unique[building.building_name]";
		} else {
			$iu_bangunan = '|is_unique[building.building_name]';
		}

		$this->form_validation->set_rules('building_name', 'Bangunan', 'trim|required' . $iu_bangunan);
		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'building_name' => form_error('building_name'),
				),
			];
			$this->library->output_json($data);
		} else {
			$data = ['building_name' => ucwords($this->input->post('building_name'))];

			$this->_do_upload();

			if ($this->upload->do_upload('image')) {
			    if (@$bangunan->image) {
			        unlink(IMAGE . $bangunan->image);
			    }
			    $data['image'] = $this->upload->data('file_name');
			} 

			if (@$bangunan) {
				if ($this->input->post('remove_image')) {
					unlink(IMAGE . $this->input->post('remove_image'));
					$data['image'] = '';
				}
				$this->mall->update($this->table, $where, $data);
				$set_message = 'Berhasil Mengubah Bangunan';
			} else {
				$this->mall->insert($this->table, $data);
				$set_message = 'Berhasil Menambah Bangunan';
			}

			$output = [
				'status' 	=> TRUE,
				'message'	=> $set_message,
			];

			$this->library->output_json($output);
		}
	}

	public function delete_bangunan($id = NULL)
	{
		$where 	= array('md5(building_id)' => $id);
		$data 	= $this->mall->get_data($this->table, $where)->row();
		if (@$data->image) {
			unlink(IMAGE . $data->image);
		}
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus Bangunan'
		];
		$this->library->output_json($output);
	}

	private function _do_upload()
	{
        $config['upload_path']   = UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|GIF|JPG|PNG|JPEG|BMP|';
        $config['max_size']    	 = 10000;
        $config['max_width']   	 = 10000;
        $config['max_height']  	 = 10000;
        $config['file_name']     = 'building_' . time();
        $this->upload->initialize($config);
    }
}

/* End of file Building.php */
/* Location: ./application/controllers/setting/Building.php */
