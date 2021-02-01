<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Settings_services extends MY_Controller
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
                'Settings_model' => 'sModel',
                'services/Settings_services_model' => 'ssModel'
            ];            
            $this->load->model($modelList);
        }
        
        /** get cities */
        public function get_cities(){
            try{
				$this->sModel->prov_code = $this->input->post('prov_code', true);
				$this->sModel->get_cities();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
        }

        /** get barangays */
        public function get_brgy(){
            try{
				$this->sModel->city_code = $this->input->post('city_code', true);
				$this->sModel->get_barangay();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
        }

        /** save edit data */
        public function save_edit(){
            try {
                $this->ssModel->token = $this->input->post('token', true);
                $this->ssModel->firstName = $this->input->post('fName', true);
                $this->ssModel->middleName = $this->input->post('mName', true);
                $this->ssModel->lastName = $this->input->post('lName', true);
                $this->ssModel->extName = $this->input->post('xtName', true);
                $this->ssModel->contactNo = $this->input->post('contact_no', true);
                $this->ssModel->contactPerson = $this->input->post('contact-person', true);
                $this->ssModel->contactPersonNo = $this->input->post('contact-person-number', true);
                $this->ssModel->blk_door = $this->input->post('blk-door', true);
                $this->ssModel->street = $this->input->post('edit-street', true);
                $this->ssModel->brgy = $this->input->post('brgy', true);
                $this->ssModel->city = $this->input->post('city', true);
                $this->ssModel->province = $this->input->post('province', true);
                $this->ssModel->update_data();
            } catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
        }

        /** update password */
        public function update_password(){
            try {
                if(empty($this->input->post('token', true))){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->ssModel->token = $this->input->post('token', true);
                $this->ssModel->pass = $this->input->post('password', true);
                $this->ssModel->update_password();
            } catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
        }
    }
?>