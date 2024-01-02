<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Boxes extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('session');
		$this->check();
		$this->load->library('form_validation');
		$this->load->model('Boxes_model');
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
            'page_title' => 'eArsip | Box',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Box',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item active">Box</li>',
			'boxes'=>$this->Boxes_model->findAll()
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('boxes/index', $data);
		$this->load->view('template/footer', $data);
    }
	public function create(){
        $data = array(
            'page_title' => 'eArsip | Box',
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Box',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Box</li><li class="breadcrumb-item active">Create</li>'
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('boxes/create', $data);
		$this->load->view('template/footer', $data);
	}
	public function insert(){
		$this->form_validation->set_rules('boxCode','Box Code must be filled !','required|alpha_numeric|is_unique[boxes.bcode]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->create());
		}else{
			$raw_bcode = $this->input->post('boxCode');
			$bcode = str_replace(' ','',$raw_bcode);
			$data = array(
				'bcode'=>$bcode,
				'bcreated_at'=>date('Y-m-d H:i:s')
			);
			$process = $this->Boxes_model->insert($data);
			if($process){
				$msg = '<label class="alert alert-success">Success Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('boxes','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('boxes','refresh');
			}
		}
	}	
	public function edit($id){
        $data = array(
            'page_title' => 'eArsip | Box',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Box',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Box</li><li class="breadcrumb-item active">Edit</li>',
			'boxes'=>$this->Boxes_model->find(['bid'=>$id])
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('boxes/edit', $data);
		$this->load->view('template/footer', $data);		
	}
	public function update(){
		$this->form_validation->set_rules('boxCode','Box Code must be filled !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->edit($this->input->post('idBox')));
		}else{
			$bid = $this->input->post('idBox');
			$bcode = $this->input->post('boxCode');
			$data = array(
				'bcode'=>$bcode,
				'bupdated_at'=>date('Y-m-d H:i:s')
			);
			$process = $this->Boxes_model->update($bid,$data);
			if($process){
				$msg = '<label class="alert alert-success">Success Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('boxes','refresh');		
			}else{
				$msg = '<label class="alert alert-warning">Failed Update Data</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->edit($bid));
			}
		}
	}
	public function delete($bcode){
		if($this->Docs_model->find(['bcode'=>$bcode])){
			$msg = '<label class="alert alert-warning">This box has been used. Can\'t be deleted.</label>';
			$this->session->set_flashdata('msg',$msg);
			return redirect('boxes','refresh');
		}else{
			if($this->Boxes_model->delete($cid)){
				$msg = '<label class="alert alert-success">Success delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('boxes','refresh');
			}else{
				$msg = '<label class="alert alert-warning">Failed delete data.</label>';
				$this->session->set_flashdata('msg',$msg);
				return redirect('boxes','refresh');			
			}			
		}			
	}
	public function import(){
        $data = array(
            'page_title' => 'eArsip | Box',
			'errors' => $this->session->flashdata('err'),
			'msg' => $this->session->flashdata('msg'),
			'heading'=>'Box',
			'breadcrumb'=>'<li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item"><a href="#">Settings</a></li><li class="breadcrumb-item">Box</li><li class="breadcrumb-item active">Edit</li>',
			);
		$this->load->view('template/header', $data);
		$this->load->view('template/navs', $data);
        $this->load->view('boxes/import', $data);
		$this->load->view('template/footer', $data);				
	}
	public function import_excel(){
		$config['upload_path'] = './assets/files/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size'] = 2000;
		$this->load->library('upload');
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('InputFile')){
			$error = array('error'=>$this->upload->display_errors());
			$this->session->set_flashdata('err',$error);
			return($this->import());
		}else{
			$file_import = $this->upload->data('full_path');
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet = $reader->load($file_import);
			$sheets = $spreadsheet->getActiveSheet()->toArray();
			unset($sheets[0]);
			$data = array();
			foreach($sheets as $sheet){
				$data[] = array(
					'bcode'=>$sheet[0],
					'bcreated_at'=>date('Y-m-d H:i:s'),
					'bupdated_at'=>NULL,
				);
			}
			var_dump($data);
			$process = $this->Boxes_model->insert_b($data);
			if($process){
				$msg = '<label class="alert alert-success">Success Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
			}else{
				$msg = '<label class="alert alert-warning">Failed Create Data</label>';
				$this->session->set_flashdata('msg',$msg);
			}
			return redirect('boxes','refresh');		
			
		}
	}
}
