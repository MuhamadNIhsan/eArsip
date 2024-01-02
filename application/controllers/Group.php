<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
		$this->check();
		$this->load->library('form_validation');
		$this->load->model('Group_model');
		$this->load->model('Users_model');
    }
	private function check(){
		if(empty($this->session->userdata('id'))){
			return redirect('login','refresh');
		}
		if($this->session->userdata('level')!= '0'){
			return redirect('show_404','refresh');
		}
	}
    public function index(){
        $data = array(
            'page_title' => 'eArsip | Group Data',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Group Data',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item active">Group Data</li>',
			'groups'=>$this->Group_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('group_data/index', $data);
		$this->load->view('template/footer', $data);
    }
	public function create(){
        $data = array(
            'page_title' => 'eArsip | Group Data',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Group Data',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Group Data</li><li class="breadcrumb-item active">Create</li>'
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('group_data/create', $data);
		$this->load->view('template/footer', $data);
	}
	public function insert(){
		$this->form_validation->set_rules('groupName','Group name must be filled !','required|is_unique[group_data.gname]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->create());
		}else{
			$group = $this->input->post('groupName');
			$data = array(
				'gname'=>$group,
				'gcreated_at'=>date('Y-m-d H:i:s')
			);
			$process = $this->Group_model->insert($data);
			if($process){
				$msg = '<label class="alert alert-success">Success Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('group','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('group','refresh');
			}
		}
	}	
	public function edit($id){
        $data = array(
            'page_title' => 'eArsip | Group Data',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Group Data',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Group Data</li><li class="breadcrumb-item active">Edit</li>',
			'groups'=>$this->Group_model->find(['gid'=>$id])
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('group_data/edit', $data);
		$this->load->view('template/footer', $data);		
	}
	public function update(){
		$this->form_validation->set_rules('groupName','Group name must be filled !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->edit($this->input->post('idGroup')));
		}else{
			$gid = $this->input->post('idGroup');
			$group = $this->input->post('groupName');
			$data = array(
				'gname'=>$group,
				'gupdated_at'=>date('Y-m-d H:i:s')
			);
			$process = $this->Group_model->update($gid,$data);
			if($process){
				$msg = '<label class="alert alert-success">Success Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('group','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->edit($gid));
			}
		}
	}
	public function delete($id){
		if($this->Users_model->findSimilar(['gid'=>'@'.$id])){
			$msg = '<label class="alert alert-warning">This group has been used. Can\'t be deleted.</label>';
			$this->session->set_flashdata('msg',$msg);
			return redirect('group','refresh');
		}else{
			if($this->Group_model->delete($id)){
				$msg = '<label class="alert alert-success">Success delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('group','refresh');
			}else{
				$msg = '<label class="alert alert-warning">Failed delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('group','refresh');			
			}			
		}			
	}
}
