<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Docs_model');
    }
	
	public function docs_get(){
		$docs = $this->Docs_model->findAll();
		$this->response( $docs, 200);
	}
}