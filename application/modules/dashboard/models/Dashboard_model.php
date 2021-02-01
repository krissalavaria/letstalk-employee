<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Dashboard_model extends CI_Model
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
            'stock' => 'stock'           
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

        /** get all categery */
        public function get_category(){
            try{
                $this->db->select(
                    'p.*'
                );
                $this->db->from($this->table['prod_cat'].' p');
                $query = $this->db->get()->result();

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get all menu for today base on the product category */
        public function get_all_menu(){
            try{
                if(empty($this->productID)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->db->select(
                    'pr.*'
                );
                $this->db->from($this->table['prod'].' pr');  
                $this->db->join($this->table['stock'].' st', 'st.product_id = pr.ID', 'left');
                $this->db->where('st.qty !=', 0);
                if($this->productID === 'null')   {
                    $this->db->where('pr.product_category_id', 1);
                }else{
                    $this->db->where('pr.product_category_id', $this->productID);
                }                
                $query = $this->db->get()->result();
                
                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get all order list per user */
        public function get_order_list(){            
            try{
                $this->db->select(
                    'ol.*, '. 
                    'pr.product_name, '. 
                    'pr.price, '. 
                    'oh.order_no'                    
                );
                $this->db->from($this->table['orderh'].' oh');
                $this->db->join($this->table['orderL'].' ol', 'ol.order_no = oh.order_no', 'left');
                $this->db->join($this->table['prod'].' pr', 'pr.ID = ol.product_id', 'left');
                $this->db->where('oh.user_account_id', $this->session->id);
                $this->db->where('oh.order_status_id', NULL);
                $query = $this->db->get()->result();

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get all order history */
        public function get_order_history(){
            try{
                
                if(!empty($this->start_date) || !empty($this->end_date)){                         
                    $this->db->select(
                        'oh.*, '. 
                        'os.order_status'                                     
                    );
                    $this->db->order_by('oh.ID', 'desc');
                    $this->db->from($this->table['user'].' us');
                    $this->db->join($this->table['cycle'].' cl', 'cl.user_account_id = us.id', 'left');
                    $this->db->join($this->table['orderh'].' oh', 'cl.ID = oh.salary_cycle_id', 'left');                              
                    $this->db->join($this->table['orderS'].' os', 'os.ID = oh.order_status_id', 'left');                                        
                    $this->db->where('us.id', $this->session->id);
                    $this->db->where('oh.order_status_id !=', NULL);                                    
                    $this->db->where('DATE(oh.order_date) >=', $this->start_date);
                    $this->db->where('DATE(oh.order_date) <=', $this->end_date);    
                }else{
                    $this->db->select(
                        'oh.*, '. 
                        'os.order_status'                                     
                    );
                    $this->db->order_by('oh.ID', 'desc');
                    $this->db->from($this->table['user'].' us');
                    $this->db->join($this->table['cycle'].' cl', 'cl.user_account_id = us.id', 'left');
                    $this->db->join($this->table['orderh'].' oh', 'cl.ID = oh.salary_cycle_id', 'left');                              
                    $this->db->join($this->table['orderS'].' os', 'os.ID = oh.order_status_id', 'left');
                    $this->db->where('cl.is_cleared', 0);
                    $this->db->where('us.id', $this->session->id);
                    $this->db->where('oh.order_status_id !=', NULL);   
                    $this->db->where('DATE(oh.order_date)', date('Y-m-d'));                 
                }                                
                $query = $this->db->get()->result();
                
                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get order history to load in modl */
        public function get_to_load_histo_modal(){
            try{
                if(empty($this->orderID)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->db->select('ol.*, '. 'pr.product_name');
                $this->db->from($this->table['orderL'].' ol');
                $this->db->join($this->table['orderh'].' oh', 'oh.order_no = ol.order_no', 'left');
                $this->db->join($this->table['prod'].' pr', 'pr.ID = ol.product_id', 'left');
                $this->db->where('oh.order_no', $this->orderID);
                $this->db->where('ol.order_no', $this->orderID);
                $this->db->where('oh.user_account_id', $this->session->id);
                $query = $this->db->get()->result();
                
                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get total credits */
        public function get_total_credits(){
            try{
                $this->db->select('ol.total_amount');
                $this->db->from($this->table['user'].' us');
                $this->db->join($this->table['cycle'].' cl', 'cl.user_account_id = us.id', 'left');
                $this->db->join($this->table['orderh'].' oh', 'oh.salary_cycle_id = cl.id', 'left');
                $this->db->join($this->table['orderL'].' ol', 'ol.order_no = oh.order_no', 'left');
                $this->db->join($this->table['orderS'].' os', 'os.ID = oh.order_status_id', 'left');
                $this->db->where('cl.is_cleared', 0);
                $this->db->where('us.id', $this->session->id);
                $this->db->where('os.order_status !=', 'Cancelled');
                $query = $this->db->get()->result();
                $total = 0;
                if(!empty($query)){
                    foreach ($query as $key => $value) {
                        $total+=$value->total_amount;
                    }
                }                
                return $total;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get total balance*/
        public function get_total_balance(){
            try{
                $total_credits = $this->get_total_credits();
                $total_class_income = $this->get_total_class_amount();
                $total_balance = 0;
                $total_balance = $total_class_income - $total_credits;

                return $total_balance;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get total class amount */
        public function get_total_class_amount(){
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
            } 
            catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }        
        /** get user coverage of credits */
        public function get_coverage(){
            try {
                $this->db->select('sc.*');
                $this->db->order_by('sc.ID', 'desc');
                $this->db->from($this->table['cycle'].' sc');
                $this->db->where('sc.user_account_id', $this->session->id);
                $this->db->where('sc.is_cleared', 0);
                $query = $this->db->get()->row();

                return $query;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>