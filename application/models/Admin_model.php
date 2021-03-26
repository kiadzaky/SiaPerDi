<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function getData($table, $order_by = null, $where = null)
	{
		if($order_by <> null){
			$this->db->order_by($order_by);
		}
		if($where <> null){
			$this->db->where($where);
		}
		return $this->db->get($table);

	}

	public function getQuery($query)
	{
		$q = $this->db->query($query);
		return $q;
	}

	public function insertData($table, $data)
	{
		$this->db->insert($table, $data);
	}

	public function Delete($table, $id)
	{
		$this->db->delete($table, $id);
	}

}
