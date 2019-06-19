<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Full_calendar extends Admin_main
{
	private $color_array = [];

	public function __construct()
	{
		parent::__construct();
		$this->color_array = [];
	}

	public function index ()
	{
		$data = $this->data;
		$data['title'] = "Calendar";
		
		$data['session_data'] = $data;

		$t_status_ids                                      = "";
		if (isset($_GET['t_open'])) { $t_status_ids        .= "1, "; $data['t_open'] = 1; }
		if (isset($_GET['t_closed'])) { $t_status_ids      .= "2, "; $data['t_closed'] = 1; }
		
		$s_status_ids                                      = "";
		if (isset($_GET['s_open'])) { $s_status_ids        .= "1, "; $data['s_open'] = 1; }
		if (isset($_GET['s_closed'])) { $s_status_ids      .= "2, "; $data['s_closed'] = 1; }
		
		$l_status_ids                                      = "";
		if (isset($_GET['l_new'])) { $l_status_ids         .= "1, "; $data['l_new'] = 1; }
		if (isset($_GET['l_attempted'])) { $l_status_ids   .= "2, "; $data['l_attempted'] = 1; }
		if (isset($_GET['l_tendering'])) { $l_status_ids   .= "3, "; $data['l_tendering'] = 1; }
		if (isset($_GET['l_submitted'])) { $l_status_ids   .= "4, "; $data['l_submitted'] = 1; }
		if (isset($_GET['l_onhold'])) { $l_status_ids      .= "8, "; $data['l_onhold'] = 1; }
		if (isset($_GET['l_approved'])) { $l_status_ids    .= "5, "; $data['l_approved'] = 1; }
		if (isset($_GET['l_delivered'])) { $l_status_ids   .= "6, "; $data['l_delivered'] = 1; }
		if (isset($_GET['l_settled'])) { $l_status_ids     .= "7, "; $data['l_settled'] = 1; }
		if (isset($_GET['l_deleted'])) { $l_status_ids     .= "100, "; $data['l_deleted'] = 1; }
		
		$fa_status_ids                                     = "";
		if (isset($_GET['fa_new'])) { $fa_status_ids       .= "1, "; $data['fa_new'] = 1; }
		if (isset($_GET['fa_attempted'])) { $fa_status_ids .= "2, "; $data['fa_attempted'] = 1; }
		if (isset($_GET['fa_deleted'])) { $fa_status_ids   .= "100, "; $data['fa_deleted'] = 1; }

		$data['fapplications'] = [];
		$data['fapplications'] = $this->fapplication_model->get_fapplications_fullcalendar($fa_status_ids, $data['user_id'], $data['admin_type']);

		$data['email_templates'] = $this->fapplication_model->get_email_templates($data['user_id']);
		$data['system_email_templates'] = $this->fapplication_model->get_system_email_templates($data['user_id']);
		$data['unscheduled_leads'] = $this->lead_model->get_unscheduled_leads($data['user_id']);

		$now = date('Y-m-d');

		foreach ($data['fapplications'] as $key => $val) 
		{
			$temp_date = date('Y-m-d',strtotime($val['assignment_date']));

			if (strtotime($temp_date) < strtotime($now))
			{
				$date1 = date_create($now);
				$date2 = date_create($temp_date);

				$date_diff = date_diff($date2,$date1);

				$diff = $date_diff->format("%R%a days");

				$data['fapplications'][$key]['assignment_date'] = date('Y-m-d H:i:s',strtotime($val['assignment_date'] . $diff));
				$data['fapplications'][$key]['assignment_date_end'] = date('Y-m-d H:i:s',strtotime($val['assignment_date_end'] . $diff));
			}
		}

		$data['admin_flag'] = $this->fapplication_model->get_fq_admin_flag($data['user_id']);
		
		$emailtemplate_query = "SELECT * FROM email_template ORDER BY id_email_template ASC";
		$emailtemplate_sql = $this->db->query($emailtemplate_query);
		$data['email_template'] =  $emailtemplate_sql->result();
		
		$this->load->view('admin/full_calendar_view', $data);
	}

	public function update_record_date ($id)
	{
		$post_data = $this->input->post();
		$this->fapplication_model->update_record_date_fullcalendar($id, $post_data, 'assignment_date');
	}

	public function get_calendar_items ()
	{
		$now = date('Y-m-d');
		$data = $this->data;
		
		$return_array = [];

		$post_data = $this->input->post();
		
		$user_id = $post_data['user_id'];
		$query_flag = $post_data['query_flag'];
		$display_flag = $post_data['display_flag'];
		
		/*
		$user_id = 259;
		$query_flag = "attempted";
		$display_flag = 1;		
		*/

		/*
		if ($data['user_id'] != 259)
		{
			$result = $this->lead_model->get_calendar_items($post_data['user_id'], $query_flag);
		}
		else
		{
			$result = [];
		}
		*/
		
		$results = $this->lead_model->get_calendar_items($user_id, $query_flag);

		if ($query_flag == "event")
		{
			if ($display_flag == "1")
			{
				foreach ($results as $result) 
				{
					$temp_array = [];

					$assignment_start_date = date("Y-m-d", strtotime($result['assignment_date']));
					$assignment_start_time = date("H:i:s", strtotime($result['assignment_date']));

					if ($assignment_start_time <> "00:00:00")
					{
						$assignment_end_date = $assignment_start_date;
						$assignment_end_time = date("H:i:s", strtotime($assignment_start_time) + 60 * 30);

						$start = $assignment_start_date." ".$assignment_start_time;
						$end = $assignment_end_date." ".$assignment_end_time;

						$temp_array = [
							"id" => $result['id_lead'],		
							"title" => "(".$result['cq_number'].") ".$result['event_details'],
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "event",
							"backgroundColor" => "#f8ffbf",
							"allDay" => false,
							"start" => $start,
							"end" => $end
						];
					}
					else
					{
						$start = $assignment_start_date." ".$assignment_start_time;
						
						$temp_array = [
							"id" => $result['id_lead'],						
							"title" => "(".$result['cq_number'].") ".$result['event_details'],
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "event",
							"backgroundColor" => "#f8ffbf",
							"allDay" => true,
							"start" => $start
						];
					}

					$return_array[] = $temp_array;
				}
			}
		}
		else if ($query_flag == "order") // #d2ffbf
		{
			if ($display_flag == "1")
			{
				foreach ($results as $result) 
				{
					$temp_array = [];
					
					$status = "";
					if ($result['status'] == "4") { $status = "Pending"; }
					else if ($result['status'] == "5") { $status = "Approved"; }
					else if ($result['status'] == "6") { $status = "Delivered"; }
					else if ($result['status'] == "7") { $status = "Settled"; }
					else if ($result['status'] == "8") { $status = "On Hold"; }
					else if ($result['status'] == "9") { $status = "Cancelled"; }

					$at = ""; if ($result['at'] > 0) { $at = " (AT)"; }
					$st = ""; if ($result['st'] > 0) { $st = " (ST)"; }
					
					$car = $result['tender_make']." ".$result['tender_model'];
					
					$start = $result['delivery_date'];

					$temp_array = [
						"id"     => $result['id_lead'],
						"title"  => $result['cq_number'] . $at . $st . " (".$status.") " . $result['name'] . "  (".$car.") ",
						"url"    => site_url("lead/record_final/".$result['id_lead']),
						"className" => "order",
						"backgroundColor" => "#d2ffbf",
						"allDay" => true,
						"start"  => $start
					];

					$return_array[] = $temp_array;
				}
			}
		}
		else if ($query_flag == "tradein") // #ffd1d1
		{
			if ($display_flag == "1")
			{
				foreach ($results as $result) 
				{
					$temp_array = [];
					
					$car = $result['tradein_make']." ".$result['tradein_model'];
					$name = $result['first_name']." ".$result['last_name'];
					
					$start = $result['delivery_date'];
					
					$temp_array = [
						"id" => $result['tradein_id'],
						"title" => $result['ti_number']."  ".$name."  (".$car.") ",
						"url" => site_url("tradein/record_final/".$result['tradein_id']),
						"className" => "tradein",
						"backgroundColor" => "#ffd1d1",
						"allDay" => true,
						"start" => $start
					];

					$return_array[] = $temp_array;
				}
			}
		}
		else if ($query_flag == "ticket")
		{
			if ($display_flag == "1")
			{
				/*
				$t_status_ids = "";

				if (isset($_GET['t_open'])) { $t_status_ids .= "1, "; $data['t_open'] = 1; }
				if (isset($_GET['t_closed'])) { $t_status_ids .= "2, "; $data['t_closed'] = 1; }

				$tickets = $this->ticket_model->get_tickets_mycalendar($t_status_ids, $data['user_id'], $data['admin_type']);

				foreach ($results as $result) 
				{
					$temp_array = [
						"url"    => "ticket",
						"id"     => $t_val->id_ticket,
						"title"  => addslashes($t_val->name . " (From: " . $t_val->assigned_by . ")"),
						"start"  => $t_val->assignment_date,
						"allDay" => true
					];

					$temp_array['backgroundColor'] = "#e6e6e6";

					$return_array[] = $temp_array;
				}
				*/
			}
		}
		else if ($query_flag == "tender") // #e9d1ff
		{
			if ($display_flag == "1")
			{		
				foreach ($results as $result) 
				{
					$temp_array = [];

					$at = ""; if ($result['at'] > 0) { $at = " (AT)"; }
					$st = ""; if ($result['st'] > 0) { $st = " (ST)"; }
						
					$car = $result['tender_make']." ".$result['tender_model'];
					
					$assignment_start_date = date("Y-m-d", strtotime($result['assignment_date']));
					$assignment_start_time = date("H:i:s", strtotime($result['assignment_date']));
					
					/*
					if (strtotime($assignment_start_date) < strtotime($now))
					{
						$assignment_start_date = $now;
					}
					*/

					if ($assignment_start_time <> "00:00:00")
					{
						$assignment_end_date = $assignment_start_date;
						$assignment_end_time = date("H:i:s", strtotime($assignment_start_time) + 60 * 30);

						$start = $assignment_start_date." ".$assignment_start_time;
						$end = $assignment_end_date." ".$assignment_end_time;

						$temp_array = [
							"id" => $result['id_lead'],
							"title" => $result['cq_number'].$at.$st." ".$result['name']." (".$result['quote_count'] .") ".$car,
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "tender",
							"backgroundColor" => "#e9d1ff",							
							"allDay" => false,
							"start" => $start,
							"end" => $end
						];
					}
					else
					{
						$start = $assignment_start_date." ".$assignment_start_time;
						
						$temp_array = [
							"id" => $result['id_lead'],
							"title" => $result['cq_number'].$at.$st." ".$result['name']." (".$result['quote_count'] .") ".$car,
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "tender",
							"backgroundColor" => "#e9d1ff",
							"allDay" => true,
							"start" => $start
						];						
					}

					$return_array[] = $temp_array;
				}
			}
		}
		else if ($query_flag == "unattempted") // #ffffff
		{
			if ($display_flag == "1")
			{		
				foreach ($results as $result) 
				{
					$temp_array = [];
					$start = "";

					$at = ""; if ($result['at'] > 0) { $at = " (AT)"; }
					$st = ""; if ($result['st'] > 0) { $st = " (ST)"; }

					$car = $result['make']." ".$result['model'];	
					
					$assignment_start_date = date("Y-m-d", strtotime($result['assignment_date']));
					$assignment_start_time = date("H:i:s", strtotime($result['assignment_date']));
					
					/*
					if (strtotime($assignment_start_date) < strtotime($now))
					{
						$assignment_start_date = $now;
					}
					*/

					if ($assignment_start_time <> "00:00:00")
					{
						$assignment_end_date = $assignment_start_date;
						$assignment_end_time = date("H:i:s", strtotime($assignment_start_time) + 60 * 30);

						$start = $assignment_start_date." ".$assignment_start_time;
						$end = $assignment_end_date." ".$assignment_end_time;

						$temp_array = [
							"id" => $result['id_lead'],
							"title" => $result['cq_number']." ".$at.$st." ".$result['name']."  (".$car.")",
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "unattempted_lead",
							"backgroundColor" => "#ffffff",							
							"allDay" => false,
							"start" => $start,
							"end" => $end
						];
					}
					else
					{
						$start = $assignment_start_date." ".$assignment_start_time;
						
						$temp_array = [
							"id" => $result['id_lead'],
							"title" => $result['cq_number']." ".$at.$st." ".$result['name']."  (".$car.")",
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "unattempted_lead",
							"backgroundColor" => "#ffffff",
							"allDay" => true,
							"start" => $start
						];
					}
					
					$return_array[] = $temp_array;
				}
			}
		}
		else if ($query_flag == "attempted") // #f0ffff
		{
			if ($display_flag == "1")
			{
				foreach ($results as $result) 
				{
					$temp_array = [];
					$final_date = "";

					$at = ""; if ($result['at'] > 0) { $at = " (AT)"; }
					$st = ""; if ($result['st'] > 0) { $st = " (ST)"; }

					$car = $result['make']." ".$result['model'];

					$assignment_start_date = date("Y-m-d", strtotime($result['assignment_date']));
					$assignment_start_time = date("H:i:s", strtotime($result['assignment_date']));
					
					/*
					if (strtotime($assignment_start_date) < strtotime($now))
					{
						$assignment_start_date = $now;
					}
					*/

					if ($assignment_start_time <> "00:00:00")
					{
						$assignment_end_date = $assignment_start_date;
						$assignment_end_time = date("H:i:s", strtotime($assignment_start_time) + 60 * 30);

						$start = $assignment_start_date." ".$assignment_start_time;
						$end = $assignment_end_date." ".$assignment_end_time;

						$temp_array = [
							"id" => $result['id_lead'],
							"title" => $result['cq_number']." ".$at.$st." ".$result['name']."  (".$car.")",
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "attempted_lead",
							"backgroundColor" => "#f0ffff",							
							"allDay" => false,
							"start" => $start,
							"end" => $end
						];
					}
					else
					{
						$start = $assignment_start_date." ".$assignment_start_time;
						
						$temp_array = [
							"id" => $result['id_lead'],
							"title" => $result['cq_number']." ".$at.$st." ".$result['name']."  (".$car.")",
							"url" => site_url("lead/record_final/".$result['id_lead']),
							"className" => "attempted_lead",
							"backgroundColor" => "#f0ffff",
							"allDay" => true,
							"start" => $start
						];
					}		
					
					$return_array[] = $temp_array;
				}
			}
		}

		echo json_encode($return_array);
	}

	public function calendar_test ()
	{
		$data = $this->data;
		$this->load->view('admin/calendar_test', $data);
	}
}

