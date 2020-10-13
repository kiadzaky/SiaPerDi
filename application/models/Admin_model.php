<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function getData($table)
	{
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
