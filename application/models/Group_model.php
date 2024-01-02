<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->table = 'group_data';
		$this->id = 'group_data.gid';	
	}
	public function insert($data){
		$p = $this->db->insert($this->table,$data);
		if($p){
			return true;
		}else{
			return false;
		}
	}
	public function insert_b($data){
		$p = $this->db->insert_batch($this->table,$data);
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