<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->table = 'categories';
		$this->id = 'categories.cid';
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