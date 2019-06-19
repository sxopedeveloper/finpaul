<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Email_Template extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('email_template/list_view'));
		exit();
	}

	public function add_record () // PAGE ACTION
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->emailtemplate_model->insert_email_template($input_arr);
	}

	public function update_record ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->emailtemplate_model->update_email_template($input_arr);
	}

	public function record ($email_template_id) // MODAL VIEW (EMAIL TEMPLATE POPUP)
	{
		$data = $this->data;

		$email_template = $this->emailtemplate_model->get_email_template($email_template_id);
		$email_template_arr = array(
			"description" => $email_template['description'],
			"subject" => $email_template['subject'],
			"eq_function" => $email_template['eq_function'],
			"content" => $email_template['content'],
			"attachment" => $email_template['attachment']
		);

		echo json_encode($email_template_arr);
	}	

	public function list_view ($start = 0) // PAGE VIEW (LV)
	{		
		$data = $this->data;
		$data['title'] = 'Email Templates - List View';

		$limit = 50;
		$count_result = $this->emailtemplate_model->get_email_templates_count($_GET);  // Record count
		$data['email_templates'] = $this->emailtemplate_model->get_email_templates($_GET, $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('email_template/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$data['session_data'] = $this->data;

		$data['result_count'] = $count_result['cnt'];
		$this->load->view('admin/email_templates', $data);
	}

	public function update_email_template_data(){		
		$data = $this->data;
		$input_arr = $this->input->post();

		/*echo "<pre>";
		//print_r($input_arr);
		echo "<br>111";
		echo $this->input->post('email_content',FALSE);exit;*/
		$this->emailtemplate_model->update_email_template_new($input_arr);
	}
	
}
?>