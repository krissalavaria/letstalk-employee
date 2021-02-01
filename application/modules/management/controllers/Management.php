<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Management extends MY_Controller
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

        /** load main page */
        public function index(){
            $this->data['content'] = "management_index";
            $this->load->view('layout', $this->data);
        }

        /** load teachers list */
        public function load_teachers(){
            try {
                $this->data['result'] = $this->mModel->get_teachers_lists();
                $this->data['content'] = "grid/load_teachers_lists";
                $this->load->view('layout', $this->data);
            } catch (Exception $msg) {
                echo json_encode(array('error_message'>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** open teacher account */
        public function teacher_account(){
            try {
                if(unit_permission('Team Leader', $this->session)){                    
                    $this->mModel->auth_token = $this->input->get('get', true);
                    $this->data['detail'] = $this->mModel->get_teacher_profile();
                    if(empty($this->input->get('get')) || empty($this->data['detail'])){
                        redirect(base_url().'dashboard', 'refresh');
                    }
                    $this->data['content'] = "teacher_profile";
                    $this->load->view('layout', $this->data);
                }else{
                    $this->data['content'] = "error";
                    $this->load->view('layout', $this->data);
                }                
            } catch (Exception $msg) {
                echo json_encode(array('error_message'>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>