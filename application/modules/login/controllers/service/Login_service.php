
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_service extends MY_Controller {

	private $data = [];
	protected $session;
    public function __construct()
	{
		parent::__construct(); 
		$this->session = (object)get_userdata(USER);
		
		$modelList = [
            'login/Login_model' => 'login',
		];
		
        $this->load->model($modelList);
	}


	public function index()
	{
		echo 'error';
    }
    
	public function login()
	{
		$this->login->username = $this->input->post('username', true);
		$this->login->password = $this->input->post('password', true);

		$response = $this->login->authentication();

		echo json_encode($response);

	}

	public function log_out(){
		session_destroy();
	}
	
	public function change(){		
		$this->data['token'] = $this->input->get('tok', true);
		$this->data['content'] = "change_password";
		$this->load->view('layout', $this->data);
	}

	public function update_password(){
		try {
			$this->login->token = $this->input->post('token', true);
			$this->login->first_password = $this->input->post('first_password', true);
			$this->login->second_password = $this->input->post('second_password', true);
			$this->login->change_password();
		} catch (Exception $msg) {
			echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
		}
	}

}
