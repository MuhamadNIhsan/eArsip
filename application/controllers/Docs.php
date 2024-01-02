<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docs extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
		$this->check();
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->model('Docs_model');
		$this->load->model('Categories_model');
		$this->load->model('Boxes_model');
		$this->load->model('Users_model');
		$this->load->model('Group_model');
    }
	private function check(){
		if(empty($this->session->userdata('id'))){
			redirect('login','refresh');
		}
	}
	//get list groups from users
	private function group_auth(){
		$result = explode("@",$this->session->userdata('group'));
		$result = array_map('trim',$result);
		$result = array_filter($result);
		return $result;
	}
	//get users in same group
	private function user_list(){
		$group_auth = $this->group_auth();
		$result=array();
		if(!is_array($group_auth)){
			return FALSE;
		}
		if(is_array($group_auth)){
			foreach($group_auth as $gid){//1,3,5
				$users = $this->Users_model->findSimilar(['gid'=>'@'.$gid.'@']);//@1@
				foreach($users as $user){
					if(!in_array($user,$result)){
						$result[] = $user['uid'];
					}
				}
			}
			$result = array_unique($result);
			$this->session->set_userdata('users_group',$result);
			return $result;
		}
	}
	//get file id in same group
	private function file_list(){
		$group_auth = $this->group_auth();
		$result=array();
		if(!is_array($group_auth)){
			return FALSE;
		}
		if(is_array($group_auth)){
			foreach($group_auth as $gid){
				$docs = $this->Docs_model->findSimilar(['gid'=>'@'.$gid.'@']);
				foreach($docs as $doc){
					if(!in_array($doc['fid'],$result)){
						$result[] = $doc['fid'];
					}
				}
			}
			$result = array_unique($result);
			return $result;
		}
	}
    public function index(){
		$file_group = $this->file_list();
        $data = array(
            'page_title' => 'eArsip | Docs',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Docs',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item active">Docs</li>',
			'docs'=>$this->Docs_model->findIn($file_group)
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('docs/index', $data);
		$this->load->view('template/footer', $data);
    }
	public function create(){
        $data = array(
            'page_title' => 'eArsip | Docs',
			'heading'=>'Docs',
			'errors' => $this->session->flashdata('err'),
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item">Docs</li><li class="breadcrumb-item active">Create</li>',
			'categories'=>$this->Categories_model->findAll(),
			'boxes'=>$this->Boxes_model->findAll(),
			'groups'=>$this->Group_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('docs/create', $data);
		$this->load->view('template/footer', $data);				
	}
	public function insert(){
		$this->form_validation->set_rules('fileName','File Name must be filled !','required');
		$this->form_validation->set_rules('group[]','Group name must be filled !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->create());
		}else{
		$config['upload_path'] = './assets/files/';
		$config['allowed_types'] = 'jpg|png|jpeg|pdf';
		$config['max_size'] = 20000;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		$raw_groups = $this->input->post('group');
		$groups = "@".implode("@",$raw_groups)."@";
		$fname = $this->input->post('fileName');
		$cid = $this->input->post('catFile');
		$bcode = $this->input->post('boxFile');
		$fdesc = $this->input->post('fileDesc');
		if(!$this->upload->do_upload('InputFile')){
			$error = array('error'=>$this->upload->display_errors());
			$this->session->set_flashdata('err',$error);
			//jika kategori file tidak sesuai maka tidak bisa tersimpan
			/*
			$data = array(
				'fname'=>$fname,
				'fdesc'=>$fdesc,
				'cid'=>$cid,
				'bcode'=>$bcode,
				'fcreated_at'=>date('Y-m-d H:i:s')
			);
			*/
			return($this->create());
		}else{
			$fpath = $this->upload->data('file_name');
			$data = array(
				'fname'=>$fname,
				'fpath'=>$fpath,
				'fupload_by'=>$this->session->userdata('id'),
				'fdesc'=>$fdesc,
				'cid'=>$cid,
				'bcode'=>$bcode,
				'gid'=>$groups,
				'fcreated_at'=>date('Y-m-d H:i:s'),
				'fuploaded_at'=>date('Y-m-d H:i:s')
			);
			$process = $this->Docs_model->insert($data);
				if($process){
					$msg = '<label class="alert alert-success">Success Create Data</label>';
					$this->session->set_flashdata('msg',$msg);
					return redirect('docs','refresh');
				}else{
					$msg = '<label class="alert alert-warning">Failed Create Data</label>';
					$this->session->set_flashdata('msg',$msg);
					return redirect('docs','refresh');
				}
			}
		}
	}
	public function edit($id){
		$docs = $this->Docs_model->find(['fid'=>$id]);
		//cek apakah ada file id 
		if(!$docs){
			$msg = '<label class="alert alert-warning">No records</label>';
			$this->session->set_flashdata('msg',$msg);
			return redirect('docs','refresh');			
		}
		//cek file id masuk dalam grup data atau tidak
		$fg = $this->file_list();
		foreach($docs as $doc){
			if(!in_array($doc->fid,$fg)){
				$msg = '<label class="alert alert-warning">You are not authorized.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('docs','refresh');
			}
		}		
        $data = array(
            'page_title' => 'eArsip | Docs',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Docs',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item">Docs</li><li class="breadcrumb-item active">Edit</li>',
			'docs'=>$docs,
			'categories'=>$this->Categories_model->findAll(),
			'boxes'=>$this->Boxes_model->findAll(),
			'groups'=>$this->Group_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('docs/edit', $data);
		$this->load->view('template/footer', $data);		
	}
	public function update(){
		$this->form_validation->set_rules('fileName','File Name must be filled !','required');
		$this->form_validation->set_rules('group[]','Group name must be filled !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->edit($this->input->post('idFile')));
		}else{
		$config['upload_path'] = './assets/files/';
		$config['allowed_types'] = 'jpg|png|jpeg|pdf';
		$config['max_size'] = 20000;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		$fid = $this->input->post('idFile');
		$fname = $this->input->post('fileName');
		$cid = $this->input->post('catFile');
		$bcode = $this->input->post('boxFile');
		$raw_groups = $this->input->post('group');
		$groups = "@".implode("@",$raw_groups)."@";
		$fdesc = $this->input->post('fileDesc');
		$oldFile = FCPATH .'assets/files/'.$this->input->post('oldFile');
		if(!$this->upload->do_upload('InputFile')){
			$error = array('error'=>$this->upload->display_errors());
			$this->session->set_flashdata('err',$error);
			$data = array(
				'fname'=>$fname,
				'fdesc'=>$fdesc,
				'cid'=>$cid,
				'bcode'=>$bcode,
				'gid'=>$groups,
				'fupdated_at'=>date('Y-m-d H:i:s')
			);
		}else{
			$fpath = $this->upload->data('file_name');
			$data = array(
				'fname'=>$fname,
				'fpath'=>$fpath,
				'fupload_by'=>$this->session->userdata('id'),
				'fdesc'=>$fdesc,
				'cid'=>$cid,
				'bcode'=>$bcode,
				'gid'=>$groups,
				'fupdated_at'=>date('Y-m-d H:i:s'),
				'fuploaded_at'=>date('Y-m-d H:i:s')
			);
		}
		$process = $this->Docs_model->update($fid,$data);
			if($process){
				if( isset($data['fpath']) && file_exists($oldFile)){
					unlink($oldFile);	
				}
				$msg = '<label class="alert alert-success">Success Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('docs','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->edit($fid));			
			}
		}
	}
	public function delete($fid){
		if($this->session->userdata('level') != '0'){
			$msg = '<label class="alert alert-warning">You are not authorized.</label>';
			$this->session->set_flashdata('msg',$msg);
			return redirect('docs','refresh');
		}else{
			//cek file id masuk dalam grup data atau tidak
			$docs = $this->Docs_model->find(['fid'=>$fid]);
			$fg = $this->file_list();
			foreach($docs as $doc){
				if(!in_array($doc->fid,$fg)){
					$msg = '<label class="alert alert-warning">You are not authorized.</label>';
					$this->session->set_flashdata('msg',$msg);
					return redirect('docs','refresh');
				}
				$file_path = FCPATH.'assets/files/'.$doc->fpath;
			}		
			if($this->Docs_model->delete($fid)){
				if(file_exists($file_path)){
					unlink($file_path);					
				}
				$msg = '<label class="alert alert-success">Success delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('docs','refresh');
			}else{
				$msg = '<label class="alert alert-warning">Failed delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('docs','refresh');			
			}			
		}
	}
	public function get_modal(){
		if(!$this->input->post('id')){
			return redirect('docs','refresh');			
		}
		$id = $this->input->post('id');
		$docs = $this->Docs_model->find(['fid'=>$id]);
		echo json_encode($docs);
	}
}
