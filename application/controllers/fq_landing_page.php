<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Fq_landing_page extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('fq_landing_page/list_view'));
		exit();
	}
	
	public function list_view ($start = 0) // PAGE VIEW
	{		
		$data = $this->data;
		$data['title'] = 'Landing Pages - FinQuote';

		$limit = 50;
		$count_result = $this->fqlanding_model->get_landing_pages_count($_GET);  // Record count
		$data['landing_pages'] = $this->fqlanding_model->get_landing_pages($_GET, $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('fq_landing_page/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$this->load->view('admin/fq_landing_pages', $data);
	}
	
    public function record ($lp_id) // MODAL VIEW
    {
		$query = "
		SELECT * FROM fq_landing_pages WHERE 1 AND deprecated <> 1 AND id_fq_landing_page = ".$lp_id." LIMIT 1";
		$result = $this->db->query($query);

		foreach ($result->result() as $row)
		{
			$lp_arr = array(
				"lp_title" => $row->title, 
				"lp_subtitle" => $row->subtitle,
				"lp_root" => $row->root,
				"lp_website_url" => $row->website_url,
				"lp_content" => $row->content
			);
		}
		echo json_encode($lp_arr);
    }
	
	public function update_record () // MODAL ACTION
	{
		$data = $this->data;
		$lp_arr = $this->input->post();
		$this->fqlanding_model->update_fq_lp($lp_arr);
	}	
}
?>