<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cars extends CI_Controller {

	function __construct()
	{
	    ob_start();
		parent::__construct();
		$this->load->model('car_model', '', TRUE);
		$this->load->model('request_model', '', TRUE);
	}
	public function load_rbdata()
	{
		$make_id = $_POST['id_make'];
		$model_id = $_POST['id_family'];
		$build_date = $_POST['build_date'];
		$id_rbdata = $_POST['id_rbdata'];
		
		//$query = "SELECT * FROM rb_data WHERE year = '".$build_date."' AND make_id = '".$make_id."' AND model_id = '". $model_id."' " ;//LIMIT 100
		$query = "SELECT * FROM rb_data WHERE make_id = '".$make_id."' AND model_id = '". $model_id."' " ;//LIMIT 100
		
		$result = $this->db->query($query);
		$html = '';
		$i = 1;
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{	
				$selected = ($id_rbdata==$row->car_id)?"SELECTED":"";
				
				$dess = unserialize( $row->des);
				$des = implode(" - ",$dess);
				
				$html .= '<option '.$selected.' value="'.$row->car_id.'" >'.$row->name." - ".$des." - ".$row->price.'</option>' ;
			}
		}else
		{	
			$html .= '<option value="" >No Data Found</option>' ;
		}
		
		echo $html;
	}

	public function load_registration_colour($lead_id)
	{
		$quotes = $this->car_model->get_quotes_by_lead_id($lead_id);
		echo json_encode($quotes);
	}

	public function get_accessories($lead_id,$container='')
	{
		/* Quote Id By Lead Id */
		$quoteId = $this->car_model->get_quotes_id($lead_id);
		$quoteId = $quoteId['id_quote_request'];
		/* Quote Accesories By Quote Id */
		if($container == '') {
			$accessory = $this->car_model->get_accessories($quoteId);
		}
		else if($container == 'edit_tender_modal') {
			$accessory = $this->request_model->get_accessories_edit_tender($quoteId);
		}
		$accessories = array();
		foreach ($accessory as $key => $value) {
			array_push($accessories, $value['name']);
		}
		
		echo json_encode($accessories);
	}

	public function load_makes ($make_id)
	{
		$makes = $this->car_model->get_makes();
		$html = '';
		foreach($makes as $make)
		{
			$selected = '';
			if (isset($make_id))
			{
				if ($make_id==$make->id_make) { $selected = ' selected'; }
			}
			$html .= '<option value="'.$make->id_make.'" '.$selected.'>'.$make->name.'</option>';
		}
		echo $html;
	}

	public function load_families ()
	{
		$make_id = $_POST['make_id'];
		$families = $this->car_model->get_families($make_id);
		$html = '';
		foreach($families as $family)
		{
			$selected = '';
			if (isset($_POST['family_id']))
			{
				if ($_POST['family_id']==$family->id_family)
				{
					$selected = ' selected';
				}
			}
			$html .= '<option value="'.$family->id_family.'" '.$selected.'>'.$family->name.'</option>';
		}
		echo $html;
	}

	public function load_build_dates ()
	{
		$family_id = $_POST['family_id'];

		$build_dates = $this->car_model->get_build_dates($family_id);
		$html = '';
		foreach($build_dates as $build_date)
		{
			$selected = '';
			if (isset($_POST['build_date']))
			{
				if ($_POST['build_date']==$build_date->year)
				{
					$selected = ' selected';
				}
			}	
			$html .= '<option value="'.$family_id.'-'.$build_date->year.'" '.$selected.'>'.$build_date->year.'</option>';
		}
		echo $html;
	}
    
    public function load_build_dates_rb ()
	{
		$family_id = $_POST['family_id'];

		$build_dates = $this->car_model->get_build_dates_rb($family_id);
		$html = '';
		foreach($build_dates as $build_date)
		{
			$selected = '';
			if (isset($_POST['build_date']))
			{
				if ($_POST['build_date']==$build_date->year)
				{
					$selected = ' selected';
				}
			}	
			$html .= '<option value="'.$family_id.'-'.$build_date->year.'" '.$selected.'>'.$build_date->year.'</option>';
		}
		echo $html;
	}	
	
	public function load_vehicles ()
	{
		$code = $_POST['code'];
		$vehicles = $this->car_model->get_vehicles($code);
		$html = '';
		foreach($vehicles as $vehicle)
		{
			$selected = '';
			if (isset($_POST['vehicle_id']))
			{
				if ($_POST['vehicle_id']==$vehicle->id_vehicle)
				{
					$selected = ' selected';
				}
			}		
			$html .= '
			<option value="'.$vehicle->id_vehicle.'" '.$selected.'>'.$vehicle->name.'</option>';
		}
		echo $html;
	}

	public function load_options ()
	{
		$vehicle_id = $_POST['vehicle_id'];
		$options = $this->car_model->get_options($vehicle_id);

		$html = '';
		
		if (isset($_POST['quote_request_id']))
		{
			$qr_options = $this->request_model->get_quote_request_options($_POST['quote_request_id']);
		}
		
		foreach($options as $option)
		{
			$items = '';
			if ($option->items <> "")
			{
				$items = '('.$option->items.')';
			}
			
			$checked = '';
			if (isset($_POST['quote_request_id']))
			{				
				foreach ($qr_options AS $qr_option)
				{
					if ($qr_option->id_option==$option->id_option)
					{
						$checked = ' checked';
					}
				}
			}
			$html .= '
			<div class="col-md-4">
				<input type="checkbox" name="options_arr[]" value="'.$option->id_option.'" '.$checked.'> 
				'.$option->name.' '.$items.'
			</div>';
		}
		echo $html;
	}

	public function load_accessories ()
	{
		$quote_request_id = $_POST['quote_request_id'];
		$accessories = $this->request_model->get_accessories($quote_request_id);
		$html = "";
		foreach($accessories as $accessory_index => $accessory)
		{
			if ($accessory_index > 0)
			{
				$hr = "<hr />";
			}
			else
			{
				$hr = "<br />";
			}

			$html .= $hr.'
            <div class="input-group accessory_name">
               <input class="form-control input-md" name="accessory_name[]" type="text" placeholder="Accessory" value="'.$accessory->name.'">
               <span class="input-group-btn">
                    <button style="margin-left: 5px;" class="btn btn-default btn-sm ajax_button remove_accessory_button" data-container="edit_tender_modal" type="button">Remove</button>
               </span>
            </div>
			<textarea style="display:none" class="form-control" name="accessory_desc[]" id="textareaDefault" placeholder="Description">'.$accessory->description.'</textarea>';
		}
		echo $html;
	}	
}