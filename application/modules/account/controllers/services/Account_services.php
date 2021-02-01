<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Account_services extends MY_Controller
    {
        private $data = [];
		protected $session;
		public function __construct()
		{
			parent::__construct(); 
			$this->session = (object)get_userdata(USER);
			
			if(is_empty_object($this->session)){
				redirect(base_url().'dashboard/authentication', 'refresh');
			}
			$modelList = [
				'account/Account_model' => 'acModel',
				'account/Account_services_model' => 'acsModel'
            ];            
            $this->load->model($modelList);
		}
		/** save user classes */
		public function save_classes()
		{
			try{
				$this->acsModel->ID = $this->input->post('ID', true);
				$this->acsModel->cl_date = $this->input->post('cl-date', true);
				$this->acsModel->cl_no_class = $this->input->post('cl-no-class', true);
				$this->acsModel->cl_no_hours = $this->input->post('cl-no-hours', true);
				$this->acsModel->save_classes();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
		/** save logo */
		public function save_logo(){
			try {
				if(empty($this->input->post('token'))){
					throw new Exception(ERROR_PROCESSING, true);
				}
				$this->acsModel->token = $this->input->post('token', true);
				$this->acsModel->image = @$_FILES['logo'];
				$this->acsModel->save_logo();
			} 
			catch (Exception $msg) {
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
    }
?>