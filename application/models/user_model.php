<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_Model extends CI_Model {

	public function get_users ($params) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$type = isset($params['type']) ? $params['type'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND status = '".$this->db->escape_str($status)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }
		if ($type <> "") { $where .= " AND type LIKE '%".$this->db->escape_str($type)."%' "; }

		$query = "
		SELECT 
		CASE (status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		CASE (type)
			WHEN 1 THEN 'Dealer'
			WHEN 2 THEN 'Staff'
			WHEN 3 THEN 'Wholesaler'
		END `type_text`,		
		id_user, status, username, password, name, abn, state, postcode, address, phone, mobile, description, deprecated, created_at
		FROM users WHERE 1 AND deprecated <> 1 ".$where." ORDER BY name ASC";
		return $this->db->query($query)->result_array();
	}
	
	public function get_user ($user_id)
	{
		$query = "SELECT * FROM `users` WHERE `id_user` = '".$this->db->escape_str($user_id)."'";
		return $this->db->query($query)->row_array();
	}

	public function get_staff ($user_id)
	{
		$query = "
		SELECT
		CASE (u.status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		u.id_user, u.status, u.username, u.password, u.name, u.abn, u.state, u.postcode, u.address, u.phone, u.mobile, u.description
		FROM users u WHERE u.id_user = '".$this->db->escape_str($user_id)."'";
		return $this->db->query($query)->row_array();	
	}
	
	public function get_user_id ($email) // ALL
	{
		$query = "SELECT `id_user` FROM `users` WHERE `username` = '".$this->db->escape_str($email)."'";
		return $this->db->query($query)->row_array();
	}
	
	public function getby_email ($email = '')
	{
		$this->db->where( 'username', $email );
		$query = $this->db->get('users');
		if ($query->num_rows() == 1)
		{
			return $query->row();
		}
		else 
		{
			return false;
		}
	}
	
	public function get_userkey ($id, $key)
	{
		$this->db->where('id_user', $id );
		$this->db->where('forget_password_key', $key);
		$query = $this->db->get('users');
		if( $query->num_rows() == 1 )
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
    
    public function register_user ($user_type, $admin_type, $username, $password, $name, $abn, $state, $postcode, $address, $phone, $mobile, $description, $dob, $bank_acct_name, $bank_acct_bsb, $bank_acct_num, $account_holders_name, $dealer_license = "") // ALL
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO `users` (
			type, 
            admin_type,
            status,
            username,
            password,
            name,
            abn,
            address,
            state,
            postcode, 
			phone,
            mobile,
            description,
            dob, 
			bank_acct_name,
            bank_acct_bsb, 
			bank_acct_num,
            account_holders_name, 
			dealer_license,
            created_at
            )
		VALUES (
			'".$this->db->escape_str($user_type)."',
            '".$this->db->escape_str($admin_type)."',
			1,
            '".$this->db->escape_str($username)."',
            '".$this->db->escape_str($password)."',
			'".$this->db->escape_str($name)."',
            '".$this->db->escape_str($abn)."', 
			'".$this->db->escape_str($address)."',
			'".$this->db->escape_str($state)."',
            '".$this->db->escape_str($postcode)."',
			'".$this->db->escape_str($phone)."',
            '".$this->db->escape_str($mobile)."',
			'".$this->db->escape_str($description)."',
            '".$this->db->escape_str($dob)."',
			'".$this->db->escape_str($bank_acct_name)."',
            '".$this->db->escape_str($bank_acct_bsb)."',
			'".$this->db->escape_str($bank_acct_num)."',
            '".$this->db->escape_str($account_holders_name)."',
			'".$this->db->escape_str($dealer_license)."',
            '".$now."')";
		$sql = $this->db->query($query);
	}	
	
	public function register_wholesaler ($user_type, $input_arr, $exceptions_arr)
	{
		$now = date("Y-m-d H:i:s");
		$input_fields_string = "";
		$input_values_string = "";
		foreach ($input_arr AS $field => $value)
		{
			if (!in_array($field, $exceptions_arr))
			{
				$input_fields_string .= $field.", ";
				$input_values_string .= "'".$this->db->escape_str($value)."', ";
			}
		}

		$query = "
		INSERT INTO `users` (`type`, ".$input_fields_string." `created_at`, `last_updated`)
		VALUES (".$user_type.", ".$input_values_string." '".$now."', '".$now."')";
		return $this->db->query($query);
	}

	public function register_dealer ($input_arr) // ALL
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO `users` 
		(
			type, admin_type, status, 
			username, password, 
			name, dealer_license, abn,
			state, postcode, address,
			
			phone, mobile, email,
			
			manager_name, manager_phone, manager_mobile, manager_email,
			account_name, account_phone, account_mobile, account_email,
			dealer_principal_name, dealer_principal_phone, dealer_principal_mobile, dealer_principal_email,

			bank_acct_name, bank_acct_num, bank_acct_bsb,

			description, created_at)
		VALUES 
		(
			1, 0, 1, 
			'".$this->db->escape_str($input_arr['username'])."', MD5('".$this->db->escape_str($input_arr['password'])."'),
			'".$this->db->escape_str($input_arr['manager_name'])."', '".$this->db->escape_str($input_arr['dealer_license'])."', '".$this->db->escape_str($input_arr['abn'])."',
			'".$this->db->escape_str($input_arr['state'])."', '".$this->db->escape_str($input_arr['postcode'])."', '".$this->db->escape_str($input_arr['address'])."',
			
			'".$this->db->escape_str($input_arr['manager_phone'])."', '".$this->db->escape_str($input_arr['manager_mobile'])."', '".$this->db->escape_str($input_arr['manager_email'])."',
			
			'".$this->db->escape_str($input_arr['manager_name'])."', '".$this->db->escape_str($input_arr['manager_phone'])."', '".$this->db->escape_str($input_arr['manager_mobile'])."', '".$this->db->escape_str($input_arr['manager_email'])."',
			'".$this->db->escape_str($input_arr['account_name'])."', '".$this->db->escape_str($input_arr['account_phone'])."', '".$this->db->escape_str($input_arr['account_mobile'])."', '".$this->db->escape_str($input_arr['account_email'])."',
			'".$this->db->escape_str($input_arr['dealer_principal_name'])."', '".$this->db->escape_str($input_arr['dealer_principal_phone'])."', '".$this->db->escape_str($input_arr['dealer_principal_mobile'])."', '".$this->db->escape_str($input_arr['dealer_principal_email'])."',

			'".$this->db->escape_str($input_arr['bank_acct_name'])."', '".$this->db->escape_str($input_arr['bank_acct_num'])."', '".$this->db->escape_str($input_arr['bank_acct_bsb'])."',
			
			'".$this->db->escape_str($input_arr['description'])."', '".$now."'
		)";
		$sql = $this->db->query($query);
	}	
	
	public function register_dealer_attributes ($id_user, $dealership_name, $dealership_brand, $dealership_states)
	{
		if (!isset($dealership_name)) { $dealership_name = ""; }
		if (!isset($dealership_brand)) { $dealership_brand = ""; }
		if (!isset($dealership_states)) { $dealership_states = ""; }
		
		$query = "
		INSERT INTO `dealer_attributes` 
		(
			fk_user, 
			dealership_name, dealership_brand, dealership_states
		)
		VALUES 
		(
			'".$this->db->escape_str($id_user)."', 
			'".$this->db->escape_str($dealership_name)."', 
			'".$this->db->escape_str($dealership_brand)."', 
			'".$this->db->escape_str($dealership_states)."'
		)";
		$sql = $this->db->query($query);
	}	
	
	public function login ($username, $password) // ALL
	{
		
		$query = "SELECT * FROM`users` WHERE `username` = '".$username."' AND `password` = '".md5( $password )."' AND `deprecated` = 0 LIMIT 1";

		if( $this->db->query($query)->num_rows() == 1 )
		{
	
			return $this->db->query($query)->result();

		}
		else
		{
			return false;
		}
	}

	public function check_password ($password, $user_id) // ALL
	{
		$this->db->select('password');
		$this->db->where('id_user', $user_id);
		$this->db->where('password', MD5($password));
		$this->db->where('deprecated', 0);
		$this->db->limit(1);
		$query = $this->db->get('users');
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

    public function check_username_availability ($username, $usertype = null) // ALL
	{
		$this->db->select('username');
		$this->db->where('username', $username);
        if(isset($usertype) && !empty($usertype)) {
            $this->db->where('type', $usertype);
        }
		$this->db->where('deprecated', 0);
		$this->db->limit(1);
		$query = $this->db->get('users');
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
		
	}

	public function clear_passkey ($id_user)
	{
		$this->db->where('id_user', $id_user);
		$passkey = array('forget_password_key' => '');
		$this->db->update('users', $passkey);
	}
	
	public function update_passkey ($user, $key)
	{
		$this->db->where('username', $user);
		$passkey = array('forget_password_key' => $key);
		$this->db->update('users', $passkey);
	}

	public function get_user_balance ($user_id)
	{
		$query = "SELECT `balance` FROM `users` WHERE `id_user` = '".$this->db->escape_str($user_id)."'";
		return $this->db->query($query)->row_array();
	}

	public function update_user_balance ($user_id, $balance)
	{
		$query = "UPDATE `users` SET `balance` = '".$this->db->escape_str($balance)."' WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}

	public function insert_user_message ($user_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "INSERT INTO `user_messages` (fk_user, message, created_at) VALUES ('".$user_id."', '".$this->db->escape_str($input_arr['message'])."', '".$now."')";
		return $this->db->query($query);	
	}

	public function update_password ($user_id, $password) // ALL
	{
		$query = "UPDATE `users` SET `password` = '".$this->db->escape_str($password)."' WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
		return true;
	}

	public function activate_lead_stack ($user_id) // ALL
	{
		$query = "UPDATE `users` SET `lead_stack` = 0 WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}

	public function deactivate_lead_stack ($user_id) // ALL
	{
		$query = "UPDATE `users` SET `lead_stack` = 1 WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);	
	}

	public function activate ($user_id) // ALL
	{
		$query = "UPDATE `users` SET `status` = 1 WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);	
	}
	
	public function deactivate ($user_id) // ALL
	{
		$query = "UPDATE `users` SET `status` = 0 WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);	
	}

	public function delete ($user_id) // ALL
	{
		$query = "UPDATE `users` SET `deprecated` = 1 WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);	
	}	

	public function get_user_invites ($params = array()) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$user_type = isset($params['user_type']) ? $params['user_type'] : '';
		$email = isset($params['email']) ? $params['email'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND `status` = '".$this->db->escape_str($status)."' "; }
		if ($user_type <> "") { $where .= " AND `user_type` = '".$this->db->escape_str($user_type)."' "; }
		if ($email <> "") { $where .= " AND email LIKE '%".$this->db->escape_str($email)."%' "; }

		$query = "
		SELECT 
		ui.id_user_invite, 
		IF (u.type IS NULL, 'Invitation Sent', 
			IF (u.type = 1, 'Joined as Dealer',
				IF (u.type = 2, 'Registered as Quote Me Staff',
					IF (u.type = 3, 'Registered as Quote Me Staff', 'N/A')
				)
			)
		) AS `status_text`,
		ui.email, ui.created_at
		FROM user_invites ui
		LEFT JOIN users u ON ui.email = u.username
		WHERE ui.deprecated <> 1 ".$where." 
		GROUP BY ui.id_user_invite
		ORDER BY ui.created_at DESC";
		// echo $query;die();
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function insert_user_invite ($user_type, $email)
	{
		$query = "
		INSERT `user_invites` 
		(user_type, email, created_at) 
		VALUES 
		('".$this->db->escape_str($user_type)."', '".$this->db->escape_str($email)."', '".date("Y-m-d H:i:s")."')";
		$sql = $this->db->query($query);			
	}

	public function get_staffs ($params, $start, $limit) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$admin_type = isset($params['admin_type']) ? $params['admin_type'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND deprecated = '".$this->db->escape_str($status)."' "; }
		if ($admin_type <> "") { $where .= " AND admin_type = '".$this->db->escape_str($admin_type)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }

		$query = "
		SELECT 
		CASE (admin_type)
			WHEN 1 THEN 'Sales'
			WHEN 2 THEN 'Admin'
			WHEN 3 THEN 'FQ Admin'
		END `admin_type_text`,
		CASE (status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		CASE (lead_stack)
			WHEN 0 THEN 'Activated'
			WHEN 1 THEN 'Deactivated'
		END `lead_stack_text`,
		id_user, status, type, admin_type, username, password, name, abn, state, postcode, address, phone, mobile, description, deprecated, created_at, `lead_stack`
		FROM users WHERE 1 AND type = 2 AND deprecated <> 1 ".$where." ORDER BY name ASC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_fquser ($params, $start, $limit) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$admin_type = isset($params['admin_type']) ? $params['admin_type'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND deprecated = '".$this->db->escape_str($status)."' "; }
		if ($admin_type <> "") { $where .= " AND admin_type = '".$this->db->escape_str($admin_type)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }

		$query = "
		SELECT 
		CASE (admin_type)
			WHEN 1 THEN 'Sales'
			WHEN 2 THEN 'Admin'
			WHEN 3 THEN 'FQ Admin'
			WHEN 5 THEN 'FQ User Account'
		END `admin_type_text`,
		CASE (status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		CASE (lead_stack)
			WHEN 0 THEN 'Activated'
			WHEN 1 THEN 'Deactivated'
		END `lead_stack_text`,
		id_user, status, type, admin_type, username, password, name, abn, state, postcode, address, phone, mobile, description, deprecated, created_at, `lead_stack`
		FROM users WHERE 1 AND type = 5 AND deprecated <> 1 ".$where." ORDER BY name ASC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_staffs_count ($params) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$admin_type = isset($params['admin_type']) ? $params['admin_type'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND deprecated = '".$this->db->escape_str($status)."' "; }
		if ($admin_type <> "") { $where .= " AND admin_type = '".$this->db->escape_str($admin_type)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }
	
		$query = "
		SELECT COUNT(1) AS cnt FROM users WHERE 1 AND type = 2 AND deprecated <> 1 ".$where;
		return $this->db->query($query)->row_array();
	}

	
	public function get_fquser_count ($params) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$admin_type = isset($params['admin_type']) ? $params['admin_type'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND deprecated = '".$this->db->escape_str($status)."' "; }
		if ($admin_type <> "") { $where .= " AND admin_type = '".$this->db->escape_str($admin_type)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }
	
		$query = "
		SELECT COUNT(1) AS cnt FROM users WHERE 1 AND type = 5 AND deprecated <> 1 ".$where;
		return $this->db->query($query)->row_array();
	}
	
	public function update_admin_profile ($user_id, $input_arr) // ADMIN
	{
		$admin_type = isset($input_arr['admin_type']) ? $input_arr['admin_type'] : '';
		$admin_type_update = "";
		if ($admin_type <> "") 
		{
			$admin_type_update .= ", admin_type = '".$this->db->escape_str($input_arr['admin_type'])."' " ;
		}

		$query = "
		UPDATE `users` SET 
		name = '".$this->db->escape_str($input_arr['name'])."',
		abn = '".$this->db->escape_str($input_arr['abn'])."',
		state = '".$this->db->escape_str($input_arr['state'])."',
		postcode = '".$this->db->escape_str($input_arr['postcode'])."',
		address = '".$this->db->escape_str($input_arr['address'])."',
		phone = '".$this->db->escape_str($input_arr['phone'])."',
		mobile = '".$this->db->escape_str($input_arr['mobile'])."',
		direct = '".$this->db->escape_str($input_arr['direct'])."',
		postname = '".$this->db->escape_str($input_arr['postname'])."',
		description = '".$this->db->escape_str($input_arr['description'])."'
		".$admin_type_update."
		WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}
	
	public function get_admins ($user_id = 0) // ADMIN
	{
		$query = "SELECT * FROM users WHERE type = 2 AND deprecated <> 1 AND id_user <> ".$user_id." ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_admin ($user_id) // ADMIN
	{
		$query = "SELECT * FROM users WHERE type = 2 AND id_user = ".$user_id;
		return $this->db->query($query)->row_array();		
	}

	public function update_dealer_license ($user_id, $dealer_license) // DEALERS
	{
		$query = "
		UPDATE `users` SET
		dealer_license = '".$this->db->escape_str($dealer_license)."'
		WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}

	public function update_dealer_profile ($user_id, $input_arr) // DEALERS
	{
		$now = date("Y-m-d H:i:s");
		
		$fields = "";
	
		$dealership_data = array();
		if (isset($input_arr['abn'])) { $fields .= ", abn = '".$this->db->escape_str($input_arr['abn'])."' "; }
		if (isset($input_arr['dealer_license'])) { $fields .= ", dealer_license = '".$this->db->escape_str($input_arr['dealer_license'])."' "; }
		if (isset($input_arr['state'])) { $fields .= ", state = '".$this->db->escape_str($input_arr['state'])."' "; }
		if (isset($input_arr['postcode'])) { $fields .= ", postcode = '".$this->db->escape_str($input_arr['postcode'])."' "; }
		if (isset($input_arr['address'])) { $fields .= ", address = '".$this->db->escape_str($input_arr['address'])."' "; }
		
		/*if (isset($input_arr['manager_name'])) { $fields .= ", name = '".$this->db->escape_str($input_arr['manager_name'])."' "; }
		if (isset($input_arr['manager_phone'])) { $fields .= ", phone = '".$this->db->escape_str($input_arr['manager_phone'])."' "; }
		if (isset($input_arr['manager_mobile'])) { $fields .= ", mobile = '".$this->db->escape_str($input_arr['manager_mobile'])."' "; }
		if (isset($input_arr['manager_email'])) { $fields .= ", email = '".$this->db->escape_str($input_arr['manager_email'])."' "; }		
		
		if (isset($input_arr['manager_name'])) { $fields .= ", manager_name = '".$this->db->escape_str($input_arr['manager_name'])."' "; }
		if (isset($input_arr['manager_phone'])) { $fields .= ", manager_phone = '".$this->db->escape_str($input_arr['manager_phone'])."' "; }
		if (isset($input_arr['manager_mobile'])) { $fields .= ", manager_mobile = '".$this->db->escape_str($input_arr['manager_mobile'])."' "; }
		if (isset($input_arr['manager_email'])) { $fields .= ", manager_email = '".$this->db->escape_str($input_arr['manager_email'])."' "; }*/
		
		if (isset($input_arr['name'])) { $fields .= ", name = '".$this->db->escape_str($input_arr['name'])."' "; }
		if (isset($input_arr['phone'])) { $fields .= ", phone = '".$this->db->escape_str($input_arr['phone'])."' "; }
		if (isset($input_arr['mobile'])) { $fields .= ", mobile = '".$this->db->escape_str($input_arr['mobile'])."' "; }
		if (isset($input_arr['email'])) { $fields .= ", email = '".$this->db->escape_str($input_arr['email'])."' "; }	
		if (isset($input_arr['email'])) { $fields .= ", username = '".$this->db->escape_str($input_arr['email'])."' "; }	
		
		if (isset($input_arr['name'])) { $fields .= ", manager_name = '".$this->db->escape_str($input_arr['name'])."' "; }
		if (isset($input_arr['phone'])) { $fields .= ", manager_phone = '".$this->db->escape_str($input_arr['phone'])."' "; }
		if (isset($input_arr['mobile'])) { $fields .= ", manager_mobile = '".$this->db->escape_str($input_arr['mobile'])."' "; }
		if (isset($input_arr['email'])) { $fields .= ", manager_email = '".$this->db->escape_str($input_arr['email'])."' "; }
		
		
		if (isset($input_arr['account_name'])) { $fields .= ", account_name = '".$this->db->escape_str($input_arr['account_name'])."' "; }
		if (isset($input_arr['account_phone'])) { $fields .= ", account_phone = '".$this->db->escape_str($input_arr['account_phone'])."' "; }
		if (isset($input_arr['account_mobile'])) { $fields .= ", account_mobile = '".$this->db->escape_str($input_arr['account_mobile'])."' "; }
		if (isset($input_arr['account_email'])) { $fields .= ", account_email = '".$this->db->escape_str($input_arr['account_email'])."' "; }
		
		if (isset($input_arr['dealer_principal_name'])) { $fields .= ", dealer_principal_name = '".$this->db->escape_str($input_arr['dealer_principal_name'])."' "; }
		if (isset($input_arr['dealer_principal_phone'])) { $fields .= ", dealer_principal_phone = '".$this->db->escape_str($input_arr['dealer_principal_phone'])."' "; }
		if (isset($input_arr['dealer_principal_mobile'])) { $fields .= ", dealer_principal_mobile = '".$this->db->escape_str($input_arr['dealer_principal_mobile'])."' "; }
		if (isset($input_arr['dealer_principal_email'])) { $fields .= ", dealer_principal_email = '".$this->db->escape_str($input_arr['dealer_principal_email'])."' "; }		

		if (isset($input_arr['bank_acct_name'])) { $fields .= ", bank_acct_name = '".$this->db->escape_str($input_arr['bank_acct_name'])."' "; }
		if (isset($input_arr['bank_acct_num'])) { $fields .= ", bank_acct_num = '".$this->db->escape_str($input_arr['bank_acct_num'])."' "; }
		if (isset($input_arr['bank_acct_bsb'])) { $fields .= ", bank_acct_bsb = '".$this->db->escape_str($input_arr['bank_acct_bsb'])."' "; }
		
		if (isset($input_arr['description'])) { $fields .= ", description = '".$this->db->escape_str($input_arr['description'])."' "; }
		
		if (isset($input_arr['dealer_note'])) { $fields .= ", dealer_note = '".$this->db->escape_str($input_arr['dealer_note'])."' "; }
		//if (isset($input_arr['is_primary_contact'])) { $fields .= ", is_primary_contact = '".$this->db->escape_str($input_arr['update_dealer_profile'])."' "; }
		
		//echo  $fields;
		
		$query = "
		UPDATE `users` SET last_updated = '".$now."' ".$fields." WHERE `id_user` = '".$user_id."'";		
		 $sql = $this->db->query($query);
		//if($sql){echo 'yyy';}else{ echo 'no';}
		if (isset($input_arr['dealership_brand']) && is_array($input_arr['dealership_brand']))
		{
			$input_arr['dealership_brand'] = implode(",", $input_arr['dealership_brand']);
		}
		if (isset($input_arr['dealership_states']) && is_array($input_arr['dealership_states']))
		{
			$input_arr['dealership_states'] = implode(",", $input_arr['dealership_states']);
		}
		
		$dealership_columns = array("1"=>"dealership_name","2"=>"dealership_brand","3"=>"dealership_states","abn"=>"dealership_abn","dealer_license"=>"dealership_license","4"=>"dealership_contacts","5"=>"dealership_editkey","6"=>"dealership_password","7"=>"dealership_contact_title","8"=>"dealership_contact_boxs");
		foreach ($dealership_columns as $column_key=>$column_name) {
			if($column_key != "abn" || $column_key != 'dealer_license')
			{
				$column_key = $column_name;
			}
			if(isset($input_arr[$column_key]))
			{
				$dealership_data[$column_name] = $this->db->escape_str($input_arr[$column_key]);
			}	
		}
		$dealership_data['is_primary_contact'] = (isset($input_arr['is_primary_contact']) && $input_arr['is_primary_contact']!='')?1:0;
		//$dealership_data['dealership_editkey'] = $this->db->escape_str($input_arr['dealership_editkey']);
		$dealership_data['deal_agreement'] = (isset($input_arr['deal_agreement']) && $input_arr['deal_agreement']!='')?1:0;
		
		$dealership_where = array("fk_user"=>$user_id);
		
		$result = $this->db->update('dealer_attributes',$dealership_data,$dealership_where);
	
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
    
    public function create_dealer_profile ($input_arr) // DEALERS
	{
        //echo '<pre>';print_r($input_arr);exit;
		$now = date("Y-m-d H:i:s");
		
		$fields = "";
        
		$dealership_data = array();
		$ins_data = array();
        if (isset($input_arr['abn'])) { $ins_data['abn'] = $this->db->escape_str($input_arr['abn']);}
		if (isset($input_arr['dealer_license'])) { $ins_data['dealer_license'] = $this->db->escape_str($input_arr['dealer_license']);}
		if (isset($input_arr['state'])) { $ins_data['state'] = $this->db->escape_str($input_arr['state']);}
		if (isset($input_arr['postcode'])) { $ins_data['postcode'] = $this->db->escape_str($input_arr['postcode']);}
		if (isset($input_arr['address'])) { $ins_data['address'] = $this->db->escape_str($input_arr['address']);}
		if (isset($input_arr['name'])) { $ins_data['name'] = $this->db->escape_str($input_arr['name']);}
		if (isset($input_arr['phone'])) { $ins_data['phone'] = $this->db->escape_str($input_arr['phone']);}
		if (isset($input_arr['mobile'])) { $ins_data['mobile'] = $this->db->escape_str($input_arr['mobile']);}
		if (isset($input_arr['email'])) { $ins_data['email'] = $this->db->escape_str($input_arr['email']);}	
		if (isset($input_arr['email'])) { $ins_data['username'] = $this->db->escape_str($input_arr['email']);}	
		if (isset($input_arr['name'])) { $ins_data['manager_name'] = $this->db->escape_str($input_arr['name']);}
		if (isset($input_arr['phone'])) { $ins_data['manager_phone'] = $this->db->escape_str($input_arr['phone']);}
		if (isset($input_arr['mobile'])) { $ins_data['manager_mobile'] = $this->db->escape_str($input_arr['mobile']);}
		if (isset($input_arr['email'])) { $ins_data['manager_email'] = $this->db->escape_str($input_arr['email']);}
		if (isset($input_arr['account_name'])) { $ins_data['account_name'] = $this->db->escape_str($input_arr['account_name']);}
		if (isset($input_arr['account_phone'])) { $ins_data['account_phone'] = $this->db->escape_str($input_arr['account_phone']);}
		if (isset($input_arr['account_mobile'])) { $ins_data['account_mobile'] = $this->db->escape_str($input_arr['account_mobile']);}
		if (isset($input_arr['account_email'])) { $ins_data['account_email'] = $this->db->escape_str($input_arr['account_email']);}
		if (isset($input_arr['dealer_principal_name'])) { $ins_data['dealer_principal_name'] = $this->db->escape_str($input_arr['dealer_principal_name']);}
		if (isset($input_arr['dealer_principal_phone'])) { $ins_data['dealer_principal_phone'] = $this->db->escape_str($input_arr['dealer_principal_phone']);}
		if (isset($input_arr['dealer_principal_mobile'])) { $ins_data['dealer_principal_mobile'] = $this->db->escape_str($input_arr['dealer_principal_mobile']);}
		if (isset($input_arr['dealer_principal_email'])) { $ins_data['dealer_principal_email'] = $this->db->escape_str($input_arr['dealer_principal_email']);}		
        if (isset($input_arr['bank_acct_name'])) { $ins_data['bank_acct_name'] = $this->db->escape_str($input_arr['bank_acct_name']);}
		if (isset($input_arr['bank_acct_num'])) { $ins_data['bank_acct_num'] = $this->db->escape_str($input_arr['bank_acct_num']);}
		if (isset($input_arr['bank_acct_bsb'])) { $ins_data['bank_acct_bsb'] = $this->db->escape_str($input_arr['bank_acct_bsb']);}
		if (isset($input_arr['description'])) { $ins_data['description'] = $this->db->escape_str($input_arr['description']);}
		if (isset($input_arr['dealer_note'])) { $ins_data['dealer_note'] = $this->db->escape_str($input_arr['dealer_note']);}
        if (isset($input_arr['user_type'])) { $ins_data['type'] = $this->db->escape_str($input_arr['user_type']);}
        
        //$ins_data['type'] = 1;
        $ins_data['status'] = 1;
        $ins_data['created_at'] = $now;        
		
        //echo '<pre>';print_r($ins_data);exit;
		//echo  $fields;
        
        $last_ins_id = $this->insert('users',$ins_data);
        
        /*if($last_ins_id){
            return true;
        }else{
            return false;
        }*/
		
		//if($sql){echo 'yyy';}else{ echo 'no';}
		if (isset($input_arr['dealership_brand']) && is_array($input_arr['dealership_brand']))
		{
			$input_arr['dealership_brand'] = implode(",", $input_arr['dealership_brand']);
		}
		if (isset($input_arr['dealership_states']) && is_array($input_arr['dealership_states']))
		{
			$input_arr['dealership_states'] = implode(",", $input_arr['dealership_states']);
		}
		
		$dealership_columns = array("1"=>"dealership_name","2"=>"dealership_brand","3"=>"dealership_states","abn"=>"dealership_abn","dealer_license"=>"dealership_license","4"=>"dealership_contacts","5"=>"dealership_editkey","6"=>"dealership_password","7"=>"dealership_contact_title","8"=>"dealership_contact_boxs");
		foreach ($dealership_columns as $column_key=>$column_name) {
			if($column_key != "abn" || $column_key != 'dealer_license')
			{
				$column_key = $column_name;
			}
			if(isset($input_arr[$column_key]))
			{
				$dealership_data[$column_name] = $this->db->escape_str($input_arr[$column_key]);
			}	
		}
		//$dealership_data['dealership_editkey'] = $this->db->escape_str($input_arr['dealership_editkey']);
		$dealership_data['is_primary_contact'] = (isset($input_arr['is_primary_contact']) && $input_arr['is_primary_contact']!='')?1:0;
		$dealership_data['deal_agreement'] = (isset($input_arr['deal_agreement']) && $input_arr['deal_agreement']!='')?1:0;
		$dealership_data['fk_user'] = $last_ins_id;
        
		//$dealership_where = array("fk_user" => $last_ins_id);		
		//$result = $this->db->update('dealer_attributes',$dealership_data,$dealership_where);
        
        $result = $this->insert('dealer_attributes',$dealership_data);
        
        /*if ($user_type=="1") {
            $dealership_name = $this->input->post('dealership_name'); 
            $dealership_brand = "";				
            $dealership_states = "";

            $post_data = $this->input->post();
            if (isset($post_data['dealership_state'])) {
                $dealership_states = implode(",", $this->input->post('dealership_state'));
            }                
            if (isset($post_data['dealership_brand'])) {
                $dealership_brands = implode(",", $this->input->post('dealership_brand'));					
            }
            $this->user_model->register_dealer_attributes($user_id, $dealership_name, $dealership_brands, $dealership_states);
        }*/
	
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_remind_dealers ($quote_request_id) // DEALERS
	{
		$query = "
		SELECT id_user, username as `email` FROM users WHERE 1
		AND deprecated <> 1
		AND id_user IN (SELECT DISTINCT fk_user FROM dealer_requests WHERE fk_quote_request = ".$quote_request_id.")
		AND id_user NOT IN (SELECT DISTINCT fk_user FROM quotes WHERE fk_quote_request = ".$quote_request_id.")";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_dealers_count ($params) // DEALERS
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$pma_status = isset($params['pma_status']) ? $params['pma_status'] : '';
		$gold_status = isset($params['gold_status']) ? $params['gold_status'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$dealership_name = isset($params['dealership_name']) ? $params['dealership_name'] : '';
		$dealership_brand = isset($params['dealership_brand']) ? $params['dealership_brand'] : '';
		
		$where = "";
		if ($status <> "") { $where .= " AND u.status = '".$this->db->escape_str($status)."' "; }
		if ($pma_status <> "") { $where .= " AND u.pma_status = '".$this->db->escape_str($pma_status)."' "; }
		if ($gold_status <> "") { $where .= " AND u.gold_status = '".$this->db->escape_str($gold_status)."' "; }
		if ($email <> "") { $where .= " AND u.username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND u.name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND u.abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND u.state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND u.postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND u.address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND u.phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND u.mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }
		if ($dealership_name <> "") { $where = " AND da.dealership_name LIKE '%".$this->db->escape_str($dealership_name)."%' "; }
		if ($dealership_brand <> "") { $where = " AND da.dealership_brand LIKE '%".$this->db->escape_str($dealership_brand)."%' "; }
	
		$query = "
		SELECT COUNT(1) AS cnt 
		FROM users u JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND u.type = 1 AND u.deprecated <> 1 ".$where;
		return $this->db->query($query)->row_array();
	}

	public function get_dealers ($params, $start, $limit) // DEALERS
	{
	
		$status = isset($params['status']) ? $params['status'] : '';
		$pma_status = isset($params['pma_status']) ? $params['pma_status'] : '';
		$gold_status = isset($params['gold_status']) ? $params['gold_status'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$dealership_name = isset($params['dealership_name']) ? $params['dealership_name'] : '';
		$dealership_brand = isset($params['dealership_brand']) ? $params['dealership_brand'] : '';
		$catered_state= isset($params['catered_state']) ? $params['catered_state'] : '';
		
		$where = "";
		if ($status <> "") { $where .= " AND u.status = '".$this->db->escape_str($status)."' "; }
		if ($pma_status <> "") { $where .= " AND u.pma_status = '".$this->db->escape_str($pma_status)."' "; }
		if ($gold_status <> "") { $where .= " AND u.gold_status = '".$this->db->escape_str($gold_status)."' "; }
		if ($email <> "") { $where .= " AND u.username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND u.name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND u.abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND u.state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND u.postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND u.address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND u.phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND u.mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }
		if ($dealership_name <> "") { $where .= " AND da.dealership_name LIKE '%".$this->db->escape_str($dealership_name)."%' "; }
		if ($dealership_brand <> "") { $where .= " AND da.dealership_brand LIKE '%".$this->db->escape_str($dealership_brand)."%' "; }
		
		if ($catered_state <> "") { $where .= " AND da.dealership_states LIKE '%".$this->db->escape_str($catered_state)."%' "; }
		
		//echo  $where;
		 $query = "
		SELECT 
		u.id_user AS `user_id`,
		(
			SELECT COUNT(DISTINCT qr.id_quote_request) FROM quotes q
			JOIN quote_requests qr ON q.id_quote = qr.winner
			JOIN fq_accounts_new fa ON qr.fk_lead = fa.id_fq_account 
			WHERE fa.status IN (5, 6, 7, 8) AND q.fk_user = `user_id`			
		) AS `orders_count`,
		(
			SELECT COUNT(DISTINCT q.fk_quote_request) FROM quotes q
			WHERE q.fk_user = `user_id`			
		) AS `quotes_count`,
		(
			SELECT COUNT(DISTINCT fk_quote_request) FROM dealer_requests WHERE fk_user = `user_id`
		) AS `invites_count`,
		CASE (u.status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		CASE (u.pma_status)
			WHEN 0 THEN 'Inactive'
			WHEN 1 THEN 'Active'
		END `pma_status_text`,
        
        CASE
            WHEN da.is_primary_contact = 1 THEN '1'
            WHEN da.is_primary_contact = '1' THEN '1'
            WHEN da.is_primary_contact IS NULL THEN '1'
            ELSE da.dealership_contacts
        END as primary_contact,
  
        CASE (u.gold_status)
			WHEN 0 THEN 'Standard'
			WHEN 1 THEN 'Gold'
		END `gold_status_text`,
		u.id_user, u.status, u.username, u.password, u.name, u.abn, u.state, u.postcode, u.address, 
		u.phone, u.mobile, u.description, u.deprecated, u.created_at,u.dealer_note,        
		da.dealership_name, da.dealership_brand, u.pma_status, u.gold_status, u.deposit_show_status
        
		FROM users u JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND u.type = 1 AND u.deprecated <> 1
		".$where."
		ORDER BY `orders_count` DESC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_dealers_all () // DEALERS
	{
		$query = "
		SELECT 
		CASE (u.status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		u.id_user, u.status, u.username, u.password, u.name, u.abn, u.state, u.postcode, u.address, 
		u.phone, u.mobile, u.description, u.deprecated, u.created_at,
		da.dealership_name, da.dealership_brand
		FROM users u
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND u.type = 1 AND u.deprecated <> 1 
		GROUP BY u.id_user 
		ORDER BY u.name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_suggested_dealers ($type,$make, $postcode, $state, $quote_request_id) // DEALERS
	{
		$post = $this->input->post();
		
		if($post['quote_request_id'] != '') {
			$quote_request_id = $post['quote_request_id'];
		}

		$where = "";
		if ($type != 0) { $where .= " AND u.type = ".$type." "; }
		if($type == 0){

			if ($make != "") { $where .= " AND da.dealership_brand LIKE '%".$make."%' "; }
			//if ($postcode != "") { $where .= " AND u.postcode LIKE '%".$postcode."%' "; }
			if ($state != "") { $where .= " AND u.state LIKE '%".$state."%' "; }
			if ($quote_request_id <> 0) { $where .= " AND u.id_user NOT IN (SELECT fk_user FROM dealer_requests WHERE fk_quote_request = ".$quote_request_id.")"; }
		}

		$query = "
		SELECT 
			u.id_user, u.id_user AS `user_id`, u.gold_status,
			u.name, u.abn, u.username, 
			da.dealership_name, u.address as `dealership_address`, 
			u.phone, u.mobile, u.state, u.postcode, 
            da.dealership_contacts AS contacts, da.dealership_contact_boxs,
			(SELECT COUNT(DISTINCT fk_quote_request) FROM dealer_attributes WHERE fk_user = `user_id`) AS `tender_count`,
			(SELECT COUNT(1) FROM quotes WHERE fk_user = `user_id`) AS `quote_count`,
			(
				SELECT COUNT(DISTINCT fk_quote_request) FROM quotes q 
				JOIN quote_requests qr ON q.id_quote = qr.winner
				WHERE q.fk_user = `user_id`
			) AS `won_count`,
			(
				SELECT COUNT(1) FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q  ON qr.winner = q.id_quote
				WHERE q.fk_user = `user_id` AND l.status IN (5, 6, 7)
			) AS `order_count`
		FROM users u
		LEFT JOIN dealer_attributes da ON u.id_user = da.fk_user
		LEFT JOIN dealer_requests dr ON u.id_user = dr.fk_user
		WHERE 1
		AND u.deprecated <> 1
		".$where."
		GROUP BY u.id_user
		ORDER BY u.gold_status DESC, u.name ASC";

		$sql = $this->db->query($query);
		return $sql;
	}
    
    public function get_invited_dealers ($quote_request_id) // DEALERS
	{
		$where = "";
		
		$query = "
		SELECT 
			u.id_user, u.id_user AS `user_id`, u.gold_status,
			u.name, u.abn, u.username, 
			da.dealership_name, u.address as `dealership_address`, 
			u.phone, u.mobile, u.state, u.postcode,
			(SELECT COUNT(DISTINCT fk_quote_request) FROM dealer_attributes WHERE fk_user = `user_id`) AS `tender_count`,
			(SELECT COUNT(1) FROM quotes WHERE fk_user = `user_id`) AS `quote_count`,
			(
				SELECT COUNT(DISTINCT fk_quote_request) FROM quotes q 
				JOIN quote_requests qr ON q.id_quote = qr.winner
				WHERE q.fk_user = `user_id`
			) AS `won_count`,
			(
				SELECT COUNT(1) FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q  ON qr.winner = q.id_quote
				WHERE q.fk_user = `user_id` AND l.status IN (5, 6, 7)
			) AS `order_count`
		FROM users u
		LEFT JOIN dealer_attributes da ON u.id_user = da.fk_user
		LEFT JOIN dealer_requests dr ON u.id_user = dr.fk_user
		WHERE 1
		AND u.type = 1
		AND u.deprecated <> 1
        AND dr.fk_quote_request = '".$this->db->escape_str($quote_request_id)."'
		".$where."
		GROUP BY u.id_user
		ORDER BY u.gold_status DESC, u.name ASC";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_dealer ($user_id) // DEALERS
	{
		$query = "
		SELECT
		u.id_user, 
		u.username, u.dealer_license, u.abn, u.state, u.postcode, u.address,
		u.address as `dealership_address`, 
		u.name, u.phone, u.mobile, u.email,
		u.manager_name, u.manager_email, u.manager_mobile, u.manager_phone,
		u.account_name, u.account_email, u.account_mobile, u.account_phone,
		u.dealer_principal_name, u.dealer_principal_email, u.dealer_principal_mobile, u.dealer_principal_phone,
		u.dealer_note,
		u.bank_acct_name, u.bank_acct_bsb, u.bank_acct_num, 
		u.description, u.balance,
		pg.latitude, pg.longitude,
		da.dealership_name, da.dealership_brand, da.dealership_states, da.dealership_contact_title,da.dealership_contacts,da.dealership_contact_boxs,da.deal_agreement,
        da.is_primary_contact
		FROM users u 
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		LEFT JOIN postcodes_geo pg ON u.state = pg.state AND u.postcode = pg.postcode
		WHERE u.id_user = ".$user_id."
		GROUP BY u.id_user";
		return $this->db->query($query)->row_array();		
	}

	public function get_dealership_contacts($user_id){		
        $this->db->select('da.dealership_contacts,u.name');
		$this->db->from('users u');
		$this->db->join('dealer_attributes da', 'u.id_user = da.fk_user');
        $this->db->where('fk_user',$user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
	}

	public function get_wholesalers ($params, $start, $limit) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND status = '".$this->db->escape_str($status)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }

		$query = "
		SELECT 
		CASE (status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		id_user, status, username, password, name, abn, state, postcode, address, phone, mobile, description, deprecated, created_at
		FROM users WHERE 1 AND deprecated <> 1 AND type = 3 ".$where." ORDER BY name ASC LIMIT ".$start.", ".$limit;
		// echo $query; die();
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_referrers ($params, $start, $limit) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND status = '".$this->db->escape_str($status)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }

		$query = "
		SELECT 
		CASE (status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		id_user, status, username, password, name, abn, state, postcode, address, phone, mobile, description, deprecated, created_at
		FROM referrers WHERE 1 AND deprecated <> 1 AND type = 4 ".$where." ORDER BY name ASC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_referrers_count ($params) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND status = '".$this->db->escape_str($status)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }
	
		$query = "
		SELECT COUNT(1) AS cnt FROM referrers WHERE 1 AND deprecated <> 1 AND type = 4 ".$where;
		return $this->db->query($query)->row_array();
	}

	public function get_wholesalers_count ($params) // ADMIN
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$abn = isset($params['abn']) ? $params['abn'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND status = '".$this->db->escape_str($status)."' "; }
		if ($email <> "") { $where .= " AND username LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($abn <> "") { $where .= " AND abn LIKE '%".$this->db->escape_str($abn)."%' "; }
		if ($state <> "") { $where .= " AND state LIKE '%".$this->db->escape_str($state)."%' "; }
		if ($postcode <> "") { $where .= " AND postcode LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND address LIKE '%".$this->db->escape_str($address)."%' "; }
		if ($phone <> "") { $where .= " AND phone LIKE '%".$this->db->escape_str($phone)."%' "; }
		if ($mobile <> "") { $where .= " AND mobile LIKE '%".$this->db->escape_str($mobile)."%' "; }
	
		$query = "
		SELECT COUNT(1) AS cnt FROM users WHERE 1 AND deprecated <> 1 AND type = 3 ".$where;
		return $this->db->query($query)->row_array();
	}

	public function get_wholesaler ($user_id) // WHOLESALERS
	{
		$query = "
		SELECT 
		u.username, u.name, u.abn, 
		u.state, u.postcode, u.address, u.phone, u.mobile, u.description 
		FROM users u WHERE 1 AND u.id_user = ".$user_id;
		return $this->db->query($query)->row_array();
	}
	
	public function update_wholesaler_profile ($user_id, $input_arr) // WHOLESALERS
	{
		$dob = date('Y-m-d', strtotime($input_arr['dob']));

		$query = "
		UPDATE `users` SET
		name = '".$this->db->escape_str($input_arr['name'])."',
		abn = '".$this->db->escape_str($input_arr['abn'])."',
		state = '".$this->db->escape_str($input_arr['state'])."',
		postcode = '".$this->db->escape_str($input_arr['postcode'])."',
		address = '".$this->db->escape_str($input_arr['address'])."',
		phone = '".$this->db->escape_str($input_arr['phone'])."',
		mobile = '".$this->db->escape_str($input_arr['mobile'])."',
		description = '".$this->db->escape_str($input_arr['description'])."',
		dob = '".$this->db->escape_str($dob)."',
		account_holders_name = '".$this->db->escape_str($input_arr['account_holders_name'])."',
		bank_acct_name = '".$this->db->escape_str($input_arr['bank_acct_name'])."',
		bank_acct_num = '".$this->db->escape_str($input_arr['bank_acct_num'])."',
		bank_acct_bsb = '".$this->db->escape_str($input_arr['bank_acct_bsb'])."'
		WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}

	public function update_referrer_profile ($user_id, $input_arr) // WHOLESALERS
	{
		$dob = date('Y-m-d', strtotime($input_arr['dob']));

		$query = "
		UPDATE `referrers` SET
		name = '".$this->db->escape_str($input_arr['name'])."',
		state = '".$this->db->escape_str($input_arr['state'])."',
		postcode = '".$this->db->escape_str($input_arr['postcode'])."',
		address = '".$this->db->escape_str($input_arr['address'])."',
		phone = '".$this->db->escape_str($input_arr['phone'])."',
		mobile = '".$this->db->escape_str($input_arr['mobile'])."',
		description = '".$this->db->escape_str($input_arr['description'])."',
		dob = '".$this->db->escape_str($dob)."',
		account_holders_name = '".$this->db->escape_str($input_arr['account_holders_name'])."',
		bank_acct_name = '".$this->db->escape_str($input_arr['bank_acct_name'])."',
		bank_acct_num = '".$this->db->escape_str($input_arr['bank_acct_num'])."',
		bank_acct_bsb = '".$this->db->escape_str($input_arr['bank_acct_bsb'])."'
		WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}

	public function get_suggested_wholesalers () // WHOLESALERS
	{
		$query = "
		SELECT u.id_user, u.id_user AS `user_id`, u.gold_status, u.name, u.abn, u.address, u.username, u.phone, u.mobile, u.state, u.postcode
		FROM users u
		WHERE u.deprecated <> 1 AND u.status = 1 AND u.type = 3
		ORDER BY u.name ASC";
		$sql = $this->db->query($query);
		// return $sql->result();
		return $sql;
	}

	public function get_suggested_wholesalers_2 ($make, $postcode, $state, $quote_request_id) // DEALERS
	{
		$where = "";
		if ($make != "") { $where .= " AND da.dealership_brand LIKE '%".$make."%' "; }
		//if ($postcode != "") { $where .= " AND u.postcode LIKE '%".$postcode."%' "; }
		if ($state != "") { $where .= " AND u.state LIKE '%".$state."%' "; }
		if ($quote_request_id <> 0) { $where .= " AND u.id_user NOT IN (SELECT fk_user FROM dealer_requests WHERE fk_quote_request = ".$quote_request_id.")"; }

		$query = "
		SELECT 
			u.id_user, u.id_user AS `user_id`, u.gold_status,
			u.name, u.abn, u.username, 
			da.dealership_name, u.address as `dealership_address`, 
			u.phone, u.mobile, u.state, u.postcode, 
            da.dealership_contacts AS contacts, da.dealership_contact_boxs,
			(SELECT COUNT(DISTINCT fk_quote_request) FROM dealer_attributes WHERE fk_user = `user_id`) AS `tender_count`,
			(SELECT COUNT(1) FROM quotes WHERE fk_user = `user_id`) AS `quote_count`,
			(
				SELECT COUNT(DISTINCT fk_quote_request) FROM quotes q 
				JOIN quote_requests qr ON q.id_quote = qr.winner
				WHERE q.fk_user = `user_id`
			) AS `won_count`,
			(
				SELECT COUNT(1) FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q  ON qr.winner = q.id_quote
				WHERE q.fk_user = `user_id` AND l.status IN (5, 6, 7)
			) AS `order_count`
		FROM users u
		LEFT JOIN dealer_attributes da ON u.id_user = da.fk_user
		LEFT JOIN dealer_requests dr ON u.id_user = dr.fk_user
		WHERE 1
		AND u.type = 3
		AND u.deprecated <> 1
		".$where."
		GROUP BY u.id_user
		ORDER BY u.gold_status DESC, u.name ASC";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_pma_status ($user_id)
	{
		$query = "SELECT pma_status, lead_cap FROM users WHERE id_user = '".$this->db->escape_str($user_id)."'";
		return $this->db->query($query)->row_array();
	}

	public function get_pma_protection ($user_id)
	{
		$query = "
		SELECT pp.id_pma_protection, pp.postcode, pg.state, pp.postcode as `pma_postcode`,
		(
			SELECT COUNT(1) FROM leads 
			WHERE 1
			AND postcode = `pma_postcode`
			AND fk_buyer = '".$this->db->escape_str($user_id)."'
			AND MONTH(purchase_date) = MONTH(CURDATE()) 
			AND YEAR(CURDATE()) = YEAR(CURDATE())
		) AS `leads_count`, pp.fk_user as `user`
		FROM pma_protection pp
		JOIN postcodes_geo pg ON pp.postcode = pg.postcode
		WHERE pp.fk_user = '".$this->db->escape_str($user_id)."'
		GROUP BY id_pma_protection";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_suggested_locations ($user_id)
	{
		$query = "
		SELECT pg.id as `id`,pg.postcode, pg.state
		FROM postcodes_geo pg
		JOIN users u ON pg.state = u.state
		WHERE u.id_user = '".$this->db->escape_str($user_id)."'
		AND CONCAT('".$this->db->escape_str($user_id)."', '-', pg.postcode) 
			NOT IN (SELECT CONCAT('".$this->db->escape_str($user_id)."', '-', postcode) FROM pma_protection)
		AND pg.postcode NOT LIKE '1%'
		GROUP BY pg.postcode";
		$sql = $this->db->query($query);
		return $sql->result_array();		
	}

	public function add_pma_protection ($user_id, $postcode)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO `pma_protection` (fk_user, postcode, created_at)
		VALUES (
		'".$this->db->escape_str($user_id)."',
		'".$this->db->escape_str($postcode)."',
		'".$now."')";
		$sql = $this->db->query($query);

		return $this->db->insert_id();
	}

	public function activate_pma($data_array)
	{
		$data = [
			'pma_status' => 1,
			'fk_token'   => $data_array['fk_token']
		];

		$this->db->where('id_user', $data_array['user']);

		if($this->db->update('users', $data))
			return TRUE;

		return FALSE;
	}

	public function update_pma_status ($user_id, $status)
	{
		$query = "UPDATE `users` SET pma_status = '".$this->db->escape_str($status)."', fk_token = 0 WHERE id_user = '".$this->db->escape_str($user_id)."'";
		$sql = $this->db->query($query);
	}

	public function delete_pma_protection ($params)
	{
		$query = "DELETE FROM `pma_protection` where postcode = '{$params['this_postcode']}' AND fk_user = '{$params['this_user']}'";
		$this->db->query($query);
	}

	public function update_lead_cap ($user_id, $lead_cap)
	{
		$query = "UPDATE `users` SET lead_cap = '".$this->db->escape_str($lead_cap)."' WHERE id_user = '".$this->db->escape_str($user_id)."'";
		$sql = $this->db->query($query);
	}	

	// FOR EMAILING //
	public function get_dealer_for_email ($user_id)
	{
		$query = "
		SELECT u.username AS `dealer_email`, da.dealership_name AS `dealer_name`,
		u.abn AS `dealer_abn`, u.name AS `dealer_manager_name`,
		u.address AS `dealer_address`, u.state AS `dealer_state`, u.postcode AS `dealer_postcode`, pg.suburb AS `dealer_suburb`,
		u.mobile AS `dealer_mobile`, u.phone AS `dealer_phone`,da.dealership_contacts AS contacts,da.dealership_contact_boxs
		FROM users u 
		LEFT JOIN dealer_attributes da ON u.id_user = da.fk_user
		LEFT JOIN postcodes_geo pg ON u.state = pg.state AND u.postcode = pg.postcode
		WHERE u.id_user = '".$this->db->escape_str($user_id)."' GROUP BY u.id_user LIMIT 1";
		return $this->db->query($query)->row_array();		
	}

	public function get_makes ()
	{
		$query = "SELECT * FROM makes";
		return $this->db->query($query)->result_array();
	}

	public function update_gold_status ($id, $status)
	{
		$this->db->where('id_user', $id);

		if( $this->db->update('users', array('gold_status' => $status)) )
			return TRUE;
		else
			return FALSE;
	}

	public function change_deposit_visibility_status ($id, $status)
	{
		$this->db->where('id_user', $id);

		if ($this->db->update('users', array('deposit_show_status' => $status)))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_dealer_files ($fk_main, $fk_user)
	{
		return $this->db->get_where('file_attachments', array('fk_main' => $fk_main, 'type' => 7, 'fk_user' => $fk_user))->result_array();
	}

	public function delete_dealer_file ($params)
	{
		$this->load->helper('file');
		$fk_main  = $params['fk_main'];
		$abspath    = "./uploads/dealer_files/".$params['abspath'];
		$delete_file_q = "delete from file_attachments where id_file_attachment = {$fk_main}";
		if ($this->db->query($delete_file_q))
		{
			if (unlink($abspath))
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	public function get_all_referrals_admin ()
	{
		$query = "select r.id_referral,
		r.fk_user,
		r.first_name, r.last_name, r.address, r.postcode, r.mobile_number, r.secondary_number, r.email_address, r.make, r.model, r.variant,
		CASE (r.`status`)
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
		END `status_text`,
		r.state, m.name as `name`
		from referrals r
		join makes m on r.make = m.id_make ;";

		return $this->db->query($query)->result_array();
	}

	public function get_all_referrals ($id_user)
	{
		$query = "select r.id_referral,
		r.fk_user,
		r.first_name, r.last_name, r.address, r.postcode, r.mobile_number, r.secondary_number, r.email_address, r.make, r.model, r.variant,
		CASE (r.`status`)
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
		END `status_text`,
		r.state, m.name as `name`
		from referrals r
		join makes m on r.make = m.id_make 
		where fk_user={$id_user};";

		return $this->db->query($query)->result_array();
	}

	public function insert_new_referral ($data)
	{
		$this->db->insert('referrals', $data);
		return $this->db->insert_id();
	}

	public function get_referral ($id)
	{
		$query = "select * from referrals where id_referral = {$id}";
		return $this->db->query($query)->row_array();
	}

	public function update_referral ($data)
	{
		$this->db->where('id_referral', $data['hidden_id']);
		$update_data = [
			'make'             => $data['make'],
			'model'            => $data['model'],
			'variant'          => $data['variant'],
			'first_name'       => $data['first_name'],
			'last_name'        => $data['last_name'],
			'address'          => $data['address'],
			'postcode'         => $data['postcode'],
			'state'            => $data['state'],
			'mobile_number'    => $data['mobile_number'],
			'secondary_number' => $data['secondary_number'],
			'email_address'    => $data['email_address'],
		];

		$this->db->update('referrals', $update_data);
	}

	public function update_referral_admin ($data)
	{
		$this->db->where('id_referral', $data['hidden_id']);

		$update_data = [
			'make'             => $data['make'],
			'model'            => $data['model'],
			'variant'          => $data['variant'],
			'first_name'       => $data['first_name'],
			'last_name'        => $data['last_name'],
			'address'          => $data['address'],
			'postcode'         => $data['postcode'],
			'state'            => $data['state'],
			'mobile_number'    => $data['mobile_number'],
			'secondary_number' => $data['secondary_number'],
			'email_address'    => $data['email_address'],
			'status'           => $data['status']
		];

		$this->db->update('referrals', $update_data);
	}
	
	public function get_token_infos ($user_id)
	{
		return $this->db->get_where('customer_token', array('fk_user'=> $user_id, 'deprecated' => 0))->result_array();
	}

	public function get_token ($user_id)
	{
		return $this->db->get_where('customer_token', array('id' => $user_id))->row_array();
	}

	public function insert_token_info ($data)
	{
		$reply = [
			'status' => FALSE,
			'id' => 0
		];

		if($this->db->insert('customer_token', $data))
		{
			$id = $this->db->insert_id();

			$reply['status'] = TRUE;
			$reply['id']     = $id;
		}

		return $reply;
	}

	public function delete_token ($user_id)
	{
		$data = array(
			'deprecated' => 1
		);

		$this->db->where('id', $user_id);
		$this->db->update('customer_token', $data);

		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function update_picture ($user_id, $image)
	{	
		$this->db->where( 'id_user', $user_id );
		$data = array( 'profile_image' => str_replace( "[removed]", "data:image/jpeg;base64,", $image ) );
		return $this->db->update( 'users', $data );
	}

	public function get_quote_audit_trail ($id)
	{
		$query = "select 
				 at.fk_user, at.trail, at.created_at, u.name
				from audit_trail `at`
				join users u on at.fk_user = u.id_user
				where at.fk_main = {$id} and `at`.`table_name` = 'quotes'";

		return $this->db->query($query)->result_array();
	}

	public function get_tradein_data ($id)
	{
		$query = "select 
					l.delivery_date as `temp_del_date`, t.first_name as `first_name`, t.last_name as `last_name`, t.tradein_make as `make`,
					t.tradein_model as `model`, t.tradein_build_date as `tradein_build_date`, t.tradein_variant as `variant`, t.tradein_colour as `colour`, t.upload_key as `key`, t.`image_1`, t.`image_2`, t.`image_3`, t.`image_4`
					from tradeins t 
					join leads l on t.fk_lead = l.id_lead where t.id_tradein = {$id}";

		return $this->db->query($query)->row_array();
	}

	public function get_tradein_documents($tradein_id)
	{
		$query = "select * from tradein_documents_upload where fk_lead = {$tradein_id}";

		return $this->db->query($query)->result_array();
	}

	public function get_latest_pdf($lead_id)
	{
		$query = "SELECT *, SUBSTRING_INDEX(path, '/', -1) as `simple_path` FROM pdfs 
					WHERE fk_main = {$lead_id} 
					AND pdf_type = 'TEMP_RBO'
					ORDER BY fk_main DESC LIMIT 1;";

		return $this->db->query($query)->row_array();
	}

	public function create_new_signature($id, $path)
	{
		$this->db->where('id_user', $id);

		$update_array = [
			'signature_image' => $path
		];

		$this->db->update('users', $update_array);
	}

	public function client_create_new_signature($lead_id, $path)
	{
		$this->db->where('id_lead', $lead_id);

		$update_array = [
			'client_signature' => $path
		];

		$this->db->update('leads', $update_array);
	}

	public function get_user_signature($user_id)
	{
		$query = "select signature_image from users where id_user = {$user_id}";

		return $this->db->query($query)->row_array();
	}

	public function get_client_signature($lead_id)
	{
		$query = "select client_signature from leads where id_lead = {$lead_id}";

		return $this->db->query($query)->row_array();
	}

	public function submit_quote_request_validator($quote_request_id, $user_id, $demo)
	{
		$query = "select * from quotes where fk_quote_request = {$quote_request_id} and fk_user = {$user_id} and demo = '{$demo}' limit 1";

		return $this->db->query($query)->result_array();
	}

	public function get_tradein_details_quote ($lead_id)
	{
		$query = "select * from tradeins where fk_lead = {$lead_id} and dealer_visibility = 1;";
		return $this->db->query($query)->result_array();
	}

	public function getRow($table='',$where=array())
	{
		if($table != '')
		{
			$this->db->select("*");
			$this->db->from($table);
			if(!empty($where))
			{
				$this->db->where($where);
				$result = $this->db->get();
				return $result->row();
			}
		}
		else
		{
			return false;
		}
	}
    
	public function updateRow($table,$data,$where)
	{
		$res = $this->db->update($table, $data,$where);
		if($res)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
    
    public function insert($table_name,$data_array){
		if($this->db->insert($table_name,$data_array)) {
			return $this->db->insert_id();
		}
		return false;
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
    
    function get_id_by_val($table,$id_column,$column,$column_val){
		$this->db->select($id_column);
		$this->db->from($table);
		$this->db->where($column,$column_val);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row()->$id_column;
		} else {
			return null;
		}
	}
}
