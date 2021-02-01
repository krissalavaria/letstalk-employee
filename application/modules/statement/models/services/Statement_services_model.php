<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Statement_services_model extends CI_Model
    {
        private $table = array(     
            'user' => 'user_account',       
            'prov' => 'province',
            'city' => 'city_municipality',
            'brgy' => 'barangays',
            'prod_cat' => 'product_category', 
            'prod' => 'product',
            'orderh' => 'orderhead',
            'orderL' => 'orderline', 
            'orderS' => 'orderstatus',
            'cycle' => 'salary_cycle',
            'emprate' => 'employee_rate'           
        );                

        public function __construct()
        {
            parent::__construct(); 
			$this->session = (object)get_userdata(USER);
			
			if(is_empty_object($this->session)){
				redirect(base_url().'dashboard/authentication', 'refresh');
			}
			$model_list = [               
            ];
            $this->load->model($model_list);
        }  
        
    }
?>