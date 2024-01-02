<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->check();
		$this->load->model('Users_model');
		$this->load->model('Group_model');
    }
	private function check(){
		if(empty($this->session->userdata('id'))){
			redirect('login','refresh');
		}
	}
	private function check_superadmin(){
		if($this->session->userdata('level')!='0'){
			return redirect('show_404','refresh');
		}
	}
    public function index(){
		$this->check_superadmin();
        $data = array(
            'page_title' => 'eArsip | Users',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Users',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item active">Users</li>',
			'users'=>$this->Users_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('users/index', $data);
		$this->load->view('template/footer', $data);
    }
	public function create(){
		$this->check_superadmin();
        $data = array(
            'page_title' => 'eArsip | Users',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Users',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Users</li><li class="breadcrumb-item active">Create</li>',
			'groups'=>$this->Group_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('users/create', $data);
		$this->load->view('template/footer', $data);
	}
	public function insert(){
		$this->check_superadmin();
		$this->form_validation->set_rules('uname','Username must be filled !','required|is_unique[users.uname]');
		$this->form_validation->set_rules('email','Email must be filled !','required|valid_email|is_unique[users.umail]');
		$this->form_validation->set_rules('pwd','Password must be filled !','required');
		$this->form_validation->set_rules('level','User Level must be choosed !','required|numeric');
		$this->form_validation->set_rules('active_status','User status must be choosed !','required|numeric');
		$this->form_validation->set_rules('group[]','Group name must be filled !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->create());
		}else{
		$uname = $this->input->post('uname');
		$raw_groups = $this->input->post('group');
		$groups = "@".implode("@",$raw_groups)."@";
		$email = $this->input->post('email');
		$pwd = password_hash($this->input->post('pwd'), PASSWORD_BCRYPT);
		$token = md5($email);
		$level = $this->input->post('level');
		$is_active = $this->input->post('active_status');
		$data = array('uname'=>$uname,'gid'=>$groups,'umail'=>$email,'utoken'=>$token,'upwd'=>$pwd,'ulevel'=>$level,'uis_active'=>$is_active,'ucreated_at'=>date('Y-m-d H:i:s'));
		$process = $this->Users_model->insert($data);
			if($process){
				$msg = '<label class="alert alert-success">Success Insert Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('users','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Insert Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->create());			
			}
		}
	}
	public function edit($id){
		$this->check_superadmin();
        $data = array(
            'page_title' => 'eArsip | Users',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Users',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Users</li><li class="breadcrumb-item active">Edit</li>',
			'users'=>$this->Users_model->find(['uid'=>$id]),
			'groups'=>$this->Group_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('users/edit', $data);
		$this->load->view('template/footer', $data);
	}
	public function update_auth(){
		$this->check_superadmin();
		$this->form_validation->set_rules('uname','Username must be filled !','required');
		$this->form_validation->set_rules('email','Email must be filled !','required|valid_email');
		$this->form_validation->set_rules('level','User Level must be choosed !','required|numeric');
		$this->form_validation->set_rules('active_status','User status must be choosed !','required|numeric');
		$this->form_validation->set_rules('group[]','Group name must be filled !','required');
		if($this->form_validation->run() == FALSE){
			return($this->edit($this->input->post('uid')));
		}else{
			$uid = $this->input->post('uid');
			$raw_groups = $this->input->post('group');
			$groups = "@".implode("@",$raw_groups)."@";
			$uname = $this->input->post('uname');
			$email = $this->input->post('email');
			$pwd = $this->input->post('pwd');
			$token = md5($email);
			$level = $this->input->post('level');
			$is_active = $this->input->post('active_status');
			$data1 = array('uname'=>$uname,'gid'=>$groups,'umail'=>$email,'utoken'=>$token,'ulevel'=>$level,'uis_active'=>$is_active,'uupdated_at'=>date('Y-m-d H:i:s'));
			if($pwd != NULL){
				$data2 = ['upwd'=>password_hash($pwd, PASSWORD_BCRYPT)];
				$data = array_merge($data1,$data2);
			}else{
				$data = $data1;
			}
			$process = $this->Users_model->update($uid,$data);
			if($process){
				$msg = '<label class="alert alert-success">Success Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('users','refresh');
			}else{
				$msg = '<label class="alert alert-warning">Failed Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->edit($uid));			
			}
		}
	}
	public function delete($uid){
		$this->check_superadmin();
		if($uid == $this->session->userdata('id')){
			$msg = '<label class="alert alert-warning">You can\'t delete your own account.</label>';
			$this->session->set_flashdata('msg',$msg);
			return redirect('users','refresh');							
		}else{
			if($this->Users_model->delete($uid)){
				$msg = '<label class="alert alert-success">Success delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('users','refresh');
			}else{
				$msg = '<label class="alert alert-warning">Failed delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('users','refresh');			
			}				
		}
	}
	public function profile(){
        $data = array(
            'page_title' => 'eArsip | Profile',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Profile',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item active">Profile</li>',
			'user'=>$this->Users_model->find(['uid'=>$this->session->userdata('id')])
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('users/profile', $data);		
		$this->load->view('template/footer', $data);
	}
	public function update(){
		$this->form_validation->set_rules('uname','Username must be filled !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->profile());
		}else{
		$uid = $this->session->userdata('id');
		$uname = $this->input->post('uname');
		$pwd = $this->input->post('pwd');
		$data1 = array('uname'=>$uname,'uupdated_at'=>date('Y-m-d H:i:s'));
		if($pwd != NULL){
			$data2 = ['upwd'=>password_hash($pwd, PASSWORD_BCRYPT)];
			$data = array_merge($data1,$data2);
		}else{
			$data = $data1;
		}
		$process = $this->Users_model->update($uid,$data);
			if($process){
				$msg = '<label class="alert alert-success">Success Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('Dashboard','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->profile());			
			}
		}
	}
}
