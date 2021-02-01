<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Settings extends MY_Controller
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
        
        /** load main page */
        public function index(){
            $this->data['provinces'] = $this->sModel->get_all_province();
            $this->data['details'] = $this->acModel->get_profile_data();
            $this->data['content'] = "settings_index";
            $this->load->view('layout', $this->data);
        }
    }
?>