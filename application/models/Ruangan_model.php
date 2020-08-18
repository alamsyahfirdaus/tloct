<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan_model extends CI_Model {
 
	private $table 		= 'room r';
	private $col_order	= ['room_id', 'room_name', 'lantai', 'building_name', NULL];
	private $col_search	= ['room_id', 'room_name', 'lantai', 'building_name'];
	private $order_by 	= ['room_id' => 'DESC'];


	private function _get_query()
	{
		$this->db->join('building b', 'b.building_id = r.building_id', 'left');
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
			$row[] 	= $field->room_name;
			$row[] 	= $field->lantai;
			$row[] 	= $field->building_name;
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
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_ruangan(' . "'" . md5($field->room_id) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_ruangan(' . "'" . md5($field->room_id) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</div>';

		return $button;
	}

}

/* End of file Ruangan_model.php */
/* Location: ./application/models/Ruangan_model.php */