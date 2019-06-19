<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');
ob_start();
class Quote extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('quote/search'));
		exit();
	}

	public function search ($start = 0) // PAGE VIEW
	{
		$data = $this->data;
		$data['title'] = 'Quote Search';
		$data['makes'] = $this->car_model->get_makes();

		$limit = 10;
		$count_result = $this->quote_model->get_quotes_count($_GET); // Record count
		$data['quotes'] = $this->quote_model->get_quotes($_GET, $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('quote/search/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
	//	echo json_encode($data['links']); die();
		$data['result_count'] = $count_result['cnt'];
		
		$quotesearch='';
		$quotesearch='<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
						<span class="label label-primary label-sm text-normal va-middle mr-sm">'.$data['result_count'].'</span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>

						<form action="'.site_url('quote/search').'" method="get" accept-charset="utf-8" id="searchquote">
							<div class="panel-body">
								<div class="form-group">';
									
									$quote_number = isset($_GET['quote_number']) ? $_GET['quote_number'] : '';
									$quote_specialist = isset($_GET['quote_specialist']) ? $_GET['quote_specialist'] : '';
									$client_name = isset($_GET['client_name']) ? $_GET['client_name'] : '';
									$client_email = isset($_GET['client_email']) ? $_GET['client_email'] : '';
									
									$make_value = isset($_GET['make']) ? $_GET['make'] : '';
									$model_value = isset($_GET['model']) ? $_GET['model'] : '';
									$build_date_value = isset($_GET['build_date']) ? $_GET['build_date'] : '';
									$variant_value = isset($_GET['vehicle']) ? $_GET['vehicle'] : '';
									
									$series = isset($_GET['series']) ? $_GET['series'] : '';
									$body_type = isset($_GET['body_type']) ? $_GET['body_type'] : '';
									$transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';
									$colour = isset($_GET['colour']) ? $_GET['colour'] : '';
									$fuel_type = isset($_GET['fuel_type']) ? $_GET['fuel_type'] : '';
									$postcode = isset($_GET['postcode']) ? $_GET['postcode'] : '';
									$state = isset($_GET['state']) ? $_GET['state'] : '';
									$dealership_name = isset($_GET['dealership_name']) ? $_GET['dealership_name'] : '';
									$manager_name = isset($_GET['manager_name']) ? $_GET['manager_name'] : '';
									$username = isset($_GET['username']) ? $_GET['username'] : '';
									
									$winner = isset($_GET['winner']) ? $_GET['winner'] : '';
									
									$quotesearch .='<div class="col-md-6 text-left">
										<label>CQ Number:</label>
										<input value="'.$quote_number.'" class="form-control input-md" id="quote_number" name="quote_number" type="text"><br />
									</div>			
									<div class="col-md-6 text-left">
										<label>Quote Specialist Email:</label>
										<input value="'.$quote_specialist.'" class="form-control input-md" id="quote_specialist" name="quote_specialist" type="text"><br />
									</div>
									
									<div class="col-md-3 text-left">
										<label>Client Email:</label>
										<input value="'.$client_email.'" class="form-control input-md" id="client_email" name="client_email" type="text"><br />
									</div>
									<div class="col-md-3 text-left">
										<label>Client Name:</label>
										<input value="'.$client_name.'" class="form-control input-md" id="client_name" name="client_name" type="text"><br />
									</div>
									<div class="col-md-3 text-left">
										<label>Postcode:</label>
										<input value="'.$postcode.'" class="form-control input-md" id="postcode" name="postcode" type="text"><br />
									</div>
									
									<div class="col-md-3 text-left">
										<label>State:</label>
										<input value="'.$state.'" class="form-control input-md" id="state" name="state" type="text"><br />
									</div>

									<div class="col-md-3 text-left">
										<label>Make:</label>				
										<select class="form-control" id="make_dropdown" name="make" title="Make" onchange="load_families(this.options[this.selectedIndex].value)">
											<option name="make" value=""></option>';
											
											foreach ($data['makes'] as $make)
											{
												$selected_make = "";
												if ($make->id_make == $make_value) { $selected_make = " selected "; }
												
												$quotesearch .='<option name="make" value="'.$make->id_make.'" '.$selected_make.'>'.$make->name.'</option>';
												
											}
											
									$quotesearch .='</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label>Model:</label>										
										<select class="form-control" id="family_dropdown" name="family" title="Model" onchange="load_build_datess(this.options[this.selectedIndex].value)" disabled>
											<option name="family" value=""><span id="family_loader"></span></option>
										</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label>Build Date:</label>
										<select class="form-control" id="build_date_dropdown" name="build_date" title="Build Date" onchange="load_vehicless(this.options[this.selectedIndex].value)" disabled>
											<option name="build_date" value=""><span id="build_date_loader"></span></option>
										</select>
										<br />
									</div>													
									<div class="col-md-3 text-left">
										<label>Variant:</label>
										<select class="form-control" id="vehicle_dropdown" name="vehicle" title="Variant" disabled>
											<option name="vehicle" value=""><span id="vehicle_loader"></span></option>
										</select>
										<br />
									</div>

									<div class="col-md-6 text-left">
										<label>Series:</label>
										<input value="'.$series.'" class="form-control input-md" id="series" name="series" type="text"><br />
									</div>
									<div class="col-md-6 text-left">
										<label>Body Type:</label>
										<input value="'.$body_type.'" class="form-control input-md" id="body_type" name="body_type" type="text"><br />
									</div>

									<div class="col-md-4 text-left">
										<label>Transmission:</label>
										<input value="'.$transmission.'" class="form-control input-md" id="transmission" name="transmission" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Colour:</label>
										<input value="'.$colour.'" class="form-control input-md" id="colour" name="colour" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Fuel Type:</label>
										<input value="'.$fuel_type.'" class="form-control input-md" id="fuel_type" name="fuel_type" type="text"><br />
									</div>
									
									<div class="col-md-4 text-left">
										<label>Dealership Name:</label>
										<input value="'.$dealership_name.'" class="form-control input-md" id="dealership_name" name="dealership_name" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Fleet Manager:</label>
										<input value="'.$manager_name.'" class="form-control input-md" id="manager_name" name="manager_name" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Dealer Email:</label>
										<input value="'.$username.'" class="form-control input-md" id="username" name="username" type="text"><br />
									</div>';									

									
									$winner_checked = "";
									if ($winner == 1)
									{
										$winner_checked = " checked";
									}
									

									$quotesearch .='<div class="col-md-12 text-right">
										<input type="checkbox" name="winner" id="winner" value="1" '.$winner_checked.'> Winning Quotes Only
									</div>
									<div class="col-md-12 text-center">
										<br />
										<input value="Search" name="submit" onclick="qsearch()" class="btn btn-primary pull-right push-bottom" type="button">
									</div>
								</div>
							</div>
						</form>
					</section>
					<section class="panel">
						<div class="panel-body">
							<div class="">';
								
								if (count($data['quotes'])==0)
								{
									$quotesearch .='<br /><center><i>No results found!</i></center><br /><br /><br /><br />';
								}
								else
								{
								
									$quotesearch .='<table id="quoteserch" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<td><i class="fa fa-desktop"></i></td>';
												
												if ($data['admin_type'] == 2)
												{
													
													$quotesearch .='<th></th>';
													
												}
										
												$quotesearch .='<td><b><i class="fa fa-trophy"></i></b></td>
												<td><b>Quote Number</b></td>
												<td><b>Consultant</b></td>
												<td><b>Registration</b></td>												
												<td><b>Client Name</b></td>
												<td><b>Client Email</b></td>
												<td><b>Dealer</b></td>
												<td><b>List Price</b></td>
												<td><b>Total Price</b></td>
												<td><b>Make</b></td>
												<td><b>Model</b></td>
												<td><b>Build Date</b></td>
												<td><b>Variant</b></td>
												<td><b>Series</b></td>
												<td><b>Body Type</b></td>
												<td><b>Transmission</b></td>
												<td><b>Colour</b></td>
												<td><b>Fuel Type</b></td>
												<td><b>Postcode</b></td>
												<td><b>State</b></td>
												<td><b>Date</b></td>
											</tr>
										</thead>
										<tbody>';
											
											foreach ($data['quotes'] as $quote)
											{
											
												$quotesearch .='<tr>
													<td>
														<span class="ajax_button_primary quote_modal_button" data-id_lead="'.$quote['id_lead'].'" data-id_quote_request="'.$quote['id_quote_request'].'" data-id_quote="'.$quote['id_quote'].'" data-process="view" onclick="quote_modal_button()">
															<i class="fa fa-edit" data-toggle="tooltip" title="View Quote"></i>
														</span>
													</td>';
													
													if ($data['admin_type'] == 2)
													{
														
														$quotesearch .='<td>
															<input type="hidden" id="quoteid" name="quoteid" value="'.$quote['id_quote'].'" />
																<i class="fa fa-trash-o" onclick="deletequote()" data-toggle="tooltip" data-placement="top" title="Delete Quote"></i>
															
														</td>';
													}
													
													$quotesearch .='<td>
														<b>';
															
															if ($quote['winner'] > 0)
															{
																$quotesearch .='<i class="fa fa-trophy"></i>';
															}
															
														$quotesearch .='</b>
													</td>
													<td>'.$quote['quote_number'].'</td>
													<td>'.$quote['quote_specialist'].'</td>
													<td>'.$quote['registration_type'].'</td>
													<td>'.$quote['client_name'].'</td>
													<td>'.$quote['client_email'].'</td>
													<td>'.$quote['dealer'].'</td>
													<td>'.$quote['list_price'].'</td>
													<td>'.$quote['total'].'></td>
													<td>'.$quote['make'].'</td>
													<td>'.$quote['model'].'</td>
													<td>'.$quote['build_date'].'</td>
													<td>'.$quote['variant'].'</td>
													<td>'.$quote['series'].'</td>
													<td>'.$quote['body_type'].'</td>
													<td>'.$quote['transmission'].'</td>
													<td>'.$quote['colour'].'</td>
													<td>'.$quote['fuel_type'].'</td>
													<td>'.$quote['postcode'].'</td>
													<td>'.$quote['state'].'</td>
													<td>'. $quote['created_at'].'</td>
												</tr>';		
											
											}
											
										$quotesearch .='</tbody>
									</table>
									<br />
									</section>';
								
								}
								
						// $quotesearch .='</div>
							// '.$data['links'].'						
						// </div>						
					// </section>';
		
		echo $quotesearch;
		
		//$this->load->view('admin/quote_search', $data);
	}
	
	public function delete () // PAGE ACTION (Convert to AJAX)
	{
		$input_arr = $this->input->post();
	//	echo json_encode($data); die();
		$id_quote =$input_arr['id_quote'];
		$this->quote_model->delete_quote($id_quote);
		//header("Location: ".site_url('quote/search'));
	//	exit();		
	}	
}
?>