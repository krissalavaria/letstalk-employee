<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Account extends MY_Controller
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
            ];            
            $this->load->model($modelList);
		}

		public function index()
		{            
            $this->data['details'] = $this->acModel->get_profile_data();
            $this->data['content'] = "account_index";
            $this->load->view('layout', $this->data);
        }
        /** load all class list and amounts */
        public function load_class_list(){
            $this->acModel->startDate = $this->input->post('startDate', true);
            $this->acModel->endDate = $this->input->post('endDate', true);
            $this->data['result'] = $this->acModel->get_all_classes();
            $this->data['content'] = "grid/load_class_list";
            $this->load->view('layout', $this->data);
        }
        /** load user time record */
        public function load_time_record(){
            try {
                $this->acModel->timeStartDate = $this->input->post('timeStartDate', true);
                $this->acModel->timeEndDate = $this->input->post('timeEndDate', true);
                $this->data['result'] = $this->acModel->get_time_record();
                $this->data['content'] = "grid/load_time_record";
                $this->load->view('layout', $this->data);
            } 
            catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** laod users total income per salary cycle */
        public function load_users_income(){
            try {   
                $this->data['total_class_amount'] = $this->acModel->get_total_classes_amount();
                $this->data['total_class'] = $this->acModel->get_total_class();
                $this->data['content'] = "grid/load_users_income";
                $this->load->view('layout', $this->data);
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>