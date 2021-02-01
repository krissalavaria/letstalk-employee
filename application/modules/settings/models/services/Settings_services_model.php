<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Settings_services_model extends CI_Model
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

        /** save update data */
        public function update_data(){
            try {
                if(empty($this->token)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                if($this->brgy === 'undefined' || $this->city === 'undefined'){
                    throw new Exception('Please review your address', true);
                }
                $data = array(
                    'first_name' => ucfirst($this->firstName),
                    'middle_name' => ucfirst($this->middleName), 
                    'last_name' => ucfirst($this->lastName), 
                    'contact_number' => $this->contactNo, 
                    'contact_person' => ucfirst($this->contactPerson), 
                    'contact_person_number' => $this->contactPersonNo, 
                    'blk_door' => $this->blk_door, 
                    'street' => $this->street, 
                    'barangay_id' => $this->brgy, 
                    'city_municipality_id' => $this->city, 
                    'province_id' => $this->province,
                    'verified' => 1
                );
                $this->db->trans_start();
                $this->db->where('auth_token', $this->token);
                $this->db->update($this->table['user'], $data);
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();
                    echo json_encode(array('message'=>'Success', 'has_error'=>false));
                }
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }

        /** update password */
        public function update_password(){
            try {

                $this->password = password_hash($this->pass, PASSWORD_DEFAULT);

                $data = array(
                    'password' => $this->password                    
                );
    
                $this->db->trans_start();
                $this->db->where('auth_token', $this->token);
                $this->db->update($this->table['user'], $data);
                $this->db->trans_complete();
    
                if ($this->db->trans_status() === FALSE){                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();
                    echo json_encode(array('message'=>'Success', 'has_error'=>false));
                }
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>