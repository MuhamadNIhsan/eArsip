<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
		$this->check();
		$this->load->library('form_validation');
		$this->load->model('Categories_model');
		$this->load->model('Docs_model');
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
            'page_title' => 'eArsip | Docs Category',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Docs Category',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item active">Docs Category</li>',
			'categories'=>$this->Categories_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('category/index', $data);
		$this->load->view('template/footer', $data);
    }
	public function create(){
        $data = array(
            'page_title' => 'eArsip | Docs Category',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Docs Category',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Docs Category</li><li class="breadcrumb-item active">Create</li>'
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('category/create', $data);
		$this->load->view('template/footer', $data);				
	}
	public function insert(){
		$this->form_validation->set_rules('catName','Category Name must be filled !','required');
		$this->form_validation->set_rules('catColor','Category Color must be choosed !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->create());
		}else{
			$cname = $this->input->post('catName');
			$ccolor = $this->input->post('catColor');
			$data = array(
				'cname'=>$cname,
				'ccolor'=>$ccolor,
				'ccreated_at'=>date('Y-m-d H:i:s')
			);
			$process = $this->Categories_model->insert($data);
			if($process){
				$msg = '<label class="alert alert-success">Success Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('category','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('category','refresh');
			}
		}
	}	
	public function edit($id){
        $data = array(
            'page_title' => 'eArsip | Docs Category',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Docs Category',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Docs Category</li><li class="breadcrumb-item active">Edit</li>',
			'categories'=>$this->Categories_model->find(['cid'=>$id])
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('category/edit', $data);
		$this->load->view('template/footer', $data);		
	}
	public function update(){
		$this->form_validation->set_rules('catName','Category Name must be filled !','required');
		$this->form_validation->set_rules('catColor','Category Color must be choosed !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->edit($this->input->post('idCatName')));
		}else{
			$cid = $this->input->post('idCatName');
			$cname = $this->input->post('catName');
			$ccolor = $this->input->post('catColor');
			$data = array(
				'cname'=>$cname,
				'ccolor'=>$ccolor,
				'cupdated_at'=>date('Y-m-d H:i:s')
			);
			$process = $this->Categories_model->update($cid,$data);
			if($process){
				$msg = '<label class="alert alert-success">Success Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('category','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->edit($cid));
			}
		}
	}
	public function delete($cid){
		if($this->Docs_model->find(['cid'=>$cid])){
			$msg = '<label class="alert alert-warning">This category has been used. Can\'t be deleted.</label>';
			$this->session->set_flashdata('msg',$msg);
			return redirect('category','refresh');
		}else{
			if($this->Categories_model->delete($cid)){
				$msg = '<label class="alert alert-success">Success delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('category','refresh');
			}else{
				$msg = '<label class="alert alert-warning">Failed delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('category','refresh');			
			}			
		}			
	}	
}
