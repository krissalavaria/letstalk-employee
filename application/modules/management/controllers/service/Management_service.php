<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Management_service extends MY_Controller 
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
                'management/service/Management_service_model' => 'msModel', 
                'management/Management_model' => 'mModel'                
            ];            
            $this->load->model($modelList);
        }

        /** save edited classes of teachers */
        public function save_classes(){
            try {
                if(empty($this->input->post('ID', true))){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                if(empty($this->input->post('cl-date', true))){
                    throw new Exception('Date is Empty', true);
                }
                $this->msModel->Token = $this->input->post('Token', true);
                $this->msModel->ID = $this->input->post('ID', true);
                $this->msModel->cl_date = $this->input->post('cl-date', true);
                $this->msModel->cl_class = $this->input->post('cl-no-class', true);
                $this->msModel->cl_hours = $this->input->post('cl-no-hours', true);
                $this->msModel->save_edited_class();
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>