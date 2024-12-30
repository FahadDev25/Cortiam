<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Backend model
 *
 * The system model with a series of CRUD functions (powered by CI's query builder), validation-in-model support, event callbacks and more for backend administration actions.
 *
 * @package    Cortiam Web Application
 * @subpackage Models
 * @category   Models
 * @copyright  Copyright (c) 2021, The Webb Enterprises Inc.
 * @author     The Webb Enterprises Dev Team
 * @link       http://www.thewebbenterprises.com
 * @since      Version 1.0
 *
 */
class Backend_model extends CI_Model {

		public function __construct(){
    		$this->load->database();
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_administrators($post = null){
			$this->db->select('accounts.*, administrators.*');
			$this->db->from('accounts');
			$this->db->join('administrators', 'administrators.admin_id = accounts.id', 'left');
			$this->db->where('accounts.active !=', 0);
			if ($post['approval']) {
				$this->db->where('accounts.approval =', $post['approval']);
			}else{
				$this->db->where('accounts.approval =', 'Completed');
			}
			$this->db->where('accounts.user_type =', 'Administrator');
			$this->db->order_by('accounts.id ASC');

			$admins = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $admins;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_administrator($admin_id){
	    $admin = $this->db->select('accounts.*, administrators.*')->from('accounts')->where("accounts.id =", $admin_id)->where("accounts.user_type =", 'Administrator')->join('administrators', 'administrators.admin_id = accounts.id', 'left')->get()->row_array();
			$admin['permissions'] = unserialize($admin['permissions']);
			$admin['notifications'] = unserialize($admin['notifications']);
    	return $admin;
		}


	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function add_administrator($data){
			$this->db->insert('administrators', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function edit_administrator($account_id, $data){
			$this->db->update('administrators', $data, "admin_id = '".$account_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_sellers($post = null){
			$this->db->select('accounts.*, sellers.*');
			$this->db->from('accounts');
			$this->db->join('sellers', 'sellers.seller_id = accounts.id', 'left');
			$this->db->where('accounts.active !=', 0);
			if ($post['state']) {
				$this->db->where('sellers.state =', $post['state']);
			}
			if ($post['approval'] == 'All') {
				$this->db->where_in('accounts.approval', array('Waiting','Denied','Completed'));
			}elseif ($post['approval']) {
				$this->db->where('accounts.approval =', $post['approval']);
			}else{
				$this->db->where('accounts.approval =', 'Completed');
			}
			if ($post["start_date"] && $post["end_date"]) {
				$start_date = strtotime($post["start_date"].' 00:00:01');
				$end_date = strtotime($post["end_date"].' 23:59:59');
				$this->db->where("(accounts.approval_date BETWEEN ".$start_date." AND ".$end_date.")");
			}
			$this->db->where('accounts.user_type =', 'Seller');
			if ($post['order']) {
				$this->db->order_by($post['order']);
			}else{
				$this->db->order_by('accounts.created_on DESC');
			}
			if ($post['limit']) {
				$this->db->limit($post['limit']);
			}
			$sellers = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $sellers;
		}

	/**
	 * Get details of selected seller account
	 *
	 * @param  integer $seller_id ID of system seller to return
	 * @return array Seller details
	 */
		public function get_seller($seller_id){
	    $seller = $this->db->select('accounts.*, sellers.*')->from('accounts')->where("accounts.id =", $seller_id)->where("accounts.user_type =", 'Seller')->join('sellers', 'sellers.seller_id = accounts.id', 'left')->get()->row_array();
    	return $seller;
		}

	/**
	 * Add new seller account
	 *
	 * @param  array 	 $data Details of seller account
	 * @return boolean true|false
	 */
		public function add_seller($data){
			$this->db->insert('sellers', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new seller account
	 *
	 * @param  array 	 $data Details of seller account
	 * @return boolean true|false
	 */
		public function edit_seller($account_id, $data){
			$this->db->update('sellers', $data, "seller_id = '".$account_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_awaitings(){
			$this->db->from('waiting_users');
//			$this->db->group_by('waiting_users.email');
			$awaitings = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $awaitings;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_awaiting($awaiting_id){
	    $agent = $this->db->from('waiting_users')->where("waiting_users.id =", $awaiting_id)->get()->row_array();
    	return $agent;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function delete_awaiting($awaiting_id){
			if ($awaiting_id) {
				$this->db->delete('waiting_users', array('id' => $awaiting_id));
			}
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_agents($post = null){
			$this->db->select('accounts.*, agents.*, licenses.license_status, MAX(licenses.license_expire) AS license_expires');
			$this->db->from('accounts');
			$this->db->join('agents', 'agents.agent_id = accounts.id', 'left');
			$this->db->where('accounts.active !=', 0);
			if ($post['state']) {
				$this->db->where('agents.state =', $post['state']);
			}
			if ($post['approval'] == 'All') {
				$this->db->where_in('accounts.approval', array('Waiting','Denied','Completed'));
			}elseif ($post['approval']) {
				$this->db->where('accounts.approval =', $post['approval']);
			}else{
				$this->db->where('accounts.approval =', 'Completed');
			}
			if ($post["start_date"] && $post["end_date"]) {
				$start_date = strtotime($post["start_date"].' 00:00:01');
				$end_date = strtotime($post["end_date"].' 23:59:59');
				$this->db->where("(accounts.approval_date BETWEEN ".$start_date." AND ".$end_date.")");
			}
			$this->db->where('accounts.user_type =', 'Agent');
			if ($post['order']) {
				$this->db->order_by($post['order']);
			}else{
				$this->db->order_by('accounts.created_on DESC');
			}
			if ($post['limit']) {
				$this->db->limit($post['limit']);
			}
			$this->db->join('licenses', "licenses.agent_id = accounts.id AND (license_status = 'Expired')", 'left');
			$this->db->group_by('accounts.id');
			$agents = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $agents;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_agent($agent_id){
	    $agent = $this->db->select('accounts.*, agents.*')->from('accounts')->where("accounts.id =", $agent_id)->where("accounts.user_type =", 'Agent')->join('agents', 'agents.agent_id = accounts.id', 'left')->get()->row_array();
    	return $agent;
		}

	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function add_agent($data){
			$this->db->insert('agents', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function edit_agent($account_id, $data){
			$this->db->update('agents', $data, "agent_id = '".$account_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_properties($post = null){
			$this->db->select('properties.*, sellers.first_name, sellers.last_name');
			$this->db->from('properties');
			$this->db->join('sellers', 'properties.seller_id = sellers.seller_id', 'left');
			if ($post['state']) {
				$this->db->where('properties.state =', $post['state']);
			}
			if ($post['approval'] == 'All') {
			}elseif ($post['approval']) {
				$this->db->where('properties.status =', $post['approval']);
			}else{
				$this->db->where('properties.status =', 'Active');
			}
			if ($post["start_date"] && $post["end_date"]) {
				$start_date = strtotime($post["start_date"].' 00:00:01');
				$end_date = strtotime($post["end_date"].' 23:59:59');
				$this->db->where("(properties.approval_date BETWEEN ".$start_date." AND ".$end_date.")");
			}

			if ($post['order']) {
				$this->db->order_by($post['order']);
			}else{
				$this->db->order_by('properties.approval_date DESC');
			}
			if ($post['limit']) {
				$this->db->limit($post['limit']);
			}
			$properties = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $properties;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_property($property_id){
	    $property = $this->db->select('properties.*, sellers.first_name, sellers.last_name, accounts.email')->from('properties')->where("properties.property_id =", $property_id)->join('sellers', 'properties.seller_id = sellers.seller_id', 'left')->join('accounts', 'properties.seller_id = accounts.id', 'left')->get()->row_array();
    	return $property;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_property($data){
			$this->db->insert('properties', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function edit_property($account_id, $data){
			$this->db->update('properties', $data, "property_id = '".$account_id."'");
			return $this->db->last_query();
//      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}


	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function get_notified($notification_id = null){
			$this->db->select('accounts.id, accounts.email');
			$this->db->from('administrators');
			$this->db->join('accounts', 'administrators.admin_id = accounts.id', 'left');
			$this->db->like('administrators.notifications', 'i:'.$notification_id.';s:3:"Yes";', 'both');
			if ($emails = $this->db->get()->result_array()) {
				$email_array = array_column($emails,"email","id");
				return $email_array;
			}else{
				return false;
			}

		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function waiting_approvals(){
			$account = $this->db->select('accounts.user_type AS type, COUNT(id) AS total_number')->from('accounts')->where("accounts.approval =", 'Waiting')->group_by('accounts.user_type')->get()->result_array();
			$properties = $this->db->select('"Properties" AS "type", COUNT(property_id) AS total_number')->from('properties')->where("properties.status =", 'Pending')->get()->result_array();

			$results = array_merge($account, $properties);
			if ($results) {
				foreach ($results as $result) {
					$return[$result['type']] = $result['total_number'];
				}
			}
    	return $return;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function waiting_support(){
			$results = $this->db->query('SELECT "Agent" AS `user_type`, `tickets`.`agent_id` AS `user_id`, `tickets`.`message_date`, `tickets`.`message_title`, CONCAT(agents.first_name, " ", agents.last_name) AS user, agents.avatar_string AS user_image FROM `tickets` LEFT JOIN `agents` ON `tickets`.`agent_id` = `agents`.`agent_id` WHERE `tickets`.`status` = "Unread" AND `tickets`.`msg_from` = "Agent" UNION SELECT "Seller" AS `user_type`, `tickets`.`seller_id` AS `user_id`, `tickets`.`message_date`, `tickets`.`message_title`, CONCAT(sellers.first_name, " ", sellers.last_name) AS user, sellers.avatar_string AS user_image FROM `tickets` LEFT JOIN `sellers` ON `tickets`.`seller_id` = `sellers`.`seller_id` WHERE `tickets`.`status` = "Unread" AND `tickets`.`msg_from` = "Seller" ORDER by message_date')->result_array();
			if ($results) {
				foreach ($results as $result) {
					$return[$result['user_type']]++;
					$return['All']++;
					$return['messages'][$result['user_id']] = array('user_type' => $result['user_type'], 'user' => $result['user'], 'message_title' => $result["message_title"], 'message_date' => $result["message_date"], 'user_image' => $result["user_image"]);
				}
			}
    	return $return;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function waiting_notifications($user_id){
			$this->db->from('notifications');
			$this->db->where('notifications.user_id =', $user_id);
			$this->db->where('notifications.status =', 'Unread');
			$this->db->order_by('notifications.added_on DESC');

			$results = $this->db->get()->result_array();
    	return $results;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_notification_list($user_id){
			$this->db->from('notifications');
			$this->db->where('notifications.user_id =', $user_id);
			$this->db->order_by('notifications.added_on DESC');
			$results = $this->db->get()->result_array();

			$this->db->set('notifications.status','Read');
			$this->db->where('notifications.user_id =', $user_id);
			$this->db->where('notifications.status =', 'Unread');
			$this->db->update('notifications');
    	return $results;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_notification_id($notify_id){
			$this->db->from('notifications');
			$this->db->where('notifications.notify_id =', $notify_id);
			$results = $this->db->get()->row_array();
    	return $results;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function list_approval_text($filter){
			$this->db->select('approvals.*, CONCAT(administrators.first_name, " ", administrators.first_name) AS admin, administrators.avatar_string AS admin_image');
			$this->db->join('administrators', 'administrators.admin_id = approvals.admin_id', 'left');
			$this->db->from('approvals');
			if ($filter['seller_id']) {
				$this->db->select('CONCAT(sellers.first_name, " ", sellers.first_name) AS seller, sellers.avatar_string AS seller_image');
				$this->db->join('sellers', 'sellers.seller_id = approvals.seller_id', 'left');
				$this->db->where('approvals.seller_id =', $filter['seller_id']);
				if ($filter['property_id']) {
					$this->db->where('approvals.property_id =', $filter['property_id']);
				}else{
					$this->db->where('approvals.property_id IS NULL');
				}
			}
			if ($filter['agent_id']) {
				$this->db->select('CONCAT(agents.first_name, " ", agents.first_name) AS agent, agents.avatar_string AS agent_image');
				$this->db->join('agents', 'agents.agent_id = approvals.agent_id', 'left');
				$this->db->where('approvals.agent_id =', $filter['agent_id']);
			}
			$this->db->order_by('approvals.app_id ASC');

			$sellers = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $sellers;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_approval($data){
			$this->db->insert('approvals', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_settings(){
			$settings = $this->db->from('settings')->get()->result_array();
	    return $settings;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_setting($setting_name){
			$settings = $this->db->from('settings')->where("settings.setting_name =", $setting_name)->get()->row_array();
	    return $settings;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function update_setting($setting_id, $data){
			$this->db->update('settings', $data, "setting_id = '".$setting_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_state_costs(){
			$state_costs = $this->db->from('state_costs')->where("state_status =", 'Active')->order_by('state ASC')->get()->result_array();
	    return $state_costs;
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_state_cost($state_id){
			$state_cost = $this->db->from('state_costs')->where("state_id =", $state_id)->get()->row_array();
	    return $state_cost;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_state_cost_by_name($state){
	    $state_cost = $this->db->from('state_costs')->where("state =", $state)->get()->row_array();
    	return $state_cost;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function update_state_cost($state_id, $data){
			$this->db->update('state_costs', $data, "state_id = '".$state_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_state_cost($data){
			$this->db->insert('state_costs', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_cities($state_id){
			$state_costs = $this->db->from('cities')->where("state_id =", $state_id)->where("city_status =", 'Active')->order_by('city_name ASC')->get()->result_array();
	    return $state_costs;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_all_cities(){
			$state_costs = $this->db->from('cities')->where("city_status =", 'Active')->order_by('state_id ASC, city_name ASC')->get()->result_array();
	    return $state_costs;
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_city($city_id){
			$state_cost = $this->db->from('cities')->where("city_id =", $city_id)->get()->row_array();
	    return $state_cost;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function edit_city($city_id, $data){
			$this->db->update('cities', $data, "city_id = '".$city_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_city($data){
			$this->db->insert('cities', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_invoice($data){
			$this->db->insert('invoices', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function update_invoice($invoice_id, $data){
			$this->db->update('invoices', $data, "invoice_id = '".$invoice_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_coupons($post = null){
			$this->db->from('coupons');
			if ($post['coupon_status']) {
				$this->db->where('coupons.coupon_status =', $post['coupon_status']);
			}else{
				$this->db->where('coupons.coupon_status =', 'Active');
			}
			if ($post['coupon_type']) {
				$this->db->where('coupons.coupon_type =', $post['coupon_type']);
			}
			if ($post["start_date"] && $post["end_date"]) {
				$start_date = strtotime($post["start_date"].' 00:00:01');
				$end_date = strtotime($post["end_date"].' 23:59:59');
				$this->db->where("(coupons.begin_date <= ".$start_date." OR coupons.end_date >= ".$end_date.")");
			}
			$this->db->order_by('coupons.coupon_id DESC');

			$admins = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $admins;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_coupon($coupon_id){
	    $admin = $this->db->from('coupons')->where("coupon_id =", $coupon_id)->get()->row_array();
    	return $admin;
		}


	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function add_coupon($data){
			$this->db->insert('coupons', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function edit_coupon($coupon_id, $data){
			$this->db->update('coupons', $data, "coupon_id = '".$coupon_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function check_couponcode($coupon_code, $coupon_id = null){
			$this->db->select('coupon_id');
			$this->db->from('coupons');
			$this->db->where("coupons.coupon_code =", $coupon_code);
			$this->db->where_in("coupons.coupon_status", array('Active','Inactive'));
			if ($coupon_id) {
				$this->db->where("coupons.coupon_id !=", $coupon_id);
			}
			$coupon = $this->db->get()->row_array();
      return ($coupon) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_packages($post = null){
			$this->db->from('packages');
			if ($post['package_status']) {
				$this->db->where('packages.package_status =', $post['package_status']);
			}else{
				$this->db->where('packages.package_status =', 'Active');
			}
			switch ($post['package_type']) {
				case 'Win':
						$this->db->where('packages.win_limit IS NOT NULL', NULL);
					break;
				case 'Expression':
						$this->db->where('packages.offer_limit IS NOT NULL', NULL);
					break;
				case 'All':
						$this->db->where('packages.win_limit IS NOT NULL', NULL);
						$this->db->where('packages.offer_limit IS NOT NULL', NULL);
					break;
				default:
					break;
			}
			if ($post["start_date"] && $post["end_date"]) {
				$start_date = strtotime($post["start_date"].' 00:00:01');
				$end_date = strtotime($post["end_date"].' 23:59:59');
				$this->db->where("(packages.added_on BETWEEN ".$start_date." AND ".$end_date.")");
			}
			$this->db->order_by('packages.package_id DESC');

//  		echo $this->db->get_compiled_select(); exit();
			$packages = $this->db->get()->result_array();
	    return $packages;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_package($package_id){
	    $admin = $this->db->from('packages')->where("package_id =", $package_id)->get()->row_array();
    	return $admin;
		}


	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function add_package($data){
			$this->db->insert('packages', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function edit_package($package_id, $data){
			$this->db->update('packages', $data, "package_id = '".$package_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}


	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
		public function get_user_graph($start_time = null, $end_time = null){

			$this->db->select('accounts.user_type');
			$this->db->select('COUNT(id) AS amount');
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%Y') AS ayear");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%m') AS amonth");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%d') AS aday");
			$this->db->select("SUM(CASE WHEN accounts.approval = 'Completed' then 1 Else 0 end) AS approveds");
			$this->db->select("SUM(CASE WHEN accounts.approval = 'Waiting' then 1 Else 0 end) AS waitings");
			$this->db->select("SUM(CASE WHEN accounts.approval = 'Denied' then 1 Else 0 end) AS denieds");
			$this->db->from('accounts');
			$this->db->where_in('accounts.user_type' , array('Agent','Seller'));
			if ($start_time && $end_time) {
				$start_date = strtotime($start_time.' 00:00:01');
				$end_date = strtotime($end_time.' 23:59:59');
			}else{
				$start_date = strtotime(date('Y-m-01').' 00:00:01');
				$end_date = strtotime(date('Y-m-t').' 23:59:59');
			}
			$this->db->where("(accounts.created_on BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->group_by('ayear, amonth, aday, accounts.user_type');
			$this->db->order_by(' ayear ASC, amonth ASC, aday ASC');

			$prop_datas = $this->db->get()->result_array();
			foreach ($prop_datas as $prop_data) {
				$date_string = $prop_data['ayear'].$prop_data['amonth'].$prop_data['aday'];
				$results[strtolower($prop_data['user_type'])][$date_string] = (int)$prop_data['amount'];
				$results['numbers'][strtolower($prop_data['user_type'])] += (int)$prop_data['amount'];
				$results['approveds'][$date_string] += $prop_data['approveds'];
				$results['numbers']['approveds'] += (int)$prop_data['approveds'];
				$results['waitings'][$date_string] += $prop_data['waitings'];
				$results['numbers']['waitings'] += (int)$prop_data['waitings'];
				$results['denieds'][$date_string] += $prop_data['denieds'];
				$results['numbers']['denieds'] += (int)$prop_data['denieds'];
			}

			$dataset_begin = new DateTime();
			$dataset_begin->setTimestamp($start_date);
			$dataset_end = new DateTime();
			$dataset_end->setTimestamp($end_date);

			$dataset_range = new DatePeriod($dataset_begin, new DateInterval('P1D'), $dataset_end);

			foreach($dataset_range as $date){
				$today = $date->format("Ymd");
				$return['datatable'][$today]['record_id'] = $today;
				$return['datatable'][$today]['date'] = $return['index'][] = $date->format("Y-m-d");
				$return['datatable'][$today]['seller'] = $return['seller'][] = (($results['seller'][$today])? $results['seller'][$today]:0);
				$return['datatable'][$today]['agent'] = $return['agent'][] = (($results['agent'][$today])? $results['agent'][$today]:0);
				$return['datatable'][$today]['approveds'] = $return['approveds'][] = (($results['approveds'][$today])? $results['approveds'][$today]:0);
				$return['datatable'][$today]['waitings'] = $return['waitings'][] = (($results['waitings'][$today])? $results['waitings'][$today]:0);
				$return['datatable'][$today]['denieds'] = $return['denieds'][] = (($results['denieds'][$today])? $results['denieds'][$today]:0);
			}

			if(!$results['numbers']['seller']){$results['numbers']['seller'] = 0;}
			if(!$results['numbers']['agent']){$results['numbers']['agent'] = 0;}
			if(!$results['numbers']['approveds']){$results['numbers']['approveds'] = 0;}
			if(!$results['numbers']['waitings']){$results['numbers']['waitings'] = 0;}
			if(!$results['numbers']['denieds']){$results['numbers']['denieds'] = 0;}

			$response['formatted']['dates'] = array_values($return['index']);
			$response['formatted']['seller'] = array_values($return['seller']);
			$response['formatted']['agent'] = array_values($return['agent']);
			$response['formatted']['approveds'] = array_values($return['approveds']);
			$response['formatted']['waitings'] = array_values($return['waitings']);
			$response['formatted']['denieds'] = array_values($return['denieds']);
			$response['datatable'] = array_values($return['datatable']);
			$response['numbers'] = $results['numbers'];
//  		echo $this->db->last_query();exit();
	    return $response;
		}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
		public function get_properties_graph($start_time = null, $end_time = null){
			/*
			$this->db->select('properties.*');
			$this->db->from('properties');
			$prop_datas = $this->db->get()->result_array();

			$name_array = array(
			1 => 'Active',
			2 => 'Pending',
			3 => 'Declined',
			4 => 'Contracted',
			5 => 'Inactivated',
			);
			foreach ($prop_datas as $prop_data) {
				$data['status'] = $name_array[rand(1,5)];
				$this->db->update('properties', $data, "property_id = '".$prop_data['property_id']."'");
			}
			*/
			$this->db->select('properties.type');
			$this->db->select('COUNT(property_id) AS amount');
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(properties.created_on),'%Y') AS ayear");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(properties.created_on),'%m') AS amonth");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(properties.created_on),'%d') AS aday");
			$this->db->select("SUM(CASE WHEN properties.status = 'Active' then 1 Else 0 end) AS actives");
			$this->db->select("SUM(CASE WHEN properties.status = 'Pending' then 1 Else 0 end) AS pendings");
			$this->db->select("SUM(CASE WHEN properties.status = 'Declined' then 1 Else 0 end) AS declineds");
			$this->db->select("SUM(CASE WHEN properties.status = 'Contracted' then 1 Else 0 end) AS contracteds");
			$this->db->select("SUM(CASE WHEN properties.status = 'Inactivated' then 1 Else 0 end) AS inactivateds");
			$this->db->from('properties');
			if ($start_time && $end_time) {
				$start_date = strtotime($start_time.' 00:00:01');
				$end_date = strtotime($end_time.' 23:59:59');
			}else{
				$start_date = strtotime(date('Y-m-01').' 00:00:01');
				$end_date = strtotime(date('Y-m-t').' 23:59:59');
			}
			$this->db->where("(properties.created_on BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->group_by('ayear, amonth, aday, properties.type');
			$this->db->order_by(' ayear ASC, amonth ASC, aday ASC');

			$prop_datas = $this->db->get()->result_array();
			foreach ($prop_datas as $prop_data) {
				$date_string = $prop_data['ayear'].$prop_data['amonth'].$prop_data['aday'];
				$results[strtolower($prop_data['type'])][$date_string] = (int)$prop_data['amount'];
				$results['numbers'][strtolower($prop_data['type'])] += (int)$prop_data['amount'];
				$results['active'][$date_string] += $prop_data['actives'];
				$results['numbers']['active'] += (int)$prop_data['actives'];
				$results['pending'][$date_string] += $prop_data['pendings'];
				$results['numbers']['pending'] += (int)$prop_data['pendings'];
				$results['declined'][$date_string] += $prop_data['declineds'];
				$results['numbers']['declined'] += (int)$prop_data['declineds'];
				$results['contracted'][$date_string] += $prop_data['contracteds'];
				$results['numbers']['contracted'] += (int)$prop_data['contracteds'];
				$results['inactive'][$date_string] += $prop_data['inactivateds'];
				$results['numbers']['inactive'] += (int)$prop_data['inactivateds'];
			}

			$dataset_begin = new DateTime();
			$dataset_begin->setTimestamp($start_date);
			$dataset_end = new DateTime();
			$dataset_end->setTimestamp($end_date);

			$dataset_range = new DatePeriod($dataset_begin, new DateInterval('P1D'), $dataset_end);

			foreach($dataset_range as $date){
				$today = $date->format("Ymd");
				$return['datatable'][$today]['record_id'] = $today;
				$return['datatable'][$today]['date'] = $return['index'][] = $date->format("Y-m-d");
				$return['datatable'][$today]['commercial'] = $return['commercial'][] = (($results['commercial'][$today])? $results['commercial'][$today]:0);
				$return['datatable'][$today]['residential'] = $return['residential'][] = (($results['residential'][$today])? $results['residential'][$today]:0);
				$return['datatable'][$today]['actives'] = $return['actives'][] = (($results['active'][$today])? $results['active'][$today]:0);
				$return['datatable'][$today]['pending'] = $return['pending'][] = (($results['pending'][$today])? $results['pending'][$today]:0);
				$return['datatable'][$today]['declined'] = $return['declined'][] = (($results['declined'][$today])? $results['declined'][$today]:0);
				$return['datatable'][$today]['contracted'] = $return['contracted'][] = (($results['contracted'][$today])? $results['contracted'][$today]:0);
				$return['datatable'][$today]['inactive'] = $return['inactive'][] = (($results['inactive'][$today])? $results['inactive'][$today]:0);
			}

			if(!$results['numbers']['commercial']){$results['numbers']['commercial'] = 0;}
			if(!$results['numbers']['residential']){$results['numbers']['residential'] = 0;}
			if(!$results['numbers']['pending']){$results['numbers']['pending'] = 0;}
			if(!$results['numbers']['declined']){$results['numbers']['declined'] = 0;}
			if(!$results['numbers']['active']){$results['numbers']['active'] = 0;}
			if(!$results['numbers']['contracted']){$results['numbers']['contracted'] = 0;}
			if(!$results['numbers']['inactive']){$results['numbers']['inactive'] = 0;}

			$response['formatted']['dates'] = array_values($return['index']);
			$response['formatted']['commercial'] = array_values($return['commercial']);
			$response['formatted']['residential'] = array_values($return['residential']);
			$response['formatted']['pending'] = array_values($return['pending']);
			$response['formatted']['declined'] = array_values($return['declined']);
			$response['formatted']['active'] = array_values($return['actives']);
			$response['formatted']['contracted'] = array_values($return['contracted']);
			$response['formatted']['inactive'] = array_values($return['inactive']);
			$response['datatable'] = array_values($return['datatable']);
			$response['numbers'] = $results['numbers'];
//  		echo $this->db->last_query();exit();
	    return $response;
		}



	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
		public function get_financial_graph($start_time = null, $end_time = null){

			$this->db->select('invoices.payment_type');
			$this->db->select('COUNT(invoice_id) AS amount');
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(invoices.payment_time),'%Y') AS ayear");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(invoices.payment_time),'%m') AS amonth");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(invoices.payment_time),'%d') AS aday");
			$this->db->select("SUM(invoices.final_amount) AS amount");
//			$this->db->select("SUM(CASE WHEN invoices.payment_type = 'Commission' then invoices.final_amount Else 0 end) AS commission");
//			$this->db->select("SUM(CASE WHEN invoices.payment_type = 'Product' then invoices.final_amount Else 0 end) AS product");
//			$this->db->select("SUM(CASE WHEN invoices.payment_type = 'Membership' then invoices.final_amount Else 0 end) AS membership");
			$this->db->from('invoices');
			$this->db->where('invoices.invoice_status' , 'Completed');
			if ($start_time && $end_time) {
				$start_date = strtotime($start_time.' 00:00:01');
				$end_date = strtotime($end_time.' 23:59:59');
			}else{
				$start_date = strtotime(date('Y-m-01').' 00:00:01');
				$end_date = strtotime(date('Y-m-t').' 23:59:59');
			}
			$this->db->where("(invoices.payment_time BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->group_by('ayear, amonth, aday, invoices.payment_type');
			$this->db->order_by(' ayear ASC, amonth ASC, aday ASC');

			$prop_datas = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
			foreach ($prop_datas as $prop_data) {
				$date_string = $prop_data['ayear'].$prop_data['amonth'].$prop_data['aday'];
				$results[strtolower($prop_data['payment_type'])][$date_string] = (int)$prop_data['amount'];
				$results['total'][$date_string] += (int)$prop_data['amount'];
				$results['numbers'][strtolower($prop_data['payment_type'])] += (int)$prop_data['amount'];
			}

			$dataset_begin = new DateTime();
			$dataset_begin->setTimestamp($start_date);
			$dataset_end = new DateTime();
			$dataset_end->setTimestamp($end_date);

			$dataset_range = new DatePeriod($dataset_begin, new DateInterval('P1D'), $dataset_end);

			foreach($dataset_range as $date){
				$today = $date->format("Ymd");
				$return['datatable'][$today]['record_id'] = $today;
				$return['datatable'][$today]['date'] = $return['index'][] = $date->format("Y-m-d");
				$return['datatable'][$today]['total'] = $return['total'][] = (($results['total'][$today])? $results['total'][$today]:0);
				$return['datatable'][$today]['membership'] = $return['membership'][] = (($results['membership'][$today])? $results['membership'][$today]:0);
				$return['datatable'][$today]['product'] = $return['product'][] = (($results['product'][$today])? $results['product'][$today]:0);
				$return['datatable'][$today]['commission'] = $return['commission'][] = (($results['commission'][$today])? $results['commission'][$today]:0);
			}

			if(!$results['numbers']['membership']){$results['numbers']['membership'] = 0;}
			if(!$results['numbers']['product']){$results['numbers']['product'] = 0;}
			if(!$results['numbers']['commission']){$results['numbers']['commission'] = 0;}

			$response['formatted']['dates'] = array_values($return['index']);
			$response['formatted']['membership'] = array_values($return['membership']);
			$response['formatted']['product'] = array_values($return['product']);
			$response['formatted']['commission'] = array_values($return['commission']);
			$response['datatable'] = array_values($return['datatable']);
			$response['numbers'] = $results['numbers'];
	    return $response;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_message_list($filter = null){
			$this->db->select('messages.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS Seller, CONCAT(agents.first_name, " ", agents.last_name) AS Agent');
			$this->db->from('messages');
			$this->db->join('sellers', 'messages.seller_id = sellers.seller_id', 'left');
			$this->db->join('agents', 'messages.agent_id = agents.agent_id', 'left');
			if ($filter['agent_id']) {
				$this->db->where('messages.agent_id =', $filter['agent_id']);
			}
			if ($filter['seller_id']) {
				$this->db->where('messages.seller_id =', $filter['seller_id']);
			}
			$this->db->order_by('messages.message_date DESC');

			$messages = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    	return $messages;
		}



		public function get_plan_list($request)
		{	
			$search 		 = $request['search']['value']; // Search value	
			$start 			 = $request['start'];
			$rowperpage 	 = $request['length']; // Rows display per page
			$columnIndex 	 = $request['order'][0]['column']; // Column index
			$columnName 	 = $request['columns'][$columnIndex]['data']; // Column name
			$columnSortOrder = $request['order'][0]['dir']; // asc or desc

			$this->db->select('member_ship_plans.*,  plan_feature.plan_id, plan_feature.feature_id, SUM(plan_features.price) as price, SUM(plan_features.discount_value) as discount, plan_features.discount_type');
			$this->db->join('plan_feature', 'member_ship_plans.id = plan_feature.plan_id', 'left');
			$this->db->join('plan_features', 'plan_feature.feature_id = plan_features.id', 'left');
			$this->db->from('member_ship_plans');	
			$this->db->like('member_ship_plans.title', $search, 'both');
			$this->db->group_by('member_ship_plans.id');
			$this->db->order_by($columnName, $columnSortOrder);
			$this->db->limit($rowperpage, $start);
			$plans = $this->db->get()->result_array();
	    	return $plans;
		}


		public function get_features_list($request)
		{
			$search 		 = $request['search']['value']; // Search value	
			$start 			 = $request['start'];
			$rowperpage 	 = $request['length']; // Rows display per page
			$columnIndex 	 = $request['order'][0]['column']; // Column index
			$columnName 	 = $request['columns'][$columnIndex]['data']; // Column name
			$columnSortOrder = $request['order'][0]['dir']; // asc or desc

			$this->db->select('plan_features.*');
			$this->db->from('plan_features');
			$this->db->like('plan_features.title', $search, 'both');
			$this->db->order_by($columnName, $columnSortOrder);
			$this->db->limit($rowperpage, $start);
			$plans = $this->db->get()->result_array();

	    	return $plans;
		}


		public function get_total_features()
		{
			$query = $this->db->query('SELECT id FROM plan_features');
			return $query->num_rows();
		}


		public function get_total_plans()
		{
			$query = $this->db->query('SELECT id FROM plan_features');
			return $query->num_rows();
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_message_id($message_id){
			$this->db->select('messages.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS Seller, CONCAT(agents.first_name, " ", agents.last_name) AS Agent');
			$this->db->from('messages');
			$this->db->join('sellers', 'messages.seller_id = sellers.seller_id', 'left');
			$this->db->join('agents', 'messages.agent_id = agents.agent_id', 'left');
			$this->db->where('messages.message_id =', $message_id);
			$this->db->order_by('messages.message_date DESC');

			$messages = $this->db->get()->row_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_properties_list($filter = null){
			if ($filter['seller_id']) {
				$this->db->select('properties.*, sellers.first_name, sellers.last_name');
				$this->db->from('properties');
				$this->db->join('sellers', 'properties.seller_id = sellers.seller_id', 'left');
				$this->db->where('properties.seller_id =', $filter['seller_id']);
			}
			if ($filter['agent_id']) {
				$this->db->select('properties.*,agreements.agr_status, sellers.first_name, sellers.last_name');
				$this->db->from('agreements');
				$this->db->join('sellers', 'agreements.seller_id = sellers.seller_id', 'left');
				$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
				$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
				$this->db->where('agreements.agent_id =', $filter['agent_id']);
			}
			$this->db->order_by('properties.property_id ASC');

			$properties = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $properties;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_offer_list($filter = null){
			$this->db->select('proposals.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS Seller, CONCAT(agents.first_name, " ", agents.last_name) AS Agent, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('sellers', 'proposals.seller_id = sellers.seller_id', 'left');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			if ($filter['agent_id']) {
				$this->db->where('proposals.agent_id =', $filter['agent_id']);
			}
			if ($filter['seller_id']) {
				$this->db->where('proposals.seller_id =', $filter['seller_id']);
			}
			$this->db->order_by('proposals.prop_id ASC');

			$records = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $records;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_offer_id($offer_id){
			$this->db->select('proposals.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS Seller, CONCAT(agents.first_name, " ", agents.last_name) AS Agent, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('sellers', 'proposals.seller_id = sellers.seller_id', 'left');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('proposals.prop_id =', $offer_id);

			$record = $this->db->get()->row_array();
//  		echo $this->db->last_query();exit();
	    return $record;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_contract_list($filter = null){
			$this->db->select('agreements.*, proposals.commission_rate, proposals.contract_length, CONCAT(sellers.first_name, " ", sellers.last_name) AS Seller, CONCAT(agents.first_name, " ", agents.last_name) AS Agent, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('agreements');
			$this->db->join('sellers', 'agreements.seller_id = sellers.seller_id', 'left');
			$this->db->join('agents', 'agreements.agent_id = agents.agent_id', 'left');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			if ($filter['agent_id']) {
				$this->db->where('agreements.agent_id =', $filter['agent_id']);
			}
			if ($filter['seller_id']) {
				$this->db->where('agreements.seller_id =', $filter['seller_id']);
			}
			$this->db->order_by('agreements.agr_id ASC');

			$records = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $records;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_contract_id($contract_id){
			$this->db->select('agreements.*, proposals.commission_rate, proposals.contract_length, CONCAT(sellers.first_name, " ", sellers.last_name) AS Seller, CONCAT(agents.first_name, " ", agents.last_name) AS Agent, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('agreements');
			$this->db->join('sellers', 'agreements.seller_id = sellers.seller_id', 'left');
			$this->db->join('agents', 'agreements.agent_id = agents.agent_id', 'left');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('agreements.agr_id =', $contract_id);

			$record = $this->db->get()->row_array();
//  		echo $this->db->last_query();exit();
	    return $record;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function dashboard_numbers(){
			$this->db->select('accounts.user_type, COUNT(id) AS amount');
			$this->db->from('accounts');
			$this->db->group_by('accounts.user_type');
			$this->db->where('accounts.active =', 1);
			$start_date = strtotime(date('Y-m-01').' 00:00:01');
			$end_date = strtotime(date('Y-m-t').' 23:59:59');
			$this->db->where("(accounts.approval_date BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->where_in('accounts.user_type', array('Agent','Seller'));

			$records = $this->db->get()->result_array();
			foreach ($records as $record) {
				$return['numbers']['accounts'][$record['user_type']] = $record['amount'];
			}

			$this->db->select('properties.type, COUNT(property_id) AS amount');
			$this->db->from('properties');
			$this->db->group_by('properties.type');
			$start_date = strtotime(date('Y-m-01').' 00:00:01');
			$end_date = strtotime(date('Y-m-t').' 23:59:59');
			$this->db->where("(properties.created_on BETWEEN ".$start_date." AND ".$end_date.")");

			$records = $this->db->get()->result_array();
  		echo $this->db->last_query();exit();
			foreach ($records as $record) {
				$return['numbers']['properties'][$record['user_type']] = $record['amount'];
			}
	    return ;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_tutorial($page_id)
		{
	    	$record = $this->db->from('tutorial_pages')->where("page_id =", 'agentvideo')->get()->row_array();
    		return $record;
		}

	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function edit_tutorial($page_id, $data){
			$this->db->update('tutorial_pages', $data, "page_id = '".$page_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_user_invoice($invoice_id){
	    $this->db->select('invoices.*, agents.stripe_id, agents.payment_id, agent_coupons.coupon_code, CONCAT(administrators.first_name, " ", administrators.last_name) AS refund_admin');
	    $this->db->from('invoices');
	    $this->db->where("invoices.invoice_id =", $invoice_id);
	    $this->db->join('agents', 'invoices.agent_id = agents.agent_id', 'left');
	    $this->db->join('agent_coupons', 'invoices.coupon_id = agent_coupons.use_id', 'left');
	    $this->db->join('administrators', 'invoices.refund_admin_id = administrators.admin_id', 'left');
			$this->db->order_by('invoices.payment_time ASC, invoices.invoice_id DESC');
	    $invoice = $this->db->get()->row_array();
   		return $invoice;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_user_invoices($user_id, $status = null){
	    $this->db->select('invoices.*, agents.stripe_id, agents.payment_id, agent_coupons.coupon_code, CONCAT(administrators.first_name, " ", administrators.last_name) AS refund_admin');
	    $this->db->from('invoices');
	    $this->db->where("invoices.agent_id =", $user_id);
	    $this->db->where("invoices.try_time <=", time());
	    if ($status) {
	    	$this->db->where_in("invoices.invoice_status", $status);
	    }else{
	    	$this->db->where_in("invoices.invoice_status", array('Open','Failed'));
	    	$this->db->where("invoices.try_amount <=", 3);
	    }
	    $this->db->join('agents', 'invoices.agent_id = agents.agent_id', 'left');
	    $this->db->join('agent_coupons', 'invoices.coupon_id = agent_coupons.use_id', 'left');
	    $this->db->join('administrators', 'invoices.refund_admin_id = administrators.admin_id', 'left');
			$this->db->order_by('invoices.payment_time ASC, invoices.invoice_id DESC');
	    $invoices = $this->db->get()->result_array();
   		return $invoices;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_support($data){
			$this->db->insert('tickets', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_agent_supports($post = null){
			$this->db->select('accounts.email, agents.*, MAX(tickets.message_date) AS message_date, tickets.status AS tstatus');
			$this->db->from('tickets');
			$this->db->join('agents', 'tickets.agent_id = agents.agent_id', 'left');
			$this->db->join('accounts', 'tickets.agent_id = accounts.id', 'left');
			$this->db->where('tickets.msg_from =', 'Agent');
			if ($post['state']) {
				$this->db->where('agents.state =', $post['state']);
			}
			if ($post['status']) {
				$this->db->where('tickets.status =', $post['status']);
			}
			if ($post["start_date"] && $post["end_date"]) {
				$start_date = strtotime($post["start_date"].' 00:00:01');
				$end_date = strtotime($post["end_date"].' 23:59:59');
				$this->db->where("(tickets.message_date BETWEEN ".$start_date." AND ".$end_date.")");
			}
			$this->db->group_by('tickets.agent_id');
			$this->db->order_by('tickets.message_date DESC');
			$agents = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $agents;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function agent_support_history($agent_id){
			$this->db->set('tickets.status','Read');
			$this->db->set('tickets.seen_date',time());
			$this->db->where('tickets.agent_id =', $agent_id);
			$this->db->where('tickets.status =', 'Unread');
			$this->db->where('tickets.msg_from =', 'Agent');
			$this->db->update('tickets');
			$this->db->reset_query();

			$this->db->select('tickets.*, CONCAT(agents.first_name, " ", agents.last_name) AS agent, agents.avatar_string AS agent_image, CONCAT(administrators.first_name, " ", administrators.last_name) AS admin, administrators.avatar_string AS admin_image');
			$this->db->from('tickets');
			$this->db->join('administrators', 'tickets.admin_id = administrators.admin_id', 'left');
			$this->db->join('agents', 'tickets.agent_id = agents.agent_id', 'left');
			$this->db->where('tickets.agent_id =', $agent_id);
			$this->db->where_in('tickets.status', array('Read','Unread'));
			$this->db->order_by('tickets.message_date DESC');

			$messages = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_seller_supports($post = null){
			$this->db->select('accounts.email, sellers.*, MAX(tickets.message_date) AS message_date, tickets.status AS tstatus');
			$this->db->from('tickets');
			$this->db->join('sellers', 'tickets.seller_id = sellers.seller_id', 'left');
			$this->db->join('accounts', 'tickets.agent_id = accounts.id', 'left');
			$this->db->where('tickets.msg_from =', 'Seller');
			if ($post['state']) {
				$this->db->where('sellers.state =', $post['state']);
			}
			if ($post['status']) {
				$this->db->where('tickets.status =', $post['status']);
			}
			if ($post["start_date"] && $post["end_date"]) {
				$start_date = strtotime($post["start_date"].' 00:00:01');
				$end_date = strtotime($post["end_date"].' 23:59:59');
				$this->db->where("(tickets.message_date BETWEEN ".$start_date." AND ".$end_date.")");
			}
			$this->db->group_by('tickets.seller_id');
			$this->db->order_by('tickets.message_date DESC');
			$agents = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $agents;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function seller_support_history($seller_id){
			$this->db->set('tickets.status','Read');
			$this->db->set('tickets.seen_date',time());
			$this->db->where('tickets.seller_id =', $seller_id);
			$this->db->where('tickets.status =', 'Unread');
			$this->db->where('tickets.msg_from =', 'Seller');
			$this->db->update('tickets');
			$this->db->reset_query();

			$this->db->select('tickets.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS seller, sellers.avatar_string AS seller_image, CONCAT(administrators.first_name, " ", administrators.last_name) AS admin, administrators.avatar_string AS admin_image');
			$this->db->from('tickets');
			$this->db->join('administrators', 'tickets.admin_id = administrators.admin_id', 'left');
			$this->db->join('sellers', 'tickets.seller_id = sellers.seller_id', 'left');
			$this->db->where('tickets.seller_id =', $seller_id);
			$this->db->where_in('tickets.status', array('Read','Unread'));
			$this->db->order_by('tickets.message_date DESC');

			$messages = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function set_default_image($property_id, $image_type){
			$this->db->query("UPDATE properties SET default_image = properties.".$image_type." WHERE property_id = '".$property_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function delete_property_image($property_id, $image_type){
			$this->db->query("UPDATE properties SET ".$image_type." = NULL WHERE property_id = '".$property_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function dashboard_last_agents(){
			$this->db->select('COUNT(id) AS amount');
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%Y') AS ayear");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%m') AS amonth");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%d') AS aday");
			$this->db->from('accounts');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Agent');
			$this->db->where('accounts.approval =', 'Completed');
			$start_date = strtotime('-15 days');
			$end_date = time();
			$this->db->where("(accounts.created_on BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->group_by('ayear, amonth, aday');
			$this->db->order_by(' ayear ASC, amonth ASC, aday ASC');

			$records = $this->db->get()->result_array();
			foreach ($records as $record) {
				$date_string = $record['ayear'].$record['amonth'].$record['aday'];
				$results[$date_string] = $record['amount'];
			}

			$dataset_begin = new DateTime();
			$dataset_begin->setTimestamp($start_date);
			$dataset_end = new DateTime();
			$dataset_end->setTimestamp($end_date);

			$dataset_range = new DatePeriod($dataset_begin, new DateInterval('P1D'), $dataset_end);

			foreach($dataset_range as $date){
				$today = $date->format("Ymd");
				$val = (($results[$today])? $results[$today]:0);
//				$return['list'][$today]['date'] = $date->format("Y-m-d");
				$return['list'][] = $val;
				$return['total'] += $val;
			}

	    return $return;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function dashboard_last_sellers(){
			$this->db->select('COUNT(id) AS amount');
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%Y') AS ayear");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%m') AS amonth");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(accounts.created_on),'%d') AS aday");
			$this->db->from('accounts');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Seller');
			$this->db->where('accounts.approval =', 'Completed');
			$start_date = strtotime('-15 days');
			$end_date = time();
			$this->db->where("(accounts.created_on BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->group_by('ayear, amonth, aday');
			$this->db->order_by(' ayear ASC, amonth ASC, aday ASC');

			$records = $this->db->get()->result_array();
			foreach ($records as $record) {
				$date_string = $record['ayear'].$record['amonth'].$record['aday'];
				$results[$date_string] = $record['amount'];
			}

			$dataset_begin = new DateTime();
			$dataset_begin->setTimestamp($start_date);
			$dataset_end = new DateTime();
			$dataset_end->setTimestamp($end_date);

			$dataset_range = new DatePeriod($dataset_begin, new DateInterval('P1D'), $dataset_end);

			foreach($dataset_range as $date){
				$today = $date->format("Ymd");
				$val = (($results[$today])? $results[$today]:0);
//				$return['list'][$today]['date'] = $date->format("Y-m-d");
				$return['list'][] = $val;
				$return['total'] += $val;
			}

	    return $return;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function dashboard_last_properties(){
			$this->db->select('COUNT(property_id) AS amount');
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(properties.created_on),'%Y') AS ayear");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(properties.created_on),'%m') AS amonth");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(properties.created_on),'%d') AS aday");
			$this->db->from('properties');
			$this->db->where('properties.status =', 'Active');
			$start_date = strtotime('-15 days');
			$end_date = time();
			$this->db->where("(properties.created_on BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->group_by('ayear, amonth, aday');
			$this->db->order_by(' ayear ASC, amonth ASC, aday ASC');

			$records = $this->db->get()->result_array();
			foreach ($records as $record) {
				$date_string = $record['ayear'].$record['amonth'].$record['aday'];
				$results[$date_string] = $record['amount'];
			}

			$dataset_begin = new DateTime();
			$dataset_begin->setTimestamp($start_date);
			$dataset_end = new DateTime();
			$dataset_end->setTimestamp($end_date);

			$dataset_range = new DatePeriod($dataset_begin, new DateInterval('P1D'), $dataset_end);

			foreach($dataset_range as $date){
				$today = $date->format("Ymd");
				$val = (($results[$today])? $results[$today]:0);
				$return['list'][$today]['date'] = $date->format("Y-m-d");
				$return['list'][$today]['value'] = $val;
				$return['total'] += $val;
			}

	    return $return;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function dashboard_last_earnings(){
			$this->db->select('SUM(final_amount) AS amount');
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(invoices.payment_time),'%Y') AS ayear");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(invoices.payment_time),'%m') AS amonth");
			$this->db->select("DATE_FORMAT(FROM_UNIXTIME(invoices.payment_time),'%d') AS aday");
			$this->db->from('invoices');
			$this->db->where('invoices.invoice_status =', 'invoice_status');
			$start_date = strtotime('-15 days');
			$end_date = time();
			$this->db->where("(invoices.payment_time BETWEEN ".$start_date." AND ".$end_date.")");
			$this->db->group_by('ayear, amonth, aday');
			$this->db->order_by(' ayear ASC, amonth ASC, aday ASC');

			$records = $this->db->get()->result_array();
			foreach ($records as $record) {
				$date_string = $record['ayear'].$record['amonth'].$record['aday'];
				$results[$date_string] = $record['amount'];
			}

			$dataset_begin = new DateTime();
			$dataset_begin->setTimestamp($start_date);
			$dataset_end = new DateTime();
			$dataset_end->setTimestamp($end_date);

			$dataset_range = new DatePeriod($dataset_begin, new DateInterval('P1D'), $dataset_end);

			foreach($dataset_range as $date){
				$today = $date->format("Ymd");
				$val = (($results[$today])? $results[$today]:0);
				$return['list'][$today]['date'] = $date->format("Y-m-d");
				$return['list'][$today]['value'] = $val;
				$return['total'] += $val;
			}

	    return $return;
		}

		public function dashboard_proposals_count($post = null){
			$this->db->select('COUNT(prop_id) AS amount');
			$this->db->from('proposals');

			$records = $this->db->get()->row_array();
	    return $records['amount'];
		}

		public function dashboard_contract_count($post = null){
			$this->db->select('COUNT(agr_id) AS amount');
			$this->db->from('agreements');

			$records = $this->db->get()->row_array();
	    return $records['amount'];
		}

		public function dashboard_coupon_count($post = null){
			$this->db->select('COUNT(coupon_id) AS amount');
			$this->db->from('coupons');
			$this->db->where('coupons.coupon_status =', 'Active');

			$records = $this->db->get()->row_array();
	    return $records['amount'];
		}

		public function dashboard_approval_counts($post = null){
			$this->db->select('COUNT(package_id) AS amount');
			$this->db->from('packages');
			$this->db->where('packages.package_status =', 'Active');

			$records = $this->db->get()->row_array();
	    return $records['amount'];
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_notification($user_ids, $title, $message, $action = null, $action_id = null){
			if (is_array($user_ids)) {
				foreach ($user_ids as $user_id => $email) {
					$data = array(
					'user_id' => $user_id,
					'message' => $message,
					'title' => $title,
					'action' => $action,
					'action_id' => $action_id,
					'added_on' => time()
					);
					$this->db->insert('notifications', $data);
				}
			}else{
				$data = array(
				'user_id' => $user_ids,
				'message' => $message,
				'title' => $title,
				'action' => $action,
				'action_id' => $action_id,
				'added_on' => time()
				);
				$this->db->insert('notifications', $data);
			}
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function clear_notifications($user_id, $action = null, $action_id = null){
			$this->db->set('status','Read');
			$this->db->where('user_id =', $user_id);
			$this->db->where('status =', 'Unread');
			if($action){
				$this->db->where('action =', $action);
			}
			if($action_id){
				$this->db->where('action_id =', $action_id);
			}
			$this->db->update('notifications');
			return $this->waiting_notifications($user_id);
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_licenses($agent_id){
			$this->db->from('licenses');
			$this->db->where('licenses.license_status !=', 'Removed');
			$this->db->where("agent_id =", $agent_id);
			$this->db->order_by('licenses.license_id DESC');

			$records = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $records;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_license($license_id){
	    $record = $this->db->from('licenses')->where("license_id =", $license_id)->get()->row_array();
    	return $record;
		}


	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function add_license($data){
			$this->db->insert('licenses', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function edit_license($license_id, $data){
			$this->db->update('licenses', $data, "license_id = '".$license_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function check_active_licenses($agent_id){
			$this->db->from('licenses');
			$this->db->where('licenses.license_status =', 'Active');
			$this->db->where("agent_id =", $agent_id);
			$this->db->order_by('licenses.license_id DESC');

			$records = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $records;
	}

	public function save_membership_plan($request)
	{

		$data = array(
			'title'   => $request['title'],
			'details' => $request['detail']
	    );
		$this->db->insert('member_ship_plans', $data);
		$insert_id = $this->db->insert_id();

		if(isset($request['features']) && !empty($request['features']))
		{
			$features = $request['features'];
			foreach ($features as $key => $feature)
			{
				$data = array(
					"plan_id"    => $insert_id,
					"feature_id" => $feature
				);

				$this->db->insert('plan_feature', $data);

			}
		}

	    return true;
	}

	

	public function save_plan($request)
	{

		$data = array(
			'title'   	  	 => $request['title'],
			'description' 	 => $request['detail'],
			'price'       	 => $request['price'],
			'discount_value' => $request['discount'],
			'discount_type'  => $request['type']

			);

		$this->db->insert('plan_features', $data);
		$insert_id = $this->db->insert_id();

		if(isset($request['plans']) && !empty($request['plans']))
		{
			$plans = $request['plans'];
			foreach ($plans as $key => $plan)
			{
				$data = array(
					"plan_id"    => $plan,
					"feature_id" => $insert_id
				);

				$this->db->insert('plan_feature', $data);

			}
		}

		return true;
	}

	public function update_membership_plan($request)
	{
		$data = array(
			'title'   => $request['editTitle'],
			'details' => $request['editDetail']
	    );

		$this->db->where('id', $request['id']);
		$this->db->update('member_ship_plans', $data);
		$this->db->delete('plan_feature', array('plan_id' => $request['id']));

		if(isset($request['features']) && !empty($request['features']))
		{

			$features = $request['features'];
			foreach ($features as $key => $feature)
			{
				$data = array(
					"plan_id"    => $request['id'],
					"feature_id" => $feature
				);

				$this->db->insert('plan_feature', $data);

			}
		}
       return true;
	}


	public function update_plan($request)
	{	


		$data = array(
			'title'   	  	 => $request['editTitle'],
			'description' 	 => $request['editDetail'],
			'price'       	 => $request['editPrice'],
			'discount_value' => $request['editDiscount'],
			'discount_type'  => $request['editType']
	    );

		$this->db->where('id', $request['id']);
		$this->db->update('plan_features', $data);

		if(isset($request['updateOptions']) && !empty($request['updateOptions']))
		{

			$this->db->delete('plan_feature', array('feature_id' => $request['id']));
			$plans  = $request['updateOptions'];

			foreach ($plans as $key => $plan)
			{
				$data = array(
					"plan_id"    => $plan,
					"feature_id" => $request['id']
				);

				$this->db->insert('plan_feature', $data);

			}
		}


       return true;
	}



	public function delete_plan($request)
	{
		$this->db->delete('member_ship_plans', array('id' => $request['id']));
		$this->db->delete('plan_feature', array('plan_id' => $request['id']));
		return true;
	}

	public function delete_feature($request)
	{
		$this->db->delete('plan_features', array('id' => $request['id']));
		$this->db->delete('plan_feature', array('feature_id' => $request['id']));
		return true;
	}

	public function edit_plan($request)
	{
		$this->db->select('member_ship_plans.*, plan_feature.*,  plan_features.title as feature, plan_features.id');
		$this->db->join('plan_feature', 'plan_feature.plan_id = member_ship_plans.id', 'left');
		$this->db->join('plan_features', 'plan_feature.feature_id = plan_features.id', 'left');
		$this->db->from('member_ship_plans');
		$this->db->where("member_ship_plans.id =", $request['id']);
		return $records = $this->db->get()->result_array();
	}

	
	public function edit_feature($id)
	{

		$this->db->select('plan_features.*, plan_feature.plan_id');
		$this->db->join('plan_feature', 'plan_feature.feature_id = plan_features.id', 'left');
		$this->db->from('plan_features');
		$this->db->where("plan_features.id =", $id);
		return $records = $this->db->get()->result_array();
	}

	public function get_plans()
	{	
		$this->db->select('id, title');
		$this->db->from('member_ship_plans');
		return $records = $this->db->get()->result_array();
	}

    public function get_specializations_list($request)
    {
        $search 		 = $request['search']['value']; // Search value
        $start 			 = $request['start'];
        $rowperpage 	 = $request['length']; // Rows display per page
        $columnIndex 	 = $request['order'][0]['column']; // Column index
        $columnName 	 = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc

        $this->db->select('specializations.*');
        $this->db->from('specializations');
        if(isset($search) && $search !== '')
        {
            $this->db->like('name', $search, 'both');
        }
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $specializations = $this->db->get()->result_array();
        return $specializations;
    }

    public function get_total_specializations()
    {
        $query = $this->db->query('SELECT id FROM specializations');
        return $query->num_rows();
    }
    public function save_specializations($request)
    {
        $date = new DateTime();

        $data = array(
            'name'   => $request['name'],
            'created_at' => $date->format("Y-m-d"),
            'updated_at'   => $date->format("Y-m-d"),
        );
        $this->db->insert('specializations', $data);
        return true;
    }

    public function edit_specializations($id)
    {
        $this->db->from('specializations');
        $this->db->where("id =", $id);
        return $this->db->get()->result_array();
    }

    public function update_specializations_plan($request)
    {

        $data = array(
            'name'   	  => $request['editName'],
        );
        $this->db->where('id', $request['id']);
        $this->db->update('specializations', $data);

        return true;
    }
    public function delete_specialization($request)
    {
        $this->db->delete('specializations', array('id' => $request['id']));
        return true;
    }

	public function add_option($request)
	{
		$data = array(
			'feature_id'    => $request['featureId'],
			'display_name'  => $request['display_name'],
			'name' 	        => $request['label'],
			'value'         => $request['value'],
		  );
		$this->db->insert('plan_feature_options', $data);
		return true;
	}


	public function update_options($request)
	{
		$data = array(
			'display_name'  => $request['editdisplay_name'],
			'name' 	        => $request['editlabel'],
			'value'         => $request['editvalue'],
		 );

    	$this->db->where('id', $request['updateId']);
		$this->db->update('plan_feature_options', $data);
		return true;
	}

	public function get_options($request)
	{
	    $this->db->select('plan_feature_options.*');
		$this->db->from('plan_feature_options');
		$this->db->where("plan_feature_options.feature_id =", $request['featureId']);
		return $records = $this->db->get()->result_array();




	}

	public function get_all_features()
	{
		$this->db->select('plan_features.*');
		$this->db->from('plan_features');
		return $records = $this->db->get()->result_array();

	}

	public function delete_options($request)
	{
		$this->db->delete('plan_feature_options', array('id' => $request['optionId']));
		return true;
	}

	public function option_edit($id)
	{
		$this->db->select('plan_feature_options.*');
		$this->db->from('plan_feature_options');
		$this->db->where("plan_feature_options.id =", $id);
		return $records = $this->db->get()->result_array();
	}
}
