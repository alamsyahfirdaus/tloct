<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_slider_model extends CI_Model {

	private $table 			= 'image_slider';
	private $col_order 		= ['id_image_slider', 'description', NULL];
	private $col_search 	= ['id_image_slider', 'description'];
	private $order_by		= ['id_image_slider ' => 'DESC'];

	private function _get_query()
	{
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query 	= $this->library->get_result($this->_get_query());
		$data 	= array();
		$start 	= $this->input->post('start');
		$no  	= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[]	= $field->description;
			$row[]	= '<p class="text-center"><img class="profile-user-img img-fluid" src="' . site_url(IMAGE . $this->library->image($field->image)) . '" alt="User profile picture"></p>';
			$row[] 	= $this->_get_button($field);
			$data[]	= $row;
		}

		$output	= [
			'draw' 				=> $this->input->post('draw'),
			'recordsTotal'		=> $this->db->count_all_results($this->table),
			'recordsFiltered' 	=> $this->db->get($this->_get_query())->num_rows(),
			'data' 				=> $data,
		];

		return $output;
	}

	private function _get_button($field)
	{
		$button		= '<div class="btn-group">';
		$button		.= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"> Aksi</i></button>';
		$button		.= '<div class="dropdown-menu dropdown-menu-right">';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_slider(' . "'" . md5($field->id_image_slider) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_slider(' . "'" . md5($field->id_image_slider) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</div>';

		return $button;
	}

}

/* End of file Image_slider_model.php */
/* Location: ./application/models/Image_slider_model.php */