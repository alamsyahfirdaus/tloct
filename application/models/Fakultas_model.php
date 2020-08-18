<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fakultas_model extends CI_Model {

	private $table 			= 'faculty';
	private $col_order 		= ['faculty_id', 'faculty_name', NULL];
	private $col_search 	= ['faculty_id', 'faculty_name'];
	private $order_by		= ['faculty_id ' => 'DESC'];

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
			$row[]	= $field->faculty_name;
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
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_fakultas(' . "'" . md5($field->faculty_id) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_fakultas(' . "'" . md5($field->faculty_id) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</div>';

		return $button;
	}

}

/* End of file Fakultas_model.php */
/* Location: ./application/models/Fakultas_model.php */