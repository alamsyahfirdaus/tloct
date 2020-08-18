<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	private $table 			= 'user u';
	private $col_order 		= ['user_id', 'no_induk', '	username', 'phone', NULL];
	private $col_search 	= ['user_id', 'no_induk', '	username', 'phone'];
	private $order_by 		= ['user_id' => 'DESC'];

	private function _join()
	{
		$this->db->join('user_type ut', 'ut.user_type_id = u.user_type_id', 'left');
		$this->db->join('faculty f', 'f.faculty_id  = u.faculty_id ', 'left');
		$this->db->join('prodi p', 'p.prodi_id = u.prodi_id', 'left');
	}

	private function _get_query()
	{
		$this->_join();

		if ($this->input->get('id')) {
			$this->db->where('u.user_type_id', $this->input->get('id'));
		}

		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query 		= $this->library->get_result($this->_get_query());
		$data 		= array();
		$start 		= $this->input->post('start');
		$no  		= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[] 	= $field->no_induk;
			$row[] 	= $field->full_name;
			$row[] 	= $field->username;
			$row[] 	= $field->phone;
			$row[]	= $this->_get_button($field);
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
		if ($this->session->login == $field->user_id) {
			$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="profile()">Profile</a>';
		} else {
			$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="detail_user(' . "'" . md5($field->user_id) . "'" . ')">Detail</a>';
			$button		.= '<div class="dropdown-divider"></div>';
			$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_user(' . "'" . md5($field->user_id) . "'" . ')">Edit</a>';
			$button		.= '<div class="dropdown-divider"></div>';
			$button		.= '<a class="dropdown-item"  href="javascript:void(0)" onclick="delete_user(' . "'" . md5($field->user_id) . "'" . "," . "'" . $field->full_name . "'". ')">Hapus</a>';
		}
		$button		.= '</div>';
		$button		.= '</div>';

		return $button;
	}

	public function get_data($id)
	{
		$this->_join();

		if ($id) {
			return $this->db->get_where($this->table, ['md5(user_id)' => $id])->row();
		} else {
			return $this->db->get($this->table)->result();
		}
	}

	# Get Detail Dosen

	public function get_dd($id = NULL)
	{
		$this->db->join('detail_dosen dd', 'dd.user_id = u.user_id', 'left');
		$this->db->join('room r', 'r.room_id = dd.room_id', 'left');
		$this->db->where('u.user_id', $id);
		return $this->db->get('user u')->row();
	}
}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */