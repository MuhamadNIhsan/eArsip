<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
		$this->check();
		$this->load->model('Categories_model');
		$this->load->model('Docs_model');
		$this->load->model('Users_model');
    }
	private function check(){
		if(empty($this->session->userdata('id'))){
			redirect('login','refresh');
		}
	}
    public function index(){
        $data = array(
            'page_title' => 'eArsip | Dashboard',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Dashboard',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item active">Dashboard</li>',
			'categories'=>$this->Categories_model->findAll(),
			'docs'=>$this->Docs_model->findAll(),
			'users'=>$this->Users_model->findAll(),
			'data_chart'=>$this->Docs_model->findAllGroup()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('index', $data);
		$this->load->view('template/footer', $data);
    }
}
