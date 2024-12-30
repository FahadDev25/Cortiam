<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Backend Process controller
 *
 * The base controller which process page actions of the Cortiam Web Application Backend Panel
 *
 * @package    Cortiam Web Application
 * @subpackage Controllers
 * @category   Controllers
 * @copyright  Copyright (c) 2021, The Webb Enterprises Inc.
 * @author     The Webb Enterprises Dev Team
 * @link       http://www.thewebbenterprises.com
 * @since      Version 1.0
 *
 */

class Backendprocess extends CRTM_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('backend_model');
		$this->load->helper(array('backend'));

		if ($this->ion_auth->logged_in() && ($this->ion_auth->get_user_type() == 'Administrator'))	{
			$this->page_data["account"] =  $this->account = $this->backend_model->get_administrator($this->ion_auth->get_user_id());
		}else{
			redirect('/login', 'refresh');
		}
	}

	/**
	 * Lists of administrator accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function save_settings(){
		foreach ($this->input->post("setting") as $key => $setting) {
			if (!$setting) {$response["errorfields"]['setting-'.$key] = true;}
		}
		foreach ($this->input->post("states") as $key => $state) {
			if (!$state) {$response["errorfields"]['state-'.$key] = true;}
		}
		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = 'Please fill out all the required/missing fields and try again.';
		}else{
			foreach ($this->input->post("setting") as $key => $setting) {
				$this->backend_model->update_setting($key, array('setting_value' => $setting));
			}
			foreach ($this->input->post("states") as $key => $state) {
				$this->backend_model->update_state_cost($key, array('cost' => $state));
			}
			$this->session->set_flashdata('notify', 'success');
			$this->session->set_flashdata('notify_message', 'System settings updated succesfully.');
			$this->session->set_flashdata('notify_title', 'Update System Settings');
			$response["success"] = true;
			$response["redirect_to"] = base_url('ct-admin/settings');
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of administrator accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function save_free_payment_periods(){
		foreach ($this->input->post("days") as $key => $state) {
			if (!$state) {$response["errorfields"]['stset-'.$key] = true;}
		}
		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = 'Please fill out all the required/missing fields and try again.';
		}else{
			foreach ($this->input->post("days") as $key => $state) {
				$this->backend_model->update_state_cost($key, array('free_days' => $state, 'free_period' => (($_POST['enable'][$key] == 'on')? 'Yes':'No')));
			}
			$this->session->set_flashdata('notify', 'success');
			$this->session->set_flashdata('notify_message', 'Free payment periods updated succesfully.');
			$this->session->set_flashdata('notify_title', 'Free Payment Periods');
			$response["success"] = true;
			$response["redirect_to"] = base_url('ct-admin/free-period');
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of administrator accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function save_state_signups(){
		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = 'Please fill out all the required/missing fields and try again.';
		}else{
			foreach ($this->input->post("enable") as $key => $state) {
				$this->backend_model->update_state_cost($key, array('signup' => (($_POST['enable'][$key] == 'on')? 'Enabled':'Disabled')));
			}
			$this->session->set_flashdata('notify', 'success');
			$this->session->set_flashdata('notify_message', 'Signup Settings updated succesfully.');
			$this->session->set_flashdata('notify_title', 'Signup Settings');
			$response["success"] = true;
			$response["redirect_to"] = base_url('ct-admin/state-signup');
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of administrator accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_admins(){
		if ($accounts = $this->backend_model->get_administrators($this->input->post("status"))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["id"];
	    	$response['data'][$key]['user_image'] = '<img class="img-fluid rounded-circle" src="'.(($account['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$account['avatar_string'])):base_url('images/userphoto_mini.jpg')).'" width="40" height="40" alt="">';
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['status'] = (($account["active"] == 1)? '<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Inactive</span>');
	    	$response['data'][$key]['created_on'] = date("F jS, Y",$account["created_on"]);
	    	$response['data'][$key]['actions'] = ((($this->account['permissions'][30] == 'Yes') || ($this->account['permissions'][40] == 'Yes'))? '<div class="btn-group btn-block"><button class="btn btn-clean btn-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-clipboard"></i> Actions</button>
	    	<div class="dropdown-menu dropdown-menu-right p-0">'
					.(($this->account['permissions'][30] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/edit-administrator/'.$account["id"]).'"><i class="icon-pencil7"></i> Edit Details</a>':'')
					.(($this->account['permissions'][41] == 'Yes' && ($account["active"] == 1))? '<a class="dropdown-item text-warning acdisableaccount" href="#" data-record="'.$account["id"].'"><i class="icon-pause"></i> Disable Account</a>':'')
					.(($this->account['permissions'][41] == 'Yes' && ($account["active"] == 2))? '<a class="dropdown-item text-danger acenableaccount" href="#" data-record="'.$account["id"].'"><i class="icon-play3"></i> Enable Account</a>':'')
					.(($this->account['permissions'][40] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$account["id"].'"><i class="icon-cancel-square"></i> Delete Account</a>':'')
				.'</div>
			</div>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new administrator account
	 * @uses system_model::add_admin To add details of admin account
	 *
	 * @return json true or false
	 */
	public function add_administrator(){
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}
		if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
		if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Confirmation";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif(($this->input->post("address") && $this->input->post("city") && $this->input->post("state") && $this->input->post("zipcode")) && (!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit")))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}else{
			$additional_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'first_name' => $this->input->post("first_name"),
				'last_name' => $this->input->post("last_name"),
				'phone' => (($this->input->post("phone"))? $this->input->post("phone"):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'avatar_string' => 'images/avatar/'.uniqid('adm_',true).'.jpg',
				'permissions' => (($this->input->post("permissions"))? serialize($this->input->post("permissions")):null),
				'notifications' => (($this->input->post("notifications"))? serialize($this->input->post("notifications")):null),
			);
			if ($hesapid = $this->ion_auth->register($this->input->post("email"), $this->input->post("password"), $this->input->post("email"), array('user_type' => 'Administrator', 'approval_date' => time(), 'approval' => 'Completed'))) {
				$additional_data['admin_id'] = $hesapid;
				$this->backend_model->add_administrator($additional_data);
				$this->create_avatar($additional_data['avatar_string'],$additional_data['first_name'],$additional_data['last_name']);
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $this->input->post("first_name").' '.$this->input->post("last_name").'\'s account added succesfully.');
				$this->session->set_flashdata('notify_title', 'New Administrator Account');
				$admin_email_text = '<h3 style="color:#4c525e;">NEW ADMINISTRATOR ACCOUNT</h3><p style="color:#848994;">New administrator accounts have been created for '.$additional_data['first_name'].' '.$additional_data['last_name'].' on Cortiam. For more details please login to Cortiam to check this administrator account.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(20);
				$this->backend_model->add_notification($admin_emails, 'New Administrator Account Created', 'New administrator accounts have been created for '.$additional_data['first_name'].' '.$additional_data['last_name'].' on Cortiam.', 'admin_review', $hesapid);
				$this->mailer->regular_email('New Administrator Account Created', $admin_email_text, $admin_emails);

				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-administrator');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new administrator account
	 * @uses system_model::add_admin To add details of admin account
	 *
	 * @return json true or false
	 */
	public function edit_administrator(){
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif(($this->input->post("address") && $this->input->post("city") && $this->input->post("state") && $this->input->post("zipcode")) && (!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit")))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}elseif(($this->input->post("password")) && ($this->input->post("password") != $this->input->post("passwordagain"))){
			if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
			if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Again";}
			$response["fail"] = true;
			$response["fail_title"] = 'Password Doesnt Match!';
			$response["fail_message"] = 'Password confirmation and password must match. Please check out password fields and try again.';
		}else{
			$additional_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'first_name' => $this->input->post("first_name"),
				'last_name' => $this->input->post("last_name"),
				'phone' => (($this->input->post("phone"))? $this->input->post("phone"):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'permissions' => (($this->input->post("permissions"))? serialize($this->input->post("permissions")):null),
				'notifications' => (($this->input->post("notifications"))? serialize($this->input->post("notifications")):null),
			);
			if ($hesapid = $this->ion_auth->update($this->input->post("recordID"), array('email' => $this->input->post("email")))) {
				$this->backend_model->edit_administrator($this->input->post("recordID"), $additional_data);
				$this->create_avatar($this->input->post("avatar_string"),$this->input->post("first_name"),$this->input->post("last_name"));

				if ($this->input->post('password')){
					$this->ion_auth->change_password($this->input->post("email"),$this->input->post('password'));
				}

				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $this->input->post("first_name").' '.$this->input->post("last_name").'\'s account details updated succesfully.');
				$this->session->set_flashdata('notify_title', 'Edit Administrator Account');
				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-administrator');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_administrator(){
		if ($account_id = $this->input->post("recordID")) {
			$removeduser = $this->backend_model->get_administrator($account_id);
			$data = array(
				'active' => 0,
				'email' => uniqid('email_').uniqid().'@deleted.com',
				'deleted_email' => $removeduser['email'],
			);
			if ($this->ion_auth->update($account_id, $data)) {
				$admin_email_text = '<h3 style="color:#4c525e;">DELETED ADMINISTRATOR ACCOUNT</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account has been deleted on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(30);
				$this->backend_model->add_notification($admin_emails, 'Administrator Account Deleted', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account has been deleted on Cortiam.');
				$this->mailer->regular_email('Administrator Account Deleted', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account deleted succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Disables selected account
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function enable_administrator(){
		if ($account_id = $this->input->post("recordID")) {
			if ($this->ion_auth->update($account_id, array('active' => 1))) {
				$removeduser = $this->backend_model->get_administrator($account_id);
				$admin_email_text = '<h3 style="color:#4c525e;">ADMINISTRATOR ACCOUNT ENABLED</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account is now enabled on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(31);
				$this->backend_model->add_notification($admin_emails, 'Administrator Account Enabled', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account is now enabled on Cortiam.', 'admin_review', $account_id);
				$this->mailer->regular_email('Administrator Account Enabled', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Account Enabled Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account enabled succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Disables selected account
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function disable_administrator(){
		if ($account_id = $this->input->post("recordID")) {
			if ($this->ion_auth->update($account_id, array('active' => 2))) {
				$removeduser = $this->backend_model->get_administrator($account_id);
				$admin_email_text = '<h3 style="color:#4c525e;">ADMINISTRATOR ACCOUNT DISABLED</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account has been disabled on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(31);
				$this->backend_model->add_notification($admin_emails, 'Administrator Account Disabled', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account has been disabled on Cortiam.', 'admin_review', $account_id);
				$this->mailer->regular_email('Administrator Account Disabled', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Account Disabled Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s administrator account disabled succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}


	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_sellers(){
		if ($accounts = $this->backend_model->get_sellers($this->input->post("status"))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["id"];
	    	$response['data'][$key]['user_image'] = '<img class="img-fluid rounded-circle" src="'.(($account['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$account['avatar_string'])):base_url('images/userphoto_mini.jpg')).'" width="40" height="40" alt="">';
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['location'] = $account["city"].', '.$account["state"];
	    	$response['data'][$key]['status'] = (($account["active"] == 1)? '<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Inactive</span>');
	    	$response['data'][$key]['created_on'] = date("F jS, Y",$account["created_on"]);
	    	$response['data'][$key]['actions'] = ((($this->account['permissions'][210] == 'Yes') || ($this->account['permissions'][230] == 'Yes'))? '<div class="btn-group btn-block"><button class="btn btn-clean btn-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-clipboard"></i> Actions</button>
	    	<div class="dropdown-menu dropdown-menu-right p-0">'
					.(($this->account['permissions'][210] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/edit-seller/'.$account["id"]).'"><i class="icon-pencil7"></i> Edit Details</a>':'')
					.(($this->account['permissions'][231] == 'Yes' && ($account["active"] == 1))? '<a class="dropdown-item text-warning acdisableaccount" href="#" data-record="'.$account["id"].'"><i class="icon-pause"></i> Disable Account</a>':'')
					.(($this->account['permissions'][231] == 'Yes' && ($account["active"] == 2))? '<a class="dropdown-item text-danger acenableaccount" href="#" data-record="'.$account["id"].'"><i class="icon-play3"></i> Enable Account</a>':'')
					.(($this->account['permissions'][230] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$account["id"].'"><i class="icon-cancel-square"></i> Delete Account</a>':'')
				.'</div>
			</div>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function add_seller(){

			echo "i'm here...";
			exit;

		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}
		if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
		if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Confirmation";}



		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}else{
			$additional_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'first_name' => $this->input->post("first_name"),
				'last_name' => $this->input->post("last_name"),
				'phone' => (($this->input->post("phone"))? $this->input->post("phone"):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'avatar_string' => 'images/avatar/'.uniqid('usr_',true).'.jpg',
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
			);
			if ($hesapid = $this->ion_auth->register($this->input->post("email"), $this->input->post("password"), $this->input->post("email"), array('user_type' => 'Seller', 'approval' => 'Completed', 'approval_date' => time()))) {
				$additional_data['seller_id'] = $hesapid;
				$this->backend_model->add_seller($additional_data);
				$this->create_avatar($additional_data['avatar_string'],$additional_data['first_name'],$additional_data['last_name']);
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $this->input->post("first_name").' '.$this->input->post("last_name").'\'s account added succesfully.');
				$this->session->set_flashdata('notify_title', 'New Seller Account');
				$admin_email_text = '<h3 style="color:#4c525e;">NEW SELLER ACCOUNT</h3><p style="color:#848994;">'.$additional_data['first_name'].' '.$additional_data['last_name'].' created new property owner account on Cortiam.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(70);
				$this->backend_model->add_notification($admin_emails, 'New Property Owner Account Created', $additional_data['first_name'].' '.$additional_data['last_name'].' created new property owner account on Cortiam.', 'seller_edit', $hesapid);
				$this->mailer->regular_email('New Property Owner Account Created', $admin_email_text, $admin_emails);

				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-seller');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function edit_seller(){
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}elseif(($this->input->post("password")) && ($this->input->post("password") != $this->input->post("passwordagain"))){
			if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
			if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Again";}
			$response["fail"] = true;
			$response["fail_title"] = 'Password Doesnt Match!';
			$response["fail_message"] = 'Password confirmation and password must match. Please check out password fields and try again.';
		}else{
			$additional_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'first_name' => $this->input->post("first_name"),
				'last_name' => $this->input->post("last_name"),
				'phone' => (($this->input->post("phone"))? $this->input->post("phone"):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
			);
			if ($hesapid = $this->ion_auth->update($this->input->post("recordID"), array('email' => $this->input->post("email")))) {
				$this->backend_model->edit_seller($this->input->post("recordID"), $additional_data);
				$this->create_avatar($this->input->post("avatar_string"),$this->input->post("first_name"),$this->input->post("last_name"));

				if ($this->input->post('password')){
					$this->ion_auth->change_password($this->input->post("email"),$this->input->post('password'));
				}

				$response["success"] = true;
				if ($this->input->post("edittype") == 'approval') {
					$response["success_title"] = 'Edit Seller Account';
					$response["success_message"] =  $this->input->post("first_name").' '.$this->input->post("last_name").'\'s account details updated succesfully.';
				}else{
					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', $this->input->post("first_name").' '.$this->input->post("last_name").'\'s account details updated succesfully.');
					$this->session->set_flashdata('notify_title', 'Edit Seller Account');
					$response["redirect_to"] = base_url('ct-admin/list-seller');
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_seller(){
		if ($account_id = $this->input->post("recordID")) {
			$removeduser = $this->backend_model->get_seller($account_id);
			$data = array(
				'active' => 0,
				'email' => uniqid('email_').uniqid().'@deleted.com',
				'deleted_email' => $removeduser['email'],
			);
			if ($this->ion_auth->update($account_id, $data)) {
				$admin_email_text = '<h3 style="color:#4c525e;">DELETED PROPERTY OWNER ACCOUNT</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account has been deleted on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(90);
				$this->backend_model->add_notification($admin_emails, 'Property Owner Account Deleted', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account has been deleted on Cortiam.');
				$this->mailer->regular_email('Property Owner Account Deleted', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account deleted succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}


	/**
	 * Disables selected account
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function enable_seller(){
		if ($account_id = $this->input->post("recordID")) {
			if ($this->ion_auth->update($account_id, array('active' => 1))) {
				$removeduser = $this->backend_model->get_seller($account_id);
				$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY OWNER ACCOUNT ENABLED</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account is now enabled on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(91);
				$this->backend_model->add_notification($admin_emails, 'Property Owner Account Enabled', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account is now enabled on Cortiam.', 'seller_edit', $account_id);
				$this->mailer->regular_email('Property Owner Account Enabled', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Account Enabled Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account enabled succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Disables selected account
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function disable_seller(){
		if ($account_id = $this->input->post("recordID")) {
			if ($this->ion_auth->update($account_id, array('active' => 2))) {
				$removeduser = $this->backend_model->get_seller($account_id);
				$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY OWNER ACCOUNT DISABLED</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account has been disabled on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(91);
				$this->backend_model->add_notification($admin_emails, 'Property Owner Account Disabled', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account has been disabled on Cortiam.', 'seller_edit', $account_id);
				$this->mailer->regular_email('Property Owner Account Disabled', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Account Disabled Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s property owner account disabled succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_agents(){
		if ($accounts = $this->backend_model->get_agents($this->input->post("status"))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["id"];
	    	$response['data'][$key]['user_image'] = '<img class="img-fluid rounded-circle" src="'.(($account['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$account['avatar_string'])):base_url('images/userphoto_mini.jpg')).'" width="40" height="40" alt="">';
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['location'] = $account["city"].', '.$account["state"];
	    	$response['data'][$key]['brokerage'] = $account["brokerage_name"];
	    	$response['data'][$key]['interested'] = $account["interested"];
	    	$response['data'][$key]['status'] = ((($account["license_expires"] < time()) && ($account["license_expires"]))? '<span class="badge badge-danger">Expired</span>':(($account["active"] == 1)? '<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Inactive</span>'));
	    	$response['data'][$key]['created_on'] = date("F jS, Y",$account["created_on"]);
	    	$response['data'][$key]['actions'] = ((($this->account['permissions'][80] == 'Yes') || ($this->account['permissions'][100] == 'Yes'))? '<div class="btn-group btn-block"><button class="btn btn-clean btn-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-clipboard"></i> Actions</button>
	    	<div class="dropdown-menu dropdown-menu-right p-0">'
					.(($this->account['permissions'][80] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/edit-agent/'.$account["id"]).'"><i class="icon-pencil7"></i> Edit Details</a>':'')
					.(($this->account['permissions'][101] == 'Yes' && ($account["active"] == 1))? '<a class="dropdown-item text-warning acdisableaccount" href="#" data-record="'.$account["id"].'"><i class="icon-pause"></i> Disable Account</a>':'')
					.(($this->account['permissions'][101] == 'Yes' && ($account["active"] == 2))? '<a class="dropdown-item text-danger acenableaccount" href="#" data-record="'.$account["id"].'"><i class="icon-play3"></i> Enable Account</a>':'')
					.(($this->account['permissions'][100] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$account["id"].'"><i class="icon-cancel-square"></i> Delete Account</a>':'')
				.'</div>
			</div>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new agent account
	 * @uses system_model::add_agent To add details of agent account
	 *
	 * @return json true or false
	 */
	public function add_agent(){
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}
		if (!$this->input->post("phone")) {$response["errorfields"]['phone'] = "Phone Number";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}
		if (!$this->input->post("experience")) {$response["errorfields"]['experience'] = "First Year Licensed";}
		if (!$this->input->post("license_number")) {$response["errorfields"]['license_number'] = "License Number";}
		if (!$this->input->post("license_expires")) {$response["errorfields"]['license_expires'] = "License Expiration Date";}
		if (!$this->input->post("license_states")) {$response["errorfields"]['license_states'] = "State Licensed";}
		if (!$this->input->post("interested")) {$response["errorfields"]['interested'] = "Real Estate Focus";}
		if (!$this->input->post("brokerage_name")) {$response["errorfields"]['brokerage_name'] = "Brokerage Name";}
		if (!$this->input->post("brokerage_address")) {$response["errorfields"]['brokerage_address'] = "Brokerage Address";}
		if (!$this->input->post("brokerage_city")) {$response["errorfields"]['brokerage_city'] = "Brokerage City";}
		if (!$this->input->post("brokerage_state")) {$response["errorfields"]['brokerage_state'] = "Brokerage State";}
		if (!$this->input->post("brokerage_zipcode")) {$response["errorfields"]['brokerage_zipcode'] = "Brokerage ZIP Code";}
		if (!$this->input->post("brokerage_phone")) {$response["errorfields"]['brokerage_phone'] = "Brokerage Phone Number";}
		if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
		if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Confirmation";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("brokerage_zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid Brokerage ZIP Code';
			$response["fail_message"] = 'Your Brokerage ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}elseif(!$brokage_loc_data = geolocate_address($this->input->post("brokerage_city"),$this->input->post("brokerage_state"),$this->input->post("brokerage_zipcode"),$this->input->post("brokerage_address"),$this->input->post("brokerage_unit"))){
			if ($this->input->post("brokerage_address")) {$response["errorfields"]['brokerage_address'] = "Brokerage Address";}
			if ($this->input->post("brokerage_city")) {$response["errorfields"]['brokerage_city'] = "Brokerage City";}
			if ($this->input->post("brokerage_state")) {$response["errorfields"]['brokerage_state'] = "Brokerage State";}
			if ($this->input->post("brokerage_zipcode")) {$response["errorfields"]['brokerage_zipcode'] = "Brokerage Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address for brokage information. Please check your address details and try again.';
		}elseif(strtotime($this->input->post("license_expires")) < time()){
			$response["errorfields"]['license_expires'] = "License Expiration Date";
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid Expiration Date!';
			$response["fail_message"] = 'License expiration date cannot be earlier than today. Please check&fix your license expiration date and try again.';
		}else{
			$additional_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'first_name' => $this->input->post("first_name"),
				'last_name' => $this->input->post("last_name"),
				'phone' => (($this->input->post("phone"))? $this->input->post("phone"):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'experience' => (($this->input->post("experience"))? $this->input->post("experience"):null),
				'estate_specialization' => (($this->input->post("estate_specialization"))? $this->input->post("estate_specialization"):null),
				'bio' => (($this->input->post("bio"))? $this->input->post("bio"):null),
				'facebook' => (($this->input->post("facebook"))? $this->input->post("facebook"):null),
				'linkedin' => (($this->input->post("linkedin"))? $this->input->post("linkedin"):null),
				'twitter' => (($this->input->post("twitter"))? $this->input->post("twitter"):null),
				'google' => (($this->input->post("google"))? $this->input->post("google"):null),
				'avatar_string' => (($this->input->post("avatar_string"))? $this->input->post("avatar_string"):null),
				'instagram' => (($this->input->post("instagram"))? $this->input->post("instagram"):null),
				'brokerage_name' => (($this->input->post("brokerage_name"))? $this->input->post("brokerage_name"):null),
				'brokerage_address' => (($this->input->post("brokerage_address"))? $this->input->post("brokerage_address"):null),
				'brokerage_unit' => (($this->input->post("brokerage_unit"))? $this->input->post("brokerage_unit"):null),
				'brokerage_city' => (($this->input->post("brokerage_city"))? $this->input->post("brokerage_city"):null),
				'brokerage_state' => (($this->input->post("brokerage_state"))? $this->input->post("brokerage_state"):null),
				'brokerage_zipcode' => (($this->input->post("brokerage_zipcode"))? $this->input->post("brokerage_zipcode"):null),
				'brokerage_phone' => (($this->input->post("brokerage_phone"))? $this->input->post("brokerage_phone"):null),
				'youtube_video' => (($this->input->post("youtube_video"))? $this->input->post("youtube_video"):null),
				'brokage_latitude' => (($brokage_loc_data['latitude'])? $brokage_loc_data['latitude']:null),
				'brokage_longitude' => (($brokage_loc_data['longitude'])? $brokage_loc_data['longitude']:null),
			);
			if ($hesapid = $this->ion_auth->register($this->input->post("email"), $this->input->post("password"), $this->input->post("email"), array('user_type' => 'Agent', 'approval_date' => time()))) {
				$additional_data['agent_id'] = $hesapid;
				$this->backend_model->add_agent($additional_data);
				$record_data = array(
					'agent_id' => $hesapid,
					'license_number' => $this->input->post("license_number"),
					'license_expire' => (($this->input->post("license_expires"))? strtotime($this->input->post("license_expires")):null),
					'license_state' => $this->input->post("license_states"),
					'interested' => $this->input->post("interested"),
					'added_date' => time(),
				);
				$this->backend_model->add_license($record_data);

				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $this->input->post("first_name").' '.$this->input->post("last_name").'\'s account added succesfully.');
				$this->session->set_flashdata('notify_title', 'New Agent Account');
				$admin_email_text = '<h3 style="color:#4c525e;">NEW AGENT ACCOUNT</h3><p style="color:#848994;">'.$additional_data['first_name'].' '.$additional_data['last_name'].' has created new real estate agent account on Cortiam. Please login to Cortiam to validate this account as soon as possible.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(40);
				$this->backend_model->add_notification($admin_emails, 'New Real Estate Agent Account Created', $additional_data['first_name'].' '.$additional_data['last_name'].' has created new real estate agent account on Cortiam.', 'agent_review', $hesapid);
				$this->mailer->regular_email('New Real Estate Agent Account Created', $admin_email_text, $admin_emails);

				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-agent');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new agent account
	 * @uses system_model::add_agent To add details of agent account
	 *
	 * @return json true or false
	 */
	public function edit_agent(){


		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}
		if (!$this->input->post("phone")) {$response["errorfields"]['phone'] = "Phone Number";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}
		if (!$this->input->post("experience")) {$response["errorfields"]['experience'] = "First Year Licensed";}
		if (!$this->input->post("brokerage_name")) {$response["errorfields"]['brokerage_name'] = "Brokerage Name";}
		if (!$this->input->post("brokerage_address")) {$response["errorfields"]['brokerage_address'] = "Brokerage Address";}
		if (!$this->input->post("brokerage_city")) {$response["errorfields"]['brokerage_city'] = "Brokerage City";}
		if (!$this->input->post("brokerage_state")) {$response["errorfields"]['brokerage_state'] = "Brokerage State";}
		if (!$this->input->post("brokerage_zipcode")) {$response["errorfields"]['brokerage_zipcode'] = "Brokerage ZIP Code";}
		if (!$this->input->post("brokerage_phone")) {$response["errorfields"]['brokerage_phone'] = "Brokerage Phone Number";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("brokerage_zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid Brokerage ZIP Code';
			$response["fail_message"] = 'Your Brokerage ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}elseif(!$brokage_loc_data = geolocate_address($this->input->post("brokerage_city"),$this->input->post("brokerage_state"),$this->input->post("brokerage_zipcode"),$this->input->post("brokerage_address"),$this->input->post("brokerage_unit"))){
			if ($this->input->post("brokerage_address")) {$response["errorfields"]['brokerage_address'] = "Brokerage Address";}
			if ($this->input->post("brokerage_city")) {$response["errorfields"]['brokerage_city'] = "Brokerage City";}
			if ($this->input->post("brokerage_state")) {$response["errorfields"]['brokerage_state'] = "Brokerage State";}
			if ($this->input->post("brokerage_zipcode")) {$response["errorfields"]['brokerage_zipcode'] = "Brokerage Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address for brokage information. Please check your address details and try again.';
		}elseif(($this->input->post("password")) && ($this->input->post("password") != $this->input->post("passwordagain"))){
			if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
			if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Again";}
			$response["fail"] = true;
			$response["fail_title"] = 'Password Doesnt Match!';
			$response["fail_message"] = 'Password confirmation and password must match. Please check out password fields and try again.';
		}else{
			$additional_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'first_name' => $this->input->post("first_name"),
				'last_name' => $this->input->post("last_name"),
				'offer_limit' => $this->input->post("offer_limit"),
				'offer_remain' => $this->input->post("offer_remain"),
				'win_limit' => $this->input->post("win_limit"),
				'win_remain' => $this->input->post("win_remain"),
				'membership_fee' => (($this->input->post("membership_fee"))? $this->input->post("membership_fee"):null),
				'win_cost' => (($this->input->post("win_cost"))? $this->input->post("win_cost"):null),
				'phone' => (($this->input->post("phone"))? $this->input->post("phone"):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'experience' => (($this->input->post("experience"))? $this->input->post("experience"):null),
				'estate_specialization' => (($this->input->post("estate_specialization"))? $this->input->post("estate_specialization"):null),
				'bio' => (($this->input->post("bio"))? $this->input->post("bio"):null),
				'facebook' => (($this->input->post("facebook"))? $this->input->post("facebook"):null),
				'linkedin' => (($this->input->post("linkedin"))? $this->input->post("linkedin"):null),
				'twitter' => (($this->input->post("twitter"))? $this->input->post("twitter"):null),
				'google' => (($this->input->post("google"))? $this->input->post("google"):null),
				'instagram' => (($this->input->post("instagram"))? $this->input->post("instagram"):null),
				'brokerage_name' => (($this->input->post("brokerage_name"))? $this->input->post("brokerage_name"):null),
				'brokerage_address' => (($this->input->post("brokerage_address"))? $this->input->post("brokerage_address"):null),
				'brokerage_unit' => (($this->input->post("brokerage_unit"))? $this->input->post("brokerage_unit"):null),
				'brokerage_city' => (($this->input->post("brokerage_city"))? $this->input->post("brokerage_city"):null),
				'brokerage_state' => (($this->input->post("brokerage_state"))? $this->input->post("brokerage_state"):null),
				'brokerage_zipcode' => (($this->input->post("brokerage_zipcode"))? $this->input->post("brokerage_zipcode"):null),
				'brokerage_phone' => (($this->input->post("brokerage_phone"))? $this->input->post("brokerage_phone"):null),
				'youtube_video' => (($this->input->post("youtube_video"))? $this->input->post("youtube_video"):null),
				'brokage_latitude' => (($brokage_loc_data['latitude'])? $brokage_loc_data['latitude']:null),
				'brokage_longitude' => (($brokage_loc_data['longitude'])? $brokage_loc_data['longitude']:null),
			);
			if ($hesapid = $this->ion_auth->update($this->input->post("recordID"), array('email' => $this->input->post("email")))) {
				$this->backend_model->edit_agent($this->input->post("recordID"), $additional_data);

				if ($this->input->post('password')){
					$this->ion_auth->change_password($this->input->post("email"),$this->input->post('password'));
				}

				$response["success"] = true;
				if ($this->input->post("edittype") == 'approval') {
					$response["success_title"] = 'Edit Agent Account';
					$response["success_message"] =  $this->input->post("first_name").' '.$this->input->post("last_name").'\'s real estate agent account details updated succesfully.';
				}else{
					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', $this->input->post("first_name").' '.$this->input->post("last_name").'\'s account details updated succesfully.');
					$this->session->set_flashdata('notify_title', 'Edit Agent Account');
					$response["redirect_to"] = base_url('ct-admin/list-agent');
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_agent(){
		if ($account_id = $this->input->post("recordID")) {
			$removeduser = $this->backend_model->get_agent($account_id);
			$data = array(
				'active' => 0,
				'email' => uniqid('email_').uniqid().'@deleted.com',
				'deleted_email' => $removeduser['email'],
			);
			if ($this->ion_auth->update($account_id, $data)) {
				if ($removeduser['approval'] == 'Waiting') {
					$admin_email_text = '<h3 style="color:#4c525e;">DELETED AGENT ACCOUNT APPLICATION</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account application has been deleted on Cortiam.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->backend_model->get_notified(60);
					$this->backend_model->add_notification($admin_emails, 'Real Estate Agent Account Application Deleted', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account application has been deleted on Cortiam.');
					$this->mailer->regular_email('Real Estate Agent Account Application Deleted', $admin_email_text, $admin_emails);

					$response["success"] = true;
					$response["redirect_to"] = base_url('ct-admin/approval-agents');
					$response["success_title"] = 'Deleted Succesfully';
					$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account application deleted succesfully.';
				}else{
					$admin_email_text = '<h3 style="color:#4c525e;">DELETED AGENT ACCOUNT</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account has been deleted on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->backend_model->get_notified(60);
					$this->backend_model->add_notification($admin_emails, 'Real Estate Agent Account Deleted', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account has been deleted on Cortiam.');
					$this->mailer->regular_email('Real Estate Agent Account Deleted', $admin_email_text, $admin_emails);

					$response["success"] = true;
					$response["success_title"] = 'Deleted Succesfully';
					$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account deleted succesfully.';
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_awaitings(){
		if ($accounts = $this->backend_model->get_awaitings()){
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["id"];
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['city'] = $account["city"];
	    	$response['data'][$key]['state'] = $account["state"];
	    	$response['data'][$key]['user_type'] = $account["user_type"];
	    	$response['data'][$key]['created_on'] = date("F jS, Y",$account["signup_time"]);
	    	$response['data'][$key]['actions'] = (($this->account['permissions'][262] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$account["id"].'"><i class="icon-cancel-square mr-1"></i>Delete</a>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_awaiting(){
		if ($account_id = $this->input->post("recordID")) {
			$removeduser = $this->backend_model->get_awaiting($account_id);
			if ($this->backend_model->delete_awaiting($account_id)) {
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s account has been deleted from awaiting users succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Disables selected account
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function enable_agent(){
		if ($account_id = $this->input->post("recordID")) {
			if ($this->ion_auth->update($account_id, array('active' => 1))) {
				$removeduser = $this->backend_model->get_agent($account_id);
				$admin_email_text = '<h3 style="color:#4c525e;">AGENT ACCOUNT ENABLED</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account is now enabled on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(61);
				$this->backend_model->add_notification($admin_emails, 'Real Estate Agent Account Enabled', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account is now enabled on Cortiam.', 'agent_edit', $account_id);
				$this->mailer->regular_email('Real Estate Agent Account Enabled', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Account Enabled Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account enabled succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Disables selected account
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function disable_agent(){
		if ($account_id = $this->input->post("recordID")) {
			if ($this->ion_auth->update($account_id, array('active' => 2))) {
				$removeduser = $this->backend_model->get_agent($account_id);
				$admin_email_text = '<h3 style="color:#4c525e;">AGENT ACCOUNT DISABLED</h3><p style="color:#848994;">'.$removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account has been disabled on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(61);
				$this->backend_model->add_notification($admin_emails, 'Real Estate Agent Account Disabled', $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account has been disabled on Cortiam.', 'agent_edit', $account_id);
				$this->mailer->regular_email('Real Estate Agent Account Disabled', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'Account Disabled Succesfully';
				$response["success_message"] = $removeduser['first_name'].' '.$removeduser['last_name'].'\'s real estate agent account disabled succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_properties(){
		if ($properties = $this->backend_model->get_properties($this->input->post("status"))) {
	    foreach ($properties as $key => $property) {
	    	$response['data'][$key]['property_id'] = $property["property_id"];
	    	$response['data'][$key]['image'] = '<img class="img-fluid" src="'.(($property['default_image'])? base_url(str_replace(".jpg","_mini.jpg",$property['default_image'])):base_url('assets/images/backend/propertyphoto_mini.jpg')).'" width="40" height="30" alt="">';
	    	$response['data'][$key]['fullname'] = $property["first_name"].' '.$property["last_name"];
	    	$response['data'][$key]['location'] = $property["city"].', '.$property["state"];
	    	$response['data'][$key]['address'] = $property["address"].', '.$property["zipcode"];
	    	$response['data'][$key]['type'] = $property["type"];
	    	$response['data'][$key]['sub_type'] = $property["sub_type"];
	    	$response['data'][$key]['building_size'] = $property["building_size"];
	    	$response['data'][$key]['status'] = '<span class="badge badge-success">Active</span>';
	    	$response['data'][$key]['created_on'] = date("F jS, Y",$property["created_on"]);
	    	$response['data'][$key]['actions'] = ((($this->account['permissions'][290] == 'Yes') || ($this->account['permissions'][310] == 'Yes'))? '<div class="btn-group btn-block"><button class="btn btn-clean btn-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-clipboard"></i> Actions</button>
	    	<div class="dropdown-menu dropdown-menu-right p-0">'
					.(($this->account['permissions'][290] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/edit-property/'.$property["property_id"]).'"><i class="icon-pencil7"></i> Edit Details</a>':'')
					.(($this->account['permissions'][310] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$property["property_id"].'"><i class="icon-cancel-square"></i> Delete Property</a>':'')
				.'</div>
			</div>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new property account
	 * @uses system_model::add_property To add details of property
	 *
	 * @return json true or false
	 */
	public function add_property(){
		if (!$this->input->post("seller_id")) {$response["errorfields"]['seller_id'] = "Seller Account";}
		if (!$this->input->post("sub_type")) {$response["errorfields"]['sub_type'] = "Property Type";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}
		if (!$this->input->post("land_size")) {$response["errorfields"]['land_size'] = "Land Size";}
		if (!$this->input->post("building_size")) {$response["errorfields"]['building_size'] = "Building Size";}
		if (!$this->input->post("built_date")) {$response["errorfields"]['built_date'] = "Build Date";}
		if (!$this->input->post("commission_rate")) {$response["errorfields"]['commission_rate'] = "Commission Rate";}
		if (!$this->input->post("contract_length")) {$response["errorfields"]['contract_length'] = "Contract Length";}
		if ($this->input->post("type") == "on") {
			if (!$this->input->post("bedroom")) {$response["errorfields"]['bedroom'] = "Bedroom Amount";}
			if (!$this->input->post("bathroom")) {$response["errorfields"]['bathroom'] = "Bathroom Amount";}
		}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}else{
			$timestamp = time();
			$property_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'seller_id' => $this->input->post("seller_id"),
				'type' => (($this->input->post("type"))? 'Residential':'Commercial'),
				'sub_type' => $this->input->post("sub_type"),
				'approx_value' => (($this->input->post("approx_value"))? str_ireplace(",","",$this->input->post("approx_value")):null),
				'winning_fee' => (($this->input->post("winning_fee"))? str_ireplace(",","",$this->input->post("winning_fee")):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'land_size' => (($this->input->post("land_size"))? $this->input->post("land_size"):null),
				'building_size' => (($this->input->post("building_size"))? $this->input->post("building_size"):null),
				'built_date' => (($this->input->post("built_date"))? $this->input->post("built_date"):null),
				'interior_features' => (($this->input->post("interior_features"))? $this->input->post("interior_features"):null),
				'building_features' => (($this->input->post("building_features"))? $this->input->post("building_features"):null),
				'neighbourhood_features' => (($this->input->post("neighbourhood_features"))? $this->input->post("neighbourhood_features"):null),
				'lot_features' => (($this->input->post("lot_features"))? $this->input->post("lot_features"):null),
				'bedroom' => (($this->input->post("bedroom"))? $this->input->post("bedroom"):null),
				'bathroom' => (($this->input->post("bathroom"))? $this->input->post("bathroom"):null),
				'created_on' => $timestamp,
				'approval_date' => $timestamp,
				'commission_rate' => (($this->input->post("commission_rate"))? $this->input->post("commission_rate"):null),
				'contract_length' => (($this->input->post("contract_length"))? $this->input->post("contract_length"):null),
			);
			if ($property_id = $this->backend_model->add_property($property_data)) {
				$folderPath = FCPATH.'images/property/'.$property_id.'/';
				if (!file_exists($folderPath)) {
			    mkdir($folderPath, 0755, true);
				}
				if ($this->input->post("left_image")) {
					$update_data['default_image'] = $update_data['left_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("left_image"));
					rename(FCPATH.$this->input->post("left_image"),FCPATH.$update_data['left_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("left_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['left_image']));
				}
				if ($this->input->post("right_image")) {
					$update_data['default_image'] = $update_data['right_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("right_image"));
					rename(FCPATH.$this->input->post("right_image"),FCPATH.$update_data['right_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("right_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['right_image']));
				}
				if ($this->input->post("rear_image")) {
					$update_data['default_image'] = $update_data['rear_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("rear_image"));
					rename(FCPATH.$this->input->post("rear_image"),FCPATH.$update_data['rear_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("rear_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['rear_image']));
				}
				if ($this->input->post("front_image")) {
					$update_data['default_image'] = $update_data['front_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("front_image"));
					rename(FCPATH.$this->input->post("front_image"),FCPATH.$update_data['front_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("front_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['front_image']));
				}
				if ($update_data) {
					$this->backend_model->edit_property($property_id, $update_data);
				}
				$admin_email_text = '<h3 style="color:#4c525e;">NEW PROPERTY</h3><p style="color:#848994;">New  '.(($this->input->post("type") == "on")? 'Residental':'Commercial').' property has been added on Cortiam. Please login to Cortiam to validate this property as soon as possible.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(100);
				$this->backend_model->add_notification($admin_emails, 'Property Needs Approval', 'New  '.(($this->input->post("type") == "on")? 'Residental':'Commercial').' property has been added on Cortiam.', 'property_review', $property_id);
				$this->mailer->regular_email('New Property Created', $admin_email_text, $admin_emails);
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', 'New  '.(($this->input->post("type") == "on")? 'Residental':'Commercial').' property added succesfully.');
				$this->session->set_flashdata('notify_title', 'New Listing Property');
				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-properties');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new property account
	 * @uses system_model::add_property To add details of agent account
	 *
	 * @return json true or false
	 */
	public function edit_property(){
		if (!$this->input->post("seller_id")) {$response["errorfields"]['seller_id'] = "Seller Account";}
		if (!$this->input->post("sub_type")) {$response["errorfields"]['sub_type'] = "Property Type";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}
		if (!$this->input->post("land_size")) {$response["errorfields"]['land_size'] = "Land Size";}
		if (!$this->input->post("approx_value")) {$response["errorfields"]['approx_value'] = "Approx. Property Value";}
		if (!$this->input->post("building_size")) {$response["errorfields"]['building_size'] = "Building Size";}
		if (!$this->input->post("built_date")) {$response["errorfields"]['built_date'] = "Build Date";}
		if (!$this->input->post("commission_rate")) {$response["errorfields"]['commission_rate'] = "Commission Rate";}
		if (!$this->input->post("contract_length")) {$response["errorfields"]['contract_length'] = "Contract Length";}
		if ($this->input->post("type") == "on") {
			if (!$this->input->post("bedroom")) {$response["errorfields"]['bedroom'] = "Bedroom Amount";}
			if (!$this->input->post("bathroom")) {$response["errorfields"]['bathroom'] = "Bathroom Amount";}
		}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}else{
			$property_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'seller_id' => $this->input->post("seller_id"),
				'type' => (($this->input->post("type"))? 'Residential':'Commercial'),
				'sub_type' => $this->input->post("sub_type"),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'approx_value' => (($this->input->post("approx_value"))? str_ireplace(",","",$this->input->post("approx_value")):null),
				'winning_fee' => (($this->input->post("winning_fee"))? str_ireplace(",","",$this->input->post("winning_fee")):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'land_size' => (($this->input->post("land_size"))? $this->input->post("land_size"):null),
				'building_size' => (($this->input->post("building_size"))? $this->input->post("building_size"):null),
				'built_date' => (($this->input->post("built_date"))? $this->input->post("built_date"):null),
				'interior_features' => (($this->input->post("interior_features"))? $this->input->post("interior_features"):null),
				'building_features' => (($this->input->post("building_features"))? $this->input->post("building_features"):null),
				'neighbourhood_features' => (($this->input->post("neighbourhood_features"))? $this->input->post("neighbourhood_features"):null),
				'lot_features' => (($this->input->post("lot_features"))? $this->input->post("lot_features"):null),
				'bedroom' => (($this->input->post("bedroom"))? $this->input->post("bedroom"):null),
				'bathroom' => (($this->input->post("bathroom"))? $this->input->post("bathroom"):null),
				'commission_rate' => (($this->input->post("commission_rate"))? $this->input->post("commission_rate"):null),
				'contract_length' => (($this->input->post("contract_length"))? $this->input->post("contract_length"):null),
			);
			if ($this->backend_model->edit_property($this->input->post("recordID"), $property_data)) {
				$response["success"] = true;
				if ($this->input->post("updatefrom") == "review") {
					$response["success_title"] = 'Edit Property Details';
					$response["success_message"] = 'New  '.(($this->input->post("type") == "on")? 'Residental':'Commercial').' property details updated succesfully.';

				}else{
					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', 'New  '.(($this->input->post("type") == "on")? 'Residental':'Commercial').' property details updated succesfully.');
					$this->session->set_flashdata('notify_title', 'Edit Property Details');
					$response["redirect_to"] = base_url('ct-admin/list-properties');
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_property(){
		if ($property_id = $this->input->post("recordID")) {
			$data = array(
				'active' => 0,
			);
			if ($this->backend_model->edit_property($this->input->post("recordID"), array('status' => 'Deleted'))) {
				$removedproperty = $this->backend_model->get_property($property_id);
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = $removedproperty['first_name'].' '.$removedproperty['last_name'].'\'s '.$removedproperty['type'].' property in '.$removedproperty['city'].', '.$removedproperty['state'].' has been deleted on Cortiam.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}


	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function get_map_location(){
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}else{
			$response["latitude"] = $loc_data['latitude'];
			$response["longitude"] = $loc_data['longitude'];
			$response["success"] = true;
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function upload_avatar(){
	  $folderPath = FCPATH.'images/avatar/';
	  $imagename = uniqid('avatar_',true);
	  $return['avatarurl'] = base_url('images/avatar/') . $imagename . ".jpg?ver=".rand(0,1000);
	  $update['avatar_string'] = $return['avatar_string'] = 'images/avatar/'.$imagename . ".jpg";

	  $base64_string = str_replace(array('data:image/png;base64,',' '),array('','+'),$_POST['image']);
	 	$decoded = base64_decode($base64_string);

		$image = imagecreatefromstring($decoded);
		$bg = imagecreatetruecolor(250, 250);
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $image, 0, 0, 0, 0, 250, 250);
		imagedestroy($image);
		$thubnail = imagecreatetruecolor(100, 100);
		imagejpeg($bg, $folderPath . $imagename . ".jpg", 80);
		imagecopyresampled($thubnail, $bg, 0, 0, 0, 0, 100, 100, 250, 250);
		imagedestroy($bg);
		imagejpeg($thubnail, $folderPath . $imagename . "_mini.jpg", 80);
		imagedestroy($thubnail);

		if ($this->input->post("recordID") && $this->input->post("type")) {
			switch ($this->input->post("type")) {
				case 'admin':
					$this->backend_model->edit_administrator($this->input->post("recordID"), $update);
					break;
				case 'agent':
					$this->backend_model->edit_agent($this->input->post("recordID"), $update);
					break;
				default:
					$this->backend_model->edit_seller($this->input->post("recordID"), $update);
					break;
			}
		}

	  echo json_encode($return,true);
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function upload_property_image(){
		if ($this->input->post("recordID")) {
		  $folderPath = FCPATH.'images/property/'.$this->input->post("recordID").'/';
		  $imagename = uniqid('prop_',true);
		  $return['avatarurl'] = base_url('images/property/').$this->input->post("recordID").'/'.$imagename.".jpg?ver=".rand(0,1000);
		  $return['avatar_string'] = 'images/property/'.$this->input->post("recordID").'/'.$imagename . ".jpg";
		}else{
		  $folderPath = FCPATH.'images/property/';
		  $imagename = uniqid('prop_',true);
		  $return['avatarurl'] = base_url('images/property/') . $imagename . ".jpg?ver=".rand(0,1000);
		  $return['avatar_string'] = 'images/property/'.$imagename . ".jpg";
		}
		if (!file_exists($folderPath)) {
	    mkdir($folderPath, 0755, true);
		}

	  $base64_string = str_replace(array('data:image/png;base64,',' '),array('','+'),$_POST['image']);
	 	$decoded = base64_decode($base64_string);

		$image = imagecreatefromstring($decoded);
		$bg = imagecreatetruecolor(1200, 900);
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $image, 0, 0, 0, 0, 1200, 900);
		imagedestroy($image);
		$thubnail = imagecreatetruecolor(400, 300);
		imagejpeg($bg, $folderPath . $imagename . ".jpg", 80);
		imagecopyresampled($thubnail, $bg, 0, 0, 0, 0, 400, 300, 1200, 900);
		imagedestroy($bg);
		imagejpeg($thubnail, $folderPath . $imagename . "_mini.jpg", 80);
		imagedestroy($thubnail);

		if ($this->input->post("recordID") && $this->input->post("type")) {
			$update[$this->input->post("type")] = $return['avatar_string'];
			$this->backend_model->edit_property($this->input->post("recordID"), $update);
		}

	  echo json_encode($return,true);
	}

	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_sellerapp(){
		if ($accounts = $this->backend_model->get_sellers($this->security->xss_clean($_POST))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["id"];
	    	$response['data'][$key]['approval'] = strtolower($account["approval"]);
	    	$response['data'][$key]['status'] = (($account["approval"] == 'Denied')? '<span class="badge badge-danger">Denied</span>':(($account["approval"] == 'Completed')? '<span class="badge badge-success">Completed</span>':'<span class="badge badge-info">Waiting</span>'));
	    	$response['data'][$key]['user_image'] = '<img class="img-fluid rounded-circle" src="'.(($account['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$account['avatar_string'])):base_url('images/userphoto_mini.jpg')).'" width="40" height="40" alt="">';
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['location'] = (($account["city"])? $account["city"].', ':'').$account["state"];
	    	$response['data'][$key]['approval_date'] = date("F jS, Y", $account["approval_date"]);
//	    	$response['data'][$key]['actions'] = (($this->account['permissions'][340] == 'Yes')? '<a class="btn btn-success btn-labeled btn-labeled-left btn-sm" href="'.base_url('ct-admin/review-seller/'.$account["id"]).'"><b><i class="icon-eye"></i></b> Review</a>':'');
	    	$response['data'][$key]['link'] = (($this->account['permissions'][340] == 'Yes')? base_url('ct-admin/review-seller/'.$account["id"]):'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_agentapp(){
		if ($accounts = $this->backend_model->get_agents($this->security->xss_clean($_POST))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["id"];
	    	$response['data'][$key]['approval'] = strtolower($account["approval"]);
	    	$response['data'][$key]['status'] = (($account["approval"] == 'Denied')? ((($account["license_expires"] < time()) && ($account["license_expires"]))? '<span class="badge badge-danger">Expired</span>':'<span class="badge badge-danger">Denied</span>'):(($account["approval"] == 'Completed')? '<span class="badge badge-success">Completed</span>':'<span class="badge badge-info">Waiting</span>'));
	    	$response['data'][$key]['user_image'] = '<img class="img-fluid rounded-circle" src="'.(($account['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$account['avatar_string'])):base_url('images/userphoto_mini.jpg')).'" width="40" height="40" alt="">';
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['location'] = (($account["city"])? $account["city"].', ':'').$account["state"];
	    	$response['data'][$key]['brokerage'] = $account["brokerage_name"];
	    	$response['data'][$key]['approval_date'] = date("F jS, Y",$account["approval_date"]);
//	    	$response['data'][$key]['actions'] = (($this->account['permissions'][360] == 'Yes')? '<a class="btn btn-labeled btn-labeled-left btn-sm" href="'.base_url('ct-admin/review-agent/'.$account["id"]).'"><i class="icon-eye"></i></a>':'');
	    	$response['data'][$key]['link'] = (($this->account['permissions'][360] == 'Yes')? base_url('ct-admin/review-agent/'.$account["id"]):'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_propertiesapp(){
		if ($properties = $this->backend_model->get_properties($this->security->xss_clean($_POST))) {
	    foreach ($properties as $key => $property) {
	    	$response['data'][$key]['property_id'] = $property["property_id"];
  			$response['data'][$key]['status'] = generate_property_badge($property["status"]);
	    	$response['data'][$key]['approval'] = strtolower($property["status"]);
	    	$response['data'][$key]['image'] = '<img class="img-fluid" src="'.(($property['front_image'])? base_url(str_replace(".jpg","_mini.jpg",$property['front_image'])):base_url('assets/images/backend/propertyphoto_mini.jpg')).'" width="40" height="30" alt="">';
	    	$response['data'][$key]['fullname'] = $property["first_name"].' '.$property["last_name"];
	    	$response['data'][$key]['location'] = (($property["city"])? $property["city"].', ':'').$property["state"];
	    	$response['data'][$key]['address'] = $property["address"].', '.$property["zipcode"];
	    	$response['data'][$key]['type'] = $property["type"];
	    	$response['data'][$key]['sub_type'] = $property["sub_type"];
	    	$response['data'][$key]['approval_date'] = date("F jS, Y",$property["approval_date"]);
//	    	$response['data'][$key]['actions'] = (($this->account['permissions'][380] == 'Yes')? '<a class="btn btn-success btn-labeled btn-labeled-left btn-sm" href="'.base_url('ct-admin/review-property/'.$property["property_id"]).'"><b><i class="icon-eye"></i></b> Review</a>':'');
	    	$response['data'][$key]['link'] = (($this->account['permissions'][380] == 'Yes')? base_url('ct-admin/review-property/'.$property["property_id"]):'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function decline_seller($user_id){
		if($user_id){
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Approve/Decline Reason";}
			if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field is required. Please fill out all the required field and try again.';
			}else{
				$timestamp = time();
				$approval_data = array(
					'admin_id' => $this->account['id'],
					'seller_id' => $user_id,
					'message_date' => $timestamp,
					'message_text' => $this->input->post("message_text"),
				);
				if ($this->ion_auth->update($user_id, array('approval' => 'Denied', 'approval_date' => $timestamp))) {
					$this->backend_model->add_approval($approval_data);
					$user_details = $this->backend_model->get_seller($user_id);
					$user_email_text = '<h3 style="color:#4c525e;">ACCOUNT DECLINED</h3><h4 style="color:#848994;">Dear '.$user_details['first_name'].' '.$user_details['last_name'].'<br>Thank you for waiting for the validation process to join Cortiam!</h4><p>We are sorry to tell you that your account application was declined with reason "'.$this->input->post("message_text").'". You can login to your account with the email and password you selected and check and resolve the missing/wrong parts to restart your validation status.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$this->mailer->regular_email('Your Account Declined', $user_email_text, $user_details['email']);
					$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY OWNER ACCOUNT DECLINED</h3><p style="color:#848994;">'.$user_details['first_name'].' '.$user_details['last_name'].'\'s property owner account has been reviewed and was declined with reasons "'.$this->input->post("message_text").'". For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->backend_model->get_notified(80);
					$this->backend_model->add_notification($admin_emails, 'Property Owner Account Declined', $user_details['first_name'].' '.$user_details['last_name'].'\'s property owner account has been reviewed and was declined.', 'seller_review', $user_id);
					$this->mailer->regular_email('Property Owner Account Declined', $admin_email_text, $admin_emails);

					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', $user_details["first_name"].' '.$user_details["last_name"].'\'s property owner account was declined succesfully.');
					$this->session->set_flashdata('notify_title', 'You Declined An Owners Account');
					$response["success"] = true;
					$response["redirect_to"] = base_url('ct-admin/approval-sellers');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Error!';
					$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function approve_seller($user_id){
		if($user_id){
			$timestamp = time();
			if ($this->input->post("message_text")) {
				$approval_data = array(
					'admin_id' => $this->account['id'],
					'seller_id' => $user_id,
					'message_date' => $timestamp,
					'message_text' => $this->input->post("message_text"),
				);
				$this->backend_model->add_approval($approval_data);
			}
			if ($this->ion_auth->update($user_id, array('approval' => 'Completed', 'approval_date' => $timestamp))) {

				$user_details = $this->backend_model->get_seller($user_id);

				$user_email_text = '<h3 style="color:#4c525e;">ACCOUNT APPROVED</h3><h4 style="color:#848994;">Dear '.$user_details['first_name'].' '.$user_details['last_name'].'<br><br>Thank you for waiting for the validation process to join Cortiam!</h4><p>We are happy to tell you that your account application was approved successfully. You can login to your account with the email and password you selected and to get started on Cortiam!</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$this->mailer->regular_email('Your Account Approved', $user_email_text, $user_details['email']);
				$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY OWNER ACCOUNT APPROVED</h3><p style="color:#848994;">'.$user_details['first_name'].' '.$user_details['last_name'].'\'s property owner account was reviewed and has been approved. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(80);
				$this->backend_model->add_notification($admin_emails, 'Property Owner Account Approved', $user_details['first_name'].' '.$user_details['last_name'].'\'s property owner account was reviewed and has been approved.', 'seller_edit', $user_id);
				$this->mailer->regular_email('Property Owner Account Approved', $admin_email_text, $admin_emails);

				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $user_details["first_name"].' '.$user_details["last_name"].'\'s property owner account approved succesfully.');
				$this->session->set_flashdata('notify_title', 'You Approved An Property Owner Account');
				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/approval-sellers');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function decline_agent($user_id){
		if($user_id){
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Approve/Decline Reason";}
			if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field is required. Please fill out all the required field and try again.';
			}else{
				$timestamp = time();
				$approval_data = array(
					'admin_id' => $this->account['id'],
					'agent_id' => $user_id,
					'message_date' => $timestamp,
					'message_text' => $this->input->post("message_text"),
				);
				if ($this->ion_auth->update($user_id, array('approval' => 'Denied', 'approval_date' => $timestamp))) {
					$this->backend_model->add_approval($approval_data);
					$user_details = $this->backend_model->get_agent($user_id);
					$user_email_text = '<h3 style="color:#4c525e;">ACCOUNT DECLINED</h3><h4 style="color:#848994;">Dear '.$user_details['first_name'].' '.$user_details['last_name'].'<br>Thank you for waiting for the validation process to join Cortiam!</h4><p>We are sorry to tell you that your account application was declined with reason "'.$this->input->post("message_text").'". You can login to your account with the email and password you selected and check and resolve the missing/wrong parts to restart your validation status.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$this->backend_model->add_notification($user_id, 'Your Account Declined', 'We are sorry to tell you that your account application was declined. Please check approval process page for more details.','account_declined');
					$this->mailer->regular_email('Your Account Declined', $user_email_text, $user_details['email']);
					$admin_email_text = '<h3 style="color:#4c525e;">REAL ESTATE AGENT ACCOUNT DECLINED</h3><p style="color:#848994;">'.$user_details['first_name'].' '.$user_details['last_name'].'\'s real estate agent account has been reviewed and was declined with reasons "'.$this->input->post("message_text").'". For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->backend_model->get_notified(50);
					$this->backend_model->add_notification($admin_emails, 'Real Estate Agent Account Declined', $user_details['first_name'].' '.$user_details['last_name'].'\'s real estate agent account has been reviewed and was declined.', 'agent_review', $user_id);
					$this->mailer->regular_email('Real Estate Agent Account Declined', $admin_email_text, $admin_emails);

					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', $user_details["first_name"].' '.$user_details["last_name"].'\'s real estate agent account was declined successfully.');
					$this->session->set_flashdata('notify_title', 'You Declined An Agents Account');
					$response["success"] = true;
					$response["redirect_to"] = base_url('ct-admin/approval-agents');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Error!';
					$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function approve_agent($user_id){
		if($user_id){
			if($user_details = $this->backend_model->get_agent($user_id)){
				if (!$user_details["avatar_string"]) {$response["errorfields"]['avatar_string'] = "Profile Photo";}
				if (!$user_details["first_name"]) {$response["errorfields"]['first_name'] = "First Name";}
				if (!$user_details["last_name"]) {$response["errorfields"]['last_name'] = "Last Name";}
				if (!$user_details["email"]) {$response["errorfields"]['email'] = "Email";}
				if (!$user_details["phone"]) {$response["errorfields"]['phone'] = "Phone Number";}
				if (!$user_details["address"]) {$response["errorfields"]['address'] = "Address";}
				if (!$user_details["city"]) {$response["errorfields"]['city'] = "City";}
				if (!$user_details["state"]) {$response["errorfields"]['state'] = "State";}
				if (!$user_details["zipcode"]) {$response["errorfields"]['zipcode'] = "ZIP Code";}
				if (!$user_details["experience"]) {$response["errorfields"]['experience'] = "First Year Licensed";}
				if (!$user_details["brokerage_name"]) {$response["errorfields"]['brokerage_name'] = "Brokerage Name";}
				if (!$user_details["brokerage_address"]) {$response["errorfields"]['brokerage_address'] = "Brokerage Address";}
				if (!$user_details["brokerage_city"]) {$response["errorfields"]['brokerage_city'] = "Brokerage City";}
				if (!$user_details["brokerage_state"]) {$response["errorfields"]['brokerage_state'] = "Brokerage State";}
				if (!$user_details["brokerage_zipcode"]) {$response["errorfields"]['brokerage_zipcode'] = "Brokerage ZIP Code";}
				if (!$user_details["brokerage_phone"]) {$response["errorfields"]['brokerage_phone'] = "Brokerage Phone Number";}
				if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
					$response["fail"] = true;
					$response["fail_title"] = 'Required/Missing Fields!';
					$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
				}else if(!$active = $this->backend_model->check_active_licenses($user_id)){
					$response["fail"] = true;
					$response["fail_title"] = 'Real Estate Agent License Missing!';
					$response["fail_message"] = $user_details["first_name"].' '.$user_details["last_name"].' doesn\'t have any active real estate agent license. Please wait till agent completes license information and try again.';
				}else{
					$timestamp = time();
					if ($this->input->post("message_text")) {
						$approval_data = array(
							'admin_id' => $this->account['id'],
							'agent_id' => $user_id,
							'message_date' => $timestamp,
							'message_text' => $this->input->post("message_text"),
						);
						$this->backend_model->add_approval($approval_data);
					}
					$previously_approved = $user_details['previously_approved'];
					if ($this->ion_auth->update($user_id, array('approval' => 'Completed', 'approval_date' => $timestamp, 'previously_approved' => 'Yes'))) {
						if ($previously_approved == 'No') {
							$user_details["approval"] = 'Completed';
							$user_details["approval_date"] = $timestamp;
							require_once(APPPATH.'/third_party/stripe/init.php');
							\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
							$customer = \Stripe\Customer::create([
							    'name' => $user_details["first_name"].' '.$user_details["last_name"],
							    'description' => 'Cortiam Agent User',
							    'email' => $user_details["email"],
							    'phone' => preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $user_details["phone"]),
							    'metadata' => array('Cortiam ID' => $user_id),
							]);
							$user_data['stripe_id'] = $customer->id;

							$settings = $this->backend_model->get_settings();
							foreach ($settings as $setting) {
								switch ($setting['setting_name']) {
									case 'monthly_offer_limit':
										$user_data['offer_limit'] = $setting['setting_value'];
										break;
									case 'monthly_win_limit':
										$user_data['win_limit'] = $setting['setting_value'];
										break;
									case 'membership_fee':
										$monthly_cost = $setting['setting_value'];
										break;
									default:
										break;
								}
							}

							$free_time = $this->backend_model->get_state_cost_by_name($user_details['state']);
							if ($free_time['free_period'] == 'Yes') {
								$free_invoice['agent_id'] = $user_id;
								$free_invoice['payment_time'] = $free_invoice['try_time'] = $user_data['free_starts'] =  time();
								$free_invoice['payment_desc'] = 'Cortiam Free Trial Period';
								$free_invoice['real_amount'] = $free_invoice['final_amount'] = 0;
								$free_invoice['payment_type'] = 'Free Trial';
								$free_invoice['invoice_status'] = 'Completed';
								$user_data['offer_remain'] = $user_data['offer_limit'];
								$user_data['win_remain'] = $user_data['win_limit'];
								$this->backend_model->add_invoice($free_invoice);

								$invoice['agent_id'] = $user_id;
								$invoice['try_time'] = $user_data['free_ends'] = $user_data['membership_due'] = strtotime('+ '.$free_time['free_days'].' days');
								$invoice['payment_desc'] = 'Cortiam Agent Monthly Subscription Price';
								$invoice['real_amount'] = $monthly_cost;
							}else{
								$invoice['agent_id'] = $user_id;
								$invoice['try_time'] = time();
								$invoice['payment_desc'] = 'Cortiam Agent Monthly Subscription Price';
								$invoice['real_amount'] = $monthly_cost;
							}
							$this->backend_model->edit_agent($user_id, $user_data);
							$this->backend_model->add_invoice($invoice);
						}

						$user_email_text = '<h3 style="color:#4c525e;">Congratulations '.$user_details['first_name'].' '.$user_details['last_name'].'!</h3><h4 style="color:#848994;">WELCOME to Cortiam! Now that your account is approved, you will have access to view all properties listed in your area!</h4><p>Here are a few tips to help you get started:</p><p>After you log in to your account, check out the agent dashboard! This section contains essential tools and information such as searching properties and your remaining wins/introductions. Our tutorial page has short videos on how to use our platform! If you\'re in a hurry and don\'t have time to read through all the details, check out our short and easy-to-follow video tutorials!</p><p>During your Free-Trial, you can view and introduce yourself to any property on our platform! If a seller accepts you as their agent, you will be required to pay the lead fee. But don\'t worry, Cortiam will not charge the $59 monthly membership fee until you choose to upgrade to the regular membership!</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						$this->mailer->regular_email('Great News! Your Cortiam Account is now Active!', $user_email_text, $user_details['email']);
						$admin_email_text = '<h3 style="color:#4c525e;">REAL ESTATE AGENT ACCOUNT APPROVED</h3><p style="color:#848994;">'.$user_details['first_name'].' '.$user_details['last_name'].'\'s real estate agent account has been reviewed and is now validated. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						$admin_emails = $this->backend_model->get_notified(50);
						$this->backend_model->add_notification($admin_emails, 'Real Estate Agent Account Approved', $user_details['first_name'].' '.$user_details['last_name'].'\'s real estate agent account has been reviewed and is now validated.', 'agent_edit', $user_id);
						$this->mailer->regular_email('Real Estate Agent Account Approved', $admin_email_text, $admin_emails);

						$this->session->set_flashdata('notify', 'success');
						$this->session->set_flashdata('notify_message', $user_details["first_name"].' '.$user_details["last_name"].'\'s real estate agent account was approved successfully.');
						$this->session->set_flashdata('notify_title', 'You Approved An Agents Account');
						$response["success"] = true;
						$response["redirect_to"] = base_url('ct-admin/approval-agents');

					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'Error!';
						$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
					}
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function decline_property($property_id){
		if($property = $this->backend_model->get_property($property_id)){
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Approve/Decline Reason";}
			if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field is required. Please fill out all the required field and try again.';
			}else{
				$timestamp = time();
				$approval_data = array(
					'admin_id' => $this->account['id'],
					'seller_id' => $property['seller_id'],
					'property_id' => $property['property_id'],
					'message_date' => $timestamp,
					'message_text' => $this->input->post("message_text"),
				);
				if ($this->backend_model->edit_property($property['property_id'], array('status' => 'Declined', 'approval_date' => $timestamp))) {
					$this->backend_model->add_approval($approval_data);
					$user_email_text = '<h3 style="color:#4c525e;">YOUR PROPERTY DECLINED</h3><h4 style="color:#848994;">Dear '.$property['first_name'].' '.$property['last_name'].'<br>Thank you for waiting for the validation process to add your property on Cortiam!</h4><p>We are sorry to tell you that your property details cannot pass the validation process because of {reason}. You can login to your account with the email and password you selected and check and fix the missing/wrong parts to restart your properties validation status.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$this->mailer->regular_email('Your Property Declined', $user_email_text, $property['email']);
					$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY DECLINED</h3><p style="color:#848994;">'.$property['first_name'].' '.$property['last_name'].'\'s property has reviewed and was declined with reasons "'.$this->input->post("message_text").'". For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->backend_model->get_notified(110);
					$this->backend_model->add_notification($admin_emails, 'Property Declined', $property['first_name'].' '.$property['last_name'].'\'s property has reviewed and was declined.', 'property_review', $property_id);
					$this->mailer->regular_email('Property Declined', $admin_email_text, $admin_emails);
					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', $property["first_name"].' '.$property["last_name"].'\'s property at '.$property["city"].','.$property["state"].' was declined successfully.');
					$this->session->set_flashdata('notify_title', 'You Declined A Property');
					$response["success"] = true;
					$response["redirect_to"] = base_url('ct-admin/approval-properties');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Error!';
					$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function approve_property($property_id){

		

		if($property = $this->backend_model->get_property($property_id)){
			if ($property['approx_value'] > 0) {
				$timestamp = time();
				if ($this->input->post("message_text")) {
					$approval_data = array(
						'admin_id' => $this->account['id'],
						'seller_id' => $property['seller_id'],
						'property_id' => $property['property_id'],
						'message_date' => $timestamp,
						'message_text' => $this->input->post("message_text"),
					);
					$this->backend_model->add_approval($approval_data);
				}
				if ($this->backend_model->edit_property($property['property_id'], array('status' => 'Active', 'approval_date' => $timestamp))) {
					// $user_email_text = '<h3 style="color:#4c525e;">YOUR PROPERTY APPROVED</h3><h4 style="color:#848994;">Dear '.$property['first_name'].' '.$property['last_name'].'<br><br>Thank you for waiting for the validation to join Cortiam</h4><p>Your property was reviewed and has been approved. You can login to your account with the email and password you selected to check your properties status.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					// $this->mailer->regular_email('Your Property Approved', $user_email_text, $property['email']);
					// $admin_email_text = '<h3 style="color:#4c525e;">PROPERTY APPROVED</h3><p style="color:#848994;">'.$property['first_name'].' '.$property['last_name'].'\'s property has been reviewed and is now approved. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					// $admin_emails = $this->backend_model->get_notified(110);
					// $this->backend_model->add_notification($admin_emails, 'Property Approved', $property['first_name'].' '.$property['last_name'].'\'s property has been reviewed and is now approved.', 'property_edit', $property_id);
					// $this->mailer->regular_email('Property Approved', $admin_email_text, $admin_emails);
					// $this->session->set_flashdata('notify', 'success');
					// $this->session->set_flashdata('notify_message', $property["first_name"].' '.$property["last_name"].'\'s property at '.$property["city"].','.$property["state"].' was approved succesfully.');
					// $this->session->set_flashdata('notify_title', 'You Approved A Property');
					$response["success"] = true;
					$response["redirect_to"] = base_url('ct-admin/approval-properties');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Error!';
					$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
				}
			}else{
				$response["errorfields"]['approx_value'] = "Approx. Property Value";
				$response["fail"] = true;
				$response["fail_title"] = 'Approximate Property Value Missing';
				$response["fail_message"] = 'Please update and add  approximate property value before approving a property.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}

		echo json_encode($response);die();
	}


	/**
	 * Lists of administrator accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_coupons(){
		if ($coupons = $this->backend_model->get_coupons($this->security->xss_clean($_POST))) {
	    foreach ($coupons as $key => $coupon) {
	    	$response['data'][$key]['coupon_id'] = $coupon["coupon_id"];
	    	$response['data'][$key]['coupon_code'] = $coupon["coupon_code"];
	    	$response['data'][$key]['coupon_desc'] = $coupon["coupon_desc"];
	    	$response['data'][$key]['coupon_type'] = $coupon["coupon_type"];
	    	$response['data'][$key]['coupon_amount'] = ((($coupon["coupon_type"] == 'Amount') || ($coupon["coupon_type"] == 'Percentage'))? $coupon["coupon_amount"]:number_format($coupon["coupon_amount"]));
	    	$response['data'][$key]['coupon_status'] = '<span class="badge badge-'.(($coupon["coupon_status"] == 'Active')? 'success':'secondary').'">'.$coupon["coupon_status"].'</span>';
	    	$response['data'][$key]['added_on'] = date("F jS, Y",$coupon["added_on"]);
	    	$response['data'][$key]['valid_on'] = date("F jS, Y",$coupon["begin_date"]).' - '.date("F jS, Y",$coupon["end_date"]);
	    	$response['data'][$key]['actions'] = ((($this->account['permissions'][420] == 'Yes') || ($this->account['permissions'][430] == 'Yes'))? '<div class="btn-group btn-block"><button class="btn btn-clean btn-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-clipboard"></i> Actions</button>
	    	<div class="dropdown-menu dropdown-menu-right p-0">
					<a class="dropdown-item copyme" href="#" data-copy="'.base_url('agent/add-coupon/'.$coupon["coupon_code"]).'"><i class="icon-copy"></i> Copy Add URL</a>'
					.(($this->account['permissions'][420] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/edit-coupon/'.$coupon["coupon_id"]).'"><i class="icon-pencil7"></i> Edit Details</a>':'')
					.(($this->account['permissions'][430] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$coupon["coupon_id"].'"><i class="icon-cancel-square"></i> Delete Coupon</a>':'')
				.'</div>
			</div>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new administrator account
	 * @uses system_model::add_admin To add details of admin account
	 *
	 * @return json true or false
	 */
	public function add_coupon(){
		if (!$this->input->post("coupon_code")) {$response["errorfields"]['coupon_code'] = "Coupon Code";}
		if (!$this->input->post("coupon_desc")) {$response["errorfields"]['coupon_desc'] = "Coupon Description";}
		if (!$this->input->post("begin_date")) {$response["errorfields"]['couponrange'] = "Valid Between Dates";}
		if (!$this->input->post("end_date")) {$response["errorfields"]['couponrange'] = "Valid Between Dates";}
		if (!$this->input->post("coupon_type")) {$response["errorfields"]['coupon_type'] = "Coupon Type";}
		if (!$this->input->post("coupon_amount")) {$response["errorfields"]['coupon_amount'] = "Discount value";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif($this->backend_model->check_couponcode($this->input->post("coupon_code"))){
			if ($this->input->post("coupon_code")) {$response["errorfields"]['coupon_code'] = "Coupon Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Coupon Code Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'This coupon code already used on system. Please change the coupon code and try again.';
		}else{
			$additional_data = array(
				'coupon_code' => (($this->input->post("coupon_code"))? $this->input->post("coupon_code"):null),
				'coupon_desc' => (($this->input->post("coupon_desc"))? $this->input->post("coupon_desc"):null),
				'begin_date' => (($this->input->post("begin_date"))?  strtotime($this->input->post("begin_date").' 00:00:01'):null),
				'end_date' => (($this->input->post("end_date"))? strtotime($this->input->post("end_date").' 00:00:01'):null),
				'coupon_type' => (($this->input->post("coupon_type"))? $this->input->post("coupon_type"):null),
				'coupon_amount' => (($this->input->post("coupon_amount"))? $this->input->post("coupon_amount"):null),
				'added_on' => time(),
				'added_by' => $this->account['id'],
			);
			if ($this->backend_model->add_coupon($additional_data)) {
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $this->input->post("coupon_code").' coupon added succesfully.');
				$this->session->set_flashdata('notify_title', 'New Coupon Added');
				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-coupons');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new administrator account
	 * @uses system_model::add_admin To add details of admin account
	 *
	 * @return json true or false
	 */
	public function edit_coupon(){
		if (!$this->input->post("coupon_code")) {$response["errorfields"]['coupon_code'] = "Coupon Code";}
		if (!$this->input->post("coupon_desc")) {$response["errorfields"]['coupon_desc'] = "Coupon Description";}
		if (!$this->input->post("begin_date")) {$response["errorfields"]['couponrange'] = "Valid Between Dates";}
		if (!$this->input->post("end_date")) {$response["errorfields"]['couponrange'] = "Valid Between Dates";}
		if (!$this->input->post("coupon_type")) {$response["errorfields"]['coupon_type'] = "Coupon Type";}
		if (!$this->input->post("coupon_amount")) {$response["errorfields"]['coupon_amount'] = "Discount value";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif($this->backend_model->check_couponcode($this->input->post("coupon_code"), $this->input->post("recordID"))){
			if ($this->input->post("coupon_code")) {$response["errorfields"]['coupon_code'] = "Coupon Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Coupon Code Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'This coupon code already used on system. Please change the coupon code and try again.';
		}else{
			$additional_data = array(
				'coupon_code' => (($this->input->post("coupon_code"))? $this->input->post("coupon_code"):null),
				'coupon_desc' => (($this->input->post("coupon_desc"))? $this->input->post("coupon_desc"):null),
				'begin_date' => (($this->input->post("begin_date"))?  strtotime($this->input->post("begin_date").' 00:00:01'):null),
				'end_date' => (($this->input->post("end_date"))? strtotime($this->input->post("end_date").' 00:00:01'):null),
				'coupon_type' => (($this->input->post("coupon_type"))? $this->input->post("coupon_type"):null),
				'coupon_amount' => (($this->input->post("coupon_amount"))? $this->input->post("coupon_amount"):null),
			);
			if ($this->backend_model->edit_coupon($this->input->post("recordID"), $additional_data)) {

				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $this->input->post("coupon_code").' details updated succesfully.');
				$this->session->set_flashdata('notify_title', 'Edit Coupon');
				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-coupons');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_coupon(){
		if ($coupon_id = $this->input->post("recordID")) {
			$data = array(
				'coupon_status' => 'Deleted',
			);
			if ($this->backend_model->edit_coupon($coupon_id, $data)) {
				$coupon = $this->backend_model->get_coupon($coupon_id);
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = $coupon['coupon_code'].' coupon deleted succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}


	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function get_user_graph(){
		if ($this->input->post("startdate") && $this->input->post("enddate")) {
			$response["reportdata"] = $this->backend_model->get_user_graph($this->input->post("startdate"),$this->input->post("enddate"));
			$response["success"] = true;
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function get_property_graph(){
		if ($this->input->post("startdate") && $this->input->post("enddate")) {
			$response["reportdata"] = $this->backend_model->get_properties_graph($this->input->post("startdate"),$this->input->post("enddate"));
			$response["success"] = true;
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function get_financial_graph(){
		if ($this->input->post("startdate") && $this->input->post("enddate")) {
			$response["reportdata"] = $this->backend_model->get_financial_graph($this->input->post("startdate"),$this->input->post("enddate"));
			$response["success"] = true;
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of administrator accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function list_messages(){
		if ($records = $this->backend_model->get_message_list($_POST)) {
	    foreach ($records as $key => $record) {
	    	$response['data'][$key]['record_id'] = $record["message_id"];
	    	$response['data'][$key]['title'] = ((strlen($record["message_text"]) > 70)? substr($record["message_text"],0,70).'...':$record["message_text"]);
	    	$response['data'][$key]['from'] = $record[$record["msg_from"]];
	    	$response['data'][$key]['to'] = $record[$record["msg_to"]];
	    	$response['data'][$key]['date'] = date("Y-m-d h:i A",$record["message_date"]);
	    	$response['data'][$key]['status'] = (($record["status"] == 'Read')? '<span class="badge badge-flat border-success text-success-600">'.$record["status"].'</span>':'<span class="badge badge-flat border-grey text-grey">'.$record["status"].'</span>');
	    	$response['data'][$key]['link'] = '<button data-record="'.$record["message_id"].'" class="btn btn-outline bg-slate-700 border-slate-700 text-slate-700 btn-icon rounded-round viewmessage"><i class="icon-eye"></i></button>';
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}


	public function list_memberships()
	{
		$draw = $_REQUEST['draw'];
		$data  = array();

		if ($records = $this->backend_model->get_plan_list($_REQUEST))
		{
			foreach ($records as $key => $record)
			{
				$id	     = $record["id"];
				$title   = $record["title"];;
				$details = $record['details'];

				if(isset($record['price']) && $record['price'] > 0)
				{
					$price = $record['price'];

				}else{
					$price = 0;
				}
				$discount      = $record['discount'];
				$discount_type = $record['discount_type'];
				$action  	   = '<a href="javascript:void(0);" class="btn btn-success edit" data-toggle="modal" data-edit="'.$record["id"].'" data-target="#editmyModal">Edit</a>';
				$action  	  .= ' <a href="javascript:void(0);" class="btn btn-danger delete" data-delete="'.$record["id"].'">Delete</a>';

				if($discount_type == 1)
				{
					if($discount > 0 && $price > 0)
					{
						$priceDicountPrice = $price - $discount;
					}
				}else{
					if($discount > 0 && $price > 0)
					{
						$priceDicountPrice = ($price / 100) * $discount;
					}
				}
				
				
				$data[] = array(
					"id"	   => $id,
					"title"	   => $title,
					"details"  => $details,
					"price"    => "$".$price,
					"discount" => "$".$priceDicountPrice,
					"action"   => $action
				);
			}
    	}

		$totalRecordwithFilter = count($records);
		$totalRecords 		   = $this->backend_model->get_total_plans();
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"data" => $data
		);


		echo json_encode($response);die();
	}



	public function list_feattures()
	{
		$draw = $_REQUEST['draw'];
		$data  = array();

		if ($records = $this->backend_model->get_features_list($_REQUEST))
		{
			 foreach ($records as $key => $record)
			{
	    		$id 	  		= $record["id"];
				$title	  		= $record["title"];
	    		$details  		= $record['description'];
				$price    		= $record['price'];
				$discount_value = $record['discount_value'];
				$discount_type  = $record['discount_type'];

				$action   =  '<a href="javascript:void(0);" class="btn btn-info addtionalFeature" data-toggle="modal" data-edit="'.$record["id"].'" data-target="#featuremyModal">Add Option</a>';
				$action  .= ' <a href="javascript:void(0);" class="btn btn-success edit" data-toggle="modal" data-edit="'.$record["id"].'" data-target="#editmyModal">Edit</a>';
				$action  .= ' <a href="javascript:void(0);" class="btn btn-danger delete" data-delete="'.$record["id"].'">Delete</a>';
				$action  .= ' <a href="javascript:void(0);" class="btn btn-primary expand" data-edit="'.$record["id"].'">Show Options</a>';

				$data[] = array(
					"id"	 		 => $id,
					"title"   		 => $title,
					"description"	 => $details,
					"price"   		 => "$".$price,
					"discount_value" => $discount_value,
					"discount_type"  => $discount_type,
					"action"  		 => $action
				 );
	   		}
		}

		$totalRecordwithFilter = count($records);
		$totalRecords 		   = $this->backend_model->get_total_features();
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"data" => $data
		 );

		echo json_encode($response);die();
	}

	public function feature_edit($id)
	{
		if ($records = $this->backend_model->edit_feature($id))
		{
			echo json_encode($records);
		}
	}


	public function option_edit($id)
	{
		if ($records = $this->backend_model->option_edit($id))
		{
			echo json_encode($records);
		}
	}

	public function feature_deleted()
	{
		if ($records = $this->backend_model->delete_feature($_REQUEST))
		{
		    echo "success";
		}else{
			echo "fail";
		}
	}

	public function member_deleted()
	{
		if ($records = $this->backend_model->delete_plan($_REQUEST))
		{
		    echo "success";
		}else{
			echo "fail";
		}
	}

	public function member_plan_edit()
	{

		if ($records = $this->backend_model->edit_plan($_REQUEST))
		{
			echo json_encode($records);
		}

	}

	public function view_message(){
		if ($message = $this->backend_model->get_message_id($this->input->post("record_id"))) {
			$response["success"] = true;
			$response["success_title"] = 'Message Details';
			$response["html"] = '<div class="row m-0 popupdetails">
			<div class="col-md-12 maintitle"><h3 class="m-0">Message Details</h3></div>
			<div class="col-md-3">Message From</div><div class="col-md-9">'.$message[$message["msg_from"]].'</div>
			<div class="col-md-3">Message To</div><div class="col-md-9">'.$message[$message["msg_to"]].'</div>
			<div class="col-md-3">Send Date</div><div class="col-md-9">'.date("Y-m-d h:i A",$message["message_date"]).'</div>
			</div><div class="row m-0 mt-2 popupdetails">
			<div class="col-md-12 maintitle"><h3 class="m-0">Message Content</h3></div>
			<div class="col-md-12">'.$message["message_text"].'</div>
			</div>';
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Record Not Found!';
			$response["fail_message"] = 'We cannot record you have looking for, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of administrator accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function list_notifications(){
		if ($records = $this->backend_model->get_notification_list($this->account['id'])) {
	    foreach ($records as $key => $record) {
	    	$response['data'][$key]['record_id'] = $record["notify_id"];
	    	$response['data'][$key]['title'] = ((strlen($record["title"]) > 110)? substr($record["title"],0,110).'...':$record["title"]);
	    	$response['data'][$key]['date'] = date("Y-m-d h:i A",$record["added_on"]);
	    	$response['data'][$key]['status'] = (($record["status"] == 'Read')? '<span class="badge badge-flat border-success text-success-600">'.$record["status"].'</span>':'<span class="badge badge-flat border-grey text-grey">'.$record["status"].'</span>');
	    	$response['data'][$key]['link'] = '<button data-record="'.$record["notify_id"].'" class="btn btn-outline bg-slate-700 border-slate-700 text-slate-700 btn-icon rounded-round viewmessage"><i class="icon-eye"></i></button>';
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	public function view_notification(){
		if ($record = $this->backend_model->get_notification_id($this->input->post("record_id"))) {
			$response["success"] = true;
			$response["success_title"] = 'Message Details';
			$response["html"] = '<div class="row m-0 popupdetails">
			<div class="col-md-12 maintitle"><h3 class="m-0">Notification Details</h3></div>
			<div class="col-md-3">Notification Date</div><div class="col-md-9">'.date("Y-m-d h:i A",$record["added_on"]).'</div>
			</div><div class="row m-0 mt-2 popupdetails">
			<div class="col-md-12 maintitle"><h3 class="m-0">Notification Content</h3></div>
			<div class="col-md-12 subtitle">'.$record["title"].'</div>
			<div class="col-md-12">'.$record["message"].'</div>
			</div>';
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Record Not Found!';
			$response["fail_message"] = 'We cannot record you have looking for, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function list_properties(){
		if ($records = $this->backend_model->get_properties_list($_POST)) {
	    foreach ($records as $key => $record) {
	    	$response['data'][$key]['property_id'] = $record["property_id"];
	    	$response['data'][$key]['image'] = '<img class="img-fluid" src="'.(($record['front_image'])? base_url(str_replace(".jpg","_mini.jpg",$record['front_image'])):base_url('assets/images/backend/propertyphoto_mini.jpg')).'" width="40" height="30" alt="">';
	    	$response['data'][$key]['location'] = $record["city"].', '.$record["state"];
	    	$response['data'][$key]['type'] = $record["type"];
	    	$response['data'][$key]['sub_type'] = $record["sub_type"];
	    	$response['data'][$key]['building_size'] = $record["building_size"];
	    	$response['data'][$key]['status'] = generate_property_badge($record["status"]);
	    	$response['data'][$key]['created_on'] = date("Y-m-d h:i A",$record["created_on"]);
	    	$response['data'][$key]['link'] = '<a href="'.base_url('ct-admin/edit-property/'.$record["property_id"]).'" target="_blank" class="btn btn-outline bg-slate-700 border-slate-700 text-slate-700 btn-icon rounded-round"><i class="icon-eye"></i></button>';
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function list_offers(){
		if ($records = $this->backend_model->get_offer_list($_POST)) {
	    foreach ($records as $key => $record) {
	    	$response['data'][$key]['record_id'] = $record["prop_id"];
	    	$response['data'][$key]['image'] = '<img class="img-fluid" src="'.(($record['default_image'])? base_url(str_replace(".jpg","_mini.jpg",$record['default_image'])):base_url('assets/images/backend/propertyphoto_mini.jpg')).'" width="40" height="30" alt="">';
	    	$response['data'][$key]['location'] = $record["city"].', '.$record["state"];
	    	$response['data'][$key]['from'] = $record[$record["prop_from"]];
	    	$response['data'][$key]['to'] = $record[$record["prop_to"]];
	    	$response['data'][$key]['commission'] = $record["commission_rate"];
	    	$response['data'][$key]['contract'] = $record["contract_length"];
	    	$response['data'][$key]['status'] = generate_offer_badge($record["status"]);
	    	$response['data'][$key]['created_on'] = date("Y-m-d h:i A",$record["prop_date"]);
	    	$response['data'][$key]['link'] = '<button data-record="'.$record["prop_id"].'" class="btn btn-outline bg-slate-700 border-slate-700 text-slate-700 btn-icon rounded-round viewoffer"><i class="icon-eye"></i></button>';
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function view_offer(){
		if ($record = $this->backend_model->get_offer_id($this->input->post("record_id"))) {
			$response["success"] = true;
			$response["success_title"] = 'Offer Details';
			$response["html"] = '<div class="row m-0 popupdetails">
			<div class="col-md-12 maintitle"><h3 class="m-0">Offer Details</h3></div>
			<div class="col-md-3">Status</div><div class="col-md-9">'.$record["status"].'</div>
			<div class="col-md-3">From</div><div class="col-md-9">'.$record[$record["prop_from"]].'</div>
			<div class="col-md-3">To</div><div class="col-md-9">'.$record[$record["prop_to"]].'</div>
			<div class="col-md-3">Commission Rate</div><div class="col-md-9">'.$record["commission_rate"].'%</div>
			<div class="col-md-3">Contract Length</div><div class="col-md-9">'.$record["contract_length"].' Months</div>
			<div class="col-md-3">Proposal Date</div><div class="col-md-9">'.date("Y-m-d h:i A",$record["prop_date"]).'</div>
			</div><div class="row m-0 mt-2 popupdetails">
			<div class="col-md-12 maintitle"><h3 class="m-0">Message</h3></div>
			<div class="col-md-12">'.$record["prop_text"].'</div>
			</div>';
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Record Not Found!';
			$response["fail_message"] = 'We cannot record you have looking for, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function list_contracts(){
		if ($records = $this->backend_model->get_contract_list($_POST)) {
	    foreach ($records as $key => $record) {
	    	$response['data'][$key]['record_id'] = $record["agr_id"];
	    	$response['data'][$key]['image'] = '<img class="img-fluid" src="'.(($record['default_image'])? base_url(str_replace(".jpg","_mini.jpg",$record['default_image'])):base_url('assets/images/backend/propertyphoto_mini.jpg')).'" width="40" height="30" alt="">';
	    	$response['data'][$key]['location'] = $record["city"].', '.$record["state"];
	    	$response['data'][$key]['agent'] = $record['Agent'];
	    	$response['data'][$key]['seller'] = $record['Seller'];
	    	$response['data'][$key]['commission'] = $record["commission_rate"];
	    	$response['data'][$key]['contract'] = $record["contract_length"];
	    	$response['data'][$key]['signed'] = generate_contract_owner_badge( $record["agent_response"] ,'Agent ').'<br>'.generate_contract_owner_badge( $record["seller_response"] ,'Seller ');
	    	$response['data'][$key]['status'] = generate_contract_status_badge( $record["agr_status"]);
	    	$response['data'][$key]['link'] = '<button data-record="'.$record["agr_id"].'" class="btn btn-outline bg-slate-700 border-slate-700 text-slate-700 btn-icon rounded-round viewcontract"><i class="icon-eye"></i></button>';
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Lists of agent accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function view_contract(){
		if ($record = $this->backend_model->get_contract_id($this->input->post("record_id"))) {
			$response["success"] = true;
			$response["success_title"] = 'Agreement Details';
			$response["html"] = '<div class="row m-0 popupdetails">
			<div class="col-md-12 maintitle"><h3 class="m-0">Agreement Details</h3></div>
			<div class="col-md-3">Status</div><div class="col-md-9">'.$record["agr_status"].'</div>
			<div class="col-md-3">Real Estate Agent</div><div class="col-md-9">'.$record['Agent'].'</div>
			<div class="col-md-3">Property Owner</div><div class="col-md-9">'.$record['Seller'].'</div>
			<div class="col-md-3">Commission Rate</div><div class="col-md-9">'.$record["commission_rate"].'%</div>
			<div class="col-md-3">Contract Length</div><div class="col-md-9">'.$record["contract_length"].' Months</div>
			<div class="col-md-3">Agreement Fee</div><div class="col-md-9">'.$record["agr_fee"].' USD</div>
			<div class="col-md-3">Agreement Time</div><div class="col-md-9">'.date('Y/m/d h:i:s A',$record['agr_time']).'</div>
			<div class="col-md-3">Fee Payment</div><div class="col-md-9">'.$record["payment_status"].' USD</div>
			</div>';
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Record Not Found!';
			$response["fail_message"] = 'We cannot record you have looking for, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new agent account
	 * @uses system_model::add_agent To add details of agent account
	 *
	 * @return json true or false
	 */
	public function tutorial_agent(){


		if (!$this->input->post("content")) {$response["errorfields"]['content'] = "Content";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Field!';
			$response["fail_message"] = 'Please fill out page content and try again.';
		}else{
			$page_data = array(
				'page_content' => $this->input->post("content"),
			);
			if ($this->backend_model->edit_tutorial('agent', $page_data)) {
				$response["success"] = true;
				$response["success_title"] = 'Page Updated';
				$response["success_message"] = 'Real Estate Agent tutorial page content updated succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}


	public function agent_video()
	{
	
		if (!$this->input->post("content")) {$response["errorfields"]['content'] = "Content";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Field!';
			$response["fail_message"] = 'Please fill out page content and try again.';
		}else{
			$page_data = array(
				'page_content' => $this->input->post("content"),
			);
			if ($this->backend_model->edit_tutorial('agentvideo', $page_data)) {
				$response["success"] = true;
				$response["success_title"] = 'Page Updated';
				$response["success_message"] = 'Real Estate Agent tutorial page content updated succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}


	

	/**
	 * Add new agent account
	 * @uses system_model::add_agent To add details of agent account
	 *
	 * @return json true or false
	 */
	public function tutorial_seller()
	{
		if (!$this->input->post("content")) {$response["errorfields"]['content'] = "Content";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Field!';
			$response["fail_message"] = 'Please fill out page content and try again.';
		}else{
			$page_data = array(
				'page_content' => $this->input->post("content"),
			);
			if ($this->backend_model->edit_tutorial('seller', $page_data)) {
				$response["success"] = true;
				$response["success_title"] = 'Page Updated';
				$response["success_message"] = 'Property Owner tutorial page content updated succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}



	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_agentsupport(){
		if ($accounts = $this->backend_model->get_agent_supports($this->security->xss_clean($_POST))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["agent_id"];
	    	$response['data'][$key]['user_image'] = '<img class="img-fluid rounded-circle" src="'.(($account['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$account['avatar_string'])):base_url('images/userphoto_mini.jpg')).'" width="40" height="40" alt="">';
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['status'] = $account["tstatus"];
	    	$response['data'][$key]['location'] = $account["city"].', '.$account["state"];
	    	$response['data'][$key]['message_date'] = date("Y-m-d h:i A",$account["message_date"]);
	    	$response['data'][$key]['message_aaaa'] = $account["message_date"];
	    	$response['data'][$key]['actions'] = (($this->account['permissions'][600] == 'Yes')? '<a class="btn btn-success btn-labeled btn-labeled-left btn-sm" href="'.base_url('ct-admin/view-agent-support/'.$account["agent_id"]).'"><b><i class="icon-reading"></i></b> Read</a>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function send_agent_support($user_id){
		if($user_id){
			$timestamp = time();
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Your Message";}

			if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}else{
				$msg_data = array(
					'admin_id' => $this->account['id'],
					'agent_id' => $user_id,
					'msg_from' => 'Admin',
					'message_text' => $this->input->post("message_text"),
					'message_date' => time(),
				);
				if($this->backend_model->add_support($msg_data)){
					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', 'Your message send successfully.');
					$this->session->set_flashdata('notify_title', 'Send Successfully!');
					$response["success"] = true;
					$response["redirect_to"] = base_url('ct-admin/list-agent-support');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}

	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_sellersupport(){
		if ($accounts = $this->backend_model->get_seller_supports($this->security->xss_clean($_POST))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["seller_id"];
	    	$response['data'][$key]['user_image'] = '<img class="img-fluid rounded-circle" src="'.(($account['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$account['avatar_string'])):base_url('images/userphoto_mini.jpg')).'" width="40" height="40" alt="">';
	    	$response['data'][$key]['fullname'] = $account["first_name"].' '.$account["last_name"];
	    	$response['data'][$key]['email'] = '<a href="mailto:'.$account["email"].'" class="text-slate"><i class="icon-envelop2"></i> '.$account["email"].'</a>';
	    	$response['data'][$key]['phone'] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account["phone"]);
	    	$response['data'][$key]['status'] = $account["tstatus"];
	    	$response['data'][$key]['location'] = $account["city"].', '.$account["state"];
	    	$response['data'][$key]['message_date'] = date("Y-m-d h:i A",$account["message_date"]);
	    	$response['data'][$key]['message_aaaa'] = $account["message_date"];
	    	$response['data'][$key]['actions'] = (($this->account['permissions'][580] == 'Yes')? '<a class="btn btn-success btn-labeled btn-labeled-left btn-sm" href="'.base_url('ct-admin/view-seller-support/'.$account["seller_id"]).'"><b><i class="icon-reading"></i></b> Read</a>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function send_seller_support($user_id){
		if($user_id){
			$timestamp = time();
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Your Message";}

			if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}else{
				$msg_data = array(
					'admin_id' => $this->account['id'],
					'seller_id' => $user_id,
					'msg_from' => 'Admin',
					'message_text' => $this->input->post("message_text"),
					'message_date' => time(),
				);
				if($this->backend_model->add_support($msg_data)){
					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', 'Your message send successfully.');
					$this->session->set_flashdata('notify_title', 'Send Successfully!');
					$response["success"] = true;
					$response["redirect_to"] = base_url('ct-admin/list-seller-support');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}


	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function set_default_image(){
		if ($this->input->post("property_id") && $this->input->post("image_id")) {
			if ($this->backend_model->set_default_image($this->input->post("property_id"),$this->input->post("image_id"))) {
				$response["success"] = true;
				$response["success_title"] = 'Default Image Updated Succesfully';
				$response["success_message"] = 'Default image updated with the new selected image succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_property_image(){
		if ($this->input->post("property_id") && $this->input->post("image_id")) {
			if ($this->backend_model->delete_property_image($this->input->post("property_id"),$this->input->post("image_id"))) {
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = 'Selected image deleted succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_profile_image(){
		if ($this->input->post("profile_id") && $this->input->post("type")) {
			$user_id = $this->input->post("profile_id");
			$update = array('avatar_string' => null);
			switch ($this->input->post("type")) {
				case 'seller':
					$profile = $this->backend_model->get_seller($user_id);
					if ($profile['avatar_string']) {
						@unlink(FCPATH.$profile['avatar_string']);
						@unlink(FCPATH.str_ireplace(".jpg","_mini.jpg", $profile['avatar_string']));
						$this->backend_model->edit_seller($user_id, $update);
						$response["success"] = true;
						$response["success_title"] = 'Deleted Succesfully';
						$response["success_message"] = $profile['first_name'].' '.$profile['last_name'].'\'s profile image deleted succesfully.';
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'No Image Found!';
						$response["fail_message"] = 'Selected profile doesnt have any profile image. please refresh the page and try again.';
					}
					break;
				case 'agent':
					$profile = $this->backend_model->get_agent($user_id);
					if ($profile['avatar_string']) {
						@unlink(FCPATH.$profile['avatar_string']);
						@unlink(FCPATH.str_ireplace(".jpg","_mini.jpg", $profile['avatar_string']));
						$this->backend_model->edit_agent($user_id, $update);
						$response["success"] = true;
						$response["success_title"] = 'Deleted Succesfully';
						$response["success_message"] = $profile['first_name'].' '.$profile['last_name'].'\'s profile image deleted succesfully.';
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'No Image Found!';
						$response["fail_message"] = 'Selected profile doesnt have any profile image. please refresh the page and try again.';
					}
					break;
				case 'administrator':
					$profile = $this->backend_model->get_administrator($user_id);
					if ($profile['avatar_string']) {
						@unlink(FCPATH.$profile['avatar_string']);
						@unlink(FCPATH.str_ireplace(".jpg","_mini.jpg", $profile['avatar_string']));
						$this->backend_model->edit_administrator($user_id, $update);
						$response["success"] = true;
						$response["success_title"] = 'Deleted Succesfully';
						$response["success_message"] = $profile['first_name'].' '.$profile['last_name'].'\'s profile image deleted succesfully.';
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'No Image Found!';
						$response["fail_message"] = 'Selected profile doesnt have any profile image. please refresh the page and try again.';
					}
					break;
				default:
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an error occured, please try again.';
					break;
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}


	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function refund_payment(){
		if ($invoice = $this->backend_model->get_user_invoice($this->input->post("record_id"))){
			if($invoice['pay_id']){
				if($invoice['invoice_status'] == 'Completed'){
					require_once(APPPATH.'/third_party/stripe/init.php');
					\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
				  $payment = \Stripe\PaymentIntent::retrieve($invoice['pay_id']);
				  if ($payment->status == 'succeeded') {
				  	try {
				  		$refund = \Stripe\Refund::create(['payment_intent' => $invoice['pay_id']]);
				  		$data = array(
				  		'refund_date' => time(),
				  		'refund_admin_id' => $this->account['id'],
				  		'invoice_status' => 'Refund',
				  		);
				  		$this->backend_model->update_invoice($invoice['invoice_id'],$data);
				  		$agent_details = $this->backend_model->get_agent($invoice['agent_id']);
							$user_email_text = '<h3 style="color:#4c525e;">REFUND COMPLETED</h3><h4 style="color:#848994;">Dear '.$agent_details['first_name'].' '.$agent_details['last_name'].'</h4><p>We are happy to tell you that the refund process for "'.$invoice['payment_desc'].'" has been completed successfully. For more information please login to Cortiam to check your payments details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
							$this->mailer->regular_email('Your Refund Completed', $user_email_text, $agent_details['email']);
							$this->backend_model->add_notification($invoice['agent_id'], 'Your Refund Completed', 'We are happy to tell you that the refund process for "'.$invoice['payment_desc'].'" has been completed successfully.');

							$response["success"] = true;
							$response["success_title"] = 'Refunded Succesfully';
							$response["success_message"] = 'Selected payment refunded successfully.';
				  	} catch (Exception $e) {
							$response["fail"] = true;
							$response["fail_title"] = 'Error!';
							$response["fail_message"] = $e->getError()->message;
				  	}
				  }else{
						$response["fail"] = true;
						$response["fail_title"] = 'Cannot Be Refunded By System!';
						$response["fail_message"] = 'This payment cannot be refunded by system, please try to refund manually.';
				  }
				}elseif($invoice['invoice_status'] == 'Refund'){
					$response["fail"] = true;
					$response["fail_title"] = 'Already Refunded!';
					$response["fail_message"] = 'This payment already refunded and cannot be refund again.';
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Cannot Be Refunded!';
					$response["fail_message"] = 'This payment doesn\'t include payment details to be refunded.';
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Cannot Be Refunded!';
				$response["fail_message"] = 'This payment doesn\'t include payment details to be refunded.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function create_avatar($avatar_string, $first_name, $last_name){
		$source_image = FCPATH.'images/avatar_base.jpg';
	  $folderPath = FCPATH.'images/avatar/';
	  $imagename = substr(basename($avatar_string),0,-4);

		$image = imagecreatefromjpeg($source_image);
		$white_color = imagecolorallocate($image, 255, 255, 255);

		$font_path = FCPATH.'assets/fonts/robotomono-bold.ttf';
		$size=80;
		$angle=0;
		$left=60;
		$top=165;

		@imagettftext($image, $size,$angle,$left,$top, $white_color, $font_path, $first_name[0].$last_name[0]);
		imagejpeg($image, $folderPath . $imagename . ".jpg", 80);
		$thubnail = imagecreatetruecolor(100, 100);
		imagecopyresampled($thubnail, $image, 0, 0, 0, 0, 100, 100, 250, 250);
		imagedestroy($image);
		imagejpeg($thubnail, $folderPath . $imagename . "_mini.jpg", 80);
		imagedestroy($thubnail);
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function clear_all_notifications(){
		if ($this->input->post("recordID") && $this->account['id']) {
			$this->backend_model->clear_notifications($this->account['id']);
			$response["success"] = true;
			$response["success_title"] = 'Cleared Succesfully';
			$response["success_message"] = 'All notifications cleared succesfully.';
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		echo json_encode($response);die();
	}



	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_states(){
		if ($accounts = $this->backend_model->get_state_costs($this->input->post("status"))) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["state_id"];
	    	$response['data'][$key]['state'] = $account["state"];
	    	$response['data'][$key]['cost'] = $account["cost"].' USD';
	    	$response['data'][$key]['actions'] = ((($this->account['permissions'][442] == 'Yes') || ($this->account['permissions'][443] == 'Yes') || ($this->account['permissions'][450] == 'Yes') || ($this->account['permissions'][451] == 'Yes'))? '<div class="btn-group btn-block"><button class="btn btn-clean btn-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-clipboard"></i> Actions</button>
	    	<div class="dropdown-menu dropdown-menu-right p-0">'
					.(($this->account['permissions'][442] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/edit-state/'.$account["state_id"]).'"><i class="icon-pencil7"></i> Edit Details</a>':'')
					.(($this->account['permissions'][450] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/list-city/'.$account["state_id"]).'"><i class="icon-direction"></i> List Cities</a>':'')
					.(($this->account['permissions'][451] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/add-city/'.$account["state_id"]).'"><i class="icon-location3"></i> Add City</a>':'')
					.(($this->account['permissions'][443] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$account["state_id"].'"><i class="icon-cancel-square"></i> Delete State</a>':'')
				.'</div>
			</div>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function add_state(){
		if (!$this->input->post("state_name")) {$response["errorfields"]['state_name'] = "State Name";}
		if (!$this->input->post("state_cost")) {$response["errorfields"]['state_cost'] = "Winning Cost";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}else{
			$additional_data = array(
				'state' => (($this->input->post("state_name"))? $this->input->post("state_name"):null),
				'cost' => (($this->input->post("state_cost"))? $this->input->post("state_cost"):null),
			);
			if ( $this->backend_model->add_state_cost($additional_data)) {
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', 'State '.$this->input->post("state_name").' added to location listing succesfully.');
				$this->session->set_flashdata('notify_title', 'New State');

				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-state');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		$this->generate_location_file();
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function edit_state(){
		if (!$this->input->post("state_name")) {$response["errorfields"]['state_name'] = "State Name";}
		if (!$this->input->post("state_cost")) {$response["errorfields"]['state_cost'] = "Winning Cost";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}else{
			$additional_data = array(
				'state' => (($this->input->post("state_name"))? $this->input->post("state_name"):null),
				'cost' => (($this->input->post("state_cost"))? $this->input->post("state_cost"):null),
			);
			if ($this->backend_model->update_state_cost($this->input->post("recordID"), $additional_data)) {
				$response["success"] = true;
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', 'State '.$this->input->post("state_name").' details updated succesfully.');
				$this->session->set_flashdata('notify_title', 'Edit State');
				$response["redirect_to"] = base_url('ct-admin/list-state');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		$this->generate_location_file();
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_state(){
		if ($account_id = $this->input->post("recordID")) {
			$removedstate = $this->backend_model->get_state_cost($account_id);
			$additional_data = array(
				'state_status' => 'Deleted',
			);
			if ($this->backend_model->update_state_cost($this->input->post("recordID"), $additional_data)) {
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = 'State '.$removedstate['state_name'].' deleted from locations succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		$this->generate_location_file();
		echo json_encode($response);die();
	}


	/**
	 * Lists of seller accounts
	 * @uses system_model::get_accounts To get list of accounts
	 *
	 * @return json List of active accounts
	 */
	public function get_cities($state_id){
		if (!$state_id) {return false;}
		if ($accounts = $this->backend_model->get_cities($state_id)) {
	    foreach ($accounts as $key => $account) {
	    	$response['data'][$key]['user_id'] = $account["city_id"];
	    	$response['data'][$key]['city'] = $account["city_name"];
	    	$response['data'][$key]['actions'] = ((($this->account['permissions'][452] == 'Yes') || ($this->account['permissions'][453] == 'Yes'))? '<div class="btn-group btn-block"><button class="btn btn-clean btn-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-clipboard"></i> Actions</button>
	    	<div class="dropdown-menu dropdown-menu-right p-0">'
					.(($this->account['permissions'][452] == 'Yes')? '<a class="dropdown-item" href="'.base_url('ct-admin/edit-city/'.$account["city_id"]).'"><i class="icon-pencil7"></i> Edit Details</a>':'')
					.(($this->account['permissions'][453] == 'Yes')? '<a class="dropdown-item text-danger deleterecordbutton" href="#" data-record="'.$account["city_id"].'"><i class="icon-cancel-square"></i> Delete City</a>':'')
				.'</div>
			</div>':'');
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function add_city(){
		if (!$this->input->post("city_name")) {$response["errorfields"]['city_name'] = "City Name";}

		if (isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}else{
			$additional_data = array(
				'state_id' => (($this->input->post("state_id"))? $this->input->post("state_id"):null),
				'city_name' => (($this->input->post("city_name"))? $this->input->post("city_name"):null),
			);
			if ( $this->backend_model->add_city($additional_data)) {
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', 'City '.$this->input->post("city_name").' added to location listing succesfully.');
				$this->session->set_flashdata('notify_title', 'New City');

				$response["success"] = true;
				$response["redirect_to"] = base_url('ct-admin/list-city/'.$this->input->post("state_id"));
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		$this->generate_location_file();
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function edit_city(){
		if (!$this->input->post("city_name")) {$response["errorfields"]['city_name'] = "City Name";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}else{
			$additional_data = array(
				'state_id' => (($this->input->post("state_id"))? $this->input->post("state_id"):null),
				'city_name' => (($this->input->post("city_name"))? $this->input->post("city_name"):null),
			);
			if ($this->backend_model->edit_city($this->input->post("recordID"), $additional_data)) {
				$response["success"] = true;
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', 'City '.$this->input->post("city_name").' details updated succesfully.');
				$this->session->set_flashdata('notify_title', 'Edit City');
				$response["redirect_to"] = base_url('ct-admin/list-city/'.$this->input->post("state_id"));
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		$this->generate_location_file();
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function delete_city(){
		if ($account_id = $this->input->post("recordID")) {
			$removedstate = $this->backend_model->get_city($account_id);
			$additional_data = array(
				'city_status' => 'Deleted',
			);
			if ($this->backend_model->edit_city($this->input->post("recordID"), $additional_data)) {
				$response["success"] = true;
				$response["success_title"] = 'Deleted Succesfully';
				$response["success_message"] = 'City '.$removedstate['city_name'].' deleted from locations succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an error occured, please try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an error occured, please try again.';
		}
		$this->generate_location_file();
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function generate_location_file(){
		$states = $this->backend_model->get_state_costs();
		foreach ($states as $state) {
			$state_array[] = $state_name_array[$state['state_id']] = trim($state['state']);
		}
		$cities = $this->backend_model->get_all_cities();
		foreach ($cities as $city) {
			$city_array[$state_name_array[$city['state_id']]][] = trim($city['city_name']);
		}
		$fp = fopen('assets/js/dist/cslist.js', 'w');
		fwrite($fp, "var _states_ = ".json_encode($state_array).";\nvar _cities_ =".json_encode($city_array).";");
		fclose($fp);
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function get_licenseform(){
		$response["success"] = true;
		if ($license_details = $this->backend_model->get_license($this->input->post("licenseid"))) {
			$response["form"] = '<div class="outcome"><div class="error" role="alert"></div></div>
							<div class="row">
								<h5 class="col-sm-12">License Details</h5>
								<div class="col-md-6">
									<div class="form-group">
										<label>License Number:</label>
										<input type="text" name="license_number" id="license_number" class="form-control" placeholder="License Number" value="'.$license_details['license_number'].'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>License Expiration Date:</label>
										<input type="text" name="license_expire" id="license_expire" class="form-control" placeholder="License Expiration Date" value="'.date('m/d/Y',$license_details['license_expire']).'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>State Licensed:</label>
										<input type="text" name="license_state" id="license_state" class="form-control" placeholder="State Licensed" value="'.$license_details['license_state'].'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Real Estate Focus:</label>
										<select class="form-control select" name="interested" id="interested" placeholder="Real Estate Focus">
											<option value="">Real Estate Focus</option>
											<option value="Residential" '.(($license_details['interested'] == 'Residential')? 'selected':'').'>Residential</option>
											<option value="Commercial" '.(($license_details['interested'] == 'Commercial')? 'selected':'').'>Commercial</option>
											<option value="Both" '.(($license_details['interested'] == 'Both')? 'selected':'').'>Both</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<input type="hidden" name="license_id" value="'.$license_details['license_id'].'">
						  		<button id="license-update-button" class="btn btn-primary float-right">Update License</button>
						  		<button id="license-cancel-button" class="btn btn-danger left">Cancel</button>
						  	<div>
					  	<div>';
		}else{
			$response["form"] = '<div class="outcome"><div class="error" role="alert"></div></div>
							<div class="row">
								<h5 class="col-sm-12">New License</h5>
								<div class="col-md-6">
									<div class="form-group">
										<label>License Number:</label>
										<input type="text" name="license_number" id="license_number" class="form-control" placeholder="License Number">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>License Expiration Date:</label>
										<input type="text" name="license_expire" id="license_expire" class="form-control" placeholder="License Expiration Date">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>State Licensed:</label>
										<input type="text" name="license_state" id="license_state" class="form-control" placeholder="State Licensed">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Real Estate Focus:</label>
										<select class="form-control select" name="interested" id="interested" placeholder="Real Estate Focus">
											<option value="">Real Estate Focus</option>
											<option value="Residential">Residential</option>
											<option value="Commercial">Commercial</option>
											<option value="Both">Both</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
						  		<button id="license-add-button" class="btn btn-primary float-right">Save License</button>
						  		<button id="license-cancel-button" class="btn btn-danger float-left">Cancel</button>
						  	<div>
					  	<div>';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function add_license(){
		if (!$this->input->post("license_number")) {$response["errorfields"]['license_number'] = "License Number";}
		if (!$this->input->post("license_expire")) {$response["errorfields"]['license_expire'] = "License Expiration Date";}
		if (!$this->input->post("license_state")) {$response["errorfields"]['license_state'] = "State Licensed";}
		if (!$this->input->post("interested")) {$response["errorfields"]['interested'] = "Real Estate Focus";}
		if (!$this->input->post("agent_id")) {$response["errorfields"]['agent_id'] = "Agent ID";}

		if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif(strtotime($this->input->post("license_expire")) < time()){
			$response["errorfields"]['license_expire'] = "License Expiration Date";
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid Expiration Date!';
			$response["fail_message"] = 'License expiration date cannot be earlier than today. Please check&fix your license expiration date and try again.';
		}else{
			$record_data = array(
				'agent_id' => $this->input->post("agent_id"),
				'license_number' => $this->input->post("license_number"),
				'license_expire' => (($this->input->post("license_expire"))? strtotime($this->input->post("license_expire")):null),
				'license_state' => $this->input->post("license_state"),
				'interested' => $this->input->post("interested"),
				'added_date' => time(),
			);
			if($this->backend_model->add_license($record_data)){
				$agent = $this->backend_model->get_agent($this->input->post("agent_id"));
				$admin_email_text = '<h3 style="color:#4c525e;">NEW LICENSE</h3><p style="color:#848994;">Real Estate Agent '.$agent['first_name'].' '.$agent['last_name'].' added new license. New license details will need to be approved. For more information please login to Cortiam to check approval details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->backend_model->get_notified(50);
				$this->backend_model->add_notification($admin_emails, 'Real Estate Agent License Needs Approval', 'Real Estate Agent '.$agent['first_name'].' '.$agent['last_name'].' added new license. New license details will need to be approved.', 'agent_review', $this->input->post("agent_id"));
				$this->mailer->regular_email('Real Estate Agent License Needs Approval', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'License Added Successfully!';
				$response["success_message"] = 'New license added successfully. Because new license added, we need to validate your license details. In meantime your account status will be remain in approval status.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function edit_license(){
		if ($this->input->post("license_id")) {
			if (!$this->input->post("license_number")) {$response["errorfields"]['license_number'] = "License Number";}
			if (!$this->input->post("license_expire")) {$response["errorfields"]['license_expire'] = "License Expiration Date";}
			if (!$this->input->post("license_state")) {$response["errorfields"]['license_state'] = "State Licensed";}
			if (!$this->input->post("interested")) {$response["errorfields"]['interested'] = "Real Estate Focus";}

			if(isset($response["errorfields"]) &&  $response["errorfields"] !== '') {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}elseif(strtotime($this->input->post("license_expire")) < time()){
				$response["errorfields"]['license_expire'] = "License Expiration Date";
				$response["fail"] = true;
				$response["fail_title"] = 'Invalid Expiration Date!';
				$response["fail_message"] = 'License expiration date cannot be earlier than today. Please check&fix your license expiration date and try again.';
			}else{
				$record_data = array(
					'license_number' => $this->input->post("license_number"),
					'license_expire' => (($this->input->post("license_expire"))? strtotime($this->input->post("license_expire")):null),
					'license_state' => $this->input->post("license_state"),
					'interested' => $this->input->post("interested"),
					'added_date' => time(),
				);
				if($this->backend_model->edit_license($this->input->post("license_id"), $record_data)){
					$agent = $this->backend_model->get_agent($this->input->post("agent_id"));
					$admin_email_text = '<h3 style="color:#4c525e;">LICENSE UPDATED</h3><p style="color:#848994;">Real Estate Agent '.$agent['first_name'].' '.$agent['last_name'].' updated agent license details. New license details will need to be approved. For more information please login to Cortiam to check approval details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->backend_model->get_notified(50);
					$this->backend_model->add_notification($admin_emails, 'Real Estate Agent License Needs Approval', 'Real Estate Agent '.$agent['first_name'].' '.$agent['last_name'].' updated agent license details. New license details will need to be approved.', 'agent_review', $this->input->post("agent_id"));
					$this->mailer->regular_email('Real Estate Agent License Needs Approval', $admin_email_text, $admin_emails);
					$response["success"] = true;
					$response["success_title"] = 'License Updated Successfully!';
					$response["success_message"] = 'Your license updated successfully. Because license details updated, we need to validate your license details. In meantime your account status will be remain in approval status.';
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function delete_license(){
		if ($this->input->post("license_id")) {
			if($license = $this->backend_model->get_license($this->input->post("license_id"))) {
				$record_data = array(
					'license_status' => 'Removed',
				);
				if($this->backend_model->edit_license($this->input->post("license_id"), $record_data)){
					$response["success"] = true;
					$response["success_title"] = 'License Deleted Successfully!';
					$response["success_message"] = (($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']).' License for '.$license['license_state'].' deleted successfully.';
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}
	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function approve_license(){
		if ($this->input->post("license_id") && $this->input->post("type")) {
			if($license = $this->backend_model->get_license($this->input->post("license_id"))) {
				if ($this->input->post("type") == 'Approve') {
					$record_data = array('license_status' => 'Active');
					$response["success_title"] = 'License Activated Successfully!';
					$response["success_message"] = (($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']).' License for '.$license['license_state'].' activated successfully.';
				}else{
					$record_data = array('license_status' => 'Declined');
					$response["success_title"] = 'License Declined Successfully!';
					$response["success_message"] = (($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']).' License for '.$license['license_state'].' declined successfully.';
				}
				if($this->backend_model->edit_license($this->input->post("license_id"), $record_data)){
					$response["success"] = true;
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function list_licenses(){
		if ($licenses = $this->backend_model->get_licenses($this->input->post("agent_id"))) {
			foreach ($licenses as $license) {
				$response["form"] .= '<tr class="cursor-pointer collapsed" data-toggle="collapse" role="button" aria-expanded="false">
														<td>'.$license['license_number'].'</td>
														<td class="text-center">'.$license['license_state'].'</td>
														<td class="text-center">'.(($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']).'</td>
														<td class="text-center">'.date('m-d-Y', $license['license_expire']).'</td>
														<td class="text-center">'.generate_license_status_pill($license['license_status']).'</td>
														<td class="text-right">
																<div class="btn-group mt-2 dropleft" data-toggle="tooltip" data-placement="left" title="Click for options">
																	<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="cardopenmenu"><i class="icon-menu"></i></span>
																	<div class="dropdown-menu border-grey-700 bg-grey border-2">
																		'.(($license['license_status'] == 'Pending')? '<button class="dropdown-item text-success-800 approvemylicense" type="button" data-id="'.$license['license_id'].'" data-type="Approve"><i class="icon-thumbs-up3"></i> Approve</button><button class="dropdown-item text-danger-800 approvemylicense" type="button" data-id="'.$license['license_id'].'" data-type="Decline"><i class="icon-thumbs-down3"></i> Decline</button><div class="dropdown-divider"></div>':'').
																		'<button class="dropdown-item editmylicense" type="button" data-id="'.$license['license_id'].'"><i class="icon-pencil7"></i> Edit Details</button>
																		<button class="dropdown-item deletemylicense" type="button" data-id="'.$license['license_id'].'"><i class="icon-trash"></i> Delete</button>
																	</div>
																</div>
														</td>
													</tr>';
			}
		}else{
			$response["form"] = '<tr><td colspan="6" class="text-center">No agent license.</td></tr>';
		}
		$response["success"] = true;
		echo json_encode($response);die();
	}


   public function	add_membership()
   {	

		if ($this->backend_model->save_membership_plan($_REQUEST))
		{	
			echo "success";
		}else{
			echo "fail";
		} 
	}


	public function	add_plans()
	{	 
		if ($this->backend_model->save_plan($_REQUEST))
		{	
			echo "success";
		}else{
			echo "fail";
		} 
	 }

	public function update_membership()
	{
		if ($this->backend_model->update_membership_plan($_REQUEST))
		{	
			echo "success";
		}else{
			echo "fail";
		} 
	}


	public function update_plan()
	{	

		if ($this->backend_model->update_plan($_REQUEST))
		{	
			echo "success";
		}else{
			echo "fail";
		} 
	}

	public function add_option()
	{
		if ($this->backend_model->add_option($_REQUEST))
		{
			echo "success";
		}else{
			echo "fail";
		}
	}

	public function update_options()
	{
		if ($this->backend_model->update_options($_REQUEST))
		{
			echo "success";
		}else{
			echo "fail";
		}

	}

	public function get_options()
	{
		$data = $this->backend_model->get_options($_REQUEST);

		echo json_encode($data);

	}


	public function delete_options()
	{
		if ($this->backend_model->delete_options($_REQUEST))
		{
			echo "success";
		}else{
			echo "fail";
		}


	}
    public function list_specializations()
    {
        $draw = $_REQUEST['draw'];
        $data  = array();

        if ($records = $this->backend_model->get_specializations_list($_REQUEST))
        {
            foreach ($records as $key => $record)
            {
                $id 	 = $record["id"];
                $name	 = $record["name"];
                $created_at = $record['created_at'];
                $updated_at = $record['updated_at'];
                $action  = '<a href="javascript:void(0);" class="btn btn-success edit" data-toggle="modal" data-edit="'.$record["id"].'" data-target="#editSpecializationsModal">Edit</a>';
                $action .= ' <a href="javascript:void(0);" class="btn btn-danger delete" data-delete="'.$record["id"].'">Delete</a>';

                $data[] = array(
                    "id"	  => $id,
                    "name"	  => $name,
                    "action"  => $action
                );
            }
        }

        $totalRecordwithFilter = count($records);
        $totalRecords 		   = $this->backend_model->get_total_specializations();
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "data" => $data
        );

        echo json_encode($response);die();
    }

    public function	add_specializations()
    {

        if ($this->backend_model->save_specializations($_REQUEST))
        {
            echo "success";
        }else{
            echo "fail";
        }
    }

    public function specialization_edit($id)
    {
        $records = $this->backend_model->edit_specializations($id);
        if ($records)
        {
            echo json_encode($records);
        }
    }

    public function update_specializations()
    {
        if ($this->backend_model->update_specializations_plan($_REQUEST))
        {
            echo "success";
        }else{
            echo "fail";
        }
    }
    public function specialization_deleted()
    {
        if ($records = $this->backend_model->delete_specialization($_REQUEST))
        {
            echo "success";
        }else{
            echo "fail";
        }
    }


}
?>