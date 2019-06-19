<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Dealer extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('dealer/list_view'));
		exit();
	}
	
	public function list_view ($start = 0) // PAGE VIEW
	{
		$data = $this->data;
		$data['title'] = 'Car Dealers';

		$limit = 10;
		$count_result = $this->user_model->get_dealers_count($_GET); // Record count
		$data['dealers'] = $this->user_model->get_dealers($_GET, $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('dealer/list_view/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$data['result_count'] = $count_result['cnt'];
		$this->load->view('admin/dealers', $data);
	}	
	
	public function activate ($user_id) // PAGE ACTION (Convert to AJAX)
	{
		$this->user_model->activate_dealer($user_id);
		header("Location: ".site_url('dealer/list_view'));
		exit();
	}
	
	public function add_document_tender($uploadKey='')
	{
		if($uploadKey!="")
		{
			$where = array("uploadKey"=>$uploadKey);
			$row = $this->user_model->getRow("dealer_requests",$where);
			if($row)
			{
				$data = array();
				$data['id_dealer'] = $row->fk_user;
				$data['company'] = array("favicon"=>"");
				$this->load->view("admin/upload_document",$data);
			}
			else
			{
				redirect(site_url());
			}
		}
		else
		{
			redirect(site_url());
		}
	}
	public function deactivate ($user_id) // PAGE ACTION (Convert to AJAX)
	{
		$this->user_model->deactivate_dealer($user_id);
		header("Location: ".site_url('dealer/list_view'));
		exit();
	}	
	
	public function delete ($user_id) // PAGE ACTION (Convert to AJAX)
	{
		$this->user_model->delete_dealer($user_id);
		header("Location: ".site_url('dealer/list_view'));
		exit();
	}	
}
?>