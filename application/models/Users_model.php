<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->table = 'users';
		$this->id = 'users.uid';
	}
	public function insert($data){
		$p = $this->db->insert($this->table,$data);
		if($p){
			return true;
		}else{
			return false;
		}
	}
	public function findAll(){
		$p = $this->db->get($this->table);
		return $p->result();		
	}
	public function find($data){
		$this->db->where($data);
		$query = $this->db->get($this->table);
		return $query->result();
	}
	public function findSimilar($data){
		$this->db->like($data);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}	
	public function update($id,$data){
		$p = $this->db->update($this->table,$data,array($this->id=>$id));
		if($p){
			return true;
		}else{
			return false;
		}
	}
	public function delete($id){
		$p = $this->db->delete($this->table,array($this->id=>$id));
		if($p){
			return true;
		}else{
			return false;
		}
	}
}