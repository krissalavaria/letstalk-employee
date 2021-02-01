<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Account_model extends CI_Model
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

        /** get teacher profile data */
        public function get_profile_data(){
            try{
                $this->db->select(
                    'us.*, '. 
                    'br.desc as barangay, '. 
                    'ct.citymun_desc as city, '. 
                    'pr.prov_desc as province, '. 
                    'dp.name as department_name, '. 
                    'at.account_name'
                );
                $this->db->from($this->table['user'].' us');
                $this->db->join($this->table['brgy'].' br', 'br.ID = us.barangay_id', 'left');
                $this->db->join($this->table['city'].' ct', 'ct.ID = us.city_municipality_id', 'left');
                $this->db->join($this->table['prov'].' pr', 'pr.ID = us.province_id', 'left');                
                $this->db->join($this->table['acctype'].' at', 'at.ID = us.user_acct_type_id', 'left');
                $this->db->join($this->table['dept'].' dp', 'dp.ID = at.department_id', 'left');
                $this->db->where('us.auth_token', $this->session->auth_token);
                $query = $this->db->get()->row();                

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get all classes per teacher */
        public function get_all_classes(){
            try {
                if(empty($this->startDate) || empty($this->endDate)){
                    $this->date_two = (date("Y-m-d",strtotime('monday',strtotime('this week'))));     
                    $this->date_one = (date("Y-m-d",strtotime('sunday',strtotime('this week'))));                    
                    $this->db->select('er.*');
                    $this->db->order_by('er.class_date', 'desc');
                    $this->db->from($this->table['emprate'].' er');
                    $this->db->join($this->table['user'].' us', 'us.id = er.user_account_id', 'left');
                    $this->db->join($this->table['cycle'].' cl', 'cl.ID = er.salary_cycle_id', 'left');
                    $this->db->where('DATE(er.class_date) >=', $this->date_two);
                    $this->db->where('DATE(er.class_date) <=', $this->date_one);
                    $this->db->where('er.user_account_id', $this->session->id);
                    $this->db->where('cl.is_cleared', 0);
                }else{                    
                    $this->db->select('er.*');
                    $this->db->order_by('er.class_date', 'desc');
                    $this->db->from($this->table['emprate'].' er');
                    $this->db->join($this->table['user'].' us', 'us.id = er.user_account_id', 'left');
                    $this->db->join($this->table['cycle'].' cl', 'cl.ID = er.salary_cycle_id', 'left');
                    $this->db->where('DATE(er.class_date) >=', $this->startDate);
                    $this->db->where('DATE(er.class_date) <=', $this->endDate);
                    $this->db->where('er.user_account_id', $this->session->id);                    
                }                                                                                                                 
                $query = $this->db->get()->result();
                
                return $query;
            } 
            catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get all time record per user */
        public function get_time_record(){
            try {
                if(empty($this->timeStartDate) || empty($this->timeEndDate)){
                    $this->db->select('ts.*');
                    $this->db->from($this->table['timeSh'].' ts');
                    $this->db->join($this->table['user'].' us', 'us.ID = ts.user_account_id', 'left');
                    $this->db->where('ts.user_account_id', $this->session->id);
                    $this->db->where('us.deleted_at', NULL);
                    $this->db->where('DATE(ts.created_at)', date('Y-m-d'));
                }else{
                    $this->db->select('ts.*');
                    $this->db->from($this->table['timeSh'].' ts');
                    $this->db->join($this->table['user'].' us', 'us.ID = ts.user_account_id', 'left');
                    $this->db->where('ts.user_account_id', $this->session->id);
                    $this->db->where('us.deleted_at', NULL);                    
                    $this->db->where('DATE(ts.created_at) >=', $this->timeStartDate);
                    $this->db->where('DATE(ts.created_at) <=', $this->timeEndDate);
                }                 
                $query = $this->db->get()->result();
                
                return $query;
            }   
            catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get total class amount of user */
        public function get_total_classes_amount(){
            try {
                $this->db->select('er.*');
                $this->db->order_by('cl.ID', 'desc');
                $this->db->from($this->table['cycle'].' cl');
                $this->db->join($this->table['user'].' us', 'us.id = cl.user_account_id', 'left');
                $this->db->join($this->table['emprate'].' er', 'er.salary_cycle_id = cl.ID', 'left');                
                $this->db->where('er.user_account_id', $this->session->id);
                $this->db->where('cl.is_cleared', 0);                
                $query = $this->db->get()->result();
                $total = 0;
                if(!empty($query)){
                    foreach ($query as $key => $value) {
                        $total+=$value->total_amount;
                    }
                }
                
                return $total;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get total class per user */
        public function get_total_class(){
            try {
                $this->db->select('er.*');
                $this->db->order_by('cl.ID', 'desc');
                $this->db->from($this->table['cycle'].' cl');
                $this->db->join($this->table['user'].' us', 'us.id = cl.user_account_id', 'left');
                $this->db->join($this->table['emprate'].' er', 'er.salary_cycle_id = cl.ID', 'left');                
                $this->db->where('er.user_account_id', $this->session->id);
                $this->db->where('cl.is_cleared', 0);                
                $query = $this->db->get()->result();
                $total = 0;
                if(!empty($query)){
                    foreach ($query as $key => $value) {
                        $total+=$value->no_classes;
                    }
                }
                
                return $total;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>