<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard_service extends MY_Controller {

		private $data = [];
		protected $session;
		public function __construct()
		{
			parent::__construct(); 
			$this->session = (object)get_userdata(USER);
			
			if(is_empty_object($this->session)){
				redirect(base_url().'dashboard/authentication', 'refresh');
			}

			$model_list = [
				'dashboard/Dashboard_model' => 'dModel', 
				'dashboard/service/Dashboard_services_model' => 'dsModel'			
			];
			$this->load->model($model_list);
		}

		/** add order data to db */
		public function add_order()
		{
			try{
				if(empty($this->input->post('productID', true))){
					throw new Exception(ERROR_PROCESSING, true);
				}
				$this->dsModel->productID = $this->input->post('productID', true);
				$this->dsModel->productUnit = $this->input->post('prodUnit', true);
				$this->dsModel->productCatID = $this->input->post('prodCatID', true);
				$this->dsModel->productPrice = $this->input->post('prodPrice', true);
				$this->dsModel->add_order_head();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}	
		/** delete order list */
		public function delete_order(){			
			try{
				if(empty($this->input->post('orderNo', true))){
					throw new Exception(ERROR_PROCESSING, true);
				}
				$this->dsModel->orderID = $this->input->post('orderID', true);
				$this->dsModel->orderNum = $this->input->post('orderNo', true);
				$this->dsModel->delete_product();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
		/** add quantity of order */
		public function add_order_quantity(){
			try{
				if(empty($this->input->post('orderID', true))){
					throw new Exception(ERROR_PROCESSING, true);
				}
				$this->dsModel->orderID = $this->input->post('orderID', true);
				$this->dsModel->orderPrice = $this->input->post('orderPrice', true);
				$this->dsModel->add_order_quantity();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
		/** subtract quantity of order */
		public function subtract_quantity(){
			try{
				if(empty($this->input->post('orderID', true))){
					throw new Exception(ERROR_PROCESSING, true);
				}
				$this->dsModel->orderID = $this->input->post('orderID', true);
				$this->dsModel->orderPrice = $this->input->post('orderPrice', true);
				$this->dsModel->subtract_quantity_order();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
		/** confirm user order */
		public function confirm_order(){
			try{
				if(empty($this->input->post('orderNo', true))){
					throw new Exception(ERROR_PROCESSING, true);
				}
				$this->dsModel->productIDs = json_decode($this->input->post('productIDs', true));				
				$this->dsModel->orderNumber = $this->input->post('orderNo', true);	
				$this->dsModel->total_amount = $this->input->post('total_amount', true);							
				$this->dsModel->confirm_order();
			}
			catch(Exception $msg){
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
		/** cancel user order */
		public function cancel_order(){
			try {
				if(empty($this->input->post('orderHiD')) || empty($this->input->post('orderNo')) || empty($this->input->post('orderData'))){
					throw new Exception(ERROR_PROCESSING, true);
				}
				$this->dsModel->orderData = json_decode($this->input->post('orderData', true));	
				$this->dsModel->orderNumber = $this->input->post('orderNo', true);			
				$this->dsModel->orderHiD = $this->input->post('orderHiD', true);
				$this->dsModel->cancel_order();
			} 
			catch (Exception $msg) {
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
		/** chech pin */
		public function check_pin(){
			try {
				if(empty($this->input->post('PIN', true))){
					throw new Exception("PLEASE INPUT PIN NUMBER", true);
				}
				$this->dsModel->PIN = $this->input->post('PIN', true);
				$this->dsModel->check_pin();
			} catch (Exception $msg) {
				echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
			}
		}
	}		
?>
