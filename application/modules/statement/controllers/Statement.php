<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Statement extends MY_Controller
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

            $model_list = [
                'dashboard/Dashboard_model' => 'dModel',
                'account/Account_model' => 'acModel',
                'statement/Statement_model' => 'sModel',
                'statement/services/Statement_services_model' => 'dsModel'			
            ];
            $this->load->model($model_list);
        }
        /** load main page */
        public function index(){
            $this->data['details'] = $this->sModel->get_profile_data();
            $this->data['total_amount'] = $this->acModel->get_total_classes_amount();
            $this->data['Credits'] = $this->dModel->get_total_credits();			
			$this->data['Balance'] = $this->dModel->get_total_balance();
            $this->data['content'] = "statement_index";
            $this->load->view('layout', $this->data);
        }
        /** load all class records in statement */
        public function load_statement_classes(){            
            $this->data['result'] = $this->sModel->get_statement_classes();                        
            $this->data['content'] = "grid/load_statement_class";
            $this->load->view('layout', $this->data);
        }
        /** load statement of account historys */
        public function load_statement_history(){
            $this->sModel->start_date = $this->input->post('start_date', true);
            $this->sModel->end_date = $this->input->post('end_date', true);
            $this->data['details'] = $this->sModel->get_profile_data();
            $this->data['result'] = $this->sModel->get_statement_history();
            $this->data['content'] = "grid/load_statement_history";
            $this->load->view('layout', $this->data);
        }
    }
?>