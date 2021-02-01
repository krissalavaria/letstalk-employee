<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Management_model extends CI_Model
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

        /** get all teachers */
        public function get_teachers_lists(){
            try {
                $this->db->select('us.*');
                $this->db->from($this->table['user'].' us');
                $this->db->where('us.tl_id', $this->session->id);
                $query = $this->db->get()->result();                
                return $query;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** get teacher profile */
        public function get_teacher_profile(){
            try {
                $this->db->select(
                    'er.*, ', 
                    'us.auth_token'                    
                );   
                               
                $this->db->order_by('er.class_date', 'desc');
                $this->db->from($this->table['emprate'].' er');
                $this->db->join($this->table['user'].' us', 'us.id = er.user_account_id', 'left');
                $this->db->join($this->table['cycle'].' cl', 'cl.ID = er.salary_cycle_id', 'left');                
                $this->db->where('us.auth_token', $this->auth_token);
                $this->db->where('us.deleted_at', NULL);
                $this->db->where('cl.is_cleared', 0);                
                $query = $this->db->get()->result();
                
                return $query;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>