<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Users_model');
		$this->load->library('session');
		$this->load->library('form_validation');
    }
	private function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	private function send_email($receiver,$message){
		$config = array(
			'protocol'=>'smtp',
			'smtp_host'=>'mailbox2.ptjas.co.id',
			'smtp_port'=>587,
			'smtp_user'=>'mnur.ihsan@ptjas.co.id',
			'smtp_pass'=>'rebel10n@ptjas',
			'mail_type'=>'html',
			'charset'=>'UTF-8'
			);
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from("no-reply@earsip.com","no-reply@earsip.com");
		$this->email->to($receiver);
		$this->email->subject("Forgot password");
		$this->email->message($message);
		$this->email->set_mailtype('html');
		if($this->email->send()){
			return $msg = "Email Sent to ".$receiver;
		}else{
			$x = $this->email->print_debugger(array('headers'));
			return $msg = $x;
		}
	}
    public function index(){
		if($this->session->userdata('id')!==NULL){
			return redirect('/dashboard');
		}
        $data = array(
            'page_title' => 'eArsip | Login',
			'msg' => $this->session->flashdata('msg')
			);
        $this->load->view('login', $data);
    }
    public function proc(){
		$this->form_validation->set_rules('email','Email must be filled !','required|valid_email');
		$this->form_validation->set_rules('pwd','Password must be filled !','required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->index());
		}else {
            $email = $this->input->post('email');
            $password = $this->input->post('pwd');
            $user = $this->Users_model->find(['umail' => $email, 'uis_active' => 1]);
			if($user){
				foreach($user as $usr){
					$id = $usr->uid;
					$name = $usr->uname;
					$pwd = $usr->upwd;
					$token = $usr->utoken;
					$level = $usr->ulevel;
					$is_active = $usr->uis_active;
					$group = $usr->gid;
				}
				if($is_active== 0){
					$msg = 'Inactive User, contact the Administrator.';
					$this->session->set_flashdata('msg',$msg);
					return redirect($this->index());
				}
				if(password_verify($password,$pwd)){
					$data_sess = array(
						'id'=>$id,
						'name'=>$name,
						'token'=>$token,
						'level'=>$level,
						'group'=>$group
					);
					$this->session->set_userdata($data_sess);
					return redirect('/dashboard');
				}else{
					$msg = 'Invalid Password.';
					$this->session->set_flashdata('msg',$msg);
					return redirect($this->index());				
				}
			}else{
				$msg = 'Invalid account';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->index());
			}
        }
    }
	public function v_forgot(){
		if($this->session->userdata('id')!==NULL){
			return redirect('/dashboard');
		}
        $data = array(
            'page_title' => 'eArsip | Forgot Password',
			'msg' => $this->session->flashdata('msg')
			);
        $this->load->view('forgot', $data);
	}
	public function forgot(){
		if($this->session->userdata('id')!==NULL){
			return redirect('/dashboard');
		}
		$this->form_validation->set_rules('email','Email must be filled !','required|valid_email');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		if($this->form_validation->run() == FALSE){
			return($this->v_forgot());
		}else {
            $email = $this->input->post('email');
            $user = $this->Users_model->find(['umail' => $email, 'uis_active' => '1']);
			if($user){
				foreach($user as $usr){
					$id = $usr->uid;
					$token = $usr->utoken;
					$is_active = $usr->uis_active;					
				}
				if($is_active== 0){
					$msg = 'Inactive User, contact the Administrator.';
					$this->session->set_flashdata('msg',$msg);
					return redirect($this->v_forgot());
				}
				$new_pwd = $this->generateRandomString();
				$pwd = password_hash($new_pwd, PASSWORD_BCRYPT);
				$data = array(
					'upwd'=>$pwd,
					'uis_active' => '0'
				);
				$p = $this->Users_model->update($id,$data);
				if($p){
					$url = site_url('login/activate/'.$token);
					$message = 'Greetings,<br />';
					$message .= 'Your new password is <b>'.$new_pwd.'</b><br />';
					$message .= '<a href="'.$url.'">Click here</a> to activate your account<br />';
					$message .= 'or manually open this '.$url.' from your browsers.<br /><br />';
					$message .= 'Thank you.<br />';
					$message .= 'Regards.<br /><br />';
					$message .= 'eArsip mail systems.';
					//$s = $this->send_email($email,$message); dinonaktifkan karna google mencabut fitur akses email
					$s = $message;
					$this->session->set_flashdata('msg',$s);
					return redirect($this->v_forgot());										
				}else{
					$msg = 'Failed reset password.';
					$this->session->set_flashdata('msg',$msg);
					return redirect($this->v_forgot());					
				}
			}else{
				$msg = 'Email not found.';
				$this->session->set_flashdata('msg',$msg);
				return redirect($this->v_forgot());
			}
        }		
	}
	public function activate($token){
		if($search = $this->Users_model->find(['utoken'=>$token])){
			foreach($search as $s){
				$id = $s->uid;
			}
			$this->Users_model->update($id,['uis_active'=>'1']);
			$msg = 'Your account has been activated.';
			$this->session->set_flashdata('msg',$msg);
			return redirect('login');
		}else{
			return redirect('show_404');
		}
	}
	public function logout(){
		session_destroy();
		return redirect($this->index());
	}
}
