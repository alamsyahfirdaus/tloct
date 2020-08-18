<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bangunan_model extends CI_Model {

	private $table 			= 'building';
	private $col_order 		= ['building_id', 'building_name', NULL];
	private $col_search 	= ['building_id', 'building_name'];
	private $order_by		= ['building_id ' => 'DESC'];

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
			$row[]	= $field->building_name;
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
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_bangunan(' . "'" . md5($field->building_id) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_bangunan(' . "'" . md5($field->building_id) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</div>';

		return $button;
	}

}

/* End of file Bangunan_model.php */
/* Location: ./application/models/Bangunan_model.php */