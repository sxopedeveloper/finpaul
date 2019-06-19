<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Accessory extends Admin_main {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		header("Location: " . site_url('accessory/list_view'));
		exit();
	}	
	
	public function list_view ($start = 0) // PAGE VIEW (LV)
	{
		$data = $this->data;
		$data['title'] = 'Accessories - List View';

		$limit = 30;
		$count_result = $this->accesory_model->get_accessories_count($_GET);
		$data['accessories'] = $this->accesory_model->get_accessories($_GET, $start, $limit); // Main Query
		$data['accessory_suppliers'] = $this->accesory_supplier_model->get_accessory_suppliers();

		$data['makes_row'] = $this->fapplication_model->get_dropdown_data(array("code"=>1));

		$this->load->library('pagination');
		$config['base_url'] = site_url('lead/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];
		$this->load->view('admin/leads', $data);
	}

	public function generate_accessories_json ()
	{
		$accessories = $this->accessory_model->get_accessories();

		$accessories_html = '
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive" style="margin-top: 10px;">
					<table class="table table-condensed mb-none">
						<thead>
							<tr>
								<td><i class="fa fa-plus"></i></td>
								<td><b>Supplier</b></td>
								<td><b>Code</b></td>
								<td><b>Name</b></td>
								<td><b>Cost</b></td>
							</tr>
						</thead>
						<tbody>';
						foreach ($accessories AS $accessory)
						{
							$accessories_html .= '
							<tr>
								<td>
									<a href="'.site_url('').'">
										<i class="fa fa-plus"></i>
									</a>
								</td>
								<td>'.$accessory['accessory_supplier_name'].'</td>
								<td>'.$accessory['accessory_code'].'</td>
								<td>'.$accessory['accessory_name'].'</td>
								<td>'.$accessory['cost'].'</td>
							</tr>';
						}
						$accessories_html .= '
						</tbody>
					</table>
				</div>
			</div>
		</div>';
		
		$output_arr = array(
			'html' => $accessories_html
		);
		
		echo json_encode($output_arr);
	}
	
	public function initialize_create_accessory_modal ()
	{
		$data = $this->data;

		$return_data = [];

		$accessory_suppliers = $this->accessory_supplier_model->get_accessory_supplier();

		$suppliers_html = "";

		$suppliers_html .= "<option value=''>--Accessory Supplier--</option>";

		foreach ($accessory_suppliers as $a_key => $a_val) 
		{
			$suppliers_html .= "<option value='{$a_val['id_accessory_supplier']}'>{$a_val['name']}</option>";
		}

		$return_data = [
			'suppliers_html' => $suppliers_html
		];

		echo json_encode($return_data);
	}

	public function insert_new_accessory ()
	{
		$data = $this->data;

		$post_data = $this->input->post();

		$id_accessory = $this->accessory_supplier_model->insert_new_accessory($post_data);

		$description = '[{"fk_accessory_supplier":"'.$post_data["fk_accessory_supplier"].'","code":"'.$post_data["code"].'","name":"'.$post_data["name"].'","cost":"'.$post_data["cost"].'","description":"'.$post_data["description"].'"}]';

		$audit_trail_arr = array(
			'id'          => $id_accessory,
			'table_name'  => 'accessories',
			'action'      => 35,
			'description' => $description
		);
		
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);

		$supplier_data = $this->accessory_supplier_model->get_supplier($post_data["fk_accessory_supplier"]);

		$accessory_html = '
			<tr id="acc_tb_tr_'.$id_accessory.'" data-idacc="'.$id_accessory.'"
				data-supplier="'.$supplier_data["name"].'" data-code="'.$post_data["code"].'" data-name="'.$post_data["name"].'" data-cost="'.$post_data["cost"].'">
				<td class="acc_check_td"><center><input class="acc_check" name="acc_check" type="checkbox" value="'.$id_accessory.'"></center></td>
				<td >'.$post_data["code"].'</td>
				<td >'.$post_data["name"].'</td>
				<td >'.$post_data["cost"].'</td>
			</tr>';

		echo $accessory_html;
	}

	public function insert_new_accessory_supplier ()
	{
		$data = $this->data;

		$post_data = $this->input->post();

		$id_supplier = $this->accessory_supplier_model->insert_new_supplier($post_data);

		$description = '[{"name":"'.$post_data["name"].'","abn":"'.$post_data["abn"].'","email":"'.$post_data["email"].'","phone":"'.$post_data["phone"].'","address_line_1":"'.$post_data["address_line_1"].'","address_line_2":"'.$post_data["address_line_2"].'","suburb":"'.$post_data["suburb"].'","postcode":"'.$post_data["postcode"].'","state":"'.$post_data["state"].'","description":"'.$post_data["description"].'"}]';

		$audit_trail_arr = array(
			'id'          => $id_supplier,
			'table_name'  => 'accessory_suppliers',
			'action'      => 36,
			'description' => $description
		);
		
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);

		$supplier_option = "<option value='{$id_supplier}'>{$post_data["name"]}</option>";

		echo $supplier_option;
	}
}


