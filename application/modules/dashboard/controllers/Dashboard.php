<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	

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

	/** load main page */
	public function index()
	{
		$this->data['credits'] = $this->dsModel->check_order_credits();
		$this->data['category'] = $this->dModel->get_category();
		$this->data['session'] =  $this->session;		        
		$this->data['content'] = 'index';
		$this->load->view('layout',$this->data);
	}	
	/** statement of account */
	public function statement_account(){
		try{			
			$this->data['Coverage'] = $this->dModel->get_coverage();
			$this->data['Creditss'] = $this->dModel->get_total_credits();			
			$this->data['Balances'] = $this->dModel->get_total_balance();
			$this->data['Incomes'] 	= $this->dModel->get_total_class_amount();
			$this->data['content'] = "grid/load_statement_account";
			$this->load->view('layout',$this->data);
		}	
		catch(Exception $msg){
			echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
		}
	}
	/** get all menus every day */
	public function get_all_menus(){
		try{
			if(empty($this->input->post('ID', true))){
				throw new Exception(ERROR_PROCESSING, true);
			}
			$this->dModel->productID = $this->input->post('ID', true);
			$this->data['result'] = $this->dModel->get_all_menu();
			$this->data['content'] = "grid/load_menus";
			$this->load->view('layout', $this->data);
		}
		catch(Exception $msg){
			echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
		}
	}
	/** laod all order list per user */
	public function load_order_lists(){
		try{
			$this->data['result'] = $this->dModel->get_order_list();
			$this->data['content'] = 'grid/load_order_list';
			$this->load->view('layout', $this->data);
		}
		catch(Exception $msg){
			echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
		}
	}
	/** load list of history */
	public function load_order_history(){
		try{
			$this->dModel->start_date = $this->input->post('startDate', true);
			$this->dModel->end_date = $this->input->post('endDate', true);
			$this->data['result'] = $this->dModel->get_order_history();
			$this->data['content'] = "grid/load_order_history";
			$this->load->view('layout', $this->data);
		}
		catch(Exception $msg){
			echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
		}
	}
	/** load modal list or order history */
	public function load_histo_modal(){
		try{
			$this->dModel->orderID = $this->input->post('orderID', true);			
			$this->data['result'] = $this->dModel->get_to_load_histo_modal();			
			$this->data['content'] = "grid/order_histo_modal";
			$this->load->view('layout', $this->data);
		}
		catch(Exception $msg){
			echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
		}
	}
	/** view receipt order */
	public function order_receipt(){
		try {
			$this->dModel->orderID = $this->input->get('id', true);
			$this->dModel->orderNumber = $this->input->get('num', true);			
			$this->data['content'] =  'view_receipt';
			$this->load->view('layout', $this->data);
		} catch(Exception $msg){
			echo json_encode(array('error_message'=>$msg->getMessage(), 'has_error'=>true));
		}
	}
}
