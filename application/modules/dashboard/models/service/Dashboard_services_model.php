<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Dashboard_services_model extends CI_Model
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
            'cycle' => 'salary_cycle',
            'orderStat' => 'orderstatus', 
            'stock' => 'stock',
            'orderS' => 'orderstatus',            
        );                

        public $ID;
        public $cycleID;
        private $orderNo;
        private $endKey;
        public $cycle_date_end;

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
        /** add order head */
        public function add_order_head(){
            try{
                if(empty($this->productID)){
                    throw new Exception(ERROR_PROCESSING, true);
                }                                      
                $check_stock = $this->check_stock();    
                if($check_stock === false){
                    throw new Exception('PRODUCT OUT OF STOCK', true);
                }           
                $check = $this->check_order_confirmed();
                $cycle_ID = $this->get_latest_cycle();
                $this->cycleID = @$cycle_ID->ID;
                if(empty($this->cycleID)){
                    $this->cycleID = $this->insert_salary_cycle();                    
                }else{
                    $this->cycle_date_end = $this->generate_cycle_end_date();
                }                
                
                $this->orderNo = order_number_gen($this->session->id);

                if(empty($check)){
                    
                    $check_orderno = $this->check_order_number();
                    if(!empty($check_orderno)){
                        $this->orderNo = order_number_gen($this->session->id);
                    }
                    
                    $orderHeadData = array(
                        'order_no' => $this->orderNo,
                        'user_account_id' => $this->session->id,
                        'salary_cycle_id' => @$this->cycleID                    
                    );
                    
                    $this->db->trans_start();
                    $this->db->insert($this->table['orderh'], $orderHeadData);   
                    $this->db->trans_complete();
                    
                    if ($this->db->trans_status() === FALSE)
                    {                
                        $this->db->trans_rollback();
                        throw new Exception(ERROR_PROCESSING, true);	
                    }else{
                        $this->db->trans_commit();
                        $this->insert_orderline();
                    }
                }else{                    
                    $this->orderNo = $check->order_no;
                    $this->insert_orderline();
                }              
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check order number duplication */
        public function check_order_number(){
            try {
                $this->db->select('oh.order_no');
                $this->db->from($this->table['orderh'].' oh');
                $this->db->where('oh.order_no', $this->orderNo);
                $query = $this->db->get()->row();

                return $query;
            } catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check order stock if available */
        public function check_stock(){
            try {
                if(empty($this->productID)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->db->select('qty');
                $this->db->from($this->table['stock']);
                $this->db->where('product_id', $this->productID);                
                $query = $this->db->get()->row();
                if(@$query->qty <= 0){
                    return false;
                }else{
                    return true;
                }                
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }        
        /** insert into salary cycle table */
        public function insert_salary_cycle(){
            try {
                $this->salary_typeID = $this->get_salary_type_id();                                
                $data = array(
                    'user_account_id' => $this->session->id, 
                    'salary_type_id' => $this->salary_typeID, 
                    'is_cleared' => 0, 
                    'cycle_date' => date('Y-m-d'),
                    'cycle_date_end' => $this->cycle_date_end
                );
                $this->db->trans_start();
                $this->db->insert($this->table['cycle'], $data);
                $this->cycleID = $this->db->insert_id();
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();
                    $this->cycleID = $this->end_cycle_date_now();  
                    return $this->cycleID;                  
                }
            } 
            catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** generate cycle end date in user end */
        public function end_cycle_date_now(){            
            try {
                $cycle_date = $this->get_latest_cycle();                                
                if(date('d', strtotime(date('Y-m-d'))) <= date('d', strtotime(date("Y-m-15")))){   
                    $data = array(
                        'cycle_date_end' => date('d', strtotime(date("Y-m-15")))
                    );              
                    $this->db->trans_start();
                    $this->db->where('cycle_date_end', NULL);
                    $this->db->where('user_account_id', $this->session->id);
                    $this->db->where('ID', $this->cycleID);
                    $this->db->update($this->table['cycle'], $data);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE)
                    {                
                        $this->db->trans_rollback();
                        throw new Exception(ERROR_PROCESSING, true);	
                    }else{
                        $this->db->trans_commit();                          
                        return $this->cycleID;                         
                    }
                }else{
                    $last_day_of_month = strtotime(date("Y-m-d") . ", last day of this month");                                                  
                    $datas = array(
                        'cycle_date_end' => date("Y-m-d", $last_day_of_month)
                    );
                    $this->db->trans_start();
                    $this->db->where('cycle_date_end', NULL);
                    $this->db->where('user_account_id', $this->session->id);
                    $this->db->where('ID', $this->cycleID);
                    $this->db->update($this->table['cycle'], $datas);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE)
                    {                
                        $this->db->trans_rollback();
                        throw new Exception(ERROR_PROCESSING, true);	
                    }else{
                        $this->db->trans_commit();                           
                        return $this->cycleID;                          
                    }
                }
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** generate cycle end date */
        public function generate_cycle_end_date(){
            try {
                $cycle_date = $this->get_latest_cycle();                                
                if(date('d', strtotime(@$cycle_date->cycle_date)) <= date('d', strtotime(date("Y-m-15")))){   
                    $data = array(
                        'cycle_date_end' => date('d', strtotime(date("Y-m-15")))
                    );              
                    $this->db->trans_start();
                    $this->db->where('cycle_date_end', NULL);
                    $this->db->where('user_account_id', $this->session->id);
                    $this->db->where('ID', @$cycle_date->ID);
                    $this->db->update($this->table['cycle'], $data);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE)
                    {                
                        $this->db->trans_rollback();
                        throw new Exception(ERROR_PROCESSING, true);	
                    }else{
                        $this->db->trans_commit();                            
                    }
                }else{
                    $last_day_of_month = strtotime(date("Y-m-d", strtotime($cycle_date->cycle_date)) . ", last day of this month");                                                  
                    $datas = array(
                        'cycle_date_end' => date("Y-m-d", $last_day_of_month)
                    );
                    $this->db->trans_start();
                    $this->db->where('cycle_date_end', NULL);
                    $this->db->where('user_account_id', $this->session->id);
                    $this->db->where('ID', @$cycle_date->ID);
                    $this->db->update($this->table['cycle'], $datas);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE)
                    {                
                        $this->db->trans_rollback();
                        throw new Exception(ERROR_PROCESSING, true);	
                    }else{
                        $this->db->trans_commit();                            
                    }
                }
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get salary type id of a user */
        public function get_salary_type_id(){
            try {
                $this->db->select('salary_type_id');
                $this->db->order_by('ID', 'desc');
                $this->db->from($this->table['cycle']);
                $this->db->where('user_account_id', $this->session->id);
                $this->db->where('is_cleared', 1);
                $query = $this->db->get()->row();

                return @$query->salary_type_id;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** get latest salary cycle */
        public function get_latest_cycle(){
            try{
                $this->db->select('sc.ID, '. 'sc.cycle_date');
                $this->db->order_by('sc.ID', 'desc');
                $this->db->from($this->table['cycle'].' sc');
                $this->db->where('sc.is_cleared', 0);
                $this->db->where('sc.user_account_id', $this->session->id);
                $query = $this->db->get()->row();

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** insert into orderline table */
        public function insert_orderline(){            
            try{
                if(empty($this->productID)){
                    throw new Exception(ERROR_PROCESSING, true);
                } 

                $orderLineData = array(
                    'order_no' => $this->orderNo, 
                    'product_id' => $this->productID,
                    'qty' => 1, 
                    'product_unit' => $this->productUnit, 
                    'product_category_id' => $this->productCatID, 
                    'product_price' => $this->productPrice, 
                    'total_amount' => $this->productPrice
                );
                $this->db->trans_start();
                $this->db->insert($this->table['orderL'], $orderLineData);   
                $this->db->trans_complete();
                
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();
                    echo json_encode(array('message'=>ADDED_TO_CART, 'has_error'=>false));
                }
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check if order is confirmed cancelled */
        public function check_order_confirmed(){
            try{
                $this->db->select(
                    'oh.order_no'
                );
                $this->db->from($this->table['orderh'].' oh');
                $this->db->where('oh.user_account_id', $this->session->id);
                $this->db->where('oh.order_status_id', null);
                $query = $this->db->get()->row();

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** delete product list */
        public function delete_product(){            
            try{
                if(empty($this->orderNum)){
                    throw new Exception(ERROR_PROCESSING, true);
                } 
                $check = $this->check_to_delete_orderno();                
                if($check === 1){
                    $this->delete_order_head();
                }else{
                    if($check == true){
                        $this->delete_order_line();
                    }   
                }                                             
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }        
        /** delete order lined */
        public function delete_order_line(){
            try{
                $this->db->trans_start();
                $this->db->where('ID', $this->orderID);
                $this->db->delete($this->table['orderL']);
                $this->db->trans_complete();
                    
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();    
                    echo json_encode(array('message'=>'Success', 'has_error'=>false));
                }
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }            
        }
        /** delete order head */
        public function delete_order_head(){
            try{
                $this->db->trans_start();
                $this->db->where('order_no', $this->orderNum);
                $this->db->delete($this->table['orderh']);
                $this->db->trans_complete();
                    
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();    
                    $this->delete_order_line();
                }
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }            
        }
        /** check oder no to delete */
        public function check_to_delete_orderno(){
            try{
                if(empty($this->orderNum)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->db->select('ol.order_no');
                $this->db->from($this->table['orderL'].' ol');
                $this->db->where('ol.order_no', $this->orderNum);
                $query = $this->db->get()->result();

                return count($query);                
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** add quantity of order */
        public function add_order_quantity(){
            try{
                $check = $this->check_quantity();       
                $quantity = ($check->qty + 1);
                $totalPrice = ($this->orderPrice * $quantity);         
                $addData = array(
                    'qty'=> $quantity,
                    'total_amount' => $totalPrice
                );                
                $this->db->trans_start();
                $this->db->where('ID', $this->orderID);
                $this->db->update($this->table['orderL'], $addData);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();    
                    echo json_encode(array('message'=>'Added', 'price'=>$totalPrice, 'has_error'=>false));
                }
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check quantity */
        public function check_quantity(){
            try{
                $this->db->select('ol.qty');
                $this->db->from($this->table['orderL'].' ol');
                $this->db->where('ol.ID', $this->orderID);
                $query = $this->db->get()->row();

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** subtract order quantity */
        public function subtract_quantity_order(){
            try{
                $check = $this->check_quantity();          
                $quantity = ($check->qty - 1);                      
                $totalPrice = ($this->orderPrice * $quantity);         
                $addData = array(
                    'qty'=> $quantity,
                    'product_price' => $totalPrice
                );               
                if($quantity === 0){
                    $this->delete_order_line();
                }else{
                    $this->db->trans_start();
                    $this->db->where('ID', $this->orderID);
                    $this->db->update($this->table['orderL'], $addData);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE)
                    {                
                        $this->db->trans_rollback();
                        throw new Exception(ERROR_PROCESSING, true);	
                    }else{
                        $this->db->trans_commit();    
                        echo json_encode(array('message'=>'Success', 'has_error'=>false));
                    }
                }                 
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check user pin */
        public function check_pin(){
            try {
                if(empty($this->PIN)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                $this->db->select('us.ID');
                $this->db->from($this->table['user'].' us');
                $this->db->where('us.security_pin', $this->PIN);
                $this->db->where('us.ID', $this->session->id);
                $query = $this->db->get()->row();

                if(empty($query)){          
                    echo json_encode(array('error_message'=>'Invalid PIN Number. Please try again.', 'has_error'=>true));          
                }else{
                    echo json_encode(array('message'=>SUCCESS, 'has_error'=>false));
                }
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** confirm user order */
        public function confirm_order(){
            try{                
                if(empty($this->orderNumber)){
                    throw new Exception(ERROR_PROCESSING, true);
                }                                    
                if($this->total_amount == '150' || $this->total_amount > '150'){
                    throw new Exception('Maximum Credit Limit Per Day <b>(150)</b>. Sorry you have reached the limit');
                }                           
                // $checkPaid = $this->check_isPaid();
                // if(!empty($checkPaid)){
                //     throw new Exception('Settle first previous transaction', true);
                // }                                
                $updateData = array('order_status_id' => 1, 'order_date' => date('Y-m-d H:i:s'));                
                $this->db->trans_start();
                $this->db->where('order_no', $this->orderNumber);
                $this->db->where('user_account_id', $this->session->id);
                $this->db->update($this->table['orderh'], $updateData);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();    
                    $this->subtract_quantity();                    
                }
            }   
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check if user is cleared and can order again this cycle */
        public function check_cycle_cleared(){
            try {   
                $this->db->select('ID');
                $this->db->oder_by('ID', 'desc');
                $this->db->from($this->table['cycle']);
                $this->db->where('is_cleared', 0);
                $this->db->where('user_account_id', $this->db->session->id);
                $query = $this->db->get()->row();

                return $query;
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** cancel order */
        public function cancel_order(){
            try {
                if(empty($this->orderData) || empty($this->orderNumber)){
                    throw new Exception(ERROR_PROCESSING, true);                    
                }
                
                $updateData = array('order_status_id' => 2);                
                $this->db->trans_start();
                $this->db->where('order_no', $this->orderNumber); 
                $this->db->where('ID', $this->orderHiD);                               
                $this->db->where('user_account_id', $this->session->id);
                $this->db->update($this->table['orderh'], $updateData);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();    
                    $this->add_quantity();                    
                }
            } 
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** subtract quantity of a product */
        public function subtract_quantity(){
            try{
                if(empty($this->productIDs)){
                    throw new Exception(ERROR_PROCESSING, true);
                }
                
                foreach ($this->productIDs as $key => $value) {        
                    $this->db->select(
                        'ID as stockID, '. 'qty'
                    );            
                    $this->db->from($this->table['stock']);
                    $this->db->where('product_id', $value->ID);
                    $query = $this->db->get()->row();
                    $this->update_quantity($query->stockID, $value->ID, ($query->qty - $value->Qty));                    
                }                
                if(count($this->productIDs) === 1){
                    echo json_encode(array('message'=>'Order Confirmed', 'has_error'=>false));
                }                
                $keys = array_keys($this->productIDs);
                $last = end($keys);
                if($last){
                    echo json_encode(array('message'=>'Order Confirmed', 'has_error'=>false));
                }
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** add quantity for cancelled orders */
        private function add_quantity(){
            try {                                
                foreach ($this->orderData as $key => $value) {        
                    $this->db->select(
                        'ID as stockID, '. 'qty'
                    );            
                    $this->db->from($this->table['stock']);
                    $this->db->where('product_id', $value->prodID);
                    $query = $this->db->get()->row();
                    $this->update_quantity($query->stockID, $value->prodID, ($query->qty + $value->Qty));
                }  
                $keys = array_keys($this->orderData);
                $last = end($keys);
                if($last){
                    echo json_encode(array('message'=>'Order Cancelled', 'has_error'=>false));
                }
            } 
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** update quantity in stock */
        public function update_quantity($stockID='', $prodID='', $Qty=''){
            try{
                $toUpdateData = array(
                    'qty' => $Qty
                );
                $this->db->trans_start();
                $this->db->where('product_id', $prodID);
                $this->db->where('ID', $stockID);
                $this->db->update($this->table['stock'], $toUpdateData);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE)
                {                
                    $this->db->trans_rollback();
                    throw new Exception(ERROR_PROCESSING, true);	
                }else{
                    $this->db->trans_commit();                                                                
                }                
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check if user is cleared to credits */
        public function check_isPaid(){
            try{
                $this->db->select('oh.ID');
                $this->db->order_by('oh.ID', 'desc');
                $this->db->from($this->table['orderh'].' oh');
                $this->db->join($this->table['orderStat'].' os', 'os.ID = oh.order_status_id', 'left');
                $this->db->where('oh.order_status_id !=', NULL);
                $this->db->where('os.order_status', 'Confirmed');
                $this->db->where('oh.user_account_id', $this->session->id);
                $query = $this->db->get()->row();

                return $query;
            }
            catch(Exception $msg){
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
        /** check order credits */
        public function check_order_credits(){
            try {
                
                $total = 0;
                $this->db->select(
                    'oh.*, '. 
                    'os.order_status, '. 
                    'ol.total_amount'                                     
                );
                $this->db->order_by('oh.ID', 'desc');
                $this->db->from($this->table['user'].' us');
                $this->db->join($this->table['cycle'].' cl', 'cl.user_account_id = us.id', 'left');
                $this->db->join($this->table['orderh'].' oh', 'cl.ID = oh.salary_cycle_id', 'left');    
                $this->db->join($this->table['orderL'].' ol', 'ol.order_no = oh.order_no', 'left');                          
                $this->db->join($this->table['orderS'].' os', 'os.ID = oh.order_status_id', 'left');
                $this->db->where('cl.is_cleared', 0);
                $this->db->where('us.id', $this->session->id);
                $this->db->where('os.order_status !=', 'Cancelled');   
                $this->db->where('DATE(oh.order_date)', date('Y-m-d')); 
                $query = $this->db->get()->result();

                foreach (@$query as $key => $value) {
                    $total += @$value->total_amount;
                }
                
                return $total;
                
            } catch (Exception $msg) {
                echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
            }
        }
    }
?>