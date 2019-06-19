<?php 
include_once("./application/libraries/PDFMerger/PDFMerger.php");

class Fapplication_Model extends CI_Model {

	function get_records ($params, $my_id, $admin_type, $start, $limit) // DONE
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$state = isset($params['state']) ? $params['state'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND fa.status = '".$this->db->escape_str($status)."' "; }
		if ($name <> "") { $where .= " AND fa.lead_name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.lead_email = '".$this->db->escape_str($email)."' "; }
		if ($phone <> "") { $where .= " AND fa.lead_phone = '".$this->db->escape_str($phone)."' "; }
		if ($mobile <> "") { $where .= " AND fa.lead_mobile = '".$this->db->escape_str($mobile)."' "; }
		if ($state <> "") { $where .= " AND fa.lead_state = '".$this->db->escape_str($state)."' "; }

		$user_id = $this->session->userdata('user_id');

		if ($admin_type == 3 || $user_id == 259)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "") { $where .= " AND fa.fk_user = '".$this->db->escape_str($user_id)."' "; }
		}
		else
		{
			$where .= " AND fa.fk_user = ".$my_id; 
		}

		$query = "
		SELECT 
		fa.id_fq_account, fa.fk_user, fa.source,
		CONCAT('FQ', LPAD(fa.id_fq_account, 5, '0')) as `fq_number`,
		fa.status,
		CASE (fa.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'App Started'
			WHEN 4 THEN 'Submitted'
			WHEN 5 THEN 'Approved'
			WHEN 6 THEN 'Settlement'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		
		l.status as `cq_status`,
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 100 THEN 'Not Proceeding'
		END `cq_status_text`,
		
		ul.name as `cq_staff`,
		uf.name as `fq_staff`,
		fa.lead_name as `name`, fa.lead_email as `email`, fa.lead_phone as `phone`, fa.lead_mobile as `mobile`, 
		fa.lead_state as `state`, '' as `postcode`, fa.further_details as `details`,
		fa.assignment_date, fa.created_at, fa.last_updated, l.id_lead as `id_lead` 
		FROM `fq_accounts_new` fa
		LEFT JOIN users uf ON fa.fk_user = uf.id_user
		LEFT JOIN leads l ON fa.fk_lead = l.id_lead
		LEFT JOIN users ul ON l.fk_user = ul.id_user
		WHERE fa.deprecated <> 1 
		".$where."
		ORDER BY fa.id_fq_account DESC LIMIT ".$start.", ".$limit;

		// echo $query; die();
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_records_count ($params, $my_id, $admin_type) // DONE
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$state = isset($params['state']) ? $params['state'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND fa.status = '".$this->db->escape_str($status)."' "; }
		if ($name <> "") { $where .= " AND fa.lead_name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.lead_email = '".$this->db->escape_str($email)."' "; }
		if ($phone <> "") { $where .= " AND fa.lead_phone = '".$this->db->escape_str($phone)."' "; }
		if ($mobile <> "") { $where .= " AND fa.lead_mobile = '".$this->db->escape_str($mobile)."' "; }
		if ($state <> "") { $where .= " AND fa.lead_state = '".$this->db->escape_str($state)."' "; }

		$user_id = $this->session->userdata('user_id');

		if ($admin_type == 3 || $user_id == 259)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "") { $where .= " AND fa.fk_user = '".$this->db->escape_str($user_id)."' "; }
		}
		else
		{
			$where .= " AND fa.fk_user = ".$my_id; 
		}
	
		$query = "SELECT COUNT(1) AS cnt FROM fq_accounts_new fa WHERE fa.deprecated <> 1 ".$where;
		return $this->db->query($query)->row_array();
	}

	function admin_get_records ($params, $my_id, $admin_type, $start, $limit) // DONE
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$state = isset($params['state']) ? $params['state'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND fa.status = '".$this->db->escape_str($status)."' "; }
		if ($name <> "") { $where .= " AND fa.lead_name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.lead_email = '".$this->db->escape_str($email)."' "; }
		if ($phone <> "") { $where .= " AND fa.lead_phone = '".$this->db->escape_str($phone)."' "; }
		if ($mobile <> "") { $where .= " AND fa.lead_mobile = '".$this->db->escape_str($mobile)."' "; }
		if ($state <> "") { $where .= " AND fa.lead_state = '".$this->db->escape_str($state)."' "; }

		// $where .= " AND fa.fk_admin = ".$my_id;

		$where .= " AND fa.submitted_to_admin = 1";

		$query = "
		SELECT 
		fa.id_fq_account, fa.fk_user, fa.source,
		CONCAT('FQA', LPAD(fa.id_fq_account, 5, '0')) as `fq_number`,
		fa.status,
		CASE (fa.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'App Started'
			WHEN 4 THEN 'Submitted'
			WHEN 5 THEN 'Approved'
			WHEN 6 THEN 'Settlement'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		
		l.status as `cq_status`,
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 100 THEN 'Not Proceeding'
		END `cq_status_text`,
		
		ul.name as `cq_staff`,
		uf.name as `fq_staff`,
		fa.lead_name as `name`, fa.lead_email as `email`, fa.lead_phone as `phone`, fa.lead_mobile as `mobile`, 
		fa.lead_state as `state`, '' as `postcode`, fa.further_details as `details`,
		fa.assignment_date, fa.created_at, fa.last_updated, l.id_lead as `id_lead` 
		FROM `fq_accounts_new` fa
		LEFT JOIN users uf ON fa.fk_user = uf.id_user
		LEFT JOIN leads l ON fa.fk_lead = l.id_lead
		LEFT JOIN users ul ON l.fk_user = ul.id_user
		WHERE fa.deprecated <> 1 
		".$where."
		ORDER BY fa.id_fq_account DESC LIMIT ".$start.", ".$limit;

		// echo $query; die();
		$sql = $this->db->query($query);
		return $sql->result();
	}

	function admin_get_records_count ($params, $my_id, $admin_type) // DONE
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$state = isset($params['state']) ? $params['state'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND fa.status = '".$this->db->escape_str($status)."' "; }
		if ($name <> "") { $where .= " AND fa.lead_name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.lead_email = '".$this->db->escape_str($email)."' "; }
		if ($phone <> "") { $where .= " AND fa.lead_phone = '".$this->db->escape_str($phone)."' "; }
		if ($mobile <> "") { $where .= " AND fa.lead_mobile = '".$this->db->escape_str($mobile)."' "; }
		if ($state <> "") { $where .= " AND fa.lead_state = '".$this->db->escape_str($state)."' "; }

		// $where .= " AND fa.fk_admin = ".$my_id;

		$where .= " AND fa.submitted_to_admin = 1";
	
		$query = "SELECT COUNT(1) AS cnt FROM fq_accounts_new fa WHERE fa.deprecated <> 1 ".$where;
		return $this->db->query($query)->row_array();
	}

	function get_fapplications_mycalendar ($status_ids, $my_id, $admin_type)
	{
		$now = date("Y-m-d H:i:s");

		$user_id = $this->session->userdata('user_id');

		$where = "";
		if ($admin_type == 3 || $user_id == 259)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "" AND $user_id <> 0) 
			{
				$where .= " AND fa.fk_user = '".$this->db->escape_str($user_id)."' ";
			}
			else
			{
				$where .= " AND fa.fk_user = ".$my_id;
			}
		}
		else
		{
			$where .= " AND fa.fk_user = ".$my_id;
		}
		$where .= " AND fa.status IN (".$status_ids." 9999)";
		
		$query = "
		SELECT fa.id_fq_account, fa.fk_user, fa.source,
		CONCAT('FQA', LPAD(fa.id_fq_account, 5, '0')) AS `fqa_number`,
		fa.status,
		CASE (fa.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		ul.name as `cq_staff`,
		uf.name as `fq_staff`,

		fa.lead_name, fa.lead_email, fa.lead_phone, fa.lead_mobile, fa.lead_state, fa.lead_make, fa.lead_model,

		IF (DATE(fa.assignment_date) = '0000-00-00' OR DATE(fa.assignment_date) = '', 
			IF (DATE(fa.allocated_date) = '0000-00-00' OR DATE(fa.allocated_date) = '',
				DATE('".$now."'), DATE(fa.allocated_date)
			), 
			DATE(fa.assignment_date)
		)
		AS assignment_date,
		fa.created_at, fa.last_updated
		FROM fq_accounts_new fa
		LEFT JOIN users uf ON fa.fk_user = uf.id_user
		LEFT JOIN leads l ON fa.fk_lead = l.id_lead
		LEFT JOIN users ul ON l.fk_user = ul.id_user
		WHERE fa.deprecated <> 1 ".$where."
		ORDER BY fa.id_fq_account ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	function get_fapplications_fullcalendar ($status_ids, $my_id, $admin_type)
	{
		$now = date("Y-m-d") . " 00:00:00";

		$user_id = $this->session->userdata('user_id');

		$where = "";
		if ($admin_type == 3 || $user_id == 259)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "" AND $user_id <> 0) 
			{
				$where .= " AND fa.fk_user = '".$this->db->escape_str($user_id)."' ";
			}
			else
			{
				$where .= " AND fa.fk_user = ".$my_id;
			}
		}
		else
		{
			$where .= " AND fa.fk_user = ".$my_id;
		}
		$where .= " AND fa.status NOT IN (100, 9999)";
		
		$query = "
		SELECT fa.id_fq_account, fa.fk_user, fa.source,
		CONCAT('FQA', LPAD(fa.id_fq_account, 5, '0')) AS `fqa_number`,
		fa.status,
		CASE (fa.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Attempted'
			WHEN 2 THEN 'App Started'
			WHEN 3 THEN 'Submitted'
			WHEN 4 THEN 'Approved'
			WHEN 5 THEN 'Settlement'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		ul.name as `cq_staff`,
		uf.name as `fq_staff`,

		fa.lead_name, fa.lead_email, fa.lead_phone, fa.lead_mobile, fa.lead_state, fa.lead_make, fa.lead_model, fa.color_status,

		IF (fa.assignment_date = '0000-00-00 00:00:00' OR fa.assignment_date = '', 
			IF (fa.allocated_date = '0000-00-00 00:00:00' OR fa.allocated_date = '',
				'".$now."', fa.allocated_date
			), 
			fa.assignment_date
		)
		AS assignment_date,
		fa.assignment_date_end as `assignment_date_end`,

		fa.created_at, fa.last_updated
		FROM fq_accounts_new fa
		LEFT JOIN users uf ON fa.fk_user = uf.id_user
		LEFT JOIN leads l ON fa.fk_lead = l.id_lead
		LEFT JOIN users ul ON l.fk_user = ul.id_user
		WHERE fa.deprecated <> 1 ".$where."
		ORDER BY fa.id_fq_account ASC";
		// echo $query; die();
		$sql = $this->db->query($query);

		// echo "<pre>";
		// print_r($sql->result_array()); die();

		return $sql->result_array();
	}

	function get_record_client ($id) // DONE
	{
		$query = "SELECT fk_user, lead_name, lead_email FROM `fq_accounts_new` WHERE id_fq_account = ".$id;
		return $this->db->query($query)->row_array();
	}
	
	function delete_record ($id) // DONE
	{
		$query = "UPDATE `fq_accounts_new` SET `deprecated` = 1 WHERE `id_fq_account` = ".$id;
		$sql = $this->db->query($query);
	}

	function allocate_record ($id, $user_id) // DONE
	{
		$query = "UPDATE `fq_accounts_new` SET `fk_user` = ".$user_id." WHERE `id_fq_account` = ".$id;
		$sql = $this->db->query($query);		
	}
	
	function update_record_status ($id, $status) // DONE
	{
		$query = "UPDATE `fq_accounts_new` SET `status` = ".$status." WHERE `id_fq_account` = ".$id;
		$sql = $this->db->query($query);
	}

	function allocate_records ($ids, $user_id) // DONE
	{
		$query = "UPDATE `fq_accounts_new` SET `fk_user` = ".$user_id." WHERE `id_fq_account` IN (".str_replace('on', '', str_replace(',on', '', $ids)).")";
		$sql = $this->db->query($query);
	}
	
	function delete_records ($ids) // DONE
	{
		// $query = "DELETE FROM `fq_accounts_new` WHERE `id_fq_account` IN (".str_replace('on', '', str_replace(',on', '', $ids)).")";
		// $sql = $this->db->query($query);

		if(count($ids) > 0)
		{
			foreach ($ids as $i_key => $i_val) 
			{
				$select_query = "select status from fq_accounts_new where id_fq_account = {$i_val}";

				$result = $this->db->query($select_query)->row_array();

				if($result['status'] != 100)
				{
					$this->db->where("id_fq_account", $i_val);

					$update_data = [
						'status' => 100
					];

					$this->db->update("fq_accounts_new", $update_data);
				}
			}
		}
	}
    
	function allocation_status_change($ids,$status,$allto)
	{
		if(count($ids) > 0)
		{
			foreach ($ids as $i_key => $i_val)
			{
				//$select_query = "select status from fq_accounts_new where id_fq_account = {$i_val}";
                $id_quote_request = $this->get_column_value_by_id('quote_requests','id_quote_request',array('fk_lead' => $i_val, 'deprecated' => '0'));
                $update_data = array();
                if(isset($id_quote_request) && !empty($id_quote_request)) {
                    $update_data['status']  = 3;
				} else {
                    $update_data['status']  = $status;    
                }   
                $this->db->where("id_fq_account", $i_val);
                if($allto!="") {
                    $update_data['fk_user'] = $allto;
                }
                $this->db->update("fq_accounts_new", $update_data);
			}
		}
	}
    
    function DuplicateMySQLRecord ($table, $primary_key_field, $primary_key_val) 
    {
        $this->db->where($primary_key_field, $primary_key_val); 
        $query = $this->db->get($table);
        echo '<pre>';$query->result_array();exit;
        foreach ($query->result() as $row){
           foreach($row as $key=>$val){
              if($key != $primary_key_field){ 
                $this->db->set($key, $val);               
              }
           }
        }
        return $this->db->insert($table); 
    }
    
    function duplicate_lead_dealer_data($primary_id, $new_lead_id) 
    {
        $query = $this->db->get_where('fq_lead_dealer_data', array('fq_lead_id' => $primary_id));
        if($query->num_rows() != 0){
            foreach ($query->result_array() as $row){
                unset($row['fq_lead_id']);
                unset($row['id']);
                $row['fq_lead_id'] = $new_lead_id;
                $this->db->insert('fq_lead_dealer_data', $row);
            }    
        }
    }
    
	function restore_record_status ($ids)
	{
		if(count($ids) > 0)
		{
			foreach ($ids as $i_key => $i_val) 
			{
				$select_query = "select status from fq_accounts_new where id_fq_account = {$i_val}";

				$result = $this->db->query($select_query)->row_array();

				if($result['status'] == 100)
				{
					$this->db->where("id_fq_account", $i_val);

					$update_data = [
						'status'  => 1,
					];

					$this->db->update("fq_accounts_new", $update_data);
				}
			}
		}
	}

	function update_records_status ($ids, $status) // DONE
	{
		$query = "UPDATE `fq_accounts_new` SET `status` = ".$status." WHERE `id_fq_account` IN (".str_replace('on', '', str_replace(',on', '', $ids)).") AND `status` < ".$status."";
		$sql = $this->db->query($query);
	}

	function get_application_date($ids, $user_id)
	{
		$query = "select id_fq_account, created_at from fq_accounts_new where id_fq_account in (".str_replace('on', '', str_replace(',on', '', $ids)).") order by created_at asc";

		return $this->db->query($query)->result_array();
	}

	function update_record_date ($id = 1, $date, $date_type) // DONE
	{
		$now = date('Y-m-d');

		if ($date_type=="assignment_date")
		{
			$date = $date . " 00:00:00";
			$where = "";
		}
		else 
		{
			$where = " AND (`".$date_type."` = '0000-00-00 00:00:00' OR `".$date_type."` = '' OR `".$date_type."` IS NULL)";
		}

		$query = "UPDATE `fq_accounts_new` SET `".$date_type."` = '".$now."', `assignment_date` = '{$date}' 
						WHERE `id_fq_account` = ".$id." ".$where;

		$sql = $this->db->query($query);
	}

	function update_record_date_fullcalendar ($id = 1, $post_data, $date_type) // DONE
	{
		$date_start = str_replace("T", " ", $post_data['time_start']);
		$date_end   = str_replace("T", " ", $post_data['time_end']);

		$this->db->where('id_fq_account', $id);

		$data = [
			'assignment_date'     => $date_start,
			'assignment_date_end' => $date_end
		];

		$this->db->update('fq_accounts_new', $data);
	}

	public function delete_cal_item($id,$isDelete='false')
	{
		$this->db->where('id_fq_account', $id);
	
		if($isDelete==='true')
		{			
			$re = $this->db->delete('fq_accounts_new');
		}
		else
		{
			$update_data = [
				'status' => 100
			];
			$re = $this->db->update('fq_accounts_new', $update_data);
		}
		return $re;
	}
    
	public function reallocate_cal_item($id)
	{
		$this->db->where('id_fq_account', $id);

		$update_data = [
			'status' => 1
		];

		$re = $this->db->update('fq_accounts_new', $update_data);
		return $re;
	}

	public function update_record_details ($input_arr) // DONE
	{
		// echo $input_arr['fapplication_id']; die();
		// echo "<pre>";
		// print_r($input_arr); die();

		$update_data = array(
						'car'                      => isset($input_arr['car']) ? $input_arr['car'] : "",
						'year'                     => isset($input_arr['year']) ? $input_arr['year'] : "",
						'make'                     => isset($input_arr['make']) ? $input_arr['make'] : "", 
						'model'                    => isset($input_arr['model']) ? $input_arr['model'] : "",
						'variant'                  => isset($input_arr['variant']) ? $input_arr['variant'] : "",
						'further_details'          => isset($input_arr['further_details']) ? $input_arr['further_details'] : "",
						'further_details_supplier' => isset($input_arr['further_details_supplies']) ? $input_arr['further_details_supplies'] : "",
						'further_details_deals'    => isset($input_arr['further_details_deals']) ? $input_arr['further_details_deals'] : "",
						'delivery_date'            => $input_arr['delivery_date'],
						'seller'                   => isset($input_arr['seller']) ? $input_arr['seller'] : "",
						'dealer'                   => isset($input_arr['dealer']) ? $input_arr['dealer'] : "",
						'supplier_contact'         => $input_arr['supplier_contact'],
						'supplier_email'           => $input_arr['supplier_email'],
						'supplier_mobile'          => $input_arr['supplier_mobile'],
						'supplier_landline'        => $input_arr['supplier_landline'],
						'delivery_date'            => $input_arr['delivery_date'],
						'loan_use'                 => isset($input_arr['loan_use']) ? $input_arr['loan_use'] : "",
						'customer_type'            => $input_arr['cust_type'],
						'purchase_price'           => $input_arr['purchase_price'],
						'deposit'                  => $input_arr['deposit'],
						'trade'                    => $input_arr['trade'],
						'term'                     => isset($input_arr['term']) ? $input_arr['term'] : "",
						'balloon_percent'          => $input_arr['balloon_percentage'],
						'balloon_amt'              => $input_arr['balloon_amt'],
						'est_fee'                  => $input_arr['est_fee'],
						'origination_fee'          => $input_arr['origination_fee'],
						'rate'                     => $input_arr['rate'],
						'cust_rate'                => $input_arr['cust_rate'],
						'frequency'                => isset($input_arr['frequency']) ? $input_arr['frequency'] : "",
						'gap'                      => $input_arr['gap'],
						'lti'                      => $input_arr['lti'],
						'comprehensive'            => $input_arr['comprehensive'],
						'lender'                   => isset($input_arr['lender']) ? $input_arr['lender'] : "",
						'commision'                => $input_arr['commision'],
						'total_outgoings'          => $input_arr['total_outgoings'],
						// 'total_expenses'        => $input_arr['total_expenses'],
						'payments'                 => $input_arr['payments'],
						'trading_name'             => $input_arr['trading_name'],
						'abn'                      => $input_arr['abn'],
						'abn_date'                 => $input_arr['abn_date'],
						'abr_name'                 => $input_arr['abr_name'],
						'industry'                 => $input_arr['industry'],
						'gst_registered'           => isset($input_arr['gst_registered']) ? $input_arr['gst_registered']: "",
						// 'turnover_gross'        => $input_arr['turnover_gross'],
						'net_profit'               => $input_arr['net_profit'],
						'other_income'             => $input_arr['other_income'],
						// 'trade_unit_address'    => $input_arr['trade_unit_address'],
						'trade_address'            => $input_arr['trade_address'],
						'trade_suburb'             => $input_arr['trade_suburb'],
						'trade_post_code'          => $input_arr['trade_post_code'],
						'accountant'               => $input_arr['accountant'],
						'accountant_contact'       => $input_arr['accountant_contact'],
						'accountant_number'        => $input_arr['accountant_number'],
						'accountant_address'       => $input_arr['accountant_address'],
						'accountant_suburb'        => $input_arr['accountant_suburb'],
						'accountant_post_code'     => $input_arr['accountant_post_code'],
						'banking_institution'      => $input_arr['banking_institution'],
						'surp_def_pos'             => $input_arr['surp_def_pos'],
						'naf'                      => $input_arr['naf'],
						'bank_addr_titled'         => isset($input_arr['bank_addr_titled']) ? $input_arr['bank_addr_titled'] : "",
						'accountant_email'         => $input_arr['accountant_email'],
						'arrears'                  => isset($input_arr['arrears']) ? $input_arr['arrears'] : "",
						//'deposit_check'            => isset($input_arr['deposit_check']) ? "1" : "0",
						'deposit_check'            => isset($input_arr['depositCheck']) ? "1" : "0",
						'trade_check'              => isset($input_arr['trade_check']) ? "1" : "0",
						'assessment_type'          => isset($input_arr['assessment_type']) ? $input_arr['assessment_type'] : "",
						'book_value'               => $input_arr['book_value'],
						'total_income'             => $input_arr['total_income'],
						'dealer_street_address'    => $input_arr['dealer_street_address'],
						'dealer_suburb'            => $input_arr['dealer_suburb'],
						'dealer_postcode'          => $input_arr['dealer_postcode'],
						'alt_dealer'               => $input_arr['alt_dealer'],
						'replacement'              => isset($input_arr['replacement']) ? "1" : "0",
						'trust_name'               => $input_arr['trust_name'],
						'trust_type'               => isset($input_arr['trust_type']) ? $input_arr['trust_type'] : "",
						'loan_type'                => isset($input_arr['loan_type']) ? $input_arr['loan_type'] : "",
						'acn'                      => $input_arr['acn'],
						'lead_email'			   => $input_arr['new_lead_email_address'],
							);
		
		$fq_dealer_data = array(
						'fq_lead_id'		=> $input_arr['fapplication_id'],
						'name'				=> $input_arr['new_lead_name'],
						'surname'			=> $input_arr['new_lead_surname'],
						'number'			=> $input_arr['new_lead_number'],
						'email'				=> $input_arr['new_lead_email_address'],
						'address'			=> $input_arr['new_lead_address'],
						'postcode'			=> $input_arr['new_lead_postcode'],
						'dl_no'				=> $input_arr['new_lead_dl_no'],
						'c_card_type'		=> $input_arr['new_lead_credit_card'],
						'c_card_num'		=> $input_arr['new_lead_card_no'],
						'c_card_exp'		=> $input_arr['new_lead_exp_date'],
						'c_card_cvv'		=> $input_arr['new_lead_cvv_no'],
						'deposite_amt'		=> $input_arr['new_lead_deposit_amt'],
						'year'				=> $input_arr['newLead_car_year'],
						'make'				=> $input_arr['newLead_make'],
						'modal'				=> $input_arr['newLead_model'],
						'veriant'			=> $input_arr['newLead_car_variant'],
						'redbook_url'		=> $input_arr['new_lead_redbook_url'],
						'sale_price'		=> $input_arr['new_lead_sale_price'],
						'winning_quote'		=> $input_arr['new_lead_winning_quote'],
						'winning_trade'		=> $input_arr['new_lead_winning_trade'],
						'gross_margin'		=> $input_arr['new_lead_gross_margin'],
						'delivery_date'		=> $input_arr['new_lead_delivery_date'],
						'dealer'			=> $input_arr['new_lead_dealer'],
						'dealer_surname' 	=> $input_arr['new_lead_dealer_surname'],
						'wholesaler'		=> $input_arr['new_lead_wholesaler'],
							);
		$this->insert_update_fq_dealer_data($fq_dealer_data,$input_arr['fapplication_id']);
		
		
		$extra_update_data = [
			'lead_make'  => isset($input_arr['make']) ? $input_arr['make'] : "", 
			'lead_model' => isset($input_arr['model']) ? $input_arr['model'] : "",
			'lead_email' => $input_arr['new_lead_email_address'],
		];
		// echo $input_arr['fapplication_id']; die();

		if(!isset($input_arr['fapplication_id'])) {
			die();
		}

		$this->update_fq_lead_details($extra_update_data, $input_arr['fapplication_id']);
		$this->db->where('id_fq_account', $input_arr['fapplication_id']);
		if($this->db->update('fq_accounts_new', $update_data))
		{
			$this->update_insert_applicant($input_arr);
			if($input_arr['cust_type'] == "trust")
			{
				$this->update_insert_beneficiary($input_arr);
			}
			// echo $this->db->last_query(); die();
		}
	}

	private function update_lead_data($input_arr)
	{
		$update_data = [];

		$select_query = "select * from leads where id_lead = {$input_arr['lead_id_fq']}";

		$result = $this->db->query($select_query)->row_array();

		$this->db->where("id_lead", $input_arr['lead_id_fq']);

		if($result['driver_license'] == "")
			$update_data['driver_license'] = $input_arr['dl_number'][0];
		
		if($result['email'] == "")
			$update_data['email'] = $input_arr['email'][0];

		if($result['phone'] == "")
			$update_data['mobile'] = $input_arr['mobile'][0];

		if($result['mobile'] == "")
			$update_data['mobile'] = $input_arr['other_telephone'][0];

		if($result['mobile'] == "")
			$update_data['mobile'] = $input_arr['other_telephone'][0];

		if($result['postcode'] == "")
			$update_data['postcode'] = $input_arr['client_post_code'][0][0];

		if($result['address'] == "")
			$update_data['address'] = $input_arr['client_address'][0][0] ." ".$input_arr['client_suburb'][0][0];

		if($result['date_of_birth'] == "")
			$update_data['date_of_birth'] = $input_arr['date_of_birth'][0];

		if($result['state'] == "")
			$update_data['state'] = $input_arr['client_state'][0][0];

		if( count($update_data) > 0 )
			$this->db->update('leads', $update_data);

		// if(1==2)
		// {
		// 	$this->db->where("id_lead", $input_arr['lead_id_fq']);

		// 	$update_data = [
		// 		'email'         => $input_arr['email'][0],
		// 		'name'          => $input_arr['first_name'][0] . " " . $input_arr['last_name'][0],
		// 		'phone'         => $input_arr['mobile'][0],
		// 		'mobile'        => $input_arr['other_telephone'][0],
		// 		'postcode'      => $input_arr['client_post_code'][0][0],
		// 		'address'       => $input_arr['client_address'][0][0] ." ".$input_arr['client_suburb'][0][0],
		// 		'date_of_birth' => $input_arr['date_of_birth'][0],
		// 		'state'         => $input_arr['client_state'][0][0]
		// 	];

		// 	$this->db->update('leads', $update_data);
		// }
	}

	private function update_fq_lead_details($extra_update_data, $fq_id)
	{
		$this->db->where('id_fq_account', $fq_id);
		$this->db->update('fq_accounts_new', $extra_update_data);
	}

	public function update_insert_applicant ($input_arr) // DONE
	{
		
		$count = 0;
		$data = array();
		foreach ($input_arr['first_name'] as $key => $value) 
		{
			
			$curr_id = 0;
			
			$count   = 0;

			$count_query = "";

			$id = ($input_arr['applicant_id'][$key] != '') ? $input_arr['applicant_id'][$key] : 0;

			$count_query = "SELECT * FROM (`fq_applicants`) WHERE `fk_accounts` = {$input_arr['fapplication_id']} AND `id` = {$id}";

			$count = $this->db->query($count_query)->num_rows();
			//print_r($input_arr['email']);
			
				$email = '';
				if(is_array($input_arr['email']) && isset($input_arr['email'][$key]) && $input_arr['email'][$key]!="")
				 { $email = $input_arr['email'][$key]; }
				 elseif(isset($input_arr['email']) && $input_arr['email']!="")
				 { $email =$input_arr['email'];}
				 
				 
			$data = array(
						'fk_accounts'          => $input_arr['fapplication_id'],
						'title'                => (isset($input_arr['title'][$key])) ? $input_arr['title'][$key] : '',
						'first_name'           => $input_arr['first_name'][$key],
						'middle_name'          => $input_arr['middle_name'][$key],
						'last_name'            => $input_arr['last_name'][$key],
						'date_of_birth'        => $input_arr['date_of_birth'][$key],
						'sex'                  => isset($input_arr['sex'][$key]) ? $input_arr['sex'][$key]: "",
						'dl_number'            => $input_arr['dl_number'][$key],
						'dl_exp'               => $input_arr['dl_exp'][$key],
						'dl_state'             => (isset($input_arr['dl_state'][$key])) ? $input_arr['dl_state'][$key] : '',
						'dl_type'              => (isset($input_arr['dl_type'][$key])) ? $input_arr['dl_type'][$key] : '',
						'marital_stat'         => (isset($input_arr['marital_stat'][$key])) ? $input_arr['marital_stat'][$key] : '' ,
						'dependents'           => (isset($input_arr['dependents'][$key])) ? $input_arr['dependents'][$key] : '',
						'ages'                 => $input_arr['ages'][$key],
						'citizen_stat'         => (isset($input_arr['citizen_stat'][$key])) ? $input_arr['citizen_stat'][$key] : '',
						'mobile'               => $input_arr['mobile'][$key],
						'email'                => $input_arr['email'][$key],
						//'email'                => $email,
						'other_telephone'      => $input_arr['other_telephone'][$key],
						'cash_savings'         => isset($input_arr['cash_savings'][$key]) ? $input_arr['cash_savings'][$key] : "",
						'personal_effects'     => isset($input_arr['personal_effects'][$key]) ? $input_arr['personal_effects'][$key] : "",
						'shares_investments'   => isset($input_arr['shares_investments'][$key]) ? $input_arr['shares_investments'][$key] : "",
						'superannuation'       => isset($input_arr['superannuation'][$key]) ? $input_arr['superannuation'][$key] : "",
						'asset_vehicles'       => isset($input_arr['asset_vehicles'][$key]) ? $input_arr['asset_vehicles'][$key] : "",
						'total_assets'         => isset($input_arr['total_assets'][$key]) ? $input_arr['total_assets'][$key] : "",
						'food_beverage'        => isset($input_arr['food_beverage'][$key]) ? $input_arr['food_beverage'][$key] : "",
						'power_gas'            => isset($input_arr['power_gas'][$key]) ? $input_arr['power_gas'][$key] : "",
						'transportation_fuel'  => isset($input_arr['transportation_fuel'][$key]) ? $input_arr['transportation_fuel'][$key] : "",
						'recreation'           => isset($input_arr['recreation'][$key]) ? $input_arr['recreation'][$key] : "",
						'insurance'            => isset($input_arr['insurance'][$key]) ? $input_arr['insurance'][$key] : "",
						'tot_living_cost'      => isset($input_arr['tot_living_cost'][$key]) ? $input_arr['tot_living_cost'][$key] : "",
						'total_property_value' => isset($input_arr['total_property_value'][$key]) ? $input_arr['total_property_value'][$key] : "",
						'statement_1'          => isset($input_arr['statement_1'][$key]) ? $input_arr['statement_1'][$key] : "No",
						'statement_2'          => isset($input_arr['statement_2'][$key]) ? $input_arr['statement_1'][$key] : "No",
						'statement_3'          => isset($input_arr['statement_3'][$key]) ? $input_arr['statement_1'][$key] : "No",
						'statement_4'          => isset($input_arr['statement_4'][$key]) ? $input_arr['statement_1'][$key] : "No",
						'statement_5'          => isset($input_arr['statement_5'][$key]) ? $input_arr['statement_1'][$key] : "No",
						'visa_holder'          => isset($input_arr['visa_holder']) ? "1" : "0"
							);
			// echo $input_arr['tot_living_cost_check'][$key]; echo "<br>";
			//print_r($data);exit;
			if($key == 0)
			{
				$email = '';
				if(is_array($input_arr['email']) && isset($input_arr['email'][$key]) && $input_arr['email'][$key]!="")
				 { $email = $input_arr['email'][$key]; }
				 elseif(isset($input_arr['email']) && $input_arr['email']!="")
				 { $email =$input_arr['email'];}
				
				$extra_update_data = [
					//'lead_name'   => $input_arr['first_name'][$key] . " " . $input_arr['last_name'][$key],
					//'lead_email'  => $input_arr['email'][$key],
					//'lead_email'  => $email,
					'lead_name'   => $input_arr['new_lead_name'] . " " . $input_arr['new_lead_surname'],
					'lead_email'=> $input_arr['new_lead_email_address'],
					'lead_phone'=> $input_arr['new_lead_number'],
					//'lead_phone'  => $input_arr['mobile'][$key],
					'lead_mobile' => $input_arr['other_telephone'][$key],
					'lead_state'  => $input_arr['client_state'][$key][0]
				];

				$this->update_fq_lead_details($extra_update_data, $input_arr['fapplication_id']);

				if($input_arr['lead_id_fq'] != NULL or $input_arr['lead_id_fq'] != 0 or $input_arr['lead_id_fq'] != 0)
				{
					// $this->update_lead_data($input_arr);
				}
			}

			if($count > 0)
			{	
				$this->db->where('id', $input_arr['applicant_id'][$key]);

				$this->db->update('fq_applicants', $data);

				$this->update_insert_address($input_arr, $input_arr['applicant_id'][$key], $key);

				$this->update_insert_employer($input_arr, $input_arr['applicant_id'][$key], $key);

				$this->update_insert_credit_card($input_arr, $input_arr['applicant_id'][$key], $key);

				$this->update_insert_other_loans($input_arr, $input_arr['applicant_id'][$key], $key);

				$this->update_insert_credit_reference($input_arr, $input_arr['applicant_id'][$key], $key);

				$this->update_insert_property($input_arr, $input_arr['applicant_id'][$key], $key);

				$this->update_insert_other_asset($input_arr, $input_arr['applicant_id'][$key], $key);
			}
			else
			{
				if( trim($input_arr['first_name'][$key] != '') OR trim($input_arr['last_name'][$key] != '') )
				{
					$this->db->insert('fq_applicants', $data);
					
					$curr_id = $this->db->insert_id();
					
					$this->update_insert_address($input_arr, $curr_id, $key);
					
					$this->update_insert_employer($input_arr, $curr_id, $key);
					
					$this->update_insert_credit_card($input_arr, $curr_id, $key);
					
					$this->update_insert_other_loans($input_arr, $curr_id, $key);
					
					$this->update_insert_credit_reference($input_arr, $curr_id, $key);
					
					$this->update_insert_property($input_arr, $curr_id, $key);

					$this->update_insert_other_asset($input_arr, $curr_id, $key);
				}
			}
			
		}
		// die();	
	}

	public function update_insert_beneficiary ($input_arr)
	{
		$count = 0;
		$data = array();

		if($input_arr['b_first_name'][0] != '')
		{
			foreach ($input_arr['b_first_name'] as $key => $value) 
			{
				$curr_id = 0;
				
				$count   = 0;

				$count_query = "";

				$id = ($input_arr['beneficiary_id'][$key] != '') ? $input_arr['beneficiary_id'][$key] : 0;

				$count_query = "SELECT * FROM (`fq_beneficiaries`) WHERE `fk_account` = {$input_arr['fapplication_id']} AND `id` = {$id}";

				$count = $this->db->query($count_query)->num_rows();
				
				$data = array(
							'fk_account'      => $input_arr['fapplication_id'],
							'b_first_name'    => $input_arr['b_first_name'][$key],
							'b_last_name'     => isset($input_arr['b_last_name'][$key]) ? $input_arr['b_last_name'][$key] : "",
							'b_address'       => $input_arr['b_address'][$key],
							'b_suburb'        => $input_arr['b_suburb'][$key],
							'b_postcode'      => $input_arr['b_postcode'][$key],
							'b_mobile_number' => isset($input_arr['b_mobile_number'][$key]) ? $input_arr['b_mobile_number'][$key] : "",
							'b_other_number'  => isset($input_arr['b_other_number'][$key]) ? $input_arr['b_other_number'][$key] : "",
							'b_type'          => $input_arr['b_type'][$key],
							'b_acn'           => $input_arr['b_acn'][$key]
								);

				if($count > 0)
				{	
					$this->db->where('id', $input_arr['beneficiary_id'][$key]);

					$this->db->update('fq_beneficiaries', $data);
				}
				else
				{	
					if( trim($input_arr['b_first_name'] != '') OR trim($input_arr['b_last_name'] != '') )
					{
						$this->db->insert('fq_beneficiaries', $data);
					}
				}
				
			}
		}
	}

	public function update_insert_address ($input_arr, $applicant_id = 0, $parent_key = 0) // DONE
	{
		$count = 0;
		$data  = array();

		$current_key = "";

		// echo "<pre>";
		// print_r($input_arr); die();

		foreach ($input_arr['client_address'][$parent_key] as $key => $value) 
		{
			$count = 0;

			$curr_id = 0;

			$count = $this->db->get_where(
											'fq_app_address', 
											array('fk_applicant' => $applicant_id, 'id' => $input_arr['address_id'][$parent_key][$key]), 
											1, 
											0
										)->num_rows();

			$data = array(
						'fk_applicant'                => $applicant_id,
						'client_address'              => $input_arr['client_address'][$parent_key][$key],
						'client_suburb'               => $input_arr['client_suburb'][$parent_key][$key],
						'client_postcode'             => $input_arr['client_post_code'][$parent_key][$key],
						'client_res_stat'             => (isset($input_arr['client_res_stat'][$parent_key][$key])) ? $input_arr['client_res_stat'][$parent_key][$key] : '',
						'client_state'                => (isset($input_arr['client_state'][$parent_key][$key])) ? $input_arr['client_state'][$parent_key][$key] : '',
						'time_address_years'          => (isset($input_arr['time_address_years'][$parent_key][$key])) ? $input_arr['time_address_years'][$parent_key][$key] : "0",
						'time_address_months'         => (isset($input_arr['time_address_month'][$parent_key][$key])) ? $input_arr['time_address_month'][$parent_key][$key] : "",
						'landlord_realestate_name'    => (isset($input_arr['landlord_realestate_name'][$parent_key][$key])) ? $input_arr['landlord_realestate_name'][$parent_key][$key] : "",
						'landlord_realestate_number'  => (isset($input_arr['landlord_realestate_number'][$parent_key][$key])) ? $input_arr['landlord_realestate_number'][$parent_key][$key] : "",
						'landlord_realestate_contact' => (isset($input_arr['landlord_realestate_contact'][$parent_key][$key])) ? $input_arr['landlord_realestate_contact'][$parent_key][$key] : "",
						'monthly_commitment'          => (isset($input_arr['monthly_commitment'][$parent_key][$key])) ? $input_arr['monthly_commitment'][$parent_key][$key] : "",
						'name_on_title'               => (isset($input_arr['name_on_title'][$parent_key][$key])) ? $input_arr['name_on_title'][$parent_key][$key] : '',
						'number_on_lease'             => (isset($input_arr['number_on_lease'][$parent_key][$key])) ? $input_arr['number_on_lease'][$parent_key][$key] : ''
						);

			if( $input_arr['client_address'][$parent_key][$key] != "" )
				$current_key = "client_address";
			elseif( $input_arr['client_post_code'][$parent_key][$key] != "" )
				$current_key = "client_post_code";
			else
				$current_key = "client_address";

			if($count > 0)
			{
				$this->db->where('id', $input_arr['address_id'][$parent_key][$key]);

				$this->db->update('fq_app_address', $data);
				

			}
			else
			{
				if(isset($input_arr[$current_key][$parent_key][$key]) && trim($input_arr[$current_key][$parent_key][$key]) != '')
				{
					$this->db->insert('fq_app_address', $data);	
				}
			}
		}
	}

	public function update_insert_employer ($input_arr, $applicant_id = 0, $parent_key = 0) // DONE
	{
		// echo "<pre>";
		// print_r($input_arr);
		// die();
		
		$count = 0;
		$data  = array();

		foreach ($input_arr['employer_name'][$parent_key] as $key => $value) 
		{
			$count = 0;

			$curr_id = 0;

			$insert_id = 0;

			$count = $this->db->get_where(
											'fq_app_employer', 
											array('fk_applicant' => $applicant_id, 'id' => $input_arr['employer_id'][$parent_key][$key]), 
											1, 
											0
										)->num_rows();

			$data = array(
						'fk_applicant'        => $applicant_id,
						'employer_name'       => $input_arr['employer_name'][$parent_key][$key],
						'employment_status'   => (isset($input_arr['employment_status'][$parent_key][$key])) ? $input_arr['employment_status'][$parent_key][$key] : '',
						'occ_position'        => $input_arr['occ_position'][$parent_key][$key],
						'emp_address'         => isset($input_arr['emp_address'][$parent_key][$key]) ? $input_arr['emp_address'][$parent_key][$key] : "",
						'emp_suburb'          => isset($input_arr['emp_suburb'][$parent_key][$key]) ? $input_arr['emp_suburb'][$parent_key][$key] : "",
						'emp_post'            => isset($input_arr['emp_post'][$parent_key][$key]) ? $input_arr['emp_post'][$parent_key][$key] : "",
						'emp_state'            => isset($input_arr['emp_state'][$parent_key][$key]) ? $input_arr['emp_state'][$parent_key][$key] : "",
						'contact_person'      => isset($input_arr['contact_person'][$parent_key][$key]) ? $input_arr['contact_person'][$parent_key][$key] : "",
						'contact_number'      => $input_arr['contact_number'][$parent_key][$key],
						'net_income'          => isset($input_arr['net_income'][$parent_key][$key]) ? $input_arr['net_income'][$parent_key][$key] : "",
						'time_employer_years' => (isset($input_arr['time_employer_years'][$parent_key][$key])) ? $input_arr['time_employer_years'][$parent_key][$key] : '',
						'time_employer_month' => (isset($input_arr['time_employer_month'][$parent_key][$key])) ? $input_arr['time_employer_month'][$parent_key][$key] : '',
						'emp_abn'             => isset($input_arr['emp_abn'][$parent_key][$key]) ? $input_arr['emp_abn'][$parent_key][$key] : "",
						'industry'            => isset($input_arr['industry'][$parent_key][$key]) ? $input_arr['industry'][$parent_key][$key] : ""
						);

			if($count > 0)
			{
				$this->db->where('id', $input_arr['employer_id'][$parent_key][$key]);

				$this->db->update('fq_app_employer', $data);

				$insert_id = $input_arr['employer_id'][$parent_key][$key];

				if($key == 0)
					$this->update_insert_other_income($input_arr, $insert_id, $parent_key, $key);
			}
			else
			{
				if(isset($input_arr['employer_name'][$parent_key][$key]) && trim($input_arr['employer_name'][$parent_key][$key]) != '')
				{
					$this->db->insert('fq_app_employer', $data);

					$insert_id = $this->db->insert_id();

					if($key == 0)
						$this->update_insert_other_income($input_arr, $insert_id, $parent_key, $key);
				}
			}
			
		}
	}

	public function update_insert_other_income($input_arr, $employer_id = 0, $level_1_key = 0, $level_2_key = 0)
	{
		$count = 0;
		$data  = array();


		// echo "<pre>";
		// print_r($input_arr); die();

		foreach ($input_arr['other_income_name'][$level_1_key][$level_2_key] as $key => $value) 
		{
			$count = 0;

			$count = $this->db->get_where(
											'fq_employer_other_inc', 
											array('fk_employer_id' => $employer_id, 'id' => $input_arr['other_income_id'][$level_1_key][$level_2_key][$key]), 
											1, 
											0
										)->num_rows();

			$data = array(
						'fk_employer_id'       => $employer_id,
						'other_income_name'    => $input_arr['other_income_name'][$level_1_key][$level_2_key][$key],
						'other_income_details' => $input_arr['other_income_details'][$level_1_key][$level_2_key][$key],
						'other_income_amount'  => $input_arr['other_income_amount'][$level_1_key][$level_2_key][$key]
						);

			if($count > 0)
			{
				$this->db->where('id', $input_arr['other_income_id'][$level_1_key][$level_2_key][$key]);

				$this->db->update('fq_employer_other_inc', $data);
			}
			else
			{
				if(isset($input_arr['other_income_name'][$level_1_key][$level_2_key][$key]) && trim($input_arr['other_income_name'][$level_1_key][$level_2_key][$key]) != '')
				{
					$this->db->insert('fq_employer_other_inc', $data);
				}
			}
		}
	}

	public function update_insert_credit_card ($input_arr, $applicant_id = 0, $parent_key = 0) // DONE
	{

		$count = 0;
		$data  = array();

		foreach ($input_arr['credit_card_limit'][$parent_key] as $key => $value) 
		{
			$count = 0;

			$curr_id = 0;

			$count = $this->db->get_where(
											'fq_credit_card', 
											array('fk_applicant' => $applicant_id, 'id' => $input_arr['credit_card_id'][$parent_key][$key]), 
											1, 
											0
										)->num_rows();

			$data = array(
						'fk_applicant'        => $applicant_id,
						'credit_card_name'    => $input_arr['credit_card_name'][$parent_key][$key],
						'credit_card_limit'   => $input_arr['credit_card_limit'][$parent_key][$key],
						'credit_card_balance' => $input_arr['credit_card_balance'][$parent_key][$key],
						'credit_card_monthly' => $input_arr['credit_card_monthly'][$parent_key][$key]
						);

			if($count > 0)
			{
				$this->db->where('id', $input_arr['credit_card_id'][$parent_key][$key]);

				$this->db->update('fq_credit_card', $data);
			}
			else
			{
				if(isset($input_arr['credit_card_limit'][$parent_key][$key]) && trim($input_arr['credit_card_limit'][$parent_key][$key]) != '')
				{
					$this->db->insert('fq_credit_card', $data);
				}
			}
		}
	}

	public function update_insert_other_loans ($input_arr, $applicant_id = 0, $parent_key = 0) // DONE
	{

		$count = 0;
		$data  = array();

		foreach ($input_arr['lending_institution'][$parent_key] as $key => $value) 
		{

			$count = 0;

			$curr_id = 0;

			$count = $this->db->get_where(
											'fq_other_loans', 
											array('fk_applicant' => $applicant_id, 'id' => $input_arr['other_loans_id'][$parent_key][$key]), 
											1, 
											0
										)->num_rows();

			$data = array(
						'fk_applicant'         => $applicant_id,
						'lending_institution'  => $input_arr['lending_institution'][$parent_key][$key],
						'purpose'              => $input_arr['purpose'][$parent_key][$key],
						'amount_borrowed'      => $input_arr['amount_borrowed'][$parent_key][$key],
						'o_term'               => $input_arr['o_term'][$parent_key][$key],
						'loan_start_date'      => $input_arr['loan_start_date'][$parent_key][$key],
						'monthly_commitment'   => $input_arr['o_monthly_payment'][$parent_key][$key]
						);
			

			if($count > 0)
			{
				$this->db->where('id', $input_arr['other_loans_id'][$parent_key][$key]);

				$this->db->update('fq_other_loans', $data);
			}
			else
			{
				if(isset($input_arr['lending_institution'][$parent_key][$key]) && trim($input_arr['lending_institution'][$parent_key][$key]) != '')
				{
					$this->db->insert('fq_other_loans', $data);
				}
			}
		}
	}

	public function update_insert_credit_reference ($input_arr, $applicant_id = 0, $parent_key = 0) // DONE
	{

		$count = 0;
		$data  = array();

		if(isset($input_arr['r_first_name'][$parent_key]))
		{
			foreach ($input_arr['r_first_name'][$parent_key] as $key => $value) 
			{
				$count = 0;

				$curr_id = 0;

				$count = $this->db->get_where(
												'fq_reference', 
												array('fk_applicant' => $applicant_id, 'id' => $input_arr['credit_reference_id'][$parent_key][$key]), 
												1, 
												0
											)->num_rows();

				$data = array(
							'fk_applicant' => $applicant_id,
							'r_first_name' => $input_arr['r_first_name'][$parent_key][$key],
							'r_last_name'  => $input_arr['r_last_name'][$parent_key][$key],
							'r_telephone'  => $input_arr['r_telephone'][$parent_key][$key],
							// 'r_unit'       => $input_arr['r_unit'][$parent_key][$key],
							'r_address'    => $input_arr['r_address'][$parent_key][$key],
							'r_suburb'     => $input_arr['r_suburb'][$parent_key][$key],
							'r_postcode'   => $input_arr['r_postcode'][$parent_key][$key],
							'r_business_name'   => $input_arr['r_business_name'][$parent_key][$key]
							);

				if($count > 0)
				{
					$this->db->where('id', $input_arr['credit_reference_id'][$parent_key][$key]);

					$this->db->update('fq_reference', $data);
				}
				else
				{
					if(isset($input_arr['r_first_name'][$parent_key][$key]) && trim($input_arr['r_first_name'][$parent_key][$key]) != '')
					{
						$this->db->insert('fq_reference', $data);
					}
				}
			}
		}
	}

	public function update_insert_property ($input_arr, $applicant_id = 0, $parent_key = 0) // DONE
	{
		$count = 0;
		$data  = array();

		$current_key = "";

		foreach ($input_arr['property_address'][$parent_key] as $key => $value) 
		{
			$count = 0;

			$curr_id = 0;

			$count = $this->db->get_where(
											'fq_property_assets', 
											array('fk_applicant' => $applicant_id, 'id' => $input_arr['property_id'][$parent_key][$key]), 
											1, 
											0
										)->num_rows();

			$data = array(
						'fk_applicant'        => $applicant_id,
						'property_address'    => $input_arr['property_address'][$parent_key][$key],
						'property_suburb'     => $input_arr['property_suburb'][$parent_key][$key],
						'property_postcode'   => $input_arr['property_postcode'][$parent_key][$key],
						'mortgage_with'       => $input_arr['mortgage_with'][$parent_key][$key],
						'mortgage_commitment' => $input_arr['mortgage_commitment'][$parent_key][$key],
						'balance'             => $input_arr['balance'][$parent_key][$key],
						'property_value'      => $input_arr['property_value'][$parent_key][$key],
						'monthly_payment'     => $input_arr['monthly_payment'][$parent_key][$key],
						'name_on_title'       => isset($input_arr['name_on_title']) ? "1" : "0",
						'managed'             => isset($input_arr['managed']) ? "1" : "0"
						);

			if( $input_arr['property_address'][$parent_key][$key] != "" )
				$current_key = "property_address";
			elseif( $input_arr['property_suburb'][$parent_key][$key] != "" )
				$current_key = "property_suburb";
			elseif( $input_arr['property_postcode'][$parent_key][$key] != "" )
				$current_key = "property_postcode";
			elseif( $input_arr['mortgage_with'][$parent_key][$key] != "" )
				$current_key = "mortgage_with";
			elseif( $input_arr['mortgage_commitment'][$parent_key][$key] != "" )
				$current_key = "mortgage_commitment";
			elseif( $input_arr['balance'][$parent_key][$key] != "" )
				$current_key = "balance";
			elseif( $input_arr['property_value'][$parent_key][$key] != "" )
				$current_key = "property_value";
			else
				$current_key = "property_address";

			if($count > 0)
			{
				$this->db->where('id', $input_arr['property_id'][$parent_key][$key]);

				$this->db->update('fq_property_assets', $data);
			}
			else
			{
				if(isset($input_arr[$current_key][$parent_key][$key]) && trim($input_arr[$current_key][$parent_key][$key]) != '')
				{
					$this->db->insert('fq_property_assets', $data);
				}
			}
		} 
	}

	public function update_insert_other_asset ($input_arr, $applicant_id = 0, $parent_key = 0) // DONE
	{
		$count = 0;
		$data  = array();

		// foreach ($input_arr['other_asset_name'][$parent_key] as $key => $value) 
		// {
		// 	$count = 0;

		// 	$curr_id = 0;

		// 	$count = $this->db->get_where(
		// 									'fq_other_asset', 
		// 									array('fk_applicant' => $applicant_id, 'id' => $input_arr['other_asset_id'][$parent_key][$key]), 
		// 									1, 
		// 									0
		// 								)->num_rows();
			
		// 	$data = array(
		// 				'fk_applicant'      => $applicant_id,
		// 				'other_asset_name'  => $input_arr['other_asset_name'][$parent_key][$key],
		// 				'other_asset_value' => $input_arr['other_asset_value'][$parent_key][$key]
		// 				);

		// 	if($count > 0)
		// 	{
		// 		$this->db->where('id', $input_arr['other_asset_id'][$parent_key][$key]);

		// 		$this->db->update('fq_other_asset', $data);
		// 	}
		// 	else
		// 	{
		// 		if(isset($input_arr['other_asset_name'][$parent_key][$key]) && trim($input_arr['other_asset_name'][$parent_key][$key]) != '')
		// 		{
		// 			$this->db->insert('fq_other_asset', $data);
		// 		}
		// 	}
		// }
	}

	public function get_fq_account($id) // DONE
	{
		$query = "
				SELECT
				fa.id_fq_account, CONCAT('FQA', LPAD(fa.id_fq_account, 5, '0')) AS `fqa_number`, fa.source, fa.status,
				CASE (fa.status)
					WHEN 0 THEN 'Unallocated'
					WHEN 1 THEN 'Allocated'
					WHEN 2 THEN 'Attempted'
					WHEN 100 THEN 'Deleted'
				END `status_text`,

				fa.lead_name, fa.lead_email, fa.lead_phone, fa.lead_mobile, fa.lead_state, fa.lead_make, fa.lead_model,

				fa.car, fa.year, fa.make, fa.model, fa.variant, fa.color, fa.kms, fa.options, fa.further_details,fa.further_details_supplier,fa.further_details_deals, fa.dealer,
				fa.delivery_date, fa.supplier_contact, fa.supplier_landline, fa.supplier_mobile, fa.supplier_email, fa.loan_use, fa.customer_type, 
				fa.applicant_count, fa.purchase_price, fa.deposit, fa.trade, fa.amt_to_finance, fa.term, fa.balloon_percent, fa.balloon_amt,
				fa.dof, fa.est_fee, fa.origination_fee, fa.rate, fa.frequency, fa.gap, fa.lti, fa.comprehensive, fa.lender, fa.total_pd,
				fa.payments, fa.commision, fa.trading_name, fa.abn, fa.abn_date, fa.abr_name, fa.gst_registered, fa.trade_address, fa.trade_suburb,
				fa.trade_post_code, fa.trade_state, fa.accountant, fa.accountant_contact, fa.accountant_number, fa.accountant_address, 
				fa.accountant_suburb, fa.accountant_post_code, fa.accountant_state, fa.turnover_gross, fa.net_profit, fa.other_income, fa.seller, fa.tax_inv_dealer, fa.payout,
				fa.car_stock, fa.car_arrival, fa.total_expenses, fa.total_income, fa.surp_def_pos, fa.total_outgoings, fa.cust_rate, fa.industry, fa.banking_institution, 

				fa.created_at, fa.last_updated, fa.vin, fa.engine, fa.rego, fa.trade_unit_address, fa.bank_addr_titled, fa.accountant_email, fa.naf, fa.arrears,
				fa.deposit_check, fa.color_status, fa.assessment_type, fa.book_value, fa.trade_check,

				fa.dealer_street_address, fa.dealer_suburb, fa.dealer_postcode, fa.replacement, fa.trust_name, fa.trust_type, fa.acn, fa.loan_type,
				fa.alt_dealer, 

				ul.name as `cq_staff`,
				uf.name as `fq_staff`,		

				l.state as `le_state`,l.postcode as `le_postcode`,l.address as `le_address`,
				l.details as `cq_details`, l.status as `lead_status`, l.id_lead as `lead_id`, l.fk_temp_user as `temp_lead_user`, ut.name as `temp_user`

				FROM fq_accounts_new fa
				LEFT JOIN users uf ON fa.fk_user = uf.id_user
				LEFT JOIN leads l ON fa.fk_lead = l.id_lead
				LEFT JOIN users ul ON l.fk_user = ul.id_user
				LEFT JOIN users ut ON l.fk_temp_user = ut.id_user
				WHERE 1 AND id_fq_account = ".$id." LIMIT 1";

		return $this->db->query($query)->row_array();
	}

	public function get_applicant_data($id) // DONE
	{
		$query = "select * from fq_applicants where fk_accounts=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_beneficiary_data($id) // DONE
	{
		$query = "select * from fq_beneficiaries where fk_account=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_address_data($id) // DONE
	{
		$query = "select * from fq_app_address where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_employer_data($id) // DONE
	{
		$query = "select * from fq_app_employer where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_other_income_data($id)
	{
		$query = "select * from fq_employer_other_inc where fk_employer_id = ".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_credit_card_data($id) // DONE
	{
		$query = "select * from fq_credit_card where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_other_loans_data($id) // DONE
	{
		$query = "select * from fq_other_loans where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_reference_data($id) // DONE
	{
		$query = "select * from fq_reference where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_property_data($id) // DONE
	{
		$query = "select * from fq_property_assets where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_vehicle_data($id) // DONE
	{
		$query = "select * from fq_vehicle_asset where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_asset_data($id) // DONE
	{
		$query = "select * from fq_other_asset where fk_applicant=".$id;

		return $this->db->query($query)->result_array();
	}

	public function get_attachment_fapplications($id)
	{
		return $this->db->select('*')->where('type', 2)->where('fk_main',$id)->get('file_attachments')->result_array();
	}
		public function get_attachment_flag ($lead_id)
	{
		$query = "SELECT COUNT(1) AS `count` FROM file_attachments WHERE fk_main = {$lead_id}";
		$result = $this->db->query($query)->row_array();
		return (int)$result['count'];
	}
	
	public function get_leads_summary_main ($params, $my_id, $admin_type) // ADMIN
	{
		
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$source = isset($params['source']) ? $params['source'] : '';		
		
		/*
		$status = isset($params['status']) ? $params['status'] : '';
		$date_from = isset($params['date_from']) ? $params['date_from'] : '';
		$date_to = isset($params['date_to']) ? $params['date_to'] : '';
		*/

		$where = "";
		if ($cq_number <> "") 
		{
			$where .= " 
			AND (
				CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) = '".$this->db->escape_str($cq_number)."' 
				OR fa.`id_fq_account` = '".$this->db->escape_str($cq_number)."'
			) "; 
		}
		
		if ($current_status <> "")
		{
			if ($current_status==4)
			{
				$where .= " AND fa.`status` IN (4, 5, 6, 7, 8, 9) "; 
			}
			else
			{
				$where .= " AND fa.`status` = '".$this->db->escape_str($current_status)."' "; 
			}
		}
		
		if ($admin_type==2 OR $admin_type==5)
		{
			if ($user_id <> "")
			{
				$where .= " AND fa.`fk_user` = '".$this->db->escape_str($user_id)."' ";
			}
		}
		else
		{
			$where .= " AND fa.`fk_user` = ".$my_id;
		}

		if ($name <> "") { $where .= " AND fa.`lead_name` LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.`lead_email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($phone <> "") { $where .= " AND fa.`lead_phone` LIKE '%".$this->db->escape_str($phone)."%' "; }
		
		if ($state <> "") { $where .= " AND fa.`lead_state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND fa.`lead_postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }
		// if ($address <> "") { $where .= " AND fa.`address` LIKE '%".$this->db->escape_str($address)."%' "; }

		if ($make <> "") { $where .= " AND fa.`lead_make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND fa.`lead_model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($source <> "") { $where .= " AND fa.`source` = '".$this->db->escape_str($source)."' "; }

		/*
		if ($status == 1) { $status_date_label = "allocated_date"; }
		else if ($status == 2) { $status_date_label = "attempted_date"; }
		else if ($status == 3) { $status_date_label = "tender_date"; }
		else if ($status == 4) { $status_date_label = "order_date"; }
		else if ($status == 5) { $status_date_label = "approved_date"; }
		else if ($status == 6) { $status_date_label = "delivery_date"; }
		else if ($status == 7) { $status_date_label = "settled_date"; }
		else if ($status == 98) { $status_date_label = "decline_date"; }
		else if ($status == 100) { $status_date_label = "delete_date"; }
		else { $status_date_label = "created_at"; }
		if ($date_from <> "") { $where .= " AND DATE(l.`".$status_date_label."`) >= DATE('".$this->db->escape_str($date_from)."') "; }
		if ($date_to <> "") { $where .= " AND DATE(l.`".$status_date_label."`) <= DATE('".$this->db->escape_str($date_to)."') "; }
		*/

		$filter_column = "";

		if (isset($params['filter_column']))
		{
			if ($params['filter_column'] != "")
			{
				$filter_column = $params['filter_column'];
			}
			else
			{
				$filter_column = "created_at";
			}
		}

		$date_filter_by = isset($params['date_filter_by']) ? $params['date_filter_by'] : "";
		
		if ($date_filter_by != "")
		{
			if ($date_filter_by == 1)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday this week') )."' AND '".date( "Y-m-d",strtotime("sunday this week") )."' )";
			}
			else if ($date_filter_by == 2)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday last week') )."' AND '".date( "Y-m-d",strtotime("sunday last week") )."' )";
			}
			else if ($date_filter_by == 3)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of this month') )."' AND '".date( "Y-m-d",strtotime("last day of this month") )."' )";
			}
			else if ($date_filter_by == 4)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of last month') )."' AND '".date( "Y-m-d",strtotime("last day of last month") )."' )";
			}
			else if ($date_filter_by == 5)
			{
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d" )."'"; 
			}
			else if ($date_filter_by == 6)
			{
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d",strtotime('yesterday') )."'"; 
			}
			else if ($date_filter_by == 7)
			{
				if (isset($params['filter_date_from']))
				{
					$filter_date_from = date('Y-m-d', strtotime($params['filter_date_from']));
				}
				else
				{
					$filter_date_from = date('Y-m-d');
				}

				if (isset($params['filter_date_to']))
				{
					$filter_date_to = date('Y-m-d', strtotime($params['filter_date_to']));
				}
				else
				{
					$filter_date_to = date('Y-m-d');
				}

				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN '{$filter_date_from}' AND '{$filter_date_to}' ) ";
			}
			else
			{
				$where .= " ";
			}
		}

		if (isset($params['order_by_filter']))
		{
			if ($params['order_by_filter']<>"")
			{
				$order_by = " `fa`.`".$params['order_by_filter']."` ";
			}
			else
			{
				$order_by = " `fa`.`id_fq_account` ";
			}
		}
		else
		{
			$order_by = " `fa`.`id_fq_account` ";
		}

		if (isset($params['order_filter']))
		{
			if ($params['order_by_filter']<>"")
			{		
				$order = " ".$params['order_filter']." ";
			}
			else
			{
				$order = " DESC ";
			}
		}
		else
		{
			$order = " DESC ";
		}
		
		

		$query = "
		SELECT 
		fa.`id_fq_account` AS `lead_id`,
		fa.`id_fq_account`, fa.`fk_user`, fa.`source`,
		CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) AS `cq_number`,
		fa.`status`,
		CASE (fa.`status`)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 10 THEN 'Pre-Tender'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		
		fa.`client_status`,
		CASE (fa.`client_status`)
			WHEN 0 THEN 'Pending Client Approval'
			WHEN 1 THEN 'Agreement Seen'
			WHEN 2 THEN 'Approved by Client'
			WHEN 3 THEN 'Awaiting Approval'
		END `client_status_text`,
		CONCAT('FQ', LPAD(fa.id_fq_account, 5, '0')) as `fq_number`,
		
		

		fa.`admin_status`,

		fa.`lead_email`, fa.`lead_name`, fa.`lead_phone`, fa.`lead_mobile`, fa.`lead_state`, fa.`lead_postcode`, 
		fa.`lead_make`, fa.`lead_model`, fa.`details`, fa.`admin_details`, fa.`admin_to_qs_details`,

		fa.`created_at`, fa.`last_updated`, 
		fa.`landing_page_url`, fa.`landing_date_time`, 
		fa.`finance`,
		ul.`name` AS `cq_staff`,
	
		
		fa.`lead_email` as `ti_email`, fa.`lead_phone` as `ti_phone`, fa.`lead_mobile` as `ti_mobile`,
		IF (fa.`lead_email` <> '', (SELECT COUNT(1) FROM tradeins WHERE lead_email = `ti_email` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_email_check`,
		IF (fa.`lead_phone` <> '', (SELECT COUNT(1) FROM tradeins WHERE lead_phone = `ti_phone` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_phone_check`,
		IF (fa.`lead_mobile` <> '', (SELECT COUNT(1) FROM tradeins WHERE lead_phone = `ti_mobile` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_mobile_check`,
		(SELECT GREATEST(`tradein_email_check`, `tradein_phone_check`, `tradein_mobile_check`) AS `at`) AS `available_trades`,

		qr.`id_quote_request` as `qr_id`,
		(SELECT COUNT(1) FROM `quotes` WHERE `fk_quote_request` = `qr_id` AND deprecated <> 1) AS `quote_count`
		FROM `fq_accounts_new` `fa`
		LEFT JOIN `users` ul ON fa.`fk_user` = ul.`id_user`
		
		LEFT JOIN `quote_requests` qr ON fa.`id_fq_account` = qr.`fk_lead`		
		WHERE fa.`deprecated` <> 1
		AND fa.`status` != 100
		AND (fa.`lead_phone` <> '' OR fa.`lead_mobile` <> '') ".$where."
		
		GROUP BY fa.id_fq_account";
		//ORDER BY ".$order_by." ".$order." ".$limit_query;
		//	return $this->db->query($query)->result_array();
	
		//".$where."
		//) `filtered_leads`";
		return $this->db->query($query)->row_array();
	}	
	
	public function get_lead_sources ()
	{
		$query = "
		SELECT DISTINCT source 
		FROM fq_accounts_new 
		WHERE deprecated <> 1 AND source <> 'LP - ' AND source <> '' 
		ORDER BY source ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	
	public function get_leads ($params, $my_id, $admin_type, $start, $limit) // ADMIN
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$source = isset($params['source']) ? $params['source'] : '';		
		
		/*
		$status = isset($params['status']) ? $params['status'] : '';
		$date_from = isset($params['date_from']) ? $params['date_from'] : '';
		$date_to = isset($params['date_to']) ? $params['date_to'] : '';
		*/

		$where = "";
		if ($cq_number <> "") 
		{
			$where .= " 
			AND (
				CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) = '".$this->db->escape_str($cq_number)."' 
				OR fa.`id_fq_account` = '".$this->db->escape_str($cq_number)."'
			) "; 
		}
		
		if ($current_status <> "")
		{
			if ($current_status==4)
			{
				$where .= " AND fa.`status` IN (4, 5, 6, 7, 8, 9) "; 
			}
			else
			{
				$where .= " AND fa.`status` = '".$this->db->escape_str($current_status)."' "; 
			}
		}
		$where_status = "" ;
		if ($admin_type==2 OR $admin_type==5)
		{
			if ($user_id <> "")
			{
				$where .= " AND fa.`fk_user` = '".$this->db->escape_str($user_id)."' ";
			}
		}
		else
		{
			$where_status = "AND fa.`status` != 100";
			$where .= " AND fa.`fk_user` = ".$my_id;
		}

		if ($name <> "") { $where .= " AND fa.`lead_name` LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.`lead_email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($phone <> "") { $where .= " AND fa.`lead_phone` LIKE '%".$this->db->escape_str($phone)."%' "; }
		
		if ($state <> "") { $where .= " AND fa.`lead_state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND fa.`lead_postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }
		// if ($address <> "") { $where .= " AND fa.`address` LIKE '%".$this->db->escape_str($address)."%' "; }

		if ($make <> "") { $where .= " AND fa.`lead_make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND fa.`lead_model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($source <> "") { $where .= " AND fa.`source` = '".$this->db->escape_str($source)."' "; }

		/*
		if ($status == 1) { $status_date_label = "allocated_date"; }
		else if ($status == 2) { $status_date_label = "attempted_date"; }
		else if ($status == 3) { $status_date_label = "tender_date"; }
		else if ($status == 4) { $status_date_label = "order_date"; }
		else if ($status == 5) { $status_date_label = "approved_date"; }
		else if ($status == 6) { $status_date_label = "delivery_date"; }
		else if ($status == 7) { $status_date_label = "settled_date"; }
		else if ($status == 98) { $status_date_label = "decline_date"; }
		else if ($status == 100) { $status_date_label = "delete_date"; }
		else { $status_date_label = "created_at"; }
		if ($date_from <> "") { $where .= " AND DATE(l.`".$status_date_label."`) >= DATE('".$this->db->escape_str($date_from)."') "; }
		if ($date_to <> "") { $where .= " AND DATE(l.`".$status_date_label."`) <= DATE('".$this->db->escape_str($date_to)."') "; }
		*/

		$filter_column = "";

		if (isset($params['filter_column']))
		{
			if ($params['filter_column'] != "")
			{
				$filter_column = $params['filter_column'];
			}
			else
			{
				$filter_column = "created_at";
			}
		}

		$date_filter_by = isset($params['date_filter_by']) ? $params['date_filter_by'] : "";
		
		if ($date_filter_by != "")
		{
			if ($date_filter_by == 1)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday this week') )."' AND '".date( "Y-m-d",strtotime("sunday this week") )."' )";
			}
			else if ($date_filter_by == 2)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday last week') )."' AND '".date( "Y-m-d",strtotime("sunday last week") )."' )";
			}
			else if ($date_filter_by == 3)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of this month') )."' AND '".date( "Y-m-d",strtotime("last day of this month") )."' )";
			}
			else if ($date_filter_by == 4)
			{
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of last month') )."' AND '".date( "Y-m-d",strtotime("last day of last month") )."' )";
			}
			else if ($date_filter_by == 5)
			{
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d" )."'"; 
			}
			else if ($date_filter_by == 6)
			{
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d",strtotime('yesterday') )."'"; 
			}
			else if ($date_filter_by == 7)
			{
				if (isset($params['filter_date_from']))
				{
					$filter_date_from = date('Y-m-d', strtotime($params['filter_date_from']));
				}
				else
				{
					$filter_date_from = date('Y-m-d');
				}

				if (isset($params['filter_date_to']))
				{
					$filter_date_to = date('Y-m-d', strtotime($params['filter_date_to']));
				}
				else
				{
					$filter_date_to = date('Y-m-d');
				}

				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN '{$filter_date_from}' AND '{$filter_date_to}' ) ";
			}
			else
			{
				$where .= " ";
			}
		}

		if (isset($params['order_by_filter']))
		{
			if ($params['order_by_filter']<>"")
			{
				$order_by = " `fa`.`".$params['order_by_filter']."` ";
			}
			else
			{
				$order_by = " `fa`.`id_fq_account` ";
			}
		}
		else
		{
			$order_by = " `fa`.`id_fq_account` ";
		}

		if (isset($params['order_filter']))
		{
			if ($params['order_by_filter']<>"")
			{		
				$order = " ".$params['order_filter']." ";
			}
			else
			{
				$order = " DESC ";
			}
		}
		else
		{
			$order = " DESC ";
		}
		
		if ($limit == "0")
		{
			$limit_query = "";
		}
		else
		{
			$limit_query = " LIMIT ".$start.", ".$limit;
		}

		$query = "
		SELECT 
		fa.`id_fq_account` AS `lead_id`,
		fa.`id_fq_account`, fa.`fk_user`, fa.`source`,
		CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) AS `cq_number`,
		fa.`status`,
		CASE (fa.`status`)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 10 THEN 'Pre-Tender'
			WHEN 11 THEN 'Ordered'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		
		fa.`client_status`,
		CASE (fa.`client_status`)
			WHEN 0 THEN 'Pending Client Approval'
			WHEN 1 THEN 'Agreement Seen'
			WHEN 2 THEN 'Approved by Client'
			WHEN 3 THEN 'Awaiting Approval'
		END `client_status_text`,
		CONCAT('FQ', LPAD(fa.id_fq_account, 5, '0')) as `fq_number`,

		fa.`admin_status`,

		fa.`lead_email`, fa.`lead_name`, fa.`lead_phone`, fa.`lead_mobile`, fa.`lead_state`, fa.`lead_postcode`, 
		fa.`lead_make`, fa.`lead_model`, fa.`details`, fa.`admin_details`, fa.`admin_to_qs_details`,

		fa.`created_at`, fa.`last_updated`, 
		fa.`landing_page_url`, fa.`landing_date_time`, 
		fa.`finance`,
		ul.`name` AS `cq_staff`,
	
		
		fa.`lead_email` as `ti_email`, fa.`lead_phone` as `ti_phone`, fa.`lead_mobile` as `ti_mobile`,
		IF (fa.`lead_email` <> '', (SELECT COUNT(1) FROM tradeins WHERE lead_email = `ti_email` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_email_check`,
		IF (fa.`lead_phone` <> '', (SELECT COUNT(1) FROM tradeins WHERE lead_phone = `ti_phone` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_phone_check`,
		IF (fa.`lead_mobile` <> '', (SELECT COUNT(1) FROM tradeins WHERE lead_phone = `ti_mobile` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_mobile_check`,
		(SELECT GREATEST(`tradein_email_check`, `tradein_phone_check`, `tradein_mobile_check`) AS `at`) AS `available_trades`,

		qr.`id_quote_request` as `qr_id`,
		(SELECT COUNT(1) FROM `quotes` WHERE `fk_quote_request` = `qr_id` AND deprecated <> 1) AS `quote_count`
		FROM `fq_accounts_new` `fa`
		LEFT JOIN `users` ul ON fa.`fk_user` = ul.`id_user`
		
		LEFT JOIN `quote_requests` qr ON fa.`id_fq_account` = qr.`fk_lead`		
		WHERE fa.`deprecated` <> 1
		".$where_status."
		AND (fa.`lead_phone` <> '' OR fa.`lead_mobile` <> '') ".$where."
		
		GROUP BY fa.id_fq_account
		ORDER BY ".$order_by." ".$order." ".$limit_query;
		return $this->db->query($query)->result_array();
	}
    
    function record_count(){
        $this->db->select('qu.quote_file, qr.rb_data, rb.name AS car_name, rb.price AS car_price');
		$this->db->from('quotes qu');
		$this->db->join('quote_requests qr', 'qr.id_quote_request = qu.fk_quote_request');
		$this->db->join('fq_accounts_new fa', 'fa.id_fq_account = qr.fk_lead');
		$this->db->join('rb_data rb', 'rb.car_id = qr.rb_data');
        $this->db->where('fa.deprecated', 0);
        return $this->db->count_all_results();
    }
	
    function get_historical_quotes($limit, $start){
        $this->db->select('qu.quote_file, qr.rb_data, rb.name AS car_name, rb.price AS car_price');
		$this->db->from('quotes qu');
		$this->db->join('quote_requests qr', 'qr.id_quote_request = qu.fk_quote_request');
		$this->db->join('fq_accounts_new fa', 'fa.id_fq_account = qr.fk_lead');
		$this->db->join('rb_data rb', 'rb.car_id = qr.rb_data');
        $this->db->where('fa.deprecated', 0);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
        /*if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }*/
        return false;
    }
    
	public function get_leads_count ($params, $my_id, $admin_type) // ADMIN
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$source = isset($params['source']) ? $params['source'] : '';

		$date_filter_by = isset($params['date_filter_by']) ? $params['date_filter_by'] : "";
		
		/*
		$status = isset($params['status']) ? $params['status'] : '';
		$date_from = isset($params['date_from']) ? $params['date_from'] : '';
		$date_to = isset($params['date_to']) ? $params['date_to'] : '';
		*/

		$where = "";
		if ($cq_number <> "") { $where .= " AND CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) = '".$this->db->escape_str($cq_number)."' "; }
		if ($current_status <> "")
		{
			if ($current_status==4)
			{
				$where .= " AND fa.`status` IN (4, 5, 6, 7, 8, 9) "; 
			}
			else
			{
				$where .= " AND fa.`status` = '".$this->db->escape_str($current_status)."' "; 
			}			
		}
		if ($admin_type==2 OR $admin_type==5)
		{
			if ($user_id <> "")
			{
				$where .= " AND fa.`fk_user` = '".$this->db->escape_str($user_id)."' ";
			}
		}
		else
		{
			$where .= " AND fa.`fk_user` = ".$my_id;
		}

		if ($name <> "") { $where .= " AND fa.`lead_name` LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.`lead_email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($phone <> "") { $where .= " AND fa.`lead_phone` LIKE '%".$this->db->escape_str($phone)."%' "; }
		
		if ($state <> "") { $where .= " AND fa.`lead_state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND fa.`lead_postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }
		// if ($address <> "") { $where .= " AND fa.`address` LIKE '%".$this->db->escape_str($address)."%' "; }

		if ($make <> "") { $where .= " AND fa.`lead_make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND fa.`lead_model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($source <> "") { $where .= " AND fa.`source` = '".$this->db->escape_str($source)."' "; }

		/*
		if ($status == 1) { $status_date_label = "allocated_date"; }
		else if ($status == 2) { $status_date_label = "attempted_date"; }
		else if ($status == 3) { $status_date_label = "tender_date"; }
		else if ($status == 4) { $status_date_label = "order_date"; }
		else if ($status == 5) { $status_date_label = "approved_date"; }
		else if ($status == 6) { $status_date_label = "delivery_date"; }
		else if ($status == 7) { $status_date_label = "settled_date"; }		
		else if ($status == 98) { $status_date_label = "decline_date"; }
		else if ($status == 100) { $status_date_label = "delete_date"; }
		else { $status_date_label = "created_at"; }
		if ($date_from <> "") { $where .= " AND DATE(l.`".$status_date_label."`) >= DATE('".$this->db->escape_str($date_from)."') "; }
		if ($date_to <> "") { $where .= " AND DATE(l.`".$status_date_label."`) <= DATE('".$this->db->escape_str($date_to)."') "; }
		*/

		$filter_column = "";

		if( isset($params['filter_column']) )
		{
			if($params['filter_column'] != "")
				$filter_column = $params['filter_column'];
			else
				$filter_column = "created_at";
		}

		if($date_filter_by != "")
		{
			if($date_filter_by == 1)
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday this week') )."' AND '".date( "Y-m-d",strtotime("sunday this week") )."' )";
			elseif($date_filter_by == 2)
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday last week') )."' AND '".date( "Y-m-d",strtotime("sunday last week") )."' )";
			elseif($date_filter_by == 3)
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of this month') )."' AND '".date( "Y-m-d",strtotime("last day of this month") )."' )";
			elseif($date_filter_by == 4)
				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of last month') )."' AND '".date( "Y-m-d",strtotime("last day of last month") )."' )";
			elseif($date_filter_by == 5)
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d" )."'"; 
			elseif($date_filter_by == 6)
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d",strtotime('yesterday') )."'"; 
			elseif($date_filter_by == 7)
			{
				if(isset($params['filter_date_from']))
					$filter_date_from = date('Y-m-d', strtotime($params['filter_date_from']));
				else
					$filter_date_from = date('Y-m-d');

				if(isset($params['filter_date_to']))
					$filter_date_to = date('Y-m-d', strtotime($params['filter_date_to']));
				else
					$filter_date_to = date('Y-m-d');

				$where .= " AND (DATE(`fa`.`{$filter_column}`) BETWEEN '{$filter_date_from}' AND '{$filter_date_to}' ) ";
			}
			else
			{
				$where .= " ";
			}
		}
	
		$query = "SELECT COUNT(1) AS cnt FROM `fq_accounts_new` fa WHERE fa.`deprecated` <> 1  AND (fa.`lead_phone` <> '' OR fa.`lead_mobile` <> '') ".$where."";
		return $this->db->query($query)->row_array();
	}

	public function get_dropdown_data($data_array)
	{
	//	return $data_array; die();
		if($data_array['code'] == 1)
		{
			$make_query = "select * from makes";

			$make_array = $this->db->query($make_query)->result_array();

			return $make_array;
		}
		elseif(isset($data_array['id_make']) && $data_array['code'] == 2)
		{	
			$fk_make = $data_array['id_make'];

			$families_query = "select * from families where fk_make=".$fk_make;

			$families_array = $this->db->query($families_query)->result_array();

			return $families_array;
		}
		elseif(isset($data_array['var_code']) && $data_array['code'] == 3)
		{	
			$code = $data_array['var_code'];

			// $vehicle_query = "select * from vehicles where fk_family=".$fk_model;

			$vehicle_query = "
							SELECT id_vehicle, code, name FROM vehicles
							WHERE deprecated <> 1 AND MD5(CONCAT(fk_family, '-', year)) = '".$code."'
							ORDER BY name ASC";

			$vehicles_array = $this->db->query($vehicle_query)->result_array();

			return $vehicles_array;
		}
		elseif(isset($data_array['id_model']) && $data_array['code'] == 4)
		{	
			$fk_model = $data_array['id_model'];

			$year_query = "SELECT MD5(CONCAT(fk_family, '-', year)) AS `code`, year FROM vehicles WHERE deprecated <> 1 AND fk_family = ".$fk_model." GROUP BY year ORDER BY year DESC";

			$year_array = $this->db->query($year_query)->result_array();

			return $year_array;
		}
		elseif(isset($data_array['id_model']) && $data_array['code'] == 3)
		{
			$id_model = $data_array['id_model'];

			$vehicle_query = "
							SELECT id_vehicle, code, name FROM vehicles
							WHERE deprecated <> 1 AND fk_family = {$id_model}
							ORDER BY name ASC";

			$vehicles_array = $this->db->query($vehicle_query)->result_array();

			return $vehicles_array;
		}

	}

	public function insert_requirements ($id, $file_name, $user, $type, $fk_requirement, $orig_filename, $is_temp,$ext='')
	{
		$req_id = 0;

		$now = date("Y-m-d g:i:s");

		// $req_fq_accounts_data = array(
		// 						'fk_requirement' => $fk_requirement,
		// 						'fk_fq_account'  => $id
		// 							);

		// // $this->db->insert('req_fq_accounts', $req_fq_accounts_data);

		// // $req_id = $this->db->insert_id();

		$select_query = "select * from requirements where id_requirement={$fk_requirement}";

		$sel_res = $this->db->query($select_query)->row_array();

		$type_file = str_replace(' ', '', $sel_res['name']);

		$type_file = str_replace("'", '', $type_file);
		
		$file_name = $type_file . "_" . time() . "_" . $user . ".".$ext;
		
		$file_data = array(
				'file_name'      => $file_name,
				'fk_account'     => $id,
				'fk_requirement' => $fk_requirement,
				'fk_user'        => $user,
				'created_at'     => $now,
				'orig_filename'  => $orig_filename,
				'is_temp'        => $is_temp
					);

		$this->db->insert('requirement_uploads', $file_data);

		return $file_name;
	}

	public function update_requirement_filename($data)
	{
		$this->db->where('id_req_up', $data['id']);

		$update_data = [
			'orig_filename' => trim($data['filename'])
		];

		$this->db->update('requirement_uploads', $update_data);
	}

	public function hide_permanent_requirement($data)
	{
		$insert_data = [
			'fk_requirement' => $data['id_req'],
			'fk_fq_account' => $data['fapplication_id']
		];

		$this->db->insert('hidden_requirements', $insert_data);
	}

	public function get_all_hidden_requirements($id_fq_account = 0)
	{
		$id_array = [];

		$query = "select * from hidden_requirements where fk_fq_account={$id_fq_account}";

		$result = $this->db->query($query)->result_array();

		foreach ($result as $r_key => $r_val) 
		{
			$id_array[] = $r_val['fk_requirement'];
		}

		return $id_array;
	}

	public function insert_global_requirements($file_name, $user)
	{
		$return_array = [];

		$type_array = ['.jpg','.png','.jpeg','.gif','.pdf','.doc','.docx','.xls','.xlsx','.pdf'];

		foreach ($type_array as $key => $value) 
		{
			if(strpos($file_name, $value)!==false)
			{	
				$file_name = str_replace($value, '', $file_name);
				break;
			}
		}

		$req_id = 0;

		$orig_filename = $file_name;

		$now = date("Y-m-d H:i:s");
		$date_file = date("Y-m-d_H:i:s");

		$date_file = str_replace(":", "-", $date_file);
		
		$file_name = $file_name . "_" . $date_file . ".pdf";

		$file_data = array(
				'file_name'      => $file_name,
				'fk_account'     => "0",
				'fk_requirement' => "0",
				'fk_user'        => $user,
				'created_at'     => $now,
				'orig_filename'  => $orig_filename,
				'is_temp'        => "0"
					);

		$this->db->insert('requirement_uploads', $file_data);

		$req_id = $this->db->insert_id();

		$return_array = [
			"id_req"    => $req_id,
			"file_name" => $file_name
		];

		return $return_array;
	}

	public function get_requirements_class($id, $fk_requirement, $is_temp = 0)
	{
		if($is_temp == 0)
		{
			$query = "select
						*
						from requirement_uploads
						where fk_account = {$id} and fk_requirement = {$fk_requirement};";
		}
		else
		{
			$query = "select
						*
						from requirement_uploads
						where fk_account = {$id} and fk_requirement = {$fk_requirement} and is_temp = 1;";
		}

		$result = $this->db->query($query)->num_rows();

		return $result;
	}

	public function get_requirements_dom($id, $type = 0)
	{
		if($type != 0)
		{
			$query = "select
					r.name as `name`, `r`.`id_requirement` as `id_requirement`, ra.`id_req_fq_account` as `id_req_fq_account`
					from req_fq_accounts ra
					join requirements r on ra.`fk_requirement` = r.`id_requirement`
					where ra.fk_fq_account = {$id} and type = {$type};";
		}
		else
		{	
			$query = "select 
					name, id_requirement
					from requirements 
					where id_requirement not in (select fk_requirement from req_fq_accounts where `fk_fq_account` = {$id});";
		}
		
		return $this->db->query($query)->result_array();
	}

	public function insert_requirement_details($params)
	{
		$sel_query = "select `order` from requirements order by `order` desc limit 1";

		$result = $this->db->query($sel_query)->row_array();

		$data = [
			'name'        => $params['short_name'],
			'description' => $params['full_name'],
			'order'       => (string)((int)$result['order'] + 1)
		];

		$this->db->insert('requirements', $data);
			
		return $this->db->insert_id();
	}

	public function edit_requirement_details($params)
	{
		$value  = $params['value'];
		$field  = $params['field'];
		$req_id = $params['req_id'];

		$data = [
			$field => $value
		];

		$this->db->where('id_requirement', $req_id);

		if($this->db->update('requirements', $data))
			return TRUE;
		else
			return FALSE;
	}

	public function delete_requirement_details($params)
	{
		$req_id = $params['req_id'];

		$data = [
			'deprecated' => 1
		];

		$this->db->where('id_requirement', $req_id);

		if($this->db->update('requirements', $data))
			return TRUE;
		else
			return FALSE;
	}

	public function get_requirements_new()
	{
		$query = "select * from requirements where deprecated = 0 order by `order` asc";

		return $this->db->query($query)->result_array();
	}

	public function get_temp_requirements($id, $type)
	{
		$query = "select fk_requirement from req_fq_accounts where fk_fq_account={$id} and type={$type}";

		return $this->db->query($query)->result_array();
	}

	public function get_specific_requirements ($id, $requirement_type, $is_temp = 0)
	{
		$query = "select * from requirement_uploads where fk_account = {$id} and fk_requirement = {$requirement_type} and is_temp = {$is_temp} order by id_req_up;";					
		return $this->db->query($query)->result_array();
	}

	public function get_requirement_name ($id_requirement)
	{
		$query = "select * from requirements where id_requirement = {$id_requirement}";

		return $this->db->query($query)->row_array();
	}

	public function get_global_requirements()
	{
		$query = "select * from requirement_uploads where fk_account = 0;";

		return $this->db->query($query)->result_array();
	}

	public function get_spec_req($id)
	{
		$query = "select * from requirement_uploads where id_req_up = {$id};";

		return $this->db->query($query)->row_array();
	}

	public function get_all_requirements ($id)
	{
		$query = "select * from requirement_uploads where fk_account={$id} || fk_account = 0 order by orig_filename asc;";

		return $this->db->query($query)->result_array();
	}

	public function get_all_final_requirements($id)
	{
		$query = "select * from requirement_uploads where is_merged = 1 and fk_account={$id} order by orig_filename asc;";

		return $this->db->query($query)->result_array();
	}

	public function delete_requirements($params)
	{
		$return_array = [];

		$this->load->helper('file');

		$idrequp  = $params['id_req'];
		
		$abspath    = "./uploads/cq_requirements/".$params['abspath'];

		$delete_file_q = "delete from requirement_uploads where id_req_up={$idrequp}";

		if($this->db->query($delete_file_q))
		{
			$sel_query = "select * from requirement_uploads where fk_requirement={$params['fk_requirement']} and fk_user={$params['fk_user']}";

			$return_array['count'] = $this->db->query($sel_query)->num_rows();

			if(unlink($abspath))
				$return_array['status'] = 1;
			else
				$return_array['status'] = 0;
		}

		return $return_array;
	}

	public function delete_global_requirements($params)
	{
		$this->load->helper('file');

		$idrequp  = $params['id_req'];
		
		$abspath    = "./uploads/cq_requirements/".$params['abspath'];

		$delete_file_q = "delete from requirement_uploads where id_req_up={$idrequp}";

		if($this->db->query($delete_file_q))
			unlink($abspath);
	}

	public function del_new_req($data)
	{
		$fk_requirement = $data['req'];
		$fk_account     = $data['fapplication_id'];
		$is_temp        = $data['is_temp'];
		$id_req         = $data['id_req'];

		$delete_req_panel_q = "delete from req_fq_accounts where id_req_fq_account=".$id_req;
		$delete_db_file     = "delete from requirement_uploads where fk_account={$fk_account} and fk_requirement = {$fk_requirement} and is_temp={$is_temp}";
		$select_files       = "select * from requirement_uploads where fk_account={$fk_account} and fk_requirement = {$fk_requirement} and is_temp={$is_temp}";

		$results = $this->db->query($select_files)->result_array();

		$count = $this->db->query($select_files)->num_rows();

		if($this->db->query($delete_req_panel_q))
		{
			if($this->db->query($delete_db_file))
			{
				if($count > 0)
				{
					foreach ($results as $key => $val) 
					{
						$abspath = "";
						$abspath = "./uploads/cq_requirements/".$val['file_name'];

						unlink($abspath);
					}
				}

				return "success";
			}
			else
				return "fail";
		}
		else
			return "fail";
	}

	public function merge_files($data_array)
	{
		$pdf = new PDFMerger;

		// echo "<pre>";
		// print_r($data_array); die();

		$directory       = './uploads/cq_requirements/';
		$req_type        = str_replace(" ", "_", $this->db->get_where('requirements', array('id_requirement'=>$data_array['req_type_id']))->row_array());
		$final_file_name = "";
		$merged_count    = 1;
		$now             = date("Y-m-d g:i:s");

		$merged_count_query = "select
								 *
								from req_fq_accounts rf
								join file_attachments fa on rf.id_req_fq_account = fa.fk_main
								where rf.fk_requirement = {$data_array['req_type_id']} and rf.fk_fq_account = {$data_array['fq_acct_id']} and fa.file_name like '%MERGED%';";

		$merged_count_result = $this->db->query($merged_count_query)->num_rows();

		$merged_count = (String)($merged_count + $merged_count_result);

		foreach ($data_array['id_array'] as $dat_key => $dat_val) 
		{
			$file_loc = "";

			$file_id = $dat_val;

			$file_query = "select file_name, fk_main from file_attachments where fk_main={$file_id} and type=4";

			$data = $this->db->query($file_query)->row_array();

			$file_loc = $directory . $data['file_name'];

			$pdf->addPDF($file_loc, 'all');
		}

		$final_file_name = $req_type['name'] . "_" . $data_array['fq_acct_id'] . "_" . "MERGED" . "_" . $merged_count . ".pdf";

		$req_fq_accounts_data = array(
								'fk_requirement' => $data_array['req_type_id'],
								'fk_fq_account'  => $data_array['fq_acct_id']
									);

		$this->db->insert('req_fq_accounts', $req_fq_accounts_data);

		$req_id = $this->db->insert_id();

		$file_data = array(
				'file_name'  => $final_file_name,
				'fk_main'    => $req_id,
				'fk_user'    => $data_array['req_user'],
				'type'       => 4,
				'created_at' => $now
					);

		$this->db->insert('file_attachments', $file_data);

		$pdf->merge('file',$directory . $final_file_name);
		
		$return_array = array(
						'file_name'     => $final_file_name,
						'absolute_path' => $directory . $final_file_name
							);

		return json_encode($return_array);
	}

	public function merge_all_files($data_array)
	{
		$pdf = new PDFMerger;

		$user_id = $this->session->userdata('user_id');

		$directory       = './uploads/cq_requirements/';
		$final_file_name = "";
		$merged_count    = 1;
		$now             = date("Y-m-d g:i:s");

		foreach ($data_array['name_arr'] as $dat_key => $dat_val) 
		{
			$file_loc = "";
			$pages    = "";

			$file_loc = $directory . $data_array['name_arr'][$dat_key];
			$pages    = $data_array['pages_arr'][$dat_key];

			$pdf->addPDF($file_loc, $pages);
		}

		$final_file_name = "requirements_" . $user_id ."_". time() . ".pdf";

		$pdf->merge('file',$directory . $final_file_name);

		if(file_exists($directory . $final_file_name) > 0)
		{
			$file_data = array(
					'file_name'      => $final_file_name,
					'fk_account'     => $data_array['fq_acct_id'],
					'fk_user'        => $user_id,
					'fk_requirement' => 00,
					'is_merged'      => 1,
					'is_temp'        => 0,
					'created_at'     => $now
						);

			$this->db->insert('requirement_uploads', $file_data);

			return "success";
		}
		else
		{
			return "fail";
		}
	}

	public function insert_note($data_array)
	{
		$type    = 1;
		$fk_main = $data_array['fa_acct_id'];
		$fk_user = $this->session->userdata('user_id');
		$note    = $data_array['note'];

		$data = array(
				'note'    => $note
					);

		$this->db->where('id_fq_account', $fk_main);

		return $this->db->update('fq_accounts_new', $data);
	}

	public function get_all_notes($data_array)
	{
		$type = 1;
		$fk_main = $data_array['fa_acct_id'];
		$fk_user = $this->session->userdata('user_id');

		$query = "select * from notes where fk_main={$fk_main} and fk_user={$fk_user} and type={$type} order by created_at desc limit 20";

		return $this->db->query($query)->result_array();
	}

	public function get_note($id)
	{
		$query = "select note from fq_accounts_new where id_fq_account=".$id.";";

		$note_arr = $this->db->query($query)->row_array();

		return $note_arr['note'];
	}

	public function view_note($data_array)
	{
		$id = $data_array['note_id'];

		$query = "select * from notes where id={$id}";

		return $this->db->query($query)->row_array();
	}

	public function note_checker($id)
	{
		$query = "select note from fq_accounts_new where id_fq_account=".$id.";";

		$note_arr = $this->db->query($query)->row_array();

		if($note_arr['note'] != "" OR $note_arr['note'] != NULL)
			return FALSE;
		else
			return TRUE;
	}

	public function delete_panel($data_array)
	{
		$table     = $data_array['table'];
		$id        = $data_array['panel_id'];
		// $parent_id = $data_array['parent_id'];

		$query = "delete from {$table} where id={$id}";

		return $this->db->query($query);
	}

	public function delete_panel_3rd($data_array)
	{
		$table     = $data_array['table'];
		$id        = $data_array['panel_id'];
		$parent_id = $data_array['parent_id'];
		$fk_parent = $data_array['fk_parent'];

		$query = "delete from {$table} where id={$id} and {$fk_parent}={$parent_id}";

		return $this->db->query($query);
	}

	public function delete_applicant($data_array)
	{
		$id        = $data_array['panel_id'];
		$parent_id = $data_array['fapplication_id'];

		$table_array = array('fq_app_address','fq_app_employer','fq_credit_card','fq_other_loans','fq_credit_reference','fq_property_assets','fq_vehicle_asset','fq_other_asset');

		$primary_delete_query = "delete from fq_applicants where id={$id} and fk_accounts={$parent_id}";

		if($this->db->query($primary_delete_query))
		{
			foreach ($table_array as $tbl_key => $tbl_val) 
			{
				$delete_query = "";

				$delete_query = "delete from {$tbl_val} where fk_applicant={$id}";

				$this->db->query($delete_query);
			}
		}
	}

	public function check_req_panel($data)
	{
		$query = "select * from req_fq_accounts where fk_requirement={$data['req_id']} and fk_fq_account={$data['fapplication_id']}";

		return $this->db->query($query)->num_rows();
	}

	public function add_new_req($data)
	{
		$insert_data['fk_fq_account']  = $data['fapplication_id'];
		$insert_data['fk_requirement'] = $data['req_id'];
		$insert_data['type']           = $data['type'];

		$this->db->insert('req_fq_accounts', $insert_data);

		return $this->db->insert_id();
	}

	public function get_all_fq_staff()
	{
		$query = "select * from users where fq_sales = 1;";

		return $this->db->query($query)->result_array();
	}

	public function create_new_calendar_item($data_array)
	{
//echo json_encode($data_array); die();
		$data = [
			'lead_name'  => trim($data_array['lead_first_name'] . " " . $data_array['lead_last_name']),
			'lead_email' => $data_array['lead_email'],
			'lead_phone' => $data_array['lead_phone'],
			'lead_state' => $data_array['lead_state'],
			'source'     => $data_array['client_source'],
			'lead_state' => $data_array['lead_state'],
			'fk_user'    => $data_array['user'],
			'landing_page_url'  => isset($data_array['landing_page_url'])?$data_array['landing_page_url']:"",
			'landing_date_time' => isset($data_array['landing_date_time'])?$data_array['landing_date_time']:"",
		];

		$data['source'] = "ElQuoto";
		$data['status'] = 1;
		//echo json_encode($data); die();
		$this->db->insert('fq_accounts_new', $data);

		$insert_id = $this->db->insert_id();

		if( trim($data_array['lead_first_name']) != "" || trim($data_array['lead_last_name']) != "" )
		{
			/*$applicant_arr = [
				'fk_accounts'     => $insert_id,
				'first_name'      => trim($data_array['lead_first_name']),
				'last_name'       => trim($data_array['lead_last_name']),
				'mobile'          => $data_array['lead_phone'],
				'other_telephone' => $data_array['lead_mobile'],
				'email'           => $data_array['lead_email'],
			];
			echo 'asd';exit;
			$this->db->insert('fq_applicants', $applicant_arr);*/
		}

		return $insert_id;
	}

	public function submit_to_admin($params)
	{
		$query = "update fq_accounts_new set submitted_to_admin=1, fk_admin=272, assignment_date='0000-00-00 00:00:00', assignment_date_end='0000-00-00 00:00:00' where id_fq_account = {$params['id_fq_account']}";

		if( $this->db->query($query) )
			return TRUE;
		else
			return FALSE;
	}

	public function allocate_temp_lead($data)
	{
		$lead_id = ( trim($data['lead_id'] != "") ) ? $data['lead_id'] : "";

		if($lead_id != "")
		{
			$query = "select * from leads where id_lead = {$lead_id}";

			$lead_res = $this->db->query($query)->row_array();

			if($lead_res['fk_user'] == 0 && $lead_res['fk_temp_user'] == 0)
			{
				$update_data = [
					'fk_temp_user' => $data['user_id']
				];

				$this->db->where('id_lead', $lead_id);

				$this->db->update('leads', $update_data);
			}
		}
	}

	public function deallocate_temp_lead($data)
	{
		$lead_id = ( trim($data['lead_id'] != "") ) ? $data['lead_id'] : "";

		if($lead_id != "")
		{
			$query = "select * from leads where id_lead = {$lead_id}";

			$lead_res = $this->db->query($query)->row_array();

			$update_data = [
				'fk_temp_user' => 0
			];

			if($lead_res['fk_temp_user'] == $data['user_id'])
			{
				$this->db->where('id_lead', $lead_id);

				$this->db->update('leads', $update_data);
			}
		}
	}

	public function assign_cqo_staff($data)
	{
		$this->db->where('id_lead', $data['lead_id']);

		$update_data = [
			'fk_user' => $data['assigned_id']
		];

		$this->db->update('leads', $update_data);
	}

	public function get_cqo_staff($id_user)
	{
		$final_array = [];

		$query = "select * from users where cq_sales = 1 and status = 1;";

		$query_2 = "select * from users where id_user = {$id_user}";

		$first_result = $this->db->query($query_2)->result_array();

		$second_result = $this->db->query($query)->result_array();

		foreach ($first_result as $first_key => $first_val) 
		{
			$final_array[] = $first_val;
		}

		foreach ($second_result as $sec_key => $sec_val) 
		{
			$final_array[] = $sec_val;
		}

		return $final_array;
	}

	public function verify_assigned_lead($lead_id, $user_id)
	{
		if($lead_id == "" || $lead_id == "0")
			return FALSE;

		$query = "select fk_user, fk_temp_user from leads where id_lead = {$lead_id}";

		$result = $this->db->query($query)->row_array();

		// echo $user_id; echo "<br>"; echo $result['fk_temp_user']; die();

		if($result['fk_temp_user'] == $user_id || $result['fk_user'] == $user_id)
			return TRUE;

		if($result['fk_user'] == "0" && $result['fk_temp_user'] == "0")
			return TRUE;
		
		return FALSE;
	}

	public function diarize($id, $date, $status='')
	{
		$temp_1 = date("Y-m-d", strtotime($date));

		$temp_2 = date("H:i:s", strtotime($date) + 60*30);

		$end = $temp_1 . " " . $temp_2;

		/* alarm status */
		if($status != '') {
			$alarm_status = $status;
		}
		else {
			$alarm_status = '';
		}
		/* alarm status */

		$data = [
			'assignment_date'     => $date,
			'assignment_date_end' => $end,
			'alarm_status' => $alarm_status
		];

		/*echo "<pre>";
		print_r($data);
		die();*/

		$this->db->where('id_fq_account', $id);
		// $this->db->update('fq_accounts_new', $data);
		if($this->db->update('fq_accounts_new', $data))
			return TRUE;
		else
			return FALSE;
	}

	public function get_hover_data($id)
	{
		$query_1 = "select dealer as `dealer`, supplier_contact as `dealer_contact`, supplier_email as `dealer_email`, supplier_mobile as `dealer_mobile`,
					supplier_landline as `dealer_landline`, delivery_date from fq_accounts_new where id_fq_account = {$id}";

		$query_2 = "select mobile as `primary_number`, other_telephone as `other_number`, email as `client_email` from fq_applicants where fk_accounts = {$id} limit 1";

		$response_1 = $this->db->query($query_1)->row_array();
		$response_2 = $this->db->query($query_2)->row_array();

		$return_data = [
			'dealer'          => ($response_1['dealer'] == null) ? "" : $response_1['dealer'],
			'dealer_contact'  => ($response_1['dealer_contact'] == null) ? "" : $response_1['dealer_contact'],
			'dealer_email'    => ($response_1['dealer_email'] == null) ? "" : $response_1['dealer_email'],
			'dealer_mobile'   => ($response_1['dealer_mobile'] == null) ? "" : $response_1['dealer_mobile'],
			'dealer_landline' => ($response_1['dealer_landline'] == null) ? "" : $response_1['dealer_landline'],
			'delivery_date'   => ($response_1['delivery_date'] == null) ? "" : $response_1['delivery_date'],
			'primary_number'  => isset($response_2['primary_number']) ? $response_2['primary_number'] : "",
			'other_number'    => isset($response_2['other_number']) ? $response_2['other_number'] : "",
			'client_email'    => isset($response_2['client_email']) ? $response_2['client_email'] : ""
		];

		return $return_data;
	}

	public function get_tax_invoice_details($id)
	{
		$query = "select * from fq_accounts_new where id_fq_account = {$id}";

		return $this->db->query($query)->row_array();
	}

	public function get_first_address($fq_id)
	{
		$first_query = "select id from fq_applicants where fk_accounts = {$fq_id} limit 1";

		$first_result = $this->db->query($first_query)->row_array();

		if(count($first_result) > 0)
		{
			$second_query = "select * from fq_app_address where fk_applicant = {$first_result['id']} limit 1";

			return $this->db->query($second_query)->row_array();
		}

		return array();
	}

	public function get_all_dealers()
	{
		$query = "SELECT 
		u.id_user AS `user_id`,
		u.id_user,u.username, u.name, u.abn, u.state, u.postcode, u.address, 
		u.phone, u.mobile, u.description, u.deprecated, u.created_at,
		da.dealership_name, da.dealership_brand
		FROM users u JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND u.type = 1 AND u.deprecated <> 1 AND u.`status` = 1 order by da.dealership_name asc";

		return $this->db->query($query)->result_array();
	}

	public function get_dealer_fields($id)
	{
		$query = "SELECT 
		u.id_user AS `user_id`,
		u.id_user,u.username, u.name, u.abn, u.state, u.postcode, u.address, 
		u.phone, u.mobile, u.description, u.deprecated, u.created_at,
		da.dealership_name, da.dealership_brand
		FROM users u JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE u.id_user = {$id}";

		return $this->db->query($query)->row_array();
	}

	public function get_email_templates ($fk_user)
	{
		$query = "SELECT * FROM fq_email_templates WHERE (`global_flag` = 1 OR ( `fk_user` = '{$fk_user}' AND `global_flag` = 0 )) and deprecated != 1
				ORDER BY id_email_template ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
    
    public function get_system_email_templates ($fk_user)
	{
		$query = "SELECT * FROM system_email_templates WHERE (`global_flag` = 1 OR ( `fk_user` = '{$fk_user}' AND `global_flag` = 0 )) and deprecated != 1
				ORDER BY id_email_template ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_email_trail ($fq_id)
	{
		$query = "select ft.id as `id_trail`, u.name as `sender_name`, u.email as `sender_email`,ft.sent_to as `sent_to`, ft.subject as `subject`, ft.attachment as `attachment`, ft.attachment_url as `attachment_url`, ft.created_at as `created_at`, ft.forwarded as `forwarded`
from fq_email_trail ft join `users` u on ft.fk_user = u.id_user where ft.fk_account = {$fq_id} ORDER BY ft.id desc;";
	
		return $this->db->query($query)->result_array();
	}

	public function get_email_trail_body($id)
	{
		$query = "select ft.id as `id_trail`, u.name as `sender_name`, u.email as `sender_email`,ft.sent_to as `sent_to`, ft.subject as `subject`, ft.attachment as `attachment`, ft.created_at as `created_at`, ft.message as `body`
from fq_email_trail ft
join `users` u on ft.fk_user = u.id_user where ft.id = {$id}; ";

		return $this->db->query($query)->row_array();
	}

	public function get_email_body($id)
	{
		$query = "select message from fq_email_trail where id={$id}";

		return $this->db->query($query)->row_array();
	}

	public function get_email_template ($email_template_id)
	{
		$query = "SELECT * FROM fq_email_templates WHERE id_email_template = ".$email_template_id;
		return $this->db->query($query)->row_array();
	}
    
    public function get_system_email_template ($email_template_id)
	{
		$query = "SELECT * FROM system_email_templates WHERE id_email_template = ".$email_template_id;
		return $this->db->query($query)->row_array();
	}

	public function get_sent_email($id)
	{
		$query = "SELECT * FROM fq_email_trail WHERE id = ".$id;
		return $this->db->query($query)->row_array();
	}

	public function get_all_requirements_attachments($fk_account, $fk_user)
	{
		$query = "select * from requirement_uploads where (fk_account = {$fk_account}) OR (fk_account = 0);";

		return $this->db->query($query)->result_array();
	}

	public function insert_email_template ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$input_arr['email_content'] = str_replace("%26", "&amp;", $input_arr['email_content']);
		$query = "
		INSERT INTO fq_email_templates (description, subject, content, attachment, created_at, fk_user, global_flag,recipients) VALUES
		(
			'".$this->db->escape_str($input_arr['email_description'])."',
			'".$this->db->escape_str($input_arr['email_subject'])."',
			'".$this->db->escape_str($input_arr['email_content'])."',
			'".$this->db->escape_str($input_arr['attachment'])."',
			'".$now."',
			'".$this->db->escape_str($input_arr['fk_user'])."',
			'".$this->db->escape_str($input_arr['visibility'])."',
			'".$this->db->escape_str($input_arr['new_email_recipient'])."'
		)";
		
		$this->db->query($query);		
	}

	public function validate_order($id)
	{
		$order_string = "";

		$query = "select * from req_order where fk_account = {$id} limit 1;";

		$result = $this->db->query($query)->row_array();

		if(count($result) < 1)
		{
			$query_2 = "select * from requirements where deprecated = 0 order by id_requirement ASC";

			$res_2 = $this->db->query($query_2)->result_array();

			$temp_arr_res2 = [];

			foreach ($res_2 as $res_2_key => $res_2_val) 
			{
				$temp_arr_res2[] = $res_2_val['id_requirement'];
			}

			$order_string = implode(',', $temp_arr_res2);

			$now = date('Y-m-d H:i:s');

			$insert_query = "insert into req_order (`fk_account`, `order_string`, `created_at`) VALUES ('{$id}','{$order_string}', '{$now}')";

			$this->db->query($insert_query);

			$last_query = "select * from req_order where fk_account = {$id} limit 1;";

			$last_result = $result = $this->db->query($last_query)->row_array();

			return $last_result['order_string'];
		}
		else
		{
			return $result['order_string'];
		}
	}

	public function update_order($data)
	{
		$update_data = [];

		foreach ($data['id_array'] as $i_key => $i_value) 
		{
			$temp_array = [];

			$temp_array = [
				'id_requirement' => $i_value,
				'order' => $data['order_array'][$i_key]
			];

			$update_data[] = $temp_array;
		}

		// echo "<pre>";
		// print_r($update_data); die();

		$this->db->update_batch('requirements', $update_data, 'id_requirement');


	}

	public function upload_merged_document_new($data)
	{
		$insert_data = [
			'file_name'      => $data['file_name'],
			'fk_account'     => $data['fq_acct_id'],
			'fk_user'        => $data['user_id'],
			'fk_requirement' => 0,
			'orig_filename'  => $data['file_name'],
			'is_temp'        => 0,
			'is_merged'      => 1,
			'created_at'     => date('Y-m-d H:i:s')
		];

		$this->db->insert('requirement_uploads', $insert_data);
	}

	public function email_audit_trail_model($trail_array)
	{
		$this->db->insert('fq_email_trail', $trail_array);
	}

	public function search_lead($email, $name, $state, $make)
	{
		$where = "";
		if ($make != "") { $where .= " AND l.`make` like '%".$make."%' "; }
		if ($email != "") { $where .= " AND l.`email` like '%".$email."%' "; }
		if ($name != "") { $where .= " AND l.`name` like '%".$name."%' "; }
		if ($state != "") { $where .= " AND l.`state` like '%".$state."%' "; }

		$query = "select 
					l.id_lead, l.email, l.name, l.phone, l.mobile, l.state, l.postcode, l.address, l.make, l.model,
					fa.id_fq_account, u.name as `qm_user`, u2.name as `temp_user`
				from leads l
				left join fq_accounts_new fa on l.id_lead = fa.fk_lead
				left join `users` u on l.fk_user = u.id_user
				left join `users` u2 on l.fk_temp_user = u.id_user
				where 1 AND (fa.id_fq_account is NULL || fa.id_fq_account = 0 || fa.id_fq_account = '') {$where} 
				order by l.`created_at` desc limit 50";

		return $this->db->query($query)->result_array();
	}

	public function get_searched_lead($lead_id)
	{
		$query = "select 
					l.id_lead, l.email, l.name, l.phone, l.mobile, l.state, l.postcode, l.address, l.make, l.model,
					fa.id_fq_account, u.name as `qm_user`, u2.name as `temp_user`
				from leads l
				left join fq_accounts_new fa on l.id_lead = fa.fk_lead
				left join `users` u on l.fk_user = u.id_user
				left join `users` u2 on l.fk_temp_user = u.id_user
				where l.id_lead = {$lead_id};";

		return $this->db->query($query)->row_array();
	}

	public function assign_lead_to_fq($lead_id, $id_fq_account)
	{
		$this->db->where("id_fq_account", $id_fq_account);

		$update_data = [
			'fk_lead' => $lead_id
		];

		$this->db->update("fq_accounts_new", $update_data);

		$select_query = "select lead_name, lead_model, lead_make, lead_state, lead_phone, lead_email from fq_accounts_new where id_fq_account = {$id_fq_account}";

		$result = $this->db->query($select_query)->row_array();

		$lead_query = "select * from leads where id_lead = {$lead_id}";

		$lead_result = $this->db->query($lead_query)->row_array();

		$this->db->where('id_fq_account', $id_fq_account);

		$fq_update_data = [];

		if($result['lead_make'] == "")
			$fq_update_data['lead_make'] = $lead_result['make'];

		if($result['lead_model'] == "")
			$fq_update_data['lead_model'] = $lead_result['model'];

		if($result['lead_email'] == "")
			$fq_update_data['lead_email'] = $lead_result['email'];

		if($result['lead_name'] == "")
			$fq_update_data['lead_name'] = $lead_result['name'];

		if($result['lead_state'] == "")
			$fq_update_data['lead_state'] = $lead_result['state'];

		if($result['lead_phone'] == "")
			$fq_update_data['lead_phone '] = $lead_result['phone'];

		if(count($fq_update_data) > 0)
			$this->db->update("fq_accounts_new", $fq_update_data);
	}

	public function update_status_color($id, $color, $status)
	{
		$query = "select status from fq_accounts_new where id_fq_account = {$id}";

		$result = $this->db->query($query)->row_array();
		
		if($status == 1){
			if($result['status'] == 0)
				$status = 1;

			if($this->validate_applicant_completion($id))
				$status = 2;
		}
		elseif($status==2){
			if($this->validate_applicant_completion($id) && ($result['status'] == 1 || $result['status'] == 0))
				$status = 2;
			else
				$status = $result['status'];
		}
		elseif($status==3){
			$status = 3;
		}
		elseif($status==4){
			$status = 4;
		}
		elseif($status==5){
			$this->update_lead_flag($id);
			$status = 5;
		}
		elseif($status==11){
			$this->update_lead_flag($id);
			$status = 11;
		}
		else{
			$status = $result['status'];
		}

		switch ($status) 
		{
			case '0':
				$color = "#ffffff";
				break;
			case '1':
				$color = "#c0d6f9";
				break;
			case '2':
				$color = "#55b2ed";
				break;
			case '3':
				$color = "#91f2c1";
				break;
			case '4':
				$color = "#1cbc34";
				break;
			case '5':
				$color = "#d8d51c";
				break;
			case '11':
				$color = "#58c603";
				break;	
			case '100':
				$color = "#ffffff";
				break;
			default:
				$color = "#ffffff";
				break;
		}
		
		$this->db->where('id_fq_account', $id);

		$update_data = [
			'color_status' => $color,
			'status'       => $status
		];
		
		$this->db->update('fq_accounts_new', $update_data);
	}

	private function validate_applicant_completion($fq_id)
	{
		$query = "select first_name, last_name, middle_name, mobile, email, date_of_birth, dl_number, dl_exp from fq_applicants where fk_accounts = {$fq_id} order by id asc limit 1;";

		$result = $this->db->query($query)->row_array();

		$flag = 1;

		foreach ($result as $key => $value) 
		{
			if($value == "")
				$flag = 0;
		}

		if($flag == 1)
			return TRUE;
		else
			return FALSE;
	}

	private function update_lead_flag($fq_id)
	{
		$select_query = "select fk_lead from fq_accounts_new where id_fq_account = {$fq_id}";
		$result = $this->db->query($select_query)->row_array();

		if($result['fk_lead'] != 0)
		{
			$lead_id = $result['fk_lead'];

			$this->db->where('id_lead', $lead_id);

			$update_data = [
				'finance_flag' => 1
			];

			$this->db->update('leads', $update_data);
		}
	}

	public function unallocate_lead($lead_id, $user_id)
	{
		$validation_query = "select * from leads where id_lead = {$lead_id}";

		$validation_result = $this->db->query($validation_query)->row_array();

		if($validation_result['fk_user'] == $user_id)
		{
			$this->db->where('id_lead', $lead_id);

			$update_data = [
				'fk_user'      => 0,
				'status'       => 0,
				'fk_temp_user' => 0
			];

			$this->db->update('leads', $update_data);

			return "successful";
		}
		else
		{
			return "fail";
		}
	}

	public function update_email_template($data)
	{
		$this->db->where('id_email_template', $data['email_template_id']);
		$data['email_message'] = str_replace("%26", "&amp;", $data['email_message']);
		$update_data = [
			'content' => $data['email_message'],
			'subject' => $data['email_subject'],
			'recipients' => $data['recipients'],
			'attachment' => $data['attachment'],
		];

		$this->db->update('fq_email_templates', $update_data);
	}
    
    public function update_system_email_template($data)
	{
		$this->db->where('id_email_template', $data['email_template_id']);

		$update_data = [
			'content' => $data['email_content'],
		];

		$this->db->update('system_email_templates', $update_data);
	}

	public function delete_email_template($data)
	{
		$this->db->where('id_email_template', $data['id_email_template']);

		$update_data = [
			'deprecated' => 1
		];

		$this->db->update('fq_email_templates', $update_data);
	}

	public function get_fq_admin_flag($user_id)
	{
		$query = "select fq_admin_flag from users where id_user = {$user_id}";

		$result = $this->db->query($query)->row_array();

		return isset($result['fq_admin_flag']) ? $result['fq_admin_flag'] : "0";
	}

	public function get_lead_note_details($lead_id)
	{
		$query = "select details from leads where id_lead = {$lead_id}";

		$result = $this->db->query($query)->row_array();

		return $result['details'];
	}

	public function update_lead_note_detail($data)
	{
		$this->db->where('id_lead', $data['lead_id']);

		$update_data = [
			'details' => trim($data['note'])
		];

		$this->db->update('leads', $update_data);
	}

	public function get_basic_fapplication_data($id)
	{
		$query = "select * from fq_accounts_new where id_fq_account = {$id}";

		return $this->db->query($query)->row_array();
	}

	public function get_save_state($id)
	{
		$select_query = "select * from fq_save_state where fk_account = {$id}";

		$result = $this->db->query($select_query)->row_array();
		
		if(count($result) > 0)
		{
			return $result;
		}
		else
		{
			$insert_id = $this->insert_new_save_state($id);

			$query_2 = "select * from fq_save_state where id_save_state = {$insert_id}";			

			return $this->db->query($query_2)->row_array();
		}
	}

	public function insert_new_save_state($id)
	{
		$insert_data = [
			'fk_account' => $id
		];

		$this->db->insert("fq_save_state", $insert_data);

		return $this->db->insert_id();
	}

	public function update_save_state($id, $data)
	{
		$this->db->where('fk_account', $id);

		$update_data = [
			'note_state'             => ($data['note_state'] == "true") ? "1" : "0",
			'requirements_tab_state' => ($data['requirements_state'] == "true") ? "1" : "0",
			'application_tab_state'  => ($data['application_state'] == "true") ? "1" : "0",
			'note_1_height'          => $data['note_1_height'],
			'note_2_height'          => $data['note_2_height']
		];

		$this->db->update("fq_save_state", $update_data);
	}

	public function allocate_lead_note($lead_id, $user) //allocate lead to paul triggered by writing a note on a fq lead that's connected to a lead that is not assigned
	{
		if($lead_id != "" && ($user == 259 || $user == 327) )
		{
			$select_query = "select id_lead, fk_temp_user, fk_user, status from leads where id_lead = {$lead_id}";

			$result = $this->db->query($select_query)->row_array();

			if($result['fk_temp_user'] == $user && $result['fk_user'] == 0 && $result['status'] == 0)
			{
				$this->db->where('id_lead', $lead_id);

				$update_data = [
					'fk_user' => $user,
					'status'  => 2
				];

				$this->db->update('leads', $update_data);
			}
		}
	}

	public function get_email_list()
	{
		$select_query = "select * from fq_email_list where deprecated <> 1";

		return $this->db->query($select_query)->result_array();
	}

	public function update_email_list_item($email, $id)
	{
		$this->db->where("id_email_list", $id);

		$update_data = [
			'email' => $email
		];

		$this->db->update("fq_email_list", $update_data);
	}

	public function delete_email_list_item ($id)
	{
		$this->db->where("id_email_list", $id);

		$update_data = [
			'deprecated' => 1
		];

		$this->db->update("fq_email_list", $update_data);
	}

	public function add_email_list_item($email)
	{
		$insert_array = [
			"email" => $email
		];

		$this->db->insert("fq_email_list", $insert_array);
	}
	
	public function get_fq_dealer_data($fq_lead_id=0)
	{
		$select_query = "select * from fq_lead_dealer_data where fq_lead_id = ".$fq_lead_id;
		return $this->db->query($select_query)->row_array();
	}
    
	public function insert_update_fq_dealer_data($insert_array,$fq_lead_id=0)
	{
		$fq_lead_id = ($fq_lead_id != '') ? $fq_lead_id : 0;
		$select_query = "select * from fq_lead_dealer_data where fq_lead_id = ".$fq_lead_id;

		$is_row = $this->db->query($select_query)->row_array();
		if($is_row)
		{
			$this->db->where("fq_lead_id", $fq_lead_id);
			$this->db->update("fq_lead_dealer_data", $insert_array);
		}
		else
		{
			$this->db->insert("fq_lead_dealer_data", $insert_array);
		}
	}
    
    public function get_column_value_by_id($tbl_name,$column_name,$where_id)
    {				
        $this->db->select("*");
        $this->db->from($tbl_name);
        $this->db->where($where_id);		
        $this->db->last_query();
        $query = $this->db->get();
        return $query->row($column_name);
    }
    
    function get_data_row_by_id($tbl_name,$where)
	{
		$this->db->select("*");
		$this->db->from($tbl_name);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}
    
    function get_tradein_valuations($tradein_id){
        $this->db->select('tv.id_trade_valuation,tv.value, u.name, u.state');
        $this->db->from('trade_valuations tv');
        $this->db->join('users u', 'u.id_user = tv.dealer_id');
        $this->db->where('tv.fk_tradein', $tradein_id);
        //$this->db->where_in('lineitems.id',$where_in_ids);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_winner_trade() {
        $this->db->select('tv.id_trade_valuation,tv.value, u.name, u.state, ti.fk_trade_valuation');
        $this->db->from('trade_valuations tv');
        $this->db->join('users u', 'u.id_user = tv.dealer_id');
        $this->db->join('tradeins ti', 'ti.id_tradein = tv.fk_tradein AND tv.id_trade_valuation = ti.fk_trade_valuation');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }

    function get_winning_trade($tradein_id) {
        $this->db->select('tv.id_trade_valuation,tv.value, u.name, u.state, ti.fk_trade_valuation');
        $this->db->from('trade_valuations tv');
        $this->db->join('users u', 'u.id_user = tv.dealer_id');
        $this->db->join('tradein_new ti', 'ti.id_tradein = tv.fk_tradein');
        $this->db->where('ti.id_leads',$tradein_id);
        $query = $this->db->get();
        /*echo $this->db->last_query();
        die();*/
        $res = $query->row_array();
        return $res;
    }
    
    function get_tradein_recipients($tradein_id){
        $this->db->select('u.name, u.state');
        $this->db->from('tradein_recipients tr');
        $this->db->join('users u', 'u.id_user = tr.id_dealer');
        $this->db->where('tr.fk_tradein', $tradein_id);
        //$this->db->where_in('lineitems.id',$where_in_ids);
        $query = $this->db->get();
        return $query->result_array();
    }

    function delivery_details_for_computation($lead_id, $computation)
    {
    	extract($computation);

    	$query_accounts_new = "UPDATE fq_accounts_new SET deposit = '".$deposite."',delivery_date = '".$delivery_date."',delivery_address = '".$delivery_address."', delivery_instructions = '".$delivery_instructions."', special_conditions= '".$special_conditions."' WHERE id_fq_account = ".$lead_id;

    	$this->db->query($query_accounts_new);

    	$query_lead_dealer = "UPDATE fq_lead_dealer_data SET sale_price = '".$sale_price."', delivery_date = '".$delivery_date."' WHERE fq_lead_id = ".$lead_id;

    	$this->db->query($query_lead_dealer);
    	// return $this->db->affected_rows();
    	return true;
    }

    function pdf_refresh($id,$type)
    {
    	if($type == 'both'){

	    	$filenm = 'PurchaseOrder_'.$id.'.pdf';
	    	unlink("uploads/cq_requirements/".$filenm);
	    	$select_query = "DELETE from requirement_uploads where file_name= '".$filenm."' and fk_account = '".$id."'";
				$query = $this->db->query($select_query);

			$filenm = 'Dealer_Purchase_Order'.$id.'.pdf';
			unlink("uploads/cq_requirements/".$filenm);
	    	$select_query = "DELETE from requirement_uploads where file_name= '".$filenm."' and fk_account = '".$id."'";
				$query = $this->db->query($select_query);
    	}
    	if($type == 'client'){

	    	$filenm = 'PurchaseOrder_'.$id.'.pdf';
	    	unlink("uploads/cq_requirements/".$filenm);
	    	$select_query = "DELETE from requirement_uploads where file_name= '".$filenm."' and fk_account = '".$id."'";
				$query = $this->db->query($select_query);
    	}
    	if($type == 'dealer'){
    		
			$filenm = 'Dealer_Purchase_Order'.$id.'.pdf';
			unlink("uploads/cq_requirements/".$filenm);
	    	$select_query = "DELETE from requirement_uploads where file_name= '".$filenm."' and fk_account = '".$id."'";
				$query = $this->db->query($select_query);
    	}

    }

    function get_lead_dealer_data($id_lead)
    {
    	$this->db->select('*');
        $this->db->from('fq_accounts_new');
        $this->db->where('id_fq_account', $id_lead);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_carOnroad($id){		

		$query = ("SELECT on_road From quotes WHERE id_quote = '".$id."' ");
		$sql = $this->db->query($query);
		print_r($sql);
		exit;
		return $sql->result();
	}
	
    
}