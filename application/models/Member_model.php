<?php 

class Member_model extends CI_Model{

	public function insert($data = array()){

		$insert = $this->db->insert("member", $data);
		return $insert;
	}


	public function get($where = array()){

		$row = $this->db->where($where)->get("member")->row();
		return $row;
	}


	public function update($where = array(), $data = array()){

		$update = $this->db->where($where)->update("member", $data);
		return $update;
	}
}

?>