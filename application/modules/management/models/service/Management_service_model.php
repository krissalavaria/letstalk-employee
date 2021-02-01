<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
    class Management_service_model extends CI_Model
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

        /** save edited classes */
        public function save_edited_class(){
            try {
                if(empty($this->ID)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $getAmount = $this->get_total_amount();
                $last_cycle = $this->get_last_salary_cycle();
                $check_date = $this->check_class_date();
                
                if($getAmount === false){
                    throw new Exception("Empty hourly rate please contact your administrator", true);
                }
                if(!empty($check_date) && empty($this->ID)){
                    throw new Exception(DUPLICATE_RECORD, true);
                }
                $data = array(            
                    'no_classes' => $this->cl_class, 
                    'no_hours' => $this->cl_hours, 
                    'total_amount' => ($this->cl_hours * $getAmount),
                    'class_date' => $this->cl_date
                );
                
                $this->db->trans_start();                
                $this->db->where('ID', $this->ID);
                $this->db->update($this->table['emprate'], $data);
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE){                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();
                    echo json_encode(array('message'=>'Success', 'has_error'=>false, 'token'=>$this->Token));
                }
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** get copmute total amount of rate */
        public function get_total_amount(){
            try {
                $this->db->select('ua.hourly_rate');
                $this->db->from($this->table['acct_type'].' ua');
                $this->db->join($this->table['user'].' us', 'us.user_acct_type_id = ua.ID', 'left');
                $this->db->where('ua.ID', $this->session->user_acct_type_id);
                $query = $this->db->get()->row();
                if(empty($query)){
                    return false;
                }
                return $query->hourly_rate;                
            } 
            catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }  

        /** get last salary cycle */
        public function get_last_salary_cycle(){
            try {
                $this->db->select(
                    'cl.ID, '.  
                    'cl.cycle_date'
                );
                $this->db->order_by('cl.ID', 'desc');
                $this->db->from($this->table['cycle'].' cl');
                $this->db->where('cl.user_account_id', $this->session->id);
                $query = $this->db->get()->row();

                return $query;
            } catch (Exception $msg) {
               echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** check class date */
        public function check_class_date(){
            try {
                $this->db->select('ID');
                $this->db->from($this->table['emprate']);
                $this->db->where('class_date', $this->cl_date);
                $this->db->where('user_account_id', $this->session->id);
                $query = $this->db->get()->row();

                return $query;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>