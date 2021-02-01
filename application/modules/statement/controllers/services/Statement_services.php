<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Statement_services extends MY_Controller
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
                'statement/Statement_model' => 'sModel',
                'statement/services/Statement_services_model' => 'dsModel'			
            ];
            $this->load->model($model_list);
        }
    }
?>