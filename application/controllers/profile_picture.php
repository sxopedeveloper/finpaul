<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('user_main.php');

class Profile_picture extends User_main {

	function __construct() {
		
		parent::__construct();
	
	}

	function index () {
		
		$data = $this->data;	
		$data['title'] = "Profile Picture";

		$data['delivery_percentage'] = 0;
		$data['user'] = $this->user_model->get_dealer($data['user_id']);

		// ORDERS //
		$order_param = array();

		$order_param['status'] = 0;
		$count_result = $this->lead_model->get_orders_count($order_param, $data['user_id']);
		$data['new_orders_count'] = $count_result['cnt'];

		$order_param['status'] = 1;
		$count_result = $this->lead_model->get_orders_count($order_param, $data['user_id']);
		$data['deliveries_pending_count'] = $count_result['cnt'];

		$order_param['status'] = 2;
		$count_result = $this->lead_model->get_orders_count($order_param, $data['user_id']);
		$data['delivered_count'] = $count_result['cnt'];

		$count_result = $this->request_model->get_dealer_quote_requests_count($data['user_id'], 2);
		$data['tenders_won_count'] = $count_result['cnt'];

		$count_result = $this->request_model->get_dealer_quote_requests_count($data['user_id'], 0);
		$data['quote_requests_count'] = $count_result['cnt'];

		$data['newest_orders'] = $this->lead_model->get_newest_orders($data['user_id']);
		$data['incoming_deliveries'] = $this->lead_model->get_incoming_deliveries($data['user_id']);		

		// LEADS //
		$leads_arr = array();
		$dealership_brands_arr = explode(',', $data['user']['dealership_brand']);

		$data['newest_leads'] = $this->lead_model->get_newest_available_leads($data['user_id'], $data['user']['state'], $dealership_brands_arr);

		$count_result = $this->lead_model->get_available_leads_count($data['user_id'], $data['user']['state'], $dealership_brands_arr);
		$data['available_leads_count'] = $count_result['cnt'];

		$count_result = $this->lead_model->get_purchased_leads_count($leads_arr, $data['user_id']);
		$data['purchased_leads_count'] = $count_result['cnt'];

		$data['token_infos'] = $this->payment_model->get_token_infos($data['user_id']);

		$data['makes'] = $this->user_model->get_makes();

		$this->load->view('profile_picture', $data);
	
	}
	
	function test_sess(){
		
		print_r( $this->session->userdata );
		
	}
	
	function update() {
		
		$data = $this->data;
		// print_r( $data['user_id'] );
		
		// echo $this->input->post('image');
		
		if( $this->user_model->update_picture( $data['user_id'] , $_POST['image'] ) ){
			
			echo true;
			
		}
		
	}

}