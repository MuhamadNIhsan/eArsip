<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docs_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->table = 'files';
		$this->id = 'files.fid';
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
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('users','users.uid = files.fupload_by','left');
		$this->db->join('categories','categories.cid = files.cid','left');
		$this->db->join('boxes','boxes.bcode = files.bcode','left');
		$p = $this->db->get();
		return $p->result();		
	}
	public function findAllGroup(){
		$this->db->select('categories.cname, count(files.fid) as jml,categories.ccolor');
		$this->db->from($this->table);
		$this->db->join('categories','categories.cid = files.cid','left');
		$this->db->group_by('categories.cname');
		$this->db->order_by('files.cid','ASC');
		$p = $this->db->get();
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
	public function findIn($data){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('users','users.uid = files.fupload_by','left');
		$this->db->join('categories','categories.cid = files.cid','left');
		$this->db->join('boxes','boxes.bcode = files.bcode','left');
		$this->db->where_in('files.fid',$data);
		$query = $this->db->get();
		return $query->result();
	}
	/*public function findByGroup(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('users','users.uid = files.fupload_by','left');
		$this->db->join('categories','categories.cid = files.cid','left');
		$this->db->join('boxes','boxes.bcode = files.bcode','left');
		$p = $this->db->get();
		return $p->result();				
	}*/
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