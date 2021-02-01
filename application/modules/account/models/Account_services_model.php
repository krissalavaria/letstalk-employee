<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Account_services_model extends CI_Model
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
            'cycle' => 'salary_cycle'            
        );  
        
        private $upload_max = 2*MB;
        private  $allowed = array("image/jpeg", "image/png", "image/HEIC");
        protected $session;
        private $folder_path = [
        'documents' => [
            'target' => 'assets/documents/',
        ],
        'profile' => [
            'target' => 'assets/images/logo/Profile/',
        ],
    ];

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
            $library = [
                'String_library' => 'str_lib'
            ];
            $this->load->library($library);
        } 

        /** save user classes */
        public function save_classes(){
            try {
                if(empty($this->cl_date) || empty($this->cl_no_class) || empty($this->cl_no_hours)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $getAmount = $this->get_total_amount();
                $check_date = $this->check_class_date();
                $last_cycle = $this->get_last_salary_cycle();
                if($this->cl_date > date('Y-m-d')){
                    throw new Exception('DATE MUST NOT BE GREATER THAN FOR TODAY', true);
                }
                if(@$last_cycle->is_cleared === '1'){
                    throw new Exception('Please add ORDER FIRST. Thank You.', true);
                }
                
                if($this->cl_date < @$last_cycle->cycle_date){
                    // throw new Exception('Invalid date. Please check you date', true);
                }
                if($getAmount === false){
                    throw new Exception("Empty hourly rate please contact your administrator", true);
                }
                if(!empty($check_date) && empty($this->ID)){
                    throw new Exception(DUPLICATE_RECORD, true);
                }
                $data = array(
                    'user_account_id' => $this->session->id, 
                    'salary_cycle_id' => @$last_cycle->ID,
                    'no_classes' => $this->cl_no_class, 
                    'no_hours' => $this->cl_no_hours, 
                    'total_amount' => ($this->cl_no_hours * $getAmount),
                    'class_date' => $this->cl_date
                );
                if($this->ID === 'undefined'){                   
                    $this->db->trans_start();
                    $this->db->insert($this->table['emprate'], $data);
                    $this->db->trans_complete();
                }else{                    
                    $this->db->trans_start();
                    $this->db->where('ID', $this->ID);
                    $this->db->update($this->table['emprate'], $data);
                    $this->db->trans_complete();
                }                
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();
                    echo json_encode(array('message'=>'Success', 'has_error'=>false));
                }
            }
            catch(Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get last salary cycle */
        public function get_last_salary_cycle(){
            try {
                $this->db->select(
                    'cl.ID, '.  
                    'cl.cycle_date, '. 
                    'cl.is_cleared'
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
        /** save logo */
        public function save_logo(){
            try{
                if(empty($this->token)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                if(empty($this->image)){
                    throw new Exception("Please upload image file", true);
                }
                $file_type = $this->image['type'];
                if(!in_array($file_type, $this->allowed)) {
                    throw new Exception('Only JPEG image format is allowed.', true);
                }

                $new_file_name = str_replace(":","_",$this->token).'.jpg';
                $compressedImage = $this->str_lib->compressImage($this->image['tmp_name'], $this->folder_path['profile']['target'].$new_file_name,50);
                if(!$compressedImage){ 
                    throw new Exception("Image compress failed!", 1);
                } 

                $this->db->where('auth_token',$this->token);
                $this->db->update($this->table['user'],array('picture' => $new_file_name));
                
                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    throw new Exception("Error Saving image. Transaction halted.", true);	
                }else
                {
                    $this->db->trans_commit();
                    echo json_encode(array('has_error' => false, 'message' => 'Successfully saved Picture'));
                }                                
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>