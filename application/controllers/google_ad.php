<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Google_ad extends Admin_main 
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('google_ad/list_view'));
		exit();
	}
	
	public function list_view ($start = 0)
	{
		$data = $this->data;
		$this->load->library('pagination');

		$limit = 20;
		$data = $this->data;
		
		$data['title']         = 'Google Ads';
		$data['landing_pages'] = $this->google_ad_model->get_all_landing_pages();
		$data['google_ads']    = $this->google_ad_model->get_all($_GET, $start, $limit);
		$count_result          = $this->google_ad_model->get_all_count($_GET);

		$config['base_url']    = site_url('google_ad/list_view/');
		$config['total_rows']  = $count_result["cnt"];
		$config['per_page']    = $limit;

		$this->pagination->initialize($config); 

		$default_values = array(
			
		);
		
		$data['links']         = $this->pagination->create_links();
		$data['header']        = '';
		
		$this->load->view('admin/google_ads', $data);
	}	

	public function temp_upload ()
	{
		$directory       = "/home/mycarquo/public_html/myelquoto.com.au/global_images/backgrounds/";
		$suffix          = time();
		$file_name       = $_FILES['file']['name'];
		$file_tmp        = $_FILES['file']['tmp_name'];

		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$file_name = str_replace(".".$ext, "", $file_name);
		$file            = $directory.$file_name . "_" . $suffix . "." . $ext;
		$return_filename = $file_name . "_" . $suffix . "." . $ext;

		if(move_uploaded_file($file_tmp, $file))
		{
			echo $return_filename;
		}	
	}

	public function edit_upload ()
	{
		$post_data = $this->input->post();

		$directory       = "/home/mycarquo/public_html/myelquoto.com.au/global_images/backgrounds/";
		$suffix          = time();
		$file_name       = $_FILES['file']['name'];
		$file_tmp        = $_FILES['file']['tmp_name'];

		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$file_name = str_replace(".".$ext, "", $file_name);
		$file  = $directory.$file_name . "_" . $suffix . "." . $ext;
		$return_filename = $file_name . "_" . $suffix . "." . $ext;

		$data = [
			'image' => $return_filename,
			'id'    => $post_data['id']
		];

		if(move_uploaded_file($file_tmp, $file))
		{
			$this->google_ad_model->update_image($data);
			echo "http://myelquoto.com.au/global_images/backgrounds/".$return_filename;
		}	
	}

	public function get_ads ()
	{
		$ads_id = $this->input->post('id');
		$directory = "http://myelquoto.com.au/global_images/backgrounds/";

		$google_ads = [];
		$ads_query = "
		SELECT advertisements.*, landing_pages.root 
		FROM advertisements 
		LEFT JOIN landing_pages
		ON advertisements.fk_landing_page = landing_pages.id_landing_page
		WHERE advertisements.deprecated != 1 
		AND id_advertisement = ".$ads_id;

		$ads_row = $this->db->query($ads_query)->row_array();

		if ($ads_row['img'] == "")
		{
			$final_image = "http://www.mytradevaluation.com.au/uploads/no_image.png";
		}
		else
		{
			$final_image = $directory.$ads_row['img'];
		}

		$google_ads[] = array(
			'root'                         => $ads_row['root'],
			'id_advertisement'             => $ads_row['id_advertisement'],
			'slug'                         => $ads_row['slug'],
			'description'                  => $ads_row['description'],
			'img'                          => $final_image,
			
			'heading_1_line_1_text'        => $ads_row['heading_1_line_1_text'],
			'heading_1_line_1_font_size'   => $ads_row['heading_1_line_1_font_size'],
			'heading_1_line_1_font_weight' => $ads_row['heading_1_line_1_font_weight'],
			
			'heading_1_line_2_text'        => $ads_row['heading_1_line_2_text'],
			'heading_1_line_2_font_size'   => $ads_row['heading_1_line_2_font_size'],
			'heading_1_line_2_font_weight' => $ads_row['heading_1_line_2_font_weight'],
			
			'heading_2_text'               => $ads_row['heading_2_text'],
			'heading_2_font_size'          => $ads_row['heading_2_font_size'],
			'heading_2_font_weight'        => $ads_row['heading_2_font_weight'],
			
			'heading_3_text'               => $ads_row['heading_3_text'],
			'heading_3_font_size'          => $ads_row['heading_3_font_size'],
			'heading_3_font_weight'        => $ads_row['heading_3_font_weight'],
			
			'list_1_text'                  => $ads_row['list_1_text'],
			'list_1_font_size'             => $ads_row['list_1_font_size'],
			'list_1_font_weight'           => $ads_row['list_1_font_weight'],
			
			'list_2_text'                  => $ads_row['list_2_text'],
			'list_2_font_size'             => $ads_row['list_2_font_size'],
			'list_2_font_weight'           => $ads_row['list_2_font_weight'],
			
			'list_3_text'                  => $ads_row['list_3_text'],
			'list_3_font_size'             => $ads_row['list_3_font_size'],
			'list_3_font_weight'           => $ads_row['list_3_font_weight'],
			
			'list_4_text'                  => $ads_row['list_4_text'],
			'list_4_font_size'             => $ads_row['list_4_font_size'],
			'list_4_font_weight'           => $ads_row['list_4_font_weight'],

			'heading_4_line_1_text'        => $ads_row['heading_4_line_1_text'],
			'heading_4_line_1_font_size'   => $ads_row['heading_4_line_1_font_size'],
			'heading_4_line_1_font_weight' => $ads_row['heading_4_line_1_font_weight'],

			'heading_4_line_2_text'        => $ads_row['heading_4_line_2_text'],
			'heading_4_line_2_font_size'   => $ads_row['heading_4_line_2_font_size'],
			'heading_4_line_2_font_weight' => $ads_row['heading_4_line_2_font_weight'],
			
			'fk_landing_page'              => $ads_row['fk_landing_page'],
			'fk_make'					   => $ads_row['fk_make'],
			'fk_family'					   => $ads_row['fk_family']
		);

		echo json_encode( $google_ads );
	}
	
	public function get_landing_page_make ()
	{
		$input_arr = $this->input->post();
		$result = $this->google_ad_model->get_landing_page_make($input_arr['landing_page_id']);
		
		if (!$result['id_make'])
		{
			$result = array(
				'id_make' => '0',
				'make' => 'Car'
			);
		}
		
		echo json_encode($result);
	}
	
	public function edit_ads ($ad_id)
	{	
		$data['settings'] = $this->data['settings'];
		if ($this->session->userdata('logged_in'))
		{
			$data['user_id'] = $this->session->userdata('user_id');
			$data['username'] = $this->session->userdata('username');
			$data['firstname'] = $this->session->userdata('firstname');
			$data['lastname'] = $this->session->userdata('lastname');

			$data['title'] = 'Admin Panel - Site Settings';
			$data['landing_pages'] = $this->landingpage_model->get_all();
			$data['google_ads'] = $this->google_ad_model->getby_id($ad_id);
			$data['header'] = '';
			
			$this->load->view('admin/edit_ads', $data);
		}
		else
		{
			header ("Location: ".site_url('login'));
		}
	}

	public function delete_record ()
	{
		$this->load->model('google_ad_model');
		$this->google_ad_model->delete_ad( );
	}
	
	public function insert_record ()
	{
		$this->load->model('google_ad_model');
		$insert_id = $this->google_ad_model->insert_ad();
		echo $insert_id;
	}
	
	public function update_record ()
	{
		$this->load->model('google_ad_model');
		$this->google_ad_model->update_ad();
	}
}