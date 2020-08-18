<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imageslider extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder = 'Pengaturan';
	private $title 	= 'Image Slider';
	private $table 	= 'image_slider';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('content/image_slider_view', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Image_slider_model', 'ism');
		$data = $this->ism->get_datatables();
		echo json_encode($data);
	}

	public function get_slider($id = NULL)
	{
		$where 	= array('md5(id_image_slider)' => $id);
		$data 	= $this->mall->get_data($this->table, $where)->row();

		$image 	= site_url(IMAGE . @$data->image); 

		$output = [
			'id_image_slider' 		=> md5(@$data->id_image_slider),
			'description' 			=> @$data->description,
			'url_image'				=> @$data->image ? $image : '',
			'image'					=> @$data->image ? $data->image : '',
		]; 
		echo json_encode($output);
	}

	public function save_slider()
	{
		$this->form_validation->set_error_delimiters('', '');
		
		$where = array('md5(id_image_slider)' => $this->input->post('id_image_slider'));
		$slider = $this->mall->get_data($this->table, $where)->row();

		$this->form_validation->set_rules('description', 'Keterangan', 'trim|required');
		$this->form_validation->set_message('required', '{field} harus diisi');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'description' => form_error('description'),
				),
			];
			$this->library->output_json($data);
		} else {
			$data = ['description' => ucwords($this->input->post('description'))];

			$this->_do_upload();

			if ($this->upload->do_upload('image')) {
			    if (@$slider->image) {
			        unlink(IMAGE . $slider->image);
			    }
			    $data['image'] = $this->upload->data('file_name');
			} 

			if (@$slider) {
				if ($this->input->post('remove_image')) {
					unlink(IMAGE . $this->input->post('remove_image'));
					$data['image'] = '';
				}
				$this->mall->update($this->table, $where, $data);
				$set_message = 'Berhasil Mengubah Image Slider';
			} else {
				$this->mall->insert($this->table, $data);
				$set_message = 'Berhasil Menambah Image Slider';
			}

			$output = [
				'status' 	=> TRUE,
				'message'	=> $set_message,
			];

			$this->library->output_json($output);
		}
	}

	public function delete_slider($id = NULL)
	{
		$where 	= array('md5(id_image_slider)' => $id);
		$data 	= $this->mall->get_data($this->table, $where)->row();
		if (@$data->image) {
			unlink(IMAGE . $data->image);
		}
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus Image Slider'
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
        $config['file_name']     = 'slider_' . time();
        $this->upload->initialize($config);
    }
}

/* End of file Imageslider.php */
/* Location: ./application/controllers/setting/Imageslider.php */
