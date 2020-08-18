<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

	private $table		= 'setting';
	private $col_order 	= ['setting_id', 'setting_name', 'setting_value', 'description', NULL];
	private $col_search = ['setting_id', 'setting_name', 'setting_value', 'description'];
	private $order_by 	= ['setting_id' => 'ASC'];

	private function _get_query()
	{
		$this->db->where_not_in('setting_id', [3]);
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query  = $this->library->get_result($this->_get_query());
		$start 	= $this->input->post('start');
		$data 	= array();
		$no  	= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;

			if ($field->setting_id == 2) {
				$query 	= $this->db->get_where($this->table, ['setting_id' => 3])->row();

				$row[]	= strtoupper($field->setting_name) . '_' . strtoupper($query->setting_name);
				$row[]	= $field->setting_value . ' | ' . $query->setting_value;
				$row[]	= $field->description;
				$row[]	= '<button type="button" onclick="edit_lat_lng()" class="btn btn-primary text-center" title="Edit Pengaturan"><i class="fas fa-edit"></i></button>';

			} else {

				$row[]	= $field->setting_name;
				$row[]	= $field->setting_value;
				$row[]	= $field->description;
				$row[]	= '<button type="button" onclick="edit_setting(' . "'" . md5($field->setting_id) . "'" . ')" class="btn btn-primary text-center" title="Edit Pengaturan"><i class="fas fa-edit"></i></button>';
			}

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

	public function get_data($id = NULL)
	{
		if ($id) {
			return $this->db->get_where($this->table, ['md5(setting_id)' => $id])->row();
		} else {
			return $this->db->get($this->table)->result();
		}
	}

}

/* End of file Pengaturan_model.php */
/* Location: ./application/models/Pengaturan_model.php */