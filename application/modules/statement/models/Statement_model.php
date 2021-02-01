<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Statement_model extends CI_Model
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
            'emprate' => 'employee_rate',
            'acctType' => 'user_account_type', 
            'dept' => 'department'           
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

        /** get account details per cycle */
        public function get_profile_data(){
            try{
                $this->db->select(
                    'us.*, '. 
                    'br.desc as barangay, '. 
                    'ct.citymun_desc as city, '. 
                    'pr.prov_desc as province, '. 
                    'dp.name as department_name, '. 
                    'at.account_name, '. 
                    'cl.cycle_date, '. 
                    'cl.cycle_date_end, '. 
                    'cl.is_cleared'
                );
                $this->db->order_by('cl.ID', 'desc');
                $this->db->from($this->table['cycle'].' cl');                
                $this->db->join($this->table['user'].' us', 'us.id = cl.user_account_id', 'left');
                $this->db->join($this->table['brgy'].' br', 'br.ID = us.barangay_id', 'left');
                $this->db->join($this->table['city'].' ct', 'ct.ID = us.city_municipality_id', 'left');
                $this->db->join($this->table['prov'].' pr', 'pr.ID = us.province_id', 'left');                
                $this->db->join($this->table['acctType'].' at', 'at.ID = us.user_acct_type_id', 'left');
                $this->db->join($this->table['dept'].' dp', 'dp.ID = at.department_id', 'left');
                $this->db->where('us.auth_token', $this->session->auth_token);
                $query = $this->db->get()->row();                

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get all classess of user for statement of account */
        public function get_statement_classes(){
            try {
                $this->db->select('er.*, '. 'at.hourly_rate');
                $this->db->order_by('er.class_date', 'desc');
                $this->db->from($this->table['emprate'].' er');
                $this->db->join($this->table['user'].' us', 'us.id = er.user_account_id', 'left');
                $this->db->join($this->table['cycle'].' cl', 'cl.ID = er.salary_cycle_id', 'left');
                $this->db->join($this->table['acctType'].' at', 'at.ID = us.user_acct_type_id', 'left');                
                $this->db->where('er.user_account_id', $this->session->id);
                $this->db->where('cl.is_cleared', 0);
                $query = $this->db->get()->result();

                return $query;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** generate statement of account history */
        public function get_statement_history(){
            try {
                if(empty($this->start_date) || empty($this->end_date)){
                    $this->db->select('er.*, '. 'at.hourly_rate');
                    $this->db->order_by('er.class_date', 'desc');
                    $this->db->from($this->table['emprate'].' er');
                    $this->db->join($this->table['user'].' us', 'us.id = er.user_account_id', 'left');
                    $this->db->join($this->table['cycle'].' cl', 'cl.ID = er.salary_cycle_id', 'left');
                    $this->db->join($this->table['acctType'].' at', 'at.ID = us.user_acct_type_id', 'left');                
                    $this->db->where('er.user_account_id', $this->session->id);
                    $this->db->where('cl.is_cleared', 1);                  
                }else{
                    $this->db->select('er.*, '. 'at.hourly_rate');
                    $this->db->order_by('er.class_date', 'desc');
                    $this->db->from($this->table['emprate'].' er');
                    $this->db->join($this->table['user'].' us', 'us.id = er.user_account_id', 'left');
                    $this->db->join($this->table['cycle'].' cl', 'cl.ID = er.salary_cycle_id', 'left');
                    $this->db->join($this->table['acctType'].' at', 'at.ID = us.user_acct_type_id', 'left');                
                    $this->db->where('er.user_account_id', $this->session->id);
                    $this->db->where('cl.is_cleared', 1);
                    $this->db->where('DATE(cl.cycle_date) >=', $this->start_date);
                    $this->db->where('DATE(cl.cycle_date) <=', $this->end_date);
                }
               
                $query = $this->db->get()->result();               
                
                return $query;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>