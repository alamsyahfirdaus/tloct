<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi_model extends CI_Model {

	private $table 		= 'prodi p';
	private $col_order	= ['prodi_id', 'prodi_name', 'faculty_name', NULL];
	private $col_search	= ['prodi_id', 'prodi_name', 'faculty_name'];
	private $order_by 	= ['prodi_id' => 'DESC'];


	private function _get_query()
	{
		$this->db->join('faculty f', 'f.faculty_id = p.faculty_id', 'left');
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query 		= $this->library->get_result($this->_get_query());
		$start 		= $this->input->post('start');
		$data 		= array();
		$no  		= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[] 	= ucwords($field->prodi_name);
			$row[] 	= $field->faculty_name;
			$row[] 	= $this->_get_button($field);
			$data[] = $row;
		}

		$output = [
			'draw' 					=> $this->input->post('draw'),
			'recordsTotal' 			=> $this->db->count_all_results($this->table),
			'recordsFiltered' 		=> $this->db->get($this->_get_query())->num_rows(),
			'data'					=> $data,
		];

		return $output;
	}

	private function _get_button($field)
	{
		$button		= '<div class="btn-group">';
		$button		.= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"> Aksi</i></button>';
		$button		.= '<div class="dropdown-menu dropdown-menu-right">';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_prodi(' . "'" . md5($field->prodi_id) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_prodi(' . "'" . md5($field->prodi_id) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</div>';

		return $button;
	}

}

/* End of file Prodi_model.php */
/* Location: ./application/models/Prodi_model.php */