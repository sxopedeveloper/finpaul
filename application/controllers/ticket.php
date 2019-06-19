<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Ticket extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('ticket/list_view'));
		exit();
	}
	
	public function new_record () // PAGE VIEW
	{
		$data = $this->data;
		$data['title'] = 'Tickets - Create New';

		$data['ticket_types'] = $this->ticket_model->get_ticket_types();
		$data['modules'] = $this->ticket_model->get_modules();
		$data['admins'] = $this->user_model->get_admins();
		$this->load->view('admin/ticket_form', $data);
	}
	
	public function add_record () // PAGE ACTION (with Notification - DONE)
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		if (!$this->input->post())
		{
			header ("Location: ".site_url('ticket/new_record'));
			exit ();
		}

		if (isset($_POST['cq_reference']))
		{
			$input_arr['name'] = "(For: ".$_POST['cq_reference'].") ".$input_arr['name'];
			$input_arr['description'] = 'Ticket for QM Number: <span class="open-lead-details" data-lead_id="'.$_POST['id_lead'].'" style="cursor: pointer; cursor: hand; color: #58c603;">'.$_POST['cq_reference'].'</span><br /><br />'.$input_arr['description'];
		}
		
		$input_arr['user_id_from'] = $data['user_id'];
		$ticket_id = $this->ticket_model->add_ticket($input_arr);

		$ticket_details = $this->ticket_model->get_ticket($ticket_id);
		$notification_message = 'New Ticket received from <b>'.$data['name'].'</b>: <b><a href="#" class="open-ticket" data-ticket_id="'.$ticket_id.'">'.$ticket_details['ticket_number'].'</a></b>';
		$this->notification_model->add_notification(1, $notification_message);
		$notification_id = $this->db->insert_id();

		foreach ($input_arr['user_id_to'] as $user_key => $user_val) 
		{
			$this->notification_model->add_notification_user($notification_id, $user_val);
		}

		header ("Location: ".site_url('ticket/list_view'));
		exit ();
	}

	public function list_view () // PAGE VIEW (LV)
	{
		$data = $this->data;
		$data['title'] = 'Tickets - List View';

		$data['tickets']       = $this->ticket_model->get_tickets($_GET, $data['user_id'], $data['admin_type']); // Main Query
		$data['ticket_status'] = $this->ticket_model->get_ticket_status();
		$data['ticket_types']  = $this->ticket_model->get_ticket_types();
		$data['modules']       = $this->ticket_model->get_modules();
		$data['admins']        = $this->user_model->get_admins();

		$this->load->view('admin/tickets', $data);
	}

	public function update_ticket()
	{
		$data = $this->data;

		$post_data = $this->input->post();

		$this->ticket_model->update_ticket($post_data);
	}

	public function calendar_view ($user = 0) // PAGE VIEW (CV)
	{
		$data = $this->data;
		$data['title'] = 'Tickets - Calendar View';
		$params['user_id'] = $user;

		$data['tickets'] = $this->ticket_model->get_tickets_calendar($params, $data['user_id'], $data['admin_type']);
		$data['admins'] = $this->user_model->get_admins();
		$this->load->view('admin/tickets_calendar', $data);
	}
	
    public function record ($ticket_id) // MODAL VIEW
    {
		$data = $this->data;
	
		$query = "
		SELECT 
		t.id_ticket, CONCAT('TN', LPAD(t.id_ticket, 5, '0')) AS `ticket_number`,
		t.name, t.description, t.image_url, t.eta,
		t.fk_user_from, t.fk_user_to,
		CASE (t.priority)
			WHEN 1 THEN 'Urgent'
			WHEN 2 THEN 'High'
			WHEN 3 THEN 'Low'
		END `priority`,
		u1.name as `assigned_by`, u1.email as `ab_email`,
		ts.id_ticket_status as `id_ticket_status`, ts.name as `ticket_status`,
		tt.name as `ticket_type`, m.name as `module`, t.created_at, 
		IF (t.toc = '0' OR t.toc = '', 'NOT SET', t.toc) AS toc,
		IF (DATE(t.assignment_date) = '0000-00-00', 'NOT SET', DATE(t.assignment_date)) AS assignment_date		
		FROM tickets t
		JOIN ticket_types tt ON t.fk_ticket_type = tt.id_ticket_type
		JOIN modules m ON t.fk_module = m.id_module
		JOIN ticket_status ts ON t.fk_ticket_status = ts.id_ticket_status
		JOIN users u1 ON t.fk_user_from = u1.id_user
		WHERE id_ticket = ".$ticket_id;
		$result = $this->db->query($query);
		foreach ($result->result() as $row)
		{
			$comments = '';
			$comments_query = "
			SELECT c.id_comment, c.comment, c.created_at, u.id_user, u.name AS `sender`
			FROM comments c
			JOIN users u ON c.fk_user = u.id_user
			WHERE c.fk_main = '".$ticket_id."' AND c.type = 0
			ORDER BY c.id_comment DESC";
			$comments_result = $this->db->query($comments_query);
			foreach ($comments_result->result() as $comment_row)
			{
				if ($comment_row->id_user==$data['user_id']) { $comment_bg = "#DDDBFF"; }
				else { $comment_bg = "#DCFDE0"; }			
				$comments .= '
				<div style="background: '.$comment_bg.'; padding: 10px 15px 10px 15px; border-radius: 8px;">
					<p>'.nl2br($comment_row->comment).'</p>';
					
					$comment_attachments_query = "
					SELECT file_name
					FROM comment_attachments
					WHERE fk_comment = '".$comment_row->id_comment."'
					ORDER BY id_comment_attachment ASC";
					$comment_attachments_result = $this->db->query($comment_attachments_query);
					if (count($comment_attachments_result->result()) <> 0)
					{
						$comments .= '<p><b>Attached Files:</b><br />';
						foreach ($comment_attachments_result->result() as $comment_attachment_row)
						{			
							$comments .= '<a target="_blank" href="'.base_url('uploads/ti_files/'.$comment_attachment_row->file_name).'">'.$comment_attachment_row->file_name.'</a><br />';
						}					
						$comments .= '</p>';
					}

					$comments .= '
					<div class="tm-meta text-right">
						<span>
							<i class="fa fa-user"></i> <span style="color: #0088cc">'.$comment_row->sender.'</span>
						</span>
						&nbsp;&nbsp;
						<span>
							<i class="fa fa-calendar"></i> <span style="color: #0088cc">'.$comment_row->created_at.'<span>
						</span>
					</div>
				</div><br />';				
			}
			
			$ticket_actions = '
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="add_t_comment_modal()">Add Comment</button>
			';			
			
			if ($row->id_ticket_status <= 1)
			{
				$ticket_actions .= '
				<button type="button" class="btn btn-primary" onclick="close_ticket()">Mark as Closed</button>
				';
			}

			if ($row->fk_user_from == $data['user_id'] AND $row->id_ticket_status > 1)
			{
				$ticket_actions .= '
				<button type="button" class="btn btn-primary" onclick="reopen_ticket()">Reopen</button>
				';			
			}
			$name_string    = "";
			$assigned_table = "";

			$assigned_tos = $this->ticket_model->get_users_to($ticket_id);

			foreach ($assigned_tos as $ass_key => $ass_val) 
			{
				$name_string .= $ass_val['name'] . ", ";
			}

			$name_string = rtrim($name_string, ', ');

			$assigned_table .= "
							<tr>
								<td>{$row->assigned_by}</td>
								<td>{$name_string}</td>
							</tr>
							";

			$ticket_arr = array(
				"id_ticket"        => $row->id_ticket,
				"id_ticket_status" => $row->id_ticket_status,
				"ticket_status"    => $row->ticket_status,
				"ticket_priority"  => $row->priority,
				"ticket_type"      => $row->ticket_type,
				"ticket_module"    => $row->module,			
				"ticket_number"    => $row->ticket_number,
				"toc"              => $row->toc,
				"assignment_date"  => $row->assignment_date,
				"name"             => $row->name,				
				"description"      => nl2br($row->description),
				"ticket_comments"  => $comments,
				"ticket_actions"   => $ticket_actions,
				"assigned_table"   => $assigned_table
			);
		}
		echo json_encode($ticket_arr);	
	}
	
	public function close () // MODAL ACTION (with Notification)
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->ticket_model->update_ticket_status($input_arr['ticket_id'], 2);

		$ticket_details = $this->ticket_model->get_ticket($input_arr['ticket_id']);

		$ticket_to_arr = explode(",", $ticket_details['id_to']);

		if($ticket_details['user_id_from'] != $data['user_id'])
			$ticket_to_arr[] = $ticket_details['user_id_from'];

		foreach ($ticket_to_arr as $key => $val) 
		{
			if($val == $data['user_id'])
				unset($ticket_to_arr[$key]);
		}

		$notification_message = '<b>'.$data['name'].'</b> marked ticket <b><a href="#" class="open-ticket" data-ticket_id="'.$input_arr['ticket_id'].'">'.$ticket_details['ticket_number'].'</a></b> as <b>CLOSED</b>';
		$this->notification_model->add_notification(1, $notification_message);
		$notification_id = $this->db->insert_id();

		foreach ($ticket_to_arr as $user_key => $user_val)
		{
			$this->notification_model->add_notification_user($notification_id, $user_val);
		}
	}
	
	public function reopen () // MODAL ACTION (with Notification)
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->ticket_model->update_ticket_status($input_arr['ticket_id'], 1);

		$ticket_details = $this->ticket_model->get_ticket($input_arr['ticket_id']);

		$ticket_to_arr = explode(",", $ticket_details['id_to']);

		if($ticket_details['user_id_from'] != $data['user_id'])
		{
			$ticket_to_arr[] = $ticket_details['user_id_from'];
		}

		foreach ($ticket_to_arr as $key => $val) 
		{
			if($val == $data['user_id'])
			{
				unset($ticket_to_arr[$key]);
			}
		}

		$ticket_details = $this->ticket_model->get_ticket($input_arr['ticket_id']);
		$notification_message = '<b>'.$data['name'].'</b> marked ticket <b><a href="#" class="open-ticket" data-ticket_id="'.$input_arr['ticket_id'].'">'.$ticket_details['ticket_number'].'</a></b> as <b>REOPENED</b>';		
		$this->notification_model->add_notification(1, $notification_message);
		$notification_id = $this->db->insert_id();
				
		foreach ($ticket_to_arr as $user_key => $user_val)
		{
			$this->notification_model->add_notification_user($notification_id, $user_val);
		}
	}
	
	public function update_toc () // ??  (with Notification)
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		if (!$this->input->post())
		{
			header ("Location: ".site_url('ticket/list_view'));
			exit ();
		}
		$this->ticket_model->update_ticket_toc($input_arr);	
		
		$ticket_details = $this->ticket_model->get_ticket($input_arr['ticket_id']);
		if ($ticket_details['user_id_from']<>$ticket_details['user_id_to'])
		{
			if ($data['user_id']==$ticket_details['user_id_from'])
			{
				$to = $ticket_details['user_id_to'];
			}
			else
			{
				$to = $ticket_details['user_id_from'];
			}
			$notification_message = '<b>'.$data['name'].'</b> changed ETA of ticket <b><a href="#" class="open-ticket" data-ticket_id="'.$input_arr['ticket_id'].'">'.$ticket_details['ticket_number'].'</a></b> to <b>'.$input_arr['toc'].' days</b>';
			$this->notification_model->add_notification(1, $notification_message);
			$notification_id = $this->db->insert_id();
			$this->notification_model->add_notification_user($notification_id, $to);		
		}
	}
	
	public function add_comment_old ($ticket_id) // MODAL ACTION  (with Notification - DONE)
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$input_arr['user_id'] = $data['user_id'];
		$this->ticket_model->add_ticket_comment($input_arr);

		$ticket_details = $this->ticket_model->get_ticket($input_arr['ticket_id']);
		if ($ticket_details['user_id_from']<>$ticket_details['user_id_to'])
		{
			if ($data['user_id']==$ticket_details['user_id_from'])
			{
				$to = $ticket_details['user_id_to'];
			}
			else
			{
				$to = $ticket_details['user_id_from'];
			}
			$notification_message = '<b>'.$data['name'].'</b> submitted a comment on ticket <b><a href="#" class="open-ticket" data-ticket_id="'.$input_arr['ticket_id'].'">'.$ticket_details['ticket_number'].'</a></b>';
			$this->notification_model->add_notification(1, $notification_message);
			$notification_id = $this->db->insert_id();
			$this->notification_model->add_notification_user($notification_id, $to);		
		}
	}
	
	public function update_assignment_date ($ticket_id) // MODAL ACTION (CV) (with Notification - DONE)
	{
		$data = $this->data;
		$new_date = $this->input->post('new_date');
		$this->ticket_model->update_ticket_assignment_date($ticket_id, $new_date);

		$ticket_details = $this->ticket_model->get_ticket($ticket_id);
		if ($ticket_details['user_id_from']<>$ticket_details['user_id_to'])
		{
			if ($data['user_id']==$ticket_details['user_id_from'])
			{
				$to = $ticket_details['user_id_to'];
			}
			else
			{
				$to = $ticket_details['user_id_from'];
			}
			$notification_message = '<b>'.$data['name'].'</b> rescheduled ticket <b><a href="#" class="open-ticket" data-ticket_id="'.$ticket_id.'">'.$ticket_details['ticket_number'].'</a></b> to <b>'.$new_date.'</b>';
			$this->notification_model->add_notification(1, $notification_message);
			$notification_id = $this->db->insert_id();
			$this->notification_model->add_notification_user($notification_id, $to);		
		}
	}	

	public function upload_file() // BACKGROUND ACTION
	{
		$data = $this->data;
		$directory = './uploads/ti_files/';
		$prefix = time().'_'.$data['user_id'].'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		if(move_uploaded_file($file_tmp, $file))
		{
			echo $file;
		}
	}

	public function add_comment ($id) // MODAL ACTION
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$input_arr['user_id'] = $data['user_id'];
		$this->comment_model->insert_comment($id, 0, $input_arr);
		$comment_id = $this->db->insert_id();
		if (isset($_POST['t_uploaded_comment_file']))
		{
			foreach ($_POST['t_uploaded_comment_file'] AS $uploaded_file)
			{
				$file_name = str_replace('./uploads/ti_files/', '', $uploaded_file);
				$this->comment_model->insert_comment_attachment($comment_id, $file_name);
			}
		}

		$ticket_details = $this->ticket_model->get_ticket($id);

		$ticket_to_arr = explode(",", $ticket_details['id_to']);

		if($ticket_details['user_id_from'] != $data['user_id'])
		{
			$ticket_to_arr[] = $ticket_details['user_id_from'];
		}

		foreach ($ticket_to_arr as $key => $val) 
		{
			if($val == $data['user_id'])
			{
				unset($ticket_to_arr[$key]);
			}
		}

		$notification_message = '<b>'.$data['name'].'</b> submitted a comment on ticket <b><a href="#" class="open-ticket" data-ticket_id="'.$id.'">'.$ticket_details['ticket_number'].'</a></b>';
		$this->notification_model->add_notification(1, $notification_message);
		$notification_id = $this->db->insert_id();
		
		foreach ($ticket_to_arr as $user_key => $user_val)
		{
			$this->notification_model->add_notification_user($notification_id, $user_val);
		}	
	}

	public function get_ticket()
	{
		$ticket_id = $this->input->post('ticket_id');

		$result = $this->ticket_model->get_ticket($ticket_id);

		$id_to_arr = explode(",", $result['id_to']);

		$result['id_to'] = $id_to_arr;

		echo json_encode($result);
	}
}
?>