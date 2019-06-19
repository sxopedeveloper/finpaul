<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Cq_landing_page extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('cq_landing_page/list_view'));
		exit();
	}

	public function list_view ($start = 0) // PAGE VIEW
	{
		$data = $this->data;
		$data['title'] = 'Landing Pages - Quote Me';

		$limit = 50;
		$count_result = $this->landing_model->get_landing_pages_count($_GET);  // Record count
		$data['landing_pages'] = $this->landing_model->get_landing_pages($_GET, $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('cq_landing_page/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$this->load->view('admin/cq_landing_pages', $data);
	}
	
    public function record ($lp_id) // MODAL VIEW
    {
		$query = "SELECT * FROM landing_pages WHERE 1 AND deprecated <> 1 AND id_landing_page = ".$lp_id." LIMIT 1";
		$result = $this->db->query($query);
		foreach ($result->result() as $row)
		{
			$lp_arr = array(
				"lp_root" => $row->root,
				"lp_website_url" => $row->website_url,
				"lp_make" => $row->make,
				"lp_model" => $row->model,
				"lp_img" => $row->img,
				"lp_main_color" => $row->main_color,
				"lp_get_quotes_size" => $row->get_quotes_size,
				"lp_bing" => $row->bing,
				"lp_google_analytics" => $row->google_analytics,
				"lp_google_conversion_id" => $row->google_conversion_id,
				"lp_google_conversion_label" => $row->google_conversion_label,
				"lp_content" => $row->content
			);
		}
		echo json_encode($lp_arr);
    }
	
	public function update_record () // MODAL ACTION
	{
		$data = $this->data;
		$lp_arr = $this->input->post();
		$this->landing_model->update_landing($lp_arr);
	}

	public function upload_landing_image ()
	{
		$post_data = $this->input->post();
		$request_array = array();
		$data               = $this->data;
		$directory          = $this->landing_page_file_base_path;
		$prefix             = time();
		$file_name          = $_FILES['file']['name'];
		$file_tmp           = $_FILES['file']['tmp_name'];

		$file               = $directory.$prefix.".png";
		$database_file_name = $prefix.".png";
		
		if (move_uploaded_file($file_tmp, $file))
		{
			if ($this->landing_model->update_image($post_data['modal_id'], $database_file_name))
			{
				echo $database_file_name;
			}
		}
	}
}
?>