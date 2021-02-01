<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Settings_model extends CI_Model
    {
        private $table = array(    
            'user' => 'user_account',        
            'prov' => 'province',
            'city' => 'city_municipality',
            'brgy' => 'barangays',
            'acctype' => 'user_account_type', 
            'desig' => 'designation', 
            'dept' => 'department',
            'emprate' => 'employee_rate',
            'acct_type' => 'user_account_type',
            'cycle' => 'salary_cycle',
            'timeSh' => 'time_sheet'           
        );                

        public $date_two;
        public $date_one;

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

        /** get all province */
        public function get_all_province(){
            try {
                $this->db->select('pr.*');
                $this->db->from($this->table['prov'].' pr');
                $query = $this->db->get()->result();
                
                return $query;
            } catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** get all cities in province */
        public function get_cities(){
            try{
                if(empty($this->prov_code)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->db->select('*');
                $this->db->where('prov_code', $this->prov_code);
                $query = $this->db->get($this->table['city'])->result();

                echo json_encode($query);
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** get barangays of a cities */
        public function get_barangay(){
            try{
                if(empty($this->city_code)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->db->select('*');
                $this->db->where('citymun_code', $this->city_code);
                $query = $this->db->get($this->table['brgy'])->result();

                echo json_encode($query);
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>