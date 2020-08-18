<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class All_model extends CI_Model {

	public function insert($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update($table, $where, $data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

	public function get_data($table, $where = NULL)
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->get($table);
	}

	public function count_data($table, $where = NULL)
	{
		if ($where) {
			$this->db->where($where);
		} 
		return $this->db->count_all_results($table);
	}
}

/* End of file All_model.php */
/* Location: ./application/models/All_model.php */